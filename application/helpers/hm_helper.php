<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('format_date'))
{
	function format_date($date) {
		$dateArray = explode("-", $date);
		$monthArray = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
		$datestring = $dateArray[2] . " " . $monthArray[intval($dateArray[1] - 1)] . " " . $dateArray[0];
		return $datestring; 
	}
}

if ( ! function_exists('format_col_header'))
{
	function format_col_header($header) {
		$headerArray = explode("_", $header);
		unset($headerArray[0]);
		$headerArray = implode(" ", $headerArray);
		return strtoupper($headerArray);
	}
}