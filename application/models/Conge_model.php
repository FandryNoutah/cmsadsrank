<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Conge_model extends CI_Model {

    public function get_all_demandes($user_id = null, $is_validator = false) {
    $this->db->select('c.*, u.first_name, u.last_name')
             ->from('conges c')
             ->join('users u', 'u.id = c.user_id');

    if (!$is_validator) {
        $this->db->where('c.user_id', $user_id);
    }

    $this->db->order_by('c.date_demande', 'DESC');
    return $this->db->get()->result();
}
public function get_all_demandes_valider($user_id = null, $is_validator = false) {
    $this->db->select('c.*, u.first_name, u.last_name')
             ->from('conges c')
             ->join('users u', 'u.id = c.user_id');
    if (!$is_validator && $user_id !== null) {
        $this->db->where('c.user_id', $user_id);
    }

    $this->db->where('c.etat', 'valide');

    $this->db->order_by('c.date_demande', 'DESC');

    return $this->db->get()->result();
}



    public function add_demande($data) {
        return $this->db->insert('conges', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('conges', ['id' => $id])->row();
    }

   public function update_statut($id, $etat, $valide_par, $commentaire = null) {
    return $this->db->where('id', $id)
                    ->update('conges', [
                        'etat' => $etat,
                        'valide_par' => $valide_par,
                        'date_validation' => date('Y-m-d H:i:s'),
                        'commentaire_validation' => $commentaire
                    ]);
}
public function update_etat($id, $commentaire, $etat)
{
    $result = $this->db->where('id', $id)
                   ->update('conges', [
                       'etat' => $etat,
                       'commentaire_validation' => $commentaire
                   ]);

if (!$result) {
    log_message('error', 'Erreur de mise à jour : ' . $this->db->error()['message']);
}

}


public function get_conge_by_id($id)
{
    $this->db->select('c.*, u.first_name AS prenom, u.last_name AS nom, u.couleur AS couleur');
    $this->db->from('conges c');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where('c.id', $id);
    $query = $this->db->get();
    return $query->row();
}



}
