<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notes extends MY_Controller
{

	private $current_user;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Note_model');
		$this->load->model('Note_message_model');
		$this->load->library('ion_auth');
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{

		$notes = $this->Note_model->get_for_user($this->current_user->id);

		$this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$users = $this->Note_model->get_all_users();

		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}

		foreach ($users as $index => $user) {
			if ($user->id == $this->current_user->id) {
				unset($users[$index]);
			}
		}

		$this->data['users'] = $users;
		$this->data['notes'] = $notes;

		$this->content = "layouts/note/index.php";
		$this->layout();

		// $this->load->view('layouts/note/list', $data);
	}

	public function detail_note($id_note)
	{

		$note = $this->Note_model->get_by_id($id_note);
		$assigned_users = $this->Note_model->get_assigned_users($id_note);
		$messages = $this->Note_message_model->get_messages_by_note($id_note);

		foreach ($messages as $message) {

			$created_at = $message->created_at;
			$message->created_at = (new DateTime($created_at))->format('j M, H:i');

			$photo_users = base_url(IMAGES_PATH . $message->photo_users);
			$message->photo_users = $photo_users;
		}

		echo json_encode([
			'note'		=>	$note,
			'messages'	=>	$messages,
			'assigned_users'	=>	$assigned_users
		]);
	}

	public function create($idclients = null)
	{
		if ($this->input->method() === 'post') {
			$this->load->library('upload');

			$fichier_nom = null;

			if (isset($_FILES['fichier']) && $_FILES['fichier']['name'] != '') {
				$config['upload_path']   = './uploads/';
				$config['allowed_types'] = 'jpg|png|gif|pdf|doc|docx|xls|xlsx|csv';
				$config['max_size'] = 10240;
				$config['encrypt_name']  = TRUE;
				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, true);
				}

				$this->upload->initialize($config);
				if ($this->upload->do_upload('fichier')) {
					$uploadData = $this->upload->data();
					$fichier_nom = 'uploads/' . $uploadData['file_name'];
				} else {
					$error = $this->upload->display_errors();
					log_message('error', 'Échec de l\'upload: ' . $error);
					$this->session->set_flashdata('error', 'Erreur lors de l\'upload : ' . $error);
					redirect('notes/create');
					return;
				}
			}

			$noteData = [
				'idclients'		=>	$idclients = $idclients ?? $this->input->post('idclients', TRUE) ?? null,
				'title'       	=>	$this->input->post('title', TRUE),
				'content'     	=>	$this->input->post('content', TRUE),
				'type'        	=>	$this->input->post('type', TRUE),
				'status'      	=>	$this->input->post('status', TRUE),
				'created_by'  	=>	$this->current_user->id,
				'date_due'    	=>	$this->input->post('date_due', TRUE),
				'fichier_nom'  	=>	$fichier_nom,
			];
			$assignedUsers = $this->input->post('assigned_to') ?? [];
			$assignedUsers[] = $this->current_user->id;

			$this->Note_model->create($noteData, $assignedUsers);
			if ($idclients != null) {
				redirect('Client/detail_client/'. $idclients);
			} else {
				redirect('Notes');
			}
		}

		$data['users'] = $this->Note_model->get_all_users();
		$this->load->view('layouts/note/create', $data);
	}


	public function edit($id)
	{
		$note = $this->Note_model->get_by_id($id);
		if (!$note) {
			show_404();
		}

		if ($this->input->method() === 'post') {
			$noteData = [
				'title'    => $this->input->post('title', TRUE),
				'content'  => $this->input->post('content', TRUE),
				'type'     => $this->input->post('type', TRUE),
				'status'   => $this->input->post('status', TRUE),
				'date_due' => $this->input->post('date_due', TRUE),
			];

			$assignedUsers = [];

			if ($this->input->post('assign_mode') === 'self') {
				$assignedUsers[] = $this->current_user->id;
			} else {
				$assignedUsers = $this->input->post('assigned_to') ?? [];
			}

			if (empty($assignedUsers)) {
				$assignedUsers[] = $this->current_user->id;
			}

			$this->Note_model->update($id, $noteData, $assignedUsers);
			redirect('notes');
		}

		$data['note'] = $note;
		$data['users'] = $this->Note_model->get_all_users();
		$data['assigned_users'] = $this->Note_model->get_assigned_users($id);
		$this->load->view('layouts/note/edit', $data);
	}

	public function delete($id)
	{
		$note = $this->Note_model->get_by_id($id);
		if (!$note) {
			show_404();
		}

		if ($note->created_by != $this->current_user->id) {
			show_error('Action non autorisée', 403);
		}

		$this->Note_model->delete($id);
		redirect('notes');
	}

	public function fetch_discussion($id_note)
	{

		// Check for order (ascendant || descendant)

		$messages = $this->Note_message_model->get_messages_by_note($id_note);
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

		$id_note = $this->input->post('id_note', TRUE);
		$message = $this->input->post('message', TRUE);

		if (!empty($message) && $this->current_user) {
			$this->Note_message_model->insert_message([
				'user_id' => $this->current_user->id,
				'id_notes' => $id_note,
				'message' => $message
			]);
		}

		echo json_encode([
			"done"	=>	true
		]);
	}
}
