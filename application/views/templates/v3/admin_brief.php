<style>
  .main-container {
    display: flex;
    gap: 10px;
    transition: all 0.3s ease;
  }

  #leftColumn {
  width: 340px;
  background-color: white;
  padding: 25px 20px 50px;
  border-radius: 5px;
  height: 100vh;
  overflow-y: auto;
  transition: all 0.3s ease;
  box-sizing: border-box;

  flex-shrink: 0; /* ✅ Empêche la colonne gauche de se rétrécir */
}


#rightColumn {
  flex-grow: 1;         /* ✅ Prend tout l’espace dispo */
  flex-shrink: 1;       /* Peut rétrécir si l’espace manque */
  min-width: 0;         /* ✅ Important pour éviter les débordements internes */
  background-color: white;
  padding: 30px;
  transition: all 0.3s ease;
}


  #toggleButton {
    cursor: pointer;
    font-size: 22px;
    margin-bottom: 10px;
    display: inline-block;
  }

  .badge {
    padding: 5px 15px;
    border-radius: 5px;
    color: white !important;
    font-weight: bold;
  }

  .badge.black { background-color: black; }
  .badge.purple { background-color: #6355e7; }
  .info-section h2 {
  font-size: 16px;
  margin-top: 20px;
  font-weight: bold;
}


.info-content p {
  font-size: 14px;
  word-break: break-word; /* ✅ Casse les mots longs */
  overflow-wrap: break-word; /* ✅ Coupe proprement si besoin */
  white-space: normal; /* ✅ Le texte revient automatiquement à la ligne */
}


  .client-name {
    color: black;
    font-size: 25px;
    text-decoration: underline;
  }

  .details-card {
    padding: 30px;
  }
</style>

<div class="row" style="margin-top: -10px; margin-bottom: 20px;">
    <div class="col-md-1">
      <span id="toggleButton" onclick="toggleDetails()">
      <i class="fas fa-times" style="color: #949cab;"></i>
      </span>
    </div>
    <div class="col-md-11" style="text-align: right">
    <?php foreach($donnees as $D): ?>
                    <?php if($D['information_client'] != NULL): ?>  
                      <?php echo anchor("Googleads/information_client/".$D['idclients'], 
                        '<h6 style="font-size: 16px; font-weight: 500; width: 200px; height: 44px; margin-left: 10px; background-color: white; color: black; border-width: 2px; border-color: rgb(230, 227, 227); border-radius: 20px; border-size: 1px; margin-top: 5px;" class="btn">Modifier information</h6><i class="button"></i>', 
                        'data-edit="'.$D['idonnee'].'"'); ?>         
                      <?php 
                      echo anchor(
                          "Googleads/campagne/".$D['idclients'],
                          '<span style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 10px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FC; color: white! important; border-radius: 20px; text-decoration: none;margin-left: 10px;">Suivant</span>',
                          'data-edit="'.$D['idonnee'].'"'
                      ); 
                      ?>

                       
                    <?php endif; ?>   
    <?php endforeach; ?> 
    </div>
 
</div>
<!-- Two Columns -->
<div class="main-container">

  <!-- Left Column -->
  <div class="details" id="leftColumn">
  <?php foreach($idinitiative as $D): ?> 

<!-- Avatar utilisateur -->
<div style="text-align: center;">
  <img width="150" style="margin-bottom: 30px;" src="<?php echo base_url(IMAGES_PATH.$D['photo_users']) ?>" alt="avatar"> 
</div>  

<!-- Infos utilisateur -->
<div class="row" style="margin-bottom: 20px;">
  <div class="col-md-6" style="padding-left: 10px;margin-right: -20px; ">
    <p style="color: black;font-size: 16px;"><b>Commercial</b> </p>
    <p style="color:black;font-size: 16px;"><b>AM </b></p>

  </div>

  <div class="col-md-6" style="text-align: right; padding-right: 0px;">
    <p style="color: black;font-size: 16px;"><?php echo $D['first_name']; ?> <?php echo $D['last_name']; ?></span></p>
    <p style="color: black;font-size: 16px;"><?php echo $idam[0]['first_name']; ?> <?php echo $idam[0]['last_name']; ?></p>

  </div>
</div>

<hr style="border: 1px solid rgb(230, 227, 227); width: 50%; margin: 20px auto;">

<!-- Nom du client -->

<div class="row" style="text-align: center; margin: 10px;">
<span style="font-weight: bold; color: black !important; font-size: 20px; ">
  
  Client : <?php echo $client[0]['nom_client']; ?>
</span>

</div> 

<!-- Informations complémentaires client -->



<div class="row" style="margin-bottom: 10px;">
<div class="col-md-6" style="padding-left: 10px;margin-right: -20px;margin-bottom: 5px; ">
<p style="margin: 0; color:black;" >
<b style="color: black;font-size: 16px;">Site Internet</b>
</p>
</div>
<div class="col-md-6" style="text-align: right; padding-right: 0px;">
<p style="margin: 0;">
  <a style="color: black;font-size: 16px;" href="<?php 
    $url = $client[0]['site_client'];
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
      $url = 'https://' . $url;
    }
    echo $url;
  ?>" target="_blank" style="color:black;">
    Lien
  </a>
</p>
</div>
</div>
<?php //var_dump($upsell); die(); ?>
     
<div class="row" style="margin-bottom: 0px;">
  <div class="col-md-6" style="padding-left: 10px;margin-right: -20px; width: 180px;margin-bottom: 5px;">
    <p style="color: black;font-size: 16px;"><b>Date mise en ligne</b> </p>
    <p style="color: black;font-size: 16px;"><b>Date Anniversaire</b></p>
  </div>

  <div class="col-md-6" style="text-align: right; padding-right: 15px;margin-bottom: 5px;">
    <p style="color: black;font-size: 16px;"><?php echo $donnees[0]['annonce']; ?> </p>
    <p style="color: black;font-size: 16px;"><?php echo $donnees[0]['mis_en_place_paiement']; ?> </p>
  </div>
</div>
<?php if (!empty($client[0]['logo_client'])): ?>
<div class="row" style="margin-bottom: 10px;">
  <div class="col-md-6" style="padding-left: 10px;margin-right: -20px;">
    <p style="margin: 0 ; color: black;font-size: 16px;">
    <b>Logo</b>
    </p>
  </div>
  <div class="col-md-6" style="text-align: right; padding-right: 00px; margin-bottom: 5px;">
   
      <a href="<?php echo base_url($client[0]['logo_client']); ?>">
        <img src="<?php echo base_url($client[0]['logo_client']); ?>" 
            alt="Logo Client" 
            title="Logo Client"
            style="width: 120px; height: auto;" />
      </a>
 
  </div>
</div>
<hr style="border: 1px solid rgb(230, 227, 227); width: 50%; margin: 20px auto;">

<!-- Nom du client -->

<div class="row" style="text-align: center; margin: 10px;">
<span style="font-weight: bold; color: black !important; font-size: 20px; ">
  
  Budget</br>
</span>
</div>
<?php if($upsell == NULL): ?>
      <div class="row">
        <div class="col-md-6" style="padding-left: 10px;margin-right: -20px;margin-bottom: 5px; ">
          <p style="color:black;font-size: 16px;"><b>Budget initiale</b></p>
        </div>

        <div class="col-md-6" style="text-align: right; padding-right: 0px;">
          <p style="color: black;font-size: 16px;"><?php echo $donnees[0]['budget']; ?> €</p>
        </div>
      </div>
      <?php endif; ?>
      <?php if($upsell != NULL): ?>
        <div class="row" style="text-align: center; ">
          <p style="color: black;font-size: 16px;"><?php echo $upsell->date_demande; ?> -> <?php echo $upsell->date_upsell; ?></p>
        </div>
      <div class="row">
        <div class="col-md-6" style="padding-left: 10px;margin-right: -20px;margin-bottom: 5px; ">
          <p style="color:black;font-size: 16px;"><b>Budget initiale</b></p>
        </div>

        <div class="col-md-6" style="text-align: right; padding-right: 0px;">
          <p style="color: black;font-size: 16px;"><?php echo $upsell->budget_initiale; ?> €</p>
        </div>
      </div>
      <?php if( $upsell->type_upsell == 2): ?>
      <div class="row">
        <div class="col-md-6" style="padding-left:10px;margin-right: -20px;margin-bottom: 5px; ">
          <p style="color:black;font-size: 16px;"><b>Budget Upsell</b></p>
        </div>

        <div class="col-md-6" style="text-align: right; padding-right: 0px;">
          <p style="color: black;font-size: 16px;"><?php echo $upsell->budgets; ?> €</p>
        </div>
      </div>
      <?php endif; ?>
      <?php if( $upsell->type_upsell == 1): ?>
      <div class="row">
        <div class="col-md-6" style="padding-left: 10px;margin-right: -20px;margin-bottom: 5px; ">
          <p style="color:black;font-size: 16px;"><b>Baisse de budget</b></p>
        </div>

        <div class="col-md-6" style="text-align: right; padding-right: 0px;">
          <p style="color: black;font-size: 16px;"><?php echo $upsell->budgets; ?> €</p>
        </div>
      </div>
      <?php endif; ?>
      <div class="row">
        <div class="col-md-6" style="padding-left: 10px;margin-right: -20px;margin-bottom: 5px; ">
          <p style="color:black;font-size: 16px;"><b>Budget Total</b></p>
        </div>

        <div class="col-md-6" style="text-align: right; padding-right: 0px;">
          <p style="color: black;font-size: 16px;"><?php echo $donnees[0]['budget']; ?> €</p>
        </div>
      </div>   
      <?php endif; ?>
<?php endif; ?>


<?php endforeach; ?>
</div>

  <!-- Right Column -->
  <div id="rightColumn">
    <div class="details-card">
      <!-- Ton contenu PHP ici comme dans ton exemple -->
      <?php foreach($donnees as $D): ?>
            <?php //var_dump($D['dejaclient']); die(); ?>
            <div class="badges">
            <?php if($D['dejaclient'] == 0): ?>
              <span class="badge black" style="background-color: black; padding: 5px;padding-left: 15px;padding-right: 15px; border-radius: 5px; color: white! important; "><b>Nouveau client</b></span>
              <?php endif; ?>
              <?php if($D['dejaclient'] == 1): ?>

              <span class="badge black" style="background-color: black; padding: 5px;padding-left: 15px;padding-right: 15px; border-radius: 5px; color: white! important; "><b>Upsell</b></span>
              <?php endif; ?>
                <?php if($D['secteur_activite'] != NULL): ?>
              <span class="badge purple" style="margin-left: 10px;background-color: #6355e7; padding: 5px;padding-left: 15px;padding-right: 15px; border-radius: 5px; color: white! important; "><b><?php echo $D['secteur_activite']; ?></b></span>
              <?php endif; ?>
              <?php endforeach; ?>
              
              </div>
              <?php foreach($client as $Cl): ?> 
                    <div style="margin-right: 10px;margin-top: 20px; ">
                    <p class="client-name" style="color: black; font-size: 25px; text-decoration: underline;">
                    <b>Client : <?php echo $Cl['nom_client']; ?></b></p>

                    </div>
            <?php endforeach; ?>  
            <div style="text-align: center">   
                    <?php if($D['information_client'] == NULL): ?>
                        <?php foreach($client as $C): ?> 
                            <?php foreach($idam as $DA): ?>  
                                <h1 class="congratulation-message" style="font-size: 40px; margin-top: 40px;">
                                   <b> Félicitation <?php echo $DA['first_name'] ?> ,</br> tu as en gestion l’entreprise <?php echo $C['nom_client'] ?>.</br>
                                    À toi de jouer !!
                                </b></h1>
                            <?php endforeach; ?> 
                            <?php echo anchor("Googleads/information_client/".$D['idclients'], 
                            '<img width="150" src="'.base_url('assets/images/ico/drop.png').'" alt="WLB" title="WLB"/>', 
                            'data-edit="'.$D['idonnee'].'"'); ?>
                        <?php endforeach; ?>         
                        <p style="font-size: 20px;">Cliquer pour enregistrer le brief du client</p>
                    </div>  
                    <?php endif; ?>
            </div>  
            <?php if($D['information_client'] != NULL): ?>                    
            <section class="info-section">
              <h2 style="font-size: 16px;">Information client :</h2>
              <div class="info-content">
              <p style="font-size: 16px;">
              <?php echo nl2br($D['information_client']); ?>
            </p>
              </div>
            </section>
            
            <?php if (!empty($D['contexte_client'])): ?>
            <section class="info-section">
              <h2 style="font-size: 16px;">Contexte client :</h2>
              <div class="info-content">
                <p style="font-size: 16px;"><?php echo $D['contexte_client']; ?><br>
                </p>
               
              </div>
            </section>
            <?php endif; ?>
            <?php if (!empty($D['tracking_gtm'])): ?>
            <section class="info-section">
              <h2 style="font-size: 16px;">Tracking GTM :</h2>
              <div class="info-content">
                <p style="font-size: 16px;"><?php echo nl2br($D['tracking_gtm']); ?><br>
                </p>
               
              </div>
            </section>
            <?php endif; ?>
            <?php if (!empty($D['commentaire'])): ?>    
            <section class="info-section">
              <h2 style="font-size: 16px;">Commentaire</h2>
              <div class="info-content">
                <p style="font-size: 16px;"><?php echo nl2br($D['commentaire']); ?></p>
              </div>
            </section>
            <?php endif; ?>
            <?php if (!empty($D['information_complementaire'])): ?>    
            <section class="info-section">
              <h2 style="font-size: 16px;">Information complémentaire :</h2>
              <div class="info-content">
                <p style="font-size: 16px;"><?php echo nl2br($D['information_complementaire']); ?></p>
              </div>
            </section>
          </div>
          <?php endif; ?>
          <?php endif; ?>
            
    </div>
  </div>

</div>

<script>
  function toggleDetails() {
    const leftCol = document.getElementById("leftColumn");
    const toggleBtn = document.getElementById("toggleButton");

    if (leftCol.style.display === "none") {
      leftCol.style.display = "block";
      toggleBtn.innerHTML = '<i class="fas fa-times" style="color: #949cab;"></i>';
    } else {
      leftCol.style.display = "none";
      toggleBtn.innerHTML = '<i class="fas fa-eye" style="color: #949cab;"></i>';
    }
  }
</script>
