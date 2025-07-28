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


<div class="card-body collapse in">
    <div class="card-block">
        <div class="card-text"></div>
		<h4>Modification groupe</h4>
        <form action="<?php echo site_url('Validation/save_groupe_pmax'); ?>" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
            
				<?php foreach($groupe as $G){ ?>
             
				<input class="form-control" type="hidden" name="idgroupe_annonce" value="<?php echo $G['idgroupe_annonce']; ?>"/>
                <input class="form-control" type="hidden" name="idclients" value="<?php echo $G['idclients']; ?>"/>
                <input class="form-control" type="hidden" name="idcampagne" value="<?php echo $G['idcampagne']; ?>"/>
                <input class="form-control" type="hidden" name="type_campagne" value="<?php echo $G['type_campagnes']; ?>"/>
                <div class="row g-3">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Nom groupe d'annonce</label>
                            <input class="form-control" type="text" name="nom_groupe" id="zone" value="<?php echo $G['nom_groupe']; ?>" />
                        </div>
                </div>
             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 1</label>
                            <input class="form-control" type="text" name="titre1" id="zone" value="<?php echo $G['titre1']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 2</label>
                            <input class="form-control" type="text" name="titre2" id="zone" value="<?php echo $G['titre2']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 3</label>
                            <input class="form-control" type="text" name="titre3" id="zone" value="<?php echo $G['titre3']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 4</label>
                            <input class="form-control" type="text" name="titre4" id="zone" value="<?php echo $G['titre4']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 5</label>
                            <input class="form-control" type="text" name="titre5" id="zone" value="<?php echo $G['titre5']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 6</label>
                            <input class="form-control" type="text" name="titre6" id="zone" value="<?php echo $G['titre6']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 7</label>
                            <input class="form-control" type="text" name="titre7" id="zone" value="<?php echo $G['titre7']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 8</label>
                            <input class="form-control" type="text" name="titre8" id="zone" value="<?php echo $G['titre8']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 9</label>
                            <input class="form-control" type="text" name="titre9" id="zone" value="<?php echo $G['titre9']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 10</label>
                            <input class="form-control" type="text" name="titre10" id="zone" value="<?php echo $G['titre10']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 11</label>
                            <input class="form-control" type="text" name="titre11" id="zone" value="<?php echo $G['titre11']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Titre 12</label>
                            <input class="form-control" type="text" name="titre12" id="zone" value="<?php echo $G['titre12']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">URL</label>
                            <input class="form-control" type="text" name="url" id="zone" value="<?php echo $G['url_groupe_annonce']; ?>" />
                        </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Description 1</label>
                            <input class="form-control" type="text" name="description1" id="zone" value="<?php echo $G['descriptions1']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Description 2</label>
                            <input class="form-control" type="text" name="description2" id="zone" value="<?php echo $G['descriptions2']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Description 3</label>
                            <input class="form-control" type="text" name="description3" id="zone" value="<?php echo $G['descriptions3']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Description 4</label>
                            <input class="form-control" type="text" name="description4" id="zone" value="<?php echo $G['descriptions4']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="zone" class="form-label text-dark">Description brève</label>
                            <input class="form-control" type="text" name="description_breve" id="zone" value="<?php echo $G['description_breve']; ?>" />
                        </div>
                    </div>

                    <?php } ?>

                </div>

                <div class="form-actions d-flex justify-content-end mt-4">
                    <button class="btn btn-success" type="submit" name="update">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>
            
        </form>
    </div>
</div>
