<?php

class Validation_client extends CI_Controller {
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
        public function view($id) {
            // On récupère l'id du client à partir de l'id passé en paramètre
            $this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id);
            $this->load->view("templates/v3/Validation_client", $this->data);
        }
		
		
}