<?php 
  
  $image_url_2 = isset($images[2]) && !empty($images[2]->image_url) ? $images[2]->image_url : $images[1]->image_url;
  $image_url_3 = isset($images[3]) && !empty($images[3]->image_url) ? $images[3]->image_url : $images[1]->image_url;
  $image_url_4 = isset($images[4]) && !empty($images[4]->image_url) ? $images[4]->image_url : $images[1]->image_url;
  $image_url_5 = isset($images[5]) && !empty($images[5]->image_url) ? $images[5]->image_url : $images[1]->image_url;
  $image_url_6 = isset($images[6]) && !empty($images[6]->image_url) ? $images[6]->image_url : $images[1]->image_url;
  $image_url_7 = isset($images[7]) && !empty($images[7]->image_url) ? $images[7]->image_url : $images[1]->image_url;
  $image_url_8 = isset($images[8]) && !empty($images[8]->image_url) ? $images[8]->image_url : $images[1]->image_url;
  
//($image_url === $image_url_3) ? 
  function afficher_image($image_url) {
    if (strpos($image_url, 'http') === 0): ?>
        <img src="<?= $image_url ?>" alt="Image" style="width = 30%" : "object-fit: cover; margin-bottom: 15px;">
    <?php else: ?>
        <img src="<?= base_url($image_url) ?>" alt="Image" style="object-fit: cover; margin-bottom: 15px;">
    <?php endif;
  }


?>

<?php $r = $pmax[0]['type_image']; if($r == 0): ?>
  <?php  
    foreach($pmax as $G): 
      //echo json_encode($G,JSON_PRETTY_PRINT);
      //die();
  ?>
 <?php 
      //echo json_encode($images, JSON_PRETTY_PRINT);
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
  .header-mine{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    width: 100%;
    padding: 0;
  }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: #f1f1f1;
            border-radius: 7px;
            padding: 5px 10px;
            width: 300px;
            margin-left: 10px;
        }

        .search-bar input {
            border: none;
            background: none;
            outline: none;
            flex: 1;
            font-size: 14px;
            padding: 5px;
        }

        .search-bar .icon {
            width: 20px;
            height: 20px;
            background-color: #ddd;
            border-radius: 50%;
        }

        .menu-icon {
            width: 18px;
            height: 18px;
            margin-right: 10px;
        }
        .ep-btn a{
            margin: 10px;
            margin-left: 80px;
            background-color: #1E88E5; /* Bleu */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 25px; /* Bord arrondi */
            cursor: pointer;
            display: inline-block;
            text-align: center;
            min-width: 150px;
            transition: background 0.3s;
            text-decoration: none;
            align-items: center
        }

        .ep-btn a:hover {
            background-color: #1565C0; /* Bleu plus foncé au survol */
        }

        .floating-btn {
          width: 50px;
          height: 50px;
          background-color: #1E88E5;
          border: none;
          border-radius: 50%;
          margin-right:10px;
          margin-top: 15px;
          color: white;
          font-size: 24px;
          cursor: pointer;
          display: flex;
          justify-content: center;
          align-items: center;
          box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
          transition: background-color 0.3s, transform 0.2s;
      }

      .floating-btn:hover {
          background-color: #1565C0;
          transform: scale(1.1);
      }
    </style>
  </head>
  <body>
    
    <div class="header-mine">
      <img src="<?php echo base_url(IMAGES_PATH."/logo3.png")?>" style="max-height : 50px; margin-left: 20px;" alt="logo">
      <h1 style="margin: 0; margin-right: 20px;">Inventaire&nbsp;</h1>
    </div>
    <div class="container">
	

      <!-- Bloc YouTube -->
      <div class="block" >
      <h3 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius : 12px">Youtube</h3>


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
          <h3 style="margin-left: 15px; text-decoration: bold; color: black;"><?php echo $G['titre1']; ?></h3>
            <p><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description" ?></p></br>
            <p><b>Annonce - </b>  <?php echo $G['nom_client']; ?> </p> 
          </div>
          <div class="ep-btn">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item" style="margin-top : 20px">

          <div class="text">
          <img src="<?php echo base_url(IMAGES_PATH."/youtube.jpg"); ?>" style="width: 100%;">
          
                                    <?php if (strpos($images[1]->image_url, 'http') === 0): ?>
                                        <!-- Image externe -->
                                        <img src="<?= $images[1]->image_url ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php else: ?>
                                        <!-- Image locale (dans le dossier 'uploads') -->
                                        <img src="<?= base_url($images[1]->image_url) ?>" alt="Image" style=" object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php endif; ?>
          <h3 style="margin-left: 15px; text-decoration: bold; color: black;"><?php echo !empty($G['titre2']) ? $G['titre2'] : $G['titre1']; ?></h3>
          <p><?php echo !empty($G['descriptions2']) ? $G['descriptions2'] : "Aucune description" ?></p></br>
          <p><b>Annonce - </b>  <?php echo $G['nom_client']; ?> </p> 
          </div>
           <div class="ep-btn">
            <a href="#">En savoir plus</a>
          </div>                             
        </div>
        </div> 

         <!-- Bloc Gmail -->
      <div class="block">
        <h3 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius : 12px">Gmail</h3>
        <div class="ad-item">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/entetegmail.jpg"); ?>" style="width: 100%;">
        <div class="container2">
        <div class="col1" style="margin-top: 15px; margin-left: 15px;;">
        <img src="<?php echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><?php echo !empty($G['titre3']) ? $G['titre3'] : $G['titre1']; ?> </br> à moi</p>
        </div>
        </div>

        

        <?php afficher_image($image_url_2) ?>
        <h2 ><?php echo !empty($G['titre4']) ? $G['titre4'] : $G['titre1']; ?> </h2>
        <p><?php !empty($G['descriptions3']) ? $G['descriptions3'] : "Aucune description" ?></p>
        


        <div class="search-bar">
          <img src="https://cdn-icons-png.flaticon.com/512/60/60510.png" class="menu-icon" alt="Menu">
          <input type="text" placeholder="Rechercher dans les messages">
          <div class="icon"></div>
        </div>
        <p style="margin-left: 15px;">PROMOTIONS</p>
        <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><b>Sponsored - </b> <?php echo !empty($G['titre5']) ? $G['titre5'] : $G['titre1']; ?> </br> <?php echo !empty($G['descriptions4']) ? $G['descriptions4'] : "Aucune description"?></p>
        </div>
        <div class="col3">
        <img src="<?php echo base_url(IMAGES_PATH."/formats/troiepoint.jpg"); ?>" style="width: 52%; margin-top: 17px;">
        </div>
        </div>
      </div>
      </div>

      <!-- Bloc Recherche -->
      <div class="block">
        <h3 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius : 12px">Recherche</h3>
        <div class="ad-item">
          <p style="text-align: left; margin-left: 15px"><b>Sponsorisé</b></p>
          <div class="container2">
            <div class="col1">
             <img src="<?php echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">
            </div>
        
            <div class="col2">
              <p style="margin-left: 15px; "><b><?php echo $G['nom_client']; ?></b><br><?php echo $G['site_client']; ?></p>
            </div>
          </div>
          <h2 style="margin-left: 15px; margin-top: 10px; color: #4285f4; text-align: left;"><?php echo $G['titre7']; ?> <?php echo $G['titre1']; ?></h2>
          <p style="margin-left: 15px; margin-top : 6px"><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description"; ?></p>
        </div>

        <div class="ad-item">
          <p style="text-align: left; margin-left: 15px"><b>Sponsorisé</b></p>
          <div class="container2">
            <div class="col1">
              <img src="<?php echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">
            </div>
        
            <div class="col2">
              <p style="margin-left: 15px; "><b><?php echo $G['nom_client']; ?></b><br><?php echo $G['site_client']; ?></p>
            </div>
          </div>
          <h2 style="margin-left: 15px; margin-top: 10px; color: #4285f4; text-align: left;"><?php echo $G['titre7']; ?> <?php echo $G['titre1']; ?></h2>
          <div class="container2">
            <div class="col1">
              <p style="margin-left: 15px; margin-top : 10px ; margin-right: 10px;"><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description"; ?></p>
            </div>
        
            <div class="col2">
           <?php echo '<img src="' . $image_url_3 . '" width="250" height="auto" />'; ?>

            </div>
          </div>
        </div>
      </div>

      <!-- Bloc Display -->
      <div class="block">
        <h3 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius : 12px">Display</h3>
        <div class="ad-item">
          <?php afficher_image($image_url_4) ?>
          
        <div class="container2">
          <div class="col1" style="margin-top: 20px">

              
          <img src="<?php echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">

          </div>
          
          <div class="col2">
          <p style="margin-left: 15px;"><b><?php echo $G['titre1']; ?></b> </br> <?php echo $G['description_breve']; ?></p>
          </div>
        </div>
          <!-- <div class="text">
            <h3 style="text-decoration: bold; color: black;">Rénovez Votre Façade</h3>
            <p>Transformez l’apparence et la performance de votre maison.</p>
          </div> -->
          <div class="ep-btn">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item" style="margin-top : 20px">
        <?php afficher_image($image_url_5) ?>
          <div class="text">
            <h3 style="text-decoration: bold; color: black;"><?php echo $G['titre1']; ?></h3>
            <p><?php echo $G['description_breve']; ?></p>
          </div>
          <div class="ep-btn">
            <a href="#">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Bloc Discover -->
      <div class="block">
        <h3 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius : 12px">Discover</h3>
        <div class="ad-item">
        <?php afficher_image($image_url_6) ?>
          <div class="text">
            <p style="margin-left: 15px;"><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description"; ?></p>
            <p style="margin-top: 10px"><b>Annonce - </b>  <?php echo $G['nom_client']; ?> </p>
          </div>
          <div class="ep-btn">
            <a href="#">En savoir plus</a>
          </div>
        </div>
        <div class="ad-item" style="margin-top : 20px">
        <?php afficher_image($image_url_7) ?>
          <div class="text">
            <h3 style="text-decoration: bold; color: black;"></h3><?php echo $G['titre1']; ?></h3>
          </div>
          <div class="container2">
        <div class="col1" style="margin-top: 20px">
        <img src="<?php echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">
        </div>
        
        <div class="col2">
        <p style="margin-left: 15px;"><?php echo $G['description_breve']; ?></p>
        </div>
        <div class="col3">
        <button class="floating-btn">
            &#10095;
        </button>
        </div>
        </div>
        <!-- <div class="ep-btn">
            <a href="#">En savoir plus</a>
          </div> -->
      </div>

	<?php endforeach; ?>
  </body>
</html>
<?php endif; ?>
