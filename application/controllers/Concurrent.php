<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concurrent extends MY_Controller {
	
	protected $file_upload_field;
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("visuels_model");
		$this->load->model("Concurrent");
		$this->data['visuels'] = $this->visuels_model->get_all();
		$this->data['listeConcurrent'] = $this->Concurrent->getConcurrent();
		$this->data['visuels'] = $this->visuels_model->get_by_id($id);
		$this->load->helper(array('form', 'url'));
		
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		
		$this->load->library('upload');
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
	}
	
	public function index($id) {
		$this->data['visuels'] = $this->visuels_model->get_by_id($id);
		$this->page = "templates/visuelsConcurrent";
		$this->layout();
	}
	public function fichevisuels()
	{
		$this->page = "templates/fichevisuels";
		//templates/fichevisuels
		$this->layout();
	}
	
	public function delete($id) {
		if($this->visuels_model->delete_row($id)) {
			$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
			redirect('visuels', 'refresh');
		}
		//datadump($deleted);
	}
	
		public function visuelConcurrent($id){
		$ok = $this->visuels_model->get_all();
		$this->data['visuels'] = $this->visuels_model->get_by_id($id);
		
		//$this->data["visuels"] = $this->visuels_model->get_by_id($id);
		$this->page = "templates/visuelsConcurrent";
        $this->layout();
		
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
	/*public function add() {
		$this->form_validation->set_rules('label', 'Nom', 'trim|required');
		$this->form_validation->set_rules('date_visuel', 'Date visuel', 'trim|required');
		$newData = array();
        
        $this->form_validation->set_rules('logo', '', 'callback_file_check');
        if($this->form_validation->run() == true) {
            
            $newData = $this->input->post();
            $this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
            if ($this->upload->do_upload('logo')) {
                $newData['logo'] = $this->path . $this->upload->file_name;
            }
            //print_r($newData);
            if($this->regisseur_model->save_regisseur($newData)) {
                $this->session->set_flashdata('message-succes', "Données inserées avec succès");
                redirect('regisseur', 'refresh');
            }
            redirect('regisseur', 'refresh');
        } else {
            $this->data['label'] = array(
                'name'          => 'label',
                'id'            => 'label',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Label',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('label'),
            );

            $this->data['commentaires'] = array(
                'name'          => 'commentaires',
                'id'            => 'commentaires',
                'class'         => 'form-control',
                'placeholder'   => 'Commentaires',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('commentaires'),
            );

            $this->data['telephone'] = array(
                'name'          => 'telephone',
                'id'            => 'telephone',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Téléphone',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('telephone'),
            );

            $this->data['email'] = array(
                'name'          => 'email',
                'id'            => 'email',
                'type'          => 'email',
                'class'         => 'form-control',
                'placeholder'   => 'Email',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('email'),
            );
			$this->data['DateDebut'] = array(
                'name'          => 'DateDebut',
                'id'            => 'DateDebut',
                'class'         => 'form-control',
                'placeholder'   => 'DateDebut',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('DateDebut'),
            );
			$this->data['DateFin'] = array(
                'name'          => 'DateFin',
                'id'            => 'DateFin',
                'class'         => 'form-control',
                'placeholder'   => 'DateFin',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('DateFin'),
            );
			$this->data['information'] = array(
                'name'          => 'information',
                'id'            => 'information',
                'class'         => 'form-control',
                'placeholder'   => 'information',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('information'),
            );

            $this->data['logo'] = array(
                'name'  => 'logo',
                'id'    => 'logo',
            );
        }
        $this->page = "templates/admin_regisseur_add";
        $this->layout();
	}*/
	
	
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
