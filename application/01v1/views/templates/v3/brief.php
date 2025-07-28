<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Brief campagne Google Ads</h4>
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
				<form action="<?php echo site_url('Googleads/updateDonneeClient'); ?>" method="POST">
				<?php foreach($client as $C){ ?>
					<?php foreach($donnees as $D){ ?>
						<input class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
						<input class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
                      
						
					
							
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Client : <?php echo $C['nom_client']; ?></label>
                                       
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Logo client :</label>
                                        <input class="form-control" type="file" name="Email_client" />
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">URL du site : </label>
										<input class="form-control" type="text" name="Numero_client"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Secteur d'activité:</label>
                                        <input class="form-control" type="text" name="Numero_client"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Objectif campagne :</label>
                                        <input class="form-control" type="text" name="Numero_client"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Budget Total  :</label>
                                        <input class="form-control" type="text" name="Numero_client"/>
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
										<option value="<?php echo htmlspecialchars($p['idinitiative']); ?>">
											<?php echo htmlspecialchars($p['nominitiative']); ?> (Actuellement)
										</option>
									<?php endforeach; ?>
									<?php foreach ($initiative as $d): ?>
										<option value="<?php echo htmlspecialchars($d->idinitiative); ?>">
											<?php echo htmlspecialchars($d->nominitiative); ?>
										</option>
									<?php endforeach; ?>
								</select>
								</div>
								<div class="form-group">
								  <label for="exampleInputEmail1">Accoount manager</label>
								 <select name="Am" id="product-choice">
								 <?php foreach ($idam as $p): ?>
										<option value="<?php echo htmlspecialchars($p['idam']); ?>">
											<?php echo htmlspecialchars($p['nomam']); ?> (Actuellement)
										</option>
									<?php endforeach; ?>
									<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
									<?php foreach ($am as $d): ?>
										<option value="<?php echo htmlspecialchars($d->idam); ?>">
											<?php echo htmlspecialchars($d->nomam); ?>
										</option>
									<?php endforeach; ?>
								</select>
								</div>
							
							
						<div class="form-actions right">
							
                            <input class="btn btn-warning mr-1" type="submit" name="update" value="Enregister"/>

                        </div>
                    </form>
				
			</div>
			<?php  }}?>
		
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

    
