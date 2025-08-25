<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Note_message_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_messages_by_note($note_id) {
        $this->db->select('group_messages_note.*, users.username, users.photo_users');
        $this->db->from('group_messages_note');
        $this->db->join('users', 'users.id = group_messages_note.user_id');
        $this->db->where('group_messages_note.id_notes', $note_id);
        $this->db->order_by('group_messages_note.created_at', 'ASC');
        return $this->db->get()->result();
    }

    public function count_messages_by_note($note_id) {
        $this->db->select('group_messages_note.*');
        $this->db->from('group_messages_note');
        $this->db->where('group_messages_note.id_notes', $note_id);
        return $this->db->count_all_results();
    }

    public function insert_message($data) {
        return $this->db->insert('group_messages_note', $data);
    }
}
