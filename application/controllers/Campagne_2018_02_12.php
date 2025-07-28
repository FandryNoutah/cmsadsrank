<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campagne extends MY_Controller {
	
	protected $file_upload_field;
	
	public function __construct() {
		parent::__construct();
		$this->load->model("campagne_model");
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
	
	public function add() {
		
		$this->form_validation->set_rules('panneau_campagne_nom', 'Nom campagne', 'trim|required');
		$this->form_validation->set_rules("panneau_campagne_date_lancement", "Date de lancement", 'trim|required|callback_valid_date');
		
		$newData = $this->input->post();
		//datadump($newData);
		
		if($this->form_validation->run() == FALSE) {
			$error = [
				"validation_error" => $this->form_validation->error_array(),
			];
			echo json_encode($error);
		} else {
			
			if($this->campagne_model->save_campagne($newData)) {
				//$this->session->set_flashdata('message-succes', "Données inserées avec succès");
				echo json_encode(["success" => "Visuel ajoutée"]);
				redirect('visuels', 'refresh');
			}
		}
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