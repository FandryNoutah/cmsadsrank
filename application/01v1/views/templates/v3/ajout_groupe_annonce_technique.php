<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec popup</title>
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
</head>
<body>

<h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Ajout Groupe d'annonces - Technique </h4>   
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


<?php foreach($groupe as $D): ?>
							<h3></br>Campagne client : <a style="color: #37BC9B"> <?php echo $D['nom_groupe'] ?></a> </h3>

                            <?php endforeach; ?>
                            <table id="campaign-table">
    <thead>
        <tr>
            <th>Nom de campagne</th>
            <th style="width: 350px">Information campagne</th>
            <th style="width: 350px">Contexte groupe annonce</th>
            <th>Zone</th>
            <th>Objectif campagne</th>
            <th>URL</th>
            <th>Calendrier</th>
            <th>Appareils</th>
            <th>Budget</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach($campagnes as $D): ?>
            <tr>
                    <td >
                        <?php echo $D['nom_campagne']; ?>
                    </td>
                    <td ><?php echo $D['information_campagne']; ?></td>
                    <td ><?php echo $D['contexte_groupes_annonces']; ?></td>
                    
                    <td ><?php echo $D['zones']; ?></td>
                    <td ><?php echo $D['objectif']; ?></td>
                    <td ><?php echo $D['url_site']; ?></td>
                    <td ><?php echo $D['date_campagne']; ?></td>
                    <td ><?php echo $D['appareil']; ?></td>
                    <td ><?php echo $D['repartition_budget']; ?> €</td>
               
            </tr> <!-- Fermer la ligne ici pour chaque campagne -->
        <?php endforeach; ?>
    </tbody>
</table>

							<form action="<?php echo site_url('Googleads/Ajoutgroupes'); ?>" method="POST" enctype="multipart/form-data">
                                    <div id="annonce-groups">
                                        <div class="annonce-group">
                                        <input type="hidden" name="idgroupe_annonce" class="form-control" value="<?php echo $D['idgroupe_annonce']; ?>" > <br>
                                        <input type="hidden" name="idcampagne" class="form-control" value="<?php echo $D['idcampagne']; ?>" > <br>
                                        <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>" > <br>
                                        <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagnes']; ?>" > <br>
                                            <label for="group-name">Nom du groupe :</label>
                                            <input type="text" name="nom_groupe" class="form-control" value="<?php echo $D['nom_groupe'] ?>" ><br>

                                            
                                        <label for="titre">Titre 1:</label>
                                        <textarea name="titre1" class="form-control" ><?php echo $D['titre1']; ?></textarea><br>
                                        <label for="titre">Titre 2:</label>
                                        <textarea name="titre2" class="form-control" ><?php echo $D['titre2']; ?></textarea><br>
                                        <label for="titre">Titre 3:</label>
                                        <textarea name="titre3" class="form-control" ><?php echo $D['titre3']; ?></textarea><br>
                                        <label for="titre">Titre 4:</label>
                                        <textarea name="titre4" class="form-control" ><?php echo $D['titre4']; ?></textarea><br>
                                        <label for="titre">Titre 5:</label>
                                        <textarea name="titre5" class="form-control" ><?php echo $D['titre5']; ?></textarea><br>
                                        <label for="titre">Titre 6:</label>
                                        <textarea name="titre6" class="form-control" ><?php echo $D['titre6']; ?></textarea><br>
                                        <label for="titre">Titre 7:</label>
                                        <textarea name="titre7" class="form-control" ><?php echo $D['titre7']; ?></textarea><br>
                                        <label for="titre">Titre 8:</label>
                                        <textarea name="titre8" class="form-control" ><?php echo $D['titre8']; ?></textarea><br>
                                        <label for="titre">Titre 9:</label>
                                        <textarea name="titre9" class="form-control" ><?php echo $D['titre9']; ?></textarea><br>
                                        <label for="titre">Titre 10:</label>
                                        <textarea name="titre10" class="form-control" ><?php echo $D['titre10']; ?></textarea><br>
                                        <label for="titre">Titre 11:</label>
                                        <textarea name="titre11" class="form-control" ><?php echo $D['titre11']; ?></textarea><br>
                                        <label for="titre">Titre 12:</label>
                                        <textarea name="titre12" class="form-control" ><?php echo $D['titre12']; ?></textarea><br>



                                        <label for="description">Description 1:</label>
                                                <textarea name="description1" class="form-control" ><?php echo $D['descriptions1']; ?></textarea><br>

                                                <label for="description">Description 2:</label>
                                                <textarea name="description2" class="form-control" ><?php echo $D['descriptions2']; ?></textarea><br>

                                                <label for="description">Description 3:</label>
                                                <textarea name="description3" class="form-control" ><?php echo $D['descriptions3']; ?></textarea><br>

                                                <label for="description">Description 4:</label>
                                                <textarea name="description4" class="form-control" ><?php echo $D['descriptions4']; ?></textarea><br>

                                                <label for="path">Chemin 1 :</label>
                                                <input type="text" name="chemin1" class="form-control" value="<?php echo $D['chemin1']; ?>"><br>

                                                <label for="path">Chemin 2 :</label>
                                                <input type="text" name="chemin2" class="form-control" value="<?php echo $D['chemin2']; ?>"><br>

                                                <label for="url">URL :</label>
                                                <input type="text" name="url" class="form-control" value="<?php echo $D['url_groupe_annonce']; ?>" ><br>

                                                <label for="keywords">Mot clé :</label>
                                                <textarea name="mot_cle" class="form-control" rows="10" cols="50"><?php echo $D['mot_cle']; ?></textarea><br>



											<button type="submit" class="btn btn-success">Ajouter</button>
											</form>
                                            