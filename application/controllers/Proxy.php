<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proxy extends CI_Controller {
  public function img() {
    $url = $this->input->get('url', TRUE);
    if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) show_404();
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_TIMEOUT => 10,
    ]);
    $data = curl_exec($ch);
    $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);
    if (!$data) show_404();

    header('Content-Type: '.($type ?: 'image/jpeg'));
    header('Access-Control-Allow-Origin: *');
    echo $data;
  }
}
