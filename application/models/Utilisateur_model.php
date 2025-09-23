<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utilisateur_model extends CI_Model {



    public function get_users_by_id($id) {
        $sql = "select * from users where id='".$id."'";
        $result = $this->db->query($sql);
        $retour = $result->result_array();
        $this->db->close();
        return $retour;
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
