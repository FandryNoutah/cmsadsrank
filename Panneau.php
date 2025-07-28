<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Panneau extends MY_Controller
{
	protected $path;

	function __construct() {
		parent::__construct();
		
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

		$this->data["yesno"] = array("Oui", "Non");
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
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		/* Form validation */
		$this->form_validation->set_rules('panneau_reference', '', 'trim|required');
		$this->form_validation->set_rules('panneau_format', '', 'trim|required');
		$this->form_validation->set_rules('panneau_type', '', 'trim|required');
		$this->form_validation->set_rules('panneau_regisseur', '', 'trim|required');
		$this->form_validation->set_rules('panneau_province', '', 'trim|required');
		$this->form_validation->set_rules('panneau_quartier', '', 'trim|required');
		$this->form_validation->set_rules('panneau_axe', '', 'trim|required');
		$this->form_validation->set_rules('panneau_sam', 'trim|required');
		$this->form_validation->set_rules('panneau_emplacement', '', 'trim|required');
		$this->form_validation->set_rules('panneau_region', '', 'trim|required');
		$this->form_validation->set_rules('panneau_proximite', '', 'trim|required');
		$this->form_validation->set_rules('panneau_latitude', '', 'trim|required|decimal');
		$this->form_validation->set_rules('panneau_longitude', '', 'trim|required|decimal');
		$this->form_validation->set_rules('panneau_couverture_4g', 'trim|required');
		$this->form_validation->set_rules('panneau_couverture_fo', 'trim|required');
		$this->form_validation->set_rules('panneau_couverture_adsl', 'trim|required');
		$this->form_validation->set_rules('panneau_cout_location', '', 'trim|required|integer');
		$this->form_validation->set_rules('panneau_cout_pose_finition', '', 'trim|required|integer');
		$this->form_validation->set_rules('panneau_cout_impression', '', 'trim|required|integer');
		/* Form validation */

		if ($this->form_validation->run() == FALSE)
        {
                echo "Je me figure de ce zouave qui joue du xylophone";
        }

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

		$this->data['panneau_emplacement'] = array(
            'name'  		=> 'panneau_emplacement',
            'id'    		=> 'panneau_emplacement',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Emplacement',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_emplacement'),
        );
		
		$this->data['panneau_quartier'] = array(
            'name'  		=> 'panneau_quartier',
            'id'    		=> 'panneau_quartier',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Quartier',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_quartier'),
        );
		
		$this->data['panneau_region'] = array(
            'name'  		=> 'panneau_region',
            'id'    		=> 'panneau_region',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Région',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_region'),
        );
		
		$this->data['panneau_proximite'] = array(
            'name'  		=> 'panneau_proximite',
            'id'    		=> 'panneau_proximite',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Proximité',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_proximite'),
        );
		
		$this->data['panneau_latitude'] = array(
            'name'  		=> 'panneau_latitude',
            'id'    		=> 'panneau_latitude',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Latitude',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_latitude'),
        );
		
		$this->data['panneau_longitude'] = array(
            'name'  		=> 'panneau_longitude',
            'id'    		=> 'panneau_longitude',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Longitude',
            'required' 		=> 'required',
            'value' 		=> $this->form_validation->set_value('panneau_longitude'),
        );
		
		$this->data['panneau_cout_impression'] = array(
            'name'  		=> 'panneau_cout_impression',
            'id'    		=> 'panneau_cout_impression',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Impression',
            'value' 		=> $this->form_validation->set_value('panneau_cout_impression'),
        );

        $this->data['panneau_cout_pose_finition'] = array(
            'name'  		=> 'panneau_cout_pose_finition',
            'id'    		=> 'panneau_cout_pose_finition',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Pose et finition',
            'value' 		=> $this->form_validation->set_value('panneau_cout_pose_finition'),
        );

        $this->data['panneau_cout_location'] = array(
            'name'  		=> 'panneau_cout_location',
            'id'    		=> 'panneau_cout_location',
            'type'  		=> 'text',
            'class' 		=> 'form-control',
            'placeholder' 	=> 'Location',
            'value' 		=> $this->form_validation->set_value('panneau_cout_location'),
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

        $this->data['panneau_province'] = array(
            'name'  => 'panneau_province',
        );

        $this->data['panneau_axe'] = array(
            'name'  => 'panneau_axe',
        );

        $this->data['panneau_sam'] = array(
            'name'  => 'panneau_sam',
        );
		
		$this->data['panneau_couverture_4g'] = array(
            'name'  => 'panneau_couverture_4g',
        );

        $this->data['panneau_couverture_fo'] = array(
            'name'  => 'panneau_couverture_fo',
        );

        $this->data['panneau_couverture_adsl'] = array(
            'name'  => 'panneau_couverture_adsl',
        );
		/* Set form */

		$this->page = "templates/admin_panneau_add";
		$this->layout();
	}
}