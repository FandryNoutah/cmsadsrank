<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Editer Car</h4>
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
				<?php foreach($car as $C){ ?>
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
                                        <label for="fname">Nombre place :</label>
                                        <input class="form-control" type="text" name="Nombre_place" value="<?php echo $C['Nombre_place']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Prix jour :</label>
                                        <input class="form-control" type="text" name="Prix_jour" value="<?php echo $C['Prix_jour']; ?>"/>
                                    </div>
                                    
                            </div><div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Prestataire :</label>
                                        <input class="form-control" type="text" name="Prestataire" value="<?php echo $C['Prestataire']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Nom chauffeur :</label>
                                        <input class="form-control" type="text" name="Nom_chauffeur" value="<?php echo $C['Nom_chauffeur']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Numero voiture :</label>
                                        <input class="form-control" type="text" name="Numero_voiture" value="<?php echo $C['Numero_voiture']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Numero voiture :</label>
                                        <input class="form-control" type="text" name="Numero_voiture" value="<?php echo $C['Numero_voiture']; ?>"/>
                                    </div>
                                    
                            </div>
							<div class="row">
							<div class="col-md-3">
								<div class="form-group">
                                        <label  for="fname">Marque :</label>
                                        <input class="form-control"  type="text" name="Marque" value="<?php echo $C['Marque']; ?>"/>
                                    </div>
                                   </div>  
                            </div>
							
						<div class="form-actions right">
							
                            <input class="btn btn-warning mr-1" type="submit" name="update" value="Update Car"/>
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