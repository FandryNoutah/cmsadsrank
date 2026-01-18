<?php
defined('BASEPATH') or exit('No direct script access allowed');

$vendorAutoload = FCPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (!file_exists($vendorAutoload)) {
    log_message('error', 'vendor/autoload.php introuvable : ' . $vendorAutoload);
    show_error("Dépendances Composer manquantes. Exécuter `composer require phpoffice/phpspreadsheet` dans le dossier racine du projet.", 500, 'Dépendances manquantes');
    exit;
}
require_once $vendorAutoload;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends MY_Controller
{
    private $api_url = 'https://api.aircall.io/v1/calls';
    private $api_auth = '';
    protected $file_upload_field;

    public function __construct()
    {
        parent::__construct();

        $this->load->model("visuels_model");
        $this->load->model("concurrent");
        $this->load->model("Donne_modele");
        $this->load->model("Data_modele");
        $this->load->model("Image_model");
        $this->load->model("Message_model");
        $this->load->model("Task_model");
        $this->load->model("Note_model");
        $this->load->model("Discussion_model");
        $this->load->model("Gtm_model");
        $this->load->model("Application_model");

        $this->data['visuels'] = $this->visuels_model->get_all();
        $this->load->helper(array('form', 'url'));
        $this->load->library('curl');
        $this->path = "assets/images/formats/";
        $this->file_upload_field = "visuel_path";
        $this->load->database();
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->current_user = $this->ion_auth->user()->row();
    }

    public function index()
    {
        $this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
        $this->data['users'] = $this->Task_model->get_all_users();
        $this->data['produit'] = $this->Donne_modele->get_all_produit();
        $this->data['am'] = $this->Donne_modele->get_all_am();
        $this->data['initiative'] = $this->Donne_modele->get_all_initiative();

        $this->content = "layouts/excel/index.php";
        $this->layout();
    }

    public function export()
    {
        // Récupère les données depuis visuels_model (adapte si tu veux un autre model)
        $donnee = $this->visuels_model->getClientDataByDonnee(); // array d'objets

        // Crée le spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $headers = ['Client', 'GTM', 'Google Ads', 'Analytics'];
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $col++;
        }

        // Remplissage des données
        $rowNum = 2;
        foreach ($donnee as $d) {
            // adapte les champs si nécessaire
            $client = isset($d->nom_client) ? $d->nom_client : (is_array($d) && isset($d['nom_client']) ? $d['nom_client'] : '');
            $gtm = isset($d->tracking_gtm) ? $d->tracking_gtm : (is_array($d) && isset($d['tracking_gtm']) ? $d['tracking_gtm'] : '');
            $googleads = isset($d->googleads) ? $d->googleads : (is_array($d) && isset($d['googleads']) ? $d['googleads'] : '');
            $analytics = isset($d->google_analytics) ? $d->google_analytics : (is_array($d) && isset($d['google_analytics']) ? $d['google_analytics'] : '');

            $sheet->setCellValue('A' . $rowNum, $client);
            $sheet->setCellValue('B' . $rowNum, $gtm);
            $sheet->setCellValue('C' . $rowNum, $googleads);
            $sheet->setCellValue('D' . $rowNum, $analytics);

            $rowNum++;
        }

        // Auto-size colonnes
        foreach (range('A', 'D') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // Prépare l'envoi du fichier au navigateur
        $filename = 'export_clients_' . date('Ymd_His') . '.xlsx';

        // Nettoie le buffer (évite corruption du fichier si un echo/HTML est envoyé)
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
