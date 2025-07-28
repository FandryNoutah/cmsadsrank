<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Arche_model extends CI_Model {

	protected $table = "hm_arche";
	protected $formats = "hm_arche_formats";

    public function __construct() {
        parent::__construct();
    }

	public function get_all() {
        $this->db->where('status', 1);
        return $this->db->get($this->table)->result();
	}

	public function get_formats() {
        $this->db->where('status', 1);
        return $this->db->get($this->formats)->result();
	}

	public function save_arche($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}

	public function update_arche($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function delete_arche($id) {
    	/*
        $this->db->where("id", $id);
    	$image_file = $this->db->get($this->table)->row();
    	
    	if(isset($image_file->image) && $image_file->image)
    		@unlink($image_file->image);
        */
    	$this->db->where("id", $id);
    	return $this->db->delete($this->table);
    }

    public function get_arche_by_id($id) {
        $this->db->where("id", $id);
        return $this->db->get_where($this->table)->row();
    }
}