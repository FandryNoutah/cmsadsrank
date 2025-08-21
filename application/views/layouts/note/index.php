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
		<button class="btn btn-dark" data-toggle="modal" data-target="#noteModal">
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
						<a href="javascript:void(0);" class="stretched-link" data-id="<?= $note->id; ?>" data-toggle="modal" data-target="#detailModal"></a>
						<div class="row">
							<span class="col-auto mx-1 badge alert-warning">
								<?= htmlspecialchars($note->type); ?>
							</span>
							<span class="col-auto mx-1 badge alert-primary">
								<?= htmlspecialchars($note->status); ?>
							</span>
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

						<span class="text-muted text-right text-nowrap">Mar 5, 04:25</span>
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

		function fetchDetail(task_id) {
			$.ajax({
				type: "GET",
				url: "Notes/detail_note/" + task_id,
				dataType: "json",
				success: function (response) {
					
					let note = response.note;
					let messages = response.messages;

					$('#detailModalLabel').text("Tâche: " + note.title);
					$('#detail_due_date').val(note.date_due);
					$('#detail_description').text(note.description);

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
			let task_id = $(button).attr('data-id');
			$('#detail_discussion_form').data('id', task_id);

			fetchDetail(task_id);
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
