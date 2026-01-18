<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagInspectorHook
{
    public function run()
    {
        $CI = &get_instance();
        // ne pas analyser les requêtes AJAX JSON épurées (optionnel)
        $ct = $CI->output->get_content_type();
        if ($ct && stripos($ct, 'html') === false) {
            return;
        }

        $html = $CI->output->get_output();

        $CI->load->library('TagInspector');
        $result = $CI->taginspector->inspect($html);

        // Exemple : logger dans application/logs (ou autre stockage)
        log_message('debug', 'TagInspector: ' . json_encode($result));

        // Optionnel : ajouter un badge HTML en bas de page en environnement dev
        if (ENVIRONMENT !== 'production') {
            $badge = "<!-- TagInspector: " . htmlspecialchars(json_encode($result)) . " -->";
            $html .= $badge;
            $CI->output->set_output($html);
        }
    }
}
