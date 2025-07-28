<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Editer kiosque</h4>
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
						<h4 class="form-section"><i class="icon-eye6"></i> Détails</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">Nom du kiosque <?php echo form_error('nom_kiosque'); ?></label>
									<?php echo form_input($nom_kiosque, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="last_name">Dimension <?php echo form_error('dimension'); ?></label>
									<?php //echo form_input($dimension, '', 'required'); ?>
									<?php echo form_dropdown('dimension', $dimensions, $dimension_selected, $attributes); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="username">Statut<?php echo form_error('status'); ?></label>
									<?php //echo form_input($status, '', 'required'); ?>
									<?php echo form_dropdown('status', $statuses, $status_selected, $attributes); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="media">
										<a class="media-left" href="#">
											<?php if(isset($image_properties) && $image_properties): ?>
											<?php echo img($image_properties); ?>
											<?php endif; ?>
										</a>
										<br>
										<div class="media-body">
											<label for="image">Image <?php echo form_error('image'); ?></label>
											<?php echo form_upload($image); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-actions right">
						<button type="submit" class="btn btn-primary">
							<i class="icon-check2"></i> Update
						</button>
					</div>
				<?php echo form_close();?>

			</div>
		</div>
	</div>
</div>