<?php
// BLOCK 1 - Détermination de l'image principale : si $groupe_valider[0]['images'][0] existe on l'utilise, sinon fallback local
// si $groupe_valider[0]['images'][0] existe, on l'utilise ; sinon fallback local
$image_src = (isset($groupe_valider[0]['images'][0]) && $groupe_valider[0]['images'][0]) ? $groupe_valider[0]['images'][0] : base_url('img/1.png');
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- BLOCK 2 - Métadonnées et inclusion des feuilles de style globales -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/test/globals.css") ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/test/styleguide.css") ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/test/style.css") ?>" />
    <style>
      /* petit style local pour zoomer toute la maquette */
      .zoom {
        transform: scale(0.4);
        transform-origin: top left;
        width: 250%;
      }
    </style>
  </head>
  <body>
    <!-- BLOCK 3 - Wrapper zoomé : conteneur agrandi pour afficher la maquette -->
    <div class="zoom">
      <!-- boucle sur les groupes validés (chaque groupe correspond à une maquette/ad) -->
      <?php foreach($groupe_valider as $groupe): ?>
        <?php if ($groupe['type_campagne'] == 1): ?>

      <!-- BLOCK 4 - Conteneur principal de l'item (boîte de la maquette / "card") -->
      <div class="box" data-model-id="40567:247867-frame">
        <div class="group">
          <div class="div">

            <!-- BLOCK 5 - Zone image principale + overlays (image large en haut de la card et éléments superposés) -->
            <img class="img" src="<?php echo $image_src; ?>" />
            <div class="div-2">
              <!-- icônes et éléments superposés sur l'image (favoris, home, clock, user, etc.) -->
              <div class="heart-icon"></div>
              <div class="text-wrapper">Most Viewed</div>
              <div class="icon-home"></div>
              <div class="icon-clock">
                <div class="group-2">
                  <img class="vector" src="img/vector-67.svg" /> <img class="vector-2" src="img/vector-68.svg" />
                </div>
              </div>
              <div class="icon-heart"><img class="vector-3" src="img/vector-70.svg" /></div>
              <div class="icon-user">
                <div class="group-3">
                  <img class="vector-4" src="img/vector-71.svg" />
                  <img class="vector-5" src="img/vector-72.svg" />
                  <img class="vector-6" src="img/vector-73.svg" />
                </div>
              </div>
              <div class="ellipse"></div>
              <img class="image-2" src="<?= $groupe['favicon'] ?>" />
              <img class="mask-group" src="<?= $groupe['images'][0] ?>" />
              <img class="ellipse-2" src="img/ellipse-20.png" />
              <div class="icon-arrow-left"><img class="vector-7" src="img/vector-65.svg" /></div>
            </div>

            <!-- BLOCK 6 - Titre et description courte sous l'image (ligne titre + paragraphe descriptif) -->
            <div class="text-wrapper-2">Chalet de Luxe Disponibles</div>
            <p class="p"> <?= $groupe['descriptions1'] ?> -   <?= $groupe['descriptions2'] ?> -   <?= $groupe['descriptions3'] ?></p>

            <!-- BLOCK 7 - Image secondaire + bloc sponsor / favicon / url (zone qui contient info client et url) -->
            <img class="img-2" src="<?php echo $image_src; ?>" />
            <div class="div-3">
              <!-- ensemble d'icônes et éléments répétitifs (coeur, home, clock...) + affichage du client / url -->
              <div class="heart-icon-2"></div>
              <div class="text-wrapper">Most Viewed</div>
              <div class="icon-home-2"></div>
              <div class="icon-clock">
                <div class="group-2">
                  <img class="vector" src="img/vector-67.svg" /> <img class="vector-2" src="img/vector-68.svg" />
                </div>
              </div>
              <div class="vector-wrapper"><img class="vector-3" src="img/vector-70.svg" /></div>
              <div class="icon-user">
                <div class="group-3">
                  <img class="vector-4" src="img/vector-71.svg" />
                  <img class="vector-5" src="img/vector-72.svg" />
                  <img class="vector-6" src="img/vector-73.svg" />
                </div>
              </div>
              <div class="ellipse"></div>
              <img class="mask-group-2" src="img/mask-group-1.png" />
              <p class="r-sidence-luxe-https">
                <span class="span"><?= $groupe['nom_client'] ?>br /></span>
                <span class="text-wrapper-3"><?= $groupe['url_site'] ?></span>
              </p>
              <img class="image-3" src="img/image-177.png" />
              <img class="image-4" src="img/image-182.png" />
              <!-- rectangles et étiquettes (visuels additionnels) -->
              <div class="rectangle"></div>
              <div class="rectangle-2"></div>
              <div class="rectangle-3"></div>
              <div class="rectangle-4"></div>
              <div class="rectangle-5"></div>
              <div class="text-wrapper-4">ANNONCE</div>
              <div class="rectangle-6"></div>
              <img class="vector-8" src="img/vector-19.svg" />
            </div>

            <!-- BLOCK 8 - Zone CTA "Book Now" / informations détaillées (adresse, téléphone, descriptions longues) -->
            <div class="div-4">
              <div class="text-wrapper-5">Book Now</div>
              <div class="overlap-group">
                <div class="send-icon">
                  <div class="img-wrapper"><img class="vector-9" src="img/vector-64.svg" /></div>
                </div>
                <div class="send-icon">
                  <div class="img-wrapper"><img class="vector-9" src="img/vector-64.svg" /></div>
                </div>
              </div>
              <img class="mask-group-3" src="img/mask-group-3.png" />
              <img class="fi-rr-marker" src="img/fi-rr-marker.svg" />
              <p class="r-sidence-luxe-https-2">
                <span class="span"><?= $groupe['nom_client'] ?><br /></span>
                <span class="text-wrapper-3"><?= $groupe['url_site'] ?></span>
              </p>
              <p class="s-lection-des-plus">
                <?= $groupe['descriptions1'] ?> -   <?= $groupe['descriptions2'] ?> -   <?= $groupe['descriptions3'] ?>
              </p>
              <p class="text-wrapper-6">20 rue les petits pos 772012 Le valnceces</p>
              <p class="text-wrapper-7">Appelez le 06 96 52 58 52</p>
              <p class="location-de-chalets">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
              <p class="location-de-chalets-2">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
              <p class="location-de-chalets-3">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
              <img class="line" src="img/line-56.svg" />
              <img class="image-5" src="img/image-175-1.png" />
              <img class="image-6" src="img/image-237.png" />
              <div class="rectangle-7"></div>
              <img class="icon-phone" src="img/phone-2.png" />
              <img class="line-2" src="img/line-56.svg" />
              <div class="icon-arrow-left-2"><img class="vector-7" src="img/vector-65.svg" /></div>
              <div class="icon-arrow-left-3"><img class="vector-7" src="img/vector-65.svg" /></div>
              <div class="icon-home-3"></div>

              <!-- éléments répétés/overlaps : icônes et labels sponsor -->
              <div class="overlap">
                <div class="group-wrapper">
                  <div class="group-2">
                    <img class="vector" src="img/vector-67.svg" /> <img class="vector-2" src="img/vector-68.svg" />
                  </div>
                </div>
                <div class="group-wrapper">
                  <div class="group-2">
                    <img class="vector" src="img/vector-67.svg" /> <img class="vector-2" src="img/vector-68.svg" />
                  </div>
                </div>
              </div>
              <div class="icon-heart-2"><img class="vector-3" src="img/vector-70.svg" /></div>
              <div class="overlap-2">
                <div class="div-wrapper">
                  <div class="group-3">
                    <img class="vector-4" src="img/vector-71.svg" />
                    <img class="vector-5" src="img/vector-72.svg" />
                    <img class="vector-6" src="img/vector-73.svg" />
                  </div>
                </div>
                <div class="div-wrapper">
                  <div class="group-3">
                    <img class="vector-4" src="img/vector-71.svg" />
                    <img class="vector-5" src="img/vector-72.svg" />
                    <img class="vector-6" src="img/vector-73.svg" />
                  </div>
                </div>
              </div>
              <div class="text-wrapper-8">Sponsorisé</div>
              <img class="mask-group-3" src="img/mask-group-3.png" />
              <img class="fi-rr-marker" src="img/fi-rr-marker-1.svg" />
              <p class="r-sidence-luxe-https-2">
                <span class="span"><?= $groupe['nom_client'] ?><br /></span>
                <span class="text-wrapper-3"><?= $groupe['url_site'] ?></span>
              </p>
              <p class="s-lection-des-plus">
                Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                d&#39;activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
              </p>
              <p class="text-wrapper-6">20 rue les petits pos 772012 Le valnceces</p>
              <p class="location-de-chalets">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
              <img class="image-5" src="img/image-175-1.png" />
              <img class="image-6" src="img/image-237.png" />
              <div class="rectangle-7"></div>
              <img class="icon-phone-2" src="img/phone.png" />
              <div class="icon-home-3"></div>
              <div class="icon-heart-2"><img class="vector-3" src="img/vector-70.svg" /></div>
              <div class="text-wrapper-8">Sponsorisé</div>
              <div class="frame"><img class="vector-10" src="img/vector-74.svg" /></div>
              <div class="text-wrapper-9">Chalet de Luxe Disponibles</div>
              <img class="vector-11" src="img/vector-43.svg" />
            </div>

            <!-- BLOCK 9 - Cartes / variantes visuelles (div-5, div-6) : mini-cards, icônes, images répétées, CTA secondaires -->
            <div class="div-5">
              <div class="rectangle-8"></div>
              <div class="heart-icon-2"></div>
              <img class="image" src="img/image-172-2.png" />
              <div class="text-wrapper">Most Viewed</div>
              <div class="icon-home-2"></div>
              <div class="icon-clock">
                <div class="group-2">
                  <img class="vector" src="img/vector-67.svg" /> <img class="vector-2" src="img/vector-68.svg" />
                </div>
              </div>
              <div class="vector-wrapper"><img class="vector-3" src="img/vector-70.svg" /></div>
              <div class="icon-user">
                <div class="group-3">
                  <img class="vector-4" src="img/vector-71.svg" />
                  <img class="vector-5" src="img/vector-72.svg" />
                  <img class="vector-6" src="img/vector-73.svg" />
                </div>
              </div>
              <div class="ellipse"></div>
              <img class="mask-group-4" src="<?= $groupe['images'][0] ?>" />
              <div class="r-sidence-luxe-https-3">
                &nbsp;&nbsp;<?= $groupe['nom_client'] ?><br />&nbsp;&nbsp;<?= $groupe['url_site'] ?>
              </div>
              <p class="s-lection-des-plus-2">
                Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                d&#39;activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
              </p>
              <p class="location-de-chalets-4">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
              <img class="image-7" src="img/image-175-1.png" />
              <div class="text-wrapper-10">Sponsorisé</div>
              <div class="frame-2"><img class="vector-10" src="img/vector-74.svg" /></div>
              <div class="text-wrapper-11">Chalet de Luxe Disponibles</div>
              <p class="text-wrapper-12">Appelez le 06 96 52 58 52</p>
              <img class="vector-12" src="img/vector-54.svg" />
            </div>

            <div class="div-6">
              <!-- zone avec icônes et mini-images (autre variante de card/preview) -->
              <p class="chalet-de-luxe">
                <span class="text-wrapper-18">Chalet de Luxe Disponibles</span> <span class="text-wrapper-19"></span>
              </p>
              <div class="heart-icon"></div>
              <img class="image" src="img/image-172-2.png" />
              <div class="text-wrapper">Most Viewed</div>
              <div class="ellipse-3"></div>
              <img class="image-9" src="img/image-175-1.png" />
              <img class="mask-group-5" src="<?= $groupe['images'][0] ?>" />
              <img class="ellipse-4" src="img/ellipse-9-1.png" />
              <div class="icon-arrow-left-4"><img class="vector-7" src="img/vector-56.svg" /></div>
              <img class="image-10" src="img/image-176-1.png" />
              <div class="text-wrapper-20">Sponsorisé</div>
              <div class="rectangle-9"></div>
              <div class="text-wrapper-21">Book Now</div>
              <div class="send-icon-2">
                <div class="img-wrapper"><img class="vector-9" src="img/vector-64.svg" /></div>
              </div>
              <div class="frame-3"><img class="vector-13" src="img/vector-59.svg" /></div>
              <div class="frame-4"><img class="vector-10" src="img/vector-60.svg" /></div>
              <div class="frame-5"><img class="vector-14" src="img/vector-61.svg" /></div>
              <div class="frame-6"><img class="vector-15" src="img/vector-62.svg" /></div>
            </div>

            <img class="image-11" src="<?php echo base_url("assets/css/test/img/image-236.png") ?>" />
            <div class="text-wrapper-22">Chalet de Luxe Disponibles</div>

            <!-- BLOCK 10 - Footer / assets partagés / badges Display/Search/Youtube/Discovery/Gmail et éléments finaux -->
            <div class="div-7">
              <div class="rectangle-10"></div>
              <div class="text-wrapper-5">Book Now</div>
              <div class="send-icon-3">
                <div class="img-wrapper"><img class="vector-9" src="img/vector-64.svg" /></div>
              </div>
              <img class="mask-group-6" src="img/mask-group-6.png" />
              <img class="fi-rr-marker-2" src="img/fi-rr-marker-2.svg" />
              <img class="ellipse-5" src="img/ellipse-20.png" />
              <div class="icon-arrow-left-5"><img class="vector-7" src="img/vector-65.svg" /></div>
              <p class="notre-service-de">
                Notre Service de Conciergerie s’occupe de Tout. Vos Vacances Méritent d&#39;être Inoubliables
              </p>
              <div class="r-sidence-luxe-https-4">
                &nbsp;&nbsp;<?= $groupe['nom_client'] ?><br />&nbsp;&nbsp;<?= $groupe['url_site'] ?>
              </div>
              <img class="image-12" src="img/image-175-1.png" />
            </div>

            <div class="div-8">
              <img class="ellipse-6" src="img/ellipse-18.svg" />
              <img class="rectangle-11" src="img/rectangle-78.svg" />
              <img class="heart-icon-3" src="img/image-170-1.png" />
              <img class="image-13" src="img/image-170-1.png" />
              <img class="image-14" src="img/image-170-1.png" />
              <img class="most-viewed" src="img/most-viewed.svg" />
              <img class="fi-rr-marker-3" src="img/fi-rr-marker-3.svg" />
              <div class="icon-home-2"></div>
              <div class="icon-clock">
                <div class="group-2">
                  <img class="vector" src="img/vector-67.svg" /> <img class="vector-2" src="img/vector-68.svg" />
                </div>
              </div>
              <div class="vector-wrapper"><img class="vector-3" src="img/vector-70.svg" /></div>
              <div class="icon-user">
                <div class="group-3">
                  <img class="vector-4" src="img/vector-71.svg" />
                  <img class="vector-5" src="img/vector-72.svg" />
                  <img class="vector-6" src="img/vector-73.svg" />
                </div>
              </div>
              <div class="ellipse"></div>
              <img class="image-2" src="img/image-175-1.png" />
              <img class="mask-group-7" src="img/mask-group-7.png" />
              <img class="ellipse-7" src="img/ellipse-9-2.png" />
              <div class="r-sidence-luxe-https-5">
                &nbsp;&nbsp;<?= $groupe['nom_client'] ?><br />&nbsp;&nbsp;<?= $groupe['url_site'] ?>
              </div>
              <img class="image-15" src="img/image-175-1.png" />
              <img class="image-16" src="img/image-237.png" />
              <div class="rectangle-12"></div>
              <div class="frame-7"><img class="vector-10" src="img/vector-74.svg" /></div>
              <div class="text-wrapper-23">Chalet de Luxe Disponibles</div>
            </div>

            <p class="text-wrapper-24">
              Location de Chalets de Luxe et d’Appartements à Serre Chevalier. Réservez dès Maintenant
            </p>
            <img class="image-17" src="<?php echo base_url("assets/css/test/img/image-236.png") ?>" />
            <img class="display-icon" src="<?php echo base_url("assets/css/test/img/display-icon-48-4.png") ?>" />
            <img class="image-18" src="<?php echo base_url("assets/css/test/img/image-238.png") ?>" />
            <img class="discover-icon" src="<?php echo base_url("assets/css/test/img/discover-icon-48-3.png") ?>" />
            <img class="image-19" src="<?php echo base_url("assets/css/test/img/image-239.png") ?>" />
          </div>
        </div>
      </div>

        <?php endif; ?>
      <?php endforeach; ?>
    </div>

  </body>
</html>
