<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des images</title>

    <!-- Lien vers le fichier CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ajouter votre propre CSS si nécessaire -->
    <style>
        /* Personnalisation du modal */
        .modal-content {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .modal {
            display: none;
        }

        .image-item {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }

        .delete-image {
            background: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<!-- Le popup avec les onglets -->
<div class="modal" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gestion des images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="url-tab" data-bs-toggle="tab" href="#url" role="tab" aria-controls="url" aria-selected="true">Ajout par URL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="file-tab" data-bs-toggle="tab" href="#file" role="tab" aria-controls="file" aria-selected="false">Ajout par fichier</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- Ajout par URL -->
                    <div class="tab-pane fade show active" id="url" role="tabpanel" aria-labelledby="url-tab">
                        <form method="POST" action="<?= site_url('imagescraper/add_image_from_url'); ?>">
                            <input type="text" name="url" placeholder="Entrez l'URL de l'image" required>
                            <button type="submit" class="btn btn-primary">Ajouter l'image</button>
                        </form>
                    </div>

                    <!-- Ajout par fichier -->
                    <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab">
                        <form method="POST" action="<?= site_url('imagescraper/add_image_from_computer'); ?>" enctype="multipart/form-data">
                            <input type="file" name="image" required>
                            <button type="submit" class="btn btn-primary">Ajouter l'image</button>
                        </form>
                    </div>
                </div>

                <!-- Affichage des images -->
                <h3>Images :</h3>
                <div id="image-gallery">
                    <?php foreach ($images as $image): ?>
                        <div class="image-item">
                            <img src="<?= base_url($image['image_url']); ?>" alt="Image" style="max-width: 100px;">
                            <button class="delete-image" data-id="<?= $image['id']; ?>">Supprimer</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajout des fichiers JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Affichage et fermeture du modal
    $(document).ready(function() {
        // Affichage du modal
        $('#imageModal').modal('show');
        
        // Suppression d'image via AJAX
        $(document).on('click', '.delete-image', function() {
            var imageId = $(this).data('id');
            $.ajax({
                url: '<?= site_url('imagescraper/delete_image/'); ?>' + imageId,
                method: 'GET',
                success: function(response) {
                    $('#image-gallery').html(response); // Met à jour l'affichage des images
                }
            });
        });
    });
</script>

</body>
</html>
