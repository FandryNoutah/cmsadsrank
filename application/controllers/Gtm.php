<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gtm extends MY_Controller
{
	private $api_url = 'https://api.aircall.io/v1/calls';
	private $api_auth = 'e69c2f6c77144ad053a54bf77088aa09:6ab56a32536bc017ed6b2adb619338e0';
	protected $file_upload_field;

	public function __construct()
	{
		parent::__construct();

		$this->load->model("visuels_model");
		$this->load->model("concurrent");
		$this->load->model("Donne_modele");
		$this->load->model("Data_modele");
		$this->load->model("Image_model");
		$this->load->model("Gtm_model");
		$this->load->model("Task_message_model");
		$this->load->model("Task_model");
		$this->data['visuels'] = $this->visuels_model->get_all();
		// $this->load->library('PHPExcel');
		// $this->load->library('excel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('curl');
		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";

		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$this->current_user = $this->ion_auth->user()->row();

	}

	public function index()
	{
		//$this->data['gtm_task'] = $this->Task_model->get_all_procedure_gtm();
		$this->data["gtm"] = $this->Gtm_model->get_all_gtm();
		$this->data["optimisation_gtm"] = $this->Gtm_model->get_all_optimisation_gtm();
		$this->content = "layouts/gtm/index.php";
		$this->layout();
	}
	public function get_optimisation_by_id($id){
        $optim = $this->Gtm_model->get_optimisation_by_id($id);
        echo json_encode($optim);
    }

    public function add_optimisation(){
        $idclients = $this->input->post('idclients');
        $mois = $this->input->post('mois');
        $debug = $this->input->post('Débogage');

        // Vérifie doublon
        if($this->Gtm_model->exists_optimisation($idclients, $mois)){
            $this->session->set_flashdata('error','Optimisation déjà existante pour ce mois.');
            redirect('Gtm/optimisation');
        }

        $this->Gtm_model->add_optimisation($idclients, $mois, $debug);

        if($debug=='Erreur'){
            $this->create_task_for_error_manual($idclients,$mois);
        }

        redirect('Gtm/optimisation');
    }

    public function update_optimisation(){
        $id = $this->input->post('id_optimisation_gtm');
        $debug = $this->input->post('debougage');


        $this->Gtm_model->update_optimisation($id, $debug);

        if ($debug === 'Erreur') {

    $optim = $this->Gtm_model->get_optimisation_by_id($id);

    $error_key = $this->input->post('error_title'); // gtm, tracking, etc.
    $error_description = $this->input->post('error_description');

    // Correspondance clé => libellé EXACT du select
    $errorLabels = [
        'gtm' => 'Bug Mise en place GTM',
        'tracking' => 'Problème tracking balises',
        'url' => 'Changement d’URL',
        'href' => 'Problème lien href',
        'cmp' => 'Problème CMP',
        'thankyou' => 'URL page de remerciement incorrecte',
        'contact' => 'Problème demande mise en relation'
    ];

    $error_title = $errorLabels[$error_key] ?? 'Erreur optimisation';

    // Gestion Mois + Année
    $months = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
    ];

    $mois = $optim['mois']; // ex: 2024-03-01
    $numeroMois = (int) date('m', strtotime($mois));
    $annee = date('Y', strtotime($mois));
    $moisLettre = $months[$numeroMois];

    $am = $optim['am'];

    $this->create_task_for_error_manual(
        $optim['idclients'],
        $am,
        ucfirst($moisLettre),
        $annee,
        $error_title,
        $error_description
    );
}



        redirect('Gtm');
    }

    private function create_task_for_error_manual(
    $idclients,
    $am,
    $moisLettre,
    $annee,
    $error_title,
    $error_description
) {
    $data = [
        'type_tache' => 13,
        'date_demande' => date('Y-m-d'),
        'date_due' => date('Y-m-d'),
        'idclients' => $idclients,
        'AM' => $am,
        'assigned_to' => 23,
        'title' => $error_title . ' – ' . $moisLettre . ' ' . $annee,
        'Statuts_technique' => 1,
        'procedure_gtm' => 1,
        'description' => $error_description
    ];

    $this->Task_model->add_task($data);
}


public function add_row()
{
    $idclients = $this->input->post('idclients');

    $data = [
        'idclients'        => $idclients,
        'conversion'       => $this->input->post('conversion'),
        'actions'          => $this->input->post('actions'),
        'types'            => $this->input->post('types'),
        'remarque'         => $this->input->post('remarque'),
        'etat'             => $this->input->post('etat'),
        'conditions'       => $this->input->post('conditions'),
        'conversion_id'    => $this->input->post('conversion_id'),
        'extensions_appel' => $this->input->post('conversion_label'),
    ];

    $this->db->insert('plan_de_taggage', $data);

    redirect('Gtm/Plan_de_taggage/'.$idclients);
}


public function update_row()
{
    $idclients = $this->input->post('idclients');
    $id = $this->input->post('idplan_de_taggage');
    $etat = $this->input->post('etat');

    $data = [
        'conversion'        => $this->input->post('conversion'),
        'actions'           => $this->input->post('actions'),
        'types'             => $this->input->post('types'),
        'remarque'          => $this->input->post('remarque'),
        'etat'              => $etat,
        'conditions'        => $this->input->post('conditions'),
        'conversion_id'     => $this->input->post('conversion_id'),
        'extensions_appel'  => $this->input->post('conversion_label'),
    ];

    $this->db->where('idplan_de_taggage', $id);
    $this->db->update('plan_de_taggage', $data);

    // ✅ Création tâche si ERREUR
    if ($etat == 2) {
		$client = $this->visuels_model->getDonneeById($idclients);
		$am = $client[0]['account_manager'];
        $error_key = $this->input->post('error_title');
        $error_description = $this->input->post('error_description');

        $errorLabels = [
            'gtm' => 'Bug Mise en place GTM',
            'tracking' => 'Problème tracking balises',
            'url' => 'Changement d’URL',
            'href' => 'Problème lien href',
            'cmp' => 'Problème CMP',
            'thankyou' => 'URL page de remerciement incorrecte',
            'contact' => 'Problème demande mise en relation'
        ];

        $error_title = $errorLabels[$error_key] ?? 'Erreur plan de taggage';

        $mois = ucfirst(strftime('%B'));
        $annee = date('Y');

        $this->Task_model->add_task([
            'type_tache' => 13,
            'date_demande' => date('Y-m-d'),
            'date_due' => date('Y-m-d'),
			'AM' => $am,
            'idclients' => $idclients,
            'assigned_to' => 23,
            'title' => $error_title,
            'Statuts_technique' => 1,
            'procedure_gtm' => 1,
            'description' => $error_description
        ]);
    }

    redirect('Gtm/Plan_de_taggage/' . $idclients);
}



public function delete_row($id = null, $idclients = null)
{
    if (!$id || !$idclients) {
        show_error("Paramètres manquants pour la suppression.");
    }

    $this->db->delete('plan_de_taggage', ['idplan_de_taggage' => $id]);

    redirect('Gtm/Plan_de_taggage/'.$idclients);
}




	public function Plan_de_taggage($id)
	{

		$this->data["plan_taggage"] = $this->visuels_model->getplantaggage($id); 
		$this->data['idclients'] = $id;
		$this->content = "layouts/plan_de_taggage/index.php";
		$this->layout();
	}
	public function get_gtm_by_id($id)
	{
		$data = $this->Gtm_model->get_by_id($id);
		echo json_encode($data);
	}
	public function update_gtm()
{
    $id = (int) $this->input->post('id_gtm');
    $idclients = (int) $this->input->post('idclients');
    $am = (int) $this->input->post('am');
    $statut = $this->input->post('statut');
    $date_du_jour = date('Y-m-d');

    $data = [
        'date_demande'    => $this->input->post('date_demande'),
        'invitation_reçu' => $this->input->post('invitation_reçu'),
        'statut'          => $statut,
    ];

    $this->Gtm_model->update($id, $data);

    // ✅ Si Implémenté → optimisation
    if ($statut === "Implémenté") {
        $this->Gtm_model->insert_optimisation([
            'idclients'    => $idclients,
            'am'           => $am,
            'tm'           => 23,
            'date_demande' => $date_du_jour,
            'mois'         => $date_du_jour
        ]);
    }

    // ✅ Si Erreur → création tâche
    if ($statut === "Erreur") {

        $error_key = $this->input->post('error_title');
        $error_description = $this->input->post('error_description');

        $errorLabels = [
            'gtm' => 'Bug Mise en place GTM',
            'tracking' => 'Problème tracking balises',
            'url' => 'Changement d’URL',
            'href' => 'Problème lien href',
            'cmp' => 'Problème CMP',
            'thankyou' => 'URL page de remerciement incorrecte',
            'contact' => 'Problème demande mise en relation'
        ];

        $error_title = $errorLabels[$error_key] ?? 'Erreur GTM';

        $moisLettre = ucfirst(strftime('%B'));
        $annee = date('Y');

        $this->create_task_gtm_error(
            $idclients,
            $am,
            $error_title,
            $moisLettre,
            $annee,
            $error_description
        );
    }

    redirect('Gtm');
}
private function create_task_gtm_error(
    $idclients,
    $am,
    $error_title,
    $moisLettre,
    $annee,
    $error_description
) {
    $data = [
        'type_tache' => 13,
        'date_demande' => date('Y-m-d'),
        'date_due' => date('Y-m-d'),
        'idclients' => $idclients,
        'AM' => $am,
        'assigned_to' => 23,
        'title' => $error_title,
        'Statuts_technique' => 1,
        'procedure_gtm' => 1,
        'description' => $error_description
    ];

    $this->Task_model->add_task($data);
}


		public function update_table() {
	$this->load->model('Gtm_model');

	$rows = $this->input->post('rows');
	$idclients = 1; // ou depuis la session/utilisateur

	foreach ($rows as $row) {
		if (!empty($row['deleted']) && !empty($row['idplan_de_taggage'])) {
			// Supprimer de la base
			$this->Gtm_model->delete_row($row['idplan_de_taggage']);
		} elseif (!empty($row['idplan_de_taggage'])) {
			// Mise à jour
			$this->Gtm_model->update_row($row['idplan_de_taggage'], $row);
		} else {
			// Insertion
			$row['idclients'] = $idclients;
			$this->Gtm_model->insert_row($row);
		}
	}

	// ✅ Correction de la redirection
	redirect('Gtm/Plan_de_taggage/' . $idclients);
}


	public function fetch_discussion($id_task)
	{

		// Check for order (ascendant || descendant)

		$messages = $this->Task_message_model->get_messages_by_task($id_task);
		$currentUser = $this->current_user;

		foreach ($messages as $message) {

			$created_at = $message->created_at;
			$message->created_at = (new DateTime($created_at))->format('j M, H:i');

			$message->owner = $message->user_id == $currentUser->id;
		}

		echo json_encode($messages);
	}

	public function send_message()
	{

		$id_task = $this->input->post('id_task', TRUE);
		$message = $this->input->post('message', TRUE);

		if (!empty($message) && $this->current_user) {
			$this->Task_message_model->insert_message([
				'user_id' => $this->current_user->id,
				'task_id' => $id_task,
				'message' => $message
			]);
		}

		echo json_encode([
			"done"	=>	true
		]);
	}

	public function detail_task($id_task) {

		$task = $this->Task_model->get_task_by_id($id_task);
		$messages = $this->Task_message_model->get_messages_by_task($id_task);

		foreach ($messages as $message) {
			
			$created_at = $message->created_at;
			$message->created_at = (new DateTime($created_at))->format('j M, H:i');

			$photo_users = base_url(IMAGES_PATH . $message->photo_users);
			$message->photo_users = $photo_users;
		}
		
		echo json_encode([
			'task'		=>	$task,
			'messages'	=>	$messages
		]);
	}
}
