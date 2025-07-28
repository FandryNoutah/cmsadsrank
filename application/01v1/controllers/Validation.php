<?php

class Validation extends CI_Controller {
    function __construct() {
        parent::__construct();
        // Suppression de la bibliothèque ion_auth et de tout code lié à l'authentification
        $this->load->library(array('form_validation')); // Conserver les bibliothèques nécessaires pour la validation des formulaires
        $this->load->helper(array('url','language'));
        $this->load->model("panneau_model");
        $this->load->model("Image_model");
        $this->load->model('MaBase');
        $this->load->model('Data_modele');
        $this->load->model('Donne_modele');
        $this->load->library('upload');
        $this->load->model('visuels_model'); // Ajout du modèle visuels_model si nécessaire
        $this->load->helper(array('form', 'url'));
		$this->load->library('curl');
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		
		$this->load->library('upload');
        $this->load->library('form_validation');
        // Si vous avez des règles   de validation de formulaire spécifiques, vous pouvez les conserver
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        // Chargement des traductions nécessaires (si des textes sont à afficher en plusieurs langues)
        $this->lang->load('auth');
    }
        public function index()
        {
            $this->load->view("templates/v3/Datastudio", $this->data);
        }
        public function gestion_image($id) {
            $data['idgroupe_annone'] = $id;
            $b = $data['clients'] = $this->Image_model->getgroupe_annonce($id);
            
            $a = $data['images'] = $this->Image_model->get_images_by_id($id);
            

            $this->load->view('image_list2', $data);
        
        }public function add_image() {
            // On récupère l'URL de l'image si elle est envoyée
            $image = $this->input->post('image');
            $id = $this->input->post('idgroupe_annone');
            $idclients = $this->input->post('idclients');
    
            // Vérification et téléchargement du logo
            if ($_FILES['image']['name'] != '') {
                $this->upload->initialize($this->set_upload_options("", $_FILES["image"]["name"]));
                if ($this->upload->do_upload('image')) {
                    $image_url = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
                }
            }
            $idimage = $this->Image_model->insert_image($image_url,$idclients, 0);
            $this->Image_model->insertidgroupeimage($idimage, $id);
            redirect('Validation/gestion_image/'.$id, 'refresh');
        }
   
        
        // Ajouter une image depuis une URL
        public function add_image_url() {
            $image_url = $this->input->post('image_url');
            $id = $this->input->post('idgroupe_annone');
            $idclients = $this->input->post('idclients');
        
            // Vérifier que l'URL n'est pas vide
            if (!empty($image_url)) {
                // Vérifier si l'URL est valide
                if (@getimagesize($image_url)) {
                    // Si l'URL est valide et pointe vers une image, insérer dans la base de données
                    $idimage = $this->Image_model->insert_image($image_url,$idclients, 0);
                    $this->Image_model->insertidgroupeimage($idimage, $id);
                    redirect('Validation/gestion_image/'.$id);
                } else {
                    echo "Ce n'est pas une image valide.";
                }
            } else {
                echo "L'URL ne peut pas être vide.";
            }
        }
        
    
        // Supprimer une image
        public function delete_image($id) {
            $idgroupe_annonce = $this->Image_model->get_idgroupe_annonceimage($id);
            
            $this->Image_model->delete_image($id);
            $id = $idgroupe_annonce;
            redirect('Validation/gestion_image/' . $id);
        }
    
        // Mettre à jour l'ordre des images
        public function update_order() {
            // Récupérer l'ordre des images envoyé via AJAX
            $order = json_decode($this->input->post('order'));
    
            // Mettre à jour l'ordre des images dans la base de données
            foreach ($order as $index => $id) {
                $this->Image_model->update_rank($id, $index + 1);  // Le rang commence à 1
            }
    
            echo json_encode(['status' => 'success']);
        }
    

        public function validation_structure($id) {
            // Récupérer les données des campagnes
            $donnees_valider = $this->Donne_modele->getclientvalidation($id);
            
            // Récupérer les groupes d'annonces
            $groupes_valider = $this->Donne_modele->getgroupevalidation($id);
        
            // Regrouper les groupes d'annonces par campagne
            foreach ($donnees_valider as &$campagne) {
                // Initialiser un tableau pour les groupes d'annonces de cette campagne
                $campagne['groupes_annonces'] = [];
        
                // Ajouter les groupes d'annonces qui appartiennent à cette campagne
                foreach ($groupes_valider as $groupe) {
                    if ($groupe['idcampagne'] == $campagne['idcampagne']) {
                        $campagne['groupes_annonces'][] = $groupe;
                    }
                }
            }
        
            // Passer les données à la vue
            $this->data["donne_valider"] = $donnees_valider;
            $t = $this->data["extensions"] = $this->visuels_model->getallextensionsByIdc($id); 
            $this->data["groupe_valider"] = $groupes_valider;
            $a = $this->Donne_modele->getpmaxvalider($id);
            $idgroupe_annonce = $a[0]['idgroupe_annonce'];
           
            $idgroupe_annonce = intval($idgroupe_annonce);
            
            $id = intval($id);
       
		    $g = $this->data["images"] = $this->Image_model->get_images_by_clients($id,$idgroupe_annonce);
            $this->load->view("templates/v3/Validation_structure", $this->data);
        }
        
        public function editcampagne($id) {
            // Récupérer les données de la campagne
            $t = $this->data["campagne"] = $this->visuels_model->getCAMPAGNEByIdc($id); 
            $t = $t[0]['idcampagne'];
        
            // Récupérer les groupes d'annonces
            $q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdg($id); 
        
            // Charger la vue pour éditer la campagne
            $this->load->view("templates/v3/edit_campagne_structure", $this->data);
        }


        public function editgroupesearch($id) {
            $this->data["campagne"] = $this->visuels_model->getCampagneById($id);
            $this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
            $ko = $this->visuels_model->getClientById($id); 
            $this->data["donnees"] = $this->visuels_model->getDonneeById($id);
            $this->data["client"] = $ko;
            $t = $this->data["groupe"] = $this->visuels_model->getgpid($id); 
        
            $this->load->view("templates/v3/edit_groupe_structure_search", $this->data);
        }
        public function editgroupelocal($id) {
            $this->data["campagne"] = $this->visuels_model->getCampagneById($id);
            $this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
            $ko = $this->visuels_model->getClientById($id); 
            $this->data["donnees"] = $this->visuels_model->getDonneeById($id);
            $this->data["client"] = $ko;
            $t = $this->data["groupe"] = $this->visuels_model->getgpid($id); 
        
            $this->load->view("templates/v3/edit_groupe_structure_local", $this->data);
        }
        public function editgroupepmax($id) {
            $this->data["campagne"] = $this->visuels_model->getCampagneById($id);
            $this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
            $ko = $this->visuels_model->getClientById($id); 
            $this->data["donnees"] = $this->visuels_model->getDonneeById($id);
            $this->data["client"] = $ko;
            $t = $this->data["groupe"] = $this->visuels_model->getgpid($id); 
        
            $this->load->view("templates/v3/edit_groupe_structure_local", $this->data);
        }
        public function editgroupe($id) {
            $q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdgs($id); 
        
            // Charger la vue pour éditer la campagne
            $this->load->view("templates/v3/edit_groupe_structure", $this->data);
        }
        public function save_groupe_search() {
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
				'url_groupe_annonce' => $url
			];
	
			// Appeler la fonction de mise à jour dans le modèle
			$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
			redirect('Validation/validation_structure/' . $idclients);
		}

        public function save_groupe_local() {
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
			$description_breve = $this->input->post('description_breve');
			$url = $this->input->post('url');
	
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
				'description_breve' => $description_breve,
				'url_groupe_annonce' => $url
			];
	
			// Appeler la fonction de mise à jour dans le modèle
			$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
			redirect('Validation/validation_structure/' . $idclients);
		}
        public function save_groupe_pmax() {
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
			$description_breve = $this->input->post('description_breve');
			$url = $this->input->post('url');
	
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
				'description_breve' => $description_breve,
				'url_groupe_annonce' => $url
			];
	
			// Appeler la fonction de mise à jour dans le modèle
			$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
			redirect('Validation/validation_structure/' . $idclients);
		}
        public function updateDonneeClient() {
            // Récupérer les données postées
            $idcampagne = $this->input->post('idcampagne');
            $idgroupe_annonce = $this->input->post('idgroupe_annonce');
            $id = $this->input->post('idclients');
            $zones = $this->input->post('zones');
            $date_campagne = $this->input->post('date_campagne');
            $nom_groupe = $this->input->post('nom_groupe');    
            $appareil = $this->input->post('appareil');
            $budget = $this->input->post('budget');
            $nom_campagne = $this->input->post('nom_campagne');
            $mot_cle = $this->input->post('mot_cle');

            $this->visuels_model->updatescampagnes($zones, $date_campagne, $appareil, $budget, $idcampagne);
            $this->visuels_model->updatesgroupe($nom_groupe, $mot_cle, $idgroupe_annonce);
        
            // Rediriger vers la méthode validation_structure avec l'id du client
            redirect('Validation/validation_structure/' . $id);
        }
        public function updateDonneeClients() {
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
        
            // Mettre à jour les données de la campagne et des groupes d'annonces
            $this->visuels_model->updatescampagne($zones, $date_campagne, $appareil, $budget, $idcampagne);
            $this->visuels_model->updatesgroupe($nom_groupe, $mot_cle, $idgroupe_annonce);
        
            // Rediriger vers la méthode validation_structure avec l'id du client
            redirect('Validation/validation_structure/' . $id);
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