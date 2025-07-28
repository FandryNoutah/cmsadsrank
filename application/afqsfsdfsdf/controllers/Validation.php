<?php

class Validation extends CI_Controller
{
	function __construct() {
		parent::__construct();

		require_once FCPATH . 'vendor/autoload.php';

		// Suppression de la bibliothèque ion_auth et de tout code lié à l'authentification
		$this->load->library(array('form_validation')); // Conserver les bibliothèques nécessaires pour la validation des formulaires
		$this->load->helper(array('url', 'language'));
		$this->load->model("panneau_model");
		$this->load->model("Image_model");
		$this->load->model('MaBase');
		$this->load->model('Data_modele');
		$this->load->model('Visuels_model');
		$this->load->model('Donne_modele');
		$this->load->library('upload');
		$this->load->model('visuels_model'); // Ajout du modèle visuels_model si nécessaire
		$this->load->helper(array('form', 'url'));
		$this->load->library('curl');

		$this->path = "assets/images/formats/";
		$this->file_upload_field = "visuel_path";
		// require_once(APPPATH.'third_party/tcpdf/src/tcpdf.php');
		$this->load->library('upload');
		$this->load->library('form_validation');
		// Si vous avez des règles   de validation de formulaire spécifiques, vous pouvez les conserver
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		// Chargement des traductions nécessaires (si des textes sont à afficher en plusieurs langues)
		$this->lang->load('auth');
	}

	public function index() {
		$this->load->view("templates/v3/Datastudio", $this->data);
	}
	public function editextensions($id)
	{
		// Récupérer les données de la campagne

		$this->data["extensions"] = $this->visuels_model->getextensionsByIdc($id);
		$this->load->view("templates/v3/edit_extensions_validation", $this->data);
	}
	public function updateextensions()
	{
		$idclients = $this->input->post('idclients');
		$idextensions = $this->input->post('idextensions');
		$data = array(
			'idextensions' => $this->input->post('idextensions'),
			'titre_extensions' => $this->input->post('titre_extensions'),
			'description_extensions' => $this->input->post('description_extensions'),
			'url_extensions' => $this->input->post('url_extensions'),
			'extensions_accroche' => $this->input->post('extensions_accroche'),
			'extensions_extrait_site' => $this->input->post('extensions_extrait_site'),
			'extensions_lieu' => $this->input->post('extensions_lieu'),
			'extensions_appel' => $this->input->post('extensions_appel')
		);
		$this->Donne_modele->updateextensions($idextensions, $data);
		$this->session->set_flashdata('message-success', 'Extenions mis à jours.');
		redirect('Validation/validation_structure/' . $idclients);
	}
	public function exclusion()
	{
		$exclusion = $this->input->post('exclusion');
		$id = $this->input->post('idclients');
		$id = intval($id);

		$this->visuels_model->exclusion($id, $exclusion);
		$this->session->set_flashdata('message-exclusion', 'Exclusion mis à jours.');
		redirect('Validation/validation_structure/' . $id, 'refresh');
	}
	public function generate_pdf() {
		// Charger la vue HTML avec le contenu que tu veux convertir en PDF
		$html = $this->load->view('ta_vue_avec_tableau', [], TRUE);

		// Charger le HTML dans DOMPDF
		$this->pdf->load_html($html);

		// Générer le PDF
		$this->pdf->render();

		// Télécharger le PDF dans le navigateur
		$this->pdf->stream("campagne_google_ads.pdf", array("Attachment" => 0));
	}
	public function ajouter_images_recup() {
		// Récupérer les images sélectionnées depuis le formulaire
		$selected_images = $this->input->post('selected_images');
		$idgroupe_annone = $this->input->post('idgroupe_annone');
		
		$idclients = $this->input->post('idclients');
	
		// Vérifier si des images ont été sélectionnées
		if ($selected_images) {
			// Insérer les images dans la base de données
			foreach ($selected_images as $image) {
				// Insertion de l'image dans la table 'images_table'
				$data = array(
					'image_url' => $image,  // Enregistrer le chemin de l'image
				);
				$this->db->insert('images', $data);
	
				// Récupérer l'ID de la dernière image insérée
				
				$idimage = $this->db->insert_id();
	
				
				//$this->Image_model->insertidgroupeimagess($idimage, $idgroupe_annone);
				$this->Image_model->insert_image($image, $idclients,$idgroupe_annone, $idimage);  // Insertion avec le chemin d'image, ID client et ID image
			}
	
			// Redirection vers la gestion des images après l'ajout
			redirect('Validation/gestion_image/' . $idgroupe_annone);
		} else {
			// Si aucune image n'est sélectionnée
			echo "Aucune image sélectionnée.";
		}
	}
	public function gestion_image($id) {
		$data['idgroupe_annone'] = $id;
		$b = $data['clients'] = $this->Image_model->getgroupe_annonce($id);

		$a = $data['images'] = $this->Image_model->get_images_by_id($id);
		$domain_name = $this->input->post('domain_name');

		$this->load->helper('url');
			$html = $this->get_html_from_url($domain_name); // Implémenter cette méthode

			// Extraire les images
			$images = $this->extract_images($html, $domain_name);

			// Charger la vue et passer les variables
			$data['html'] = $html;   // Passez la variable $html à la vue
			$data['Images_recup'] = $images;

		$this->load->view('image_list2', $data);
	}
	private function fetch_html($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);
        
        return $html;
    }

// Fonction pour extraire les images depuis le HTML
private function extract_images($html, $url) {
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);

    $images = [];
    foreach ($matches[1] as $src) {
        // Si l'URL est relative, la rendre absolue
        $image_url = (filter_var($src, FILTER_VALIDATE_URL)) ? $src : base_url($src);
        
        // Vérifier si l'URL est valide et bien formée
        $image_url = $this->make_absolute_url($image_url, $url);
        
        // Ajouter l'URL de l'image à la liste
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            $images[] = $image_url;
        }
    }

    return $images;
}

private function get_html_from_url($url) {
    if (!empty($url)): 
    $response = file_get_contents($url);

    // Vérifiez si la réponse est vide ou s'il y a eu une erreur
    if ($response === false) {
        // Si l'URL ne peut pas être récupérée, retourner une chaîne vide ou un message d'erreur
        return "Erreur lors de la récupération du contenu.";
    }

    return $response;
endif;
}

    // Fonction pour transformer une URL relative en URL absolue
    private function make_absolute_url($src, $base_url) {
        if (filter_var($src, FILTER_VALIDATE_URL)) {
            return $src;
        }
        return base_url() . ltrim($src, '/');
    }
	public function add_image() {
		// On récupère l'URL de l'image si elle est envoyée
		$image = $this->input->post('image');
		$idgroupe_annone = $id = $this->input->post('idgroupe_annone');
		$idclients = $this->input->post('idclients');

		// Vérification et téléchargement du logo
		if ($_FILES['image']['name'] != '') {
			$this->upload->initialize($this->set_upload_options("", $_FILES["image"]["name"]));
			if ($this->upload->do_upload('image')) {
				$image_url = $this->path . $this->upload->file_name; // Nouveau logo téléchargé
			}
		}
		$idimage = $this->Image_model->insert_image($image_url, $idclients,$idgroupe_annone, 0);
		$this->Image_model->insertidgroupeimage($idimage, $id);
		redirect('Validation/gestion_image/' . $id, 'refresh');
	}

	// Ajouter une image depuis une URL
	public function add_image_url() {
		$image_url = $this->input->post('image_url');
		$idgroupe_annone = $id = $this->input->post('idgroupe_annone');
		$idclients = $this->input->post('idclients');

		// Vérifier que l'URL n'est pas vide
		if (!empty($image_url)) {
			// Vérifier si l'URL est valide
			if (@getimagesize($image_url)) {
				// Si l'URL est valide et pointe vers une image, insérer dans la base de données
				$idimage = $this->Image_model->insert_image($image_url, $idclients,$idgroupe_annone, 0);
				$this->Image_model->insertidgroupeimage($idimage, $id);
				redirect('Validation/gestion_image/' . $id);
			} else {
				echo "Ce n'est pas une image valide.";
			}
		} else {
			echo "L'URL ne peut pas être vide.";
		}
	}

	// Supprimer une image
	public function delete_image($id) {
		$idgroupe_annonce = $this->Image_model->get_idgroupe_annonceimage($id);

		$this->Image_model->delete_image($id);
		$id = $idgroupe_annonce;
		redirect('Validation/gestion_image/' . $id);
	}

	// Mettre à jour l'ordre des images
	public function update_order() {
		// Récupérer l'ordre des images envoyé via AJAX
		$order = json_decode($this->input->post('order'));

		// Mettre à jour l'ordre des images dans la base de données
		foreach ($order as $index => $id) {
			$this->Image_model->update_rank($id, $index + 1);  // Le rang commence à 1
		}

		echo json_encode(['status' => 'success']);
	}

	public function validation_structure(int $id) {
		// Récupérer les données des campagnes

		$donnees_valider = $this->Donne_modele->getclientvalidation($id);
		$this->data["clients"] = $this->visuels_model->getClientById($id);

		// Récupérer les groupes d'annonces
		$groupes_valider = $this->Donne_modele->getgroupevalidation($id);
		if (!is_array($groupes_valider) || !count($groupes_valider)) {
			redirect('Googleads');
		}

		// Regrouper les groupes d'annonces par campagne
		foreach ($donnees_valider as &$campagne) {
			// Initialiser un tableau pour les groupes d'annonces de cette campagne
			$campagne['groupes_annonces'] = [];

			// Ajouter les groupes d'annonces qui appartiennent à cette campagne
			foreach ($groupes_valider as $groupe) {
				if ($groupe['idcampagne'] == $campagne['idcampagne']) {
					$campagne['groupes_annonces'][] = $groupe;
				}

				if ($groupe['type_campagnes'] == 5) {
					$logo_client = $groupe['logo_client'];
					if (file_exists($logo_client)) {
						$logo_type = mime_content_type($logo_client);
						$logo_data = base64_encode(file_get_contents($logo_client));
						$groupe['logo_client'] = "data:{$logo_type};base64,{$logo_data}";
					} else {
						$groupe['logo_client'] = ''; // Fallback if logo not found
					}
				}
			}
		}

		$idclients = intval($groupes_valider[0]['idclients']);
		$this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);
		$this->data["donne_valider"] = $donnees_valider;
		$this->data["extensions"] = $this->visuels_model->getallextensionsByIdc($id);
		$this->data["groupe_valider"] = $groupes_valider;

		// Encode static logo image to Base64
		$logo_path = FCPATH . IMAGES_PATH . '/logo/logo3.png';
		if (file_exists($logo_path)) {
			$logo_type = mime_content_type($logo_path);
			$logo_data = base64_encode(file_get_contents($logo_path));
			$this->data['logo_base64'] = "data:{$logo_type};base64,{$logo_data}";
		} else {
			$this->data['logo_base64'] = ''; // Fallback if logo not found
		}

		$a = $this->Donne_modele->getpmaxvalider($id);
		if ($a != NULL) {

			$idgroupe_annonce = intval($a[0]['idgroupe_annonce']);
			$images = $this->Image_model->get_images_by_clients($id, $idgroupe_annonce);
			foreach ($images as &$image) {

				$image_path = (strpos($image->image_url, 'http') === 0) ? $image->image_url : FCPATH . $image->image_url;

				if (file_exists($image_path)) {
					$image_type = mime_content_type($image_path);
					$image_data = base64_encode(file_get_contents($image_path));
					$image->image_base64 = "data:{$image_type};base64,{$image_data}";
				} else {
					$image->image_base64 = ''; // Fallback if image not found
				}
			}

			$this->data["images"] = $images;
		}
		$a = $this->Donne_modele->getlocalxvalider($id);

		if ($a != NULL) {

			$idgroupe_annonce = intval($a[0]['idgroupe_annonce']);
		
			$images = $this->Image_model->get_images_by_clients($id, $idgroupe_annonce);
			foreach ($images as &$image) {

				$image_path = (strpos($image->image_url, 'http') === 0) ? $image->image_url : FCPATH . $image->image_url;

				if (file_exists($image_path)) {
					$image_type = mime_content_type($image_path);
					$image_data = base64_encode(file_get_contents($image_path));
					$image->image_base64 = "data:{$image_type};base64,{$image_data}";
				} else {
					$image->image_base64 = ''; // Fallback if image not found
				}
			}
		
			$this->data["images_local"] = $images;
		}
		// Pass the $id to the view
        $this->data['id'] = $id;

		$action = $this->input->get('action');
		$this->data['action'] = $action;
		if ($action === "export") {

			// Chargez la vue HTML à partir de CodeIgniter
			$html = $this->load->view("templates/v3/Validation_structure_pdf", $this->data, TRUE);
			
			// Enregistrez le fichier HTML pour le débogage (optionnel)
			file_put_contents(FCPATH . 'debug.html', $html);
		
			// Initialisez Dompdf
			$dompdf = new \Dompdf\Dompdf();
		
			// Chargez le contenu HTML
			$dompdf->loadHtml($html);
		
			// Configurez les options de Dompdf (si nécessaire)
			$dompdf->setPaper('A4', 'landscape'); // Format A4 en paysage
		
			// Rendu du PDF
			$dompdf->render();
		
			// Nom du fichier à générer (avec timestamp pour éviter les conflits)
			$filename = "Validation_structure_pdf" . date('Ymd_His') . ".pdf";
		
			// Envoyer le fichier PDF directement au navigateur (en mode téléchargement ou prévisualisation)
			$dompdf->stream($filename, array("Attachment" => 0)); // Remplacez "0" par "1" si vous souhaitez forcer le téléchargement
		}
		else {
			$this->load->view("templates/v3/Validation_structure", $this->data);
		}
		
	}
	public function resize_and_compress_image($image_path, $max_width = 400, $max_height = 300, $quality = 30) {
		if (!file_exists($image_path)) {
			return '';
		}
	
		// Obtenir les dimensions et le type d'image
		list($original_width, $original_height, $image_type) = getimagesize($image_path);
	
		// Calculer les nouvelles dimensions
		$ratio = min($max_width / $original_width, $max_height / $original_height);
		$new_width = (int)($original_width * $ratio);
		$new_height = (int)($original_height * $ratio);
	
		// Créer une image vide (fond blanc pour éviter la transparence)
		$new_image = imagecreatetruecolor($new_width, $new_height);
		$white = imagecolorallocate($new_image, 255, 255, 255);
		imagefill($new_image, 0, 0, $white);
	
		// Créer l'image source selon le type
		switch ($image_type) {
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($image_path);
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($image_path);
				break;
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif($image_path);
				break;
			default:
				return '';
		}
	
		// Redimensionnement
		imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
	
		// Conversion en JPEG avec compression forte
		ob_start();
		imagejpeg($new_image, null, $quality);
		$compressed_image_data = ob_get_clean();
	
		// Nettoyer
		imagedestroy($new_image);
		imagedestroy($image);
	
		// Retourner en base64
		return 'data:image/jpeg;base64,' . base64_encode($compressed_image_data);
	}
	

    public function export_rendu($id) {
        // Assurez-vous que $html est bien défini avant de l'utiliser
        $donnees_valider = $this->Donne_modele->getclientvalidation($id);
        $groupes_valider = $this->Donne_modele->getgroupevalidation($id);

        if (!is_array($groupes_valider) || !count($groupes_valider)) {
            redirect('Googleads');
        }

        // Regrouper les groupes d'annonces par campagne
        foreach ($donnees_valider as &$campagne) {
            $campagne['groupes_annonces'] = [];
            foreach ($groupes_valider as $groupe) {
                if ($groupe['idcampagne'] == $campagne['idcampagne']) {
                    $campagne['groupes_annonces'][] = $groupe;
                }
				$c = $this->visuels_model->getClientById($id);
				$c = $c[0]['logo_client'];
				
			

                if ($groupe['type_campagnes'] == 3) {
                    $logo_client = $c;
                    if (file_exists($c)) {
                        $logo_type = mime_content_type($c);
                        $logo_data = base64_encode(file_get_contents($c));
						$logoclient = $groupe['logo_client'] = "data:{$logo_type};base64,{$logo_data}";
                    } else {
                       $groupe['logo_client'] = ''; 
                    }
				
                }
            }
        }
		$this->data["logoclient"] = $logoclient;

        // Récupérer les exclusions et autres données
        $idclients = intval($groupes_valider[0]['idclients']);
        $id = $idclients;
        $CL = $this->data["clients"] = $this->visuels_model->getClientById($id);
        $this->data["exlusions"] = $this->Visuels_model->get_exclusions($idclients);
        $this->data["donne_valider"] = $donnees_valider;
        $this->data["extensions"] = $this->visuels_model->getallextensionsByIdc($id);
        $this->data["groupe_valider"] = $groupes_valider;

        // Logo client
        $logo_path = FCPATH . IMAGES_PATH . '/logo/logo3.png';
        if (file_exists($logo_path)) {
            $logo_type = mime_content_type($logo_path);
            $logo_data = base64_encode(file_get_contents($logo_path));
            $this->data['logo_base64'] = "data:{$logo_type};base64,{$logo_data}";
        } else {
            $this->data['logo_base64'] = ''; 
        }
        $youtube = FCPATH . IMAGES_PATH. '/youtube.jpg';
        if (file_exists($youtube)) {
            $youtube_type = mime_content_type($youtube);
            $youtube_data = base64_encode(file_get_contents($youtube));
            $this->data['youtube_base64'] = "data:{$youtube_type};base64,{$youtube_data}";
        } else {
            $this->data['youtube_base64'] = ''; 
        }
		$youtube2 = FCPATH . IMAGES_PATH. '/footeryoutube.jpg';
        if (file_exists($youtube2)) {
            $youtube2_type = mime_content_type($youtube2);
            $youtube2_data = base64_encode(file_get_contents($youtube2));
            $this->data['youtube2_base64'] = "data:{$youtube2_type};base64,{$youtube2_data}";
        } else {
            $this->data['youtube2_base64'] = ''; 
        }
		$entetegmail = FCPATH . IMAGES_PATH. '/entetegmail.jpg';
        if (file_exists($entetegmail)) {
            $entetegmail_type = mime_content_type($entetegmail);
            $entetegmail_data = base64_encode(file_get_contents($entetegmail));
            $this->data['entetegmail_base64'] = "data:{$entetegmail_type};base64,{$entetegmail_data}";
        } else {
            $this->data['entetegmail_base64'] = ''; 
        }
		$recherchegmail = FCPATH . IMAGES_PATH. '/recherchegmail.jpg';
        if (file_exists($recherchegmail)) {
            $recherchegmail_type = mime_content_type($recherchegmail);
            $recherchegmail_data = base64_encode(file_get_contents($recherchegmail));
            $this->data['recherchegmail_base64'] = "data:{$recherchegmail_type};base64,{$recherchegmail_data}";
        } else {
            $this->data['recherchegmail_base64'] = ''; 
        }
		$troiepoint = FCPATH . IMAGES_PATH. '/troiepoint.jpg';
        if (file_exists($troiepoint)) {
            $troiepoint_type = mime_content_type($troiepoint);
            $troiepoint_data = base64_encode(file_get_contents($troiepoint));
            $point = $this->data['troiepoint_base64'] = "data:{$troiepoint_type};base64,{$troiepoint_data}";
        } else {
            $this->data['troiepoint_base64'] = ''; 
        }

        // Images liées aux groupes d'annonces
        $a = $this->Donne_modele->getpmaxvalider($id);
        if ($a != NULL) {
            $idgroupe_annonce = intval($a[0]['idgroupe_annonce']);
            $images = $this->Image_model->get_images_by_clients($id, $idgroupe_annonce);

            foreach ($images as &$image) {
                // Détermine si l'URL est complète ou un chemin local
                $image_path = (strpos($image->image_url, 'http') === 0) ? $image->image_url : FCPATH . $image->image_url;
            
                // Si l'image est locale
                if (strpos($image->image_url, 'http') !== 0) {
                    // Redimensionner et compresser l'image avant de la convertir en base64
                    $image->image_base64 = $this->resize_and_compress_image($image_path, 800, 600, 75); // Limite la taille à 800x600 et qualité à 75
                } else {
                    // Si c'est une image distante
                    $image_data = @file_get_contents($image->image_url);
            
                    // Vérifie si le contenu a bien été récupéré
                    if ($image_data !== false) {
                        // Utiliser getimagesizefromstring pour obtenir le type MIME de l'image
                        $image_info = getimagesizefromstring($image_data);
            
                        // Si les informations de l'image ont été récupérées
                        if ($image_info !== false) {
                            $image_type = $image_info['mime']; // Le type MIME est dans l'index 'mime'
                            $image->image_base64 = "data:{$image_type};base64," . base64_encode($image_data); // Convertir l'image en base64
                        } else {
                            $image->image_base64 = ''; // Si l'image est invalide
                        }
                    } else {
                        $image->image_base64 = ''; // Si file_get_contents échoue
                        log_message('error', "Erreur lors de la récupération de l'image distante: " . $image->image_url);
                    }
                }
            }
            // Assigner les images traitées à la vue
            $this->data["images"] = $images;
        }
		if ($a == NULL) {
			$this->data["images"] = NULL;
		}

        // Localisation et images locales
        $b = $this->Donne_modele->getlocalxvalider($id);
        if ($b != NULL) {
            $idgroupe_annonce = intval($a[0]['idgroupe_annonce']);
            $images = $this->Image_model->get_images_by_clients($id, $idgroupe_annonce);

            foreach ($images as &$image) {
                // Détermine si l'URL est complète ou un chemin local
                $image_path = (strpos($image->image_url, 'http') === 0) ? $image->image_url : FCPATH . $image->image_url;
            
                // Si l'image est locale
                if (strpos($image->image_url, 'http') !== 0) {
                    // Redimensionner et compresser l'image avant de la convertir en base64
                    $image->image_base64 = $this->resize_and_compress_image($image_path, 800, 600, 75); // Limite la taille à 800x600 et qualité à 75
                } else {
                    // Si c'est une image distante
                    $image_data = @file_get_contents($image->image_url);
            
                    // Vérifie si le contenu a bien été récupéré
                    if ($image_data !== false) {
                        // Utiliser getimagesizefromstring pour obtenir le type MIME de l'image
                        $image_info = getimagesizefromstring($image_data);
            
                        // Si les informations de l'image ont été récupérées
                        if ($image_info !== false) {
                            $image_type = $image_info['mime']; // Le type MIME est dans l'index 'mime'
                            $image->image_base64 = "data:{$image_type};base64," . base64_encode($image_data); // Convertir l'image en base64
                        } else {
                            $image->image_base64 = ''; // Si l'image est invalide
                        }
                    } else {
                        $image->image_base64 = ''; // Si file_get_contents échoue
                        log_message('error', "Erreur lors de la récupération de l'image distante: " . $image->image_url);
                    }
                }
            }
            // Assigner les images traitées à la vue
            $this->data["images_local"] = $images;
        }
		if ($b == NULL) {
			$this->data["images_local"] = NULL;
		}

        $action = $this->input->get('action');
        $this->data['action'] = $action;

        // Assurez-vous que les données sont bien passées
        $this->data['id'] = $id;
        $html = $this->load->view('templates/v3/Validation_structure_pdf', $this->data, true); // Charger le HTML via une vue

        // Initialisez Dompdf
        $dompdf = new \Dompdf\Dompdf();

        // Chargez le contenu HTML
        $dompdf->loadHtml($html);

        // Configurez les options de Dompdf (si nécessaire)
        $dompdf->setPaper('A4', 'landscape'); // Format A4 en paysage

        $CL = $CL[0]['nom_client'];
        $dompdf->render();
        $dompdf->stream("Validation-structure-" .  $CL . " .pdf", array("Attachment" => 0));
    }
	public function editcampagne($id) {
		// Récupérer les données de la campagne
		$t = $this->data["campagne"] = $this->visuels_model->getCAMPAGNEByIdc($id);
		$t = $t[0]['idcampagne'];

		// Récupérer les groupes d'annonces
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdg($id);

		// Charger la vue pour éditer la campagne
		$this->load->view("templates/v3/edit_campagne_structure", $this->data);
	}


	public function editgroupesearch($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);

		$this->load->view("templates/v3/edit_groupe_structure_search", $this->data);
	}

	public function editgroupelocal($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);

		$this->load->view("templates/v3/edit_groupe_structure_local", $this->data);
	}

	public function editgroupepmax($id) {
		$this->data["campagne"] = $this->visuels_model->getCampagneById($id);
		$this->data["campagnes"] = $this->visuels_model->getcampagne_Groupe_annonce_briefById($id);
		$ko = $this->visuels_model->getClientById($id);
		$this->data["donnees"] = $this->visuels_model->getDonneeById($id);
		$this->data["client"] = $ko;
		$t = $this->data["groupe"] = $this->visuels_model->getgpid($id);

		$this->load->view("templates/v3/edit_groupe_structure_local", $this->data);
	}

	public function editgroupe($id) {
		$q = $this->data["groupe"] = $this->visuels_model->getgRoupeannonceByIdgs($id);

		// Charger la vue pour éditer la campagne
		$this->load->view("templates/v3/edit_groupe_structure", $this->data);
	}

	public function save_groupe_search() {
		// Récupérer les données envoyées via POST
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');

		// Récupérer les titres et descriptions (dynamique de 1 à 12 pour les titres et 1 à 4 pour les descriptions)
		$titre1 = $this->input->post('titre1');
		$titre2 = $this->input->post('titre2');
		$titre3 = $this->input->post('titre3');
		$titre4 = $this->input->post('titre4');
		$titre5 = $this->input->post('titre5');
		$titre6 = $this->input->post('titre6');
		$titre7 = $this->input->post('titre7');
		$titre8 = $this->input->post('titre8');
		$titre9 = $this->input->post('titre9');
		$titre10 = $this->input->post('titre10');
		$titre11 = $this->input->post('titre11');
		$titre12 = $this->input->post('titre12');

		// Récupérer les descriptions explicitement sans boucle
		$description1 = $this->input->post('description1');
		$description2 = $this->input->post('description2');
		$description3 = $this->input->post('description3');
		$description4 = $this->input->post('description4');

		// Récupérer les autres champs
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$url = $this->input->post('url');

		// Données à mettre à jour
		$groupe_data = [
			'idgroupe_annonce' => $idgroupe_annonce,
			'idclients' => $idclients,
			'type_campagnes' => $type_campagne,
			'nom_groupe' => $nom_groupe,
			'titre1' => $titre1,
			'titre2' => $titre2,
			'titre3' => $titre3,
			'titre4' => $titre4,
			'titre5' => $titre5,
			'titre6' => $titre6,
			'titre7' => $titre7,
			'titre8' => $titre8,
			'titre9' => $titre9,
			'titre10' => $titre10,
			'titre11' => $titre11,
			'titre12' => $titre12,
			// Descriptions individuelles
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'chemin1' => $chemin1,
			'chemin2' => $chemin2,
			'url_groupe_annonce' => $url
		];

		// Appeler la fonction de mise à jour dans le modèle
		$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
		redirect('Validation/validation_structure/' . $idclients);
	}

	public function save_groupe_local() {
		// Récupérer les données envoyées via POST
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');

		// Récupérer les titres et descriptions (dynamique de 1 à 12 pour les titres et 1 à 4 pour les descriptions)
		$titre1 = $this->input->post('titre1');
		$titre2 = $this->input->post('titre2');
		$titre3 = $this->input->post('titre3');
		$titre4 = $this->input->post('titre4');
		$titre5 = $this->input->post('titre5');
		$titre6 = $this->input->post('titre6');
		$titre7 = $this->input->post('titre7');
		$titre8 = $this->input->post('titre8');
		$titre9 = $this->input->post('titre9');
		$titre10 = $this->input->post('titre10');
		$titre11 = $this->input->post('titre11');
		$titre12 = $this->input->post('titre12');

		// Récupérer les descriptions explicitement sans boucle
		$description1 = $this->input->post('description1');
		$description2 = $this->input->post('description2');
		$description3 = $this->input->post('description3');
		$description4 = $this->input->post('description4');

		// Récupérer les autres champs
		$description_breve = $this->input->post('description_breve');
		$url = $this->input->post('url');

		// Données à mettre à jour
		$groupe_data = [
			'idgroupe_annonce' => $idgroupe_annonce,
			'idclients' => $idclients,
			'type_campagnes' => $type_campagne,
			'nom_groupe' => $nom_groupe,
			'titre1' => $titre1,
			'titre2' => $titre2,
			'titre3' => $titre3,
			'titre4' => $titre4,
			'titre5' => $titre5,
			'titre6' => $titre6,
			'titre7' => $titre7,
			'titre8' => $titre8,
			'titre9' => $titre9,
			'titre10' => $titre10,
			'titre11' => $titre11,
			'titre12' => $titre12,
			// Descriptions individuelles
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'description_breve' => $description_breve,
			'url_groupe_annonce' => $url
		];

		// Appeler la fonction de mise à jour dans le modèle
		$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
		redirect('Validation/validation_structure/' . $idclients);
	}

	public function save_groupe_pmax() {
		// Récupérer les données envoyées via POST
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');

		// Récupérer les titres et descriptions (dynamique de 1 à 12 pour les titres et 1 à 4 pour les descriptions)
		$titre1 = $this->input->post('titre1');
		$titre2 = $this->input->post('titre2');
		$titre3 = $this->input->post('titre3');
		$titre4 = $this->input->post('titre4');
		$titre5 = $this->input->post('titre5');
		$titre6 = $this->input->post('titre6');
		$titre7 = $this->input->post('titre7');
		$titre8 = $this->input->post('titre8');
		$titre9 = $this->input->post('titre9');
		$titre10 = $this->input->post('titre10');
		$titre11 = $this->input->post('titre11');
		$titre12 = $this->input->post('titre12');

		// Récupérer les descriptions explicitement sans boucle
		$description1 = $this->input->post('description1');
		$description2 = $this->input->post('description2');
		$description3 = $this->input->post('description3');
		$description4 = $this->input->post('description4');

		// Récupérer les autres champs
		$description_breve = $this->input->post('description_breve');
		$url = $this->input->post('url');

		// Données à mettre à jour
		$groupe_data = [
			'idgroupe_annonce' => $idgroupe_annonce,
			'idclients' => $idclients,
			'type_campagnes' => $type_campagne,
			'nom_groupe' => $nom_groupe,
			'titre1' => $titre1,
			'titre2' => $titre2,
			'titre3' => $titre3,
			'titre4' => $titre4,
			'titre5' => $titre5,
			'titre6' => $titre6,
			'titre7' => $titre7,
			'titre8' => $titre8,
			'titre9' => $titre9,
			'titre10' => $titre10,
			'titre11' => $titre11,
			'titre12' => $titre12,
			// Descriptions individuelles
			'descriptions1' => $description1,
			'descriptions2' => $description2,
			'descriptions3' => $description3,
			'descriptions4' => $description4,
			'description_breve' => $description_breve,
			'url_groupe_annonce' => $url
		];

		// Appeler la fonction de mise à jour dans le modèle
		$this->visuels_model->update_group($idgroupe_annonce, $groupe_data);
		redirect('Validation/validation_structure/' . $idclients);
	}

	public function updateDonneeClient() {
		// Récupérer les données postées
		$idcampagne = $this->input->post('idcampagne');
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$id = $this->input->post('idclients');
		$zones = $this->input->post('zones');
		$date_campagne = $this->input->post('date_campagne');
		$nom_groupe = $this->input->post('nom_groupe');
		$appareil = $this->input->post('appareil');
		$budget = $this->input->post('budget');
		$nom_campagne = $this->input->post('nom_campagne');
		$mot_cle = $this->input->post('mot_cle');

		$this->visuels_model->updatescampagnes($zones, $date_campagne, $appareil, $budget, $idcampagne);
		$this->visuels_model->updatesgroupe($nom_groupe, $mot_cle, $idgroupe_annonce);

		// Rediriger vers la méthode validation_structure avec l'id du client
		redirect('Validation/validation_structure/' . $id);
	}

	public function updateDonneeClients() {
		$idgroupe_annonce = $this->input->post('idgroupe_annonce');
		$idcampagne = $this->input->post('idcampagne');
		$idclients = $this->input->post('idclients');
		$type_campagne = $this->input->post('type_campagne');
		$nom_groupe = $this->input->post('nom_groupe');
		$titre1 = $this->input->post('titre1');
		$titre2 = $this->input->post('titre2');
		$titre3 = $this->input->post('titre3');
		$titre4 = $this->input->post('titre4');
		$titre5 = $this->input->post('titre5');
		$titre6 = $this->input->post('titre6');
		$titre7 = $this->input->post('titre7');
		$titre8 = $this->input->post('titre8');
		$titre9 = $this->input->post('titre9');
		$titre10 = $this->input->post('titre10');
		$titre11 = $this->input->post('titre11');
		$titre12 = $this->input->post('titre12');
		$description1 = $this->input->post('description1');
		$description2 = $this->input->post('description2');
		$description3 = $this->input->post('description3');
		$description4 = $this->input->post('description4');
		$description_breve = $this->input->post('description_breve');
		$chemin1 = $this->input->post('chemin1');
		$chemin2 = $this->input->post('chemin2');
		$url = $this->input->post('url');

		// Mettre à jour les données de la campagne et des groupes d'annonces
		$this->visuels_model->updatescampagne($zones, $date_campagne, $appareil, $budget, $idcampagne);
		$this->visuels_model->updatesgroupe($nom_groupe, $mot_cle, $idgroupe_annonce);

		// Rediriger vers la méthode validation_structure avec l'id du client
		redirect('Validation/validation_structure/' . $id);
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
