<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Donne_modele extends CI_Model
{

	protected $table = "donnee";
	protected $table2 = "campagne";
	protected $table1 = "produit";

	public function __construct()
	{
		parent::__construct();
	}
	public function update_status_onboarding($idonboarding, $statut_upsell)
	{
		$sql = "UPDATE onboarding SET statut_upsell = $statut_upsell WHERE idonboarding = $idonboarding";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_budger_donnee($idclients, $budget)
	{
		$sql = "UPDATE donnee SET budget = $budget WHERE idclients = $idclients";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_budger_upsell($idupsell, $budget)
	{
		$sql = "UPDATE upsell SET budgets = $budget WHERE idupsell = $idupsell";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_budger_onboarding($idclient, $budget)
	{
		$sql = "UPDATE onboarding SET budget = $budget WHERE idclients = $idclient";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_information_resiliation(
		$idonnee,
		$information_resiliation,
		$demande_resiliation,
		$statut_resiliation
	) {
		// Préparer les données à mettre à jour
		$data = array(
			'information_resiliation' => $information_resiliation,
			'demande_resiliation' => $demande_resiliation,
			'statut_resiliation' => $statut_resiliation
		);

		// Effectuer la mise à jour de la table (par exemple, table "compte")
		$this->db->where('idonnee', $idonnee); // Utiliser 'idonnee' comme clé primaire
		return $this->db->update('donnee', $data); // Remplacez 'compte' par le nom de votre table
	}

	public function update_information_upsell($idonnee, $inforamtion_upsell, $budget_upsell, $statut_upsell)
	{
		// Préparer les données à mettre à jour
		$data = array(
			'inforamtion_upsell' => $inforamtion_upsell,
			'budget_upsell' => $budget_upsell,
			'statut_upsell' => $statut_upsell
		);

		// Effectuer la mise à jour de la table (par exemple, table "compte")
		$this->db->where('idonnee', $idonnee); // Utiliser 'idonnee' comme clé primaire
		return $this->db->update('donnee', $data); // Remplacez 'compte' par le nom de votre table
	}

	public function update_etat_upsell($id, $etat)
	{
		return $this->db->where('idupsell', $id)
			->update('upsell', ['etat' => $etat]);
	}

	public function update_etat_am($id, $etat_am)
	{
		return $this->db->where('idupsell', $id)
			->update('upsells', ['etat_am' => $etat_am]);
	}

	public function update_information_rapport($idonnee, $rapport, $rapportConversions, $rapportConvCa, $bilan, $remarque, $resiliation, $statut_resiliation)
	{
		// Préparer les données à mettre à jour
		$data = array(
			'rapport' => $rapport,
			'rapport_conversions' => $rapportConversions,
			'rapport_conv_ca' => $rapportConvCa,
			'bilan' => $bilan,
			'remarque' => $remarque,
			'resiliation' => $resiliation,
			'statut_resiliation' => $statut_resiliation
		);

		// Effectuer la mise à jour de la table (par exemple, table "compte")
		$this->db->where('idonnee', $idonnee); // Utiliser 'idonnee' comme clé primaire
		return $this->db->update('donnee', $data); // Remplacez 'compte' par le nom de votre table
	}

	public function update_information_upsells($idupsell, $information_upsell)
	{
		// Préparer les données à mettre à jour
		$data = array(
			'information' => $information_upsell
		);

		// Effectuer la mise à jour dans la base de données
		$this->db->where('idupsell', $idupsell);
		$result = $this->db->update('upsell', $data);

		return $result; // Retourner le résultat de la mise à jour
	}

	// Exemple de méthode dans Donne_modele
	public function update_information_ams($idupsell, $information_am)
	{
		$data = [
			'information_am' => $information_am
		];

		// Effectuer la mise à jour dans la base de données
		$this->db->where('idupsell', $idupsell);
		$this->db->update('upsell', $data);

		// Retourner true si la mise à jour a réussi, sinon false
		return $this->db->affected_rows() > 0;
	}


	public function updateEtat($idplandetaggage, $etat)
	{
		// Vérifiez si l'état est "NULL" et ajustez-le en conséquence
		if ($etat === 'NULL') {
			$etat = NULL;
		}

		// Données à mettre à jour
		$data = array(
			'etat' => $etat
		);

		// Mise à jour dans la base de données
		$this->db->where('idplan_de_taggage', $idplandetaggage);
		return $this->db->update('plan_de_taggage', $data);
	}

	// Fonction pour mettre à jour les données
	public function updateData($data)
	{
		$this->db->where('idplan_de_taggage', $data['rowId']);
		$this->db->update('plan_de_taggage', $data); // Remplacez 'plan_de_taggage' par le nom de votre table
		return $this->db->affected_rows() > 0; // Retourne true si la mise à jour est réussie
	}


	public function update_conversion($id, $data)
	{
		$this->db->where('idplan_de_taggage', $id);
		return $this->db->update('plan_de_taggage', $data); // Mettre à jour la base
	}


	// Fonction pour insérer les conversions avec une requête sécurisée
	public function insert_conversions($conversions)
	{
		$this->load->database();
		if (is_array($conversions) && count($conversions) > 0) {
			// Préparer les données pour l'insertion
			$data = [];
			foreach ($conversions as $conversion) {
				$data[] = [
					'idclients' => $conversion['idclients'],
					'conversion' => $conversion['conversion'],
					'actions' => $conversion['actions'],
					'types' => $conversion['types'],
					'remarque' => $conversion['remarque'],
					'etat' => $conversion['etat'],
					'conditions' => $conversion['conditions'],
					'conversion_id' => $conversion['conversion_id'],
					'conversion_label' => $conversion['conversion_label'],
					'extensions_appel' => $conversion['extensions_appel']
				];
			}

			// Insérer toutes les conversions dans la base de données
			$this->db->insert_batch('plan_de_taggage', $data);
		}
	}




	public function update_type_clients($choix, $idclients)
	{
		$sql = "update groupe_annonce set type_plan_taggage='" . $choix . "' where idclients='" . $idclients . "' AND type_campagnes = 3";
		$this->db->query($sql);
		$this->db->close();
	}
	// Dans le modèle Donne_modele
	public function insert_gp($groupes_annonces, $idcampagne, $idclients, $type_campagne)
	{
		if (is_array($groupes_annonces) && !empty($groupes_annonces)) {
			$this->load->database();
			$insert_data = array();

			foreach ($groupes_annonces as $groupe) {
				if (!empty($groupe['groupe_annonce']) && !empty($groupe['mot_cle'])) {
					// Nettoyage des mots-clés (si tableau)
					$mots = is_array($groupe['mot_cle']) ? implode(', ', $groupe['mot_cle']) : $groupe['mot_cle'];

					$insert_data[] = array(
						'nom_groupe' => $groupe['groupe_annonce'],
						'contexte_groupes_annonces' => $groupe['contexte_groupe_annonce'],
						'mot_cle' => $mots,
						'url_groupe_annonce' => $groupe['url_groupe_annonce'],
						'idclients' => $idclients,
						'type_campagnes' => $type_campagne,
						'idcampagne' => $idcampagne
					);
				}
			}

			if (!empty($insert_data)) {
				$this->db->insert_batch('groupe_annonce', $insert_data);
				return true;
			}
		}

		return false;
	}

	public function get_gp_by_idcampagne($idcampagne)
	{
		$this->load->database();

		$this->db->select('*');
		$this->db->from('groupe_annonce');
		$this->db->where('idcampagne', $idcampagne);
		$this->db->order_by('idgroupe_annonce', 'ASC'); // optional: to keep a stable order

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array(); // or ->result() if you prefer objects
		}

		return [];
	}

	public function getpmaxnonvalider($id)
	{
		$sql = "select * from groupe_annonce where idclients = $id AND type_campagnes = 3";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getcclientvalidation()
	{
		$sql = "select * from campagne";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getcclientvalidationbyidclients($idclients)
	{
		$sql = "select * from campagne where idclients = '" . $idclients . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getidclients($id)
	{
		$sql = "select idclients from campagne where idcampagne = '" . $id . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}


	public function getidclientsbypladetaggage($id)
	{
		$sql = "select idclients from plan_de_taggage where idplan_de_taggage = '" . $id . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getidclientsg($id)
	{
		$sql = "select idclients from groupe_annonce where idgroupe_annonce = '" . $id . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getclientvalidation($id)
	{
		$sql = "select * from campagne where idclients = '" . $id . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getclientvalidations($id)
	{
		$sql = "select * from campagne where idclients = '" . $id . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function deletecampagne($id)
	{
		// Préparez la requête DELETE
		$sql = "DELETE FROM campagne WHERE idcampagne = '" . $id . "'";

		// Exécutez la requête
		$this->db->query($sql);

		// Vérifiez si l'opération a réussi (facultatif)
		if ($this->db->affected_rows() > 0) {
			return true;  // Suppression réussie
		} else {
			return false; // Aucun enregistrement supprimé
		}

		// Fermez la connexion
		$this->db->close();
	}

	public function deleteplandetaggage($id)
	{
		// Préparez la requête DELETE
		$sql = "DELETE FROM plan_de_taggage WHERE idplan_de_taggage = '" . $id . "'";

		// Exécutez la requête
		$this->db->query($sql);

		// Vérifiez si l'opération a réussi (facultatif)
		if ($this->db->affected_rows() > 0) {
			return true;  // Suppression réussie
		} else {
			return false; // Aucun enregistrement supprimé
		}

		// Fermez la connexion
		$this->db->close();
	}

	public function deleteextensions($id)
	{
		// Préparez la requête DELETE
		$sql = "DELETE FROM extensions WHERE idextensions = '" . $id . "'";

		// Exécutez la requête
		$this->db->query($sql);

		// Vérifiez si l'opération a réussi (facultatif)
		if ($this->db->affected_rows() > 0) {
			return true;  // Suppression réussie
		} else {
			return false; // Aucun enregistrement supprimé
		}

		// Fermez la connexion
		$this->db->close();
	}

	public function deletegroupe($id)
	{
		// Préparez la requête DELETE
		$sql = "DELETE FROM groupe_annonce WHERE idgroupe_annonce = '" . $id . "'";

		// Exécutez la requête
		$this->db->query($sql);

		// Vérifiez si l'opération a réussi (facultatif)
		if ($this->db->affected_rows() > 0) {
			return true;  // Suppression réussie
		} else {
			return false; // Aucun enregistrement supprimé
		}

		// Fermez la connexion
		$this->db->close();
	}

	public function deletegroupecampagne($id)
	{
		// Préparez la requête DELETE
		$sql = "DELETE FROM groupe_annonce WHERE idcampagne = '" . $id . "'";

		// Exécutez la requête
		$this->db->query($sql);

		// Vérifiez si l'opération a réussi (facultatif)
		if ($this->db->affected_rows() > 0) {
			return true;  // Suppression réussie
		} else {
			return false; // Aucun enregistrement supprimé
		}

		// Fermez la connexion
		$this->db->close();
	}

	public function deleteimage($id)
	{
		// Préparez la requête DELETE
		$sql = "DELETE FROM groupe_annonce WHERE idcampagne = '" . $id . "'";

		// Exécutez la requête
		$this->db->query($sql);

		// Vérifiez si l'opération a réussi (facultatif)
		if ($this->db->affected_rows() > 0) {
			return true;  // Suppression réussie
		} else {
			return false; // Aucun enregistrement supprimé
		}

		// Fermez la connexion
		$this->db->close();
	}

	public function getgroupevalidation($id)
	{
		// Requête SQL avec JOIN pour inclure la table campagne
		$sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = '" . $id . "' 
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

	public function getgroupevalidations($id)
	{
		// Requête SQL avec JOIN pour inclure la table campagne
		$sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = '" . $id . "' ";

		// Exécution de la requête
		$result = $this->db->query($sql);

		// Récupération des résultats sous forme de tableau
		$retour = $result->result_array();

		// Fermeture de la connexion à la base de données
		$this->db->close();

		// Retour des résultats
		return $retour;
	}

	public function getpmaxvalider($id)
	{
		// Requête SQL avec JOIN pour inclure la table campagne
		$sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = '" . $id . "' 
            AND ga.validation_technique = '1' AND type_campagne = '3'";

		// Exécution de la requête
		$result = $this->db->query($sql);

		// Récupération des résultats sous forme de tableau
		$retour = $result->result_array();

		// Fermeture de la connexion à la base de données
		$this->db->close();

		// Retour des résultats
		return $retour;
	}

	public function getlocalxvalider($id)
	{
		// Requête SQL avec JOIN pour inclure la table campagne
		$sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = '" . $id . "' 
            AND ga.validation_technique = '1' AND type_campagne = '2'";

		// Exécution de la requête
		$result = $this->db->query($sql);

		// Récupération des résultats sous forme de tableau
		$retour = $result->result_array();

		// Fermeture de la connexion à la base de données
		$this->db->close();

		// Retour des résultats
		return $retour;
	}

	public function getcampagnegroupevalidationbyidclients($idclients)
	{
		// Assurez-vous que l'ID client est un nombre entier pour éviter les injections
		$idclients = (int)$idclients;

		// Requête SQL sécurisée avec des paramètres liés pour éviter l'injection SQL
		$sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = ?";

		// Exécution de la requête avec un paramètre lié
		$query = $this->db->query($sql, array($idclients));

		// Récupération des résultats sous forme de tableau
		$retour = $query->result_array();

		// Retourner les résultats
		return $retour;
	}

	public function getcampagnegroupevalidationbyidclient($idclients)
	{
		// Assurez-vous que l'ID client est un nombre entier pour éviter les injections
		$idclients = (int)$idclients;

		// Requête SQL sécurisée avec des paramètres liés pour éviter l'injection SQL
		$sql = "SELECT ga.*, c.* 
            FROM groupe_annonce ga 
            JOIN campagne c ON ga.idcampagne = c.idcampagne 
            WHERE ga.idclients = ?"	;

		// Exécution de la requête avec un paramètre lié
		$query = $this->db->query($sql, array($idclients));

		// Récupération des résultats sous forme de tableau
		$retour = $query->result_array();

		// Retourner les résultats
		return $retour;
	}










	public function insert_pmax($idclient, $idcampagne, $nom_campagne, $zone, $calendar, $appareil, $mot_cle, $objectif, $repartition_budget, $titre, $description, $description_bref, $url, $logos, $favicon, $Images_youtube1, $Images_youtube2, $Images_gmail, $Images_display1, $Images_display2, $Images_discover1, $Images_discover2, $Images_discover3)
	{
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

	public function insert_pmax_groupe(
		$idclients,
		$idcampagne,
		$type_campagne,
		$nom_groupe,
		$logos,
		$favicon,
		$Images_youtube1,
		$Images_youtube2,
		$Images_gmail,
		$Images_display1,
		$Images_display2,
		$Images_discover1,
		$Images_discover2,
		$Images_discover3
	) {
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

public function insert_campagne_am(
					$idclients,
					$camp_type,
					$nom_campagne,
					$information_campagne,
					$cible,
					$ages,
					$zones,
					$repartition_budget,
					$date_campagne,
					$appareil,
					$objectif,
					$url_site,
					$mots_cle,
					$Mots_cle_exclus,
					$sexe,
					$promotions,
					$prix,
					$téléphone
				){
    // Échappement des variables
    $idclients = $this->db->escape($idclients);
    $camp_type = $this->db->escape($camp_type);
    $nom_campagne = $this->db->escape($nom_campagne);
    $information_campagne = $this->db->escape($information_campagne);
    $ages = $this->db->escape($ages);
    $cible = $this->db->escape($cible);
    $zones = $this->db->escape($zones);
    $repartition_budget = $this->db->escape($repartition_budget);
    $date_campagne = $this->db->escape($date_campagne);
    $appareil = $this->db->escape($appareil);
    $objectif = $this->db->escape($objectif);
    $url_site = $this->db->escape($url_site);
    $Mots_cle_exclus = $this->db->escape($Mots_cle_exclus);
	$sexe = $this->db->escape($sexe);
    $promotions = $this->db->escape($promotions);
    $prix = $this->db->escape($prix);
    $téléphone = $this->db->escape($téléphone);

    // Construction de la requête SQL
    $sql = "
        INSERT INTO campagne (
            idclients,
            type_campagne,
            nom_campagne,
            information_campagne,
            age,
            cible,
            zones,
            repartition_budget,
            date_campagne,
            appareil,
            objectif,
            url_site,
            Mots_cle_exclus,
			sexe,
			promotions,
			prix,
			téléphone
        ) VALUES (
            $idclients,
            $camp_type,
            $nom_campagne,
            $information_campagne,
            $ages,
            $cible,
            $zones,
            $repartition_budget,
            $date_campagne,
            $appareil,
            $objectif,
            $url_site,
            $Mots_cle_exclus,
			$sexe,
			$promotions,
			$prix,
			$téléphone
        )
    ";


    $this->db->query($sql);

    $idcampagne = $this->db->insert_id();

    $this->db->close();

    return $idcampagne;
}


	public function update_campagne_am(
		$idcampagne,
		$idclients,
		$type_campagne,
		$nom_campagne,
		$information_campagne,
		$zones,
		$repartition_budget,
		$date_campagne,
		$appareil,
		$objectif,
		$url_site,
		$Mots_cle_exclus
	) {
		$this->load->database();

		// Sécurisation automatique via Active Record
		$data = [
			'idclients'           => $idclients,
			'type_campagne'       => $type_campagne,
			'nom_campagne'        => $nom_campagne,
			'information_campagne' => $information_campagne,
			'zones'               => $zones,
			'repartition_budget'  => $repartition_budget,
			'date_campagne'       => $date_campagne,
			'appareil'            => $appareil,
			'objectif'            => $objectif,
			'url_site'            => $url_site,
			'Mots_cle_exclus'     => $Mots_cle_exclus
		];

		$this->db->where('idcampagne', $idcampagne);
		$updated = $this->db->update('campagne', $data);

		$this->db->close();

		return $updated; // true si succès, false sinon
	}


	public function insert_groupe_search($data)
	{
		// Insérer les données dans la base de données
		$this->db->insert('groupe_annonce', $data);
	}

	public function creer_groupe_search($data)
	{
		// Insérer les données dans la base de données
		$this->db->insert('groupe_annonce', $data);
	}

	public function update_groupe_search($idgroupe_annonce, $data)
	{
		// Mise à jour des données dans la table des groupes d'annonces en fonction de l'ID
		$this->db->where('idgroupe_annonce', $idgroupe_annonce);
		return $this->db->update('groupe_annonce', $data);
	}

	public function insert_campagne($data)
	{
		$this->db->insert('campagne', $data);
		return $this->db->insert_id();
	}

	public function insert_gppmax($idclients, $nom_groupe_pmax, $type_campagne, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client)
	{



		$sql = "INSERT INTO groupe_annonce(idclients,nom_groupe,type_campagnes,url_groupe_annonce,mot_cle, idcampagne,contexte_groupes_annonces) 
				VALUES ('$idclients','$nom_groupe_pmax','$type_campagne','$url_site','$Mots_cle_potentiels','$idcampagne','$contextes_client')";
		$this->db->query($sql);
		$this->db->close();
	}

	public function insert_campagne_pmax($idclient, $zone, $type_de_campagne, $calendar, $appareil)
	{

		$sql = "INSERT INTO campagne(idclients, zones, type_campagne, date_campagne, appareil) 
            VALUES ('$idclient', '$zone', '$type_de_campagne', '$calendar', '$appareil')";
		$this->db->query($sql);
		$insert_id = $this->db->insert_id();
		$this->db->close();

		return $insert_id; // Retourner l'ID de l'insertion
	}

	public function insert_donne_information($idclients, $information_client, $contextes_client)
	{
		$sql = "update donnee set information_client='" . $information_client . "',contexte_client='" . $contextes_client . "' where idclients='" . $idclients . "'";
		$this->db->query($sql);
		$this->db->close();
	}


	// Fonction pour insérer un groupe d'annonce
	public function insert_groupe_annonce($data)
	{
		// Insérer les données dans la table groupe_annonce
		$this->db->insert('groupe_annonce', $data);
		return $this->db->insert_id();  // Retourne l'ID de la dernière insertion
	}

	public function insert_groupe_pmax($data)
	{
		// Insérer les données dans la base de données
		$this->db->insert('groupe_annonce', $data);
	}

	public function update_groupe_pmax($data, $idgroupe_annonce)
	{
		// Mettre à jour les données dans la base de données en fonction de l'idgroupe_annonce
		$this->db->where('idgroupe_annonce', $idgroupe_annonce); // Condition sur l'ID
		$this->db->update('groupe_annonce', $data); // Mise à jour de la table
	}

	// Fonction pour insérer plusieurs groupes d'annonces
	public function insert_multiple_groupe_annonce($data)
	{
		// Insérer plusieurs groupes d'annonces
		return $this->db->insert_batch('groupe_annonce', $data);  // Utilise insert_batch pour insérer plusieurs lignes
	}

	public function save_campagne($idonnee, $decision)
	{
		$sql = "update donnee set campagne_actif='" . $decision . "' where idonnee='" . $idonnee . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function save_campagne_clients($idclients, $decision)
	{
		$sql = "update donnee set lien_datastudio='" . $decision . "' where idclients='" . $idclients . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function bouillon_campagnes($idcampagne, $decision)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE campagne SET actif = '" . $decision . "' WHERE idcampagne = '" . $idcampagne . "'";
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

	public function save_campagnestech($idclients, $decision)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE campagne SET actif = '" . $decision . "',publier_techinque='" . $decision . "' WHERE idclients = '" . $idclients . "'";
		$this->db->query($sql);
	}

	public function save_annoncestech($idclients, $decision)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE groupe_annonce SET validation_technique = '" . $decision . "' WHERE idclients = '" . $idclients . "'";
		$this->db->query($sql);
	}

	public function save_campagnes($idcampagne, $decision)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE campagne SET actif = '" . $decision . "',publier_techinque='" . $decision . "' WHERE idcampagne = '" . $idcampagne . "'";
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

	public function updateDonneesClientss($idgroupe_annonce, $data)
	{
		// Mise à jour des données dans la table en fonction de l'idgroupe_annonce
		$this->db->where('idgroupe_annonce', $idgroupe_annonce);
		$this->db->update('groupe_annonce', $data);

		// Vérifiez si la mise à jour s'est bien passée
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateextensions($idextensions, $data)
	{
		// Mise à jour des données dans la table en fonction de l'idgroupe_annonce
		$this->db->where('idextensions', $idextensions);
		$this->db->update('extensions', $data);

		// Vérifiez si la mise à jour s'est bien passée
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function save_annonces($idcampagne, $decision)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE groupe_annonce SET validation_technique = '" . $decision . "' WHERE idcampagne = '" . $idcampagne . "'";
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

	public function save_annonces_donnee($idclients, $structure)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE donnee SET validation_technique = '" . $structure . "' WHERE idclients = '" . $idclients . "'";
		$this->db->query($sql);
	}

	public function changelogo($logos, $idgroupe_annonce)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE groupe_annonce SET  	logo_client = '" . $logos . "' WHERE idgroupe_annonce = '" . $idgroupe_annonce . "'";
		$this->db->query($sql);
	}

	public function changelogoclients($logos, $idclients)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE clients SET  	logo_client = '" . $logos . "' WHERE idclients = '" . $idclients . "'";
		$this->db->query($sql);
	}

	public function changefavicons($favicon, $idgroupe_annonce)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE groupe_annonce SET  	favicon = '" . $favicon . "' WHERE idgroupe_annonce = '" . $idgroupe_annonce . "'";
		$this->db->query($sql);
	}

	public function changefavicon($favicon, $idgroupe_annonce)
	{
		// Met à jour l'état de la campagne
		$sql = "UPDATE groupe_annonce SET  	favicon = '" . $favicon . "' WHERE idgroupe_annonce = '" . $idgroupe_annonce . "'";
		$this->db->query($sql);
	}



	public function insert_structure($idonnee, $structure)
	{
		$sql = "update donnee set Validation_structure='" . $structure . "' where idonnee='" . $idonnee . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function save_annonce($idgroupe_annonce, $decision)
	{
		// Mettre à jour le statut du groupe d'annonces
		$sql = "UPDATE groupe_annonce SET statut='" . $decision . "' WHERE idgroupe_annonce='" . $idgroupe_annonce . "'";
		$this->db->query($sql);

		// Récupérer l'idclients après la mise à jour
		$sql = "SELECT idclients FROM groupe_annonce WHERE idgroupe_annonce='" . $idgroupe_annonce . "'";
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

	public function save_brouillon($idonnee, $decision)
	{
		$sql = "update donnee set campagne_actif='" . $decision . "' where idonnee='" . $idonnee . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function update_dejaclient($decision, $id_donnee)
	{
		$sql = "update donnee set dejaclient='" . $decision . "' where idonnee='" . $id_donnee . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function updatelogo($idclients, $logo)
	{
		$sql = "update clients set logo_client='" . $logo . "' where idclients='" . $idclients . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function updateinformation($idonnee, $secteur_activite, $information_client, $contexte_client, $tracking_gtm, $commentaire, $information_complementaire)
	{
		// Échapper les variables avant d'utiliser dans la requête SQL
		$secteur_activite = $this->db->escape($secteur_activite);
		$information_client = $this->db->escape($information_client);
		$contexte_client = $this->db->escape($contexte_client);
		$tracking_gtm = $this->db->escape($tracking_gtm);
		$commentaire = $this->db->escape($commentaire);
		$information_complementaire = $this->db->escape($information_complementaire);

		// Requête pour mettre à jour les informations
		$sql = "UPDATE donnee SET secteur_activite=" . $secteur_activite . ", information_client=" . $information_client . ", contexte_client=" . $contexte_client . ", tracking_gtm=" . $tracking_gtm . ", commentaire=" . $commentaire . ", information_complementaire=" . $information_complementaire . " WHERE idonnee=" . $idonnee;

		// Exécution de la requête
		$this->db->query($sql);

		// Récupérer l'idclients après la mise à jour
		$sql = "SELECT idclients FROM donnee WHERE idonnee=" . $idonnee;
		$result = $this->db->query($sql);

		// Supposons qu'il y ait un seul résultat
		$row = $result->row_array(); // Utilisation de row_array() pour obtenir un tableau associatif
		$idclients = $row['idclients'];

		// Fermeture de la connexion
		$this->db->close();

		// Retourner l'idclients
		return $idclients;
	}




	public function update_client($idclient, $client, $email_client, $numero_client, $site_client)
	{
		// Charger la base de données
		$this->load->database();

		// Échapper les valeurs pour éviter les injections SQL
		$idclient = $this->db->escape($idclient);
		$client = $this->db->escape($client);
		$email_client = $this->db->escape($email_client);
		$numero_client = $this->db->escape($numero_client);
		$site_client = $this->db->escape($site_client);

		// Construire la requête avec les valeurs échappées
		$sql = "UPDATE clients SET nom_client = $client, email_client = $email_client, numero_client = $numero_client, site_client = $site_client WHERE idclients = $idclient";

		// Exécuter la requête
		$this->db->query($sql);

		// Fermer la connexion à la base de données
		$this->db->close();
	}

	public function update_donnee_client($budget, $secteur_activite, $Produit, $Initiative, $Am, $mis_en_place_paiement, $Brief, $annonce, $commentaire_client, $paiement_recu, $datastudio, $email_onboarding, $facturation, $idonnee)
	{
		// Charger la base de données
		$this->load->database();

		// Échapper les valeurs pour éviter les injections SQL
		$budget = $this->db->escape($budget);
		$secteur_activite = $this->db->escape($secteur_activite);
		$Produit = $this->db->escape($Produit);
		$Initiative = $this->db->escape($Initiative);
		$Am = $this->db->escape($Am);
		$mis_en_place_paiement = $this->db->escape($mis_en_place_paiement);
		$Brief = $this->db->escape($Brief);
		$annonce = $this->db->escape($annonce);
		$commentaire_client = $this->db->escape($commentaire_client);
		$paiement_recu = $this->db->escape($paiement_recu);
		$datastudio = $this->db->escape($datastudio);
		$email_onboarding = $this->db->escape($email_onboarding);
		$facturation = $this->db->escape($facturation);
		$idonnee = $this->db->escape($idonnee);

		// Construire la requête avec les valeurs échappées
		$sql = "UPDATE donnee SET 
					budget = $budget, 
					secteur_activite = $secteur_activite, 
					idproduit = $Produit, 
					initiative = $Initiative, 
					account_manager = $Am, 
					mis_en_place_paiement = $mis_en_place_paiement, 
					Brief = $Brief, 
					annonce = $annonce, 
					modifier_par = $Am, 
					commentaire_client = $commentaire_client, 
					paiement_recu = $paiement_recu, 
					datastudio = $datastudio, 
					email_onboarding = $email_onboarding, 
					facturation = $facturation 
				WHERE idonnee = $idonnee";

		// Exécuter la requête
		$this->db->query($sql);

		// Fermer la connexion à la base de données
		$this->db->close();
	}
	public function update_onboarding_client($budget, $secteur_activite, $Produit, $Initiative, $Am, $mis_en_place_paiement, $Brief, $annonce, $commentaire_client, $paiement_recu, $datastudio, $email_onboarding, $facturation, $idonboarding)
	{
		// Charger la base de données
		$this->load->database();

		// Échapper les valeurs pour éviter les injections SQL
		$budget = $this->db->escape($budget);
		$secteur_activite = $this->db->escape($secteur_activite);
		$Produit = $this->db->escape($Produit);
		$Initiative = $this->db->escape($Initiative);
		$Am = $this->db->escape($Am);
		$mis_en_place_paiement = $this->db->escape($mis_en_place_paiement);
		$Brief = $this->db->escape($Brief);
		$annonce = $this->db->escape($annonce);
		$commentaire_client = $this->db->escape($commentaire_client);
		$paiement_recu = $this->db->escape($paiement_recu);
		$datastudio = $this->db->escape($datastudio);
		$email_onboarding = $this->db->escape($email_onboarding);
		$facturation = $this->db->escape($facturation);
		$idonboarding = $this->db->escape($idonboarding);

		// Construire la requête avec les valeurs échappées
		$sql = "UPDATE onboarding SET 
					budget = $budget, 
					secteur_activite = $secteur_activite, 
					idproduit = $Produit, 
					mis_en_place_paiement = $mis_en_place_paiement, 
					Brief = $Brief, 
					annonce = $annonce, 
					modifier_par = $Am, 
					commentaire_client = $commentaire_client, 
					paiement_recu = $paiement_recu, 
					datastudio = $datastudio, 
					email_onboarding = $email_onboarding, 
					facturation = $facturation 
				WHERE idonboarding = $idonboarding";

		// Exécuter la requête
		$this->db->query($sql);

		// Fermer la connexion à la base de données
		$this->db->close();
	}

	public function update_produit($product_choice, $idonnee)
	{
		$sql = "update donnee set idproduit='" . $product_choice . "' where idonnee='" . $idonnee . "'";
		$this->db->query($sql);
		$this->db->close();
	}

	public function getProduitById($idproduit)
	{
		$sql = "select * from produit where idproduit = '" . $idproduit . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}


	public function getinitiativeById($idinitiative)
	{
		//var_dump($idinitiative);
		$sql = "select * from users where id = '" . $idinitiative . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function getamById($idam)
	{
		$sql = "select * from users where id = '" . $idam . "'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}

	public function get_all_produit()
	{
		$query = $this->db->get('produit');
		return $query->result(); // Renvoie un tableau d'objets
	}

	public function get_all_am()
	{
		$query = $this->db->get('am');
		return $query->result(); // Renvoie un tableau d'objets
	}

	public function get_all_initiative()
	{
		$query = $this->db->get('initiative');
		return $query->result(); // Renvoie un tableau d'objets
	}
}
