<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/search/globals.css") ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/search/styleguide.css") ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/search/style.css") ?>" />
     <style>
      .zoom {
        transform: scale(0.45);
        transform-origin: top left;
        width: 250%;
      }
    </style>
  </head>
  <body>
    <div class="zoom" >
    <?php foreach($groupe_valider as $groupe): ?>
    <?php if ($groupe['type_campagne'] == 1): ?>
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
                      <div class="vector-wrapper"><img class="vector" src="<?php echo base_url("assets/css/search/img/globals.css") ?>" /></div>
                    </div>
                    <div class="send-icon">
                      <div class="vector-wrapper"><img class="vector" src="<?= $groupe['favicon'] ?>" /></div>
                    </div>
                  </div>
                  <img class="mask-group" src="<?= $groupe['images'][0] ?>" />
                  <p class="s-lection-des-plus">
                    <?= $groupe['descriptions1'] ?> -   <?= $groupe['descriptions2'] ?> -   <?= $groupe['descriptions3'] ?>
                  </p>
                  <p class="p">20 rue les petits pos 772012 Le valnceces</p>
                  <p class="text-wrapper-2">Appelez le 06 96 52 58 52</p>
                  <p class="location-de-chalets"><?= $groupe['titre1'] ?> | <?= $groupe['titre2'] ?> </p>
                  <p class="text-wrapper-3">
                    Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile
                  </p>
                  <img class="image" src="<?= $groupe['favicon'] ?>" />
                  <img class="img" src="<?php echo base_url("assets/css/search/img/image-177.png") ?>" />
                  <img class="icon-phone" src="img/image.png" />
                  <div class="text-wrapper">Book Now</div>
                  <div class="fi-rr-marker">
                    <img class="vector-2" src="img/vector-4.svg" /> <img class="vector-3" src="<?= $groupe['favicon'] ?>" />
                  </div>
                  <p class="r-sidence-luxe-https">
                    <span class="span"><?= $groupe['nom_client'] ?><br /></span>
                    <span class="text-wrapper-4"><?= $groupe['url_site'] ?></span>
                  </p>
                  <p class="location-de-chalets-2"><?= $groupe['titre1'] ?></p>
                  <p class="text-wrapper-5">
                   <?= $groupe['descriptions1'] ?>
                  </p>
                  <p class="location-de-chalets-3"><?= $groupe['titre1'] ?> | <?= $groupe['titre2'] ?> | <?= $groupe['titre2'] ?></p>
                  <img class="line" src="img/line-60.svg" />
                  <div class="rectangle"></div>
                  <img class="line-2" src="img/line-59.svg" />
                  <div class="icon-arrow-left"><img class="vector-4" src="img/vector-8.svg" /></div>
                  <div class="img-wrapper"><img class="vector-4" src="img/vector-8.svg" /></div>
                  <p class="text-wrapper-6">
                    Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile
                  </p>
                  <p class="location-de-chalets-4">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
                  <img class="line-3" src="img/line-60.svg" />
                  <div class="icon-arrow-left-2"><img class="vector-4" src="img/vector-8.svg" /></div>
                  <div class="text-wrapper-7">Sponsorisé</div>
                  <div class="frame-2"><img class="vector-5" src="<?= $groupe['favicon'] ?>" /></div>
                </div>
                <img class="vector-6" src="img/vector-45.svg" />
              </div>
              <div class="div-3">
                <div class="heart-icon"></div>
                <img class="image-2" src="img/image-172.png" />
                <div class="text-wrapper-8">Most Viewed</div>
                <div class="icon-home"></div>
                <div class="icon-clock">
                  <div class="group-2">
                    <img class="vector-7" src="img/vector-37.svg" /> <img class="vector-8" src="img/vector-38.svg" />
                  </div>
                </div>
                <div class="icon-heart"><img class="vector-9" src="img/vector-40.svg" /></div>
                <div class="icon-user">
                  <div class="group-3">
                    <img class="vector-10" src="img/vector-41.svg" />
                    <img class="vector-11" src="img/vector-42.svg" />
                    <img class="vector-12" src="img/vector-43.svg" />
                  </div>
                </div>
                <div class="ellipse"></div>
                <img class="mask-group-2" src="<?= $groupe['images'][0] ?>" />
                <div class="r-sidence-luxe-https-2">
                  &nbsp;&nbsp;<?= $groupe['nom_client'] ?><br />&nbsp;&nbsp;https://www.residence-luxe.com
                </div>
                <p class="s-lection-des-plus-2">
                  Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                  d&#39;activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
                </p>
                <p class="location-de-chalets-5">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
                <img class="image-3" src="<?= $groupe['favicon'] ?>" />
                <div class="text-wrapper-9">Sponsorisé</div>
                <p class="text-wrapper-10">Appelez le 06 96 52 58 52</p>
                <img class="vector-13" src="img/vector-20.svg" />
                <img class="image-4" src="<?php echo base_url("assets/css/search/img/image-177.png") ?>" />
                <div class="rectangle-2"></div>
                <div class="frame-3"><img class="vector-5" src="img/vector-44.svg" /></div>
                <div class="text-wrapper-11">Chalet de Luxe Disponibles</div>
              </div>
              <div class="div-4">
                <div class="text-wrapper-12">Book Now</div>
                <div class="overlap">
                  <div class="send-icon-2">
                    <div class="group-4"><img class="vector-14" src="img/vector-35.svg" /></div>
                  </div>
                  <div class="send-icon-2">
                    <div class="group-4"><img class="vector-14" src="img/vector-35.svg" /></div>
                  </div>
                </div>
                <img class="mask-group-3" src="<?= $groupe['images'][0] ?>" />
                <img class="fi-rr-marker-2" src="img/fi-rr-marker.svg" />
                <p class="r-sidence-luxe-https-3">
                  <span class="span"><?= $groupe['nom_client'] ?><br /></span>
                  <span class="text-wrapper-13">https://www.residence-luxe.com</span>
                </p>
                <p class="s-lection-des-plus-3">
                  Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                  d&#39;activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
                </p>
                <p class="text-wrapper-14">20 rue les petits pos 772012 Le valnceces</p>
                <p class="text-wrapper-15">Appelez le 06 96 52 58 52</p>
                <p class="location-de-chalets-6">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
                <p class="location-de-chalets-7">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
                <p class="location-de-chalets-8">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
                <img class="line-4" src="img/line-56.svg" />
                <img class="image-5" src="<?= $groupe['favicon'] ?>" />
                <img class="image-6" src="<?php echo base_url("assets/css/search/img/image-177.png") ?>" />
                <div class="rectangle-2"></div>
                <img class="icon-phone-2" src="img/phone.png" />
                <img class="line-5" src="img/line-56.svg" />
                <div class="icon-arrow-left-3"><img class="vector-15" src="img/vector-25.svg" /></div>
                <div class="icon-arrow-left-4"><img class="vector-15" src="img/vector-25.svg" /></div>
                <div class="icon-home-2"></div>
                <div class="overlap-2">
                  <div class="icon-clock-2">
                    <div class="group-2">
                      <img class="vector-7" src="img/vector-37.svg" /> <img class="vector-8" src="img/vector-38.svg" />
                    </div>
                  </div>
                  <div class="icon-clock-2">
                    <div class="group-2">
                      <img class="vector-7" src="img/vector-37.svg" /> <img class="vector-8" src="img/vector-38.svg" />
                    </div>
                  </div>
                </div>
                <div class="icon-heart-2"><img class="vector-9" src="img/vector-40.svg" /></div>
                <div class="overlap-3">
                  <div class="icon-user-2">
                    <div class="group-3">
                      <img class="vector-10" src="img/vector-41.svg" />
                      <img class="vector-11" src="img/vector-42.svg" />
                      <img class="vector-12" src="img/vector-43.svg" />
                    </div>
                  </div>
                  <div class="icon-user-2">
                    <div class="group-3">
                      <img class="vector-10" src="img/vector-41.svg" />
                      <img class="vector-11" src="img/vector-42.svg" />
                      <img class="vector-12" src="img/vector-43.svg" />
                    </div>
                  </div>
                </div>
                <div class="text-wrapper-16">Sponsorisé</div>
                <img class="mask-group-3" src="img/mask-group-3.png" />
                <img class="fi-rr-marker-2" src="img/fi-rr-marker-1.svg" />
                <p class="r-sidence-luxe-https-3">
                  <span class="span">Résidence Luxe<br /></span>
                  <span class="text-wrapper-13">https://www.residence-luxe.com</span>
                </p>
                <p class="s-lection-des-plus-3">
                  Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation
                  d&#39;activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
                </p>
                <p class="text-wrapper-14">20 rue les petits pos 772012 Le valnceces</p>
                <p class="location-de-chalets-6">Location de Chalets de Luxe &amp; Prestige à Serre Chevalier</p>
                <img class="image-5" src="<?= $groupe['favicon'] ?>" />
                <img class="image-6" src="<?php echo base_url("assets/css/search/img/image-177.png") ?>" />
                <div class="rectangle-2"></div>
                <img class="icon-phone-3" src="img/phone-2.png" />
                <div class="icon-home-2"></div>
                <div class="icon-heart-2"><img class="vector-9" src="img/vector-40.svg" /></div>
                <div class="text-wrapper-16">Sponsorisé</div>
                <div class="frame-3"><img class="vector-5" src="img/vector-44.svg" /></div>
                <div class="text-wrapper-11">Chalet de Luxe Disponibles</div>
                <img class="vector-16" src="img/vector-45.svg" />
              </div>
              <div class="text-wrapper-17">Search</div>
              <img class="image-7" src="img/image-178.png" />
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
     <?php endif; ?>
    <?php endforeach; ?>
  </body>
</html>
