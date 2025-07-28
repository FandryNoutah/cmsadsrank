<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends MY_Controller {
	
	protected $file_upload_field;
	
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
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
		
		$ko = $this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();	

		$this->data['produit'] = $this->Donne_modele->get_all_produit();
		$this->data['am'] = $this->Donne_modele->get_all_am();
		$this->data['initiative'] = $this->Donne_modele->get_all_initiative();
		$this->page = "templates/v3/listing_client.php";
		$this->layout();
	}
	public function Contexte($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idclients = $ko[0]['idclients'];
		$all = $this->data["all_campagne"] = $this->visuels_model->getAllCampagneByIdcontexte($idclients);
		$all = $this->data["all_groupe"] = $this->visuels_model->getAllgroupeByIdcontexte($idclients);

		$this->data["campagne"] = $this->visuels_model->getCampagneById($idclients);
		
		$this->data["groupe_annonce"] = $this->visuels_model->getGroupe_annonce_briefById($id);

		$t = $this->data["groupe_annonce_pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
		$this->data["groupe_annonce_local"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
	
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
	
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/contexte";
		$this->layout();
		
	}







	public function insertgroupeannonce($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$ko = $this->visuels_model->getClientById($id); 
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id); 
	
		$this->page = "templates/v3/ajout_groupe_annonce_technique";
		$this->layout();
		
	}
		// Fonction pour enregistrer un groupe
		public function save_groupe() {
			// Récupérer les données envoyées via POST
			$idgroupe_annonce = $this->input->post('idgroupe_annonce');
			$idclients = $this->input->post('idclients');
			$type_campagne = $this->input->post('type_campagne');
			$nom_groupe = $this->input->post('nom_groupe');
			
			// Récupérer les titres et descriptions (dynamique de 1 à 12 pour les titres et 1 à 4 pour les descriptions)
			$titre1 = $this->input->post('titre1');
			$titre2 = $this->input->post('titre2');
			$titre3 = $this->input->post('titre3');
			$titre4 = $this->input->post('titre4');
			$titre5 = $this->input->post('titre5');
			$titre6 = $this->input->post('titre6');
			$titre7 = $this->input->post('titre7');
			$titre8 = $this->input->post('titre8');
			$titre9 = $this->input->post('titre9');
			$titre10 = $this->input->post('titre10');
			$titre11 = $this->input->post('titre11');
			$titre12 = $this->input->post('titre12');
			
			// Récupérer les descriptions explicitement sans boucle
			$description1 = $this->input->post('description1');
			$description2 = $this->input->post('description2');
			$description3 = $this->input->post('description3');
			$description4 = $this->input->post('description4');
			
			// Récupérer les autres champs
			$chemin1 = $this->input->post('chemin1');
			$chemin2 = $this->input->post('chemin2');
			$url = $this->input->post('url');
			$mot_cle = $this->input->post('mot_cle');
	
			// Données à mettre à jour
			$groupe_data = [
				'idgroupe_annonce' => $idgroupe_annonce,
				'idclients' => $idclients,
				'type_campagnes' => $type_campagne,
				'nom_groupe' => $nom_groupe,
				'titre1' => $titre1,
            'titre2' => $titre2,
            'titre3' => $titre3,
            'titre4' => $titre4,
            'titre5' => $titre5,
            'titre6' => $titre6,
            'titre7' => $titre7,
            'titre8' => $titre8,
            'titre9' => $titre9,
            'titre10' => $titre10,
            'titre11' => $titre11,
            'titre12' => $titre12,
            // Descriptions individuelles
            'descriptions1' => $description1,
            'descriptions2' => $description2,
            'descriptions3' => $description3,
            'descriptions4' => $description4,
				'chemin1' => $chemin1,
				'chemin2' => $chemin2,
				'url_groupe_annonce' => $url,
				'mot_cle' => $mot_cle
			];
	
			// Appeler la fonction de mise à jour dans le modèle
			$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
			redirect('Googleads/validation_client/' . $idgroupe_annonce);
			// Après la mise à jour, vous pouvez rediriger ou afficher une vue de confirmation
			$this->session->set_flashdata('success', 'Groupe mis à jour avec succès.');
			redirect('Googleads/success');  // Exemple de redirection après mise à jour
		}
		public function edit_groupe($id) {
			$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 
			$this->load->view("templates/v3/edit_groupe_annonce", $this->data);
			
		}
	public function information_client($id) {
		$this->data["donnees"] = $this->visuels_model->getinformation($id);
		$this->data["clients"] = $this->visuels_model->getclients($id);  
		$this->page = "templates/v3/edit_information_client";
		$this->layout();
		
	}
	public function ajout_groupeannonce_pmax($id) {
		$o = $this->data["campagne"] = $this->visuels_model->getCampagneid($id); 
		$this->data["groupe"] = $this->visuels_model->getgroupepmaxidcampagne($id); 
		$o = $o[0]['idclients'];
		$o = intval($o);
		$id = $o;
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $this->visuels_model->getClientById($id); 
		$this->page = "templates/v3/ajout_groupe_annonce_pmax";
		$this->layout();
		
	}	
	public function ajout_groupeannonce_local($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneid($id); 
		$this->data["groupe"] = $this->visuels_model->getgroupepmaxidcampagne($id); 
		$this->page = "templates/v3/ajout_groupe_annonce_pmax";
		$this->layout();
		
	}	
	public function indexs() {
		$data['images'] = [];
	
		// Vérifier si une URL a été soumise
		if ($this->input->post('url')) {
			$url = $this->input->post('url');
			$data['images'] = $this->scrape_images($url);
			
			// Retourner les images sous forme de JSON pour l'AJAX
			echo json_encode($data['images']);
			return;
		}
	
		// Si des images ont été sélectionnées, les enregistrer dans la base de données
		if ($this->input->post('selected_images')) {
			$selected_images = $this->input->post('selected_images');
			$this->save_images_to_db($selected_images);
		}
	
		// Charger la vue
		$this->load->view('templates/v3/ajout_groupe_annonce_pmax', $data);
	}
	

    private function scrape_images($url) {
        // Créer une instance de cURL pour l'URL
        $this->curl->create($url);

        // Ajouter un User-Agent pour simuler une requête depuis un navigateur
        $this->curl->option(CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ]);

        // Activer le suivi des redirections si nécessaire
        $this->curl->option(CURLOPT_FOLLOWLOCATION, true);

        // Désactiver la vérification SSL (utile pour certains serveurs avec des problèmes de certificat)
        $this->curl->option(CURLOPT_SSL_VERIFYPEER, false);

        // Récupérer le contenu de la page HTML
        $html = $this->curl->execute();

        // Vérifier si la page a bien été récupérée
        if (!$html) {
            echo 'Erreur cURL: ' . $this->curl->error_string;
            return [];
        }

        // Expression régulière pour récupérer les URL des images
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
        
        $images = [];
        
        if (isset($matches[1])) {
            foreach ($matches[1] as $img_url) {
                // On vérifie si l'URL de l'image est complète ou relative
                if (!filter_var($img_url, FILTER_VALIDATE_URL)) {
                    // Si l'URL est relative, on la rend absolue
                    $img_url = rtrim($url, '/') . '/' . ltrim($img_url, '/');
                }
                $images[] = $img_url;
            }
        }

        return $images;
    }
	public function save_images() {

		$idclients = $this->input->post('idclients');
		$type_image = 0;
        $selected_images = $this->input->post('selected_images');
		


        if (!empty($selected_images)) {
			$Images_youtube1 = $selected_images[0];
			$Images_youtube2 = $selected_images[1];
			$Images_gmail = $selected_images[2];
			$Images_display1 = $selected_images[3];
			$Images_display2 = $selected_images[4];
			$Images_discover1 = $selected_images[5];
			$Images_discover2 = $selected_images[6];
			$Images_discover3 = $selected_images[7];

            $this->visuels_model->insert_images_bd($idclients,$Images_youtube1,$Images_youtube2,$Images_gmail,$Images_display1,$Images_display2,$Images_discover1,$Images_discover2,$Images_discover3,$type_image); 
        } else {
            // Si aucune image n'est sélectionnée
            echo "Aucune image sélectionnée.";
        }
    }
	public function save_images2() {

		$idclients = $this->input->post('idclients');
		$type_image = 0;
        $selected_images = $this->input->post('selected_images');


        if (!empty($selected_images)) {
			$Images_youtube1 = $selected_images[0];
			$Images_youtube2 = $selected_images[1];
			$Images_gmail = $selected_images[2];
			$Images_display1 = $selected_images[3];
			$Images_display2 = $selected_images[4];
			$Images_discover1 = $selected_images[5];
			$Images_discover2 = $selected_images[6];
			$Images_discover3 = $selected_images[7];

            $this->visuels_model->insert_images_bd2($idclients,$Images_youtube1,$Images_youtube2,$Images_gmail,$Images_display1,$Images_display2,$Images_discover1,$Images_discover2,$Images_discover3,$type_image); 
        } else {
            // Si aucune image n'est sélectionnée
            echo "Aucune image sélectionnée.";
        }
    }
	public function save_images_upload() {
		$idclients = $this->input->post('idclients');
		$selected_images = $this->input->post('selected_images');
		$selected_images = $this->file_upload_field = 'selected_images';
		$favicon = $this->file_upload_field = 'favicon';
		$selected_images = "";
		$favicon = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["selected_images"]["name"]));
		if ($this->upload->do_upload('selected_images') != null) {
			$selected_images = $this->path . $this->upload->file_name;
		}
		$this->upload->initialize($this->set_upload_options("", $_FILES["favicon"]["name"]));
		if ($this->upload->do_upload('favicon') != null) {
			$favicon = $this->path . $this->upload->file_name;
		}
		if (!empty($selected_images)) {
			// Initialisation des variables d'image
			$Images_youtube1 = $Images_youtube2 = $Images_gmail = $Images_display1 = "";
			$Images_display2 = $Images_discover1 = $Images_discover2 = $Images_discover3 = "";
			
			// Téléchargement des images et affectation des valeurs
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube1"]["name"]));
			if ($this->upload->do_upload('Images_youtube1')) {
				$Images_youtube1 = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube2"]["name"]));
			if ($this->upload->do_upload('Images_youtube2')) {
				$Images_youtube2 = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_gmail"]["name"]));
			if ($this->upload->do_upload('Images_gmail')) {
				$Images_gmail = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display1"]["name"]));
			if ($this->upload->do_upload('Images_display1')) {
				$Images_display1 = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display2"]["name"]));
			if ($this->upload->do_upload('Images_display2')) {
				$Images_display2 = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover1"]["name"]));
			if ($this->upload->do_upload('Images_discover1')) {
				$Images_discover1 = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover2"]["name"]));
			if ($this->upload->do_upload('Images_discover2')) {
				$Images_discover2 = $this->path . $this->upload->file_name;
			}
	
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover3"]["name"]));
			if ($this->upload->do_upload('Images_discover3')) {
				$Images_discover3 = $this->path . $this->upload->file_name;
			}
	
			// Vérification des images téléchargées et affichage
			var_dump($Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3);
			die();
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
	}
	
    private function save_images_to_db($selected_images) {
        // Enregistrer chaque image sélectionnée dans la base de données
        foreach ($selected_images as $image_url) {
            $data = [
                'image_url' => $image_url
            ];
			var_dump($data);
			die();
            $this->Image_model->insert_image($data);
        }
    }
	public function ajout_groupeannonce($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneid($id); 
		$this->page = "templates/v3/ajout_groupe_annonce";
		$this->layout();
		
	}
		
	public function detail_campagne($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$ko = $this->visuels_model->getClientById($id); 
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
	 	$c[0] = $this->visuels_model->getCampagneiddetail($id); 
		 $this->data["campagne"] = $c[0];
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 

		$this->page = "templates/v3/detailcampagne";
		$this->layout();
		
	}	
	public function detail_campagne_local($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$ko = $this->visuels_model->getClientById($id); 
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$this->data["campagne"] = $this->visuels_model->getCampagneid($id); 
		$this->data["local"] = $this->visuels_model->getGroupeAnnonceByIdlocals($id); 
		$this->page = "templates/v3/detailcampagnelocal";
		$this->layout();
		
	}	
	public function detail_campagne_pmax($id) {
	
		$c = $this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$o = $this->data["pmax"] = $this->visuels_model->getGroupeAnnonceByIdPmaxs($id);

		$o = $o[0]['idclients'];
		$o = intval($o);
		$id = $o;
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $this->visuels_model->getClientById($id); 
		$this->page = "templates/v3/detailcampagnepmax";
		$this->layout();
		
	}	


	public function save_brouillon($idonnee) {
		$decision = 0;
		$date = new DateTime();
		$structure = $date->format('d-m-Y');
		$this->Donne_modele->save_brouillon($idonnee, $decision);
		$this->Donne_modele->insert_structure($idonnee, $structure);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	public function save_campagne($idonnee) {
		$decision = 1;
		$this->Donne_modele->save_campagne($idonnee, $decision);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	public function campagne($idclients) {
		$id = $idclients;
		$this->data["campagne"] = $this->visuels_model->getCampagneByIdclient($id);
		$ko = $this->visuels_model->getClientById($id); 
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$this->data["groupe_annonce"] = $this->visuels_model->getGroupe_annonce_briefById($id);
		
		$t = $this->data["groupe_annonce_pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
		$this->data["groupe_annonce_local"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
		$this->page = "templates/v3/campagne";
		$this->layout();
	}
	public function save_annonce($idcampagne) {
		$decision = 1;
		$date = new DateTime();
		$structure = $date->format('Y-m-d');
		$idclients = $this->Donne_modele->save_campagnes($idcampagne, $decision);
		$idclients = $this->Donne_modele->save_annonces($idcampagne, $decision);
		$idclients = intval($idclients[0]);

		$this->Donne_modele->save_annonces_donnee($idclients, $structure);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads/admin_brief/' . $idclients);
		$this->layout();
	}
	public function save_brouillon_annonce($idcampagne) {
		$decision = 0;
		$date = new DateTime();
		$structure = $date->format('d-m-Y');
		$idclients = $this->Donne_modele->bouillon_campagnes($idcampagne, $decision);
		$idclients = intval($idclients[0]);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads/admin_brief/' . $idclients);
		$this->layout();
	}
	
	
	public function visualiser($id) {
		// Récupérer les données du modèle
		$this->data["pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id); 
		
		// Charger la vue
		$this->load->view("templates/v3/Visualiser", $this->data);
	}
	public function VisualiserSearch($id) {
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 
		$this->load->view("templates/v3/Search", $this->data);
		
	}
	public function validation_client($id) {
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 
		$this->load->view("templates/v3/Search", $this->data);
		
	}
	public function Visualiserpmax($id) {
		$this->data["pmax"] = $t = $this->visuels_model->getGroupeAnnonceByIdpmax($id); 

		$this->load->view("templates/v3/Visualiser", $this->data);
		
	}
	public function VisualiserSearchs($id) {
    $idclients = $this->visuels_model->getGroupeAnnonceByIdclient($id);
    $idclients = $idclients[0];
    $idclients = $idclients['idclients'];
    $idclients = intval($idclients);
    $this->data["search"] = $this->visuels_model->getGroupeAnnonceByIdclients($idclients); 
    
    // Utiliser le répertoire writable de CodeIgniter (FCPATH fait référence à la racine de votre application CodeIgniter)
    $tempHtmlFile = FCPATH . 'writable/temp/temp_view.html';
    $outputImage = FCPATH . 'writable/temp/output_image.jpg';

    // Créer le contenu HTML
    $viewContent = $this->load->view("templates/v3/Search", $this->data, true);

    // Sauvegarder le contenu HTML dans un fichier temporaire
    if (file_put_contents($tempHtmlFile, $viewContent) === false) {
        die("Erreur lors de l'écriture dans le fichier.");
    }

    // Commande pour utiliser wkhtmltoimage et convertir le HTML en image
    $command = "wkhtmltoimage --width 1200 --height 800 $tempHtmlFile $outputImage";
    exec($command, $output, $return_var);

    // Vérifier si l'image a été générée avec succès
    if ($return_var === 0) {
        // Optionnellement, afficher l'image générée
        echo "<img src='" . base_url('writable/temp/output_image.jpg') . "' />";
    } else {
        echo "Erreur lors de la génération de l'image.";
    }

    // Nettoyer en supprimant le fichier HTML temporaire
    unlink($tempHtmlFile);
}
	
	public function Ajoutgroupe() {
				$idcampagne = $this->input->post('idcampagne');
				$idclients = $this->input->post('idclients');
				$type_campagne = $this->input->post('type_campagne');
				$nom_groupe = $this->input->post('nom_groupe');
				$titre1 = $this->input->post('titre1');
				$titre2 = $this->input->post('titre2');
				$titre3 = $this->input->post('titre3');
				$titre4 = $this->input->post('titre4');
				$titre5 = $this->input->post('titre5');
				$titre6 = $this->input->post('titre6');
				$titre7 = $this->input->post('titre7');
				$titre8 = $this->input->post('titre8');
				$titre9 = $this->input->post('titre9');
				$titre10 = $this->input->post('titre10');
				$titre11 = $this->input->post('titre11');
				$titre12 = $this->input->post('titre12');
				$description1 = $this->input->post('description1');
				$description2 = $this->input->post('description2');
				$description3 = $this->input->post('description3');
				$description4 = $this->input->post('description4');
				$chemin1 = $this->input->post('chemin1');
				$chemin2 = $this->input->post('chemin2');
				$url = $this->input->post('url');
				$mot_cle = $this->input->post('mot_cle');
				$data = array(
					'idcampagne' => $idcampagne,
					'idclients' => $idclients,
					'type_campagnes' => $type_campagne,
					'nom_groupe' => $nom_groupe,
					'titre1' => $titre1,
					'titre2' => $titre2,
					'titre3' => $titre3,
					'titre4' => $titre4,
					'titre5' => $titre5,
					'titre6' => $titre6,
					'titre7' => $titre7,
					'titre8' => $titre8,
					'titre9' => $titre9,
					'titre10' => $titre10,
					'titre11' => $titre11,
					'titre12' => $titre12,
					'descriptions1' => $description1,
					'descriptions2' => $description2,
					'descriptions3' => $description3,
					'descriptions4' => $description4,
					'chemin1' => $chemin1,
					'chemin2' => $chemin2,
					'url_groupe_annonce' => $url,
					'mot_cle' => $mot_cle
				);
				$this->Donne_modele->insert_groupe_search($data);
				redirect('Googleads', 'refresh');
		$this->layout();
		
	}
	public function Ajoutgroupes() {
		// Récupérer les données depuis la requête POST
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idcampagne = $this->input->post('idcampagne');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');
		$titre1 = $this->input->post('titre1');
		$titre2 = $this->input->post('titre2');
		$titre3 = $this->input->post('titre3');
		$titre4 = $this->input->post('titre4');
		$titre5 = $this->input->post('titre5');
		$titre6 = $this->input->post('titre6');
		$titre7 = $this->input->post('titre7');
		$titre8 = $this->input->post('titre8');
		$titre9 = $this->input->post('titre9');
		$titre10 = $this->input->post('titre10');
		$titre11 = $this->input->post('titre11');
		$titre12 = $this->input->post('titre12');
		$description1 = $this->input->post('description1');
		$description2 = $this->input->post('description2');
		$description3 = $this->input->post('description3');
		$description4 = $this->input->post('description4');
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$url = $this->input->post('url');
		$mot_cle = $this->input->post('mot_cle');
		
		// Préparer les données à mettre à jour
		$data = array(
			'idcampagne' => $idcampagne,
			'idclients' => $idclients,
			'type_campagnes' => $type_campagne,
			'nom_groupe' => $nom_groupe,
			'titre1' => $titre1,
			'titre2' => $titre2,
			'titre3' => $titre3,
			'titre4' => $titre4,
			'titre5' => $titre5,
			'titre6' => $titre6,
			'titre7' => $titre7,
			'titre8' => $titre8,
			'titre9' => $titre9,
			'titre10' => $titre10,
			'titre11' => $titre11,
			'titre12' => $titre12,
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle
		);
	
		// Mise à jour des données en fonction de l'idgroupe_annonce
		$this->Donne_modele->update_groupe_search($idgroupe_annonce, $data);
	
		// Redirection après la mise à jour
		redirect('Googleads', 'refresh');
	}
	
	public function Ajoutgroupepmax() {
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idcampagne = $this->input->post('idcampagne');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');	
		$titre1 = $this->input->post('titre1');
		$titre2 = $this->input->post('titre2');
		$titre3 = $this->input->post('titre3');
		$titre4 = $this->input->post('titre4');
		$titre5 = $this->input->post('titre5');
		$titre6 = $this->input->post('titre6');
		$titre7 = $this->input->post('titre7');
		$titre8 = $this->input->post('titre8');
		$titre9 = $this->input->post('titre9');
		$titre10 = $this->input->post('titre10');
		$titre11 = $this->input->post('titre11');
		$titre12 = $this->input->post('titre12');
		$description1 = $this->input->post('description1');
		$description2 = $this->input->post('description2');
		$description3 = $this->input->post('description3');
		$description4 = $this->input->post('description4');
		$description_breve = $this->input->post('description_breve');
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$url = $this->input->post('url');
		$mot_cle = $this->input->post('mot_cle');

		$logos = $this->file_upload_field = 'logos';
		$favicon = $this->file_upload_field = 'favicon';
		$logos = "";
		$favicon = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
		if ($this->upload->do_upload('logos') != null) {
			$logos = $this->path . $this->upload->file_name;
		}
		$this->upload->initialize($this->set_upload_options("", $_FILES["favicon"]["name"]));
		if ($this->upload->do_upload('favicon') != null) {
			$favicon = $this->path . $this->upload->file_name;
		}
		$data = array(
			'idclients' => $idclients,
			'idcampagne' => $idcampagne,
			'type_campagnes' => $type_campagne,
			'nom_groupe' => $nom_groupe,
			'titre1' => $titre1,
			'titre2' => $titre2,
			'titre3' => $titre3,
			'titre4' => $titre4,
			'titre5' => $titre5,
			'titre6' => $titre6,
			'titre7' => $titre7,
			'titre8' => $titre8,
			'titre9' => $titre9,
			'titre10' => $titre10,
			'titre11' => $titre11,
			'titre12' => $titre12,
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'description_breve' => $description_breve,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle,
			'logo_client' => $logos,
			'favicon' => $favicon
		);
		// Mise à jour du groupe en fonction de l'idgroupe_annonce
$this->Donne_modele->update_groupe_pmax($data, $idgroupe_annonce);

		redirect('Googleads', 'refresh');
		$this->layout();

}
public function Ajoutgroupelocal() {
	$idgroupe_annonce = $this->input->post('idgroupe_annonce');
	$idcampagne = $this->input->post('idcampagne');
	$idclients = $this->input->post('idclients');
	$type_campagne = 2;
	$nom_groupe = $this->input->post('nom_groupe');	
	$titre1 = $this->input->post('titre1');
	$titre2 = $this->input->post('titre2');
	$titre3 = $this->input->post('titre3');
	$titre4 = $this->input->post('titre4');
	$titre5 = $this->input->post('titre5');
	$titre6 = $this->input->post('titre6');
	$titre7 = $this->input->post('titre7');
	$titre8 = $this->input->post('titre8');
	$titre9 = $this->input->post('titre9');
	$titre10 = $this->input->post('titre10');
	$titre11 = $this->input->post('titre11');
	$titre12 = $this->input->post('titre12');
	$description1 = $this->input->post('description1');
	$description2 = $this->input->post('description2');
	$description3 = $this->input->post('description3');
	$description4 = $this->input->post('description4');
	$description_breve = $this->input->post('description_breve');
	$chemin1 = $this->input->post('chemin1');
	$chemin2 = $this->input->post('chemin2');
	$url = $this->input->post('url');
	$mot_cle = $this->input->post('mot_cle');

	$logos = $this->file_upload_field = 'logos';
	$favicon = $this->file_upload_field = 'favicon';
	$logos = "";
	$favicon = "";
	$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
	if ($this->upload->do_upload('logos') != null) {
		$logos = $this->path . $this->upload->file_name;
	}
	$this->upload->initialize($this->set_upload_options("", $_FILES["favicon"]["name"]));
	if ($this->upload->do_upload('favicon') != null) {
		$favicon = $this->path . $this->upload->file_name;
	}
	$data = array(
		'idclients' => $idclients,
		'idcampagne' => $idcampagne,
		'type_campagnes' => $type_campagne,
		'nom_groupe' => $nom_groupe,
		'titre1' => $titre1,
		'titre2' => $titre2,
		'titre3' => $titre3,
		'titre4' => $titre4,
		'titre5' => $titre5,
		'titre6' => $titre6,
		'titre7' => $titre7,
		'titre8' => $titre8,
		'titre9' => $titre9,
		'titre10' => $titre10,
		'titre11' => $titre11,
		'titre12' => $titre12,
		'descriptions1' => $description1,
		'descriptions2' => $description2,
		'descriptions3' => $description3,
		'descriptions4' => $description4,
		'description_breve' => $description_breve,
		'chemin1' => $chemin1,
		'chemin2' => $chemin2,
		'url_groupe_annonce' => $url,
		'mot_cle' => $mot_cle,
		'logo_client' => $logos,
		'favicon' => $favicon
	);
	// Mise à jour du groupe en fonction de l'idgroupe_annonce
$this->Donne_modele->update_groupe_pmax($data, $idgroupe_annonce);

	redirect('Googleads', 'refresh');
	$this->layout();

}
public function Ajout_Campagne() {
    if ($this->input->post('type_de_campagne') == 1) {
        $idclients = $this->input->post('idclient');
        $type_campagne = $this->input->post('type_de_campagne');
        $nom_campagne = $this->input->post('nom_campagne_search');
        $information_campagne = $this->input->post('information_campagne_search');
		
        $zones = $this->input->post('zone_search');
        $repartition_budget = $this->input->post('repartition_budget_search');
        $date_campagne = $this->input->post('date_campagne');
        $appareil = $this->input->post('appareil_search');
        $objectif = $this->input->post('objectif');
        $url_site = $this->input->post('url_campagne');
        $Mots_cle_potentiels = $this->input->post('Mot_cle');

        // Récupérer tous les groupes d'annonces dynamiques
        $groupes_annonces = $this->input->post('groupe_annonce'); // Récupère les groupes d'annonces

        $contexte_groupes_annonces = $this->input->post('contexte_groupe_annonce'); // Récupère les contextes des groupes d'annonces
        $mots_cle = $this->input->post('Mot_cle'); // Récupère les mots-clés
        
        // Vérifier que les groupes d'annonces, leurs contextes et les mots-clés sont bien récupérés
        if (count($groupes_annonces) == count($contexte_groupes_annonces) && count($groupes_annonces) == count($mots_cle)) {
            // Lancer l'insertion de la campagne
            $idcampagne = $this->Donne_modele->insert_campagne_am(
                $idclients,
                $type_campagne,
                $nom_campagne,
                $information_campagne,
                $zones,
                $repartition_budget,
                $date_campagne,
                $appareil,
                $objectif,
                $url_site,
                $Mots_cle_potentiels
            );
        
            // Insérer les groupes d'annonces et leurs contextes associés
            $data_groups = array();
            foreach ($groupes_annonces as $index => $groupe) {
                $data_groups[] = array(
                    'groupe_annonce' => $groupe,
                    'contexte_groupe_annonce' => isset($contexte_groupes_annonces[$index]) ? $contexte_groupes_annonces[$index] : '',
                    'mot_cle' => isset($mots_cle[$index]) ? $mots_cle[$index] : '', // Ajouter le mot-clé associé
					'url_groupe_annonce' => $url_site,
                    'idcampagne' => $idcampagne,
                    'idclient' => $idclients,
                    'type_campagne' => $type_campagne
                );
            }
        
            // Insertion des données dans la table des groupes d'annonces
            $this->Donne_modele->insert_gp($data_groups, $idcampagne, $idclients, $type_campagne, $contexte_groupes_annonces, $mots_cle, $url_site); // Passe tous les arguments nécessaires
        } else {
            // Gérer l'erreur si les données ne sont pas cohérentes
            // Par exemple, retourner un message d'erreur ou rediriger
            echo 'Erreur : Le nombre de groupes d\'annonces, de contextes et de mots-clés ne correspond pas.';
        }
        $this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
        redirect('Googleads/campagne/'. $idclients, 'refresh');
        $this->layout();
    } // Fermeture du premier if

    if ($this->input->post('type_de_campagne') == 2) {
        $idclients = $this->input->post('idclient');
        $type_campagne = $this->input->post('type_de_campagne');
        $nom_campagne = $this->input->post('nom_campagne_local');
		$nom_groupe_pmax = $this->input->post('nom_groupe_local');
        $information_campagne = $this->input->post('information_campagne_local');
        $zones = $this->input->post('zone_Local');
	
        $repartition_budget = $this->input->post('repartition_budget_local');
        $date_campagne = $this->input->post('date_campagne_local');
        $appareil = $this->input->post('appareil_local');
        $objectif = $this->input->post('objectif_local');
        $url_site = $this->input->post('url_campagne_local');
        $Mots_cle_potentiels = $this->input->post('Mot_cle_local');
        $contextes_client = $this->input->post('contexte_groupe_local');
		$idcampagne = $this->Donne_modele->insert_campagne_am($idclients, $type_campagne, $nom_campagne, $information_campagne, $zones,
        $repartition_budget, $date_campagne, $appareil, $objectif, $url_site, $Mots_cle_potentiels);
        $this->Donne_modele->insert_gppmax($idclients,$nom_groupe_pmax, $type_campagne,$url_site,$Mots_cle_potentiels, $idcampagne,$contextes_client);
		$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
        redirect('Googleads/campagne/'. $idclients, 'refresh');
        $this->layout();
    } // Fermeture du deuxième if

    if ($this->input->post('type_de_campagne') == 3) {
        $idclients = $this->input->post('idclient');
        $type_campagne = $this->input->post('type_de_campagne');
        $nom_campagne = $this->input->post('nom_campagne_pmax');
		$nom_groupe_pmax = $this->input->post('nom_groupe_pmax');
        $information_campagne = $this->input->post('information_campagne_pmax');
        $zones = $this->input->post('zone_pmax');
        $repartition_budget = $this->input->post('repartition_budget_pmax');
        $date_campagne = $this->input->post('date_campagne_pmax');
        $appareil = $this->input->post('appareil_pmax');
        $objectif = $this->input->post('objectif_pmax');
        $url_site = $this->input->post('url_campagne_pmax');
        $Mots_cle_potentiels = $this->input->post('Mot_cle_pmax');
        $information_client = $this->input->post('information_client_pmax');
        $contextes_client = $this->input->post('contextes_client_pmax');
		$idcampagne = $this->Donne_modele->insert_campagne_am($idclients, $type_campagne, $nom_campagne, $information_campagne, $zones,
        $repartition_budget, $date_campagne, $appareil, $objectif, $url_site, $Mots_cle_potentiels);
        $this->Donne_modele->insert_gppmax($idclients,$nom_groupe_pmax, $type_campagne,$url_site,$Mots_cle_potentiels, $idcampagne,$contextes_client);
        
		$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
        redirect('Googleads/campagne/'. $idclients, 'refresh');
        $this->layout();
    } // Fermeture du troisième if
}







	public function submitForm() {
        // Récupérer les données du formulaire de la campagne
		if ($this->input->post('type_de_campagne') == 1) {
			
        $campaign_data = array(
            'idclients' => $this->input->post('idclient'),  // ID client récupéré depuis le champ caché
			'nom_campagne' => $this->input->post('nom_campagne'),
			'type_campagne' => $this->input->post('type_de_campagne'),
			'logo_client' => NULL,  // Ajoutez si vous avez un champ pour le logo
            'parametre_campagne' => $this->input->post('campaign-name'),
            'repartition_budget' => $this->input->post('repartition_budget'),
            'date_campagne' => $this->input->post('calendar'),
			'url_site' => $this->input->post('url_site'),  // Ajoutez si nécessaire
			'cible' => $this->input->post('cible'),
			'zones' => $this->input->post('zone'),
            'cible' => $this->input->post('cible'),  // Ajoutez si nécessaire
            'idextentions' => $this->input->post('extentions'),  // Ajoutez si nécessaire
            'Mots_cle_potentiels' => $this->input->post('Mots_cle_potentiels'),  // Ajoutez si nécessaire
            'valeurs_ajouter' => $this->input->post('valeurs_ajouter'),  // Ajoutez si nécessaire
			'appareil' => $this->input->post('appareil'),
			'Extensions_de_liens' => $this->input->post('Extensions_de_liens'),
			'Extensions_de_produits' => $this->input->post('Extensions_de_produits'),
            'label_produit' => NULL,  // Ajoutez si nécessairetype_de_campagne
			'objectif' => $this->input->post('objectif')
        );

        // Insérer la campagne dans la table campagne
        $idcampagne = $this->Donne_modele->insert_campagne($campaign_data);

        // Récupérer les groupes d'annonces selon le type de campagne
        $annonce_groups = $this->input->post('group-name');  // Liste des groupes d'annonces
        $group_data = array();

        foreach ($annonce_groups as $index => $group_name) {
            // Ajouter l'ID du client et de la campagne dans chaque groupe d'annonce
            $group_data[] = array(
                'idclients' => $this->input->post('idclient'),  // Ajouter l'ID du client
                'idcampagne' => $idcampagne,  // ID de la campagne associée
				'nom_groupe' => $this->input->post('group-name')[$index],
                'titre1' => $this->input->post('group-title1')[$index],
				'titre2' => $this->input->post('group-title2')[$index],
				'titre3' => $this->input->post('group-title3')[$index],
				'titre4' => $this->input->post('group-title4')[$index],
				'titre5' => $this->input->post('group-title5')[$index],
				'titre6' => $this->input->post('group-title6')[$index],
				'titre7' => $this->input->post('group-title7')[$index],
				'titre8' => $this->input->post('group-title8')[$index],
				'titre9' => $this->input->post('group-title9')[$index],
				'titre10' => $this->input->post('group-title10')[$index],
				'titre11' => $this->input->post('group-title11')[$index],
				'titre12' => $this->input->post('group-title12')[$index],
                'descriptions1' => $this->input->post('group-description1')[$index],
				'descriptions2' => $this->input->post('group-description2')[$index],
				'descriptions3' => $this->input->post('group-description3')[$index],
				'descriptions4' => $this->input->post('group-description4')[$index],
				'titre' => $this->input->post('group-title')[$index],
                'chemin1' => $this->input->post('group-path1')[$index],
                'chemin2' => $this->input->post('group-path2')[$index],
                'url_groupe_annonce' => $this->input->post('group-url')[$index],
                'mot_cle' => $this->input->post('group-keywords')[$index]
            );
        }

        // Insérer les groupes d'annonces
        if (!empty($group_data)) {
            $this->Donne_modele->insert_multiple_groupe_annonce($group_data);
        }

        // Rediriger ou afficher un message de succès
        $this->session->set_flashdata('Admin_brief', 'Campagne et groupes d\'annonces ajoutés avec succès.');
		redirect('Admin_brief', 'refresh');
		$this->layout();
	}
	if ($this->input->post('type_de_campagne') == 2) {
		$logos = $this->file_upload_field = 'logos';
		$logos = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
		if ($this->upload->do_upload('logo') != null) {
				
			$logos = $this->path . $this->upload->file_name;
			}
		var_dump($logos);
		die();	
	
		// Insertion dans la base de données
		var_dump($data);
		die();
	}
	
	
	if ($this->input->post('type_de_campagne') == 3) {
		$idclient = $this->input->post('idclient');
		$idclient = intval($idclient);
		$type_de_campagne = $this->input->post('type_de_campagne');
		$zone = $this->input->post('zone');
		$calendar = $this->input->post('calendar');
		$appareil = $this->input->post('appareil');
		$appareil = intval($appareil);
		$idcampagne = $this->Donne_modele->insert_campagne_pmax($idclient,$zone,$type_de_campagne,$calendar,$appareil);
		$mot_cle = $this->input->post('mot_cle');
		$nom_campagne = $this->input->post('nom_campagne');
		$objectif = $this->input->post('objectif');
		$repartition_budget = $this->input->post('repartition_budget');
		$titre = $this->input->post('titre');
		$description = $this->input->post('description');
		$description_bref = $this->input->post('description_bref');
		$url = $this->input->post('url');
		$logos = $this->file_upload_field = 'logos';
		$Images_youtube1 = $this->file_upload_field = 'Images_youtube1';
		$Images_youtube2 = $this->file_upload_field = 'Images_youtube2';
		$Images_gmail = $this->file_upload_field = 'Images_gmail';
		$Images_display1 = $this->file_upload_field = 'Images_display1';
		$Images_display2 = $this->file_upload_field = 'Images_display2';
		$Images_discover1 = $this->file_upload_field = 'Images_discover1';
		$Images_discover2 = $this->file_upload_field = 'Images_discover2';
		$Images_discover3 = $this->file_upload_field = 'Images_discover3';
		$logos = "";
		$Images_youtube1 = "";
		$Images_youtube2 = "";
		$Images_gmail = "";
		$Images_display1 = "";
		$Images_display2 = "";
		$Images_discover1 = "";
		$Images_discover2 = "";
		$Images_discover3 = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
		if ($this->upload->do_upload('logos') != null) {
			$logos = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube1"]["name"]));
		if ($this->upload->do_upload('Images_youtube1') != null) {
			$Images_youtube1 = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube2"]["name"]));
		if ($this->upload->do_upload('Images_youtube2') != null) {
			$Images_youtube2 = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_gmail"]["name"]));
		if ($this->upload->do_upload('Images_gmail') != null) {
			$Images_gmail = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display1"]["name"]));
		if ($this->upload->do_upload('Images_display1') != null) {
			$Images_display1 = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display2"]["name"]));
		if ($this->upload->do_upload('Images_display2') != null) {
			$Images_display2 = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover1"]["name"]));
		if ($this->upload->do_upload('Images_discover1') != null) {
			$Images_discover1 = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover2"]["name"]));
		if ($this->upload->do_upload('Images_discover2') != null) {
			$Images_discover2 = $this->path . $this->upload->file_name;
		}

		$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover3"]["name"]));
		if ($this->upload->do_upload('Images_discover3') != null) {
			$Images_discover3 = $this->path . $this->upload->file_name;
		}
		var_dump($Images_youtube1);
		die();

		$this->Donne_modele->insert_pmax($idclient,$idcampagne,$nom_campagne, $zone, $calendar, $appareil, $mot_cle, 
		$objectif, $repartition_budget, $titre, $description, $description_bref, $url, $logos, $Images_youtube1,
		 $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, 
		 $Images_discover2, $Images_discover3);
		 $this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
		 redirect('Googleads', 'refresh');
		 $this->layout();

	}
	}
	private function _upload_files($field_name) {
        $files = $_FILES[$field_name];
        $file_names = [];
        $upload_path = './uploads/';

        // Si plusieurs fichiers sont téléchargés
        if (!empty($files['name'][0])) {
            for ($i = 0; $i < count($files['name']); $i++) {
                $_FILES['file']['name'] = $files['name'][$i];
                $_FILES['file']['type'] = $files['type'][$i];
                $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['file']['error'] = $files['error'][$i];
                $_FILES['file']['size'] = $files['size'][$i];

                // Configuration du téléchargement
                $this->load->library('upload');
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;  // 2MB
                $config['file_name'] = time() . '-' . $files['name'][$i];  // Nom unique

                $this->upload->initialize($config);

                // Téléchargement
                if ($this->upload->do_upload('file')) {
                    $file_names[] = $upload_path . $this->upload->data('file_name');
                }
            }
        }

        return implode(',', $file_names);  // Retourne les noms de fichiers séparés par une virgule
    }
	public function insert_client()
	{
		$client = $this->input->post('client');
		$site_client = $this->input->post('site_client');
		$email_client = $this->input->post('email_client');
		$numero_client = $this->input->post('numero_client');
		$dejaclient = $this->input->post('dejaclient');
		$budget = $this->input->post('budget');
		$secteur_activite = $this->input->post('secteur_activite');
		$product_choice = $this->input->post('product_choice');
		$initiative = $this->input->post('initiative');
		$am = $this->input->post('am');
		$date_mis_en_place = $this->input->post('date_mis_en_place');
		$date_brief = $this->input->post('date_brief');
		$date_annonce = $this->input->post('date_annonce');
		$logo = $this->file_upload_field = 'logo';

        $idclient = $this->visuels_model->insertclient($client, $site_client, $email_client, $numero_client);
        $this->visuels_model->insertfiche($idclient,$budget,$secteur_activite,$product_choice,$initiative,$am,$date_mis_en_place,$date_brief,$date_annonce,$dejaclient);
		$this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
			redirect('Googleads', 'refresh');
			$this->layout();
	}

	
	public function Admin_brief($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idclients = $ko[0]['idclients'];
		$all = $this->data["all_campagne"] = $this->visuels_model->getAllCampagneById($idclients);
		$all = $this->data["all_campagne"] = $this->visuels_model->getAllgroupeById($idclients);

		$this->data["campagne"] = $this->visuels_model->getCampagneById($idclients);
		
		$this->data["groupe_annonce"] = $this->visuels_model->getGroupe_annonce_briefById($id);

		$t = $this->data["groupe_annonce_pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
		$this->data["groupe_annonce_local"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
	
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
	
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/Admin_brief";
		$this->layout();
		
	}
	public function validation_clients($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idclients = $ko[0]['idclients'];
		$this->data["all_campagne"] = $this->visuels_model->getAllCampagneById($idclients);
		$this->data["all_groupe"] = $this->visuels_model->getAllgroupeById($idclients);
		$this->page = "templates/v3/Vision_client";
		$this->layout();
		
	}
	public function brief($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
	
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/brief";
		$this->layout();
		
	}
	public function ajoutCampagne($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
	
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/ajout_campagne";
		$this->layout();
		
	}


	public function produitselectionner() {
        // Récupérer les données envoyées par POST
        $idonnee = $this->input->post('idonnee');
        $product_choice = $this->input->post('product_choice');
		$this->Donne_modele->update_produit($product_choice,$idonnee);
		$this->session->set_flashdata('message-succes', "Produit mis à jours");
		redirect('Googleads', 'refresh');
		$this->layout();

    }
	public function dejaclient() {
		$id_donnee=$this->input->post('idonnee');
		$decision=$this->input->post('decision');
		$this->Donne_modele->update_dejaclient($decision,$id_donnee);
		$this->session->set_flashdata('message-succes', "Client mis à jours");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	
	public function editclient($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
	
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/edithistorique";
		$this->layout();
		
	}
	public function message($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
	
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/message";
		$this->layout();
		
	}
	public function view($id) {
		$ko = $this->visuels_model->getClientById($id); 
		$ka = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
		$initiative = intval($idinitiative);
		$idam = intval($idam);
		
		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);
		$this->page = "templates/v3/view_client";
		$this->layout();
		
	}
	public function updateinformationClient() {
		$idonnee = $this->input->post('idonnee');
		$secteur_activite = $this->input->post('secteur_activite');
		$information_client = $this->input->post('information_client');
		$contexte_client = $this->input->post('contexte_client');
		$tracking_gtm = $this->input->post('tracking_gtm');
		$commentaire = $this->input->post('commentaire');
		$information_complementaire = $this->input->post('information_complementaire');
		
		$logo = $this->file_upload_field = 'logo';
		
		$logo = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {
				
			$logo = $this->path . $this->upload->file_name;
			}
			if ($logo != NULL) {
				$idclients = $this->Donne_modele->updateinformation($idonnee, $secteur_activite, $information_client, $contexte_client,$tracking_gtm,$commentaire,$information_complementaire);
				$this->Donne_modele->updatelogo($idclients, $logo);
			} else {
				$idclients = $this->Donne_modele->updateinformation($idonnee, $secteur_activite, $information_client, $contexte_client,$tracking_gtm,$commentaire,$information_complementaire);
			}
			
		$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
		redirect('Googleads/Admin_brief/'. $idonnee, 'refresh');
	}
	
	public function updateDonneeClient() {
		// Récupération des données du formulaire
		$idclient = $this->input->post('idclient');
		$idonnee = $this->input->post('idonnee');
		$client = $this->input->post('Client');
		$email_client = $this->input->post('Email_client');
		$numero_client = $this->input->post('Numero_client');
		$site_client = $this->input->post('Site_client');
		$budget = $this->input->post('budget');
		$secteur_activite = $this->input->post('secteur_activite');
		$Produit = $this->input->post('Produit');
		$Initiative = $this->input->post('Initiative');
		$Am = $this->input->post('Am');
		$mis_en_place_paiement = $this->input->post('mis_en_place_paiement');
		$Brief = $this->input->post('Brief');
		$annonce = $this->input->post('annonce');
		$commentaire_client = $this->input->post('commentaire_client');
		if($commentaire_client == NULL){
			$commentaire_client = NULL;
		}
		if($commentaire_client != NULL){
			$commentaire_client = $this->input->post('commentaire_client');
		}
		
		$this->Donne_modele->update_client($idclient, $client, $email_client, $numero_client, $site_client);
		$this->Donne_modele->update_donnee_client($budget,$secteur_activite, $Produit, $Initiative, $Am, $mis_en_place_paiement, $Brief, $annonce,$commentaire_client, $idonnee);
		$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
		redirect('Googleads', 'refresh');
	}
	
	
		public function update_produit($idonnee){
			
			$idonnee=$this->input->post('idonnee');
			$product_id=$this->input->post('product_id');
			$this->visuels_model->update_produit_client($product_id,$idonnee);
			$this->session->set_flashdata('message-succes', "Donnée Mise a jour avec succès");
			redirect('Googleads', 'refresh');
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
		redirect('Googleads', 'refresh');
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
