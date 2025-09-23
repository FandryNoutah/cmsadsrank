<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utilisateur extends MY_Controller
{
	protected $file_upload_field;
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Utilisateur_model");
		$this->load->helper('url');
		$this->load->library(['ion_auth']);
		$this->load->library('upload');
	}

	public function index()
	{
		$current_user = $this->current_user = $this->ion_auth->user()->row();
		$id = $current_user->id;
		$this->data['users'] = $this->Utilisateur_model->get_users_by_id($id);
		$this->content = "layouts/Utilisateur/edit_utilisateur.php";
		$this->layout();
	}
	public function modifier()
	{
		$id = $this->input->post('id');
		$upload_path = './assets/images/equipe/';
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0755, true);
		}

		$photo_filename = null;

		if (!empty($_FILES['photo_users']['name'])) {
			$this->upload->initialize($this->set_upload_options($upload_path, $_FILES["photo_users"]["name"]));

			if ($this->upload->do_upload('photo_users')) {
				$upload_data = $this->upload->data();
				// Ajoute le chemin relatif devant le nom
				$photo_filename = '/equipe/' . $upload_data['file_name']; 
			} else {
				// Gérer erreur upload si besoin
			}
		}

		$data = [
			"first_name" => $this->input->post('first_name'),
			"last_name"  => $this->input->post('last_name'),
			"username"   => $this->input->post('username'),
			"email"      => $this->input->post('email'),
			"phone"      => $this->input->post('phone'),
			"couleur"    => $this->input->post('couleur'),
		];

		if ($photo_filename) {
			$data['photo_users'] = $photo_filename;
		}

		$this->Utilisateur_model->edit_user($data, $id);
		$this->Utilisateur_model->change_color($data['couleur'], $id);

		redirect('Utilisateur');
	}
			

	private function set_upload_options($upload_path, $filename)
		{
			$file = pathinfo($filename);
			$basename = $file['filename'];

			$config = array();
			$config['upload_path']   = $upload_path;
			$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
			$config['max_size']      = 10240; 
			$config['file_name']     = url_title(iconv("UTF-8", "ASCII//TRANSLIT", 'user_' . $basename), '_', TRUE);
			$config['overwrite']     = FALSE;

			return $config;
		}


}
