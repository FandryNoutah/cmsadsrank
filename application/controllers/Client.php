<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends MY_Controller
{
	private $api_url = 'https://api.aircall.io/v1/calls';
	private $api_auth = '';
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
		$this->load->model("Note_model");
		$this->load->model("Discussion_model");
		$this->load->model("Gtm_model");
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
		$this->current_user = $this->ion_auth->user()->row();
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
	public function Ajoutgroupes()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idcampagne = $this->input->post('idcampagne');
		$idclients = $this->input->post('idclients');
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$titres = is_array($this->input->post('titres')) ? $this->input->post('titres') : [];
		$titres_longs = is_array($this->input->post('titres_longs')) ? $this->input->post('titres_longs') : [];
		$descriptions = is_array($this->input->post('descriptions')) ? $this->input->post('descriptions') : [];

		$statut = 1;

		$data = array(
			'idgroupe_annonce' => $idgroupe_annonce,
			'idcampagne'       => $idcampagne,
			'idclients'        => $idclients,
			'chemin1'          => $chemin1,
			'chemin2'          => $chemin2,
			'statut'           => $statut
		);

		for ($i = 0; $i < 12; $i++) {
			$data['titre' . ($i + 1)] = $titres[$i] ?? null;
		}

		for ($i = 0; $i < 5; $i++) {
			$data['longtitre' . ($i + 1)] = $titres_longs[$i] ?? null;
		}

		for ($i = 0; $i < 4; $i++) {
			$data['descriptions' . ($i + 1)] = $descriptions[$i] ?? null;
		}

		$this->Donne_modele->update_groupe_search($idgroupe_annonce, $data);

		redirect('Client/onboarding/' . $idclients, 'refresh');
	}


	public function insertgroupeannonce($id)
	{
		$k = $this->data["groupe"] = $this->visuels_model->getgpid($id);
		$id = $k[0]['idclients'];
		$id = intval($id);
		$d = $this->data['donnees'] = $this->visuels_model->getDonneeById($id);
		$information_base = $d[0]['info_base_client'];
		$information_client = $d[0]['information_client'];
		$site_client = $d[0]['site_client'];
		$type_campagne = $k[0]['type_campagne'];
		$adsContent = $this->generateGoogleAdsCopy($information_base, $information_client, $site_client);
		$this->data['ads_titres'] = $adsContent['titres'];
		$this->data['ads_titres_longs'] = $adsContent['titres_longs'];
		$this->data['ads_descriptions'] = $adsContent['descriptions'];

		if ($type_campagne == 1) {
			$this->content = "layouts/client/onboarding/annonce_search";
		}
		if ($type_campagne == 3) {
			$this->content = "layouts/client/onboarding/annonce_pmax";
		}
		$this->layout();
	}


	private function generateGoogleAdsCopy($info_base, $info_client, $site)
	{
		$prompt = "Tu es un expert en Google Ads. 
		À partir de ces informations :
		- Informations de base : $info_base
		- Brief client : $info_client
		- Site web : $site

		Génère :
		- 12 titres courts accrocheurs (max 30 caractères chacun),
		- 4 titres longs (max 90 caractères chacun),
		- 4 descriptions (max 90 caractères chacune).

		Retourne uniquement une réponse JSON structurée comme ceci :
		{
		\"titres\": [\"titre1\", \"titre2\", ...],
		\"titres_longs\": [\"titre_long1\", ...],
		\"descriptions\": [\"description1\", ...]
		}";

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json',
				'Authorization: Bearer ' . env('CHAT_GPT_API_KEY')
			],
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => json_encode([
				'model' => 'gpt-4',
				'messages' => [
					['role' => 'system', 'content' => 'Tu es un expert en publicité Google Ads.'],
					['role' => 'user', 'content' => $prompt]
				],
				'temperature' => 0.7
			])
		]);

		$response = curl_exec($curl);
		curl_close($curl);

		$decoded = json_decode($response, true);
		$content = $decoded['choices'][0]['message']['content'] ?? '';

		$result = json_decode($content, true);

		return $result ?: ['titres' => [], 'titres_longs' => [], 'descriptions' => []];
	}

	public function details_ajax($id)
	{
		$idclients = $id;
		$type_campagne = [
			1	=> "SEARCH",
			2	=>	"LOCAL",
			3	=>	"PERFORMANCE MAX"
		];
		$campagnes = $this->data["campagnes"] = $this->visuels_model->getCampagneByIdclient($idclients);
		$campagnes = $this->visuels_model->getCampagneByIdclient($idclients);

		foreach ($campagnes as $index => $campagne) {
			$campagnes[$index]['type_campagne'] = $type_campagne[$campagne['type_campagne']];
		}

		$data['campagnes'] = $campagnes;
		$donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];
		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}
		foreach ($donne_valider as &$campagne) {
			$idcampagne = $campagne['idcampagne'];
			$campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
		}
		unset($campagne);
		$data['donne_valider'] = $donne_valider;
		$data['images'] = $this->Image_model->get_images_by_client($idclients);
		$data['groupe_annonce'] = $this->Donne_modele->getcampagnegroupevalidationbyidclient($idclients);
		$data['id'] = $id;
		$this->load->view('layouts/client/onboarding/detail_campagne', $data);
	}

	public function inventaire_pmax($idclients)
	{
		$data['groupe_annonce'] = $this->Donne_modele->getpmaxvalider($idclients);
		$data['images'] = $this->Image_model->get_images_by_client($idclients);
		$this->load->view('layouts/client/onboarding/inventaire_pmax', $data);
	}

	public function export_pdf($id)
	{
		$this->load->library('pdf');

		$idclients = $id;
		$type_campagne = [
			1 => "SEARCH",
			2 => "LOCAL",
			3 => "PERFORMANCE MAX"
		];

		$campagnes = $this->visuels_model->getCampagneByIdclient($idclients);
		foreach ($campagnes as $index => $campagne) {
			$campagnes[$index]['type_campagne'] = $type_campagne[$campagne['type_campagne']];
		}

		$data['campagnes'] = $campagnes;
		$donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];
		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}
		foreach ($donne_valider as &$campagne) {
			$idcampagne = $campagne['idcampagne'];
			$campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
		}
		unset($campagne);
		$data['donne_valider'] = $donne_valider;
		$html = $this->load->view('layouts/client/onboarding/detail_campagne_pdf', $data, true);

		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$this->pdf->stream("campagnes_client_$idclients.pdf", ['Attachment' => true]);
	}


	public function mis_a_jour_gtm($idclients)
	{
		$id = $idclients;
		$client = $this->visuels_model->getDonneeById($id);
		$site_client = $client[0]['site_client'];
		if (!preg_match('#^https?://#i', $site_client)) {
			$site_client = 'https://' . $site_client;
		}
		$html = $this->fetch_url($site_client);
		if ($html === false) {
			die("Erreur : impossible d'accéder à l'URL $site_client");
		}
		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		if ($gtm_code != Null):
			$this->visuels_model->mis_a_jour_gtm($idclients, $gtm_code);
		endif;
		redirect('Client/application/' . $idclients);
	}
	public function mis_a_jour_cms($idclients)
	{
		$id = $idclients;
		$client = $this->visuels_model->getDonneeById($id);
		$site_client = $client[0]['site_client'];
		if (!preg_match('#^https?://#i', $site_client)) {
			$site_client = 'https://' . $site_client;
		}
		$html = $this->fetch_url($site_client);
		if ($html === false) {
			die("Erreur : impossible d'accéder à l'URL $site_client");
		}
		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		$cms = $this->detect_cms($html, $site_client);
		if ($cms !== null) {
			$this->visuels_model->mis_a_jour_cms($idclients, $cms);
		}

		redirect('Client/application/' . $idclients);
	}
	public function ajout_brief()
	{
		$id = $this->input->post('idclients');
		$information_client = $this->input->post('information_client');
		$this->visuels_model->ajout_brief($id, $information_client);
		redirect('Client/onboarding/' . $id);
	}

	public function change_rappor_base()
	{
		$id = $this->input->post('idclients');
		$rapport_base = $this->input->post('rapport_base');
		$this->visuels_model->change_rapport_base($id, $rapport_base);
		redirect('Client/detail_client/' . $id);
	}


	public function change_conversions()
	{
		$id = $this->input->post('idclients');
		$rapport_conversion = $this->input->post('rapport_conversion');
		$this->visuels_model->change_rapport_conversion($id, $rapport_conversion);
		redirect('Client/detail_client/' . $id);
	}
	public function change_bilan_annuelle()
	{
		$id = $this->input->post('idclients');
		$bilan_annuele = $this->input->post('bilan_annuele');
		$this->visuels_model->change_bilan_annuele($id, $bilan_annuele);
		redirect('Client/detail_client/' . $id);
	}
	public function relance()
	{
		$id = $this->input->post('idclients');
		$statut_demande = 0;
		$id = $id;
		$this->visuels_model->change_statut_en_demande($id, $statut_demande);
		redirect('Client/detail_client/' . $id);
	}

	public function change_color()
	{
		$color_id = $this->input->post('color_id');
		$idclients = $this->input->post('idclients');

		if (!in_array($color_id, [1, 2, 3, 4])) {
			echo json_encode(['status' => 'error', 'message' => 'ID de couleur invalide']);
			return;
		}
		$this->visuels_model->update_color($idclients, $color_id);
		echo json_encode([
			'status' => 'success',
			'redirect_url' => base_url('Client/detail_client/' . $idclients)
		]);
	}
	public function date_google_meet()
	{
		$meetingDate = $this->input->post('meetingDate');
		$idclients = $this->input->post('idclients');
		$this->visuels_model->change_meetingDate($idclients, $meetingDate);
		redirect('Client/detail_client/' . $idclients);
	}
	public function upload_logo()
	{
		$idclients = $this->input->post('idclients');

		$logo = $this->file_upload_field = "logo";
		$logo = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {

			$logo = $this->path . $this->upload->file_name;
		}
		$this->Donne_modele->updatelogo($idclients, $logo);

		redirect('Client/detail_client/' . $idclients);
	}
	public function upload_logo_campagne()
	{
		$idclients = $this->input->post('idclients');

		$logo = $this->file_upload_field = "logo";
		$logo = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {

			$logo = $this->path . $this->upload->file_name;
		}
		$this->Donne_modele->updatelogo($idclients, $logo);

		echo json_encode(['success' => true, 'logo_url' => base_url($logo)]);
	}


	public function enregistrer()
	{
		$idclients = $this->input->post('idclients');
		$rating = $this->input->post('rating');

		if ($idclients && $rating) {
			$this->visuels_model->enregistrer_note($idclients, $rating);
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Données invalides']);
		}
	}

	public function resiliation()
	{
		$resiliation = $this->input->post('resiliation');
		$idclients = $this->input->post('client');
		$tm_resiliation = $this->input->post('tm');
		$date_resiliation = $this->input->post('date_resiliation');
		$demande_resiliation = $this->input->post('demande_resiliation');
		$fin_campagne = $this->input->post('fin_campagne');

		$am_resiliation = $this->input->post('am_resiliation');
		$information_resiliation = $this->input->post('information_resiliation');
		$statut_resiliation = $this->input->post('statut_resiliation');

		$idclient = $this->visuels_model->create_resiliation($resiliation, $date_resiliation, $fin_campagne, $am_resiliation, $tm_resiliation, $demande_resiliation, $information_resiliation, $statut_resiliation, $idclients);

		if ($resiliation == 1):
			$type_upsell = 2;
		endif;
		if ($resiliation == 2):
			$type_upsell = 4;
		endif;
		if ($resiliation == 3):
			$type_upsell = 5;
		endif;

		$demmande_upsell = $date_resiliation;
		$tm = $tm_resiliation;
		$date_upsell = $fin_campagne;
		$date_demande_upsell = $demmande_upsell;
		$inforamtion_upsell = $information_resiliation;
		$statut_upsell = $statut_resiliation;
		$id = intval($idclients);
		$idclients = $id;
		$donnee = $this->data["clients"] = $this->visuels_model->getDonneeById($id);
		$idonnee = $donnee[0]['idonnee'];
		$account_manager = $donnee[0]['account_manager'];
		$initiative = $donnee[0]['initiative'];
		$statut_demande = 1;
		$this->visuels_model->change_statut_en_demande($id, $statut_demande);
		$budget_initiale = $donnee[0]['budget'];
		$am = $this->input->post('am');
		$budget_initiale = intval($budget_initiale);
		$budget_upsell = intval($budget_initiale);
		$budget_finale = $budget_initiale;
		$actif = 1;
		$idupsell = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients, $actif);
		$type_tache = 1;
		if ($type_upsell == 2):
			$title = "Relance client";
			$tache = "Le client sera relancer, voir date due";
			$type_tache = 9;
			$dejaclient = 4;
			$type_upsell = 9;
			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $account_manager,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);

		endif;
		if ($type_upsell == 4):
			$title = "Mise en pause";
			$tache = "Mettre le client en pause, voir date due";
			$type_tache = 8;
			$dejaclient = 4;

			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $account_manager,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);
		endif;
		if ($type_upsell == 5):
			$title = "Résiliation";
			$tache = "Résiliation complète du client, voir date due";
			$type_tache = 7;
			$dejaclient = 5;
			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $am,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);
		endif;
		$Statuts_technique = 1;

		$data = array(
			'idupsell' => $idupsell,
			'type_tache' => $type_tache,
			'date_demande' => $date_demande_upsell,
			'date_due' => $fin_campagne,
			'idclients' => $idclients,
			'AM' => $am_resiliation,
			'assigned_to' => $tm,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'description' => $tache

		);

		$this->Task_model->add_task($data);

		$this->session->set_flashdata('message-succes', "Client résilier avec succès");
		redirect('Client/detail_client/' . $idclients, 'refresh');
		$this->layout();
	}

	public function search()
	{

		$keyword = $this->input->post('keyword');
		$clients = $this->visuels_model->search_clients($keyword);

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
		$this->data['procedure_gtm'] = $this->Task_model->get_procedure_gtm($idclients);
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$this->content = "layouts/client/detail/application/index.php";
		$this->layout();
	}

	public function gtm($idclients)
	{

		$this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$t = $this->data["gtm"] = $this->visuels_model->get_gtm($idclients);
		$this->content = "layouts/client/detail/gtm/index.php";
		$this->layout();
	}
	public function get_gtm_by_id($id)
	{
		$data = $this->Gtm_model->get_by_id($id);
		echo json_encode($data);
	}
	public function update_gtm()
	{
		$id = $this->input->post('id_gtm');
		$idclients = $this->input->post('idclients');
		var_dump($idclients);
		die();
		$data = [
			'date_demande'      => $this->input->post('date_demande'),
			'invitation_reçu'   => $this->input->post('invitation_reçu'),
			'gtm'               => $this->input->post('gtm'),
			'statut'            => $this->input->post('statut'),
		];

		$this->Gtm_model->update($id, $data);

		redirect('Client/gtm/' . $idclients);
	}



	public function updateDonneeClient()
	{
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
		$commentaire_client = $this->input->post('commentaire_client') ?: NULL;
		$paiement_recu = (int) $this->input->post('paiement_recu');
		$datastudio = (int) $this->input->post('datastudio');
		$email_onboarding = (int) $this->input->post('email_onboarding');
		$facturation = (int) $this->input->post('facturation');

		$this->Donne_modele->update_client($idclient, $client, $email_client, $numero_client, $site_client);
		$this->Donne_modele->update_donnee_client(
			$budget,
			$secteur_activite,
			$Produit,
			$Initiative,
			$Am,
			$mis_en_place_paiement,
			$Brief,
			$annonce,
			$commentaire_client,
			$paiement_recu,
			$datastudio,
			$email_onboarding,
			$facturation,
			$idonnee
		);

		$this->session->set_flashdata('message-succes', "Données mises à jour avec succès");
		redirect('Onboarding', 'refresh');
	}


	public function activer_processus_tache()
	{
		$idclients = $this->input->post('idclients');
		$am = $this->input->post('am');
		$assigned_to = $this->input->post('assigned_to');
		$date = $this->input->post('date');
		$choix = $this->input->post('conversion');
		$conversion = [

			"lead" => [
				['idclients' => $idclients, 'conversion' => 'Lead - Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton chat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
			],

			"ecommerce" => [
				['idclients' => $idclients, 'conversion' => 'Lead | Achat', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a réalisé un achat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le begin checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d appel téléphonique ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le téléphone', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur l email', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a utilisé le chat pour entrer en contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité un article', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
			],

			"reservation" => [
				['idclients' => $idclients, 'conversion' => 'Lead | Réservation', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a effectué une réservation', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page produit', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un autre bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
			]
		];

		$conversions = $conversion[$choix] ?? [];

		$this->Donne_modele->insert_conversions($conversions);
		$this->Donne_modele->update_type_clients($choix, $idclients);
		$data = [
			'idclients' => $idclients,
			'account_manager' => $assigned_to,
			'initiative' => $assigned_to,
			'conversion_type' => $conversion,
			'date_activation' => $date,
		];
		header('Content-Type: application/json');

		// DEBUG temporaire
		$debug = array(
			'POST' => $this->input->post(),
		);

		if (empty($debug['POST']['idclients']) || empty($debug['POST']['am']) || empty($debug['POST']['assigned_to']) || empty($debug['POST']['date'])) {
			$debug['error'] = 'Un ou plusieurs champs POST sont vides';
			echo json_encode($debug);
			return;
		}
		$type_tache = 3;
		$title = "Demande invitation GTM";
		$description = "Invitation et demande de mise en place GTM au Client";
		$Statuts_technique = 1;
		$procedure_gtm = 1;
		$idclients = $this->input->post('idclients');
		$am = $this->input->post('am');
		$tm = $this->input->post('assigned_to');
		$date = $this->input->post('date');

		$data = array(
			'type_tache' => $type_tache,
			'date_demande' => $date,
			'date_due' => $date,
			'idclients' => $idclients,
			'AM' => $assigned_to,
			'assigned_to' => $assigned_to,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'procedure_gtm' => $procedure_gtm,
			'description' => $description
		);

		$this->Task_model->add_task($data);



		$data_gtm = array(
			'idclients' => $idclients,
			'am' => $am,
			'tm' => $tm,
			'date_demande' => $date
		);
		$this->Gtm_model->add_gtm_process($data_gtm);

		echo json_encode(['redirect_url' => base_url('Client/application/' . $idclients)]);
	}

	public function detail_client($idclients)
	{

		$this->data['noteClient'] = $this->visuels_model->get_note_par_client($idclients);
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$this->data['discussion'] = $this->Discussion_model->getdiscussionbyidclient($idclients);
		$t = $this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$t = count($t);
		$this->data['nbr_task'] = $t;
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);

		$notes = $this->Note_model->get_all_by_idclients($idclients);
		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}
		$this->data['notes'] = $notes;

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

		$this->content = "layouts/client/detail/index.php";
		$this->layout();
	}

	public function onboarding($idclients)
	{

		$type_campagne = [
			1	=> "SEARCH",
			2	=>	"LOCAL",
			3	=>	"PERFORMANCE MAX"
		];
		$this->data['idclients'] = $idclients;
		$d = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$campagnes = $this->data["campagnes"] = $this->visuels_model->getCampagneByIdclient($idclients);
		$campagnes = $this->visuels_model->getCampagneByIdclient($idclients);

		foreach ($campagnes as $index => $campagne) {
			$campagnes[$index]['type_campagne'] = $type_campagne[$campagne['type_campagne']];
		}

		$this->data['campagnes'] = $campagnes;
		$donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];

		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}

		foreach ($donne_valider as &$campagne) {
			$idcampagne = $campagne['idcampagne'];
			$campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
		}
		unset($campagne);
		// dd($donne_valider);
		$this->data['donne_valider'] = $donne_valider;
		$this->data['procedure_gtm'] = $this->Task_model->get_procedure_gtm($idclients);
		$this->content = "layouts/client/onboarding/index.php";
		$this->layout();
	}

	public function campagne($idclients)
	{
		$type_page = [
			1 => "search",
			2 => "local",
			3 => "pmax"
		];

		$this->data['idclients'] = $idclients;
		$d = $this->visuels_model->getDonneeById($idclients);
		$id_campagne = $this->input->get('id_camp');
		$information_client = $d->information ?? '';
		$site_client = $d[0]['site_client'];
		//$images_site = $this->fetch_all_images_from_site($site_client, 8);

		if ($id_campagne) {
			$campagne = $this->data['campagne'] = $this->visuels_model->getCampagneById($id_campagne);
			$camp_type = $campagne->type_campagne;

			$this->data['id_camp'] = $id_campagne;
			$this->data['mots_exclus'] = "Test";
			$groupes_annonces = $this->data['groupes_annonces'] = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);
		} else {

			$this->data['conversion'] = $this->input->get('conversion');
			$this->data['camp_type'] = $camp_type = $this->input->get('camp_type');
			$this->data['gtm'] = $this->input->get('gtm');



			//$raw_keywords = $this->call_openai($prompt);
			//$raw_keywords = trim($raw_keywords);
			//if (preg_match('/([a-zA-ZÀ-ÿ0-9,\s]+)/', $raw_keywords, $matches)) {
			// $raw_keywords = $matches[1];
			//}
			//$clean_keywords = preg_replace('/,\s*/', "\n", $raw_keywords);

			//$this->data["mots_exclus"] = "test";
		}

		$this->data["donnees"] = $d;

		$site_client = $d[0]['site_client'] ?? '';
		//$images_site = $this->fetch_all_images_from_site($site_client, 8);
		//$this->data["images_site"] = $images_site;
		$this->data["site_client"] = $site_client;
		$this->data['procedure_gtm'] = $this->Task_model->get_procedure_gtm($idclients);
		$this->content = "layouts/client/onboarding/" . $type_page[$camp_type] . ".php";
		$this->layout();
	}
	public function fetch_images_campagne()
	{
		$url = $this->input->post('url');
		$images = [];

		if (!empty($url)) {
			// Utilise ta fonction existante pour récupérer les images
			$images = $this->fetch_all_images_from_site($url, 8);
		}

		echo json_encode([
			'success' => !empty($images),
			'images'  => $images
		]);
	}

	public function information_campagne($idclients)
	{
		$url = $this->input->post('url');

		if (!$url) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'URL manquante.']));
		}

		// 1. Récupération du HTML
		$html = @file_get_contents($url);
		if ($html === false) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'Impossible de charger le contenu de la page.']));
		}

		// 2. Charger dans DOMDocument pour extraire uniquement le contenu texte
		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		libxml_clear_errors();

		$xpath = new DOMXPath($dom);

		// 3. Récupérer uniquement les balises visibles
		$nodes = $xpath->query('//h1 | //h2 | //h3 | //p | //article | //section | //div');

		$textContent = '';
		foreach ($nodes as $node) {
			$text = trim($node->textContent);
			if (strlen($text) > 30) { // on ignore les tout petits morceaux de texte
				$textContent .= $text . "\n";
			}
		}

		$textContent = substr($textContent, 0, 3500); // limite la taille pour OpenAI

		// 4. Construire un prompt pour générer un résumé **sans explication technique**
		$prompt = "EOT
			Voici le contenu textuel extrait d'une page web : 
			$textContent
			Donne un résumé court et objectif de ce que propose le site ou la page, sans détails techniques ni structure HTML. Ne parle pas de scripts ou de performances. Ne commence pas par 'Voici le résumé', écris directement le contenu comme un humain qui explique à un autre humain de quoi parle le site.
			EOT";

		// 5. Appel à l'API OpenAI
		$response = $this->call_openai($prompt);
		$response = trim($response);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(['status' => 'success', 'data' => $response]));
	}


	public function get_mot_cle_a_exclure($idclients)
	{
		$campagne_info = $this->input->post('information_campagne_search');

		if (!$campagne_info) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'Aucune information de campagne reçue.']));
		}

		$prompt = "Tu es un expert Google Ads.
		Génère une liste de 60 mots-clés à exclure pour une campagne Google Ads sur le réseau de recherche.
		Voici les informations de la campagne :

		$campagne_info

		⚠️ Tu ne peux pas visiter de site web.
		Même si les informations sont partielles, propose une liste pertinente et standard de mots-clés à exclure en français pour éviter les recherches non qualifiées.
		Donne UNIQUEMENT les mots, séparés par des virgules, sans introduction ni phrase explicative.";

		$raw_keywords = $this->call_openai($prompt);
		$raw_keywords = trim($raw_keywords);

		if (preg_match('/([a-zA-ZÀ-ÿ0-9,\s]+)/', $raw_keywords, $matches)) {
			$raw_keywords = $matches[1];
		}

		$clean_keywords = preg_replace('/,\s*/', "\n", $raw_keywords);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => 'success',
				'data' => $clean_keywords
			]));
	}

	public function ajout_campagne($idclients)
	{

		$id_campagne = $this->input->get('id_camp');
		if ($id_campagne) {
			$campagne = $this->data['campagne'] = $this->visuels_model->getCampagneById($id_campagne);
			$camp_type = $campagne->type_campagne;
		} else {
			$camp_type = $this->input->get('camp_type');
		}

		switch ($camp_type) {

			case 1:
				// Inputs spécifiques
				$nom_campagne          	= $this->input->post('nom_campagne_search'); // not in view
				$information_campagne  	= $this->input->post('information_campagne_search'); // not in view
				$age				   = $this->input->post('age');
				$cible				   = $this->input->post('cible');
				$zones                 	= $this->input->post('zone_search'); // OK
				$repartition_budget    	= $this->input->post('repartition_budget_search'); // OK
				$date_campagne         	= $this->input->post('date_campagne'); // not in view
				$appareil              	= $this->input->post('appareil'); // OK
				$objectif              	= $this->input->post('objectif'); // not in view
				$url_site              	= $this->input->post('url_campagne'); // OK
				$groupes_annonces      	= $this->input->post('groupe_annonce'); // OK
				$contexte_groupes      	= $this->input->post('contexte_groupe_annonce'); // not in view
				$mots_cle              	= $this->input->post('Mot_cle'); // OK
				$Mots_cle_exclus       	= $this->input->post('Mots_cle_exclus');
				$selected_images		= $this->input->post('selected_images');


				// Vérification cohérence
				if (count($groupes_annonces) == count($contexte_groupes) && count($groupes_annonces) == count($mots_cle)) {

					if ($id_campagne) {


						$id_campagne = $this->Donne_modele->insert_campagne_am = $this->Donne_modele->insert_campagne_am(
							$idclients,
							$camp_type,
							$nom_campagne,
							$information_campagne,
							$cible,
							$ages,
							$zones,
							$repartition_budget,
							$date_campagne,
							$appareil,
							$objectif,
							$url_site,
							$mots_cle,
							$Mots_cle_exclus
						);


						/** Supprimer d'abord tous les groupes */
						$groupes_campagnes = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);
						foreach ($groupes_campagnes as $groupe_campagne) {
							$this->Donne_modele->deletegroupecampagne($groupe_campagne['idgroupe_annonce']);
						}
					} else {

						$id_campagne = $this->Donne_modele->insert_campagne_am = $this->Donne_modele->insert_campagne_am(
							$idclients,
							$camp_type,
							$nom_campagne,
							$information_campagne,
							$cible,
							$age,
							$zones,
							$repartition_budget,
							$date_campagne,
							$appareil,
							$objectif,
							$url_site,
							$mots_cle,
							$Mots_cle_exclus
						);
					}

					// Data groupes
					$data_groups = [];
					foreach ($groupes_annonces as $index => $groupe) {
						$data_groups[] = [
							'groupe_annonce'         	=>	$groupe,
							'contexte_groupe_annonce' 	=>	$contexte_groupes[$index] ?? '',
							'mot_cle'                	=>	$mots_cle[$index] ?? '',
							'url_groupe_annonce'     	=>	$url_site,
							'idcampagne'             	=>	$id_campagne,
							'idclient'               	=>	$idclients,
							'camp_type'          		=>	$camp_type
						];
					}
					//var_dump($data_groups);
					$this->Donne_modele->insert_gp($data_groups, $id_campagne, $idclients, $camp_type);
					if ($selected_images) {
						$selected_images_array = explode(',', $selected_images);
						$idgroupe_annonce = 0;
						$inserted_count = $this->Image_model->insert_images($selected_images_array, $idclients, $id_campagne, $idgroupe_annonce);
					}
				} else {
					echo 'Erreur : Le nombre de groupes d\'annonces, de contextes et de mots-clés ne correspond pas.';
				}
				break;

			case 2: //local
				// Inputs spécifiques
				$nom_campagne          = $this->input->post('nom_campagne_pmax');
				$information_campagne  = $this->input->post('information_campagne_search');
				$age				   = $this->input->post('age');
				$cible				   = $this->input->post('cible');
				$url_site              = $this->input->post('url_campagne_pmax');
				$repartition_budget    = $this->input->post('repartition_budget_pmax');
				$zones                 = $this->input->post('zone_pmax');
				$nom_groupe_pmax       = $this->input->post('nom_groupe_pmax');
				$date_campagne         = $this->input->post('date_campagne_pmax');
				$appareil              = $this->input->post('appareil');
				$objectif              = $this->input->post('objectif_pmax');
				$Mots_cle_potentiels   = $this->input->post('Mot_cle_pmax');
				$information_client    = $this->input->post('information_client_pmax');
				$contextes_client      = $this->input->post('contextes_client_pmax');
				$choix                 = $this->input->get('conversion');
				$groupes_annonces      = $this->input->post('groupe_annonce'); // OK
				$contexte_groupes      = $this->input->post('contexte_groupe_annonce'); // not in view
				$mots_cle              = $this->input->post('Mot_cle'); // OK
				$Mots_cle_exclus       = $this->input->post('Mots_cle_exclus');
				$idcampagne = $this->Donne_modele->insert_campagne_am(
					$idclients,
					$camp_type,
					$nom_campagne,
					$information_campagne,
					$cible,
					$age,
					$zones,
					$repartition_budget,
					$date_campagne,
					$appareil,
					$objectif,
					$url_site,
					$mots_cle,
					$Mots_cle_exclus
				);

				// Insert groupe pmax
				$this->Donne_modele->insert_gppmax($idclients, $nom_groupe_pmax, $camp_type, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client);
				break;

			case 3:
				// Inputs spécifiques
				$nom_campagne          = $this->input->post('nom_campagne_pmax');
				$information_campagne  = $this->input->post('information_campagne_search');
				$age				   = $this->input->post('age');
				$cible				   = $this->input->post('cible');
				$url_site              = $this->input->post('url_campagne_pmax');
				$repartition_budget    = $this->input->post('repartition_budget_pmax');
				$zones                 = $this->input->post('zone_pmax');
				$nom_groupe_pmax       = $this->input->post('nom_groupe_pmax');
				$date_campagne         = $this->input->post('date_campagne_pmax');
				$appareil              = $this->input->post('appareil');
				$objectif              = $this->input->post('objectif_pmax');
				$Mots_cle_potentiels   = $this->input->post('Mot_cle_pmax');
				$information_client    = $this->input->post('information_client_pmax');
				$contextes_client      = $this->input->post('contextes_client_pmax');
				$choix                 = $this->input->get('conversion');
				$groupes_annonces      = $this->input->post('groupe_annonce'); // OK
				$contexte_groupes      = $this->input->post('contexte_groupe_annonce'); // not in view
				$mots_cle              = $this->input->post('Mot_cle'); // OK
				$Mots_cle_exclus       = $this->input->post('Mots_cle_exclus');
				$idcampagne = $this->Donne_modele->insert_campagne_am(
					$idclients,
					$camp_type,
					$nom_campagne,
					$information_campagne,
					$cible,
					$age,
					$zones,
					$repartition_budget,
					$date_campagne,
					$appareil,
					$objectif,
					$url_site,
					$mots_cle,
					$Mots_cle_exclus
				);

				// Insert groupe pmax
				$this->Donne_modele->insert_gppmax($idclients, $nom_groupe_pmax, $camp_type, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client);

				// Définir toutes les conversions possibles
				$conversionSets = [

					"lead" => [
						['idclients' => $idclients, 'conversion' => 'Lead - Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead - Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead - Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead - Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton chat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Page vue', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					],

					"ecommerce" => [
						['idclients' => $idclients, 'conversion' => 'Lead | Achat', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a réalisé un achat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le begin checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d appel téléphonique ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le téléphone', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur l email', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a utilisé le chat pour entrer en contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité un article', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					],

					"reservation" => [
						['idclients' => $idclients, 'conversion' => 'Lead | Réservation', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a effectué une réservation', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page produit', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un autre bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
						['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					]
				];

				$conversions = $conversionSets[$choix] ?? [];

				$this->Donne_modele->insert_conversions($conversions);
				$this->Donne_modele->update_type_clients($choix, $idclients);

				$data_groups = [];
				foreach ($groupes_annonces as $index => $groupe) {
					$data_groups[] = [
						'groupe_annonce'         	=>	$groupe,
						'contexte_groupe_annonce' 	=>	$contexte_groupes[$index] ?? '',
						'mot_cle'                	=>	$mots_cle[$index] ?? '',
						'url_groupe_annonce'     	=>	$url_site,
						'idcampagne'             	=>	$idcampagne,
						'idclient'               	=>	$idclients,
						'camp_type'          		=>	$camp_type
					];
				}
				$this->Donne_modele->insert_gp($data_groups, $idcampagne, $idclients, $camp_type);
				break;
		}
		// Bloc final commun
		$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
		redirect('Client/onboarding/' . $idclients, 'refresh');

		// $this->layout();
	}

	public function supprimer_campagne($id_campagne)
	{

		$campagne = $this->data['campagne'] = $this->visuels_model->getCampagneById($id_campagne);
		$groupes_annonces = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);

		foreach ($groupes_annonces as $groupe_annonce) {
			$this->Donne_modele->deletegroupe($groupe_annonce['idgroupe_annonce']);
		}

		$this->Donne_modele->deletecampagne($id_campagne);

		$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
		redirect('Client/onboarding/' . $campagne->idclients, 'refresh');
	}

	public function groupe_annonce($id_campagne, $id_groupe) {}

	private function fetch_all_images_from_site($site_url, $max_images = 8, $max_pages = 20)
	{
		if (!preg_match('#^https?://#', $site_url)) {
			$site_url = 'http://' . $site_url;
		}

		$visited = [];
		$to_visit = [$site_url];
		$images = [];

		while (!empty($to_visit) && count($visited) < $max_pages && count($images) < $max_images) {
			$current_url = array_shift($to_visit);
			if (isset($visited[$current_url])) continue;
			$visited[$current_url] = true;

			$html = @file_get_contents($current_url);
			if (!$html) continue;

			// 1. Extraire les images
			$img_urls = $this->extract_image_urls($html, $current_url);
			foreach ($img_urls as $img_url) {
				if ($this->looks_like_logo_or_icon($img_url) || $this->is_data_uri($img_url)) continue;

				$meta = $this->get_image_metadata($img_url);
				if (!$meta) continue;

				if (!$this->is_photo_mime($meta['mime'])) continue;
				if ($meta['width'] < 150 || $meta['height'] < 150) continue;

				$images[] = $img_url;
				if (count($images) >= $max_images) break 2;
			}

			// 2. Extraire les liens internes pour crawler
			$dom = new DOMDocument();
			libxml_use_internal_errors(true);
			$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);
			$links = $xpath->query('//a[@href]');
			foreach ($links as $link) {
				$href = $link->getAttribute('href');
				$url = $this->resolve_url($href, $current_url);
				if (!$this->is_internal_link($url, $site_url)) continue;
				if (!isset($visited[$url]) && !in_array($url, $to_visit)) {
					$to_visit[] = $url;
				}
			}
		}

		return array_slice($images, 0, $max_images);
	}

	private function fetch_images_from_site($site_url, $max_images = 8)
	{
		$site_url = trim($site_url);
		if (empty($site_url)) return [];

		if (!preg_match('#^https?://#', $site_url)) {
			$site_url = 'http://' . $site_url;
		}

		$html = @file_get_contents($site_url);
		if (!$html) return [];

		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$imgs = $xpath->query('//img');
		$images = [];

		foreach ($imgs as $img) {
			$src = $img->getAttribute('src');
			if (!$src) continue;

			// ignore logos/icônes
			$src_lc = strtolower($src);
			if (strpos($src_lc, 'logo') !== false || strpos($src_lc, 'icon') !== false || strpos($src_lc, 'svg') !== false) {
				continue;
			}

			// construire l'URL absolue
			$img_url = $this->resolve_url($src, $site_url);

			// vérifie si l’image est valide
			$img_info = @getimagesize($img_url);
			if (!$img_info || $img_info[0] < 150 || $img_info[1] < 150) continue;

			$images[] = $img_url;

			if (count($images) >= $max_images) break;
		}

		return $images;
	}

	private function resolve_url($relative, $base)
	{
		if (empty($relative)) return '';

		// ignore les data:uri
		if (preg_match('#^data:#', $relative)) return '';
		if (preg_match('#^https?://#', $relative)) return $relative;
		if (strpos($relative, '//') === 0) {
			$scheme = parse_url($base, PHP_URL_SCHEME) ?: 'http';
			return $scheme . ':' . $relative;
		}

		// gestion des chemins relatifs
		$parsed_base = parse_url($base);
		$scheme = $parsed_base['scheme'] ?? 'http';
		$host = $parsed_base['host'] ?? '';
		$base_path = rtrim(dirname($parsed_base['path'] ?? '/'), '/');

		$path = ($relative[0] === '/') ? $relative : $base_path . '/' . $relative;

		return $scheme . '://' . $host . '/' . ltrim($path, '/');
	}

	private function extract_image_urls($html, $base_url)
	{
		$urls = [];
		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);

		// <img src>
		$imgs = $dom->getElementsByTagName('img');
		foreach ($imgs as $img) {
			$src = $img->getAttribute('src');
			if (!$src) continue;
			$urls[] = $this->resolve_url($src, $base_url);
			// srcset handling: prend la plus grande candidate si existe
			$srcset = $img->getAttribute('srcset');
			if ($srcset) {
				$best = $this->pick_best_from_srcset($srcset, $base_url);
				if ($best) $urls[] = $best;
			}
		}

		// inline styles background-image: url(...)
		$xpath = new DOMXPath($dom);
		$nodes = $xpath->query('//*[@style]');
		foreach ($nodes as $node) {
			$style = $node->getAttribute('style');
			if (preg_match_all('/background(?:-image)?:\s*url\((["\']?)(.*?)\1\)/i', $style, $m)) {
				foreach ($m[2] as $bg) {
					$urls[] = $this->resolve_url($bg, $base_url);
				}
			}
		}

		return array_values(array_unique($urls));
	}

	private function pick_best_from_srcset($srcset, $base_url)
	{
		// srcset format: url1 1x, url2 2x, or url w, ...
		$parts = preg_split('/\s*,\s*/', trim($srcset));
		$bestUrl = null;
		$bestScore = 0;
		foreach ($parts as $p) {
			// "url 2x" or "url 300w" or just "url"
			$sub = preg_split('/\s+/', trim($p));
			$url = $sub[0];
			$score = 1;
			if (isset($sub[1])) {
				if (strpos($sub[1], 'w') !== false) {
					$score = intval($sub[1]);
				} elseif (strpos($sub[1], 'x') !== false) {
					$score = floatval($sub[1]) * 1000;
				}
			}
			if ($score > $bestScore) {
				$bestScore = $score;
				$bestUrl = $url;
			}
		}
		return $bestUrl ? $this->resolve_url($bestUrl, $base_url) : null;
	}

	private function is_internal_link($url, $base)
	{
		$uHost = parse_url($url, PHP_URL_HOST);
		$bHost = parse_url($base, PHP_URL_HOST);
		return $uHost && $bHost && (strcasecmp($uHost, $bHost) === 0);
	}

	private function looks_like_logo_or_icon($url)
	{
		$lower = strtolower($url);
		// mots courants pour logos/icônes
		$bad_words = ['logo', 'icon', 'sprite', 'favicon', 'badge', 'btn', 'spacer', 'pixel', 'placeholder', 'thumb', 'avatar'];
		foreach ($bad_words as $w) {
			if (strpos($lower, '/' . $w) !== false) return true;
			if (strpos($lower, '-' . $w) !== false) return true;
			if (strpos($lower, '_' . $w) !== false) return true;
			if (strpos($lower, $w . '.') !== false) return true;
		}
		// svg files often logos/illustrations — on peut exclure si souhaité
		if (preg_match('/\.svg(\?|$)/i', $lower)) return true;
		return false;
	}

	private function is_data_uri($s)
	{
		return preg_match('#^data:#i', $s);
	}

	private function is_photo_mime($mime)
	{
		// accepter jpg/png/webp/gif (gif peut être animé)
		$allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
		return in_array(strtolower($mime), $allowed);
	}

	private function get_image_metadata($img_url)
	{
		// tente HEAD pour obtenir content-type et content-length
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $img_url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SiteImageBot/1.0)');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ctype = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		$clen = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		curl_close($ch);
		if ($http >= 400) return false;

		// si content-type absent ou pas image, on essaie de télécharger les premiers octets
		$mime = $ctype ?: '';
		// pour récupérer width/height, on télécharge un bloc
		$imgData = $this->fetch_partial($img_url, 0, 200000); // 200KB max
		if ($imgData === false) return false;

		// utilise getimagesizefromstring pour obtenir dims
		$info = @getimagesizefromstring($imgData);
		if ($info === false) return false;
		$width = $info[0];
		$height = $info[1];
		$mime_from_info = $info['mime'] ?? null;
		if (empty($mime) && $mime_from_info) $mime = $mime_from_info;

		// taille en octets : si content-length dispo, sinon length du blob (estimation)
		$filesize = ($clen > 0) ? $clen : strlen($imgData);

		return [
			'width' => intval($width),
			'height' => intval($height),
			'mime' => $mime ?: 'application/octet-stream',
			'filesize' => intval($filesize)
		];
	}

	private function fetch_partial($url, $start = 0, $maxBytes = 200000)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RANGE, "$start-" . ($start + $maxBytes - 1));
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SiteImageBot/1.0)');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($http >= 400) return false;
		return $data;
	}
	public function generer_mots_exclus()
	{
		$information_client = $this->input->post('information_client');
		$site_client = $this->input->post('site_client');

		$prompt = "À partir de ces informations : $information_client 
        et en analysant le site : $site_client, génère une liste de 60 mots-clés à exclure pour une campagne Google Ads (type search). 
        Ne donne que les mots, séparés par des virgules ou des retours à la ligne.";

		$response = $this->call_openai($prompt);

		echo $response ? nl2br(htmlspecialchars($response)) : "❌ Erreur lors de la génération.";
	}

	private function call_openai($prompt)
	{
		$url = "https://api.openai.com/v1/chat/completions";
		$data = [
			"model" => "gpt-4o-mini",
			"messages" => [
				["role" => "system", "content" => "Tu es un expert Google Ads."],
				["role" => "user", "content" => $prompt]
			],
			"temperature" => 0.7
		];

		$headers = [
			"Content-Type: application/json",
			"Authorization: Bearer " . env('CHAT_GPT_API_KEY')
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$result = curl_exec($ch);

		if (curl_errno($ch)) {
			log_message('error', 'Erreur CURL OpenAI: ' . curl_error($ch));
		}

		curl_close($ch);

		if ($result) {
			$json = json_decode($result, true);
			return $json['choices'][0]['message']['content'] ?? null;
		}

		return null;
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
		$initiative = $donnee[0]['initiative'];
		$idonnee = $donnee[0]['idonnee'];
		$buget_initiale = $donnee[0]['budget'];
		if ($type_upsell == 2):
			$am = $this->input->post('am');
			$budget_initiale = $this->input->post('budget_initiale');
			$budget_initiale = intval($budget_initiale);
			$budget_upsell = intval($budget_upsell);
			$budget_finale = $budget_upsell + $budget_initiale;
			$actif = 1;
			$idupsell = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients, $actif);
			$type_tache = 5;
			$title = "Upsell";
			if ($inforamtion_upsell == Null) {
				$tache = "Le client fait une upsell de "  . number_format($budget_upsell, 0, ',', ' ') . " €";
			}
			if ($inforamtion_upsell != Null) {
				$tache = "Le client fait une upsell de " . number_format($budget_upsell, 0, ',', ' ') . " €" . " avec les informations suivantes :\n" . $inforamtion_upsell;
			}
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
				'description' => $tache,
				'idupsell' => $idupsell
			);

			$this->Task_model->add_task($data);
			$client = $idclients;
			$dejaclient = 1;
			$budget = $budget_upsell;
			$am = $am;
			$type_upsell = $type_upsell;
			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $am,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);
		endif;
		if ($type_upsell == 1):
			$am = $this->input->post('am');
			$budget_initiale = $this->input->post('budget_initiale');
			$budget_initiale = intval($budget_initiale);
			$budget_upsell = intval($budget_upsell);
			$budget_finale = $budget_initiale - $budget_upsell;
			$actif = 1;
			$idupsell = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients, $actif);
			$type_tache = 6;
			$title = "Baisse";
			if ($inforamtion_upsell == Null) {
				$tache = "Le client fait une baisse de "  . number_format($budget_upsell, 0, ',', ' ') . " €";
			}
			if ($inforamtion_upsell != Null) {
				$tache = "Le client fait une baisse de " . number_format($budget_upsell, 0, ',', ' ') . " €" . " avec les informations suivantes :\n" . $inforamtion_upsell;
			}
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
				'description' => $tache,
				'idupsell' => $idupsell
			);

			$this->Task_model->add_task($data);
			$client = $idclients;
			$idupsell = $idupsell;
			$dejaclient = 1;
			$budget = $budget_upsell;
			$initiative = $tm;
			$am = $am;
			$type_upsell = $type_upsell;

			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $am,
				'initiative' => $tm,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);

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
		$budget = $this->input->post('budget');
		$secteur_activite = $this->input->post('secteur_activite');
		$product_choice = $this->input->post('product_choice');
		$initiative = $this->input->post('initiative');
		$am = $this->input->post('am');
		$date_mis_en_place = $this->input->post('date_mis_en_place');
		$date_brief = $this->input->post('date_brief');
		$date_annonce = $this->input->post('date_annonce');
		$dejaclient = 0;
		$logo = $this->file_upload_field = 'logo';
		$tm = $initiative;


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
		$summary = $this->get_summary_from_chatgpt($headings, $paragraphs);
		$naf_info = $this->get_naf_code_from_summary($summary);
		//var_dump($naf_info);
		//die();
		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		$cms = $this->detect_cms($html, $site_client);
		$cms_logo = $this->get_cms_logo($cms);
		$favicon = $this->get_favicon($html, $site_client);

		$idclients = $this->visuels_model->insertclient($client, $site_client, $email_client, $numero_client, $favicon, $cms, $cms_logo, $summary);
		$idclient_onboarding = $idclients;
		$idclient = $idclients;
		$this->visuels_model->insertfiche($idclient, $budget, $secteur_activite, $product_choice, $initiative, $am, $date_mis_en_place, $date_brief, $date_annonce, $dejaclient, $gtm_code);
		$title = "Création de Brief";
		$tache = "En attente de brief";
		$Statuts_technique = 1;
		$type_tache = 1;
		$data = array(
			'type_tache' => $type_tache,
			'date_demande' => $date_mis_en_place,
			'date_due' => $date_brief,
			'idclients' => $idclients,
			'AM' => $initiative,
			'assigned_to' => $am,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'description' => $tache
		);

		$this->Task_model->add_task($data);
		$type_upsell = 1;
		$budget_finale = $budget;
		$budget_initiale = $budget;
		$statut_upsell = 1;
		$idclients = $idclients;
		$demmande_upsell = $am;
		$am = $am;
		$tm = $am;
		$actif = 0;
		$date_upsell = $date_mis_en_place;
		$date_demande_upsell = $date_mis_en_place;
		$inforamtion_upsell = "Budget initial";
		$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients, $actif);
		$data_upsell = array(
			'idclients' => $idclient_onboarding,
			'dejaclient' => $dejaclient,
			'budget' => $budget,
			'account_manager' => $am,
			'initiative' => $initiative,
			'idproduit' => $product_choice,
			'mis_en_place_paiement' => $date_mis_en_place,
			'Brief' => $date_brief,
			'annonce' => $date_annonce

		);
		$this->visuels_model->add_upsell_onboarding($data_upsell);
		redirect('Client');
	}

	private function get_naf_code_from_summary($summary)
	{
		$model = 'gpt-4';

		$prompt = "Voici le résumé d’un site internet représentant une entreprise.\n\n" .
			"Ta tâche est de déterminer le **code NAF (APE)** le plus approprié pour cette activité, basé sur la nomenclature française officielle (INSEE).\n" .
			"Donne-moi le résultat au format JSON avec deux champs : `code` et `libelle`. Ne donne rien d'autre.\n\n" .
			"Résumé :\n$summary";

		$data = [
			"model" => $model,
			"messages" => [
				["role" => "user", "content" => $prompt]
			],
			"temperature" => 0.2
		];

		$ch = curl_init('https://api.openai.com/v1/chat/completions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . env('CHAT_GPT_API_KEY')
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return ['code' => '0000Z', 'libelle' => 'Secteur non identifié'];
		}

		curl_close($ch);
		$result = json_decode($response, true);
		$output = $result['choices'][0]['message']['content'] ?? '';

		// Exemple attendu : {"code": "6201Z", "libelle": "Programmation informatique"}
		$decoded = json_decode($output, true);
		if (json_last_error() === JSON_ERROR_NONE && isset($decoded['code'], $decoded['libelle'])) {
			return $decoded;
		}

		return ['code' => '0000Z', 'libelle' => 'Secteur non identifié'];
	}


	private function get_summary_from_chatgpt($headings, $paragraphs)
	{

		$model = 'gpt-4';

		$input_text = "Voici les titres et paragraphes d’un site web.\n\n";
		$input_text .= "Ta tâche est de rédiger un résumé informatif en **deux paragraphes distincts**, séparés par une **ligne vide** (un simple saut de ligne).\n\n";

		$input_text .= "✍️ Le résumé total doit contenir **entre 175 et 190 mots maximum**, répartis de façon naturelle entre les deux paragraphes.\n";
		$input_text .= "Le premier paragraphe doit présenter l'activité ou le secteur du site.\n";
		$input_text .= "Le second paragraphe doit décrire l’objectif, les services ou la valeur ajoutée.\n\n";

		$input_text .= "Titres :\n";
		foreach ($headings as $h) {
			$input_text .= "- ({$h['tag']}) {$h['text']}\n";
		}

		$input_text .= "\nParagraphes :\n";
		foreach (array_slice($paragraphs, 0, 10) as $p) {
			$input_text .= "- $p\n";
		}

		// Requête à l'API OpenAI
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
			'Authorization: Bearer ' . env('CHAT_GPT_API_KEY')
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'Erreur OpenAI : ' . curl_error($ch);
		}

		curl_close($ch);
		$result = json_decode($response, true);
		$raw_output = $result['choices'][0]['message']['content'] ?? 'Résumé non disponible.';

		// Séparation des deux paragraphes
		$paragraphs_split = preg_split('/\n\s*\n/', trim($raw_output));

		if (count($paragraphs_split) >= 2) {
			$para1 = trim($paragraphs_split[0]);
			$para2 = trim($paragraphs_split[1]);

			// Comptage des mots (utile pour test ou journalisation)
			$word_count1 = str_word_count(strip_tags($para1));
			$word_count2 = str_word_count(strip_tags($para2));
			$total_words = $word_count1 + $word_count2;

			// Retourne toujours le contenu, sans alerte
			return $para1 . "\n\n" . $para2;
		}

		// Fallback si le texte généré n'a pas deux paragraphes distincts
		return $raw_output;
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
		} elseif (strpos($html, 'Magento') !== false || strpos($html, 'mage/') !== false) {
			return 'Magento';
		} elseif (strpos($html, 'PrestaShop') !== false || strpos($html, 'mage/') !== false) {
			return 'PrestaShop';
		} elseif (strpos($html, 'Google') !== false || strpos($html, 'mage/') !== false) {
			return 'Google';
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
			'Magento' => 'Magento.png',
			'Wix' => 'wix.png',
			'PrestaShop' => 'prestashop.png',
			'Google' => 'site_kit.png'
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

	private function set_upload_options($prefix, $filename)
	{
		$file = pathinfo($filename);
		$file = $file['filename'];
		$config = array();
		$config['upload_path']      = $this->path;
		$config['allowed_types']    = 'jpg|jpeg|png|gif|webp';
		$config['max_size']         = '0';
		$config['file_name']        = url_title(iconv("UTF-8", "ASCII//TRANSLIT", $prefix . '_' . $file), '_', TRUE);
		$config['overwrite']        = FALSE;
		return $config;
	}
}
