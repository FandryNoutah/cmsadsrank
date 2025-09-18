<form id="editEventForm">
	<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" style="width: 640px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editEventModalLabel">Modifier un événement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id">

					<div class="form-group">
						<label>Titre</label><br>
						<input type="text" class="form-control" name="title"><br><br>
					</div>

					<div class="form-group">
						<label>Description</label><br>
						<textarea name="description" class="form-control"></textarea><br><br>
					</div>

					<div class="form-group">
						<label>Début</label><br>
						<input type="datetime-local" class="form-control" name="start_date"><br><br>
					</div>

					<div class="form-group">
						<label>Fin</label><br>
						<input type="datetime-local" class="form-control" name="end_date"><br><br>
					</div>

					<label>Couleur</label><br>
					<input type="color" name="color" value="#3788d8"><br><br>

					<div class="form-group">
						<label>Participants</label><br>
						<select name="attendees[]" id="editAttendeesSelect" class="form-control" multiple></select><br><br>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" id="cancelEditBtn" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Annuler</button>
					<button type="submit" class="btn btn-dark">Mettre à jour</button>
				</div>
			</div>
		</div>
	</div>
</form>
