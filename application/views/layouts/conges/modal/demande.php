<div class="modal fade" id="demandeModal" tabindex="-1" role="dialog" aria-labelledby="demandeModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" action="<?= site_url('conges/demander') ?>">
				<div class="modal-header">
					<h5 class="modal-title" id="demandeModalLabel">Nouvelle demande de congé</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label>Date début</label>
						<input type="date" name="date_debut" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Jours</label>
						<select name="jours" class="form-control" required>
							<option value="1">Toute la journée</option>
							<option value="0.5">Demi-journée</option>
						</select>
					</div>
					<div class="form-group">
						<label>Date fin</label>
						<input type="date" name="date_fin" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Motif</label>
						<textarea name="motif" class="form-control" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Envoyer</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
				</div>
			</form>
		</div>
	</div>
</div>
