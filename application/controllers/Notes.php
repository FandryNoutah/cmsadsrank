<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends MY_Controller {

    private $current_user;

    public function __construct() {
        parent::__construct();
        $this->load->model('Note_model');
        $this->load->library('ion_auth');

        // Utilisateur connecté
        $this->current_user = $this->ion_auth->user()->row();

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function index() {

        $data['notes'] = $this->Note_model->get_for_user($this->current_user->id);
    	$data['users'] = $this->Note_model->get_all_users();
        var_dump( $data['notes']);
        die();
		//$this->content = "layouts/note/index.php";
		//$this->layout();

        $this->load->view('layouts/note/list', $data);
    }

    public function create() {
    if ($this->input->method() === 'post') {
        $noteData = [
            'title'       => $this->input->post('title', TRUE),
            'content'     => $this->input->post('content', TRUE),
            'type'        => $this->input->post('type', TRUE),
            'status'      => $this->input->post('status', TRUE),
            'created_by'  => $this->current_user->id
        ];

        $assignedUsers = [];

        if ($this->input->post('assign_mode') === 'self') {
            $assignedUsers[] = $this->current_user->id;
        } else {
            $assignedUsers = $this->input->post('assigned_to') ?? [];
        }

        if (empty($assignedUsers)) {
            $assignedUsers[] = $this->current_user->id; // sécurité
        }

        $this->Note_model->create($noteData, $assignedUsers);
        redirect('notes');
    }

    $data['users'] = $this->Note_model->get_all_users();
    $this->load->view('layouts/note/create', $data);
}



}
