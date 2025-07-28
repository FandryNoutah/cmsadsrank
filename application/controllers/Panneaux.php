<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Panneaux extends MY_Controller
{
    protected $path;
    protected $sam_id;
    protected $support;
    protected $panneaux;
	protected $file_upload_field;

	function __construct() {
		parent::__construct();
		$this->data['page_title'] = 'Panneaux';
		$this->support = 5;
		$this->load->model("data_model");
		$this->load->model("panneaux_model");
        //$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$sam_id = $this->ion_auth->user()->row();
		//$this->sam_id = @$sam_id->sam_id;
		//$this->data["panneaux"] = $this->panneaux_model->get_all($this->sam_id);
		//$this->data["panneaux"] = $this->panneaux_model->get_all();
		$this->panneaux = $this->data_model->getAll($this->support);
		
		$this->data["panneaux"] = $this->panneaux;
		
		//datadump($this->data_model->getAll($this->support)); die("end");
		$this->data["locations"] = $this->getMapLocations();
		
		$this->data["filterData"] = array(
            "format" 	 => $this->getFormats(),
            "regisseur" => $this->getRegisseurs(), 
            "province"  => $this->getProvinces(), 
            "type" 	 => $this->getTypes(), 
            "region" 	 => $this->getRegions(),
            "visuel" 	 => $this->getVisuels(),
        );
	}
	
	public function getMapLocations() {
		$locations = array();
		foreach($this->data_model->getAll($this->support) as $location) {
			$locations[] = [
				"<b>Ref.</b> " . $location->reference . "<br/><b>Région</b> : " . $location->region . "<br/><b>Ville</b> : " . $location->ville . "<br/><b>Quartier</b> : " . $location->quartier . "<br/><b>Emplacement</b> : " . $location->emplacement . "<br/><b>Visuel</b> : " . $location->visuel,
				$location->latitude,
				$location->longitude
			];
		}
		return $locations;
	}
	
	public function getStats() {
		$data = array();
        $column = $this->input->post("stat-panneau");
		//datadump($this->input->post());
		foreach($this->data_model->getStatByColumn($this->support) as $statData) {
			$data[$statData->$column][] = $statData;
		}
		//datadump($data);
		$this->load->view("templates/v3/parts/stats/stat-panneaux", ["data" => $data]);
	}
	
	/*
	public function getStatsVisuels() {
		$data = array();
        $column = $this->input->post();
		
		datadump($this->input->post());
		
		//datadump($this->data_model->getStatByColumn($this->support));
		
		foreach($this->data_model->getStatByColumn($this->support) as $statData) {
			//$data[$statData->$column][] = $statData;
			if($column["stat-visuels"] == "") {
				$data[$statData->visuel][] = $statData;
			} else {
				$key = $column["stat-visuels"];
				datadump($statData->$key);
				$data[$statData->$key][] = $statData;
			}
		}
		
		//datadump($data);
		$this->load->view("templates/v3/parts/stats/stat-visuels", ["data" => $data]);
	}*/
	
	public function getStatsVisuels() {
		$data = array();
        $datapost = $this->input->post();
		
        $title = $this->input->get("title");
		//datadump($title);
        
		$column = $datapost["stat-visuels"];
        $value = ($column == "") ? "" : $datapost[$column];	
		$data = $this->data_model->getStatVisuelsByColumn($this->support, $column, $value);
		//datadump($data);
		$this->load->view("templates/v3/parts/stats/stat-visuels", ["data" => $data, "title" => $title]);
	}
	
	
	
	public function getFormats() {
		$return = array();
		foreach($this->data_model->getFormats($this->support) as $format) {
			$return[$format->format] = $format->format;
		}
		return $return;
	}
	
	public function getRegisseurs() {
		$return = array();
		foreach($this->data_model->getRegisseurs($this->support) as $regisseur) {
			$return[$regisseur->id] = $regisseur->label;
		}
		return $return;
	}
	
	public function getProvinces() {
		$return = array();
		foreach($this->data_model->getProvinces() as $province) {
			$return[$province->id] = $province->label;
		}
		return $return;
	}
	
	public function getTypes() {
		$return = array();
		foreach($this->data_model->getTypes($this->support) as $type) {
			$return[$type->id] = $type->label;
		}
		return $return;
	}
	
	public function getRegions() {
		$return = array();
		foreach($this->data_model->getRegions() as $region) {
			$return[$region->id] = $region->label;
		}
		return $return;
	}
	
	public function getVisuels() {
		$return = array();
		foreach($this->data_model->getVisuels($this->support) as $visuel) {
			$return[$visuel->visuel_actuel] = $visuel->visuel;
		}
		return $return;
	}

	public function index() {
		$this->page = "templates/v3/admin-panneaux";
		$this->layout();
	}
}
//iconv("UTF-8", "ASCII//TRANSLIT", $text)