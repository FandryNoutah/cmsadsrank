<?php
defined('BASEPATH') or exit('No direct script access allowed');

$vendorAutoload = FCPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (!file_exists($vendorAutoload)) {
    log_message('error', 'vendor/autoload.php introuvable : ' . $vendorAutoload);
    show_error(
        "Dépendances Composer manquantes. Exécuter `composer require phpoffice/phpspreadsheet` dans le dossier racine du projet.",
        500,
        'Dépendances manquantes'
    );
    exit;
}
require_once $vendorAutoload;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Site_erreur extends MY_Controller
{
    // Patterns pour détecter pages par défaut / parking
    private $default_page_patterns = [
        '/apache2 Ubuntu Default Page/i' => 'Apache default page',
        '/it works/i' => 'Server default message',
        '/welcome to nginx/i' => 'Nginx default page',
        '/index of \//i' => 'Directory listing',
        '/this domain is parked/i' => 'Domain parked',
        '/suspended domain/i' => 'Domain suspended',
        '/plesk/i' => 'Plesk default page',
        '/directadmin/i' => 'DirectAdmin default page',
        '/default web site page/i' => 'Hosting default page',
        '/provided by your hosting provider/i' => 'Hosting provider default page',
        '/this site has been suspended/i' => 'Hosting suspended',
        '/forbidden/i' => 'Forbidden (text)',
        '/403 Forbidden/i' => '403 Forbidden (text)'
    ];

    // Options cURL (initialisées dans le constructeur)
    private $curl_opts = [];

    protected $file_upload_field;
    protected $path;

    public function __construct()
    {
        parent::__construct();

        // Initialisation safe des options cURL (verify_ssl déterminé au runtime)
        $this->curl_opts = [
            'connect_timeout' => 5,
            'timeout' => 10,
            'user_agent' => 'Mozilla/5.0 (compatible; SiteChecker/1.0; +https://example.com)',
            // verification SSL activée en production
            'verify_ssl' => (defined('ENVIRONMENT') && ENVIRONMENT === 'production')
        ];

        // charger les modèles
        $this->load->model("visuels_model");
        $this->load->model("concurrent");
        $this->load->model("Donne_modele");
        $this->load->model("Data_modele");
        $this->load->model("Image_model");
        $this->load->model("Message_model");
        $this->load->model("Task_model");
        $this->load->model("Note_model");
        $this->load->model("Discussion_model");
        $this->load->model("Gtm_model");
        $this->load->model("Application_model");

        $this->data['visuels'] = $this->visuels_model->get_all();
        $this->load->helper(['form', 'url']);
        $this->load->library('curl');
        $this->path = "assets/images/formats/";
        $this->file_upload_field = "visuel_path";
        $this->load->database();
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        // utilisateur courant
        $this->current_user = $this->ion_auth->user()->row();
    }

    /**
     * Page d'affichage : n'affiche que les clients avec erreur_url non vide
     */
    public function index()
    {
        $this->data['donnee'] = $this->db
            ->select('*')
            ->from('clients')
            ->where("erreur_url IS NOT NULL AND erreur_url <> ''")
            ->order_by('nom_client', 'asc')
            ->get()
            ->result();

        $this->data['users'] = $this->Task_model->get_all_users();
        $this->data['produit'] = $this->Donne_modele->get_all_produit();
        $this->data['am'] = $this->Donne_modele->get_all_am();
        $this->data['initiative'] = $this->Donne_modele->get_all_initiative();

        $this->content = "layouts/site_erreur/index.php";
        $this->layout();
    }

    /**
     * Retourne la liste des sites en erreur à partir d'un tableau d'objets $donnees
     */
    private function scan_sites_for_errors($donnees)
    {
        $liste_site_erreur = [];

        foreach ($donnees as $d) {
            $site = isset($d->site_client) ? trim($d->site_client) : '';
            $id   = isset($d->idonnee) ? $d->idonnee : (isset($d->idclients) ? $d->idclients : null);
            $nom  = isset($d->nom_client) ? $d->nom_client : (isset($d->nom) ? $d->nom : '');

            if (empty($site)) {
                continue;
            }

            $res = $this->check_site_url($site);

            if (!empty($res['error_type']) || !empty($res['message'])) {
                $liste_site_erreur[] = [
                    'idonnee'     => $id,
                    'nom_client'  => $nom,
                    'site_client' => $site,
                    'url_testee'  => $res['url_testee'] ?? $site,
                    'http_code'   => $res['http_code'] ?? 0,
                    'error_type'  => $res['error_type'],
                    'message'     => $res['message'],
                    'body_snippet'=> $res['body_snippet'] ?? ''
                ];
            }
        }

        $this->data['liste_site_erreur'] = $liste_site_erreur;
        return $liste_site_erreur;
    }

    /**
     * Vérifie une URL et retourne un tableau décrivant le statut
     */
    private function check_site_url($site)
    {
        $site = trim((string)$site);
        if ($site === '') {
            return [
                'http_code' => 0,
                'error_type' => 'empty_url',
                'message' => 'URL vide',
                'body_snippet' => '',
                'url_testee' => $site
            ];
        }

        // Normaliser (ajouter scheme si absent)
        $url = preg_match('#^https?://#i', $site) ? $site : 'http://' . $site;
        $url_testee = $url;

        // Vérifier host interne
        $parts = @parse_url($url);
        $host = $parts['host'] ?? null;
        if ($host && $this->is_internal_host($host)) {
            return [
                'http_code' => 0,
                'error_type' => 'internal_host',
                'message' => 'Hôte interne ignoré',
                'body_snippet' => '',
                'url_testee' => $url_testee
            ];
        }

        // Préparer cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // FOLLOWLOCATION only if allowed
        if (!ini_get('open_basedir')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, (int)$this->curl_opts['connect_timeout']);
        curl_setopt($ch, CURLOPT_TIMEOUT, (int)$this->curl_opts['timeout']);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->curl_opts['user_agent']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->curl_opts['verify_ssl']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->curl_opts['verify_ssl'] ? 2 : 0);

        $body = curl_exec($ch);
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $body_snippet = is_string($body) ? mb_substr(strip_tags($body), 0, 500) : '';

        if ($errno) {
            log_message('warning', "Site_erreur::check_site_url cURL error for {$url} : ({$errno}) {$errstr}");
            return [
                'http_code' => 0,
                'error_type' => 'curl_error',
                'message' => "cURL error ({$errno}): {$errstr}",
                'body_snippet' => $body_snippet,
                'url_testee' => $url_testee
            ];
        }

        if ($http_code >= 400) {
            return [
                'http_code' => $http_code,
                'error_type' => 'http_error',
                'message' => "HTTP status code {$http_code}",
                'body_snippet' => $body_snippet,
                'url_testee' => $url_testee
            ];
        }

        $body_plain = is_string($body) ? trim(strip_tags($body)) : '';
        if ($body_plain === '') {
            return [
                'http_code' => $http_code,
                'error_type' => 'empty_body',
                'message' => 'Réponse vide',
                'body_snippet' => $body_snippet,
                'url_testee' => $url_testee
            ];
        }

        foreach ($this->default_page_patterns as $pattern => $label) {
            if (preg_match($pattern, $body)) {
                return [
                    'http_code' => $http_code,
                    'error_type' => 'default_page',
                    'message' => $label,
                    'body_snippet' => $body_snippet,
                    'url_testee' => $url_testee
                ];
            }
        }

        if (mb_strlen($body_plain) < 50) {
            return [
                'http_code' => $http_code,
                'error_type' => 'suspicious_content',
                'message' => 'Contenu très court / page minimale détectée',
                'body_snippet' => $body_snippet,
                'url_testee' => $url_testee
            ];
        }

        // OK
        return [
            'http_code' => $http_code,
            'error_type' => null,
            'message' => null,
            'body_snippet' => $body_snippet,
            'url_testee' => $url_testee
        ];
    }

    /**
     * Détecte si l'hôte est local / privé (localhost, 127.0.0.1, IP privées)
     */
    private function is_internal_host($host)
    {
        $h = strtolower((string)$host);
        if (in_array($h, ['localhost', '127.0.0.1', '::1'], true)) {
            return true;
        }
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $ipLong = ip2long($host);
            if ($ipLong === false) return false;

            $privateRanges = [
                ['start' => ip2long('10.0.0.0'), 'end' => ip2long('10.255.255.255')],
                ['start' => ip2long('172.16.0.0'), 'end' => ip2long('172.31.255.255')],
                ['start' => ip2long('192.168.0.0'), 'end' => ip2long('192.168.255.255')]
            ];
            foreach ($privateRanges as $r) {
                if ($ipLong >= $r['start'] && $ipLong <= $r['end']) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Endpoint appelé par le bouton "Mettre à jour" (AJAX).
     * Politique d'accès : admin OR membre d'un groupe autorisé OR adresse e-mail listée OR (mode debug) tout utilisateur connecté.
     */
    public function update_sites_error()
    {
        // Requête AJAX uniquement
        if (!$this->input->is_ajax_request()) {
            show_error('Accès non autorisé', 403);
            return;
        }

        // --- Politique d'accès configurable ---
        $allow_logged_in_for_debug = true; // <--- passe à false en production
        $allowed_groups = ['webmaster', 'admin', 'it']; // noms de groupes Ion Auth autorisés
        $allowed_emails = ['mavreen.bassin@adsrank.fr'];    // e-mails autorisés (optionnel)
        // ---------------------------------------

        // récupérer utilisateur et ses groupes pour debug/log
        $user = $this->ion_auth->user()->row();
        $groups = $user ? $this->ion_auth->get_users_groups($user->id)->result() : [];

        log_message('debug', 'Site_erreur::update_sites_error - user=' . print_r($user, true));
        log_message('debug', 'Site_erreur::update_sites_error - user groups=' . print_r($groups, true));

        $has_access = false;

        // admin ?
        if ($this->ion_auth->is_admin()) {
            $has_access = true;
        }

        // membre d'un groupe autorisé ?
        if (! $has_access && $user) {
            foreach ($allowed_groups as $g) {
                if ($this->ion_auth->in_group($g, $user->id)) {
                    $has_access = true;
                    break;
                }
            }
        }

        // email autorisé ?
        if (! $has_access && $user && !empty($allowed_emails)) {
            if (in_array(strtolower($user->email), array_map('strtolower', $allowed_emails), true)) {
                $has_access = true;
            }
        }

        // debug : autoriser tout utilisateur connecté si activé (définir à false ensuite)
        if (! $has_access && $allow_logged_in_for_debug) {
            if ($this->ion_auth->logged_in()) {
                $has_access = true;
            }
        }

        if (! $has_access) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'msg' => 'Accès refusé - privilèges insuffisants',
                    // debug info (ne pas laisser en prod si sensibles)
                    'debug' => [
                        'user_id' => $user->id ?? null,
                        'user_email' => $user->email ?? null,
                        'user_groups' => array_map(function($g){ return $g->name ?? ''; }, $groups)
                    ]
                ]));
            return;
        }

        // Récupérer clients
        $clients = $this->db->select('*')->from('clients')->get()->result();
        $liste_erreurs = [];

        foreach ($clients as $c) {
            $site = isset($c->site_client) ? $c->site_client : '';
            $id = isset($c->idclients) ? (int)$c->idclients : 0;

            $res = $this->check_site_url($site);

            // Construire message pour erreur_url (vide si OK)
            $err_msg = '';
            if (!empty($res['error_type']) || !empty($res['message'])) {
                $err_msg = trim(($res['error_type'] ?? '') . ($res['message'] ? ' - ' . $res['message'] : ''));
                if (mb_strlen($err_msg) > 250) {
                    $err_msg = mb_substr($err_msg, 0, 247) . '...';
                }
            }

            // Mettre à jour DB (erreur_url)
            if ($id > 0) {
                $ok = $this->db->where('idclients', $id)->update('clients', ['erreur_url' => $err_msg]);
                if ($ok === false) {
                    log_message('error', "Site_erreur::update_sites_error - échec update idclients={$id}");
                }
            }

            // Ajouter à la liste renvoyée si erreur présente
            if ($err_msg !== '') {
                $liste_erreurs[] = [
                    'idclients' => $id,
                    'nom_client' => $c->nom_client,
                    'site_client' => $site,
                    'http_code' => $res['http_code'] ?? 0,
                    'error_type' => $res['error_type'] ?? null,
                    'message' => $res['message'] ?? null
                ];
            }
        }

// Réponse JSON — envoyer proprement et arrêter l'exécution immédiatement
header('Content-Type: application/json; charset=utf-8');

// Utiliser echo + exit garantit qu'aucun autre HTML ne sera ajouté (même si un hook/layout se lance)
echo json_encode(['success' => false, 'msg' => 'Accès refusé - privilèges insuffisants']);
exit;

// IMPORTANT : arrêter le script pour éviter rendu/layout additionnel
exit;

    }
}
