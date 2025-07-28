<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fichevisuels extends MY_Controller {
	
	protected $file_upload_field;
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("visuels_model");
		$this->load->model("Concurrent");
		$this->data['visuels'] = $this->visuels_model->get_all();
		$this->data['listeConcurrent'] = $this->Concurrent->getConcurrent();
		
		$this->load->helper(array('form', 'url'));
		
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		
		$this->load->library('upload');
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
	}
	
	public function index() {
		
		$listeConcurrent = $this->Concurrent->getConcurrent();
		$this->page = "templates/fichevisuels";
		$this->layout();
	}

	public function getVisuel(){
        $page = "templates/fichevisuels";
        $this['visuels'] = $this->visuels_model->getVisuels();
        $rep = array('page'=>$page,'visuels'=>$visuels);
		$this->load->view('templates/fichevisuels',$rep);
      }
	
	
	public function delete($id) {
		if($this->visuels_model->delete_row($id)) {
			$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
			redirect('visuels', 'refresh');
		}
		//datadump($deleted);
	}
	
	public function edit($id = null) {
		if($id == null) {
			$postdata = $this->visuels_model->get_by_id($this->input->post("id"));
			$this->load->view("templates/v3/parts/visuels/part-edit", ["id" => $this->input->post("id"), "postdata" => $postdata]);
		} else {
			if($visuel = $this->visuels_model->update_visuel($id, $this->input->post())) {
				//datadump($visuel);
				$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
				redirect('visuels', 'refresh');
			}
		}
	}
	
	public function new() {
		$this->form_validation->set_rules('label', 'Nom', 'trim|required');
		$this->form_validation->set_rules('date_visuel', 'Date visuel', 'trim|required');
		
		$newData = $this->input->post();
		
		if($this->form_validation->run() == true) {
			datadump($newData);
			die();
			if($this->visuels_model->new_visuel($newData)) {
				$this->session->set_flashdata('message-succes', "Données inserées avec succès");
				redirect('visuels', 'refresh');
            } else {
				datadump("error");
			}
		}else {
			datadump("error");
			$this->page = "templates/v3/admin-visuels";
			$this->layout();
		}
		//redirect('visuels', 'refresh');
	}
	
	
	public function addVisuel() {
		
		$newData = $this->input->post();
				
				//datadump($newData);
				//datadump($_FILES); die();
		$listeConcurrent = $this->concurrent->getConcurrent();
		$insertconcurrent = $this->concurrent->insertconcurrent($data = null);
		
        $rep = array('listeConcurrent'=>$listeConcurrent);		
		$this->form_validation->set_rules($this->file_upload_field, '', 'callback_file_check');
		
            if($this->form_validation->run() == true) {

                $newData = $this->input->post();
				$insertconcurrent = $this->concurrent->insertconcurrent($data = null);
				
				//datadump($newData);
				//datadump($_FILES); die();
				
				$prefix = $newData["visuel_id"] . "_" . $newData["format_id"] . "_".$insertconcurrent["nomconcurrent"]. "_";
				
                $this->upload->initialize($this->set_upload_options($prefix,$insertconcurrent, $_FILES[$this->file_upload_field]["name"]));
                if ($this->upload->do_upload($this->file_upload_field)) {
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData["file_name"];
                    $newData[$this->file_upload_field] = $this->path . $this->upload->file_name;
					
					//datadump($newData);
					//datadump($_FILES);
					//die();
					
					if($this->visuels_model->save_visuel_formats($newData,$listeConcurrent,$insertconcurrent)) {
						$this->session->set_flashdata('message-succes', "Données inserées avec succès");
						redirect('visuels', 'refresh');
					}
                }

                redirect('visuels', 'refresh');
            } else {
				datadump("error");
			}
	}
	public function getPageAjoutConcurrent(){
        $page = "visuels";
        $listeConcurrent = $this->Concurrent->getConcurrent();
		datadump($listeConcurrent);
		die();
        $rep = array('page'=>$page,'listeConcurrent'=>$listeConcurrent);
        $this->load->view('visuels',$rep);
      }
	
	
	public function add() {
		
		//$newData = $this->input->post();
		//datadump($this->input->post());
		//datadump($_FILES);
		
		$this->form_validation->set_rules('panneau_visuel_name', 'Visuel', 'trim|required');
		$this->form_validation->set_rules($this->file_upload_field, $this->file_upload_field, 'callback_file_check');
			
            if($this->form_validation->run() == FALSE) {
				$error = [
					"validation_error" => $this->form_validation->error_array(),
				];
				echo json_encode($error);
            } else {
				$newDataVisuel["panneau_visuel_name"] = $this->input->post("panneau_visuel_name");
				if($visuel_id = $this->visuels_model->save_visuel($newDataVisuel)) {
					
					$prefix = $visuel_id . "_" . $this->input->post("format_id");
					
					$this->upload->initialize($this->set_upload_options($prefix, $_FILES[$this->file_upload_field]["name"]));
					
					if ($this->upload->do_upload($this->file_upload_field)) {
						$uploadData = $this->upload->data();
						$uploadedFile = $uploadData["file_name"];
						//$newData[$this->file_upload_field] = $this->path . $this->upload->file_name;
						
						$insertVisuelFormat = [
							"visuel_id" => $visuel_id,
							"format_id" => $this->input->post("format_id"),
							$this->file_upload_field => $this->path . $this->upload->file_name,
						];
						
						//datadump($insertVisuelFormat);
						//die();
						
						if($this->visuels_model->save_visuel_formats($insertVisuelFormat)) {
							//$this->session->set_flashdata('message-succes', "Données inserées avec succès");
							echo json_encode(["success" => "Visuel ajoutée"]);
							redirect('visuels', 'refresh');
						}
						
					}
					$this->session->set_flashdata('message-succes', "Données inserées avec succès");
					redirect('visuels', 'refresh');
				}
				//echo "Visuel inséré";
			}
	}
	
	public function get_visuels_formats() {
		$return = array();
		foreach($this->visuels_model->get_all_visuel_formats() as $key => $value) {
			$return[$value["visuel_id"]][$value["format_id"]] = $value["visuel_path"];
		}
		return $return;
	}
	
	public function file_check($string) {
        $allowedMimeTypeArray = [
            "image/gif", 
            "image/jpeg", 
            "image/png", 
            "image/x-png"
        ];
		
		
        if(isset($_FILES[$this->file_upload_field]["name"]) && $_FILES[$this->file_upload_field]["name"] != "") {
			$mime = get_mime_by_extension($_FILES[$this->file_upload_field]["name"]);
			if(in_array($mime, $allowedMimeTypeArray)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Type de fichier invalide');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_check', 'Veuillez choisir un fichier');
            return false;
        }
    }
	
	private function set_upload_options($prefix, $filename) {
        $file = pathinfo($filename);
        $file = $file['filename'];
        $config = array();
        $config['upload_path']      = $this->path;
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = '0';
        $config['file_name']        = url_title(iconv("UTF-8", "ASCII//TRANSLIT", $prefix . '_' . $file), '_', TRUE);
        $config['overwrite']        = FALSE;
        return $config;
    }
}
