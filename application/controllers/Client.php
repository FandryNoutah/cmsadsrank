<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends MY_Controller
{
	private $api_url = 'https://api.aircall.io/v1/calls';
	private $api_auth = 'e69c2f6c77144ad053a54bf77088aa09:6ab56a32536bc017ed6b2adb619338e0';
	protected $file_upload_field;

	public function __construct()
	{
		parent::__construct();

		$this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
		$this->load->model("Data_modele");
		$this->load->model("Image_model");
		$this->load->model("Message_model");
		$this->load->model("Task_model");
		$this->data['visuels'] = $this->visuels_model->get_all();
		// $this->load->library('PHPExcel');
		// $this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('curl');
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";

		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}

	public function index()
	{
		$this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$this->data['users'] = $this->Task_model->get_all_users();
		$this->data['produit'] = $this->Donne_modele->get_all_produit();
		$this->data['am'] = $this->Donne_modele->get_all_am();
		$this->data['initiative'] = $this->Donne_modele->get_all_initiative();

		$this->content = "layouts/client/index.php";
		$this->layout();
	}
	public function search() {
    $term = "Jean"; // remplace par un nom réel présent dans la base
    $clients = $this->visuels_model->search_clients($term);

    $result = [];
    foreach ($clients as $client) {
        $result[] = [
            'idclients' => $client->idclients,
            'nom_client' => $client->nom_client
        ];
    }

    echo json_encode($result);
}
public function tache_client($idclients)
	{
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$t = $this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$this->content = "layouts/client/detail/tache/index.php";
		$this->layout();
	}


public function application($idclients)
	{
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$t = $this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$this->content = "layouts/client/detail/application/index.php";
		$this->layout();
	}
	public function activer_processus_tache()
	{
		var_dump("tache");
		die();
	}

	public function detail_client($idclients)
	{
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$t = $this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$t = count($t);
		$this->data['nbr_task'] = $t;
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$numero_client = $clients[0]['numero_client'];
		$numero_am = $clients[0]['am_phone'];
		
		$calls = $this->get_all_calls();

		// Numéros à comparer (normalisés)
		$my_number = $numero_am;
		$client_number = $numero_client;
		$count = 0;
		$matched_calls = [];

		// Parcours des appels
		foreach ($calls as $call) {
			$aircall_number = isset($call->number->digits) ? preg_replace('/\D/', '', $call->number->digits) : '';
			$external_number = isset($call->raw_digits) ? preg_replace('/\D/', '', $call->raw_digits) : '';

			if (
				($aircall_number === $my_number && $external_number === $client_number) ||
				($aircall_number === $client_number && $external_number === $my_number)
			) {
				$count++;
				$matched_calls[] = $call;
			}
		}

		$this->data["call_count"] = $count;
		$this->data['matched_calls'] = $matched_calls;

		$latestByMonth = [];

		$clientUpsells = $this->visuels_model->getupsell();
		foreach ($clientUpsells as $upsell) {

			$monthIndex = (int)date('n', strtotime($upsell->date_upsell)) - 1; // 0-based index
			$dateTimestamp = strtotime($upsell->date_upsell);

			// Keep only latest date per month
			if (!isset($latestByMonth[$monthIndex]) || $dateTimestamp > strtotime($latestByMonth[$monthIndex]['date'])) {
				$latestByMonth[$monthIndex] = [
					'date' => $upsell->date_upsell,
					'budget' => $upsell->budgets
				];
			}
		}

		$chartData = array_fill(0, 12, 0);
		$tooltipData = array_fill(0, 12, []);
		
		foreach ($latestByMonth as $monthIndex => $data) {
			$chartData[$monthIndex] = $data['budget'];
			$tooltipData[$monthIndex][] = [
				'date' => date('d M Y', strtotime($data['date'])),
				'budget' => $data['budget']
			];
		}
		
		$this->data['chartData'] = json_encode($chartData);
		$this->data['tooltipData'] = json_encode($tooltipData);

		$this->content = "layouts/client/detail/index.php";
		$this->layout();
	}

	public function creer_upsell()
	{
		$type_upsell = $this->input->post('type_upsell');
		$demmande_upsell = $this->input->post('demmande_upsell');
		$budget_upsell = $this->input->post('budget_upsell');
		$idclients = $this->input->post('client');
		$tm = $this->input->post('tm');
		$date_upsell = $this->input->post('date_upsell');
		$date_demande_upsell = $this->input->post('date_demande_upsell');
		$inforamtion_upsell = $this->input->post('information_upsell');
		$statut_upsell = $this->input->post('statut_upsell');
		$id = $idclients;
		$donnee = $this->data["clients"] = $this->visuels_model->getDonneeById($id);
		$idonnee = $donnee[0]['idonnee'];
		$buget_initiale = $donnee[0]['budget'];
		if ($type_upsell == 2):
			$am = $this->input->post('am');
			$budget_initiale = $this->input->post('budget_initiale');
			//$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_upsell, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients);
			$budget_initiale = intval($budget_initiale);
			$budget_upsell = intval($budget_upsell);
			$budget_finale = $budget_upsell + $budget_initiale;
			//var_dump($budget_finale );die();
			//$this->visuels_model->update_budget($budget_finale, $idclients);
			//$date_brief = 0000 - 00 - 00;
			//$campagne_actif = 0;
			//$lien_datastudio = 0;
			//$validation_technique = 0000 - 00 - 00;
			//$date_validation_structure = 0000 - 00 - 00;
			//$this->visuels_model->update_brief($date_brief, $campagne_actif, $validation_technique, $date_validation_structure, $lien_datastudio, $idclients);
			$actif = 1;
			$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients,$actif);
			$type_tache = 1; 
			$title = "Upsell";
			$tache = "Le client fait une upsell";
			$Statuts_technique = 1;
			
			$data = array(
				'type_tache' => $type_tache,
				'date_demande' => $date_demande_upsell,
				'date_due' => $date_demande_upsell,
				'idclients' => $idclients,
				'AM' => $am,
				'assigned_to' => $tm,
				'title' => $title,
				'Statuts_technique' => $Statuts_technique,
				'description' => $tache

			);

		$this->Task_model->add_task($data);
		endif;
		if ($type_upsell == 1):
			$am = $this->input->post('am');
			$budget_initiale = $this->input->post('budget_initiale');
			//$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_upsell, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients);
			$budget_initiale = intval($budget_initiale);
			$budget_upsell = intval($budget_upsell);
			$budget_finale = $budget_initiale - $budget_upsell;
			//var_dump($budget_finale );die();
			//$this->visuels_model->update_budget($budget_finale, $idclients);
			//$date_brief = 0000 - 00 - 00;
			//$campagne_actif = 0;
			//$lien_datastudio = 0;
			//$validation_technique = 0000 - 00 - 00;
			//$date_validation_structure = 0000 - 00 - 00;
			//$this->visuels_model->update_brief($date_brief, $campagne_actif, $validation_technique, $date_validation_structure, $lien_datastudio, $idclients);
			$type_tache = 1; 
			$title = "Baisse";
			$tache = "Le client fait une baisse";
			$Statuts_technique = 1;
			$actif = 1;
			$data = array(
				'type_tache' => $type_tache,
				'date_demande' => $date_demande_upsell,
				'date_due' => $date_demande_upsell,
				'idclients' => $idclients,
				'AM' => $am,
				'assigned_to' => $tm,
				'title' => $title,
				'Statuts_technique' => $Statuts_technique,
				'description' => $tache
			);

			$this->Task_model->add_task($data);
			$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients,$actif);


		endif;
		//if ($type_upsell == 3):
			//$am = $this->input->post('am');
			//$am = $demmande_upsell;
			//$budget_initiale = $this->input->post('budget_initiale');
			//$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_upsell, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients);

		//endif;
		$this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
		redirect('Client/detail_client/' . $idclients, 'refresh');


		$this->layout();
	}
	private function get_all_calls()
	{
		$all_calls = [];
		$page = 1;

		do {
			$url = $this->api_url . '?page=' . $page;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_auth);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			$response = curl_exec($ch);
			curl_close($ch);

			$data = json_decode($response);
			if (isset($data->calls)) {
				$all_calls = array_merge($all_calls, $data->calls);
			}

			$has_more = isset($data->meta->next_page_link);
			$page++;
		} while ($has_more);

		return $all_calls;
	}

	public function test_api_connection()
	{
		$url = $this->api_url . '?per_page=1'; // On limite à 1 appel pour le test

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $this->api_auth);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpcode === 200) {
			echo "✅ Connexion API réussie !<br>";
			echo "<pre>" . print_r(json_decode($response), true) . "</pre>";
		} else {
			echo "❌ Échec de la connexion à l'API. Code HTTP : $httpcode<br>";
			echo "Réponse brute :<br><pre>$response</pre>";
		}
	}

	public function insert_client()
	{
		$client = $this->input->post('client');
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
		

		$this->form_validation->set_rules('site_client', 'URL', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			die('Validation échouée : champ site_client requis');
		}

		$site_client = trim($this->input->post('site_client'));
		if (!preg_match('#^https?://#i', $site_client)) {
			$site_client = 'https://' . $site_client;
		}

		$html = $this->fetch_url($site_client);
		if ($html === false) {
			die("Erreur : impossible d'accéder à l'URL $site_client");
		}

		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		libxml_clear_errors();

		$xpath = new DOMXPath($dom);

		// ✅ Extraire les titres et paragraphes
		$paragraphs = [];
		$p_nodes = $xpath->query("//p");
		foreach ($p_nodes as $p) {
			$text = trim($p->textContent);
			if (!empty($text)) {
				$paragraphs[] = $text;
			}
		}

		$headings = [];
		for ($i = 1; $i <= 6; $i++) {
			$h_nodes = $xpath->query("//h$i");
			foreach ($h_nodes as $h) {
				$text = trim($h->textContent);
				if (!empty($text)) {
					$headings[] = [
						'tag' => "h$i",
						'text' => $text
					];
				}
			}
		}

		// ✅ Générer le résumé avec ChatGPT
		$summary = $this->get_summary_from_chatgpt($headings, $paragraphs);

		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		$cms = $this->detect_cms($html, $site_client);
		$cms_logo = $this->get_cms_logo($cms);
		$favicon = $this->get_favicon($html, $site_client);

		// ✅ Insérer le résumé à la place du paragraphe le plus long
		$idclient = $this->visuels_model->insertclient($client, $site_client, $email_client, $numero_client, $favicon, $cms, $cms_logo, $summary);
		$this->visuels_model->insertfiche($idclient, $budget, $secteur_activite, $product_choice, $initiative, $am, $date_mis_en_place, $date_brief, $date_annonce, $dejaclient, $gtm_code);
		$title = "Création de Brief";
			$tache = "En attente de brief";
			$Statuts_technique = 1;
			$type_tache = 1;
			$data = array(
				'type_tache' => $type_tache,
				'date_demande' => $date_mis_en_place,
				'date_due' => $date_brief,
				'idclients' => $idclient,
				'AM' => $am,
				'assigned_to' => $initiative,
				'title' => $title,
				'Statuts_technique' => $Statuts_technique,
				'description' => $tache
			);

		$this->Task_model->add_task($data);
		$type_upsell = 1;
		$budget_finale = $budget;
		$budget_initiale = $budget;
		$statut_upsell = 1;
		$idclients = $idclient;
		$demmande_upsell = $am;
		$am = $am;
		$tm = $am;
		$actif = 0;
		$date_upsell = $date_mis_en_place;
		$date_demande_upsell = $date_mis_en_place;
		$inforamtion_upsell = "Budget initial";
		$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients,$actif);

		redirect('Client');
	}
	private function get_summary_from_chatgpt($headings, $paragraphs)
	{
		$api_key = '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'; // 🔐 Remplace avec ta clé
		$model = 'gpt-4'; // ou 'gpt-3.5-turbo'

		$input_text = "Voici les titres et paragraphes d’un site web. Résume ce que fait ce site, son activité, son objectif ou secteur, en **deux paragraphes distincts, séparés par une ligne vide**.\n\n";
		$input_text .= "Titres :\n";
		foreach ($headings as $h) {
			$input_text .= "- ({$h['tag']}) {$h['text']}\n";
		}
		$input_text .= "\nParagraphes :\n";
		foreach (array_slice($paragraphs, 0, 10) as $p) {
			$input_text .= "- $p\n";
		}

		$data = [
			"model" => $model,
			"messages" => [
				["role" => "user", "content" => $input_text]
			],
			"temperature" => 0.7
		];

		$ch = curl_init('https://api.openai.com/v1/chat/completions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . $api_key
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'Erreur OpenAI : ' . curl_error($ch);
		}

		curl_close($ch);
		$result = json_decode($response, true);
		return $result['choices'][0]['message']['content'] ?? 'Résumé non disponible.';
	}


	// Fonction cURL pour récupérer le contenu HTML
	private function fetch_url($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // À activer en prod si possible
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MyBot/1.0)');

		$response = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($response === false || $code >= 400) {
			return false;
		}

		return $response;
	}

	// Reste de tes méthodes detect_cms(), get_cms_logo(), get_favicon() inchangées



	private function detect_cms($html, $url)
	{
		if (preg_match('/<meta name=["\']generator["\'] content=["\']([^"\']+)["\']/', $html, $match)) {
			return $match[1];
		}
		if (strpos($html, '/wp-content/') !== false || strpos($html, 'wp-') !== false) {
			return 'WordPress';
		} elseif (strpos($html, 'Joomla') !== false || strpos($html, '/administrator/') !== false) {
			return 'Joomla';
		} elseif (strpos($html, '/sites/default/') !== false) {
			return 'Drupal';
		} elseif (strpos($html, 'Shopify') !== false || strpos($html, 'cdn.shopify.com') !== false) {
			return 'Shopify';
		} elseif (strpos($html, 'Magento') !== false || strpos($html, 'mage/') !== false) {
			return 'Magento';
		}
		$headers = @get_headers($url, 1);
		if ($headers && isset($headers['X-Powered-By'])) {
			return $headers['X-Powered-By'];
		}

		return 'Inconnu ou non détectable automatiquement';
	}
	private function get_cms_logo($cms_name)
	{
		$cms_logos = [
			'WordPress' => 'wordpress.png',
			'Joomla' => 'joomla.png',
			'Drupal' => 'drupal.png',
			'Shopify' => 'shopify.png',
			'Magento' => 'magento.png'
		];

		foreach ($cms_logos as $key => $file) {
			if (stripos($cms_name, $key) !== false) {
				return base_url('assets/images/cms/' . $file);
			}
		}

		return base_url('assets/images/cms/unknown.png');
	}
	private function get_favicon($html, $url)
	{
		if (preg_match('/<link[^>]+rel=["\'](?:shortcut icon|icon)["\'][^>]+href=["\']([^"\']+)["\']/i', $html, $matches)) {
			$favicon = $matches[1];
			if (parse_url($favicon, PHP_URL_SCHEME) === null) {
				$parsed_url = parse_url($url);
				$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] : 'https';
				$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
				$base = "$scheme://$host";
				$favicon = (substr($favicon, 0, 1) === '/') ? $base . $favicon : $base . '/' . $favicon;
			}

			return $favicon;
		}
		$parsed_url = parse_url($url);
		$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] : 'https';
		$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		return "$scheme://$host/favicon.ico";
	}
}
