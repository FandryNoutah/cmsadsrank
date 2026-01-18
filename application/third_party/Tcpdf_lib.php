<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tcpdf_lib {

    public function __construct()
    {
        // Note le nom du dossier TCPDF-main
        require_once(APPPATH . 'third_party/TCPDF-main/tcpdf.php');
    }

    public function load($orientation = 'P', $unit = 'mm', $format = 'A4')
    {
        return new TCPDF($orientation, $unit, $format, true, 'UTF-8', false);
    }
}
