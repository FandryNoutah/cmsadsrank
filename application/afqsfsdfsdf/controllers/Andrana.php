<?php

class Andrana extends CI_Controller {

        public function index()
        {
                $this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');
				
				$this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required',
                        array('required' => 'You must provide a %s.')
                );
                $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
				$this->form_validation->set_rules("fichier", "fichier", 'callback_file_check');

                if ($this->form_validation->run() == FALSE)
                {
						echo 'templates/andrana';
                        $this->load->view('templates/andrana');
                }
                else
                {
						echo 'templates/andranaok';
                        $this->load->view('templates/andranaok');
                }
        }
		
		public function file_check($string) {
			$allowedMimeTypeArray = [
				"image/gif", 
				"image/jpeg", 
				"image/png", 
				"image/x-png"
			];
			
			
			if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
				$mime = get_mime_by_extension($_FILES["fichier"]["name"]);
				if(in_array($mime, $allowedMimeTypeArray)) {
					return true;
				} else {
					$this->form_validation->set_message('file_check', 'Type de fichier invalide');
					return false;
				}
			} else {
				$this->form_validation->set_message('file_check', 'Veuillez choisir un fichier');
				return false;
			}
		}
		
		private function set_upload_options($prefix, $filename) {
			$file = pathinfo($filename);
			$file = $file['filename'];
			$config = array();
			$config['upload_path']      = $this->path;
			$config['allowed_types']    = 'gif|jpg|png';
			$config['max_size']         = '0';
			$config['file_name']        = url_title(iconv("UTF-8", "ASCII//TRANSLIT", $prefix . '_' . $file), '_', TRUE);
			$config['overwrite']        = FALSE;
			return $config;
		}
}