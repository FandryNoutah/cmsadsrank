<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Note_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
    public function create($noteData, $assignedUsers) {
        $this->db->insert('notes', $noteData);
        $note_id = $this->db->insert_id();

        if (!empty($assignedUsers)) {
            $batch = [];
            foreach ($assignedUsers as $user_id) {
                $batch[] = [
                    'note_id' => $note_id,
                    'user_id' => $user_id
                ];
            }
            $this->db->insert_batch('note_users', $batch);
        }
        return $note_id;
    }

    public function get_for_user($user_id) {
        $this->db->select('n.*, u.username AS author');
        $this->db->from('notes n');
        $this->db->join('users u', 'u.id = n.created_by', 'left');
        $this->db->join('note_users nu', 'nu.note_id = n.id', 'inner');
        $this->db->where('nu.user_id', $user_id);
        $this->db->order_by('n.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_users() {
        return $this->db->select('id, username')
                        ->from('users')
                        ->order_by('username', 'ASC')
                        ->get()
                        ->result();
    }

    public function get_note_recipients($note_id) {
        $this->db->select('u.username');
        $this->db->from('note_users nu');
        $this->db->join('users u', 'u.id = nu.user_id');
        $this->db->where('nu.note_id', $note_id); // line 45
        return $this->db->get()->result();
    }
}
