<?php
defined('BASEPATH') or exit('No direct script access allowed');

$vendorAutoload = FCPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (!file_exists($vendorAutoload)) {
	// Message lisible et log si le fichier n'existe pas
	log_message('error', 'vendor/autoload.php introuvable : ' . $vendorAutoload);
	show_error("Dépendances Composer manquantes. Exécuter `composer require dompdf/dompdf` dans le dossier racine du projet.", 500, 'Dépendances manquantes');
	exit;
}
require_once $vendorAutoload;

use Dompdf\Dompdf;
use Dompdf\Options;


class Validation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Helpers et librairies communes (éviter les doublons)
		$this->load->helper(['url', 'language', 'form']);
		$this->load->library(['form_validation', 'upload', 'curl']);

		// Models
		$this->load->model([
			'panneau_model',
			'Image_model',
			'MaBase',
			'Data_modele',
			'Visuels_model',
			'Donne_modele',
			'visuels_model'
		]);

		// Chemins et champs par défaut pour les uploads
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";

		// Sécuriser set_error_delimiters : n'appeler que si les clés existent
		$start = $this->config->item('error_start_delimiter', 'ion_auth');
		$end   = $this->config->item('error_end_delimiter', 'ion_auth');
		if ($start !== null && $end !== null) {
			$this->form_validation->set_error_delimiters($start, $end);
		}

		// Charger les traductions si nécessaire
		$this->lang->load('auth');

		// NOTE:
		// - Dompdf est déjà inclus en haut du fichier via require_once.
		// - N'inclure pas require_once ni use ici à l'intérieur du constructeur.
	}

	public function index()
	{
		$url = base_url('Client');
		$response = file_get_contents($url);
		echo $response;
		//$this->load->view("templates/v3/Datastudio", $this->data);
	}
	public function inventaire_pmax($idclients)
	{
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
		$this->data['groupe_valider'] = $groupe_valider;
		$this->load->view('layouts/client/onboarding/inventaire', $this->data);
	}
	public function updateImages()
	{
		$idcampagne = trim($this->input->post('idcampagne'));
		$idclients  = trim($this->input->post('idclients'));
		$imagesJson = $this->input->post('images');
		$images     = json_decode($imagesJson, true);

		if (!$idcampagne || !$idclients) {
			echo json_encode(['status' => 'error', 'message' => 'Identifiants manquants.']);
			return;
		}

		$this->db->trans_start();

		// DELETE robuste : campagne uniquement (0) + compat NULL
		$this->db->where('idcampagne', $idcampagne)
			->where('idclients',  $idclients)
			->group_start()
			->where('idgroupe_annonce', 0)
			->or_where('idgroupe_annonce IS NULL', null, false)
			->group_end()
			->delete('images');

		$deleted = $this->db->affected_rows();

		// Réinsertion propre
		if (!empty($images) && is_array($images)) {
			foreach ($images as $rank => $img) {
				$url = isset($img['image_url']) ? trim($img['image_url']) : '';
				if ($url === '') continue;

				$this->db->insert('images', [
					'idclients'        => (int)$idclients,
					'idcampagne'       => (int)$idcampagne,
					'idgroupe_annonce' => 0,   // campagne only
					'image_url'        => $url,
					'rank'             => (int)$rank,
				]);
			}
		}

		$this->db->trans_complete();

		if (!$this->db->trans_status()) {
			echo json_encode(['status' => 'error', 'message' => 'Échec transaction.']);
			return;
		}

		echo json_encode([
			'status'  => 'success',
			'deleted' => $deleted,
			'kept'    => !empty($images) ? count($images) : 0
		]);
	}




	public function updateExclusions()
	{

		$idclients = $this->input->post('idclients');
		$exclusion = trim($this->input->post('exclusion'));

		if (empty($idclients)) {
			$this->session->set_flashdata('error', 'Client non défini.');
			redirect($_SERVER['HTTP_REFERER'] ?? 'Validation');
			return;
		}

		// Met à jour la colonne exclusion dans la table donnee
		$this->visuels_model->update_exclusion_by_client($idclients, $exclusion);

		$this->session->set_flashdata('success', 'Mots-clés exclus mis à jour avec succès.');
		redirect($_SERVER['HTTP_REFERER'] ?? 'Validation');
	}

	public function updateExtensions()
	{

		$idclients = $this->input->post('idclients');

		// Champs simples
		$dataGlobal = [
			'extensions_accroche'      => $this->input->post('extensions_accroche'),
			'extensions_extrait_site'  => $this->input->post('extensions_extrait_site'),
			'extensions_lieu'          => $this->input->post('extensions_lieu'),
			'extensions_appel'         => $this->input->post('extensions_appel')
		];

		$titres = $this->input->post('titre_extensions');
		$descs  = $this->input->post('description_extensions');
		$urls   = $this->input->post('url_extensions');

		// ⚠️ Supprimer les anciennes extensions liées au client
		$this->visuels_model->delete_extensions_by_client($idclients);

		// Réinsérer les nouvelles lignes
		if (is_array($titres)) {
			foreach ($titres as $i => $titre) {
				$data = array_merge($dataGlobal, [
					'idclients' => $idclients,
					'idcampagne' => 0, // ou laisse vide si tu veux
					'titre_extensions' => trim($titre),
					'description_extensions' => trim($descs[$i] ?? ''),
					'url_extensions' => trim($urls[$i] ?? '')
				]);
				$this->visuels_model->insert_extension($data);
			}
		}

		$this->session->set_flashdata('success', 'Extensions du client mises à jour avec succès.');
		redirect($_SERVER['HTTP_REFERER'] ?? 'Validation');
	}



	public function editextensions($id)
	{
		// Récupérer les données de la campagne

		$this->data["extensions"] = $this->visuels_model->getextensionsByIdc($id);
		$this->load->view("templates/v3/edit_extensions_validation", $this->data);
	}

	public function exclusion()
	{
		$exclusion = $this->input->post('exclusion');
		$id = $this->input->post('idclients');
		$id = intval($id);

		$this->visuels_model->exclusion($id, $exclusion);
		$this->session->set_flashdata('message-exclusion', 'Exclusion mis à jours.');
		redirect('Validation/validation_structure/' . $id, 'refresh');
	}
	public function generate_pdf()
	{
		// Charger la vue HTML avec le contenu que tu veux convertir en PDF
		$html = $this->load->view('ta_vue_avec_tableau', [], TRUE);

		// Charger le HTML dans DOMPDF
		$this->pdf->load_html($html);

		// Générer le PDF
		$this->pdf->render();

		// Télécharger le PDF dans le navigateur
		$this->pdf->stream("campagne_google_ads.pdf", array("Attachment" => 0));
	}
	public function ajouter_images_recup()
	{
		// Récupérer les images sélectionnées depuis le formulaire
		$selected_images = $this->input->post('selected_images');
		$idgroupe_annone = $this->input->post('idgroupe_annone');

		$idclients = $this->input->post('idclients');

		// Vérifier si des images ont été sélectionnées
		if ($selected_images) {
			// Insérer les images dans la base de données
			foreach ($selected_images as $image) {
				// Insertion de l'image dans la table 'images_table'
				$data = array(
					'image_url' => $image,  // Enregistrer le chemin de l'image
				);
				$this->db->insert('images', $data);

				// Récupérer l'ID de la dernière image insérée

				$idimage = $this->db->insert_id();


				//$this->Image_model->insertidgroupeimagess($idimage, $idgroupe_annone);
				$this->Image_model->insert_image($image, $idclients, $idgroupe_annone, $idimage);  // Insertion avec le chemin d'image, ID client et ID image
			}

			// Redirection vers la gestion des images après l'ajout
			redirect('Validation/gestion_image/' . $idgroupe_annone);
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
	}
	public function gestion_image($id)
	{
		$data['idgroupe_annone'] = $id;
		$b = $data['clients'] = $this->Image_model->getgroupe_annonce($id);

		$a = $data['images'] = $this->Image_model->get_images_by_id($id);
		$domain_name = $this->input->post('domain_name');

		$this->load->helper('url');
		$html = $this->get_html_from_url($domain_name); // Implémenter cette méthode

		// Extraire les images
		$images = $this->extract_images($html, $domain_name);

		// Charger la vue et passer les variables
		$data['html'] = $html;   // Passez la variable $html à la vue
		$data['Images_recup'] = $images;

		$this->load->view('image_list2', $data);
	}
	private function fetch_html($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$html = curl_exec($ch);
		curl_close($ch);

		return $html;
	}

	// Fonction pour extraire les images depuis le HTML
	private function extract_images($html, $url)
	{
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

	private function get_html_from_url($url)
	{
		if (!empty($url)):
			$response = file_get_contents($url);

			// Vérifiez si la réponse est vide ou s'il y a eu une erreur
			if ($response === false) {
				// Si l'URL ne peut pas être récupérée, retourner une chaîne vide ou un message d'erreur
				return "Erreur lors de la récupération du contenu.";
			}

			return $response;
		endif;
	}

	// Fonction pour transformer une URL relative en URL absolue
	private function make_absolute_url($src, $base_url)
	{
		if (filter_var($src, FILTER_VALIDATE_URL)) {
			return $src;
		}
		return base_url() . ltrim($src, '/');
	}
	public function add_image()
	{
		// On récupère l'URL de l'image si elle est envoyée
		$image = $this->input->post('image');
		$idgroupe_annone = $id = $this->input->post('idgroupe_annone');
		$idclients = $this->input->post('idclients');

		// Vérification et téléchargement du logo
		if ($_FILES['image']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["image"]["name"]));
			if ($this->upload->do_upload('image')) {
				$image_url = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$idimage = $this->Image_model->insert_image($image_url, $idclients, $idgroupe_annone, 0);
		$this->Image_model->insertidgroupeimage($idimage, $id);
		redirect('Validation/gestion_image/' . $id, 'refresh');
	}

	// Ajouter une image depuis une URL
	public function add_image_url()
	{
		$image_url = $this->input->post('image_url');
		$idgroupe_annone = $id = $this->input->post('idgroupe_annone');
		$idclients = $this->input->post('idclients');

		// Vérifier que l'URL n'est pas vide
		if (!empty($image_url)) {
			// Vérifier si l'URL est valide
			if (@getimagesize($image_url)) {
				// Si l'URL est valide et pointe vers une image, insérer dans la base de données
				$idimage = $this->Image_model->insert_image($image_url, $idclients, $idgroupe_annone, 0);
				$this->Image_model->insertidgroupeimage($idimage, $id);
				redirect('Validation/gestion_image/' . $id);
			} else {
				echo "Ce n'est pas une image valide.";
			}
		} else {
			echo "L'URL ne peut pas être vide.";
		}
	}

	// Supprimer une image
	public function delete_image($id)
	{
		$idgroupe_annonce = $this->Image_model->get_idgroupe_annonceimage($id);

		$this->Image_model->delete_image($id);
		$id = $idgroupe_annonce;
		redirect('Validation/gestion_image/' . $id);
	}

	// Mettre à jour l'ordre des images
	public function update_order()
	{
		// Récupérer l'ordre des images envoyé via AJAX
		$order = json_decode($this->input->post('order'));

		// Mettre à jour l'ordre des images dans la base de données
		foreach ($order as $index => $id) {
			$this->Image_model->update_rank($id, $index + 1);  // Le rang commence à 1
		}

		echo json_encode(['status' => 'success']);
	}


    // Mettre à jour les exclusions

	/**
	 * Affiche la page de validation et gère l'export via ?action=export
	 */
	public function validation_structure(int $id)
	{
		// 1️⃣ Logo statique
		$this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
			FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
		);


		// 2️⃣ Charger les campagnes + groupes + images
		$campagnes = $this->Visuels_model->get_campagnes_by_client($id);
		if (is_array($campagnes)) {
			foreach ($campagnes as &$campagne) {
				$campagne['groupes_annonces'] = $this->Visuels_model->get_groupes_by_campagne($campagne['idcampagne']) ?: [];
				$campagne['images'] = $this->Image_model->get_images_by_campagne($campagne['idcampagne']) ?: [];

				foreach ($campagne['images'] as &$img) {
					if (!empty($img->image_url)) {
						if (file_exists(FCPATH . $img->image_url)) {
							$img->final_url = base_url($img->image_url);
						} else {
							$img->final_url = $img->image_url;
						}
					} else {
						$img->final_url = base_url('assets/images/placeholder.jpg');
					}
				}

				unset($img);
			}
			unset($campagne);
		}
		$idclients = $id;
		$this->data['campagnes'] = $campagnes ?: [];
		$this->data['id'] = $id;
		$this->data['is_pdf'] = false;
		$this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
		$this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);
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
		$this->data['donne_valider'] = $donne_valider;
		$this->data['groupe_valider'] = $groupe_valider;
		$this->load->view('templates/v3/Validation_structure', $this->data);
	}

	public function exporter(int $id)
	{
		$this->data['logo_base64'] = $this->encode_local_image_to_data_uri(
			FCPATH . (defined('IMAGES_PATH') ? IMAGES_PATH : 'assets/images') . '/logo/logo3.png'
		);

		$campagnes = $this->Visuels_model->get_campagnes_by_client($id);
		if (is_array($campagnes)) {
			foreach ($campagnes as &$campagne) {
				$campagne['groupes_annonces'] = $this->Visuels_model->get_groupes_by_campagne($campagne['idcampagne']) ?: [];
				$campagne['images'] = $this->Image_model->get_images_by_campagne($campagne['idcampagne']) ?: [];

				foreach ($campagne['images'] as &$img) {
					$pathOrUrl = isset($img->image_url) ? $img->image_url : '';
					$img->image_base64 = $this->maybe_data_uri($pathOrUrl);
				}
				unset($img);
			}
			unset($campagne);
		}

		$this->data['campagnes'] = $campagnes ?: [];
		$this->data['id'] = $id;
		$this->data['is_pdf'] = true;
		$idclients = $id;
		$this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
		$this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];

		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}
		$this->data['groupe_valider'] = $groupe_valider;
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
		$this->data['donne_valider'] = $donne_valider;
		$this->data['groupe_valider'] = $groupe_valider;

		// 2️⃣ Générer le HTML
		$html = $this->load->view('templates/v3/Validation_structure_pdf', $this->data, true);
		// $this->load->view('templates/v3/Validation_structure_pdf', $this->data);
		
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$options->set('defaultFont', 'DejaVu Sans');
		$options->set('isHtml5ParserEnabled', true);
		$options->set('enable_css_float', true);
		// optionnel :
		$options->set('debugPng', false);

		// 4️⃣ Render + stream dans try/catch et nettoyer le buffer
		try {
			$dompdf = new Dompdf($options);
			$dompdf->setPaper('A3', 'landscape');
			$dompdf->loadHtml($html, 'UTF-8');
			$dompdf->render();

			// Nettoyage d'éventuels buffers pour éviter PDF corrompu
			if (ob_get_length()) {
				@ob_end_clean();
			}

			$filename = 'validation_structure_' . $id . '_' . date('Ymd_His') . '.pdf';
			// Affiche dans le navigateur (Attachment => 0). Pour forcer le téléchargement => 1
			$dompdf->stream($filename, ['Attachment' => 0]);
			exit; // termine proprement après l'envoi
		} catch (\Exception $e) {
			// Log et message d'erreur lisible (à adapter à ton logger)
			log_message('error', 'Dompdf error: ' . $e->getMessage());
			show_error('Erreur lors de la génération du PDF. Voir les logs serveur.');
		}
	}

	/**
	 * POST depuis le modal "Modifier la campagne"
	 * Form action: Validation/updateCampagne
	 * Champs: idcampagne, zones, date_campagne, appareil, repartition_budget, nom_campagne, mot_cle (optionnel: appliquer aux groupes)
	 */
	public function updateCampagne()
	{
		if (strtoupper($this->input->method()) !== 'POST') {
			show_error('Méthode non autorisée', 405);
		}

		$idcampagne = (int) $this->input->post('idcampagne', true);
		if (!$idcampagne) {
			$this->session->set_flashdata('error', 'ID campagne manquant');
			return $this->_redirect_back();
		}

		$fields = [
			'zones'              => $this->input->post('zones', true),
			'date_campagne'      => $this->input->post('date_campagne', true),
			'appareil'           => $this->input->post('appareil', true),
			'repartition_budget' => $this->input->post('repartition_budget', true),
			'nom_campagne'       => $this->input->post('nom_campagne', true),
		];
		$update = [];
		foreach ($fields as $k => $v) {
			if ($v !== null) {
				$update[$k] = trim($v);
			}
		}

		$ok = !empty($update)
			? $this->db->where('idcampagne', $idcampagne)->update('campagne', $update)
			: true;

		if (!$ok) {
			$this->session->set_flashdata('error', 'Échec de la mise à jour de la campagne.');
		} else {
			$this->session->set_flashdata('success', 'Campagne mise à jour.');
		}
		return $this->_redirect_back();
	}
	public function updateMotCleGroupe()
	{
		if (strtoupper($this->input->method()) !== 'POST') {
			return $this->_json(['status' => 'error', 'message' => 'Méthode non autorisée'], 405);
		}

		$idg = (int) $this->input->post('idgroupe_annonce', true);
		if (!$idg) {
			return $this->_json(['status' => 'error', 'message' => 'ID groupe manquant'], 400);
		}

		// Récupère tel quel, tu peux ajouter validations (taille max, blacklist, etc.)
		$mot_cle = trim((string) $this->input->post('mot_cle'));

		$ok = $this->db->where('idgroupe_annonce', $idg)
			->update('groupe_annonce', ['mot_cle' => $mot_cle !== '' ? $mot_cle : null]);

		if (!$ok) {
			return $this->_json(['status' => 'error', 'message' => 'Échec de la mise à jour'], 500);
		}
		return $this->_json(['status' => 'success']);
	}

	// petit helper JSON (si tu ne l’as pas déjà)
	private function _json($payload, $code = 200)
	{
		$this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($payload));
	}

	/**
	 * Convertit un chemin local ou une URL en data:image/...;base64,... 
	 * Retourne la data-uri ou '' en cas d'échec.
	 */
	protected function maybe_data_uri(string $pathOrUrl = ''): string
	{
		$pathOrUrl = trim($pathOrUrl);
		if ($pathOrUrl === '') return '';

		// si déjà data-uri
		if (strpos($pathOrUrl, 'data:') === 0) return $pathOrUrl;

		// déterminer si URL distante
		$isRemote = preg_match('#^https?://#i', $pathOrUrl);

		// Tentative de lecture
		$contents = false;
		if ($isRemote) {
			// Préférer curl pour robustesse
			if (function_exists('curl_init')) {
				$ch = curl_init($pathOrUrl);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 8);
				$contents = @curl_exec($ch);
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if ($contents === false || $httpCode >= 400) $contents = false;
			} elseif (ini_get('allow_url_fopen')) {
				$contents = @file_get_contents($pathOrUrl);
			}
		} else {
			// chemin local relatif/absolu
			if (file_exists($pathOrUrl)) {
				$contents = @file_get_contents($pathOrUrl);
			} else {
				// tenter en l'appendant à FCPATH si c'est un chemin relatif
				$possible = FCPATH . ltrim($pathOrUrl, '/\\');
				if (file_exists($possible)) $contents = @file_get_contents($possible);
			}
		}

		if ($contents === false) return '';

		// déterminer le mime type
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->buffer($contents) ?: 'image/png';
		$base64 = base64_encode($contents);
		return "data:{$mime};base64,{$base64}";
	}


	/**
	 * POST depuis le modal "Modifier le groupe d’annonce"
	 * Form action: Validation/updateDonneeClient
	 * Champs:
	 *   idgroupe_annonce (req), idcampagne, idclients,
	 *   nom_groupe, mot_cle, url_groupe_annonce,
	 *   titres (textarea lignes → titre1..12)
	 *   descriptions (textarea lignes → descriptions1..4)
	 */
	public function updateDonneeClient()
	{
		if (strtoupper($this->input->method()) !== 'POST') {
			show_error('Méthode non autorisée', 405);
		}

		$idg = (int) $this->input->post('idgroupe_annonce', true);
		if (!$idg) {
			$this->session->set_flashdata('error', 'ID groupe manquant');
			return $this->_redirect_back();
		}

		// Champs de base
		$payload = [
			'nom_groupe'         => $this->input->post('nom_groupe', true),
			'mot_cle'            => $this->input->post('mot_cle', true),
			'url_groupe_annonce' => $this->input->post('url_groupe_annonce', true),
		];

		// Type & champs conditionnels
		$type = $this->input->post('type_campagnes');
		$type = is_numeric($type) ? (int)$type : null;
		if ($type !== null) {
			$payload['type_campagnes'] = $type;
		}

		// Si type 1: chemins, sinon NULL
		$payload['chemin1'] = ($type === 1) ? $this->input->post('chemin1', true) : null;
		$payload['chemin2'] = ($type === 1) ? $this->input->post('chemin2', true) : null;

		// Si type 2/3: description_breve, sinon NULL
		$payload['description_breve'] = ($type === 2 || $type === 3) ? $this->input->post('description_breve', true) : null;

		// Titre1..12
		// Titres
		$titres_lines = preg_split('/\r\n|\r|\n/', (string)$this->input->post('titres'));
		$titres_lines = array_values(array_filter(
			array_map('trim', $titres_lines),
			function ($x) {
				return $x !== '';
			}
		));
		for ($i = 1; $i <= 12; $i++) {
			$payload['titre' . $i] = isset($titres_lines[$i - 1]) ? $titres_lines[$i - 1] : null;
		}

		// Descriptions
		$desc_lines = preg_split('/\r\n|\r|\n/', (string)$this->input->post('descriptions'));
		$desc_lines = array_values(array_filter(
			array_map('trim', $desc_lines),
			function ($x) {
				return $x !== '';
			}
		));
		for ($i = 1; $i <= 4; $i++) {
			$payload['descriptions' . $i] = isset($desc_lines[$i - 1]) ? $desc_lines[$i - 1] : null;
		}


		// '' -> NULL
		foreach ($payload as $k => $v) {
			if ($v === '') {
				$payload[$k] = null;
			}
		}

		$ok = $this->db->where('idgroupe_annonce', $idg)->update('groupe_annonce', $payload);

		$this->session->set_flashdata($ok ? 'success' : 'error', $ok ? 'Groupe mis à jour.' : 'Échec de la mise à jour du groupe.');

		return $this->_redirect_back();
	}


    /* ============================================================
     *                         HELPERS
     * ============================================================ */

	/**
	 * Retourne une data-uri si $pathOrUrl est un fichier local lisible.
	 * Sinon, retourne l’URL telle quelle (ou chaîne vide).
	 */


	/**
	 * Convertit un fichier image local en data-uri base64 (si lisible), sinon ''.
	 */
	private function encode_local_image_to_data_uri(string $absolutePath): string
	{
		if (is_file($absolutePath) && is_readable($absolutePath)) {
			$mime = @mime_content_type($absolutePath) ?: 'image/png';
			$data = @file_get_contents($absolutePath);
			if ($data !== false) {
				return 'data:' . $mime . ';base64,' . base64_encode($data);
			}
		}
		return '';
	}

	/**
	 * Redirige vers la page précédente ou, à défaut, vers Googleads.
	 */
	private function _redirect_back()
	{
		$ref = $this->input->server('HTTP_REFERER');
		if ($ref) {
			redirect($ref);
		} else {
			redirect('Googleads');
		}
	}
	public function export_rendu($idclient = null)
	{
		$id = $idclient;

		// Récupérer campagnes + groupes + images
		$campagnes = $this->visuels_model->get_campagnes_by_client($idclient);
		if (!is_array($campagnes)) $campagnes = [];

		foreach ($campagnes as &$C) {
			// Récupérer les groupes
			$C['groupes_annonces'] = $this->visuels_model->get_groupes_by_campagne($C['idcampagne']);

			// Récupérer images liées à la campagne et convertir en data-uri
			$imgs = $this->Image_model->get_images_by_campagne($C['idcampagne']);
			$C['images'] = [];
			if (is_array($imgs)) {
				foreach ($imgs as $img) {
					$url = is_object($img) ? ($img->image_url ?? '') : (is_array($img) ? ($img['image_url'] ?? '') : $img);
					$dataUri = $this->_image_to_datauri($url);
					$C['images'][] = [
						'image_url' => $url,
						'image_base64' => $dataUri
					];
				}
			}
		}
		unset($C);

		// Préparer données pour la vue PDF
		$this->data['campagnes'] = $campagnes;
		$this->data['id'] = $id;
		$this->data['is_pdf'] = true;

		// Logo en base64 si tu t'en sers
		$logo_path = FCPATH . IMAGES_PATH . '/logo/logo3.png';
		if (file_exists($logo_path)) {
			$logo_type = mime_content_type($logo_path) ?: 'image/png';
			$logo_data = base64_encode(file_get_contents($logo_path));
			$this->data['logo_base64'] = "data:{$logo_type};base64,{$logo_data}";
		} else {
			$this->data['logo_base64'] = '';
		}

		// Charger la vue PDF dédiée
		$html = $this->load->view('templates/v3/Validation_structure', $this->data, TRUE);

		// Sauvegarde de debug (optionnel)
		file_put_contents(FCPATH . 'debug_validation_structure_pdf.html', $html);

		// Dompdf
		$options = new \Dompdf\Options();
		$options->set('isRemoteEnabled', true);
		$options->set('defaultFont', 'DejaVu Sans');

		$dompdf = new \Dompdf\Dompdf($options);
		$dompdf->setPaper('A4', 'portrait'); // portrait = campagne page + groupes page par page vertical
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->render();

		$filename = 'validation_campagne_' . ($id ?? date('Ymd_His')) . '.pdf';
		$dompdf->stream($filename, ['Attachment' => 0]);
		exit;
	}
	public function update_campagne_field()
	{
		$this->output->set_content_type('application/json');

		$id   = (int) $this->input->post('id');
		$fld  = trim($this->input->post('field', true));
		$val  = $this->input->post('value', true);

		if (!$id || !$fld) return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Paramètres manquants.']));

		// Whitelist stricte des colonnes éditables
		$allowed = [
			'nom_campagne',
			'zones',
			'date_campagne',
			'appareil',
			'repartition_budget',
			'url_site',
			'age',
			'cible',
			'Mots_cle_exclus'
		];
		if (!in_array($fld, $allowed, true)) {
			return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Champ non autorisé.']));
		}

		$ok = $this->db->where('idcampagne', $id)->update('campagne', [$fld => $val]);
		return $this->output->set_output(json_encode(['ok' => $ok ? true : false]));
	}

	public function update_groupe_field()
	{
		$this->output->set_content_type('application/json');

		$id   = (int) $this->input->post('id');
		$fld  = trim($this->input->post('field', true));
		$val  = $this->input->post('value', true);

		if (!$id || !$fld) return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Paramètres manquants.']));

		// Whitelist des champs éditables dans groupe_annonce
		$allowed = [
			'nom_groupe',
			'mot_cle',
			'url_groupe_annonce',
			'repartition_budget',
			'titre1',
			'titre2',
			'titre3',
			'titre4',
			'titre5',
			'titre6',
			'titre7',
			'titre8',
			'titre9',
			'titre10',
			'titre11',
			'titre12',
			'descriptions1',
			'descriptions2',
			'descriptions3',
			'descriptions4'
		];
		if (!in_array($fld, $allowed, true)) {
			return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Champ non autorisé.']));
		}

		$ok = $this->db->where('idgroupe_annonce', $id)->update('groupe_annonce', [$fld => $val]);
		return $this->output->set_output(json_encode(['ok' => $ok ? true : false]));
	}

	/** Helper pour convertir une image (URL ou chemin local) en data URI */
	private function _image_to_datauri($url)
	{
		if (empty($url)) return '';

		if (strpos($url, 'data:') === 0) return $url;

		// remote URL
		if (strpos($url, 'http') === 0) {
			$content = @file_get_contents($url);
			if ($content !== false) {
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_buffer($finfo, $content);
				finfo_close($finfo);
				return 'data:' . $mime . ';base64,' . base64_encode($content);
			}
			return $url;
		}

		// local file - construire chemin absolu
		$path = (is_file($url)) ? $url : FCPATH . ltrim($url, '/\\');
		if (is_file($path)) {
			$content = file_get_contents($path);
			$mime = mime_content_type($path) ?: 'image/jpeg';
			return 'data:' . $mime . ';base64,' . base64_encode($content);
		}

		return $url;
	}


	public function resize_and_compress_image($image_path, $max_width = 400, $max_height = 300, $quality = 30)
	{
		if (!file_exists($image_path)) {
			return '';
		}

		// Obtenir les dimensions et le type d'image
		list($original_width, $original_height, $image_type) = getimagesize($image_path);

		// Calculer les nouvelles dimensions
		$ratio = min($max_width / $original_width, $max_height / $original_height);
		$new_width = (int)($original_width * $ratio);
		$new_height = (int)($original_height * $ratio);

		// Créer une image vide (fond blanc pour éviter la transparence)
		$new_image = imagecreatetruecolor($new_width, $new_height);
		$white = imagecolorallocate($new_image, 255, 255, 255);
		imagefill($new_image, 0, 0, $white);

		// Créer l'image source selon le type
		switch ($image_type) {
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($image_path);
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($image_path);
				break;
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif($image_path);
				break;
			default:
				return '';
		}

		// Redimensionnement
		imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

		// Conversion en JPEG avec compression forte
		ob_start();
		imagejpeg($new_image, null, $quality);
		$compressed_image_data = ob_get_clean();

		// Nettoyer
		imagedestroy($new_image);
		imagedestroy($image);

		// Retourner en base64
		return 'data:image/jpeg;base64,' . base64_encode($compressed_image_data);
	}






	/**
	 * Convertit une URL (ou chemin local) d'image en data URI base64.
	 * Retourne l'URL d'origine si l'encodage échoue.
	 */
	private function _remote_to_base64($url)
	{
		if (empty($url)) return $url;
		// si c'est déjà un data-uri, on retourne tel quel
		if (strpos($url, 'data:') === 0) return $url;

		// essayer récupérer le contenu (attention allow_url_fopen ou curl)
		$imageContent = @file_get_contents($url);
		if ($imageContent === false) {
			// fallback : essayer curl
			if (function_exists('curl_init')) {
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$imageContent = curl_exec($ch);
				curl_close($ch);
			}
		}

		if ($imageContent === false || $imageContent === null) {
			// on renvoie l'URL d'origine si impossible
			return $url;
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_buffer($finfo, $imageContent);
		finfo_close($finfo);

		$base64 = 'data:' . $mime . ';base64,' . base64_encode($imageContent);
		return $base64;
	}
	public function editcampagne($id)
	{
		// Récupérer les données de la campagne
		$t = $this->data["campagne"] = $this->visuels_model->getCAMPAGNEByIdc($id);
		$t = $t[0]['idcampagne'];

		// Récupérer les groupes d'annonces
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdg($id);

		// Charger la vue pour éditer la campagne
		$this->load->view("templates/v3/edit_campagne_structure", $this->data);
	}


	public function editgroupesearch($id)
	{
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);

		$this->load->view("templates/v3/edit_groupe_structure_search", $this->data);
	}

	public function editgroupelocal($id)
	{
		$id = intval($id);
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);

		$this->load->view("templates/v3/edit_groupe_structure_local", $this->data);
	}

	public function editgroupepmax($id)
	{
		$id = intval($id);

		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);

		$this->load->view("templates/v3/edit_groupe_structure_local", $this->data);
	}

	public function editgroupe($id)
	{
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdgs($id);

		// Charger la vue pour éditer la campagne
		$this->load->view("templates/v3/edit_groupe_structure", $this->data);
	}

	public function save_groupe_search()
	{
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

	public function save_groupe_local()
	{
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

	public function save_groupe_pmax()
	{
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





	private function set_upload_options($prefix, $filename)
	{
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
	// --- Récupérer les images d'une URL (scraping simple) ---
	public function fetch_images_campagnes()
	{
		$this->output->set_content_type('application/json');

		$url = trim((string)$this->input->post('url', true));
		if ($url === '' || !preg_match('#^https?://#i', $url)) {
			return $this->output->set_output(json_encode(['success' => false, 'msg' => 'URL invalide']));
		}

		// Récupération HTML (cURL > file_get_contents)
		$html = $this->_curl_get($url);
		if ($html === false) {
			return $this->output->set_output(json_encode(['success' => false, 'msg' => 'Impossible de charger la page']));
		}

		// Parse <img src>
		$images = $this->_extract_images_from_html($html, $url);
		// Filtrer doublons + formats douteux
		$images = array_values(array_unique(array_filter($images, function ($u) {
			if (!$u) return false;
			// ignorer data uri très longues
			if (strpos($u, 'data:image') === 0) return strlen($u) < 2 * 1024 * 1024; // <2MB pour l’UI
			// extensions usuelles
			return preg_match('#\.(png|jpg|jpeg|gif|webp)(\?.*)?$#i', parse_url($u, PHP_URL_PATH) ?? '') === 1;
		})));

		return $this->output->set_output(json_encode([
			'success' => true,
			'images'  => $images
		]));
	}

	// --- Sauvegarder les images sélectionnées pour un groupe/campagne ---
	public function save_images_for_group()
	{
		$this->output->set_content_type('application/json');

		$idclients        = (int)$this->input->post('idclients');
		$idcampagne       = (int)$this->input->post('idcampagne');
		$idgroupe_annonce = (int)$this->input->post('idgroupe_annonce');
		$imagesCsv        = (string)$this->input->post('images'); // CSV d’URLs ou data-uri

		if (!$idclients || !$idcampagne || !$idgroupe_annonce) {
			return $this->output->set_output(json_encode(['success' => false, 'msg' => 'IDs manquants']));
		}

		$images = array_values(array_filter(array_map('trim', explode(',', $imagesCsv))));
		if (empty($images)) {
			return $this->output->set_output(json_encode(['success' => false, 'msg' => 'Aucune image']));
		}

		// Option: effacer l’existant pour ce groupe (sinon on append)
		$this->db->where([
			'idclients'        => $idclients,
			'idcampagne'       => $idcampagne,
			'idgroupe_annonce' => $idgroupe_annonce
		])->delete('images');

		// Insert (rank ordonné)
		$rank = 1;
		foreach ($images as $src) {
			$this->db->insert('images', [
				'idclients'        => $idclients,
				'idcampagne'       => $idcampagne,
				'idgroupe_annonce' => $idgroupe_annonce,
				'image_url'        => $src,
				'rank'             => $rank++
			]);
		}

		return $this->output->set_output(json_encode(['success' => true]));
	}

	/* ========== helpers scraping ========== */

	private function _curl_get(string $url)
	{
		if (!function_exists('curl_init')) {
			// fallback
			$ctx = stream_context_create(['http' => ['timeout' => 10, 'header' => "User-Agent: Mozilla/5.0\r\n"]]);
			return @file_get_contents($url, false, $ctx);
		}

		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CONNECTTIMEOUT => 8,
			CURLOPT_TIMEOUT        => 12,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_USERAGENT      => 'Mozilla/5.0',
		]);
		$out = curl_exec($ch);
		curl_close($ch);
		return $out;
	}

	private function _extract_images_from_html(string $html, string $baseUrl): array
	{
		$images = [];
		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		// Charger en UTF-8
		@$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
		libxml_clear_errors();

		$tags = $dom->getElementsByTagName('img');
		foreach ($tags as $tag) {
			$src = $tag->getAttribute('src');
			if (!$src) continue;
			$images[] = $this->_absolutize_url($src, $baseUrl);
		}
		return $images;
	}

	private function _absolutize_url(string $maybeRelative, string $base): string
	{
		if (preg_match('#^https?://#i', $maybeRelative) || strpos($maybeRelative, 'data:image') === 0) {
			return $maybeRelative;
		}
		// composer une URL absolue
		$baseParts = parse_url($base);
		if (!$baseParts || empty($baseParts['scheme']) || empty($baseParts['host'])) return $maybeRelative;

		$scheme = $baseParts['scheme'];
		$host   = $baseParts['host'];
		$port   = isset($baseParts['port']) ? ':' . $baseParts['port'] : '';
		$path   = isset($baseParts['path']) ? $baseParts['path'] : '/';

		if (substr($maybeRelative, 0, 1) === '/') {
			$absPath = $maybeRelative;
		} else {
			$dir = rtrim(dirname($path), '/\\');
			$absPath = $dir . '/' . $maybeRelative;
		}

		// normaliser ../ ./ dans le path
		$segments = [];
		foreach (explode('/', $absPath) as $part) {
			if ($part === '' || $part === '.') continue;
			if ($part === '..') {
				array_pop($segments);
				continue;
			}
			$segments[] = $part;
		}
		$absPath = '/' . implode('/', $segments);

		return $scheme . '://' . $host . $port . $absPath;
	}
}
