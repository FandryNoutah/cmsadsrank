<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_tasks() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('tasks')->result();
    }

    public function get_task($idtask) {
        return $this->db->get_where('tasks', ['idtask' => $idtask])->row();
    }
}
