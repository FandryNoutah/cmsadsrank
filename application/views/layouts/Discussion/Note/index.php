<?php start_section('page_title'); ?>
Discussion
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="row no-gutters h-100">

	<?php $this->load->view('layouts/discussion/sidebar'); ?>

	<div class="col" style="height: calc(100vh - 130px); overflow-y:auto;">
		<div class="container-fluid">

			<h5 class="mb-4">📥 Message Note <small>(<?= count($notes); ?> messages)</small></h5>

			<?php foreach ($notes as $note): ?>
				<div class="card mb-3">
					<div class="card-body">
						<div class="d-flex justify-content-between mb-2">
							<span class="font-weight-bold"><?= nl2br(htmlspecialchars($note->author)); ?></span>
							<span class="text-muted small"><?= nl2br(htmlspecialchars($note->date_due)); ?></span>
						</div>

						<div class="font-weight-bold mb-1"><?= htmlspecialchars($note->title); ?></div>
						<div class="text-muted small mb-2"><?= nl2br(htmlspecialchars($note->content)); ?></div>

						<div class="d-flex justify-content-between">
							<div>
								<button type="button" class="btn btn-light btn-sm mt-1 position-relative" data-toggle="modal" data-target="#noteModal" data-id="<?= $note->id; ?>">
									<i class="fa fa-eye"></i>
									<?php if ($note->count_messages > 0): ?>
										<span class="badge badge-danger position-absolute rounded-circle" style="top: -10px; right: -10px;"><?= $note->count_messages; ?></span>
									<?php endif; ?>
								</button>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<?php foreach ($note->assigned_users as $assigned_user): ?>
									<img src="<?= base_url(IMAGES_PATH . $assigned_user->photo_users); ?>" class="avatar rounded-circle" width="28" height="28" alt="Client Image">
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php $this->load->view('layouts/discussion/modal'); ?>
<?php $this->load->view('layouts/discussion/note'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
	$(function() {

		function resetDetail() {
			$('#note_detail_discussion').html("");
			$('#noteModalLabel').text("");
			$('#note_detail_due_date').removeAttr('value');
			$('#note_detail_description').text("");
			$('#note_detail_avatar').html("");
			$('#note_detail_discussion_form').removeAttr('data-id');
			$('#attachment_download').removeAttr("href");
			$('#attachment_container').addClass('d-none');
		}

		function fetch_detail(id_note) {

			$.ajax({
				type: "GET",
				url: "detail_note/" + id_note,
				dataType: "json",
				beforeSend: function() {
					resetDetail();
				},
				success: function(response) {

					let note = response.note;
					let messages = response.messages;

					$('#note_detail_discussion_form').data('id', id_note);

					$('#noteModalLabel').text("Note: " + note.title);
					$('#note_detail_due_date').val(note.date_due);
					$('#note_detail_description').text(note.content);
					$('#note_detail_type').text(note.type);
					$('#note_detail_status').text(note.status);

					let assigned_users = response.assigned_users;
					$.each(assigned_users, function(index, value) {
						let avatar = `<img src = "<?= base_url(IMAGES_PATH) ?>${value.photo_users}"width = "36"class = "rounded-circle avatar" >`;
						$('#note_detail_avatar').append(avatar);
					});

					$.each(messages, function(index, data) {

						let html = `
							<div class="d-block activity-container mt-3">
								<div class="d-flex">
									<div class="mx-1">
										<img src="${data.photo_users}" alt="" width="32">
									</div>
									<div class="flex-fill mx-1">
										<div class="d-block mb-2">
											<span class="font-weight-bold">${data.username}</span>
											${data.message}
										</div>
										<div class="d-block mb-2">
											<span class="text-muted small">${data.created_at}</span>
										</div>
									</div>
									<div class="mx-1">
										<a href="javascript:void(0);" class="text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
								</div>
							</div>
						`;

						$('#note_detail_discussion').prepend(html);
					});

					if (note.fichier_nom) {
						$('#note_attachment_download').attr('href', "<?= base_url(); ?>/" + note.fichier_nom);
						$('#note_attachment_container').removeClass('d-none');
					}
				}
			});
		}

		$('#note_detail_discussion_form').submit(function(event) {

			event.preventDefault();

			let submitter = event.originalEvent.submitter;
			let buttonChild = $(submitter).html();
			let id_note = $(this).data('id');
			
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					"id": id_note,
					"type": "note",
					"message": $('#note_detail_message').val()
				},
				dataType: "json",
				beforeSend: function() {
					$(submitter).attr('disabled', "disabled");
					$(submitter).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
				},
				success: function(response) {

					$(submitter).removeAttr("disabled");
					$(submitter).html(buttonChild);

					$('#note_detail_message').val("");
					fetch_detail(id_note);
				}
			});
		});

		$('#noteModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let id_note = $(button).attr('data-id');

			fetch_detail(id_note);
		});

		$('#noteModal').on('hide.bs.modal', function(event) {
			resetDetail();
		});
	});
</script>
<?php end_section(); ?>
