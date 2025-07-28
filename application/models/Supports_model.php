<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supports_model extends CI_Model {

	protected $table = "hm_support";

    public function __construct() {
        parent::__construct();
    }
	
	public function get_all() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	
	public function get_by_id($id) {
		$this->db->get('hm_data');
		$this->db->where('support', $id);
        $this->db->where("status", 1);
	    return $this->db->get('hm_data')->result();
	}
}