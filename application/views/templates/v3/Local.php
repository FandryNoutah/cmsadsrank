<?php
// templates/v3/Search.php
defined('BASEPATH') OR exit('No direct script access allowed');

// Variables attendues : $groupe_valider, $donne_valider

// Base pour images relatives (où se trouvent tes "img/...")
$img_base = base_url('assets/css/local/'); // ex: http://localhost/cmsadsrank/assets/css/search/

// Helper pour convertir une image locale en base64
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
    <link rel="stylesheet" href="<?php echo base_url('assets/css/local/globals.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/local/styleguide.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/local/style.css'); ?>" />
 <style>
/* Conteneur écran */
.viewer {
  width: 100vw;
  height: 100vh;
  overflow: auto;           /* scroll si nécessaire */
  background: #ffffff;
}

.preview {
  transform: scale(0.40);
  transform-origin: top left;
}

/* WEB UNIQUEMENT */
<?php if (empty($is_pdf)): ?>
.preview {
  transform: scale(0.30);
  transform-origin: top left;
}
<?php endif; ?>

<?php if (!empty($is_pdf)): ?>
.preview {
  transform: none !important;
  transform-origin: unset !important;
  width: 100% !important;
  height: auto !important;
  background-color: white !important;
}

.frame {
  position: relative !important;
  width: 3000px !important;
  min-width: 2581px !important;
  max-width: 3000px !important;
  min-height: 1621px !important;

}

/* Assurer que les éléments absolus restent dans leur conteneur */
.frame .group,
.frame .group-wrapper,
.frame .group-3,
.frame .group-6,
.frame .div-wrapper {
  position: absolute !important;
}

/* Corriger les calculs calc() - convertir en valeurs fixes basées sur 2581px */
.frame .group {
  top: 426px !important; /* (1621/2) - 384 = 426.5px */
  left: 559px !important; /* (2581/2) - 732 = 558.5px */
  width: 430px !important;
  height: 932px !important;
}

.frame .group-3 {
  top: 418px !important; /* (1621/2) - 392 = 418.5px */
  left: 1061px !important; /* (2581/2) - 230 = 1060.5px */
  width: 434px !important;
  height: 932px !important;
}

.frame .group-wrapper {
  top: 426px !important;
  left: 58px !important;
  width: 430px !important;
  height: 932px !important;
}


.frame .group-6 {
  left: 1561px !important;
  top: 426px !important;
  width: 430px !important;
  height: 932px !important;
}

.frame .div-wrapper {
  left: 2074px !important;
  top: 426px !important;
  width: 430px !important;
  height: 932px !important;
}

/* Désactiver les transformations qui peuvent causer des problèmes */
.frame .icon-arrow-left,
.frame .icon-arrow-left-2 {
  transform: none !important;
}

.frame .vector-6,
.frame .vector-15 {
  transform: none !important;
}
/* 1. Correction pour l'arrondi (Border Radius) */
.image-container-fixed {
    display: block !important;
    position: absolute; 
    
    /* AJOUTEZ LES DIMENSIONS ICI */
    width: 430px;  /* Ajustez selon la largeur voulue */
    height: 390px; /* Ajustez selon la hauteur voulue */
    top: 0;        /* Ajustez la position */
    left: 0;
    
    overflow: hidden !important; 
    border-top-left-radius: 50px !important;
    border-top-right-radius: 50px !important;
    z-index: 10;
}

.image-container-fixed .image {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important; /* Pour Chrome */
    display: block !important;
}

.rectangle {
    position: absolute !important;
    background-color: #FFFFFF !important; /* Force le blanc opaque */
    opacity: 1 !important;
    z-index: 20 !important; /* Doit être supérieur à l'image-container-fixed */
    /* ... vos autres styles ... */
}

<?php endif; ?>
/* PDF */
@media print {
  body {
    overflow: hidden;
  }

  .preview {
    transform: none !important;
  }
  
  .frame {
    page-break-inside: avoid;
  }
}

  </style>


  </head>
  <body>
   <div class="viewer">
  <div class="frame preview">
    <?php if (!empty($groupe_valider) && is_array($groupe_valider)): ?>
      <?php foreach($groupe_valider as $groupe): ?>
        <?php if (isset($groupe['type_campagne']) && $groupe['type_campagne'] == 2): ?>
          <?php $motCle = strtok($groupe['mot_cle'] ?? '', "\n"); ?>
           <div class="frame" data-model-id="40648:261">
              <div class="group">
                <div class="div">
                  <div class="heart-icon"></div>
                  <div class="text-wrapper">Most Viewed</div>
                  <img class="mask-group" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>" />
                  <img class="img" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>" />
                  <img class="mask-group-2" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>" />
                  <div class="text-wrapper-2">(35)</div>
                  <div class="text-wrapper-3">Ferme à 20H</div>
                  <div class="text-wrapper-4">Ouvert</div>
                  <div class="text-wrapper-5">5</div>
                  <div class="image-container-fixed" style="
                      z-index: 10;
                      background-image: url('<?php echo vimg('img/image-186.png', $img_base, $is_pdf_mode); ?>');
                      background-size: cover;
                      background-position: center;
                      width: 430px; 
                      height: 390px;
                      border-radius: 50px 50px 0 0;">
                  </div>
                  <div class="rectangle" style="z-index: 20;"></div>
                  <img class="vector" style="z-index: 30;" src="<?php echo vimg('img/vector-41.svg', $img_base); ?>" />
                  <div class="text-wrapper-6" style="z-index: 30;"><?= htmlspecialchars($motCle); ?></div>
                  <div class="text-wrapper-7">Sponsorisé</div>
                  <p class="p"> <?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($groupe['descriptions2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                  <div class="text-wrapper-8">Site Internet</div>
                  <div class="text-wrapper-9">Itinéraire</div>
                  <div class="text-wrapper-10">Appel</div>
                  <img class="icon-star" src="<?php echo full_img('icon-star.svg', $img_base); ?>" />
                  <img class="ellipse" src="<?php echo vimg('img/ellipse-23.png', $img_base, $is_pdf_mode); ?>" />
                  <img class="ellipse-2" src="<?php echo vimg('img/ellipse-23.png', $img_base, $is_pdf_mode); ?>" />
                  <img class="ellipse-3" src="<?php echo vimg('img/ellipse-23.png', $img_base, $is_pdf_mode); ?>" />
                  <div class="vector-wrapper"><img class="vector-2" src="<?php echo vimg('img/vector-2.svg', $img_base); ?>" /></div>
                  <div class="img-wrapper"><img class="vector-3" style="z-index: 50;" src="<?php echo vimg('img/vector-3.svg', $img_base); ?>" /></div>
                  <div class="vector-wrapper-2"><img class="vector-4" src="<?php echo vimg('img/vector-4.svg', $img_base); ?>" /></div>
                </div>
              </div>
              <div class="group-wrapper">
                <div class="group-2">
                  <img class="img-2" src="<?php echo vimg('img/group-482802.png', $img_base, $is_pdf_mode); ?>" />
                  <img class="img-2" src="<?php echo vimg('img/1.svg', $img_base); ?>" />
                  <div class="div-2">
                    <div class="icon-heart"><img class="vector-5" src="<?php echo vimg('img/vector-5.svg', $img_base); ?>" /></div>
                  </div>
                  <div class="heart-icon-2"></div>
                  <div class="text-wrapper-11">Most Viewed</div>
                  <div class="icon-arrow-left"><img class="vector-6" src="<?php echo vimg('img/vector-7.svg', $img_base); ?>" /></div>
                  <div class="heart-icon-2"></div>
                  <div class="text-wrapper-11">Most Viewed</div>
                  <img class="mask-group-3" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>" />
                  <img class="mask-group-4" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>" />
                  <img class="mask-group-5" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>" />
                  <div class="mask-group-6" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 390px; /* Assurez-vous que la largeur est définie */
                         height: 250px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         display: block;
                  "></div>
                  <div class="text-wrapper-12">Ferme à 20H</div>
                  <div class="text-wrapper-13">Ouvert</div>
                  <div class="text-wrapper-14">Sponsorisé</div>
                  <p class="text-wrapper-15"> <?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                  <div class="text-wrapper-16">(35)</div>
                  <div class="text-wrapper-17">5</div>
                  <div class="icon-star-2">
                    <img class="vector-7" src="<?php echo vimg('img/vector.svg', $img_base); ?>" /> <img class="vector-8" src="<?php echo vimg('img/vector-9.svg', $img_base); ?>" />
                  </div>
                  <div class="rectangle-2" style="z-index: 30;">&nbsp;</div>
                  <img class="rectangle-3" src="<?php echo vimg('img/rectangle-144.svg', $img_base); ?>" />
                  <div class="vector-wrapper-3"><img class="vector-4" src="<?php echo vimg('img/vector-10.svg', $img_base); ?>" /></div>
                  <div class="vector-wrapper-4"><img class="vector-3" src="<?php echo vimg('img/vector-11.svg', $img_base); ?>" /></div>
                  <div class="text-wrapper-18">Itinéraire</div>
                  <div class="text-wrapper-19">Appeler</div>
                  <img class="rectangle-4" src="<?php echo vimg('img/rectangle-146.svg', $img_base); ?>" />
                  <div class="text-wrapper-20">Visiter le site Internet</div>
                  <div class="rectangle-5"></div>
                  <div class="text-wrapper-21"><?= htmlspecialchars($motCle); ?></div>
                  <img class="image-2" src="<?php echo vimg('img/image-186-1.png', $img_base, $is_pdf_mode); ?>" />
                </div>
              </div>
              <div class="text-wrapper-22">Locale</div>
              <img class="image-3" src="<?php echo vimg('img/image-234.png', $img_base, $is_pdf_mode); ?>" />
              <div class="text-wrapper-23">Display</div>
              <div class="text-wrapper-24">Search</div>
              <div class="text-wrapper-25">Gmail</div>
              <img class="display-icon" src="<?php echo vimg('img/display-icon-48-5.png', $img_base, $is_pdf_mode); ?>" />
              <img class="image-4" src="<?php echo vimg('img/image-244.png', $img_base, $is_pdf_mode); ?>" />
              <img class="image-5" src="<?php echo vimg('img/image-246.png', $img_base, $is_pdf_mode); ?>" />
              <div class="group-3">
                <div class="div-3">
                  <div class="heart-icon"></div>
                  <div class="text-wrapper">Most Viewed</div>
                  <div class="icon-home"></div>
                  <div class="icon-clock">
                    <div class="group-4">
                      <img class="vector-9" src="<?php echo vimg('img/vector-34.svg', $img_base); ?>" /> <img class="vector-10" src="<?php echo vimg('img/vector-35.svg', $img_base); ?>" />
                    </div>
                  </div>
                  <div class="icon-heart-2"><img class="vector-11" src="<?php echo vimg('img/vector-37.svg', $img_base); ?>" /></div>
                  <div class="icon-user">
                    <div class="group-5">
                      <img class="vector-12" src="<?php echo vimg('img/vector-38.svg', $img_base); ?>" />
                      <img class="vector-13" src="<?php echo vimg('img/vector-39.svg', $img_base); ?>" />
                      <img class="vector-14" src="<?php echo vimg('img/vector-40.svg', $img_base); ?>" />
                    </div>
                  </div>
                  <div class="ellipse-4"></div>
                  <img class="image-6" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $is_pdf_mode); ?>" />
                  <div class="mask-group-7" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 380px; /* Assurez-vous que la largeur est définie */
                         height: 550px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         position: absolute;
                         display: block;
                  "></div>
                  <img class="ellipse-5" src="<?php echo vimg('img/ellipse-9-1.png', $img_base, $is_pdf_mode); ?>" />
                  <div class="icon-arrow-left-2"><img class="vector-15" src="<?php echo vimg('img/vector-21.svg', $img_base); ?>" /></div>
                </div>
                <div class="text-wrapper-26"><?= htmlspecialchars($motCle); ?></div>
                <p class="text-wrapper-27">
                  <?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($groupe['descriptions2'] ?? '', ENT_QUOTES, 'UTF-8'); ?> 
                </p>
              </div>
              <div class="group-6">
                <div class="div-2">
                  <div class="rectangle-6"></div>
                  <div class="heart-icon-3"></div>
                  <img class="image-7" src="<?php echo vimg('img/image-172.png', $img_base, $is_pdf_mode); ?>" />
                  <div class="text-wrapper">Most Viewed</div>
                  <div class="icon-home-2"></div>
                  <div class="icon-clock">
                    <div class="group-4">
                      <img class="vector-9" src="<?php echo vimg('img/vector-34.svg', $img_base); ?>" /> <img class="vector-10" src="<?php echo vimg('img/vector-35.svg', $img_base); ?>" />
                    </div>
                  </div>
                  <div class="icon-heart-3"><img class="vector-11" src="<?php echo vimg('img/vector-37.svg', $img_base); ?>" /></div>
                  <div class="icon-user">
                    <div class="group-5">
                      <img class="vector-12" src="<?php echo vimg('img/vector-38.svg', $img_base); ?>" />
                      <img class="vector-13" src="<?php echo vimg('img/vector-39.svg', $img_base); ?>" />
                      <img class="vector-14" src="<?php echo vimg('img/vector-40.svg', $img_base); ?>" />
                    </div>
                  </div>
                  <div class="ellipse-4"></div>
                  <div class="mask-group-8" 
                  style="background-image: url('<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $is_pdf_mode); ?>');
                         background-size: cover;
                         background-position: center;
                         width: 370px; /* Assurez-vous que la largeur est définie */
                         height: 260px; /* Assurez-vous que la hauteur est définie */
                         border-radius: 10px;
                         display: block;
                  "></div>
                  <div class="r-sidence-luxe-https">
                    &nbsp;&nbsp;<?= htmlspecialchars($groupe['nom_client']) ?><br />&nbsp;&nbsp;<?= htmlspecialchars($groupe['site_client']) ?>
                  </div>
                  <p class="s-lection-des-plus">
                    <?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($groupe['descriptions2'] ?? '', ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($groupe['descriptions3'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                  </p>
                  <p class="location-de-chalets"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                  <img class="image-8" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $is_pdf_mode); ?>" />
                  <div class="text-wrapper-28">Sponsorisé</div>
                  <div class="vector-wrapper-5"><img class="vector-16" src="<?php echo vimg('img/vector-31.svg', $img_base); ?>" /></div>
                  <div class="text-wrapper-29"><?= htmlspecialchars($motCle); ?></div>
                  <p class="text-wrapper-30">Appelez le 06 96 52 58 52</p>
                  <img class="vector-17" src="<?php echo vimg('img/vector-32.svg', $img_base); ?>" />
                </div>
                <img class="image-9" src="<?php echo vimg('img/image-247.png', $img_base, $is_pdf_mode); ?>" />
              </div>
              <div class="div-wrapper">
                <div class="div-4">
                  <div class="icon-home-2"></div>
                  <div class="icon-clock">
                    <div class="group-4">
                      <img class="vector-9" src="<?php echo vimg('img/vector-34.svg', $img_base); ?>" /> <img class="vector-10" src="<?php echo vimg('img/vector-35.svg', $img_base); ?>" />
                    </div>
                  </div>
                  <div class="icon-heart-3"><img class="vector-11" src="<?php echo vimg('img/vector-37.svg', $img_base); ?>" /></div>
                  <div class="icon-user">
                    <div class="group-5">
                      <img class="vector-12" src="<?php echo vimg('img/vector-38.svg', $img_base); ?>" />
                      <img class="vector-13" src="<?php echo vimg('img/vector-39.svg', $img_base); ?>" />
                      <img class="vector-14" src="<?php echo vimg('img/vector-40.svg', $img_base); ?>" />
                    </div>
                  </div>
                  <div class="ellipse-4"></div>
                  <div class="rectangle-7"></div>
                  <div class="rectangle-8"></div>
                  <div class="rectangle-9"></div>
                  <div class="rectangle-10"></div>
                  <div class="rectangle-11"></div>
                  <div class="rectangle-12"></div>
                  <div class="rectangle-13"></div>
                  <div class="rectangle-14"></div>
                  <div class="rectangle-15"></div>
                  <img class="vector-18" src="<?php echo vimg('img/vector-41.svg', $img_base); ?>" />
                  <p class="r-sidence-luxe-https-2">
                    <span class="span"><?= htmlspecialchars($groupe['nom_client']) ?><br /></span>
                    <span class="text-wrapper-31"><?= htmlspecialchars($groupe['site_client']) ?></span>
                  </p>
                  <img class="image-10" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $is_pdf_mode); ?>" />
                  <div class="text-wrapper-32">ANNONCE</div>
                  <img class="image-11" src="<?php echo vimg('img/image-184.png', $img_base, $is_pdf_mode); ?>" />
                  <p class="location-de-chalets-2"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
              </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
      </div>
  </body>
</html>