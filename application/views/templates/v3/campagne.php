<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:500,400,600|Manrope:400,500,700,800" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/Amdin_brief_css.css") ?>">
    <title>Page avec popup</title>
    <style>
        body{
            font-family: 'Manrope', sans-serif;
           
            min-height: 100vh;

        }
.popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border: 2px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-width: 1800px; /* Augmenter la largeur de la popup */
    width: 100%;
    text-align: center;
    max-height: 80vh; /* Limite la hauteur à 80% de la fenêtre visible */
    overflow: hidden;  /* Masque tout débordement à l'extérieur de la popup */
}

/* Contenu de la popup avec scroll si nécessaire */
.popup-content2 {
    max-height: 70vh; /* Limite la hauteur du contenu à 70% de la fenêtre */
    max-width: 150;
    overflow-y: auto;  /* Permet le défilement vertical si le contenu dépasse */
    margin-bottom: 20px;
}

/* Style pour le fond sombre derrière la popup */
.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Fond noir transparent */
    z-index: 999;
}





        /* Style pour le bouton */
        button {
            padding: 10px 20px;
            background-color: #4EA5FE;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }
            .col-md-67 {
                padding-top: 200px;
    display: flex;
    flex-direction: column; 
    height: 100vh; 
    }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #4EA5FE;
            color: white;
            text-align: left;
        }
        td {
            background-color: white;
        }
        .header {
            font-weight: bold;
            color: #333;
            font-size: 18px;
            width: 35%;
        }
        .blue-cell {
            background-color: #4EA5FE;
            font-weight: bold;
            color: white;
            width: 10%;
        }
        .green-text {
            color: green;
        }
        .col {
            background-color: red;
        }
        /* Style for export button */
        .export-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #004A99;
            color: white;
            border: none;
            cursor: pointer;
        }
        /* Image style for logo */
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            width: 200px;
            padding-right: 20px;
        }
        .logo-container h1 {
            flex: 1;
            text-align: right;
        }
@font-face {
    font-family: 'Product Sans';
    font-style: normal;
    font-weight: normal;
    src: local('Product Sans'), url('<?php echo base_url(CSS_PATH."/fontgoogle/ProductSans-Regular.woff"); ?>') format('woff');
}	.table-striped tbody tr:nth-of-type(2n+1) {
  background-color: white;
}

    .status-new-client, .status-upsell {
        color: white; 
        background-color: black; 
        padding: 0 20px; 
        text-align: center; 
        border-radius: 4px;
    }
    .sector-info {
        margin-left: 25px; 
        color: white; 
        background-color: #6554E5; 
        text-align: center; 
        border-radius: 4px; 
        padding: 0 20px;
    }
    .congratulation-message {
        font-size: 72px; 
        text-align: center; 
        font-weight: bold;
    }
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
    font-size: 16px;
  }
    </style>
  
    
    
</head>
<body >
<?php if($this->session->flashdata('success')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("success"); ?>
	</div>

<?php endif; ?>
<?php if($this->session->flashdata('message-success')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-success"); ?>
	</div>

<?php endif; ?>
<?php if($this->session->flashdata('success-images')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("success-images"); ?>
	</div>

<?php endif; ?>
<div class="row">
    <div class="col-md-1">
      <span id="toggleButton" onclick="toggleDetails()">
      <i class="fas fa-times" style="color: #949cab;"></i>
      </span>
    </div>
    <div class="col-md-11" style="text-align: right">
        
<?php foreach($donnees as $D): ?>
                    <!-- Display Campaign Status -->
                    <p style="margin-right: 10px;">
                        <?php if($D['campagne_actif'] == 0): ?>
                            Statut brief : <a style="color: #CEC80F"> Brouillon</a>
                        <?php elseif($D['campagne_actif'] == 1): ?>
                            
                            Statut brief: <a style="color: #37BC9B"> Actif</a>
                        <?php endif; ?>
                        &ensp;&ensp;&ensp;&ensp;&ensp;
                        <?php if($D['validation_technique'] == "0000-00-00"): ?>
                            Envoye structure : <a style="color: #CEC80F"> En cours</a>
                        <?php elseif($D['validation_technique'] != "0000-00-00"): ?>
                            Envoye structure : <a style="color: #37BC9B"> Publier</a>
                        <?php endif; ?>
                        <?php if ($current_user->tech != 1): ?>  
                            <?php echo anchor(
                        "Googleads/save_campagne/".$donnees[0]['idonnee'], 
                        '<span style="font-size: 16px; font-weight: 500;width: 190px; height: 41px; margin-left: 10px; background-color: #CEC80F; color: white !important; border-radius: 20px;" class="btn">
                             Save Brief
                        </span>',
                        'data-edit="'.$donnees[0]['idonnee'].'"'
                         ); ?>
                         <?php endif; ?>

                        
                          
                            <?php if ($current_user->tech == 1): ?>  
                                    <?php echo anchor(
                                        "Googleads/save_annonce_technique/" . $donnees[0]['idclients'], 
                                        '<span style="font-size: 16px; font-weight: 500;width: 190px; height: 41px; margin-left: 10px; background-color: #CEC80F; color: white !important; border-radius: 20px;" class="btn">
                                            Save structure
                                        </span>',
                                        'data-edit="' . $donnees[0]['idonnee'] . '"'
                                    ); ?>
                                <?php endif; ?>
                    </p>
            </div>
        <?php endforeach; ?> 
    </div>
</div>
<div class="main-container" style="margin-top: -20px;">
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
  <div id="rightColumn" style="margin-right: 40px; ">
    <div class="details-card">
    <?php foreach($donnees as $D): ?>

<?php if ($current_user->tech != 1): ?>  
    <?php if ($donne_valider == NULL): ?>   
        <h3 style="font-size: 52px; text-align: center"><b><?php echo $current_user->first_name ?> , C’est parti pour</br> l’élaboration de la stratégie !!</h3></b>  
        <div style="text-align: center; margin-top: 20px;">  
        <?php echo anchor("Googleads/ajoutCampagne/".$D['idonnee'], 
        '<h6 class="btn btn-secondary mr-1" style="border-color: #4EA5FE; font-size: 16px; font-weight: 500;margin-top: 5px; margin-left: 10px; width: 200px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; cursor: pointer; margin-right: 25px; "> <i class="fas fa-plus" ></i>  &nbsp;&nbsp;&nbsp;<b>Ajout campagne</b></h6>', 
        'data-edit="'.$D['idonnee'].'"'); ?>   
        </div>  
    <?php endif; ?>

    <?php if ($donne_valider != NULL): ?>   
        <?php $nbrcampagne = count($campagne); $nbrgroupe = count($nbrgroupe);  ?>
    
        <?php foreach($donnees as $D){ ?>
            <!-- Code à compléter si nécessaire -->
        <?php } ?> 

        <?php $budget_restant = $D['budget'] - $budgetutilisé ?> 
        <div style="text-align: center; margin-top: 20px;">  
        <?php if($budget_restant != 0): ?>           
            <h3 style="font-size: 52px; text-align: center"><b><?php echo $current_user->first_name ?> ,Il te reste <?php echo $budget_restant ?> euros de budget,</br> que souhaites-tu faire ?</h3></b> 
                 <?php echo anchor("Googleads/ajoutCampagne/".$D['idonnee'], 
                        '<h6 style="font-size: 16px; font-weight: 500;margin-top: 5px; margin-left: 10px; width: 200px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; cursor: pointer; margin-right: 25px" class="btn">Ajout campagne</h6><i class="button"></i>', 
                        'data-edit="'.$D['idonnee'].'"'); ?>
                    <i class="open-remarque-modal" 
                    data-id="<?php echo $D['idonnee']; ?>" 
                    style="font-size: 24px; color: #4EA5FE; cursor: pointer;">
                    <img style="margin-top: 0px; margin-right: 10px;" 
                            width="42" 
                            src="<?php echo base_url('assets/images/ico/1f4e92.png'); ?>" 
                            alt="WLB" title="WLB" />
                    </i>

            <div class="modal fade" id="remarqueModal" tabindex="-1" role="dialog" aria-labelledby="remarqueModalLabel" aria-hidden="true" style="margin-top: 150px;"> 
                <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Ajoute cette classe -->
                <form method="post" action="<?php echo site_url('Googleads/ajoutremarqueCampagne'); ?>" enctype="multipart/form-data">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="remarqueModalLabel">Ajouter une remarque</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="idonnee" id="modal-idonnee">

                            <div class="form-group">
                                <label for="remarque">Remarque :</label>
                                <textarea class="form-control" name="remarque" id="remarque" rows="20"><?php echo $D['remarque_campagne']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="fichier">Pièce jointe :</label>
                                <input type="file" name="fichier" class="form-control-file">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" style="font-size: 16px; font-weight: 500; background-color: #4EA5FE;">Enregistrer</button>
                        </div>
                    </div>
                </form>

                </div>
                </div>

            </div>
            <script>
            $(document).ready(function(){
                $('.open-remarque-modal').click(function(){
                    var id = $(this).data('id');
                    $('#modal-idonnee').val(id);
                    $('#remarqueModal').modal('show');
                });
            });
            </script>



  
        <?php endif; ?>     
        </div>  
         
        <?php if($budget_restant == 0): ?>
            <h3 style="font-size: 52px; text-align: center"><b>Bravo, il ne reste plus qu’à faire</br> valider stratégie!</h3></b> 
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($current_user->tech == 1): ?>  
    <h3 style="font-size: 52px; text-align: center"><b><?php echo $current_user->first_name ?> , C’est parti pour</br>la création de l’annonce !!</h3></b>       
<?php endif; ?>
        <?php if ($current_user->tech == 1): ?>  
        <div style="text-align: center; margin-top: 20px;">          
            <?php //echo anchor("Googleads/gestion_extension/".$D['idclients'], '<h6 class="btn btn-secondary mr-2 " style="font-size: 16px; font-weight: 500;margin-top: 5px; margin-left: 10px; width: 200px; height: 41px;padding-top: 9px; background-color: #4EA5FE; color: white; border-radius: 20px; cursor: pointer; margin-right: 25px; border: none;"><i style="margin-right:  10px"></i>Extensions</h6>', 'data-edit="'.$D['idclients'].'"'); ?>  
            <?php if ($D['remarque_campagne'] != NULL): ?> 
                <i 
                class="open-remarque-modal"
                data-id="<?php echo $D['idonnee']; ?>" 
                style="font-size: 24px; color: #4EA5FE; cursor: pointer;">
                <img style="margin-top: -5px; margin-right: 10px;" width="42" src="<?php echo base_url('assets/images/ico/1f4e9.png'); ?>" alt="WLB" title="WLB" />
            </i>
            <?php endif; ?>
        </div> 

    


                        <div class="modal fade" id="remarqueModal" tabindex="-1" role="dialog" aria-labelledby="remarqueModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="margin-top: 40%;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="remarqueModalLabel"><b>Remarque sur le client:</b></h5>
                            </div>
                            <div class="modal-body">
                                <p style="font-size: 16px;">
                                    <?php echo nl2br(htmlspecialchars($D['remarque_campagne'], ENT_QUOTES, 'UTF-8')); ?>
                                 </p>

                                <?php if (!empty($D['fichier_nom'])): ?>
                                    <hr style="border: 1px solid rgb(230, 227, 227); width: 50%; margin: 20px auto; margin-top: 40px;">

                                    <h5 class="modal-title" id="remarqueModalLabel"><b>Une pièce jointe est disponible:</b></h5>
                                    <p class="mt-3">
                                        📎 <a href="<?php echo base_url($D['fichier_nom']); ?>" target="_blank" download>
                                            Télécharger la pièce joint
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <script>
                $(document).ready(function(){
                $('.open-remarque-modal').click(function(){
                    var id = $(this).data('id');
                    $('#modal-idonnee').val(id);
                    $('#remarqueModal').modal('show');
                });
                });
                </script>
        <?php endif; ?>  

<div style="text-align: left; margin-top: 25px; margin-left: 20px; font-size: 16px;">
    Budget GoogleAds :   <b><?php echo $donnees[0]['budget']; ?> €  </b>  </br> 
    <?php foreach ($donne_valider as $D): ?>
        <?php 
            $nomCampagne = $D['nom_campagne']; 
            $repartitionBudget = $D['repartition_budget']; 
        ?>
        <?php echo $nomCampagne; ?> : <b><?php echo $repartitionBudget; ?> €</b> <br>
    <?php endforeach; ?>  
</div>
<table id="campaign-table" style="margin-top: 105px;">
                    <thead>
                        <tr >
                            <?php if($current_user->tech == 0 || $current_user->tech == 3): ?> 
                            <th style="text-align: center;">AM</th>
                            <?php endif; ?>
                            <th style="text-align: center;">Campagne</th>
                            <th style="width: 250px; text-align: center;"  >Information campagne</th>
                            <th  style="text-align: center;">Zone</th>
                            <th style="text-align: center;">Objectif</th>
                            <th style="text-align: center;">URL</th>
                            <th style="text-align: center;">Calendrier</th>
                            <th style="text-align: center;">Appareils</th>
                            <th style="text-align: center;">Budget</th>
                            <th style="text-align: center;">Campagne</th>
                            <th style="text-align: center;">GA</th>
                            <th style="text-align: center; width: 350px! important;">Contexte Groupe d'annonces</th>
                            <th style="text-align: center;" style="width: 350px">Mots-clés</th>
                            <?php if($current_user->tech == 0 || $current_user->tech == 3) : ?> 
                            <th style="text-align: center;">AM</th>
                            <?php endif; ?>
                            <?php if($current_user->tech == 1 || $current_user->tech == 3): ?> 
                            <th style="text-align: center;">Tech</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php foreach($donne_valider as $D): ?>
                            <?php
                                $countG = count($D['groupes_annonces']);
                            ?>
                            <tr>
                                <?php if ($countG > 0): ?>
                                    <!-- Affichage pour la campagne avec des groupes d'annonces -->
                                    <?php if($current_user->tech == 0 || $current_user->tech == 3): ?> 
                                    <td rowspan="<?php echo $countG; ?>">
                                        <?php echo anchor("Googleads/editcampagne/".$D['idcampagne'], '<i class="fas fa-edit" style="color: #949cab"></i>','data-edit="'.$D['idcampagne'].'"'); ?>
                                        <?php echo anchor("Googleads/deletecampagne/".$D['idcampagne'], '<i class="fas fa-trash" style="color: #949cab"></i>', 'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette campagne ?\');" data-edit="'.$D['idcampagne'].'"'); ?>
                                        <?php if($current_user->tech == 0 || $current_user->tech == 3): ?> 
                                            <?php //var_dump($group); ?>
                                            <?php if( $D['type_campagne']  == 1): ?>
                                            <?php //echo anchor("Googleads/insertgroupeannonce/".$group['idgroupe_annonce'], '<i class="fas fa-edit"></i>', 'data-edit="'.$group['idgroupe_annonce'].'"'); ?>
                                            <?php //echo anchor("Googleads/validation_client/".$D['idcampagne'], '<h6 class="fas fa-eye"></h6><i class="button"></i>', 'data-edit="'.$D['idcampagne'].'" target="_blank"'); ?>

                                            <?php echo anchor("Googleads/ajout_groupeannonce/".$D['idcampagne'], '<i class="fas fa-plus" style="color: #949cab"></i>','data-edit="'.$D['idcampagne'].'"') ;?>
                                            
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        
                                    </td>
                                    <?php endif; ?>
                                    <td rowspan="<?php echo $countG; ?>">
                                        <?php echo $D['nom_campagne']; ?>
                                    </td>
                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['information_campagne']; ?></td>
                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['zones']; ?></td>
                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['objectif']; ?></td>
                                    <td rowspan="<?php echo $countG; ?>">
                                        <a href="<?php 
                                            // Vérifier si l'URL commence par http:// ou https://
                                            $url = $D['url_site'];
                                            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                                                // Ajouter https:// si l'URL est mal formée ou relative
                                                $url = 'https://' . $url;
                                            }
                                            echo $url; 
                                        ?>" 
                                        style="color: #373a3c" target="_blank">
                                        <?php echo htmlspecialchars($D['url_site']); ?>
                                        </a>
                                    </td>


                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['date_campagne']; ?></td>
                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['appareil']; ?></td>
                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['repartition_budget']; ?> €</td>
                                    <td rowspan="<?php echo $countG; ?>"><?php echo $D['nom_campagne']; ?></td>
                                    <?php foreach($D['groupes_annonces'] as $group): ?>
                                        <td><?php echo $group['nom_groupe']; ?></td>
                                        <td style="width: 400px;"><?php echo $group['contexte_groupes_annonces']; ?></td>
                                        <td style="text-align: center; width: 500px! important;" >
                                            <?php 
                                                $motCles = explode("\n", $group['mot_cle']);
                                                foreach ($motCles as $motCle) {
                                                    echo '"' . trim($motCle) . '"<br>';
                                                }
                                            ?>
                                        </td>
                                        <?php if($current_user->tech == 0 || $current_user->tech == 3): ?> 
                                        <td>
                                            <?php //var_dump($group); ?>
                                            <?php if( $D['type_campagne']  == 1): ?>
                                            <?php //echo anchor("Googleads/insertgroupeannonce/".$group['idgroupe_annonce'], '<i class="fas fa-edit"></i>', 'data-edit="'.$group['idgroupe_annonce'].'"'); ?>
                                            <?php //echo anchor("Googleads/validation_client/".$D['idcampagne'], '<h6 class="fas fa-eye"></h6><i class="button"></i>', 'data-edit="'.$D['idcampagne'].'" target="_blank"'); ?>
                                      
                                            <?php //echo anchor("Googleads/ajout_groupeannonce/".$D['idcampagne'], '<i class="fas fa-plus" style="color: #4285f4"></i>','data-edit="'.$D['idcampagne'].'"') ;?>
                                            
                                            <?php endif; ?>
                                            <?php if( $D['type_campagne']  == 2): ?>
                                        
                                            <?php //echo $group['idgroupe_annonce']; ?>
                                            <?php endif; ?>
                                            <?php if( $D['type_campagne']  == 3): ?>
                                                <?php //var_dump($group['idgroupe_annonce']);  ?>   
                                      
                                            <?php //echo $group['idgroupe_annonce']; ?>
                                            <?php endif; ?>
                                            <?php echo anchor(
                                                "Googleads/deletegroupeannonce/".$group['idgroupe_annonce'], 
                                                '<i class="fas fa-trash" style="color: #949cab"></i>', 
                                                'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce groupe d annonce ?\');" data-edit="'.$group['idgroupe_annonce'].'"'
                                            ); ?>
                                            <?php //echo anchor("Googleads/ajout_groupeannonce/".$D['idcampagne'], '<h6 class="fas fa-plus"></h6><i  class="button" ></i>','data-edit="'.$D['idcampagne'].'"') ;?>
                                            
                                        </td>
                                        <?php endif; ?>
                                        <?php if($current_user->tech == 1 || $current_user->tech == 3): ?> 
                                        <td>
                                        
                                            <?php if( $D['type_campagne']  == 1): ?>
                                            <?php echo anchor(
                                                "Googleads/insertgroupeannonce/".$group['idgroupe_annonce'], 
                                                '<i class="fas fa-plus-circle" style="color: #949cab"></i>', 
                                                'data-edit="'.$group['idgroupe_annonce'].'"'
                                            ); ?>
                                            </br>
                                            <?php echo anchor("Googleads/validation_client/".$D['idcampagne'], 
                                            '<i class="fas fa-eye" style="color: #949cab"></i>', 
                                            'data-edit="'.$D['idcampagne'].'" target="_blank"'); ?>
                                            <?php endif; ?>
                                            <?php if( $D['type_campagne']  == 2): ?>
                                            <?php echo anchor(
                                                "Googleads/ajout_groupeannonce_local/".$group['idgroupe_annonce'], 
                                                '<i class="fas fa-plus-circle" style="color: #949cab"></i>', 
                                                'data-edit="'.$group['idgroupe_annonce'].'"'
                                            ); ?>
                                            </br>
                                            <?php echo anchor("Googleads/Visualiserlocal/".$group['idgroupe_annonce'], 
                                            '<i class="fas fa-eye" style="color: #949cab"></i>', 
                                            'data-edit="'.$group['idgroupe_annonce'].'" target="_blank"'); ?>
                                            <?php endif; ?>
                                            <?php if( $D['type_campagne']  == 3): ?>
                                            
                                            <?php echo anchor(
                                                "Googleads/ajout_groupeannonce_pmax/".$group['idgroupe_annonce'], 
                                                '<i class="fas fa-plus-circle" style="color: #949cab"></i>', 
                                                'data-edit="'.$D['idcampagne'].'"'
                                            ); ?>
                                            </br>
                                            <?php // echo anchor("Googleads/gestion_extension_pmax/".$D['idclients'],  '<i class="fas fa-cogs"></i>', 'data-edit="'.$D['idclients'].'"'); ?>
                                            <?php echo anchor("Googleads/Visualiserpmax/".$group['idgroupe_annonce'], 
                                            '<i class="fas fa-eye" style="color: #949cab"></i>', 
                                            'data-edit="'.$group['idgroupe_annonce'].'" target="_blank"'); ?>
                                            <?php endif; ?>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Si aucun groupe d'annonces n'est disponible, affichez la campagne avec une ligne vide pour "Groupe d'annonces" -->
                                
                                    <td><?php echo anchor("Googleads/editcampagne/".$D['idcampagne'], '<i class="fas fa-edit" style="color: #949cab"></i>','data-edit="'.$D['idcampagne'].'"'); ?>
                                        
                                        <?php echo anchor(
                                            "Googleads/deletecampagne/".$D['idcampagne'], 
                                            '<i class="fas fa-trash" style="color: #949cab"></i>', 
                                            'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette campagne ?\');" data-edit="'.$D['idcampagne'].'"'
                                        ); ?>
                                        
                                    </td>
                                    <td><?php echo $D['nom_campagne']; ?></td>
                                    <td><?php echo $D['information_campagne']; ?></td>
                                    <td><?php echo $D['zones']; ?></td>
                                    <td><?php echo $D['objectif']; ?></td>
                                    <td><?php echo $D['url_site']; ?></td>
                                    <td><?php echo $D['date_campagne']; ?></td>
                                    <td><?php echo $D['appareil']; ?></td>
                                    <td><?php echo $D['repartition_budget']; ?> €</td>
                                    <td><?php echo $D['nom_campagne']; ?></td>
                                    <td>Pas de groupe d'annonces</td> <!-- Message d'absence de groupe -->
                                    <td> </td>
                                    <td> </td>
                                 
                                    <td> <?php 
                                        echo anchor(
                                            "Googleads/ajout_groupeannonce/".$D['idcampagne'], 
                                            '<i class="fas fa-plus" style="color: #949cab"></i> ', 
                                            '" data-edit="'.$D['idcampagne'].'"'
                                        ); 
                                        ?>
                                        </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                    </tbody>
                </table>
                
        </div>    </div>
      
      </main>

      <?php endforeach; ?>
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















































































































</div>              