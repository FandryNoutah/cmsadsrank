<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_Controller__old extends CI_Controller
{
  protected $data = array();
  function __construct()
  {
    parent::__construct();
    $this->load->library('ion_auth');
    $this->load->model("panneau_model");
    $this->load->model("kiosque_model");
    $this->data['page_title'] = 'CI App';
    $this->data['before_head'] = '';
    $this->data['before_body'] ='';
    $this->data['current_user'] = $this->ion_auth->user()->row();
  }

  public function layout($template = NULL) {
    $this->template["header"] = $this->load->view("templates/parts/admin_header", $this->data, TRUE);
    $this->template["footer"] = $this->load->view("templates/parts/admin_footer", $this->data, TRUE);
    $this->template["leftmenu"] = $this->load->view("templates/parts/admin_leftmenu", $this->data, TRUE);
    $this->template["page"] = $this->load->view($this->page, $this->data, TRUE);
    $this->load->view("admin/dashboard_main_view", $this->template);
  }
 
  protected function render($the_view = NULL, $template = 'master')
  {
    if($template == 'json' || $this->input->is_ajax_request())
    {
      header('Content-Type: application/json');
      echo json_encode($this->data);
    }
    else
    {
      $this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view,$this->data, TRUE);
      $this->load->view('templates/'.$template.'_view', $this->data);
    }
  }
}
