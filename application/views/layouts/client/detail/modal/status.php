<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="statusModalLabel">Créer Upsell - Baisse</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<label for="status_type">Type</label>
					<select name="status_type" id="status_type" class="form-control">
						<option value="">Arrêt campagne / résiliation client</option>
					</select>
				</div>

				<div class="form-group">
					<label for="status_client">Client</label>
					<input type="text" readonly value="<?= $d['nom_client']; ?>" class="form-control">
				</div>

				<div class="form-group">
					<label for="status_tm">TM</label>
					<select name="status_tm" id="status_tm" class="form-control">
						<?php foreach ($users as $u): ?>
							<option value="<?= $u->id ?>"><?= $u->first_name ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="status_date">Date</label>
					<input type="month" name="status_date" id="status_date" class="form-control">
				</div>

				<div class="form-group">
					<label for="status_date_resiliation">Date de résiliation</label>
					<input type="month" name="status_date_resiliation" id="status_date_resiliation" class="form-control">
				</div>

				<div class="form-group">
					<label for="status_information">Information</label>
					<textarea name="status_information" id="status_information" rows="2" class="form-control"></textarea>
				</div>

				<div class="form-group">
					<label for="status_status">Statut</label>
					<select name="status_status" id="status_status" class="form-control">
						<option value="planifier">Planifier</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark btn-block">Sauvegarder</button>
			</div>
		</div>
	</div>
</div>
