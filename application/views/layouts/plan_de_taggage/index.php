<?php start_section('stylesheet'); ?>
<style>
	/* .table-wrapper {
		border-collapse: separate !important;
		border-spacing: 0 10px;
	}

	.table-wrapper tr {
		background: #fff;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
		border-radius: 8px;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		padding: 1rem;
	} */

	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		border: border;
		border-bottom: 1px solid #dee2e6 !important;
	}

	.table-wrapper tbody tr td:first-child,
	.table-wrapper thead tr th:first-child {
		border-left: 1px solid #dee2e6;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.table-wrapper tbody tr td:last-child,
	.table-wrapper thead tr th:last-child {
		border-right: 1px solid #dee2e6;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
Plan de taggage
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
</div>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
		<div class="table-responsive">

			<table class="table table-wrapper">
				<thead class="bg-light text-muted">
					<tr>
						<th>
							AM
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Client
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Plan de taggage
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Etat
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($donnee as $C): ?>
					<tr>
						
						<td style="text-align: center">
							<img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->photo_users)); ?>" alt="avatar" style="width: 40px;" class="avatar-image">
							<a style="display: none"><?php echo htmlspecialchars($C->nomam); ?></a>
						</td>
						<td style="text-align: center"><?php echo htmlspecialchars($C->nom_client); ?></td>  
						<td style="text-align: center"><?php echo anchor('Plan_de_taggage/plandetaggage/' . $C->idclients, 'Voir plan', ['style' => 'color: black', 'data-edit' => $C->idclients]); ?></td>
						<td style="text-align: center"></td>  
						<td style="text-align: center"></td>  
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
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
