<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task extends MY_Controller
{

	protected $file_upload_field;


	public function __construct()
	{
		parent::__construct();

		$this->load->model('Tasks_model');
		$this->load->model('Gtm_model');
		$this->load->model('Task_message_model');
		$this->current_user = $this->ion_auth->user()->row();

		/* $this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
		$this->data['visuels'] = $this->visuels_model->get_all();
		$this->load->library('PHPExcel');
		$this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		
		$this->load->library('upload');
        $this->load->library('form_validation'); */
		//$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

	}

	public function index()
	{

		/* 
		 $this->data['Campgagne_non_actif'] = $this->visuels_model->getDonneeByCampagneNonActif();
		  $this->data['Campgagne_en_attente_envoye'] = $this->visuels_model->getDonneeByenattentedeenvoyestructure();
		$ko = $this->data['upsell'] = $this->visuels_model->getupsell();
		$this->data['produit'] = $this->Donne_modele->get_all_produit();
		$this->data['am'] = $this->Donne_modele->get_all_am();
		$this->data['initiative'] = $this->Donne_modele->get_all_initiative(); */

		// $this->page = "templates/v3/Task.php";

		$this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$this->data['users'] = $this->visuels_model->getusersall();
		$tasks = $this->data['tache'] = $this->Task_model->get_all_tâche();
		$this->data['count_planned'] = 0;
		$this->data['count_upcoming'] = 0;
		$this->data['count_completed'] = 0;

		foreach ($tasks as $task) {
			
			$task->expired = (new DateTime($task->date_due)) <= (new DateTime('now'));
			
			$task->count_messages = $this->Task_message_model->count_messages_by_task($task->idtask);
			switch ($task->status) {
				case "planifié":
					$this->data['count_planned']++;
					break;

				case "en cours":
					$this->data['count_upcoming']++;
					break;

				case "effectuée":
					$this->data['count_completed']++;
					break;
			}
		}

		$this->content = "layouts/task/index.php";
		$this->layout();
	}

	public function delete_task($task_id)
	{
		$this->Task_model->delete_task($task_id);
		redirect('Task');
	}

	public function edits_task()
	{

		$taskId = $this->input->post('taskId');
		$Statuts_technique = $this->input->post('Statuts_technique') !== null ? 3 : 1;

		$data = [
			'type_tache'		=>	$this->input->post('type_tache'),
			'Statuts_technique'	=>	$Statuts_technique,
			'title'				=>	$this->input->post('title'),
			'assigned_to'		=>	$this->input->post('assigned_to'),
			'date_demande'		=>	$this->input->post('date_demande'),
			'date_due'			=>	$this->input->post('date_due'),
			'description'		=>	$this->input->post('tache')
		];

		$this->Task_model->update_task($taskId, $data);
		redirect('Task');
	}

	public function change_status()
	{
		$id_task = $taskId = $this->input->post('taskId');
		$task = $this->Task_model->get_task_by_id($id_task);
		if ($this->input->post('status') == "effectuée") {
			if ($task->title == "Mise en pause" || $task->title == "Résiliation") {
				$statut_demande = 0;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$statut_upsell = 1;
				$this->visuels_model->update_status_upsell($statut_upsell, $idupsell);
			}
			if (strpos($task->title, "Erreur d'optimisation") === 0) {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$date_due = $task->date_due;
				$Débogage = "Implémenté";
				$this->Gtm_model->change_statut_optimisation($id, $Débogage, $date_due);
			}

			if ($task->title == "Relance client") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$this->visuels_model->change_statut_en_demande($id, $statut_demande);
				$statut_upsell = 1;
				$this->visuels_model->update_status_upsell($statut_upsell, $idupsell);
			}
			if ($task->title == "Mise en ligne") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$statut_upsell = 2;
				$this->visuels_model->update_status_upsell($statut_upsell, $idupsell);
			}
			if ($task->title == "Mise en ligne - Booster") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$statut_upsell = 1;
				$this->visuels_model->update_status_booster($statut_upsell, $idupsell);
			}
			if ($task->title == "Validation client") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$am = intval($task->assigned_to);
					$type_tache = 15;
					$title = "Mise en ligne";
					$description = "Veuiller mettre la campagne";
					$Statuts_technique = 1;
					$procedure_gtm = 4;
					$tm = 23;
					$date_debut = date('Y-m-d');
					$date_fin = date('Y-m-d', strtotime($date_debut . ' +2 days'));

					$data = array(
						'type_tache' => $type_tache,
						'date_demande' => $date_debut,
						'date_due' => $date_fin,
						'idclients' => $id,
						'AM' => $am,
						'assigned_to' => 23,
						'title' => $title,
						'Statuts_technique' => $Statuts_technique,
						'procedure_gtm' => $procedure_gtm,
						'description' => $description
					);

			$this->Task_model->add_task($data);
				
				
			}
			
			if ($task->title == "Demande invitation GTM") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$am = intval($task->AM);
					$type_tache = 3;
					$title = "Reception invitation";
					$description = "Veuiller mettre en tâche effectuer des que l'invitation du client est reçu";
					$Statuts_technique = 1;
					$procedure_gtm = 4;
					$tm = 23;
					$date_debut = date('Y-m-d');
					$date_fin = date('Y-m-d', strtotime($date_debut . ' +2 days'));

					$data = array(
						'type_tache' => $type_tache,
						'date_demande' => $date_debut,
						'date_due' => $date_fin,
						'idclients' => $id,
						'AM' => $am,
						'assigned_to' => 24,
						'title' => $title,
						'Statuts_technique' => $Statuts_technique,
						'procedure_gtm' => $procedure_gtm,
						'description' => $description
					);

			$this->Task_model->add_task($data);
				
				
			}
			if ($task->title == "Reception invitation") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$am = intval($task->AM);
				$statut = "Implémenté";
				$data = [
					'statut'   =>$statut,
				];
				$this->Gtm_model->update_implementation($id,$data);
				$date_invitation = date('Y-m-d');
				$data = [
					'invitation_reçu'   => $date_invitation,
				];
				$this->Gtm_model->update_invitation($id,$data);
			}
			if ($task->title == "Implémentation Plan de taggage") {
				$statut_demande = 3;
				$id = intval($task->idclients);
				$am = intval($task->AM);
				$statut = "Implémenté";
				$data = [
					'statut'   =>$statut,
				];
				$this->Gtm_model->update_implementation($id,$data);
			}
		}
		if ($this->input->post('status') == "effectuée") {
			if ($task->title == "Upsell") {
				$statut_demande = 0;
				$statut_actif = 1;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$this->visuels_model->activer_upsell($statut_actif, $idupsell);
				$upsell = $this->visuels_model->get_upsell_by_id($idupsell);
				$budget_finale = $upsell[0]['budgets'];
				$idclients = $upsell[0]['idclients'];
				$budget_finale = floatval($budget_finale);
				$this->visuels_model->update_budget($budget_finale, $idclients);
				$statut_upsell = 1;
				$this->visuels_model->update_status_upsell($statut_upsell, $idupsell);
			}
			if ($task->title == "Baisse") {
				$statut_demande = 0;
				$statut_actif = 1;
				$id = intval($task->idclients);
				$idupsell = $task->idupsell;
				$this->visuels_model->activer_upsell($statut_actif, $idupsell);
				$upsell = $this->visuels_model->get_upsell_by_id($idupsell);
				$budget_finale = $upsell[0]['budgets'];
				$idclients = $upsell[0]['idclients'];
				$budget_finale = floatval($budget_finale);
				$this->visuels_model->update_budget($budget_finale, $idclients);
				$statut_upsell = 1;
				$this->visuels_model->update_status_upsell($statut_upsell, $idupsell);
			}
		}
		$taskId = intval($taskId);
		$data = [
			'status'	=>	$this->input->post('status'),
		];
		$this->Task_model->update_task_statuts($taskId, $data);
		redirect('Task');
	}

		public function creer_task_implementation($id_task)
		{

					$type_tache = 3;
					$title = "Implémentation Plan de taggage";
					$description = "Veuiller mettre en place et implémenté le Plan de taggage du client";
					$Statuts_technique = 1;
					$procedure_gtm = 4;
					$tm = 23;
					$date_debut = date('Y-m-d');
					$date_fin = date('Y-m-d', strtotime($date_debut . ' +2 days'));

					$data = array(
						'type_tache' => $type_tache,
						'date_demande' => $date_debut,
						'date_due' => $date_fin,
						'idclients' => $id,
						'AM' => $am,
						'assigned_to' => $tm,
						'title' => $title,
						'Statuts_technique' => $Statuts_technique,
						'procedure_gtm' => $procedure_gtm,
						'description' => $description
					);

			$this->Task_model->add_task($data);
		}

	public function fetch_discussion($id_task)
	{

		// Check for order (ascendant || descendant)

		$messages = $this->Task_message_model->get_messages_by_task($id_task);
		$currentUser = $this->current_user;

		foreach ($messages as $message) {

			$created_at = $message->created_at;
			$message->created_at = (new DateTime($created_at))->format('j M, H:i');

			$message->owner = $message->user_id == $currentUser->id;
		}

		echo json_encode($messages);
	}

	public function send_message()
	{

		$id_task = $this->input->post('id_task', TRUE);
		$message = $this->input->post('message', TRUE);

		if (!empty($message) && $this->current_user) {
			$this->Task_message_model->insert_message([
				'user_id' => $this->current_user->id,
				'task_id' => $id_task,
				'message' => $message
			]);
		}

		echo json_encode([
			"done"	=>	true
		]);
	}

	public function detail_task($id_task)
	{

		$task = $this->Task_model->get_task_by_id($id_task);
		$messages = $this->Task_message_model->get_messages_by_task($id_task);

		foreach ($messages as $message) {

			$created_at = $message->created_at;
			$message->created_at = (new DateTime($created_at))->format('j M, H:i');

			$photo_users = base_url(IMAGES_PATH . $message->photo_users);
			$message->photo_users = $photo_users;
		}

		echo json_encode([
			'task'		=>	$task,
			'messages'	=>	$messages
		]);
	}

	public function detail_client($idclients)
	{
		$this->data['donne_detail_client'] = $this->visuels_model->getdonneclientbyidclients($idclients);

		$this->page = "templates/v3/Task.php";
		$this->layout();
	}

	public function insert_tache()
	{
		// Récupérer les données envoyées par le formulaire
		$type_tache = $this->input->post('type_tache');
		$date_demande = $this->input->post('date_demande');

		$date_due = $this->input->post('date_due');
		$idclients = $this->input->post('idclients');
		$AM = $this->input->post('am');
		$assigned_to = $this->input->post('assigned_to');
		$title = $this->input->post('title');
		$Statuts_technique = $this->input->post('Statuts_technique') !== null ? 3 : 1;
		$tache = $this->input->post('tache');
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
		$data = array(
			'type_tache' => $type_tache,
			'date_demande' => $date_demande,
			'date_due' => $date_due,
			'idclients' => $idclients,
			'AM' => $AM,
			'assigned_to' => $assigned_to,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'fichier_nom' => $fichier_nom,
			'description' => $tache
		);

		$this->Task_model->add_task($data);
		$this->session->set_flashdata('message-succes', "Tâche ajoutée avec succès");
		redirect('Task', 'refresh');
	}

	public function uptates_information()
	{
		// Récupérer les données envoyées par AJAX
		$idonnee = $this->input->post('idonnee');
		$inforamtion_upsell = $this->input->post('inforamtion_upsell');
		$budget_upsell = $this->input->post('budget_upsell');
		$statut_upsell = $this->input->post('statut_upsell');

		// Appeler la méthode du modèle pour mettre à jour les données
		$updateResult = $this->Donne_modele->update_information_upsell(
			$idonnee,
			$inforamtion_upsell,
			$budget_upsell,
			$statut_upsell
		);

		// Vérifier si la mise à jour a réussi
		if ($updateResult) {
			// Retourner un message de succès à la réponse AJAX
			echo json_encode(array('status' => 'success', 'message' => 'Mise à jour réussie'));
		} else {
			// Retourner un message d'erreur à la réponse AJAX
			echo json_encode(array('status' => 'error', 'message' => 'Erreur lors de la mise à jour'));
		}
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
		$config['allowed_types']    = 'gif|jpg|png';
		$config['max_size']         = '0';
		$config['file_name']        = url_title(iconv("UTF-8", "ASCII//TRANSLIT", $prefix . '_' . $file), '_', TRUE);
		$config['overwrite']        = FALSE;
		return $config;
	}
}
