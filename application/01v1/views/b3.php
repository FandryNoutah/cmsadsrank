<h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Ajout Groupe d'annonces - Technique</h4>

<?php foreach($campagne as $D): ?>
    <h3><br>Campagne client : <a style="color: #37BC9B"><?php echo $D['nom_campagne']; ?></a></h3>
<?php endforeach; ?>

<form action="<?php echo site_url('Googleads/Ajoutgroupepmax'); ?>" method="POST" enctype="multipart/form-data">
    <div id="annonce-groups">
        <div class="annonce-group">
            <input type="hidden" name="idcampagne" class="form-control" value="<?php echo $D['idcampagne']; ?>">
            <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>">
            <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagne']; ?>">

            <label for="group-name">Nom du groupe :</label>
            <input type="text" name="nom_groupe" class="form-control"><br>

            <label for="logos">Logo :</label>
            <input type="file" id="logos" name="logos" class="form-control"><br>

            <label for="favicon">Favicon :</label>
            <input type="file" id="favicon" name="favicon" class="form-control"><br><br>

      
           <!-- Choisir une source d'image -->
<label for="image-source">Choisir une source d'image :</label>
<select id="image-source" name="image-source" class="form-control">
    <option value="" disabled selected>Sélectionnez une option</option>
    <option value="url">Ajouter une image par URL</option>
    <option value="file">Téléchargement d'image (Fichier)</option>
</select>

<!-- Section pour ajouter une image par URL -->
<div id="url-upload" class="image-upload" style="display:none;">
    <label for="url">URL du site:</label>
    <input type="text" name="url" id="url" placeholder="Entrez l'URL du site" required>
    <button type="submit">Récupérer les images</button>
    <div id="images-container"></div>
</div>

<!-- Section pour télécharger des images -->
<div id="file-upload" class="image-upload" style="display:none;">
    <label for="local-image">Images :</label><br>
    Youtube 1 : <input type="file" name="Images_youtube1" class="form-control" multiple accept="image/*"><br>
    Youtube 2 : <input type="file" name="Images_youtube2" class="form-control" multiple accept="image/*"><br>
    Gmail : <input type="file" name="Images_gmail" class="form-control" multiple accept="image/*"><br>
    Display 1 : <input type="file" name="Images_display1" class="form-control" multiple accept="image/*"><br>
    Display 2 : <input type="file" name="Images_display2" class="form-control" multiple accept="image/*"><br>
    Discover 1 : <input type="file" name="Images_discover1" class="form-control" multiple accept="image/*"><br>
    Discover 2 : <input type="file" name="Images_discover2" class="form-control" multiple accept="image/*"><br>
    Discover 3 : <input type="file" name="Images_discover3" class="form-control" multiple accept="image/*"><br>
</div>

<!-- jQuery et script AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fonction pour basculer entre les champs d'upload d'image par fichier et par URL
    $('#image-source').on('change', function() {
        var imageSource = this.value;
        var fileUpload = $('#file-upload');
        var urlUpload = $('#url-upload');
        
        // Masquer les deux sections au départ
        fileUpload.hide();
        urlUpload.hide();
        
        // Afficher la section en fonction de la sélection
        if (imageSource === 'file') {
            fileUpload.show();  // Afficher la section de téléchargement de fichiers
        } else if (imageSource === 'url') {
            urlUpload.show();   // Afficher la section de téléchargement par URL
        }
    });
</script>


            <button type="submit" class="btn btn-success">Ajouter</button>
        </div>
    </div>
</form>

<!-- jQuery et script AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fonction pour basculer entre les champs d'upload d'image par fichier et par URL
    document.getElementById('image-source').addEventListener('change', function() {
        var imageSource = this.value;
        var fileUpload = document.getElementById('file-upload');
        var urlUpload = document.getElementById('url-upload');
        
        // Masquer les deux sections au départ
        fileUpload.style.display = 'none';
        urlUpload.style.display = 'none';
        
        // Afficher la section en fonction de la sélection
        if (imageSource === 'file') {
            fileUpload.style.display = 'block';
        } else if (imageSource === 'url') {
            urlUpload.style.display = 'block';
        }
    });

    // AJAX pour récupérer les images via l'URL
    $('#url-form').on('submit', function(event) {
        event.preventDefault();  // Empêche la soumission classique du formulaire

        var url = $('#url').val();

        $.ajax({
            url: '<?= site_url('imagescraper/vie/'.$id); ?>',  // URL de traitement en PHP
            type: 'POST',
            data: { url: url },  // Données à envoyer (URL)
            success: function(response) {
                // Traite la réponse reçue du serveur
                if (response.images) {
                    var imagesHtml = '<h2>Images récupérées :</h2>';
                    imagesHtml += '<form method="POST" action="<?= site_url('imagescraper/index'); ?>">';
                    imagesHtml += '<div>';

                    response.images.forEach(function(image) {
                        imagesHtml += '<label>';
                        imagesHtml += '<input type="checkbox" name="selected_images[]" value="' + image + '">';
                        imagesHtml += '<img src="' + image + '" alt="Image" style="max-width: 300px; margin: 10px;">';
                        imagesHtml += '</label>';
                    });

                    imagesHtml += '</div>';
                    imagesHtml += '<button type="submit">Enregistrer les images sélectionnées</button>';
                    imagesHtml += '</form>';

                    $('#images-container').html(imagesHtml);
                } else {
                    $('#images-container').html('<p>Aucune image trouvée.</p>');
                }
            },
            error: function(xhr, status, error) {
                $('#images-container').html('<p>Une erreur est survenue. Veuillez réessayer.</p>');
            }
        });
    });
</script>
