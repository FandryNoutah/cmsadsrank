<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Arches extends MY_Controller
{
	protected $path;
	protected $support;
	protected $arches;
	

	function __construct() {
		parent::__construct();	
		$this->support = 2;
		$this->load->model("data_model");
		
		$this->kiosques = $this->data_model->getAll($this->support);
		$this->data["arches"] = $this->arches;
		$this->data['current_user'] = $this->ion_auth->user()->row();
		$this->ion_auth_model->trigger_events('in_group');

		$id = $this->session->userdata('user_id');
		$this->data['idusers'] = $this->session->userdata('user_id');
		$this->data['users_groups'] = $this->ion_auth_model->get_users_groups($id)->result();
		
		$this->data["filterData"] = array(
            "format" 	 => $this->getFormats(),
            "regisseur" => $this->getRegisseurs(), 
            "province"  => $this->getProvinces(), 
            "type" 	 	=> $this->getTypes(), 
            "region" 	 => $this->getRegions(),
            "visuel" 	 => $this->getVisuels(),
        );
		
	}

	public function index()
	{
		$this->page = "templates/v3/admin_arches";
		$this->layout();
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
}