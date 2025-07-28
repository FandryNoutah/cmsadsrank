<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-form">Nouveau panneau</h4>
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
				<?php echo form_open('',array('class'=>'form-horizontal form-simple form'));?>
					<div class="form-body">
						<h4 class="form-section"><i class="icon-head"></i> Infos</h4>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_reference">Réference <?php echo form_error('panneau_reference'); ?></label>
									<?php echo form_input($panneau_reference, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_format">Format <?php echo form_error('panneau_format'); ?></label>
									<?php echo form_dropdown('panneau_format', $formats, 1,'id="panneau_format" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_type">Type <?php echo form_error('panneau_type'); ?></label>
									<?php echo form_dropdown('panneau_type', $types, 1,'id="panneau_type" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_regisseur">Format <?php echo form_error('panneau_regisseur'); ?></label>
									<?php echo form_dropdown('panneau_regisseur', $regisseurs, 1,'id="panneau_regisseur" class="form-control"'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Emplacements</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_province">Province <?php echo form_error('panneau_province'); ?></label>
									<?php echo form_dropdown('panneau_province', $provinces, 1,'id="panneau_province" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_axe">Axe <?php echo form_error('panneau_axe'); ?></label>
									<?php echo form_dropdown('panneau_axe', $axes, 1,'id="panneau_axe" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_sam">SAM <?php echo form_error('panneau_sam'); ?></label>
									<?php echo form_dropdown('panneau_sam', $sam, 1,'id="panneau_sam" class="form-control"'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_emplacement">Emplacement <?php echo form_error('panneau_emplacement'); ?></label>
									<?php echo form_input($panneau_emplacement, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_quartier">Quartier <?php echo form_error('panneau_quartier'); ?></label>
									<?php echo form_input($panneau_quartier, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_region">Région <?php echo form_error('panneau_region'); ?></label>
									<?php echo form_input($panneau_region, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_proximite">Proximité <?php echo form_error('panneau_proximite'); ?></label>
									<?php echo form_input($panneau_proximite, '', 'required'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Coordonnées géographiques</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="panneau_longitude">Longitude <?php echo form_error('panneau_longitude'); ?></label>
									<?php echo form_input($panneau_longitude, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="panneau_latitude">Latitude <?php echo form_error('panneau_latitude'); ?></label>
									<?php echo form_input($panneau_latitude, '', 'required'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Couverture</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_couverture_fo">Couverture FO <?php echo form_error('panneau_couverture_fo'); ?></label>
									<?php echo form_dropdown('panneau_couverture_fo', $yesno, 0,'id="panneau_couverture_fo" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_axe">Couverture ADSL <?php echo form_error('panneau_axe'); ?></label>
									<?php echo form_dropdown('panneau_axe', $yesno, 0,'id="panneau_axe" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_couverture_4g">Couverture 4G <?php echo form_error('panneau_couverture_4g'); ?></label>
									<?php echo form_dropdown('panneau_couverture_4g', $yesno, 0,'id="panneau_couverture_4g" class="form-control"'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Coûts</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_cout_impression">Impression <?php echo form_error('panneau_cout_impression'); ?></label>
									<?php echo form_input($panneau_cout_impression, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_cout_pose_finition">Pose et finition <?php echo form_error('panneau_cout_pose_finition'); ?></label>
									<?php echo form_input($panneau_cout_pose_finition, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_cout_location">Location <?php echo form_error('panneau_cout_location'); ?></label>
									<?php echo form_input($panneau_cout_location, '', 'required'); ?>
								</div>
							</div>
						</div>













						<!--

						<div class="form-group">
							<label for="companyName">Company</label>
							<input type="text" id="companyName" class="form-control" placeholder="Company Name" name="company">
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="projectinput5">Interested in</label>
									<select id="projectinput5" name="interested" class="form-control">
										<option value="none" selected="" disabled="">Interested in</option>
										<option value="design">design</option>
										<option value="development">development</option>
										<option value="illustration">illustration</option>
										<option value="branding">branding</option>
										<option value="video">video</option>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="projectinput6">Budget</label>
									<select id="projectinput6" name="budget" class="form-control">
										<option value="0" selected="" disabled="">Budget</option>
										<option value="less than 5000$">less than 5000$</option>
										<option value="5000$ - 10000$">5000$ - 10000$</option>
										<option value="10000$ - 20000$">10000$ - 20000$</option>
										<option value="more than 20000$">more than 20000$</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Select File</label>
							<label id="projectinput7" class="file center-block">
								<input type="file" id="file">
								<span class="file-custom"></span>
							</label>
						</div>

						<div class="form-group">
							<label for="projectinput8">About Project</label>
							<textarea id="projectinput8" rows="5" class="form-control" name="comment" placeholder="About Project"></textarea>
						</div>
						-->
					</div>

					<div class="form-actions">
						<button type="button" class="btn btn-warning mr-1">
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