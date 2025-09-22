<form id="eventForm">
	<div class="modal fade" id="eventModal" aria-labelledby="eventModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="eventModalLabel">Ajouter un événement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">

						<label for="title-select">Titre</label><br>
						<select id="title-select" class="form-control" name="title" onchange="toggleCustomTitle(this)">
							<option value="Télétravail">Télétravail</option>
							<option value="Perso">Perso</option>
							<option value="Soutenance">Soutenance</option>
							<option value="Formation">Formation</option>
							<option value="Maladie">Maladie</option>
							<option value="Congé">Congé</option>
							<option value="Contact">Contact</option>
							<option value="Autre">Autre...</option>
						</select>
					</div>

					<div class="form-group d-none" id="custom_title_container">
						<label for="custom-title">Titre personnalisé</label><br>
						<input type="text" id="custom-title" class="form-control" name="custom_title">
					</div>

					<div class="form-group">

						<label>Description</label><br>
						<textarea name="description" class="form-control" placeholder="Description"></textarea>
					</div>

					<div class="form-group">
						<label>Début</label><br>
						<input type="datetime-local" class="form-control" name="start_date" required>

					</div>

					<div class="form-group">

						<label>Fin</label><br>
						<input type="datetime-local" class="form-control" name="end_date" required>
					</div>

					<div class="form-group">
						<label>Participants (tagger)</label><br>
						<select class="form-control" name="attendees[]" id="attendeesSelect" multiple>
						</select>

					</div>

					<small>Ctrl/Cmd+Click pour sélectionner plusieurs</small>
					

				</div>
				<div class="modal-footer">
					<button type="button" id="cancelBtn" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Annuler</button>
					<button type="submit" class="btn btn-dark">Enregistrer</button>
				</div>
			</div>
		</div>
	</div>
</form>
