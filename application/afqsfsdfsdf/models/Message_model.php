<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model {

	protected $table = "hm_visuels";
	protected $table1 = "concurrent";
	protected $table2 = "liste_car";
	protected $table3 = "clients";
	protected $table4 = "donnee";
	protected $visuels_formats_images = "hm_visuels_formats_images";
    protected $_database;
    public $table_fields = array();

	public function send_message($sender_id, $receiver_id, $message) {
        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message
        );
        $this->db->insert('messages', $data);
        return $this->db->insert_id();
    }

    public function get_messages($sender_id, $receiver_id) {
        $this->db->where('(sender_id = '.$sender_id.' AND receiver_id = '.$receiver_id.') OR (sender_id = '.$receiver_id.' AND receiver_id = '.$sender_id.')');
        $query = $this->db->get('messages');
        return $query->result();
    }
	public function get_all_users_except_current($current_user_id)
    {
        // Récupérer tous les utilisateurs sauf celui dont l'ID correspond à $current_user_id
        $this->db->select('id, first_name'); // Sélectionne uniquement l'ID et le prénom de l'utilisateur
        $this->db->from('users'); // Table des utilisateurs
        $this->db->where('id !=', $current_user_id); // Exclure l'utilisateur actuel
        $query = $this->db->get();

        // Vérifie si des résultats ont été trouvés
        if ($query->num_rows() > 0) {
            return $query->result(); // Retourne tous les utilisateurs sauf l'utilisateur actuel
        }

        return []; // Si aucun utilisateur n'est trouvé, retourne un tableau vide
    }
	public function get_messages_for_user($user_id)
	{
		// Construire la requête pour récupérer les messages envoyés et reçus par l'utilisateur
		$this->db->select('messages.id, messages.message, messages.sender_id, messages.timestamp, users.first_name as sender_name');
		$this->db->from('messages');
		$this->db->join('users', 'users.id = messages.sender_id');
		$this->db->where('messages.receiver_id', $user_id); // Récupérer les messages reçus
		$this->db->or_where('messages.sender_id', $user_id); // Récupérer les messages envoyés
		$this->db->order_by('messages.timestamp', 'ASC'); // Trier par l'heure d'envoi
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->result(); // Retourne les messages
		} else {
			return []; // Aucun message trouvé
		}
	}
	public function delete_message($message_id) {
    $this->db->where('id', $message_id);
    $this->db->delete('messages');
}

	

}