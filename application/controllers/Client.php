<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends MY_Controller
{

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

	public function detail_client($idclients)
	{

		// $this->data['donnee'] = $this->visuels_model->getClientDataByDonnee();
		// $this->data['users'] = $this->Task_model->get_all_users();
		// $this->data['produit'] = $this->Donne_modele->get_all_produit();
		// $this->data['am'] = $this->Donne_modele->get_all_am();
		// $this->data['initiative'] = $this->Donne_modele->get_all_initiative();

		$this->content = "layouts/client/detail.php";
		$this->layout();
	}
	public function insert_client()
		{
			$client = $this->input->post('client');
			$email_client = $this->input->post('email_client');
			$numero_client = $this->input->post('numero_client');
			$dejaclient = $this->input->post('dejaclient');
			$budget = $this->input->post('budget');
			$secteur_activite = $this->input->post('secteur_activite');
			$product_choice = $this->input->post('product_choice');
			$initiative = $this->input->post('initiative');
			$am = $this->input->post('am');
			$date_mis_en_place = $this->input->post('date_mis_en_place');
			$date_brief = $this->input->post('date_brief');
			$date_annonce = $this->input->post('date_annonce');
			$logo = $this->file_upload_field = 'logo';
			$this->form_validation->set_rules('site_client', 'URL', 'required|trim');

			if ($this->form_validation->run() == FALSE) {
				die('Validation échouée : champ site_client requis');
			}

			$site_client = trim($this->input->post('site_client'));
			if (!preg_match('#^https?://#i', $site_client)) {
				$site_client = 'https://' . $site_client;
			}
			$html = file_get_contents($site_client);

			if ($html === FALSE) {
				die("Erreur : impossible d'accéder à l'URL $site_client");
			}
			preg_match('/GTM-[A-Z0-9]+/', $html, $matches);
			$gtm_code = !empty($matches) ? $matches[0] : null;
			$cms = $this->detect_cms($html, $site_client);
			$cms_logo = $this->get_cms_logo($cms);
			$favicon = $this->get_favicon($html, $site_client);
			$idclient = $this->visuels_model->insertclient($client, $site_client, $email_client, $numero_client,$favicon,$cms,$cms_logo);
			$this->visuels_model->insertfiche($idclient, $budget, $secteur_activite, $product_choice, $initiative, $am, $date_mis_en_place, $date_brief, $date_annonce, $dejaclient,$gtm_code);
			redirect('Client');
		}


			private function detect_cms($html, $url) {
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
			}
			$headers = @get_headers($url, 1);
			if ($headers && isset($headers['X-Powered-By'])) {
				return $headers['X-Powered-By'];
			}

			return 'Inconnu ou non détectable automatiquement';
		}
		private function get_cms_logo($cms_name) {
			$cms_logos = [
				'WordPress' => 'wordpress.png',
				'Joomla' => 'joomla.png',
				'Drupal' => 'drupal.png',
				'Shopify' => 'shopify.png',
				'Magento' => 'magento.png'
			];

			foreach ($cms_logos as $key => $file) {
				if (stripos($cms_name, $key) !== false) {
					return base_url('assets/images/cms/' . $file);
				}
			}

			return base_url('assets/images/cms/unknown.png');
		}
		private function get_favicon($html, $url) {
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
}
