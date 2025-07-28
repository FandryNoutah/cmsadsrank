<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Flags extends MY_Controller
{
    protected $path;
	protected $file_upload_field;
	protected $_arrondissement;
	protected $_etat_armature;
	protected $_etat_poteau;
	protected $_etat_bache;

	function __construct() {
		parent::__construct();
		
		$this->load->model("flags_model");
		$this->data["flags"] = $this->flags_model->get_all();
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        foreach ($this->flags_model->get_etat_armature() as $etat_armatures) {
            //$etat_armature[$etat_armatures->id] = $etat_armatures->label;
            $etat_armature[$etat_armatures->label] = $etat_armatures->label;
        }

        foreach ($this->flags_model->get_etat_bache() as $etat_baches) {
            //$etat_bache[$etat_baches->id] = $etat_baches->label;
            $etat_bache[$etat_baches->label] = $etat_baches->label;
        }

        foreach ($this->flags_model->get_etat_poteau() as $etat_poteaux) {
            //$etat_poteau[$etat_poteaux->id] = $etat_poteaux->label;
            $etat_poteau[$etat_poteaux->label] = $etat_poteaux->label;
        }

        foreach ($this->flags_model->get_operations() as $operations) {
            //$operation[$operations->id] = $operations->label;
            $operation[$operations->label] = $operations->label;
        }

        foreach ($this->flags_model->get_axes() as $axes) {
            //$axe[$axes->id] = $axes->label;
            $axe[$axes->label] = $axes->label;
        }

        foreach ($this->flags_model->get_provinces() as $provinces) {
            //$province[$provinces->label] = $provinces->label;
            $province[$provinces->label] = $provinces->label;
        }

        foreach ($this->flags_model->get_arrondissements() as $arrondissements) {
            //$arrondissement[$arrondissements->id] = $arrondissements->label;
            $arrondissement[$arrondissements->label] = $arrondissements->label;
        }
        
        foreach ($this->flags_model->get_types() as $types) {
            //$type[$types->id] = $types->label;
            $type[$types->label] = $types->label;
        }

        foreach ($this->flags_model->get_regions() as $regions) {
            //$region[$regions->id] = $regions->label;
            $region[$regions->label] = $regions->label;
        }

        $this->data["yesno"]            = array("Non", "Oui");
        $this->data["etats_armature"]    = $etat_armature;
        $this->data["etats_bache"]       = $etat_bache;
        $this->data["etats_poteau"]      = $etat_poteau;
        $this->data["operation"]        = $operation;
        $this->data["provinces"]        = $province;
        $this->data["axes"]             = $axe;
        $this->data["types"]            = $type;
        $this->data["regions"]          = $region;
        $this->data["arrondissements"]  = $arrondissement;
		
		$this->data["filterData"] = array(
                                    "yesno"        		=> array("Non", "Oui"),
                                    "arrondissements" 	=> $this->get_arrondissements(),
                                    "etat_armature"    	=> $this->get_etat_armature(),
                                    "etat_poteau"      	=> $this->get_etat_poteau(),
                                    "etat_bache"	    => $this->get_etat_bache(),
                                );
								
        $this->path = "assets/uploads/flags/";

        //print_r($province);

    }

    public function index() {
        $this->data['page_title'] = "Flags";
    	$this->page = "templates/admin_flags";
		$this->layout();
    }
	
	public function liste() {
        $this->data['page_title'] = "Flags";
    	$this->page = "templates/admin_flags_liste";
		
		$this->data["filters"] = array(
                                    "_yesno"        	=> array("Non", "Oui"),
                                    "_arrondissements" 	=> $this->get_arrondissements(),
                                    "_etat_armature"    => $this->get_etat_armature(),
                                    "_etat_poteau"      => $this->get_etat_poteau(),
                                    "_etat_bache"	    => $this->get_etat_bache(),
                                );

		$this->layout();
    }
	
	public function get_arrondissements() {
		foreach ($this->flags_model->get_arrondissements() as $key => $value) {
            $return[$value->id] = $value->label;
        }
        return $return;
	}
	
	public function get_etat_bache() {
		foreach ($this->flags_model->get_etat_bache() as $key => $value) {
            $return[$value->id] = $value->label;
        }
        return $return;
	}
	
	public function get_etat_poteau() {
		foreach ($this->flags_model->get_etat_poteau() as $key => $value) {
            $return[$value->id] = $value->label;
        }
        return $return;
	}
	
	public function get_etat_armature() {
		foreach ($this->flags_model->get_etat_armature() as $key => $value) {
            $return[$value->id] = $value->label;
        }
        return $return;
	}
	
    public function add() {
        $this->data['page_title'] = "Ajout Flag";
        $this->file_upload_field = "visuel_actuel_path";

        $this->form_validation->set_rules('reference', '', 'trim|required');
        $this->form_validation->set_rules('ville', '', 'trim|required');
        $this->form_validation->set_rules('type', '', 'trim|required');
        $this->form_validation->set_rules('date_previsionnelle', '', 'trim');
        $this->form_validation->set_rules('date_effective', '', 'trim');
        $this->form_validation->set_rules('latitude', '', 'trim|required|decimal');
        $this->form_validation->set_rules('longitude', '', 'trim|required|decimal');        
        $this->form_validation->set_rules('province', '', 'trim|required');
        $this->form_validation->set_rules('region', '', 'trim|required');
        $this->form_validation->set_rules('arrondissement', '', 'trim|required');
        $this->form_validation->set_rules('quartier', '', 'trim|required');
        $this->form_validation->set_rules('propal', '', 'trim|required');
        $this->form_validation->set_rules('emplacement', '', 'trim|required');
        $this->form_validation->set_rules('observations', '', 'trim');
        $this->form_validation->set_rules('etat_poteau', '', 'trim|required');
        $this->form_validation->set_rules('etat_bache', '', 'trim|required');
        $this->form_validation->set_rules('etat_armature', '', 'trim|required');
        $this->form_validation->set_rules('visuel_actuel', '', 'trim');

        $newData = array();

        if(isset($_FILES) && $_FILES && $_FILES[$this->file_upload_field]["name"] != "") { 
            print_r($_FILES);
            $this->form_validation->set_rules('visuel_actuel_path', '', 'callback_file_check');
        }

        if ($this->form_validation->run() == true) {
            $newData = $this->input->post();
            if(isset($_FILES) && $_FILES && $_FILES[$this->file_upload_field]["name"] != "") {
                $this->upload->initialize($this->set_upload_options($newData["reference"], $_FILES[$this->file_upload_field]["name"]));
                if ($this->upload->do_upload($this->file_upload_field)) {
                    $newData[$this->file_upload_field] = $this->path . $this->upload->file_name;
                }
            }
            echo "<pre>";
            print_r($newData);
            echo "</pre>";
            //die("eto");
            if($this->flags_model->save_flag($newData)) {
                $this->session->set_flashdata('message-succes', "Données inserées avec succès");
                redirect('flags', 'refresh');
            }
            redirect('flags', 'refresh');
        } else {
            $this->data['reference'] = array(
                'name'          => 'reference',
                'id'            => 'reference',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Réference',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('reference'),
            );

            $this->data['date_previsionnelle'] = array(
                'name'          => 'date_previsionnelle',
                'id'            => 'date_previsionnelle',
                'type'          => 'date',
                'class'         => 'form-control',
                //'required'      => 'required',
                'value'         => $this->form_validation->set_value('date_previsionnelle'),
            );

            $this->data['date_effective'] = array(
                'name'          => 'date_effective',
                'id'            => 'date_effective',
                'type'          => 'date',
                'class'         => 'form-control',
                //'required'      => 'required',
                'value'         => $this->form_validation->set_value('date_effective'),
            );

            $this->data['latitude'] = array(
                'name'          => 'latitude',
                'id'            => 'latitude',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Latitude',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('latitude'),
            );
            
            $this->data['longitude'] = array(
                'name'          => 'longitude',
                'id'            => 'longitude',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Longitude',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('longitude'),
            );

            $this->data['ville'] = array(
                'name'          => 'ville',
                'id'            => 'ville',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Ville',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('ville'),
            );

            $this->data['emplacement'] = array(
                'name'          => 'emplacement',
                'id'            => 'emplacement',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Emplacement',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('emplacement'),
            );

            $this->data['quartier'] = array(
                'name'          => 'quartier',
                'id'            => 'quartier',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Quartier',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('quartier'),
            );

            $this->data['propal'] = array(
                'name'          => 'propal',
                'id'            => 'propal',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Propal',
                'value'         => $this->form_validation->set_value('propal'),
            );

            $this->data['visuel_actuel'] = array(
                'name'          => 'visuel_actuel',
                'id'            => 'visuel_actuel',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Visuel actuel',
                'value'         => $this->form_validation->set_value('visuel_actuel'),
            );

            $this->data['observations'] = array(
                'name'          => 'observations',
                'id'            => 'observations',
                'class'         => 'form-control',
                'placeholder'   => 'Observations',
                'value'         => $this->form_validation->set_value('observations'),
            );

            $this->data['type'] = array(
                'name'          => 'type',
            );

            $this->data['axe'] = array(
                'name'         => 'axe',
            );

            $this->data['province'] = array(
                'name'          => 'province',
            );

            $this->data['arrondissement'] = array(
                'name'          => 'arrondissement',
            );

            $this->data['region'] = array(
                'name'          => 'region',
            );

            $this->data['axe_prio'] = array(
                'name'          => 'axe_prio',
            );

            $this->data['etat_armature'] = array(
                'name'          => 'etat_armature',
            );

            $this->data['etat_bache'] = array(
                'name'          => 'etat_bache',
            );

            $this->data['etat_poteau'] = array(
                'name'          => 'etat_poteau',
            );

            $this->data['operations'] = array(
                'name'          => 'operations',
            );

            $this->data[$this->file_upload_field] = array(
                'name'  => $this->file_upload_field,
                'id'    => $this->file_upload_field,
            );
        }

    	$this->page = "templates/admin_flags_add";
		$this->layout();
    }

    public function delete($id = null) {
        if($id == null) {
            $this->session->set_flashdata('message-error', "Veuillez selectionner un élément à supprimer SVP!");
            redirect('flags', 'refresh');
        } else {
            if($this->flags_model->delete_flag($id) == 1) {
                $this->session->set_flashdata('message-succes', "Données supprimée avec succès");
                redirect('flags', 'refresh');
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