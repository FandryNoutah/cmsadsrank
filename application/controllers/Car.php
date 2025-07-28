<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car extends MY_Controller {
	
	protected $file_upload_field;
	
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->data['visuels'] = $this->visuels_model->get_all();
		$this->load->library('PHPExcel');
		$this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		
		$this->load->library('upload');
        $this->load->library('form_validation');
        //$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
	}
	
	public function index() {
		
		$this->data['liste_car'] = $this->visuels_model->get_all_car();	
		$this->page = "templates/v3/admin-car";
		$this->layout();
	}
	public function update_car($id_Car){
	
	$ko = $this->visuels_model->get_by_id($id_Car); 
	$this->data["car"] = $ko;
	$this->page = "templates/v3/admin_car_edit";
	$this->layout();
	
		if($this->input->post('update'))
		{
		
		$Nom=$this->input->post('Nom');
		$Nombre_place=$this->input->post('Nombre_place');
		$Prix_jour=$this->input->post('Prix_jour');
		$Prestataire=$this->input->post('Prestataire');
		$Nom_chauffeur=$this->input->post('Nom_chauffeur');
		$Numero_chauffeur=$this->input->post('Numero_chauffeur');
		$Numero_voiture=$this->input->post('Numero_voiture');
		$Marque=$this->input->post('Marque');
		//var_dump($Nom);
		//Die();
		$this->visuels_model->update_car($Nom,$Nombre_place,$Prix_jour,$Prestataire,$Nom_chauffeur,$Numero_chauffeur,$Numero_voiture,$Marque,$id_Car);
		$this->session->set_flashdata('message-succes', "Donnée Mise a jour avec succès");
		redirect('Car', 'refresh');
		$this->layout();
		}
		
	}
	public function fiche_car($id_car){	
		//$idvisuels = $this->concurrent->get_concurrent_by_idvisuels($id);
		//datadump($idvisuels);
		//die();azerzerzer
		$ko = $this->visuels_model->get_by_id($id_car); 
		//datadump($ko);
		//die();
		
		$ho = $this->concurrent->getListeConcurrent();
		$co = $this->visuels_model->get_by_id($id_car);
		// $idv = $co[0]['id_car'];
		$axe = $this->visuels_model->get_axe_id($id_car); 
		
		 foreach($axe as $a){
		     
		         $axes = $a['Nom'];
				 $P = $this->visuels_model->get_personnelle_by_axes($axes);
				 foreach($P as $p){
				 
				 $personnelle = $p['Ligne'];
				  $valiny = Strcmp($axes,$personnelle);
				 
				
				 if($valiny == 0){
					
		         $perso = $P;
				}else($perso = "Sans donneer");
				
				
		     }
		 }
		//datadump($ko);
		  //die();
		
		//datadump($idv);
		//die();
		//datadump($ho);
		//die();
		if($P != Null){
			
			
		foreach($ko as $place){
		     
		         $Nbr_place_car = $place['Nombre_place'];
		}
		$Nbr_place_car = substr($Nbr_place_car,0,2);
		$Nbre_presonnelle = count($P);
		$Nbr_place_car_result = intval($Nbr_place_car);
		
		$Nbre_presonnelle_result = intval($Nbre_presonnelle);
		$place_libre = $Nbr_place_car_result - $Nbre_presonnelle_result;
		$this->data["listeConcurrent"] = $ho;
		$this->data["visuels"] = $co;
		$this->data["Place_Libre"] = $place_libre;
		$this->data["Nbre_presonnelle"] = $Nbre_presonnelle_result;
		$this->data["perso"] = $perso;
		$this->data["Car"] = $ko;
		$this->page = "templates/detail_car";
        $this->layout();
		}
		else{
			$this->session->set_flashdata('message-succes', "Le Car que vous avez selectionner est vide");
			redirect('Car', 'refresh');
			$this->layout();
		}
		
		
	}
	public function insert_liste_car()
	{
		$Nom = $this->input->post('Nom');
		$Nombre_place = $this->input->post('Nombre_place');
		$Prix_jour = $this->input->post('Prix_jour');
		$Prestataire = $this->input->post('Prestataire');
		$Nom_chauffeur = $this->input->post('Nom_chauffeur');
		$Numero_chauffeur = $this->input->post('Numero_chauffeur');
		$Numero_voiture = $this->input->post('Numero_voiture');
		$Marque = $this->input->post('Marque');
		
			
        $this->visuels_model->insertCar($Nom,$Nombre_place,$Prix_jour,$Prestataire,$Nom_chauffeur,$Numero_chauffeur,$Numero_voiture,$Marque);
		$this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
			redirect('Car', 'refresh');
			$this->layout();
	}
	function insert_liste_car_xls()
 {
  if(isset($_FILES["file"]["name"]))
  {
   $path = $_FILES["file"]["tmp_name"];
   $object = PHPExcel_IOFactory::load($path);
   foreach($object->getWorksheetIterator() as $worksheet)
   {
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    for($row=2; $row<=$highestRow; $row++)
    {
     
	 $Nom = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
	 $Nombre_place = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	 $Prix_jour = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
	 $Prestataire = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	 $Nom_chauffeur = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
	 $Numero_chauffeur = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	 $Numero_voiture = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
	 $Marque = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
	 
	
	 
	 
	 
     $data[] = array(
	  'Nom'  => $Nom,
	  'Nombre_place'  => $Nombre_place,
	  'Prix_jour'  => $Prix_jour,
	  'Prestataire'  => $Prestataire,
	  'Nom_chauffeur'  => $Nom_chauffeur,
	  'Numero_chauffeur'  => $Numero_chauffeur,
	  'Numero_voiture'  => $Numero_voiture,
	  'Marque'  => $Marque
	  
	  
	  
	  
	  
     );
    }
   }
   $this->visuels_model->Insert_DATA($data);
   
  
   $this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
			redirect('Car', 'refresh');
			$this->layout();
  } 
 }
 public function delete_car($id_Car){
	        $this->visuels_model->deletecar($id_Car);
			$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
			redirect('Car', 'refresh');
			$this->layout();
		
	}
	
	
		
	
	
	
	
	public function fichevisuels()
	{
		$this->page = "templates/fichevisuels";
		//templates/fichevisuels
		$this->layout();
	}
	function Export()
				 {
				$output = '';
				if(isset($_POST["export"]))
				{
				 $query = "SELECT * FROM tbl_customer";
				 $result = mysqli_query($connect, $query);
				 if(mysqli_num_rows($result) > 0)
				 {
				  $output .= '
				   <table class="table" bordered="1">  
									<tr>  
										 <th>Name</th>  
										 <th>Address</th>  
										 <th>City</th>  
					   <th>Postal Code</th>
					   <th>Country</th>
									</tr>
				  ';
				  while($row = mysqli_fetch_array($result))
				  {
				   $output .= '
					<tr>  
										 <td>'.$row["CustomerName"].'</td>  
										 <td>'.$row["Address"].'</td>  
										 <td>'.$row["City"].'</td>  
					   <td>'.$row["PostalCode"].'</td>  
					   <td>'.$row["Country"].'</td>
									</tr>
				   ';
				  }
				  $output .= '</table>';
				  header('Content-Type: application/xls');
				  header('Content-Disposition: attachment; filename=download.xls');
				  echo $output;
				 }
				}
		 }
	public function AjoutConcurrent()
	{
		//$ok = $this->visuels_model->get_all();	
		//$this->data['visuels'] = $this->visuels_model->get_by_id($id);
		$this->data['listeConcurrent'] = $this->concurrent->getListeConcurrent();	
        $categorie = $this->input->post('categorie');
        $remarque = $this->input->post('remarque');
		$image1 = $this->file_upload_field = "image1";
		$image2 = $this->file_upload_field = "image2";
		//$image3 = $this->file_upload_field = "image3";
		//$image4 = $this->file_upload_field = "image4";
		$image1 = "";
		$image2 = "";
		$image3 = "";
		$image4 = "";
		$idvisuels = $this->input->post('id');
		
		
		//datadump($_FILES['image1']['name']);
		//die();
		//$newData = $this->input->get();
		
		$this->upload->initialize($this->set_upload_options("", $_FILES["image1"]["name"]));
		$this->upload->initialize($this->set_upload_options("", $_FILES["image2"]["name"]));
		$this->upload->initialize($this->set_upload_options("", $_FILES["image3"]["name"]));
		$this->upload->initialize($this->set_upload_options("", $_FILES["image4"]["name"]));
		   if ($this->upload->do_upload('image1') != null) {
				
                $image1 = $this->path . $this->upload->file_name;
				}
			if ($this->upload->do_upload('image2') != null) {
				
                $image2 = $this->path . $this->upload->file_name;
				}
				
			if ($this->upload->do_upload('image3') != null) {
				
                $image3 = $this->path . $this->upload->file_name;
				}
			if ($this->upload->do_upload('image4') != null) {
				
                $image4 = $this->path . $this->upload->file_name;
				}
        $this->concurrent->insererConcurrent($categorie,$remarque,$image1,$image2,$image3,$image4,$idvisuels);
		redirect('visuels/visuelConcurrent/'.$id, 'refresh');
		$this->layout();
	}
	public function insert_visuels()
	{
        $label = $this->input->post('label');
        $date_visuel = $this->input->post('date_visuel');
		$logo = $this->file_upload_field = "logo";
		$logo = "";	
		//datadump($logo);
		//die();
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		   if ($this->upload->do_upload('logo') != null) {
				
                $logo = $this->path . $this->upload->file_name;
			
        $this->visuels_model->insertVisuels($label,$date_visuel,$logo);
		datadump('Donner inserer');
	}
	}
	public function EditConcurrent($id = null ){
		if($id == null) {
			$postdata = $this->concurrent->get_concurrent_by_idvisuels($this->input->post("id"));
			datadump($postdata);
			die();
			$this->load->view("templates/v3/parts/visuels/part-edit", ["id" => $this->input->post("id"), "postdata" => $postdata]);
		}
		
		
	}
	
	public function Concurrent($id)
	{
		
		//datadump($this->concurrent->getListeConcurrent());
		//die();
	   $this->data['listeConcurrent'] = $this->concurrent->getListeConcurrent();
		
		//$ok = $this->visuels_model->get_by_id($id);
		//datadump($ok);
		//die();
		//$this->data['visuels'] = $this->visuels_model->get_concurrent_by_id($id);
		//$ok2 = $this->concurrent->get_concurrent_by_id($id);
		
		
		
		
		//$this->data['visuels'] = $this->visuels_model->get_concurrent_by_id($id);	
		$this->page = "templates/concurrent_add";
		//templates/fichevisuels
		$this->layout();
	}
	
	public function delete($id) {
		if($this->visuels_model->delete_row($id)) {
			$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
			$this->page = "templates/visuelsConcurrent";
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
	
	// public function new() {
		// $this->form_validation->set_rules('label', 'Nom', 'trim|required');
		// $this->form_validation->set_rules('date_visuel', 'Date visuel', 'trim|required');
		
		// $newData = $this->input->post();
		
		// if($this->form_validation->run() == true) {
			
			// if($this->visuels_model->new_visuel($newData)) {
				// $this->session->set_flashdata('message-succes', "Données inserées avec succès");
				// redirect('visuels', 'refresh');
            // } else {
				// datadump("error");
			// }
		// }else {
			// datadump("error");
			// $this->page = "templates/v3/admin-visuels";
			// $this->layout();
		// }
		// redirect('visuels', 'refresh');
	// }
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
	
	public function Update(){
		$id = $this->input->post('id');
        $label = $this->input->post('label');
        $date_visuel = $this->input->post('date_visuel');
		$logo1 = $this->input->post('logo1');	
		$logo =  "";
		
		
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		   if ($this->upload->do_upload('logo') != null) {
				
                $logo = $this->path . $this->upload->file_name;
				}else{
					$logo = $logo1;
				}
				
        $this->visuels_model->update_visuel($id,$label,$date_visuel,$logo);
        redirect('Visuels');
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
	
	public function addConcurrent() {
		
		$newData = $this->input->post();
				
				datadump($newData);
				 die();
				//datadump($_FILES);
		$listeConcurrent = $this->concurrent->getListeConcurrent();
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
