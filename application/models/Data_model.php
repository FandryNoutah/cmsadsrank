<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_model extends CI_Model {

	protected $table      = "hm_data";
    protected $format     = "hm_format";
    protected $regisseur  = "hm_regisseur";
    protected $province   = "hm_province";
    protected $type       = "hm_type";
    protected $region     = "hm_region";
    protected $visuels    = "hm_visuels";
    protected $campagne   = "hm_campagnes";
    protected $_database;
    protected $_queryString = "";
    public $table_fields = array();

    public function __construct() {
        parent::__construct();
		$this->_queryString .= "select d.id, d.ville, d.quartier, d.emplacement, d.longitude, d.latitude, d.format, d.reference, d.etat, d.societe, d.commentaire, d.hm_visuel_campagne, ";
		$this->_queryString .= "reg.label as region, ";
		$this->_queryString .= "vis.label as visuel, "; 
		$this->_queryString .= "rgs.label as regisseur, "; 
		$this->_queryString .= "type.label as type, ";
		$this->_queryString .= "prov.label as province, ";
		$this->_queryString .= "sup.label as support ";
		$this->_queryString .= "FROM hm_data d ";
		$this->_queryString .= "JOIN hm_type type on type.id = d.type ";
		$this->_queryString .= "JOIN hm_region reg on reg.id = d.region ";
		$this->_queryString .= "JOIN hm_regisseur rgs on rgs.id = d.regisseur ";
		$this->_queryString .= "JOIN hm_support sup on sup.id = d.support ";
		$this->_queryString .= "JOIN hm_province prov on prov.id = d.province ";
		$this->_queryString .= "JOIN hm_visuels vis on vis.id = d.visuel_actuel ";
		$this->_queryString .= "WHERE vis.status = 1 ";
		$this->_queryString .= "AND d.status = 1 ";
    }
	
	public function getAll($support = null) {
		$queryString = $this->_queryString;
		if($support != null)
			$queryString .= " AND d.support = $support";
		
		//print_r($queryString);
		//exit;
		
		return $this->db->query($queryString)->result();
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

    public function get_array_by_id($id) {
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
	
	public function getStatByColumn($support, $column = null) {
		$queryString = $this->_queryString;
		$queryString .= " AND d.support = $support";
		//echo $queryString;
		return $this->db->query($queryString)->result();
	}
	
	public function getStatVisuelsByColumn($support, $column = null, $value = null) {
		$queryString  = "select ";
        $queryString .= "vis.label as visuel, ";
        $queryString .= "COUNT(visuel_actuel) as datacount ";
        $queryString .= "FROM hm_data d ";
        $queryString .= "JOIN hm_visuels vis on vis.id = d.visuel_actuel ";
        $queryString .= "WHERE d.status = 1 ";
        $queryString .= "AND d.support = $support ";
        
        if ($value != null)
            $queryString .= "AND d.$column = '$value' ";
        
        $queryString .= "GROUP BY visuel ";
        $queryString .= "ORDER BY datacount DESC";
        //echo $queryString;
		return $this->db->query($queryString)->result();
	}
	
	public function getVisuels($support) {
        $queryString  = "select DISTINCT d.visuel_actuel, vis.label as visuel ";
        $queryString .= "FROM hm_data d ";
        $queryString .= "JOIN hm_visuels vis on vis.id = d.visuel_actuel ";
        $queryString .= "WHERE d.status = 1 AND d.support = $support ";
        $queryString .= "AND vis.status = 1 ";
        $queryString .= "GROUP BY visuel";
        return $this->db->query($queryString)->result();
    }
	
	public function getTypes($support) {
		$queryString  = "select DISTINCT d.type as id, tp.label as label ";
        $queryString .= "FROM hm_data d ";
        $queryString .= "JOIN hm_type tp on tp.id = d.type ";
        $queryString .= "WHERE d.status = 1 AND d.support = $support ";
        $queryString .= "GROUP BY label";
        return $this->db->query($queryString)->result();
	}
	
	public function getRegisseurs($support) {
		$queryString  = "select DISTINCT d.regisseur as id, reg.label as label ";
        $queryString .= "FROM hm_data d ";
        $queryString .= "JOIN hm_regisseur reg on reg.id = d.regisseur ";
        $queryString .= "WHERE d.status = 1 AND d.support = $support ";
        $queryString .= "GROUP BY label";
        return $this->db->query($queryString)->result();
	}

    public function getFormats($support) {
		$this->db->select('id, format, support');
		$this->db->distinct();
		$this->db->where('support', $support);
		$this->db->group_by('format');
        $this->db->where("status", 1);
        return $this->db->get($this->table)->result();
    }

    /*public function getTypes() {
        $this->db->where("status", 1);
        return $this->db->get($this->type)->result();
    }*/

    public function getRegions() {
        $this->db->where("status", 1);
        return $this->db->get($this->region)->result();
    }

    public function getProvinces() {
        $this->db->where("status", 1);
        return $this->db->get($this->province)->result();
    }
	/*
    public function getRegisseurs() {
        $this->db->where("status", 1);
        return $this->db->get($this->regisseur)->result();
    }*/

    public function getByFilter_old($support, $array = null) {
        if ($array !== null) {
            $this->db->where("status", 1);
            $this->db->where("support", $support);
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
	
	public function getByFilter($support, $array = null) {
		$this->_queryString .= "AND d.support = $support ";
        if ($array !== null && count($array) > 0) {
			$this->_queryString .= " AND ";
			$count = 1;
            foreach($array as $key => $filter) {
				$filterString = "('";
				$filterString .= implode("','", $filter) . "')";
				$this->_queryString .= " d.$key in $filterString ";
				if($count < count($array))
					$this->_queryString .= " AND ";
				++$count;
            }
        }
		echo $this->_queryString;
		return $this->db->query($this->_queryString)->result();
    }
	
	public function getCampagnes() {
		//$this->db->select('label, data');
		$this->db->select('label');
		$this->db->where("status", 1);
		return $this->db->get($this->campagne)->result();
	}
	
	public function updateCV($id, $value) {
		$data = array( 
			'hm_visuel_campagne' => $value
		);

		$this->db->where('id', $id);
		$this->db->update('hm_data', $data);
	}
}