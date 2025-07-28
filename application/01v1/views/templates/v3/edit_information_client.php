<?php  foreach($donnees as $D){ ?>
<div class="col-md-13">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Modifier information client <?php echo $D->nom_client; ?></h4>
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

				
				<!--
				<div id="infoMessage"><?php //echo $message;?></div>
				
				-->
				<form action="<?php echo site_url('Googleads/updateinformationClient'); ?>" method="POST" enctype="multipart/form-data">
					
						<input class="form-control" type="hidden" name="idonnee" value="<?php echo $D->idonnee; ?>"/>
                      
						<div class="col-md-13"> 
						<?php  foreach($clients as $C): ?>
							<div class="form-group">
							<label for="exampleInputEmail1">Logo client </label>
							<input type="file" class="form-control" id="logo" aria-describedby="emailHelp" name="logo" value="<?php echo $D->logo_client; ?>" accept=".jpg, .jpeg, .png">

							<img class="media-object" src="<?php echo base_url($D->logo_client); ?>" 
								title="<?php echo $D->logo_client; ?>" alt="<?php echo $D->logo_client; ?>" 
								style="width: 50px;height: 50px;" />
						</div>
						</div>
						<?php endforeach; ?>

							<div class="col-md-13">                                
                                    <div class="form-group">
                                        <label for="fname">Sécteur d'activité :</label>
                                        <input class="form-control" type="text" name="secteur_activite" value="<?php echo $D->secteur_activite; ?>"/> 
                                    </div>
                                    
                            </div>
                            <div class="col-md-13">                                
								<div class="form-group">
									<label for="fname">Information Client :</label>
									<textarea class="form-control" name="information_client" rows="8" cols="50"><?php echo $D->information_client; ?></textarea>
								</div>
							</div>

							<div class="col-md-13">                                
								<div class="form-group">
									<label for="fname">Contexte Client :</label>
									<textarea class="form-control" name="contexte_client" rows="8" cols="50"><?php echo $D->contexte_client; ?></textarea>
								</div>
							</div>

							<div class="col-md-13">                                
								<div class="form-group">
									<label for="fname">Tracking GTM :</label>
									<textarea class="form-control" name="tracking_gtm" ><?php echo $D->tracking_gtm; ?></textarea>
								</div>
							</div>

							<div class="col-md-13">                                
								<div class="form-group">
									<label for="fname">Plan de taggage :</label>
									<textarea class="form-control" name="commentaire" rows="8" cols="50"><?php echo $D->commentaire; ?></textarea>
								</div>
							</div>

							<div class="col-md-13">                                
								<div class="form-group">
									<label for="fname">Information complémentaire :</label>
									<textarea class="form-control" name="information_complementaire" rows="5" cols="50"><?php echo $D->information_complementaire; ?></textarea>
								</div>
							</div>


							
						<div class="form-actions right">
							
                            <input class="btn btn-warning mr-1" type="submit" name="update" value="Enregister"/>

                        </div>
                    </form>
				
			</div>
			<?php  }?>
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

    
