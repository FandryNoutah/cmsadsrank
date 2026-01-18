<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfExport extends CI_Controller {

    public function exporter(int $id)
    {
        // --- Ton code de préparation des données (inchangé) ---
        $this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
            FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
        );

        // ... (tout ton code de récupération des campagnes / images / groupes) ...
        // pour la brièveté, on suppose que $this->data est rempli comme avant
        // ---------------------------------------------------------------

        // 2️⃣ Générer le HTML depuis ton template
        $html = $this->load->view('templates/v3/pmax_dynamic', $this->data, true);

        // ------------------ TRANSFORMATIONS POUR DOMPDF -------------------

        // 1) Inline les <link rel="stylesheet" href="..."> en <style>...</style>
        $html = $this->inline_css_in_html($html);

        // 2) Convertit url(...) dans le CSS en data:URI (pour background, etc.)
        $html = $this->convert_css_urls_to_data_uri($html);

        // 3) Convertit toutes les <img src="..."> locales en data:URI
        $html = $this->local_images_to_data_uri($html);

        // Petite surcharge CSS utile pour Dompdf (force images responsives, supprime zoom transform)
        $html = str_replace('</head>', "<style>
            img { display: block; max-width: 100% !important; height: auto !important; }
            .zoom-50 { transform: none !important; width: auto !important; }
            .box { position: relative !important; min-width: auto !important; width: 100% !important; }
            .box .group { position: relative !important; width: 100% !important; height: auto !important; }
        </style></head>", $html);

        // Debug : sauvegarde HTML résultant (ouvre-le dans un navigateur pour vérifier)
        @file_put_contents(FCPATH . 'html_debug_inlined.html', $html);

        // Nettoyer buffers PHP (préparer pour Dompdf)
        while (ob_get_level()) { @ob_end_clean(); }

        // ------------------ OPTIONS DOMPDF -------------------
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('enable_css_float', true);
        $options->set('dpi', 150);
        $options->set('chroot', FCPATH);
        $options->set('tempDir', sys_get_temp_dir());
        @ini_set('memory_limit', '1024M');
        @set_time_limit(120);

        try {
            $dompdf = new Dompdf($options);
            // Choisis la taille/orientation que tu veux (A3 landscape dans ton snippet)
            $dompdf->setPaper('A3', 'landscape');
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->render();

            if (ob_get_length()) { @ob_end_clean(); }

            $filename = 'validation_structure_' . $id . '_' . date('Ymd_His') . '.pdf';
            $dompdf->stream($filename, ['Attachment' => 0]);
            exit;
        } catch (\Exception $e) {
            log_message('error', 'Dompdf error: ' . $e->getMessage());
            log_message('error', $e->getTraceAsString());
            @file_put_contents(FCPATH . 'dompdf_last_error.html', $html);
            echo '<h2>Dompdf error (debug)</h2>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . "</pre>";
            echo '<p>Fichier debug HTML: <code>' . FCPATH . 'dompdf_last_error.html</code></p>';
            exit;
        }
    }

    // ------------------ Helpers ------------------

    private function inline_css_in_html(string $html) : string {
        return preg_replace_callback(
            '#<link[^>]+href=["\']([^"\']+)["\'][^>]*>#i',
            function($m) {
                $href = $m[1];
                // Skip remote links (http/https or protocol relative)
                if (preg_match('#^(https?:)?//#i', $href)) return $m[0];
                $path = FCPATH . ltrim($href, '/');
                // fallback common pdf css folder
                if (!file_exists($path)) {
                    $alt = FCPATH . 'assets/css/pdf/' . basename($href);
                    if (file_exists($alt)) $path = $alt;
                }
                if (file_exists($path)) {
                    $css = file_get_contents($path);
                    return "<style>\n" . $css . "\n</style>";
                }
                return $m[0];
            },
            $html
        );
    }

    private function convert_css_urls_to_data_uri(string $html) : string {
        return preg_replace_callback(
            '#url\((["\']?)([^"\)\'"]+)\1\)#i',
            function($m) {
                $url = $m[2];
                if (strpos($url, 'data:') === 0 || preg_match('#^(https?:)?//#i', $url)) return $m[0];
                $alternatives = [
                    FCPATH . ltrim($url, '/'),
                    FCPATH . 'assets/css/pdf/' . basename($url),
                    FCPATH . 'assets/img/' . basename($url),
                    FCPATH . 'assets/images/' . basename($url),
                    FCPATH . 'img/' . basename($url),
                ];
                foreach ($alternatives as $a) {
                    if (file_exists($a)) {
                        $data = file_get_contents($a);
                        $ext = strtolower(pathinfo($a, PATHINFO_EXTENSION));
                        $mime = $ext === 'svg' ? 'image/svg+xml' : ($ext ? "image/$ext" : 'image/png');
                        return "url('data:$mime;base64," . base64_encode($data) . "')";
                    }
                }
                return $m[0];
            },
            $html
        );
    }

    private function local_images_to_data_uri(string $html) : string {
        return preg_replace_callback(
            '#(<img[^>]+src=["\'])([^"\']+)(["\'][^>]*>)#i',
            function($m) {
                $prefix = $m[1]; $src = $m[2]; $suffix = $m[3];
                if (strpos($src, 'data:') === 0 || preg_match('#^(https?:)?//#i', $src)) return $m[0];
                $candidates = [
                    FCPATH . ltrim($src, '/'),
                    FCPATH . 'assets/css/pdf/' . basename($src),
                    FCPATH . 'assets/img/' . basename($src),
                    FCPATH . 'assets/images/' . basename($src),
                    FCPATH . 'img/' . basename($src),
                ];
                foreach ($candidates as $c) {
                    if (file_exists($c)) {
                        $data = file_get_contents($c);
                        $ext = strtolower(pathinfo($c, PATHINFO_EXTENSION));
                        $mime = $ext === 'svg' ? 'image/svg+xml' : ($ext ? "image/$ext" : 'image/png');
                        return $prefix . 'data:' . $mime . ';base64,' . base64_encode($data) . $suffix;
                    }
                }
                // si non trouvé : on retourne le tag original (pour debug)
                return $m[0];
            },
            $html
        );
    }

    // Si tu as déjà un helper existant : tu peux l'utiliser à la place
    private function encode_local_image_to_data_uri(string $file) {
        if (!file_exists($file)) return '';
        $data = file_get_contents($file);
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mime = $ext === 'svg' ? 'image/svg+xml' : ($ext ? "image/$ext" : 'image/png');
        return 'data:' . $mime . ';base64,' . base64_encode($data);
    }
}
