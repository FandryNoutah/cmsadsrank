<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Discussion_model extends CI_Model
{

	protected $table3 = "clients";
	protected $table4 = "donnee";
	protected $table5 = "upsell";

	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function get_discussion_note_by_id_users($idusers)
	{
		$this->db->select('group_messages_note.*, users.*');
		$this->db->from('group_messages_note');
		$this->db->join('users', 'users.id = group_messages_note.user_id', 'left');
		$this->db->where('group_messages_note.user_id', $idusers);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_discussion_teamtask_by_id_users($idusers)
	{
		$this->db->select('group_messages.*, users.*');
		$this->db->from('group_messages');
		$this->db->join('users', 'users.id = group_messages.user_id', 'left');
		$this->db->join('users', 'users.id = group_messages.user_id', 'right');
		$this->db->where('group_messages.user_id', $idusers);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_discussion_temporaire_by_id_users($idusers)
	{
		$this->db->select('group_messages.*, users.*, tasks.*');
		$this->db->from('group_messages');
		$this->db->join('users', 'users.id = group_messages.user_id', 'left');
		$this->db->join('tasks', 'tasks.idtask = group_messages.task_id', 'right');
		$this->db->where('group_messages.user_id', $idusers);
		$this->db->where('tasks.type_tache', 1);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_discussion_brief_by_id_users($idusers)
	{
		$this->db->select('group_messages.*, users.*');
		$this->db->from('group_messages');
		$this->db->join('users', 'users.id = group_messages.user_id', 'left');
		$this->db->join('users', 'users.id = group_messages.user_id', 'right');
		$this->db->where('group_messages.user_id', $idusers);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_discussion_gtm_by_id_users($idusers)
	{
		$this->db->select('group_messages_gtm.*, users.*');
		$this->db->from('group_messages_gtm');
		$this->db->join('users', 'users.id = group_messages_gtm.user_id', 'left');
		$this->db->where('group_messages_gtm.user_id', $idusers);

		$query = $this->db->get();
		return $query->result();
	}


	public function getClientDataByDonnee()
	{
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
