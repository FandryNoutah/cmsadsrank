<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Images</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajouter Sortable.js via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <style>
         /* Styles généraux */
body {
    font-family: Arial, sans-serif;  /* Choix d'une police professionnelle */
    background-color: #f8f9fa;      /* Couleur de fond claire */
}

/* Conteneur principal */
.container {
    margin-top: 20px;
}

/* Style des cartes d'images */
.image-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    background-color: #fff;  /* Fond blanc pour chaque carte */
    transition: transform 0.3s ease, box-shadow 0.3s ease;  /* Effet au survol */
}

.image-card:hover {
    transform: scale(1.05);  /* Légère mise en avant au survol */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);  /* Ombre plus marquée au survol */
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

/* Style du bouton de suppression */
.image-card .delete-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 18px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.image-card .delete-btn:hover {
    background-color: #c82333;  /* Changer la couleur au survol pour un effet interactif */
}

/* Section d'ajout d'images */
.upload-container {
    text-align: center;
    margin-bottom: 30px;
}

.upload-container h4 {
    margin-bottom: 20px;
    font-size: 1.25rem;
    font-weight: 600;
}

/* Formulaire d'ajout */
input[type="file"], input[type="text"] {
    width: 80%;               /* Largeur d'entrée plus grande */
    max-width: 400px;         /* Limiter la largeur */
    margin: 0 auto;           /* Centrer horizontalement */
    display: block;           /* Enlever les marges par défaut */
}

/* Boutons d'action */
button {
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;  /* Couleur plus foncée au survol */
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0069d9;  /* Couleur plus foncée au survol */
}

/* Onglets */
.nav-tabs {
    border-bottom: 2px solid #ddd;
}

.nav-tabs .nav-link {
    border: 1px solid #ddd;
    border-radius: 4px 4px 0 0;
    padding: 10px 15px;
}

.nav-tabs .nav-link.active {
    background-color: #fff;
    border-color: #ddd;
    color: #007bff;
}

/* Disposition des images */
.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

/* Colonne d'image */
.col-md-4 {
    display: flex;
    justify-content: center;  /* Centrer horizontalement les images */
    align-items: center;      /* Centrer verticalement les images */
    margin-bottom: 20px;
    padding: 0 10px;
    flex-basis: calc(33.3333% - 20px); /* 3 images par ligne avec des espacements */
}

@media (max-width: 768px) {
    .col-md-4 {
        flex-basis: calc(50% - 20px); /* 2 images par ligne pour les écrans plus petits */
    }
}

@media (max-width: 576px) {
    .col-md-4 {
        flex-basis: 100%; /* Une seule image par ligne pour les petits écrans */
    }
}
    </style>
</head>
<body>

<div class="container">

    <h1 class="text-center mb-4">Gestion des Images <?php echo $clients->nom_client; ?></h1>
    <?php if($images != NULL): ?>
        <?php 
           
            if($clients->type_campagnes == 2): ?>
    <?php echo anchor("Validation/validation_structure/".$clients->idclients, '<h6 class="btn btn-success mr-3">Enregistrer</h6><i class="button"></i>', 'data-edit="'.$clients->idclients.'"'); ?>
            <?php endif; ?>  
            <?php  if($clients->type_campagnes == 3): ?>
    <?php echo anchor("Validation/validation_structure/".$clients->idclients, '<h6 class="btn btn-success mr-3">Enregistrer</h6><i class="button"></i>', 'data-edit="'.$clients->idclients.'"'); ?>
            <?php endif; ?>      
    <?php endif; ?>  
    <ul class="nav nav-tabs" id="imageTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="upload-tab" data-bs-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="true">Télécharger une image</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="url-tab" data-bs-toggle="tab" href="#url" role="tab" aria-controls="url" aria-selected="false">Ajouter une image par URL</a>
        </li>
    </ul>
    <div class="tab-content" id="imageTabsContent">
        <!-- Onglet pour télécharger une image -->
        <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
            <div class="upload-container">
                <h4>Ajouter une nouvelle image (par téléchargement)</h4>
                <?php echo form_open_multipart('Validation/add_image'); ?>
                <div class="mb-3">
                    <?php  ?>
                    <input type="hidden" name="idgroupe_annone" class="form-control" value="<?php echo $idgroupe_annone; ?>">
                    <input type="hidden" name="idclients" class="form-control" value="<?php echo $clients->idclients; ?>">
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Ajouter l'image</button>
                <?php echo form_close(); ?>
            </div>
        </div>

        <!-- Onglet pour ajouter une image via URL -->
        <div class="tab-pane fade" id="url" role="tabpanel" aria-labelledby="url-tab">
            <div class="upload-container">
                <h4>Ajouter une image depuis une URL</h4>
                <?php echo form_open('Validation/add_image_url'); ?>
                <div class="mb-3">
                <input type="hidden" name="idgroupe_annone" class="form-control" value="<?php echo $idgroupe_annone; ?>">
                <input type="hidden" name="idclients" class="form-control" value="<?php echo $clients->idclients; ?>">
                    <input type="text" name="image_url" class="form-control" placeholder="Entrez l'URL de l'image" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter l'image via URL</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Liste des images (glisser-déposer activé) -->
    <div id="image-list" class="row" style="list-style: none;">
    <?php foreach ($images as $image): ?>
        <div class="col-md-4" id="image-<?= $image->id ?>" data-id="<?= $image->id ?>">
            <div class="image-card">
                <!-- Vérifier si l'image est locale ou externe -->
                <?php if (strpos($image->image_url, 'http') === 0): ?>
                    <!-- Image externe -->
                    <img src="<?= $image->image_url ?>" alt="Image">
                <?php else: ?>
                    <!-- Image locale (dans le dossier 'uploads') -->
                    <img src="<?= base_url($image->image_url) ?>" alt="Image">
                <?php endif; ?>
                
                <button class="delete-btn" onclick="window.location.href='<?= site_url('Validation/delete_image/'.$image->id) ?>'">&times;</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Script pour activer Sortable.js -->
<script>
    // Initialiser Sortable.js pour la liste d'images
    var el = document.getElementById('image-list');
    var sortable = new Sortable(el, {
        animation: 150,  // Animation de glissement
        onEnd: function (evt) {
            // Lorsque l'utilisateur a fini de glisser les éléments
            var order = sortable.toArray();  // Récupérer l'ordre des éléments
            updateImageOrder(order);  // Appeler une fonction pour mettre à jour l'ordre des images
        }
    });

    // Fonction pour envoyer l'ordre des images au serveur
    function updateImageOrder(order) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= site_url('googleads/update_order') ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("order=" + JSON.stringify(order));  // Envoyer l'ordre en JSON
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
