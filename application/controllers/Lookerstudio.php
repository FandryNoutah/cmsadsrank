<?php
defined('BASEPATH') or exit('No direct script access allowed');
$vendorAutoload = FCPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (!file_exists($vendorAutoload)) {
    // Message lisible et log si le fichier n'existe pas
    log_message('error', 'vendor/autoload.php introuvable : ' . $vendorAutoload);
    show_error("Dépendances Composer manquantes. Exécuter `composer require dompdf/dompdf` dans le dossier racine du projet.", 500, 'Dépendances manquantes');
    exit;
}
require_once $vendorAutoload;

use Dompdf\Dompdf;
use Dompdf\Options;

class Lookerstudio extends MY_Controller
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
		// $this->load->library('PHPExcel');
		// $this->load->library('excel');
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
		$this->content = "layouts/Lookerstudio/index.php";
		$this->layout();
	}
	public function update_rapports()
	{
		$id = $this->input->post("idonnee");

		$data = [
			"rapport"              => $this->input->post("rapport"),
			"rapport_conversions"  => $this->input->post("rapport_conversions"),
			"rapport_conv_ca"      => $this->input->post("rapport_conv_ca"),
			"bilan"                => $this->input->post("bilan"),
		];
		$this->visuels_model->update_rapports($id, $data);

		$this->session->set_flashdata("success", "Rapports mis à jour !");
		redirect($_SERVER['HTTP_REFERER']);
	}

}
