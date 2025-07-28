<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends MY_Controller
{
	protected $data;
 
	function __construct() {
		parent::__construct();
		$this->data['page_title'] = 'Hors Média';
		
		/*
		$this->data['panneaux'] = $this->panneau_model->get_all();
		$this->data['kiosques'] = $this->kiosque_model->get_all();
		$this->data['flags'] = $this->flags_model->get_all();
		$this->data['regisseurs'] = $this->regisseur_model->get_all();
		$this->data['panneaux_coords'] = $this->panneau_model->get_all_panneau_coords();
		$this->data['flag_coords'] = $this->flags_model->get_all_flag_coords();
		$this->data['_visuels'] = $this->visuels_model->get_all();
		
		foreach ($this->panneau_model->get_provinces() as $key => $value) {
			$provinces[$value->id] = $value->label;
		}
		foreach ($this->panneau_model->get_regisseurs() as $regisseurs) {
			$regisseur[$regisseurs->id] = $regisseurs->label;
		}
		$this->data['provinces'] = $provinces;
		$this->data['regisseurs'] = $regisseur;
		*/
	}

	public function index()
	{
		$this->content = "layouts/dashboard";
		$this->layout();
	}
}
