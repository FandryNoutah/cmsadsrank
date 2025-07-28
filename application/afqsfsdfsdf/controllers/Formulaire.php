<?php
use GuzzleHttp\Client;

class Formulaire extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Si Guzzle n'est pas encore installé, tu peux le faire via Composer
        // Assure-toi que le chemin de autoload est correct
        $this->load->library('session'); // Charger la session si nécessaire
        $this->load->helper('url'); // Charger l'helper URL si nécessaire
    }

	public function generer_titre_ai() {
		header('Content-Type: application/json');
		$apiKey = 'VOTRE_CLE_API_OPENAI';
		$prompt = "Génère un titre court (moins de 30 caractères) pour une annonce Google Ads dans le domaine du marketing digital.";
	
		try {
			$client = new \GuzzleHttp\Client();
			
			$response = $client->post('https://api.openai.com/v1/chat/completions', [
				'headers' => [
					'Authorization' => 'Bearer ' . $apiKey,
					'Content-Type' => 'application/json',
				],
				'json' => [
					'model' => 'gpt-3.5-turbo',
					'messages' => [['role' => 'user', 'content' => $prompt]],
					'max_tokens' => 60,
					'temperature' => 0.7
				]
			]);
	
			// Log de la réponse brute
			$responseBody = $response->getBody()->getContents();
			log_message('debug', 'Réponse API OpenAI : ' . $responseBody);
	
			// Décodage de la réponse JSON
			$body = json_decode($responseBody, true);
	
			if (isset($body['choices'][0]['message']['content'])) {
				$titre = trim($body['choices'][0]['message']['content']);
				echo json_encode(['success' => true, 'titre' => $titre]);
			} else {
				throw new Exception('Réponse invalide de l\'API');
			}
		} catch (Exception $e) {
			// Log de l'erreur
			log_message('error', 'Erreur API OpenAI : ' . $e->getMessage());
			echo json_encode(['success' => false, 'error' => $e->getMessage()]);
		}
	}
	
	

    // Exemple de méthode pour enregistrer les titres (si nécessaire)
    public function enregistrer() {
        // Exemple de traitement à faire pour enregistrer les titres
        if ($this->input->method() === 'post') {
            $data = [];
            for ($i = 1; $i <= 12; $i++) {
                $data["titre$i"] = $this->input->post("titre$i");
            }

            // Traitement et redirection après enregistrement
            // À adapter selon la logique de ton application
            $this->load->view('formulaire_view', ['D' => $data]);
        }
    }
}
