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
<?php if($this->session->flashdata('message-exclusion')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-exclusion"); ?>
	</div>

<?php endif; ?>
<?php if($this->session->flashdata('message-ajout-extensions')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-ajout-extensions"); ?>
	</div>

<?php endif; ?>
<div id="exportable-content">
    <h1>Gestion extension <?php  foreach($clients as $C): ?>
        <?php echo $C['nom_client']; ?>
                   </h1>

<?php echo anchor("Googleads/ajoutextension/".$C['idclients'], '<h6 class="btn btn-secondary mr-1" >Ajout extension</h6>', 'data-edit="'.$C['idclients'].'"'); ?>
<?php echo anchor("Googleads/campagne/".$C['idclients'], '<h6 class="btn btn-secondary mr-2">Campagne</h6><i class="button"></i>', 'data-edit="'.$C['idclients'].'"'); ?>
<?php echo anchor("Googleads/exclusion/".$C['idclients'], '<h6 class="btn btn-secondary mr-2">Exlusion</h6><i class="button"></i>', 'data-edit="'.$C['idclients'].'" class="open-popup"'); ?>
<?php echo anchor("Googleads/plandetaggage/".$C['idclients'], '<h6 class="btn btn-secondary mr-1" >Plan de taggage</h6>', 'data-edit="'.$C['idclients'].'"'); ?>


<?php endforeach; ?>                         
    <div class="logo-container">
        <div style="flex: 1; padding-right: 20px;">
            <img src="<?php echo base_url(IMAGES_PATH.'/logo/logo3.png'); ?>" style="width: 200px;">
        </div>
        <div style="flex: 1; text-align: right;">
            <h1>Extensions</h1>
        </div>
    </div>

   
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
            <tr> <td> <?php echo anchor("Googleads/editextensions/".$E['idextensions'], '<i class="fas fa-edit"></i>','data-edit="'.$E['idextensions'].'"'); ?>
                        <?php echo anchor("Googleads/deleteextension/".$E['idextensions'], '<i class="fas fa-trash"></i>', 'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette extension ?\');" data-edit="'.$E['idextensions'].'"'); ?>
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

</html>     
</body>
</html>
<?php foreach($donnees as $D): ?>
<!-- Popup (initialement masqué) -->
<div id="popupForm" style="display:none;">
    <div class="popup-content">
    <form action="<?php echo site_url('Googleads/exclusion'); ?>" method="post">
    <label for="comment">MOTS CLES A EXCLURE :</label>
    
    <!-- Champ caché pour l'ID du client -->
    <input type="hidden" name="idclients" value="<?php echo htmlspecialchars($D['idclients'], ENT_QUOTES, 'UTF-8'); ?>" /> 
    
    <!-- Zone de texte pré-remplie avec la valeur de l'exclusion -->
    <textarea id="comment" name="exclusion" class="large-textarea"><?php echo htmlspecialchars($donnees[0]['exclusion'], ENT_QUOTES, 'UTF-8'); ?></textarea><br>
    
    <button type="submit">Valider</button>
</form>

    </div>
</div>
<!-- Style du Popup -->
<style>
    #popupForm {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999; /* S'assurer qu'il soit au-dessus des autres éléments */
    }
    .popup-content {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
        height: 900px; 
        margin-left: 39%;
    }

    textarea {
        width: 100%;
        height: 100px;
    }
    .large-textarea {
        width: 100%; /* Occupe toute la largeur du parent */
        height: 750px; /* Définit une hauteur de 500px */
        font-size: 16px; /* Vous pouvez ajuster la taille du texte ici si nécessaire */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Lorsque le lien avec la classe "open-popup" est cliqué
    $('.open-popup').on('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien

        // Affiche le popup
        $('#popupForm').fadeIn();
    });

    // Lorsque le bouton "Fermer" est cliqué
    $('#closePopup').on('click', function() {
        // Masque le popup
        $('#popupForm').fadeOut();
    });

    // Lorsque l'utilisateur clique en dehors du popup, il se ferme
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.popup-content').length && !$(event.target).closest('.open-popup').length) {
            $('#popupForm').fadeOut();
        }
    });
});
</script>
<?php endforeach;?>
</br>  </br>  </br>  </br>
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
        <?php foreach($donnees as $D): ?>
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


        </br>  </br>  </br>  </br>