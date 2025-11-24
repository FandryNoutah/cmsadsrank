<?php
defined('BASEPATH') or exit('No direct script access allowed');
$vendorAutoload = FCPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (!file_exists($vendorAutoload)) {
    // Message lisible et log si le fichier n'existe pas
    log_message('error', 'vendor/autoload.php introuvable : ' . $vendorAutoload);
    show_error("Dépendances Composer manquantes. Exécuter `composer require dompdf/dompdf` dans le dossier racine du projet.", 500, 'Dépendances manquantes');
    exit;
}
require_once $vendorAutoload;

use Dompdf\Dompdf;
use Dompdf\Options;

class Client extends MY_Controller
{
	private $api_url = 'https://api.aircall.io/v1/calls';
	private $api_auth = '';
	protected $file_upload_field;
	public function __construct()
	{
		parent::__construct();

		$this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
		$this->load->model("Data_modele");
		$this->load->model("Image_model");
		$this->load->model("Message_model");
		$this->load->model("Task_model");
		$this->load->model("Note_model");
		$this->load->model("Discussion_model");
		$this->load->model("Gtm_model");
		$this->load->model("Application_model");
		$this->data['visuels'] = $this->visuels_model->get_all();
		// $this->load->library('PHPExcel');
		// $this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('curl');
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		$this->load->database(); 
		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$this->current_user = $this->ion_auth->user()->row();
	}


	public function index()
	{
		$this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$this->data['users'] = $this->Task_model->get_all_users();
		$this->data['produit'] = $this->Donne_modele->get_all_produit();
		$this->data['am'] = $this->Donne_modele->get_all_am();
		$this->data['initiative'] = $this->Donne_modele->get_all_initiative();
		
		$this->content = "layouts/client/index.php";
		$this->layout();
	}
	public function valider_campagne($idclients)
	{
				$statut_demande = 3;
				$statut_valide  = 1;
				$task = $this->Task_model->get_task_by_id_and_validation($idclients);
				$onboarding = $this->visuels_model->get_last_onboarding_by_id($idclients);
				$date_fin = $onboarding['annonce'];
				$idonboarding = $onboarding['idonboarding'];
				$id = intval($task->idtask);
				$idtask = intval($task->idtask);
				$am = intval($task->assigned_to);
				$this->visuels_model->change_statut_en_demande($id, $statut_demande);
				$this->visuels_model->change_statut_valider_client($idonboarding, $statut_valide);
				$data = [
					'status'	=>	"effectuée",
				];
				$this->Task_model->update_task_statuts($idtask, $data);
					$id = intval($task->idclients);
					$type_tache = 15;
					$title = "Mise en ligne";
					$description = "Veuiller mettre la campagne en ligne le $date_fin";
					$Statuts_technique = 1;
					$procedure_gtm = 4;
					$tm = 23;
					$date_debut = date('Y-m-d');
					$data = array(
						'type_tache' => $type_tache,
						'date_demande' => $date_debut,
						'date_due' => $date_fin,
						'idclients' => $id,
						'AM' => $am,
						'assigned_to' => 23,
						'title' => $title,
						'Statuts_technique' => $Statuts_technique,
						'procedure_gtm' => $procedure_gtm,
						'description' => $description
					);

		$this->Task_model->add_task($data);
		redirect('Onboarding');
	}
	public function uspell_campagne()
	{
		$idclients = intval($this->input->post('idclients'));
		$camp_param = intval($this->input->post('camp_param'));
		$onboarding = $this->visuels_model->get_last_onboarding_by_id($idclients);
		$idonnee = $onboarding['idonnee'];
		$idupsell = $onboarding['idupsell'];
		$statut = 2;
		if($camp_param == 1){

		}
		if($camp_param == 2){
			$this->visuels_model->delete_all_campagne($idclients);
			$this->visuels_model->delete_all_images($idclients);
		}
		$statut_demande_en_cours = 0;
		$this->load->database();
		$update = $this->db
			->where('idupsell', $idupsell)
			->update('upsell', ['statut_actif' => $statut]);

		$this->visuels_model->update_statut_demande_en_cours($statut_demande_en_cours,$idonnee);
		$this->visuels_model->update_statut_demande_en_cours($statut_demande_en_cours,$idonnee);
		redirect('Client/onboarding/'. $idclients );

	}
	public function mis_a_jour_cmp($id)
	{

		// récupérer l’URL du client
		$client = $this->Application_model->get_client($id);
		$url = $client['site_client'];

		// détecter CMP
		$cmp = $this->Application_model->detect_cmp($url);

		// mettre à jour en base
		$this->Application_model->update_cmp($id, $cmp);

		// message puis redirection
		$this->session->set_flashdata('success', 'CMP mis à jour automatiquement : ' . $cmp);
		redirect('Client/application/'.$id.'?maj=ok&type=cmp');

	}


	public function mis_a_jour_datalayer($id)
	{

		// récupérer l’URL du client
		$client = $this->Application_model->get_client($id);
		$url = $client['site_client'];

		// détecter datalayer
		$datalayer = $this->Application_model->detect_datalayer($url);

		// mise à jour
		$this->Application_model->update_datalayer($id, $datalayer);

		$this->session->set_flashdata('success', 'DataLayer mis à jour : ' . $datalayer);
		redirect('Client/application/'.$id.'?maj=ok&type=datalayer');

	}

	public function repatition_budget()
{
    $this->load->model('Donne_modele'); // assure-toi que le model est chargé
    $this->load->model('Task_model');
    $this->load->model('visuels_model');

    $idclients       = $this->input->post('client');
    $campagnesData   = $this->input->post('campagne');      // nouveaux montants
    $campagnesOld    = $this->input->post('campagne_old');  // anciens montants (hidden)
    $campagnesName   = $this->input->post('campagne_name'); // noms (hidden)
    $type_upsell     = intval($this->input->post('type_upsell'));

    if (!$idclients || !$campagnesData || !is_array($campagnesData)) {
        $this->session->set_flashdata('error', 'Aucune donnée reçue.');
        redirect($_SERVER['HTTP_REFERER']);
        return;
    }

    // transaction optionnelle
    $this->db->trans_begin();

    $changes = [];
    foreach ($campagnesData as $idcampagne => $newBudgetRaw) {
        $idcamp = intval($idcampagne);
        $newBudget = floatval($newBudgetRaw);

        // récupérer old et nom depuis le POST (fallback si manquant)
        $oldBudget = isset($campagnesOld[$idcamp]) ? floatval($campagnesOld[$idcamp]) : 0;
        $nomCampagne = isset($campagnesName[$idcamp]) ? $campagnesName[$idcamp] : 'Campagne #' . $idcamp;

        // Mettre à jour via ton model si existant
        if (method_exists($this->Donne_modele, 'update_budget')) {
            $this->Donne_modele->update_budget($idcamp, $newBudget);
        } else {
            // fallback : update direct si model indisponible
            $this->db->where('idcampagne', $idcamp)->update('campagnes', ['repartition_budget' => $newBudget]);
        }

        $changes[] = [
            'idcampagne' => $idcamp,
            'nom' => $nomCampagne,
            'old' => $oldBudget,
            'new' => $newBudget,
        ];
    }

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('error', 'Erreur lors de la mise à jour des budgets.');
        redirect($_SERVER['HTTP_REFERER']);
        return;
    } else {
        $this->db->trans_commit();
    }

    // Si Booster : on ajoute le détail directement dans la description de la tache
    if ($type_upsell === 3) {
        // recuperer la tache booster la plus récente
        $task = $this->Task_model->get_task_booster_by_id_and_validation($idclients);

        // Préparer la description textuelle (Ancien -> Nouveau)
        $lines = [];
        $lines[] = "Répartition BOOSTER";
        $lines[] = "";
        $lines[] = "Détails des modifications :";
		foreach ($changes as $c) {
			$lines[] =  $c['nom'] . " : Ancien montant : " 
						. number_format($c['old'], 2, ',', ' ') . " € -> Nouveau montant : " 
						. number_format($c['new'], 2, ',', ' ') . " €";
		}

        $description = implode("\n", $lines);

        // si tache existante -> marquer effectuée
        if ($task && isset($task->idtask)) {
            $idtask = intval($task->idtask);
            // si tu as des fonctions pour changer statuts, les appeler
            $this->visuels_model->change_statut_en_demande($idtask, 3); // adapte si besoin
            $this->Task_model->update_task_statuts($idtask, ['status' => 'effectuée']);
        }

        // créer une nouvelle tache "Mise en ligne" avec la description (ou l'ajouter à la tache existante)
        $onboarding = $this->visuels_model->get_last_onboarding_by_id($idclients);
        $date_mise_en_ligne = isset($onboarding['annonce']) ? $onboarding['annonce'] : date('Y-m-d');

        $am = ($task && isset($task->assigned_to)) ? intval($task->assigned_to) : null;
        $assigned_to = 23; // fallback
		$idupsell = intval($task->idupsell);
        $newTask = [
            'type_tache'        => 15,
            'date_demande'      => date('Y-m-d'),
            'date_due'          => $date_mise_en_ligne,
            'idclients'         => intval($idclients),
            'AM'                => $am,
            'assigned_to'       => $assigned_to,
            'title'             => 'Mise en ligne - Booster',
            'Statuts_technique' => 1,
            'procedure_gtm'     => 4,
            'description'       => $description,
			'idupsell'       => $idupsell
        ];

        $this->Task_model->add_task($newTask);
    }

    // flash summary
    $summaryLines = [];
    foreach ($changes as $c) {
        $summaryLines[] = $c['nom'] . ': ' . number_format($c['old'], 0, ',', ' ') . '€ → ' . number_format($c['new'], 0, ',', ' ') . '€';
    }
    $this->session->set_flashdata('success', 'Répartition du budget mise à jour !<br>' . implode('<br>', $summaryLines));

    redirect($_SERVER['HTTP_REFERER']);
}

	public function change_statut_budget()
	{
		$idupsell = (int) $this->input->post('idupsell');
		$statut = (int) $this->input->post('statut_actif');

		$upsell = $this->visuels_model->get_upsell_by_id($idupsell);
		$budget_finale = $upsell[0]['budgets'];
		$idclients     = $upsell[0]['idclients'];
		if ($statut == 2) {
			$this->visuels_model->update_budget($budget_finale, $idclients);
		}
		$this->load->database();
		$update = $this->db
			->where('idupsell', $idupsell)
			->update('upsell', ['statut_actif' => $statut]);

		if ($update) {
			$this->session->set_flashdata('success', 'Statut modifié avec succès !');
		} else {
			$this->session->set_flashdata('error', 'Erreur lors de la mise à jour du statut.');
		}
		

		// Redirection vers la page précédente
		return redirect($_SERVER['HTTP_REFERER']);
	}





	public function export_inventaire_pdf($client_id = null)
    {
        // TODO: récupère tes données comme d’habitude
        // Ex: $groupe_valider = $this->Client_model->getGroupesValider($client_id);
        $groupe_valider = isset($this->groupe_valider) ? $this->groupe_valider : []; // adapte à ton code

        // Flag pour adapter l’affichage "spécial PDF"
        $data = [
            'groupe_valider' => $groupe_valider,
            'for_pdf'        => true,
            'client_id'      => $client_id,
        ];

        // 1) Rendre une vue spéciale PDF
        $html = $this->load->view('client/inventaire_pdf', $data, true);

        // 2) Dompdf (options safe)
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php'; // adapte si besoin

        $options = new Options();
        $options->set('isRemoteEnabled', true);       // pour images https externes
        $options->set('isHtml5ParserEnabled', true);  // meilleur rendu HTML5/CSS3
        $options->setChroot(FCPATH);                  // sécurité fichiers locaux

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        // 3) Stream (Attachment=false = ouvre dans le navigateur)
        $filename = 'inventaire-' . ($client_id ?? 'client') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
    }
	public function send_annonce($idonnee = null)
		{

			if (!$idonnee) {
				show_error('Aucune donnée spécifiée', 400);
				return;
			}
			$am = intval($this->input->post('am'));
			$date_envoye = date('Y-m-d');
			$idclients = $this->Donne_modele->update_send_annonce($idonnee, 1);
			$this->Donne_modele->update_send_annonce_onboarding($idonnee, 1);

			if (!$idclients) {
				$this->session->set_flashdata('error', 'Brief introuvable.');
				redirect($_SERVER['HTTP_REFERER']); 
			}

			$date_demande = date('Y-m-d');
			$date_due = date('Y-m-d', strtotime('+3 days'));
			$title = "Validation client";
			$tache = "Annonce prêt pour validation client";
			$current_user = $this->ion_auth->user()->row();
			$tm = intval($current_user->id);

			$datas = [
				'date_demande'      => $date_demande,
				'date_due'          => $date_due,
				'idclients'         => $idclients,
				'AM'                => $tm,
				'assigned_to'       => $am, 
				'title'             => $title,
				'type_tache'	    => 10,
				'description'       => $tache
			];
			$title = "Création annonce";
			$this->Task_model->add_tasks($datas);
			$task = $this->Task_model->get_task_brief($idclients, $title);
				$taskId = intval($task->idtask);
				$data = [
					'status'	=>	"effectuée",
				];
			$this->Task_model->update_task_statuts($taskId, $data);
			$this->session->set_flashdata('success', 'Brief envoyé à la technique et tâche créée.');
			redirect($_SERVER['HTTP_REFERER']); 
		}

	public function send_to_technique($idonnee = null)
		{;

			if (!$idonnee) {
				show_error('Aucune donnée spécifiée', 400);
				return;
			}
			$date_envoye = date('Y-m-d');
			$idclients = $this->Donne_modele->update_status_brief($idonnee,$date_envoye, 1);
			$this->Donne_modele->update_status_brief_onboarding($idonnee,$date_envoye, 1);

			if (!$idclients) {
				$this->session->set_flashdata('error', 'Brief introuvable.');
				redirect($_SERVER['HTTP_REFERER']); 
			}

			$date_demande = date('Y-m-d');
			$date_due = date('Y-m-d', strtotime('+3 days'));
			$title = "Création annonce";
			$tache = "Le brief de ce client est fait, veuillez procéder à la création des annonces";
			$current_user = $this->ion_auth->user()->row();
			$am = intval($current_user->id);

			$datas = [
				'date_demande'      => $date_demande,
				'date_due'          => $date_due,
				'idclients'         => $idclients,
				'AM'                => $am,
				'assigned_to'       => 23, 
				'title'             => $title,
				'type_tache'	    => 10,
				'description'       => $tache
			];
			$title = "Création de Brief";
			$this->Task_model->add_tasks($datas);
			$task = $this->Task_model->get_task_brief($idclients, $title);
				$taskId = intval($task->idtask);
				$data = [
					'status'	=>	"effectuée",
				];
			$this->Task_model->update_task_statuts($taskId, $data);
			$this->session->set_flashdata('success', 'Brief envoyé à la technique et tâche créée.');
			redirect($_SERVER['HTTP_REFERER']); 
		}



	public function annonces($idclient)
	{
		$this->data['client'] = $this->visuels_model->getDonneeById($idclient);
		$campagnes = $this->visuels_model->get_campagnes_by_client($idclient);
		foreach ($campagnes as &$campagne) {
			$campagne['groupes_annonces'] = $this->visuels_model->get_groupes_by_campagne($campagne['idcampagne']);
			$campagne['images'] = $this->Image_model->get_images_by_campagne($campagne['idcampagne']);
		}
		$this->data['campagnes'] = $campagnes;
		$this->content = "layouts/client/onboarding/annonces_liste";
		$this->layout();
	}
	public function modifier_annonce($idgroupe_annonce)
{
	
    // --- Groupe
    $groupe = $this->db->get_where('groupe_annonce', [
        'idgroupe_annonce' => (int)$idgroupe_annonce
    ])->row_array();
    if (!$groupe) { show_404(); }

    // --- Campagne
    $campagne = $this->db->get_where('campagne', [
        'idcampagne' => (int)$groupe['idcampagne']
    ])->row_array();
    if (!$campagne) { show_404(); }

    $idcampagne = (int)$groupe['idcampagne'];
    $idclients  = (int)$groupe['idclients'];
	

    // --- Mapping type_campagne : 1=search, 2=local, 3=pmax
    $mapNumToSlug = [
        1 => 'search',
        2 => 'local',
        3 => 'pmax',
    ];
    $mapSlugToSlug = [
        '1' => 'search', 'search' => 'search',
        '2' => 'local',  'local'  => 'local',
        '3' => 'pmax',   'pmax'   => 'pmax',
    ];

    // 1) si ?type= fourni (nombre ou slug), il a la priorité
    $typeReq = strtolower((string)$this->input->get('type', true));
    $type = $mapSlugToSlug[$typeReq] ?? null;

    // 2) sinon, on lit la DB : int dans type_campagne ou un éventuel texte dans type
    if (!$type) {
        if (isset($campagne['type_campagne']) && $campagne['type_campagne'] !== '') {
            $typeNum = (int)$campagne['type_campagne'];
            $type = $mapNumToSlug[$typeNum] ?? null;
        }
    }
    if (!$type) {
        // fallback : texte éventuel en base (search/local/pmax) ou défaut search
        $raw = strtolower((string)($campagne['type'] ?? ''));
        $type = $mapSlugToSlug[$raw] ?? 'search';
    }

    // --- Titres / longues / descriptions
    $ads_titres = [];
    for ($i=1; $i<=15; $i++) { $ads_titres[] = (string)($groupe['titre'.$i] ?? ''); }

    $ads_titres_longs = [];
    for ($i=1; $i<=5; $i++) { $ads_titres_longs[] = (string)($groupe['longtitre'.$i] ?? ''); }

    $ads_descriptions = [];
    for ($i=1; $i<=4; $i++) { $ads_descriptions[] = (string)($groupe['descriptions'.$i] ?? ''); }

    // --- Extensions
    $extensions = $this->db->order_by('idlien_annexe','asc')
        ->get_where('lien_annexe', ['idcampagne' => $idcampagne])->result_array();

    $accroches = $this->db->order_by('idextension_accroche','asc')
        ->get_where('extension_accroche', ['idcampagne' => $idcampagne])->result_array();

    $extraits = $this->db->order_by('idextrait_de_site','asc')
        ->get_where('extrait_de_site', ['idcampagne' => $idcampagne])->result_array();

    // --- Images
    $images = $this->db->order_by('rank','asc')->get_where('images', [
        'idcampagne' => $idcampagne,
        'idclients'  => $idclients
    ])->result_array();
	$this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);

    // Normalisation pour vues "Local" qui attendent $images_site (objets { image_url })
    $images_site = array_map(function($row){
        return (object)['image_url' => $row['image_url'] ?? ($row['url'] ?? '')];
    }, $images);

    // --- Infos client
    $donnees = $this->visuels_model->getDonneeById($idclients);

    // --- Sauvegarde Numéro/Adresse en POST uniquement
    if (strtolower($this->input->method()) === 'post') {
        $numero  = $this->input->post('numero', true);
        $adresse = $this->input->post('adresse', true);
        if ($numero !== null || $adresse !== null) {
            if (method_exists($this->Donne_modele, 'update_num_adresse')) {
                $this->Donne_modele->update_num_adresse($numero, $adresse, $idcampagne);
            }
        }
    }

    // --- Data partagée
    $this->data = array_merge($this->data ?? [], [
        'mode'               => 'edit',
        'type'               => $type,
        'groupe'             => [$groupe],
        'campagne'           => $campagne,
        'donnees'            => [$donnees[0] ?? []],
        'ads_titres'         => $ads_titres,
        'ads_titres_longs'   => $ads_titres_longs,
        'ads_descriptions'   => $ads_descriptions,
        'extensions'         => $extensions,
        'accroches'          => $accroches,
        'extraits'           => $extraits,
        'images'             => $images,
        'images_site'        => $images_site,
    ]);

    // --- Sélection de la vue par type
    $views = [
        'search' => 'layouts/client/onboarding/modifier_annonce_search',
        'local'  => 'layouts/client/onboarding/modifier_annonce_local',
        'pmax'   => 'layouts/client/onboarding/modifier_annonce_pmax',
    ];

    $this->content = $views[$type] ?? $views['search'];
    $this->layout();
}


public function update_annonce()
{
    // --- Inputs de base
    $idgroupe_annonce = (int)$this->input->post('idgroupe_annonce');
    $idcampagne       = (int)$this->input->post('idcampagne');
    $idclients        = (int)$this->input->post('idclients');

    // Récupérer le type de campagne pour appliquer la logique
    $groupe = $this->db->get_where('groupe_annonce', ['idgroupe_annonce' => $idgroupe_annonce])->row_array();
    if (!$groupe) { show_404(); return; }
    $type = (int)$groupe['type_campagnes']; // 1=Search, 2=Local, 3=PMax

    // Champs communs
    $mot_cle          = trim((string)$this->input->post('mot_cle'));
    $url_campagne     = trim((string)$this->input->post('url_campagne'));

    // Champs spécifiques
	$chemin1           = trim((string)$this->input->post('chemin1'));
	$chemin2           = trim((string)$this->input->post('chemin2'));

	// -> clé ASCII "description_breve" prioritaire, puis fallback sur "Description_brève"
	$description_breve = trim((string)(
		$this->input->post('description_breve') !== null
			? $this->input->post('description_breve')
			: $this->input->post('Description_brève')
	));


    // Groupes d’assets
    $titres           = is_array($this->input->post('titres'))         ? $this->input->post('titres')         : [];
    $titres_longs     = is_array($this->input->post('titres_longs'))   ? $this->input->post('titres_longs')   : [];
    $descriptions     = is_array($this->input->post('descriptions'))   ? $this->input->post('descriptions')   : [];

    // “Nouvelle” UX
    $titre_annexe     = is_array($this->input->post('titre_annexe'))   ? $this->input->post('titre_annexe')   : [];
    $desc1_annexe     = is_array($this->input->post('desc1_annexe'))   ? $this->input->post('desc1_annexe')   : [];
    $desc2_annexe     = is_array($this->input->post('desc2_annexe'))   ? $this->input->post('desc2_annexe')   : [];
    $url_annexe       = is_array($this->input->post('url_annexe'))     ? $this->input->post('url_annexe')     : [];
    $accroche_annexe  = is_array($this->input->post('accroche_annexe'))? $this->input->post('accroche_annexe'): [];
    $site_annexe      = is_array($this->input->post('site_annexe'))    ? $this->input->post('site_annexe')    : [];

    // Autres champs (déjà présents dans ton code)
    $fiche_etablissement = $this->input->post('fiche_etablissement');
    $email_campagne      = $this->input->post('email_campagne');
    $adresse_campagne    = $this->input->post('adresse_campagne');

    // Téléphone / Adresse (sauvegarde via modèle dédié)
    $numero  = $this->input->post('numero');
    $adresse = $this->input->post('adresse');

    // ---------- Construction de $data commun ----------
    $data = [
        'fiche_etablissement' => $fiche_etablissement,
        'email_campagne'      => $email_campagne,
        'adresse_campagne'    => $adresse_campagne,
        'mot_cle'             => mb_substr($mot_cle, 0, 255),
        'url_groupe_annonce'  => mb_substr($url_campagne, 0, 200),
    ];

    // Titres / Longtitres / Descriptions (respect des limites de colonnes)
    for ($i = 0; $i < 12; $i++) {
        $val = isset($titres[$i]) ? trim((string)$titres[$i]) : null;
        $data['titre'.($i+1)] = $val !== '' ? mb_substr($val, 0, 200) : null;
    }
    for ($i = 0; $i < 5; $i++) {
        $val = isset($titres_longs[$i]) ? trim((string)$titres_longs[$i]) : null;
        $data['longtitre'.($i+1)] = $val !== '' ? mb_substr($val, 0, 200) : '';
    }
    for ($i = 0; $i < 4; $i++) {
        $val = isset($descriptions[$i]) ? trim((string)$descriptions[$i]) : null;
        $data['descriptions'.($i+1)] = $val !== '' ? mb_substr($val, 0, 200) : null;
    }

    // ---------- Logique conditionnelle par type ----------
    if ($type === 1) {
    // SEARCH
    $data['chemin1'] = $chemin1 !== '' ? mb_substr($chemin1, 0, 200) : null;
    $data['chemin2'] = $chemin2 !== '' ? mb_substr($chemin2, 0, 200) : null;
    $data['description_breve'] = null;  // plutôt null qu'une chaîne vide
	} else {
		// LOCAL & PMAX
		$data['description_breve'] = $description_breve !== '' ? mb_substr($description_breve, 0, 250) : null;
		$data['chemin1'] = null;
		$data['chemin2'] = null;
	}


    // ---------- Transaction ----------
    $this->db->trans_start();

    // (1) MAJ groupe
    $this->db->where('idgroupe_annonce', $idgroupe_annonce)->update('groupe_annonce', $data);

    // (2) SITELINKS
    $this->db->where('idcampagne', $idcampagne)->delete('lien_annexe');
    $max = max(count($titre_annexe), count($desc1_annexe), count($desc2_annexe), count($url_annexe));
    for ($i=0; $i<$max; $i++) {
        $t  = isset($titre_annexe[$i]) ? trim((string)$titre_annexe[$i]) : '';
        $d1 = isset($desc1_annexe[$i]) ? trim((string)$desc1_annexe[$i]) : '';
        $d2 = isset($desc2_annexe[$i]) ? trim((string)$desc2_annexe[$i]) : '';
        $u  = isset($url_annexe[$i])   ? trim((string)$url_annexe[$i])   : '';
        if ($t==='' && $d1==='' && $d2==='' && $u==='') continue;

        $this->db->insert('lien_annexe', [
            'idclients'                => $idclients,
            'idcampagne'               => $idcampagne,
            'titre_lien_annexe'        => mb_substr($t,  0, 25),
            'description1_lien_annexe' => mb_substr($d1, 0, 90),
            'description2_lien_annexe' => mb_substr($d2, 0, 90),
            'url_lien_annexe'          => mb_substr($u,  0, 200),
        ]);
    }

    // (3) ACCROCHES
    $this->db->where('idcampagne', $idcampagne)->delete('extension_accroche');
    foreach ($accroche_annexe as $acc) {
        $acc = trim((string)$acc);
        if ($acc==='') continue;
        $this->db->insert('extension_accroche', [
            'idclients'                => $idclients,
            'idcampagne'               => $idcampagne,
            'texte_extension_accroche' => mb_substr($acc, 0, 25),
        ]);
    }

    // (4) EXTRAITS
    $this->db->where('idcampagne', $idcampagne)->delete('extrait_de_site');
    foreach ($site_annexe as $snip) {
        $snip = trim((string)$snip);
        if ($snip==='') continue;
        $this->db->insert('extrait_de_site', [
            'idclients'             => $idclients,
            'idcampagne'            => $idcampagne,
            'texte_extrait_de_site' => mb_substr($snip, 0, 25),
        ]);
    }

    // (5) Téléphone / Adresse (table dédiée)
    $this->Donne_modele->update_num_adresse($numero, $adresse, $idcampagne);

    $this->db->trans_complete();

    if (!$this->db->trans_status()) {
        show_error('Erreur lors de la modification du groupe/annonce.');
        return;
    }

    redirect('Client/onboarding/'.$idclients, 'refresh');
}





	public function Ajoutgroupes()
{
    // --- Inputs de base
	$this->load->database(); 
    $idgroupe_annonce = $this->input->post('idgroupe_annonce');
    $idcampagne       = $this->input->post('idcampagne');
    $idclients        = $this->input->post('idclients');

    $chemin1          = trim((string)$this->input->post('chemin1'));
    $chemin2          = trim((string)$this->input->post('chemin2'));

    $titres           = is_array($this->input->post('titres'))         ? $this->input->post('titres')         : [];
    $titres_longs     = is_array($this->input->post('titres_longs'))   ? $this->input->post('titres_longs')   : [];
    $descriptions     = is_array($this->input->post('descriptions'))   ? $this->input->post('descriptions')   : [];

    $fiche_etablissement = $this->input->post('fiche_etablissement');
    $email_campagne      = $this->input->post('email_campagne');
    $adresse_campagne    = $this->input->post('adresse_campagne');

    // --- NOUVEAUX CHAMPS — Sitelinks + Accroches + Extraits
    $titre_annexe = is_array($this->input->post('titre_annexe'))  ? $this->input->post('titre_annexe')  : [];
    $desc1_annexe = is_array($this->input->post('desc1_annexe'))  ? $this->input->post('desc1_annexe')  : [];
    $desc2_annexe = is_array($this->input->post('desc2_annexe'))  ? $this->input->post('desc2_annexe')  : [];
    $url_annexe   = is_array($this->input->post('url_annexe'))    ? $this->input->post('url_annexe')    : [];

    $accroche_annexe = is_array($this->input->post('accroche_annexe')) ? $this->input->post('accroche_annexe') : [];
    $site_annexe     = is_array($this->input->post('site_annexe'))     ? $this->input->post('site_annexe')     : [];

	$numero = $this->input->post('numero');
    $adresse     = $this->input->post('adresse');

	$this->Donne_modele->update_num_adresse($numero, $adresse, $idcampagne);
	$id = $idclients;
    $exclusion = $this->input->post('Mots_cle_exclus');
	$this->visuels_model->exclusion($id, $exclusion);
    $statut = 1;

    // --- Prépare les données du groupe
    $data = [
        'idgroupe_annonce'    => $idgroupe_annonce,
        'idcampagne'          => $idcampagne,
        'idclients'           => $idclients,
        'chemin1'             => $chemin1,
        'chemin2'             => $chemin2,
        'statut'              => $statut,
        'fiche_etablissement' => $fiche_etablissement,
        'email_campagne'      => $email_campagne,
        'adresse_campagne'    => $adresse_campagne
    ];

    // Titres (jusqu’à 12)
    for ($i = 0; $i < 12; $i++) {
        $data['titre' . ($i + 1)] = isset($titres[$i]) ? trim($titres[$i]) : null;
    }
    // Titres longs (jusqu’à 5)
    for ($i = 0; $i < 5; $i++) {
        $data['longtitre' . ($i + 1)] = isset($titres_longs[$i]) ? trim($titres_longs[$i]) : null;
    }
    // Descriptions (jusqu’à 4)
    for ($i = 0; $i < 4; $i++) {
        $data['descriptions' . ($i + 1)] = isset($descriptions[$i]) ? trim($descriptions[$i]) : null;
    }

    // --- Transaction globale
    //$this->db->trans_start();

    // 1) MAJ du groupe
    $this->Donne_modele->update_groupe_search($idgroupe_annonce, $data);

    // 2) SITELINKS (lien_annexe)
    // Nettoyage ancien
    $this->db->where('idcampagne', $idcampagne)->delete('lien_annexe');

    // Insert (max 4 affichés côté front)
    $max = max(count($titre_annexe), count($desc1_annexe), count($desc2_annexe), count($url_annexe));
    for ($i = 0; $i < $max; $i++) {
        $t  = isset($titre_annexe[$i]) ? trim($titre_annexe[$i]) : '';
        $d1 = isset($desc1_annexe[$i]) ? trim($desc1_annexe[$i]) : '';
        $d2 = isset($desc2_annexe[$i]) ? trim($desc2_annexe[$i]) : '';
        $u  = isset($url_annexe[$i])   ? trim($url_annexe[$i])   : '';

        // si tout est vide, on saute
        if ($t === '' && $d1 === '' && $d2 === '' && $u === '') continue;

        // bornes de sécurité (Google: 25/90/90)
        $row = [
            'idclients'                => $idclients,
            'idcampagne'               => $idcampagne,
            'titre_lien_annexe'        => mb_substr($t,  0, 25),
            'description1_lien_annexe' => mb_substr($d1, 0, 90),
            'description2_lien_annexe' => mb_substr($d2, 0, 90),
            'url_lien_annexe'          => mb_substr($u,  0, 200),
        ];
        $this->db->insert('lien_annexe', $row);
    }

    // 3) EXTENSIONS D’ACCROCHE (extension_accroche)
    $this->db->where('idcampagne', $idcampagne)->delete('extension_accroche');
    foreach ($accroche_annexe as $acc) {
        $acc = trim((string)$acc);
        if ($acc === '') continue;
        $this->db->insert('extension_accroche', [
            'idclients'                => $idclients,
            'idcampagne'               => $idcampagne,
            'texte_extension_accroche' => mb_substr($acc, 0, 25),
        ]);
    }

    // 4) EXTRAITS DE SITE (extrait_de_site)
    $this->db->where('idcampagne', $idcampagne)->delete('extrait_de_site');
    foreach ($site_annexe as $snip) {
        $snip = trim((string)$snip);
        if ($snip === '') continue;
        $this->db->insert('extrait_de_site', [
            'idclients'            => $idclients,
            'idcampagne'           => $idcampagne,
            'texte_extrait_de_site'=> mb_substr($snip, 0, 25),
        ]);
    }

    // 5) éventuelle logique “fiche établissement” (inchangée)
    $donnees  = $this->visuels_model->getDonneeById($idclients);
    $assigned_to = $donnees[0]['account_manager'];

    if ($fiche_etablissement === "Non") {
        $date_demande = date('Y-m-d');
        $date_due     = date('Y-m-d', strtotime('+3 days'));
        $title        = "Demande fiche d'etablissement";
        $tache        = "Nous avons besoin du fiche d'etablissement du client";
        $current_user = $this->ion_auth->user()->row();
        $am           = intval($current_user->id);

        $datas = [
            'date_demande' => $date_demande,
            'date_due'     => $date_due,
            'idclients'    => $idclients,
            'AM'           => $am,
            'assigned_to'  => $assigned_to,
            'title'        => $title,
            'type_tache'   => 11,
            'description'  => $tache
        ];
        $this->Task_model->add_tasks($datas);
    }

    $this->db->trans_complete();

    if (!$this->db->trans_status()) {
        // tu peux logger et afficher un flash error si nécessaire
        show_error('Erreur lors de la sauvegarde du groupe et des extensions.');
        return;
    }

    redirect('Client/onboarding/' . $idclients, 'refresh');
}




	public function insertgroupeannonce($id)
	{
		$k = $this->data["groupe"] = $this->visuels_model->getgpid($id);
		$mot_cle = $k[0]['mot_cle'];
		$contexte_groupes_annonces = $k[0]['contexte_groupes_annonces'];
		$information_campagne = $k[0]['information_campagne'];
		$url_site = $k[0]['url_site'];
		$id = $idclients = $k[0]['idclients'];
		$id = intval($id);
		$d = $this->data['donnees'] = $this->visuels_model->getDonneeById($id);
		$information_base = $d[0]['info_base_client'];
		$information_client = $d[0]['information_client'];
		$site_client = $d[0]['site_client'];
		$type_campagne = $k[0]['type_campagne'];
		$idcampagne = $k[0]['idcampagne'];

		$adsContent = $this->generateGoogleAdsCopy($mot_cle, $contexte_groupes_annonces, $information_campagne, $url_site);
		$sitelinks = $this->generateSitelinks(
			$mot_cle,
			$information_campagne,
			$contexte_groupes_annonces,
			$url_site
		);

		$this->data['sitelinks'] = $sitelinks;


		$this->data['ads_titres'] = $adsContent['titres'];
		$this->data['ads_titres_longs'] = $adsContent['titres_longs'];
		$this->data['ads_descriptions'] = $adsContent['descriptions'];
		$this->data['images_site'] = $this->Image_model->get_images_by_campagne($idcampagne);
		$this->data['extensions'] = $this->Donne_modele->get_extensions_by_clients($idclients);
		$this->data["mots_exclus"] = $this->visuels_model->get_exclusions($idclients);
		if ($type_campagne == 1) {
			$this->content = "layouts/client/onboarding/annonce_search";
		}
		if ($type_campagne == 3) {
			$this->content = "layouts/client/onboarding/annonce_pmax";
		}
		if ($type_campagne == 2) {

			$this->content = "layouts/client/onboarding/annonce_local";
		}
		$this->layout();
	}
	private function generateSitelinks($mot_cle, $information_campagne, $contexte_groupes_annonces, $url_site)
{
    // Prompt strict: demande 2 liens, longueurs Google Ads
    $prompt = "Tu es un expert Google Ads.
En t'appuyant sur:
- Informations de campagne: $information_campagne
- Contexte/brief: $contexte_groupes_annonces
- Mot clé principal: $mot_cle
- URL de campagne (par défaut pour les liens): $url_site

Objectif: Génère exactement 2 liens annexes (sitelinks) pertinents.
Contraintes:
- title: max 25 caractères (ton clair, actionnable)
- desc1: max 90 caractères
- desc2: max 90 caractères
- url: par défaut l'URL de campagne fournie ($url_site). Si tu proposes un chemin, concatène proprement (ex: $url_site/page) sans paramètres.

Retourne UNIQUEMENT ce JSON:
{
  \"sitelinks\": [
    {\"title\":\"...\",\"desc1\":\"...\",\"desc2\":\"...\",\"url\":\"...\"},
    {\"title\":\"...\",\"desc1\":\"...\",\"desc2\":\"...\",\"url\":\"...\"}
  ]
}";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . getenv('CHAT_GPT_API_KEY')
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'model' => 'gpt-4-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Tu es un expert en publicité Google Ads.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7
        ])
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $decoded = json_decode($response, true);
    $content = $decoded['choices'][0]['message']['content'] ?? '';
    $json = json_decode($content, true);

    // Sécurisation/fallback
    $sitelinks = [];
    if (isset($json['sitelinks']) && is_array($json['sitelinks'])) {
        foreach ($json['sitelinks'] as $sl) {
            $title = isset($sl['title']) ? $this->trimUtf8($sl['title'], 25) : '';
            $desc1 = isset($sl['desc1']) ? $this->trimUtf8($sl['desc1'], 90) : '';
            $desc2 = isset($sl['desc2']) ? $this->trimUtf8($sl['desc2'], 90) : '';
            $url   = !empty($sl['url']) ? $sl['url'] : $url_site;

            // URL par défaut = URL campagne si vide, normalisation simple
            if (empty($url)) $url = $url_site;

            // Garde seulement si on a au moins un titre
            if ($title !== '') {
                $sitelinks[] = [
                    'title' => $title,
                    'desc1' => $desc1,
                    'desc2' => $desc2,
                    'url'   => $url,
                ];
            }
            if (count($sitelinks) === 2) break;
        }
    }

    // Fallback si le modèle ne renvoie pas correctement
    if (count($sitelinks) < 2) {
        // Deux suggestions génériques mais propres
        $sitelinks = [
            [
                'title' => $this->trimUtf8('Nos services', 25),
                'desc1' => $this->trimUtf8("Découvrez nos prestations phares adaptées à vos besoins.", 90),
                'desc2' => $this->trimUtf8("Tarifs, délais et garanties clairs pour décider rapidement.", 90),
                'url'   => $url_site
            ],
            [
                'title' => $this->trimUtf8('Contact & devis', 25),
                'desc1' => $this->trimUtf8("Obtenez un devis gratuit et personnalisé en quelques minutes.", 90),
                'desc2' => $this->trimUtf8("Nos experts vous répondent rapidement, sans engagement.", 90),
                'url'   => $url_site
            ]
        ];
    }

    // Toujours 2 éléments
    return array_slice($sitelinks, 0, 2);
}

/**
 * Coupe proprement en UTF-8 sans casser les caractères multioctets.
 */
private function trimUtf8($text, $limit)
{
    $text = trim((string)$text);
    if (mb_strlen($text, 'UTF-8') <= $limit) return $text;
    return mb_substr($text, 0, $limit, 'UTF-8');
}

	public function fetch_images_campagnes()
{
    $idcampagne = $this->input->post('idcampagne');
    $url = $this->input->post('url');

    if (!empty($idcampagne)) {
        $this->load->model('Image_model');
        $images = $this->Image_model->get_images_by_campagnes($idcampagne);

       $urls = array_map(function($img) {
    return $img->image_url;
}, $images);

        echo json_encode(['success' => true, 'images' => $urls]);
        return;
    }

    if (!empty($url)) {
        // Exemple : aller chercher les images du site
        $this->load->helper('url');
        $images = $this->_scrape_images_from_site($url);
        echo json_encode(['success' => true, 'images' => $images]);
        return;
    }

    echo json_encode(['success' => false, 'message' => 'Paramètre manquant']);
}

private function _scrape_images_from_site($url)
{
    $html = @file_get_contents($url);
    if (!$html) return [];

    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
    $images = array_unique($matches[1]);
    $absolute_images = [];

    $parsedUrl = parse_url($url);
    $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

    foreach ($images as $img) {
        if (strpos($img, 'http') === 0) {
            $absolute_images[] = $img;
        } elseif (strpos($img, '/') === 0) {
            $absolute_images[] = $baseUrl . $img;
        } else {
            $absolute_images[] = $baseUrl . '/' . $img;
        }
    }

    return $absolute_images;
}




	public function save_images_campagnes()
	{
		$idcampagne = $this->input->post('idcampagne');
		$images = $this->input->post('images'); // array d'URLs
		$idclient = $this->input->post('idclient'); // optionnel

		if (empty($idcampagne)) {
			echo json_encode(['success' => false, 'message' => 'ID campagne manquant']);
			return;
		}

		$this->load->model('Image_model');

		// Nettoie les anciennes images qui ne sont plus dans la liste
		$this->Image_model->delete_images_not_in($idcampagne, $images);

		// Ajoute les nouvelles
		if (!empty($images)) {
			foreach ($images as $url) {
				$this->Image_model->insert_or_ignore($idcampagne, $url, $idclient);
			}
		}

		echo json_encode(['success' => true]);
	}


	private function generateGoogleAdsCopy($mot_cle, $contexte_groupes_annonces, $information_campagne, $url_site)
	{
		$prompt = "Tu es un expert en Google Ads. 
		À partir de ces informations :
		- Informations de campagne : $information_campagne
		- Brief client : $contexte_groupes_annonces
		- Site web : $url_site
		- Mot clé : $mot_cle

		Génère :
		- 12 titres courts accrocheurs (max 30 caractères chacun),
		- 4 titres longs (max 90 caractères chacun),
		- 4 descriptions entre 70 et 90 caractère (max 90 caractères chacune).

		Retourne uniquement une réponse JSON structurée comme ceci :
		{
		\"titres\": [\"titre1\", \"titre2\", ...],
		\"titres_longs\": [\"titre_long1\", ...],
		\"descriptions\": [\"description1\", ...]
		}";

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json',
				'Authorization: Bearer ' . getenv('CHAT_GPT_API_KEY')
			],
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => json_encode([
				'model' => 'gpt-4-turbo',
				'messages' => [
					['role' => 'system', 'content' => 'Tu es un expert en publicité Google Ads.'],
					['role' => 'user', 'content' => $prompt]
				],
				'temperature' => 0.7
			])
		]);

		$response = curl_exec($curl);
		curl_close($curl);

		$decoded = json_decode($response, true);
		$content = $decoded['choices'][0]['message']['content'] ?? '';

		$result = json_decode($content, true);

		return $result ?: ['titres' => [], 'titres_longs' => [], 'descriptions' => []];
	}

	public function details_ajax($id)
	{
		$idclients = $id;
		$type_campagne = [
			1	=> "SEARCH",
			2	=>	"LOCAL",
			3	=>	"PERFORMANCE MAX"
		];
		$campagnes = $this->data["campagnes"] = $this->visuels_model->getCampagneByIdclient($idclients);
		$campagnes = $this->visuels_model->getCampagneByIdclient($idclients);

		foreach ($campagnes as $index => $campagne) {
			$campagnes[$index]['type_campagne'] = $type_campagne[$campagne['type_campagne']];
		}

		$data['campagnes'] = $campagnes;
		$donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];
		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}
		foreach ($donne_valider as &$campagne) {
			$idcampagne = $campagne['idcampagne'];
			$campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
		}
		unset($campagne);
		$data['donne_valider'] = $donne_valider;
		$data['images'] = $this->Image_model->get_images_by_client($idclients);
		$data['groupe_annonce'] = $this->Donne_modele->getcampagnegroupevalidationbyidclient($idclients);
		$data['id'] = $id;
		$this->load->view('layouts/client/onboarding/detail_campagne', $data);
	}

	public function inventaire_pmax($idclients)
	{
		$data['groupe_annonce'] = $this->Donne_modele->getpmaxvalider($idclients);
		$data['images'] = $this->Image_model->get_images_by_client($idclients);
		$this->load->view('layouts/client/onboarding/inventaire_pmax', $data);
	}

	public function export_pdf($id)
	{
		$this->load->library('pdf');

		$idclients = $id;
		$type_campagne = [
			1 => "SEARCH",
			2 => "LOCAL",
			3 => "PERFORMANCE MAX"
		];

		$campagnes = $this->visuels_model->getCampagneByIdclient($idclients);
		foreach ($campagnes as $index => $campagne) {
			$campagnes[$index]['type_campagne'] = $type_campagne[$campagne['type_campagne']];
		}

		$data['campagnes'] = $campagnes;
		$donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];
		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}
		foreach ($donne_valider as &$campagne) {
			$idcampagne = $campagne['idcampagne'];
			$campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
		}
		unset($campagne);
		$data['donne_valider'] = $donne_valider;
		$html = $this->load->view('layouts/client/onboarding/detail_campagne_pdf', $data, true);

		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$this->pdf->stream("campagnes_client_$idclients.pdf", ['Attachment' => true]);
	}


	public function mis_a_jour_gtm($idclients)
	{
		$id = $idclients;
		$client = $this->visuels_model->getDonneeById($id);
		$site_client = $client[0]['site_client'];
		if (!preg_match('#^https?://#i', $site_client)) {
			$site_client = 'https://' . $site_client;
		}
		$html = $this->fetch_url($site_client);
		if ($html === false) {
			die("Erreur : impossible d'accéder à l'URL $site_client");
		}
		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		if ($gtm_code != Null):
			$this->visuels_model->mis_a_jour_gtm($idclients, $gtm_code);
		endif;
		redirect('Client/application/'.$id.'?maj=ok&type=gtm');

	}
	public function mis_a_jour_cms($idclients)
	{
		$id = $idclients;
		$client = $this->visuels_model->getDonneeById($id);
		$site_client = $client[0]['site_client'];
		if (!preg_match('#^https?://#i', $site_client)) {
			$site_client = 'https://' . $site_client;
		}
		$html = $this->fetch_url($site_client);
		if ($html === false) {
			die("Erreur : impossible d'accéder à l'URL $site_client");
		}
		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		$cms = $this->detect_cms($html, $site_client);
		if ($cms !== null) {
			$this->visuels_model->mis_a_jour_cms($idclients, $cms);
		}

		redirect('Client/application/'.$id.'?maj=ok&type=cms');

	}
	public function ajout_brief()
	{
		$id = $this->input->post('idclients');
		$information_client = $this->input->post('information_client');
		$this->visuels_model->ajout_brief($id, $information_client);
		redirect('Client/onboarding/' . $id);
	}

	public function change_rappor_base()
	{
		$id = $this->input->post('idclients');
		$rapport_base = $this->input->post('rapport_base');
		$this->visuels_model->change_rapport_base($id, $rapport_base);
		redirect('Client/detail_client/' . $id);
	}


	public function change_conversions()
	{
		$id = $this->input->post('idclients');
		$rapport_conversion = $this->input->post('rapport_conversion');
		$this->visuels_model->change_rapport_conversion($id, $rapport_conversion);
		redirect('Client/detail_client/' . $id);
	}
	public function change_bilan_annuelle()
	{
		$id = $this->input->post('idclients');
		$bilan_annuele = $this->input->post('bilan_annuele');
		$this->visuels_model->change_bilan_annuele($id, $bilan_annuele);
		redirect('Client/detail_client/' . $id);
	}
	public function relance()
	{
		$id = $this->input->post('idclients');
		$statut_demande = 0;
		$id = $id;
		$this->visuels_model->change_statut_en_demande($id, $statut_demande);
		redirect('Client/detail_client/' . $id);
	}

	public function change_color()
	{
		$color_id = $this->input->post('color_id');
		$idclients = $this->input->post('idclients');

		if (!in_array($color_id, [1, 2, 3, 4])) {
			echo json_encode(['status' => 'error', 'message' => 'ID de couleur invalide']);
			return;
		}
		$this->visuels_model->update_color($idclients, $color_id);
		echo json_encode([
			'status' => 'success',
			'redirect_url' => base_url('Client/detail_client/' . $idclients)
		]);
	}
	public function date_google_meet()
	{
		$meetingDate = $this->input->post('meetingDate');
		$idclients = $this->input->post('idclients');
		$this->visuels_model->change_meetingDate($idclients, $meetingDate);
		redirect('Client/detail_client/' . $idclients);
	}
	public function upload_logo()
	{
		$idclients = $this->input->post('idclients');

		$logo = $this->file_upload_field = "logo";
		$logo_field = "logo";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));

		if ($this->upload->do_upload($logo_field)) {
			$logo = $this->path . $this->upload->data('file_name');
		} else {
			echo json_encode(['error' => $this->upload->display_errors()]);
			return;
		}


		$this->Donne_modele->updatelogo($idclients, $logo);

		redirect('Client/detail_client/' . $idclients);
	}
	public function upload_logo_campagne()
	{
		$idclients = $this->input->post('idclients');

		$logo = $this->file_upload_field = "logo";
		$logo = "";
		$this->upload->initialize($this->set_upload_options("", $_FILES["logo"]["name"]));
		if ($this->upload->do_upload('logo') != null) {

			$logo = $this->path . $this->upload->file_name;
		}
		$this->Donne_modele->updatelogo($idclients, $logo);

		echo json_encode(['success' => true, 'logo_url' => base_url($logo)]);
	}


	public function enregistrer()
	{
		$idclients = $this->input->post('idclients');
		$rating = $this->input->post('rating');

		if ($idclients && $rating) {
			$this->visuels_model->enregistrer_note($idclients, $rating);
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Données invalides']);
		}
	}

	public function resiliation()
	{
		$resiliation = $this->input->post('resiliation');
		$idclients = $this->input->post('client');
		$tm_resiliation = $this->input->post('tm');
		$date_resiliation = $this->input->post('date_resiliation');
		$demande_resiliation = $this->input->post('demande_resiliation');
		$fin_campagne = $this->input->post('fin_campagne');

		$am_resiliation = $this->input->post('am_resiliation');
		$information_resiliation = $this->input->post('information_resiliation');
		$statut_resiliation = $this->input->post('statut_resiliation');

		$idclient = $this->visuels_model->create_resiliation($resiliation, $date_resiliation, $fin_campagne, $am_resiliation, $tm_resiliation, $demande_resiliation, $information_resiliation, $statut_resiliation, $idclients);

		if ($resiliation == 1):
			$type_upsell = 2;
		endif;
		if ($resiliation == 2):
			$type_upsell = 4;
		endif;
		if ($resiliation == 3):
			$type_upsell = 5;
		endif;

		$demmande_upsell = $date_resiliation;
		$tm = $tm_resiliation;
		$date_upsell = $fin_campagne;
		$date_demande_upsell = $demmande_upsell;
		$inforamtion_upsell = $information_resiliation;
		$statut_upsell = $statut_resiliation;
		$id = intval($idclients);
		$idclients = $id;
		$donnee = $this->data["clients"] = $this->visuels_model->getDonneeById($id);
		$idonnee = $donnee[0]['idonnee'];
		$account_manager = $donnee[0]['account_manager'];
		$initiative = $donnee[0]['initiative'];
		$statut_demande = 1;
		$this->visuels_model->change_statut_en_demande($id, $statut_demande);
		$budget_initiale = $donnee[0]['budget'];
		$am = $this->input->post('am');
		$budget_initiale = intval($budget_initiale);
		$budget_upsell = intval($budget_initiale);
		$budget_finale = $budget_initiale;
		$actif = 1;
		$idupsell = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients, $actif);
		$type_tache = 1;
		if ($type_upsell == 2):
			$title = "Relance client";
			$tache = "Le client sera relancer, voir date due";
			$type_tache = 9;
			$dejaclient = 4;
			$type_upsell = 9;
			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $account_manager,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);

		endif;
		if ($type_upsell == 4):
			$title = "Mise en pause";
			$tache = "Mettre le client en pause, voir date due";
			$type_tache = 8;
			$dejaclient = 4;

			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $account_manager,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);
		endif;
		if ($type_upsell == 5):
			$title = "Résiliation";
			$tache = "Résiliation complète du client, voir date due";
			$type_tache = 7;
			$dejaclient = 5;
			$data_upsell = array(
				'idupsell' => $idupsell,
				'idclients' => $idclients,
				'dejaclient' => $dejaclient,
				'budget' => $budget_finale,
				'account_manager' => $am,
				'initiative' => $initiative,
				'type_upsell' => $type_upsell,
				'budget_upsell' => $budget_upsell

			);
			$this->visuels_model->add_upsell_onboarding($data_upsell);
		endif;
		$Statuts_technique = 1;

		$data = array(
			'idupsell' => $idupsell,
			'type_tache' => $type_tache,
			'date_demande' => $date_demande_upsell,
			'date_due' => $fin_campagne,
			'idclients' => $idclients,
			'AM' => $am_resiliation,
			'assigned_to' => $tm,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'description' => $tache

		);

		$this->Task_model->add_task($data);

		$this->session->set_flashdata('message-succes', "Client résilier avec succès");
		redirect('Client/detail_client/' . $idclients, 'refresh');
		$this->layout();
	}

	public function search()
	{

		$keyword = $this->input->post('keyword');
		$clients = $this->visuels_model->search_clients($keyword);

		$result = [];
		foreach ($clients as $client) {
			$result[] = [
				'idclients' => $client->idclients,
				'nom_client' => $client->nom_client
			];
		}

		echo json_encode($result);
	}

	public function tache_client($idclients)
	{
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$t = $this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$this->content = "layouts/client/detail/tache/index.php";
		$this->layout();
	}

	public function application($idclients)
	{
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$t = $this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$this->data['procedure_gtm'] = $this->Task_model->get_procedure_gtm($idclients);
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$this->content = "layouts/client/detail/application/index.php";
		$this->layout();
	}

	public function gtm($idclients)
	{

		$this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$t = $this->data["gtm"] = $this->visuels_model->get_gtm($idclients);
		$this->content = "layouts/client/detail/gtm/index.php";
		$this->layout();
	}
	public function get_gtm_by_id($id)
	{
		$data = $this->Gtm_model->get_by_id($id);
		echo json_encode($data);
	}
	public function update_gtm()
	{
		$id = $this->input->post('id_gtm');
		$idclients = $this->input->post('idclients');
		var_dump($idclients);
		die();
		$data = [
			'date_demande'      => $this->input->post('date_demande'),
			'invitation_reçu'   => $this->input->post('invitation_reçu'),
			'gtm'               => $this->input->post('gtm'),
			'statut'            => $this->input->post('statut'),
		];

		$this->Gtm_model->update($id, $data);

		redirect('Client/gtm/' . $idclients);
	}



	public function updateDonneeClient()
	{
		$idclient = $this->input->post('idclient');
		$idonnee = $this->input->post('idonnee');
		$client = $this->input->post('Client');
		$email_client = $this->input->post('Email_client');
		$numero_client = $this->input->post('Numero_client');
		$site_client = $this->input->post('Site_client');
		$budget = $this->input->post('budget');

		$secteur_activite = $this->input->post('secteur_activite');
		$Produit = $this->input->post('Produit');
		$Initiative = $this->input->post('Initiative');
		$Am = $this->input->post('Am');
		$mis_en_place_paiement = $this->input->post('mis_en_place_paiement');
		$Brief = $this->input->post('Brief');
		$annonce = $this->input->post('annonce');
		$commentaire_client = $this->input->post('commentaire_client') ?: NULL;
		$paiement_recu = (int) $this->input->post('paiement_recu');
		$datastudio = (int) $this->input->post('datastudio');
		$email_onboarding = (int) $this->input->post('email_onboarding');
		$facturation = (int) $this->input->post('facturation');

		$this->Donne_modele->update_client($idclient, $client, $email_client, $numero_client, $site_client);
		$this->Donne_modele->update_donnee_client(
			$budget,
			$secteur_activite,
			$Produit,
			$Initiative,
			$Am,
			$mis_en_place_paiement,
			$Brief,
			$annonce,
			$commentaire_client,
			$paiement_recu,
			$datastudio,
			$email_onboarding,
			$facturation,
			$idonnee
		);

		$this->session->set_flashdata('message-succes', "Données mises à jour avec succès");
		redirect('Onboarding', 'refresh');
	}


	public function activer_processus_tache()
	{
		$idclients = $this->input->post('idclients');
		$am = $this->input->post('am');
		$assigned_to = $this->input->post('assigned_to');
		$date = $this->input->post('date');
		$choix = $this->input->post('conversion');
		$conversion = [

			"lead" => [
				['idclients' => $idclients, 'conversion' => 'Lead - Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead - Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’envoi d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton chat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
			],

			"ecommerce" => [
				['idclients' => $idclients, 'conversion' => 'Lead | Achat', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a réalisé un achat', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le begin checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d appel téléphonique ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le téléphone', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur l email', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Contact - Chat', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a utilisé le chat pour entrer en contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du processus de commande', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité un article', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
			],

			"reservation" => [
				['idclients' => $idclients, 'conversion' => 'Lead | Réservation', 'actions' => 'Principale', 'types' => 'Purchase', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a effectué une réservation', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Formulaire Page contact', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a rempli le formulaire de contact', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Demande de devis', 'actions' => 'Principale', 'types' => 'Formulaire', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a soumis une demande de devis ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Téléphone', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’appel téléphonique', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Lead | Email', 'actions' => 'Principale', 'types' => 'Contact', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur le bouton d’email ', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Checkout', 'actions' => 'Secondaire', 'types' => 'begin_checkout', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a atteint le début du checkout', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Ajout au panier', 'actions' => 'Secondaire', 'types' => 'Add to cart', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a ajouté un article au panier', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue | Vue d\'un article', 'actions' => 'Secondaire', 'types' => 'View item', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page produit', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Page vue |', 'actions' => 'Secondaire', 'types' => 'Page_view', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a visité une page du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton | Télécharger notre catalogue', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur "Télécharger notre catalogue"', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Bouton |', 'actions' => 'Secondaire', 'types' => 'Click', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a cliqué sur un autre bouton du site', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Newsletter', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne s est inscrite à la newsletter', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
				['idclients' => $idclients, 'conversion' => 'Création de compte Client', 'actions' => 'Secondaire', 'types' => 'inscription', 'remarque' => '', 'etat' => '', 'conditions' => 'Quand une personne a créé un compte client', 'conversion_id' => '', 'conversion_label' => '', 'extensions_appel' => ''],
			]
		];

		$conversions = $conversion[$choix] ?? [];

		$this->Donne_modele->insert_conversions($conversions);
		$this->Donne_modele->update_type_clients($choix, $idclients);
		$data = [
			'idclients' => $idclients,
			'account_manager' => $assigned_to,
			'initiative' => $assigned_to,
			'conversion_type' => $conversion,
			'date_activation' => $date,
		];
		header('Content-Type: application/json');

		// DEBUG temporaire
		$debug = array(
			'POST' => $this->input->post(),
		);

		if (empty($debug['POST']['idclients']) || empty($debug['POST']['am']) || empty($debug['POST']['assigned_to']) || empty($debug['POST']['date'])) {
			$debug['error'] = 'Un ou plusieurs champs POST sont vides';
			echo json_encode($debug);
			return;
		}
		$type_tache = 3;
		$title = "Demande invitation GTM";
		$description = "Invitation et demande de mise en place GTM au Client";
		$Statuts_technique = 1;
		$procedure_gtm = 1;
		$idclients = $this->input->post('idclients');
		$am = $this->input->post('am');
		$tm = $this->input->post('assigned_to');
		$date = $this->input->post('date');

		$data = array(
			'type_tache' => $type_tache,
			'date_demande' => $date,
			'date_due' => $date,
			'idclients' => $idclients,
			'AM' => $assigned_to,
			'assigned_to' => $assigned_to,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'procedure_gtm' => $procedure_gtm,
			'description' => $description
		);

		$this->Task_model->add_task($data);



		$data_gtm = array(
			'idclients' => $idclients,
			'am' => $am,
			'tm' => $tm,
			'date_demande' => $date
		);
		$this->Gtm_model->add_gtm_process($data_gtm);

		echo json_encode(['redirect_url' => base_url('Client/application/' . $idclients)]);
	}

	public function detail_client($idclients)
	{

		$this->data['noteClient'] = $this->visuels_model->get_note_par_client($idclients);
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$this->data['budget_initial'] = $this->visuels_model->getdernierbyidclient($idclients);
		$this->data['discussion'] = $this->Discussion_model->getdiscussionbyidclient($idclients);
		$this->data["campagnes"] = $this->visuels_model->getCampagneByIdclient($idclients);
		$t = $this->data['task'] = $this->Task_model->get_task_by_id_client($idclients);
		$t = count($t);
		$this->data['nbr_task'] = $t;
		$this->data["users"] = $this->Task_model->get_all_users();
		$clients = $this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);

		$notes = $this->Note_model->get_all_by_idclients($idclients);
		foreach ($notes as $note) {

			$id_note = $note->id;
			$assigned_users = $this->Note_model->get_assigned_users($id_note);
			$note->assigned_users = $assigned_users;
		}
		$this->data['notes'] = $notes;

		$latestByMonth = [];

		$clientUpsells = $this->visuels_model->getupsell();
		foreach ($clientUpsells as $upsell) {

			$monthIndex = (int)date('n', strtotime($upsell->date_upsell)) - 1; // 0-based index
			$dateTimestamp = strtotime($upsell->date_upsell);

			// Keep only latest date per month
			if (!isset($latestByMonth[$monthIndex]) || $dateTimestamp > strtotime($latestByMonth[$monthIndex]['date'])) {
				$latestByMonth[$monthIndex] = [
					'date' => $upsell->date_upsell,
					'budget' => $upsell->budgets
				];
			}
		}

		$this->content = "layouts/client/detail/index.php";
		$this->layout();
	}
	public function update_campagne($idclients)
{
    $id_campagne = intval($this->input->post('id_campagne'));

    if (!$id_campagne) {
        show_error("Identifiant de campagne manquant", 400);
        return;
    }

    // Récupération des champs principaux
    $data = [
        'nom_campagne'          => $this->input->post('nom_campagne_search'),
        'url_site'                   => $this->input->post('url_campagne'),
        'information_campagne'  => $this->input->post('information_campagne_search'),
        'repartition_budget'    => $this->input->post('repartition_budget_search'),
        'zones'                 => $this->input->post('zone_search'),
        'langue'                => $this->input->post('langue'),
        'cible'                 => $this->input->post('cible'),
        'age'                   => $this->input->post('age'),
        'sexe'                  => $this->input->post('sexe'),
        'date_campagne'         => $this->input->post('date_campagne'),
        'audience'              => $this->input->post('audience'),
        'appareil'              => $this->input->post('appareil'),
        'youtube'               => $this->input->post('Youtube')
    ];

    // Mise à jour de la campagne principale
    $this->visuels_model->update_campagne($id_campagne, $data);

    // Gestion des groupes d’annonces
    $groupes = $this->input->post('groupe_annonce');
    $contextes = $this->input->post('contexte_groupe_annonce');
    $keywords = $this->input->post('Mot_cle');

    if (!empty($groupes)) {
        $this->Donne_modele->delete_gp_by_idcampagne($id_campagne);
        foreach ($groupes as $i => $nom) {
    if (trim($nom) === '') continue;

    $this->Donne_modele->insert_gp_update([
        'idcampagne'  => $id_campagne,
        'nom_groupe'  => $nom,
        'contexte_groupes_annonces' => $contextes[$i] ?? '',
        'mot_cle'     => $keywords[$i] ?? '',
        'idclients'   => $idclients
    ]);
}

    }

    // Mots-clés à exclure
    $mots_exclus = $this->input->post('Mots_cle_exclus');
    if ($mots_exclus !== null) {
        $this->visuels_model->update_exclusion_by_client($idclients, $exclusion);
    }
	$campagne['images'] = $this->Image_model->get_images_by_campagne($campagne['idcampagne']) ?: [];

				foreach ($campagne['images'] as &$img) {
					if (!empty($img->image_url)) {
						if (file_exists(FCPATH . $img->image_url)) {
							$img->final_url = base_url($img->image_url);
						} else {
							$img->final_url = $img->image_url;
						}
					} else {
						$img->final_url = base_url('assets/images/placeholder.jpg');
					}
				}

				unset($img);
    // Redirection
    $this->session->set_flashdata('success', 'Campagne mise à jour avec succès.');
    redirect('Client/onboarding/' . $idclients);
}
public function update_brief()
{
    $idcampagne = $this->input->post('idcampagne');
    $information = $this->input->post('information_campagne');

    if (!$idcampagne || !$information) {
        show_error('Données invalides', 400);
    }

    $this->db->where('idcampagne', $idcampagne);
    $this->db->update('campagne', ['information_campagne' => $information]);

    echo json_encode(['success' => true]);
}


	public function onboarding($idclients)
	{

		$type_campagne = [
			1	=> "SEARCH",
			2	=>	"LOCAL",
			3	=>	"PERFORMANCE MAX"
		];
		$this->data['idclients'] = $idclients;
		$this->data["donnees"] = $this->visuels_model->getDonneeById($idclients);
		$this->data['upsell'] = $this->visuels_model->getupsellbyidclient($idclients);
		$campagnes = $this->data["campagnes"] = $this->visuels_model->getCampagneByIdclient($idclients);
		$campagnes = $this->visuels_model->getCampagneByIdclient($idclients);

		foreach ($campagnes as $index => $campagne) {
			$campagnes[$index]['type_campagne'] = $type_campagne[$campagne['type_campagne']];
		}

		$this->data['campagnes'] = $campagnes;
		$donne_valider = $this->Donne_modele->getcclientvalidationbyidclients($idclients);
		$groupe_valider = $this->Donne_modele->getcampagnegroupevalidationbyidclients($idclients);
		$groupes_par_campagne = [];

		foreach ($groupe_valider as $groupe) {
			$idcampagne = $groupe['idcampagne'];
			if (!isset($groupes_par_campagne[$idcampagne])) {
				$groupes_par_campagne[$idcampagne] = [];
			}
			$groupes_par_campagne[$idcampagne][] = $groupe;
		}

		foreach ($donne_valider as &$campagne) {
			$idcampagne = $campagne['idcampagne'];
			$campagne['groupes_annonces'] = isset($groupes_par_campagne[$idcampagne]) ? $groupes_par_campagne[$idcampagne] : [];
		}
		unset($campagne);
		$this->data['donne_valider'] = $donne_valider;
		$this->data['groupe_valider'] = $groupe_valider;
		
		$this->data['procedure_gtm'] = $this->Task_model->get_procedure_gtm($idclients);
		if(!empty($idcampagne)){
			$this->data['extensions'] = $this->Donne_modele->get_extensions_by_campagne($idcampagne);
		}	

		$this->content = "layouts/client/onboarding/index.php";
		$this->layout();
	}
	public function campagne_edit($idclients)
{
    $id_campagne = intval($this->input->get('id_camp'));

    if (!$id_campagne) {
        show_error("Aucune campagne spécifiée.", 404);
        return;
    }

    // Récupère les infos du client
    $d = $this->visuels_model->getDonneeById($idclients);
    $this->data['donnees'] = $d;

    // Récupère la campagne existante
    $campagne = $this->visuels_model->getCampagneById($id_campagne);
    if (!$campagne) {
        show_error("Campagne introuvable.", 404);
        return;
    }

    // Récupère les groupes d'annonces associés
    $groupes_annonces = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);

    // Récupère les exclusions associées
    $mots_exclus = $this->visuels_model->get_exclusions($idclients);

    // Récupère éventuellement les images
    $site_client = $d[0]['site_client'] ?? '';
    $images_site = []; // tu peux appeler ici fetch_all_images_from_site($site_client, 8) si tu veux.

    // Remplissage des données pour la vue
    $this->data['idclients'] = $idclients;
    $this->data['id_camp'] = $id_campagne;
    $this->data['campagne'] = $campagne;
    $this->data['groupes_annonces'] = $groupes_annonces;
    $this->data['mots_exclus'] = $mots_exclus;
    $this->data['images_site'] = $images_site;
    $this->data['site_client'] = $site_client;

    // Vue correspondante
    $this->content = "layouts/client/onboarding/search_edit.php";
    $this->layout();
}


	public function campagne($idclients)
	{
		$type_page = [
			1 => "search",
			2 => "local",
			3 => "pmax"
		];

		$this->data['idclients'] = $idclients;
		$d = $this->visuels_model->getDonneeById($idclients);
		$id_campagne = intval($this->input->get('id_camp'));
		$information_client = $d->information ?? '';
		$site_client = $d[0]['site_client'];
		//$images_site = $this->fetch_all_images_from_site($site_client, 8);
		if ($id_campagne) {
			$campagne = $this->data['campagne'] = $this->visuels_model->getCampagneById($id_campagne);
			$camp_type = $campagne->type_campagne;

			$this->data['id_camp'] = $id_campagne;
			$this->data['mots_exclus'] = "Test";
			$groupes_annonces = $this->data['groupes_annonces'] = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);
		} else {

			$this->data['conversion'] = $this->input->get('conversion');
			$this->data['camp_type'] = $camp_type = $this->input->get('camp_type');
			$this->data['gtm'] = $this->input->get('gtm');



			//$raw_keywords = $this->call_openai($prompt);
			//$raw_keywords = trim($raw_keywords);
			//if (preg_match('/([a-zA-ZÀ-ÿ0-9,\s]+)/', $raw_keywords, $matches)) {
			// $raw_keywords = $matches[1];
			//}
			//$clean_keywords = preg_replace('/,\s*/', "\n", $raw_keywords);

			//$this->data["mots_exclus"] = "test";
		}

		$this->data["donnees"] = $d;

		$site_client = $d[0]['site_client'] ?? '';
		//$images_site = $this->fetch_all_images_from_site($site_client, 8);
		//$this->data["images_site"] = $images_site;
		$this->data["site_client"] = $site_client;
		$this->data['procedure_gtm'] = $this->Task_model->get_procedure_gtm($idclients);
		$this->data['images_site'] = [];
		//$campagne = $this->visuels_model->get_mot_clé($idclients);
		//$mots_exclus = $campagne[]
		//$this->data["mots_exclus"]
		$this->data["mots_exclus"] = $this->visuels_model->get_exclusions($idclients);
		$this->content = "layouts/client/onboarding/" . $type_page[$camp_type] . ".php";
		$this->layout();
	}
	public function fetch_images_campagne()
	{
		$url = $this->input->post('url');
		$images = [];

		if (!empty($url)) {
			// Utilise ta fonction existante pour récupérer les images
			$images = $this->fetch_all_images_from_site($url, 15);
		}

		echo json_encode([
			'success' => !empty($images),
			'images'  => $images
		]);
	}

	public function information_campagne($idclients)
	{
		$url = $this->input->post('url');
		//$url ="https://www.florenthamon.com/hypnose/";
		if (!$url) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'URL manquante.']));
		}
		$summary = $this->get_information_campagne_from_chatgpt($url);
		
		$response = trim($summary);
		//var_dump($response);
		//die();
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(['status' => 'success', 'data' => $response]));
	}


	public function get_mot_cle_a_exclure($idclients)
{
	$campagne_info = '';

$info_post = $this->input->post('information_campagne_search', true);
$pmax_post = $this->input->post('information_campagne_pmax', true);

if (!empty($info_post)) {
    $campagne_info = trim((string) $info_post);
} elseif (!empty($pmax_post)) {
    $campagne_info = trim((string) $pmax_post);
}


	

    if ($campagne_info === '') {
        return $this->output
            ->set_content_type('application/json; charset=utf-8')
            ->set_output(json_encode(['status' => 'error', 'message' => 'Aucune information de campagne reçue.']));
    }

    $prompt = "Tu es un expert Google Ads.
	Génère une liste de 60 mots-clés à exclure pour la Google Ads concernant ce Brief.
	Voici le Brief de la campagne :

	$campagne_info
	NB: Exclus moi les mots à exlure qui n'ont rien à voir avec le brief

	Même si les informations sont partielles, propose une liste pertinente et standard de mots-clés à exclure en français pour éviter les recherches non qualifiées.
	Donne UNIQUEMENT les mots, séparés par des virgules, sans introduction ni phrase explicative.";

    $raw_keywords = (string) $this->call_openai($prompt);
    $raw_keywords = trim($raw_keywords);

    // Récupère seulement lettres/chiffres/accents/virgules/espaces/+/-
    if (preg_match('/([0-9A-Za-zÀ-ÖØ-öø-ÿÉÈÊËéèêëÀÂÄàâäÎÏîïÔÖôöÛÜûüÇç\'"’„”«»+\\-_,.\\s]+)/u', $raw_keywords, $m)) {
        $raw_keywords = $m[1];
    }

    // Remplace retours à la ligne / point-virgule par des virgules
    $raw_keywords = preg_replace('/[;\r\n]+/u', ',', $raw_keywords);

    // Split, trim, déduplique (case-insensitive) et filtre les vides
    $items = array_filter(array_map('trim', explode(',', $raw_keywords)), function ($v) {
        return $v !== '';
    });

    // Déduplication insensible à la casse/accents
    $seen = [];
    $dedup = [];
    foreach ($items as $kw) {
        $key = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $kw));
        if (!isset($seen[$key])) {
            $seen[$key] = true;
            $dedup[] = $kw;
        }
    }

    // Limite à 60 lignes max
    $dedup = array_slice($dedup, 0, 60);

    // Sortie : une par ligne
    $clean_keywords = implode("\n", $dedup);

    $payload = [
        'status' => 'success',
        'data'   => $clean_keywords,
        // Décommente si tu régénères CSRF à chaque requête AJAX
        // 'csrfName' => $this->security->get_csrf_token_name(),
        // 'csrfHash' => $this->security->get_csrf_hash(),
    ];

    return $this->output
        ->set_content_type('application/json; charset=utf-8')
        ->set_output(json_encode($payload));
}
public function get_mots_cle_depuis_url($idclients)
{
    $url      = trim((string) $this->input->post('url'));
    $langue   = trim((string) $this->input->post('langue'));   // 'fr' ou 'en'
    $zone     = trim((string) $this->input->post('zone'));
    $services = trim((string) $this->input->post('services'));

    if ($url === '') {
        return $this->output
            ->set_content_type('application/json; charset=utf-8')
            ->set_output(json_encode(['status' => 'error', 'message' => 'URL manquante.']));
    }

    // Prompt : on demande des mots-clés pertinents pour Search (exact/expressions implicites),
    // une ligne par mot-clé, en langue choisie, contextualisés par zone/services si fournis.
    $lang_label = ($langue === 'en') ? 'anglais' : 'français';
    $prompt = "Tu es un expert Google Ads (réseau de recherche).
Je te donne l'URL du site d'un client : $url
Contexte additionnel (facultatif) :
- Zone géographique : " . ($zone ?: 'non spécifiée') . "
- Produits/Services : " . ($services ?: 'non spécifiés') . "

Objectif : Propose entre 5 mots-clés pertinents pour une campagne Google Ads Search.
Contraintes :
- Donne UNIQUEMENT la liste, un mot-clé par ligne (pas de numéros, pas d'introduction).
- Mots-clés en $lang_label.
- Mélange d'intentions haut/milieu de funnel, incluant quelques requêtes de marque si pertinentes.
- Évite les requêtes trop génériques et les requêtes non qualifiées (pas d'emplois, gratuit, tuto, formation, pdf, etc.).
- N'ajoute pas de variantes exactes/broad modifiées explicitement (pas de guillemets, pas de +), juste le texte du mot-clé.";

    // Option simple : laisser le modèle inférer à partir de l'URL (il peut parcourir si tools browsing côté backend).
    // Si tu as déjà un helper qui résume la page : $info = $this->get_information_campagne_from_chatgpt($url); et tu peux l'ajouter au prompt.

    $raw = (string) $this->call_openai($prompt);
    $raw = trim($raw);

    // Normalisation douce : accepte lettres/chiffres/accents/espaces/+-'"/,.
    if (preg_match('/([0-9A-Za-zÀ-ÖØ-öø-ÿÉÈÊËéèêëÀÂÄàâäÎÏîïÔÖôöÛÜûüÇç\'"’„”«»+\\-_,.\\s]+)/u', $raw, $m)) {
        $raw = $m[1];
    }

    // Uniformise séparateurs : transforme virgules/semicolon en retours à la ligne
    $raw = preg_replace('/[;,]+/u', "\n", $raw);

    // Split lignes, trim, filtre vides
    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw)), function ($v) {
        return $v !== '';
    });

    // Dédup insensible à la casse/accents
    $seen = [];
    $dedup = [];
    foreach ($lines as $kw) {
        $key = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $kw));
        if (!isset($seen[$key])) {
            $seen[$key] = true;
            $dedup[] = $kw;
        }
    }

    // Clamp 120 max
    $dedup = array_slice($dedup, 0, 120);

    $payload = [
        'status' => 'success',
        'data'   => implode("\n", $dedup),
        // Si tu régénères le CSRF à chaque requête AJAX, renvoie-les :
        // 'csrfName' => $this->security->get_csrf_token_name(),
        // 'csrfHash' => $this->security->get_csrf_hash(),
    ];

    return $this->output
        ->set_content_type('application/json; charset=utf-8')
        ->set_output(json_encode($payload));
}


	public function ajout_campagne($idclients)
	{
		$id_campagne = $this->input->get('id_camp');
		if ($id_campagne) {
			$campagne = $this->data['campagne'] = $this->visuels_model->getCampagneById($id_campagne);
			$camp_type = $campagne->type_campagne;
		} else {
			$camp_type = $this->input->get('camp_type');
		}

		switch ($camp_type) {

			case 1:
				// Inputs spécifiques
				$nom_campagne          	= $this->input->post('nom_campagne_search'); // not in view
				$information_campagne  	= $this->input->post('information_campagne_search'); // not in view
				$ages				   = $this->input->post('age');
				$cible				   = $this->input->post('cible');
				$zones                 	= $this->input->post('zone_search'); // OK
				$repartition_budget    	= $this->input->post('repartition_budget_search'); // OK
				$date_campagne         	= $this->input->post('date_campagne'); // not in view
				$appareil              	= $this->input->post('appareil'); // OK
				$objectif              	= $this->input->post('objectif'); // not in view
				$url_site              	= $this->input->post('url_campagne'); // OK
				$groupes_annonces      	= $this->input->post('groupe_annonce'); // OK
				$contexte_groupes      	= $this->input->post('contexte_groupe_annonce'); // not in view
				$mots_cle              	= $this->input->post('Mot_cle'); // OK
				$selected_images		= $this->input->post('selected_images');
				$sexe			      	= $this->input->post('sexe');
				$promotions            	= $this->input->post('promotions');
				$prix			       	= $this->input->post('prix');
				$téléphone				= $this->input->post('téléphone');


				// Vérification cohérence
				if (count($groupes_annonces) == count($contexte_groupes) && count($groupes_annonces) == count($mots_cle)) {

					if ($id_campagne) {


						$id_campagne = $this->Donne_modele->insert_campagne_am(
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
							$sexe,
							$promotions,
							$prix,
							$téléphone
						);


						/** Supprimer d'abord tous les groupes */
						$groupes_campagnes = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);
						foreach ($groupes_campagnes as $groupe_campagne) {
							$this->Donne_modele->deletegroupecampagne($groupe_campagne['idgroupe_annonce']);
						}
					} else {

						$id_campagne = $this->Donne_modele->insert_campagne_am(
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
							$sexe,
							$promotions,
							$prix,
							$téléphone
						);
					}

					// Data groupes
					$data_groups = [];
					foreach ($groupes_annonces as $index => $groupe) {
						$data_groups[] = [
							'groupe_annonce'         	=>	$groupe,
							'contexte_groupe_annonce' 	=>	$contexte_groupes[$index] ?? '',
							'mot_cle'                	=>	$mots_cle[$index] ?? '',
							'url_groupe_annonce'     	=>	$url_site,
							'idcampagne'             	=>	$id_campagne,
							'idclient'               	=>	$idclients,
							'camp_type'          		=>	$camp_type
						];
					}
					//var_dump($data_groups);
					$this->Donne_modele->insert_gp($data_groups, $id_campagne, $idclients, $camp_type);
					if ($selected_images) {
						$selected_images_array = explode(',', $selected_images);
						$idgroupe_annonce = 0;
						$inserted_count = $this->Image_model->insert_images($selected_images_array, $idclients, $id_campagne, $idgroupe_annonce);
					}
				} else {
					echo 'Erreur : Le nombre de groupes d\'annonces, de contextes et de mots-clés ne correspond pas.';
				}
				break;

			case 2: //local
				// Inputs spécifiques
				$nom_campagne          = $this->input->post('nom_campagne_pmax');
				$information_campagne  = $this->input->post('information_campagne_search');
				$ages				   = $this->input->post('age');
				$cible				   = $this->input->post('cible');
				$url_site              = $this->input->post('url_campagne');
				$repartition_budget    = $this->input->post('repartition_budget_pmax');
				$zones                 = $this->input->post('zone_search');
				$nom_groupe_pmax       = $this->input->post('nom_groupe_pmax');
				$date_campagne         = $this->input->post('date_campagne');
				$appareil              = $this->input->post('appareil');
				$objectif              = $this->input->post('objectif_pmax');
				$Mots_cle_potentiels   = $this->input->post('Mot_cle_pmax');
				$information_client    = $this->input->post('information_client_pmax');
				$contextes_client      = $this->input->post('contextes_client_pmax');
				$choix                 = $this->input->get('conversion');
				$groupes_annonces      = $this->input->post('groupe_annonce'); // OK
				$contexte_groupes      = $this->input->post('contexte_groupe_annonce'); // not in view
				$mots_cle              = $this->input->post('Mot_cle'); // OK
				$sexe			      	= $this->input->post('sexe');
				$promotions            	= $this->input->post('promotions');
				$prix			       	= $this->input->post('prix');
				$téléphone				= $this->input->post('téléphone');
				$magasin            	= $this->input->post('magasin');
				$services			       	= $this->input->post('services');
				$produit				= $this->input->post('produit');
				$youtube				= $this->input->post('Youtube');
				$id_campagne = $this->Donne_modele->insert_campagne_am(
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
					$sexe,
					$promotions,
					$prix,
					$téléphone
				);

				// Insert groupe pmax
				//$this->Donne_modele->insert_gppmax($idclients, $nom_groupe_pmax, $camp_type, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client);
				
						$data_groups = [
						'nom_groupe'         	=>	$groupes_annonces,
						'contexte_groupes_annonces' 	=>	$contexte_groupes,
						'mot_cle'                	=>	$mots_cle,
						'url_groupe_annonce'     	=>	$url_site,
						'idcampagne'             	=>	$id_campagne,
						'idclients'               	=>	$idclients,
						'type_campagnes'          	=>	$camp_type
					];
				$this->Donne_modele->insert_gp_pmax($data_groups);	
				break;

			case 3:
				// Inputs spécifiques
				$nom_campagne          = $this->input->post('nom_campagne_pmax');
				$information_campagne  = $this->input->post('information_campagne_pmax');
				$ages				   = $this->input->post('age');
				$cible				   = $this->input->post('cible');
				$url_site              = $this->input->post('url_campagne');
				$repartition_budget    = $this->input->post('repartition_budget_pmax');
				$zones                 = $this->input->post('zone_search');
				$nom_groupe_pmax       = $this->input->post('nom_groupe_pmax');
				$date_campagne         = $this->input->post('date_campagne');
				$appareil              = $this->input->post('appareil');
				$objectif              = $this->input->post('objectif_pmax');
				$Mots_cle_potentiels   = $this->input->post('Mot_cle_pmax');
				$information_client    = $this->input->post('information_client_pmax');
				$contextes_client      = $this->input->post('contextes_client_pmax');
				$choix                 = $this->input->get('conversion');
				$groupes_annonces      = $this->input->post('groupe_annonce'); // OK
				$contexte_groupes      = $this->input->post('contexte_groupe_annonce'); // not in view
				$mots_cle              = $this->input->post('Mot_cle'); // OK
				$sexe			      	= $this->input->post('sexe');
				$promotions            	= $this->input->post('promotions');
				$prix			       	= $this->input->post('prix');
				$téléphone				= $this->input->post('téléphone');
				$id_campagne = $this->Donne_modele->insert_campagne_am(
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
					$sexe,
					$promotions,
					$prix,
					$téléphone
				);

				// Insert groupe pmax
				//$this->Donne_modele->insert_gppmax($idclients, $nom_groupe_pmax, $camp_type, $url_site, $Mots_cle_potentiels, $idcampagne, $contextes_client);
				$this->Donne_modele->update_type_clients($choix, $idclients);
				$data_groups = [
					'nom_groupe'         	=>	$groupes_annonces,
					'contexte_groupes_annonces' 	=>	$contexte_groupes,
					'mot_cle'                	=>	$mots_cle,
					'url_groupe_annonce'     	=>	$url_site,
					'idcampagne'             	=>	$id_campagne,
					'idclients'               	=>	$idclients,
					'type_campagnes'          	=>	$camp_type
				];
				$this->Donne_modele->insert_gp_pmax($data_groups);
				//$exclusion = $this->input->post('Mots_cle_exclus');

				break;
		}
		$selectedImages = $this->input->post('selectedImages');
		$imagesArray = array_filter(array_map('trim', explode(',', $selectedImages)));
		$idcampagne = $id_campagne;
		$idgroupe_annonce = 0;
		$this->Image_model->insert_images($imagesArray, $idclients, $idcampagne, $idgroupe_annonce);
		$exclusion = $this->input->post('Mots_cle_exclus');
		
		$id = $idclients;
		$this->visuels_model->exclusion($id, $exclusion);
		
		$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
		redirect('Client/onboarding/' . $idclients, 'refresh');

		// $this->layout();
	}
	public function generate_group_keywords_url_context($idclients)
{
    $url       = trim((string) $this->input->post('url_campagne'));
    $contexte  = trim((string) $this->input->post('contexte'));
    $nomGroupe = trim((string) $this->input->post('nom_groupe'));

    if ($url === '') {
        return $this->output->set_content_type('application/json; charset=utf-8')
            ->set_output(json_encode(['status' => 'error', 'message' => 'URL manquante.']));
    }

    // Langue : si tu as un <select name="langue"> côté vue, tu peux aussi la poster. Ici on force FR.
    $prompt = "Tu es un expert Google Ads (réseau Search).
Objectif : Générer une liste de mots-clés pertinents pour un groupe d'annonce, en français.

Données :
- URL du site : $url
- Nom du groupe : " . ($nomGroupe ?: 'non spécifié') . "
- Contexte du groupe : " . ($contexte ?: 'non spécifié') . "

Attendus :
- Donne UNIQUEMENT la liste, un mot-clé par ligne (pas de numéros, pas d'introduction).
- Entre 5 et 10 mots-clés.
- Mélange d'intentions hautes et milieu de tunnel, focalisés sur le contexte du groupe.
- Évite les requêtes non qualifiées (emploi, gratuit, tutoriel, pdf, occasion, réparation si HS, etc.).
- Pas de guillemets, pas de +, pas de [].";

    // (Optionnel) enrichir avec ton résumé du site :
    // $site_info = $this->get_information_campagne_from_chatgpt($url);
    // $prompt .= \"\\n\\nRésumé du site :\\n$site_info\";

    $raw = (string) $this->call_openai($prompt);
    $raw = trim($raw);

    // Filtrage caractères plausibles puis normalisation en lignes
    if (preg_match('/([0-9A-Za-zÀ-ÖØ-öø-ÿÉÈÊËéèêëÀÂÄàâäÎÏîïÔÖôöÛÜûüÇç\'\"’„”«»+\\-_,.\\s]+)/u', $raw, $m)) {
        $raw = $m[1];
    }
    $raw = preg_replace('/[;,]+/u', "\n", $raw);
    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw)), function ($v) { return $v !== ''; });

    // Dédup insensible casse/accents
    $seen = [];
    $dedup = [];
    foreach ($lines as $kw) {
        $key = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $kw));
        if (!isset($seen[$key])) { $seen[$key] = true; $dedup[] = $kw; }
    }

    // Limite 80
    $dedup = array_slice($dedup, 0, 80);

    $payload = [
        'status' => 'success',
        'data'   => implode("\n", $dedup),
        // 'csrfName' => $this->security->get_csrf_token_name(),
        // 'csrfHash' => $this->security->get_csrf_hash(),
    ];

    return $this->output
        ->set_content_type('application/json; charset=utf-8')
        ->set_output(json_encode($payload));
}


	public function supprimer_campagne($id_campagne)
	{

		$campagne = $this->data['campagne'] = $this->visuels_model->getCampagneById($id_campagne);
		$groupes_annonces = $this->Donne_modele->get_gp_by_idcampagne($id_campagne);
		$idclients = $groupes_annonces[0]['idclients'];

		foreach ($groupes_annonces as $groupe_annonce) {
			$this->Donne_modele->deletegroupe($groupe_annonce['idgroupe_annonce']);
		}

		$this->Donne_modele->deletecampagne($id_campagne);
		$this->session->set_flashdata('success', 'Campagne ajouter avec succès.');
		redirect('Client/onboarding/' . $idclients, 'refresh');
	}

	public function groupe_annonce($id_campagne, $id_groupe) {}

	private function fetch_all_images_from_site($site_url, $max_images = 8, $max_pages = 20)
	{
		if (!preg_match('#^https?://#', $site_url)) {
			$site_url = 'http://' . $site_url;
		}

		$visited = [];
		$to_visit = [$site_url];
		$images = [];

		while (!empty($to_visit) && count($visited) < $max_pages && count($images) < $max_images) {
			$current_url = array_shift($to_visit);
			if (isset($visited[$current_url])) continue;
			$visited[$current_url] = true;

			$html = @file_get_contents($current_url);
			if (!$html) continue;

			// 1. Extraire les images
			$img_urls = $this->extract_image_urls($html, $current_url);
			foreach ($img_urls as $img_url) {
				if ($this->looks_like_logo_or_icon($img_url) || $this->is_data_uri($img_url)) continue;

				$meta = $this->get_image_metadata($img_url);
				if (!$meta) continue;

				if (!$this->is_photo_mime($meta['mime'])) continue;
				if ($meta['width'] < 150 || $meta['height'] < 150) continue;

				$images[] = $img_url;
				if (count($images) >= $max_images) break 2;
			}

			// 2. Extraire les liens internes pour crawler
			$dom = new DOMDocument();
			libxml_use_internal_errors(true);
			$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);
			$links = $xpath->query('//a[@href]');
			foreach ($links as $link) {
				$href = $link->getAttribute('href');
				$url = $this->resolve_url($href, $current_url);
				if (!$this->is_internal_link($url, $site_url)) continue;
				if (!isset($visited[$url]) && !in_array($url, $to_visit)) {
					$to_visit[] = $url;
				}
			}
		}

		return array_slice($images, 0, $max_images);
	}

	private function fetch_images_from_site($site_url, $max_images = 8)
	{
		$site_url = trim($site_url);
		if (empty($site_url)) return [];

		if (!preg_match('#^https?://#', $site_url)) {
			$site_url = 'http://' . $site_url;
		}

		$html = @file_get_contents($site_url);
		if (!$html) return [];

		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$imgs = $xpath->query('//img');
		$images = [];

		foreach ($imgs as $img) {
			$src = $img->getAttribute('src');
			if (!$src) continue;

			// ignore logos/icônes
			$src_lc = strtolower($src);
			if (strpos($src_lc, 'logo') !== false || strpos($src_lc, 'icon') !== false || strpos($src_lc, 'svg') !== false) {
				continue;
			}

			// construire l'URL absolue
			$img_url = $this->resolve_url($src, $site_url);

			// vérifie si l’image est valide
			$img_info = @getimagesize($img_url);
			if (!$img_info || $img_info[0] < 150 || $img_info[1] < 150) continue;

			$images[] = $img_url;

			if (count($images) >= $max_images) break;
		}

		return $images;
	}

	private function resolve_url($relative, $base)
	{
		if (empty($relative)) return '';

		// ignore les data:uri
		if (preg_match('#^data:#', $relative)) return '';
		if (preg_match('#^https?://#', $relative)) return $relative;
		if (strpos($relative, '//') === 0) {
			$scheme = parse_url($base, PHP_URL_SCHEME) ?: 'http';
			return $scheme . ':' . $relative;
		}

		// gestion des chemins relatifs
		$parsed_base = parse_url($base);
		$scheme = $parsed_base['scheme'] ?? 'http';
		$host = $parsed_base['host'] ?? '';
		$base_path = rtrim(dirname($parsed_base['path'] ?? '/'), '/');

		$path = ($relative[0] === '/') ? $relative : $base_path . '/' . $relative;

		return $scheme . '://' . $host . '/' . ltrim($path, '/');
	}

	private function extract_image_urls($html, $base_url)
	{
		$urls = [];
		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);

		// <img src>
		$imgs = $dom->getElementsByTagName('img');
		foreach ($imgs as $img) {
			$src = $img->getAttribute('src');
			if (!$src) continue;
			$urls[] = $this->resolve_url($src, $base_url);
			// srcset handling: prend la plus grande candidate si existe
			$srcset = $img->getAttribute('srcset');
			if ($srcset) {
				$best = $this->pick_best_from_srcset($srcset, $base_url);
				if ($best) $urls[] = $best;
			}
		}

		// inline styles background-image: url(...)
		$xpath = new DOMXPath($dom);
		$nodes = $xpath->query('//*[@style]');
		foreach ($nodes as $node) {
			$style = $node->getAttribute('style');
			if (preg_match_all('/background(?:-image)?:\s*url\((["\']?)(.*?)\1\)/i', $style, $m)) {
				foreach ($m[2] as $bg) {
					$urls[] = $this->resolve_url($bg, $base_url);
				}
			}
		}

		return array_values(array_unique($urls));
	}

	private function pick_best_from_srcset($srcset, $base_url)
	{
		// srcset format: url1 1x, url2 2x, or url w, ...
		$parts = preg_split('/\s*,\s*/', trim($srcset));
		$bestUrl = null;
		$bestScore = 0;
		foreach ($parts as $p) {
			// "url 2x" or "url 300w" or just "url"
			$sub = preg_split('/\s+/', trim($p));
			$url = $sub[0];
			$score = 1;
			if (isset($sub[1])) {
				if (strpos($sub[1], 'w') !== false) {
					$score = intval($sub[1]);
				} elseif (strpos($sub[1], 'x') !== false) {
					$score = floatval($sub[1]) * 1000;
				}
			}
			if ($score > $bestScore) {
				$bestScore = $score;
				$bestUrl = $url;
			}
		}
		return $bestUrl ? $this->resolve_url($bestUrl, $base_url) : null;
	}

	private function is_internal_link($url, $base)
	{
		$uHost = parse_url($url, PHP_URL_HOST);
		$bHost = parse_url($base, PHP_URL_HOST);
		return $uHost && $bHost && (strcasecmp($uHost, $bHost) === 0);
	}

	private function looks_like_logo_or_icon($url)
	{
		$lower = strtolower($url);
		// mots courants pour logos/icônes
		$bad_words = ['logo', 'icon', 'sprite', 'favicon', 'badge', 'btn', 'spacer', 'pixel', 'placeholder', 'thumb', 'avatar'];
		foreach ($bad_words as $w) {
			if (strpos($lower, '/' . $w) !== false) return true;
			if (strpos($lower, '-' . $w) !== false) return true;
			if (strpos($lower, '_' . $w) !== false) return true;
			if (strpos($lower, $w . '.') !== false) return true;
		}
		// svg files often logos/illustrations — on peut exclure si souhaité
		if (preg_match('/\.svg(\?|$)/i', $lower)) return true;
		return false;
	}

	private function is_data_uri($s)
	{
		return preg_match('#^data:#i', $s);
	}

	private function is_photo_mime($mime)
	{
		// accepter jpg/png/webp/gif (gif peut être animé)
		$allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
		return in_array(strtolower($mime), $allowed);
	}

	private function get_image_metadata($img_url)
	{
		// tente HEAD pour obtenir content-type et content-length
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $img_url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SiteImageBot/1.0)');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ctype = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		$clen = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		curl_close($ch);
		if ($http >= 400) return false;

		// si content-type absent ou pas image, on essaie de télécharger les premiers octets
		$mime = $ctype ?: '';
		// pour récupérer width/height, on télécharge un bloc
		$imgData = $this->fetch_partial($img_url, 0, 200000); // 200KB max
		if ($imgData === false) return false;

		// utilise getimagesizefromstring pour obtenir dims
		$info = @getimagesizefromstring($imgData);
		if ($info === false) return false;
		$width = $info[0];
		$height = $info[1];
		$mime_from_info = $info['mime'] ?? null;
		if (empty($mime) && $mime_from_info) $mime = $mime_from_info;

		// taille en octets : si content-length dispo, sinon length du blob (estimation)
		$filesize = ($clen > 0) ? $clen : strlen($imgData);

		return [
			'width' => intval($width),
			'height' => intval($height),
			'mime' => $mime ?: 'application/octet-stream',
			'filesize' => intval($filesize)
		];
	}

	private function fetch_partial($url, $start = 0, $maxBytes = 200000)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RANGE, "$start-" . ($start + $maxBytes - 1));
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SiteImageBot/1.0)');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($http >= 400) return false;
		return $data;
	}
	public function generer_mots_exclus()
	{
		$information_client = $this->input->post('information_client');
		$site_client = $this->input->post('site_client');

		$prompt = "À partir de ces informations : $information_client 
        et en analysant le site : $site_client, génère une liste de 60 mots-clés à exclure pour une campagne Google Ads (type search). 
        Ne donne que les mots, séparés par des virgules ou des retours à la ligne.";

		$response = $this->call_openai($prompt);

		echo $response ? nl2br(htmlspecialchars($response)) : "❌ Erreur lors de la génération.";
	}

	private function call_openai($prompt)
	{
		$url = "https://api.openai.com/v1/chat/completions";
		$data = [
			"model" => "gpt-4o-mini",
			"messages" => [
				["role" => "system", "content" => "Tu es un expert Google Ads."],
				["role" => "user", "content" => $prompt]
			],
			"temperature" => 0.7
		];

		$headers = [
			"Content-Type: application/json",
			"Authorization: Bearer " . getenv('CHAT_GPT_API_KEY')
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$result = curl_exec($ch);

		if (curl_errno($ch)) {
			log_message('error', 'Erreur CURL OpenAI: ' . curl_error($ch));
		}

		curl_close($ch);

		if ($result) {
			$json = json_decode($result, true);
			return $json['choices'][0]['message']['content'] ?? null;
		}

		return null;
	}

	public function creer_upsell()
	{
		// Récupération des données
		$type_upsell          = $this->input->post('type_upsell');
		$demmande_upsell      = $this->input->post('demmande_upsell');
		$budget_upsell        = intval($this->input->post('budget_upsell'));
		$idclients            = $this->input->post('client');
		$tm                   = $this->input->post('tm');
		$date_upsell          = $this->input->post('date_upsell');
		$date_demande_upsell  = $this->input->post('date_demande_upsell');
		$information_upsell   = $this->input->post('information_upsell');
		$date_brief           = $this->input->post('date_brief');
		$statut_upsell        = $this->input->post('statut_upsell');
		$am                   = $this->input->post('am');

		// Donnée client
		$donnee      = $this->visuels_model->getDonneeById($idclients);
		$initiative  = $donnee[0]['initiative'];
		$idonnee     = $donnee[0]['idonnee'];
		$budget_init = intval($donnee[0]['budget']);

		// Contrôle du type upsell
		if (!$type_upsell) {
			$this->session->set_flashdata('message-erreur', "Type upsell manquant.");
			redirect('Client/detail_client/' . $idclients);
			return;
		}

		// Construction du budget final
		if ($type_upsell == 1) { 
			// BAISSE
			$budget_final = $budget_init - $budget_upsell;
			$title        = "Baisse";
			$type_tache   = 6;
			$tache        = "Le client fait une baisse de " . number_format($budget_upsell, 0, ',', ' ') . " €";

		} elseif ($type_upsell == 2) {  
			// UPSELL NOUVELLE CAMPAGNE
			$budget_final = $budget_init + $budget_upsell;
			$title        = "Upsell";
			$type_tache   = 5;
			$tache        = "Le client fait une upsell de " . number_format($budget_upsell, 0, ',', ' ') . " €";

		} elseif ($type_upsell == 3) {  
			// BOOSTER
			$budget_final = $budget_init + $budget_upsell;
			$title        = "Booster";
			$type_tache   = 5;
			$tache        = "Le client fait un Booster de " . number_format($budget_upsell, 0, ',', ' ') . " €";

		} else {
			$this->session->set_flashdata('message-erreur', "Type upsell invalide.");
			redirect('Client/detail_client/' . $idclients);
			return;
		}

		// Ajouter les informations supplémentaires si présentes
		if (!empty($information_upsell)) {
			$tache .= " avec les informations suivantes :\n" . $information_upsell;
		}

		// Création UPSell (table upsell principale)
		$idupsell = $this->visuels_model->create_upsell(
			$type_upsell,
			$budget_final,
			$budget_init,
			$demmande_upsell,
			$am,
			$tm,
			$date_upsell,
			$date_demande_upsell,
			$information_upsell,
			$statut_upsell,
			$idclients,
			1 // actif
		);

		// Création tâche liée
		$task = array(
			'type_tache'        => $type_tache,
			'date_demande'      => $date_demande_upsell,
			'date_due'          => $date_upsell,
			'idclients'         => $idclients,
			'AM'                => $tm,
			'assigned_to'       => $am,
			'title'             => $title,
			'Statuts_technique' => 1,
			'description'       => $tache,
			'idupsell'          => $idupsell
		);
		$this->Task_model->add_task($task);

		// Données onboarding (une seule insertion)
		$data_upsell = array(
			'idupsell'              => $idupsell,
			'idonnee'               => $idonnee,
			'idclients'             => $idclients,
			'dejaclient'            => 1,
			'budget'                => $budget_final,
			'account_manager'       => $am,
			'initiative'            => $initiative,
			'type_upsell'           => $type_upsell,
			'mis_en_place_paiement' => $date_demande_upsell,
			'Brief'                 => $date_brief,
			'annonce'               => $date_upsell,
			'budget_upsell'         => $budget_upsell
		);

		$this->visuels_model->add_upsell_onboarding($data_upsell);
		if ($type_upsell == 2) { 
			$statut_demande_en_cours = 3;
			$budget_finale = $budget_final; 
			$statut = 0;
			$this->Donne_modele->update_last_onboarding_status_briefs($idonnee, $statut);
			$this->Donne_modele->update_status_statut_envoye($idonnee, $statut);
			$this->Donne_modele->update_status_briefs($idonnee, $statut);
			//$this->visuels_model->update_statut_demande_en_cours($statut_demande_en_cours,$idonnee);
			$this->visuels_model->update_budget($budget_finale, $idclients);
			$date_envoye = date('Y-m-d');
			//$this->Donne_modele->update_status_brief_onboarding($idonnee,$date_envoye, 0);
		} 
		else{
			$budget_finale = $budget_final; 
			$this->visuels_model->update_budget($budget_finale, $idclients);
			$date_envoye = date('Y-m-d');
		}

		// Message + redirection
		$this->session->set_flashdata('message-succes', "Donnée ajoutée avec succès");
		redirect('Client/detail_client/' . $idclients);
	}


	private function get_all_calls()
	{
		$all_calls = [];
		$page = 1;

		do {
			$url = $this->api_url . '?page=' . $page;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_auth);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			$response = curl_exec($ch);
			curl_close($ch);

			$data = json_decode($response);
			if (isset($data->calls)) {
				$all_calls = array_merge($all_calls, $data->calls);
			}

			$has_more = isset($data->meta->next_page_link);
			$page++;
		} while ($has_more);

		return $all_calls;
	}

	public function test_api_connection()
	{
		$url = $this->api_url . '?per_page=1'; // On limite à 1 appel pour le test

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $this->api_auth);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpcode === 200) {
			echo "✅ Connexion API réussie !<br>";
			echo "<pre>" . print_r(json_decode($response), true) . "</pre>";
		} else {
			echo "❌ Échec de la connexion à l'API. Code HTTP : $httpcode<br>";
			echo "Réponse brute :<br><pre>$response</pre>";
		}
	}

	public function insert_client()
	{
		$client = $this->input->post('client');
		$email_client = $this->input->post('email_client');
		$numero_client = $this->input->post('numero_client');
		$budget = $this->input->post('budget');
		$secteur_activite = $this->input->post('secteur_activite');
		$product_choice = $this->input->post('product_choice');
		$initiative = $this->input->post('initiative');
		$am = $this->input->post('am');
		$date_mis_en_place = $this->input->post('date_mis_en_place');
		$date_brief = $this->input->post('date_brief');
		$date_annonce = $this->input->post('date_annonce');
		$dejaclient = 0;
		$logo = $this->file_upload_field = 'logo';
		$tm = $initiative;


		$this->form_validation->set_rules('site_client', 'URL', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			die('Validation échouée : champ site_client requis');
		}

		$site_client = trim($this->input->post('site_client'));
		if (!preg_match('#^https?://#i', $site_client)) {
			$site_client = 'https://' . $site_client;
		}

		$html = $this->fetch_url($site_client);
		if ($html === false) {
			die("Erreur : impossible d'accéder à l'URL $site_client");
		}

		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		libxml_clear_errors();

		$xpath = new DOMXPath($dom);

		$paragraphs = [];
		$p_nodes = $xpath->query("//p");
		foreach ($p_nodes as $p) {
			$text = trim($p->textContent);
			if (!empty($text)) {
				$paragraphs[] = $text;
			}
		}

		$headings = [];
		for ($i = 1; $i <= 6; $i++) {
			$h_nodes = $xpath->query("//h$i");
			foreach ($h_nodes as $h) {
				$text = trim($h->textContent);
				if (!empty($text)) {
					$headings[] = [
						'tag' => "h$i",
						'text' => $text
					];
				}
			}
		}
		$summary = $this->get_summary_from_chatgpt($headings, $paragraphs);
		$naf_info = $this->get_naf_code_from_summary($summary);
		$secteur_activite =	$naf_info['libelle'];
		preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
		$gtm_code = !empty($matches) ? $matches[0] : null;
		$cms = $this->detect_cms($html, $site_client);
		$cms_logo = $this->get_cms_logo($cms);
		$favicon = $this->get_favicon($html, $site_client);

		$idclients = $this->visuels_model->insertclient($client, $site_client, $email_client, $numero_client, $favicon, $cms, $cms_logo, $summary,$naf_info);
		$idclient_onboarding = $idclients;
		$idclient = $idclients;
		$idonnee = $this->visuels_model->insertfiche($idclient, $budget, $secteur_activite, $product_choice, $initiative, $am, $date_mis_en_place, $date_brief, $date_annonce, $dejaclient, $gtm_code);
		$title = "Création de Brief";
		$tache = "En attente de brief";
		$Statuts_technique = 1;
		$type_tache = 1;
		$data = array(
			'type_tache' => $type_tache,
			'date_demande' => $date_mis_en_place,
			'date_due' => $date_brief,
			'idclients' => $idclients,
			'AM' => $initiative,
			'assigned_to' => $am,
			'title' => $title,
			'Statuts_technique' => $Statuts_technique,
			'description' => $tache
		);

		$this->Task_model->add_task($data);
		$type_upsell = 1;
		$budget_finale = $budget;
		$budget_initiale = $budget;
		$statut_upsell = 1;
		$idclients = $idclients;
		$demmande_upsell = $am;
		$am = $am;
		$tm = $am;
		$actif = 0;
		$date_upsell = $date_mis_en_place;
		$date_demande_upsell = $date_mis_en_place;
		$inforamtion_upsell = "Budget initial";
		$idclient = $this->visuels_model->create_upsell($type_upsell, $budget_finale, $budget_initiale, $demmande_upsell, $am, $tm, $date_upsell, $date_demande_upsell, $inforamtion_upsell, $statut_upsell, $idclients, $actif);
		$data_upsell = array(
			'idonnee' => $idonnee,
			'idclients' => $idclient_onboarding,
			'dejaclient' => $dejaclient,
			'budget' => $budget,
			'account_manager' => $am,
			'initiative' => $initiative,
			'idproduit' => $product_choice,
			'mis_en_place_paiement' => $date_mis_en_place,
			'Brief' => $date_brief,
			'annonce' => $date_annonce

		);
		$this->visuels_model->add_upsell_onboarding($data_upsell);
		redirect('Onboarding');
	}

	private function get_naf_code_from_summary($summary)
	{
		$model = 'gpt-4';

		$prompt = "Voici le résumé d’un site internet représentant une entreprise.\n\n" .
			"Ta tâche est de déterminer le **code NAF (APE)** le plus approprié pour cette activité, basé sur la nomenclature française officielle (INSEE).\n" .
			"Donne-moi le résultat au format JSON avec deux champs : `code` et `libelle`. Ne donne rien d'autre.\n\n" .
			"Résumé :\n$summary";

		$data = [
			"model" => $model,
			"messages" => [
				["role" => "user", "content" => $prompt]
			],
			"temperature" => 0.2
		];

		$ch = curl_init('https://api.openai.com/v1/chat/completions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . getenv('CHAT_GPT_API_KEY')
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return ['code' => '0000Z', 'libelle' => 'Secteur non identifié'];
		}

		curl_close($ch);
		$result = json_decode($response, true);
		$output = $result['choices'][0]['message']['content'] ?? '';

		// Exemple attendu : {"code": "6201Z", "libelle": "Programmation informatique"}
		$decoded = json_decode($output, true);
		if (json_last_error() === JSON_ERROR_NONE && isset($decoded['code'], $decoded['libelle'])) {
			return $decoded;
		}

		return ['code' => '0000Z', 'libelle' => 'Secteur non identifié'];
	}
	private function get_information_campagne_from_chatgpt($url)
	{
		$model = 'gpt-4';

		$input_text = "Regarde le contenu du site: $url et dit moi ce que le site fait";
		$data = [
			"model" => $model,
			"messages" => [
				["role" => "user", "content" => $input_text]
			],
			"temperature" => 0.7
		];

		$ch = curl_init('https://api.openai.com/v1/chat/completions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . getenv('CHAT_GPT_API_KEY')
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'Erreur OpenAI : ' . curl_error($ch);
		}

		curl_close($ch);
		$result = json_decode($response, true);
		$raw_output = $result['choices'][0]['message']['content'] ?? 'Résumé non disponible.';

		// Séparation des deux paragraphes
		$paragraphs_split = preg_split('/\n\s*\n/', trim($raw_output));

		if (count($paragraphs_split) >= 2) {
			$para1 = trim($paragraphs_split[0]);
			$para2 = trim($paragraphs_split[1]);

			// Comptage des mots (utile pour test ou journalisation)
			$word_count1 = str_word_count(strip_tags($para1));
			$word_count2 = str_word_count(strip_tags($para2));
			$total_words = $word_count1 + $word_count2;

			// Retourne toujours le contenu, sans alerte
			return $para1 . "\n\n" . $para2;
		}

		// Fallback si le texte généré n'a pas deux paragraphes distincts
		return $raw_output;
	}


	private function get_summary_from_chatgpt($headings, $paragraphs)
	{
		$model = 'gpt-4';

		$input_text = "Voici les titres et paragraphes d’un site web.\n\n";
		$input_text .= "Ta tâche est de rédiger un résumé informatif en **deux paragraphes distincts**, séparés par une **ligne vide** (un simple saut de ligne).\n\n";

		$input_text .= "✍️ Le résumé total doit contenir **entre 175 et 190 mots maximum**, répartis de façon naturelle entre les deux paragraphes.\n";
		$input_text .= "Le premier paragraphe doit présenter l'activité ou le secteur du site.\n";
		$input_text .= "Le second paragraphe doit décrire l’objectif, les services ou la valeur ajoutée.\n\n";

		$input_text .= "Titres :\n";
		foreach ($headings as $h) {
			$input_text .= "- ({$h['tag']}) {$h['text']}\n";
		}

		$input_text .= "\nParagraphes :\n";
		foreach (array_slice($paragraphs, 0, 10) as $p) {
			$input_text .= "- $p\n";
		}

		// Requête à l'API OpenAI
		$data = [
			"model" => $model,
			"messages" => [
				["role" => "user", "content" => $input_text]
			],
			"temperature" => 0.7
		];

		$ch = curl_init('https://api.openai.com/v1/chat/completions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . getenv('CHAT_GPT_API_KEY')
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'Erreur OpenAI : ' . curl_error($ch);
		}

		curl_close($ch);
		$result = json_decode($response, true);
		$raw_output = $result['choices'][0]['message']['content'] ?? 'Résumé non disponible.';

		// Séparation des deux paragraphes
		$paragraphs_split = preg_split('/\n\s*\n/', trim($raw_output));

		if (count($paragraphs_split) >= 2) {
			$para1 = trim($paragraphs_split[0]);
			$para2 = trim($paragraphs_split[1]);

			// Comptage des mots (utile pour test ou journalisation)
			$word_count1 = str_word_count(strip_tags($para1));
			$word_count2 = str_word_count(strip_tags($para2));
			$total_words = $word_count1 + $word_count2;

			// Retourne toujours le contenu, sans alerte
			return $para1 . "\n\n" . $para2;
		}

		// Fallback si le texte généré n'a pas deux paragraphes distincts
		return $raw_output;
	}


	// Fonction cURL pour récupérer le contenu HTML
	private function fetch_url($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // À activer en prod si possible
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MyBot/1.0)');

		$response = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($response === false || $code >= 400) {
			return false;
		}

		return $response;
	}

	// Reste de tes méthodes detect_cms(), get_cms_logo(), get_favicon() inchangées
	private function detect_cms($html, $url)
	{
		if (preg_match('/<meta name=["\']generator["\'] content=["\']([^"\']+)["\']/', $html, $match)) {
			return $match[1];
		}
		if (strpos($html, '/wp-content/') !== false || strpos($html, 'wp-') !== false) {
			return 'WordPress';
		} elseif (strpos($html, 'Joomla') !== false || strpos($html, '/administrator/') !== false) {
			return 'Joomla';
		} elseif (strpos($html, '/sites/default/') !== false) {
			return 'Drupal';
		} elseif (strpos($html, 'Shopify') !== false || strpos($html, 'cdn.shopify.com') !== false) {
			return 'Shopify';
		} elseif (strpos($html, 'Magento') !== false || strpos($html, 'mage/') !== false) {
			return 'Magento';
		} elseif (strpos($html, 'Magento') !== false || strpos($html, 'mage/') !== false) {
			return 'Magento';
		} elseif (strpos($html, 'PrestaShop') !== false || strpos($html, 'mage/') !== false) {
			return 'PrestaShop';
		} elseif (strpos($html, 'Google') !== false || strpos($html, 'mage/') !== false) {
			return 'Google';
		}
		$headers = @get_headers($url, 1);
		if ($headers && isset($headers['X-Powered-By'])) {
			return $headers['X-Powered-By'];
		}

		return 'Inconnu ou non détectable automatiquement';
	}

	private function get_cms_logo($cms_name)
	{
		$cms_logos = [
			'WordPress' => 'wordpress.png',
			'Joomla' => 'joomla.png',
			'Drupal' => 'drupal.png',
			'Shopify' => 'shopify.png',
			'Magento' => 'Magento.png',
			'Wix' => 'wix.png',
			'PrestaShop' => 'prestashop.png',
			'Google' => 'site_kit.png'
		];

		foreach ($cms_logos as $key => $file) {
			if (stripos($cms_name, $key) !== false) {
				return base_url('assets/images/cms/' . $file);
			}
		}

		return base_url('assets/images/cms/unknown.png');
	}

	private function get_favicon($html, $url)
	{
		if (preg_match('/<link[^>]+rel=["\'](?:shortcut icon|icon)["\'][^>]+href=["\']([^"\']+)["\']/i', $html, $matches)) {
			$favicon = $matches[1];
			if (parse_url($favicon, PHP_URL_SCHEME) === null) {
				$parsed_url = parse_url($url);
				$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] : 'https';
				$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
				$base = "$scheme://$host";
				$favicon = (substr($favicon, 0, 1) === '/') ? $base . $favicon : $base . '/' . $favicon;
			}

			return $favicon;
		}
		$parsed_url = parse_url($url);
		$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] : 'https';
		$host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		return "$scheme://$host/favicon.ico";
	}

	private function set_upload_options($prefix, $filename)
	{
		$file = pathinfo($filename);
		$file = $file['filename'];
		$config = array();
		$config['upload_path']      = $this->path;
		$config['allowed_types']    = 'jpg|jpeg|png|gif|webp';
		$config['max_size']         = '0';
		$config['file_name']        = url_title(iconv("UTF-8", "ASCII//TRANSLIT", $prefix . '_' . $file), '_', TRUE);
		$config['overwrite']        = FALSE;
		return $config;
	}
}
