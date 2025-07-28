
<?php //var_dump($local); die(); ?>
<style>
             body{
            background-color: white! important;
            color: black;
          
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
            background-color: #4EA5FC;
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
            background-color: #4EA5FC;
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
  
<div class="row">
    <div class="col-md-12" style="text-align: right">
    <h6 
    onclick="confirmerPrevisualisation(<?= $client[0]['idclients'] ?>)" 
    style="font-size: 16px; font-weight: 500;width: 200px; height: 41px;margin-top: 8px;  margin-left: 10px; background-color: #4EA5FE; color: white; border-radius: 20px; cursor: pointer;" 
    class="btn">
    Valider votre annonce
</h6>

<script>
function confirmerPrevisualisation(clientId) {
    // Fenêtre de confirmation personnalisée
    if (confirm("Avant de valider votre annonce, vous devrez prévisualiser.\n\nAvez-vous bien prévisualisé ?")) {
        // Redirection si l'utilisateur confirme
        window.location.href = "<?= base_url('Googleads/gestion_extension/') ?>" + clientId;

    } else {
        // Sinon rien ne se passe
        // Optionnel: tu peux mettre un message ici
        console.log("Prévisualisation annulée.");
    }
}
</script>
</div>
</div>
<h3 style="font-size: 52px; text-align: center"><b><?php echo $current_user->first_name ?> , C’est parti pour la</br>création de l’annonce Local!!</h3></b> 
<?php foreach($campagnes as $D): ?>
    <h3 style="font-size: 20px;"></br>Campagne client : <a style="color: #37BC9B"> <?php echo $D['nom_campagne'] ?></a> </h3>
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
<div class="row">
    <div class="col-md-4" style="margin-top: 24px">
        <?php foreach($groupe as $index => $G): ?>
            <form action="<?php echo site_url('Googleads/Ajoutgroupelocal'); ?>" method="POST" enctype="multipart/form-data">
                <div id="annonce-groups">
                    <div class="annonce-group">
                        <input type="hidden" name="idgroupe_annonce" class="form-control" value="<?php echo $G['idgroupe_annonce']; ?>">
                        <input type="hidden" name="idcampagne" class="form-control" value="<?php echo $D['idcampagne']; ?>">
                        <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>">
                        <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagne']; ?>">
                        <label for="group-name">Nom du groupe :</label>
                        <input type="text" name="nom_groupe" class="form-control" value="<?php echo $G['nom_groupe'] ?>"><br>
                        <label for="url">URL :</label>
                        <input type="text" name="url" class="form-control" value="<?php echo $G['url_groupe_annonce'] ?>"><br>
                        <label for="keywords">Mot clé :</label>
                        <textarea name="mot_cle" class="form-control" rows="10" cols="50"><?php echo $G['mot_cle'] ?></textarea><br>
                       
                        <?php
    // Compter le nombre de titres non vides
    $filledCount = 0;
    for ($i = 1; $i <= 12; $i++) {
        if (!empty($D["titre$i"])) {
            $filledCount = $i;
        }
    }
?>

<?php for ($i = 1; $i <= $filledCount; $i++): ?>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <label for="titre">Titre <?= $i ?>:</label>
        <small class="char-counter" style="color: #888;">0/30</small>
    </div>
    <input type="text" name="titre<?= $i ?>" class="form-control titre-input" style="text-transform: capitalize;" maxlength="30" value="<?= htmlspecialchars($D["titre$i"]) ?>">
    <br>
<?php endfor; ?>

<!-- Zone pour les champs ajoutés dynamiquement -->
<div id="additional-fields"></div>

<!-- Bouton pour ajouter des champs -->
<a href="javascript:void(0);" id="add-field-btn" onclick="addField()" style="font-size: 16px; font-weight: 500;display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-left: 10px; width: 280px; height: 41px; background-color: #4EA5FC; color: white !important; border-radius: 20px; text-decoration: none;">
    Ajouter un titre avec gemini <img width="8%" style="margin-top: 0px; margin-left: 5px;" src="<?php echo base_url("assets/images/ico/geminib.png"); ?>" alt="WLB" title="WLB" />
</a>
<br><br>

<script>
    // Initialisation avec le nombre de champs déjà affichés depuis PHP
    let fieldCount = <?= $filledCount ?>;

    function updateCounters() {
        const inputs = document.querySelectorAll('.titre-input');
        inputs.forEach(input => {
            const counter = input.previousElementSibling.querySelector('.char-counter');

            function updateCounter() {
                counter.textContent = `${input.value.length}/30`;
            }

            input.removeEventListener('input', updateCounter); // pour éviter les doublons
            input.addEventListener('input', updateCounter);
            updateCounter(); // Initialiser immédiatement
        });
    }

    updateCounters(); // Appel initial

    function addField() {
        if (fieldCount < 12) {
            fieldCount++;
            const newField = document.createElement("div");
            newField.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label for="titre">Titre ${fieldCount}:</label>
                    <small class="char-counter" style="color: #888;">0/30</small>
                </div>
                <input type="text" name="titre${fieldCount}" class="form-control titre-input" style="text-transform: capitalize;" maxlength="30"><br>
            `;
            document.getElementById("additional-fields").appendChild(newField);
            updateCounters(); // Mettre à jour le compteur du nouveau champ
        }

        // Cacher le bouton si on atteint 12 champs
        if (fieldCount >= 12) {
            document.getElementById("add-field-btn").style.display = "none";
        }
    }

    // Cacher le bouton directement si on est déjà à 12 depuis le PHP
    if (fieldCount >= 12) {
        document.getElementById("add-field-btn").style.display = "none";
    }
</script>
                                              

<div style="display: flex; justify-content: space-between; align-items: center;">
    <label for="description">Description 1:</label>
    <small class="desc-counter" style="color: #888;">0/90</small>
</div>
<textarea name="description1" class="form-control description-textarea" maxlength="90"><?php echo htmlspecialchars($G['descriptions1'] ?? '') ?></textarea>
<br>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <label for="description">Description 2:</label>
    <small class="desc-counter" style="color: #888;">0/90</small>
</div>
<textarea name="description2" class="form-control description-textarea" maxlength="90"><?php echo htmlspecialchars($G['descriptions2'] ?? '') ?></textarea>
<br>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <label for="description">Description 3:</label>
    <small class="desc-counter" style="color: #888;">0/90</small>
</div>
<textarea name="description3" class="form-control description-textarea" maxlength="90"><?php echo htmlspecialchars($G['descriptions3'] ?? '') ?></textarea>
<br>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <label for="description">Description 4:</label>
    <small class="desc-counter" style="color: #888;">0/90</small>
</div>
<textarea name="description4" class="form-control description-textarea" maxlength="90"><?php echo htmlspecialchars($G['descriptions4'] ?? '') ?></textarea>
<br>
<script>
    function updateDescriptionCounters() {
        const textareas = document.querySelectorAll('.description-textarea');
        textareas.forEach(textarea => {
            const counter = textarea.previousElementSibling.querySelector('.desc-counter');

            function updateCounter() {
                const max = textarea.getAttribute('maxlength');
                const current = textarea.value.length;
                counter.textContent = max ? `${current}/${max}` : `${current}`;
            }

            textarea.removeEventListener('input', updateCounter); // éviter les doublons
            textarea.addEventListener('input', updateCounter);
            updateCounter(); // initialiser
        });
    }

    updateDescriptionCounters();
</script>

                        <label for="description">Description brève:</label>
                        <textarea name="description_breve" class="form-control"><?php echo $G['description_breve'] ?></textarea><br>
                       
                    </div> <!-- Fermeture de annonce-group -->
                </div> <!-- Fermeture de annonce-groups -->
           
        <?php endforeach; ?> <!-- Fermeture de foreach pour $groupe -->
    </div> <!-- Fermeture de col-md-4 -->

    <div class="col-md-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            width: 1400px;
        }

        /* Styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #e0e0e0;
            font-size: 14px;
        }

        /* Styling for headers */
        th {
            background-color: #4EA5FC;
            color: white;
            text-transform: none;
            letter-spacing: 1px;
        }

        /* Styling for the table rows */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Make sure long texts wrap correctly */
        td {
            word-wrap: break-word;
        }

        /* Styling for the row that spans multiple cells */
        .row-span {
            background-color: #f1f8ff;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }
        }

        /* Logo container */
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

        /* Styling for the header text */
        .header {
            font-weight: bold;
            color: #333;
            font-size: 18px;
            width: 35%;
        }

        /* Styling for specific table cells */
        .blue-cell {
            background-color: #4EA5FC;
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

        /* Export button style */
        .export-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #4EA5FC;
            color: white;
            border: none;
            cursor: pointer;
        }
 

/* Style des images */
.image-card img {
    width: 100%;              /* L'image occupe 100% de la largeur du conteneur */
    max-width: 350px;         /* Limiter la largeur à 350px pour un affichage harmonieux */
    height: 200px;            /* Fixer la hauteur à 200px pour un ratio constant */
    object-fit: cover;        /* Garder un bon ratio d'aspect sans déformation */
    border-radius: 8px;       /* Coins arrondis pour une apparence douce */
    display: block;           /* Enlever les espaces indésirables autour de l'image */
    margin: 0 auto;           /* Centrer l'image horizontalement */
}
/* Style général du bouton */
.btn-success {
    background-color: #28a745; /* Couleur verte */
    color: white; /* Texte en blanc */
    padding: 10px 20px; /* Espacement interne */
    border-radius: 5px; /* Coins arrondis */
    border: none; /* Pas de bordure */
    font-size: 16px; /* Taille de police */
    cursor: pointer; /* Curseur de souris en forme de main */
    text-align: center; /* Centrer le texte */
    display: inline-flex;
    align-items: center; /* Aligner les éléments à l'intérieur */
    justify-content: center;
}

/* Ajout d'un effet au survol */
.btn-success:hover {
    background-color: #218838; /* Changer de couleur au survol */
    text-decoration: none; /* Enlever soulignement */
}

/* Ajouter un léger ombrage pour un effet de profondeur */
.btn-success:active {
    background-color: #1e7e34; /* Assombrir un peu le bouton lorsqu'il est cliqué */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
}

/* Assurer une taille minimale pour le bouton */
h6.btn-success {
    margin-bottom: 0; /* Enlever le margin par défaut */
}

    </style>
    <!-- Inclure la bibliothèque html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
<div id="exportable-content" style="margin-top: 25px;">
<label for="group-name">Preview</label>
        <div class="logo-container">
            <div style="flex: 1; padding-right: 20px;">
                <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
            </div>
            <div style="flex: 1; text-align: right;">
                <h1><b>Annonce</b></h1>
            </div>
        </div> 
        
    <?php   foreach($local as $G): ?>
        
        
        <div id="exportable-content"> 
       

        <table class="group-table" id="exportable-table-<?php echo $G['nom_groupe']; ?>" style="page-break-before: always;">
            <tr>
                <td class="blue-cell">Campagne  </td>
                <td class="header" style="text-align: center;"><?php echo $G['nom_campagne']; ?></td>
            </tr>
            <tr>
                <td class="blue-cell">Groupe d'annonces</td>
                <td class="header" style="text-align: center;"><?php echo $G['nom_groupe']; ?></td>
            </tr>
            <tr>
                <td class="blue-cell">Titres</td>
                <td style="text-align: center;">
                    <?php echo implode('<br>', array_filter([$G['titre1'], $G['titre2'], $G['titre3'], $G['titre4'], $G['titre5'], $G['titre6'], $G['titre7'], $G['titre8'], $G['titre9'], $G['titre10'], $G['titre11'], $G['titre12']])); ?>
                </td>
            </tr>
            <tr>
                <td class="blue-cell">Descriptions</td>
                <td style="text-align: center;">
                    <?php echo implode('<br>', array_filter([$G['descriptions1'], $G['descriptions2'], $G['descriptions3'], $G['descriptions4']])); ?>
                </td>
            </tr>
            <?php if ($G['type_campagnes'] == 3): ?>
                <tr>
                    <td class="blue-cell">Déscription brève</td>
                    <td style="text-align: center;">
                    <?php echo $G['description_breve']; ?>
                       
                    </td>
                </tr>
            <?php endif; ?>
            
            <?php if ($G['type_campagnes'] == 2): ?>
                <tr>
                    <td class="blue-cell">Déscription brève</td>
                    <td style="text-align: center;">
                    <?php echo $G['description_breve']; ?>
                       
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 1): ?>
            <tr>
                <td class="blue-cell">Chemin 1</td>
                <td style="text-align: center;">
                <?php echo $G['chemin1']; ?>
                </td>
            </tr>
            <tr>
                <td class="blue-cell">Chemin 2</td>
                <td style="text-align: center;">
                <?php echo $G['chemin2']; ?>
                </td>
            </tr>
            <?php endif; ?>   
            <tr>
                <td class="blue-cell">URL</td>
                <td style="text-align: center;">
                    <a href="<?php echo $G['url_groupe_annonce']; ?>" target="_blank"><?php echo $G['url_groupe_annonce']; ?></a>
                </td>
            </tr>
            <?php if ($G['type_campagnes'] == 20): ?>
                <tr>
                    <td class="blue-cell">Logo</td>
                    <td style="text-align: center;">
                    <?php if($G['logo_client'] !=NULL):  ?>
            <img id="logoImage" class="media-object" src="<?php echo base_url($G['logo_client']); ?>"
                        title="<?php echo $G['logo_client']; ?>" style="width: 100px; height: auto; display: inline-block;" />
            <?php endif; ?>    

                </tr>

            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 2): ?>
                <tr>
                    <td class="blue-cell">Images</td>
                    <td>
                    <?php $counter = 0; ?>
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $image): ?>

                            <!-- Ouvrir une nouvelle ligne toutes les 5 images -->
                            <?php if ($counter % 5 == 0): ?>
                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px; margin-left: 20px;">
                            <?php endif; ?>

                            <div class="col-md-2" id="image-<?= $image->id ?>" data-id="<?= $image->id ?>" style="padding: 0;">
                                <div class="image-card" style="display: flex; justify-content: center;">
                                    <?php if (strpos($image->image_url, 'http') === 0): ?>
                                        <img src="<?= $image->image_url ?>" alt="Image" style="width: 130px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                    <?php else: ?>
                                        <img src="<?= base_url($image->image_url) ?>" alt="Image" style="width: 130px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php $counter++; ?>

                            <!-- Fermer la ligne après chaque 5 images OU à la fin du tableau -->
                            <?php if ($counter % 5 == 0 || $counter === count($images)): ?>
                                </div> <!-- Fin de .row -->
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 15px; text-align: center;">Aucune image disponible</div>
                    <?php endif; ?>



                    </td>
                </tr>
            <?php endif; ?>
        </table>
       
                <button type="submit" class="btn btn-success" style="font-size: 16px; font-weight: 500;width: 180px; height: 41px; margin-left: 10px; background-color: #4EA5FC; color: white !important; border-radius: 20px;">Prévisualiser</button>
                </form>   
                <?php echo anchor("Googleads/gestion_image/".$local[0]['idgroupe_annonce'], '<h6 style="font-size: 16px; font-weight: 500;margin-top: 5px;margin-left: 10px; width: 180px; height: 41px; background-color: #4EA5FE;color: white;  border-radius: 20px;"  class="btn" >Ajouter les images</h6><i class="button"></i>', 'data-edit="'.$local[0]['idgroupe_annonce'].'"'); ?>



                <div class="row" style="margin-top: 50px;">
            <div class="col-md-3" >
            <span style="margin-bottom; 20px;"><b>Logo</b></span>
            <div style="margin-left: 0px;border: 1px solid #949cab; display: flex; justify-content: center; align-items: center; height: 150px; width:150px;"> 
            <?php if($G['logo_client'] ==NULL):  ?>
            <img id="logoImage" class="media-object" src="<?php echo base_url($client[0]['logo_client']); ?>"
                        title="<?php echo $G['logo_client']; ?>" style="width: 100px; height: auto; display: inline-block;" />
            <?php endif; ?>   
            <?php if($G['logo_client'] !=NULL):  ?>
            <img id="logoImage" class="media-object" src="<?php echo base_url($G['logo_client']); ?>"
                        title="<?php echo $G['logo_client']; ?>" style="width: 100px; height: auto; display: inline-block;" />
            <?php endif; ?>        
                    <!-- Formulaire d'upload caché -->
                    <form id="uploadForm" action="<?php echo base_url('Googleads/upload_logo_local'); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <input type="hidden" name="idclients" value="<?php echo $G['idclients']; ?>" />
                    <input type="hidden" name="idgroupe_annonce" value="<?php echo $G['idgroupe_annonce']; ?>" />

                        <input type="file" name="logos" id="logoInput" accept="image/*" />
                        <button type="submit">Uploader</button>
                    </form>
                </td>

                <script>
                    document.getElementById('logoImage').onclick = function() {
                        document.getElementById('logoInput').click();  // Ouvrir le sélecteur de fichier
                    };

                    document.getElementById('logoInput').onchange = function() {
                        document.getElementById('uploadForm').submit(); // Soumettre le formulaire une fois un fichier sélectionné
                    };
                </script>
                    </div>
                </div>
                
                
                </div>             
            </div>
        <?php endforeach; ?>   
    </div> <!-- Fermeture de col-md-8 -->
</div> <!-- Fermeture de row -->
<?php endforeach; ?>     
</div>                            
</div>