<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class AjoutConcurrent extends MY_Controller
{
	protected $path;
	protected $file_upload_field;

	function __construct() {
		parent::__construct();
		$this->load->model("arche_model");
		$this->load->model("flags_model");
		$this->load->library('upload');
		$this->data["arches"] = $this->arche_model->get_all();
		$this->path = "assets/uploads/arches/";

		foreach ($this->arche_model->get_formats() as $formats) {
			$formatArche[$formats->label] = $formats->label;
		}

		foreach ($this->flags_model->get_provinces() as $provinces) {
            //$province[$provinces->label] = $provinces->label;
            $province[$provinces->label] = $provinces->label;
        }
		$this->data["formats"] = $formatArche;
		$this->data["provinces"] = $province;
	}

	public function index()
	{
		$this->page = "templates/ajout_concurrent";
		$this->layout();
	}

}