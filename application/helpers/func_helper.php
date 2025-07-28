<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('datadump'))
{
	function datadump($var) {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}

if ( ! function_exists('dd'))
{
	function dd($var) {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
		exit;
	}
}
