<?php
class Application_model extends CI_Model {

    public function get_client($id)
    {
        return $this->db->get_where('clients', ['idclients' => $id])->row_array();
    }

    public function update_cmp($id, $cmp)
    {
        $this->db->where('idclients', $id);
        return $this->db->update('clients', ['cmp' => $cmp]);
    }

    public function update_datalayer($id, $datalayer)
    {
        $this->db->where('idclients', $id);
        return $this->db->update('clients', ['datalayer' => $datalayer]);
    }

    /**
     * Détecter le CMP
     */
    public function detect_cmp($url)
{
    $html = $this->fetch_html($url);

    if(!$html){
        return "Impossible d'analyser";
    }

    // 1. DÉTECTION DU CMP
    $cmp_list = [
        'Tarteaucitron' => 'tarteaucitron',
        'Cookiebot'     => 'cookiebot',
        'Didomi'        => 'didomi',
        'Axeptio'       => 'axeptio',
        'OneTrust'      => 'onetrust',
        'Complianz'     => 'complianz',
        'Iubenda'       => 'iubenda'
    ];

    $detected_cmp = null;

    foreach ($cmp_list as $name => $keyword) {
        if (stripos($html, $keyword) !== false) {
            $detected_cmp = $name;
            break;
        }
    }

    if (!$detected_cmp) {
        return "Aucun CMP détecté";
    }

    // 2. DÉTECTION INITIALISATION ACTIVE
    $active_patterns = [
        'Tarteaucitron' => 'tarteaucitron.init',
        'Cookiebot'     => 'CookieConsent',
        'Didomi'        => 'didomiOnReady',
        'Axeptio'       => '__axeptio_sdk',
        'OneTrust'      => 'Optanon',
        'Complianz'     => 'cmplz_cookie_settings',
        'Iubenda'       => 'IubendaConsent'
    ];

    $active = false;

    if (!empty($active_patterns[$detected_cmp])) {
        if (stripos($html, $active_patterns[$detected_cmp]) !== false) {
            $active = true;
        }
    }

    // 3. DÉTECTION D’UNE BANNIÈRE
    $banner_keywords = ['cookie', 'consent', 'banner', 'popup', 'axeptio', 'didomi'];

    foreach ($banner_keywords as $kw) {
        if (preg_match('/id=["\'][^"\']*'.$kw.'[^"\']*["\']/', $html) ||
            preg_match('/class=["\'][^"\']*'.$kw.'[^"\']*["\']/', $html)) {
            $active = true;
        }
    }

    // 4. DÉTECTION DES SCRIPTS BLOQUÉS (RGPD actif)
    if (strpos($html, 'type="text/plain"') !== false) {
        $active = true;
    }

    // 5. RÉSULTAT FINAL
    if ($active) {
        return $detected_cmp . " (actif)";
    } else {
        return $detected_cmp . " (inactif)";
    }
}



    /**
     * Détection du DataLayer
     */
    public function detect_datalayer($url)
    {
        $html = $this->fetch_html($url);

        if(!$html){
            return "Impossible d'analyser";
        }

        // Recherche du mot "dataLayer"
        if(stripos($html, "dataLayer") !== false){
            return "Présent";
        }

        return "Non détecté";
    }


    /**
     * Récupérer le HTML de la page
     */
    private function fetch_html($url)
    {
        if(!preg_match("#^https?://#", $url)){
            $url = "https://" . $url;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}
