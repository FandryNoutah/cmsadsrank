<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Filtre extends MY_Controller
{
	protected $sam_id;
	
	function __construct() {
		parent::__construct();
		$this->load->model("panneau_model");
		$this->load->model("campagne_model");
		$sam_id = $this->ion_auth->user()->row();
		$this->sam_id = @$sam_id->sam_id;
	}

	public function index() {
		//echo json_encode($this->input->post());
		
		//$data["post"] = $this->input->post();
		$data["filters"] = $this->input->post("filters");
		$dataPost = $this->input->post();
		
		unset($dataPost["filters"]);
		$data["filters"] = json_decode(stripslashes($this->input->post("filters")), true);
		/*
		$filter = array();
		
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
		*/

		
		$data["datapost"] = $dataPost;
		//$data["result"] = $this->campagne_model->resultByFilter($dataPost);
		$data["result"] = $this->getResultByFilter($dataPost);
		$data["visuels"] = $this->getVisuels();
		$data["campagnes"] = $this->getCampagnes();
		
		//datadump(count($this->getResultByFilter($dataPost)));
		//datadump($this->getResultByFilter($dataPost));
		
		$this->load->view("templates/admin_panneau_filter_campagne", $data);

	}
	
	
	/*Faniry 20180130 - getAllVisuels*/
	private function getVisuels() {
        foreach ($this->campagne_model->get_all_visuels() as $key => $value) {
            $return[$value["id"]] = isset($value["panneau_visuel_name"]) ? $value["panneau_visuel_name"] : "";
        }
        return $return;
    }
	
	private function getCampagnes() {
        foreach ($this->campagne_model->get_all() as $key => $value) {
            $return[$value["id"]] = isset($value["panneau_campagne_nom"]) ? $value["panneau_campagne_nom"] : "";
        }
        return $return;
    }
	
	public function getResultByFilter($filter) {
		$res    = array();
		$result = array();
		//$data["result"] = $this->campagne_model->resultByFilter($filter);
		$model = $this->campagne_model->resultByFilter($filter);
			
		
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
	
	/*end*/
	
}