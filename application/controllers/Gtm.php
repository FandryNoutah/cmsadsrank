<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gtm extends MY_Controller
{
	private $api_url = 'https://api.aircall.io/v1/calls';
	private $api_auth = 'e69c2f6c77144ad053a54bf77088aa09:6ab56a32536bc017ed6b2adb619338e0';
	protected $file_upload_field;

	public function __construct()
	{
		parent::__construct();

		$this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
		$this->load->model("Data_modele");
		$this->load->model("Image_model");
		$this->load->model("Task_message_model");
		$this->load->model("Task_model");
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
		$this->data['gtm_task'] = $this->Task_model->get_all_procedure_gtm();
		$this->content = "layouts/gtm/index.php";
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

	public function detail_task($id_task) {

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
}
