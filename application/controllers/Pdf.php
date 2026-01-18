<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Charger la DB AVANT les modèles
        $this->load->database();

        // Charger le modèle
        $this->load->model('Donne_modele');

        // Ne pas charger tcpdf_lib ici (évite l'erreur si la lib manque)
        // $this->load->library('tcpdf_lib');

        // Helpers
        $this->load->helper(['file','url']);
    }

    // Méthode existante qui affiche la view HTML (ne la touche pas)
    public function afficher($idclients)
    {
        $donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
        $groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
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
            $campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
        }
        unset($campagne);

        $this->data['donne_valider'] = $donne_valider;
        $this->data['groupe_valider'] = $groupe_valider;
        $this->load->view('templates/v3/Search', $this->data);
    }

    // -------------------------
    // Nouvelle méthode : export PDF
    // -------------------------
    public function export_pdf($idclients)
{
    // Charge TCPDF
    $this->load->library('tcpdf_lib');

    // Protection output/warnings
    @ob_end_clean();
    ob_start();
    $old_display = ini_get('display_errors');
    ini_set('display_errors', '0');
    $old_error_reporting = error_reporting();
    error_reporting($old_error_reporting & ~E_WARNING & ~E_NOTICE);

    // --- Récupère les données (inchangé) ---
    $donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
    $groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
    $groupes_par_campagne = [];
    foreach ($groupe_valider as $groupe) {
        $idcampagne = $groupe['idcampagne'];
        if (!isset($groupes_par_campagne[$idcampagne])) $groupes_par_campagne[$idcampagne] = [];
        $groupes_par_campagne[$idcampagne][] = $groupe;
    }
    foreach ($donne_valider as &$campagne) {
        $idcampagne = $campagne['idcampagne'];
        $campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
    }
    unset($campagne);

    // Passe pdf_mode à la view
    $data = [
        'donne_valider' => $donne_valider,
        'groupe_valider' => $groupe_valider,
        'pdf_mode' => true
    ];

    // Récupère la view (qui, si pdf_mode=true, doit renvoyer le HTML simplifié)
    $html_full = $this->load->view('templates/v3/Search', $data, TRUE);

    // EXTRA DEBUG: sauvegarde tel quel (raw) pour voir ce qui est renvoyé
    @file_put_contents(FCPATH . 'tmp_debug_pdf_raw.html', $html_full);

    // Extrait le body si présent
    if (preg_match('#<body[^>]*>(.*)</body>#is', $html_full, $m)) {
        $html_body = $m[1];
    } else {
        $html_body = $html_full;
    }

    // Si la view renvoie peu ou rien (ex: template mal routé), on injecte un fallback visible
    $trimmed_text = trim(strip_tags($html_body));
    if ($trimmed_text === '') {
        log_message('error', 'export_pdf: HTML body vide pour client ' . $idclients . ' — génération d\'un fallback simple.');
        // fallback HTML visible
        $html_body = '<div style="color:#000;font-family:DejaVuSans,Helvetica,Arial,sans-serif;font-size:14pt;padding:20px;">'
            . '<strong>DEBUG PDF - contenu vide</strong><br/>Vérifier tmp_debug_pdf_raw.html et application/logs pour détails.'
            . '</div>';
    }

    // Injecte un style minimal pour s'assurer que le texte est visible (no white-on-white, etc.)
    $print_css = '<style>
        html,body{margin:0;padding:0;background:#fff;color:#000;font-family:DejaVuSans,Helvetica,Arial,sans-serif;}
        .pdf-root{padding:6mm;box-sizing:border-box;}
        img{max-width:100%;height:auto;}
    </style>';

    $html = $print_css . '<div class="pdf-root">' . $html_body . '</div>';

    // Sauvegarde le HTML final envoyé à TCPDF (contrôle)
    @file_put_contents(FCPATH . 'tmp_debug_pdf.html', $html);

    // Remplace base_url(...) par chemins locaux si nécessaire (existant chez toi)
    $base = base_url();
    $html = str_replace('src="' . $base, 'src="' . FCPATH, $html);
    $html = str_replace("src='" . $base, "src='" . FCPATH, $html);

    // Nettoyage SVG problématiques (clipPath etc.)
    $html = preg_replace('#<clipPath\b[^>]*>.*?</clipPath>#is', '', $html);
    $html = preg_replace('#\sclip-path\s*=\s*["\']?url\([#][^"\')]+[\'"]?\)#i', '', $html);
    $html = preg_replace('#\sclip-path\s*:\s*url\([#][^"\)]+\);?#i', '', $html);

    // Correction chemins relatifs d'images : convertit src="img/..." en chemins absolus sur disque si trouve fichier
    $html = preg_replace_callback('/src=[\'"]([^\'"]+)[\'"]/i', function($m) {
        $src = $m[1];
        if (preg_match('#^(https?:)?//#i', $src) || strpos($src, 'data:') === 0
            || strpos($src, DIRECTORY_SEPARATOR) === 0 || preg_match('#^[A-Za-z]:\\\\#', $src)) {
            return 'src="' . $src . '"';
        }
        if (strpos($src, FCPATH) === 0) return 'src="' . $src . '"';

        $candidates = [];
        $candidates[] = FCPATH . 'assets/css/search/' . $src;
        $candidates[] = FCPATH . 'assets/css/search/img/' . $src;
        $candidates[] = FCPATH . 'assets/img/' . $src;
        $candidates[] = FCPATH . 'img/' . $src;
        $candidates[] = FCPATH . $src;

        foreach ($candidates as $file) {
            if (file_exists($file)) return 'src="' . $file . '"';
        }
        // log pour debug
        log_message('error', 'export_pdf: image non trouvée -> ' . $src . ' (candidates: ' . implode(',', $candidates) . ')');
        return 'src="' . $src . '"';
    }, $html);

    // --- Génération PDF (mode paysage) ---
    try {
        $pdf = $this->tcpdf_lib->load('L', 'mm', 'A4');
        $pdf->SetCreator('CodeIgniter');
        $pdf->SetAuthor('Ton Application');
        $pdf->SetTitle('Export - ' . date('Y-m-d'));
        $pdf->SetSubject('Export PDF');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Police UTF-8 fiable (fallback)
        $font = 'dejavusans';
        $dejavu_path1 = APPPATH . '../application/third_party/TCPDF-main/fonts/dejavusans.php';
        $dejavu_path2 = APPPATH . '../application/third_party/TCPDF-main/fonts/DejaVuSans.ttf';
        if (!file_exists($dejavu_path1) && !file_exists($dejavu_path2)) {
            $font = 'helvetica';
            log_message('warning', 'export_pdf: DejaVu non trouvé, fallback helvetica.');
        }
        $pdf->SetFont($font, '', 10);

        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->SetMargins(10, 10, 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();

        // Écrit le HTML final
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Nettoyage buffers et restauration
        if (ob_get_length() !== false) ob_end_clean();
        ini_set('display_errors', $old_display);
        error_reporting($old_error_reporting);

        // Envoi PDF inline
        $pdf->Output('export_search_' . $idclients . '.pdf', 'I');
        return;
    } catch (Exception $e) {
        // Restore et log
        if (ob_get_length() !== false) ob_end_clean();
        ini_set('display_errors', $old_display);
        error_reporting($old_error_reporting);

        log_message('error', 'export_pdf: Exception pendant génération PDF: ' . $e->getMessage());
        // Envoi un PDF très simple pour indiquer l'erreur
        try {
            $pdf2 = $this->tcpdf_lib->load('L', 'mm', 'A4');
            $pdf2->setPrintHeader(false);
            $pdf2->setPrintFooter(false);
            $pdf2->SetFont('helvetica', '', 12);
            $pdf2->AddPage();
            $pdf2->Write(0, "Erreur génération PDF. Voir logs. (" . substr($e->getMessage(),0,200) . ")");
            $pdf2->Output('export_search_error_' . $idclients . '.pdf', 'I');
            return;
        } catch (Exception $e2) {
            show_error('Erreur critique génération PDF. Voir logs.');
            return;
        }
    }
}

public function export_pdf_test()
{
    $this->load->library('tcpdf_lib');

    // small safety
    @ob_end_clean();
    ini_set('display_errors', '0');

    try {
        $pdf = $this->tcpdf_lib->load('L', 'mm', 'A4');
        $pdf->SetCreator('CI');
        $pdf->SetAuthor('Test');
        $pdf->SetTitle('Test Bonjour');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Try DejaVu first, fallback to helvetica if not found
        $font = 'dejavusans';
        if (!file_exists(APPPATH . '../application/third_party/TCPDF-main/fonts/dejavusans.php') &&
            !file_exists(APPPATH . '../application/third_party/TCPDF-main/fonts/DejaVuSans.ttf')) {
            $font = 'helvetica';
        }
        $pdf->SetFont($font, '', 16);

        $pdf->AddPage();

        // simple HTML forced black and decent size
        $html = '<div style="color:#000; font-size:18pt; font-family: ' . $font . ';">Bonjour</div>';

        // save the debug HTML that will be passed to TCPDF
        @file_put_contents(FCPATH . 'tmp_debug_pdf_minimal.html', $html);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('test_bonjour.pdf', 'I');
    } catch (Exception $e) {
        echo 'Erreur: ' . $e->getMessage();
    }
}
// DEBUG helper — coller temporairement dans Pdf controller
public function debug_export($idclients = 1)
{
    // 1) écrase tout output précédent
    @ob_end_clean();
    ini_set('display_errors', '1'); // pour debug on réactive l'affichage localement
    error_reporting(E_ALL);

    // 2) récupère les mêmes données que pour export_pdf
    $this->load->model('Donne_modele');
    $donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
    $groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);

    // 3) prépare $data comme dans export_pdf
    $data = [
        'donne_valider' => $donne_valider,
        'groupe_valider' => $groupe_valider,
        'pdf_mode' => true
    ];

    // 4) charge la view en chaîne (ce que tu fais dans export_pdf)
    $html_full = $this->load->view('templates/v3/Search', $data, TRUE);

    // 5) write debug files (permets de les ouvrir)
    file_put_contents(FCPATH . 'tmp_debug_pdf_raw.html', $html_full === false ? '[load->view returned false]' : $html_full);
    // extraction body
    if (preg_match('#<body[^>]*>(.*)</body>#is', $html_full, $m)) {
        $html_body = $m[1];
    } else {
        $html_body = $html_full;
    }
    file_put_contents(FCPATH . 'tmp_debug_pdf.html', $html_body === false ? '[no body]' : $html_body);

    // 6) log basique des tailles / existence variables
    $infos = [];
    $infos[] = 'date: ' . date('c');
    $infos[] = 'idclients: ' . $idclients;
    $infos[] = 'donne_valider count: ' . (is_array($donne_valider) ? count($donne_valider) : gettype($donne_valider));
    $infos[] = 'groupe_valider count: ' . (is_array($groupe_valider) ? count($groupe_valider) : gettype($groupe_valider));
    $infos[] = 'html_full length: ' . (is_string($html_full) ? strlen($html_full) : 'not string');
    $infos[] = 'html_body length: ' . (is_string($html_body) ? strlen($html_body) : 'not string');
    file_put_contents(FCPATH . 'tmp_debug_info.txt', implode(PHP_EOL, $infos));

    // 7) permissions check
    $perms = is_writable(FCPATH) ? 'FCPATH writable' : 'FCPATH NOT writable';
    file_put_contents(FCPATH . 'tmp_debug_perm.txt', $perms);

    // 8) retourne une page claire pour toi
    echo '<h2>DEBUG export_pdf — idclients=' . htmlentities($idclients) . '</h2>';
    echo '<ul>';
    echo '<li><a href="' . base_url('tmp_debug_pdf_raw.html') . '" target="_blank">tmp_debug_pdf_raw.html</a></li>';
    echo '<li><a href="' . base_url('tmp_debug_pdf.html') . '" target="_blank">tmp_debug_pdf.html</a></li>';
    echo '<li><a href="' . base_url('tmp_debug_pdf_min.html') . '" target="_blank">tmp_debug_pdf_min.html (si exist)</a></li>';
    echo '<li><a href="' . base_url('tmp_debug_info.txt') . '" target="_blank">tmp_debug_info.txt</a></li>';
    echo '<li><a href="' . base_url('tmp_debug_perm.txt') . '" target="_blank">tmp_debug_perm.txt</a></li>';
    echo '</ul>';
    echo '<p>Ouvre ces fichiers et colle ici les 30–100 premiers caractères (ou indique ce que tu vois).</p>';
    echo '<p>Après test, supprime cette méthode debug ou protège-la.</p>';
}

}
