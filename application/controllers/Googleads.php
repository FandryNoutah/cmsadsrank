<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Googleads extends MY_Controller
{

	protected $file_upload_field;


	public function __construct()
	{
		parent::__construct();

		// $this->load->model("visuels_model");
		// $this->load->model("concurrent");
		// $this->load->model("Donne_modele");
		// $this->load->model("Data_modele");
		// $this->load->model("Image_model");
		// $this->load->model("Message_model");
		// $this->load->model("Task_model");
		// $this->data['visuels'] = $this->visuels_model->get_all();
		// $this->load->library('PHPExcel');
		// $this->load->library('excel');
		// $this->load->helper(array('form', 'url'));
		// $this->load->library('curl');
		// $this->path = "assets/images/formats/";
		// $this->file_upload_field = "visuel_path";

		// $this->load->library('upload');
		// $this->load->library('form_validation');
		//$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

	}

	public function index()
	{
		
		// $month_filter = $this->input->get('month_filter');
		// if (isset($month_filter)) {
		// 	$ko = $this->data['donnee'] = $this->visuels_model->getClientDataByDonneeWithMonth($month_filter);
		// } else {
		// 	$ko = $this->data['donnee'] = $this->visuels_model->getClientDataByDonneesuperieur();
		// }

		// $this->data['users'] = $this->Task_model->get_all_users();
		// $this->data['produit'] = $this->Donne_modele->get_all_produit();
		// $this->data['am'] = $this->Donne_modele->get_all_am();
		// $this->data['initiative'] = $this->Donne_modele->get_all_initiative();
		// $this->page = "templates/v3/admin-google-ads.php";
		$this->content = "layouts/admin/googleads.php";
		$this->layout();
	}

	public function ajoutremarqueCampagne()
	{
		// Récupération des données POST
		$idonnee = $this->input->post('idonnee');
		$remarque = $this->input->post('remarque');
		$fichier_nom = null;

		// Chargement de la bibliothèque d'upload
		$this->load->library('upload');

		// Vérification du fichier
		if (isset($_FILES['fichier']) && $_FILES['fichier']['name'] != '') {

			// Configuration de l'upload
			$config['upload_path']   = './uploads/';
			$config['allowed_types'] = 'jpg|png|gif|pdf|doc|docx|xls|xlsx|csv';

			$config['max_size']      = 2048; // Taille max en Ko (2 Mo)
			$config['encrypt_name']  = FALSE; // Renomme le fichier

			// Initialisation de l'upload
			$this->upload->initialize($config);

			// Tentative d'upload
			if ($this->upload->do_upload('fichier')) {
				$uploadData = $this->upload->data();
				$fichier_nom = 'uploads/' . $uploadData['file_name'];
			} else {
				$error = $this->upload->display_errors();
				log_message('error', 'Échec de l\'upload: ' . $error);
				echo 'Erreur lors de l\'upload : ' . $error;
				return;
			}
		}

		// Appel du modèle avec le vrai nom de fichier (ou null)
		$idclients = $this->visuels_model->insert_remarque_campagne($remarque, $idonnee, $fichier_nom);

		// Redirection
		redirect('Googleads/campagne/' . $idclients);
	}







	public function completed_tasks()
	{
		$data['tasks'] = $this->Task_model->get_completed_tasks();
		$this->load->view('completed_tasks', $data);
	}

	// Ajouter une tâche
	public function add_task()
	{
		// Récupérer l'id du client
		$idclients = $this->input->post('idclients');

		// On valide le formulaire
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Titre de la tâche', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('user_id', 'Utilisateur', 'required');
		$this->form_validation->set_rules('status', 'Statut', 'required');

		if ($this->form_validation->run() === FALSE) {
			// Si la validation échoue, retourner à la même page
			$this->load->view('add_task');
		} else {
			// Si la validation réussit, ajouter la tâche à la base de données
			$data = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'assigned_to' => $this->input->post('user_id'),
				'status' => $this->input->post('status'),
				'idclients' => $this->input->post('idclients')
			);

			// On charge le modèle et on ajoute la tâche
			$this->load->model('Task_model');
			$this->Task_model->add_task($data);

			// Rediriger après l'ajout de la tâche
			redirect('Googleads/plandetaggage/' . $idclients);
		}
	}

	public function edit_task()
	{
		$idclients = $this->input->post('idclients');
		$taskId = $this->input->post('idtask');
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$assignedTo = $this->input->post('user_id');
		$status = $this->input->post('status');

		// Appel à un modèle pour mettre à jour la tâche dans la base de données
		$this->Task_model->update_task($taskId, $title, $description, $assignedTo, $status);

		// Rediriger vers une page avec un message de succès
		$this->session->set_flashdata('message', 'Tâche mise à jour avec succès');
		redirect('Googleads/plandetaggage/' . $idclients);
	}


	// Modifier le statut d'une tâche (effectuée, annulée)
	public function update_task($task_id)
	{
		$data = array(
			'status' => $this->input->post('status')
		);
		$this->Task_model->update_task($task_id, $data);
		redirect('taskcontroller/index');
	}

	// Supprimer une tâche
	public function delete_task()
	{
		// Récupérer l'ID de la tâche et l'ID du client depuis l'URL
		$task_id = $this->input->get('id');  // Récupère l'ID de la tâche
		$idclients = $this->input->get('client_id');  // Récupère l'ID du client
		$this->Task_model->delete_task($task_id);
		redirect('Googleads/plandetaggage/' . $idclients);
		$this->layout();
	}

	public function deleteplandetagggage($id)
	{
		$idclients = $this->Donne_modele->getidclientsbypladetaggage($id);


		$idclients = $idclients[0]['idclients'];
		$idclients = intval($idclients);

		$this->Donne_modele->deleteplandetaggage($id);
		$this->session->set_flashdata('success', "Extensions supprimer");
		redirect('Googleads/plandetaggage/' . $idclients);
		$this->layout();
	}

	public function updateEtat()
	{
		// Récupérer les données envoyées par le formulaire
		$idplandetaggage = $this->input->post('idplandetaggage');
		$idclients = $this->input->post('idclients');
		$etat = $this->input->post('etat');

		$updateSuccess = $this->Donne_modele->updateEtat($idplandetaggage, $etat);

		// Vérifier si la mise à jour a réussi
		if ($updateSuccess) {
			// Ajouter un message flash pour informer de la réussite
			$this->session->set_flashdata('message', 'État mis à jour avec succès.');
		} else {
			// Ajouter un message flash pour informer de l'échec
			$this->session->set_flashdata('message', 'Une erreur est survenue lors de la mise à jour.');
		}

		// Rediriger vers la page précédente ou la page souhaitée
		redirect('Googleads/plandetaggage/' . $idclients);
	}
	// Méthode pour mettre à jour les données
	public function updateData()
	{
		// Vérifier si la requête est une requête POST
		if ($this->input->method() === 'post') {
			// Récupérer les données envoyées via POST
			$data = $this->input->post();

			// Récupérer l'ID de la ligne et les autres champs
			$rowId = $data['rowId'];
			$conversion = $data['conversion'];
			$actions = $data['actions'];
			$types = $data['types'];
			$remarque = $data['remarque'];
			$conditions = $data['conditions'];
			$conversion_id = $data['conversion_id'];
			$conversion_label = $data['conversion_label'];
			$etat = $data['etat'];


			// Mettre à jour les données dans la base de données
			$updateData = [
				'conversion' => $conversion,
				'actions' => $actions,
				'types' => $types,
				'remarque' => $remarque,
				'conditions' => $conditions,
				'conversion_id' => $conversion_id,
				'conversion_label' => $conversion_label,
				'etat' => $etat
			];

			// Mettre à jour la base de données (assure-toi d'avoir un modèle ou une méthode pour cela)
			$this->db->where('idplan_de_taggage', $rowId);
			$this->db->update('plan_de_taggage', $updateData);

			// Retourner un message de succès
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
		}
	}


	public function update_conversion()
	{
		$id = $this->input->post('id'); // ID du plan de taggage
		$column = $this->input->post('column'); // Colonne à mettre à jour
		$value = $this->input->post('value'); // Nouvelle valeur

		// Mettre à jour la base de données
		$data = array($column => $value);
		$update = $this->Donne_modele->update_conversion($id, $data);

		// Retourner une réponse JSON
		if ($update) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}


	public function ajout_type_plan_taggage()
	{
		$idclients = $this->input->post('idclients');
		$choix = $this->input->post('choix');
		if ($choix == "lead") {
			$conversions = [
				['idclients' => $idclients, 'conversion' => 'Lead - Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton chat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => '']
			];
		}
		if ($choix == "ecommerce") {
			$conversions = [
				['idclients' => $idclients, 'conversion' => 'Lead | Achat', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a réalisé un achat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le begin checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d appel téléphonique ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le téléphone', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur l email', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a utilisé le chat pour entrer en contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => '']
			];
		}
		if ($choix == "reservation") {
			$conversions = [
				['idclients' => $idclients, 'conversion' => 'Lead | Réservation', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a effectué une réservation', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact sur la page dédiée', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page produit', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une autre page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une autre page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une autre page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un autre bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => '']
			];
		}
		$this->Donne_modele->insert_conversions($conversions);
		$this->Donne_modele->update_type_clients($choix, $idclients);
		redirect('Googleads/campagne/' . $idclients);
		$this->layout();
	}
	public function send_message()
	{
		$sender_id = $this->input->post('sender_id');
		$receiver_id = $this->input->post('receiver_id');
		$message = $this->input->post('message');

		// Enregistrer le message dans la base de données
		$message_id = $this->Message_model->send_message($sender_id, $receiver_id, $message);

		// Récupérer l'heure du message
		$timestamp = date('H:i');

		// Retourner une réponse avec l'ID, le sender_id et l'heure
		echo json_encode([
			'id' => $message_id,
			'sender_id' => $sender_id,  // Ajouter sender_id dans la réponse
			'timestamp' => $timestamp
		]);
	}
	public function delete_message()
	{
		// Vérifie si l'utilisateur est connecté
		if ($this->ion_auth->logged_in()) {
			$message_id = $this->input->post('message_id');
			if ($message_id) {
				// Suppression du message dans la base de données
				$this->Message_model->delete_message($message_id);
				echo json_encode(['status' => 'success']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'ID du message manquant']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
		}
	}




	public function vision_globale($id)
	{
		// Récupérer les données des campagnes
		$donnees_valider = $this->Donne_modele->getclientvalidations($id);

		// Récupérer les groupes d'annonces
		$groupes_valider = $this->Donne_modele->getgroupevalidations($id);

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
		$this->data["extensions"] = $this->visuels_model->getextensions($id);
		// Passer les données à la vue
		$this->data["donne_valider"] = $donnees_valider;
		$this->data["groupe_valider"] = $groupes_valider;
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$a = $this->Donne_modele->getpmaxnonvalider($id);
		if ($a != NULL):
			$idgroupe_annonce = $a[0]['idgroupe_annonce'];
			$idgroupe_annonce = intval($idgroupe_annonce);
			$id = intval($id);

			$g = $this->data["images"] = $this->Image_model->get_images_by_clients($id, $idgroupe_annonce);
		endif;
		$this->load->view("templates/v3/vision_globale", $this->data);
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
			redirect('Googleads/gestion_image/' . $idgroupe_annone);
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
	}

	public function gestion_image($id)
	{
		$v =  $data['idgroupe_annone'] = $id;

		$b =  $data['clients'] = $this->Image_model->getgroupe_annonce($id);

		$a = $data['images'] = $this->Image_model->get_images_by_id($id);
		$domain_name = $this->input->post('domain_name');

		$this->load->helper('url');
		$html = $this->get_html_from_url($domain_name); // Implémenter cette méthode

		// Extraire les images
		$images = $this->extract_images($html, $domain_name);

		// Charger la vue et passer les variables
		$data['html'] = $html;   // Passez la variable $html à la vue
		$data['Images_recup'] = $images;

		$this->load->view('image_list', $data);
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
		$id = $this->input->post('idgroupe_annone');
		$idgroupe_annone = $id;
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
		redirect('googleads/gestion_image/' . $id, 'refresh');
	}

	// Ajouter une image depuis une URL
	public function add_image_url()
	{
		$image_url = $this->input->post('image_url');
		$id = $this->input->post('idgroupe_annone');
		$idgroupe_annone = $id;
		$idclients = $this->input->post('idclients');

		// Vérifier que l'URL n'est pas vide
		if (!empty($image_url)) {
			// Vérifier si l'URL est valide
			if (@getimagesize($image_url)) {
				// Si l'URL est valide et pointe vers une image, insérer dans la base de données
				$idimage = $this->Image_model->insert_image($image_url, $idclients, $idgroupe_annone, 0);
				$this->Image_model->insertidgroupeimage($idimage, $id);
				redirect('googleads/gestion_image/' . $id);
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
		redirect('googleads/gestion_image/' . $id);
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

	public function upload_favicon_pmax()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$favicon = $this->input->post('favicon'); // On récupère le logo existant

		// Vérification et téléchargement du logo
		if ($_FILES['favicon']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["favicon"]["name"]));
			if ($this->upload->do_upload('favicon')) {
				$favicon = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$this->Donne_modele->changefavicons($favicon, $idgroupe_annonce);
		$id = $idgroupe_annonce;

		redirect("Googleads/ajout_groupeannonce_pmax/" . $idgroupe_annonce);
	}
	public function upload_logo_pmax()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$logos = $this->input->post('logos'); // On récupère le logo existant

		// Vérification et téléchargement du logo
		if ($_FILES['logos']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
			if ($this->upload->do_upload('logos')) {
				$logos = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$this->Donne_modele->changelogo($logos, $idgroupe_annonce);
		$this->Donne_modele->changelogoclients($logos, $idclients);
		$id = $idgroupe_annonce;

		redirect("Googleads/ajout_groupeannonce_pmax/" . $idgroupe_annonce);
	}
	public function upload_logo_local()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$logos = $this->input->post('logos'); // On récupère le logo existant

		// Vérification et téléchargement du logo
		if ($_FILES['logos']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
			if ($this->upload->do_upload('logos')) {
				$logos = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$this->Donne_modele->changelogo($logos, $idgroupe_annonce);
		$this->Donne_modele->changelogoclients($logos, $idclients);
		$id = $idgroupe_annonce;

		redirect("Googleads/ajout_groupeannonce_local/" . $idgroupe_annonce);
	}
	public function gestion_extension($id)
	{

		$this->data["clients"] = $this->visuels_model->getClientById($id);
		$this->data["extensions"] = $this->visuels_model->getextensions($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->page = "templates/v3/gestion_extension";
		$this->layout();
	}
	public function exclusion()
	{
		$exclusion = $this->input->post('exclusion');
		$id = $this->input->post('idclients');
		$id = intval($id);

		$this->visuels_model->exclusion($id, $exclusion);
		$this->session->set_flashdata('message-exclusion', 'Exclusion mis à jours.');
		redirect('Googleads/gestion_extension/' . $id, 'refresh');
	}

	public function plandetaggage($id)
	{
		if ($this->ion_auth->logged_in()) {
			$current_user = $this->ion_auth->user()->row();
			$this->data['donnee'] = $this->visuels_model->getClientDataByDonneewithpmax();
			$t = $this->data["tasks"] = $this->Task_model->get_all_tasks_by_idclients($id);

			$c = $this->data["users"] = $this->Message_model->get_all_users_except_current($current_user->id);
			// Récupérer les messages de l'utilisateur
			$this->data["messages"] = $this->Message_model->get_messages_for_user($current_user->id);
			$this->data["clients"] = $this->visuels_model->getClientById($id);
			$this->data["plan_taggage"] = $this->visuels_model->getplantaggage($id);

			$this->page = "templates/v3/plan_de_taggage1";
			$this->layout();
		}
	}

	public function ajoutextension($id)
	{
		$this->data["idcampagne"] = $id;
		$idclients = $this->visuels_model->getglientbycampagnes($id);
		$idclients = intval($idclients[0]['idclients']);
		$id = $idclients;
		$this->data["clients"] = $this->visuels_model->getClientById($id);
		$this->session->set_flashdata('message-ajout-extensions', 'Extenions ajouter.');
		$this->page = "templates/v3/ajout_extension";
		$this->layout();
	}
	public function ajoutplandetaggage($id)
	{
		$this->data["clients"] = $this->visuels_model->getClientById($id);
		$this->page = "templates/v3/ajout_plan_de_taggage";
		$this->layout();
	}
	public function Ajoutextensions()
	{
		$idclients = $this->input->post('idclients');
		$extensions_accroche = $this->input->post('extensions_accroche');
		$extensions_extrait_site = $this->input->post('extensions_extrait_site');
		$extensions_lieu = $this->input->post('extensions_lieu');
		$extensions_appel = $this->input->post('extensions_appel');

		// Initialisation du tableau pour les extensions
		$data_extensions = array();

		// Boucle pour préparer les données à insérer
		foreach ($_POST['titre_extensions'] as $index => $titre_extension) {
			$data_extensions[] = array(
				'titre_extensions' => $titre_extension,
				'description_extensions' => isset($_POST['description_extensions'][$index]) ? $_POST['description_extensions'][$index] : '',
				'url_extensions' => isset($_POST['url_extensions'][$index]) ? $_POST['url_extensions'][$index] : '',
				'idclients' => $idclients,
				'extensions_accroche' => $extensions_accroche,
				'extensions_extrait_site' => $extensions_extrait_site,
				'extensions_lieu' => $extensions_lieu,
				'extensions_appel' => $extensions_appel
			);
		}


		// Insérer les données dans la base de données
		if ($this->visuels_model->insert_extensions($data_extensions)) {
			// Si l'insertion réussit, rediriger vers la page de campagne
			redirect('Googleads/gestion_extension/' . $idclients, 'refresh');
		} else {
			// Si une erreur se produit, afficher un message d'erreur
			$this->session->set_flashdata('error', 'Erreur lors de l\'ajout des extensions');
			redirect('Googleads/gestion_extension/' . $idclients, 'refresh');
		}

		// Cette ligne ne sera pas exécutée si tu utilises redirect
		$this->layout();
	}

	public function Ajoutplantaggage()
	{
		$idclients = $this->input->post('idclients');
		$conversion = $this->input->post('conversion');
		$actions = $this->input->post('actions');
		$types = $this->input->post('types');
		$remarque = $this->input->post('remarque');
		$etat = $this->input->post('etat');
		$conditions = $this->input->post('conditions');
		$conversion_id = $this->input->post('conversion_id');
		$convarsion_label = $this->input->post('convarsion_label');
		$data_extensions = array();
		$data_extensions[] = array(
			'idclients' => $idclients,
			'conversion' => $conversion,
			'actions' => $actions,
			'types' => $types,
			'remarque' => $remarque,
			'etat' => $etat,
			'conditions' => $conditions,
			'conversion_id' => $conversion_id,
			'conversion_label' => $convarsion_label
		);



		// Insérer les données dans la base de données
		$this->visuels_model->insert_plan_de_taggage($data_extensions);
		// Si l'insertion réussit, rediriger vers la page de campagne

		$this->session->set_flashdata('message', 'Plan de taggage ajouter.');
		redirect('Googleads/plandetaggage/' . $idclients, 'refresh');
		$this->layout();
	}


	public function upload_logo()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$logos = $this->input->post('logos'); // On récupère le logo existant

		// Vérification et téléchargement du logo
		if ($_FILES['logos']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
			if ($this->upload->do_upload('logos')) {
				$logos = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$this->Donne_modele->changelogo($logos, $idgroupe_annonce);
		$id = $idgroupe_annonce;

		redirect("Googleads/Visualiserpmax/" . $id);
	}
	public function upload_logos()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$logos = $this->input->post('logos'); // On récupère le logo existant

		// Vérification et téléchargement du logo
		if ($_FILES['logos']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
			if ($this->upload->do_upload('logos')) {
				$logos = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$this->Donne_modele->changelogo($logos, $idgroupe_annonce);
		$id = $idgroupe_annonce;

		redirect("Googleads/Visualiserlocal/" . $id);
	}
	public function upload_favicon()
	{
		// Charger la bibliothèque d'upload
		$this->load->library('upload');
		$this->load->helper('url');  // Pour base_url() si nécessaire

		// Configuration de l'upload
		$config['upload_path'] = './uploads/favicon/';  // Le répertoire où vous voulez stocker le favicon
		$config['allowed_types'] = 'ico|jpg|png|jpeg';  // Types d'image autorisés
		$config['max_size'] = 1024;  // Taille maximale en Ko
		$config['file_name'] = 'favicon_' . time();  // Nom de fichier unique

		$this->upload->initialize($config);

		// Vérifier si l'upload est réussi
		if ($this->upload->do_upload('favicon')) {
			$data = $this->upload->data();

			// Mettre à jour le chemin du favicon dans la base de données si nécessaire
			$favicon_path = 'uploads/favicon/' . $data['file_name'];

			// Optionnel : mettre à jour le favicon dans la base de données
			// Exemple : $this->update_favicon($favicon_path);

			// Retourner la nouvelle URL du favicon en JSON
			echo json_encode(['favicon_url' => base_url($favicon_path)]);
		} else {
			// Si l'upload échoue, renvoyer une erreur JSON
			echo json_encode(['error' => $this->upload->display_errors()]);
		}
	}
	public function editgroupepmaxtech($id)
	{
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdgs($id);

		// Charger la vue pour éditer la campagne
		$this->load->view("templates/v3/edit_groupe_structure_tech", $this->data);
	}
	public function editgroupelocaltech($id)
	{
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdgs($id);

		// Charger la vue pour éditer la campagne
		$this->load->view("templates/v3/edit_groupe_structure_tech_local", $this->data);
	}


	public function updateDonneeClientss()
	{
		// Récupérer les données envoyées par POST
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$type = $this->input->post('type_campagne');
		$data = array(
			'idgroupe_annonce' => $this->input->post('idgroupe_annonce'),
			'idcampagne' => $this->input->post('idcampagne'),
			'idclients' => $this->input->post('idclients'),
			'type_campagnes' => $this->input->post('type_campagne'),
			'nom_groupe' => $this->input->post('nom_groupe'),
			'titre1' => $this->input->post('titre1'),
			'titre2' => $this->input->post('titre2'),
			'titre3' => $this->input->post('titre3'),
			'titre4' => $this->input->post('titre4'),
			'titre5' => $this->input->post('titre5'),
			'titre6' => $this->input->post('titre6'),
			'titre7' => $this->input->post('titre7'),
			'titre8' => $this->input->post('titre8'),
			'titre9' => $this->input->post('titre9'),
			'titre10' => $this->input->post('titre10'),
			'titre11' => $this->input->post('titre11'),
			'titre12' => $this->input->post('titre12'),
			'descriptions1' => $this->input->post('description1'),
			'descriptions2' => $this->input->post('description2'),
			'descriptions3' => $this->input->post('description3'),
			'descriptions4' => $this->input->post('description4'),
			'description_breve' => $this->input->post('description_breve'),
			'url_groupe_annonce' => $this->input->post('url')
		);
		if ($type == 3) {
			if ($this->Donne_modele->updateDonneesClientss($idgroupe_annonce, $data)) {
				redirect('Googleads/Visualiserpmax/' . $this->input->post('idgroupe_annonce'));
			} else {
				redirect('Googleads/Visualiserpmax/' . $this->input->post('idgroupe_annonce'));
			}
		}
		if ($type == 2) {
			if ($this->Donne_modele->updateDonneesClientss($idgroupe_annonce, $data)) {
				redirect('Googleads/Visualiserlocal/' . $this->input->post('idgroupe_annonce'));
			} else {
				redirect('Googleads/Visualiserlocal/' . $this->input->post('idgroupe_annonce'));
			}
		}
	}





	public function updateextensions()
	{
		$idclients = $this->input->post('idclients');
		$idextensions = $this->input->post('idextensions');
		$data = array(
			'idextensions' => $this->input->post('idextensions'),
			'titre_extensions' => $this->input->post('titre_extensions'),
			'description_extensions' => $this->input->post('description_extensions'),
			'url_extensions' => $this->input->post('url_extensions'),
			'extensions_accroche' => $this->input->post('extensions_accroche'),
			'extensions_extrait_site' => $this->input->post('extensions_extrait_site'),
			'extensions_lieu' => $this->input->post('extensions_lieu'),
			'extensions_appel' => $this->input->post('extensions_appel')
		);
		$this->Donne_modele->updateextensions($idextensions, $data);
		$this->session->set_flashdata('message-success', 'Extenions mis à jours.');
		redirect('Googleads/gestion_extension/' . $idclients);
	}





	public function insertgroupeannonce($id)
	{
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$c = $this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);

		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);
		$this->data["search"] = $this->visuels_model->getgpid($id);
		$k = $this->visuels_model->getclientbyannonce($id);
		$id = $k[0]['idclients'];
		$id = intval($id);
		$ko = $id;

		$this->data["client"] = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		//$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id); 
		$this->page = "templates/v3/ajout_groupe_annonce_technique";
		$this->layout();
	}
	public function validation_structure()
	{
		// Récupérer les données envoyées par le formulaire via POST
		$idonnee = $this->input->post('idonnee');
		$date_validation_structure = $this->input->post('date_validation_structure');

		// Vérifier si les données sont présentes
		if ($idonnee && $date_validation_structure) {
			// Appeler la méthode du modèle pour insérer la date de validation
			$this->visuels_model->insert_date_structure($date_validation_structure, $idonnee);
			$this->session->set_flashdata('message-succes', 'Date de validation de structure ajoutée.');
			redirect('Googleads');
		} else {
			// Si les données ne sont pas valides, rediriger vers une page d'erreur
			$this->session->set_flashdata('error', 'Les données sont manquantes.');
			redirect('Googleads');  // Vous pouvez définir cette route pour gérer les erreurs
		}
	}
	public function creation_ads()
	{
		// Récupérer les données envoyées par le formulaire via POST
		$idonnee = $this->input->post('idonnee');
		$date_creation_ads = $this->input->post('date_creation_ads');

		$this->visuels_model->update_creation_ads($date_creation_ads, $idonnee);
		$this->session->set_flashdata('message-succes', 'Date création Ads modifié avec succès.');
		redirect('Googleads');
	}
	public function paiement_recu()
	{
		// Récupérer les données envoyées par le formulaire via POST
		$idonnee = $this->input->post('idonnee');
		$pr = $this->input->post('paiement_recu');

		// Vérifier si les données sont présentes
		if ($idonnee && $date_validation_structure) {
			// Appeler la méthode du modèle pour insérer la date de validation
			$this->visuels_model->update_paiement_recu($pr, $idonnee);
			$this->session->set_flashdata('message-succes', 'Paiement reçu modifié avec succès.');
			redirect('Googleads');
		} else {
			// Si les données ne sont pas valides, rediriger vers une page d'erreur
			$this->session->set_flashdata('error', 'Les données sont manquantes.');
			redirect('Googleads');  // Vous pouvez définir cette route pour gérer les erreurs
		}
	}


	// Fonction pour enregistrer un groupe
	public function save_groupe()
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
		$mot_cle = $this->input->post('mot_cle');

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
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle
		];

		// Appeler la fonction de mise à jour dans le modèle
		$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
		redirect('Googleads/validation_client/' . $idgroupe_annonce);
		// Après la mise à jour, vous pouvez rediriger ou afficher une vue de confirmation
		$this->session->set_flashdata('success', 'Groupe mis à jour avec succès.');
		redirect('Googleads/success');  // Exemple de redirection après mise à jour
	}
	public function edit_groupe($id)
	{
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id);
		$this->load->view("templates/v3/edit_groupe_annonce", $this->data);
	}
	public function information_client($id)
	{
		$this->data["donnees"] = $this->visuels_model->getinformationedit($id);
		$this->data["clients"] = $this->visuels_model->getclientsedit($id);
		$this->page = "templates/v3/edit_information_client";
		$this->layout();
	}
	public function ajout_groupeannonce_pmax($id)
	{
		$this->data["pmax"] = $t = $this->visuels_model->getGroupeAnnonceByIdPmaxsgroupe($id);
		$id = $t[0]['idcampagne'];
		$id = intval($id);

		$o = $this->data["campagne"] = $this->visuels_model->getCampagneid($id);
		$g = $this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefByIds($id);

		$g = $g[0]['idcampagne'];
		$this->data["g"] = $this->visuels_model->getcampagne_Groupe_annonce_briefByIdg($g);
		$this->data["groupe"] = $this->visuels_model->getgroupepmaxidcampagne($id);
		$o = $o[0]['idclients'];
		$o = intval($o);
		$id = $o;
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $this->visuels_model->getClientById($id);
		$id = $t[0]['idgroupe_annonce'];
		$id = intval($id);

		$i = $this->data["images"] = $this->Image_model->get_images_by_id($id);

		$this->page = "templates/v3/ajout_groupe_annonce_pmax";
		$this->layout();
	}
	public function updateDonneeClients()
	{
		// Récupération des données
		$idcampagne = $this->input->post('idcampagne');
		$idclient = $this->input->post('idclients');

		// Données campagne
		$zones = $this->input->post('zones');
		$date_campagne = $this->input->post('date_campagne');
		$appareil = $this->input->post('appareil');
		$budget = $this->input->post('budget');
		$information_campagne = $this->input->post('information_campagne');
		$objectif = $this->input->post('objectif');
		$nom_campagne = $this->input->post('nom_campagne'); // Non utilisé ici mais dispo

		// Mise à jour campagne
		$this->visuels_model->updatescampagne($zones, $date_campagne, $appareil, $budget, $information_campagne, $objectif, $idcampagne);

		// Récupérer les tableaux
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$nom_groupe = $this->input->post('nom_groupe');
		$contexte_groupes_annonces = $this->input->post('contexte_groupes_annonces');
		$mot_cle = $this->input->post('mot_cle');

		// Mettre à jour chaque groupe
		for ($i = 0; $i < count($idgroupe_annonce); $i++) {
			$data = array(
				'nom_groupe' => $nom_groupe[$i],
				'contexte_groupes_annonces' => $contexte_groupes_annonces[$i],
				'mot_cle' => $mot_cle[$i]
			);

			$this->visuels_model->updateGroupe($idgroupe_annonce[$i], $data);
		}

		redirect('Googleads/campagne/' . $idclient);
	}

	public function editcampagne($id)
	{
		// Récupérer les données de la campagne
		$t = $this->data["campagne"] = $this->visuels_model->getCAMPAGNEByIdc($id);
		$t = $t[0]['idcampagne'];

		// Récupérer les groupes d'annonces
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdg($id);

		// Charger la vue pour éditer la campagne
		$this->page = "templates/v3/edit_campagnes";
		$this->layout();
	}
	public function editextensions($id)
	{
		// Récupérer les données de la campagne

		$this->data["extensions"] = $this->visuels_model->getextensionsByIdc($id);
		$this->page = "templates/v3/edit_extensions";
		$this->layout();
	}
	public function ajout_groupeannonce_local($id)
	{
		$this->data["images"] = $this->Image_model->get_images_by_id($id);
		$this->data["local"] = $t = $this->visuels_model->getGroupeAnnonceByIdLocalsgroupe($id);


		$this->data["campagne"] = $this->visuels_model->getCampagneid($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$this->data["groupe"] = $this->visuels_model->getgroupelocalidcampagne($id);
		$t = $t[0]['idclients'];
		$id = intval($t);
		$this->data["client"] = $this->visuels_model->getClientById($id);
		$this->page = "templates/v3/ajout_groupe_annonce_local";
		$this->layout();
	}

	public function indexs()
	{
		$data['images'] = [];

		// Vérifier si une URL a été soumise
		if ($this->input->post('url')) {
			$url = $this->input->post('url');
			$data['images'] = $this->scrape_images($url);

			// Retourner les images sous forme de JSON pour l'AJAX
			echo json_encode($data['images']);
			return;
		}

		// Si des images ont été sélectionnées, les enregistrer dans la base de données
		if ($this->input->post('selected_images')) {
			$selected_images = $this->input->post('selected_images');
			$this->save_images_to_db($selected_images);
		}

		// Charger la vue
		$this->load->view('templates/v3/ajout_groupe_annonce_pmax', $data);
	}


	private function scrape_images($url)
	{
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
	public function save_images()
	{

		$idclients = $this->input->post('idclients');
		$type_image = 0;
		$selected_images = $this->input->post('selected_images');



		if (!empty($selected_images)) {
			$Images_youtube1 = $selected_images[0];
			$Images_youtube2 = $selected_images[1];
			$Images_gmail = $selected_images[2];
			$Images_display1 = $selected_images[3];
			$Images_display2 = $selected_images[4];
			$Images_discover1 = $selected_images[5];
			$Images_discover2 = $selected_images[6];
			$Images_discover3 = $selected_images[7];

			$this->visuels_model->insert_images_bd($idclients, $Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3, $type_image);
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
		$this->session->set_flashdata('success-images', 'Image Pmax inserer avec success');
		$idgroupe_annonce = $this->visuels_model->prendidgroupeannoncebyclientspmax($idclients);;
		$idgroupe_annonce = intval($idgroupe_annonce[0]['idgroupe_annonce']);
		$id = $idgroupe_annonce;
		redirect("Googleads/Visualiserpmax/" . $id);
	}
	public function save_images2()
	{

		$idclients = $this->input->post('idclients');
		$type_image = 0;
		$selected_images = $this->input->post('selected_images');


		if (!empty($selected_images)) {
			$Images_youtube1 = $selected_images[0];
			$Images_youtube2 = $selected_images[1];
			$Images_gmail = $selected_images[2];
			$Images_display1 = $selected_images[3];
			$Images_display2 = $selected_images[4];
			$Images_discover1 = $selected_images[5];
			$Images_discover2 = $selected_images[6];
			$Images_discover3 = $selected_images[7];

			$this->visuels_model->insert_images_bd2($idclients, $Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3, $type_image);
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
		$this->session->set_flashdata('success-images', 'Image Local inserer avec success');
		redirect("Googleads/campagne/" . $idclients);
	}
	public function save_images_upload()
	{
		$idclients = $this->input->post('idclients');
		$selected_images = $this->input->post('selected_images');
		$selected_images = $this->file_upload_field = 'selected_images';
		$favicon = $this->file_upload_field = 'favicon';
		$selected_images = "";
		$favicon = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["selected_images"]["name"]));
		if ($this->upload->do_upload('selected_images') != null) {
			$selected_images = $this->path . $this->upload->file_name;
		}
		$this->upload->initialize($this->set_upload_options("", $_FILES["favicon"]["name"]));
		if ($this->upload->do_upload('favicon') != null) {
			$favicon = $this->path . $this->upload->file_name;
		}
		if (!empty($selected_images)) {
			// Initialisation des variables d'image
			$Images_youtube1 = $Images_youtube2 = $Images_gmail = $Images_display1 = "";
			$Images_display2 = $Images_discover1 = $Images_discover2 = $Images_discover3 = "";

			// Téléchargement des images et affectation des valeurs
			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube1"]["name"]));
			if ($this->upload->do_upload('Images_youtube1')) {
				$Images_youtube1 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube2"]["name"]));
			if ($this->upload->do_upload('Images_youtube2')) {
				$Images_youtube2 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_gmail"]["name"]));
			if ($this->upload->do_upload('Images_gmail')) {
				$Images_gmail = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display1"]["name"]));
			if ($this->upload->do_upload('Images_display1')) {
				$Images_display1 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display2"]["name"]));
			if ($this->upload->do_upload('Images_display2')) {
				$Images_display2 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover1"]["name"]));
			if ($this->upload->do_upload('Images_discover1')) {
				$Images_discover1 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover2"]["name"]));
			if ($this->upload->do_upload('Images_discover2')) {
				$Images_discover2 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover3"]["name"]));
			if ($this->upload->do_upload('Images_discover3')) {
				$Images_discover3 = $this->path . $this->upload->file_name;
			}

			// Vérification des images téléchargées et affichage
			var_dump($Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3);
			die();
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
	}

	private function save_images_to_db($selected_images)
	{
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
	public function ajout_groupeannonce($id)
	{
		$this->data["campagne"] = $this->visuels_model->getCampagneid($id);
		$this->page = "templates/v3/ajout_groupe_annonce";
		$this->layout();
	}

	public function detail_campagne($id)
	{
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$c[0] = $this->visuels_model->getCampagneiddetail($id);
		$this->data["campagne"] = $c[0];
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id);

		$this->page = "templates/v3/detailcampagne";
		$this->layout();
	}
	public function detail_campagne_local($id)
	{
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$this->data["campagne"] = $this->visuels_model->getCampagneid($id);
		$this->data["local"] = $this->visuels_model->getGroupeAnnonceByIdlocals($id);
		$this->page = "templates/v3/detailcampagnelocal";
		$this->layout();
	}
	public function detail_campagne_pmax($id)
	{

		$c = $this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$o = $this->data["pmax"] = $this->visuels_model->getGroupeAnnonceByIdPmaxs($id);

		$o = $o[0]['idclients'];
		$o = intval($o);
		$id = $o;
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $this->visuels_model->getClientById($id);
		$this->page = "templates/v3/detailcampagnepmax";
		$this->layout();
	}


	public function save_brouillon($idonnee)
	{
		$decision = 0;
		$date = new DateTime();
		$structure = $date->format('d-m-Y');
		$this->Donne_modele->save_brouillon($idonnee, $decision);
		$this->Donne_modele->insert_structure($idonnee, $structure);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	public function save_campagne($idonnee)
	{
		$decision = 1;
		$this->Donne_modele->save_campagne($idonnee, $decision);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	public function save_campagne_clients($idclients)
	{
		$decision = 1;
		$this->Donne_modele->save_campagne_clients($idclients, $decision);
		$this->session->set_flashdata('message-succes', "Campagne valider par le client");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	public function campagne($idclients)
	{
		$id = $idclients;



		$this->data['upsell'] = $this->visuels_model->getupsellbyid($id);
		$this->data["campagne"] = $this->visuels_model->getCampagneByIdclient($id);
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$this->data["groupe_annonce"] = $this->visuels_model->getGroupe_annonce_briefById($id);

		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idinitiative = $this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$idam = $this->data["idam"] = $this->Donne_modele->getamById($idam);
		//var_dump($idinitiative);
		//var_dump($idam);
		//die();
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);















		$t = $this->data["groupe_annonce_pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);

		$this->data["taggage"] = $t;

		//var_dump($t[0]['type_plan_taggage']);
		//die();
		$this->data["groupe_annonce_local"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
		$this->data["nbrgroupe"] = $this->visuels_model->getnbrgroupe($id);
		$b =  $this->visuels_model->getbudgetutilise($id);
		$total = 0;

		foreach ($b as $item) {
			$total += (int)$item['repartition_budget'];
		}

		$this->data["budgetutilisé"] = $total;
		$donnees_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupes_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);


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


		$this->page = "templates/v3/campagne";
		$this->layout();
	}

	public function deletecampagne($id)
	{
		$idclients = $this->Donne_modele->getidclients($id);
		$idclients = $idclients[0]['idclients'];
		$idclients = intval($idclients);
		$this->Donne_modele->deletecampagne($id);
		$this->Donne_modele->deletegroupecampagne($id);
		$this->session->set_flashdata('success', "Campagne supprimer");
		redirect('Googleads/campagne/' . $idclients);
		$this->layout();
	}
	public function deleteextension($id)
	{
		$idclients = $this->Donne_modele->getidclientsbyextenions($id);
		$idclients = $idclients[0]['idclients'];
		$idclients = intval($idclients);
		$this->Donne_modele->deleteextensions($id);
		$this->session->set_flashdata('success', "Extensions supprimer");
		redirect('Googleads/gestion_extension/' . $idclients);
		$this->layout();
	}

	public function deleteplandetaggage($id)
	{
		$idclients = $this->Donne_modele->getidclientsbyextenions($id);
		$idclients = $idclients[0]['idclients'];
		$idclients = intval($idclients);
		$this->Donne_modele->deleteextensions($id);
		$this->session->set_flashdata('success', "Extensions supprimer");
		redirect('Googleads/gestion_extension/' . $idclients);
		$this->layout();
	}
	public function deletegroupeannonce($id)
	{
		$idclients = $this->Donne_modele->getidclientsg($id);
		$idclients = $idclients[0]['idclients'];
		$idclients = intval($idclients);
		$this->Donne_modele->deletegroupe($id);
		$this->session->set_flashdata('success', "Groupe d annonce supprimer");
		redirect('Googleads/campagne/' . $idclients);
		$this->layout();
	}
	public function save_annonce($idcampagne)
	{
		$decision = 1;
		$date = new DateTime();
		$structure = $date->format('Y-m-d');
		$idclients = $this->Donne_modele->save_campagnes($idcampagne, $decision);
		$idclients = $this->Donne_modele->save_annonces($idcampagne, $decision);
		$idclients = intval($idclients[0]);

		$this->Donne_modele->save_annonces_donnee($idclients, $structure);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads/campagne/' . $idclients);
		$this->layout();
	}
	public function save_annonce_technique($idclients)
	{
		$decision = 1;
		$date = new DateTime();
		$structure = $date->format('Y-m-d');
		$this->Donne_modele->save_campagnestech($idclients, $decision);
		$this->Donne_modele->save_annoncestech($idclients, $decision);

		$this->Donne_modele->save_annonces_donnee($idclients, $structure);
		$this->session->set_flashdata('message-success', "Envoye structure envoyer");
		redirect('Googleads/campagne/' . $idclients);
		$this->layout();
	}
	public function save_brouillon_annonce($idcampagne)
	{
		$decision = 0;
		$date = new DateTime();
		$structure = $date->format('d-m-Y');
		$idclients = $this->Donne_modele->bouillon_campagnes($idcampagne, $decision);
		$idclients = intval($idclients[0]);
		$this->session->set_flashdata('message-succes', "Campagne sauvegarder");
		redirect('Googleads/admin_brief/' . $idclients);
		$this->layout();
	}


	public function visualiser($id)
	{
		// Récupérer les données du modèle
		$a = $this->data["pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfByIdv($id);
		$id = $a[0]['idgroupe_annonce'];
		$id = intval($id);
		$this->data["images"] = $this->Image_model->get_images_by_id($id);
		$this->load->view("templates/v3/Visualiser", $this->data);
	}
	public function inventaire_local($id)
	{
		// Récupérer les données du modèle
		$a = $this->data["local"] = $this->visuels_model->getGroupe_annonce_localfByIdv($id);
		$id = $a[0]['idgroupe_annonce'];
		$id = intval($id);
		$this->data["images"] = $this->Image_model->get_images_by_id($id);
		$this->load->view("templates/v3/Inventaire_local", $this->data);
	}
	public function VisualiserSearch($id)
	{
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id);
		$this->load->view("templates/v3/Search", $this->data);
	}
	public function validation_client($id)
	{
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceById($id);
		$this->load->view("templates/v3/Search", $this->data);
	}
	public function Visualiserpmax($id)
	{
		$this->data["images"] = $this->Image_model->get_images_by_id($id);
		$this->data["pmax"] = $t = $this->visuels_model->getGroupeAnnonceByIdPmaxsgroupe($id);

		$this->load->view("templates/v3/visualiser_pmax", $this->data);
	}
	public function Visualiserlocal($id)
	{
		$this->data["images"] = $this->Image_model->get_images_by_id($id);
		$this->data["local"] = $t = $this->visuels_model->getGroupeAnnonceByIdLocalsgroupe($id);

		$this->load->view("templates/v3/visualiser_local", $this->data);
	}
	public function VisualiserSearchs($id)
	{
		$idclients = $this->visuels_model->getGroupeAnnonceByIdclient($id);
		$idclients = $idclients[0];
		$idclients = $idclients['idclients'];
		$idclients = intval($idclients);
		$this->data["search"] = $this->visuels_model->getGroupeAnnonceByIdclients($idclients);

		// Utiliser le répertoire writable de CodeIgniter (FCPATH fait référence à la racine de votre application CodeIgniter)
		$tempHtmlFile = FCPATH . 'writable/temp/temp_view.html';
		$outputImage = FCPATH . 'writable/temp/output_image.jpg';

		// Créer le contenu HTML
		$viewContent = $this->load->view("templates/v3/Search", $this->data, true);

		// Sauvegarder le contenu HTML dans un fichier temporaire
		if (file_put_contents($tempHtmlFile, $viewContent) === false) {
			die("Erreur lors de l'écriture dans le fichier.");
		}

		// Commande pour utiliser wkhtmltoimage et convertir le HTML en image
		$command = "wkhtmltoimage --width 1200 --height 800 $tempHtmlFile $outputImage";
		exec($command, $output, $return_var);

		// Vérifier si l'image a été générée avec succès
		if ($return_var === 0) {
			// Optionnellement, afficher l'image générée
			echo "<img src='" . base_url('writable/temp/output_image.jpg') . "' />";
		} else {
			echo "Erreur lors de la génération de l'image.";
		}

		// Nettoyer en supprimant le fichier HTML temporaire
		unlink($tempHtmlFile);
	}
	public function creergroupe()
	{
		$idcampagne = $this->input->post('idcampagne');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');
		$contexte_groupes_annonces = $this->input->post('contexte_groupes_annonces');
		$mot_cle = $this->input->post('mot_cle');

		$data = array(
			'idcampagne' => $idcampagne,
			'idclients' => $idclients,
			'type_campagnes' => $type_campagne,
			'nom_groupe' => $nom_groupe,
			'contexte_groupes_annonces' => $contexte_groupes_annonces,
			'mot_cle' => $mot_cle
		);

		$this->Donne_modele->creer_groupe_search($data);
		redirect('Googleads/campagne/' . $idclients, 'refresh');
		$this->layout();
	}

	public function Ajoutgroupe()
	{
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
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$url = $this->input->post('url');
		$mot_cle = $this->input->post('mot_cle');
		$data = array(
			'idcampagne' => $idcampagne,
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
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle
		);
		$this->Donne_modele->insert_groupe_search($data);
		redirect('Googleads/campagne/' . $idclients, 'refresh');
		$this->layout();
	}
	public function Ajoutgroupes()
	{
		// Récupérer les données depuis la requête POST
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
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$url = $this->input->post('url');
		$mot_cle = $this->input->post('mot_cle');


		$data = array(
			'idcampagne' => $idcampagne,
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
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle
		);

		// Mise à jour des données en fonction de l'idgroupe_annonce
		$this->Donne_modele->update_groupe_search($idgroupe_annonce, $data);

		redirect('Googleads/insertgroupeannonce/' . $idgroupe_annonce, 'refresh');
	}

	public function Ajoutgroupepmax()
	{
		// Récupération des données
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
		$mot_cle = $this->input->post('mot_cle');

		// Préparation des données communes
		$data = array(
			'idclients' => $idclients,
			'idcampagne' => $idcampagne,
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
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'description_breve' => $description_breve,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle,
		);

		$this->Donne_modele->update_groupe_pmax($data, $idgroupe_annonce);
		$id = $idclients;
		//$this->gestion_image($idgroupe_annonce);
		// Redirection vers la page correspondante
		redirect('Googleads/ajout_groupeannonce_pmax/' . $idgroupe_annonce, 'refresh');
		$this->layout();
	}
	public function vie($id)
	{
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
	public function vie2($id)
	{
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

	public function Ajoutgroupelocal()
	{
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idcampagne = $this->input->post('idcampagne');
		$idclients = $this->input->post('idclients');
		$type_campagne = 2;
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
		$mot_cle = $this->input->post('mot_cle');

		$data = array(
			'idclients' => $idclients,
			'idcampagne' => $idcampagne,
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
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'description_breve' => $description_breve,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url,
			'mot_cle' => $mot_cle,
		);
		// Mise à jour du groupe en fonction de l'idgroupe_annonce
		$this->Donne_modele->update_groupe_pmax($data, $idgroupe_annonce);
		redirect("Googleads/ajout_groupeannonce_local/" . $idgroupe_annonce);
	}
	public function Ajout_Campagne()
	{
		if ($this->input->post('type_de_campagne') == 1) {
			$idclients = $this->input->post('idclient');
			$type_campagne = $this->input->post('type_de_campagne');
			$nom_campagne = $this->input->post('nom_campagne_search');
			$information_campagne = $this->input->post('information_campagne_search');

			$zones = $this->input->post('zone_search');
			$repartition_budget = $this->input->post('repartition_budget_search');
			$date_campagne = $this->input->post('date_campagne');
			$appareil = $this->input->post('appareil_search');
			$objectif = $this->input->post('objectif');
			$url_site = $this->input->post('url_campagne');
			$Mots_cle_potentiels = $this->input->post('Mot_cle');

			// Récupérer tous les groupes d'annonces dynamiques
			$groupes_annonces = $this->input->post('groupe_annonce'); // Récupère les groupes d'annonces

			$contexte_groupes_annonces = $this->input->post('contexte_groupe_annonce'); // Récupère les contextes des groupes d'annonces
			$mots_cle = $this->input->post('Mot_cle'); // Récupère les mots-clés

			// Vérifier que les groupes d'annonces, leurs contextes et les mots-clés sont bien récupérés
			if (count($groupes_annonces) == count($contexte_groupes_annonces) && count($groupes_annonces) == count($mots_cle)) {
				// Lancer l'insertion de la campagne
				$idcampagne = $this->Donne_modele->insert_campagne_am(
					$idclients,
					$type_campagne,
					$nom_campagne,
					$information_campagne,
					$zones,
					$repartition_budget,
					$date_campagne,
					$appareil,
					$objectif,
					$url_site,
					$Mots_cle_potentiels
				);

				// Insérer les groupes d'annonces et leurs contextes associés
				$data_groups = array();
				foreach ($groupes_annonces as $index => $groupe) {
					$data_groups[] = array(
						'groupe_annonce' => $groupe,
						'contexte_groupe_annonce' => isset($contexte_groupes_annonces[$index]) ? $contexte_groupes_annonces[$index] : '',
						'mot_cle' => isset($mots_cle[$index]) ? $mots_cle[$index] : '', // Ajouter le mot-clé associé
						'url_groupe_annonce' => $url_site,
						'idcampagne' => $idcampagne,
						'idclient' => $idclients,
						'type_campagne' => $type_campagne
					);
				}

				// Insertion des données dans la table des groupes d'annonces
				$this->Donne_modele->insert_gp($data_groups, $idcampagne, $idclients, $type_campagne, $contexte_groupes_annonces, $mots_cle, $url_site); // Passe tous les arguments nécessaires
			} else {
				// Gérer l'erreur si les données ne sont pas cohérentes
				// Par exemple, retourner un message d'erreur ou rediriger
				echo 'Erreur : Le nombre de groupes d\'annonces, de contextes et de mots-clés ne correspond pas.';
			}
			$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
			redirect('Googleads/campagne/' . $idclients, 'refresh');
			$this->layout();
		} // Fermeture du premier if

		if ($this->input->post('type_de_campagne') == 2) {
			$idclients = $this->input->post('idclient');
			$type_campagne = $this->input->post('type_de_campagne');
			$nom_campagne = $this->input->post('nom_campagne_local');
			$nom_groupe_pmax = $this->input->post('nom_groupe_local');
			$information_campagne = $this->input->post('information_campagne_local');
			$zones = $this->input->post('zone_Local');

			$repartition_budget = $this->input->post('repartition_budget_local');
			$date_campagne = $this->input->post('date_campagne_local');
			$appareil = $this->input->post('appareil_local');
			$objectif = $this->input->post('objectif_local');
			$url_site = $this->input->post('url_campagne_local');
			$Mots_cle_potentiels = $this->input->post('Mot_cle_local');
			$contextes_client = $this->input->post('contexte_groupe_local');
			$idcampagne = $this->Donne_modele->insert_campagne_am(
				$idclients,
				$type_campagne,
				$nom_campagne,
				$information_campagne,
				$zones,
				$repartition_budget,
				$date_campagne,
				$appareil,
				$objectif,
				$url_site,
				$Mots_cle_potentiels
			);
			$this->Donne_modele->insert_gppmax($idclients, $nom_groupe_pmax, $type_campagne, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client);
			$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
			redirect('Googleads/campagne/' . $idclients, 'refresh');
			$this->layout();
		} // Fermeture du deuxième if

		if ($this->input->post('type_de_campagne') == 3) {
			$idclients = $this->input->post('idclient');
			$type_campagne = $this->input->post('type_de_campagne');
			$nom_campagne = $this->input->post('nom_campagne_pmax');
			$nom_groupe_pmax = $this->input->post('nom_groupe_pmax');
			$information_campagne = $this->input->post('information_campagne_pmax');
			$zones = $this->input->post('zone_pmax');
			$repartition_budget = $this->input->post('repartition_budget_pmax');
			$date_campagne = $this->input->post('date_campagne_pmax');
			$appareil = $this->input->post('appareil_pmax');
			$objectif = $this->input->post('objectif_pmax');
			$url_site = $this->input->post('url_campagne_pmax');
			$Mots_cle_potentiels = $this->input->post('Mot_cle_pmax');
			$information_client = $this->input->post('information_client_pmax');
			$contextes_client = $this->input->post('contextes_client_pmax');
			$idcampagne = $this->Donne_modele->insert_campagne_am(
				$idclients,
				$type_campagne,
				$nom_campagne,
				$information_campagne,
				$zones,
				$repartition_budget,
				$date_campagne,
				$appareil,
				$objectif,
				$url_site,
				$Mots_cle_potentiels
			);
			$this->Donne_modele->insert_gppmax($idclients, $nom_groupe_pmax, $type_campagne, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client);
			$choix = $this->input->post('choix');
			if ($choix == "lead") {
				$conversions = [
					['idclients' => $idclients, 'conversion' => 'Lead - Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead - Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead - Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead - Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton chat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => '']
				];
			}
			if ($choix == "ecommerce") {
				$conversions = [
					['idclients' => $idclients, 'conversion' => 'Lead | Achat', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a réalisé un achat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le begin checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d appel téléphonique ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le téléphone', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur l email', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a utilisé le chat pour entrer en contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => '']
				];
			}
			if ($choix == "reservation") {
				$conversions = [
					['idclients' => $idclients, 'conversion' => 'Lead | Réservation', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a effectué une réservation', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact sur la page dédiée', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page produit', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une autre page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une autre page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une autre page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un autre bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
					['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => '']
				];
			}
			$this->Donne_modele->insert_conversions($conversions);
			$this->Donne_modele->update_type_clients($choix, $idclients);


			$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
			redirect('Googleads/campagne/' . $idclients, 'refresh');
			$this->layout();
		} // Fermeture du troisième if
	}







	public function submitForm()
	{
		// Récupérer les données du formulaire de la campagne
		if ($this->input->post('type_de_campagne') == 1) {

			$campaign_data = array(
				'idclients' => $this->input->post('idclient'),  // ID client récupéré depuis le champ caché
				'nom_campagne' => $this->input->post('nom_campagne'),
				'type_campagne' => $this->input->post('type_de_campagne'),
				'logo_client' => NULL,  // Ajoutez si vous avez un champ pour le logo
				'parametre_campagne' => $this->input->post('campaign-name'),
				'repartition_budget' => $this->input->post('repartition_budget'),
				'date_campagne' => $this->input->post('calendar'),
				'url_site' => $this->input->post('url_site'),  // Ajoutez si nécessaire
				'cible' => $this->input->post('cible'),
				'zones' => $this->input->post('zone'),
				'cible' => $this->input->post('cible'),  // Ajoutez si nécessaire
				'idextentions' => $this->input->post('extentions'),  // Ajoutez si nécessaire
				'Mots_cle_potentiels' => $this->input->post('Mots_cle_potentiels'),  // Ajoutez si nécessaire
				'valeurs_ajouter' => $this->input->post('valeurs_ajouter'),  // Ajoutez si nécessaire
				'appareil' => $this->input->post('appareil'),
				'Extensions_de_liens' => $this->input->post('Extensions_de_liens'),
				'Extensions_de_produits' => $this->input->post('Extensions_de_produits'),
				'label_produit' => NULL,  // Ajoutez si nécessairetype_de_campagne
				'objectif' => $this->input->post('objectif')
			);

			// Insérer la campagne dans la table campagne
			$idcampagne = $this->Donne_modele->insert_campagne($campaign_data);

			// Récupérer les groupes d'annonces selon le type de campagne
			$annonce_groups = $this->input->post('group-name');  // Liste des groupes d'annonces
			$group_data = array();

			foreach ($annonce_groups as $index => $group_name) {
				// Ajouter l'ID du client et de la campagne dans chaque groupe d'annonce
				$group_data[] = array(
					'idclients' => $this->input->post('idclient'),  // Ajouter l'ID du client
					'idcampagne' => $idcampagne,  // ID de la campagne associée
					'nom_groupe' => $this->input->post('group-name')[$index],
					'titre1' => $this->input->post('group-title1')[$index],
					'titre2' => $this->input->post('group-title2')[$index],
					'titre3' => $this->input->post('group-title3')[$index],
					'titre4' => $this->input->post('group-title4')[$index],
					'titre5' => $this->input->post('group-title5')[$index],
					'titre6' => $this->input->post('group-title6')[$index],
					'titre7' => $this->input->post('group-title7')[$index],
					'titre8' => $this->input->post('group-title8')[$index],
					'titre9' => $this->input->post('group-title9')[$index],
					'titre10' => $this->input->post('group-title10')[$index],
					'titre11' => $this->input->post('group-title11')[$index],
					'titre12' => $this->input->post('group-title12')[$index],
					'descriptions1' => $this->input->post('group-description1')[$index],
					'descriptions2' => $this->input->post('group-description2')[$index],
					'descriptions3' => $this->input->post('group-description3')[$index],
					'descriptions4' => $this->input->post('group-description4')[$index],
					'titre' => $this->input->post('group-title')[$index],
					'chemin1' => $this->input->post('group-path1')[$index],
					'chemin2' => $this->input->post('group-path2')[$index],
					'url_groupe_annonce' => $this->input->post('group-url')[$index],
					'mot_cle' => $this->input->post('group-keywords')[$index]
				);
			}

			// Insérer les groupes d'annonces
			if (!empty($group_data)) {
				$this->Donne_modele->insert_multiple_groupe_annonce($group_data);
			}

			// Rediriger ou afficher un message de succès
			$this->session->set_flashdata('Admin_brief', 'Campagne et groupes d\'annonces ajoutés avec succès.');
			redirect('Admin_brief', 'refresh');
			$this->layout();
		}
		if ($this->input->post('type_de_campagne') == 2) {
			$logos = $this->file_upload_field = 'logos';
			$logos = "";
			$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
			if ($this->upload->do_upload('logo') != null) {

				$logos = $this->path . $this->upload->file_name;
			}
			var_dump($logos);
			die();

			// Insertion dans la base de données
			var_dump($data);
			die();
		}


		if ($this->input->post('type_de_campagne') == 3) {
			$idclient = $this->input->post('idclient');
			$idclient = intval($idclient);
			$type_de_campagne = $this->input->post('type_de_campagne');
			$zone = $this->input->post('zone');
			$calendar = $this->input->post('calendar');
			$appareil = $this->input->post('appareil');
			$appareil = intval($appareil);
			$idcampagne = $this->Donne_modele->insert_campagne_pmax($idclient, $zone, $type_de_campagne, $calendar, $appareil);
			$mot_cle = $this->input->post('mot_cle');
			$nom_campagne = $this->input->post('nom_campagne');
			$objectif = $this->input->post('objectif');
			$repartition_budget = $this->input->post('repartition_budget');
			$titre = $this->input->post('titre');
			$description = $this->input->post('description');
			$description_bref = $this->input->post('description_bref');
			$url = $this->input->post('url');
			$logos = $this->file_upload_field = 'logos';
			$Images_youtube1 = $this->file_upload_field = 'Images_youtube1';
			$Images_youtube2 = $this->file_upload_field = 'Images_youtube2';
			$Images_gmail = $this->file_upload_field = 'Images_gmail';
			$Images_display1 = $this->file_upload_field = 'Images_display1';
			$Images_display2 = $this->file_upload_field = 'Images_display2';
			$Images_discover1 = $this->file_upload_field = 'Images_discover1';
			$Images_discover2 = $this->file_upload_field = 'Images_discover2';
			$Images_discover3 = $this->file_upload_field = 'Images_discover3';
			$logos = "";
			$Images_youtube1 = "";
			$Images_youtube2 = "";
			$Images_gmail = "";
			$Images_display1 = "";
			$Images_display2 = "";
			$Images_discover1 = "";
			$Images_discover2 = "";
			$Images_discover3 = "";
			$this->upload->initialize($this->set_upload_options("", $_FILES["logos"]["name"]));
			if ($this->upload->do_upload('logos') != null) {
				$logos = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube1"]["name"]));
			if ($this->upload->do_upload('Images_youtube1') != null) {
				$Images_youtube1 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_youtube2"]["name"]));
			if ($this->upload->do_upload('Images_youtube2') != null) {
				$Images_youtube2 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_gmail"]["name"]));
			if ($this->upload->do_upload('Images_gmail') != null) {
				$Images_gmail = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display1"]["name"]));
			if ($this->upload->do_upload('Images_display1') != null) {
				$Images_display1 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_display2"]["name"]));
			if ($this->upload->do_upload('Images_display2') != null) {
				$Images_display2 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover1"]["name"]));
			if ($this->upload->do_upload('Images_discover1') != null) {
				$Images_discover1 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover2"]["name"]));
			if ($this->upload->do_upload('Images_discover2') != null) {
				$Images_discover2 = $this->path . $this->upload->file_name;
			}

			$this->upload->initialize($this->set_upload_options("", $_FILES["Images_discover3"]["name"]));
			if ($this->upload->do_upload('Images_discover3') != null) {
				$Images_discover3 = $this->path . $this->upload->file_name;
			}
			var_dump($Images_youtube1);
			die();

			$this->Donne_modele->insert_pmax(
				$idclient,
				$idcampagne,
				$nom_campagne,
				$zone,
				$calendar,
				$appareil,
				$mot_cle,
				$objectif,
				$repartition_budget,
				$titre,
				$description,
				$description_bref,
				$url,
				$logos,
				$Images_youtube1,
				$Images_youtube2,
				$Images_gmail,
				$Images_display1,
				$Images_display2,
				$Images_discover1,
				$Images_discover2,
				$Images_discover3
			);
			$this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
			redirect('Googleads', 'refresh');
			$this->layout();
		}
	}
	private function _upload_files($field_name)
	{
		$files = $_FILES[$field_name];
		$file_names = [];
		$upload_path = './uploads/';

		// Si plusieurs fichiers sont téléchargés
		if (!empty($files['name'][0])) {
			for ($i = 0; $i < count($files['name']); $i++) {
				$_FILES['file']['name'] = $files['name'][$i];
				$_FILES['file']['type'] = $files['type'][$i];
				$_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['file']['error'] = $files['error'][$i];
				$_FILES['file']['size'] = $files['size'][$i];

				// Configuration du téléchargement
				$this->load->library('upload');
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 2048;  // 2MB
				$config['file_name'] = time() . '-' . $files['name'][$i];  // Nom unique

				$this->upload->initialize($config);

				// Téléchargement
				if ($this->upload->do_upload('file')) {
					$file_names[] = $upload_path . $this->upload->data('file_name');
				}
			}
		}

		return implode(',', $file_names);  // Retourne les noms de fichiers séparés par une virgule
	}
	public function insert_client()
	{
		$client = $this->input->post('client');
		$site_client = $this->input->post('site_client');
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

		$idclient = $this->visuels_model->insertclient($client, $site_client, $email_client, $numero_client);
		$this->visuels_model->insertfiche($idclient, $budget, $secteur_activite, $product_choice, $initiative, $am, $date_mis_en_place, $date_brief, $date_annonce, $dejaclient);
		$this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
		redirect('Googleads', 'refresh');
		$this->layout();
	}


	public function Admin_brief($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$u = $this->data['upsell'] = $this->visuels_model->getupsellbyid($id);
		//var_dump($u); die();
		$idclients = $ko[0]['idclients'];
		$all = $this->data["all_campagne"] = $this->visuels_model->getAllCampagneById($idclients);
		$all = $this->data["all_campagne"] = $this->visuels_model->getAllgroupeById($idclients);

		$this->data["campagne"] = $this->visuels_model->getCampagneById($idclients);

		$this->data["groupe_annonce"] = $this->visuels_model->getGroupe_annonce_briefById($id);

		$t = $this->data["groupe_annonce_pmax"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);
		$this->data["groupe_annonce_local"] = $this->visuels_model->getGroupe_annonce_pmaxfById($id);

		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);

		$idam = intval($idam);

		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$idinitiative = $this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$idam = $this->data["idam"] = $this->Donne_modele->getamById($idam);
		//var_dump($idinitiative);
		//var_dump($idam);
		//die();
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/admin_brief";
		$this->layout();
	}
	public function validation_clients($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$idclients = $ko[0]['idclients'];
		$this->data["all_campagne"] = $this->visuels_model->getAllCampagneById($idclients);
		$this->data["all_groupe"] = $this->visuels_model->getAllgroupeById($idclients);
		$this->page = "templates/v3/Vision_client";
		$this->layout();
	}
	public function brief($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);

		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/brief";
		$this->layout();
	}
	public function ajoutCampagne($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);

		$b =  $this->visuels_model->getbudgetutilise($id);
		$total = 0;

		foreach ($b as $item) {
			$total += (int)$item['repartition_budget'];
		}
		$this->data["budjet_restant"] = $total;


		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/ajout_campagne";
		$this->layout();
	}


	public function produitselectionner()
	{
		// Récupérer les données envoyées par POST
		$idonnee = $this->input->post('idonnee');
		$product_choice = $this->input->post('product_choice');
		$this->Donne_modele->update_produit($product_choice, $idonnee);
		$this->session->set_flashdata('message-succes', "Produit mis à jours");
		redirect('Googleads', 'refresh');
		$this->layout();
	}
	public function dejaclient()
	{
		$id_donnee = $this->input->post('idonnee');
		$decision = $this->input->post('decision');
		$this->Donne_modele->update_dejaclient($decision, $id_donnee);
		$this->session->set_flashdata('message-succes', "Client mis à jours");
		redirect('Googleads', 'refresh');
		$this->layout();
	}

	public function editclient($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);

		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$a = $this->data["idam"] = $this->Donne_modele->getamById($idam);


		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data['users'] = $this->Task_model->get_all_users();
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/edithistorique";
		$this->layout();
	}
	public function message($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$idproduit = $ka[0]['idproduit'];
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$idproduit = intval($idproduit);
		$idinitiative = intval($idinitiative);
		$idam = intval($idam);

		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$this->data["initiative"] = $this->Donne_modele->get_all_initiative($id);
		$this->data["am"] = $this->Donne_modele->get_all_am($id);

		$this->page = "templates/v3/message";
		$this->layout();
	}
	public function view($id)
	{
		$ko = $this->visuels_model->getClientById($id);
		$ka = $this->visuels_model->getDonneeById($id);
		$idinitiative = $ka[0]['initiative'];
		$idam = $ka[0]['account_manager'];
		$this->data["client"] = $ko;
		$this->data["donnees"] = $ka;
		$idproduit = $ka[0]['idproduit'];

		$idinitiative = intval($idinitiative);
		$idam = intval($idam);
		$initiative = intval($idinitiative);
		$idam = intval($idam);

		$this->data["produitbyid"] = $this->Donne_modele->getProduitById($idproduit);
		$this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$this->data["idam"] = $this->Donne_modele->getamById($idam);
		$this->data["produit"] = $this->Donne_modele->get_all_produit($id);
		$idinitiative = $this->data["idinitiative"] = $this->Donne_modele->getinitiativeById($idinitiative);
		$idam = $this->data["idam"] = $this->Donne_modele->getamById($idam);

		$this->page = "templates/v3/view_client";
		$this->layout();
	}
	public function updateinformationClient()
	{
		$idonnee = $this->input->post('idonnee');
		$secteur_activite = $this->input->post('secteur_activite');
		$information_client = $this->input->post('information_client');
		$contexte_client = $this->input->post('contexte_client');
		$tracking_gtm = $this->input->post('tracking_gtm');
		$commentaire = $this->input->post('commentaire');
		$information_complementaire = $this->input->post('information_complementaire');

		$logo = $this->file_upload_field = 'logo';

		$logo = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {

			$logo = $this->path . $this->upload->file_name;
		}
		if ($logo != NULL) {
			$idclients = $this->Donne_modele->updateinformation($idonnee, $secteur_activite, $information_client, $contexte_client, $tracking_gtm, $commentaire, $information_complementaire);
			$this->Donne_modele->updatelogo($idclients, $logo);
		} else {
			$idclients = $this->Donne_modele->updateinformation($idonnee, $secteur_activite, $information_client, $contexte_client, $tracking_gtm, $commentaire, $information_complementaire);
		}

		$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
		redirect('Googleads/Admin_brief/' . $idonnee, 'refresh');
	}

	public function updateDonneeClient()
	{
		// Récupération des données du formulaire
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
		$commentaire_client = $this->input->post('commentaire_client');
		$paiement_recu = $this->input->post('paiement_recu');
		$datastudio = $this->input->post('datastudio');
		$email_onboarding = $this->input->post('email_onboarding');
		$facturation = $this->input->post('facturation');
		$paiement_recu = intval($paiement_recu);
		$datastudio = intval($datastudio);
		$email_onboarding = intval($email_onboarding);
		$facturation = intval($facturation);

		if ($commentaire_client == NULL) {
			$commentaire_client = NULL;
		}
		if ($commentaire_client != NULL) {
			$commentaire_client = $this->input->post('commentaire_client');
		}

		$this->Donne_modele->update_client($idclient, $client, $email_client, $numero_client, $site_client);
		$this->Donne_modele->update_donnee_client($budget, $secteur_activite, $Produit, $Initiative, $Am, $mis_en_place_paiement, $Brief, $annonce, $commentaire_client, $paiement_recu, $datastudio, $email_onboarding, $facturation, $idonnee);
		$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
		redirect('Googleads', 'refresh');
	}


	public function update_produit($idonnee)
	{

		$idonnee = $this->input->post('idonnee');
		$product_id = $this->input->post('product_id');
		$this->visuels_model->update_produit_client($product_id, $idonnee);
		$this->session->set_flashdata('message-succes', "Donnée Mise a jour avec succès");
		redirect('Googleads', 'refresh');
		$this->layout();
	}


	public function update_car($id_Car)
	{

		$ko = $this->visuels_model->get_by_id($id_Car);
		$this->data["car"] = $ko;
		$this->page = "templates/v3/admin_car_edit";
		$this->layout();

		if ($this->input->post('update')) {

			$Nom = $this->input->post('Nom');
			$Nombre_place = $this->input->post('Nombre_place');
			$Prix_jour = $this->input->post('Prix_jour');
			$Prestataire = $this->input->post('Prestataire');
			$Nom_chauffeur = $this->input->post('Nom_chauffeur');
			$Numero_chauffeur = $this->input->post('Numero_chauffeur');
			$Numero_voiture = $this->input->post('Numero_voiture');
			$Marque = $this->input->post('Marque');
			//var_dump($Nom);
			//Die();
			$this->visuels_model->update_car($Nom, $Nombre_place, $Prix_jour, $Prestataire, $Nom_chauffeur, $Numero_chauffeur, $Numero_voiture, $Marque, $id_Car);
			$this->session->set_flashdata('message-succes', "Donnée Mise a jour avec succès");
			redirect('Googleads', 'refresh');
			$this->layout();
		}
	}
	public function fiche_car($id_car)
	{
		//$idvisuels = $this->concurrent->get_concurrent_by_idvisuels($id);
		//datadump($idvisuels);
		//die();azerzerzer
		$ko = $this->visuels_model->get_by_id($id_car);
		//datadump($ko);
		//die();

		$ho = $this->concurrent->getListeConcurrent();
		$co = $this->visuels_model->get_by_id($id_car);
		// $idv = $co[0]['id_car'];
		$axe = $this->visuels_model->get_axe_id($id_car);

		foreach ($axe as $a) {

			$axes = $a['Nom'];
			$P = $this->visuels_model->get_personnelle_by_axes($axes);
			foreach ($P as $p) {

				$personnelle = $p['Ligne'];
				$valiny = Strcmp($axes, $personnelle);


				if ($valiny == 0) {

					$perso = $P;
				} else ($perso = "Sans donneer");
			}
		}
		//datadump($ko);
		//die();

		//datadump($idv);
		//die();
		//datadump($ho);
		//die();
		if ($P != Null) {


			foreach ($ko as $place) {

				$Nbr_place_car = $place['Nombre_place'];
			}
			$Nbr_place_car = substr($Nbr_place_car, 0, 2);
			$Nbre_presonnelle = count($P);
			$Nbr_place_car_result = intval($Nbr_place_car);

			$Nbre_presonnelle_result = intval($Nbre_presonnelle);
			$place_libre = $Nbr_place_car_result - $Nbre_presonnelle_result;
			$this->data["listeConcurrent"] = $ho;
			$this->data["visuels"] = $co;
			$this->data["Place_Libre"] = $place_libre;
			$this->data["Nbre_presonnelle"] = $Nbre_presonnelle_result;
			$this->data["perso"] = $perso;
			$this->data["Car"] = $ko;
			$this->page = "templates/detail_car";
			$this->layout();
		} else {
			$this->session->set_flashdata('message-succes', "Le Car que vous avez selectionner est vide");
			redirect('Car', 'refresh');
			$this->layout();
		}
	}

	function insert_liste_car_xls()
	{
		if (isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 2; $row <= $highestRow; $row++) {

					$Nom = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$Nombre_place = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$Prix_jour = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$Prestataire = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$Nom_chauffeur = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$Numero_chauffeur = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$Numero_voiture = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$Marque = $worksheet->getCellByColumnAndRow(7, $row)->getValue();





					$data[] = array(
						'Nom'  => $Nom,
						'Nombre_place'  => $Nombre_place,
						'Prix_jour'  => $Prix_jour,
						'Prestataire'  => $Prestataire,
						'Nom_chauffeur'  => $Nom_chauffeur,
						'Numero_chauffeur'  => $Numero_chauffeur,
						'Numero_voiture'  => $Numero_voiture,
						'Marque'  => $Marque





					);
				}
			}
			$this->visuels_model->Insert_DATA($data);


			$this->session->set_flashdata('message-succes', "Donnée ajouté avec succès");
			redirect('Car', 'refresh');
			$this->layout();
		}
	}
	public function delete_car($id_Car)
	{
		$this->visuels_model->deletecar($id_Car);
		$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
		redirect('Car', 'refresh');
		$this->layout();
	}







	public function fichevisuels()
	{
		$this->page = "templates/fichevisuels";
		//templates/fichevisuels
		$this->layout();
	}
	function Export()
	{
		$output = '';
		if (isset($_POST["export"])) {
			$query = "SELECT * FROM tbl_customer";
			$result = mysqli_query($connect, $query);
			if (mysqli_num_rows($result) > 0) {
				$output .= '
				   <table class="table" bordered="1">  
									<tr>  
										 <th>Name</th>  
										 <th>Address</th>  
										 <th>City</th>  
					   <th>Postal Code</th>
					   <th>Country</th>
									</tr>
				  ';
				while ($row = mysqli_fetch_array($result)) {
					$output .= '
					<tr>  
										 <td>' . $row["CustomerName"] . '</td>  
										 <td>' . $row["Address"] . '</td>  
										 <td>' . $row["City"] . '</td>  
					   <td>' . $row["PostalCode"] . '</td>  
					   <td>' . $row["Country"] . '</td>
									</tr>
				   ';
				}
				$output .= '</table>';
				header('Content-Type: application/xls');
				header('Content-Disposition: attachment; filename=download.xls');
				echo $output;
			}
		}
	}
	public function AjoutConcurrent()
	{
		//$ok = $this->visuels_model->get_all();	
		//$this->data['visuels'] = $this->visuels_model->get_by_id($id);
		$this->data['listeConcurrent'] = $this->concurrent->getListeConcurrent();
		$categorie = $this->input->post('categorie');
		$remarque = $this->input->post('remarque');
		$image1 = $this->file_upload_field = "image1";
		$image2 = $this->file_upload_field = "image2";
		//$image3 = $this->file_upload_field = "image3";
		//$image4 = $this->file_upload_field = "image4";
		$image1 = "";
		$image2 = "";
		$image3 = "";
		$image4 = "";
		$idvisuels = $this->input->post('id');


		//datadump($_FILES['image1']['name']);
		//die();
		//$newData = $this->input->get();

		$this->upload->initialize($this->set_upload_options("", $_FILES["image1"]["name"]));
		$this->upload->initialize($this->set_upload_options("", $_FILES["image2"]["name"]));
		$this->upload->initialize($this->set_upload_options("", $_FILES["image3"]["name"]));
		$this->upload->initialize($this->set_upload_options("", $_FILES["image4"]["name"]));
		if ($this->upload->do_upload('image1') != null) {

			$image1 = $this->path . $this->upload->file_name;
		}
		if ($this->upload->do_upload('image2') != null) {

			$image2 = $this->path . $this->upload->file_name;
		}

		if ($this->upload->do_upload('image3') != null) {

			$image3 = $this->path . $this->upload->file_name;
		}
		if ($this->upload->do_upload('image4') != null) {

			$image4 = $this->path . $this->upload->file_name;
		}
		$this->concurrent->insererConcurrent($categorie, $remarque, $image1, $image2, $image3, $image4, $idvisuels);
		redirect('visuels/visuelConcurrent/' . $id, 'refresh');
		$this->layout();
	}
	public function insert_visuels()
	{
		$label = $this->input->post('label');
		$date_visuel = $this->input->post('date_visuel');
		$logo = $this->file_upload_field = "logo";
		$logo = "";
		//datadump($logo);
		//die();
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {

			$logo = $this->path . $this->upload->file_name;

			$this->visuels_model->insertVisuels($label, $date_visuel, $logo);
			datadump('Donner inserer');
		}
	}
	public function EditConcurrent($id = null)
	{
		if ($id == null) {
			$postdata = $this->concurrent->get_concurrent_by_idvisuels($this->input->post("id"));
			datadump($postdata);
			die();
			$this->load->view("templates/v3/parts/visuels/part-edit", ["id" => $this->input->post("id"), "postdata" => $postdata]);
		}
	}

	public function Concurrent($id)
	{

		//datadump($this->concurrent->getListeConcurrent());
		//die();
		$this->data['listeConcurrent'] = $this->concurrent->getListeConcurrent();

		//$ok = $this->visuels_model->get_by_id($id);
		//datadump($ok);
		//die();
		//$this->data['visuels'] = $this->visuels_model->get_concurrent_by_id($id);
		//$ok2 = $this->concurrent->get_concurrent_by_id($id);




		//$this->data['visuels'] = $this->visuels_model->get_concurrent_by_id($id);	
		$this->page = "templates/concurrent_add";
		//templates/fichevisuels
		$this->layout();
	}

	public function delete($id)
	{
		if ($this->visuels_model->delete_row($id)) {
			$this->session->set_flashdata('message-succes', "Donnée supprimée avec succès");
			$this->page = "templates/visuelsConcurrent";
		}
		//datadump($deleted);
	}




	public function edit($id = null)
	{
		if ($id == null) {
			$postdata = $this->visuels_model->get_by_id($this->input->post("id"));

			$this->load->view("templates/v3/parts/visuels/part-edit", ["id" => $this->input->post("id"), "postdata" => $postdata]);
		} else {
			if ($visuel = $this->visuels_model->update_visuel($id, $this->input->post())) {
				//datadump($visuel);
				$this->session->set_flashdata('message-succes', "Donnée mise à jour avec succès");
				redirect('visuels', 'refresh');
			}
		}
	}

	// public function new() {
	// $this->form_validation->set_rules('label', 'Nom', 'trim|required');
	// $this->form_validation->set_rules('date_visuel', 'Date visuel', 'trim|required');

	// $newData = $this->input->post();

	// if($this->form_validation->run() == true) {

	// if($this->visuels_model->new_visuel($newData)) {
	// $this->session->set_flashdata('message-succes', "Données inserées avec succès");
	// redirect('visuels', 'refresh');
	// } else {
	// datadump("error");
	// }
	// }else {
	// datadump("error");
	// $this->page = "templates/v3/admin-visuels";
	// $this->layout();
	// }
	// redirect('visuels', 'refresh');
	// }
	/*public function add() {
		$this->form_validation->set_rules('label', 'Nom', 'trim|required');
		$this->form_validation->set_rules('date_visuel', 'Date visuel', 'trim|required');
		$newData = array();
        
        $this->form_validation->set_rules('logo', '', 'callback_file_check');
        if($this->form_validation->run() == true) {
            
            $newData = $this->input->post();
            $this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
            if ($this->upload->do_upload('logo')) {
                $newData['logo'] = $this->path . $this->upload->file_name;
            }
            //print_r($newData);
            if($this->regisseur_model->save_regisseur($newData)) {
                $this->session->set_flashdata('message-succes', "Données inserées avec succès");
                redirect('regisseur', 'refresh');
            }
            redirect('regisseur', 'refresh');
        } else {
            $this->data['label'] = array(
                'name'          => 'label',
                'id'            => 'label',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Label',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('label'),
            );

            $this->data['commentaires'] = array(
                'name'          => 'commentaires',
                'id'            => 'commentaires',
                'class'         => 'form-control',
                'placeholder'   => 'Commentaires',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('commentaires'),
            );

            $this->data['telephone'] = array(
                'name'          => 'telephone',
                'id'            => 'telephone',
                'type'          => 'text',
                'class'         => 'form-control',
                'placeholder'   => 'Téléphone',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('telephone'),
            );

            $this->data['email'] = array(
                'name'          => 'email',
                'id'            => 'email',
                'type'          => 'email',
                'class'         => 'form-control',
                'placeholder'   => 'Email',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('email'),
            );
			$this->data['DateDebut'] = array(
                'name'          => 'DateDebut',
                'id'            => 'DateDebut',
                'class'         => 'form-control',
                'placeholder'   => 'DateDebut',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('DateDebut'),
            );
			$this->data['DateFin'] = array(
                'name'          => 'DateFin',
                'id'            => 'DateFin',
                'class'         => 'form-control',
                'placeholder'   => 'DateFin',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('DateFin'),
            );
			$this->data['information'] = array(
                'name'          => 'information',
                'id'            => 'information',
                'class'         => 'form-control',
                'placeholder'   => 'information',
                'required'      => 'required',
                'value'         => $this->form_validation->set_value('information'),
            );

            $this->data['logo'] = array(
                'name'  => 'logo',
                'id'    => 'logo',
            );
        }
        $this->page = "templates/admin_regisseur_add";
        $this->layout();
	}*/

	public function Update()
	{
		$id = $this->input->post('id');
		$label = $this->input->post('label');
		$date_visuel = $this->input->post('date_visuel');
		$logo1 = $this->input->post('logo1');
		$logo =  "";


		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {

			$logo = $this->path . $this->upload->file_name;
		} else {
			$logo = $logo1;
		}

		$this->visuels_model->update_visuel($id, $label, $date_visuel, $logo);
		redirect('Visuels');
	}


	public function addVisuel()
	{

		$newData = $this->input->post();

		//datadump($newData);
		//datadump($_FILES); die();
		$listeConcurrent = $this->concurrent->getConcurrent();
		$insertconcurrent = $this->concurrent->insertconcurrent($data = null);

		$rep = array('listeConcurrent' => $listeConcurrent);
		$this->form_validation->set_rules($this->file_upload_field, '', 'callback_file_check');

		if ($this->form_validation->run() == true) {

			$newData = $this->input->post();
			$insertconcurrent = $this->concurrent->insertconcurrent($data = null);

			//datadump($newData);
			//datadump($_FILES); die();

			$prefix = $newData["visuel_id"] . "_" . $newData["format_id"] . "_" . $insertconcurrent["nomconcurrent"] . "_";

			$this->upload->initialize($this->set_upload_options($prefix, $insertconcurrent, $_FILES[$this->file_upload_field]["name"]));
			if ($this->upload->do_upload($this->file_upload_field)) {
				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData["file_name"];
				$newData[$this->file_upload_field] = $this->path . $this->upload->file_name;

				//datadump($newData);
				//datadump($_FILES);
				//die();

				if ($this->visuels_model->save_visuel_formats($newData, $listeConcurrent, $insertconcurrent)) {
					$this->session->set_flashdata('message-succes', "Données inserées avec succès");
					redirect('visuels', 'refresh');
				}
			}

			redirect('visuels', 'refresh');
		} else {
			datadump("error");
		}
	}

	public function addConcurrent()
	{

		$newData = $this->input->post();

		datadump($newData);
		die();
		//datadump($_FILES);
		$listeConcurrent = $this->concurrent->getListeConcurrent();
		$insertconcurrent = $this->concurrent->insertconcurrent($data = null);

		$rep = array('listeConcurrent' => $listeConcurrent);
		$this->form_validation->set_rules($this->file_upload_field, '', 'callback_file_check');

		if ($this->form_validation->run() == true) {

			$newData = $this->input->post();
			$insertconcurrent = $this->concurrent->insertconcurrent($data = null);

			//datadump($newData);
			//datadump($_FILES); die();

			$prefix = $newData["visuel_id"] . "_" . $newData["format_id"] . "_" . $insertconcurrent["nomconcurrent"] . "_";

			$this->upload->initialize($this->set_upload_options($prefix, $insertconcurrent, $_FILES[$this->file_upload_field]["name"]));
			if ($this->upload->do_upload($this->file_upload_field)) {
				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData["file_name"];
				$newData[$this->file_upload_field] = $this->path . $this->upload->file_name;

				//datadump($newData);
				//datadump($_FILES);
				//die();

				if ($this->visuels_model->save_visuel_formats($newData, $listeConcurrent, $insertconcurrent)) {
					$this->session->set_flashdata('message-succes', "Données inserées avec succès");
					redirect('visuels', 'refresh');
				}
			}

			redirect('visuels', 'refresh');
		} else {
			datadump("error");
		}
	}


	public function getPageAjoutConcurrent()
	{
		$page = "visuels";
		$listeConcurrent = $this->Concurrent->getConcurrent();
		datadump($listeConcurrent);
		die();
		$rep = array('page' => $page, 'listeConcurrent' => $listeConcurrent);
		$this->load->view('visuels', $rep);
	}


	public function add()
	{

		//$newData = $this->input->post();
		//datadump($this->input->post());
		//datadump($_FILES);

		$this->form_validation->set_rules('panneau_visuel_name', 'Visuel', 'trim|required');
		$this->form_validation->set_rules($this->file_upload_field, $this->file_upload_field, 'callback_file_check');

		if ($this->form_validation->run() == FALSE) {
			$error = [
				"validation_error" => $this->form_validation->error_array(),
			];
			echo json_encode($error);
		} else {
			$newDataVisuel["panneau_visuel_name"] = $this->input->post("panneau_visuel_name");
			if ($visuel_id = $this->visuels_model->save_visuel($newDataVisuel)) {

				$prefix = $visuel_id . "_" . $this->input->post("format_id");

				$this->upload->initialize($this->set_upload_options($prefix, $_FILES[$this->file_upload_field]["name"]));

				if ($this->upload->do_upload($this->file_upload_field)) {
					$uploadData = $this->upload->data();
					$uploadedFile = $uploadData["file_name"];
					//$newData[$this->file_upload_field] = $this->path . $this->upload->file_name;

					$insertVisuelFormat = [
						"visuel_id" => $visuel_id,
						"format_id" => $this->input->post("format_id"),
						$this->file_upload_field => $this->path . $this->upload->file_name,
					];

					//datadump($insertVisuelFormat);
					//die();

					if ($this->visuels_model->save_visuel_formats($insertVisuelFormat)) {
						//$this->session->set_flashdata('message-succes', "Données inserées avec succès");
						echo json_encode(["success" => "Visuel ajoutée"]);
						redirect('visuels', 'refresh');
					}
				}
				$this->session->set_flashdata('message-succes', "Données inserées avec succès");
				redirect('visuels', 'refresh');
			}
			//echo "Visuel inséré";
		}
	}

	public function get_visuels_formats()
	{
		$return = array();
		foreach ($this->visuels_model->get_all_visuel_formats() as $key => $value) {
			$return[$value["visuel_id"]][$value["format_id"]] = $value["visuel_path"];
		}
		return $return;
	}

	public function file_check($string)
	{
		$allowedMimeTypeArray = [
			"image/gif",
			"image/jpeg",
			"image/png",
			"image/x-png"
		];


		if (isset($_FILES[$this->file_upload_field]["name"]) && $_FILES[$this->file_upload_field]["name"] != "") {
			$mime = get_mime_by_extension($_FILES[$this->file_upload_field]["name"]);
			if (in_array($mime, $allowedMimeTypeArray)) {
				return true;
			} else {
				$this->form_validation->set_message('file_check', 'Type de fichier invalide');
				return false;
			}
		} else {
			$this->form_validation->set_message('file_check', 'Veuillez choisir un fichier');
			return false;
		}
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
