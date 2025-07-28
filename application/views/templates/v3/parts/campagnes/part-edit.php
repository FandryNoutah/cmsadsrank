

<?php $data = $postdata[0]; ?>

<?php $dateDebut = explode(" ", $data->date_debut); ?>
<?php $dateFin = explode(" ", $data->date_fin); ?>
<?php $dateDebut = $dateDebut[0]; ?>
<?php $dateFin = $dateFin[0]; ?>

<form action="<?php echo base_url("campagnes/edit/$id") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
	<div class="modal-body">
		<div class="form-group">
			<label for="label">Nom campagne<?php echo form_error('label'); ?></label>
			<?php echo form_input('label', $data->label, 'class="form-control"', 'required'); ?>
		</div>
		
		<div class="form-group">
			<label for="date_debut">Date début <?php echo form_error('date_debut'); ?></label>
			<div class="position-relative has-icon-left">
				<?php echo form_input(["type" => "date", "name" => "date_debut"], $dateDebut, 'class="form-control" required'); ?>
				<div class="form-control-position">
					<i class="icon-calendar5"></i>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="date_fin">Date fin <?php echo form_error('date_fin'); ?></label>
			<div class="position-relative has-icon-left">
				<?php echo form_input(["type" => "date", "name" => "date_fin"], $dateFin, 'class="form-control" required'); ?>
				<div class="form-control-position">
					<i class="icon-calendar5"></i>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="exampleSelect1">Visuels Attacher</label>
			<select class="form-control" id="exampleSelect1" name="visuels">
								
			<?php foreach($liste as $v){ ?>
			<option value="<?php echo $v->logo;?>"> <?php echo $v->label;?>  </option>
			<?php } ?>
			</select>
		</div>	
	</div>
	<div class="modal-footer">
		<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="Fermer">
		<input type="submit" class="btn btn-outline-primary btn-lg" value="Mettre à jour">
	</div>
</form>