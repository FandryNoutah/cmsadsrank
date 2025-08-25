<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
	<form action="<?php echo base_url("Task/insert_tache") ?>" enctype="multipart/form-data" method="post">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<?php $current_user = $this->ion_auth->user()->row(); ?>
				<input type="hidden" name="am" value="<?php echo $current_user->id ?>">
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
							<select name="type_tache" id="task_type" class="form-control">
								<option value="1">Team task</option>
								<option value="2">Temporaire</option>
								<option value="3">GTM</option>
							</select>
						</div>
						<div class="col form-group">
							<label for="task_status">Statut</label>
							<select name="Statuts_technique" id="task_status" class="form-control">
								<option value="1">Normal</option>
								<option value="2">Priorité</option>
								<option value="3">Urgent</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="task_title">Titre du tâche</label>
						<input type="text" name="title" id="task_title" class="form-control" placeholder="Entrer le titre du tâche">
					</div>
					<div class="form-group">
						<label for="task_title">Client</label>
						<select name="idclients" id="client_select" class="form-control" style="width: 100%;">
							<?php foreach ($donnee as $d): ?>
								<option value="<?php echo $d->idclients; ?>" data-budget="<?php echo $d->budget; ?>">
									<?php echo htmlspecialchars($d->nom_client); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-row">
						<div class="col form-group">
							<label for="task_status">To</label>
							<select name="assigned_to" id="task_status" class="form-control">
								<?php foreach ($users as $u): ?>
									<option value="<?php echo $u['id'] ?>"><?php echo $u['first_name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col form-group">
							<label for="exampleInputEmail1">Date de la demande</label>
							<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_demande">
						</div>



						<div class="col form-group">
							<label for="due_date">Date due</label>
							<input type="date" name="date_due" id="due_date" class="form-control">
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
						<input type="file" id="fileInput" class="d-none" name="fichier">
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
	<script>
		function setDefaultDate() {
			const today = new Date();
			const yyyy = today.getFullYear();
			let mm = today.getMonth() + 1;
			let dd = today.getDate();
			if (mm < 10) mm = '0' + mm;
			if (dd < 10) dd = '0' + dd;

			const formattedDate = yyyy + '-' + mm + '-' + dd;
			document.getElementById('exampleInputEmail1').value = formattedDate;
		}
		window.onload = setDefaultDate;
	</script>
</div>
