<?php

class Datastudio extends CI_Controller {
    function __construct() {
        parent::__construct();
        // Suppression de la bibliothèque ion_auth et de tout code lié à l'authentification
        $this->load->library(array('form_validation')); // Conserver les bibliothèques nécessaires pour la validation des formulaires
        $this->load->helper(array('url','language'));
        $this->load->model("panneau_model");
        $this->load->model('MaBase');
        $this->load->model('Data_modele');
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
        public function datastudios($id) {
            // On récupère l'id du client à partir de l'id passé en paramètre
            $idclients = $this->Data_modele->getidclient($id);
            $idclients = $idclients[0];
            $idclients = $idclients['idclients'];
            $idclients = intval($idclients); // Conversion en entier pour éviter des problèmes de sécurité
    
            // Chargement des données du client
            $this->data["client"] = $this->Data_modele->getclient($idclients);
             $this->data["campagne_client"] = $this->Data_modele->getcampagne_client($idclients);
            $this->data["donnee_client"] = $this->Data_modele->getdonnee_client($idclients);
           
            $t = $this->data["groupe_client"] = $this->Data_modele->getgroupe_client($idclients);
           
            // Ajout des données pour les visuels du groupe d'annonces
            $this->data["pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
    
            // Affichage de la vue DataStudio avec les données chargées
            $this->load->view("templates/v3/Datastudio", $this->data);
        }
		
		
}