<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Panneau extends MY_Controller
{
    protected $path;
    protected $sam_id;
	protected $file_upload_field;

	function __construct() {
		parent::__construct();
		
		$this->load->model("panneau_model");
        $this->load->model("campagne_model");
        $this->load->model("campagnevisuel_model");
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$sam_id = $this->ion_auth->user()->row();
		$this->sam_id = @$sam_id->sam_id;
		
		
		
		$this->data["panneaux"] = $this->panneau_model->get_all($this->sam_id);

		foreach ($this->panneau_model->get_formats() as $formats) {
			$format[$formats->id] = $formats->label;
		}

		foreach ($this->panneau_model->get_regisseurs() as $regisseurs) {
			$regisseur[$regisseurs->id] = $regisseurs->label;
		}

		foreach ($this->panneau_model->get_provinces() as $provinces) {
			$province[$provinces->id] = $provinces->label;
		}

		foreach ($this->panneau_model->get_types() as $types) {
			$type[$types->id] = $types->label;
		}

		foreach ($this->panneau_model->get_axes() as $axes) {
			$axe[$axes->id] = $axes->label;
		}
		
		foreach ($this->panneau_model->get_all_sam() as $allsam) {
			$sam[$allsam->id] = $allsam->label;
		}
        
        foreach ($this->panneau_model->get_regions() as $regions) {
            $region[$regions->id] = $regions->label;
        }

        foreach ($this->panneau_model->get_panneau_maj_types() as $majTypes) {
            $majType[$majTypes->id] = $majTypes->type;
        }

        foreach ($this->panneau_model->get_provinces_arrd() as $province_arrds) {
            if($province_arrds->panneau_region)
                $province_arrd[$province_arrds->panneau_region] = $province_arrds->panneau_region;
        }
        /*
        foreach ($this->panneau_model->get_all_visuels() as $all_visuels) {
            $all_visuel[$all_visuels->panneau_visuel_actuel] = $all_visuels->panneau_visuel_actuel;
        }
        */
        foreach ($this->campagne_model->get_all_visuels() as $all_visuels) {
            $all_visuel[$all_visuels["id"]] = $all_visuels["panneau_visuel_name"];
        }



		$this->data["yesno"]        	= array("Non", "Oui");
		$this->data["formats"] 			= $format;
		$this->data["regisseurs"] 		= $regisseur;
		$this->data["provinces"] 		= $province;
		$this->data["types"] 			= $type;
		$this->data["axes"] 			= $axe;
        $this->data["sam"]          	= $sam;
        $this->data["regions"]      	= $region;
        $this->data["majType"]      	= $majType;
        $this->data["province_arrd"]	= $province_arrd;
		$this->data["all_visuel"]   	= $all_visuel;

        $this->data["filterData"] = array(
            "panneau_couverture_4g" 	=> array("Non", "Oui"),
            "panneau_couverture_fo" 	=> array("Non", "Oui"),
            "panneau_couverture_adsl" 	=> array("Non", "Oui"),
            "panneau_format" 			=> $format, 
            "panneau_regisseur" 		=> $regisseur, 
            "panneau_province" 			=> $province, 
            "panneau_type" 				=> $type, 
            "panneau_axe" 				=> $axe, 
            "panneau_sam" 				=> $sam,
            "panneau_region" 			=> $region,
            "panneau_region" 			=> $province_arrd,
            "all_visuel" 				=> $all_visuel,
        );

		$this->path = "assets/uploads/panneaux/";
		$this->data["table_fields"] = $this->panneau_model->_get_table_fields();

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
            $this->data['maj_panneaux'] = $this->panneau_model->maj_panneau_get_all_by_id($id);
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
        $this->file_upload_field = "panneau_visuel_actuel_path";

		$this->form_validation->set_rules('panneau_reference', '', 'trim|required');
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
		$this->form_validation->set_rules('panneau_date_pose', '', 'required|callback_valid_date');
        
        $newData = array();
        
            //$this->form_validation->set_rules('panneau_visuel_actuel_path', '', 'callback_file_check');
            if($this->form_validation->run() == true) {

                $newData = $this->input->post();
                /*$this->upload->initialize($this->set_upload_options($newData["panneau_reference"], $_FILES["panneau_visuel_actuel_path"]["name"]));
                if ($this->upload->do_upload('panneau_visuel_actuel_path')) {
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData["file_name"];
                    $newData['panneau_visuel_actuel_path'] = $this->path . $this->upload->file_name;
                }
				*/
                $autres_images = $_FILES;
                $autres_images_list = "";
				/*
                if($_FILES['panneau_autres_images']['name']) {
                    $cpt = count($_FILES['panneau_autres_images']['name']);
                    for($i = 0; $i < $cpt; $i++) {    
                        echo "tsy error $cpt <br>";
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
                            //print_r($_FILES);
                            //print_r($this->upload->display_errors()); 
                        }
                    }
                }
                $newData['panneau_autres_images'] = $autres_images_list;
				
				datadump($newData);
				die("end");*/
                if($panneauId = $this->panneau_model->save_panneau($newData)) {
					foreach($this->getCampagnes() as $keyCampagne => $valueCampagne) {
						$dataCampagne = array(
							"panneau_id" 	=> $panneauId,
							"campagne_id" 	=> $keyCampagne,
							"visuel_id" 	=> $newData["panneau_visuel_actuel"],
							"sam_id" 		=> $newData["panneau_sam"],
						);
						$this->campagne_model->save_campagne_visuel_sam($dataCampagne);
					}
                    $this->session->set_flashdata('message-succes', "Données inserées avec succès");
                    redirect('panneau/liste', 'refresh');
                }
                redirect('panneau/liste', 'refresh');
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

    public function maj($id = null) {
        $this->file_upload_field = "panneau_maj_visuel_path";
        if($id === null) {
            $this->session->set_flashdata('message-error', "Panneau introuvable, veuillez selectionner un panneau à mettre à jour SVP!");
            redirect('panneau', 'refresh');
        } else {
            $this->data['id_panneau'] = $id;
            $model_panneau = $this->panneau_model->get_panneau_by_id($id);
            $ref_panneau = $model_panneau->panneau_reference;
            $this->form_validation->set_rules('panneau_maj_date_pose', '', 'required|callback_valid_date');
            $this->form_validation->set_rules('panneau_maj_visuel', '', 'trim|required');
            $this->form_validation->set_rules('panneau_maj_mesure_patch', '', 'trim');
            $this->form_validation->set_rules('panneau_maj_cout_deplacement', '', 'trim|required|integer');
            $this->form_validation->set_rules('panneau_maj_cout_pose', '', 'trim|required|integer');
            $this->form_validation->set_rules('panneau_maj_cout_impression', '', 'trim|required|integer');
            $this->form_validation->set_rules('panneau_maj_visuel_path', '', 'callback_file_check');
    
                $this->data['panneau_maj_type'] = array(
                    'name'  => 'panneau_maj_type',
                );

                $this->data['panneau_maj_visuel_path'] = array(
                    'name'  => 'panneau_maj_visuel_path',
                    'id'    => 'panneau_maj_visuel_path',
                );
    
                $this->data['panneau_maj_date_pose'] = array(
                    'name'          => 'panneau_maj_date_pose',
                    'id'            => 'panneau_maj_date_pose',
                    'type'          => 'date',
                    'class'         => 'form-control',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_maj_date_pose'),
                );
    
                $this->data['panneau_maj_mesure_patch'] = array(
                    'name'          => 'panneau_maj_mesure_patch',
                    'id'            => 'panneau_maj_mesure_patch',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'value'         => $this->form_validation->set_value('panneau_maj_mesure_patch'),
                );
    
                $this->data['panneau_maj_visuel'] = array(
                    'name'          => 'panneau_maj_visuel',
                    'id'            => 'panneau_maj_visuel',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'required'      => 'required',
                    'placeholder'   => 'Visuel (ou patch)',
                    'value'         => $this->form_validation->set_value('panneau_maj_visuel'),
                );
    
                $this->data['panneau_maj_cout_impression'] = array(
                    'name'          => 'panneau_maj_cout_impression',
                    'id'            => 'panneau_maj_cout_impression',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Impression',
                    'value'         => $this->form_validation->set_value('panneau_maj_cout_impression'),
                );
    
                $this->data['panneau_maj_cout_pose'] = array(
                    'name'          => 'panneau_maj_cout_pose',
                    'id'            => 'panneau_maj_cout_pose',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Pose',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_maj_cout_pose'),
                );
    
                $this->data['panneau_maj_cout_deplacement'] = array(
                    'name'          => 'panneau_maj_cout_deplacement',
                    'id'            => 'panneau_maj_cout_deplacement',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Déplacement',
                    'required'      => 'required',
                    'value'         => $this->form_validation->set_value('panneau_maj_cout_deplacement'),
                );
                
                $this->data['panneau_maj_commentaires'] = array(
                    'name'          => 'panneau_maj_commentaires',
                    'id'            => 'panneau_maj_commentaires',
                    'type'          => 'text',
                    'class'         => 'form-control',
                    'placeholder'   => 'Commentaires',
                    'value'         => $this->form_validation->set_value('panneau_maj_commentaires'),
                );
    
                $this->data['panneau_maj_visuel_path'] = array(
                    'name'  => 'panneau_maj_visuel_path',
                    'id'    => 'panneau_maj_visuel_path',
                );
    
            if($this->form_validation->run() == true) {

                $newData = $this->input->post();
                $this->upload->initialize($this->set_upload_options($ref_panneau, $_FILES[$this->file_upload_field]["name"]));
                if ($this->upload->do_upload($this->file_upload_field)) {
                    $newData[$this->file_upload_field] = $this->path . $this->upload->file_name;
                }

                if($this->panneau_model->maj_panneau($newData)) {
                    $this->session->set_flashdata('message-succes', "Données inserées avec succès");
                    redirect("panneau/view/$id", 'refresh');
                }
                redirect("panneau/view/$id", 'refresh');
            } else {
                
            }
        }
        $this->page = "templates/admin_panneau_maj";
        $this->layout();
    }

    public function setColumnTitle($fields) {
        if(strpos($fields, "_")){
            $title = explode("_", $fields);
            $title1 = array_shift($title);
            $title = implode(" ", $title);
        } else {
            return ucfirst($fields);
        }
        return ucfirst($title);
    }

    public function export($toexcel = null) {
		

	   $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $tablefields = $this->db->list_fields('hm_panneau');

        foreach($tablefields as $k => $field) {
            $title[$field] = $this->setColumnTitle($field);
        }
        //datadump($title);
        //die();
        
        $toexcel = $this->session->flashdata("result");
        $dataFilter = $this->session->flashdata("dataFilter");

        //datadump($dataFilter);
        //datadump($toexcel);
        //die();
        $worksheet = $this->excel->getActiveSheet();
        $worksheet->setTitle('Panneaux');
        $row = 1;
        $priceformat = array("panneau_cout_impression", "panneau_cout_pose_finition", "panneau_cout_location");
        foreach ($toexcel as $keyRow => $valueRow) {
            $cell = 0;
            foreach ($valueRow as $keyCell => $valueCell) {
                if($row == 1) {
                    $worksheet->setCellValueByColumnAndRow($cell, $row, $title[$keyCell]);
                }
                if (in_array($keyCell, $priceformat)) {
                    $worksheet->getCellByColumnAndRow($cell, $row)
                              //->setAutoSize(true)
                              ->getStyle()
                              ->getNumberFormat()
                              ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
                switch ($keyCell) {
                    case 'panneau_format':
                        $valueCell = $dataFilter["formats"][$valueCell];
                        break;
                    case 'panneau_type':
                        $valueCell = $dataFilter["types"][$valueCell];
                        break;
                    case 'panneau_province':
                        $valueCell = $dataFilter["provinces"][$valueCell];
                        break;
                    case 'panneau_axe':
                        $valueCell = $dataFilter["axes"][$valueCell];
                        break;
                    case 'panneau_regisseur':
                        $valueCell = $dataFilter["regisseurs"][$valueCell];
                        break;
                    default:
                        # code...
                        break;
                }
                $worksheet->setCellValueByColumnAndRow($cell, $row, $valueCell);
                $cell++;
            }
            $row++;
        }
        $filename ='panneaux.xls';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function liste() {
        $this->data["campagnes"]        = $this->getCampagnes();
        $this->data["byfilter"]         = $this->resultByFilter();
        $this->data["visuels"]          = $this->getVisuels();
        $this->data["panneaux"]         = $this->getPanneaux();
        $this->data["campagneVisuels"]  = $this->campagneVisuels();

        //datadump($this->campagne_model->get_all_visuels());
        /*
        $this->data["_yesno"]           = array("Non", "Oui");
        $this->data["_formats"]         = $this->getPanneauFormats();
        $this->data["_provinces"]       = $this->getPanneauProvinces();
        $this->data["_types"]           = $this->getPanneauTypes();
        $this->data["_axes"]            = $this->getPanneauAxes();
        $this->data["_regisseurs"]      = $this->getPanneauRegisseurs();
        $this->data["campagneVisuelsModel"]  = $this->campagne_model->get_campagne_visuels();
        */
		
		
		
		
		
		/*
        $this->data["filters"] = array(
                                    "_yesno"        => array("Non", "Oui"),
                                    "_formats"      => $this->getPanneauFormats(),
                                    "_provinces"    => $this->getPanneauProvinces(),
                                    "_types"        => $this->getPanneauTypes(),
                                    "_axes"         => $this->getPanneauAxes(),
                                    "_sam"          => $this->getSAM(),
                                    "_regisseurs"   => $this->getPanneauRegisseurs(),
                                    "_visuels"      => $this->getVisuels(),
                                    "_campagnes"    => $this->getCampagnes(),
                                );
								*/
							
		$this->data["filters"] = array(
            "panneau_couverture_4g" 	=> array("Non", "Oui"),
            "panneau_couverture_fo" 	=> array("Non", "Oui"),
            "panneau_couverture_adsl" 	=> array("Non", "Oui"),
            "panneau_format" 			=> $this->getPanneauFormats(), 
            "panneau_province" 			=> $this->getPanneauProvinces(), 
            "panneau_type" 				=> $this->getPanneauTypes(), 
            "panneau_axe" 				=> $this->getPanneauAxes(), 
            "panneau_sam" 				=> $this->getSAM(),
            "panneau_regisseur" 		=> $this->getPanneauRegisseurs(), 
            //"_visuels" 					=> $this->getVisuels(),
            "visuel_id" 				=> $this->getVisuels(),
			"_campagnes"    			=> $this->getCampagnes(),
		);
			
		
        $this->page = "templates/campagne";
        $this->layout();
    }

	
	/*Faniry 20180130 - Test Bulk*/
	public function addcampagne(){
		
		$campagneData = $this->input->post();
		//echo "<pre>";
		//print_r($campagneData);
		//echo "</pre>";

		$allIds = isset($campagneData["panneaux_ids"]) ? explode(",", $campagneData["panneaux_ids"]) : array();
		$visuel_id = isset($campagneData['visuel_id']) ? $campagneData['visuel_id'] : "";
		$campagne_id = isset($campagneData['campagne_id']) ? $campagneData['campagne_id'] : "";
		
		if($allIds && count($allIds) > 0){
			foreach($allIds as $id){
				//@todo insert into campagne visuel
				
				$CV_data = array(
					"panneau_id" => $id,
					"campagne_id" => $campagne_id,
					"visuel_id" => $visuel_id,
				);
				
				if($this->campagnevisuel_model->cv_exists($id, $campagne_id)){
					
					continue;
					
				}else{
					
					$this->campagnevisuel_model->save_campagne_visuel($CV_data);
					$this->session->set_flashdata('message-succes', "Mise à jour effectuées");
					
				}
				
				
				
				

			}
		}

		$this->data["campagnes"] = $this->getCampagnes();
		$this->data["visuels"]   = $this->getVisuels();
		
		//echo "<pre>";
		//print_r($this->data["campagnes"]);
		//print_r($this->data["visuels"]);
		//echo "</pre>";
		
		//exit();
		
		
		
		/*$this->data["filters"] = array(
								"_yesno"        => array("Non", "Oui"),
								"_formats"      => $this->getPanneauFormats(),
								"_provinces"    => $this->getPanneauProvinces(),
								"_types"        => $this->getPanneauTypes(),
								"_axes"         => $this->getPanneauAxes(),
								"_sam"          => $this->getSAM(),
								"_regisseurs"   => $this->getPanneauRegisseurs(),
								"_visuels"      => $this->getVisuels(),
								"_campagnes"    => $this->getCampagnes(),
								);
		
		$this->page = "templates/campagne";
		$this->layout();*/
		
		redirect('panneau/liste', 'refresh');
		
	}
	
	public function majCampagne() {
		$post = $this->input->post();
		print_r($post);
	}
	
	/*end*/
	
    private function campagneVisuels() {
		
		//datadump(count($this->campagne_model->get_campagne_visuels()));
		
        foreach ($this->campagne_model->get_campagne_visuels() as $keyCV => $valueCV) {

		
			
			if($this->sam_id != "" && $this->sam_id == $valueCV["sam_id"]) {
				$result[$valueCV["panneau_id"]][$valueCV["id"]] = $valueCV;
			} else {
				$result[$valueCV["panneau_id"]][$valueCV["id"]] = $valueCV;
			}
        }
		
		//datadump(count($result));
		//die();
		
        return $result;
    }

    private function getVisuels() {
        foreach ($this->campagne_model->get_all_visuels() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getCampagnes() {
        foreach ($this->campagne_model->get_all() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getPanneauFormats() {
        foreach ($this->panneau_model->getFormats() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getPanneauTypes() {
        foreach ($this->panneau_model->getTypes() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getPanneauProvinces() {
        foreach ($this->panneau_model->getProvinces() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getPanneauAxes() {
        foreach ($this->panneau_model->getAxes() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getSAM() {
        foreach ($this->panneau_model->getSAM() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    private function getPanneauRegisseurs() {
        foreach ($this->panneau_model->getRegisseurs() as $key => $value) {
            $return[$value["id"]] = $value;
        }
        return $return;
    }

    public function getPanneaux() {
        $return = array();
		
		//datadump($this->campagneVisuels());
		
		//datadump("qzeqzeqaze " . count($this->campagneVisuels()));
        foreach ($this->campagneVisuels() as $key => $value) {
            //$panneau = $this->panneau_model->get_panneauarray_by_id($key);
			
			foreach($value as $k => $v) {
				$idPanneau = $v["panneau_id"];
			}
			//datadump("Idpanneau : " . $idPanneau);
            //$panneau = $this->panneau_model->get_panneauarray_by_id($value[$key]["panneau_id"]);
            $panneau = $this->panneau_model->get_panneauarray_by_id($idPanneau);
			//datadump($panneau["panneau_sam"]);
            
			// Si un utilisateur SAM est connecté il ne peut voir que les éléments concernant le SAM
			//if($this->sam_id != "" && $this->sam_id == $panneau["panneau_sam"]) {
				$return[$key]["panneau"] = $this->panneau_model->get_panneauarray_by_id($idPanneau);

				foreach ($value as $keyPanneau => $valuePanneau) {
					$return[$valuePanneau["panneau_id"]][$valuePanneau["id"]] = $valuePanneau;
				}
            //}
			
			
        }
		//die("end");	
		//datadump($this->sam_id);
		/*
		datadump(count($return));
		datadump(($return));
		die();*/
		//die();
		//datadump($return);
        return $return;
    }

    public function panneaux() {
        $ret = array();
        $notShow = array("panneau_visuel_actuel","panneau_date_pose", "status", "panneau_visuel_actuel_path",   "panneau_autres_images");
        $yesno = array("Non", "Oui");

        foreach ($this->getPanneaux() as $key => $value) {
            foreach ($value as $keyRet => $valueRet) {
                if($key == "panneau") {
                    foreach($value as $k => $v) {
                        if(!in_array($k, $notShow)) {
                            switch ($k) {
                                case 'panneau_format':
                                    $format = $this->getPanneauFormats();
                                    $v = $format[$v];
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        }
                        
                    }
                } /*else {
                    if($value["visuel_id"] != 0) echo $visuels[$value["visuel_id"]]["panneau_visuel_name"];
                }*/
            }
        }
        return $ret;
    }


    public function resultByFilter() {
        $res    = array();
        $result = array();


        $model = $this->campagne_model->getPanneauByFilter();

        foreach($model as $keyFilter => $valueFilter) {
            $result[$valueFilter["id"]][$valueFilter["id"]][] = $valueFilter;
        }

        foreach($result as $panneauKey => $panneauValue) {
            foreach($panneauValue[$panneauKey] as $key => $value) {
				//if($this->sam_id != "" && $this->sam_id == $value["panneau_sam"]) {
					$res[$panneauKey] = $value;
					$campagne[$panneauKey][] = array("campagne_id" => $value["campagne_id"], "visuel_id" => $value["visuel_id"]);
					//datadump($value);
				//}
            }
            $res[$panneauKey]["campagne"] = $campagne[$panneauKey];
        }
		
		
		//die();
        return $res;
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

    /*
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
    */

    public function file_check($string) {
        $allowedMimeTypeArray = array(
            //"application/pdf", 
            "image/gif", 
            "image/jpeg", 
            "image/png", 
            "image/x-png"
        );
        $mime = get_mime_by_extension($_FILES[$this->file_upload_field]["name"]);
        //$mime = get_mime_by_extension($_FILES["panneau_visuel_actuel_path"]["name"]);
        //if(isset($_FILES["panneau_visuel_actuel_path"]["name"]) && $_FILES["panneau_visuel_actuel_path"]["name"] != "") {
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

    public function valid_date($date) {
        $format = 'Y-m-d';
        $d = DateTime::createFromFormat($format, $date);
        $today = date('Y-m-d');
        //Check for valid date in given format
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
//iconv("UTF-8", "ASCII//TRANSLIT", $text)