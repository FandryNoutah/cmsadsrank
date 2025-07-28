<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fusionner</title>
    <link rel="stylesheet" href="https://portail.lyc-la-martiniere-diderot.ac-lyon.fr/srv1/html/cours_html_css_isn/exo_sup_isn/fichier_ci_dessous.css">
    <style>
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <h1>Campagne Google ADS</h1>

    <div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Campagne</h1>
        </div>
    </div>
   
    <!-- Table avec les détails de la campagne -->
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
            </tr>
        </thead>
        <tbody>
            <tr class="row-span">
             
                <td rowspan="3">Zone globale</td>
             
                <td rowspan="3">7J/7, entre 22H - 6H -60%</td>
                <td rowspan="3">Ordinateur, Smartphone, Tablette</td>
               
                <td><?php echo $all_campagne[0]['repartition_budget']; ?> €</td>
              
                <td><?php echo $all_campagne[0]['nom_campagne']; ?> </td>
                <td><?php echo $all_groupe[0]['nom_groupe']; ?></td>
                <td><?php echo $all_campagne[0]['Mots_cle_potentiels']; ?> </td>
            <tr>
            <td><?php echo $all_campagne[1]['repartition_budget']; ?> €</td>
            <td><?php echo $all_campagne[1]['nom_campagne']; ?> </td>
            <td><?php echo $all_groupe[1]['nom_groupe']; ?></td>
                <td><?php echo $all_campagne[1]['Mots_cle_potentiels']; ?> </td></tr>
            <tr>
                
        </tbody>
    </table>
    
    <!-- Section Groupes d'annonces -->
    <h1></br>Groupe Annonce</h1>
    <div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Annonce</h1>
        </div>
    </div>   
    <div id="exportable-content">
        <?php foreach($all_groupe as $G): ?>
            <table class="group-table" id="exportable-table-<?php echo $G['nom_groupe']; ?>">
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
                <tr>
                    <td class="blue-cell">Chemin 1</td>
                    <td style="text-align: center;"><?php echo $G['chemin1']; ?></td>
                </tr>
                <tr>
                    <td class="blue-cell">Chemin 2</td>
                    <td style="text-align: center;"><?php echo $G['chemin2']; ?></td>
                </tr>
                <tr>
                    <td class="blue-cell">URL</td>
                    <td style="text-align: center;"><a href="<?php echo $G['url_groupe_annonce']; ?>" target="_blank"><?php echo $G['url_groupe_annonce']; ?></a></td>
                </tr>
                <?php  if($G['type_campagnes'] == 3): ?>
                    <tr>
                    <td class="blue-cell">Images</td>
                    <td style="text-align: center;">
    <img class="media-object" src="<?php echo $G['image_youtube1']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_youtube2']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_gmail']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_display1']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_display2']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_discover1']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_discover2']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
    <img class="media-object" src="<?php echo $G['image_discover3']; ?>" 
         title="<?php echo $G['image_youtube1']; ?>"  
         style="width: 100px; height: 100px; display: inline-block;" />
</td>



                </tr>
                <?php endif; ?>
                <?php  if($G['type_campagnes'] == 3): ?>
                    <tr>
                    <td class="blue-cell">Inventaire</td>
                    <td style="text-align: center;"><?php  if($G['type_campagnes'] == 3):
												echo anchor(
													'Datastudio/datastudios/' . $G['idclients'], 
													'Inventaire', 
													['style' => 'color: black', 'data-edit' => $G['idclients'], 'target' => '_blank']
												); endif;
											?></td>
                </tr>
                <?php endif; ?>
                
            </table>
           
            </br></br>
        <?php endforeach; ?>
    </div>

    <!-- Bouton d'exportation PDF -->
   

    <script>
        document.getElementById('export-btn').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Ajouter la première page avec le tableau de campagne
            doc.text('Campagne Google ADS', 20, 20);
            doc.autoTable({ html: '#campaign-table' });

            // Ajouter les groupes d'annonces à la suite, chaque groupe sur une nouvelle page
            <?php foreach($all_groupe as $G): ?>
                doc.addPage();
                doc.text('Groupe Annonce: <?php echo $G['nom_groupe']; ?>', 20, 20);
                doc.autoTable({ html: '#exportable-table-<?php echo $G['nom_groupe']; ?>' });
            <?php endforeach; ?>

            // Générer et télécharger le PDF
            doc.save('export_campaign.pdf');
        });
    </script>
</body>
</html>
