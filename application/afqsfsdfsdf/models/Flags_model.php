<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Flags_model extends CI_Model {

	protected $table            = "hm_flags_etats";
	protected $coords           = "hm_coords_flag";
    protected $etat_poteau      = "hm_flag_etat_poteau";
    protected $etat_bache       = "hm_flag_etat_bache";
    protected $etat_armature    = "hm_flag_etat_armature";
    protected $axe              = "hm_axe";
    protected $type             = "hm_flag_type";
    protected $operations       = "hm_flag_operations";
    protected $province         = "hm_province";
    protected $regions          = "hm_regions";
    protected $arrondissement   = "hm_arrondissement";

    public function __construct() {
        parent::__construct();
    }

	public function get_all() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	
	public function get_all_flag_coords() {
        $this->db->where("status", 1);
	    return $this->db->get($this->coords)->result_array();
	}
	
	public function get_etat_poteau() {
        $this->db->where("status", 1);
	    return $this->db->get($this->etat_poteau)->result();
	}

    public function get_etat_bache() {
        $this->db->where("status", 1);
        return $this->db->get($this->etat_bache)->result();
    }

    public function get_etat_armature() {
        $this->db->where("status", 1);
        return $this->db->get($this->etat_armature)->result();
    }

    public function get_types() {
        $this->db->where("status", 1);
        return $this->db->get($this->type)->result();
    }

    public function get_axes() {
        $this->db->where("status", 1);
        return $this->db->get($this->axe)->result();
    }

    public function get_provinces() {
        $this->db->where("status", 1);
        return $this->db->get($this->province)->result();
    }

    public function get_regions() {
        $this->db->where("status", 1);
        return $this->db->get($this->regions)->result();
    }

    public function get_arrondissements() {
        $this->db->where("status", 1);
        return $this->db->get($this->arrondissement)->result();
    }

    public function get_operations() {
        $this->db->where("status", 1);
        return $this->db->get($this->operations)->result();
    }

	public function save_flag($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}
/*
    public function maj_panneau($data = null) {
        if ($data != null) {
            return $this->db->insert($this->maj_table, $data);
        }
    }

    public function maj_panneau_get_all_by_id($id) {
        $this->db->where('id_panneau', $id);
        $this->db->where("status", 1);
        return $this->db->get($this->maj_table)->result();
    }

    public function get_panneau_maj_types() {
        $this->db->where("status", 1);
        return $this->db->get($this->maj_types)->result();
    }
*/
	public function update_flag($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function delete_flag($id) {
    	$this->db->where("id", $id);
    	$image_file = $this->db->get($this->table)->row();
    	
    	if(isset($image_file->image) && $image_file->image)
    		@unlink($image_file->image);

    	$this->db->where("id", $id);
    	return $this->db->delete($this->table);
    }

    public function get_flag_by_id($id) {
        $this->db->where("id", $id);
        $this->db->where("status", 1);
        return $this->db->get_where($this->table)->row();
    }
	
	public function getFlagsByFilter($array = null) {
        if ($array !== null) {
            $this->db->where("status", 1);
            foreach($array as $key => $filter) {
                $this->db->where_in($key, $filter);
            }
            $this->db->last_query();
            return $this->db->get($this->table)->result();
        } else {
            $this->db->where("status", 1);
            return $this->db->get($this->table)->result();
        }
    }
}