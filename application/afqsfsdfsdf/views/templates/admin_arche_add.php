<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Ajout arche</h4>
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
				<?php echo form_open_multipart("arche/add"); ?>
					<div class="form-body">
						
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="hm_arche_emplacement">Emplacement <?php echo form_error('hm_arche_emplacement'); ?></label>
									<?php echo form_input($hm_arche_emplacement, '', 'required'); ?>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="hm_arche_format">Format <?php echo form_error('hm_arche_format'); ?></label>
									<?php echo form_dropdown('hm_arche_format', $formats, 1,'id="hm_arche_format" class="form-control"'); ?>
								</div>
							</div>	

							<div class="col-md-3">
								<div class="form-group">
									<label for="hm_arche_province">Province <?php echo form_error('hm_arche_province'); ?></label>
									<?php echo form_dropdown('hm_arche_province', $provinces, 1,'id="hm_arche_province" class="form-control"'); ?>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="visuel_actuel">Visuel <?php echo form_error('hm_arche_visuel'); ?></label><br/>
									<?php echo form_input($hm_arche_visuel, '', 'required'); ?>
									<label for="visuel_actuel_path"><?php echo form_error('visuel_actuel_path'); ?></label><br/>
									<?php echo form_upload($hm_arche_visuel_path,'',''); ?>
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