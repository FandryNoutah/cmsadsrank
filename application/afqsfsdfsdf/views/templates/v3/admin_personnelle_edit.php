<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Editer Personnelle</h4>
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
				<?php foreach($personnelle as $C){ ?>
				<form method="post" >
                      
						
						<div class="row">
							
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Nom :</label>
                                        <input class="form-control" type="text" name="Nom" value="<?php echo $C['Nom']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Prenom :</label>
                                        <input class="form-control" type="text" name="Prenom" value="<?php echo $C['Prenom']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Matricule :</label>
                                        <input class="form-control" type="text" name="Matricule" value="<?php echo $C['Matricule']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Societe :</label>
                                        <input class="form-control" type="text" name="Societe" value="<?php echo $C['Societe']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Direction :</label>
                                        <input class="form-control" type="text" name="Direction" value="<?php echo $C['Direction']; ?>"/>
                                    </div>
                                    
                            </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Ramassage remisage :</label>
                                        <input class="form-control" type="text" name="Ramassage_remisage" value="<?php echo $C['Ramassage_remisage']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Adresse exacte :</label>
                                        <input class="form-control" type="text" name="Adresse_exacte" value="<?php echo $C['Adresse_exacte']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Contact :</label>
                                        <input class="form-control" type="text" name="Contact" value="<?php echo $C['Contact']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Lieu de travail :</label>
                                        <input class="form-control" type="text" name="Lieu_de_travail" value="<?php echo $C['Lieu_de_travail']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">OBS :</label>
                                        <input class="form-control" type="text" name="OBS" value="<?php echo $C['OBS']; ?>"/>
                                    </div>
                                    
                            </div>
							
						<div class="form-actions right">
							
                            <input class="btn btn-warning mr-1" type="submit" name="update" value="Update Personnelle"/>
                            <input type="reset" class="btn btn-primary"  value="Reset" />
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