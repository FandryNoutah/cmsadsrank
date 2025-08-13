<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
	<form action="#">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title" id="taskModalLabel">Nouveau tâche</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="demand_date">Date de la demande</label>
						<input type="date" name="demand_date" id="demand_date" class="form-control">
					</div>

					<div class="form-group">
						<label for="due_date">Date due</label>
						<input type="date" name="due_date" id="due_date" class="form-control">
					</div>

					<div class="form-group">
						<label for="task_client">Client</label>
						<select name="task_client" id="task_client" class="form-control">
							<option value="">Abbradebarras</option>
							<option value="">AgoraJeux</option>
						</select>
					</div>

					<div class="form-group">
						<label for="task_am">AM</label>
						<input type="text" readonly id="task_am" value="Utilisateur connecté: Mavreen Bassin" class="form-control">
					</div>

					<div class="form-group">
						<label for="task_tm">TM</label>
						<select name="task_tm" id="task_tm" class="form-control">
							<option value="">Admin Adsrank</option>
							<option value="">Dev Miora</option>
						</select>
					</div>

					<div class="form-group">
						<label for="levier_marketing">Leviers marketing</label>
						<input type="text" value="Google Ads" id="levier_marketing" name="levier_marketing" class="form-control">
					</div>

					<div class="form-group">
						<label for="tache">Tâches</label>
						<textarea name="tache" id="tache" rows="2" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label for="task_status">Statut</label>
						<select name="task_status" id="task_status" class="form-control">
							<option value="">Plannifier</option>
							<option value="">En Cours</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark px-3">Ajouter</button>
				</div>
			</div>
		</div>
	</form>
</div>
