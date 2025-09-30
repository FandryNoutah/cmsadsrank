<?php start_section('page_title'); ?>
Discussion
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="row no-gutters h-100">

	<?php $this->load->view('layouts/discussion/sidebar'); ?>

	<div class="col" style="height: calc(100vh - 130px); overflow-y:auto;">
		<div class="container-fluid">

			<h5 class="mb-4">📥 Message Team Task <small>(<?= count($tasks); ?> messages)</small></h5>

			<div class="message-list">
				<?php foreach ($tasks as $task): ?>
					<?php if ($task->count_messages > 0): ?>
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex justify-content-between mb-2">
									<span class="font-weight-bold"><?= nl2br(htmlspecialchars($task->username)); ?></span>
									<span class="text-muted small"><?= nl2br(htmlspecialchars($task->date_due)); ?></span>
								</div>

								<div class="font-weight-bold mb-1"><?= htmlspecialchars($task->title); ?></div>
								<div class="text-muted small mb-2"><?= nl2br(htmlspecialchars($task->description)); ?></div>

								<button class="btn btn-light btn-sm mt-1">👍 4</button>
								<button class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#discussionModal" data-id="<?= $task->idtask; ?>">
									💬
									<?= $task->count_messages; ?>
								</button>
								<button type="button" class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#detailModal" data-id="<?= $task->idtask; ?>">
									<i class="fa fa-eye"></i>
								</button>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layouts/discussion/modal'); ?>
<?php $this->load->view('layouts/discussion/detail'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
	$(function() {

		function resetDetail() {
			$('#detail_discussion').html("");
			$('#detailModalLabel').text("");
			$('#detail_date_due').removeAttr('value');
			$('#detail_description').text("");
			$('#detail_discussion_form').removeAttr('id');
			$('#detail_type').html("");
			$('#detail_status').html("");
			$('#detail_avatar').html("");
			$('#attachment_download').removeAttr("href");
			$('#attachment_container').addClass('d-none');
			$('#change_status').removeAttr("value")
			$('#status_form input[name="taskId"]').removeAttr("value");
		}

		function fetch_detail(task_id) {

			$.ajax({
				type: "GET",
				url: "detail_task/" + task_id,
				dataType: "json",
				beforeSend: function() {
					resetDetail();
				},
				success: function(response) {

					let task = response.task;

					$('#detailModalLabel').text("Tâche: " + task.title);
					$('#detail_date_due').val(task.date_due);
					$('#detail_description').text(task.description);

					// let photo_users = `<img src="<?= base_url(IMAGES_PATH); ?>/${task.photo_users}" class="avatar rounded-circle bg-white" width="36" height="36" alt="Client Image">`;
					let am_photo = `<img src="<?= base_url(IMAGES_PATH); ?>/${task.AM_photo}" class="avatar rounded-circle bg-white" width="36" height="36" alt="Client Image">`;
					let assigned_to_photo = `<img src="<?= base_url(IMAGES_PATH); ?>/${task.assigned_to_photo}" class="avatar rounded-circle bg-white" width="36" height="36" alt="Client Image">`;

					$('#detail_avatar').append([am_photo, assigned_to_photo]);

					var type = "";
					switch (task.type_tache) {
						case "1":
							type = "Team Task";
							break;
						case "2":
							type = "Temporaire";
							break;
						case "3":
							type = "GTM";
							break;
						case "4":
							type = "Plan de taggage";
							break;
					}

					$('#detail_type').html(`<span class="badge alert-success p-2" style="font-size: 14px;">${type}</span>`);

					var status = "";
					var status_color = "";
					switch (task.Statuts_technique) {
						case "1":
							status = "Normal";
							status_color = "success";
							break;
						case "2":
							status = "Priorité";
							status_color = "warning";
							break;
						case "3":
							status = "Urgent";
							status_color = "danger";
							break;
					}

					$('#detail_status').html(`<span class="badge alert-${status_color} p-2" style="font-size: 14px;">${status}</span>`);

					if (task.fichier_nom) {
						$('#attachment_download').attr('href', "<?= base_url(); ?>/" + task.fichier_nom);
						$('#attachment_container').removeClass('d-none');
					}

					$('#change_status').val(task.status);
					$('#status_form input[name="taskId"]').val(task.idtask);
				}
			});
		}

		function fetch_discussion(id) {

			$.ajax({
				type: "POST",
				url: "<?= site_url('Discussion/fetch_discussion'); ?>",
				data: {
					"id": id,
				},
				dataType: "json",
				beforeSend: function() {
					$('#task_discussion').html('<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>');
				},
				success: function(response) {

					$('#task_discussion').html('');
					if (response.length > 0) {
						$.each(response, function(index, data) {

							let owner = data.owner;

							let alignment = owner ? "justify-content-end" : "justify-content-start";
							let color = owner ? "bg-dark text-white" : "bg-light border";
							let sender = owner ? "You" : data.username;
							let float = owner ? "float-right" : "float-left";

							let html = `
								<div class="d-flex ${alignment}">
									<div class="message_container mt-3" style="max-width: 75%;">
										<span class="small text-muted d-block">${sender} ${data.created_at}</span>
										<div class="p-2 ${color} rounded ${float}" style="width: fit-content;">
											${data.message}
										</div>
									</div>
								</div>
							`;

							$('#task_discussion').append(html); // append if ascendant ; prepend if descendant
						});
					} else {
						$('#task_discussion').html(`
							<div class="alert alert-light" role="alert">
								Aucune discussion pour le moment!
							</div>
						`);
					}

					let modalBody = $('#discussionModal .modal-body'); // current open modal body
					modalBody.scrollTop(modalBody[0].scrollHeight);
				}
			});
		}

		$('#discussionModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);

			let title = $(button).attr('data-title');
			let id = $(button).attr('data-id');
			let action = $(button).attr('data-action');

			$('#detail_discussion_form').attr('data-id', id);
			$('#message_form').attr('data-id', id);

			$('#discussionModalLabel').html('Discussion sur: ' + title ?? "Unknown");

			fetch_discussion(id);
		});

		$('#discussionModal').on('hide.bs.modal', function(event) {
			$('#message').val("");
			$('#message').removeAttr("data-id");
			$('#message_form').removeAttr("data-id");
		});

		$('#message_form').submit(function(event) {

			event.preventDefault();

			let submitter = event.originalEvent.submitter;
			let buttonChild = $(submitter).html();
			let id = $(this).data('id');

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					"id": id,
					"type": "team_task",
					"message": $('#message').val()
				},
				dataType: "json",
				beforeSend: function() {
					$(submitter).attr('disabled', "disabled");
					$(submitter).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
				},
				success: function(response) {

					$(submitter).removeAttr("disabled");
					$(submitter).html(buttonChild);

					$('#message').val("");
					fetch_discussion(id);
				}
			});
		});

		$('#detailModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let task_id = $(button).attr('data-id');
			$('#detail_discussion_form').data('id', task_id);

			fetch_detail(task_id);
		});

		$('#detailModal').on('hide.bs.modal', function(event) {
			resetDetail();
		});
	});
</script>
<?php end_section(); ?>
