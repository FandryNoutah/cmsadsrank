<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends MY_Controller
{
	protected $data;
 
	function __construct() {
		parent::__construct();
		$this->load->model("Dashboard_model");
		$this->load->model("Note_model");
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{

		$current_user = $this->data['current_user'];
		// dd($current_user);
		$idusers = intval($current_user->id);
		$task = $this->Dashboard_model->get_task_by_id_users($idusers);

		$nbr_task_planifier = 0;
		foreach ($task as $t) {
			if ($t->status == "planifié") {
				$nbr_task_planifier++;
			}
		}

		$nbr_task = count($task);
		$this->data['task'] = $task;
		$this->data['nbr_task'] = $nbr_task;
		$this->data['nbr_task_planifier'] = $nbr_task_planifier;

		$nbr_task_attribuer = $this->Dashboard_model->get_task_by_id_users_attribuer($idusers);
		$nbr_task_attribuer_plannifier = 0;
		foreach ($nbr_task_attribuer as $t) {
			if ($t->status == "planifié") {
				$nbr_task_attribuer++;
			}
		}

		$nbr_task_attribuer = count($nbr_task_attribuer);
		$this->data['nbr_task_attribuer'] = $nbr_task_attribuer;
		$this->data['nbr_task_attribuer_plannifier'] = $nbr_task_attribuer_plannifier;

		$donnee = $this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		$this->data['nbr_client'] = count($donnee);

		$nbr_client_actif = 0;
		$nbr_client_pause = 0;
		$nbr_client_resilie = 0;
		$total_budget_actif = 0;
		$total_budget_en_pause = 0;
		$total_budget_resilie = 0;

		foreach ($donnee as $d) {
			if ($d->resiliation == 1) {
				$total_budget_actif += $d->budget;
				$nbr_client_actif++;
			}
		}

		foreach ($donnee as $d) {
			if ($d->resiliation == 2) {
				$total_budget_en_pause += $d->budget;
				$nbr_client_pause++;
			}
		}

		foreach ($donnee as $d) {
			if ($d->resiliation == 3) {
				$total_budget_resilie += $d->budget;
				$nbr_client_resilie++;
			}
		}
		
		$this->data['nbr_client_actif'] = $nbr_client_actif;
		$this->data['nbr_client_pause'] = $nbr_client_pause;
		$this->data['nbr_client_resilie'] = $nbr_client_resilie;
		$this->data['total_budget_actif'] = $total_budget_actif;
		$this->data['total_budget_en_pause'] = $total_budget_en_pause;
		$this->data['total_budget_resilie'] = $total_budget_resilie;
		$this->data['notes'] = $this->Note_model->get_for_user($this->current_user->id);

		$discussion = $this->data['discussion'] = $this->Dashboard_model->get_discussion_task_by_id_users($idusers);
		$this->data['nbr_discussion_task'] = $nbr_discussion_task = count($discussion);

		$discussion = $this->data['discussion'] = $this->Dashboard_model->get_discussion_note_by_id_users($idusers);
		$this->data['nbr_discussion_note'] = $nbr_discussion_note = count($discussion);
		
		$discussion = $this->data['discussion'] = $this->Dashboard_model->get_discussion_gtm_by_id_users($idusers);
		$this->data['nbr_discussion_gtm'] = $nbr_discussion_gtm = count($discussion);

		$this->data['notes'] = $this->Dashboard_model->get_for_user($this->current_user->id);
		$this->data['tache'] = $this->Dashboard_model->get_all_tâche();
		$this->content = "layouts/dashboard/index.php";
		$this->layout();
	}

}
