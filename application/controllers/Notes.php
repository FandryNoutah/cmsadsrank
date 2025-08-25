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

		// Utilisateur connecté
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{

		$this->data['notes'] = $this->Note_model->get_for_user($this->current_user->id);
		$this->data['users'] = $this->Note_model->get_all_users();

		// dd($this->data['notes']);
		$this->content = "layouts/note/index.php";
		$this->layout();

		// $this->load->view('layouts/note/list', $data);
	}
	public function fetch_discussion($id_notes)
	{

		// Check for order (ascendant || descendant)

		$messages = $this->Task_message_model->get_messages_by_note($id_notes);
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

		$id_notes = $this->input->post('id_notes', TRUE);
		$message = $this->input->post('message', TRUE);

		if (!empty($message) && $this->current_user) {
			$this->Task_message_model->insert_message_note([
				'user_id' => $this->current_user->id,
				'id_notes' => $id_notes,
				'message' => $message
			]);
		}

		echo json_encode([
			"done"	=>	true
		]);
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

	public function create()
	{
		if ($this->input->method() === 'post') {
			$noteData = [
				'title'       => $this->input->post('title', TRUE),
				'content'     => $this->input->post('content', TRUE),
				'type'        => $this->input->post('type', TRUE),
				'status'      => $this->input->post('status', TRUE),
				'created_by'  => $this->current_user->id,
				'date_due'    => $this->input->post('date_due', TRUE),
			];

			$assignedUsers = $this->input->post('assigned_to') ?? [$this->current_user->id];

			/* if ($this->input->post('assign_mode') === 'self') {
				$assignedUsers[] = $this->current_user->id;
			} else {
				$assignedUsers = $this->input->post('assigned_to') ?? [];
			}

			if (empty($assignedUsers)) {
				$assignedUsers[] = $this->current_user->id;
			} */

			$this->Note_model->create($noteData, $assignedUsers);
			redirect('notes');
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
