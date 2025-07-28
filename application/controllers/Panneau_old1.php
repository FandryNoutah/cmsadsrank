<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Panneau extends MY_Controller
{
	protected $path;

	function __construct() {
		parent::__construct();
		
		$this->load->model("panneau_model");
        $this->load->library('upload');
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
		$this->form_validation->set_rules('panneau_date_pose', '', 'trim|required|callback_valid_date');
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
		$this->form_validation->set_rules('panneau_visuel_actuel', '', 'trim|required');
        //$this->form_validation->set_rules('panneau_autres_images', '', 'trim');
		/* Form validation */

        /* Set form */
        
        /*
		if ($this->form_validation->run() === FALSE) {
            $this->page = "templates/admin_panneau_add";
            $this->layout();
        } else {

        }
        */
                echo "<pre>";
                print_r($this->input->post());
                echo "</pre>";
        
        
                echo "<pre>";
                print_r($_FILES);
                echo "</pre>";
        
            $newData = array();
        //if ($this->input->post()) {
            
            $this->form_validation->set_rules('panneau_visuel_actuel_path', '', 'callback_file_check');
            if($this->form_validation->run() == true) {
                $newData = $this->input->post();
                $this->upload->initialize($this->set_upload_options($newData["panneau_reference"], $_FILES["panneau_visuel_actuel_path"]["name"]));
                if ($this->upload->do_upload('panneau_visuel_actuel_path')) {
                    $uploadData = $this->upload->data('panneau_visuel_actuel_path');
                    $uploadedFile = $uploadData["file_name"];
                    $newData['panneau_visuel_actuel_path'] = $this->path . $this->upload->file_name;
                }

                $autres_images = $_FILES;
                $autres_images_list = "";
                if($_FILES['panneau_autres_images']['name']) {
                    $cpt = count($_FILES['panneau_autres_images']['name']);
                    for($i = 0; $i < $cpt; $i++) {    
                        //echo "tsy error $cpt <br>";
                        $_FILES['panneau_autres_images']['name']        = $autres_images['panneau_autres_images']['name'][$i];
                        $_FILES['panneau_autres_images']['type']        = $autres_images['panneau_autres_images']['type'][$i];
                        $_FILES['panneau_autres_images']['tmp_name']    = $autres_images['panneau_autres_images']['tmp_name'][$i];
                        $_FILES['panneau_autres_images']['error']       = $autres_images['panneau_autres_images']['error'][$i];
                        $_FILES['panneau_autres_images']['size']        = $autres_images['panneau_autres_images']['size'][$i];    
                        $this->upload->initialize($this->set_upload_options($newData["panneau_reference"], $autres_images["panneau_autres_images"]["name"][$i]));
                        if($this->upload->do_upload('panneau_autres_images')) {
                            //$autres_images_list .= $this->path . $autres_images["panneau_autres_images"]["name"][$i];
                            $autres_images_list .= $this->path . $this->upload->file_name;
                            if($i < $cpt - 1) {
                                $autres_images_list .= ";";
                            }
                        } else {
                            print_r($this->upload->display_errors()); 
                        }
                    }
                }

                $newData['panneau_autres_images'] = $autres_images_list;
                
                //redirect('panneau', 'refresh');
                echo "<pre>";
                print_r($newData);
                echo "</pre>";
                die();
            } else {
                $this->data['panneau_reference'] = array(
                    'name'          => 'panneau_reference',
                    'id'            => 'panneau_reference',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Réference',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_reference'),
                );

                $this->data['panneau_emplacement'] = array(
                    'name'          => 'panneau_emplacement',
                    'id'            => 'panneau_emplacement',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Emplacement',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_emplacement'),
                );

                $this->data['panneau_date_pose'] = array(
                    'name'          => 'panneau_date_pose',
                    'id'            => 'panneau_date_pose',
                    'type'          => 'date',
                    'class'         => 'form-control',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_date_pose'),
                );
                
                $this->data['panneau_quartier'] = array(
                    'name'          => 'panneau_quartier',
                    'id'            => 'panneau_quartier',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Quartier',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_quartier'),
                );
                
                $this->data['panneau_region'] = array(
                    'name'          => 'panneau_region',
                    'id'            => 'panneau_region',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Région',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_region'),
                );
                
                $this->data['panneau_proximite'] = array(
                    'name'          => 'panneau_proximite',
                    'id'            => 'panneau_proximite',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Proximité',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_proximite'),
                );
                
                $this->data['panneau_latitude'] = array(
                    'name'          => 'panneau_latitude',
                    'id'            => 'panneau_latitude',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Latitude',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_latitude'),
                );
                
                $this->data['panneau_longitude'] = array(
                    'name'          => 'panneau_longitude',
                    'id'            => 'panneau_longitude',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Longitude',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_longitude'),
                );
                
                $this->data['panneau_cout_impression'] = array(
                    'name'          => 'panneau_cout_impression',
                    'id'            => 'panneau_cout_impression',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Impression',
                    'value'         => $this->form_validation->set_value('panneau_cout_impression'),
                );

                $this->data['panneau_cout_pose_finition'] = array(
                    'name'          => 'panneau_cout_pose_finition',
                    'id'            => 'panneau_cout_pose_finition',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Pose et finition',
                    'value'         => $this->form_validation->set_value('panneau_cout_pose_finition'),
                );

                $this->data['panneau_cout_location'] = array(
                    'name'          => 'panneau_cout_location',
                    'id'            => 'panneau_cout_location',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Location',
                    'value'         => $this->form_validation->set_value('panneau_cout_location'),
                );

                $this->data['panneau_visuel_actuel'] = array(
                    'name'          => 'panneau_visuel_actuel',
                    'id'            => 'panneau_visuel_actuel',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Visuel actuel',
                    'value'         => $this->form_validation->set_value('panneau_visuel_actuel'),
                );

                $this->data['panneau_visuel_actuel_path'] = array(
                    'name'  => 'panneau_visuel_actuel_path',
                    'id'    => 'panneau_visuel_actuel_path',
                );

                $this->data['panneau_autres_images'] = array(
                    'name'  => 'panneau_autres_images[]',
                    'id'    => 'panneau_autres_images',
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
            }
        //}

        $this->page = "templates/admin_panneau_add";
        $this->layout();
	}

    private function set_upload_options($prefix, $filename) {
        $pathinfo = pathinfo($filename);
        $filename = $pathinfo['filename'];
        $config = array();
        $config['upload_path']      = $this->path;
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = '0';
        $config['file_name']        = url_title(iconv("UTF-8", "ASCII//TRANSLIT", $prefix . '_' . $filename), '_', TRUE);
        $config['overwrite']        = FALSE;
        return $config;
    }

    public function file_check($string) {
        $allowedMimeTypeArray = array(
            //"application/pdf", 
            "image/gif", 
            "image/jpeg", 
            "image/png", 
            "image/x-png"
        );
        $mime = get_mime_by_extension($_FILES["panneau_visuel_actuel_path"]["name"]);
        if(isset($_FILES["panneau_visuel_actuel_path"]["name"]) && $_FILES["panneau_visuel_actuel_path"]["name"] != "") {
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

    //$this->form_validation->set_rules('dob', 'Date of Birth', 'callback_valid_date');

    public function valid_date($date, $format = 'd-m-Y') {
        $d = DateTime::createFromFormat($format, $date);
        
        echo "<pre>";
        print_r($d);
        echo "</pre>";

        $today = date('Y-m-d');
        //Check for valid date in given format
        if($d && $d->format($format) == $date) {
            if ($date > $today) {
                return true;
            } else {
                $this->form_validation->set_message('valid_date', 'La date doit être supérieure à la date en cours');
                return false;
            }
        } else {
            $this->form_validation->set_message('valid_date', 'The date is not valid it should match this ('. $date .') format');
            return false;
        }
    }
}


/*

$date="2012-09-12";

if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
    return true;
} else {
    return false;
}


----------------------------------------------------

$dt = DateTime::createFromFormat("Y-m-d", $date);
return $dt !== false && !array_sum($dt->getLastErrors());

----------------------------------------------------

list($y, $m, $d) = array_pad(explode('-', $date, 3), 3, 0);
return ctype_digit("$y$m$d") && checkdate($m, $d, $y);

----------------------------------------------------

<?php
function validateDateTime($format)
{
    return function($dateStr) use ($format) {
        $date = DateTime::createFromFormat($format, $dateStr);
        return $date && $date->format($format) === $dateStr;
    };
}

----------------------------------------------------

function isValidDate($date)
    {
            if (preg_match("/^(((((1[26]|2[048])00)|[12]\d([2468][048]|[13579][26]|0[48]))-((((0[13578]|1[02])-(0[1-9]|[12]\d|3[01]))|((0[469]|11)-(0[1-9]|[12]\d|30)))|(02-(0[1-9]|[12]\d))))|((([12]\d([02468][1235679]|[13579][01345789]))|((1[1345789]|2[1235679])00))-((((0[13578]|1[02])-(0[1-9]|[12]\d|3[01]))|((0[469]|11)-(0[1-9]|[12]\d|30)))|(02-(0[1-9]|1\d|2[0-8])))))$/", $date)) {
                    return $date;
            }
            return null;
    }

----------------------------------------------------

function isValidDate($date) {
    return date('Y-m-d', strtotime($date)) === $date;
}

----------------------------------------------------



*/