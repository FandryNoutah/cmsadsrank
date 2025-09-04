<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends MY_Controller
{
	protected $data;
 
	function __construct() {
		parent::__construct();
		$this->load->model("Dashboard_model");
	
	}

	public function index()
	{
		$current_user = $this->ion_auth->user()->row();
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

		$this->content = "layouts/Dashboard/index.php";
		$this->layout();
	}

}
