<?php
// templates/v3/Search.php
defined('BASEPATH') OR exit('No direct script access allowed');

// Variables attendues : $groupe_valider, $donne_valider, éventuellement $pdf_mode (bool)
$pdf_mode = isset($pdf_mode) && $pdf_mode;

// Base pour images relatives (où se trouvent tes "img/...")
$img_base = base_url('assets/css/search/'); // ex: http://localhost/cmsadsrank/assets/css/search/

// Si on veut remplacer les SVG par PNG en PDF (utile si TCPDF a du mal avec certains SVG)
$svg_to_png_for_pdf = true;

// Helper local : convertit un chemin relatif 'img/foo.svg' en URL complète
function vimg($relpath, $img_base, $pdf_mode = false, $svg_to_png = true) {
    // normaliser
    $relpath = ltrim($relpath, '/');
    if ($pdf_mode && $svg_to_png && preg_match('/\.svg$/i', $relpath)) {
        $relpath = preg_replace('/\.svg$/i', '.png', $relpath);
    }
    return $img_base . $relpath;
}

// Helper local : gère une valeur d'image qui peut être URL complète, chemin relatif, ou nom de fichier
function full_img($src, $img_base, $pdf_mode = false, $svg_to_png = true) {
    // si vide
    if (empty($src)) return '';

    // data: URIs -> on garde
    if (strpos($src, 'data:') === 0) return $src;

    // URL absolue (http:// or https:// or //) -> garder
    if (preg_match('#^(https?:)?//#i', $src)) {
        // Optionnel : si on est en PDF et que allow_url_fopen est désactivé, le contrôleur peut télécharger l'image
        return $src;
    }

    // Chemin déjà absolu côté serveur (commence par / ou avec drive letter windows) -> l'afficher tel quel
    if (strpos($src, '/') === 0 || preg_match('#^[A-Za-z]:\\\\#', $src)) {
        return $src;
    }

    // Sinon c'est un chemin relatif : on suppose qu'il se trouve dans assets/css/search/img/ ou assets/css/search/
    // Normaliser extension SVG->PNG en PDF si demandé
    if ($pdf_mode && $svg_to_png && preg_match('/\.svg$/i', $src)) {
        $src = preg_replace('/\.svg$/i', '.png', $src);
    }

    // Si le src contient déjà 'assets/' ou 'img/' on adapte, sinon on le met sous assets/css/search/
    if (strpos($src, 'assets/') === 0) {
        return base_url($src);
    }
    if (strpos($src, 'img/') === 0) {
        // img/... -> assets/css/search/img/...
        return $img_base . $src;
    }

    // simple filename (favicon.png) => assets/css/search/img/filename
    return $img_base . 'img/' . ltrim($src, '/');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <!-- Les fichiers CSS pour affichage web — le contrôleur injecte ces CSS dans le HTML pour TCPDF -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/search/globals.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/search/styleguide.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/search/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pmax/style.css'); ?>" />

    <style>
    <?php if ($pdf_mode): ?>
      /* En mode PDF, neutraliser la transformation qui casse le rendu */
      .zoom { transform: none !important; width: 100% !important; transform-origin: initial !important; }
    <?php else: ?>
      .zoom {
        transform: scale(0.45);
        transform-origin: top left;
        width: 250%;
      }
    <?php endif; ?>
    </style>
  </head>
  <body>
    <div class="zoom">
    <?php if (!empty($groupe_valider) && is_array($groupe_valider)): ?>
      <?php foreach($groupe_valider as $groupe): ?>
        <?php if (isset($groupe['type_campagne']) && $groupe['type_campagne'] == 1): ?>
          <div class="box" data-model-id="40567:247871-frame">
            <div class="group">
              <div class="group-wrapper">
                <div class="div-wrapper">
                  <div class="div">
                    <div class="frame">
                      <div class="div-2">

                        <div class="text-wrapper">Book Now</div>

                        <div class="overlap-group">
                          <div class="send-icon">
                            <div class="vector-wrapper">
                              <?php
                                // ici dans ton HTML original tu avais base_url("assets/css/search/img/globals.css") comme src: probablement une erreur,
                                // si c'était censé être une image, corrigeons en pointant sur l'image adéquate
                                $globals_img = 'img/globals.png'; // <-- adapte ce nom si nécessaire
                              ?>
                              <img class="vector" src="<?php echo vimg($globals_img, $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="globals" />
                            </div>
                          </div>

                          <div class="send-icon">
                            <div class="vector-wrapper">
                              <?php $fav = isset($groupe['favicon']) ? $groupe['favicon'] : ''; ?>
                              <img class="vector" src="<?php echo full_img($fav, $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="favicon" />
                            </div>
                          </div>
                        </div>

                        <img class="mask-group" src="<?php echo full_img(isset($groupe['images'][0]) ? $groupe['images'][0] : '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="image principale" />

                        <p class="s-lection-des-plus">
                          <?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> -
                          <?php echo htmlspecialchars($groupe['descriptions2'] ?? '', ENT_QUOTES, 'UTF-8'); ?> -
                          <?php echo htmlspecialchars($groupe['descriptions3'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                        <p class="p">20 rue les petits pos 772012 Le valnceces</p>
                        <p class="text-wrapper-2">Appelez le 06 96 52 58 52</p>
                        <p class="location-de-chalets"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

                        <p class="text-wrapper-3">
                          Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile
                        </p>

                        <img class="image" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="favicon small" />
                        <img class="img" src="<?php echo vimg('img/image-177.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="img177" />

                        <div class="text-wrapper">Book Now</div>

                        <div class="fi-rr-marker">
                          <img class="vector-2" src="<?php echo vimg('img/vector-4.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector4" />
                          <img class="vector-3" src="<?php echo vimg('img/fi-rr-marker.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="marker" />
                        </div>

                        <p class="r-sidence-luxe-https">
                          <span class="span"><?php echo htmlspecialchars($groupe['nom_client'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br /></span>
                          <span class="text-wrapper-4"><?php echo htmlspecialchars($groupe['url_site'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </p>

                        <p class="location-de-chalets-2"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

                        <p class="text-wrapper-5"><?php echo htmlspecialchars($groupe['descriptions1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

                        <p class="location-de-chalets-3"><?php echo htmlspecialchars($groupe['titre1'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?> | <?php echo htmlspecialchars($groupe['titre2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

                        <img class="line" src="<?php echo vimg('img/line-60.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="line60" />
                        <div class="rectangle"></div>
                        <img class="line-2" src="<?php echo vimg('img/line-59.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="line59" />

                        <div class="icon-arrow-left">
                          <img class="vector-4" src="<?php echo vimg('img/vector-8.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector8" />
                        </div>

                        <div class="img-wrapper">
                          <img class="vector-4" src="<?php echo vimg('img/vector-8.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector8b" />
                        </div>

                        <p class="text-wrapper-6">Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile</p>

                        <p class="location-de-chalets-4">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>

                        <img class="line-3" src="<?php echo vimg('img/line-60.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="line60b" />

                        <div class="icon-arrow-left-2">
                          <img class="vector-4" src="<?php echo vimg('img/vector-8.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector8c" />
                        </div>

                        <div class="text-wrapper-7">Sponsorisé</div>

                        <div class="frame-2">
                          <img class="vector-5" src="<?php echo vimg('img/Frame.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="frame" />
                        </div>

                      </div>

                      <img class="vector-6" src="<?php echo vimg('img/vector-45.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector45" />
                    </div>

                    <div class="div-3">
                      <div class="heart-icon"></div>
                      <img class="image-2" src="<?php echo vimg('img/image-172.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="image172" />
                      <div class="text-wrapper-8">Most Viewed</div>
                      <div class="icon-home"></div>

                      <div class="icon-clock">
                        <div class="group-2">
                          <img class="vector-7" src="<?php echo vimg('img/vector-37.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector37" />
                          <img class="vector-8" src="<?php echo vimg('img/vector-38.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector38" />
                        </div>
                      </div>

                      <div class="icon-heart">
                        <img class="vector-9" src="<?php echo vimg('img/vector-40.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector40" />
                      </div>

                      <div class="icon-user">
                        <div class="group-3">
                          <img class="vector-10" src="<?php echo vimg('img/vector-41.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector41" />
                          <img class="vector-11" src="<?php echo vimg('img/vector-42.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector42" />
                          <img class="vector-12" src="<?php echo vimg('img/vector-43.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector43" />
                        </div>
                      </div>

                      <div class="ellipse"></div>

                      <img class="mask-group-2" src="<?php echo full_img($groupe['images'][0] ?? '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="mask2" />

                      <div class="r-sidence-luxe-https-2">
                        &nbsp;&nbsp;<?php echo htmlspecialchars($groupe['nom_client'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br />
                        &nbsp;&nbsp;<?php echo htmlspecialchars($groupe['url_site'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                      </div>

                      <p class="s-lection-des-plus-2">
                        Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                        d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
                      </p>

                      <p class="location-de-chalets-5">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>

                      <img class="image-3" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="favicon2" />
                      <div class="text-wrapper-9">Sponsorisé</div>
                      <p class="text-wrapper-10">Appelez le 06 96 52 58 52</p>

                      <img class="vector-13" src="<?php echo vimg('img/vector-20.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector20" />
                      <img class="image-4" src="<?php echo vimg('img/image-177.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="image177" />
                      <div class="rectangle-2"></div>
                      <div class="frame-3"><img class="vector-5" src="<?php echo vimg('img/vector-44.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector44" /></div>
                      <div class="text-wrapper-11">Chalet de Luxe Disponibles</div>
                    </div>

                    <div class="div-4">
                      <div class="text-wrapper-12">Book Now</div>
                      <div class="overlap">
                        <div class="send-icon-2">
                          <div class="group-4"><img class="vector-14" src="<?php echo vimg('img/vector-35.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector35" /></div>
                        </div>
                        <div class="send-icon-2">
                          <div class="group-4"><img class="vector-14" src="<?php echo vimg('img/vector-35.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector35b" /></div>
                        </div>
                      </div>

                      <img class="mask-group-3" src="<?php echo full_img($groupe['images'][0] ?? '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="mask3" />
                      <img class="fi-rr-marker-2" src="<?php echo vimg('img/fi-rr-marker.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="fi-rr-marker" />

                      <p class="r-sidence-luxe-https-3">
                        <span class="span"><?php echo htmlspecialchars($groupe['nom_client'] ?? '', ENT_QUOTES, 'UTF-8'); ?><br /></span>
                        <span class="text-wrapper-13">https://www.residence-luxe.com</span>
                      </p>

                      <p class="s-lection-des-plus-3">
                        Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                        d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
                      </p>

                      <p class="text-wrapper-14">20 rue les petits pos 772012 Le valnceces</p>
                      <p class="text-wrapper-15">Appelez le 06 96 52 58 52</p>
                      <p class="location-de-chalets-6">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>

                      <img class="line-4" src="<?php echo vimg('img/line-56.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="line56" />
                      <img class="image-5" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="favicon3" />
                      <img class="image-6" src="<?php echo vimg('img/image-177.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="image177b" />

                      <div class="rectangle-2"></div>

                      <img class="icon-phone-2" src="<?php echo vimg('img/phone.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="phone" />
                      <img class="line-5" src="<?php echo vimg('img/line-56.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="line56b" />

                      <div class="icon-arrow-left-3">
                        <img class="vector-15" src="<?php echo vimg('img/vector-25.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector25" />
                      </div>

                      <div class="icon-arrow-left-4">
                        <img class="vector-15" src="<?php echo vimg('img/vector-25.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector25b" />
                      </div>

                      <div class="icon-home-2"></div>

                      <div class="overlap-2">
                        <div class="icon-clock-2">
                          <div class="group-2">
                            <img class="vector-7" src="<?php echo vimg('img/vector-37.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector37b" />
                            <img class="vector-8" src="<?php echo vimg('img/vector-38.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector38b" />
                          </div>
                        </div>
                        <div class="icon-clock-2">
                          <div class="group-2">
                            <img class="vector-7" src="<?php echo vimg('img/vector-37.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector37c" />
                            <img class="vector-8" src="<?php echo vimg('img/vector-38.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector38c" />
                          </div>
                        </div>
                      </div>

                      <div class="icon-heart-2">
                        <img class="vector-9" src="<?php echo vimg('img/vector-40.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector40b" />
                      </div>

                      <div class="overlap-3">
                        <div class="icon-user-2">
                          <div class="group-3">
                            <img class="vector-10" src="<?php echo vimg('img/vector-41.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector41b" />
                            <img class="vector-11" src="<?php echo vimg('img/vector-42.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector42b" />
                            <img class="vector-12" src="<?php echo vimg('img/vector-43.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector43b" />
                          </div>
                        </div>
                        <div class="icon-user-2">
                          <div class="group-3">
                            <img class="vector-10" src="<?php echo vimg('img/vector-41.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector41c" />
                            <img class="vector-11" src="<?php echo vimg('img/vector-42.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector42c" />
                            <img class="vector-12" src="<?php echo vimg('img/vector-43.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector43c" />
                          </div>
                        </div>
                      </div>

                      <div class="text-wrapper-16">Sponsorisé</div>

                      <img class="mask-group-3" src="<?php echo vimg('img/mask-group-3.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="mask-group-3" />
                      <img class="fi-rr-marker-2" src="<?php echo vimg('img/fi-rr-marker-1.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="fi-rr-marker-1" />

                      <p class="r-sidence-luxe-https-3">
                        <span class="span">Résidence Luxe<br /></span>
                        <span class="text-wrapper-13">https://www.residence-luxe.com</span>
                      </p>

                      <p class="s-lection-des-plus-3">
                        Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                        d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
                      </p>

                      <p class="text-wrapper-14">20 rue les petits pos 772012 Le valnceces</p>
                      <p class="location-de-chalets-6">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>

                      <img class="image-5" src="<?php echo full_img($groupe['favicon'] ?? '', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="favicon4" />
                      <img class="image-6" src="<?php echo vimg('img/image-177.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="image177c" />

                      <div class="rectangle-2"></div>

                      <img class="icon-phone-3" src="<?php echo vimg('img/phone-2.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="phone2" />
                      <div class="icon-home-2"></div>
                      <div class="icon-heart-2"><img class="vector-9" src="<?php echo vimg('img/vector-40.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector40c" /></div>
                      <div class="text-wrapper-16">Sponsorisé</div>
                      <div class="frame-3"><img class="vector-5" src="<?php echo vimg('img/vector-44.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector44b" /></div>
                      <div class="text-wrapper-11">Chalet de Luxe Disponibles</div>
                      <img class="vector-16" src="<?php echo vimg('img/vector-45.svg', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="vector45b" />
                    </div>

                    <div class="text-wrapper-17">Search</div>
                    <img class="image-7" src="<?php echo vimg('img/image-178.png', $img_base, $pdf_mode, $svg_to_png_for_pdf); ?>" alt="image178" />
                  </div>
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
