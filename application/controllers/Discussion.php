<?php defined('BASEPATH') or exit('No direct script access allowed');

class Discussion extends MY_Controller
{
	protected $data;

	function __construct()
	{
		parent::__construct();
		$this->load->model('Discussion_model');
		$this->load->model('Note_model');
		$this->load->model('Task_message_model');
		$this->load->model('Note_message_model');

		$this->current_user = $this->ion_auth->user()->row();
		$idusers = $this->current_user->id;

		// $count_gtm = $this->data['nbr_discussion_gtm'] = count($this->Discussion_model->get_discussion_gtm_by_id_users($idusers));
		// $count_task = $this->data['nbr_discussion_task'] = count($this->Discussion_model->get_discussion_teamtask_by_id_users($idusers));
		// $count_note = $this->data['nbr_discussion_note'] = count($this->Discussion_model->get_discussion_note_by_id_users($idusers));

		// $this->data['nbr_discussion_all'] = $count_gtm + $count_task + $count_note;
	}

	public function index()
	{
		$idusers = $this->current_user->id;
		$tasks = $this->Task_model->get_task_for_users_by_type();
		$notes = $this->Note_model->get_for_user();

		foreach ($tasks as $index => $task) {
			$task->count_messages = $this->Task_message_model->count_messages_by_task($task->idtask);
			if ($task->count_messages <= 0 || $task->status !== "planifié") {
				unset($tasks[$index]);
			}
		}
		$this->data['tasks'] = $tasks;

		foreach ($notes as $index => $note) {
			$note->count_messages = $this->Note_message_model->count_messages_by_note($note->id);
			if ($note->count_messages <= 0) {
				unset($notes[$index]);
			}
		}
		$this->data['notes'] = $notes;

		$this->content = "layouts/discussion/index.php";
		$this->layout();
	}

	public function Note()
	{
		$idusers = $this->current_user->id;
		$notes = $this->Note_model->get_for_user();

		foreach ($notes as $index => $note) {
			$note->count_messages = $this->Note_message_model->count_messages_by_note($note->id);
			if ($note->count_messages <= 0) {
				unset($notes[$index]);
			}
		}

		$this->data['notes'] = $notes;
		
		$this->content = "layouts/discussion/note/index.php";
		$this->layout();
	}

	public function Team_task()
	{

		$idusers = $this->current_user->id;
		$tasks = $this->Task_model->get_task_for_users_by_type(null, 1);
		foreach ($tasks as $index => $task) {
			$task->count_messages = $this->Task_message_model->count_messages_by_task($task->idtask);
			if ($task->count_messages <= 0 || $task->status !== "planifié") {
				unset($tasks[$index]);
			}
		}
		$this->data['tasks'] = $tasks;

		$this->content = "layouts/Discussion/Team_task/index.php";
		$this->layout();
	}

	public function Brief()
	{
		$idusers = $this->current_user->id;
		$tasks = $this->Task_model->get_task_for_users_by_type(null, 5);
		foreach ($tasks as $index => $task) {
			$task->count_messages = $this->Task_message_model->count_messages_by_task($task->idtask);
			if ($task->count_messages <= 0 || $task->status !== "planifié") {
				unset($tasks[$index]);
			}
		}
		$this->data['tasks'] = $tasks;

		$this->content = "layouts/discussion/brief/index.php";
		$this->layout();
	}

	public function Temporaire()
	{
		$idusers = $this->current_user->id;
		$tasks = $this->Task_model->get_task_for_users_by_type(null, 2);
		foreach ($tasks as $index => $task) {
			$task->count_messages = $this->Task_message_model->count_messages_by_task($task->idtask);
			if ($task->count_messages <= 0 || $task->status !== "planifié") {
				unset($tasks[$index]);
			}
		}
		$this->data['tasks'] = $tasks;

		$this->content = "layouts/discussion/temporaire/index.php";
		$this->layout();
	}

	public function Gtm()
	{
		$idusers = $this->current_user->id;
		$tasks = $this->Task_model->get_all_procedure_gtm();
		foreach ($tasks as $index => $task) {
			$task->count_messages = $this->Task_message_model->count_messages_by_task($task->idtask);
			if ($task->count_messages <= 0 || $task->status !== "planifié") {
				unset($tasks[$index]);
			}
		}
		$this->data['tasks'] = $tasks;

		$this->content = "layouts/discussion/gtm/index.php";
		$this->layout();
	}

	public function fetch_discussion()
	{

		$currentUser = $this->current_user;
		$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);

		switch ($type) {
			case 'note':
				$messages = $this->Note_message_model->get_messages_by_note($id);
				break;

			default:
				$messages = $this->Task_message_model->get_messages_by_task($id);
				break;
		}

		foreach ($messages as $message) {

			$created_at = $message->created_at;
			$message->created_at = (new DateTime($created_at))->format('j M, H:i');

			$message->owner = $message->user_id === $currentUser->id;
		}

		echo json_encode($messages);
	}

	public function send_message()
	{

		$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);
		$message = $this->input->post('message', TRUE);

		if (!empty($message) && $this->current_user) {

			switch ($type) {

				case 'note':
					$this->Note_message_model->insert_message([
						'user_id' => $this->current_user->id,
						'id_notes' => $id,
						'message' => $message
					]);
					break;

				default:
					$this->Task_message_model->insert_message([
						'user_id' => $this->current_user->id,
						'task_id' => $id,
						'message' => $message
					]);
					break;
			}
		}

		echo json_encode([
			"done"	=>	true
		]);
	}

	public function detail_task($id_task)
	{

		$task = $this->Task_model->get_task_by_id($id_task);

		echo json_encode([
			'task'		=>	$task
		]);
	}

	public function detail_note($id_note)
	{

		$note = $this->Note_model->get_by_id($id_note);
		$assigned_users = $this->Note_model->get_assigned_users($id_note);

		echo json_encode([
			'note'		=>	$note,
			'assigned_users'	=>	$assigned_users
		]);
	}
}
