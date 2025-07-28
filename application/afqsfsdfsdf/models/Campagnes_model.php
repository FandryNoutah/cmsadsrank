<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Campagnes_model extends CI_Model {

    protected $table = "hm_campagnes";
	protected $table1 = "hm_campagnes";
    protected $table2 = "hm_visuels";
	public function __construct() {
        parent::__construct();
    }
	
	public function get_all() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	public function get_allV() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table2)->result();
	}
	
	public function get_by_id($id) {
        $this->db->where("id", $id);
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	
	public function insererConcurrent($label,$date_debut,$date_fin,$visuels){
            $sql = "insert into hm_campagnes(label,date_debut,date_fin,visuels) values('".$label."','".$date_debut."','".$date_fin."','".$visuels."')";
			$this->db->query($sql);
            $this->db->close();
        }	
	public function update_campagne($id, $data = null) {
		if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
	}
	
	public function delete_row($id) {
        //$result = null;
		if($id !='' && $id != null  ){
            $this->db->where('id', $id);
            $this->db->set('status', 0);
            return $this->db->update($this->table);
        }
		return;
	}

}