<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Inclure l'autoloader de Dompdf
require_once(APPPATH . 'libraries/dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf extends Dompdf
{
    public function __construct()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans'); 

        parent::__construct($options);
    }
}
