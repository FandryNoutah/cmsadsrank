<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'file']); // On charge notre helper d'images
        $this->load->model(['Visuels_model', 'Image_model', 'Donne_modele']);
    }

    /**
     * Prépare les données communes pour validation_structure et render_html_validation_structure
     * @param int $id ID du client
     * @return array Données préparées
     */
    private function prepare_validation_data(int $id): array
    {
        $id = (int)$id;

        $data = [];
        $data['logo_base64'] = $this->encode_local_image_to_data_uri(
            FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
        );

        // Charger les campagnes + groupes + images
        $campagnes = $this->Visuels_model->get_campagnes_by_client($id);
        if (is_array($campagnes)) {
            foreach ($campagnes as &$campagne) {
                $campagne['groupes_annonces'] = $this->Visuels_model->get_groupes_by_campagne($campagne['idcampagne']) ?: [];
                $campagne['images'] = $this->Image_model->get_images_by_campagne($campagne['idcampagne']) ?: [];

                foreach ($campagne['images'] as &$img) {
                    if (!empty($img->image_url)) {
                        if (file_exists(FCPATH . $img->image_url)) {
                            $img->final_url = base_url($img->image_url);
                        } else {
                            $img->final_url = $img->image_url;
                        }
                    } else {
                        $img->final_url = base_url('assets/images/placeholder.jpg');
                    }
                }
                unset($img);
            }
            unset($campagne);
        }

        $data['campagnes'] = $campagnes ?: [];
        $data['id'] = $id;
        $data['extensions'] = $this->Donne_modele->get_extensions_by_clients($id);
        $data['exlusions'] = $this->Visuels_model->get_exclusions($id);

        $donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($id);
        $groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($id);
        $groupes_par_campagne = [];

        foreach ($groupe_valider as $groupe) {
            $idcampagne = $groupe['idcampagne'];
            if (!isset($groupes_par_campagne[$idcampagne])) {
                $groupes_par_campagne[$idcampagne] = [];
            }
            $groupes_par_campagne[$idcampagne][] = $groupe;
        }

        foreach ($donne_valider as &$campagne) {
            $idcampagne = $campagne['idcampagne'];
            $campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) 
                ? $groupes_par_campagne[$idcampagne] 
                : [];
        }
        unset($campagne);

        $data['donne_valider'] = $donne_valider;
        $data['groupe_valider'] = $groupe_valider;

        return $data;
    }

    /**
     * Affiche la page web (usage normal)
     */
    public function validation_structure(int $id)
    {
        $this->data = $this->prepare_validation_data($id);
        $this->data['is_pdf'] = false;
        $this->load->view('templates/v3/Search', $this->data);
    }

    /**
     * Extrait le contenu du body d'un HTML
     * @param string $html HTML complet
     * @return string Contenu du body
     */
    private function extract_body_content(string $html): string
    {
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $bodyMatches)) {
            return $bodyMatches[1];
        }
        return '';
    }

    /**
     * Extrait les styles (link et style) du head d'un HTML
     * @param string $html HTML complet
     * @return string Styles extraits
     */
    private function extract_head_styles(string $html): string
    {
        $styles = '';
        // Extraire les <link rel="stylesheet">
        if (preg_match_all('/<link[^>]*rel=["\']stylesheet["\'][^>]*>/i', $html, $linkMatches)) {
            $styles .= implode("\n", $linkMatches[0]) . "\n";
        }
        // Extraire les <style>
        if (preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $styleMatches)) {
            foreach ($styleMatches[0] as $style) {
                $styles .= $style . "\n";
            }
        }
        return $styles;
    }

    /**
     * Renvoie le HTML pur (utilisé par wkhtmltopdf)
     * Génère 3 pages : Search (type 1), Local (type 2), PMax (type 3)
     */
    public function render_html_validation_structure(int $id)
    {
        $this->data = $this->prepare_validation_data($id);
        $this->data['is_pdf'] = true;

        // Génère les 3 pages HTML complètes
        $htmlSearch = $this->load->view('templates/v3/Search', $this->data, true);
        $htmlLocal  = $this->load->view('templates/v3/Local',  $this->data, true);
        $htmlPMax   = $this->load->view('templates/v3/PMax',   $this->data, true);

        // Vérifier que les vues ont généré du contenu
        if (empty($htmlSearch) || empty($htmlLocal) || empty($htmlPMax)) {
            // Log l'erreur ou afficher un message de debug
            error_log("PDF Generation: One or more views returned empty content for client ID: $id");
        }

        // Extraire les contenus et styles
        $bodySearch = $this->extract_body_content($htmlSearch);
        $bodyLocal  = $this->extract_body_content($htmlLocal);
        $bodyPMax   = $this->extract_body_content($htmlPMax);

        $stylesSearch = $this->extract_head_styles($htmlSearch);
        $stylesLocal  = $this->extract_head_styles($htmlLocal);
        $stylesPMax   = $this->extract_head_styles($htmlPMax);

        // Construire un seul document HTML avec les 3 pages
        echo '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
' . $stylesSearch . $stylesLocal . $stylesPMax . '
<style>
  @page { 
    margin: 0; 
    size: A3 landscape; 
  }
  
    html, body {
    background-color: #ffffff !important;
    margin: 0 !important;
    padding: 0 !important;
    }
    
  .pdf-page-section { 
    page-break-after: always; 
    page-break-inside: avoid;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    position: relative;
    box-sizing: border-box;
    background-color: white !important
  }
  
  .pdf-page-section:last-child {
    page-break-after: auto;
  }
  
</style>
</head>
<body>
  <div class="pdf-page-section">' . $bodySearch . '</div>
  <div class="pdf-page-section">' . $bodyLocal . '</div>
  <div class="pdf-page-section">' . $bodyPMax . '</div>
</body>
</html>';
    }

    /**
     * Génère le PDF et l'envoie au navigateur (wkhtmltopdf via la librairie Wkhtml)
     */
    public function export_pdf_validation_structure(int $id)
    {
        $id = (int)$id;
        $this->load->library('Wkhtml');

        $inputUrl = site_url('pdf_test/render_html_validation_structure/' . $id) . '?_=' . uniqid();

        $groupes = $this->Donne_modele->getcampagnegroupevalidationbyidclients($id);

        // Déterminer le zoom selon les types de campagnes présents
        // Priorité : type 3 (PMax) > type 2 (Local) > type 1 (Search)
        $zoom = '0.30'; // défaut pour Search
        $hasType2 = false;
        $hasType3 = false;

        foreach ($groupes as $g) {
            $type = (int)($g['type_campagne'] ?? 0);
            if ($type === 2) {
                $hasType2 = true;
            }
            if ($type === 3) {
                $hasType3 = true;
            }
        }

        // Si PMax présent, utiliser zoom plus petit
        if ($hasType3) {
            $zoom = '0.50';
        } elseif ($hasType2) {
            $zoom = '0.50';
        }

        $options = [
            '--page-size A3',
            '--orientation Landscape',
            '--viewport-size 1920x1080',   // plus raisonnable
            '--dpi 200',
            '--image-dpi 200',
            '--image-quality 90',
            '--zoom ' . $zoom,
            '--disable-smart-shrinking',
            '--print-media-type',
            '--enable-local-file-access',
            '--javascript-delay 1000',     // ou 500 si ton contenu n’a pas de JS
            // '--no-stop-slow-scripts',    // à commenter si tu n’en as pas besoin
            '--margin-top 0',
            '--margin-right 0',
            '--margin-bottom 0',
            '--margin-left 0',
            '--disable-external-links',
            '--disable-forms',
            '--load-error-handling ignore',
            '--load-media-error-handling ignore',
        ];
        
        $this->wkhtml->generate_from_url($inputUrl, $options, 'validation_structure_' . $id . '.pdf');
    }

    /**
     * Convertit une image locale en data:URI (base64) pour l'inliner dans le HTML.
     * Si le fichier n'existe pas, retourne une URL de fallback (placeholder).
     *
     * @param string $absPath chemin absolu sur disque (ex: FCPATH . 'assets/images/logo.png')
     * @return string data: URI ou URL de fallback
     */
    protected function encode_local_image_to_data_uri(string $absPath): string
    {
        $absPath = str_replace(['\\\\','/'], DIRECTORY_SEPARATOR, $absPath);

        if (file_exists($absPath) && is_readable($absPath)) {
            $data = file_get_contents($absPath);
            if ($data === false) {
                return base_url('assets/images/placeholder.jpg');
            }

            // détecte le mime type
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $absPath);
                finfo_close($finfo);
            } else {
                $ext = strtolower(pathinfo($absPath, PATHINFO_EXTENSION));
                $map = [
                    'png' => 'image/png',
                    'jpg' => 'image/jpeg',
                    'jpeg'=> 'image/jpeg',
                    'gif' => 'image/gif',
                    'svg' => 'image/svg+xml',
                    'webp'=> 'image/webp'
                ];
                $mime = $map[$ext] ?? 'application/octet-stream';
            }

            return 'data:' . $mime . ';base64,' . base64_encode($data);
        }

        return base_url('assets/images/placeholder.jpg');
    }

    public function render_html_pmax_static()
    {
        $data['is_pdf'] = true;
        echo $this->load->view('pdf/pmax_static', $data, true);
    }

    public function export_pdf_pmax_static()
    {
        $this->load->library('Wkhtml');
        $inputUrl = site_url('pdf_test/render_html_pmax_static') . '?_=' . uniqid();

        $options = [
            '--page-size A3',
            '--orientation Landscape',
            '--javascript-delay 1000',
            '--enable-local-file-access',
            '--no-stop-slow-scripts',
            '--margin-top 8mm',
            '--margin-bottom 8mm',
            '--margin-left 8mm',
            '--margin-right 8mm',
            '--zoom 0.90',
            '--disable-smart-shrinking',
        ];

        $filename = 'pmax_static_' . date('Ymd_His') . '.pdf';

        if (method_exists($this->wkhtml, 'generate_from_url')) {
            $this->wkhtml->generate_from_url($inputUrl, $options, $filename);
        } else {
            $html = file_get_contents($inputUrl);
            $this->wkhtml->generate($html, $options, $filename);
        }
    }
}