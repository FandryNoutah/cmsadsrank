<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Regisseur_model extends CI_Model {

	protected $table = "hm_regisseur";

    public function __construct() {
        parent::__construct();
    }

	public function get_all() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}

	public function save_regisseur($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}

	public function update_regisseur($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function delete_regisseur($id) {
    	$this->db->where("id", $id);
    	return $this->db->delete($this->table);
    }

    public function get_regisseur_by_id($id) {
        $this->db->where("id", $id);
        $this->db->where("status", 1);
        return $this->db->get_where($this->table)->row();
    }
}