<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Campagne_model extends CI_Model {

    protected $table           = "hm_campagnes";
    protected $panneau         = "hm_panneau";
    protected $visuels         = "hm_visuel";
	//protected $campagneVisuel  = "hm_campagne_visuel";
	protected $campagneVisuel  = "hm_campagne_visuel_sam";
    protected $_database;
    public $table_fields = array();

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->where("status", 1);
        return $this->db->get($this->table)->result();
    }
	
	public function save_campagne($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}
	
	public function save_campagne_visuel_sam($data = null) {
		if ($data != null) {
            $this->db->insert($this->campagneVisuel, $data);
			$this->db->trans_complete();
			return $this->db->insert_id();
        }
	}
	
	public function update_campagne($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function get_all_visuels() {
        $this->db->where("status", 1);
        $this->db->order_by("panneau_visuel_name", "asc");
        return $this->db->get($this->visuels)->result_array();
    }

    public function get_campagne_visuels() {
        return $this->db->get($this->campagneVisuel)->result_array();
    }


    public function getAll($params = null) {
        $return = array();
    }

    public function getPanneauByFilter($array = null) {
        //SELECT hm_panneau.*, hm_campagne_visuel.visuel_id as visuel_id, hm_campagne_visuel.campagne_id as campagne_id FROM hm_panneau
        //INNER JOIN hm_campagne_visuel ON hm_panneau.id=hm_campagne_visuel.panneau_id WHERE
        if ($array !== null) {
            foreach($array as $key => $filter) {
                $this->db->where_in($key, $filter);
            }
        }
        $query = $this->db->select("hm_panneau.*, hm_campagne_visuel_sam.visuel_id as visuel_id, hm_campagne_visuel_sam.campagne_id as campagne_id")
                      ->from("hm_panneau")
                      ->join("hm_campagne_visuel_sam", "hm_panneau.id=hm_campagne_visuel_sam.panneau_id")
					  ->where("status", 1)
                      ->get();
        return $query->result_array();
    }

    public function getVisuels() {

    }

    public function resultByFilter($array = null) {
        $result = array();
        $res    = array();


        $model = $this->getPanneauByFilter($array);

        foreach($model as $keyFilter => $valueFilter) {
            $result[$valueFilter["id"]][$valueFilter["id"]][] = $valueFilter;
        }

        foreach($result as $panneauKey => $panneauValue) {
            foreach($panneauValue[$panneauKey] as $key => $value) {
                $res[$panneauKey] = $value;
                $campagne[$panneauKey][$value["campagne_id"]] = array("campagne_id" => $value["campagne_id"], "visuel_id" => $value["visuel_id"]);
            }
            $res[$panneauKey]["campagne"] = $campagne[$panneauKey];
        }
        return $res;
    }

    public function delete_campagne($id) {
        $this->db->where("id", $id);
        return $this->db->delete($this->table);
    }
}