<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Conge_model extends CI_Model {

public function get_all_demandes($user_id = null, $is_validator = false) {
    $this->db->select('c.*, 
                       u.first_name AS demandeur_first_name, 
                       u.last_name AS demandeur_last_name, 
                       v.first_name AS validateur_first_name, 
                       v.last_name AS validateur_last_name')
             ->from('conges c')
             ->join('users u', 'u.id = c.user_id') // INNER JOIN → user_id jamais null
             ->join('users v', 'v.id = c.valide_par', 'left'); // LEFT JOIN → valide_par peut être null

    if (!$is_validator) {
        $this->db->where('c.user_id', $user_id);
    }

    $this->db->order_by('c.date_demande', 'DESC');
    return $this->db->get()->result();
}

 public function get_all_demandes_valider($user_id = null, $is_validator = false) {
    $this->db->select('c.*, 
                       u.first_name AS demandeur_first_name, 
                       u.last_name AS demandeur_last_name, 
                       v.first_name AS validateur_first_name, 
                       v.last_name AS validateur_last_name')
             ->from('conges c')
             ->join('users u', 'u.id = c.user_id')
             ->join('users v', 'v.id = c.valide_par');

    if (!$is_validator && $user_id !== null) {
        $this->db->where('c.user_id', $user_id);
    }

    $this->db->order_by('c.date_demande', 'DESC');
    return $this->db->get()->result();
}
public function get_all_demandes_valider_old($user_id = null, $is_validator = false) {
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
 public function edit_conges($id, $date_debut, $date_fin, $motif, $commentaire_validation, $jours_ouvres) {
    return $this->db->where('id', $id)
                    ->update('conges', [
                        'date_debut' => $date_debut,
                        'date_fin' => $date_fin,
                        'motif' => $motif,
                        'nbr_jour' => $jours_ouvres,
                        'commentaire_validation' => $commentaire_validation
                    ]);
}
public function update_etat($id, $commentaire, $id_validator, $etat)
{
    $result = $this->db->where('id', $id)
                   ->update('conges', [
                       'etat' => $etat,
                       'commentaire_validation' => $commentaire,
                       'valide_par' => $id_validator
                   ]);

if (!$result) {
    log_message('error', 'Erreur de mise à jour : ' . $this->db->error()['message']);
}
}
public function update_etats($id, $commentaire, $etat)
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
public function get_conge_en_cours() {
		$sql = "SELECT * FROM conges WHERE etat = 'en_attente'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}



}
