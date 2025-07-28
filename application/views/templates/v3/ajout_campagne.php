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
                <form action="<?php echo site_url('Googleads/Ajout_Campagne'); ?>" method="POST" enctype="multipart/form-data">

                    <?php foreach($donnees as $D){ ?>
                       <h2> Budget Total = <?php $budgetinitiale = $D['budget']; echo $D['budget']; ?> € | Budget utilisé = <?php echo $budjet_restant; ?> € | Budget restant = <?php $budjet_restants = $budgetinitiale - $budjet_restant;  echo $budjet_restants; ?> €</h2>
                     <?php } ?>   
                     <input type="hidden" name="idclient" class="form-control" value="<?php echo $C['idclients']; ?>">
                     <div class="form-group">
                     <div class="form-group">
                                    <label for="product-choice">Choisir un type de campagne</label>
                                    <select id="product-choice" class="form-control" onchange="showForm()" name="type_de_campagne">
                                        <option value="0">Séléctionner type de campagne</option>
                                        <option value="1">Search</option>
                                        <option value="2">Local</option>
                                        <option value="3">Pmax</option>
                                    </select>
                                </div>
                                        

                                <!-- Formulaire dynamique -->
                                

                                <!-- Formulaire Search -->
                                <div id="form-search" class="dynamic-form" style="display:none;">
                                    <h3>Search</h3>
                                    <label for="search-name">Nom campagne (Search) :</label>
                                    <input type="text" id="search-name" name="nom_campagne_search" value="<?php echo $C['nom_client']; ?> - Search" class="form-control"><br>
                                           
                                                <label>Information Campagne</label>
                                                <textarea name="information_campagne_search" class="form-control"></textarea><br>
                                                <div class="form-group">
                                    
                                            </div> 
                                    
                                    <label>Zone</label>
                                        <input type="text" name="zone_search" class="form-control">


                                        <label for="local-name">Répartition budget :</label>
                                            <input type="text" name="repartition_budget_search" class="form-control" ><br>
                                         
                                    <div class="form-group">
                                        <label>Calendrier</label>
                                        <input type="text" name="date_campagne" class="form-control" value="7J/7, 24h/24">
                                    </div>
                                    <div class="form-group">
                                        <label>Appareils</label>
                                        <select name="appareil_search" class="form-control">
                                            <option value="Ordinateur / Mobile / Tablette">Ordinateur / Mobile / Tablette</option>
                                            <option value="Ordinateur">Ordinateur</option>
                                            <option value="Mobile">Mobile</option>
                                            <option value="Tablette">Tablette</option>
                                            <option value="Ordinateur / Mobile">Ordinateur / Mobile</option>
                                            <option value="Ordinateur / Tablette">Ordinateur / Tablette</option>
                                            <option value="Mobile / Tablette">Mobile / Tablette</option>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Objectif</label>
                                        <select name="objectif" class="form-control">
                                            <option value="Lead">Lead</option>
                                            <option value="Vente">Vente</option>
                                        </select>
                                    </div>

                                  

                                    
                                            <label for="group-url">URL :</label>
                                            <input type="text" name="url_campagne" class="form-control" ><br>


                                            <div id="groupes-annonces">
                                            <div class="groupe-annonce">
                                                <label for="groupe-annonce-1">Groupe d'annonce :</label>
                                                <input type="text" name="groupe_annonce[]" class="form-control"><br>
                                                <label for="groupe-annonce-1">Contexte Groupe d'annonce :</label>
                                                <input type="text" name="contexte_groupe_annonce[]" class="form-control"><br>
                                                <label for="group-keywords">Mot clé :</label>
                                                <textarea name="Mot_cle[]" class="form-control" rows="10" cols="50"></textarea><br>

                                            </div>
                                        </div>

                                        <button type="button" id="add-group-btn" class="btn btn-primary" style="width: 250px; height: 41px; margin-left: 10px; background-color: #4EA5FE; color: white !important; border-radius: 20px; border-color: #4EA5FE">Ajouter un groupe d'annonce</button>

                                        <script>
                                            let groupCount = 1; // Nombre initial de groupes d'annonces

                                            // Fonction pour ajouter un nouveau groupe d'annonce
                                            document.getElementById('add-group-btn').addEventListener('click', function() {
                                                groupCount++; // Incrémente le nombre de groupes d'annonces
                                                const groupContainer = document.getElementById('groupes-annonces');

                                                // Créer un nouvel élément de groupe d'annonce
                                                const newGroup = document.createElement('div');
                                                newGroup.classList.add('groupe-annonce');
                                                newGroup.setAttribute('id', 'groupe-annonce-' + groupCount); // ID unique pour chaque groupe d'annonce
                                                
                                                // Ajouter un champ de texte pour le groupe d'annonce
                                                const newLabel = document.createElement('label');
                                                newLabel.setAttribute('for', 'groupe-annonce-' + groupCount);
                                                newLabel.innerText = 'Groupe d\'annonce :';

                                                const newInput = document.createElement('input');
                                                newInput.type = 'text';
                                                newInput.name = 'groupe_annonce[]'; // Utilisez [] pour que PHP traite cela comme un tableau
                                                newInput.classList.add('form-control');

                                                // Créer le champ Contexte Groupe d'annonce
                                                const newLabelContext = document.createElement('label');
                                                newLabelContext.setAttribute('for', 'contexte-groupe-annonce-' + groupCount);
                                                newLabelContext.innerText = 'Contexte Groupe d\'annonce :';

                                                const newInputContext = document.createElement('input');
                                                newInputContext.type = 'text';
                                                newInputContext.name = 'contexte_groupe_annonce[]'; // Utilisez [] pour que PHP traite cela comme un tableau
                                                newInputContext.classList.add('form-control');

                                                // Créer le champ Mot clé
                                                const newLabelKeywords = document.createElement('label');
                                                newLabelKeywords.setAttribute('for', 'mot-cle-' + groupCount);
                                                newLabelKeywords.innerText = 'Mot clé :';

                                                const newTextArea = document.createElement('textarea');
                                                newTextArea.name = 'Mot_cle[]'; // Utilisez [] pour que PHP traite cela comme un tableau
                                                newTextArea.classList.add('form-control');

                                                // Créer le bouton de suppression
                                                const deleteButton = document.createElement('button');
                                                deleteButton.type = 'button';
                                                deleteButton.classList.add('btn', 'btn-danger');
                                                deleteButton.innerText = 'Supprimer';
                                                deleteButton.addEventListener('click', function() {
                                                    // Supprimer le groupe d'annonce lorsque le bouton est cliqué
                                                    groupContainer.removeChild(newGroup);
                                                });

                                                // Ajouter le label et le champ de texte pour le groupe d'annonce
                                                newGroup.appendChild(newLabel);
                                                newGroup.appendChild(newInput);
                                                
                                                // Ajouter le label et le champ de texte pour le contexte du groupe d'annonce
                                                newGroup.appendChild(newLabelContext);
                                                newGroup.appendChild(newInputContext);

                                                // Ajouter le label et le champ de texte pour le mot clé
                                                newGroup.appendChild(newLabelKeywords);
                                                newGroup.appendChild(newTextArea);

                                                // Ajouter le bouton de suppression
                                                newGroup.appendChild(deleteButton);

                                                // Ajouter le groupe d'annonce au conteneur des groupes d'annonces
                                                groupContainer.appendChild(newGroup);
                                            });
                                        </script>


                                      

                                        </div>
                                    </div>
                                    
                                </div>
                              <script>
                                let groupCount = 1; // Nombre initial de groupes d'annonces

                            // Fonction pour ajouter un nouveau groupe d'annonce
                            document.getElementById('add-group-btn').addEventListener('click', function() {
                                groupCount++; // Incrémente le nombre de groupes d'annonces
                                const groupContainer = document.getElementById('groupes-annonces');

                                // Créer un nouvel élément de groupe d'annonce
                                const newGroup = document.createElement('div');
                                newGroup.classList.add('groupe-annonce');
                                newGroup.setAttribute('id', 'groupe-annonce-' + groupCount); // ID unique pour chaque groupe d'annonce
                                
                                // Ajouter un champ de texte pour le nouveau groupe d'annonce
                                const newLabel = document.createElement('label');
                                newLabel.setAttribute('for', 'groupe-annonce-' + groupCount);
                                newLabel.innerText = 'Groupe d\'annonce :';

                                const newInput = document.createElement('input');
                                newInput.type = 'text';
                                newInput.name = 'groupe_annonce[]'; // Utilisez [] pour que PHP traite cela comme un tableau
                                newInput.classList.add('form-control');

                                // Créer le champ Contexte Groupe d'annonce
                                const newLabelContext = document.createElement('label');
                                newLabelContext.setAttribute('for', 'contexte-groupe-annonce-' + groupCount);
                                newLabelContext.innerText = 'Contexte Groupe d\'annonce :';

                                const newInputContext = document.createElement('input');
                                newInputContext.type = 'text';
                                newInputContext.name = 'contexte_groupe_annonce[]'; // Utilisez [] pour que PHP traite cela comme un tableau
                                newInputContext.classList.add('form-control');

                                // Créer le bouton de suppression
                                const deleteButton = document.createElement('button');
                                deleteButton.type = 'button';
                                deleteButton.classList.add('btn', 'btn-danger');
                                deleteButton.innerText = 'Supprimer';
                                deleteButton.addEventListener('click', function() {
                                    // Supprimer le groupe d'annonce lorsque le bouton est cliqué
                                    groupContainer.removeChild(newGroup);
                                });

                                // Ajouter le label, le champ de texte pour le groupe d'annonce
                                newGroup.appendChild(newLabel);
                                newGroup.appendChild(newInput);
                                
                                // Ajouter le label et le champ de texte pour le contexte du groupe d'annonce
                                newGroup.appendChild(newLabelContext);
                                newGroup.appendChild(newInputContext);

                                // Ajouter le bouton de suppression
                                newGroup.appendChild(deleteButton);

                                // Ajouter le groupe d'annonce au conteneur des groupes d'annonces
                                groupContainer.appendChild(newGroup);
                            });

                            </script>

                        <!-- Formulaire Local -->
                         <div style="margin-left: 25px;">
                            <div id="form-local" class="dynamic-form" style="display:none;">
                                <h3>Local</h3>

                                <label for="search-name">Nom campagne (Local) :</label>
                            <input type="text" id="search-name" name="nom_campagne_local" value="<?php echo $C['nom_client']; ?> - Local" class="form-control"><br>

                                                <label>Information Campagne</label>
                                                <textarea type="text" name="information_campagne_local" class="form-control"></textarea><br>
                                                <div class="form-group">
                                              
                                            </div> 
                                    
                                    <label>Zone</label>
                                        <input type="text" name="zone_Local" class="form-control">
                                        <label for="local-name">Répartition budget :</label>
                                            <input type="text" name="repartition_budget_local" class="form-control" ><br>
                                         
                                    <div class="form-group">
                                        <label>Calendrier</label>
                                        <input type="text" name="date_campagne_local" class="form-control" value="7J/7, 24h/24">
                                    </div>

                                <div class="form-group">
                                    <label>Appareils</label>
                                    <select name="appareil_local" class="form-control">
                                    <option value="Ordinateur / Mobile / Tablette">Ordinateur / Mobile / Tablette</option>
                                        <option value="Ordinateur">Ordinateur</option>
                                        <option value="Mobile">Mobile</option>
                                        <option value="Tablette">Tablette</option>
                                        <option value="Ordinateur / Mobile">Ordinateur / Mobile</option>
                                        <option value="Ordinateur / Tablette">Ordinateur / Tablette</option>
                                        <option value="Mobile / Tablette">Mobile / Tablette</option>
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Objectif</label>
                                    <select name="objectif_local" class="form-control">
                                        <option value="Lead">Lead</option>
                                        <option value="Vente">Vente</option>
                                    </select>
                                </div>

                                <label for="group-url">URL :</label>
                                <input type="text" name="url_campagne_local" class="form-control"><br>

                                <label for="group-url">Nom groupe annonce Local :</label>
                                <input type="text" name="nom_groupe_local" class="form-control" ><br>

                                <label for="group-url">Contexte groupe annonce Local :</label>
                                <input type="text" name="contexte_groupe_local" class="form-control" ><br>

                                <label for="group-keywords">Mot clé :</label>
                                <textarea name="Mot_cle_local" class="form-control" rows="10" cols="50"></textarea><br>

                                <!-- Section dynamique des groupes d'annonces -->
                                
                                
                            </div>

                          


</div>
						</div>

                        <!-- Formulaire Pmax -->
                        <div style="margin-left: 25px;">
                        <div id="form-pmax" class="dynamic-form" style="display:none;">
                            <h3>Pmax</h3>
                            <label for="search-name">Nom campagne (PMax) :</label>
                            <input type="text" id="search-name" name="nom_campagne_pmax" value="<?php echo $C['nom_client']; ?> - PMax" class="form-control"><br>

                                                <label>Information Campagne</label>
                                                <textarea type="text" name="information_campagne_pmax" class="form-control"></textarea><br>
                                                <div class="form-group">
                                                <label>Contexte client</label>
                                                <textarea type="text" name="contextes_client_pmax" class="form-control"></textarea>
                                            </div> 
                                    
                                    <label>Zone</label>
                                        <input type="text" name="zone_pmax" class="form-control">


                                        <label for="local-name">Répartition budget :</label>
                                            <input type="text" name="repartition_budget_pmax" class="form-control" ><br>
                                         
                                    <div class="form-group">
                                        <label>Calendrier</label>
                                        <input type="text" name="date_campagne_pmax" class="form-control" value="7J/7, 24h/24">
                                    </div>
                                    <div class="form-group">
                                        <label>Appareils</label>
                                        <select name="appareil_pmax" class="form-control">
                                        <option value="Ordinateur / Mobile / Tablette">Ordinateur / Mobile / Tablette</option>
                                            <option value="Ordinateur">Ordinateur</option>
                                            <option value="Mobile">Mobile</option>
                                            <option value="Tablette">Tablette</option>
                                            <option value="Ordinateur / Mobile">Ordinateur / Mobile</option>
                                            <option value="Ordinateur / Tablette">Ordinateur / Tablette</option>
                                            <option value="Mobile / Tablette">Mobile / Tablette</option>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Objectif</label>
                                        <select name="objectif_pmax" class="form-control">
                                            <option value="Lead">Lead</option>
                                            <option value="Vente">Vente</option>
                                        </select>
                                    </div>
                                    
                                     <div class="form-group">
                                            <label>Type client</label>
                                            <select id="choix" name="choix">
                                                <option value="lead">Lead</option>
                                                <option value="ecommerce">E-commerce</option>
                                                <option value="reservation">Réservation</option>
                                            </select>
                                              </div>
                                         
                                            <label for="group-url">URL :</label>
                                            <input type="text" name="url_campagne_pmax" class="form-control" ><br>
                                            <label for="group-url">Nom groupe annonce PMax :</label>
                                            <input type="text" name="nom_groupe_pmax" class="form-control" ><br>

                                            <label for="group-keywords">Mot clé :</label>
                                            <textarea name="Mot_cle_pmax" class="form-control" rows="10" cols="100"></textarea><br>
                                            
                                        </div>
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


                      

                        <button type="submit" class="btn btn-success" style="background-color: #4EA5FE">Ajouter</button>
                    </form>
                    </div>
                    </div>
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

</script>

<?php } ?>