<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends CI_Controller
{
    public function find_ads()
    {
        // URL à tester (ou via GET ?url=...)
        $url = $this->input->get('url') ?? 'https://www.helenehascoet-hypnose.fr/';

        // 1) récupérer HTML page distante avec cURL (plus robuste que file_get_contents)
        $html = $this->curl_get($url);
        if ($html === false) {
            echo "Impossible de récupérer le contenu de {$url}";
            return;
        }

        // 2) charger la library TagInspector (assure-toi que tu utilises la version avec pattern 'AW-')
        $this->load->library('TagInspector');

        // 3) inspecter la page (cela détectera GTM, AW- dans le HTML, gtag config, etc.)
        $result = $this->taginspector->inspect($html);

        echo "<h3>Results for: {$url}</h3>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";

        // 4) si on trouve des GTM, tenter de charger le gtm.js correspondant et l'analyser
        if (!empty($result['gtm_container_inline']['entries'])) {
            $gtm_ids = [];
            foreach ($result['gtm_container_inline']['entries'] as $e) {
                if (!empty($e['id'])) $gtm_ids[] = $e['id'];
            }
            $gtm_ids = array_unique($gtm_ids);
        } elseif (!empty($result['gtm_script']['entries'])) {
            $gtm_ids = [];
            foreach ($result['gtm_script']['entries'] as $e) {
                if (!empty($e['id'])) $gtm_ids[] = $e['id'];
            }
            $gtm_ids = array_unique($gtm_ids);
        } else {
            $gtm_ids = [];
        }

        if (empty($gtm_ids)) {
            echo "<p>Aucun conteneur GTM détecté. Si Google Ads est injecté côté client, il ne sera pas visible côté serveur.</p>";
            return;
        }

        foreach ($gtm_ids as $gid) {
            echo "<h4>Checking GTM container: {$gid}</h4>";

            // Construire l'URL standard du bootstrap gtm.js
            $gtm_url = "https://www.googletagmanager.com/gtm.js?id=" . urlencode($gid);
            $gtm_js = $this->curl_get($gtm_url);

            if ($gtm_js === false) {
                echo "<p>Impossible de récupérer {$gtm_url}</p>";
                continue;
            }

            // 5) analyser le contenu du gtm.js à la recherche d'indices Google Ads
            $ads_found = $this->detect_google_ads_in_text($gtm_js);

            echo "<pre>";
            print_r($ads_found);
            echo "</pre>";


        }
    }

    private function curl_get($url, $timeout = 15)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // user-agent pour éviter certains blocages
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; TagInspector/1.0)');
        $data = curl_exec($ch);
        $err = curl_errno($ch);
        curl_close($ch);
        if ($err) return false;
        return $data;
    }

    /**
     * Cherche quelques patterns typiques Google Ads dans un texte donné
     */
    private function detect_google_ads_in_text($text)
    {
        $found = [];

        // Patterns à chercher
        $patterns = [
            'aw_id' => '/(AW-\d{6,})/i', // AW-123456789
            'gtag_aw_config' => "/gtag\\(\\s*['\"]config['\"]\\s*,\\s*['\"](AW-[A-Za-z0-9_-]+)['\"]/i",
            'googlesyndication' => '/googlesyndication\.com/i',
            'adsbygoogle' => '/adsbygoogle/i',
            'conversion_id_field' => '/conversion_id\\W*[:=]\\W*(\\d{6,})/i',
            // certains conteneurs stockent les tags en clair (JSON-like)
            'AW_json' => '/"AW-\\d+"/i',
        ];

        foreach ($patterns as $k => $pat) {
            if (preg_match_all($pat, $text, $m)) {
                $found[$k] = array_values(array_unique($m[0]));
            }
        }

        return $found;
    }
}
