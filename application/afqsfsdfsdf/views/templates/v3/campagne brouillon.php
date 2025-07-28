<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec popup</title>
    <style>
        /* Style pour la fenêtre popup */
/* Style pour la popup */
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
            background-color: #007bff;
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
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #5186f6;
            color: white;
            text-align: left;
        }
        td {
            background-color: #F4F8FB;
        }
        .header {
            font-weight: bold;
            color: #333;
            font-size: 18px;
            width: 35%;
        }
        .blue-cell {
            background-color: #4285f4;
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
    <h1>Brief <?php echo $client[0]['nom_client']; ?></label></h1></br>
    <div class="row">
    <div class="col-md-8">
        <?php foreach($donnees as $D): ?> 
            <?php if($current_user->tech == 0 || $current_user->tech == 3): ?>  
    <button id="openPopupButton" style=" height: 41px; background-color: #4EA5FE; color: #052740;color: white;  border-radius: 20px;"> <i class="fas fa-eye" ></i> Information client</button>
   <?php echo anchor("Googleads/ajoutCampagne/".$D['idonnee'], 
    '<h6 class="btn btn-secondary mr-1" style=" width: 180px; height: 41px; background-color: #4EA5FE; color: #052740;color: white;  border-radius: 20px;"> <i class="fas fa-plus" ></i>  &nbsp;&nbsp;&nbsp;Ajout campagne</h6>', 
    'data-edit="'.$D['idonnee'].'"'); ?>
     <?php echo anchor("Googleads/save_campagne/".$D['idonnee'], 
    '<h6 class="btn btn-secondary mr-1" style="width: 180px; height: 41px; background-color: #29A07B; color: #052740;color: white;  border-radius: 20px;"> <i  ></i>  &nbsp;&nbsp;&nbsp;Envoyer technique</h6>', 
    'data-edit="'.$D['idonnee'].'"'); ?>
    <?php endif; ?>
    <?php if($current_user->tech == 1 || $current_user->tech == 3): ?> 
     <?php echo anchor("Googleads/save_annonce_technique/".$D['idclients'], 
    '<h6 class="btn btn-secondary mr-1" style="width: 180px; height: 41px; background-color: #29A07B; color: #052740;color: white;  border-radius: 20px;"> <i  ></i>  &nbsp;&nbsp;&nbsp;Publié technique</h6>', 
    'data-edit="'.$D['idonnee'].'"'); ?>

    <?php echo anchor("Googleads/vision_globale/".$D['idclients'], 
    '<h6 class="btn btn-secondary mr-1" style=" width: 180px; height: 41px; background-color: #4EA5FE; color: #052740;color: white;  border-radius: 20px;">  <i class="fas fa-eye" ></i>  &nbsp;&nbsp;&nbsp;Vision global</h6>', 
    'data-edit="'.$D['idclients'].'"'); ?>
    <?php endif; ?>



    <?php endforeach; ?>
    </div> 
  
    
    <!-- Column 2: Client Information -->
    <div class="col-md-3">
    <?php foreach($donnees as $D): ?>
            <!-- Display Campaign Status -->
            <p><?php if($D['campagne_actif'] == 0): ?>
                    Statut brief : <a style="color: orange"> Brouillon</a>
                <?php elseif($D['campagne_actif'] == 1): ?>
                    Statut brief: <a style="color: #37BC9B"> Actif</a>
                <?php endif; ?> &ensp;&ensp;&ensp;&ensp;&ensp;
                <?php if($D['validation_technique'] == "0000-00-00"): ?>
                    Envoye structure : <a style="color: orange"> En cours</a>
                <?php elseif($D['validation_technique'] != "0000-00-00"): ?>
                    Envoye structure : <a style="color: #37BC9B"> Publier</a></p>
                <?php endif; ?>
            
            <!-- Action Buttons -->
            <?php //echo anchor("Googleads/ajoutCampagne/".$D['idonnee'], '<h6 class="btn btn-secondary mr-1" style="background-color: #c3e7fd; color: #052740" >Ajout campagne</h6>', 'data-edit="'.$D['idonnee'].'"'); ?>
           <?php if($D['campagne_actif'] == 1): ?>
    <?php //echo anchor("Googleads/save_brouillon/".$D['idonnee'], '<h6 class="btn btn-secondary mr-2" style="font-family: \'Product Sans\', sans-serif;">Brouillon</h6><i class="button"></i>', 'data-edit="'.$D['idonnee'].'"'); ?>
<?php endif; ?>

<?php if($D['campagne_actif'] == 0): ?>
    <?php //echo anchor("Googleads/save_campagne/".$D['idonnee'], 
       // '<h6 class="btn btn-success mr-3" style="background-color: #c3e7fd; color: #052740; font-family: \'Product Sans\', sans-serif;">Publié</h6><i class="button"></i>', 
       // 'data-edit="'.$D['idonnee'].'"'); ?>
<?php endif; ?>

<?php //if($D['validation_technique'] == "0000-00-00"): ?>
    <?php //echo anchor("Googleads/save_annonce_technique/".$D['idclients'], 
        //'<h6 class="btn btn-success mr-3" style="background-color: #c3e7fd; color: #052740; font-family: \'Product Sans\', sans-serif;">Publié technique</h6><i class="button"></i>', 'data-edit="'.$D['idonnee'].'"'); ?>
<?php // endif; ?>

<?php //echo anchor("Googleads/vision_globale/".$D['idclients'], 
   // '<h6 class="btn btn-secondary mr-2" style="background-color: #c3e7fd; color: #052740; font-family: \'Product Sans\', sans-serif;">Vision global</h6><i class="button"></i>', 
    //'data-edit="'.$D['idclients'].'" target="_blank"'); ?>

            <?php //echo anchor("Googleads/save_brouillon_annonce/".$C['idcampagne'], '<h6 class="btn btn-secondary mr-2">Brouillon</h6><i class="button"></i>', 'data-edit="'.$C['idcampagne'].'"'); ?>
 <?php endforeach; ?>
        
    </div>
</div>
   

    <!-- Fond sombre -->
    <div class="popup-overlay" id="popupOverlay"></div>

    <!-- Fenêtre popup -->
    <div class="popup" id="popup">
    <h2><strong>Information client</strong></h2>
    <div class="popup-content2">
        <div class="row">
            <div class="col-md-6">
                <?php foreach($donnees as $D): ?>
                    <?php foreach($client as $C): ?>
                        <input class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
                        <input class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
                        
                        <div class="form-group">
                            <label for="fname"><strong>Client :</strong> <?php echo $C['nom_client']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Logo client :</strong></label>
                            <a href="<?php echo ($C['logo_client'] != "") ? base_url($C['logo_client']) : "#"; ?>">
                                <img class="media-object" src="<?php echo base_url($C['logo_client']); ?>" 
                                     title="<?php echo $C['logo_client']; ?>" alt="<?php echo $C['logo_client']; ?>" 
                                     style="width: 50px;height: 50px;" />
                            </a>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>URL du site :</strong> <?php echo $C['site_client']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Secteur d'activité :</strong> <?php echo $D['secteur_activite']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Budget Total :</strong> <?php echo $D['budget']; ?> €</label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Information client :</strong> <?php echo nl2br($D['information_client']); ?></label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Contexte client :</strong> <?php echo $D['contexte_client']; ?></label>
                        </div>
                    </div>
                    <div class="col-md-67">
                        <div class="form-group">
                            <label for="fname"><strong>Tracking GTM :</strong> <?php echo $D['tracking_gtm']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Information complémentaire :</strong> <?php echo $D['information_complementaire']; ?></label>
                        </div>
                        <div class="form-group">
                            <label for="fname"><strong>Plan de taggage :</strong> <?php echo $D['commentaire']; ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?> 
            </div>
        </div>
    </div>
</div>



    <script>
        // Récupérer les éléments du DOM
      // Récupérer les éléments du DOM
const openPopupButton = document.getElementById('openPopupButton');
const popup = document.getElementById('popup');
const popupOverlay = document.getElementById('popupOverlay');

// Ouvrir la popup lorsque le bouton est cliqué
openPopupButton.onclick = function() {
    popup.style.display = 'block';
    popupOverlay.style.display = 'block';
};

// Fermer la popup si on clique en dehors de la fenêtre popup
popupOverlay.onclick = function() {
    popup.style.display = 'none';
    popupOverlay.style.display = 'none';
};

    </script>
    <div class="row" style="margin-top: 25px;">
    
        <h4 class="card-title" id="basic-layout-colored-form-control">Stratégie de campagne:  </br>
        <?php $nbrcampagne = count($campagne); $nbrgroupe = count($nbrgroupe);  ?>
        
       <?php echo $nbrcampagne ?> campagnes    |  <?php echo $nbrgroupe ?> groupes d'annonces   | 
                     <?php foreach($donnees as $D){ ?>
                       <?php echo $D['budget']; ?> € de budget initiale |
                     <?php } ?> <?php echo $budgetutilisé ?> € de budget utilisé</h4>




                     <table id="campaign-table">
    <thead>
        <tr >
            <?php if($current_user->tech == 0 || $current_user->tech == 3): ?> 
            <th style="text-align: center;">AM</th>
            <?php endif; ?>
            <th style="text-align: center;">Campagne</th>
            <th style="width: 350px; text-align: center;" >Information campagne</th>
            <th  style="text-align: center;">Zone</th>
            <th style="text-align: center;">Objectif</th>
            <th style="text-align: center;">URL</th>
            <th style="text-align: center;">Calendrier</th>
            <th style="text-align: center;">Appareils</th>
            <th style="text-align: center;">Budget</th>
            <th style="text-align: center;">Campagne</th>
            <th style="text-align: center;">GA</th>
            <th style="text-align: center;">Contexte Groupe d'annonces</th>
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
                        <?php echo anchor("Googleads/editcampagne/".$D['idcampagne'], '<i class="fas fa-edit"></i>','data-edit="'.$D['idcampagne'].'"'); ?>
                        <?php echo anchor("Googleads/deletecampagne/".$D['idcampagne'], '<i class="fas fa-trash"></i>', 'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette campagne ?\');" data-edit="'.$D['idcampagne'].'"'); ?>
                       
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
                            $url = $C['site_client'];
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
                        <td style="text-align: center">
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
                            <?php echo anchor(
                                "Googleads/insertgroupeannonce/".$group['idgroupe_annonce'], 
                                '<i class="fas fa-edit"></i>', 
                                'data-edit="'.$group['idgroupe_annonce'].'"'
                            ); ?>
                            <?php echo anchor("Googleads/ajout_groupeannonce/".$D['idcampagne'], '<h6 class="fas fa-plus"></h6><i  class="button" ></i>','data-edit="'.$D['idcampagne'].'"') ;?>
                            
                            <?php endif; ?>
                            <?php if( $D['type_campagne']  == 2): ?>
                            <?php echo anchor(
                                "Googleads/ajout_groupeannonce_local/".$group['idgroupe_annonce'], 
                                '<i class="fas fa-edit"></i>', 
                                'data-edit="'.$group['idgroupe_annonce'].'"'
                            ); ?>
                            <?php //echo $group['idgroupe_annonce']; ?>
                            <?php endif; ?>
                            <?php if( $D['type_campagne']  == 3): ?>
                            <?php echo anchor(
                                "Googleads/ajout_groupeannonce_pmax/".$D['idcampagne'], 
                                '<i class="fas fa-edit"></i>', 
                                'data-edit="'.$D['idcampagne'].'"'
                            ); ?>
                             <?php //echo $group['idgroupe_annonce']; ?>
                            <?php endif; ?>
                            <?php echo anchor(
                                "Googleads/deletegroupeannonce/".$group['idgroupe_annonce'], 
                                '<i class="fas fa-trash"></i>', 
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
                                '<i class="fas fa-plus-circle"></i>', 
                                'data-edit="'.$group['idgroupe_annonce'].'"'
                            ); ?><?php echo anchor("Googleads/validation_client/".$D['idcampagne'], 
                            '<h6 class="fas fa-eye"></h6><i class="button"></i>', 
                            'data-edit="'.$D['idcampagne'].'" target="_blank"'); ?>
                            <?php endif; ?>
                            <?php if( $D['type_campagne']  == 2): ?>
                            <?php echo anchor(
                                "Googleads/ajout_groupeannonce_local/".$group['idgroupe_annonce'], 
                                '<i class="fas fa-plus-circle"></i>', 
                                'data-edit="'.$group['idgroupe_annonce'].'"'
                            ); ?>
                            <?php echo anchor("Googleads/Visualiserlocal/".$group['idgroupe_annonce'], 
                            '<h6 class="fas fa-eye"></h6><i class="button"></i>', 
                            'data-edit="'.$group['idgroupe_annonce'].'" target="_blank"'); ?>
                            <?php endif; ?>
                            <?php if( $D['type_campagne']  == 3): ?>
                               
                            <?php echo anchor(
                                "Googleads/ajout_groupeannonce_pmax/".$D['idcampagne'], 
                                '<i class="fas fa-plus-circle"></i>', 
                                'data-edit="'.$D['idcampagne'].'"'
                            ); ?>
                            <?php // echo anchor("Googleads/gestion_extension_pmax/".$D['idclients'],  '<i class="fas fa-cogs"></i>', 'data-edit="'.$D['idclients'].'"'); ?>
                            <?php echo anchor("Googleads/Visualiserpmax/".$group['idgroupe_annonce'], 
                            '<h6 class="fas fa-eye"></h6><i class="button"></i>', 
                            'data-edit="'.$group['idgroupe_annonce'].'" target="_blank"'); ?>
                            <?php endif; ?>
                             <?php endif; ?>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Si aucun groupe d'annonces n'est disponible, affichez la campagne avec une ligne vide pour "Groupe d'annonces" -->
                   
                    <td>
                        <?php echo anchor(
                            "Googleads/deletecampagne/".$D['idcampagne'], 
                            '<i class="fas fa-trash"></i>', 
                            'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette campagne ?\');" data-edit="'.$D['idcampagne'].'"'
                        ); ?>
                        <?php echo $D['nom_campagne']; ?>
                    </td>
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
                    <td> <?php echo anchor("Googleads/ajout_groupeannonce/".$D['idcampagne'], '<h6 class="fas fa-plus"></h6><i  class="button" ></i>','data-edit="'.$D['idcampagne'].'"') ;?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
    </tbody>
</table>
<?php echo anchor("Googleads/gestion_extension/".$D['idclients'], '<h6 class="btn btn-secondary mr-2">Extension</h6><i class="button"></i>', 'data-edit="'.$D['idclients'].'"'); ?>


