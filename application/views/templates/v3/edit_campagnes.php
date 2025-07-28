<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Interface de gestion hors media.">
    <meta name="keywords" content="">
    <meta name="author" content="Dev Miora">
	
	
	
	


	
	
	
    <title>CMS Adsrank<?php if(isset($page_title) && $page_title)  echo " | " . $page_title ?></title>

    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(IMAGES_PATH."/ico/logo4.png") ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(IMAGES_PATH."/ico/logo4.png") ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(IMAGES_PATH."/ico/logo4.png") ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(IMAGES_PATH."/ico/logo4.png") ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(IMAGES_PATH."/ico/logo4.png") ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(IMAGES_PATH."/ico/logo4.png") ?>">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/bootstrap.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/glyphicons.css") ?>">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(FONTS_PATH."/icomoon.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(FONTS_PATH."/flag-icon-css/css/flag-icon.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(VENDORS_PATH."/css/extensions/pace.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH."/multiselect/css/prettify.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(PLUGINS_PATH."/multiselect/css/bootstrap-multiselect.css") ?>">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/bootstrap-extended.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/app.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/colors.css") ?>">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/core/menu/menu-types/vertical-menu.css") ?>">
  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/core/menu/menu-types/vertical-overlay-menu.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/core/colors/palette-gradient.css") ?>">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/font-awesome.all.min.css") ?>">
    <!-- END Custom CSS-->

    <!-- BEGIN Datatables 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/datatables/bootstrap.min.css") ?>">-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/datatables/dataTables.bootstrap.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/datatables/responsive.bootstrap.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/datatables/buttons.dataTables.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/datatables/select.dataTables.min.css") ?>">
    
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/openlayers/ol_v5.2.0.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/openlayers/ol-popup.css") ?>">
	
	
	
	

	  
	
	
	
	
	
    <script src="<?php echo base_url(SCRIPTS_PATH."/openlayers/ol_v5.2.0.js") ?>" type="text/javascript"></script>
    <script src="<?php echo base_url(CSS_PATH."/table2excel.js") ?>" type="text/javascript"></script>
    
	<!-- END Datatables -->
    <script src="<?php echo base_url(SCRIPTS_PATH."/core/libraries/jquery.min.js") ?>" type="text/javascript"></script>
	 <script src="<?php echo base_url(SCRIPTS_PATH."/core/libraries/jquery.min.js") ?>" type="text/javascript"></script>
    <!--<script src="http://maps.google.com/maps/api/js?key=AIzaSyA1fJ1HZNrL06WzcXSY1cnJ8OW1DQABTFA&callback=init_map&sensor=false"></script>-->
	
	 <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
  </head>


<div class="card-body collapse in" style="background-color: white;">
    <div class="card-block">
        <div class="card-text"></div>
		<h4 style="font-weight: 600">Modification campagne</h4>
        <form action="<?php echo site_url('Googleads/updateDonneeClients'); ?>" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
    <?php foreach($campagne as $C) { ?>
            <input class="form-control" type="hidden" name="idcampagne" value="<?php echo $C['idcampagne']; ?>"/>
            <input class="form-control" type="hidden" name="idclients" value="<?php echo $C['idclients']; ?>"/>

            <div class="row g-3">
                <!-- Zone -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="zone" class="form-label text-dark">Zone</label>
                        <input class="form-control" type="text" name="zones" id="zone" value="<?php echo $C['zones']; ?>" />
                    </div>
                </div>

                <!-- Calendrier -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="calendrier" class="form-label text-dark">Calendrier</label>
                        <input class="form-control" type="text" name="date_campagne" id="date_campagne" value="<?php echo $C['date_campagne']; ?>" />
                    </div>
                </div>

                <!-- Appareils -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="appareil" class="form-label text-dark">Appareils</label>
                        <input class="form-control" type="text" name="appareil" id="appareil" value="<?php echo $C['appareil']; ?>" />
                    </div>
                </div>

                <!-- Budget -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="budget" class="form-label text-dark">Budget</label>
                        <input class="form-control" type="text" name="budget" id="budget" value="<?php echo $C['repartition_budget']; ?>"  />
                    </div>
                </div>

                <!-- Campagne -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom_campagne" class="form-label text-dark">Campagne</label>
                        <input class="form-control" type="text" name="nom_campagne" id="nom_campagne" value="<?php echo $C['nom_campagne']; ?>"  />
                    </div>
                </div>

                <!-- Information Campagne et Mot Clé -->
             
                
            
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Objectif</label>
                        <select name="objectif" id="product-choice">
                            <option value="<?php echo $C['objectif']; ?>"><?php echo $C['objectif']; ?> (Actuellement)</option>
                            <option value="Vente">Vente</option>
                            <option value="Lead">Lead</option>
                        </select>
                    </div>
                </div>
    
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mot_cle" class="form-label text-dark">Information campagne</label>
                        <textarea class="form-control form-control-lg" name="information_campagne" id="mot_cle" rows="16" placeholder="Saisir les mots clés"><?php echo $C['information_campagne']; ?></textarea>
                    </div>
                </div>
                <h4 style="font-weight: 600; margin-left: 10px;margin-bottom: 30px;">Modification groupe annonce</h4>
                <?php foreach($groupe as $index => $g): ?>
                    <input type="hidden" name="idgroupe_annonce[]" value="<?php echo $g['idgroupe_annonce']; ?>" />
                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label text-dark">Nom groupe annonce</label>
                            <input class="form-control" type="text" name="nom_groupe[]" value="<?php echo $g['nom_groupe']; ?>" />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label text-dark">Contexte groupe annonce</label>
                            <textarea class="form-control form-control-lg" name="contexte_groupes_annonces[]" rows="2"><?php echo $g['contexte_groupes_annonces']; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label text-dark">Mot clé</label>
                            <textarea class="form-control form-control-lg" name="mot_cle[]" rows="8"><?php echo $g['mot_cle']; ?></textarea>
                        </div>
                        <hr style="border: 1px solid rgb(230, 227, 227); width: 50%; margin: 20px auto; margin-top: 70px; margin-bottom: 50px;">
                    </div>
                     <?php endforeach; ?>

                
                
                        </div>

                        <div class="form-actions d-flex justify-content-end mt-4">
                            <button class="btn btn-success" type="submit" name="update" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">
                                <i class="bi bi-check-circle" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;"></i> Enregistrer
                            </button>
                        </div>
                    <?php } ?>
                </form>

    </div>
</div>
