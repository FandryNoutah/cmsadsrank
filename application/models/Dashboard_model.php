<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	protected $table3 = "clients";
	protected $table4 = "donnee";
	protected $table5 = "upsell";

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
