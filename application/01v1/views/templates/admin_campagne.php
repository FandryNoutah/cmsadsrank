<?php //datadump($campagnes); ?>
<style>
.validation_error {
	color: red;
	font-style: italic;
	font-size: 11px;
}
</style>
<section id="using-labels-badges">
	<div class="row">
		<div class="col-xs-12">
			<h4>Campagnes</h4>
			<hr>
		</div>
	</div>
	<div class="row match-height">
		<div class="col-lg-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Liste</h4>
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
					
						<div class="btnControls">
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inlineForm">
								<i class="icon-check2"></i> Ajouter
							</button>
						</div>
						
						<!-- Modal -->
						<div class="modal fade text-xs-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
										<h2 class="modal-title text-text-bold-600" id="myModalLabel33">Ajouter</h2>
									</div>
									
									<form id="addCampagne" action="<?php echo base_url("campagne/add") ?>" method="post">
									  <div class="modal-body">
										<div class="form-group">
											<label for="panneau_campagne_nom">Nom campagne <span class="validation_error panneau_campagne_nom__error"></span></label>
											<div class="position-relative has-icon-left">
												<?php echo form_input($panneau_campagne_nom, '', ''); ?>
												<div class="form-control-position">
													<i class="icon-file2"></i>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label for="panneau_campagne_date_lancement">Date de lancement <span class="validation_error panneau_campagne_date_lancement__error"></span></label>
											<div class="position-relative has-icon-left">
												<?php echo form_input($panneau_campagne_date_lancement, '', ''); ?>
												<div class="form-control-position">
													<i class="icon-calendar5"></i>
												</div>
											</div>
										</div>

										
									  </div>
									  
									  <div class="modal-footer">
										<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="Fermer">
										<input type="submit" class="btn btn-outline-primary btn-lg" value="Ajouter">
									  </div>
									</form>
								</div>
							</div>
						</div>

						<ul class="list-group">
							<?php foreach($campagnes as $key => $campagne): $id = $campagne['id'] ?>
							<li class="list-group-item row__<?= $id ?>">
								<a href="#" data-edit="<?= $id ?>" class="edit" data-toggle="modal" data-target="#inlineForm<?= $id ?>">
									<span class="tag tag-primary tag-pill float-xs-right">
										<i class="icon-edit"></i>
									</span>
								</a>
								
								<!-- Modal -->
								<div class="modal fade text-xs-left" id="inlineForm<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?= $id ?>" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span>
												</button>
												<h2 class="modal-title text-text-bold-600" id="myModalLabel<?= $id ?>">Editer</h2>
											</div>
											
											<form id="addCampagne" class="editCampagne" action="<?php echo base_url("campagne/add") ?>" method="post">
												<?php echo form_hidden('id', $id); ?>
												<div class="modal-body">
													<div class="form-group">
														<label for="panneau_campagne_nom">Nom campagne <span class="validation_error panneau_campagne_nom__error"></span></label>
														<div class="position-relative has-icon-left">
															<?php $panneau_campagne_nom["value"] = $campagne["panneau_campagne_nom"] ?>
															<?php echo form_input($panneau_campagne_nom, '', ''); ?>
															<div class="form-control-position">
																<i class="icon-file2"></i>
															</div>
														</div>
													</div>
												
													<div class="form-group">
														<label for="panneau_campagne_date_lancement">Date de lancement <span class="validation_error panneau_campagne_date_lancement__error"></span></label>
														<div class="position-relative has-icon-left">
															<?php $panneau_campagne_date_lancement["value"] = $campagne["panneau_campagne_date_lancement"] ?>
															<?php echo form_input($panneau_campagne_date_lancement, '', ''); ?>
															<div class="form-control-position">
																<i class="icon-calendar5"></i>
															</div>
														</div>
													</div>
												</div>
											  
												<div class="modal-footer">
													<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="Fermer">
													<input type="submit" class="btn btn-outline-primary btn-lg" value="Ajouter">
												</div>
											</form>
										</div>
									</div>
								</div>
								
								<!--<span class="tag tag-primary tag-pill float-xs-right"><i class="icon-cross2"></i></span>-->
								<a href="#" data-delete="<?= $id ?>" class="delete" onclick="remove(<?= $id ?>)">
									<span class="tag tag-primary tag-pill float-xs-right">
										<i class="icon-cross2"></i>
									</span>
								</a>

								<span class="tag tag-primary tag-pill float-xs-right"><?php echo format_date($campagne["panneau_campagne_date_lancement"]) ?></span>
								<label id="label_<?= $id ?>"><?php echo $campagne["panneau_campagne_nom"] ?></label>
							</li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<script type="text/javascript">
	$(document).ready(function() {
		$("#addCampagne").submit(function() {
			$(".validation_error").empty();
			var postData = $(this).serialize();
			
			var url = '<?php echo base_url("campagne/add") ?>';
			$.ajax({
				type: "POST",
				url: url,
				data: postData,
				//cache: false,
				//contentType: false, // Only iwth input files
				//processData: false,
				success:function(data) {
					var $result = $.parseJSON(data);
					if($result.validation_error) {
						$.each($result.validation_error, function (index, value) {
							console.log(index);
							console.log(value);
							$("." + index + "__error").text(value);
						});
					} else {
						alert($result.success);
						location.reload();
					}
					//
				},
				error:function(data) {
					alert("error " + data);
				}
			}); 
			return false;
		});
		
		$(".editCampagne").submit(function() {
			edit($(this).serialize());
			return false;
		});
		
	});
	
	function edit(postData) {
		
		$(".validation_error").empty();
		var url = '<?php echo base_url("campagne/edit/") ?>';
		
		$.ajax({
			type: "POST",
			url: url,
			data: postData,
			success:function(data) {
				//alert(data);
				
				var $result = $.parseJSON(data);
				if($result.validation_error) {
					$.each($result.validation_error, function (index, value) {
						console.log(index);
						console.log(value);
						$("." + index + "__error").text(value);
					});
				} else {
					alert($result.success);
					$('.modal#inlineForm' + $result.id).modal('toggle');
					$("#label_" + $result.id).html($result.panneau_campagne_nom);
					//location.reload();
				}
				
				
				//
			},
			error:function(data) {
				alert("error " + data);
			}
		});
		return false;
	}

	function remove(postData) {
		var url = '<?php echo base_url("campagne/delete/") ?>';
		if(confirm("Voulez vous supprimer cette campagne ?")) {
			$.ajax({
				type: "POST",
				url: url,
				data: "id=" + postData,
				success:function(data) {
					var $target = $(".row__" + postData);
					var $result = $.parseJSON(data);
					alert($result.success);
					$target.hide("slow", function(){ $(this).remove(); });
				},
				error:function(data) {
					alert("error " + data);
				}
			});
		} else {
			//alert("nok");
		}
		return false;
	}
</script>