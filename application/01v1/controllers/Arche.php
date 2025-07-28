<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Arche extends MY_Controller
{
	protected $path;
	protected $file_upload_field;

	function __construct() {
		parent::__construct();
		$this->load->model("arche_model");
		$this->load->model("flags_model");
		$this->load->library('upload');
		$this->data["arches"] = $this->arche_model->get_all();
		$this->path = "assets/uploads/arches/";

		foreach ($this->arche_model->get_formats() as $formats) {
			$formatArche[$formats->label] = $formats->label;
		}

		foreach ($this->flags_model->get_provinces() as $provinces) {
            //$province[$provinces->label] = $provinces->label;
            $province[$provinces->label] = $provinces->label;
        }
		$this->data["formats"] = $formatArche;
		$this->data["provinces"] = $province;
	}

	public function index()
	{
		$this->page = "templates/admin_arche";
		$this->layout();
	}

	public function add() {
		$this->data['page_title'] = 'Ajout nouvel arche';
		$this->file_upload_field = "hm_arche_visuel_path";
        $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		$this->form_validation->set_rules('hm_arche_emplacement', '', 'trim|required');
		$this->form_validation->set_rules('hm_arche_format', '', 'trim|required');
		$this->form_validation->set_rules('hm_arche_province', '', 'trim|required');
		$this->form_validation->set_rules('hm_arche_visuel', '', 'trim|required');
		$this->form_validation->set_rules('hm_arche_visuel_path', '', 'trim');
		
		$newData = array();

        if(isset($_FILES) && $_FILES && $_FILES[$this->file_upload_field]["name"] != "") { 
            print_r($_FILES);
            $this->form_validation->set_rules('hm_arche_visuel_path', '', 'callback_file_check');
        }

        if ($this->form_validation->run() == true) {
            $newData = $this->input->post();
            if(isset($_FILES) && $_FILES && $_FILES[$this->file_upload_field]["name"] != "") {
                $this->upload->initialize($this->set_upload_options('', $_FILES[$this->file_upload_field]["name"]));
                if ($this->upload->do_upload($this->file_upload_field)) {
                    $newData[$this->file_upload_field] = $this->path . $this->upload->file_name;
                }
            }
            echo "<pre>";
            print_r($newData);
            echo "</pre>";
            //die("eto");
            if($this->arche_model->save_arche($newData)) {
                $this->session->set_flashdata('message-succes', "Données inserées avec succès");
                redirect('arche', 'refresh');
            }
            redirect('arche', 'refresh');
        } else {
			$this->data['hm_arche_emplacement'] = array(
	            'name'  => 'hm_arche_emplacement',
	            'id'    => 'hm_arche_emplacement',
	            'placeholder' => 'Emplacement',
	            'type'  => 'text',
	        	'class' => 'form-control',
	        	'required' => 'required',
	            'value' => $this->form_validation->set_value('hm_arche_emplacement'),
	        );

	        $this->data['hm_arche_visuel'] = array(
	            'name'  => 'hm_arche_visuel',
	            'id'    => 'hm_arche_visuel',
	            'placeholder' => 'Emplacement',
	            'type'  => 'text',
	        	'class' => 'form-control',
	        	'required' => 'required',
	            'value' => $this->form_validation->set_value('hm_arche_visuel'),
	        );

	        $this->data['hm_arche_visuel_path'] = array(
	        	'name'  => 'hm_arche_visuel_path',
	            'id'    => 'hm_arche_visuel_path',
	        );
    	}
    	$this->page = "templates/admin_arche_add";
		$this->layout();
	}

	public function edit($id) {
		$this->data['page_title'] = 'Mise à jour';
        $this->load->library('form_validation');
        $this->load->helper('html');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($id == null) {
            $this->session->set_flashdata('message-error', "Veuillez selectionner un élément à éditer SVP!");
            redirect('arche', 'refresh');
        } else {
            if(!is_numeric($id)) {
                $this->session->set_flashdata('message-error', "Element invalide, veuillez selectionner un élément à éditer SVP!");
                redirect('arche', 'refresh');
            } else {
                $this->data['page_title'] = 'Mise à jour';
                $this->file_upload_field = "hm_arche_visuel_path";
                $this->load->library('form_validation');
                $this->load->helper('html');
                $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

                $this->form_validation->set_rules('hm_arche_emplacement', '', 'trim|required');
				$this->form_validation->set_rules('hm_arche_format', '', 'trim|required');
				$this->form_validation->set_rules('hm_arche_province', '', 'trim|required');
				$this->form_validation->set_rules('hm_arche_visuel', '', 'trim|required');
				$this->form_validation->set_rules('hm_arche_visuel_path', '', 'trim');

				$arche = $this->arche_model->get_arche_by_id($id);
				
				$newData = array();

				if(isset($_FILES) && $_FILES && $_FILES[$this->file_upload_field]["name"] != "") { 
		            print_r($_FILES);
		            $this->form_validation->set_rules('hm_arche_visuel_path', '', 'callback_file_check');
		        }

		        if ($this->form_validation->run() == true) {
		            $newData = $this->input->post();
		            if(isset($_FILES) && $_FILES && $_FILES[$this->file_upload_field]["name"] != "") {
		                $this->upload->initialize($this->set_upload_options('', $_FILES[$this->file_upload_field]["name"]));
		                if ($this->upload->do_upload($this->file_upload_field)) {
		                    $newData[$this->file_upload_field] = $this->path . $this->upload->file_name;
		                    echo "<pre>";
				            print_r($newData);
				            echo "</pre>";
				            die("eto");
		                } else {
		                	echo "<pre>";
		                	print_r($this->upload->display_errors()); echo "</pre>";
		                }

		            }
		            die("out");
		            if($this->arche_model->update_arche($id, $newData)) {
		                $this->session->set_flashdata('message-succes', "Données modifiées avec succès");
		                redirect('arche', 'refresh');
		            }
		            redirect('arche', 'refresh');
		        } else {

		        	if($arche->hm_arche_visuel_path) {
                        $this->data['image_properties'] = array(
                            'src'   => $arche->hm_arche_visuel_path,
                            'alt'   => $arche->hm_arche_visuel,
                            'class' => 'img-fluid media-object img-thumbnail',
                            'style' => 'float: left',
                            'width' => '150',
                            'title' => $arche->hm_arche_visuel,
                        );
                    } else {
                        $this->data['image_properties'] = "";
                    }

					$this->data['hm_arche_emplacement'] = array(
			            'name'  => 'hm_arche_emplacement',
			            'id'    => 'hm_arche_emplacement',
			            'placeholder' => 'Emplacement',
			            'type'  => 'text',
			        	'class' => 'form-control',
			        	'required' => 'required',
			            'value' => $arche->hm_arche_emplacement,
			        );

			        $this->data['hm_arche_visuel'] = array(
			            'name'  => 'hm_arche_visuel',
			            'id'    => 'hm_arche_visuel',
			            'placeholder' => 'Emplacement',
			            'type'  => 'text',
			        	'class' => 'form-control',
			        	'required' => 'required',
			            'value' => $arche->hm_arche_visuel,
			        );

			        $this->data['hm_arche_visuel_path'] = array(
			        	'name'  => 'hm_arche_visuel_path',
			            'id'    => 'hm_arche_visuel_path',
			        );

			        $this->data['province_selected'] =  $arche->hm_arche_province;
			        $this->data['format_selected'] =  $arche->hm_arche_format;
		    	}
		    	$this->page = "templates/admin_arche_edit";
				$this->layout();
            }
        }
        
	}

	public function delete($id) {
		if($id != null) {
			
			//print_r($this->kiosque_model->delete_kiosque($id));
			//exit();
			if($this->arche_model->delete_arche($id) == 1) {
				$this->session->set_flashdata('message-succes', "Données supprimée avec succès");
				redirect('arche', 'refresh');
			} else {
				echo "sorry";
			}
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

    public function file_check($string) {
        $allowedMimeTypeArray = array("image/gif", "image/jpeg", "image/png", "image/x-png");
        $mime = get_mime_by_extension($_FILES[$this->file_upload_field]["name"]);
        if(isset($_FILES[$this->file_upload_field]["name"]) && $_FILES[$this->file_upload_field]["name"] != "") {
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
}