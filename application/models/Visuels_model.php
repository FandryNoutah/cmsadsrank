<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Visuels_model extends CI_Model {

	protected $table = "hm_visuels";
	protected $table1 = "concurrent";
	protected $table2 = "liste_car";
	protected $table3 = "clients";
	protected $table4 = "donnee";
	protected $table5 = "upsell";
	protected $visuels_formats_images = "hm_visuels_formats_images";
    protected $_database;
    public $table_fields = array();

	
	public function getClientDataByDonneeWithMonth($month_filter = null) {
		$this->db->select('donnee.*, clients.*, produit.*, 
							am_user.photo_users AS am_photo_user, 
							tech_user.photo_users AS tech_photo_user');
    
		$this->db->from('donnee');
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
		$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');

		// Apply month filter if provided
		if (!empty($month_filter)) {

			if (preg_match('/^\d{4}-\d{2}$/', $month_filter)) {
				// Format: YYYY-MM
				$this->db->where("DATE_FORMAT(donnee.mis_en_place_paiement, '%Y-%m') =", $month_filter);
			} 
			// Check if the filter is in MM-YYYY format
			elseif (preg_match('/^\d{2}-\d{4}$/', $month_filter)) {
				// Format: MM-YYYY
				$this->db->where("DATE_FORMAT(donnee.mis_en_place_paiement, '%m-%Y') =", $month_filter);
			}
		}

		return $this->db->get()->result();
	}
	public function get_all() {
        $this->db->where("status", 1);
	    return $this->db->get($this->table)->result();
	}
	public function create_resiliation($resiliation,$date_resiliation,$fin_campagne, $am_resiliation, $tm_resiliation, $demande_resiliation, $information_resiliation, $statut_resiliation,$idclients){
		$sql = "update donnee set resiliation='".$resiliation."',date_resiliation='".$date_resiliation."',fin_campagne='".$fin_campagne."',am_resiliation='".$am_resiliation."',tm_resiliation='".$tm_resiliation."',demande_resiliation='".$demande_resiliation."',information_resiliation='".$information_resiliation."',statut_resiliation='".$statut_resiliation."' where idclients='".$idclients."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function create_upsell($type_upsell,$budget_upsell,$budget_initiale,$demmande_upsell,$am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell,$idclients){
		$sql = "INSERT INTO upsell (type_upsell,budget_initiale, budgets,compta, am, tm, date_upsell, date_demande, information, etat, idclients) 
				VALUES ('$type_upsell', '$budget_initiale', '$budget_upsell','$demmande_upsell', '$am', '$tm', '$date_upsell', '$date_demande_upsell', '$inforamtion_upsell', '$statut_upsell', '$idclients')";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_budget($budget_finale,$idclients){
		$sql = "update donnee set budget='".$budget_finale."' where idclients='".$idclients."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_brief($date_brief,$campagne_actif,$validation_technique,$date_validation_structure,$lien_datastudio,$idclients){
		$sql = "update donnee set brief='".$date_brief."', campagne_actif='".$campagne_actif."', validation_technique='".$validation_technique."', date_validation_structure='".$date_validation_structure."', lien_datastudio='".$lien_datastudio."' where idclients='".$idclients."'";
		$this->db->query($sql);
		$this->db->close();
	}
	
	public function insert_remarque_campagne($remarque, $idonnee, $fichier_nom = null)
{
    $this->load->database();

    // Données à mettre à jour
    $data = [
        'remarque_campagne' => $remarque
    ];

    if ($fichier_nom !== null) {
        $data['fichier_nom'] = $fichier_nom; // Assure-toi que la colonne `fichier` existe dans `donnee`
    }

    // Mise à jour de la ligne avec l'idonnee correspondant
    $this->db->where('idonnee', (int)$idonnee);
    $this->db->update('donnee', $data);

    // Récupération de l'id du client concerné
    $query = $this->db->select('idclients')
                     ->from('donnee')
                     ->where('idonnee', (int)$idonnee)
                     ->get();

    $result = $query->row();

    return $result ? $result->idclients : null;
}

	
	
	
	public function getresiliation() {
		// Sélectionner toutes les colonnes nécessaires et la colonne nom_client de la table clients
		$this->db->select('donnee.*, clients.nom_client, am_user.photo_users AS am_user_photo_users, tech_user.photo_users AS tech_user_photo_users');
		
		// Table principale : donnee
		$this->db->from('donnee');
		
		// Jointure entre donnee et clients (sélectionner nom_client)
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		
		// Jointure entre donnee et produit
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		
		// Jointure entre donnee et initiative
		//$this->db->join('initiative AS init', 'donnee.initiative = init.idinitiative');
		
		// Jointure entre donnee et am_user (Account Manager)
		$this->db->join('users AS am_user', 'donnee.am_resiliation = am_user.id', 'left');
		
		// Jointure entre donnee et tech_user (Utilisateur technique)
		$this->db->join('users AS tech_user', 'donnee.tm_resiliation = tech_user.id', 'left');
		
		// Condition pour exclure les enregistrements où type_upsell est NULL
		$this->db->where('resiliation !=', 1);

		
		// Retourner les résultats
		return $this->db->get()->result();
	}
	public function getupsell() {
		// Sélectionner les colonnes de la table upsell, nom_client, photos AM et TM, et budget depuis donnee
		$this->db->select('
			upsell.*, 
			clients.nom_client, 
			am_user.photo_users AS am_photo, 
			tech_user.photo_users AS tm_photo,
			compta_user.photo_users AS compta_photo, 
			donnee.budget
		');
		
		// Table principale
		$this->db->from('upsell');
	
		// Jointure avec la table clients
		$this->db->join('clients', 'upsell.idclients = clients.idclients', 'left');
	
		// Jointure avec la table donnee
		$this->db->join('donnee', 'donnee.idclients = upsell.idclients', 'left');
		
		// Jointure avec la table users pour AM (Account Manager)
		$this->db->join('users AS am_user', 'upsell.am = am_user.id', 'left');
	
		// Jointure avec la table users pour TM (Technicien)
		$this->db->join('users AS tech_user', 'upsell.tm = tech_user.id', 'left');
		$this->db->join('users AS compta_user', 'upsell.compta = compta_user.id', 'left');
	
		// Ne garder que les enregistrements ayant un type upsell défini
		$this->db->where_in('upsell.type_upsell', [1, 2,3]);
	
		// Exécution de la requête
		return $this->db->get()->result();
	}
	public function getupsellbyid($id) {
		$this->load->database();
		$this->db->select('
			upsell.*, 
			clients.nom_client, 
			am_user.photo_users AS am_photo, 
			tech_user.photo_users AS tm_photo,
			compta_user.photo_users AS compta_photo, 
			donnee.budget
		');
	
		$this->db->from('upsell');
	
		$this->db->join('clients', 'upsell.idclients = clients.idclients', 'left');
		$this->db->join('donnee', 'donnee.idclients = upsell.idclients', 'left');
		$this->db->join('users AS am_user', 'upsell.am = am_user.id', 'left');
		$this->db->join('users AS tech_user', 'upsell.tm = tech_user.id', 'left');
		$this->db->join('users AS compta_user', 'upsell.compta = compta_user.id', 'left');
	
		$this->db->where('upsell.idclients', $id);
		$this->db->where_in('upsell.type_upsell', [1, 2]);
	
		// Utilise le bon nom de colonne ici
		$this->db->order_by('upsell.idupsell', 'DESC');
	
		$this->db->limit(1);
	
		return $this->db->get()->row(); 
	}
	
	
	
	
	
	


	public function getusersall() {
		$sql = "select * from users";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	
	public function getglientbycampagne($id) {
		$sql = "select idclients from campagne where idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
		public function getglientbycampagnes($id) {
		$sql = "select * from campagne where idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function insert_extensions($data_extensions) {
        // Utiliser la méthode insert de CodeIgniter pour insérer les données
        return $this->db->insert_batch('extensions', $data_extensions); // 'extensions' est le nom de ta table
    }
	public function insert_plan_de_taggage($data_extensions) {
        // Utiliser la méthode insert de CodeIgniter pour insérer les données
        return $this->db->insert_batch('plan_de_taggage', $data_extensions); // 'extensions' est le nom de ta table
    }
	public function getextensions($id) {
		$sql = "
			SELECT *
			FROM extensions
			WHERE idclients = '". $id ."'";
		
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		
		return $retour;    
	}


	public function getgroupepmaxidcampagne($id) {
		$sql = "select * from groupe_annonce where idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
		public function getgroupelocalidcampagne($id) {
		$sql = "select * from groupe_annonce where idgroupe_annonce = '". $id ."'";
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
		// SQL query with JOIN on the campagne table
		$sql = "SELECT * FROM groupe_annonce ga
				JOIN campagne c ON ga.idcampagne = c.idcampagne
				WHERE ga.idgroupe_annonce = '". $id ."'";
		
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
	public function getclientbyannonce($id) {
		
		$sql = "select idclients from groupe_annonce where idgroupe_annonce = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	
	public function getClientById($id) {
		
		$sql = "select * from clients where idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getplantaggage($id) {
		$sql = "SELECT * 
				FROM plan_de_taggage p
				JOIN clients c ON p.idclients = c.idclients
				WHERE p.idclients = '" . $id . "'";
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
	public function prendidgroupeannoncebyclientspmax($idclients) {
		$sql = "select idgroupe_annonce from groupe_annonce where idclients = '". $idclients ."' AND type_campagnes = 3 ";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;	
	}
	public function getGroupeAnnonceByIdPmaxsgroupe($id) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idgroupe_annonce = '". $id ."' AND ga.type_campagnes ='3'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getGroupeAnnonceByIdLocalsgroupe($id) {
		$sql = "SELECT ga.*, c.nom_client, c.email_client, c.numero_client, c.site_client, c.logo_client AS client_logo,
				ca.nom_campagne, ca.type_campagne, ca.logo_client AS campagne_logo, ca.parametre_campagne, 
				ca.repartition_budget AS campagne_repartition_budget, ca.date_campagne, ca.url_site, ca.zones, 
				ca.cible, ca.Mots_cle_potentiels, ca.valeurs_ajouter, ca.appareil, ca.Extensions_de_liens, 
				ca.Extensions_de_produits, ca.label_produit, ca.objectif AS campagne_objectif
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				JOIN campagne ca ON ga.idcampagne = ca.idcampagne
				WHERE ga.idgroupe_annonce = '". $id ."' AND ga.type_campagnes ='2'";
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
	public function getCAMPAGNEByIdc($id) {
		$sql = "SELECT * FROM campagne WHERE idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getextensionsByIdc($id) {
		$sql = "SELECT * FROM extensions WHERE idextensions = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}



	public function getallextensionsByIdc($id) {
		$sql = "SELECT * FROM extensions WHERE idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getCampagnesearchByIdclient($id) {
		$sql = "SELECT * FROM campagne WHERE idcampagne = '". $id ."' AND ";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getnbrgroupe($id) {
		$sql = "SELECT * FROM groupe_annonce WHERE idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getbudgetutilise($id) {
		$sql = "SELECT repartition_budget FROM campagne WHERE idclients = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getgRoupeannonceByIdg($id) {
		$sql = "SELECT * FROM groupe_annonce WHERE idcampagne = '". $id ."'";
		$result = $this->db->query($sql);
		$retour = $result->result_array();
		$this->db->close();
		return $retour;
	}
	public function getgRoupeannonceByIdgs($id) {
		$sql = "SELECT * FROM groupe_annonce WHERE idgroupe_annonce = '". $id ."'";
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
	public function getGroupe_annonce_pmaxfByIdv($id) {
		// Assurez-vous que l'ID est un nombre entier pour éviter les injections SQL.
		$id = (int) $id;
	
		// Requête SQL sécurisée avec un JOIN sur la table clients
		$sql = "SELECT ga.*, c.*
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				WHERE ga.idclients = ? 
				AND ga.type_campagnes = '3'";  // Condition sur 'type_campagne'
	
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
	public function getGroupe_annonce_localfByIdv($id) {
		// Assurez-vous que l'ID est un nombre entier pour éviter les injections SQL.
		$id = (int) $id;
	
		// Requête SQL sécurisée avec un JOIN sur la table clients
		$sql = "SELECT ga.*, c.*
				FROM groupe_annonce ga
				JOIN clients c ON ga.idclients = c.idclients
				WHERE ga.idclients = ? 
				AND ga.type_campagnes = '2'";  // Condition sur 'type_campagne'
	
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
	public function getcampagne_Groupe_annonce_briefById($id) {
		// Ajout du JOIN pour récupérer le label du type de campagne
		$sql = "SELECT c.*, ca.*
				FROM groupe_annonce c
				INNER JOIN campagne ca ON c.idcampagne = ca.idcampagne
				WHERE c.idgroupe_annonce = '" . $id . "'";
		
		// Exécution de la requête
		$result = $this->db->query($sql);
		
		// Retour des résultats sous forme de tableau associatif
		$retour = $result->result_array();
		
		// Fermeture de la connexion à la base de données
		$this->db->close();
		
		return $retour;  
	}
	public function getcampagne_Groupe_annonce_briefByIds($id) {
		// Ajout du JOIN pour récupérer le label du type de campagne
		$sql = "SELECT *
				FROM campagne
				WHERE idcampagne = '" . $id . "'";
		
		// Exécution de la requête
		$result = $this->db->query($sql);
		
		// Retour des résultats sous forme de tableau associatif
		$retour = $result->result_array();
		
		// Fermeture de la connexion à la base de données
		$this->db->close();
		
		return $retour;  
	}	public function getcampagne_Groupe_annonce_briefByIdg($g) {
		// Ajout du JOIN pour récupérer le label du type de campagne
		$sql = "SELECT *
				FROM groupe_annonce
				WHERE idcampagne = '" . $g . "'";
		
		// Exécution de la requête
		$result = $this->db->query($sql);
		
		// Retour des résultats sous forme de tableau associatif
		$retour = $result->result_array();
		
		// Fermeture de la connexion à la base de données
		$this->db->close();
		
		return $retour;  
	}
		public function get_exclusions($idclients) {
		// Ajout du JOIN pour récupérer le label du type de campagne
		$sql = "SELECT *
				FROM donnee
				WHERE idclients = '" . $idclients . "'";
		
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
	public function exclusion($id,$exclusion){
		$sql = "update donnee set exclusion='".$exclusion."' where idclients='".$id."'";
		$this->db->query($sql);
		$this->db->close();
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
	public function updatescampagne($zones, $date_campagne, $appareil, $budget, $information_campagne, $objectif, $idcampagne) {
		$data = array(
			'zones' => $zones,
			'date_campagne' => $date_campagne,
			'appareil' => $appareil,
			'repartition_budget' => $budget,
			'information_campagne' => $information_campagne,
			'objectif' => $objectif
		);
	
		$this->db->where('idcampagne', $idcampagne);
		return $this->db->update('campagne', $data);
	}
	

public function updatescampagnes($zones, $date_campagne, $appareil, $budget, $idcampagne) {
    $this->load->database();

    // Préparer les données
    $data = array(
        'zones' => $zones,
        'date_campagne' => $date_campagne,
        'appareil' => $appareil,
        'repartition_budget' => $budget
    );

    // Exécuter la mise à jour en utilisant Active Record
    $this->db->where('idcampagne', $idcampagne);
    $this->db->update('campagne', $data);

    // Vérifier si l'update a été effectué avec succès
    if ($this->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }

    $this->db->close();
}
public function updateGroupe($id, $data) {
	$this->db->where('idgroupe_annonce', $id);
	return $this->db->update('groupe_annonce', $data);
}

public function updatesgroupe($nom_groupe, $mot_cle, $idgroupe_annonce) {
    $this->load->database();

    // Préparer les données
    $data = array(
        'nom_groupe' => $nom_groupe,
        'mot_cle' => $mot_cle
    );

    // Exécuter la mise à jour en utilisant Active Record
    $this->db->where('idgroupe_annonce', $idgroupe_annonce);
    $this->db->update('groupe_annonce', $data);

    // Vérifier si l'update a été effectué avec succès
    if ($this->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }

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
	public function insertclient($client, $site_client, $email_client, $numero_client,$favicon,$cms,$cms_logo){
        $query = "INSERT INTO clients (nom_client, email_client, numero_client, site_client,favicon,cms,cms_logo) VALUES ('$client', '$email_client', '$numero_client', '$site_client', '$favicon', '$cms', '$cms_logo')";
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
	
    public function insertfiche($idclient,$budget,$secteur_activite,$product_choice,$initiative,$am,$date_mis_en_place,$date_brief,$date_annonce,$dejaclient,$gtm_code) {
        $query = "INSERT INTO donnee (idclients,idproduit,budget,secteur_activite,initiative,account_manager,mis_en_place_paiement,Brief,annonce,modifier_par,dejaclient,tracking_gtm) VALUES ('$idclient','$product_choice','$budget','$secteur_activite','$initiative','$am','$date_mis_en_place','$date_brief','$date_annonce','$am','$dejaclient','$gtm_code')";
        $this->db->query($query);
    }


    	public function getClientDataByDonneeWithPmax() {
    $this->db->select('*');
    $this->db->from('campagne');
    $this->db->join('clients', 'campagne.idclients = clients.idclients');
    $this->db->join('donnee', 'campagne.idclients = donnee.idclients');
    $this->db->join('users', 'donnee.account_manager = users.id');
    $this->db->where('campagne.type_campagne', 3); // Correction de la syntaxe
    $query = $this->db->get(); // Ajout de la méthode pour exécuter la requête
    return $query->result();
}


	public function getClientDataByDonneeold() {

        $this->db->select('clients.idclients, clients.nom_client, clients.email_client, clients.numero_client, clients.site_client');
        $this->db->from('donnee');
        $this->db->join('clients', 'donnee.idclients = clients.idclients');
		$this->db->join('initiative', 'donnee.initiative = initiative.idinitiative');
        return $query->result();  
    }
	public function getClientDataByDonnee() {
		// Sélectionner toutes les colonnes nécessaires, y compris les photos des utilisateurs
		$this->db->select('donnee.*, clients.*, produit.*, 
						   am_user.photo_users AS am_photo_user, 
						   tech_user.photo_users AS tech_photo_user');  // Retirer les commentaires
		
		// Table de base : donnee
		$this->db->from('donnee');
		
		// Jointure entre donnee et clients sur idclients
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		
		// Jointure entre donnee et produit sur idproduit
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		
		// Jointure entre donnee et users pour l'account_manager (utilisateur qui gère le client)
		$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
		
		// Jointure entre donnee et users pour l'initiative (utilisateur responsable de l'initiative)
		$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');
		
		// Récupérer les résultats
		return $this->db->get()->result();
	}	
public function getDonneeByCampagneNonActif() {
	// Sélection des colonnes nécessaires
	$this->db->select('
		donnee.*, 
		clients.*, 
		produit.*, 
		am_user.first_name AS am_first_name,
		am_user.last_name AS am_last_name,
		am_user.photo_users AS am_photo_user,
		tech_user.photo_users AS tech_photo_user
	');

	// Table principale
	$this->db->from('donnee');

	// Jointures
	$this->db->join('clients', 'donnee.idclients = clients.idclients');
	$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
	$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
	$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');

	// Filtres
	$this->db->where('donnee.campagne_actif', 0);
	$this->db->where('donnee.budget !=', 0);

	// Exécution de la requête
	return $this->db->get()->result();
}
public function getDonneeByenattentedeenvoyestructure() {
	// Sélection des colonnes nécessaires
	$this->db->select('
		donnee.*, 
		clients.*, 
		produit.*, 
		am_user.first_name AS am_first_name,
		am_user.last_name AS am_last_name,
		am_user.photo_users AS am_photo_user,
		tech_user.photo_users AS tech_photo_user
	');

	// Table principale
	$this->db->from('donnee');

	// Jointures
	$this->db->join('clients', 'donnee.idclients = clients.idclients');
	$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
	$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
	$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');

	// Filtres
	$this->db->where('donnee.campagne_actif', 1);
	$this->db->where('donnee.budget !=', 0);

	// Exécution de la requête
	return $this->db->get()->result();
}

	public function getClientDataByDonneesuperieur() {
		// Sélectionner toutes les colonnes nécessaires, y compris les photos des utilisateurs
		$this->db->select('donnee.*, clients.*, produit.*, 
						   am_user.photo_users AS am_photo_user, 
						   tech_user.photo_users AS tech_photo_user');
		
		// Table de base : donnee
		$this->db->from('donnee');
		
		// Jointure entre donnee et clients sur idclients
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		
		// Jointure entre donnee et produit sur idproduit
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		
		// Jointure entre donnee et users pour l'account_manager
		$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
		
		// Jointure entre donnee et users pour l'initiative
		$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');
		
		// Filtrer les enregistrements où la date d'annonce est postérieure ou égale à 2025-00-00
	
		
		// Récupérer les résultats
		return $this->db->get()->result();
	}
	
	

	
	public function getClientDataByDonneewhereclientnon() {
		$this->db->select('donnee.*, clients.*, produit.*, 
						   am_user.photo_users AS am_photo_user, 
						   tech_user.photo_users AS tech_photo_user');  // Retirer les commentaires
		
		// Table de base : donnee
		$this->db->from('donnee');
		
		// Jointure entre donnee et clients sur idclients
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		
		// Jointure entre donnee et produit sur idproduit
		$this->db->join('produit', 'donnee.idproduit = produit.idproduit');
		
		// Jointure entre donnee et users pour l'account_manager (utilisateur qui gère le client)
		$this->db->join('users AS am_user', 'donnee.account_manager = am_user.id', 'left');
		
		// Jointure entre donnee et users pour l'initiative (utilisateur responsable de l'initiative)
		$this->db->join('users AS tech_user', 'donnee.initiative = tech_user.id', 'left');
		$this->db->where('dejaclient', 1);
		// Récupérer les résultats
		return $this->db->get()->result();
	}
	public function getdonneclientbyidclients($idclients) {
		$this->db->select('*');
		$this->db->from('donnee');
		$this->db->join('clients', 'donnee.idclients = clients.idclients');
		$this->db->where('donnee.idclients', $idclients);
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

	public function update_paiement_recu($enter,$idonnee){
		$sql = "update donnee set paiement_recu='".$enter."' where idonnee='".$idonnee."'";
		$this->db->query($sql);
		$this->db->close();
	}
	public function update_creation_ads($date_creation_ads,$idonnee){
		$sql = "update donnee set Céation_compte_ads='".$date_creation_ads."' where idonnee='".$idonnee."'";
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
