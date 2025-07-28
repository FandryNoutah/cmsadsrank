<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campagnes extends MY_Controller {
	
	protected $file_upload_field;
	
	public function __construct() {
		parent::__construct();
		$this->load->model("campagnes_model");
		$this->load->library('form_validation');
		$visuels = $this->campagnes_model->get_allV();
		$this->data["listeV"] = $visuels;
		$this->data["campagnes"] = $this->campagnes_model->get_all();
	}
	
	public function index() {
		$this->data['date_debut'] = array(
			'name'          => 'date_debut',
			'id'            => 'date_debut',
			'type'          => 'date',
			'class'         => 'form-control',
			'value'         => $this->form_validation->set_value('date_debut'),
		);
		
		$this->data['date_fin'] = array(
			'name'          => 'date_fin',
			'id'            => 'date_fin',
			'type'          => 'text',
			'class'         => 'form-control',
			'placeholder'   => 'Date fin',
			'value'         => $this->form_validation->set_value('date_fin'),
		);	
		$this->page = "templates/v3/admin-campagnes";
		$this->layout();
	}
	
	public function add() {
		
		$this->form_validation->set_rules('label', 'Nom campagne', 'trim|required');
		$this->form_validation->set_rules("date_debut", "Date début", 'trim|required|callback_valid_date');
		$this->form_validation->set_rules("date_debut", "Date fin", 'trim|required|callback_valid_date');
		
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
				echo json_encode(["success" => "Campagne ajoutée"]);
				redirect('campagne', 'refresh');
			}
		}
	}
	
	public function edit($id = null) {
		$visuels = $this->campagnes_model->get_allV();
		
		if($id == null) {
			$postdata = $this->campagnes_model->get_by_id($this->input->post("id"));
			$this->load->view("templates/v3/parts/campagnes/part-edit", ["id" => $this->input->post("id"), "postdata" => $postdata ,"liste" => $visuels]);
		} else {
			if($visuel = $this->campagnes_model->update_campagne($id, $this->input->post())) {
				$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
				redirect('campagnes', 'refresh');
			}
		}
	}
	
	public function delete($id) {
		if($this->campagnes_model->delete_row($id)) {
			$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
			redirect('campagnes', 'refresh');
		}
		//datadump($deleted);
	}
	
	/*
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
	*/
	
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