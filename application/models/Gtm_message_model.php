<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gtm_message_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_messages_by_gtm($id_task) {
        $this->db->select('group_messages_gtm.*, users.username, users.photo_users');
        $this->db->from('group_messages_gtm');
        $this->db->join('users', 'users.id = group_messages_gtm.user_id');
        $this->db->where('group_messages_gtm.id_task', $id_task);
        $this->db->order_by('group_messages_gtm.created_at', 'ASC');
        return $this->db->get()->result();
    }

    public function count_messages_by_note($note_id) {
        $this->db->select('group_messages_gtm.*');
        $this->db->from('group_messages_gtm');
        $this->db->where('group_messages_gtm.id_task', $id_task);
        return $this->db->count_all_results();
    }

    public function insert_message_gtm($data) {
        return $this->db->insert('group_messages_gtm', $data);
    }
}
