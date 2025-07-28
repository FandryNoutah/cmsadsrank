
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonce Maison Beneva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 50%;
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
            background-color: #004A99;
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
    </style>
    <!-- Include html2pdf.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    <header>
        <h1>Google Ads</h1>
    </header>
    <main>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Technique</h4>
                    <style>
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
    </style>
</head>
<body>

    <h1>Campagne GoogleAds</h1>

    <button id="openPopupButton">Information client</button>

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
                    <?php foreach($campagne as $D): ?>
                        <?php echo anchor("Googleads/ajout_groupeannonce/".$D['idcampagne'], '<h6 class="btn btn-secondary mr-2">Ajout groupe annonce</h6><i class="button"></i>', 'data-edit="'.$D['idcampagne'].'"'); ?>
                        
                        <?php // if($search != NULL): foreach($search as $G): ?>  
                            <!-- <p></br>Campagne client : <a style="color: #37BC9B"> <?php echo $D['nom_campagne'] ?></a> </p> -->
                            
                            <?php // if($D['actif'] == 0): ?>
                                <?php // echo anchor("Googleads/save_annonce/".$G['idcampagne'], '<h6 class="btn btn-success mr-3">Publié</h6><i class="button"></i>', 'data-edit="'.$G['idgroupe_annonce'].'"'); ?>
                            <?php // endif; ?>
                            <?php // if($D['actif'] == 1): ?>
                                <?php // echo anchor("Googleads/save_brouillon_annonce/".$G['idcampagne'], '<h6 class="btn btn-secondary mr-2">Brouillon</h6><i class="button"></i>', 'data-edit="'.$G['idcampagne'].'"'); ?>
                            <?php  // endif; ?>
                        <?php // endforeach; endif;  
                    endforeach;?>
                    </div>
                </div>
            </div>

            <section>
                <h4 class="section-title">Informations campagne</h4>
                <table>
                    <tr>
                        <td>Client</td>
                        <td><?php echo $D['nom_campagne'] ?></td>
                    </tr>
                    <tr>
                        <td>URL du site</td>
                        <td><a href="<?php echo $D['url_site'] ?>" target="_blank"><?php echo $D['url_site'] ?></a></td>
                    </tr>
                    <tr>
                        <td>Budget Total</td>
                        <td><?php echo $D['repartition_budget'] ?> €</td>
                    </tr>
                </table>
            </section>

            <section>
                <h4 class="section-title">Groupe d'annonce</h4>
                <table border="1">
                <tr>
                    <th>Groupe annonce</th>
                    <th>Contexte groupe d'annonce</th>
                    <th>Mots clés</th>
                    <th>Action</th>
                </tr>
                <?php foreach($search as $S): ?>
                <tr>
                    <td><?php echo $S['nom_groupe'] ?> - Search</td>
                    <td><?php echo $S['contexte_groupes_annonces'] ?></td>
                    <td style="text-align: center"><?php  $motCles = explode("\n", $S['mot_cle']);

                    foreach ($motCles as $motCle) {
                       echo '"' . trim($motCle) . '"<br>';
                    } ?></td>
                    <td><?php echo anchor("Googleads/insertgroupeannonce/".$S['idgroupe_annonce'], '<h6 class="fas fa-plus"></h6><i  class="button" ></i>','data-edit="'.$S['idgroupe_annonce'].'"') ;?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            </section>

            
        </div>
    </main>

</body>
</html>
