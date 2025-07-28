<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campagne extends MY_Controller {
	
	protected $file_upload_field;
	
	public function __construct() {
		parent::__construct();
		$this->load->model("campagne_model");
		$this->load->model("campagnes_model");
		$this->load->library('form_validation');
		$this->data["campagnes"] = $this->campagne_model->get_all();
	}
	
	public function index() {
		$this->data['panneau_campagne_date_lancement'] = array(
			'name'          => 'panneau_campagne_date_lancement',
			'id'            => 'panneau_campagne_date_lancement',
			'type'          => 'date',
			'class'         => 'form-control',
			'value'         => $this->form_validation->set_value('panneau_campagne_date_lancement'),
		);
		
		$this->data['panneau_campagne_nom'] = array(
			'name'          => 'panneau_campagne_nom',
			'id'            => 'panneau_campagne_nom',
			'type'          => 'text',
			'class'         => 'form-control',
			'placeholder'   => 'Nom campagne',
			'value'         => $this->form_validation->set_value('panneau_campagne_nom'),
		);
		
		$this->page = "templates/admin_campagne";
		$this->layout();
	}
	
	/*public function add() {
		
		$this->form_validation->set_rules('label', 'label', 'trim|required');
		$this->form_validation->set_rules("date_debut", "date_debut", 'trim|required|callback_valid_date');
		$this->form_validation->set_rules("date_fin", "date_fin", 'trim|required|callback_valid_date');
		$data = $this->input->post();
		//datadump($data);
		//die();
		if($this->form_validation->run() == FALSE) {
			$error = [
				"validation_error" => $this->form_validation->error_array(),
			];
			echo json_encode($error);
		} else {
			
			if($this->campagne_model-> new_campagne($data)) {
				$this->session->set_flashdata('message-succes', "Données inserées avec succès");
				echo json_encode(["success" => "Campagne ajoutée"]);
				redirect('campagne', 'refresh');
			}
		}
	}*/
	public function add() {
		
		$label = $this->input->post('label');
        $date_debut = $this->input->post('date_debut');
		$date_fin = $this->input->post('date_fin');
		$visuels = $this->input->post('visuels');
		$this->data['listeVisuels'] = $visuels;
		
		//$data = $label;
		if($this->campagnes_model->insererConcurrent($label,$date_debut,$date_fin,$visuels)){
			$this->session->set_flashdata('message-succes', "Données inserées avec succès");
			echo json_encode(["success" => "Campagne ajoutée"]);
			
			
		}
		redirect('campagnes');
		//$this->layout();
	}
	
	public function edit() {
		$this->form_validation->set_rules('panneau_campagne_nom', 'Nom campagne', 'trim|required');
		$this->form_validation->set_rules("panneau_campagne_date_lancement", "Date de lancement", 'trim|required|callback_valid_date');
		$newData = $this->input->post();
		if($this->form_validation->run() == FALSE) {
			$error = [
				"validation_error" => $this->form_validation->error_array(),
			];
			echo json_encode($error);
		} else {
			
			if($this->campagne_model->update_campagne($this->input->post("id"), $this->input->post())) {
				//$this->session->set_flashdata('message-succes', "Données inserées avec succès");
				$success = ["success" => "MAJ effectuée"];
				$success = array_merge($success, $newData);
				echo json_encode($success);
				redirect('visuels', 'refresh');
			}
		}
	}
	
	public function delete() {
		$id = $this->input->post("id");
		if($id && $id != null) {
			if($this->campagne_model->delete_campagne($id)) 
				echo json_encode(["success" => "Campagne supprimée"]);
			else
				echo json_encode(["error" => "Une erreur est survenue"]);
		} else {
			echo json_encode(["error" => "Une erreur est survenue"]);
		}
	}
	
	public function valid_date($date) {
        $format = 'Y-m-d';
        $d = DateTime::createFromFormat($format, $date);
        $today = date('Y-m-d');
        
        if($d && $d->format($format) == $date) {
            /* à uyiliser pour une différence entre deux dates
            if ($date > $today) {
                return true;
            } else {
                $this->form_validation->set_message('valid_date', 'La date doit être supérieure à la date en cours');
                return false;
            }
            */
            return true;
        } else {
            $this->form_validation->set_message('valid_date', 'Format de date invalide');
            return false;
        }
    }
}