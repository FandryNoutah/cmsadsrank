<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Panneau_model extends CI_Model {

	protected $table        = "hm_panneau";
	protected $coords       = "hm_coords_panneaux";
    protected $format       = "hm_panneau_format";
    protected $regisseur    = "hm_regisseur";
    protected $province     = "hm_province";
    protected $type         = "hm_panneau_type";
    protected $axe          = "hm_axe";
    protected $sam          = "hm_sam";
    protected $region       = "hm_regions";
    protected $maj_types    = "hm_panneau_maj_types";
    protected $maj_table    = "hm_panneau_maj";
    protected $_database;
    public $table_fields = array();

    public function __construct() {
        parent::__construct();
    }
	
	public function get_table_headers($table) {
		//SELECT column_name, column_comment FROM information_schema.columns WHERE table_name = 'user'
		$this->db->select("column_name, column_comment");
		$this->db->where("table_name", $table);
		$this->db->where("table_schema", "horsmedia_v2");
		return $this->db->get("information_schema.columns")->result_array();
	}

    public function _get_table_fields() {
        if(empty($this->table_fields))
        {
            $this->table_fields = $this->db->list_fields($this->table);
            return $this->table_fields;
        }
        return TRUE;
    }

	public function get_all($sam_id = null) {
		if($sam_id != null)
			$this->db->where("panneau_sam", $sam_id);
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	
	public function get_all_panneau_coords() {
        $this->db->where("status", 1);
	    return $this->db->get($this->coords)->result_array();
	}

	public function get_formats() {
        $this->db->where("status", 1);
	    return $this->db->get($this->format)->result();
	}

    public function get_regisseurs() {
        $this->db->where("status", 1);
        return $this->db->get($this->regisseur)->result();
    }

    public function get_provinces() {
        $this->db->where("status", 1);
        return $this->db->get($this->province)->result();
    }

    public function get_provinces_arrd() {
        $this->db->select("id, panneau_region, status");
        $this->db->where("status", 1);
        $this->db->group_by("panneau_region");
        $this->db->order_by("panneau_region", 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_all_visuels() {
        $this->db->select("id, panneau_visuel_actuel, status");
        $this->db->where("status", 1);
        $this->db->group_by("panneau_visuel_actuel");
        $this->db->order_by("panneau_visuel_actuel", 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_types() {
        $this->db->where("status", 1);
        return $this->db->get($this->type)->result();
    }

    public function get_all_sam() {
        $this->db->where("status", 1);
        return $this->db->get($this->sam)->result();
    }

    public function get_axes() {
        $this->db->where("status", 1);
        return $this->db->get($this->axe)->result();
    }

    public function get_regions() {
        $this->db->where("status", 1);
        return $this->db->get($this->region)->result();
    }

	public function save_panneau($data = null) {
		if ($data != null) {
            $this->db->insert($this->table, $data);
			$this->db->trans_complete();
			return $this->db->insert_id();
        }
	}

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

	public function update_panneau($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function delete_panneau($id) {
    	$this->db->where("id", $id);
    	$image_file = $this->db->get($this->table)->row();
    	
    	if(isset($image_file->image) && $image_file->image)
    		@unlink($image_file->image);

    	$this->db->where("id", $id);
    	return $this->db->delete($this->table);
    }

    public function get_by($column = null, $data = null) {
        if($column != null && $data != null) {
            $this->db->where("status", 1);
            $this->db->where($column, $data);
            return $this->db->get_where($this->table)->result();
        }
        return false;
    }

    public function get_panneau_by_id($id) {
        $this->db->where("id", $id);
        $this->db->where("status", 1);
        return $this->db->get_where($this->table)->row();
    }

    public function get_panneauarray_by_id($id) {
        $this->db->where("id", $id);
        $this->db->where("status", 1);
        return $this->db->get_where($this->table)->row_array();
    }

    public function get_panneau_by_filters($array = null) {
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

    public function getFormats() {
        $this->db->where("status", 1);
        return $this->db->get($this->format)->result_array();
    }

    public function getTypes() {
        $this->db->where("status", 1);
        return $this->db->get($this->type)->result_array();
    }

    public function getSAM() {
        $this->db->where("status", 1);
        return $this->db->get($this->sam)->result_array();
    }

    public function getAxes() {
        $this->db->where("status", 1);
        return $this->db->get($this->axe)->result_array();
    }

    public function getRegions() {
        $this->db->where("status", 1);
        return $this->db->get($this->region)->result_array();
    }

    public function getProvinces() {
        $this->db->where("status", 1);
        return $this->db->get($this->province)->result_array();
    }

    public function getRegisseurs() {
        $this->db->where("status", 1);
        return $this->db->get($this->regisseur)->result_array();
    }

    public function getPanneauByFilter($array = null) {
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