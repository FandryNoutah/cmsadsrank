<pre>
<?php //print_r($_visuels_formats); ?>
</pre>
<style>
figure.col-lg-3.col-md-6.col-xs-12 {
    margin: 0;
    padding: 2px;
	display: table-cell;
	vertical-align: middle;
	position: relative;
	height: 200px;
	overflow: hidden;
}
figure.col-lg-3.col-md-6.col-xs-12 > a {
	padding: 0.25rem;
	background-color: #F1F1F1;
	border: 1px solid #ddd;
	transition: all .2s ease-in-out;
	max-width: 100%;
	display: block;
	text-align: center;
	height: inherit;
}
figure.col-lg-3.col-md-6.col-xs-12 > a > span {
    position: absolute;
	bottom: 11px;
	text-align: center;
	background: rgba(0,0,0,0.6);
	color: #fff;
	padding: 8px 10px;
	left: 11px;
}
figure.col-lg-3.col-md-6.col-xs-12 > a > img {
	/*height: 200px;*/
	max-height: 100%;
	background: none;
	border: none;
	border-radius: 0.18rem;
	transition: all .2s ease-in-out;
	max-width: 100%;
}
label > span.required {
	color: #FF0000;
}
.validation_error {
	color: red;
	font-style: italic;
	font-size: 11px;
}
</style>
<section id="accordion">
	<div class="row">
		<div class="col-xs-12 mt-1">
			<h4>Visuels</h4>
			<hr>
		</div>
	</div>
	<div class="row match-height">
		<div class="col-lg-12 col-xl-12">
			<div class="mb-1">
				<h5 class="mb-0">Liste visuels</h5>
				
			</div>
			<div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
				<div class="card">
					<?php $accordionIndex = 0; ?>
					<?php foreach($_visuelsconcurrent as $key => $_visuel): ?>
						<?php $ariaExpanded = $accordionIndex == 0 ? "true" : "false" ?>
						<div id="heading<?php echo $_visuel["id"] ?>"  class="card-header">
							<a data-toggle="collapse" data-parent="#accordionWrapa<?php echo $_visuel["id"] ?>" href="#accordion<?php echo $_visuel["id"] ?>" aria-expanded="<?php echo $ariaExpanded ?>" aria-controls="accordion<?php echo $_visuel["id"] ?>" class="card-title lead"><?php echo $_visuel["panneau_visuel_name"] ?></a>
						</div>
						<div id="accordion<?php echo $_visuel["id"] ?>" role="tabpanel" aria-labelledby="heading<?php echo $_visuel["id"] ?>" class="card-collapse collapse" aria-expanded="<?php echo $ariaExpanded ?>">
							<div class="card-body">
									
								<div class="card-block my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
									<div class="row">
										<?php foreach($_formats as $keyF => $_format): ?>
											<figure class="col-xl-2 col-lg-3 col-md-6 col-xs-12" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
											  <a href="#" itemprop="contentUrl" data-size="480x360" data-toggle="modal" data-target="#inlineForm_<?php echo $_visuel["id"] . "_" . $_format->id ?>">
													<?php if(isset($_visuels_formats[$_visuel["id"]][$_format->id]) && $_visuels_formats[$_visuel["id"]][$_format->id]): ?>
														<img class="img-thumbnail img-fluid" src="<?php echo base_url($_visuels_formats[$_visuel["id"]][$_format->id]) ?>" itemprop="thumbnail" alt="Image description">
													<?php else: ?>
														<img class="img-thumbnail img-fluid" src="<?php echo base_url("assets/images/formats/default.png") ?>" itemprop="thumbnail" alt="Image description">
													<?php endif ?>
													<span><?php echo $_format->label ?></span>
											  </a>
											</figure>
											
											<!-- MODAL -->
											<div class="modal fade text-xs-left" id="inlineForm_<?php echo $_visuel["id"] . "_" . $_format->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
															  <span aria-hidden="true">&times;</span>
															</button>
															<h2 class="modal-title text-text-bold-600" id="myModalLabel33">Ajouter une image</h2>
														</div>
														<form action="<?php echo base_url("visuels/addvisuel") ?>" enctype="multipart/form-data" method="post">
														  <div class="modal-body">
															<label><strong>Visuel :</strong> <?php echo $_visuel["panneau_visuel_name"] ?></label>
															<div class="form-group">
																<input type="hidden" name="visuel_id" value="<?php echo $_visuel["id"] ?>" placeholder="Visuel ID" class="form-control" readonly="readonly">
															</div>

															<label><strong>Format :</strong> <?php echo $_format->label ?></label>
															<div class="form-group">
																<input type="hidden" name="format_id" value="<?php echo $_format->id ?>" placeholder="Format ID" class="form-control" readonly="readonly">
															</div>
															
															<label><strong>Fichier :</strong></label>
															<div class="form-group">
																<input type="file" name="visuel_path" class="form-control">
															</div>
															
														  </div>
														  <div class="modal-footer">
															<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
															<input type="submit" class="btn btn-outline-primary btn-lg" value="Ajouter">
														  </div>
														</form>
													</div>
												</div>
											</div>
											<!-- MODAL -->
										<?php endforeach ?>
									</div>
								</div>
								
								
							</div>
						</div>
						<?php $accordionIndex++; ?>
					<?php endforeach ?>

					<div class="btnControls">
						<button type="button" class="btn btn-success upgrade-to-pro" data-toggle="modal" data-target="#inlineForm">
							Ajouter nouveau visuel
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
									<h2 class="modal-title text-text-bold-600" id="myModalLabel33">Ajouter un visuel</h2>
								</div>
								
								<?php echo validation_errors(); ?>
								
								<form id="addVisuel" action="<?php echo base_url("visuels/add") ?>" enctype="multipart/form-data" method="post">
								  <div class="modal-body">
									<label>Nom visuel: <span class="required">*</span> <span class="validation_error panneau_visuel_name__error"></span></label>
									<div class="form-group">
										<input type="text" name="panneau_visuel_name" placeholder="Nom visuel" class="form-control">
										<?php echo form_error("panneau_visuel_name"); ?>
									</div>

									<label>Image visuel: <span class="required">*</span> <span class="validation_error visuel_path__error"></span></label>
									<div class="form-group">
										<input type="file" name="visuel_path" class="form-control">
										<?php echo form_error("visuel_path"); ?>
									</div>
									
									<label>Format visuel: </label>
									<div class="form-group">
										<?php echo form_dropdown('format_id', $_formats_array, 2, "class='form-control'"); ?>
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
								
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Accordion end -->

<script type="text/javascript">
	$(document).ready(function() {
		
		
		
		
		$("#addVisuel").submit(function() {
			var inputFile = new FormData($("#addVisuel")[0]);
			
			console.log(inputFile);
			
			//var file = inputFile.append("visuel_path", document.fileInputElement.files[0]);
			//var file = inputFile.append("visuel_path", document.forms["addVisuel"]['visuel_path'].files[0]);
			//var file = document.forms["addVisuel"]['visuel_path'].files[0];
			//var dataString = $(this).serialize();
			//var postData = dataString;
			var postData = inputFile;
			
			
			var url = '<?php echo base_url("visuels/add") ?>';
			$.ajax({
				type: "POST",
				url: url,
				data: postData,
				cache: false,
				contentType: false,
				processData: false,
				success:function(data) {
					var $result = $.parseJSON(data);
					if($result.validation_error) {
						var $result = $.parseJSON(data);
						//console.log(data);
						$(".validation_error").empty();
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
					alert(data);
				}
			}); 
			return false;
		});
	});
</script>