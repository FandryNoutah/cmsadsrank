<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Panneaux_model extends CI_Model {

	protected $table = "hm_data";

    public function __construct() {
        parent::__construct();
    }

	public function get_all($sam_id = null) {
		if($sam_id != null)
			$this->db->where("region", $sam_id);
			//$this->db->where("panneau_sam", $sam_id);
        $this->db->where("status", 1);
        $this->db->where("support", 5);
	    return $this->db->get($this->table)->result();
	}
	
	public function get_by_filters($support, $array = null) {
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

	/*
	public function getAll() {
		$this->db->select("hm_data.id, hm_data.ville, hm_data.quartier, hm_data.emplacement, hm_data.longitude, hm_data.latitude, hm_data.format, hm_data.reference, hm_data.etat, hm_data.societe, hm_data.commentaire");
		$this->db->from("hm_data as d");
		$this->db->join('hm_type as type', 'type.id = hm_data.type');
		$this->db->join('hm_region as reg', 'reg.id = hm_data.region');
		$this->db->join('hm_regisseur as rgs', 'rgs.id = hm_data.regisseur');
		$this->db->join('hm_support as sup', 'sup.id = hm_data.support');
		$this->db->join('hm_province as prov', 'prov.id = hm_data.province');
		$this->db->join('hm_visuels as vis', 'vis.id = hm_data.visuel_actuel');
		$this->db->where("hm_data.status", 1);
		return $this->db->get('d')->result;
	}
	*/
	
	public function getAll() {
		$queryString = "";
		$queryString .= "select d.id, d.ville, d.quartier, d.emplacement, d.longitude, d.latitude, d.format, d.reference, d.etat, d.societe, d.commentaire,";
		$queryString .= "reg.label as region, ";
		$queryString .= "vis.label as visuel, "; 
		$queryString .= "rgs.label as regisseur, "; 
		$queryString .= "type.label as type, ";
		$queryString .= "prov.label as province, ";
		$queryString .= "sup.label as support ";
		$queryString .= "FROM hm_data d ";
		$queryString .= "JOIN hm_type type on type.id = d.type ";
		$queryString .= "JOIN hm_region reg on reg.id = d.region ";
		$queryString .= "JOIN hm_regisseur rgs on rgs.id = d.regisseur ";
		$queryString .= "JOIN hm_support sup on sup.id = d.support ";
		$queryString .= "JOIN hm_province prov on prov.id = d.province ";
		$queryString .= "JOIN hm_visuels vis on vis.id = d.visuel_actuel ";
		$queryString .= "WHERE d.status = 1 ";
		$queryString .= "AND d.support = 5 ";
		return $this->db->query($queryString)->result();
	}
}