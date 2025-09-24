<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upsell extends MY_Controller
{

	private $current_user;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Note_model');
		$this->load->model('Donne_modele');
		$this->load->library('ion_auth');

		// Utilisateur connecté
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{

		$ko = $this->data['donnee'] = $this->visuels_model->getClientDataByDonneeWithPmax();	

		$this->data['produit'] = $this->Donne_modele->get_all_produit();
		$this->data['am'] = $this->Donne_modele->get_all_am();
		$this->data['initiative'] = $this->Donne_modele->get_all_initiative();
		$this->content = "layouts/upsell/index.php";
		$this->layout();
	}


}
