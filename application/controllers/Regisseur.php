<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Regisseur extends MY_Controller
{
	protected $path;
    protected $file_upload_field;

	function __construct() {
		parent::__construct();
		$this->load->model("regisseur_model");
        $this->load->library('upload');
		$this->data["regisseurs"] = $this->regisseur_model->get_all();
		$this->path = "assets/uploads/regisseurs/";
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('admin/user/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
           // return show_error('You must be an administrator to view this page.');
			 $this->page = "templates/user_regisseur";
			$this->layout();
        }
        else
        {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
            foreach ($this->data['users'] as $k => $user)
            {
                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            //$this->_render_page('auth/index', $this->data);
            $this->page = "templates/admin_regisseur";
		$this->layout();
        }
	}	
	public function detail($id){
		//$id = $this->input->post();
		
		datadump($id);
		//die("end");
		$this->data["regisseur"] = $this->regisseur_model->get_regisseur_by_id($id);
		$this->page = "templates/admin_regisseur_detail";
        $this->layout();
		
	}
	

	public function add() {
		$this->data['page_title'] = "Ajout régisseur";
        $this->file_upload_field = "logo";
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		$this->form_validation->set_rules('label', '', 'trim|required');
        $this->form_validation->set_rules('commentaires', '', 'trim|required');
        $this->form_validation->set_rules('telephone', '', 'trim|required|numeric|exact_length[10]');
		$this->form_validation->set_rules('email', '', 'trim|required|valid_email');
		$this->form_validation->set_rules('DateDebut', '', 'trim|required');
		$this->form_validation->set_rules('DateFin', '', 'trim|required');
		$this->form_validation->set_rules('information', '', 'trim|required');

		

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
	}

    public function edit($id = null) {
        if($id == null) {
            $this->session->set_flashdata('message-error', "Veuillez selectionner un élément à éditer SVP!");
            redirect('regisseur', 'refresh');
        } else {
            if(!is_numeric($id)) {
                $this->session->set_flashdata('message-error', "Element invalide, veuillez selectionner un élément à éditer SVP!");
                redirect('regisseur', 'refresh');
            } else {
                $this->data['page_title'] = 'Mise à jour';
                $this->file_upload_field = "logo";
                $this->load->library('form_validation');
                $this->load->helper('html');
                $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

                $this->form_validation->set_rules('label', '', 'trim|required');
                $this->form_validation->set_rules('commentaires', '', 'trim|required');
                $this->form_validation->set_rules('telephone', '', 'trim|required|numeric|exact_length[10]');
                $this->form_validation->set_rules('email', '', 'trim|required|valid_email');
				$this->form_validation->set_rules('DateDebut', '', 'trim|required');
				$this->form_validation->set_rules('DateFin', '', 'trim|required');
				$this->form_validation->set_rules('information', '', 'trim');

                $regisseur = $this->regisseur_model->get_regisseur_by_id($id);

                $newData = array();

                if(isset($_FILES) && $_FILES) 
                    $this->form_validation->set_rules('logo', '', 'callback_file_check');

                if($this->form_validation->run() == true) {
                    $newData = $this->input->post();
                    if($_FILES) {
                        $this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
                        if ($this->upload->do_upload('logo')) {
                            $newData['logo'] = $this->path . $this->upload->file_name;
                        }
                    }
                    //print_r($newData);
                    //exit();
                    if($this->regisseur_model->update_regisseur($id, $newData)) {
                        $this->session->set_flashdata('message-succes', "Données mises à jour avec succès");
                        redirect('regisseur', 'refresh');
                    }
                    redirect('regisseur', 'refresh');
                } else {
                    if($regisseur->logo) {
                        $this->data['image_properties'] = array(
                            'src'   => $regisseur->logo,
                            'alt'   => $regisseur->label,
                            'class' => 'img-fluid media-object img-thumbnail',
                            'style' => 'float: left',
                            'width' => '150',
                            'title' => $regisseur->label,
                        );
                    } else {
                        $this->data['image_properties'] = "";
                    }

                    $this->data['label'] = array(
                        'name'          => 'label',
                        'id'            => 'label',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'Label',
                        'required'      => 'required',
                        'value'         => $regisseur->label,
                    );

                    $this->data['commentaires'] = array(
                        'name'          => 'commentaires',
                        'id'            => 'commentaires',
                        'class'         => 'form-control',
                        'placeholder'   => 'Commentaires',
                        'required'      => 'required',
                        'value'         => $regisseur->commentaires,
                    );

                    $this->data['telephone'] = array(
                        'name'          => 'telephone',
                        'id'            => 'telephone',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'Téléphone',
                        'required'      => 'required',
                        'value'         => $regisseur->telephone,
                    );

                    $this->data['email'] = array(
                        'name'          => 'email',
                        'id'            => 'email',
                        'type'          => 'email',
                        'class'         => 'form-control',
                        'placeholder'   => 'Email',
                        'required'      => 'required',
                        'value'         => $regisseur->email,
                    );
					$this->data['DateDebut'] = array(
                        'name'          => 'DateDebut',
                        'id'            => 'DateDebut',
                        'class'         => 'form-control',
                        'placeholder'   => 'DateDebut',
                        'required'      => 'required',
                        'value'         => $regisseur->DateDebut,
                    );
					$this->data['DateFin'] = array(
                        'name'          => 'DateFin',
                        'id'            => 'DateFin',
                        'class'         => 'form-control',
                        'placeholder'   => 'DateFin',
                        'required'      => 'required',
                        'value'         => $regisseur->DateFin,
                    );
					$this->data['information'] = array(
                        'name'          => 'information',
                        'id'            => 'information',
                        'class'         => 'form-control',
                        'placeholder'   => 'information',
                        //'required'      => 'required',
                        'value'         => $regisseur->information,
                    );

                    $this->data['logo'] = array(
                        'name'  => 'logo',
                        'id'    => 'logo',
                    );
                }
                $this->page = "templates/admin_regisseur_edit";
                $this->layout();
            }
        }
    }
	 public function edittarifs($id = null) {
		$this->data['all_regisseur'] = $this->regisseur_model->get_regisseur_by_id($id);; 
		 
        if($id == null) {
            $this->session->set_flashdata('message-error', "Veuillez selectionner un élément à éditer SVP!");
            redirect('regisseur', 'refresh');
        } else {
            if(!is_numeric($id)) {
                $this->session->set_flashdata('message-error', "Element invalide, veuillez selectionner un élément à éditer SVP!");
                redirect('regisseur', 'refresh');
            } else {
                $this->data['page_title'] = 'Mise à jour';
                $this->load->library('form_validation');
                $this->load->helper('html');
                $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

                $this->form_validation->set_rules('p12a3', '', 'trim');
				$this->form_validation->set_rules('p12a6', '', 'trim');
				$this->form_validation->set_rules('p4a3', '', 'trim');
				$this->form_validation->set_rules('p6a3', '', 'trim');
				$this->form_validation->set_rules('p6a6', '', 'trim');
				$this->form_validation->set_rules('p8a3', '', 'trim');
				$this->form_validation->set_rules('m12a3', '', 'trim');
				$this->form_validation->set_rules('m12a6', '', 'trim');
				$this->form_validation->set_rules('m4a3', '', 'trim');
				$this->form_validation->set_rules('m6a3', '', 'trim');
				$this->form_validation->set_rules('m6a6', '', 'trim');
				$this->form_validation->set_rules('m8a3', '', 'trim');
				$this->form_validation->set_rules('w3a3', '', 'trim');
				$this->form_validation->set_rules('flagsgm', '', 'trim');
				$this->form_validation->set_rules('a15a25', '', 'trim');
				$this->form_validation->set_rules('a15a2', '', 'trim');
				$this->form_validation->set_rules('kiosque', '', 'trim');
				$this->form_validation->set_rules('flagpm', '', 'trim');
				
                

                $regisseur = $this->regisseur_model->get_regisseur_by_id($id);

                $newData = array();

             
				
	 
			 
                if($this->form_validation->run() === true) {
					
					$newData = $this->input->post();
					
                    
					
                    if($this->regisseur_model->update_regisseur($id, $newData)) {
                        $this->session->set_flashdata('message-succes', "Données mises à jour avec succès");
                        redirect('regisseur', 'refresh');
                    }
                    redirect('regisseur', 'refresh');
                } else {
					
					$newData = $this->input->post();
					
					/*print_r($this->input->post());
                    exit();
					*/
                   
                    $this->data['p12a3'] = array(
                        'name'          => 'p12a3',
                        'id'            => 'p12a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
						 'required'      => 'p12a3',
                        'placeholder'   => 'p12a3',
                        'value'         => $regisseur->p12a3,
                    );
					
					$this->data['p12a6'] = array(
                        'name'          => 'p12a6',
                        'id'            => 'p12a6',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'p12a6',                   
                        'value'         => $regisseur->p12a6,
                    );
					$this->data['p4a3'] = array(
                        'name'          => 'p4a3',
                        'id'            => 'p4a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'p4a3',
                        'value'         => $regisseur->p4a3,
                    );
					$this->data['p6a3'] = array(
                        'name'          => 'p6a3',
                        'id'            => 'p6a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'p6a3',
                        'value'         => $regisseur->p6a3,
                    );
					$this->data['p6a6'] = array(
                        'name'          => 'p6a6',
                        'id'            => 'p6a6',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'p6a6',
                        'value'         => $regisseur->p6a6,
                    );
					$this->data['p8a3'] = array(
                        'name'          => 'p8a3',
                        'id'            => 'p8a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'p8a3',
                        'value'         => $regisseur->p8a3,
                    );
					$this->data['m12a3'] = array(
                        'name'          => 'm12a3',
                        'id'            => 'm12a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'm12a3',
                        'value'         => $regisseur->m12a3,
                    );
					$this->data['m12a6'] = array(
                        'name'          => 'm12a6',
                        'id'            => 'm12a6',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'm12a6',
                        'value'         => $regisseur->m12a6,
                    );
					$this->data['m4a3'] = array(
                        'name'          => 'm4a3',
                        'id'            => 'm4a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'm4a3',
                        'value'         => $regisseur->m4a3,
                    );
					$this->data['m6a3'] = array(
                        'name'          => 'm6a3',
                        'id'            => 'm6a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'm6a3',
                        'value'         => $regisseur->m6a3,
                    );
					$this->data['m6a6'] = array(
                        'name'          => 'm6a6',
                        'id'            => 'm6a6',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'm6a6',
                        'value'         => $regisseur->m6a6,
                    );
					$this->data['m8a3'] = array(
                        'name'          => 'm8a3',
                        'id'            => 'm8a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'm8a3',
                        'value'         => $regisseur->m8a3,
                    );
					$this->data['w3a3'] = array(
                        'name'          => 'w3a3',
                        'id'            => 'w3a3',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'w3a3',
                        'value'         => $regisseur->w3a3,
                    );
					$this->data['flagsgm'] = array(
                        'name'          => 'flagsgm',
                        'id'            => 'flagsgm',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'flagsgm',
                        'value'         => $regisseur->flagsgm,
                    );
					$this->data['a15a25'] = array(
                        'name'          => 'a15a25',
                        'id'            => 'a15a25',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'a15a25',
                        'value'         => $regisseur->a15a25,
                    );
					$this->data['a15a2'] = array(
                        'name'          => 'a15a2',
                        'id'            => 'a15a2',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'a15a2',
                        'value'         => $regisseur->a15a2,
                    );
					$this->data['kiosque'] = array(
                        'name'          => 'kiosque',
                        'id'            => 'kiosque',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'kiosque',
                        'value'         => $regisseur->kiosque,
                    );
					$this->data['flagpm'] = array(
                        'name'          => 'flagpm',
                        'id'            => 'flagpm',
                        'type'          => 'text',
                        'class'         => 'form-control',
                        'placeholder'   => 'flagpm',
                        'value'         => $regisseur->flagpm,
                    );
					
                    
                }
                $this->page = "templates/amdin_regisseur_edittarifs";
                $this->layout();
            }
        }
    }

    public function delete($id = null) {

        if($id == null) {
            $this->session->set_flashdata('message-error', "Veuillez selectionner un élément à supprimer SVP!");
            redirect('regisseur', 'refresh');
        } else {
            if($this->regisseur_model->delete_regisseur($id) == 1) {
                $this->session->set_flashdata('message-succes', "Données supprimée avec succès");
                redirect('regisseur', 'refresh');
            } else {
                echo "Opération non effectuée!";
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