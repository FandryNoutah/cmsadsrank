<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Modifier client</h4>
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

				<div class="card-text"></div>
				<!--
				<div id="infoMessage"><?php //echo $message;?></div>
				
				-->
				<form action="<?php echo site_url('Googleads/updateDonneeClient'); ?>" method="POST" enctype="multipart/form-data">
				<?php foreach($client as $C){ ?>
					<?php foreach($donnees as $D){ ?>
						<input class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
						<input class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
                      
						
						<div class="row">
							
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Nom :</label>
                                        <input class="form-control" type="text" name="Client" value="<?php echo $C['nom_client']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Email :</label>
                                        <input class="form-control" type="text" name="Email_client" value="<?php echo $C['email_client']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Numéro:</label>
                                        <input class="form-control" type="text" name="Numero_client" value="<?php echo $C['numero_client']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Site client :</label>
                                        <input class="form-control" type="text" name="Site_client" value="<?php echo $C['site_client']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Budget :</label>
                                        <input class="form-control" type="text" name="budget" value="<?php echo $D['budget']; ?>"/> 
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Sécteur d'activité :</label>
                                        <input class="form-control" type="text" name="secteur_activite" value="<?php echo $D['secteur_activite']; ?>"/> 
                                    </div>
                                    
                            </div>
							<div class="col-md-15"> 
							<div class="form-group">
                                        <label for="fname">Commentaire client:</label>
                                        <textarea class="form-control" type="text" name="commentaire_client"><?php echo $D['commentaire_client']; ?></textarea>
                                    </div>
									</div>
							</div><div class="form-group">
								  <label for="exampleInputEmail1">Produit</label>
								 <select name="Produit" id="product-choice">
									<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
									<?php foreach ($produitbyid as $p): ?>
										<option value="<?php echo htmlspecialchars($p['idproduit']); ?>">
											<?php echo htmlspecialchars($p['label_produit']); ?> (Actuellement)
										</option>
									<?php endforeach; ?>
									<?php foreach ($produit as $d): ?>
										<option value="<?php echo htmlspecialchars($d->idproduit); ?>">
											<?php echo htmlspecialchars($d->label_produit); ?>
										</option>
									<?php endforeach; ?>
								</select>
								</div>
								<div class="form-group">
								  <label for="exampleInputEmail1">Initiative</label>
								 <select name="Initiative" id="product-choice">
									<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
									<?php foreach ($idinitiative as $p): ?>
										<option value="<?php echo htmlspecialchars($p['id']); ?>">
											<?php echo htmlspecialchars($p['first_name']); ?> <?php echo htmlspecialchars($p['last_name']); ?> (Actuellement)
										</option>
									<?php endforeach; ?>
									<?php foreach ($users as $d): ?>
										<option value="<?php echo htmlspecialchars($d->id); ?>">
											<?php echo htmlspecialchars($d->first_name); ?> 
										</option>
									<?php endforeach; ?>
								</select>
								</div>

								<div class="form-group">
								  <label for="exampleInputEmail1">Accoount manager</label>
								 <select name="Am" id="product-choice">
								 <?php foreach ($idam as $p): 
									
									?>
										<option value="<?php echo htmlspecialchars($p['id']); ?>">
											<?php echo htmlspecialchars($p['first_name']); ?> <?php echo htmlspecialchars($p['last_name']); ?> (Actuellement)
										</option>
									<?php endforeach; ?>
									<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
									<?php foreach ($users as $d): ?>
										<option value="<?php echo htmlspecialchars($d->id); ?>">
											<?php echo htmlspecialchars($d->first_name); ?>
										</option>
									<?php endforeach; ?>
								</select>
								</div>
							
							<div class="row">
							<div class="col-md-3">
								<div class="form-group">
                                        <label  for="fname">Mis en place  paiement :</label>
                                        <input class="form-control"  type="date" name="mis_en_place_paiement" value="<?php echo $D['mis_en_place_paiement']; ?>"/>
                                    </div>
                                  
                            </div>
							<div class="col-md-3">
								<div class="form-group">
                                        <label  for="fname">Brief :</label>
                                        <input class="form-control"  type="date" name="Brief" value="<?php echo $D['Brief']; ?>"/>
                                    </div>
                                   
                            </div>
							<div class="col-md-3">
								<div class="form-group">
                                        <label  for="fname">Date de mis en ligne :</label>
                                        <input class="form-control"  type="date" name="annonce" value="<?php echo $D['annonce']; ?>"/>
                                    </div>
                                  
                            </div>
						  </div>
						  <div class="row">
						  <div class="col-md-3">
								<div class="form-group">
								  <label for="exampleInputEmail1">Paiement reçu</label>
								 <select name="paiement_recu" id="product-choice">
										<option value="<?php echo htmlspecialchars($D['paiement_recu']); ?>">
											 <?php if($D['paiement_recu'] == 0): ?>
											Non (Actuellement)
										<?php endif; ?>
										<?php if($D['paiement_recu'] == 1): ?>
											Oui (Actuellement)
										<?php endif; ?>
										</option>
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
								</div>
                            </div>
                            
                             <div class="col-md-3">
								<div class="form-group">
								  <label for="exampleInputEmail1">Email Onboarding</label>
								 <select name="email_onboarding" id="product-choice">
										<option value="<?php echo htmlspecialchars($D['email_onboarding']); ?>">
											 <?php if($D['email_onboarding'] == 0): ?>
											Non (Actuellement)
										<?php endif; ?>
										<?php if($D['email_onboarding'] == 1): ?>
											Oui (Actuellement)
										<?php endif; ?>
										</option>
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
								</div>
                            </div>
                             <div class="col-md-3">
								<div class="form-group">
								  <label for="exampleInputEmail1">Facturation</label>
								 <select name="facturation" id="product-choice">
										<option value="<?php echo htmlspecialchars($D['facturation']); ?>">
											 <?php if($D['facturation'] == 0): ?>
											Non (Actuellement)
										<?php endif; ?>
										<?php if($D['facturation'] == 1): ?>
											Oui (Actuellement)
										<?php endif; ?>
										</option>
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
								</div>
                            </div>
						</div>	
						  <h4>Technique</h4>
						   <div class="col-md-3">
								<div class="form-group">
								  <label for="exampleInputEmail1">DataStudio</label>
								 <select name="datastudio" id="product-choice">
										<option value="<?php echo htmlspecialchars($D['datastudio']); ?>">
											 <?php if($D['datastudio'] == 0): ?>
											Non (Actuellement)
										<?php endif; ?>
										<?php if($D['datastudio'] == 1): ?>
											Oui (Actuellement)
										<?php endif; ?>
										</option>
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
								</div>
                            </div>   
						<div class="form-actions right">
						  
							 
                            <input class="btn btn-warning mr-1" type="submit" name="update" style="margin-top: 50px;margin-left: 20px; width: 180px; height: 41px; background-color: #29A07B;color: white;  border-radius: 20px;" value="Enregister"/>

                        </div>
                    </form>
				
			</div>
			<?php  }}?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$("#enableFileUpdate").click(function() {
			if($(this).is(":checked")) {
				$("input#logo").removeAttr("disabled");
				$("input#logo").show();
			} else {
				$("input#logo").attr("disabled", "disabled");
				$("input#logo").hide();
			}
		});
	});
</script>

    
