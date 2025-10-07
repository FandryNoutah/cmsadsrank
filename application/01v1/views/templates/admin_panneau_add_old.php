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
				<form class="form">
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

						<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>

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
					</div>

					<div class="form-actions">
						<button type="button" class="btn btn-warning mr-1">
							<i class="icon-cross2"></i> Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="icon-check2"></i> Save
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>