<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Charger la base de données
    }
    public function get_all_images() {
        $query = $this->db->order_by('rank', 'ASC')->get('images');
        return $query->result();
    }
    public function get_images_by_id($id){
        $query = $this->db->where('idgroupe_annonce', $id)
                          ->order_by('rank', 'ASC')
                          ->get('images');
        return $query->result();
    }
    public function get_images_by_clients($id, $idgroupe_annonce){
        $this->load->database();

        $query = $this->db->select('images.*, groupe_annonce.*') // Sélectionne toutes les colonnes de images et groupe_annonce
                          ->from('images')
                          ->join('groupe_annonce', 'images.idgroupe_annonce = groupe_annonce.idgroupe_annonce', 'inner') // Jointure sur idgroupe_annonce
                          ->where('images.idclients', $id) // Filtrage par client
                          ->where('images.idgroupe_annonce', $idgroupe_annonce) // Filtrage par client
                          ->order_by('images.rank', 'ASC') // Tri par rank dans images
                          ->get();
        return $query->result();
    }
    
    
    
    public function get_idgroupe_annonceimage($id) {
        // Utiliser les requêtes préparées pour éviter les injections SQL
        $sql = "SELECT idgroupe_annonce FROM images WHERE id = ?";
        $query = $this->db->query($sql, array($id));
    
        // Vérifier si la requête retourne un résultat
        if ($query->num_rows() > 0) {
            // Retourner le résultat sous forme de tableau
            return $query->row()->idgroupe_annonce;
        }
    
        return null; // Si aucun résultat n'est trouvé
    }
    public function getgroupe_annonce($id) {
        // Requête SQL avec jointure entre groupe_annonce et clients
        $sql = "
            SELECT ga.*, c.* 
            FROM groupe_annonce ga
            LEFT JOIN clients c ON ga.idclients = c.idclients
            WHERE ga.idgroupe_annonce = ?";
        
        // Exécution de la requête avec paramètre
        $query = $this->db->query($sql, array($id));
    
        // Vérifier si la requête retourne un résultat
        if ($query->num_rows() > 0) {
            return $query->row(); // Retourne la première ligne de résultat
        }
    
        return null; // Si aucun résultat n'est trouvé
    }
    
    public function insertidgroupeimage($idimage, $id){

		$sql = "update images set idgroupe_annonce='".$id."' where id='".$idimage."'";
		$this->db->query($sql);
		$this->db->close();
	}
    public function insertidgroupeimagess($idimage, $idgroupe_annone){

		$sql = "update images set idgroupe_annonce='".$idgroupe_annone."' where id='".$idimage."'";
		$this->db->query($sql);
		$this->db->close();
	}

    public function insert_image($image_url, $idclients,$idgroupe_annone, $rank) {
        $this->load->database();
        //$image_url = $this->db->escape($image_url);
    
        $idclients = (int)$idclients; // S'assurer que $idclients est un entier
        $rank = (int)$rank; // S'assurer que $rank est un entier
    
        // Créer le tableau de données à insérer
        $data = array(
            'image_url' => $image_url,
            'idclients' => $idclients,
            'idgroupe_annonce' => $idgroupe_annone,
            'rank' => $rank
        );
        
       // var_dump($image_url);
        //var_dump($data);
		//die();
        $this->db->insert('images', $data);
        
        // Retourner l'ID de l'image insérée
        return $this->db->insert_id();
    }
    

    // Supprimer une image
    public function delete_image($id) {
        // Récupérer les infos de l'image
        $image = $this->db->get_where('images', ['id' => $id])->row();
    
        if ($image) {
            $filename = $image->filename;
    
            // Vérifie si c'est une URL externe
            if (!filter_var($filename, FILTER_VALIDATE_URL)) {
                // Chemin complet vers le fichier local
                $file_path = FCPATH . 'assets/images/formats/' . $filename;
    
                // DEBUG : Affiche le chemin pour tester
                // echo 'Chemin du fichier : ' . $file_path;
    
                // Vérifie l'existence du fichier et le supprime
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        // echo 'Fichier supprimé avec succès.';
                    } else {
                        // echo 'Erreur lors de la suppression du fichier.';
                        log_message('error', 'Impossible de supprimer le fichier : ' . $file_path);
                    }
                } else {
                    // echo 'Fichier non trouvé.';
                    log_message('error', 'Fichier introuvable : ' . $file_path);
                }
            }
    
            // Supprimer l'entrée dans la base de données
            $this->db->where('id', $id);
            $this->db->delete('images');
    
            // echo 'Entrée supprimée dans la base.';
        } else {
            // echo 'Image non trouvée en base.';
            log_message('error', 'Image avec ID ' . $id . ' non trouvée.');
        }
    }
    
    
    

    // Mettre à jour le rang d'une image
    public function update_rank($id, $rank) {
        $data = array('rank' => $rank);
        $this->db->where('id', $id);
        $this->db->update('images', $data);
    }

    // Récupérer toutes les images
    public function get_images() {
        $query = $this->db->get('images'); // Récupère toutes les images
        return $query->result_array(); // Renvoie les résultats sous forme de tableau
    }

    // Insérer une nouvelle image
    
}
