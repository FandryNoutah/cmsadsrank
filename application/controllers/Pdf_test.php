<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // helpers / models nécessaires (adapte selon ton app)
        $this->load->helper('url'); // base_url(), site_url()
        $this->load->helper('file'); // file helpers si besoin
        $this->load->model('Visuels_model');
        $this->load->model('Image_model');
        $this->load->model('Donne_modele');
    }

    /**
     * Affiche la page web (usage normal)
     */
    public function validation_structure(int $id)
    {
        $id = (int)$id;

        // 1️⃣ Logo statique (base64 ou fallback URL)
        $this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
            FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
        );

        // 2️⃣ Charger les campagnes + groupes + images
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

        $idclients = $id;
        $this->data['campagnes'] = $campagnes ?: [];
        $this->data['id'] = $id;
        $this->data['is_pdf'] = false;
        $this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
        $this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);

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

        // Affiche la vue normale (web)
        $this->load->view('templates/v3/Local', $this->data);
    }

    /**
     * Renvoie le HTML pur (utilisé par wkhtmltopdf)
     */
    /**
 * Renvoie le HTML pur (utilisé par wkhtmltopdf)
 * Maintenant assemble : 1) première page (ta vue Search) 2) saut de page 3) seconde page (fichier séparé)
 */
public function render_html_validation_structure(int $id)
{
    $id = (int)$id;

    // Prépare les mêmes données que dans validation_structure
    $this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
        FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
    );

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

    $idclients = $id;
    $this->data['campagnes'] = $campagnes ?: [];
    $this->data['id'] = $id;
    $this->data['is_pdf'] = true; // important pour les CSS PDF-only
    $this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
    $this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);

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

    // 1) HTML première page (ta view existante)
    $page1 = $this->load->view('templates/v3/Search', $this->data, true);

    // 2) Saut de page CSS-friendly (wkhtmltopdf respecte page-break-before / break-before)
    $page_break = '<div style="page-break-before: always; break-before: page;"></div>';

    // 3) HTML seconde page (nouvelle vue). Tu peux lui fournir des données si nécessaire.
    //    la vue Search_secondpage doit utiliser base_url() pour CSS & images.
   // $page2 = $this->load->view('templates/v3/Search_secondpage', [], true);

    // Concatène et renvoie le tout
     echo $page1 . $page_break;
   // echo $page1 . $page_break . $page2;
}
public function render_html_validation_structure_pmax(int $id)
{
    $id = (int)$id;

    // Prépare les mêmes données que dans validation_structure
    $this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
        FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
    );

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

    $idclients = $id;
    $this->data['campagnes'] = $campagnes ?: [];
    $this->data['id'] = $id;
    $this->data['is_pdf'] = true; // important pour les CSS PDF-only
    $this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
    $this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);

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

    // 1) HTML première page (ta view existante)
    $page1 = $this->load->view('templates/v3/PMax', $this->data, true);

    // 2) Saut de page CSS-friendly (wkhtmltopdf respecte page-break-before / break-before)
    $page_break = '<div style="page-break-before: always; break-before: page;"></div>';

    // 3) HTML seconde page (nouvelle vue). Tu peux lui fournir des données si nécessaire.
    //    la vue Search_secondpage doit utiliser base_url() pour CSS & images.
   // $page2 = $this->load->view('templates/v3/Search_secondpage', [], true);

    // Concatène et renvoie le tout
     echo $page1 . $page_break;
   // echo $page1 . $page_break . $page2;
}
public function render_html_validation_structure_local(int $id)
{
    $id = (int)$id;

    // Prépare les mêmes données que dans validation_structure
    $this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
        FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
    );

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

    $idclients = $id;
    $this->data['campagnes'] = $campagnes ?: [];
    $this->data['id'] = $id;
    $this->data['is_pdf'] = true; // important pour les CSS PDF-only
    $this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
    $this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);

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

    // 1) HTML première page (ta view existante)
    $page1 = $this->load->view('templates/v3/local', $this->data, true);

    // 2) Saut de page CSS-friendly (wkhtmltopdf respecte page-break-before / break-before)
    $page_break = '<div style="page-break-before: always; break-before: page;"></div>';

    // 3) HTML seconde page (nouvelle vue). Tu peux lui fournir des données si nécessaire.
    //    la vue Search_secondpage doit utiliser base_url() pour CSS & images.
   // $page2 = $this->load->view('templates/v3/Search_secondpage', [], true);

    // Concatène et renvoie le tout
     echo $page1 . $page_break;
   // echo $page1 . $page_break . $page2;
}


    /**
     * Génère le PDF et l'envoie au navigateur (wkhtmltopdf via la librairie Wkhtml)
     */
public function export_pdf_validation_structure(int $id)
{
    $id = (int)$id;

    // Charge la librairie Wkhtml (doit contenir generate_from_url)
    $this->load->library('Wkhtml');

    $inputUrl = site_url('pdf_test/render_html_validation_structure/' . $id) . '?_=' . uniqid();

$groupes = $this->Donne_modele->getcampagnegroupevalidationbyidclients($id);

// par défaut
$zoom = '0.65';

// si au moins un groupe type 2 → PMax
foreach ($groupes as $g) {
    if ((int)$g['type_campagne'] === 2) {
        $zoom = '0.40';
        break;
    }
    if ((int)$g['type_campagne'] === 3) {
        $zoom = '0.60';
        break;
    }
    
}
$options = [
    '--page-size A3',
    '--orientation Landscape',

    // 🔥 CRITIQUE
    '--viewport-size 3581x1621',

    '--dpi 600',
    '--zoom ' . $zoom,
    '--disable-smart-shrinking',
    '--print-media-type',

    '--image-quality 100',
    '--image-dpi 600',

    '--enable-local-file-access',
    '--javascript-delay 3000',
    '--no-stop-slow-scripts',

    '--margin-top 0',
    '--margin-right 0',
    '--margin-bottom 0',
    '--margin-left 0'
];




    $this->wkhtml->generate_from_url($inputUrl, $options, 'validation_structure_' . $id . '.pdf');
}
public function export_pdf_validation_structure_pmax(int $id)
{
    $id = (int)$id;

    // Charge la librairie Wkhtml (doit contenir generate_from_url)
    $this->load->library('Wkhtml');

    $inputUrl = site_url('pdf_test/render_html_validation_structure_pmax/' . $id) . '?_=' . uniqid();

$groupes = $this->Donne_modele->getcampagnegroupevalidationbyidclients($id);

// par défaut
$zoom = '0.65';

// si au moins un groupe type 2 → PMax
foreach ($groupes as $g) {
    if ((int)$g['type_campagne'] === 2) {
        $zoom = '0.40';
        break;
    }
    if ((int)$g['type_campagne'] === 3) {
        $zoom = '0.60';
        break;
    }
    
}
$options = [
    '--page-size A3',
    '--orientation Landscape',

    // 🔥 CRITIQUE
    '--viewport-size 3581x1621',

    '--dpi 600',
    '--zoom ' . $zoom,
    '--disable-smart-shrinking',
    '--print-media-type',

    '--image-quality 100',
    '--image-dpi 600',

    '--enable-local-file-access',
    '--javascript-delay 3000',
    '--no-stop-slow-scripts',

    '--margin-top 0',
    '--margin-right 0',
    '--margin-bottom 0',
    '--margin-left 0'
];




    $this->wkhtml->generate_from_url($inputUrl, $options, 'validation_structure_' . $id . '.pdf');
}
public function export_pdf_validation_structure_local(int $id)
{
    $id = (int)$id;

    // Charge la librairie Wkhtml (doit contenir generate_from_url)
    $this->load->library('Wkhtml');

    $inputUrl = site_url('pdf_test/render_html_validation_structure_local/' . $id) . '?_=' . uniqid();

$groupes = $this->Donne_modele->getcampagnegroupevalidationbyidclients($id);

// par défaut
$zoom = '0.65';

// si au moins un groupe type 2 → PMax
foreach ($groupes as $g) {
    if ((int)$g['type_campagne'] === 2) {
        $zoom = '0.40';
        break;
    }
    if ((int)$g['type_campagne'] === 3) {
        $zoom = '0.60';
        break;
    }
    
}
$options = [
    '--page-size A3',
    '--orientation Landscape',

    // 🔥 CRITIQUE
    '--viewport-size 3581x1621',

    '--dpi 600',
    '--zoom ' . $zoom,
    '--disable-smart-shrinking',
    '--print-media-type',

    '--image-quality 100',
    '--image-dpi 600',

    '--enable-local-file-access',
    '--javascript-delay 3000',
    '--no-stop-slow-scripts',

    '--margin-top 0',
    '--margin-right 0',
    '--margin-bottom 0',
    '--margin-left 0'
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
        // normaliser le chemin
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
                // fallback basique par extension
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

        // fallback : renvoyer URL publique d'une image placeholder (la vue peut l'utiliser dans <img src="">)
        return base_url('assets/images/placeholder.jpg');
    }
    public function render_html_pmax_static()
{
    // si tu veux passer des données dynamiques plus tard
    $data['is_pdf'] = true;

    echo $this->load->view('pdf/pmax_static', $data, true);
}

public function export_pdf_pmax_static()
{
    $this->load->library('Wkhtml');

    // URL publique qui renvoie le HTML
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
        // ajuste si ça déborde (0.85, 0.80, etc.)
        '--zoom 0.90',
        '--disable-smart-shrinking',
    ];

    $filename = 'pmax_static_' . date('Ymd_His') . '.pdf';

    if (method_exists($this->wkhtml, 'generate_from_url')) {
        $this->wkhtml->generate_from_url($inputUrl, $options, $filename);
    } else {
        // fallback si ta lib ne supporte pas generate_from_url
        $html = file_get_contents($inputUrl);
        $this->wkhtml->generate($html, $options, $filename);
    }
}

}
