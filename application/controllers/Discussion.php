<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Discussion extends MY_Controller
{
	protected $data;
 
	function __construct() {
		parent::__construct();
		$this->load->model("Discussion_model");
		$this->load->model("Note_model");
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
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
		$this->content = "layouts/Discussion/index.php";
		$this->layout();
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
