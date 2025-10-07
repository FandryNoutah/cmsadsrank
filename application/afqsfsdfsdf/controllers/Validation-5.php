<?php

class Validation extends CI_Controller {
    function __construct() {
        parent::__construct();
        // Suppression de la bibliothèque ion_auth et de tout code lié à l'authentification
        $this->load->library(array('form_validation')); // Conserver les bibliothèques nécessaires pour la validation des formulaires
        $this->load->helper(array('url','language'));
        $this->load->model("panneau_model");
        $this->load->model('MaBase');
        $this->load->model('Data_modele');
        $this->load->model('Donne_modele');
        $this->load->model('visuels_model'); // Ajout du modèle visuels_model si nécessaire

        // Si vous avez des règles de validation de formulaire spécifiques, vous pouvez les conserver
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        // Chargement des traductions nécessaires (si des textes sont à afficher en plusieurs langues)
        $this->lang->load('auth');
    }
        public function index()
        {
            $this->load->view("templates/v3/Datastudio", $this->data);
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
            $this->data["groupe_valider"] = $groupes_valider;
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


        public function editgroupe($id) {
            $q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdgs($id); 
        
            // Charger la vue pour éditer la campagne
            $this->load->view("templates/v3/edit_groupe_structure", $this->data);
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
        
            // Mettre à jour les données de la campagne et des groupes d'annonces
            $this->visuels_model->updatescampagne($zones, $date_campagne, $appareil, $budget, $idcampagne);
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
        
        
        
		
		
}