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
    </style>
    <!-- Inclure la bibliothèque html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
<div id="exportable-content">
    <h1>Campagne Google ADS</h1>
    <div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH.'/logo/logo3.png'); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Campagne</h1>
        </div>
    </div>

    <!-- Div englobant tout le contenu à exporter -->
 
        <!-- Tableau principal avec les informations de la campagne -->
        <table id="campaign-table">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Calendrier</th>
                    <th>Appareils</th>
                    <th>Budget</th>
                    <th>Campagne</th>
                    <th>Groupe d'annonces</th>
                    <th>Mots-clés</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php //var_dump($donne_valider); die();?>
                <?php foreach($donne_valider as $D): ?>
                    <?php $countG = count($D['groupes_annonces']); ?>
                    <?php for($i = 0; $i < $countG; $i++): ?>
                        <tr>
                            <?php if ($i == 0): ?>
                                <td rowspan="<?php echo $countG; ?>"><?php echo $D['zones']; ?></td>
                                <td rowspan="<?php echo $countG; ?>"><?php echo $D['date_campagne']; ?></td>
                                <td rowspan="<?php echo $countG; ?>"><?php echo $D['appareil']; ?></td>
                                <td rowspan="<?php echo $countG; ?>"><?php echo $D['repartition_budget']; ?> €</td>
                                <td rowspan="<?php echo $countG; ?>"><?php echo $D['nom_campagne']; ?></td>
                            <?php endif; ?>
                            <td><?php echo $D['groupes_annonces'][$i]['nom_groupe']; ?></td>
                            <td style="text-align: center">
                                <?php 
                                    $motCles = explode("\n", $D['groupes_annonces'][$i]['mot_cle']);
                                    foreach ($motCles as $motCle) {
                                        echo '"' . trim($motCle) . '"<br>';
                                    }
                                ?>
                            </td>
                            <td><?php echo anchor(
                                "Validation/editcampagne/".$D['idcampagne'], 
                                '<i class="fas fa-edit"></i>', 
                                'data-edit="'.$D['idcampagne'].'"'
                            ); ?>

                            </td>
                        </tr>
                    <?php endfor; ?>
                <?php endforeach; ?>          
            </tbody>
        </table>
        </br></br>
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
        
    <?php foreach($groupe_valider as $G): ?>
        
        
        <div id="exportable-content"> 
        <table class="group-table" id="exportable-table-<?php echo $G['nom_groupe']; ?>" style="page-break-before: always;">
            <tr>
                <td class="blue-cell">Campagne</td>
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
            <?php if ($G['type_campagnes'] == 5): ?>
                <tr>
                    <td class="blue-cell">Logo</td>
                    <td style="text-align: center;">
                    <img class="media-object" src="<?php var_dump($G['logo_client']); echo base_url($G['logo_client']); ?>"

                    title="<?php echo $G['logo_client']; ?>" style="width: 100px; height: 100px; display: inline-block;" />
                       
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 3): ?>
                <tr>
                    <td class="blue-cell">Images</td>
                    <td style="text-align: center;">
                        <img class="media-object" src="<?php echo $G['image_youtube1']; ?>" 
                             title="<?php echo $G['image_youtube1']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_youtube2']; ?>" 
                             title="<?php echo $G['image_youtube2']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_gmail']; ?>" 
                             title="<?php echo $G['image_gmail']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_display1']; ?>" 
                             title="<?php echo $G['image_display1']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_display2']; ?>" 
                             title="<?php echo $G['image_display2']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_discover1']; ?>" 
                             title="<?php echo $G['image_discover1']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_discover2']; ?>" 
                             title="<?php echo $G['image_discover2']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_discover3']; ?>" 
                             title="<?php echo $G['image_discover3']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                        <!-- Ajoutez plus d'images si nécessaire -->
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 2): ?>
                <tr>
                    <td class="blue-cell">Images</td>
                    <td style="text-align: center;">
                        <img class="media-object" src="<?php echo $G['image_youtube1']; ?>" 
                             title="<?php echo $G['image_youtube1']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_youtube2']; ?>" 
                             title="<?php echo $G['image_youtube2']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_gmail']; ?>" 
                             title="<?php echo $G['image_gmail']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_display1']; ?>" 
                             title="<?php echo $G['image_display1']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_display2']; ?>" 
                             title="<?php echo $G['image_display2']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_discover1']; ?>" 
                             title="<?php echo $G['image_discover1']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_discover2']; ?>" 
                             title="<?php echo $G['image_discover2']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                             <img class="media-object" src="<?php echo $G['image_discover3']; ?>" 
                             title="<?php echo $G['image_discover3']; ?>"  
                             style="width: 100px; height: 100px; display: inline-block;" />
                        <!-- Ajoutez plus d'images si nécessaire -->
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 3): ?>
                <tr>
                    <td class="blue-cell">Inventaire</td>
                    <td style="text-align: center;">
                    <?php echo anchor("Googleads/visualiser/".$G['idclients'], '<h6 class="fas fa-plus"></h6><i  class="button" >Inventaire</i>','data-edit="'.$G['idclients'].'"') ;?>
                
                       
                    </td>
                </tr>
            <?php endif; ?>
        </table>
            </br></br>
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
