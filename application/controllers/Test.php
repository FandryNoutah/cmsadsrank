<?php 
class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Charger la bibliothèque 'curl' et le helper 'url' de CI
        $this->load->helper('url');
    }

public function index() {
    // Récupération du nom de domaine ou de l'URL soumise via le formulaire
    $domain_name = $this->input->post('domain_name');

    // Récupérer le contenu HTML de la page
    $html = $this->get_html_from_url($domain_name); // Implémenter cette méthode

    // Extraire les images
    $images = $this->extract_images($html, $domain_name);

    // Charger la vue et passer les variables
    $data['html'] = $html;   // Passez la variable $html à la vue
    $data['images'] = $images;

    $this->load->view('test', $data);
}


    // Fonction pour récupérer le contenu HTML d'un site
    private function fetch_html($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);
        
        return $html;
    }

// Fonction pour extraire les images depuis le HTML
private function extract_images($html, $url) {
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);

    $images = [];
    foreach ($matches[1] as $src) {
        // Si l'URL est relative, la rendre absolue
        $image_url = (filter_var($src, FILTER_VALIDATE_URL)) ? $src : base_url($src);
        
        // Vérifier si l'URL est valide et bien formée
        $image_url = $this->make_absolute_url($image_url, $url);
        
        // Ajouter l'URL de l'image à la liste
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            $images[] = $image_url;
        }
    }

    return $images;
}

private function get_html_from_url($url) {
    // Récupérer le contenu HTML de l'URL
    $response = file_get_contents($url);

    // Vérifiez si la réponse est vide ou s'il y a eu une erreur
    if ($response === false) {
        // Si l'URL ne peut pas être récupérée, retourner une chaîne vide ou un message d'erreur
        return "Erreur lors de la récupération du contenu.";
    }

    return $response;
}

    // Fonction pour transformer une URL relative en URL absolue
    private function make_absolute_url($src, $base_url) {
        if (filter_var($src, FILTER_VALIDATE_URL)) {
            return $src;
        }
        return base_url() . ltrim($src, '/');
    }
}
