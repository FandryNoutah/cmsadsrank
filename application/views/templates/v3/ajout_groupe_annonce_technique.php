<?php
// Si une requête AJAX est envoyée, exécute le traitement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remplir') {
    header('Content-Type: application/json');
    // Configuration de l'API OpenAI
    $apiKey = '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';
$prompt = "Génère-moi STRICTEMENT un objet JSON avec les clés e'titres' (tableau de 12 titres) et 'descriptions' (tableau de 4 descriptions), en français, basé sur les mots clés : " . $campagnes[0]['mot_cle'] . " et le contexte client : " . $campagnes[0]['contexte_groupes_annonces'] . ". Les titres doivent impérativement faire **au maximum 30 caractères** chacun (espaces compris), sinon raccourcis-les sans couper les mots, et les descriptions doivent faire au maximum 90 caractères. Répond uniquement par ce JSON, sans texte supplémentaire.";




    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.7
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    $content = $result['choices'][0]['message']['content'] ?? '';

// Nettoyer le contenu pour tenter d'extraire uniquement le JSON
// Par exemple, trouver la première accolade '{' et la dernière '}' pour extraire le JSON
$start = strpos($content, '{');
$end = strrpos($content, '}');

if ($start !== false && $end !== false) {
    $json_string = substr($content, $start, $end - $start + 1);
    $json_data = json_decode($json_string, true);
    
    if ($json_data !== null) {
        // On suppose que json_data['titres'] et json_data['descriptions'] sont des tableaux
        $output = [];
        for ($i = 0; $i < 12; $i++) {
            $output['titre' . ($i + 1)] = $json_data['titres'][$i] ?? '';
        }
        for ($j = 0; $j < 4; $j++) {
            $output['description' . ($j + 1)] = $json_data['descriptions'][$j] ?? '';
        }
        echo json_encode($output);
        exit;
    } else {
        // JSON invalide
        echo json_encode(['error' => 'Réponse JSON invalide : ' . $json_string]);
        exit;
    }
} else {
    echo json_encode(['error' => 'Aucun JSON trouvé dans la réponse.']);
    exit;
}


}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec popup</title>
    <style>
       body{
            background-color: white! important;
            color: black;
          
        }
        span{
            font-family: 'Manrope', sans-serif! important;
            
        }
        body label{
            font-size: 14px;
        }
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
            background-color: white;
        
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
        /* Style for export button */
        .export-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #4285f4;
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



<h3 style="font-size: 52px; text-align: center; margin-bottom: 20px;"><b><?php echo $current_user->first_name ?> , C’est parti pour</br> l’élaboration de la stratégie Search!!</h3></b>    

            <?php foreach($groupe as $D): ?>
							<h3 style="font-size: 20px;"></br>Campagne client : <a style="color: #37BC9B"> <?php echo $D['nom_groupe'] ?></a> </h3>

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
        <?php foreach($campagnes as $index => $D): ?>
            <tr>
                    <td  style="background-color: white">
                        <?php echo $D['nom_campagne']; ?>
                    </td>
                    <td style="background-color: white"><?php echo $D['information_campagne']; ?></td>
                    <td style="background-color: white"><?php echo $D['contexte_groupes_annonces']; ?></td>
                    
                    <td style="background-color: white"><?php echo $D['zones']; ?></td>
                    <td style="background-color: white"><?php echo $D['objectif']; ?></td>
                    <td style="background-color: white"><?php echo $D['url_site']; ?></td>
                    <td style="background-color: white"><?php echo $D['date_campagne']; ?></td>
                    <td style="background-color: white"><?php echo $D['appareil']; ?></td>
                    <td style="background-color: white"><?php echo $D['repartition_budget']; ?> €</td>
               
            </tr> <!-- Fermer la ligne ici pour chaque campagne action="//site_url('Googleads/Ajoutgroupes'); " -->
        <?php endforeach; ?>
    </tbody>
</table></br></br>
            <div class="row" style="margin-top: 0px">
            <div class="col-md-4" style="margin-top: -50px">
							<form  method="POST" enctype="multipart/form-data">

    <!-- Champs cachés -->
    <input type="hidden" name="idgroupe_annonce" value="<?= $D['idgroupe_annonce']; ?>">
    <input type="hidden" name="idcampagne" value="<?= $D['idcampagne']; ?>">
    <input type="hidden" name="idclients" value="<?= $D['idclients']; ?>">
    <input type="hidden" name="type_campagne" value="<?= $D['type_campagnes']; ?>">

    <!-- Nom du groupe -->
    <label>Nom du groupe :</label>
    <input type="text" name="nom_groupe" class="form-control" value="<?= $D['nom_groupe'] ?>"><br>

    <!-- URL -->
    <label>URL :</label>
    <input type="text" name="url" class="form-control" value="<?= $D['url_groupe_annonce']; ?>"><br>

    <!-- Mots-clés -->
    <label>Mot clé :</label>
    <textarea name="mot_cle" class="form-control" rows="10"><?= $D['mot_cle']; ?></textarea><br>

    <!-- Titres générés par GPT -->
<?php for ($i = 1; $i <= 12; $i++): ?>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <label for="titre<?= $i ?>">Titre <?= $i ?> :</label>
        <small class="titre-counter">0/30</small>
    </div>
    <input
        type="text"
        id="titre<?= $i ?>"
        name="titre<?= $i ?>"
        maxlength="30"
        class="form-control titre-input"
        value="<?= isset($D["titre$i"]) ? htmlspecialchars($D["titre$i"]) : '' ?>"
    ><br>
<?php endfor; ?>



<script>
function updateTitleCounters() {
   document.querySelectorAll('input.titre-input').forEach(input => {
      const counter = input.previousElementSibling.querySelector('small.titre-counter');
      const maxLength = input.getAttribute('maxlength');

      // Initial update au chargement
      counter.textContent = input.value.length + '/' + maxLength;

      input.addEventListener('input', () => {
        counter.textContent = input.value.length + '/' + maxLength;
      });
   });
}



</script>


    <!-- Bouton GPT -->
    <button type="button" onclick="remplirChamps()" style="margin-bottom: 20px; width: 280px; height: 41px; background-color: #4EA5FC; color: white; border-radius: 20px;">
        Ajouter un titre avec ChatGPT
        <img width="8%" src="<?= base_url("assets/images/ico/geminib.png"); ?>" alt="GPT">
    </button>

    <!-- Descriptions -->
    <?php for ($i = 1; $i <= 4; $i++): ?>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <label>Description <?= $i ?>:</label>
            <small class="desc-counter">0/90</small>
        </div>
        <textarea name="description<?= $i ?>" class="form-control description-textarea" maxlength="90"><?= htmlspecialchars($D["descriptions$i"]) ?></textarea><br>
    <?php endfor; ?>

    <!-- Chemins -->
    <label>Chemin 1 :</label>
    <input type="text" name="chemin1" class="form-control" value="<?= $D['chemin1']; ?>"><br>

    <label>Chemin 2 :</label>
    <input type="text" name="chemin2" class="form-control" value="<?= $D['chemin2']; ?>"><br>
  </div>
   
 
       
     <div class="col-md-8">
            
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
        /* Style for export button */
        .export-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #4285f4;
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

    

    <div id="exportable-content" style="margin-top: 31px;">
    <label for="group-name">Preview</label>
        <div class="logo-container">
            <div style="flex: 1; padding-right: 20px;">
                <img src="<?php echo base_url(IMAGES_PATH."/logo/logo3.png"); ?>" style="width: 200px;">
            </div>
            <div style="flex: 1; text-align: right;">
                <h1><b>Annonce</b></h1>
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
                    <?php echo implode('<br>', array_filter([$G['titre1'], $G['titre2'], $G['titre3'], $G['titre4'], $G['titre5'], $G['titre6'], $G['titre7'], $G['titre8'], $G['titre9'], $G['titre10'], $G['titre11'], $G['titre12']])); ?>
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

    

    <!-- Bouton de prévisualisation -->
    <button type="submit" class="btn btn-success" style="font-size: 16px; font-weight: 500; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px;">
        Prévisualiser
    </button>

</form>
<?php endforeach; ?>
</body>
</html>

<!-- Script JS GPT -->
<script>
    async function remplirChamps() {
    try {
        const response = await fetch('', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=remplir'
        });
        const data = await response.json();
        // Remplir les titres
        for (let i = 1; i <= 12; i++) {
            const titre = document.getElementById('titre' + i);
            if (titre && data['titre' + i] !== undefined) {
                titre.value = data['titre' + i];
            }
        }

        // Remplir les descriptions
        for (let j = 1; j <= 4; j++) {
            const desc = document.querySelector(`[name="description${j}"]`);
            if (desc && data['description' + j] !== undefined) {
                desc.value = data['description' + j];
            }
        }

        // Mettre à jour les compteurs descriptions
        updateDescriptionCounters();

        // Mettre à jour les compteurs titres (important)
        updateTitleCounters();

    } catch (error) {
        console.error("Erreur :", error);
    }
}


// Mettre à jour les compteurs

</script>

<!-- Script compteur caractères descriptions -->
<script>
    function updateDescriptionCounters() {
        const textareas = document.querySelectorAll('.description-textarea');
        textareas.forEach(textarea => {
            const counter = textarea.previousElementSibling.querySelector('.desc-counter');
            function updateCounter() {
                counter.textContent = `${textarea.value.length}/90`;
            }
            textarea.addEventListener('input', updateCounter);
            updateCounter();
        });
    }
    updateDescriptionCounters();



    // Fonction qui met à jour le compteur d’un input sans ajouter d’event listener
function updateSingleTitleCounter(input) {
    const counter = input.previousElementSibling.querySelector('small.titre-counter');
    const maxLength = input.getAttribute('maxlength');
    counter.textContent = input.value.length + '/' + maxLength;
}

// Fonction qui ajoute les event listeners une fois (à appeler au chargement)
function initTitleCounters() {
    document.querySelectorAll('input.titre-input').forEach(input => {
        input.addEventListener('input', () => updateSingleTitleCounter(input));
        // Mise à jour initiale
        updateSingleTitleCounter(input);
    });
}

// Pareil pour les descriptions
function updateSingleDescCounter(textarea) {
    const counter = textarea.previousElementSibling.querySelector('.desc-counter');
    counter.textContent = `${textarea.value.length}/90`;
}

function initDescriptionCounters() {
    document.querySelectorAll('.description-textarea').forEach(textarea => {
        textarea.addEventListener('input', () => updateSingleDescCounter(textarea));
        // Mise à jour initiale
        updateSingleDescCounter(textarea);
    });
}

// Fonction qui met à jour tous les compteurs titres (après remplissage par JS)
function updateTitleCounters() {
    document.querySelectorAll('input.titre-input').forEach(input => updateSingleTitleCounter(input));
}

// Fonction qui met à jour tous les compteurs descriptions (après remplissage par JS)
function updateDescriptionCounters() {
    document.querySelectorAll('.description-textarea').forEach(textarea => updateSingleDescCounter(textarea));
}

// Au chargement, initialiser les events listeners
window.addEventListener('DOMContentLoaded', () => {
    initTitleCounters();
    initDescriptionCounters();
});

</script>

</body>
</html>


        </div>
        </div>    