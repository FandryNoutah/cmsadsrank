<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upsell_model extends CI_Model {

	public function get_upsell_active() {
    $sql = "SELECT 
                u.*, 
                c.*,
                am_user.id AS am_id,
                am_user.first_name AS am_first_name,
                am_user.last_name AS am_last_name,
                am_user.email AS am_email,
                am_user.phone AS am_phone,
                am_user.photo_users AS am_photo,
                tm_user.id AS tm_id,
                tm_user.first_name AS tm_first_name,
                tm_user.last_name AS tm_last_name,
                tm_user.email AS tm_email,
                tm_user.phone AS tm_phone,
                tm_user.photo_users AS tm_photo
            FROM upsell u
            LEFT JOIN clients c ON u.idclients = c.idclients
            LEFT JOIN users am_user ON u.am = am_user.id
            LEFT JOIN users tm_user ON u.tm = tm_user.id
            WHERE u.statut_actif = 1";

    $result = $this->db->query($sql);
    $retour = $result->result_array();
    $this->db->close();
    return $retour;
}
public function get_all_upsell() {
    $sql = "SELECT 
                u.*, 
                c.*,
                am_user.id AS am_id,
                am_user.first_name AS am_first_name,
                am_user.last_name AS am_last_name,
                am_user.email AS am_email,
                am_user.phone AS am_phone,
                am_user.photo_users AS am_photo,
                tm_user.id AS tm_id,
                tm_user.first_name AS tm_first_name,
                tm_user.last_name AS tm_last_name,
                tm_user.email AS tm_email,
                tm_user.phone AS tm_phone,
                tm_user.photo_users AS tm_photo
            FROM upsell u
            LEFT JOIN clients c ON u.idclients = c.idclients
            LEFT JOIN users am_user ON u.am = am_user.id
            LEFT JOIN users tm_user ON u.tm = tm_user.id";

    $result = $this->db->query($sql);
    $retour = $result->result_array();
    $this->db->close();
    return $retour;
}


}
