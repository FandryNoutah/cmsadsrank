<?php 
		if( !defined('BASEPATH')) exit('No direct script access allowed');

		class Mabase extends CI_Model{
		
			public function __construct(){
				parent::__construct();
				$this->load->database();
			}
			
			public function seConnecter($table,$login,$password){
				$sql = "select * from ".$table." where login = ? and mdp = ? ";
				$result = $this->db->query($sql, array($login, $password));
				$retour = $result->row_array();
				$this->db->close();
				return $retour;
			}
			
			public function autho($user_id,$group_id){
			$sql = "select * from groups where user_id =? and group_id = ?" ;
			$result = $this->db->query($sql, array($user_id,$group_id));
			$retour = $result->row_array();
			$this->db->close();
			return $retour;
			}	

	
			public function connectionAdmin($login,$password){
				$sql = "select * from administrateur where login = ? and password = ? ";
				$result = $this->db->query($sql, array($login, $password));
				$retour = $result->row_array();
				$this->db->close();
				return $retour;
			}

			public function connectionUser($login,$password){
				$sql = "select * from utilisateur where login = ? and password = ? ";
				$result = $this->db->query($sql, array($login, $password));
				$retour = $result->row_array();
				$this->db->close();
				return $retour;
			}


			public function getListeUtilisateurs(){
				$sql = "select * from utilisateur";
				$result = $this->db->query($sql);
				$retour = $result->result_array();
				$this->db->close();
				return $retour;
			}
			
			

}