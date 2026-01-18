<?php
// templates/v3/Search.php
defined('BASEPATH') OR exit('No direct script access allowed');

// Base pour images relatives (où se trouvent tes "img/...")
$img_base = base_url('assets/css/pmax/'); // ex: http://localhost/cmsadsrank/assets/css/search/

// Helper local : convertit un chemin relatif 'img/foo.svg' en URL complète
if (!function_exists('encode_image_to_base64')) {
  function encode_image_to_base64($path) {
      if (empty($path)) return '';
      
      // Si c'est déjà une data URI, on la garde
      if (strpos($path, 'data:') === 0) return $path;
      
      // Normaliser le chemin
      $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
      
      // Si c'est une URL HTTP/HTTPS, on essaie de la convertir en chemin local
      if (preg_match('#^(https?:)?//#i', $path)) {
          $base_path = str_replace(base_url(), FCPATH, $path);
          $base_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $base_path);
          
          if (file_exists($base_path) && is_readable($base_path)) {
              $data = file_get_contents($base_path);
              if ($data !== false) {
                  if (function_exists('finfo_open')) {
                      $finfo = finfo_open(FILEINFO_MIME_TYPE);
                      $mime = finfo_file($finfo, $base_path);
                      finfo_close($finfo);
                  } else {
                      $ext = strtolower(pathinfo($base_path, PATHINFO_EXTENSION));
                      $map = ['png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'svg' => 'image/svg+xml', 'webp' => 'image/webp'];
                      $mime = $map[$ext] ?? 'application/octet-stream';
                  }
                  return 'data:' . $mime . ';base64,' . base64_encode($data);
              }
          }
          return $path;
      }
      
      // Si c'est un chemin local, on le convertit en base64
      if (file_exists($path) && is_readable($path)) {
          $data = file_get_contents($path);
          if ($data !== false) {
              if (function_exists('finfo_open')) {
                  $finfo = finfo_open(FILEINFO_MIME_TYPE);
                  $mime = finfo_file($finfo, $path);
                  finfo_close($finfo);
              } else {
                  $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                  $map = ['png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'svg' => 'image/svg+xml', 'webp' => 'image/webp'];
                  $mime = $map[$ext] ?? 'application/octet-stream';
              }
              return 'data:' . $mime . ';base64,' . base64_encode($data);
          }
      }
      
      return $path;
  }
}

// Helper local : convertit un chemin relatif 'img/foo.svg' en URL complète
if (!function_exists('vimg')) {
  function vimg($relpath, $img_base, $is_pdf = false) {
      // normaliser
      $relpath = ltrim($relpath, '/');
      $full_path = $img_base . $relpath;
      
      // Pour le PDF, convertir en base64
      if ($is_pdf) {
          $local_path = str_replace(base_url('assets/css/local/'), FCPATH . 'assets/css/local/', $full_path);
          $local_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $local_path);
          $encoded = encode_image_to_base64($local_path);
          // Si l'encodage a réussi (retourne une data URI), on l'utilise
          if (strpos($encoded, 'data:') === 0) {
              return $encoded;
          }
      }
      
      return $full_path;
  }
}

// Helper local : gère une valeur d'image qui peut être URL complète, chemin relatif, ou nom de fichier
if (!function_exists('full_img')) {
  function full_img($src, $img_base, $is_pdf = false) {
      // si vide
      if (empty($src)) return '';

      // data: URIs -> on garde
      if (strpos($src, 'data:') === 0) return $src;

      // URL absolue (http:// or https:// or //) -> convertir en base64 pour PDF
      if (preg_match('#^(https?:)?//#i', $src)) {
          if ($is_pdf) {
              // Extraire le chemin relatif depuis l'URL
              $relative_path = str_replace(base_url(), '', $src);
              $local_path = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relative_path);
              $encoded = encode_image_to_base64($local_path);
              if (strpos($encoded, 'data:') === 0) {
                  return $encoded;
              }
          }
          return $src;
      }

      // Chemin déjà absolu côté serveur (commence par / ou avec drive letter windows)
      if (strpos($src, '/') === 0 || preg_match('#^[A-Za-z]:\\\\#', $src)) {
          if ($is_pdf) {
              $encoded = encode_image_to_base64($src);
              if (strpos($encoded, 'data:') === 0) {
                  return $encoded;
              }
          }
          return $src;
      }

      // Sinon c'est un chemin relatif
      if (strpos($src, 'assets/') === 0) {
          if ($is_pdf) {
              $local_path = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $src);
              $encoded = encode_image_to_base64($local_path);
              if (strpos($encoded, 'data:') === 0) {
                  return $encoded;
              }
          }
          return base_url($src);
      }
      
      if (strpos($src, 'img/') === 0) {
          if ($is_pdf) {
              $local_path = FCPATH . 'assets/css/local/' . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $src);
              $encoded = encode_image_to_base64($local_path);
              if (strpos($encoded, 'data:') === 0) {
                  return $encoded;
              }
          }
          return $img_base . $src;
      }

      // simple filename
      if ($is_pdf) {
          $local_path = FCPATH . 'assets/css/local/img/' . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($src, '/'));
          $encoded = encode_image_to_base64($local_path);
          if (strpos($encoded, 'data:') === 0) {
              return $encoded;
          }
      }
      return $img_base . 'img/' . ltrim($src, '/');
  }
}

// Variable pour savoir si on est en mode PDF
$is_pdf_mode = !empty($is_pdf);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <!-- Les fichiers CSS pour affichage web -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pmaxfinal/globals.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pmaxfinal/styleguide.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pmaxfinal/style.css'); ?>" />
  <style>
    .pdf-page {
    transform: scale(0.40);
    transform-origin: top left;
}
/* Empêche le logo YouTube de déborder */
.image-12 {
    /* On force une largeur qui respecte le ratio "plat" du logo YouTube */
    width: 150px !important; 
    height: auto !important;
    
    /* On empêche le rognage */
    object-fit: contain !important; 
    
    /* On s'assure que rien ne vient masquer l'image */
    max-width: none !important;
    overflow: visible !important;
}

</style>


  </head>
  <body>
       <div class="pdf-page">

    <div class="zoom">
    <?php if (!empty($groupe_valider) && is_array($groupe_valider)): ?>
      <?php foreach($groupe_valider as $groupe): ?>
        <?php if (isset($groupe['type_campagne']) && $groupe['type_campagne'] == 3): ?>
          <?php $motCle = strtok($groupe['mot_cle'] ?? '', "\n"); ?>
          <div class="box" data-model-id="40643:59565-frame">
      <div class="group">
        <div class="div-wrapper">
          <div class="div">
            <div class="rectangle-8"></div>
            <div class="text-wrapper">Most Viewed</div>
            <div class="icon-home"></div>
            <div class="icon-clock">
              <div class="group-2">
                <img class="vector" src="<?php echo vimg('icone/vector-52.svg', $img_base); ?>" /> <img class="img" src="<?php echo vimg('icone/vector-53.svg', $img_base); ?>" />
              </div>
            </div>
            <div class="icon-heart"><img class="vector-2" src="img/vector-55.svg" /></div>
            <div class="icon-user">
              <div class="group-3">
                <img class="vector-3" src="<?php echo vimg('icone/vector-56.svg', $img_base); ?>"/>
                <img class="vector-4" src="<?php echo vimg('icone/vector-57.svg', $img_base); ?>" />
                <img class="vector-5" src="<?php echo vimg('icone/vector-58.svg', $img_base); ?>" />
              </div>
            </div>
            <div class="ellipse"></div>
            <div class="mask-group" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 380px; /* Assurez-vous que la largeur est définie */
                         height: 470px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         position: absolute;
                         display: block;
                  "></div>
            <div class="r-sidence-luxe-https">
              &nbsp;&nbsp;<?= htmlspecialchars($groupe['nom_client']) ?><br />&nbsp;&nbsp;<?= htmlspecialchars($groupe['site_client']) ?>
            </div>
            <p class="location-de-chalets"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <img class="image" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <div class="text-wrapper-2">Sponsorisé</div>
            <div class="frame"><img class="vector-6" src="<?php echo vimg('icone/vector-41.svg', $img_base); ?>" /></div>
            <div class="text-wrapper-3"><?= htmlspecialchars($motCle); ?></div>
            <img class="image-2" src="<?php echo vimg('icone/image-177-2.png', $img_base); ?>" />
          </div>
        </div>
        <div class="frame-2">
    <div class="text-wrapper-4">Display</div>
    <div class="text-wrapper-5">Search</div>
    <div class="text-wrapper-6">Youtube</div>
    <div class="text-wrapper-7">Discovery</div>
    <div class="text-wrapper-8">Gmail</div>
    
    <img class="display-icon" src="<?php echo vimg('icone/display-icon-48-4.png', $img_base, $is_pdf_mode); ?>" />
    
    <img class="image-3" src="<?php echo vimg('icone/youtube.png', $img_base, $is_pdf_mode); ?>" />
    
    <img class="discover-icon" src="<?php echo vimg('icone/discover-icon-48-3.png', $img_base, $is_pdf_mode); ?>" />
    
    <img class="image-4" src="<?php echo vimg('icone/gmail.png', $img_base, $is_pdf_mode); ?>" />
    
    <img class="image-5" src="<?php echo vimg('icone/google.png', $img_base, $is_pdf_mode); ?>" />
</div>
        <div class="group-4">
          <div class="div">
            <div class="heart-icon"></div>
            <div class="text-wrapper">Most Viewed</div>
            <div class="icon-home"></div>
            <div class="icon-clock">
              <div class="group-2">
                <img class="vector" src="<?php echo vimg('icone/vector-52.svg', $img_base); ?>" /> <img class="img" src="<?php echo vimg('icone/vector-53.svg', $img_base); ?>" />
              </div>
            </div>
            <div class="icon-heart"><img class="vector-2" src="<?php echo vimg('icone/vector-55.svg', $img_base); ?>" /></div>
            <div class="icon-user">
              <div class="group-3">
                <img class="vector-3" src="<?php echo vimg('icone/vector-56.svg', $img_base); ?>" />
                <img class="vector-4" src="<?php echo vimg('icone/vector-57.svg', $img_base); ?>" />
                <img class="vector-5" src="<?php echo vimg('icone/vector-58.svg', $img_base); ?>" />
              </div>
            </div>
            <div class="ellipse"></div>
            <div class="mask-group-2" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 370px; /* Assurez-vous que la largeur est définie */
                         height: 230px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         position: absolute;
                         display: block;
                  "></div>
            <p class="p">
              <span class="span"><?= htmlspecialchars($groupe['nom_client']) ?><br /></span>
              <span class="text-wrapper-9"><?= htmlspecialchars($groupe['site_client']) ?></span>
            </p>
            <img class="image-6" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <img class="image-7" src="<?php echo vimg('icone/image-182.png', $img_base); ?>" />
            <div class="rectangle-2"></div>
            <div class="rectangle-3"></div>
            <div class="rectangle-4"></div>
            <div class="rectangle-5"></div>
            <div class="rectangle-6"></div>
            <div class="text-wrapper-10">ANNONCE</div>
            <img class="vector-7" src="<?php echo vimg('icone/vector-41.svg', $img_base); ?>" />
            <div class="rectangle-7"></div>
          </div>
        </div>
        <div class="group-5">
          <div class="div">
            <div class="overlap">
              <div class="send-icon">
                <div class="vector-wrapper"><img class="vector-8" src="<?php echo vimg('icone/vector-61.svg', $img_base); ?>" /></div>
              </div>
              <div class="send-icon">
                <div class="vector-wrapper"><img class="vector-8" src="<?php echo vimg('icone/vector-61.svg', $img_base); ?>" /></div>
              </div>
            </div>
            <img class="mask-group-3" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base); ?>" />
            <img class="fi-rr-marker" src="<?php echo vimg('icone/fi-rr-marker.svg', $img_base); ?>" />
            <p class="r-sidence-luxe-https-2">
              <span class="span"><?= htmlspecialchars($groupe['nom_client']) ?><br /></span>
              <span class="text-wrapper-9"><?= htmlspecialchars($groupe['site_client']) ?></span>
            </p>
            <p class="s-lection-des-plus">
               <?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($groupe['descriptions2'] ?? '', ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($groupe['descriptions3'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p class="text-wrapper-12"><?php echo htmlspecialchars($groupe['adresse_campagne'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <p class="text-wrapper-13">Appelez le <?php echo htmlspecialchars($groupe['numero'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
           
            <p class="location-de-chalets-3">Extension</p>
            <p class="location-de-chalets-4">Extension</p>
            <img class="line" src="<?php echo vimg('icone/line-56.svg', $img_base); ?>" />
            <img class="image-8" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <img class="image-9" src="<?php echo vimg('icone/image-177-2.png', $img_base); ?>" />
            <div class="rectangle-8"></div>
          
            <img class="line-2" src="<?php echo vimg('icone/line-56.svg', $img_base); ?>" />
            <div class="icon-arrow-left"><img class="vector-9" src="<?php echo vimg('icone/vector-21.svg', $img_base); ?>" /></div>
            <div class="img-wrapper"><img class="vector-10" src="<?php echo vimg('icone/vector-22.svg', $img_base); ?>" /></div>
            <div class="icon-home-2"></div>
            <div class="overlap-group">
              <div class="group-wrapper">
                <div class="group-2">
                  <img class="vector" src="<?php echo vimg('icone/vector-52.svg', $img_base); ?>" /> <img class="img" src="<?php echo vimg('icone/vector-53.svg', $img_base); ?>" />
                </div>
              </div>
              <div class="group-wrapper">
                <div class="group-2">
                  <img class="vector" src="<?php echo vimg('icone/vector-52.svg', $img_base); ?>" /> <img class="img" src="<?php echo vimg('icone/vector-53.svg', $img_base); ?>" />
                </div>
              </div>
            </div>
            <div class="icon-heart-2"><img class="vector-2" src="<?php echo vimg('icone/vector-37.svg', $img_base); ?>" /></div>
            <div class="overlap-2">
              <div class="icon-user-2">
                <div class="group-3">
                  <img class="vector-3" src="<?php echo vimg('icone/vector-56.svg', $img_base); ?>" />
                  <img class="vector-4" src="<?php echo vimg('icone/vector-57.svg', $img_base); ?>" />
                  <img class="vector-5" src="<?php echo vimg('icone/vector-58.svg', $img_base); ?>" />
                </div>
              </div>
              <div class="icon-user-2">
                <div class="group-3">
                  <img class="vector-3" src="<?php echo vimg('icone/vector-56.svg', $img_base); ?>" />
                  <img class="vector-4" src="<?php echo vimg('icone/vector-57.svg', $img_base); ?>" />
                  <img class="vector-5" src="<?php echo vimg('icone/vector-58.svg', $img_base); ?>" />
                </div>
              </div>
            </div>
            <div class="text-wrapper-14">Sponsorisé</div>
            <img class="mask-group-3" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base); ?>" />
            <img class="fi-rr-marker" src="<?php echo vimg('icone/fi-rr-marker-1.svg', $img_base); ?>" />
            <p class="r-sidence-luxe-https-2">
              <span class="span"><?= htmlspecialchars($groupe['nom_client']) ?><br /></span>
              <span class="text-wrapper-9"><?= htmlspecialchars($groupe['site_client']) ?></span>
            </p>
         
            <p class="text-wrapper-12"><?php echo htmlspecialchars($groupe['adresse_campagne'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <p class="location-de-chalets-2"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <img class="image-8" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <img class="image-9" src="<?php echo vimg('icone/image-177-2.png', $img_base); ?>" />
            <div class="rectangle-8"></div>
          
            <div class="icon-home-2"></div>
            <div class="icon-heart-2"><img class="vector-2" src="<?php echo vimg('icone/vector-37.svg', $img_base); ?>" /></div>
            <div class="text-wrapper-14">Sponsorisé</div>
            <div class="frame-3"><img class="vector-6" src="<?php echo vimg('icone/vector-41.svg', $img_base); ?>" /></div>
            <div class="text-wrapper-15"><?= htmlspecialchars($motCle); ?></div>
            <img class="vector-11" src="<?php echo vimg('icone/vector-54.svg', $img_base); ?>" />
          </div>
        </div>
        <div class="group-6">
          <div class="div">
            <p class="r-sidence-luxe-https-3">
              <span class="span"><?= htmlspecialchars($groupe['nom_client']) ?><br /></span>
              <span class="text-wrapper-9"><?= htmlspecialchars($groupe['site_client']) ?></span>
            </p>
            <img class="image-8" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <img class="image-9" src="<?php echo vimg('icone/image-177-2.png', $img_base); ?>" />
            <div class="rectangle-8"></div>
            <img class="icon-phone" src="<?php echo vimg('icone/phone.png', $img_base); ?>" />
            <div class="icon-home-2"></div>
            <div class="overlap-group">
              <div class="group-wrapper">
                <div class="group-2">
                  <img class="vector" src="<?php echo vimg('icone/vector-52.svg', $img_base); ?>" /> <img class="img" src="<?php echo vimg('icone/vector-53.svg', $img_base); ?>" />
                </div>
              </div>
              <div class="group-wrapper">
                <div class="group-2">
                  <img class="vector" src="<?php echo vimg('icone/vector-52.svg', $img_base); ?>" /> <img class="img" src="<?php echo vimg('icone/vector-53.svg', $img_base); ?>" />
                </div>
              </div>
            </div>
            <div class="icon-heart-2"><img class="vector-2" src="<?php echo vimg('icone/vector-55.svg', $img_base); ?>" /></div>
            <div class="overlap-2">
              <div class="icon-user-2">
                <div class="group-3">
                  <img class="vector-3" src="<?php echo vimg('icone/vector-56.svg', $img_base); ?>" />
                  <img class="vector-4" src="<?php echo vimg('icone/vector-57.svg', $img_base); ?>" />
                  <img class="vector-5" src="<?php echo vimg('icone/vector-58.svg', $img_base); ?>" />
                </div>
              </div>
              <div class="icon-user-2">
                <div class="group-3">
                  <img class="vector-3" src="<?php echo vimg('icone/vector-56.svg', $img_base); ?>" />
                  <img class="vector-4" src="<?php echo vimg('icone/vector-57.svg', $img_base); ?>" />
                  <img class="vector-5" src="<?php echo vimg('icone/vector-58.svg', $img_base); ?>" />
                </div>
              </div>
            </div>
            <div class="text-wrapper-14">Sponsorisé</div>
            <img class="image-8" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <img class="image-9" src="<?php echo vimg('icone/image-177-2.png', $img_base); ?>" />
            <div class="rectangle-8"></div>
            <div class="icon-home-2"></div>
            <div class="icon-heart-2"><img class="vector-2" src="<?php echo vimg('icone/vector-55.svg', $img_base); ?>" /></div>
            <div class="text-wrapper-14">Sponsorisé</div>
            <div class="frame-3"><img class="vector-6" src="<?php echo vimg('icone/vector-41.svg', $img_base); ?>" /></div>
            <div class="text-wrapper-15"><?= htmlspecialchars($motCle); ?></div>
            <div class="rectangle-9"></div>
            <div class="text-wrapper-16">Voir plus</div>
            <div class="send-icon-2">
              <div class="vector-wrapper"><img class="vector-8" src="<?php echo vimg('icone/vector-61.svg', $img_base); ?>" /></div>
            </div>
            <div class="mask-group-4" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 387px; /* Assurez-vous que la largeur est définie */
                         height: 485px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         position: absolute;
                         display: block;
                  "></div>
          </div>
        </div>
        <div class="group-7">
          <div class="div">
          <div class="rectangle-8"></div>
            <div class="frame-3"><img class="vector-6" src="<?php echo vimg('icone/vector-41.svg', $img_base); ?>" /></div>
            <div class="heart-icon"></div>
            <img class="image-10" src="<?php echo vimg('icone/image-172.png', $img_base); ?>" />
            <div class="mask-group-5" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 385px; /* Assurez-vous que la largeur est définie */
                         height: 310px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         position: absolute;
                         display: block;
                  "></div>
            <div class="r-sidence-luxe-https-4">
              &nbsp;&nbsp;<?= htmlspecialchars($groupe['nom_client']) ?><br />&nbsp;&nbsp;<?= htmlspecialchars($groupe['site_client']) ?>
            </div>
            <p class="location-de-chalets-5"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <img class="image-11" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base); ?>" />
            <div class="text-wrapper-17">Sponsorisé</div>
            <div class="frame"><img class="vector-6" src="<?php echo vimg('icone/vector-63.svg', $img_base); ?>" /></div>
            <div class="text-wrapper-3"><?= htmlspecialchars($motCle); ?></div>
            <p class="text-wrapper-18">Appelez le <?php echo htmlspecialchars($groupe['numero'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <img class="vector-12" src="<?php echo vimg('icone/vector-64.svg', $img_base); ?>" />
            <img class="image-12" style="width: 80px; height: auto;" src="<?php echo vimg('icone/you-tube-logo-without-background-c21e.png', $img_base); ?>" />
            <div class="frame-4"><img class="vector-6" src="<?php echo vimg('icone/vector-41.svg', $img_base); ?>" /></div>
            <div class="frame-5"><img class="vector-13" src="<?php echo vimg('icone/vector-66.svg', $img_base); ?>" /></div>
            <div class="frame-6"><img class="vector-14" src="<?php echo vimg('icone/vector-67.svg', $img_base); ?>" /></div>
            <img class="rectangle-10" src="<?php echo vimg('icone/rectangle-77.svg', $img_base); ?>" />
            <div class="frame-7"><img class="vector-6" src="<?php echo vimg('icone/vector-68.svg', $img_base); ?>" /></div>
       
            <img class="vector-15" src="<?php echo vimg('icone/vector-69.svg', $img_base); ?>" />
          </div>
        </div>
      </div>
    </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </body>
</html>
