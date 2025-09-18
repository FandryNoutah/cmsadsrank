<form id="eventForm">
	<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" style="width: 640px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="eventModalLabel">Ajouter un événement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label for="title-select">Titre</label><br>
					<select id="title-select" name="title" style="width:100%" onchange="toggleCustomTitle(this)">
						<option value="Télétravail">Télétravail</option>
						<option value="Perso">Perso</option>
						<option value="Soutenance">Soutenance</option>
						<option value="Formation">Formation</option>
						<option value="Maladie">Maladie</option>
						<option value="Congé">Congé</option>
						<option value="Contact">Contact</option>
						<option value="Autre">Autre...</option>
					</select>

					<div id="custom-title-container" style="margin-top:10px; display:none;">
						<label for="custom-title">Titre personnalisé</label><br>
						<input type="text" id="custom-title" name="custom_title" style="width:100%">
					</div>

					<br><br>

					<label>Description</label><br>
					<textarea name="description" placeholder="Description" style="width:100%"></textarea><br><br>

					<label>Début</label><br>
					<input type="datetime-local" name="start_date" required style="width:100%"><br><br>

					<label>Fin</label><br>
					<input type="datetime-local" name="end_date" required style="width:100%"><br><br>

					<label>Couleur</label><br>
					<input type="color" name="color" value="#3788d8"><br><br>

					<label>Participants (tagger)</label><br>
					<select name="attendees[]" id="attendeesSelect" multiple style="width:100%; min-height:90px;">
					</select>
					<small>Ctrl/Cmd+Click pour sélectionner plusieurs</small>
					<br><br>

					<button type="submit">Enregistrer</button>
					<button type="button" id="cancelBtn">Annuler</button>
				</div>
			</div>
		</div>
	</div>
</form>
