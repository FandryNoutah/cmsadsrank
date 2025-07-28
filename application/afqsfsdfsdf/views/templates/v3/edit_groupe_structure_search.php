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
     <style>
    body {
        width: 100%;
        display: flex;
        justify-content: center;

    }
</style>
  </head>


<body>
<div class="card-body collapse in" style="background-color: white; margin: 20px;">
    <div class="card-block" style="background-color: white; margin: 20px;">
        <div class="card-text"></div>
		<h4 style="font-weight: 600">Modification groupe</h4>
        <?php foreach($groupe as $D): ?>
            <form action="<?php echo site_url('Validation/save_groupe_search'); ?>" method="POST" enctype="multipart/form-data">
    <div id="annonce-groups">
        <div class="annonce-group">
            <!-- Hidden Fields -->
            <input type="hidden" name="idgroupe_annonce" class="form-control" value="<?php echo $D['idgroupe_annonce']; ?>"> 
            <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>"> 
            <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagnes']; ?>">

            <!-- Start Row -->
            <div class="row g-3">
                
                <!-- Nom du groupe -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom_groupe">Nom du groupe :</label>
                        <input type="text" name="nom_groupe" class="form-control" value="<?php echo $D['nom_groupe']; ?>">
                    </div>
                </div>

                <!-- Titre 1 -->
                <div class="col-md-6">
                <div class="form-group">
                    <label for="titre1">Titre 1 :</label>
                    <input type="text" name="titre1" class="form-control" value="<?php echo $D['titre1']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre2">Titre 2 :</label>
                    <input type="text" name="titre2" class="form-control" value="<?php echo $D['titre2']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre3">Titre 3 :</label>
                    <input type="text" name="titre3" class="form-control" value="<?php echo $D['titre3']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre4">Titre 4 :</label>
                    <input type="text" name="titre4" class="form-control" value="<?php echo $D['titre4']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre5">Titre 5 :</label>
                    <input type="text" name="titre5" class="form-control" value="<?php echo $D['titre5']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre6">Titre 6 :</label>
                    <input type="text" name="titre6" class="form-control" value="<?php echo $D['titre6']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre7">Titre 7 :</label>
                    <input type="text" name="titre7" class="form-control" value="<?php echo $D['titre7']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre8">Titre 8 :</label>
                    <input type="text" name="titre8" class="form-control" value="<?php echo $D['titre8']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre9">Titre 9 :</label>
                    <input type="text" name="titre9" class="form-control" value="<?php echo $D['titre9']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre10">Titre 10 :</label>
                    <input type="text" name="titre10" class="form-control" value="<?php echo $D['titre10']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre11">Titre 11 :</label>
                    <input type="text" name="titre11" class="form-control" value="<?php echo $D['titre11']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titre12">Titre 12 :</label>
                    <input type="text" name="titre12" class="form-control" value="<?php echo $D['titre12']; ?>">
                </div>
            </div>

                <!-- Description 1 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description1">Description 1 :</label>
                        <input type="text" name="description1" class="form-control" value="<?php echo $D['descriptions1']; ?>">
                    </div>
                </div>

                <!-- Description 2 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description2">Description 2 :</label>
                        <input type="text" name="description2" class="form-control" value="<?php echo $D['descriptions2']; ?>">
                    </div>
                </div>

                <!-- Description 3 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description3">Description 3 :</label>
                        <input type="text" name="description3" class="form-control" value="<?php echo $D['descriptions3']; ?>">
                    </div>
                </div>

                <!-- Description 4 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description4">Description 4 :</label>
                        <input type="text" name="description4" class="form-control" value="<?php echo $D['descriptions4']; ?>">
                    </div>
                </div>

                <!-- Chemin 1 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="chemin1">Chemin 1 :</label>
                        <input type="text" name="chemin1" class="form-control" value="<?php echo $D['chemin1']; ?>">
                    </div>
                </div>

                <!-- Chemin 2 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="chemin2">Chemin 2 :</label>
                        <input type="text" name="chemin2" class="form-control" value="<?php echo $D['chemin2']; ?>">
                    </div>
                </div>

                <!-- URL -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="url">URL :</label>
                        <input type="text" name="url" class="form-control" value="<?php echo $D['url_groupe_annonce']; ?>">
                    </div>
                </div>

        

            </div> <!-- End Row -->

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success" name="update" style="font-size: 16px; font-weight: 500; width: 180px; height: 41px; margin-left: 10px; background-color: #4EA5FE; color: white !important; border-radius: 20px; border-color: #4EA5FE">
                    Enregistrer
                </button>
        </div>
    </div>
</form>


                <?php endforeach; ?>
    </div>
</div>
</body>