<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upsell extends MY_Controller
{

	private $current_user;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Upsell_model');
		$this->load->library('ion_auth');

		// Utilisateur connecté
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{

		$this->data['upsell_active'] = $this->Upsell_model->get_upsell_active();	
		$this->content = "layouts/upsell/index.php";
		$this->layout();
	}


}
