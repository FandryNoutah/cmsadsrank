<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
	<form action="<?= site_url('notes/create') ?>" method="POST">
		
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title" id="noteModalLabel">Nouveau note</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-row">
						<div class="col form-group">
							<label for="note_type">Type</label>
							<select name="type" id="note_type" class="form-control">
								<option value="information">Information</option>
								<option value="tache">Tâche</option>
								<option value="rappel">Rappel</option>
							</select>
						</div>
						<div class="col form-group">
							<label for="note_status">Statut</label>
							<select name="status" id="note_status" class="form-control">
								<option value="Normal">Normal</option>
								<option value="Priorité">Priorité</option>
								<option value="Urgent">Urgent</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="note_title">Titre du note</label>
						<input type="text" name="title" id="note_title" class="form-control" placeholder="Entrer le titre du note">
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
							<input type="date" name="date_due" id="due_date" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label for="note">Notes</label>
						<textarea name="content" id="note" rows="2" class="form-control"></textarea>
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
						
					</div> -->
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark px-3">Ajouter</button>
				</div>
			</div>
		</div>
	</form>
</div>
