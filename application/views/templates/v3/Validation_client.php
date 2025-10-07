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

    

    <div id="exportable-content">
        <!-- Section Logo et Titre -->
        <div class="logo-container">
            <div style="flex: 1; padding-right: 20px;">
                <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
            </div>
            <div style="flex: 1; text-align: right;">
                <h1>ANNONCE</h1>
            </div>
        </div>

        <!-- Contenu de l'annonce -->
        <?php foreach($search as $G): ?>
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
                <?php echo $G['titre1']; ?><br>
                <?php echo $G['titre2']; ?><br>
                <?php echo $G['titre3']; ?><br>
                <?php echo $G['titre4']; ?><br>
                <?php echo $G['titre5']; ?><br>
                <?php echo $G['titre6']; ?><br>
                <?php echo $G['titre7']; ?><br>
                <?php echo $G['titre8']; ?><br>
                <?php echo $G['titre9']; ?><br>
                <?php echo $G['titre10']; ?><br>
                <?php echo $G['titre11']; ?><br>
                <?php echo $G['titre12']; ?><br>
                </td>
            </tr>
            <tr>
                <td class="blue-cell">Descriptions</td>
                <td style="text-align: center;">
                <?php echo $G['descriptions1']; ?><br>
                <?php echo $G['descriptions2']; ?><br>
                <?php echo $G['descriptions3']; ?><br>
                <?php echo $G['descriptions4']; ?><br>
                </td>
            </tr>
            <tr>
                <td class="blue-cell">Chemin 1</td>
                <td style="text-align: center;"> <?php echo $G['chemin1']; ?></td>
            </tr>
            <tr>
                <td class="blue-cell">Chemin 2</td>
                <td style="text-align: center;"> <?php echo $G['chemin2']; ?></td>
            </tr>
            <tr>
                <td class="blue-cell">URL</td>
                <td style="text-align: center;"><a href="<?php echo $G['url_groupe_annonce']; ?>" target="_blank"><?php echo $G['url_groupe_annonce']; ?></a></td>
            </tr>
        </table>
   
</div>

    <script>
        function exportToPDF() {
            const element = document.getElementById('exportable-content');
            
            // Configurer les options de pdf
            const options = {
                filename: '<?php echo $G['nom_campagne']; ?>.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 4 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Générer et télécharger le PDF
            html2pdf().from(element).set(options).save();
        }
    </script>
<?php endforeach; ?>
</body>
</html>
