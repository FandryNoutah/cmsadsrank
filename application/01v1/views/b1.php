<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <?php foreach($client as $C){ ?>
                <h4 class="card-title" id="basic-layout-colored-form-control">Ajout campagne de <?php echo $C['nom_client']; ?></h4>
                
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                <form action="<?php echo site_url('Googleads/submitForm'); ?>" method="POST" enctype="multipart/form-data">

                    <?php foreach($donnees as $D){ ?>
                        Budget Total = <?php echo $D['budget']; ?>
                     <?php } ?>   
                     <input type="hidden" name="idclient" class="form-control" value="<?php echo $C['idclients']; ?>">
                     <div class="form-group">
                                        <label>Zone</label>
                                        <input type="text" name="zone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Date de diffusion</label>
                                        <input type="text" name="calendar" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Appareils</label>
                                        <select name="appareil" class="form-control">
                                            <option value="0">Ordinateur</option>
                                            <option value="1">Mobile</option>
                                            <option value="2">Tablette</option>
                                            <option value="3">Ordinateur / Mobile</option>
                                            <option value="3">Ordinateur / Tablette</option>
                                            <option value="3">Mobile / Tablette</option>
                                            <option value="3">Ordinateur / Mobile / Tablette</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Objectif</label>
                                        <select name="objectif" class="form-control">
                                            <option value="Lead">Lead</option>
                                            <option value="Vente">Vente</option>
                                        </select>
                                    </div>

                                    
                                    <label for="local-name">Répartition budget :</label>
                                            <input type="text" name="repartition_budget" class="form-control" ><br>

                                <!-- Formulaire dynamique -->
                                <div class="form-group">
                                    <label for="product-choice">Choisir un type de campagne</label>
                                    <select id="product-choice" class="form-control" onchange="showForm()" name="type_de_campagne">
                                        <option value="0">Séléctionner type de campagne</option>
                                        <option value="1">Search</option>
                                        <option value="2">Local</option>
                                        <option value="3">Pmax</option>
                                    </select>
                                </div>

                                <!-- Formulaire Search -->
                                <div id="form-search" class="dynamic-form" style="display:none;">
                                    <h3>Search</h3>
                                    <label for="search-name">Nom campagne (Search) :</label>
                                    <input type="text" id="search-name" name="nom_campagne" value="<?php echo $C['nom_client']; ?> - Search" class="form-control"><br>

                                    <label for="group-name">Répartition budget :</label>
                                            <input type="text" name="repartition_budget" class="form-control" ><br>

                                         
                                    <label for="group-name">Informations campagne  :</label>
                                            <input type="text" name="information" class="form-control" ><br>

                                    <label for="group-name">Cible :</label>
                                    <input type="text" name="clible" class="form-control" ><br>        


                                    <label for="annonce-groups">Groupe d'annonces :</label>
                                    <div id="annonce-groups">
                                        <div class="annonce-group">
                                            <label for="group-name">Nom du groupe :</label>
                                            <input type="text" name="group-name[]" class="form-control" ><br>

                                            
                                            <label for="group-title">Titre 1:</label>
                                            <textarea name="group-title1[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 2:</label>
                                            <textarea name="group-title2[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 3:</label>
                                            <textarea name="group-title3[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 4:</label>
                                            <textarea name="group-title4[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 5:</label>
                                            <textarea name="group-title5[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 6:</label>
                                            <textarea name="group-title6[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 7:</label>
                                            <textarea name="group-title7[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 8:</label>
                                            <textarea name="group-title8[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 9:</label>
                                            <textarea name="group-title9[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 10:</label>
                                            <textarea name="group-title10[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 11:</label>
                                            <textarea name="group-title11[]" class="form-control" ></textarea><br>
                                            <label for="group-title">Titre 12:</label>
                                            <textarea name="group-title12[]" class="form-control" ></textarea><br>



                                            <label for="group-description">Description 1:</label>
                                            <textarea name="group-description1[]" class="form-control" ></textarea><br>
                                            <label for="group-description">Description 2:</label>
                                            <textarea name="group-description2[]" class="form-control" ></textarea><br>
                                            <label for="group-description">Description 3:</label>
                                            <textarea name="group-description3[]" class="form-control" ></textarea><br>
                                            <label for="group-description">Description 4:</label>
                                            <textarea name="group-description4[]" class="form-control" ></textarea><br>

                                            <label for="group-path1">Chemin 1 :</label>
                                            <input type="text" name="group-path1[]" class="form-control" ><br>

                                            <label for="group-path2">Chemin 2 :</label>
                                            <input type="text" name="group-path2[]" class="form-control" ><br>

                                            <label for="group-url">URL :</label>
                                            <input type="text" name="group-url[]" class="form-control" ><br>

                                            <label for="group-keywords">Mot clé :</label>
                                            <textarea name="group-keywords[]" class="form-control" ></textarea><br>
                                            
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="addAnnonceGroup()">Ajouter un groupe d'annonces +</button><br>
                                </div>

                        <!-- Formulaire Local -->
                        <div id="form-local" class="dynamic-form" style="display:none;">
							<h3>Local</h3>

							
                                             <label for="search-name">Nom campagne (Search) :</label>
                                            <input type="text" id="search-name" name="nom_campagne" value="<?php echo $C['nom_client']; ?> - Local" class="form-control"><br>

                                            <label for="local-name">Répartition budget :</label>
                                            <input type="text" name="repartition_budget" class="form-control" ><br>

                                            <label for="local-title">Titre :</label>
                                            <textarea name="local-title[]" class="form-control" ></textarea><br>

                                            <label for="local-description">Description :</label>
                                            <textarea name="local-description[]" class="form-control" ></textarea><br>

                                            <label for="local-description">Short description :</label>
                                            <textarea name="local-description[]" class="form-control" ></textarea><br>
                            
                                            <label for="local-url">URL :</label>
                                            <input type="text" id="local-url" name="local-url" class="form-control"><br>
                                 

                                            
                                            <label for="logos">Logo :</label>
                                            <input type="file" id="logos" name="logos" class="form-control" ><br>
                                            <small>Limité à 20 images</small><br>

                                            <label for="local-image">Images :</label>
                                            <input type="file" id="local-image" name="local-image[]" class="form-control" multiple accept="image/*"><br>
                                            <small>Limité à 20 images</small><br>


						</div>

                        <!-- Formulaire Pmax -->
                        <div id="form-pmax" class="dynamic-form" style="display:none;">
                            <h3>Pmax</h3>
                            <label for="search-name">Nom campagne (PMax) :</label>
                                            <input type="text" id="search-name" name="nom_campagne" value="<?php echo $C['nom_client']; ?> - PMax" class="form-control"><br>

                                            <label for="local-title">Titre :</label>
                                            <textarea name="titre" class="form-control" ></textarea><br>

                                            <label for="local-description">Description :</label>
                                            <textarea name="description" class="form-control" ></textarea><br>

                                            <label for="local-description">Short description :</label>
                                            <textarea name="description_bref" class="form-control" ></textarea><br>
                            
                                            <label for="local-url">URL :</label>
                                            <input type="text" id="local-url" name="url" class="form-control"><br>
                                             
                                            <label for="group-keywords">Mot clé :</label>
                                            <textarea name="mot_cle" class="form-control" ></textarea><br>
                                            
                                            <label for="logos">Logo :</label>
                                            <input type="file" id="logos1" name="logos" class="form-control" ><br>

                                            <label for="logos"> Favicon :</label>
                                            <input type="file" id="logos1" name="favicon" class="form-control" ><br><br>

                                            <label for="image-source">Choisir une source d'image :</label>
                                            <select id="image-source" name="image-source" class="form-control">
                                                <option value="" disabled selected>Sélectionnez une option</option>
                                                <option value="file">Téléchargement d'image (Fichier)</option>
                                                <option value="url">Ajouter une image par URL</option>
                                            </select>

                                            <div id="file-upload" class="image-upload" style="display:none;">
                                                <label for="local-image">Images :</label><br>
                                                Youtube 1 :<input type="file" name="Images_youtube1" class="form-control" multiple accept="image/*"><br>
                                                Youtube 2 :<input type="file" name="Images_youtube2" class="form-control" multiple accept="image/*"><br>
                                                Gmail :<input type="file" name="Images_gmail" class="form-control" multiple accept="image/*"><br>
                                                Display 1 :<input type="file" name="Images_display1" class="form-control" multiple accept="image/*"><br>
                                                Display 2 :<input type="file" name="Images_display2" class="form-control" multiple accept="image/*"><br>
                                                Discover 1 :<input type="file" name="Images_discover1" class="form-control" multiple accept="image/*"><br>
                                                Discover 2 :<input type="file" name="Images_discover2" class="form-control" multiple accept="image/*"><br>
                                                Discover 3 :<input type="file" name="Images_discover3" class="form-control" multiple accept="image/*"><br>
                                            </div>

                                            <div id="url-upload" class="image-upload" style="display:none;">
                                                <label for="url-image">URL Image :</label><br>
                                                Url image Youtube 1 :<input type="text" name="Images_youtube1" class="form-control"><br>
                                                Url image Youtube 2 :<input type="text" name="Images_youtube2" class="form-control"><br>
                                                Url image Gmail :<input type="text" name="Images_gmail" class="form-control"><br>
                                                Url image Display 1 :<input type="text" name="Images_display2" class="form-control"><br>
                                                Url image Display 2 :<input type="text" name="url_display2" class="form-control"><br>
                                                Url image Discover 1 :<input type="text" name="Images_discover1" class="form-control"><br>
                                                Url image Discover 2 :<input type="text" name="Images_discover2" class="form-control"><br>
                                                Url image Discover 3 :<input type="text" name="Images_discover3" class="form-control"><br>
                                            </div>

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
                                            </script>


                        </div>

                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour afficher le formulaire dynamique en fonction de la sélection
    function showForm() {
        var forms = document.querySelectorAll('.dynamic-form');
        forms.forEach(function(form) {
            form.style.display = 'none'; // Masque tous les formulaires dynamiques
        });

        var selectedOption = document.getElementById("product-choice").value;

        if (selectedOption === '1') {
            document.getElementById("form-search").style.display = 'block'; // Affiche le formulaire Search
        } else if (selectedOption === '2') {
            document.getElementById("form-local").style.display = 'block'; // Affiche le formulaire Local
        } else if (selectedOption === '3') {
            document.getElementById("form-pmax").style.display = 'block'; // Affiche le formulaire Pmax
        }
    }

    // Fonction pour ajouter un groupe d'annonces dynamique
    function addAnnonceGroup() {
        var container = document.getElementById("annonce-groups");

        // Crée un nouvel élément div pour le groupe d'annonce
        var newGroup = document.createElement("div");
        newGroup.classList.add("annonce-group");

        // Ajoute les champs pour le groupe d'annonce
        newGroup.innerHTML = `
            <label for="group-name">Nom du groupe :</label>
            <input type="text" name="group-name[]" class="form-control" ><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title1[]" class="form-control" ></textarea><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title2[]" class="form-control" ></textarea><br>

             <label for="group-title">Titre :</label>
            <textarea name="group-title3[]" class="form-control" ></textarea><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title4[]" class="form-control" ></textarea><br>

             <label for="group-title">Titre :</label>
            <textarea name="group-title5[]" class="form-control" ></textarea><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title6[]" class="form-control" ></textarea><br>

             <label for="group-title">Titre :</label>
            <textarea name="group-title7[]" class="form-control" ></textarea><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title8[]" class="form-control" ></textarea><br>

             <label for="group-title">Titre :</label>
            <textarea name="group-title9[]" class="form-control" ></textarea><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title10[]" class="form-control" ></textarea><br>

             <label for="group-title">Titre :</label>
            <textarea name="group-title11[]" class="form-control" ></textarea><br>

            <label for="group-title">Titre :</label>
            <textarea name="group-title12[]" class="form-control" ></textarea><br>

            

            <label for="group-description">Description 1:</label>
            <textarea name="group-description1[]" class="form-control" ></textarea><br>

            <label for="group-description">Description 2:</label>
            <textarea name="group-description2[]" class="form-control" ></textarea><br>

            <label for="group-description">Description 3:</label>
            <textarea name="group-description[]" class="form-control" ></textarea><br>

            <label for="group-description">Description 3:</label>
            <textarea name="group-description4[]" class="form-control" ></textarea><br>

            <label for="group-path1">Chemin 1 :</label>
            <input type="text" name="group-path1[]" class="form-control" ><br>

            <label for="group-path2">Chemin 2 :</label>
            <input type="text" name="group-path2[]" class="form-control" ><br>

            <label for="group-url">URL :</label>
            <input type="text" name="group-url[]" class="form-control" ><br>

            <label for="group-keywords">Mot clé :</label>
            <textarea name="group-keywords[]" class="form-control" ></textarea><br>

            <button type="button" class="btn btn-danger" onclick="removeAnnonceGroup(this)">Supprimer ce groupe</button><br><br>
        `;

        // Ajoute ce groupe au conteneur
        container.appendChild(newGroup);
    }

    // Fonction pour supprimer un groupe d'annonce
    function removeAnnonceGroup(button) {
        var group = button.parentElement;
        group.remove();
    }
	function addLocalImage() {
        var container = document.getElementById("local-images");
        
        // Vérifier si le nombre d'images est inférieur à 20
        var currentImages = container.getElementsByClassName("image-input").length;
        if (currentImages >= 20) {
            alert("Vous ne pouvez pas ajouter plus de 20 images.");
            return;
        }

        // Créer un nouvel élément pour l'ajout d'image
        var newImageGroup = document.createElement("div");
        newImageGroup.classList.add("image-input");

        // Ajouter les champs pour l'image
        newImageGroup.innerHTML = `
            <label for="image-upload">Image :</label>
            <input type="file" name="local-image[]" class="form-control"><br>
            <button type="button" class="btn btn-danger" onclick="removeLocalImage(this)">Supprimer cette image</button><br><br>
        `;
        
        // Ajouter le nouvel élément au conteneur
        container.appendChild(newImageGroup);
    }

    // Fonction pour supprimer une image
    function removeLocalImage(button) {
        var imageGroup = button.parentElement;
        imageGroup.remove();
    }
	 // Limitation à 5 fichiers pour les logos
	 document.getElementById('local-logo').addEventListener('change', function(e) {
        if (e.target.files.length > 5) {
            alert('Vous ne pouvez télécharger que 5 logos.');
            e.target.value = ''; // Réinitialiser la sélection
        }
    });

    // Limitation à 20 fichiers pour les images
    document.getElementById('local-image').addEventListener('change', function(e) {
        if (e.target.files.length > 20) {
            alert('Vous ne pouvez télécharger que 20 images.');
            e.target.value = ''; // Réinitialiser la sélection
        }
    });

    // Ajouter des champs pour les images supplémentaires
    function addImageInput() {
        var imageContainer = document.getElementById('form-local');
        var newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'local-image[]';
        newInput.classList.add('form-control');
        newInput.accept = 'image/*';
        imageContainer.appendChild(newInput);
        imageContainer.appendChild(document.createElement('br')); // Ajouter une nouvelle ligne après chaque input
    }
</script>
<?php  } ?>
