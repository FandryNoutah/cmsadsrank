<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" style="width: 640px;">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="detailModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col form-group">
						<label for="add_member">Members</label>
						<div class="d-flex align-items-center avatar-group" id="detail_avatar"></div>
					</div>
					<div class="col form-group">
						<label for="add_member">Label</label>
						<div class="d-flex align-items-center">
							<div class="mr-2" id="detail_type"></div>
							<div class="mr-2" id="detail_status"></div>
						</div>
					</div>
					<div class="col form-group">
						<label for="detail_date_due">Date due</label>
						<input type="date" name="date_due" id="detail_date_due" class="form-control">
					</div>
				</div>
				
				<!-- Remplace ta ligne existante -->
					<label>Description</label>
					<p class="text-muted" id="detail_description" style="white-space: pre-wrap;"></p>


				<div class="form-group" id="attachment_container">
					<p>Attachment</p>
					<div class="btn-group" role="group">
						<button class="btn btn-outline-dark btn-sm" type="button">
							<i class="fa fa-image"></i>
						</button>
						<a class="btn btn-outline-primary btn-sm" target="_blank" download id="attachment_download">
							Télécharger la pièce jointe
						</a>
					</div>
				</div>

				<form action="<?= site_url('Task/send_message') ?>" method="POST" id="detail_discussion_form">
					<div class="form-group input-group">
						<input type="text" class="form-control border-right-0" placeholder="Add Your Message" id="detail_message">
						<div class="input-group-append">
							<a href="#" class="btn btn-outline-secondary border-left-0 border-right-0 d-flex align-items-center">
								<i class="fa fa-paperclip"></i>
							</a>
						</div>
						<div class="input-group-append">
							<button type="submit" class="btn btn-outline-secondary border-left-0 d-flex align-items-center">
								<i class="fa fa-paper-plane"></i>
							</button>
						</div>
					</div>
				</form>

				<div class="d-flex justify-content-between">
					<label for="">Discussions</label>
					<!-- <button class="btn btn-outline-dark">Hide Activity Details</button> -->
				</div>

				<div id="detail_discussion"></div>
			</div>
			<form action="<?= site_url('Task/change_status'); ?>" method="POST" id="status_form">

				<input type="hidden" name="taskId">
				<div class="modal-footer d-flex justify-content-between">
					<select name="status" id="change_status" class="form-control w-50">
						<option value="planifié">Planifié</option>
						<option value="en cours">En cours</option>
						<option value="effectuée">Terminé</option>
					</select>
					<button type="submit" class="btn btn-dark px-3">Modifier</button>
				</div>

			</form>
		</div>
	</div>
</div>
