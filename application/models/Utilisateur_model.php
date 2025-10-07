<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Utilisateur_model extends CI_Model
{
	public function get_user_by_id($id)
	{
		$query = $this->db->get_where('users', ['id' => (int)$id]);
		return $query->row(); // returns a single user object
	}

	public function edit_user($data, $id)
	{
		$this->db->where("id", $id)->update("users", $data);
		return true;
	}

	public function change_color($couleur, $id)
	{
		$data = [
			'color' => $couleur
		];

		$this->db->where('created_by', $id);
		$this->db->update('events', $data);

		return true;
	}
}
