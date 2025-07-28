<?php // datadump($postdata[0]['id'])  ?>
<?php //$data = $postdata[0]; ?>
<?php //$date = explode(" ", $data->date_visuel); ?>
<?php //$date = $date[0]; ?>

<form action="<?php echo base_url("visuels/Update") ?>" enctype="multipart/form-data" method="post" id="majCampagne" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="form-group">
			<label for="label">Nom <?php echo form_error($postdata[0]['label']); ?></label>
			<?php echo form_input(["type" => "texte", "name" => "label"], $postdata[0]['label'], 'class="form-control"', 'required'); ?>
		</div>
		
		<div class="form-group">
			<label for="date_visuel">Date pose <?php echo form_error($postdata[0]['date_visuel']); ?></label>
			<div class="">
				<?php //echo form_input(["type" => "date", "name" => "date_visuel"], $data->date_visuel, 'class="form-control"', 'required'); ?>
				<?php echo form_input(["name" => "date_visuel"], $postdata[0]['date_visuel']); ?>
				<div class="form-control-position">
					<i class="icon-calendar5"></i>
				</div>
			</div>
		</div>
		<a href="<?php echo base_url($postdata[0]['logo'])?>" ><img width="100" src="<?php echo base_url($postdata[0]['logo'])?>" /> </a>
		<div class="form-group">
			<input type="file" name="logo">
		</div>
		<div class="form-group">
			<input type="hidden" value="<?php echo $postdata[0]['id'] ?>" name="id">
		</div>
		<div class="form-group">
			<input type="hidden" value="<?php echo $postdata[0]['logo'] ?>" name="logo1">
		</div>
	</div>
	<div class="modal-footer">
		<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="Fermer">
		<input type="submit" class="btn btn-outline-primary btn-lg" value="Mettre à jour">
	</div>
</form>