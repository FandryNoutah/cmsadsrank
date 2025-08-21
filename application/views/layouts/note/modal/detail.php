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
						<label for="add_member">Add Labels</label>
						<div class="d-flex align-items-center">
							<div class="mr-2">
								<span class="badge alert-success p-2" style="font-size: 14px;" id="detail_type"></span>
							</div>
							<div class="mr-2">
								<span class="badge alert-warning p-2" style="font-size: 14px;" id="detail_status"></span>
							</div>
							<button type="button" class="btn btn-outline-dark rounded-circle d-block">
								<i class="fa fa-tag"></i>
							</button>
						</div>
					</div>
					<div class="col form-group">
						<label for="detail_due_date">Date due</label>
						<input type="date" name="due_date" id="detail_due_date" class="form-control">
					</div>
				</div>

				<label>Description</label>
				<p class="text-muted" id="detail_description">Monthly Product Discussion by Design and Marketing Teams with CEO to Plan our future products sales and reports</p>

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

				<hr>
				
				<div class="form-group input-group">
					<input type="text" class="form-control border-right-0" placeholder="Add Your Comment">
					<div class="input-group-append">
						<a href="#" class="btn btn-outline-secondary border-left-0 border-right-0 d-flex align-items-center">
							<i class="fa fa-paperclip"></i>
						</a>
					</div>
					<div class="input-group-append">
						<a href="#" class="btn btn-outline-secondary border-left-0 d-flex align-items-center">
							<i class="fa fa-paper-plane"></i>
						</a>
					</div>
				</div>
				
				<div class="d-flex justify-content-between">
					<span>Discussions</span>
					<!-- <button class="btn btn-outline-dark">Hide Activity Details</button> -->
				</div>
				
				<!-- foreach -->
				<div class="d-block activity-container mt-3">
					<div class="d-flex">
						<div class="mx-1">
							<img src="<?= base_url('assets/images/icons/figma/frame-5518.png') ?>" alt="" width="32">
						</div>
						<div class="flex-fill mx-1">
							<div class="d-block mb-2">
								<span class="font-weight-bold">Frank Edward</span>
								mentioned you ini a comment in
								<span class="font-weight-bold">Design Team Reports</span>
							</div>
							<div class="d-block mb-2 bg-light p-2"> <!-- Optionnal -->
								<span class="font-weight-bold">@brianf</span> have you update this design so we can use it on next meeting?
							</div>
							<div class="d-block mb-2">
								<span class="text-muted small">3 hours ago | Design Team</span>
							</div>
						</div>
						<div class="mx-1">
							<a href="javascript:void(0);" class="text-decoration-none text-muted">
								<i class="fa fa-ellipsis-h"></i>
							</a>
						</div>
					</div>
				</div>

				<div class="d-block activity-container mt-3">
					<div class="d-flex">
						<div class="mx-1">
							<img src="<?= base_url('assets/images/icons/figma/frame-5518.png') ?>" alt="" width="32">
						</div>
						<div class="flex-fill mx-1">
							<div class="d-block mb-2">
								<span class="font-weight-bold">Frank Edward</span>
								mentioned you ini a comment in
								<span class="font-weight-bold">Design Team Reports</span>
							</div>
							<!-- <div class="d-block mb-2 bg-light p-2">
								<span class="font-weight-bold">@brianf</span> have you update this design so we can use it on next meeting?
							</div> -->
							<div class="d-block mb-2">
								<span class="text-muted small">3 hours ago | Design Team</span>
							</div>
						</div>
						<div class="mx-1">
							<a href="javascript:void(0);" class="text-decoration-none text-muted">
								<i class="fa fa-ellipsis-h"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-dark px-3">Ajouter</button>
			</div>
		</div>
	</div>
</div>
