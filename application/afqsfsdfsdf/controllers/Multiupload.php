<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Multiupload extends MY_Controller
{
	protected $path;

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index() {
		$this->load->view('templates/multiupload');
	}

	function do_upload() {       
	    $this->load->library('upload');
		
		echo "<pre>";
	    print_r($_FILES);
	    echo "</pre>";
		$this->upload->initialize($this->set_upload_options());		

		
	    if (empty($_FILES['userfile_1']['name'])) {
	    	echo "ffffffffff";
			
		}
		
		$this->form_validation->set_rules('userfile_1', 'Image', 'trim|required');
		if($this->upload->do_upload('userfile_1')) {
			echo "tsy erorr <br/>";
		} else { 
			echo "aaaaaaaaa";	print_r($this->upload->display_errors()); 
		}

	    $files = $_FILES;
	    
	    $cpt = count($_FILES['userfile']['name']);

	    $filename = "";

	    for($i=0; $i<$cpt; $i++)
	    {          
	    	//echo "tsy error";
	        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
	        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
	        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
	        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
	        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    
	        $this->upload->initialize($this->set_upload_options());
	        if($this->upload->do_upload()) {
	        	//echo "upload done";
	        	$filename .= $this->upload->file_name;
	        	if($i < $cpt - 1) {
	        		$filename .= ";";
	        	}
	        } else {
	        	//print_r($this->upload->display_errors()) 
	       	}
	       
	    }
	    echo $filename;
	}

	private function set_upload_options() {
	    //upload an image options
	    $config = array();
	    $config['upload_path'] = 'assets/uploads/examples/';
	    $config['allowed_types'] = 'gif|jpg|png';
	    $config['max_size']      = '0';
	    //$config['filename']      = '0';
	    $config['overwrite']     = FALSE;

	    return $config;
	}
}