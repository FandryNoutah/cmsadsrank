<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Flags extends MY_Controller
{
	protected $path;
	protected $support;
	protected $flags;
	

	function __construct() {
		parent::__construct();
		
		
		$this->support = 3;
		$this->load->model("data_model");
		
		$this->kiosques = $this->data_model->getAll($this->support);
		$this->data["flags"] = $this->flags;
		$this->data["locations"] = $this->getMapLocations();
		
		
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
		$this->page = "templates/v3/admin_flags";
		$this->layout();
	}


	public function getMapLocations() {
		$locations = array();
		$i = 0;
		
//		foreach($this->data_model->getAll($this->support) as $location) {
		foreach($this->data_model->getAll($this->support) as $location) {
			
			if (is_null($location->latitude) || is_null($location->longitude) || ($location->latitude == "0.00000000") || ($location->longitude == "0.00000000") )
				continue;
			
			$locations[] = [
/*				"<b>Ref.</b> " . $location->reference . "<br/><b>Région</b> : " . $location->region . "<br/><b>Ville</b> : " . $location->ville . "<br/><b>Quartier</b> : " . $location->quartier . "<br/><b>Emplacement</b> : " . $location->emplacement . "<br/><b>Visuel</b> : " . $location->visuel,*/
				"desc first ".$i,
				$location->latitude,
				$location->longitude,
				"desc AAA ".$i,
				"http://www.telma.mg/",
				$i
			];
			
			$i++;
			

		}
		return $locations;
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