<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends MY_Controller
{

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
		$this->data['visuels'] = $this->visuels_model->get_all();
		// $this->load->library('PHPExcel');
		// $this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('curl');
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";

		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}

	public function index()
	{
		$this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$this->data['users'] = $this->Task_model->get_all_users();
		$this->data['produit'] = $this->Donne_modele->get_all_produit();
		$this->data['am'] = $this->Donne_modele->get_all_am();
		$this->data['initiative'] = $this->Donne_modele->get_all_initiative();

		$this->content = "layouts/client/index.php";
		$this->layout();
	}

	public function detail_client($idclients)
	{

		// $this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		// $this->data['users'] = $this->Task_model->get_all_users();
		// $this->data['produit'] = $this->Donne_modele->get_all_produit();
		// $this->data['am'] = $this->Donne_modele->get_all_am();
		// $this->data['initiative'] = $this->Donne_modele->get_all_initiative();

		$this->load->view('layouts/client/detail/index');
	}
}
