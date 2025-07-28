<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion d'images moderne</title>
    <style>
        /* Styles généraux */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }

        /* Onglets */
        .tabs {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            border-bottom: 2px solid #ccc;
        }

        .tab {
            padding: 12px 30px;
            cursor: pointer;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            border-bottom: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .tab:hover {
            background-color: #ddd;
        }

        .active-tab {
            background-color: #ddd;
            border-bottom: 2px solid #0056b3;
        }

        /* Contenu des onglets */
        .tab-content {
            display: none;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-top: 10px;
            border-radius: 5px;
        }

        .active-content {
            display: block;
        }

        /* Grille d'images moderne */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .image-container {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        /* Effet au survol */
        .image-container:hover img {
            transform: scale(1.05);
            filter: brightness(0.8);
        }

        /* Cases à cocher */
        .image-container input[type="checkbox"] {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            appearance: none;
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            z-index: 10;
        }

        .image-container input[type="checkbox"]:checked {
            background-color: #0056b3;
            border-color: #004494;
        }

        .image-container input[type="checkbox"]:checked::after {
            content: '✔';
            position: absolute;
            top: 2px;
            left: 5px;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        /* Effet visuel lors de la sélection */
        .image-container.selected img {
            border: 4px solid #0056b3;
            filter: brightness(0.7);
        }

        /* Boutons */
        button {
            display: block;
            margin: 30px auto;
            padding: 10px 30px;
            background-color: #0056b3;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004494;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Titre dynamique avec les noms des clients -->
        <?php foreach ($client as $G) : ?>
            <h1>Gestion d'images du client : <?php echo $G['nom_client']; ?></h1>
       

        <!-- Onglets -->
        <div class="tabs">
            <div class="tab active-tab" onclick="showTab('tab1')">Importation par URL</div>
           <!-- <div class="tab" onclick="showTab('tab2')">Upload d'images</div> -->
        </div>

        <!-- Onglet 1 : Importation d'images par URL -->
        <div id="tab1" class="tab-content active-content">
        <form method="POST" action="<?= site_url('imagescraper/vie2/'.$id); ?>">
    <label for="url">URL du site :</label>
    <input type="text" name="url" id="url" placeholder="Entrez l'URL du site" required>
    <button type="submit">Récupérer les images</button>
</form>

<?php if (!empty($images)) : ?>
    <h2>Images récupérées :</h2>
    <form method="POST" action="<?= site_url('Googleads/save_images2'); ?>">
    <button type="submit" style="background-color: #37BC9B">Enregistrer images</button>
        <div class="image-grid">
            <?php foreach ($images as $image) : ?>
                <label class="image-container">
                    <input type="hidden" name="idclients" value="<?php echo $G['idclients']; ?>">
                    <input type="checkbox" name="selected_images[]" value="<?= $image; ?>" class="image-checkbox">
                    <img src="<?= $image; ?>" alt="Image">
                </label>
            <?php endforeach; ?>
        </div>
        
    </form>


<script>
    const checkboxes = document.querySelectorAll('.image-checkbox');
    const maxSelection = 8;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const selectedCheckboxes = document.querySelectorAll('.image-checkbox:checked');
            if (selectedCheckboxes.length > maxSelection) {
                this.checked = false; // Désélectionner cette case
                alert('Vous ne pouvez sélectionner que 8 images.');
            }
        });
    });
</script>


            <?php endif; ?>
            
        </div>

        <!-- Onglet 2 : Upload d'images -->
        <div id="tab2" class="tab-content">
    <h2>Upload d'images</h2>
    <!-- Input pour ajouter des images -->
    <form id="image-upload-form" enctype="multipart/form-data">
        <label for="file-input">Ajouter des images :</label>
        <input type="file" id="file-input" multiple accept="image/*">
    </form>

    <!-- Zone d'affichage des images uploadées -->
    <h3>Images ajoutées :</h3>
<form method="POST" action="<?= site_url('Googleads/save_images_upload'); ?>" id="selected-images-form">
    <div id="uploaded-images-grid" class="image-grid">
        <!-- Images ajoutées dynamiquement ici -->
    </div>
    <button type="submit">Enregistrer les images sélectionnées</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('file-input');
        const imageGrid = document.getElementById('uploaded-images-grid');
        const maxSelection = 8; // Limite de 8 images sélectionnées

        fileInput.addEventListener('change', function () {
            const files = Array.from(this.files);

            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imageContainer = document.createElement('div');
                        imageContainer.classList.add('image-container');

                        imageContainer.innerHTML = `
                            <label>
                            
                                <input type="checkbox" name="selected_images[]" value="${file.name}">
                                <img src="${e.target.result}" alt="Image ajoutée">
                            </label>
                            <button type="button" class="delete-button">&times;</button>
                        `;

                        const deleteButton = imageContainer.querySelector('.delete-button');
                        deleteButton.addEventListener('click', () => {
                            imageContainer.remove();
                            // Vérifier si la sélection d'images a changé après suppression
                            updateSelectionLimit();
                        });

                        const checkbox = imageContainer.querySelector('input[type="checkbox"]');
                        checkbox.addEventListener('change', () => {
                            updateSelectionLimit();
                        });

                        imageGrid.appendChild(imageContainer);
                    };

                    reader.readAsDataURL(file);
                }
            });

            this.value = '';
        });

        // Fonction pour vérifier et mettre à jour la sélection
        function updateSelectionLimit() {
            const selectedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;

            // Si plus de 8 images sont sélectionnées, afficher une alerte et désactiver les autres cases à cocher
            if (selectedCount > maxSelection) {
                alert("Vous ne pouvez pas sélectionner plus de 8 images.");
                // Désélectionner la dernière image sélectionnée pour limiter la sélection
                const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                checkboxes[checkboxes.length - 1].checked = false;
                alert('Vous ne pouvez sélectionner que 8 images.');
            }

            // Désactiver les cases à cocher restantes si 8 images sont déjà sélectionnées
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.disabled = selectedCount >= maxSelection && !checkbox.checked;
            });
        }
    });
</script>



<?php endforeach; ?>
    </div>

    <!-- JavaScript pour les onglets et sélection d'images -->
    <script>
        function showTab(tabId) {
            // Masquer tout le contenu des onglets
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active-content');
            });

            // Désactiver tous les onglets
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active-tab');
            });

            // Afficher le contenu sélectionné
            document.getElementById(tabId).classList.add('active-content');
            document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active-tab');
        }

        // Effet visuel lors de la sélection des images
        document.querySelectorAll('.image-container input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    this.parentElement.classList.add('selected');
                } else {
                    this.parentElement.classList.remove('selected');
                }
            });
        });
    </script>
</body>

</html>
