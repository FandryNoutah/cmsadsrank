<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style3.css") ?>">
</head>
<body>



<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Ajout régisseur</h4>
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

		

		<div class="label1">
			<div class="card-block">

				<div class="card-text"></div>
				<!--
				<div id="infoMessage"><?php //echo $message;?></div>
				-->
				<?php echo form_open_multipart("regisseur/add"); ?>
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
									<?php //echo form_input($dimension, '', 'required'); ?>
									<?php echo form_input($telephone, '', 'required'); ?>
								</div>
							</div>	
..............
							<div class="col-md-3">
								<div class="form-group">
									<label for="email">Email <?php echo form_error('email'); ?></label>
									<?php //echo form_input($dimension, '', 'required'); ?>
									<?php echo form_input($email, '', 'required'); ?>
								</div>
							</div>	

							<div class="col-md-3">
								<div class="form-group">
									<label for="logo">Logo <?php echo form_error('logo'); ?></label><br/>
									<?php echo form_upload($logo,'','required'); ?>
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
									<label for="DateDebut">Date début <?php echo form_error('DateDebut'); ?></label>
									<?php echo form_input($DateDebut, '', 'required'); ?>
								</div>
							</div>
					<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="DateFin">Date Fin <?php echo form_error('DateFin'); ?></label>
									<?php echo form_input($DateFin, '', 'required'); ?>
								</div>
							</div>		
					<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="information">Information <?php echo form_error('information'); ?></label>
									<?php echo form_input($information, '', ''); ?>
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
</body>