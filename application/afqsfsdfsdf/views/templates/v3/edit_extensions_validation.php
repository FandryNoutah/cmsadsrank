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
  <style>
    body {
        width: 100%;
        display: flex;
        justify-content: center;
       
     
    
    }
</style>


  </head>

<body>
<div class="card-body collapse in" style="background-color: white; margin: 20px;width: 800px;">
    <div class="card-block" style="background-color: white; margin: 20px;">
        <div class="card-text"></div>
        <h4 style="font-weight: 600">Modification extension</h4>
        <form action="<?php echo site_url('Validation/updateextensions'); ?>" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
            <?php foreach($extensions as $C) { ?>
                <input class="form-control" type="hidden" name="idextensions" value="<?php echo $C['idextensions']; ?>"/>
                <input class="form-control" type="hidden" name="idclients" value="<?php echo $C['idclients']; ?>"/>

                <!-- Titre Extension -->
                <div class="form-group mb-3">
                    <label for="zone" class="form-label text-dark">Titre extension</label>
                    <input class="form-control" type="text" name="titre_extensions" id="zone" value="<?php echo $C['titre_extensions']; ?>" />
                </div>

                <!-- Description Extension -->
                <div class="form-group mb-3">
                    <label for="description_extensions" class="form-label text-dark">Description extensions</label>
                    <textarea class="form-control" name="description_extensions" rows="6"><?php echo $C['description_extensions']; ?></textarea>
                </div>

                <!-- URL Extension -->
                <div class="form-group mb-3">
                    <label for="url_extensions" class="form-label text-dark">URL extensions</label>
                    <input class="form-control" type="text" name="url_extensions" id="url_extensions" value="<?php echo $C['url_extensions']; ?>" />
                </div>

                <!-- Accroche -->
                <div class="form-group mb-3">
                    <label for="extensions_accroche" class="form-label text-dark">Extension d'accroche</label>
                    <textarea class="form-control" name="extensions_accroche" rows="6" cols="25"
                    style="white-space: pre-wrap; word-wrap: break-word;"><?php echo $C['extensions_accroche']; ?></textarea></div>
               

<script>
document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.querySelector('textarea[name="extensions_accroche"]');

    textarea.addEventListener("input", function () {
        // Sauvegarder la position du curseur
        const cursorPos = textarea.selectionStart;

        // Ne pas supprimer les espaces !
        const valueWithoutNewlines = textarea.value.replace(/\n/g, '');

        // Reformater tous les 25 caractères
        let formatted = '';
        for (let i = 0; i < valueWithoutNewlines.length; i += 25) {
            formatted += valueWithoutNewlines.slice(i, i + 25) + '\n';
        }

        // Supprimer le dernier saut de ligne s’il est en trop
        formatted = formatted.trimEnd();

        // Ne rechange que si nécessaire (évite les bugs d'espaces)
        if (textarea.value !== formatted) {
            textarea.value = formatted;
            textarea.selectionStart = textarea.selectionEnd = formatted.length; // replacer le curseur
        }
    });
});
</script>

                <!-- Extraits de site -->
                <div class="form-group mb-3">
                    <label for="extensions_extrait_site" class="form-label text-dark">Extensions d'extraits de site</label>
                    <textarea class="form-control" name="extensions_extrait_site" rows="6"><?php echo $C['extensions_extrait_site']; ?></textarea>
                </div>

                <!-- Extension de lieu -->
                <div class="form-group mb-3">
                    <label for="extensions_lieu" class="form-label text-dark">Extension de lieu</label>
                    <textarea class="form-control" name="extensions_lieu" rows="6"><?php echo $C['extensions_lieu']; ?></textarea>
                </div>

                <!-- Extension d'appel -->
                <div class="form-group mb-3">
                    <label for="extensions_appel" class="form-label text-dark">Extension d'appel</label>
                    <input class="form-control" type="text" name="extensions_appel" id="extensions_appel" value="<?php echo $C['extensions_appel']; ?>" />
                </div>

            <?php } ?>

            <div class="form-actions d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success" name="update" style="font-size: 16px; font-weight: 500; width: 180px; height: 41px; background-color: #4EA5FE; color: white !important; border-radius: 20px;">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

            </body>