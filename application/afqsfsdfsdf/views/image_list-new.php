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
        .image-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .image-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
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
        }
        .container {
            margin-top: 20px;
        }
        .upload-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1 class="text-center mb-4">Gestion des Images <?php echo $clients->nom_client; ?></h1>
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
                <?php echo form_open_multipart('googleads/add_image'); ?>
                <div class="mb-3">
                    <?php  ?>
                    <input type="hidden" name="idgroupe_annone" class="form-control" value="<?php echo $idgroupe_annone; ?>">
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
                <?php echo form_open('googleads/add_image_url'); ?>
                <div class="mb-3">
                <input type="hidden" name="idgroupe_annone" class="form-control" value=" <?php echo $idgroupe_annone; ?>">
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
                
                <button class="delete-btn" onclick="window.location.href='<?= site_url('googleads/delete_image/'.$image->id) ?>'">&times;</button>
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
