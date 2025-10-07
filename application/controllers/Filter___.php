<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Filter extends MY_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model("data_model");
	}

	public function index() {
		$data["post"] = $this->input->post();
		$dataPost = $this->input->post();
		
		datadump($dataPost);
		
		$data["filters"] = json_decode(stripslashes($this->input->post("filterData")), true);
		
		datadump($data["filters"]);
		
		//$data["dataFilter"] = json_decode(stripslashes($this->input->post("filterData")), true);
		$filter = array();
		unset($dataPost["filterData"]);
		foreach($dataPost as $key => $value) {
			if(is_string($value) && !is_numeric($value)) {
				$filter[$key] = $value;
				if($value === "no") $filter[$key] = 0;
				if($value === "yes") $filter[$key] = 1;
			} else {
				if(is_numeric($value) && $value != 0) {
					$filter[$key] = $value;
				}
			}		
		}
		$data["filter"] = $dataPost;
		$data["result"] = $this->data_model->getByFilter(5, $dataPost);
		
		//$this->load->view("templates/admin_panneau_filter_res", array("data" => $this->input->post()));
		$this->load->view("templates/v3/parts/filter-result", $data);
	}
}