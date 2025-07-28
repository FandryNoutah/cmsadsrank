<h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Ajout Groupe d'annonces - Technique </h4>
<?php foreach($campagne as $D): ?>
							<h3></br>Campagne client : <a style="color: #37BC9B"> <?php echo $D['nom_campagne'] ?></a> </h3>
                         
                            <?php endforeach; ?>
							<form action="<?php echo site_url('Googleads/Ajoutgroupe'); ?>" method="POST" enctype="multipart/form-data">
                                    <div id="annonce-groups">
                                        <div class="annonce-group">
                                        <input type="hidden" name="idcampagne" class="form-control" value="<?php echo $D['idcampagne']; ?>" > <br>
                                        <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>" > <br>
                                        <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagne']; ?>" > <br>
                                            <label for="group-name">Nom du groupe :</label>
                                            <input type="text" name="nom_groupe" class="form-control" ><br>

                                            
                                        <label for="titre">Titre 1:</label>
                                        <textarea name="titre1" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 2:</label>
                                        <textarea name="titre2" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 3:</label>
                                        <textarea name="titre3" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 4:</label>
                                        <textarea name="titre4" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 5:</label>
                                        <textarea name="titre5" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 6:</label>
                                        <textarea name="titre6" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 7:</label>
                                        <textarea name="titre7" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 8:</label>
                                        <textarea name="titre8" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 9:</label>
                                        <textarea name="titre9" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 10:</label>
                                        <textarea name="titre10" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 11:</label>
                                        <textarea name="titre11" class="form-control" ></textarea><br>
                                        <label for="titre">Titre 12:</label>
                                        <textarea name="titre12" class="form-control" ></textarea><br>



                                        <label for="description">Description 1:</label>
                                                <textarea name="description1" class="form-control" ></textarea><br>

                                                <label for="description">Description 2:</label>
                                                <textarea name="description2" class="form-control" ></textarea><br>

                                                <label for="description">Description 3:</label>
                                                <textarea name="description3" class="form-control" ></textarea><br>

                                                <label for="description">Description 4:</label>
                                                <textarea name="description4" class="form-control" ></textarea><br>

                                                <label for="path">Chemin 1 :</label>
                                                <input type="text" name="chemin1" class="form-control" ><br>

                                                <label for="path">Chemin 2 :</label>
                                                <input type="text" name="chemin2" class="form-control" ><br>

                                                <label for="url">URL :</label>
                                                <input type="text" name="url" class="form-control" ><br>

                                                <label for="keywords">Mot clé :</label>
                                                <textarea name="mot_cle" class="form-control" ></textarea><br>


											<button type="submit" class="btn btn-success">Ajouter</button>
											</form>
                                            