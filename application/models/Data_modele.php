<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_modele extends CI_Model {

	protected $table = "donnee";
	protected $table2 = "campagne";
	protected $table1 = "produit";

    public function __construct() {
        parent::__construct();
    }

    public function getidclient($id) {
		$sql = "select idclients from donnee where idonnee = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
    public function getclient($idclients) {
		$sql = "select * from clients where idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
    public function getcampagne_client($idclients) {
		$sql = "select * from campagne where idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
    public function getdonnee_client($idclients) {
		$sql = "select * from donnee where idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
    public function getgroupe_client($idclients) {
		$sql = "select * from groupe_annonce where idclients = '". $idclients ."' AND type_campagnes='3'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}

























	public function insert_pmax($idclient, $idcampagne, $nom_campagne, $zone, $calendar, $appareil, $mot_cle, $objectif, $repartition_budget, $titre, $description, $description_bref, $url, $logos, $Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3) {
		// Créer la requête SQL d'insertion
		$sql = "INSERT INTO groupe_annonce(
					idclients, idcampagne, nom_groupe, diffusion, titre, descriptions, objectif, 
					repartition_budget, url_groupe_annonce, mot_cle, logo_client, image_youtube1, 
					image_youtube2, image_gmail, image_display1, image_display2, image_discover1, 
					image_discover2, image_discover3
				) 
				VALUES (
					'$idclient', '$idcampagne', '$nom_campagne', '$calendar', '$titre', '$description', 
					'$objectif', '$repartition_budget', '$url', '$mot_cle', '$logos', '$Images_youtube1', 
					'$Images_youtube2', '$Images_gmail', '$Images_display1', '$Images_display2', 
					'$Images_discover1', '$Images_discover2', '$Images_discover3'
				)";
	
		// Exécuter la requête
		$this->db->query($sql);
	
		// Fermer la connexion à la base de données
		$this->db->close();
	}
	public function insert_campagne_am($idclients,$type_campagne,$nom_campagne,$information_campagne,$zones,
		$repartition_budget,$date_campagne,$appareil,$objectif,$url_site,$Mots_cle_potentiels){
		$sql = "INSERT INTO campagne(idclients,type_campagne, nom_campagne, information_campagne, zones, repartition_budget, date_campagne, appareil, objectif, url_site, Mots_cle_potentiels) 
		VALUES ('$idclients', '$type_campagne', '$nom_campagne', '$information_campagne', '$zones', '$repartition_budget', '$date_campagne', '$appareil', '$objectif', '$url_site', 
		'$Mots_cle_potentiels')";
		$this->db->query($sql);
		$this->db->close();
	}
	public function insert_groupe_search($data) {
        // Insérer les données dans la base de données
        $this->db->insert('groupe_annonce', $data);
    }	
	public function insert_groupe_pmax($data) {
        // Insérer les données dans la base de données
        $this->db->insert('groupe_annonce', $data);
    }	


	public function insert_campagne($data) {
        $this->db->insert('campagne', $data);
        return $this->db->insert_id();
    }

public function insert_campagne_pmax($idclient, $zone, $type_de_campagne, $calendar, $appareil) {
    $sql = "INSERT INTO campagne(idclients, zones, type_campagne, date_campagne, appareil) 
            VALUES ('$idclient', '$zone', '$type_de_campagne', '$calendar', '$appareil')";
    $this->db->query($sql);
    $insert_id = $this->db->insert_id();
    $this->db->close();

    return $insert_id; // Retourner l'ID de l'insertion
}
public function insert_donne_information($idclients,$information_client,$contextes_client) {
	$sql = "update donnee set information_client='".$information_client."',contexte_client='".$contextes_client."' where idclients='".$idclients."'";
	$this->db->query($sql);
	$this->db->close();
}


    // Fonction pour insérer un groupe d'annonce
    public function insert_groupe_annonce($data) {
        // Insérer les données dans la table groupe_annonce
        $this->db->insert('groupe_annonce', $data);
        return $this->db->insert_id();  // Retourne l'ID de la dernière insertion
    }

    // Fonction pour insérer plusieurs groupes d'annonces
    public function insert_multiple_groupe_annonce($data) {
        // Insérer plusieurs groupes d'annonces
        return $this->db->insert_batch('groupe_annonce', $data);  // Utilise insert_batch pour insérer plusieurs lignes
    }
	
	public function save_campagne($idonnee, $decision){
		$sql = "update donnee set campagne_actif='".$decision."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function save_annonce($idgroupe_annonce, $decision){
		// Mettre à jour le statut du groupe d'annonces
		$sql = "UPDATE groupe_annonce SET statut='".$decision."' WHERE idgroupe_annonce='".$idgroupe_annonce."'";
		$this->db->query($sql);
	
		// Récupérer l'idclients après la mise à jour
		$sql = "SELECT idclients FROM groupe_annonce WHERE idgroupe_annonce='".$idgroupe_annonce."'";
		$result = $this->db->query($sql);
		
		// Vérifier si une ligne a été retournée et retourner l'idclients
		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$idclients = $row['idclients'];
		} else {
			// Si aucun résultat, on peut retourner null ou une autre valeur appropriée
			$idclients = null;
		}
		
		// Fermer la connexion
		$this->db->close();
		var_dump($idclients);
		
		// Retourner l'idclients
		return $idclients;
	}
	
	public function save_brouillon($idonnee, $decision){
		$sql = "update donnee set campagne_actif='".$decision."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_dejaclient($decision,$id_donnee){
		$sql = "update donnee set dejaclient='".$decision."' where idonnee='".$id_donnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_client($idclient, $client, $email_client, $numero_client, $site_client, $logo){
		$sql = "update clients set nom_client='".$client."',email_client='".$email_client."',numero_client='".$numero_client."',site_client='".$site_client."',logo_client='".$logo."' where idclients='".$idclient."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_donnee_client($budget,$secteur_activite,$Produit,$Initiative,$Am,$mis_en_place_paiement,$Brief,$annonce,$idonnee){
		$sql = "update donnee set budget='".$budget."',secteur_activite='".$secteur_activite."',idproduit='".$Produit."',initiative='".$Initiative."',account_manager='".$Am."',mis_en_place_paiement='".$mis_en_place_paiement."',Brief='".$Brief."',annonce='".$annonce."',modifier_par='".$Am."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_produit($product_choice,$idonnee){
		$sql = "update donnee set idproduit='".$product_choice."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function getProduitById($idproduit) {
		$sql = "select * from produit where idproduit = '". $idproduit ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}

	
	public function getinitiativeById($idinitiative) {
		$sql = "select * from initiative where idinitiative = '". $idinitiative ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getamById($idam) {
		$sql = "select * from am where idam = '". $idam ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
		public function get_all_produit() {
			$query = $this->db->get('produit');
			return $query->result(); // Renvoie un tableau d'objets
		}
		public function get_all_am() {
			$query = $this->db->get('am');
			return $query->result(); // Renvoie un tableau d'objets
		}
		public function get_all_initiative() {
			$query = $this->db->get('initiative');
			return $query->result(); // Renvoie un tableau d'objets
		}
	
	
}
	