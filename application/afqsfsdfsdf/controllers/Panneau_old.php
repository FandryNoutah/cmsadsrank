<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Panneau extends MY_Controller
{
	protected $path;

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("panneau_model");
		$this->data["panneaux"] = $this->panneau_model->get_all();

		foreach ($this->panneau_model->get_formats() as $formats) {
			$format[$formats->id] = $formats->format;
		}

		foreach ($this->panneau_model->get_regisseurs() as $regisseurs) {
			$regisseur[$regisseurs->id] = $regisseurs->label;
		}

		foreach ($this->panneau_model->get_provinces() as $provinces) {
			$province[$provinces->id] = $provinces->label;
		}

		foreach ($this->panneau_model->get_types() as $types) {
			$type[$types->id] = $types->type;
		}

		foreach ($this->panneau_model->get_axes() as $axes) {
			$axe[$axes->id] = $axes->label;
		}
		
		foreach ($this->panneau_model->get_all_sam() as $allsam) {
			$sam[$allsam->id] = $allsam->label;
		}

		$this->data["formats"] 		= $format;
		$this->data["regisseurs"] 	= $regisseur;
		$this->data["provinces"] 	= $province;
		$this->data["types"] 		= $type;
		$this->data["axes"] 		= $axe;
		$this->data["sam"] 			= $sam;
		$this->path = "assets/uploads/panneaux/";
	}

	public function index()
	{
		$this->page = "templates/admin_panneau";
		$this->layout();
	}

	public function view($id = null) {
		if($id === null) {
			$this->session->set_flashdata('message-error', "Panneau introuvable, veuillez selectionner un panneau à visualiser SVP!");
			redirect('panneau', 'refresh');
		} else {
			$panneauDetails = $this->panneau_model->get_panneau_by_id($id);
			$totalPrice = $panneauDetails->panneau_cout_impression + $panneauDetails->panneau_cout_pose_finition + $panneauDetails->panneau_cout_location;

			$this->data["totalPrice"] = $totalPrice;
			$this->data["panneau"] = $panneauDetails;
			//print_r($panneau);
			$this->page = "templates/admin_panneau_view";
			$this->layout();
		}
	}

	public function add() {
		$this->data['title'] = "Ajout panneau";

		/* Form validation */
		$this->form_validation->set_rules('panneau_reference', 'trim|required');
		$this->form_validation->set_rules('panneau_format', 'trim|required');
		$this->form_validation->set_rules('panneau_type', 'trim|required');
		$this->form_validation->set_rules('panneau_regisseur', 'trim|required');
		/* Form validation */

		/* Set form */
		$this->data['panneau_reference'] = array(
            'name'  		=> 'panneau_reference',
            'id'    		=> 'panneau_reference',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Réference',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_reference'),
        );

        $this->data['panneau_format'] = array(
            'name'  => 'panneau_format',
        );

        $this->data['panneau_type'] = array(
            'name'  => 'panneau_type',
        );

        $this->data['panneau_regisseur'] = array(
            'name'  => 'panneau_regisseur',
        );

		/* Set form */

		$this->page = "templates/admin_panneau_add";
		$this->layout();
	}
}