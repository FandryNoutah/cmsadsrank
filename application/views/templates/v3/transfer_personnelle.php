<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Tranfert Personnelle</h4>
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
				<?php foreach($detail_Personnelle as $P){ ?>
				<h3 style="color = red;"> Tranferer <h1><?php echo $P['Nom'];?> <?php echo $P['Prenom'];?></h1>
				<h3> Matricule: <?php echo $P['Matricule'];?> </h3>
				<h3> Societe:  <?php echo $P['Societe'];?></h3>
				<h3> Direction:  <?php echo $P['Direction'];?></h3>
				<h3> Ligne:  <?php echo $P['Ligne'];?></h3>
				<h3> Contact:  <?php echo $P['Contact'];?></h3>
				<h3> Lieu_de_travail:  <?php echo $P['Lieu_de_travail'];?></h3>
				
				
				
				
		
				
				<form method="post" >
				
					 	
						<div class="row">
							
							<div class="col-md-6">                                
                                    <div class="form-group">
										<h3> Dans: </h3>
                                      
										<h3> Veuiller selection le Car </h3>	
										<input type="hidden" value="<?php echo $P['id_personnelle'];?>" name="id_personnelle"></input>
										<h1><select name="Nom_Car" >
										<?php foreach($liste_car as $C){ ?>
                                        <option value="<?php echo $C['Nom']; ?>"> <?php echo $C['Nom']; ?> </option> 
										<?php  }?>   
										</select></h1>
                                    </div>
                               
                            </div>
							
						<div class="form-actions right">
							
                            <input class="btn btn-warning mr-1" type="submit" name="transferer" value="TRANSFERER"/>
                            
                        </div>
                    </form>
				<?php  }?>
			</div>
			
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