<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Visuels_model extends CI_Model {

	protected $table = "hm_visuels";
	protected $table1 = "concurrent";
	protected $table2 = "liste_car";
	protected $table3 = "clients";
	protected $table4 = "donnee";
	protected $visuels_formats_images = "hm_visuels_formats_images";
    protected $_database;
    public $table_fields = array();

	public function get_all() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}


	public function getgroupepmaxidcampagne($id) {
		$sql = "select * from groupe_annonce where idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getCampagneid($id) {
		$sql = "select * from campagne where idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getgpid($id) {
		$sql = "select * from groupe_annonce where idgroupe_annonce = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getCampagneiddetail($id) {
		$sql = "select * from campagne where idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getAllCampagneByIdcontexte($idclients) {
		$sql = "select * from campagne where idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}

	public function getAllCampagneById($idclients) {
		$sql = "select * from campagne where idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getAllgroupeByIdcontexte($idclients) {
		$sql = "SELECT ga.*, c.* 
				FROM groupe_annonce ga 
				JOIN campagne c ON ga.idcampagne = c.idcampagne 
				WHERE ga.idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getAllgroupeById($idclients) {
		$sql = "SELECT ga.*, c.* 
				FROM groupe_annonce ga 
				JOIN campagne c ON ga.idcampagne = c.idcampagne 
				WHERE ga.idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	
	public function update_group($idgroupe_annonce, $data) {
        // Identifier le groupe d'annonces par son ID et mettre à jour les données
        $this->db->where('idgroupe_annonce', $idgroupe_annonce);
        return $this->db->update('groupe_annonce', $data);  // Remplacer 'groupe_annonces' par le nom réel de votre table
    }
	
	
	public function getClientById($id) {
		
		$sql = "select * from clients where idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getDonneeById($id) {
		$sql = "select * from donnee where idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getGroupeAnnonceById($id) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idcampagne = '". $id ."' AND ga.type_campagnes ='1'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getGroupeAnnonceByIdlocals($id) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idcampagne = '". $id ."' AND ga.type_campagnes ='2'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getGroupeAnnonceByIdPmaxs($id) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idcampagne = '". $id ."' AND ga.type_campagnes ='3'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getGroupeAnnonceByIdpmax($id) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idclients = '". $id ."' AND ga.type_campagnes ='3'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	
	public function getGroupeAnnonceByIdclients($idclients) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idclients = '". $idclients ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getGroupe_annonce_localfById($id) {
		// Assurez-vous que l'ID est un nombre entier pour éviter les injections SQL.
		$id = (int) $id; 
	
		// Requête SQL sécurisée avec des paramètres pour éviter les injections SQL.
		$sql = "SELECT * 
				FROM groupe_annonce 
				WHERE idclients = ? 
				AND type_campagnes = '2'";  // Condition sur 'type_campagne'
	
		// Exécution de la requête avec des paramètres
		$query = $this->db->query($sql, array($id));
		
		// Vérification si la requête a été exécutée correctement
		if ($query === false) {
			log_message('error', 'Erreur SQL dans la requête: ' . $this->db->last_query());
			return [];  // Retourne un tableau vide en cas d'erreur
		}
	
		// Récupération des résultats sous forme de tableau
		$retour = $query->result_array();
	
		// Retour des résultats
		return $retour;
	}
	

	public function getGroupe_annonce_pmaxfById($id) {
		// Assurez-vous que l'ID est un nombre entier pour éviter les injections SQL.
		$id = (int) $id; 
	
		// Requête SQL sécurisée avec des paramètres pour éviter les injections SQL.
		$sql = "SELECT * 
				FROM groupe_annonce 
				WHERE idclients = ? 
				AND type_campagnes = '3'";  // Condition sur 'type_campagne'
	
		// Exécution de la requête avec des paramètres
		$query = $this->db->query($sql, array($id));
		
		// Vérification si la requête a été exécutée correctement
		if ($query === false) {
			log_message('error', 'Erreur SQL dans la requête: ' . $this->db->last_query());
			return [];  // Retourne un tableau vide en cas d'erreur
		}
	
		// Récupération des résultats sous forme de tableau
		$retour = $query->result_array();
	
		// Retour des résultats
		return $retour;
	}
	
	
	public function getGroupe_annonce_briefById($id) {
		// Requête SQL sans jointure avec 'campagne'
		$sql = "SELECT ga.*
				FROM groupe_annonce ga
				WHERE ga.idclients = '" . $id . "'
				AND ga.type_campagnes = 1";  // Condition sur 'type_campagne' dans la table 'groupe_annonce'
	
		// Exécution de la requête
		$result = $this->db->query($sql);
	
		// Récupération des résultats sous forme de tableau
		$retour = $result->result_array();
	
		// Fermeture de la connexion à la base de données
		$this->db->close();
	
		// Retour des résultats
		return $retour;
	}
	
	
	
	public function getGroupeAnnonceByIdclient($id) {
		$sql = "select idclients from donnee where idonnee = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	
	public function getCampagneById($id) {
		// Ajout du JOIN pour récupérer le label du type de campagne
		$sql = "SELECT c.*, t.label_type_campagne 
				FROM campagne c
				INNER JOIN type_campagne t ON c.type_campagne = t.idtype_campagne
				WHERE c.idcampagne = '" . $id . "'";
		
		// Exécution de la requête
		$result = $this->db->query($sql);
		
		// Retour des résultats sous forme de tableau associatif
		$retour = $result->result_array();
		
		// Fermeture de la connexion à la base de données
		$this->db->close();
		
		return $retour;  
	}
	public function getCampagneByIdclient($id) {
		// Ajout du JOIN pour récupérer le label du type de campagne
		$sql = "SELECT c.*, t.label_type_campagne 
				FROM campagne c
				INNER JOIN type_campagne t ON c.type_campagne = t.idtype_campagne
				WHERE c.idclients = '" . $id . "'";
		
		// Exécution de la requête
		$result = $this->db->query($sql);
		
		// Retour des résultats sous forme de tableau associatif
		$retour = $result->result_array();
		
		// Fermeture de la connexion à la base de données
		$this->db->close();
		
		return $retour;  
	}
	
	public function get_all_produit() {
		$query = $this->db->get('produit');
		return $query->result(); // Renvoie un tableau d'objets
	}
	public function deletecar($id_Car) {
        $this->db->where('id_Car', $id_Car);
        return $this->db->delete('liste_car');
	}
	public function update_client($idclient,$client,$email_client,$numero_client,$site_client){
		$sql = "update clients set nom_client='".$client."',email_client='".$email_client."',numero_client='".$numero_client."',site_client='".$site_client."' where idclients='".$idclient."'";
		$this->db->query($sql);
		$this->db->close();
	}public function update_donnee_client($budget,$idonnee){
		$sql = "update donnee set budget='".$budget."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_produit_client($product_id,$idonnee){
		$sql = "update donnee set idproduit='".$product_id."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	
	public function update_car($Nom,$Nombre_place,$Prix_jour,$Prestataire,$Nom_chauffeur,$Numero_chauffeur,$Numero_voiture,$Marque,$id_Car){
            $sql = "update liste_car set Nom='".$Nom."',Nombre_place='".$Nombre_place."',Prix_jour='".$Prix_jour."',Prestataire='".$Prestataire."',Nom_chauffeur='".$Nom_chauffeur."',Numero_chauffeur='".$Numero_chauffeur."',Numero_voiture='".$Numero_voiture."',Marque='".$Marque."' where id_Car='".$id_Car."'";
            $this->db->query($sql);
            $this->db->close();
    }
	public function get_all_car() {
        $sql = "select * from liste_car";
		$result = $this->db->query($sql);
        $retour = $result->result_array();
        $this->db->close();
        return $retour;;
	}
	public function getVisuels(){
		$sql = "select * from hm_visuels";
		$result = $this->db->query($sql);
        $retour = $result->result_array();
        $this->db->close();
        return $retour;
		
	}
	public function insertclient($client, $site_client, $email_client, $numero_client) {
        $query = "INSERT INTO clients (nom_client, email_client, numero_client, site_client) VALUES ('$client', '$email_client', '$numero_client', '$site_client')";
        $this->db->query($query);
        $idclient = $this->db->insert_id();
        
        return $idclient; 
    }
	function insert_images_bd($idclients, $Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3,$type_image) {
		// Construction de la requête SQL
		$sql = "UPDATE groupe_annonce SET 
					Image_youtube1 = '".$Images_youtube1."',
					Image_youtube2 = '".$Images_youtube2."',
					Image_gmail = '".$Images_gmail."',
					Image_display1 = '".$Images_display1."',
					Image_display2 = '".$Images_display2."',
					Image_discover1 = '".$Images_discover1."',
					Image_discover2 = '".$Images_discover2."',
					Image_discover3 = '".$Images_discover3."',
					type_image = '".$type_image."'
				WHERE idclients = '".$idclients."' AND type_campagnes = 3";
		
		// Exécution de la requête
		$this->db->query($sql);
		
		// Vérification des lignes affectées (dans le cas d'un UPDATE, il est plus pertinent de vérifier le nombre de lignes affectées)
		$affectedRows = $this->db->affected_rows();
		
		return $affectedRows; // Retourne le nombre de lignes affectées
	}
	function insert_images_bd2($idclients, $Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3,$type_image) {
		// Construction de la requête SQL
		$sql = "UPDATE groupe_annonce SET 
					Image_youtube1 = '".$Images_youtube1."',
					Image_youtube2 = '".$Images_youtube2."',
					Image_gmail = '".$Images_gmail."',
					Image_display1 = '".$Images_display1."',
					Image_display2 = '".$Images_display2."',
					Image_discover1 = '".$Images_discover1."',
					Image_discover2 = '".$Images_discover2."',
					Image_discover3 = '".$Images_discover3."',
					type_image = '".$type_image."'
				WHERE idclients = '".$idclients."' AND type_campagnes = 2";
		
		// Exécution de la requête
		$this->db->query($sql);
		
		// Vérification des lignes affectées (dans le cas d'un UPDATE, il est plus pertinent de vérifier le nombre de lignes affectées)
		$affectedRows = $this->db->affected_rows();
		
		return $affectedRows; // Retourne le nombre de lignes affectées
	}
	
    public function insertfiche($idclient,$budget,$secteur_activite,$product_choice,$initiative,$am,$date_mis_en_place,$date_brief,$date_annonce,$dejaclient) {
        $query = "INSERT INTO donnee (idclients,idproduit,budget,secteur_activite,initiative,account_manager,mis_en_place_paiement,Brief,annonce,modifier_par,dejaclient) VALUES ('$idclient','$product_choice','$budget','$secteur_activite','$initiative','$am','$date_mis_en_place','$date_brief','$date_annonce','$am','$dejaclient')";
        $this->db->query($query);
    }
	public function getClientDataByDonneeold() {

        $this->db->select('clients.idclients, clients.nom_client, clients.email_client, clients.numero_client, clients.site_client');
        $this->db->from('donnee');
        $this->db->join('clients', 'donnee.idclients = clients.idclients');
		$this->db->join('initiative', 'donnee.initiative = initiative.idinitiative');
        return $query->result();  
    }
	public function getClientDataByDonnee() {
		// Sélectionner toutes les colonnes des trois tables
		$this->db->select('*');
		
		// Table de base : donnee
		$this->db->from('donnee');
		
		// Jointure entre donnee et clients sur idclients
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		
		// Jointure entre donnee et produit sur idproduit
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		$this->db->join('initiative', 'donnee.initiative = initiative.idinitiative');
		$this->db->join('am', 'donnee.account_manager = am.idam');
		
		// Récupérer les résultats
		return $this->db->get()->result();
	}
	public function getinformationedit($id) {
		$this->db->select('*');
		$this->db->from('donnee');
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		$this->db->where('donnee.idclients', $id);
		return $this->db->get()->result();
	}	
	public function getclientsedit($id) {
		$this->db->select('*');
		$this->db->from('clients');
		$this->db->where('idclients', $id);
		return $this->db->get()->result();
	}
	public function getinformation() {
		$this->db->select('*');
		$this->db->from('donnee');
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		return $this->db->get()->result();
	}
	public function getclients() {
		$this->db->select('*');
		$this->db->from('clients');
		return $this->db->get()->result();
	}
	
	
	public function insertCar($Nom,$Nombre_place,$Prix_jour,$Prestataire,$Nom_chauffeur,$Numero_chauffeur,$Numero_voiture,$Marque){
		$query="insert into liste_car values('','$Nom','$Nombre_place','$Prix_jour','$Prestataire','$Nom_chauffeur','$Numero_chauffeur','$Numero_voiture','$Marque')";
	$this->db->query($query);
		
	}
	public function insert_Car( $Nom,$Nombre_place,$Prix_jour,$Prestataire,$Nom_chauffeur,$Numero_chauffeur,$Numero_voiture,$Marque){
		$query="insert into liste_car values('','$Nom','$Nombre_place','$Prix_jour','$Prestataire','$Nom_chauffeur','$Numero_chauffeur','$Numero_voiture','$Marque')";
		$this->db->query($query);
	}
	
	public function insert_date_structure($date_validation_structure,$idonnee){
		$sql = "update donnee set date_validation_structure='".$date_validation_structure."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
}
	public function update_visuel($id,$label,$date_visuel,$logo){
            $sql = "update hm_visuels set label='".$label."',date_visuel='".$date_visuel."',logo='".$logo."' where id='".$id."'";
            $this->db->query($sql);
            $this->db->close();
    }
		public function get_axe_id($id_Car) {
	$sql = "select Nom from Liste_Car where id_Car='".$id_Car."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
	public function get_personnelle_by_axes($axes) {
	$sql = "select * from Liste_Personnelle where Ligne='".$axes."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
	
	
	
	
	/*public function get_by_id($id = null) {
		//datadump($id);
        $this->db->where("id", $id);
        $this->db->where("status", 1);
		 $this->db->close();
	    return $this->db->get($this->table)->result();
	}*/
	
	public function get_by_id($id_Car) {
	$sql = "select * from liste_car where id_Car='".$id_Car."'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;
	}
			function Insert_DATA($data)
		 {
		  $this->db->insert_batch('liste_car', $data);
		 }
	
	public function get_all_visuel_formats() {
        $this->db->where("status", 1);
	    return $this->db->get($this->visuels_formats_images)->result_array();
	}
	
	public function save_visuel_formats($data = null) {
		if ($data != null) {
            return $this->db->insert($this->visuels_formats_images, $data);
        }
	}
	
	public function new_visuel($data) {
		//datadump($data);
		//die();
		if ($data != null) {
            return $this->db->insert($data);
        }
	}
	public function save_regisseur($data = null) {
		if ($data != null) {
            return $this->db->insert($this->table, $data);
        }
	}
	
/*	public function update_visuel($id, $data = null) {
		if ($id != null && $data != null) {
            $this->db->where('id', $id);
            return $this->db->update($this->table, $data);
        }
	}*/
	
	public function save_visuel($data = null) {
		if ($data != null) {
            $this->db->insert($this->table, $data);
			$this->db->trans_complete();
			return $this->db->insert_id();
        }
	}
	public function insertconcurrent($data = null){
		if ($data != null) {
            $this->db->insert($this->table1, $data);
			$this->db->trans_complete();
			return $this->db->insert_id();
        }
	}
		
		
	
	public function delete_row($id) {
        //$result = null;
		if($id !='' && $id != null  ){
            $this->db->where('id', $id);
            $this->db->set('status', 0);
            return $this->db->update($this->table);
        }
		return;
	}
}