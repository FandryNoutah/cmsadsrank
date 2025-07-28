<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-form">MAJ Panneau</h4>
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
				<?php echo form_open_multipart("panneau/maj/$id_panneau",array('class'=>'form-horizontal form-simple form'));?>
					<input type="hidden" name="id_panneau" readonly="" value="<?php echo $id_panneau; ?>">
					<div class="form-body">
						<h4 class="form-section"><i class="icon-head"></i> Infos</h4>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_maj_type">Type <?php echo form_error('panneau_maj_type'); ?></label>
									<?php echo form_dropdown('panneau_maj_type', $majType, 1,'id="panneau_maj_type" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_maj_date_pose">Date pose <?php echo form_error('panneau_maj_date_pose'); ?></label>
									<div class="position-relative has-icon-left">
										<?php echo form_input($panneau_maj_date_pose, '', 'required'); ?>
										<div class="form-control-position">
											<i class="icon-calendar5"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_maj_mesure_patch">Mesure patch <?php echo form_error('panneau_maj_mesure_patch'); ?></label>
									<div class="position-relative">
										<?php echo form_input($panneau_maj_mesure_patch, '', ''); ?>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_maj_visuel">Visuel (ou patch) <?php echo form_error('panneau_maj_visuel'); ?></label><br/>
									<?php echo form_input($panneau_maj_visuel, '', 'required'); ?><br/>
									<?php echo form_upload($panneau_maj_visuel_path, '', 'required'); ?>
									<label><?php echo form_error('panneau_maj_visuel_path'); ?></label>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Coûts</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_maj_cout_impression">Impression <?php echo form_error('panneau_maj_cout_impression'); ?></label>
									<div class="input-group">
										<span class="input-group-addon">Ar</span>
										<?php echo form_input($panneau_maj_cout_impression, '', 'required'); ?>
										<span class="input-group-addon">.00</span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_maj_cout_pose">Pose <?php echo form_error('panneau_maj_cout_pose'); ?></label>
									<div class="input-group">
										<span class="input-group-addon">Ar</span>
										<?php echo form_input($panneau_maj_cout_pose, '', 'required'); ?>
										<span class="input-group-addon">.00</span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_maj_cout_deplacement">Déplacement <?php echo form_error('panneau_maj_cout_deplacement'); ?></label>
									<div class="input-group">
										<span class="input-group-addon">Ar</span>
										<?php echo form_input($panneau_maj_cout_deplacement, '', 'required'); ?>
										<span class="input-group-addon">.00</span>
									</div>
									
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Commentaires</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<!--<label for="panneau_maj_commentaires">Commentaires</label>-->
									<div class="position-relative has-icon-left">
										<?php echo form_textarea($panneau_maj_commentaires, '', 'rows="3"'); ?>
										<div class="form-control-position">
											<i class="icon-file2"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-actions">
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