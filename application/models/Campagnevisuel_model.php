<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Campagnevisuel_model extends CI_Model {

	protected $table = "hm_campagne_visuel";
	
	public function save_campagne_visuel($data = null) {
		
		if ($data != null) {
			/*if($this->cv_exists($data['panneau_id'], $data['campagne_id'])){
				return true;
			}else{*/
				return $this->db->insert($this->table, $data);
			//}
        }
	}
	
	
	
	public function cv_exists($panneau_id, $campagne_id)
	{	
		$this->db->where('panneau_id', $panneau_id);
		$this->db->where('campagne_id', $campagne_id);

		$query = $this->db->get($this->table);
		
		//echo "<pre>";
		//print_r($query->result_id->num_rows);
		//print_r($query->row());
		//echo "</pre>";
		//exit();
		
		if($query->result_id->num_rows >= 1)
		{
			return true; 	//Enregistrement existant
		}else{
			return false;	//Ajout campagne
		}
	}
	
	
}