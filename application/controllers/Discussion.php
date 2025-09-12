<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Discussion extends MY_Controller
{
	protected $data;
 
	function __construct() {
		parent::__construct();
		$this->load->model("Discussion_model");
		$this->load->model("Note_model");
		$this->load->model("Task_message_model");

		$this->current_user = $this->ion_auth->user()->row();
		$idusers = $this->current_user->id;
		
		$this->data['nbr_discussion_gtm'] = count($this->Discussion_model->get_discussion_gtm_by_id_users($idusers));
	}

	public function index()
	{
		$idusers = $this->current_user->id;
		$discussion = $this->data['discussion_note'] = $this->Discussion_model->get_discussion_gtm_by_id_users($idusers);
		$notes = $this->Note_model->get_for_user($this->current_user->id);
		$this->data['users'] = $this->Note_model->get_all_users();

		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}

		$this->data['notes'] = $notes;
		$this->data['taches'] = $this->Task_model->get_all_tâche();
		$this->content = "layouts/discussion/index.php";
		$this->layout();
	}

	public function Team_task()
	{
		
		$idusers = $this->current_user->id;
		$discussion = $this->data['discussion_note'] = $this->Discussion_model->get_discussion_gtm_by_id_users($idusers);
		$notes = $this->Note_model->get_for_user($this->current_user->id);
		$this->data['users'] = $this->Note_model->get_all_users();

		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}

		$this->data['notes'] = $notes;
		$tasks = $this->data['tache'] = $this->Task_model->get_all_tâche();
		$this->data['count_planned'] = 0;
		$this->data['count_upcoming'] = 0;
		$this->data['count_completed'] = 0;

		foreach ($tasks as $task) {
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
		$this->content = "layouts/Discussion/Team_task/index.php";
		$this->layout();
	}

	public function Brief()
	{
		$idusers = $this->current_user->id;
		$discussion = $this->data['discussion_note'] = $this->Discussion_model->get_discussion_gtm_by_id_users($idusers);
		$this->data['nbr_discussion_gtm'] = $nbr_discussion_gtm = count($discussion);
		$notes = $this->Note_model->get_for_user($this->current_user->id);
		$this->data['users'] = $this->Note_model->get_all_users();

		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}

		$this->data['notes'] = $notes;
		$this->data['tache'] = $this->Task_model->get_all_tâche();
		$this->content = "layouts/discussion/brief/index.php";
		$this->layout();
	}

	public function Temporaire()
	{
		$idusers = $this->current_user->id;
		$discussion = $this->data['discussion_note'] = $this->Discussion_model->get_discussion_gtm_by_id_users($idusers);
		$this->data['nbr_discussion_gtm'] = $nbr_discussion_gtm = count($discussion);
		$notes = $this->Note_model->get_for_user($this->current_user->id);
		$this->data['users'] = $this->Note_model->get_all_users();

		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}

		$this->data['notes'] = $notes;
		$this->data['tache'] = $this->Task_model->get_all_tâche();
		$this->content = "layouts/discussion/temporaire/index.php";
		$this->layout();
	}

	public function Gtm()
	{
		$tasks = $this->data['taches'] = $this->Task_model->get_all_tâche();
		$this->data['count_planned'] = 0;
		$this->data['count_upcoming'] = 0;
		$this->data['count_completed'] = 0;

		foreach ($tasks as $task) {
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
		$this->content = "layouts/discussion/gtm/index.php";
		$this->layout();
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

}
