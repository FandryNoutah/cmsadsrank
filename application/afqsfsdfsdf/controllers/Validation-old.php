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
            $this->data["groupe_valider"] = $this->Donne_modele->getgroupevalidation($id);
            // Passer les données à la vue
            $this->data["donne_valider"] = $donnees_valider;
            $this->load->view("templates/v3/Validation_structure", $this->data);
        }
        public function editcampagne($id) {
          
			$t = $this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 
            $t = $t[0]['idcampagne'];
            $t = $this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 
            var_dump($t);
            die();
			$this->load->view("templates/v3/edit_groupe_annonce", $this->data);
			
		}
        
        
		
		
}