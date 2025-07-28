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
    <?php if($this->ion_auth->logged_in()) : ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/core/menu/menu-types/vertical-menu.css") ?>">
    <?php endif; ?>
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

  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">
	
    <!-- navbar-fixed-top-->
<?php if($this->ion_auth->logged_in()) : ?>
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
            
			
			
            <li class="nav-item">
              <a href="<?php echo base_url("Googleads"); ?>" class="navbar-brand nav-link">
                <!--
                <img 
                  alt="branding logo" 
                  src="<?php echo base_url(IMAGES_PATH."/logo/logo4.png") ?>" 
                  data-expand="<?php echo base_url(IMAGES_PATH."/logo/logo4.png") ?>" 
                  data-collapse="<?php echo base_url(IMAGES_PATH."/logo/logo4.png") ?>" 
                  class="brand-logo">
                -->
              	<img 
              alt="branding logo" 
              src="<?php echo base_url(IMAGES_PATH."/logo/logo4.png") ?>" 
              data-expand="<?php echo base_url(IMAGES_PATH."/logo/adsrank.png") ?>" 
              data-collapse="<?php echo base_url(IMAGES_PATH."/logo/logo4.png") ?>" 
              class="brand-logo">

            </li>

            <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
          </ul>
        </div>
		
        <div class="navbar-container content container-fluid">
          <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
            <ul class="nav navbar-nav">
              <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5">         </i></a></li>
              <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a></li>
			  
            </ul>

            <ul class="nav navbar-nav float-xs-right">

              <!--
              <li class="dropdown dropdown-language nav-item"><a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i class="flag-icon flag-icon-gb"></i><span class="selected-language">English</span></a>
                <div aria-labelledby="dropdown-flag" class="dropdown-menu"><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</a><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-fr"></i> French</a><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-cn"></i> Chinese</a><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-de"></i> German</a></div>
              </li>
              -->

              <!-- Notifications
              <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-bell4"></i><span class="tag tag-pill tag-default tag-danger tag-default tag-up">5</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag tag tag-default tag-danger float-xs-right m-0">5 New</span></h6>
                  </li>
                  <li class="list-group scrollable-container"><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-cart3 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">You have new order!</h6>
                          <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">30 minutes ago</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-monitor3 icon-bg-circle bg-red bg-darken-1"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading red darken-1">99% Server load</h6>
                          <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Five hour ago</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-server2 icon-bg-circle bg-yellow bg-darken-3"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                          <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-check2 icon-bg-circle bg-green bg-accent-3"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">Complete the task</h6><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last week</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-bar-graph-2 icon-bg-circle bg-teal"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">Generate monthly report</h6><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last month</time></small>
                        </div>
                      </div></a></li>
                  <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all notifications</a></li>
                </ul>
              </li>
              -->

              <!-- Messages
              <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-mail6"></i><span class="tag tag-pill tag-default tag-info tag-default tag-up">8</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span><span class="notification-tag tag tag-default tag-info float-xs-right m-0">4 New</span></h6>
                  </li>
                  <li class="list-group scrollable-container"><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?php echo base_url(IMAGES_PATH."/portrait/small/avatar-s-1.png") ?>" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Margaret Govan</h6>
                          <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start the project.</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="<?php echo base_url(IMAGES_PATH."/portrait/small/avatar-s-2.png") ?>" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Bret Lezama</h6>
                          <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Tuesday</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?php echo base_url(IMAGES_PATH."/portrait/small/avatar-s-3.png") ?>" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Carie Berra</h6>
                          <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Friday</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="<?php echo base_url(IMAGES_PATH."/portrait/small/avatar-s-6.png") ?>" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Eric Alsobrook</h6>
                          <p class="notification-text font-small-3 text-muted">We have project party this saturday night.</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">last month</time></small>
                        </div>
                      </div></a></li>
                  <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all messages</a></li>
                </ul>
              </li>
              -->

              <li class="dropdown dropdown-user nav-item">
                  <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                      <span class="avatar avatar-online">
                          <img src="<?php echo base_url(IMAGES_PATH."/portrait/small/avatar-s-1.png") ?>" alt="avatar"><i></i>
                      </span>
                      <span class="user-name"><?php echo $current_user->first_name . " " . $current_user->last_name ?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                      <a href="<?php echo base_url("admin/user/edit/" . $current_user->id); ?>" class="dropdown-item"><i class="icon-head"></i> Editer mon profil</a>
                      <!--
                      <a href="#" class="dropdown-item"><i class="icon-mail6"></i> My Inbox</a>
                      <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Task</a>
                      <a href="#" class="dropdown-item"><i class="icon-calendar5"></i> Calender</a>
                      -->
                      <div class="dropdown-divider"></div>
                      <a href="<?php echo base_url("admin/user/logout"); ?>" class="dropdown-item"><i class="icon-power3"></i> Déconnexion</a>
                  </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <style>
        /* Style de la popup */
        .popup {
            display: none; /* initialement masqué */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* fond semi-transparent */
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
        }
        

       
        .popup-header {
            font-size: 20px;
            margin-bottom: 10px;
        }
      

        .close {
            color: #aaa;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .brief {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 999;
        }
        /* Fond sombre derrière la popup (briefoverlay) */
        .briefoverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }
        /* Style pour le bouton de fermeture */
        .closebrief {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
        }
        /* Style de la cellule */
/* Style de la cellule */
.action-cell {
    position: relative;
    display: inline-block;
}

/* Les icônes de boutons sont initialement invisibles */
.action-buttons {
    display: none;
    position: absolute;
    top: 0;
    right: 0;
    background-color: #f1f1f1;
    padding: 5px;
    border-radius: 5px;
}

/* Style des boutons */
.action-btn {
    margin: 5px;
    padding: 5px 10px;
    cursor: pointer;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
}

/* Changer la couleur au survol */
.action-btn:hover {
    background-color: #45a049;
}

/* Afficher les boutons lorsque l'utilisateur survole la cellule */
.action-cell:hover .action-buttons {
    display: block;
}

/* Styles pour le popup */
.popup_edit-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

/* Contenu du popup (formulaire d'édition) */
.popup_edit-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 600px;  /* Largeur maximale */
    height: 80%;  /* Hauteur de la fenêtre */
    overflow-y: auto;  /* Permet le défilement si le contenu est trop long */
    position: relative;
}

/* Style pour la croix de fermeture */
.close_edit-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

/* Styles pour le formulaire */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;  /* Espacement entre les éléments */
}

/* Styles des champs du formulaire */
form input[type="text"], form input[type="email"], form input[type="date"] {
    width: 100%;
    padding: 10px;
    margin: 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* Style pour le bouton de soumission */
form input[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #45a049;
}
/* Style pour le popup */
.popup {
    display: none; /* initialement masqué */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* fond semi-transparent */
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Assure que le popup est bien au-dessus des autres éléments */
}

/* Contenu du popup */
.popup-content {
    background-color: #fff;
    padding: 15px; /* Réduire le padding pour une taille plus compacte */
    border-radius: 10px;
    max-width: 600px; /* Limiter la largeur du popup */
    width: 90%; /* Le popup prend 90% de la largeur disponible */
    height: 80%; /* Limiter la hauteur du popup */
    overflow-y: auto; /* Ajouter une barre de défilement verticale si le contenu est trop long */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre légère pour un effet de profondeur */
}

/* En-tête du popup */
.popup-header {
    font-size: 20px; /* Taille de police réduite pour l'en-tête */
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center; /* Centrer le texte du titre */
}

/* Bouton de fermeture */
.close {
    color: #aaa;
    float: right;
    font-size: 22px; /* Taille de police réduite pour le bouton de fermeture */
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

/* Styles des champs de formulaire */
.form-group {
    margin-bottom: 10px; /* Réduire l'espacement entre les champs */
}

.form-group label {
    font-size: 14px; /* Taille de police réduite pour les labels */
    margin-bottom: 5px;
    display: block; /* S'assurer que le label est sur une nouvelle ligne */
    text-align: left; /* Alignement du texte à gauche pour les labels */
}

/* Champs de saisie et de sélection */
.form-group input,
.form-group select {
    width: 100%; /* Champs de saisie qui occupent toute la largeur disponible */
    padding: 8px; /* Réduire le padding */
    font-size: 14px; /* Taille de texte réduite */
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    text-align: left; /* Aligner le texte à gauche dans les champs */
}

.form-group select {
    cursor: pointer;
}

/* Style pour le bouton de soumission */
button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%; /* Le bouton occupe toute la largeur */
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Média Queries pour les petits écrans */
@media (max-width: 768px) {
    .popup-content {
        width: 95%; /* Réduire encore la largeur du popup sur les petits écrans */
        height: 80%;
    }
}

/* Style de la popup */
.product-popup {
							display: none; /* Cachée par défaut */
							position: fixed; /* Fixe la popup à l'écran */
							z-index: 1; /* Au-dessus de tout le reste */
							left: 0;
							top: 0;
							width: 100%;
							height: 100%;
							overflow: auto; /* Permet de faire défiler si nécessaire */
							background-color: rgba(0,0,0,0.4); /* Fond sombre semi-transparent */
						}

						.product-popup-content {
							background-color: #fefefe;
							margin: 15% auto;
							padding: 20px;
							border: 1px solid #888;
							width: 80%; /* Largeur de la popup */
							max-width: 600px;
						}

						.close-popup {
							color: #aaa;
							float: right;
							font-size: 28px;
							font-weight: bold;
						}

						.close-popup:hover,
						.close-popup:focus {
							color: black;
							text-decoration: none;
							cursor: pointer;
						}
            #popup_edition {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
}

.popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    width: 400px;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}
.col-md-12{
  width: 1650px;
}
.content-wrapper{
  width: 1650px;
}

    </style>   
    
<?php endif; ?>