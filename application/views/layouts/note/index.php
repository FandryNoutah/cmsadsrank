<?php start_section('stylesheet'); ?>
<style>
	/* For modal attachment design */
	.file-drop-area {
		border: 2px dashed #ccc;
		border-radius: 8px;
		padding: 30px;
		text-align: center;
		cursor: pointer;
		transition: border-color 0.3s;
	}

	.file-drop-area.dragover {
		border-color: #0d6efd;
		/* bootstrap primary */
		background: #f8f9fa;
	}

	.file-drop-icon {
		font-size: 40px;
		color: #6c757d;
		margin-bottom: 10px;
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
Notes
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<div class="row mx-lg-2 my-2">
	<div class="col-auto px-1">
		<button class="btn btn-outline-dark">
			<img src="<?= base_url('assets/images/icons/figma/icon-funnelsimple.svg') ?>" alt="">
			Sort By
		</button>
	</div>
	<div class="col-auto px-1">
		<button class="btn btn-outline-dark">
			<img src="<?= base_url('assets/images/icons/figma/icon-funnel.svg') ?>" alt="">
			Filter
		</button>
	</div>
	<div class="col-auto px-1">
		<button class="btn btn-dark" data-toggle="modal" data-target="#formModal">
			<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
			Add Notes
		</button>
	</div>
</div>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
	<div class="row row-cols-3">
		<?php foreach ($notes as $note): ?>

			<div class="col">
				<div class="card h-100">
					<div class="card-body">
						<div class="row">
							<span class="col-auto mx-1 badge alert-warning">
								<?= htmlspecialchars($note->type); ?>
							</span>
							<span class="col-auto mx-1 badge alert-primary">
								<?= htmlspecialchars($note->status); ?>
							</span>
							<div class="col-auto dropdown no-arrow ml-auto">
								<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-h"></i>
								</a>
								<div class="dropdown-menu">
									<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $note->id; ?>">
										<i class="fa fa-eye mr-2"></i>
										Détails
									</button>
									<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $note->id; ?>">
										<i class="fa fa-edit mr-2"></i>
										Modifier
									</button>
									<div class="dropdown-divider"></div>
									<a href="<?= base_url('Notes/delete/' . $note->id); ?>" class="dropdown-item text-danger" data-id="<?= $note->id; ?>">
										<i class="fa fa-trash mr-2"></i>
										Supprimer
									</a>
								</div>
							</div>
						</div>
						<h6 class="my-3" style="font-size: 16px; font-weight: 500;">
							<?= htmlspecialchars($note->title); ?>
						</h6>
						<p class="text-muted">
							<?= nl2br(htmlspecialchars($note->content)); ?>
						</p>
					</div>
					<div class="card-footer d-flex justify-content-between bg-transparent">
						<?php
						echo "De: " . htmlspecialchars($note->author) . " | Pour: ";

						// $recipients = $this->Note_model->get_note_recipients($note->id);
						// echo implode(', ', array_map(function ($r) {
						// 	return htmlspecialchars($r->username);
						// }, $recipients));
						?>

						<!-- A UTILISER SI BESOIN D'IMAGE -->

						<!-- <div class="d-flex align-items-center avatar-group">
							<img src="" class="avatar rounded-circle" width="28" height="28" alt="Client Image">
							<img src="" class="avatar rounded-circle" width="28" height="28" alt="Client Image">
						</div> -->

						<span class="text-muted text-right text-nowrap"><?= $note->date_due; ?></span>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	</div>
</div>

<?php $this->load->view('layouts/note/modal/form'); ?>
<?php $this->load->view('layouts/note/modal/detail'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>

<script>
	$(function() {

		function resetDetail() {
			$('#detail_discussion').html("");
			$('#detailModalLabel').text("");
			$('#detail_due_date').removeAttr('value');
			$('#detail_description').text("");
			$('#detail_discussion_form').removeAttr('id');
		}

		function resetForm() {
			$('#formModalLabel').text("Nouveau note")
			$('#note_form').attr('action', "<?= site_url('notes/create'); ?>");
			$('#note_type').val("");
			$('#note_status').val("");
			$('#note_title').val("");
			$('#note').val("");
			$('#due_date').val("");
			$('#note_submit').html("Ajouter");
		}

		function fetchDetail(id_note) {
			$.ajax({
				type: "GET",
				url: "Notes/detail_note/" + id_note,
				dataType: "json",
				beforeSend: function() {
					resetDetail();
				},
				success: function(response) {

					let note = response.note;
					let messages = response.messages;

					$('#detailModalLabel').text("Note: " + note.title);
					$('#detail_due_date').val(note.date_due);
					$('#detail_description').text(note.content);
					$('#detail_type').text(note.type);
					$('#detail_status').text(note.status);

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

						$('#detail_discussion').prepend(html);
					});
				}
			});
		}

		$('#detailModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let id_note = $(button).attr('data-id');
			$('#detail_discussion_form').data('id', id_note);

			fetchDetail(id_note);
		});

		$('#detailModal').on('hide.bs.modal', function(event) {
			resetDetail();
		});

		$('#formModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let id_note = $(button).attr('data-id');

			if (id_note) {

				$('#note_form button[type="submit"]').text("Modifier");

				$.ajax({
					type: "GET",
					url: "Notes/detail_note/" + id_note,
					dataType: "json",
					beforeSend: function() {
						resetForm();
					},
					success: function(response) {

						let note = response.note;
						$('#formModalLabel').text("Modification note: " + note.title)
						$('#note_form').attr('action', "<?= site_url('notes/edit/'); ?>" + note.id);
						$('#note_type').val(note.type);
						$('#note_status').val(note.status);
						$('#note_title').val(note.title);
						$('#note').val(note.content);
						$('#due_date').val(note.date_due);
					}
				});
			} else {
				$('#note_form button[type="submit"]').text("Ajouter");
				$('#formModalLabel').text("Nouveau note")
				$('#note_form').attr('action', "<?= site_url('notes/create') ?>");
			}

		});

		$('#formModal').on('hide.bs.modal', function(event) {
			resetForm();
		});
	});
</script>

<!-- Attachment script -->
<script>
	$(function() {
		const dropArea = $("#fileDrop");
		const input = $("#fileInput");
		const fileName = $("#fileName");

		// Click to trigger input
		dropArea.click(function() {
			console.log("here");

			input.click();
		});

		// Drag & drop events
		dropArea.on("dragover", function(e) {
			e.preventDefault();
			e.stopPropagation();
			dropArea.addClass("dragover");
		});

		dropArea.on("dragleave drop", function(e) {
			e.preventDefault();
			e.stopPropagation();
			dropArea.removeClass("dragover");
		});

		dropArea.on("drop", function(e) {
			let file = e.originalEvent.dataTransfer.files[0]; // just one file
			input[0].files = e.originalEvent.dataTransfer.files;
			showFile(file);
		});

		input.on("change", function() {
			if (this.files[0]) {
				showFile(this.files[0]);
			}
		});

		function showFile(file) {
			fileName.text(file.name);
		}
	});
</script>
<?php end_section(); ?>
