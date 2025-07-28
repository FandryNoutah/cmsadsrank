<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Donne_modele extends CI_Model {

	protected $table = "donnee";
	protected $table2 = "campagne";
	protected $table1 = "produit";

    public function __construct() {
        parent::__construct();
    }
	// Dans le modèle Donne_modele
	public function insert_gp($groupes_annonces, $idcampagne, $idclients, $type_campagne, $contexte_groupes_annonces, $mot_cle, $url_site)
{
    // Vérifie si les groupes d'annonces, les contextes et les mots-clés sont des tableaux non vides
    if (is_array($groupes_annonces) && !empty($groupes_annonces) && is_array($contexte_groupes_annonces) && !empty($contexte_groupes_annonces) && is_array($mot_cle) && !empty($mot_cle)) {
        
        // Charge la base de données
        $this->load->database();
		
        // Vérifie si les trois tableaux ont le même nombre d'éléments
        if (count($groupes_annonces) === count($contexte_groupes_annonces) && count($groupes_annonces) === count($mot_cle)) {
            // Crée un tableau pour les données à insérer
            $insert_data = array();

            // Parcourt les éléments des groupes d'annonces et leurs contextes et mots-clés
            for ($i = 0; $i < count($groupes_annonces); $i++) {
                // Vérifie si le groupe, le contexte et le mot-clé ne sont pas vides
                if (!empty($groupes_annonces[$i]) && !empty($contexte_groupes_annonces[$i]) && !empty($mot_cle[$i])) {
                    // Vérifie si le mot-clé est bien une chaîne
                    if (is_array($mot_cle[$i])) {
                        // Si c'est un tableau, le convertir en une chaîne
                        $mot_cle[$i] = implode(", ", $mot_cle[$i]);
                    }

                    // Ajoute les données dans le tableau d'insertion
                    $insert_data[] = array(
                        'nom_groupe' => isset($groupes_annonces[$i]['groupe_annonce']) ? $groupes_annonces[$i]['groupe_annonce'] : '', // Accède directement à la valeur 'groupe_annonce'
                        'contexte_groupes_annonces' => $contexte_groupes_annonces[$i],
                        'mot_cle' => $mot_cle[$i], // Ajouter le mot-clé
						'url_groupe_annonce' => $url_site,
                        'idclients' => $idclients,
                        'type_campagnes' => $type_campagne,
                        'idcampagne' => $idcampagne
                    );
                }
            }

            // Si le tableau des données à insérer n'est pas vide, insérer les données
            if (!empty($insert_data)) {
                $this->db->insert_batch('groupe_annonce', $insert_data); // Utilise insert_batch pour insérer plusieurs lignes
                return true; // Retourne true en cas de succès
            } else {
                return false; // Retourne false si aucune donnée n'est insérée
            }
        } else {
            // Retourne false si les tableaux ne sont pas de la même taille
            return false;
        }
    }
    
    // Retourne false si les tableaux sont vides ou incorrects
    return false;
}

public function getclientvalidation($id) {
	$sql = "select * from campagne where idclients = '". $id ."' AND publier_techinque = '1'";
	$result = $this->db->query($sql);
	$retour = $result->result_array();
	$this->db->close();
	return $retour;	
}

public function getgroupevalidation($id) {
    // Requête SQL avec JOIN pour inclure la table campagne
    $sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = '". $id ."' 
            AND ga.validation_technique = '1'";

    // Exécution de la requête
    $result = $this->db->query($sql);
    
    // Récupération des résultats sous forme de tableau
    $retour = $result->result_array();
    
    // Fermeture de la connexion à la base de données
    $this->db->close();
    
    // Retour des résultats
    return $retour;
}









	

	public function insert_pmax($idclient, $idcampagne, $nom_campagne, $zone, $calendar, $appareil, $mot_cle, $objectif, $repartition_budget, $titre, $description, $description_bref, $url, $logos, $favicon,$Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3) {
		// Créer la requête SQL d'insertion
		$sql = "INSERT INTO groupe_annonce(
					idclients, idcampagne, nom_groupe, diffusion, titre, descriptions, objectif, 
					repartition_budget, url_groupe_annonce, mot_cle, logo_client,favicon, image_youtube1, 
					image_youtube2, image_gmail, image_display1, image_display2, image_discover1, 
					image_discover2, image_discover3
				) 
				VALUES (
					'$idclient', '$idcampagne', '$nom_campagne', '$calendar', '$titre', '$description', 
					'$objectif', '$repartition_budget', '$url', '$mot_cle', '$logos', '$favicon', '$Images_youtube1', 
					'$Images_youtube2', '$Images_gmail', '$Images_display1', '$Images_display2', 
					'$Images_discover1', '$Images_discover2', '$Images_discover3'
				)";
	
		// Exécuter la requête
		$this->db->query($sql);
	
		// Fermer la connexion à la base de données
		$this->db->close();
	}
	public function insert_pmax_groupe($idclients,$idcampagne,$type_campagne, $nom_groupe, $logos,$favicon, $Images_youtube1,
	$Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, 
	$Images_discover2, $Images_discover3){
		// Créer la requête SQL d'insertion
		$sql = "INSERT INTO groupe_annonce(
					idclients, idcampagne, nom_groupe,type_campagnes,logo_client,favicon, image_youtube1, 
					image_youtube2, image_gmail, image_display1, image_display2, image_discover1, 
					image_discover2, image_discover3
				) 
				VALUES (
					'$idclients', '$idcampagne', '$nom_groupe', '$type_campagne','$logos', '$favicon', '$Images_youtube1', 
					'$Images_youtube2', '$Images_gmail', '$Images_display1', '$Images_display2', 
					'$Images_discover1', '$Images_discover2', '$Images_discover3'
				)";
	
		// Exécuter la requête
		$this->db->query($sql);
	
		// Fermer la connexion à la base de données
		$this->db->close();
	}
	public function insert_campagne_am($idclients, $type_campagne, $nom_campagne, $information_campagne, $zones,
        $repartition_budget, $date_campagne, $appareil, $objectif, $url_site) {
    
    // Echappement des valeurs pour éviter les erreurs SQL
    // Ici, pas besoin de refaire l'échappement si vous le faites déjà dans la requête
    $idclients = $this->db->escape($idclients);
    $type_campagne = $this->db->escape($type_campagne);
    $nom_campagne = $this->db->escape($nom_campagne);
    $information_campagne = $this->db->escape($information_campagne);
    $zones = $this->db->escape($zones);
    $repartition_budget = $this->db->escape($repartition_budget);
    $date_campagne = $this->db->escape($date_campagne);
    $appareil = $this->db->escape($appareil);
    $objectif = $this->db->escape($objectif);
    $url_site = $this->db->escape($url_site);

    // Construction de la requête SQL pour insérer une nouvelle campagne
    $sql = "INSERT INTO campagne(idclients, type_campagne, nom_campagne, information_campagne, zones, repartition_budget, date_campagne, appareil, objectif, url_site) 
    VALUES ($idclients, $type_campagne, $nom_campagne, $information_campagne, $zones, $repartition_budget, $date_campagne, $appareil, $objectif, $url_site)";

    // Exécution de la requête
    $this->db->query($sql);

    // Récupération de l'ID de la campagne nouvellement insérée
    $idcampagne = $this->db->insert_id();

    // Fermeture de la connexion
    $this->db->close();

    // Retourner l'ID de la campagne insérée
    return $idcampagne;
}

	public function insert_groupe_search($data) {
        // Insérer les données dans la base de données
        $this->db->insert('groupe_annonce', $data);
    }	

	public function update_groupe_search($idgroupe_annonce, $data) {
		// Mise à jour des données dans la table des groupes d'annonces en fonction de l'ID
		$this->db->where('idgroupe_annonce', $idgroupe_annonce);
		return $this->db->update('groupe_annonce', $data);
	}
	
	public function insert_campagne($data) {
        $this->db->insert('campagne', $data);
        return $this->db->insert_id();
    }
	public function insert_gppmax($idclients,$nom_groupe_pmax, $type_campagne,$url_site,$Mots_cle_potentiels, $idcampagne,$contextes_client){



		$sql = "INSERT INTO groupe_annonce(idclients,nom_groupe,type_campagnes,url_groupe_annonce,mot_cle, idcampagne,contexte_groupes_annonces) 
				VALUES ('$idclients','$nom_groupe_pmax','$type_campagne','$url_site','$Mots_cle_potentiels','$idcampagne','$contextes_client')";
		$this->db->query($sql);
		$this->db->close();
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
	public function insert_groupe_pmax($data) {
        // Insérer les données dans la base de données
        $this->db->insert('groupe_annonce', $data);
    }	
	public function update_groupe_pmax($data, $idgroupe_annonce) {
		// Mettre à jour les données dans la base de données en fonction de l'idgroupe_annonce
		$this->db->where('idgroupe_annonce', $idgroupe_annonce); // Condition sur l'ID
		$this->db->update('groupe_annonce', $data); // Mise à jour de la table
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
	public function bouillon_campagnes($idcampagne, $decision) {
		// Met à jour l'état de la campagne
		$sql = "UPDATE campagne SET actif = '".$decision."' WHERE idcampagne = '".$idcampagne."'";
		$this->db->query($sql);
		
		// Récupère les ID des clients associés à cette campagne
		$this->db->select('idclients');
		$this->db->from('campagne');
		$this->db->where('idcampagne', $idcampagne);
		$query = $this->db->get();
		
		// Si des clients sont trouvés, retourne leurs IDs
		$idclients = [];
		foreach ($query->result_array() as $row) {
			$idclients[] = $row['idclients'];
		}
	
		// Retourne les IDs des clients
		return $idclients;
	}
	public function save_campagnes($idcampagne, $decision) {
		// Met à jour l'état de la campagne
		$sql = "UPDATE campagne SET actif = '".$decision."',publier_techinque='".$decision."' WHERE idcampagne = '".$idcampagne."'";
		$this->db->query($sql);
		
		// Récupère les ID des clients associés à cette campagne
		$this->db->select('idclients');
		$this->db->from('campagne');
		$this->db->where('idcampagne', $idcampagne);
		$query = $this->db->get();
		
		// Si des clients sont trouvés, retourne leurs IDs
		$idclients = [];
		foreach ($query->result_array() as $row) {
			$idclients[] = $row['idclients'];
		}
	
		// Retourne les IDs des clients
		return $idclients;
	}
	public function save_annonces($idcampagne, $decision) {
		// Met à jour l'état de la campagne
		$sql = "UPDATE groupe_annonce SET validation_technique = '".$decision."' WHERE idcampagne = '".$idcampagne."'";
		$this->db->query($sql);
		
		// Récupère les ID des clients associés à cette campagne
		$this->db->select('idclients');
		$this->db->from('campagne');
		$this->db->where('idcampagne', $idcampagne);
		$query = $this->db->get();
		
		// Si des clients sont trouvés, retourne leurs IDs
		$idclients = [];
		foreach ($query->result_array() as $row) {
			$idclients[] = $row['idclients'];
		}
	
		// Retourne les IDs des clients
		return $idclients;
	}
	public function save_annonces_donnee($idclients, $structure) {
		// Met à jour l'état de la campagne
		$sql = "UPDATE donnee SET validation_technique = '".$structure."' WHERE idclients = '".$idclients."'";
		$this->db->query($sql);
		
	}
	
	
	
	public function insert_structure($idonnee, $structure){
		$sql = "update donnee set Validation_structure='".$structure."' where idonnee='".$idonnee."'";
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
	public function updatelogo($idclients,$logo){
		$sql = "update clients set logo_client='".$logo."' where idclients='".$idclients."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function updateinformation($idonnee, $secteur_activite, $information_client, $contexte_client,$tracking_gtm,$commentaire,$information_complementaire){
		// Échapper les variables avant d'utiliser dans la requête SQL
		$secteur_activite = $this->db->escape($secteur_activite);
		$information_client = $this->db->escape($information_client);
		$contexte_client = $this->db->escape($contexte_client);
		$tracking_gtm = $this->db->escape($tracking_gtm);
		$commentaire = $this->db->escape($commentaire);
		$information_complementaire = $this->db->escape($information_complementaire);
	
		// Requête pour mettre à jour les informations
		$sql = "UPDATE donnee SET secteur_activite=".$secteur_activite.", information_client=".$information_client.", contexte_client=".$contexte_client.", tracking_gtm=".$tracking_gtm.", commentaire=".$commentaire.", information_complementaire=".$information_complementaire." WHERE idonnee=".$idonnee;
	
		// Exécution de la requête
		$this->db->query($sql);
	
		// Récupérer l'idclients après la mise à jour
		$sql = "SELECT idclients FROM donnee WHERE idonnee=".$idonnee;
		$result = $this->db->query($sql);
	
		// Supposons qu'il y ait un seul résultat
		$row = $result->row_array(); // Utilisation de row_array() pour obtenir un tableau associatif
		$idclients = $row['idclients'];
	
		// Fermeture de la connexion
		$this->db->close();
	
		// Retourner l'idclients
		return $idclients;
	}
	
	
	

	public function update_client($idclient, $client, $email_client, $numero_client, $site_client){
		$sql = "update clients set nom_client='".$client."',email_client='".$email_client."',numero_client='".$numero_client."',site_client='".$site_client."' where idclients='".$idclient."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_donnee_client($budget,$secteur_activite,$Produit,$Initiative,$Am,$mis_en_place_paiement,$Brief,$annonce,$commentaire_client,$idonnee){
		//$commentaire_client = $this->db->escape($commentaire_client);
		$sql = "update donnee set budget='".$budget."',secteur_activite='".$secteur_activite."',idproduit='".$Produit."',initiative='".$Initiative."',account_manager='".$Am."',mis_en_place_paiement='".$mis_en_place_paiement."',Brief='".$Brief."',annonce='".$annonce."',modifier_par='".$Am."',commentaire_client='".$commentaire_client."' where idonnee='".$idonnee."'";
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
	