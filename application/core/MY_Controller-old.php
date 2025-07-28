<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller_old extends CI_Controller
{
	protected $data = array();
	protected $mainData;
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->helper('hm');
		$this->load->helper('func');
		$this->load->model("Task_model");
		$this->data['page_title'] = 'Dashboard';

		$this->data['before_head'] = '';
		$this->data['before_body'] = '';
		$this->data['current_user'] = $this->ion_auth->user()->row();
		$this->ion_auth_model->trigger_events('in_group');

		$id = $this->session->userdata('user_id');
		$this->data['idusers'] = $this->session->userdata('user_id');
		$this->data['users_groups'] = $this->ion_auth_model->get_users_groups($id)->result();

		/**
		 * COUNING NON COMPLETED TASK
		 */
		$this->data['count_non_completed_task'] = $this->Task_model->count_All_task_non_complete();

		$this->load->model("panneau_model");
		$this->load->model("supports_model");
		$this->load->model("kiosque_model");
		$this->load->model("flags_model");
		$this->load->model("visuels_model");
		$this->load->model("regisseur_model");
		$this->load->model("data_model");
		/* Form validation */

		$supportdata = array();
		$supports = $this->supports_model->get_all();
		$this->data['supports'] = $supports;
		$this->mainData = $this->data_model->getAll();

		foreach ($supports as $support) {
			$supportdata[$support->id] = count($this->supports_model->get_by_id($support->id));
		}

		$this->data['supportdata'] = $supportdata;

		if (!$this->ion_auth->logged_in() /*&& $this->router->fetch_class() != "dashboard"*/ && $this->router->fetch_method() != "login") {
			redirect('admin/user/login', 'auto');
		}
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('admin/user/login', 'refresh');
		}
		/*
      if (!$this->ion_auth->logged_in()) {
      //redirect them to the login page
          redirect(base_url(), 'refresh');
      }*/
	}

	public function layout($template = NULL)
	{
		$this->template["header"] = $this->load->view("templates/parts/admin_header", $this->data, TRUE);
		$this->template["footer"] = $this->load->view("templates/parts/admin_footer", $this->data, TRUE);
		$this->template["leftmenu"] = $this->load->view("templates/parts/admin_leftmenu", $this->data, TRUE);
		$this->template["page"] = $this->load->view($this->page, $this->data, TRUE);
		$this->load->view("admin/dashboard_main_view", $this->template);
	}

	protected function render($the_view = NULL, $template = 'master')
	{
		if ($template == 'json' || $this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			echo json_encode($this->data);
		} else {
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
	}
}
