<?php $r = $pmax[0]['type_image']; if($r == 0): ?>
  <?php  foreach($pmax as $G): 
  //var_dump($G);
//die();
  ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $G['nom_groupe']; ?></title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
      }
     
      .container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        padding: 20px;
      }
      .container  h2{
       text-align: center;
       
      } #4285f4;
      .block {
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;

        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }
      .block h2 {
        font-size: 18px;
       
        color: #333;
      }
      .ad-item {
       
        border: 1px solid #ddd;
       
       
        background-color: #f8f8f8;
      }
      .ad-item img {
        max-width: 100%;
       
      }
      .ad-item .text {
        margin-top: 10px;
      }
      .ad-item .text h3 {
        font-size: 16px;
        margin-left: 15px;
        margin-bottom: 5px;
        color: #007BFF;
      }
      .ad-item .text p {
        font-size: 14px;
       
        margin: 0;
        margin-left: 15px;
        color: #555;
      }
      .cta {
        margin-top: 10px;
        text-align: center;
      }
      .cta a {
        display: inline-block;
        text-decoration: none;
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        font-size: 14px;
        border-radius: 5px;
      }
      .cta a:hover {
        background-color: #0056b3;
      }
      .container2 {
    display: flex;
}

.col1 {
    flex: 1;  /* 1/6 de la largeur */
}

.col2 {
    flex: 4;  /* 5/6 de la largeur */
}
.col3 {
    flex: 1;  /* 5/6 de la largeur */
}
.col5 {
    flex: 2;  /* 5/6 de la largeur */
}
.col6 {
    flex: 4;  /* 5/6 de la largeur */
}
    </style>
  </head>
  <body>
    <div class="container">
	

      <!-- Bloc YouTube -->
      <div class="block" >
        <h3 style="color: black; margin-top: 9px; margin-bottom: 20px; text-align: center; ">Youtube</h3>

        <div class="ad-item">
          <img src="<?php echo base_url(IMAGES_PATH."/youtube.jpg"); ?>" style="width: 100%;">
          <?php if (strpos($images[0]->image_url, 'http') === 0): ?>
                                        <!-- Image externe -->
                                        <img src="<?= $images[0]->image_url ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php else: ?>
                                        <!-- Image locale (dans le dossier 'uploads') -->
                                        <img src="<?= base_url($images[0]->image_url) ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php endif; ?>

          <div class="text">
          <h3 style="margin-left: 15px;"><?php echo $G['titre1']; ?></h3>
            <p><?php echo $G['descriptions1']; ?></p></br>
            <p><b>Annonce</b>  <?php echo $G['nom_client']; ?> </p> 
          </div>
          <div class="cta">
            
          </div>
        </div>
        <div class="ad-item">

          <div class="text">
          <img src="<?php echo base_url(IMAGES_PATH."/youtube.jpg"); ?>" style="width: 100%;">
          <?php //var_dump(); die(); ?>
                                    <?php if (strpos($images[1]->image_url, 'http') === 0): ?>
                                        <!-- Image externe -->
                                        <img src="<?= $images[1]->image_url ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php else: ?>
                                        <!-- Image locale (dans le dossier 'uploads') -->
                                        <img src="<?= base_url($images[1]->image_url) ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php endif; ?>
          <img src="<?php echo $G['image_youtube2']; ?>" alt="Maison Beneva - YouTube 1">
          <h3 style="margin-left: 15px;"><?php echo $G['titre2']; ?></h3>
          <p><?php echo $G['descriptions1']; ?></p>
          </div>
          <div class="cta">
            
          </div>
        </div>
        </div> 
         <!-- Bloc Gmail -->
      <div class="block">
        <h2>Gmail</h2>
        <div class="ad-item">
        <img src="<?php echo base_url(IMAGES_PATH."/entetegmail.jpg"); ?>" style="width: 100%;">
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 70%;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><?php echo $G['titre10']; ?> </br> à moi</p>
        </div>
        </div>
        <?php if (strpos($images[3]->image_url, 'http') === 0): ?>
                                        <!-- Image externe -->
                                        <img src="<?= $images[3]->image_url ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php else: ?>
                                        <!-- Image locale (dans le dossier 'uploads') -->
                                        <img src="<?= base_url($images[3]->image_url) ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php endif; ?>
        <h2 style="text-align: center; margin-left: 15px;"><?php echo $G['titre11']; ?> </h2>
        <p style="text-align: left; margin-left: 15px;"><?php echo $G['descriptions4']; ?></p>
        <?php if (strpos($images[4]->image_url, 'http') === 0): ?>
                                        <!-- Image externe -->
                                        <img src="<?= $images[4]->image_url ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php else: ?>
                                        <!-- Image locale (dans le dossier 'uploads') -->
                                        <img src="<?= base_url($images[4]->image_url) ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php endif; ?>
        <p style="margin-left: 15px;">PROMOTIONS</p>
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 70%; margin-left: 15px;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><b>Sponsored - </b> <?php echo $G['titre10']; ?> </br> à moi</p>
        </div>
        <div class="col3">
        <img src="<?php echo base_url(IMAGES_PATH."/troiepoint.jpg"); ?>" style="width: 25%; margin-top: 20px;">
        </div>
        </div>
      </div>
      </div>

      <!-- Bloc Recherche -->
      <div class="block">
        <h2>Recherche</h2>
        <div class="ad-item">
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 60%; margin-left: 15px;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;margin-top: 20px; font-size: 15px;"><?php echo $G['titre10']; ?> </br> <?php echo $G['url_groupe_annonce']; ?></p>
        </div>
        </div>
        <h3 style="margin-left: 15px;"><?php echo $G['titre7']; ?> - <?php echo $G['titre1']; ?></h3>
        <p style="margin-left: 15px;"><?php echo $G['descriptions1']; ?></p>
      </div>
      </div>

      <!-- Bloc Display -->
      <div class="block">
        <h2>Display</h2>
        <div class="ad-item">
        <img src="<?php echo $G['image_display1']; ?>" alt="Maison Beneva - YouTube 1">
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 90%; margin-left: 15px; margin-top: 4px;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;margin-top: 20px; "><?php echo $G['titre9']; ?> </br><?php echo $G['descriptions3']; ?></p>
        </div>
        </div>
        <div class="container2">
        <div class="col5" style="margin-top: 20px">
        <p style="margin-left: 15px;"><?php echo $G['titre10']; ?> </p>
        </div>
        
        <div class="col6">
        <p style="margin-left: 15px; text-align: right; margin-top: 35px;">En savoir plus ></p>
        </div>
        </div>
          <div class="text">
            <h3>Rénovez Votre Façade</h3>
            <p>Transformez l’apparence et la performance de votre maison.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item">
          <img src="<?php echo $G['image_display2']; ?>" alt="Maison Beneva - Display 2">
          <div class="text">
            <h3>Rénovation De Façade Complète</h3>
            <p>Demandez un devis gratuit en ligne.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Bloc Discover -->
      <div class="block">
        <h2>Discover</h2>
        <div class="ad-item">
        <img src="<?php echo $G['image_youtube1']; ?>" alt="Maison Beneva - YouTube 1">
          <div class="text">
            <h3>Façadier Dans Votre Région</h3>
            <p>Demandez un devis en ligne pour votre rénovation.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item">
        <img src="<?php echo $G['image_youtube1']; ?>" alt="Maison Beneva - YouTube 1">
          <div class="text">
            <h3>Artisan Façadier Reconnu</h3>
            <p>Rénovez et isolez votre façade avec Maison Beneva.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
      </div>

	<?php endforeach; ?>
  </body>
</html>
<?php endif; ?>
<?php $r = $pmax[0]['type_image']; if($r == 1): ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison Beneva - Publicité</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
      }
     
      .container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        padding: 20px;
      }
      .container  h2{
       text-align: center;
       
      } #4285f4;
      .block {
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;

        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }
      .block h2 {
        font-size: 18px;
       
        color: #333;
      }
      .ad-item {
       
        border: 1px solid #ddd;
       
       
        background-color: #f8f8f8;
      }
      .ad-item img {
        max-width: 100%;
       
      }
      .ad-item .text {
        margin-top: 10px;
      }
      .ad-item .text h3 {
        font-size: 16px;
        margin-left: 15px;
        margin-bottom: 5px;
        color: #007BFF;
      }
      .ad-item .text p {
        font-size: 14px;
       
        margin: 0;
        margin-left: 15px;
        color: #555;
      }
      .cta {
        margin-top: 10px;
        text-align: center;
      }
      .cta a {
        display: inline-block;
        text-decoration: none;
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        font-size: 14px;
        border-radius: 5px;
      }
      .cta a:hover {
        background-color: #0056b3;
      }
      .container2 {
    display: flex;
}

.col1 {
    flex: 1;  /* 1/6 de la largeur */
}

.col2 {
    flex: 4;  /* 5/6 de la largeur */
}
.col3 {
    flex: 1;  /* 5/6 de la largeur */
}
.col5 {
    flex: 2;  /* 5/6 de la largeur */
}
.col6 {
    flex: 4;  /* 5/6 de la largeur */
}
    </style>
  </head>
  <body>
    <div class="container">
	<?php  foreach($pmax as $G): 
	
		
		?>

      <!-- Bloc YouTube -->
      <div class="block" >
        <h3 style="color: black; margin-top: 9px; margin-bottom: 20px; text-align: center; ">Youtube</h3>

        <div class="ad-item">
          <img src="<?php echo base_url(IMAGES_PATH."/youtube.jpg"); ?>" style="width: 100%;">
          <img src="<?php echo base_url($G['image_youtube1']); ?>" alt="Maison Beneva - YouTube 1">

          <div class="text">
          <h3 style="margin-left: 15px;"><?php echo $G['titre1']; ?></h3>
            <p><?php echo $G['descriptions1']; ?></p></br>
            <p><b>Annonce</b>   Maison beneva </p> 
          </div>
          <div class="cta">
            
          </div>
        </div>
        <div class="ad-item">

          <div class="text">
          <img src="<?php echo base_url(IMAGES_PATH."/youtube.jpg"); ?>" style="width: 100%;">
          <img src="<?php echo base_url($G['image_youtube2']); ?>" alt="Maison Beneva - YouTube 1">
          <h3 style="margin-left: 15px;"><?php echo $G['titre2']; ?></h3>
          <p><?php echo $G['descriptions1']; ?></p>
          </div>
          <div class="cta">
            
          </div>
        </div>
        </div> 
         <!-- Bloc Gmail -->
      <div class="block">
        <h2>Gmail</h2>
        <div class="ad-item">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/entetegmail.jpg"); ?>" style="width: 100%;">
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 70%;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><?php echo $G['titre10']; ?> </br> à moi</p>
        </div>
        </div>
        <img src="<?php echo base_url($G['image_gmail']); ?>" alt="Maison Beneva - YouTube 1">
        <h2 style="text-align: center; margin-left: 15px;"><?php echo $G['titre11']; ?> </h2>
        <p style="text-align: left; margin-left: 15px;"><?php echo $G['descriptions4']; ?></p>
        <img src="<?php echo base_url(IMAGES_PATH."/formats/recherchegmail.jpg"); ?>" style="width: 100%;">
        <p style="margin-left: 15px;">PROMOTIONS</p>
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 70%; margin-left: 15px;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><b>Sponsored - </b> <?php echo $G['titre10']; ?> </br> à moi</p>
        </div>
        <div class="col3">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/troiepoint.jpg"); ?>" style="width: 25%; margin-top: 20px;">
        </div>
        </div>
      </div>
      </div>

      <!-- Bloc Recherche -->
      <div class="block">
        <h2>Recherche</h2>
        <div class="ad-item">
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 60%; margin-left: 15px;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;margin-top: 20px; font-size: 15px;"><?php echo $G['titre10']; ?> </br> <?php echo $G['url_groupe_annonce']; ?></p>
        </div>
        </div>
        <h3 style="margin-left: 15px;"><?php echo $G['titre7']; ?> - <?php echo $G['titre1']; ?></h3>
        <p style="margin-left: 15px;"><?php echo $G['descriptions1']; ?></p>
      </div>
      </div>

      <!-- Bloc Display -->
      <div class="block">
        <h2>Display</h2>
        <div class="ad-item">
        <img src="<?php echo base_url($G['image_display1']); ?>" alt="Maison Beneva - YouTube 1">
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/favicon.png"); ?>" style="width: 90%; margin-left: 15px; margin-top: 4px;">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;margin-top: 20px; "><?php echo $G['titre9']; ?> </br><?php echo $G['descriptions3']; ?></p>
        </div>
        </div>
        <div class="container2">
        <div class="col5" style="margin-top: 20px">
        <p style="margin-left: 15px;"><?php echo $G['titre10']; ?> </p>
        </div>
        
        <div class="col6">
        <p style="margin-left: 15px; text-align: right; margin-top: 35px;">En savoir plus ></p>
        </div>
        </div>
          <div class="text">
            <h3>Rénovez Votre Façade</h3>
            <p>Transformez l’apparence et la performance de votre maison.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item">
          <img src="<?php echo base_url($G['image_display2']); ?>" alt="Maison Beneva - Display 2">
          <div class="text">
            <h3>Rénovation De Façade Complète</h3>
            <p>Demandez un devis gratuit en ligne.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Bloc Discover -->
      <div class="block">
        <h2>Discover</h2>
        <div class="ad-item">
        <img src="<?php echo base_url($G['image_youtube1']); ?>" alt="Maison Beneva - YouTube 1">
          <div class="text">
            <h3>Façadier Dans Votre Région</h3>
            <p>Demandez un devis en ligne pour votre rénovation.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item">
        <img src="<?php echo base_url($G['image_youtube1']); ?>" alt="Maison Beneva - YouTube 1">
          <div class="text">
            <h3>Artisan Façadier Reconnu</h3>
            <p>Rénovez et isolez votre façade avec Maison Beneva.</p>
          </div>
          <div class="cta">
            <a href="#">En savoir plus</a>
          </div>
        </div>
      </div>

	<?php endforeach; ?>
  </body>
</html>
<?php endif; ?>
