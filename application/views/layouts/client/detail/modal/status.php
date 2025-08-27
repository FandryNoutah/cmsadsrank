<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="statusModalLabel">Résilier / Mise en pause client</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url("Client/resiliation") ?>" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label for="status_type">Type</label>
					<select name="resiliation" id="status_type" class="form-control">
						<option value="3">Arrêt campagne / résiliation client</option>
						<option value="2">Mise en pause</option>
					</select>
				</div>
				<input type="hidden" class="form-control" name="am_resiliation" value="<?php echo $current_user->id; ?>">
				<input type="hidden" readonly value="0" class="form-control" name="demande_resiliation">
				<input type="hidden" readonly value="<?= $donnees[0]['idclients']; ?>" class="form-control" name="client">
				<div class="form-group">
					<label for="status_client">Client</label>
					<input type="text" readonly value="<?= $donnees[0]['nom_client']; ?>" class="form-control">
				</div>

				<div class="form-group">
					<label for="status_tm">TM</label>
					<select name="tm" id="status_tm" class="form-control">
						<?php foreach ($users as $u): ?>
							<?php if($u->tech == 1): ?>
							<option value="<?= $u->id ?>"><?= $u->first_name ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="status_date">Date</label>
					<input type="date" name="date_resiliation" id="status_date" class="form-control">
				</div>

				<div class="form-group">
					<label for="status_date_resiliation">Date de résiliation</label>
					<input type="date" name="fin_campagne" id="status_date_resiliation" class="form-control">
				</div>

				<div class="form-group">
					<label for="status_information">Information</label>
					<textarea name="information_resiliation" id="status_information" rows="2" class="form-control"></textarea>
				</div>

				<div class="form-group">
					<label for="status_status">Statut</label>
					<select name="statut_resiliation" id="status_status" class="form-control">
						<option value="0">Planifier</option>
						<option value="1">En cours</option>
						<option value="2">Tâche complète</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-dark btn-block" value="Sauvegarder"></input>
			</div>
		</div>
		</form>
	</div>
</div>
