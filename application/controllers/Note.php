<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Note extends MY_Controller
{

	protected $file_upload_field;


	public function __construct()
	{
		parent::__construct();

		/* $this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
		$this->data['visuels'] = $this->visuels_model->get_all();
		$this->load->library('PHPExcel');
		$this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		
		$this->load->library('upload');
        $this->load->library('form_validation'); */
		//$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

	}

	public function index()
	{
		$this->data['tache_team'] = $this->Task_model->get_task_team();
		$this->content = "layouts/note/index.php";
		$this->layout();
	}

}
