<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Filter extends MY_Controller
{
	protected $sam_id;
	
	function __construct() {
		parent::__construct();
		$this->load->model("panneaux_model");
		$this->load->model("data_model");
		$sam_id = $this->ion_auth->user()->row();
		$this->sam_id = @$sam_id->sam_id;
	}

	public function index() {
		$data["filters"] = $this->input->post("filters");
		$dataPost = $this->input->post();
		
		$support = $this->input->post("support");
		
		unset($dataPost["filters"]);
		$data["filters"] = json_decode(stripslashes($this->input->post("filters")), true);
		$data["datapost"] = $dataPost;
		$data["result"] = $this->getResultByFilter($dataPost, $support);
		$this->load->view("templates/v3/parts/filter-result", $data);
	}
	
	public function getResultByFilter($filter, $support = 5) { // Panneaux par defaut
		$res    = array();
		$result = array();
		$model = $this->data_model->getByFilter($support, $filter);
		
		if($this->sam_id == "" && $this->sam_id == null) {
			return $model;
		} else {
			foreach($model as $key => $value) {
				if($this->sam_id != "" && $value["panneau_sam"] == $this->sam_id) {
					$res[] = $value;
				}
			}
			return $res;
		}
	}
}