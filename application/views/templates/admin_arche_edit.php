
<form action="<?php echo site_url('Googleads/updateDonneeClient'); ?>" method="POST">
    <?php foreach($client as $C): ?>
        <?php foreach($donnee as $D): ?>
        Client :  <?php echo $C['nom_client']; ?>
         <div class="mb-3">
														<label class="form-label">Client </label>
														<input  class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
                                                        <input  class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
                                                        <label class="form-label">Nom </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="client" value="<?php echo $C['nom_client']; ?>"  />
													</div>
													
													<div class="mb-3">
														<label class="form-label">Email </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="email_client" value="<?php echo $C['email_client']; ?>"  />
													</div>
													<div class="mb-3">
														<label class="form-label">Numéro </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="numero_client" value="<?php echo $C['numero_client']; ?>"  />
													</div>
													<div class="mb-3">
														<label class="form-label">Site </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="site_client" value="<?php echo $C['site_client']; ?>" />
													</div>
													<div class="mb-3">
														<label class="form-label">Budjet </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="budget" value="<?php echo $D['budget']; ?>" €/>
													</div>
													<div class="mb-3">
														<label class="form-label">Budjet </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="budget" value="<?php echo $D['budget']; ?>" €/>
													</div>
													<div class="mb-3">
														<label class="form-label">Budjet </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="budget" value="<?php echo $D['budget']; ?>" €/>
													</div>
													<div class="mb-3">
														<label class="form-label">Budjet </label>
														<input style="border-radius: 28px;" class="form-control" type="text" name="budget" value="<?php echo $D['budget']; ?>" €/>
													</div>
													
													<div class="form-group">
														<button style="border-radius: 28px;" type="submit"  class="form-control btn btn-primary submit px-3">Modifier</button>
													</div>
        <?php endforeach; ?>
        <?php endforeach; ?>
        </div>	
    </form>

