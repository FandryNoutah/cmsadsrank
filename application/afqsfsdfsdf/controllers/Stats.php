<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Stats extends MY_Controller
{
    protected $panneaux;
    protected $provinces;
    protected $regisseur;
    protected $visuels;
    protected $sam;
	protected $axe;
    protected $table = "hm_panneau";

	function __construct() {
		parent::__construct();
		
		$this->load->model("panneau_model");
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        $this->panneaux = $this->panneau_model->get_all();
        
		//$this->provinces  = $this->panneau_model->get_all_sam();
	}

    public function panneaux() {
        $data = array();
        $column = $this->input->post("stat-panneau");

        switch ($column) {
            case 'panneau_province':
                $this->provinces  = $this->panneau_model->get_provinces();
                foreach($this->provinces as $key => $province) {
                    $data[$province->label] = $this->panneau_model->get_by($column, $province->id);
                }
                break;
            case 'panneau_sam':
                $this->sam  = $this->panneau_model->get_all_sam();
                foreach($this->sam as $key => $sam) {
                    $data[$sam->description] = $this->panneau_model->get_by($column, $sam->id);
                }
                break;
            case 'panneau_axe':
                $this->axe  = $this->panneau_model->get_axes();
                foreach($this->axe as $key => $axe) {
                    $data[$axe->label] = $this->panneau_model->get_by($column, $axe->id);
                }
                break;
            case 'panneau_regisseur':
                $this->regisseur  = $this->panneau_model->get_regisseurs();
                foreach($this->regisseur as $key => $regisseur) {
                    $data[$regisseur->label] = $this->panneau_model->get_by($column, $regisseur->id);
                }
                break;            
            default:
                # code...
                break;
        }
        $this->load->view("templates/stats/chart_panneau", array("data" => $data));
    }

    public function visuels() {
        $data = array();
        $column = "panneau_visuel_actuel";
        $this->get_all_visuels = $this->panneau_model->get_all_visuels();
        foreach($this->panneaux as $key => $value) {
            $data[$value->panneau_visuel_actuel] = $this->panneau_model->get_by($column, $value->panneau_visuel_actuel);
        }
        $this->load->view("templates/stats/chart_visuels", array("data" => $data, "post" => $this->input->post("stat-visuel")));
    }

	public function index()
	{
		$this->page = "templates/admin_panneau";
		$this->layout();
	}
}
//iconv("UTF-8", "ASCII//TRANSLIT", $text)