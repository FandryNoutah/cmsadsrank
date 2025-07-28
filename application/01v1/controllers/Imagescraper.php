<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageScraper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('curl');
        $this->load->model('Data_modele');
        $this->load->model('Image_model'); // Charger le modèle pour la base de données
    }

    public function index() {
        $data['images'] = [];

        // Vérifier si une URL a été soumise
        if ($this->input->post('url')) {
            $url = $this->input->post('url');
            $data['images'] = $this->scrape_images($url);
        }

        // Si des images ont été sélectionnées, les enregistrer dans la base de données
        if ($this->input->post('selected_images')) {
            $selected_images = $this->input->post('selected_images');
            $this->save_images_to_db($selected_images);
        }

        $this->load->view('image_scraper_view', $data);
    }
    public function vie($id) {
            $data['id'] = $id;
            $idclients = $this->Data_modele->getidclient($id);
            $idclients = $idclients[0];
            $idclients = $idclients['idclients'];
            $idclients = intval($idclients); // Conversion en entier pour éviter des problèmes de sécurité
    
            // Chargement des données du client
          

            $data['images'] = [];

        // Vérifier si une URL a été soumise
        if ($this->input->post('url')) {
            $url = $this->input->post('url');
            $data['images'] = $this->scrape_images($url);
        }

        // Si des images ont été sélectionnées, les enregistrer dans la base de données
        if ($this->input->post('selected_images')) {
            $selected_images = $this->input->post('selected_images');
            $this->save_images_to_db($selected_images);
        }
        $data['client'] = $this->Data_modele->getclient($idclients);
        $this->load->view('image_scraper_view', $data);
    }
    public function vie2($id) {
        $data['id'] = $id;
        $idclients = $this->Data_modele->getidclient($id);
        $idclients = $idclients[0];
        $idclients = $idclients['idclients'];
        $idclients = intval($idclients); // Conversion en entier pour éviter des problèmes de sécurité

        // Chargement des données du client
      

        $data['images'] = [];

    // Vérifier si une URL a été soumise
    if ($this->input->post('url')) {
        $url = $this->input->post('url');
        $data['images'] = $this->scrape_images($url);
    }

    // Si des images ont été sélectionnées, les enregistrer dans la base de données
    if ($this->input->post('selected_images')) {
        $selected_images = $this->input->post('selected_images');
        $this->save_images_to_db($selected_images);
    }
    $data['client'] = $this->Data_modele->getclient($idclients);
    $this->load->view('image_scraper_view2', $data);
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
}
