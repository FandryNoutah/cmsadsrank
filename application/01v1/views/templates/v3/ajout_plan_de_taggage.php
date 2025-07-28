<h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Plan de taggage - Technique </h4>

							<h3></br>Client : <a style="color: #37BC9B"> <?php echo $clients[0]['nom_client'] ?></a> </h3>
                         
                           
							<form action="<?php echo site_url('Googleads/Ajoutplantaggage'); ?>" method="POST" enctype="multipart/form-data">
                                    <div id="annonce-groups">
                                        <div class="annonce-group">
                                        <input type="hidden" name="idclients" class="form-control" value="<?php echo $clients[0]['idclients'] ?>" > <br>
                                        
                                        <label for="description">Conversions</label>
                                        <input type="text" name="conversion" class="form-control" > <br>

                                        <label for="description">Action</label>
                                        <input type="text" name="actions" class="form-control"  > <br>

                                        <label for="description">Types</label>
                                        <input type="text" name="types" class="form-control"> <br>

                                        <label for="description">Remarques</label>
                                        <input type="text" name="remarque" class="form-control" > <br>

                                        <label for="description">Etat</label>
                                        <select name="etat" class="form-control">
                                        <option value="NULL">à défiinir</option>
                                            <option value="1">Implémenté</option>
                                            <option value="2">En attente client</option>
                                            <option value="3">À faire</option>
                                        </select> <br>
                                        <label for="description">Condition</label>
                                        <input type="text" name="conditions" class="form-control" > <br>  

                                        <label for="description">Conversions     ID</label>
                                        <input type="text" name="conversion_id" class="form-control" > <br>

                                        <label for="description">Conversions Label</label>
                                        <input type="text" name="convarsion_label" class="form-control" > <br>
											<button type="submit" class="btn btn-success">Ajouter</button>
											</form>
                                          