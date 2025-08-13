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
        $this->load->view('layouts/tasks/list_tasks', $data);
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
