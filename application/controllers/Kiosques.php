<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Kiosques extends MY_Controller
{
	protected $path;
	protected $support;
	protected $kiosques;
	

	function __construct() {
		parent::__construct();
		
		
		$this->support = 4;
		$this->load->model("data_model");
		
		$this->kiosques = $this->data_model->getAll($this->support);
		$this->data["kiosques"] = $this->kiosques;
		
		
		//$this->load->model("kiosque_model");
		//$this->data["kiosques"] = $this->kiosque_model->get_all();
		$this->path = "assets/uploads/kiosques/";
		
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
		$this->page = "templates/v3/admin_kiosque";
		$this->layout();
	}

	public function add() {
		$this->data['page_title'] = 'Ajout nouveau kiosque';
        $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		$this->form_validation->set_rules('nom_kiosque', 'nom kiosque', 'trim|required');
		$this->form_validation->set_rules('dimension', 'dimension', 'trim|required');

		if (empty($_FILES['image']['name'])) {
			$this->form_validation->set_rules('image', 'image', 'trim');
		}

		foreach($this->kiosque_model->get_dimensions() as $dimension) {
			$dimensions[$dimension->id] = $dimension->label;
		}

		$this->data['dimensions'] = $dimensions;
		$this->data['statuses'] = array("Inactive","Active");
		$this->data['attributes'] = array(
			'id'    				=> 'status',
			"class" 				=> "form-control",
			"data-toggle" 			=> "", 
			"data-trigger" 			=> "",
			"data-placement" 		=> "", 
			"data-title" 			=> "Priority",
			"data-original-title" 	=> "", 
			"title" 				=> "",
		);

		$this->data['nom_kiosque'] = array(
            'name'  => 'nom_kiosque',
            'id'    => 'nom_kiosque',
            'type'  => 'text',
        	'class' => 'form-control border-primary',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['status'] = array(
            'name'  => 'status',
            
            'class' => 'form-control',
        );
        $this->data['dimension'] = array(
            'name'  => 'dimension',
            'id'    => 'dimension',
        );
        $this->data['image'] = array(
            'name'  => 'image',
            'id'    => 'image',
        );

		if ($this->form_validation->run() === FALSE) {        	
        	$this->page = "templates/admin_kiosque_add";
			$this->layout();
        } else {
        	$uploadConfig = array(
				"upload_path" => $this->path,
				"allowed_types" => "jpg|png|jpeg",
				"max_size" => "6000",
				"max_height" => "768",
				"max_width" => "1024",
			);

			$this->load->library('upload', $uploadConfig);
			
			//$new_kiosque[] = $this->input->post();

			if (!$this->upload->do_upload('image')) {
				// case - failure
				//print_r($this->upload->filename);
				
				$upload_error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('upload-error', $upload_error);
				$this->page = "templates/admin_kiosque_add";
            	$this->layout();
			} else {
				$new_kiosque = array();
				// case - success
				$files = $_FILES;
				
				$upload_data['image'] = $this->upload->data();
				/*
				foreach($files as $key => $file) {
					if($key != 'image') {
						$this->upload->do_upload($key);
						$upload_data[$key] = $file["name"] == '' ? array('file_name' => '') : $this->upload->data();
						$new_kiosque[$key] = $upload_data[$key]['file_name'] == '' ? '' : $this->path . $upload_data[$key]['file_name'];
					}
				}
				*/
				$new_kiosque['image'] = $this->path.$this->upload->file_name;
				$this->data['message'] = (validation_errors() ? validation_errors() : '');
				$this->session->set_flashdata('message', "Message");
	        }

	        $new_kiosque["nom_kiosque"] = $this->input->post("nom_kiosque");
	        $new_kiosque["dimension"] = $this->input->post("dimension");
	        $new_kiosque["status"] = $this->input->post("status");
	        if($this->kiosque_model->save_kiosque($new_kiosque)) {
	        	$this->session->set_flashdata('message-succes', "Données inserées avec succès");
	        	redirect('kiosque', 'refresh');
	        }
            //redirect('kiosque', 'refresh');
        }
	}

	public function edit($id) {
		$this->data['page_title'] = 'Mise à jour';
        $this->load->library('form_validation');
        $this->load->helper('html');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		$this->form_validation->set_rules('nom_kiosque', 'nom kiosque', 'trim|required');
		$this->form_validation->set_rules('dimension', 'dimension', 'trim|required');

		$kiosque = $this->kiosque_model->get_kiosque_by_id($id);

		if (empty($_FILES['image']['name'])) {
			$this->form_validation->set_rules('image', 'image', 'trim');
		}

		foreach($this->kiosque_model->get_dimensions() as $dimension) {
			$dimensions[$dimension->id] = $dimension->label;
		}

		if($kiosque->image) {
			$this->data['image_properties'] = array(
		        'src'   => $kiosque->image,
		        'alt'   => $kiosque->nom_kiosque,
		        'class' => 'img-fluid media-object img-thumbnail',
		        'style' => 'float: left',
		        'width' => '120',
		        'title' => $kiosque->nom_kiosque,
			);
		}

		$this->data['dimensions'] = $dimensions;
		$this->data['statuses'] = array("Inactive","Active");

		$this->data['dimension_selected'] = $kiosque->dimension; 
		$this->data['status_selected'] = $kiosque->status; 

		$this->data['attributes'] = array(
			'id'    				=> 'status',
			"class" 				=> "form-control",
			"data-toggle" 			=> "", 
			"data-trigger" 			=> "",
			"data-placement" 		=> "", 
			"data-title" 			=> "Priority",
			"data-original-title" 	=> "", 
			"title" 				=> "",
		);

		$this->data['nom_kiosque'] = array(
            'name'  => 'nom_kiosque',
            'id'    => 'nom_kiosque',
            'type'  => 'text',
        	'class' => 'form-control border-primary',
            'value' => $this->form_validation->set_value('nom_kiosque', $kiosque->nom_kiosque),
        );
        $this->data['status'] = array(
            'name'  => 'status',
            'class' => 'form-control',
        );
        $this->data['dimension'] = array(
            'name'  => 'dimension',
            'id'    => 'dimension',
        );
        $this->data['image'] = array(
            'name'  => 'image',
            'id'    => 'image',
        );

		if ($this->form_validation->run() === FALSE) {        	
        	$this->page = "templates/admin_kiosque_edit";
			$this->layout();
        } else {
        	$uploadConfig = array(
				"upload_path" => $this->path,
				"allowed_types" => "jpg|png|jpeg",
				"max_size" => "6000",
				"max_height" => "768",
				"max_width" => "1024",
			);

			$this->load->library('upload', $uploadConfig);
			
			//$new_kiosque[] = $this->input->post();

			if (!$this->upload->do_upload('image')) {
				// case - failure
				//print_r($this->upload->filename);
				
				$upload_error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('upload-error', $upload_error);
				$this->page = "templates/admin_kiosque_add";
            	$this->layout();
			} else {
				$u_kiosque = array();
				// case - success
				$files = $_FILES;
				
				$upload_data['image'] = $this->upload->data();
				/*
				foreach($files as $key => $file) {
					if($key != 'image') {
						$this->upload->do_upload($key);
						$upload_data[$key] = $file["name"] == '' ? array('file_name' => '') : $this->upload->data();
						$new_kiosque[$key] = $upload_data[$key]['file_name'] == '' ? '' : $this->path . $upload_data[$key]['file_name'];
					}
				}
				*/
				$u_kiosque['image'] = $this->path.$this->upload->file_name;
				$this->data['message'] = (validation_errors() ? validation_errors() : '');
				$this->session->set_flashdata('message', "Message");
	        }

	        $u_kiosque["nom_kiosque"] = $this->input->post("nom_kiosque");
	        $u_kiosque["dimension"] = $this->input->post("dimension");
	        $u_kiosque["status"] = $this->input->post("status");
	        if($this->kiosque_model->update_kiosque($id, $u_kiosque)) {
	        	$this->session->set_flashdata('message-succes', "Données mises à jour avec succès");
	        	redirect('kiosque', 'refresh');
	        }
            //redirect('kiosque', 'refresh');
        }
	}

	public function delete($id) {
		if($id != null) {
			
			//print_r($this->kiosque_model->delete_kiosque($id));
			//exit();
			if($this->kiosque_model->delete_kiosque($id) == 1) {
				$this->session->set_flashdata('message-succes', "Données supprimée avec succès");
				redirect('kiosque', 'refresh');
			} else {
				echo "sorry";
			}
		}
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