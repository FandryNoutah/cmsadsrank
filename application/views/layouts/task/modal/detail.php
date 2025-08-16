<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="detailModalLabel">Détails tâche</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col form-group">
						<h6 for="add_member">Members</h6>
						<div class="d-flex align-items-center avatar-group">
							<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="36" class="rounded-circle avatar" alt="Avatar 1">
							<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="36" class="rounded-circle avatar" alt="Avatar 2">
							<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="36" class="rounded-circle avatar" alt="Avatar 3">
							<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="36" class="rounded-circle avatar" alt="Avatar 4">
							<button type="button" class="btn btn-outline-dark rounded-circle d-block ml-2 py-2">
								<i class="fa fa-user-plus"></i>
							</button>
						</div>
					</div>
					<div class="col form-group">
						<h6 for="add_member">Add Labels</h6>
						<div class="d-flex align-items-center">
							<div class="mr-2">
								<span class="badge alert-success p-2" style="font-size: 14px;">Internal</span>
							</div>
							<div class="mr-2">
								<span class="badge alert-warning p-2" style="font-size: 14px;">Marketing</span>
							</div>
							<button type="button" class="btn btn-outline-dark rounded-circle d-block">
								<i class="fa fa-tag"></i>
							</button>
						</div>
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
</div>
