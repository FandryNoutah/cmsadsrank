<div class="modal fade" id="discussionModal" tabindex="-1" aria-labelledby="discussionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="discussionModalLabel">Discussion</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" id="task_discussion"></div>

			<form action="<?= site_url('Task/send_message') ?>" method="POST" id="message_form">
				<div class="modal-footer">
					<div class="d-flex w-100">
						<div class="flex-grow-1 px-1">
							<input name="message" id="message" class="form-control" style="resize: none;" placeholder="Type a message ...">
						</div>
						<div class="px-1">
							<button class="btn btn-dark" type="submit">
								Envoyer
								<i class="fa fa-paper-plane"></i>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
