<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_message_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_messages_by_task($task_id) {
        $this->db->select('group_messages.*, users.username, users.photo_users');
        $this->db->from('group_messages');
        $this->db->join('users', 'users.id = group_messages.user_id');
        $this->db->where('group_messages.task_id', $task_id);
        $this->db->order_by('group_messages.created_at', 'ASC');
        return $this->db->get()->result();
    }

    public function count_messages_by_task($task_id) {
        $this->db->select('group_messages.*');
        $this->db->from('group_messages');
        $this->db->where('group_messages.task_id', $task_id);
        return $this->db->count_all_results();
    }

    public function insert_message($data) {
        return $this->db->insert('group_messages', $data);
    }
     public function get_messages_by_note($task_id) {
        $this->db->select('group_messages_note.*, users.username, users.photo_users');
        $this->db->from('group_messages_note');
        $this->db->join('users', 'users.id = group_messages_note.user_id');
        $this->db->where('group_messages_note.task_id', $task_id);
        $this->db->order_by('group_messages_note.created_at', 'ASC');
        return $this->db->get()->result();
    }

    public function insert_message_note($data) {
        return $this->db->insert('group_messages_note', $data);
    }
}
