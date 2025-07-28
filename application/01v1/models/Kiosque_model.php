<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kiosque_model extends CI_Model {

	protected $table = "hm_kiosques";
	protected $dimensions = "hm_kiosque_dimension";

    public function __construct() {
        parent::__construct();
    }

	public function get_all() {
	   return $this->db->get($this->table)->result();
	}

	public function get_dimensions() {
	   return $this->db->get($this->dimensions)->result();
	}

	public function save_kiosque($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}

	public function update_kiosque($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function delete_kiosque($id) {
    	$this->db->where("id", $id);
    	$image_file = $this->db->get($this->table)->row();
    	
    	if(isset($image_file->image) && $image_file->image)
    		@unlink($image_file->image);

    	$this->db->where("id", $id);
    	return $this->db->delete($this->table);
    }

    public function get_kiosque_by_id($id) {
        $this->db->where("id", $id);
        return $this->db->get_where($this->table)->row();
    }
}