<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Concurrent extends CI_Model {

	protected $table = "concurrent";
	protected $table1 = "listeconcurrent";

    public function __construct() {
        parent::__construct();
    }
	
	 public function get_liste_personnelle(){
            $sql = "select * from liste_personnelle";
            $result = $this->db->query($sql);
            $retour = $result->result_array();
            $this->db->close();
            return $retour;
    }
	
	public function get_liste_personnelle_doublon(){
            $sql = "SELECT * FROM liste_personnelle GROUP BY Nom, Matricule HAVING COUNT(*) > 1";
            $result = $this->db->query($sql);
            $retour = $result->result_array();
            $this->db->close();
            return $retour;
    }
	public function update_personnelle($Nom,$Prenom,$Matricule,$Societe,$Direction,$Ramassage_remisage,$Contact,$Lieu_de_travail,$OBS,$Adresse_exacte,$id_personnelle){
            $sql = "update liste_personnelle set Nom='".$Nom."',Prenom='".$Prenom."',Matricule='".$Matricule."',Societe='".$Societe."',Ramassage_remisage='".$Ramassage_remisage."',Contact='".$Contact."',Lieu_de_travail='".$Lieu_de_travail."',OBS='".$OBS."',Adresse_exacte='".$Adresse_exacte."' where id_personnelle='".$id_personnelle."'";
            $this->db->query($sql);
            $this->db->close();
    }
	
	function Insert_DATA($data)
 {
  $this->db->insert_batch('liste_personnelle', $data);
 }public function deletePersonnelle($id_personnelle) {
        $this->db->where('id_personnelle', $id_personnelle);
        return $this->db->delete('liste_personnelle');
	}
	public function get_allC() {
        //$this->db->where("status", 1);
	    return $this->db->get($this->table1)->result();
	}
	
	public function insertpersonnelle($Nom,$Prenom,$Matricule,$Societe,$Direction,$Ligne,$Ramassage_remisage,$Adresse_exacte,$Contact,$Lieu_de_travail,$OBS){
		$query="insert into liste_personnelle values('','$Nom','$Prenom','$Matricule','$Societe','$Direction','$Ligne','$Ramassage_remisage','$Adresse_exacte','$Contact','$Lieu_de_travail','$OBS')";
		$this->db->query($query);
		
	}
	
	public function count_Personnelle($Nom_Car) {
			$sql = "select * from liste_personnelle where Ligne='".$Nom_Car."'";
            $result = $this->db->query($sql);
            $retour = $result->result_array();
            $this->db->close();
            return $retour;
	}
	public function get_ligne_car_by_id($Nom_Car) {
			$sql = "select * from Liste_Car where Nom='".$Nom_Car."'";
            $result = $this->db->query($sql);
            $retour = $result->result_array();
            $this->db->close();
            return $retour;
	}
	public function transfer($Nom_Car,$id_personnelle){	
            $sql = "update liste_personnelle set Ligne='".$Nom_Car."' where id_personnelle='".$id_personnelle."'";
            $this->db->query($sql);
            $this->db->close();
    }
	
	public function desabonner($id_personnelle){
            $sql = "update liste_personnelle set Ligne='Pas de Ligne' where id_personnelle='".$id_personnelle."'";
            $this->db->query($sql);
            $this->db->close();
    }
	public function get_personnelle_by_id($id_personnelle) {
	$sql = "select * from liste_personnelle where id_personnelle='".$id_personnelle."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
	public function get_by_id($id) {
	$sql = "select * from concurrent where id='".$id."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
	
	public function get_all() {
        //$this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	
	
	 public function getListeConcurrent(){
            $sql = "select * from listeconcurrent";
            $result = $this->db->query($sql);
            $retour = $result->result_array();
            $this->db->close();
            return $retour;
    }
	
	public function insererConcurrent($categorie,$remarque,$image1,$image2,$image3,$image4,$idvisuels){
            $sql = "insert into concurrent(nomconcurrent,remarque,image1,image2,image3,image4,idvisuels) values('".$categorie."','".$remarque."','".$image1."','".$image2."','".$image3."','".$image4."','".$idvisuels."')";
            datadump($sql);
			datadump($this->db->query($sql));
			exit();
			$this->db->query($sql);
            $this->db->close();
        }
	

	public function save_concurrent($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}

	public function update_concurrent($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
    }

    public function delete_concurrent($idconcurrent) {
    	$this->db->where("idconcurrent", $idconcurrent);
    	return $this->db->delete($this->table);
    }

    public function get_concurrent_by_id($id) {
        //$this->db->where("id", $id);
        //$this->db->where("status", 1);
        return $this->db->get_where($this->table)->row();
    }
	/*public function get_concurrent_by_idvisuels($id) {
        $this->db->where("idvisuels", $id);
        //$this->db->where("status", 1);
        return $this->db->get_where($this->table)->row();
    }*/
	public function get_concurrent_by_idvisuels($idvisuels){
	$sql = "select * from concurrent where idvisuels='".$idvisuels."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
	public function get_car_by_id($id_Car){
	$sql = "select * from liste_car where id_Car='".$id_Car."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
	
}