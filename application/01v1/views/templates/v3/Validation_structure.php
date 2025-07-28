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
                    <?php
                       
                        $countG = count($D['groupes_annonces']); ?>
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
                <td class="blue-cell">Campagne
                    <?php if($G['type_campagnes'] == 1):?>
                    <?php echo anchor(
                    "Validation/editgroupesearch/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?>
                <?php endif; ?>
                <?php if($G['type_campagnes'] == 2):?>
                    <?php echo anchor(
                    "Validation/editgroupelocal/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?>
                <?php endif; ?>   
                <?php if($G['type_campagnes'] == 3):?>
                    <?php echo anchor(
                    "Validation/editgroupepmax/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?>
                <?php endif; ?>       
            
            </td>
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
                <td class="blue-cell">Images  <?php echo anchor(
                    "Validation/gestion_image/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?></td>
                    <td>
                    <?php $counter = 0; ?>
                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Ajout de l'écart entre les images -->
                        <?php foreach ($images as $image): ?>
                            <?php if ($image->type_campagnes == 3): ?> <!-- Vérifier si type_campagnes == 2 -->
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
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- Fermeture de la dernière ligne si nécessaire -->
                        <?php if ($counter % 6 != 0): ?>
                            </div> <!-- Fermeture de la ligne finale -->
                        <?php endif; ?>
                    </div>
                </tr>
            <?php endif; ?>
            <?php if ($G['type_campagnes'] == 2): ?>
                <tr>
                <td class="blue-cell">Images  <?php echo anchor(
                    "Validation/gestion_image/".$G['idgroupe_annonce'], 
                    '<i class="fas fa-edit" style="text-align: right;"></i>', 
                    'data-edit="'.$G['idgroupe_annonce'].'"'
                ); ?></td>
                    <td >
                                            <?php $counter = 0; ?>
                        <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Ajout de l'écart entre les images -->
                            <?php foreach ($images as $image): ?>
                                <?php if ($image->type_campagnes == 2): ?> <!-- Vérifier si type_campagnes == 2 -->
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

<div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH.'/logo/logo3.png'); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Extensions</h1>
        </div>
    </div>

    <?php if($extensions != NULL): ?>
    <table id="campaign-table">
    <thead>
        <tr>
            <th></th>
            <th>Extensions de liens annexes</th>
            <th>Extensions d'accroche</th>
            <th>Extensions d'extraits de site</th>
            <th>Extension de lieu</th>
            <th>Extension d'appel</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $countG = count($extensions); 
        $i = 0; // Initialize $i to 0
        foreach($extensions as $E): ?>
            <tr> <td> <?php //echo anchor("Googleads/editextensions/".$E['idextensions'], '<i class="fas fa-edit"></i>','data-edit="'.$E['idextensions'].'"'); ?>
                        <?php //echo anchor("Googleads/deleteextension/".$E['idextensions'], '<i class="fas fa-trash"></i>', 'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette extension ?\');" data-edit="'.$E['idextensions'].'"'); ?>
                        </td>   
                <td>
                    <b><?php echo $E['titre_extensions']; ?></b><br /><br />
                    <?php echo $E['description_extensions']; ?><br /><br />
                    <a style="color: blue"><?php echo $E['url_extensions']; ?></a>
                </td>
                <?php if ($i === 0): ?> 
                    <td rowspan="<?php echo $countG; ?>"><?php echo $E['extensions_accroche']; ?></td>
                    <td rowspan="<?php echo $countG; ?>"><?php echo $E['extensions_extrait_site']; ?></td>
                    <td rowspan="<?php echo $countG; ?>"><?php echo $E['extensions_lieu']; ?></td>
                    <td rowspan="<?php echo $countG; ?>"><?php echo $E['extensions_appel']; ?></td>
                <?php endif; ?> 
            </tr>
        <?php 
            $i++; 
        endforeach; 
        ?>
    </tbody>
</table>
<?php endif;  ?>
    </br></br>

<div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH.'/logo/logo3.png'); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Mots Clés à exclure</h1>
        </div>
    </div>

    <table id="campaign-table">
    <thead>
        <tr>
            <!-- Utilise colspan="2" pour que le titre prenne la largeur de deux colonnes -->
            <th colspan="2" style="text-align: center">Liste</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($donne_valider as $D): ?>
            <?php
            // Récupère le contenu brut de l'exclusion
            $exclusion = htmlspecialchars($D['exclusion']);
            
            // Compte le nombre de sauts de ligne (\n) dans le texte
            $lines = explode("\n", $exclusion);
            $lineCount = count($lines);
            
            // Si le nombre de lignes dépasse 21, divise en deux
            if ($lineCount > 21) {
                $firstPart = implode("\n", array_slice($lines, 0, 21));  // Prend les 21 premières lignes
                $secondPart = implode("\n", array_slice($lines, 21));    // Prend le reste des lignes
            } else {
                $firstPart = $exclusion;
                $secondPart = '';
            }
            ?>
            <tr>
                <td style="text-align: center"><?php echo nl2br($firstPart); ?></td>
                <?php if (!empty($secondPart)): ?>
                    <td style="text-align: center"><?php echo nl2br($secondPart); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>          
    </tbody>
</table>
<?php $F = $donne_valider[0]['idclients'];
    $F = intval($F);
?>
<?php echo anchor("Googleads/save_campagne_clients/".$F, 
    '<h6 class="btn btn-secondary mr-1" style="background-color: #bcf4db; color: #052740; padding-top: 15px; padding-bottom: 15px; padding-right: 20px; padding-left: 20px; border-radius: 15px; font-size: 16px; margin-left: 15px; font-family: \'Product Sans\', sans-serif; border: none;"> <i  ></i>  &nbsp;&nbsp;&nbsp;Valider la campagne</h6>', 
    'data-edit="'.$F.'"'); ?>
</body>
</html>
