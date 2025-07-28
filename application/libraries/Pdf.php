<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {

    private $dompdf;

    public function __construct() {
        // Charger l'autoload de DOMPDF
        require_once(APPPATH . 'libraries/dompdf/autoload.inc.php');
        
        // Initialiser les options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);  // Pour le support HTML5
        $options->set('isPhpEnabled', true);  // Si tu veux activer certaines fonctionnalités PHP

        // Créer l'objet Dompdf
        $this->dompdf = new Dompdf($options);
    }

    // Charger le HTML
    public function load_html($html) {
        $this->dompdf->loadHtml($html);
    }

    // Rendu du PDF
    public function render() {
        $this->dompdf->render();
    }

    // Télécharger le PDF
    public function stream($filename = "document.pdf", $options = array()) {
        $this->dompdf->stream($filename, $options);
    }

    // Retourner le PDF sous forme de contenu brut
    public function output() {
        return $this->dompdf->output();
    }
}
