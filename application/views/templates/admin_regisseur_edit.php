<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Editer régisseur</h4>
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
				<?php echo form_open_multipart(uri_string()); ?>
					<div class="form-body">
						
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="label">Label <?php echo form_error('label'); ?></label>
									<?php echo form_input($label, '', 'required'); ?>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="telephone">Téléphone <?php echo form_error('telephone'); ?></label>
									<?php echo form_input($telephone, '', 'required'); ?>
								</div>
							</div>	

							<div class="col-md-3">
								<div class="form-group">
									<label for="email">Email <?php echo form_error('email'); ?></label>
									<?php echo form_input($email, '', 'required'); ?>
								</div>
							</div>	

							<div class="col-md-3">
								<div class="form-group">
									<label for="logo" >Logo <?php echo form_error('logo'); ?></label><br/>
									<?php 
										if($image_properties != "") {
											$attribute = 'disabled="disabled"';
											echo '<div style="display:table">' . img($image_properties) . '</div>';
											
										} else {
											$attribute = '';
										}
										echo '<label style="margin:10px 15px 7px 0;cursor:pointer" for="enableFileUpdate">Changer logo</label>';
										echo '<input id="enableFileUpdate" type="checkbox" />';
									?>
									<br/>
									<?php echo form_upload($logo,'','required style="display:none"'. $attribute .''); ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="commentaires">Commentaires <?php echo form_error('commentaires'); ?></label><br/>
									<?php echo form_textarea($commentaires,'','required'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="commentaires">Date debut contrat <?php echo form_error('DateDebut'); ?></label><br/>
									<?php echo form_input($DateDebut,'','required'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="commentaires">Date Fin contrat <?php echo form_error('DateFin'); ?></label><br/>
									<?php echo form_input($DateFin,'','required'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="commentaires">Information contrat <?php echo form_error('information'); ?></label><br/>
									<?php echo form_input($information,'','required'); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-actions right">
						<button type="reset" class="btn btn-warning mr-1">
							<i class="icon-cross2"></i> Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="icon-check2"></i> Save
						</button>
					</div>
				<?php echo form_close();?>

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