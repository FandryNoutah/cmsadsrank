<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fusionner</title>
    <link rel="stylesheet" href="https://portail.lyc-la-martiniere-diderot.ac-lyon.fr/srv1/html/cours_html_css_isn/exo_sup_isn/fichier_ci_dessous.css">
    <style>
        /* Resetting some default styles */
        * {
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
</head>
<body>
    <!-- Title and Logo -->
    <h1>Campagne Google ADS</h1>

    <div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Campagne</h1>
        </div>
    </div>

    <!-- Table with campaign details -->
    <table>
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
                <td rowspan="3">Limas (Rayon de 100 km)</td>
                <td rowspan="3">7J/7, entre 22H - 6H -60%</td>
                <td rowspan="3">Ordinateur, Smartphone, Tablette</td>
                <td>800 €</td>
                <td>Maison Beneva - Search</td>
                <td>Façadier</td>
                <td>"façadier", "entreprise facade", "entreprise façadier", "entreprise isolation extérieure", "renovation facade", "ravalement de façade", "prix ravalement façade", "rénovation façade maison", "entreprise de ravalement de façade"</td>
            </tr>
            <tr>    
                <td>500 €</td>
                <td>Maison Beneva - Local</td>
                <td>Façadier - Local</td>
                <td>"Audience d'utilisateurs ayant l'un de ces centres d'intérêt ou l'une de ces intentions d'achat : entreprise de ravalement de façade, entreprise de façade, artisan façadier, façadier, entreprise façadier"</td>
            </tr>
            <tr>    
                <td>700 €</td>
                <td>Maison Beneva - Performance Max</td>
                <td>Façadier - Pmax</td>
                <td>"Audience d'utilisateurs ayant l'un de ces centres d'intérêt ou l'une de ces intentions d'achat : entreprise de ravalement de façade, entreprise de façade, artisan façadier, façadier, entreprise façadier"</td>
            </tr>
        </tbody>
    </table>

    <!-- Group Announcement Section -->
    <h1>Groupe Annonce</h1>

    <div id="exportable-content">
        <div class="logo-container">
            <div style="flex: 1; padding-right: 20px;">
                <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
            </div>
            <div style="flex: 1; text-align: right;">
                <h1>Annonce</h1>
            </div>
        </div>

        <!-- Loop through each group to display its content -->
        <?php foreach($all_groupe as $G): ?>
            <table id="exportable-table">
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
            </table>
            </br></br>
        <?php endforeach; ?>
    </div>

    <!-- Export PDF Button (future functionality) -->
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Add export functionality here -->
    </div>
</body>
</html>
