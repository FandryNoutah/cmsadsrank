<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {

	protected $table3 = "clients";
	protected $table4 = "donnee";
	protected $table5 = "upsell";

	public function get_discussion_note_by_id_users($idusers)
	{
		$sql = "SELECT group_messages_note.*, users.*
				FROM group_messages_note 
				LEFT JOIN users ON users.id = group_messages_note.user_id 
				WHERE group_messages_note.user_id = ?";
		$query = $this->db->query($sql, array($idusers));
		return $query->result(); 

	}	
	public function get_discussion_task_by_id_users($idusers)
	{
		$sql = "SELECT group_messages.*, users.*
				FROM group_messages 
				LEFT JOIN users ON users.id = group_messages.user_id 
				WHERE group_messages.user_id = ?";
		$query = $this->db->query($sql, array($idusers));
		return $query->result(); 

	}
	
	public function get_discussion_gtm_by_id_users($idusers)
	{
		$sql = "SELECT group_messages_gtm.*, users.*
				FROM group_messages_gtm 
				LEFT JOIN users ON users.id = group_messages_gtm.user_id 
				WHERE group_messages_gtm.user_id = ?";
		$query = $this->db->query($sql, array($idusers));
		return $query->result(); 

	}
	public function getClientDataByDonnee() {
		// Sélectionner toutes les colonnes nécessaires, y compris les photos des utilisateurs
		$this->db->select('donnee.*, clients.*, produit.*, 
						   am_user.photo_users AS am_photo_user, 
						   tech_user.photo_users AS tech_photo_user');  // Retirer les commentaires
		
		// Table de base : donnee
		$this->db->from('donnee');
		
		// Jointure entre donnee et clients sur idclients
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		
		// Jointure entre donnee et produit sur idproduit
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		
		// Jointure entre donnee et users pour l'account_manager (utilisateur qui gère le client)
		$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
		
		// Jointure entre donnee et users pour l'initiative (utilisateur responsable de l'initiative)
		$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');
		
		// Récupérer les résultats
		return $this->db->get()->result();
	}
	public function get_task_by_id_users($idusers)
	{
		$sql = "SELECT tasks.*, users.*, clients.*, am_clients.*, assigned_clients.* 
				FROM tasks 
				LEFT JOIN users ON users.id = tasks.assigned_to 
				LEFT JOIN clients ON clients.idclients = tasks.idclients 
				LEFT JOIN clients AS am_clients ON am_clients.idclients = tasks.AM 
				LEFT JOIN clients AS assigned_clients ON assigned_clients.idclients = tasks.assigned_to 
				WHERE tasks.assigned_to = ?";
		$query = $this->db->query($sql, array($idusers));
		return $query->result(); 

	}
	public function get_task_by_id_users_attribuer($idusers)
	{
		$sql = "SELECT tasks.*, users.*, clients.*, am_clients.*, assigned_clients.* 
				FROM tasks 
				LEFT JOIN users ON users.id = tasks.assigned_to 
				LEFT JOIN clients ON clients.idclients = tasks.idclients 
				LEFT JOIN clients AS am_clients ON am_clients.idclients = tasks.AM 
				LEFT JOIN clients AS assigned_clients ON assigned_clients.idclients = tasks.assigned_to 
				WHERE tasks.AM = ?";
		$query = $this->db->query($sql, array($idusers));
		return $query->result(); 

	}
		
}
