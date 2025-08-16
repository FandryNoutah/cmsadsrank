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

					<div class="form-row">
						<div class="col form-group">
							<label for="task_type">Type</label>
							<select name="task_type" id="task_type" class="form-control">
								<option value="information">Information</option>
								<option value="tache">Tâche</option>
								<option value="rappel">Rappel</option>
							</select>
						</div>
						<div class="col form-group">
							<label for="task_status">Statut</label>
							<select name="task_status" id="task_status" class="form-control">
								<option value="Normal">Normal</option>
								<option value="Priorité">Priorité</option>
								<option value="Urgent">Urgent</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="task_title">Titre du tâche</label>
						<input type="text" name="task_title" id="task_title" class="form-control" placeholder="Entrer le titre du tâche">
					</div>

					<div class="form-row">
						<div class="col form-group">
							<label for="add_member">Add Members</label>
							<button type="button" class="btn btn-outline-dark rounded-circle d-block">
								<i class="fa fa-user-plus"></i>
							</button>
						</div>
						<div class="col form-group">
							<label for="add_member">Add Labels</label>
							<button type="button" class="btn btn-outline-dark rounded-circle d-block">
								<i class="fa fa-tag"></i>
							</button>
						</div>
						<div class="col form-group">
							<label for="due_date">Date due</label>
							<input type="date" name="due_date" id="due_date" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label for="tache">Tâches</label>
						<textarea name="tache" id="tache" rows="2" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label for="attachment">Attachment</label>
						<div class="file-drop-area" id="fileDrop">
							<div class="file-drop-icon">
								<i class="fas fa-image"></i>
							</div>
							<span>Drag files here or <span class="text-primary">Browse</span></span>
						</div>
						<input type="file" id="fileInput" class="d-none">
						<div id="fileName" class="mt-3 text-muted"></div>
					</div>

					<!-- <div class="form-group">
						<label for="task_status">Statut</label>
						<select name="task_status" id="task_status" class="form-control">
							<option value="">Plannifier</option>
							<option value="">En Cours</option>
						</select>
					</div> -->
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark px-3">Ajouter</button>
				</div>
			</div>
		</div>
	</form>
</div>
