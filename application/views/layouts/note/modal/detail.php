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
						<label for="add_member">Add Labels</label>
						<div class="d-flex align-items-center">
							<div class="mr-2">
								<span class="badge alert-success p-2" style="font-size: 14px;" id="detail_type"></span>
							</div>
							<div class="mr-2">
								<span class="badge alert-warning p-2" style="font-size: 14px;" id="detail_status"></span>
							</div>
						</div>
					</div>
					<div class="col form-group">
						<label for="detail_due_date">Date due</label>
						<input type="date" name="due_date" id="detail_due_date" class="form-control">
					</div>
				</div>

				<label>Description</label>
				<p class="text-muted" id="detail_description">Monthly Product Discussion by Design and Marketing Teams with CEO to Plan our future products sales and reports</p>

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

				<form action="<?= site_url('Notes/send_message') ?>" method="POST" id="detail_discussion_form">
					<div class="form-group input-group">
						<input type="text" class="form-control border-right-0" placeholder="Add Your Message" id="detail_message">
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
			<!-- <div class="modal-footer">
				<button type="submit" class="btn btn-dark px-3">Ajouter</button>
			</div> -->
		</div>
	</div>
</div>
