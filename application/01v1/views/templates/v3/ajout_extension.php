<h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Ajout extenxion - Technique </h4>
<?php foreach($clients as $D): ?>
							<h3></br>Client : <a style="color: #37BC9B"> <?php echo $D['nom_client'] ?></a> </h3>
                         
                           
							<form action="<?php echo site_url('Googleads/Ajoutextensions'); ?>" method="POST" enctype="multipart/form-data">
                                    <div id="annonce-groups">
                                        <div class="annonce-group">
                                        <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients'] ?>" > <br>
                                        
                                        <label for="description">Extensions d'accroche:</label>
                                        <textarea name="extensions_accroche" class="form-control" rows="3" cols="50"></textarea><br>
                                        <label for="description">Extensions d'extraits de site:</label>
                                        <textarea name="extensions_extrait_site" class="form-control" rows="3" cols="50"></textarea><br>
                                        <label for="description">Extension de lieu:</label>
                                        <textarea name="extensions_lieu" class="form-control" rows="3" cols="50"></textarea><br>
                                        <label for="description">Extension d'appel:</label>
                                        <textarea name="extensions_appel" class="form-control" rows="3" cols="50"></textarea><br>

                                        <div id="extesnion">

                                        <div class="extension">

                                            <label for="extesnion-1">Titre extension :</label>

                                            <input type="text" name="titre_extensions[]" class="form-control"><br>

                                            <label for="extesnion-1">Description extension :</label>

                                            <textarea type="text" name="description_extensions[]" class="form-control"></textarea><br>

                                            <label for="extesnion-keywords">URL extensions :</label>

                                            <input type="text" name="url_extensions[]" class="form-control"><br>

                                       

                                        </div>

                                    </div>

                                    <button type="button" id="add-extension-btn" class="btn btn-primary">Ajouter une extension</button>

                                    <script>

                                        let groupCount = 1; // Nombre initial de groupes d'extensions

                                        // Fonction pour ajouter un nouveau groupe d'extension

                                        document.getElementById('add-extension-btn').addEventListener('click', function() {

                                            groupCount++; // Incrémente le nombre de groupes d'extensions

                                            const groupContainer = document.getElementById('extesnion');

                                            // Créer un nouvel élément de groupe d'extension

                                            const newGroup = document.createElement('div');

                                            newGroup.classList.add('extension');

                                            newGroup.setAttribute('id', 'extesnion-' + groupCount); // ID unique pour chaque extension

                                            // Ajouter un champ de texte pour le titre de l'extension
                                            const newLabel = document.createElement('label');
                                            newLabel.setAttribute('for', 'extesnion-' + groupCount);
                                            newLabel.innerText = 'Titre extension :';
                                            const newInput = document.createElement('input');
                                            newInput.type = 'text';
                                            newInput.name = 'titre_extensions[]'; 
                                            newInput.classList.add('form-control');

                                            // Créer le champ Description extension
                                            const newLabelContext = document.createElement('label');
                                            newLabelContext.setAttribute('for', 'description-extesnion-' + groupCount);
                                            newLabelContext.innerText = 'Description extension :';
                                            const newInputContext = document.createElement('textarea');
                                            newInputContext.type = 'text';
                                            newInputContext.name = 'description_extensions[]'; 
                                            newInputContext.classList.add('form-control');

                                            // Créer le champ URL extension
                                            const newLabelKeywords = document.createElement('label');
                                            newLabelKeywords.setAttribute('for', 'url-extesnion-' + groupCount);
                                            newLabelKeywords.innerText = 'URL extensions :';
                                            const newTextArea = document.createElement('input');
                                            newTextArea.name = 'url_extensions[]'; 
                                            newTextArea.classList.add('form-control');

                                            // Créer le bouton de suppression
                                            const deleteButton = document.createElement('button');
                                            deleteButton.type = 'button';
                                            deleteButton.classList.add('btn', 'btn-danger');
                                            deleteButton.innerText = 'Supprimer';
                                            deleteButton.addEventListener('click', function() {
                                                // Supprimer l'extension lorsque le bouton est cliqué
                                                groupContainer.removeChild(newGroup);
                                            });

                                            // Ajouter les éléments au groupe
                                            newGroup.appendChild(newLabel);
                                            newGroup.appendChild(newInput);
                                            newGroup.appendChild(newLabelContext);
                                            newGroup.appendChild(newInputContext);
                                            newGroup.appendChild(newLabelKeywords);
                                            newGroup.appendChild(newTextArea);
                                            newGroup.appendChild(deleteButton);

                                            // Ajouter l'extension au conteneur
                                            groupContainer.appendChild(newGroup);
                                        });

                                    </script>


											<button type="submit" class="btn btn-success">Ajouter</button>
											</form>
                                            <?php endforeach; ?>