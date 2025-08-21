<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notes extends MY_Controller
{

	private $current_user;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Note_model');
		$this->load->library('ion_auth');

		// Utilisateur connecté
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{

		$notes = $this->data['notes'] = $this->Note_model->get_for_user($this->current_user->id);
		$this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$this->data['users'] = $this->visuels_model->getusersall();

		// dd($this->data['notes']);
		$this->content = "layouts/note/index.php";
		$this->layout();

		// $this->load->view('layouts/note/list', $data);
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

			$assignedUsers = [];

			if ($this->input->post('assign_mode') === 'self') {
				$assignedUsers[] = $this->current_user->id;
			} else {
				$assignedUsers = $this->input->post('assigned_to') ?? [];
			}

			if (empty($assignedUsers)) {
				$assignedUsers[] = $this->current_user->id;
			}

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


}
