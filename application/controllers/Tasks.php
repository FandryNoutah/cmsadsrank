<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tasks_model');
        $this->load->model('Task_message_model');
        $this->current_user = $this->ion_auth->user()->row();

        if (!$this->current_user) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['tasks'] = $this->Task_model->get_all_tasks();
        $data['users'] = $this->Task_model->get_all_users();
        $this->load->view('layouts/tasks/list_tasks', $data);
    }
    public function insert_tache() {
		// Récupérer les données envoyées par le formulaire
		$type_tache = $this->input->post('type_tache');
		$date_demande = $this->input->post('date_demande');
       
		$date_due = $this->input->post('date_due');
		$idclients = $this->input->post('idclients');
		$AM = $this->input->post('AM');
		$assigned_to = $this->input->post('assigned_to');
		$title = $this->input->post('title');
		$Statuts_technique = $this->input->post('Statuts_technique');
		$tache = $this->input->post('tache');
		$reference =
			$data = array(
				'type_tache' => $type_tache,
				'date_demande' => $date_demande,
				'date_due' => $date_due,
				'idclients' => $idclients,
				'AM' => $AM,
				'assigned_to' => $assigned_to,
				'title' => $title,
				'Statuts_technique' => $Statuts_technique,
				'description' => $tache
			);

		$this->Task_model->add_task($data);
		$this->session->set_flashdata('message-succes', "Tâche ajoutée avec succès");
		redirect('Task', 'refresh');
	}

    public function view($task_id)
    {
        $data['task'] = $this->Tasks_model->get_task($task_id);
        $data['messages'] = $this->Task_message_model->get_messages_by_task($task_id);
        $data['current_user'] = $this->current_user;

        $this->load->view('layouts/tasks/task_chat', $data);
    }

    public function send_message($task_id)
    {
        $message = $this->input->post('message', TRUE);

        if (!empty($message) && $this->current_user) {
            $this->Task_message_model->insert_message([
                'user_id' => $this->current_user->id,
                'task_id' => $task_id,
                'message' => $message
            ]);
        }

        redirect('tasks/view/' . $task_id);
    }
}
