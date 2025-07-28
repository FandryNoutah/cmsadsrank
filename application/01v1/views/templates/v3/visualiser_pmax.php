<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Validation client</title>
    <link rel="stylesheet" href="https://portail.lyc-la-martiniere-diderot.ac-lyon.fr/srv1/html/cours_html_css_isn/exo_sup_isn/fichier_ci_dessous.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
            background-color: #007BFF;
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

        /* Export button style */
        .export-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #004A99;
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
<div id="exportable-content">
    <h1>Campagne PMax</h1>   </br></br></br>
        <!-- Section Groupes d'annonces -->
        <h1>Groupe Annonce</h1>
        <div class="logo-container">
            <div style="flex: 1; padding-right: 20px;">
                <img src="<?php echo base_url(IMAGES_PATH.'/logo/logo3.png'); ?>" style="width: 200px;">
            </div>
            <div style="flex: 1; text-align: right;">
                <h1>Annonce</h1>
            </div>
        </div>  
        
    <?php   foreach($pmax as $G): ?>
        
        
        <div id="exportable-content"> 
       

        <table class="group-table" id="exportable-table-<?php echo $G['nom_groupe']; ?>" style="page-break-before: always;">
            <tr>
                <td class="blue-cell">Campagne  <?php echo anchor(
                    "Googleads/editgroupepmaxtech/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?></td>
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
            <?php if ($G['type_campagnes'] == 3): ?>
                <tr>
                    <td class="blue-cell">Logo</td>
                    <td style="text-align: center;">
                    <img id="logoImage" class="media-object" src="<?php echo base_url($G['logo_client']); ?>"
                        title="<?php echo $G['logo_client']; ?>" style="width: 100px; height: auto; display: inline-block;" />
                    
                    <!-- Formulaire d'upload caché -->
                    <form id="uploadForm" action="<?php echo base_url('Googleads/upload_logo'); ?>" method="post" enctype="multipart/form-data" style="display: none;">
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

                </tr>
             
            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 3): ?>
                <tr>
                    <td class="blue-cell">Images  <?php echo anchor(
                    "Googleads/gestion_image/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?></td>
                    <td>
                    <?php $counter = 0; ?>
                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Ajout de l'écart entre les images -->
                        <?php foreach ($images as $image): ?>
                            <div class="col-md-2" id="image-<?= $image->id ?>" data-id="<?= $image->id ?>" style="padding: 0;"> <!-- Enlève le padding par défaut -->
                                <div class="image-card" style="display: flex; justify-content: center;">
                                    <!-- Vérifier si l'image est locale ou externe -->
                                    <?php if (strpos($image->image_url, 'http') === 0): ?>
                                        <!-- Image externe -->
                                        <img src="<?= $image->image_url ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php else: ?>
                                        <!-- Image locale (dans le dossier 'uploads') -->
                                        <img src="<?= base_url($image->image_url) ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php $counter++; ?>

                            <!-- Commencer une nouvelle ligne après chaque 6 images -->
                            <?php if ($counter % 6 == 0): ?>
                                </div> <!-- Fermeture de la ligne précédente -->
                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Nouvelle ligne avec écart -->
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- Fermeture de la dernière ligne si nécessaire -->
                        <?php if ($counter % 6 != 0): ?>
                            </div> <!-- Fermeture de la ligne finale -->
                        <?php endif; ?>
                    </div>



                    </td>
                </tr>
            <?php endif; ?>
        </table>
            </br></br>
            <?php echo anchor("Googleads/campagne/".$G['idclients'], 
                    '<h6 class="btn btn-success mr-3">Enregistrer</h6><i class="button"></i>', 
                    'data-edit="'.$G['idclients'].'"'); ?>
    <?php endforeach; ?>
</div>

    </div>

    <!-- Bouton d'exportation PDF 
    <button class="export-btn" onclick="previewPDF()">Aperçu du PDF</button>
<button class="export-btn" onclick="exportPDF()">Télécharger PDF</button>-->


<script>
    function previewPDF() {
        const element = document.getElementById('exportable-content');
        
        const pdf = html2pdf()
            .from(element)
            .set({
                margin: 10,
                html2canvas: {
                    scale: 4, // Augmente la qualité de la capture des images
                    dpi: 300, // Augmente la résolution
                    logging: false,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    compress: true,
                    hotfixes: ['px_scaling'], // Garantir que tout soit mis à l'échelle correctement
                    // Saut de page après chaque groupe
                    orientation: 'portrait'
                }
            })
            .toPdf()
            .get('pdf'); // Récupère l'objet PDF

        pdf.then(function(pdfObj) {
            // Création de l'iframe pour afficher l'aperçu du PDF
            const iframe = document.createElement('iframe');
            iframe.style.width = '95%';  // 95% de la largeur de la fenêtre
            iframe.style.height = '95%'; // 95% de la hauteur de la fenêtre
            iframe.style.border = 'none'; // Retirer les bordures de l'iframe
            iframe.src = pdfObj.output('datauristring'); // Convertir en string URI pour l'aperçu

            // Création d'une couche d'overlay pour l'aperçu
            const previewDiv = document.createElement('div');
            previewDiv.style.position = 'fixed';
            previewDiv.style.top = '0';
            previewDiv.style.left = '0';
            previewDiv.style.width = '100%';
            previewDiv.style.height = '100%';
            previewDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.7)'; // Couleur de fond sombre
            previewDiv.style.zIndex = '1000';
            previewDiv.style.display = 'flex';
            previewDiv.style.alignItems = 'center';
            previewDiv.style.justifyContent = 'center';
            previewDiv.style.padding = '20px';

            // Bouton pour fermer l'aperçu
            const closeButton = document.createElement('button');
            closeButton.innerText = 'Fermer';
            closeButton.style.position = 'absolute';
            closeButton.style.top = '20px';
            closeButton.style.right = '20px';
            closeButton.style.padding = '10px 20px';
            closeButton.style.fontSize = '16px';
            closeButton.style.cursor = 'pointer';
            closeButton.style.backgroundColor = '#004A99'; // Couleur du bouton
            closeButton.style.color = 'white';
            closeButton.onclick = function() {
                document.body.removeChild(previewDiv); // Retirer l'overlay lorsque le bouton est cliqué
            };

            // Ajouter l'iframe et le bouton au div de prévisualisation
            previewDiv.appendChild(iframe);
            previewDiv.appendChild(closeButton);
            document.body.appendChild(previewDiv); // Ajouter le div à l'élément body pour l'afficher
        });
    }

    // Fonction pour télécharger le PDF après l'aperçu
    function exportPDF() {
        const element = document.getElementById('exportable-content');
        
        html2pdf()
            .from(element)
            .set({
                margin: 10,
                html2canvas: {
                    scale: 4, // Améliore la qualité de l'image capturée
                    dpi: 300, // Résolution plus élevée
                    logging: false,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    compress: true,
                    orientation: 'portrait', // Orientation portrait pour une mise en page standard
                    hotfixes: ['px_scaling'], // Garantir que tout soit mis à l'échelle correctement
                    // Option pour ajouter un saut de page après chaque groupe
                    pageBreaks: 'auto'
                }
            })
            .save('Campagne_Google_ADS.pdf'); // Enregistrer le fichier PDF généré
    }
</script>


</body>
</html>
