<?php start_section('page_title'); ?>
Discussion
<?php end_section(); ?>

<?php start_section('content'); ?>


<div class="row no-gutters h-100">

	<?php $this->load->view('layouts/discussion/sidebar'); ?>

	<div class="col" style="height: calc(100vh - 130px); overflow-y:auto;">
		<div class="container-fluid">
			<h5 class="mb-4">📥 Message Team Task <small>(<?= count($tasks); ?> messages)</small></h5>

			<?php foreach ($tasks as $task): ?>
				<?php if ($task->count_messages > 0): ?>
					<div class="card mb-3">
						<div class="card-body">
							<div class="d-flex justify-content-between mb-2">
								<span class="font-weight-bold"><?= nl2br(htmlspecialchars($task->nom_client)); ?></span>
								<span class="text-muted small"><?= nl2br(htmlspecialchars($task->date_due)); ?></span>
							</div>

							<div class="font-weight-bold mb-1"><?= htmlspecialchars($task->title); ?></div>
							<div class="text-muted small mb-2"><?= nl2br(htmlspecialchars($task->description)); ?></div>

							<div class="d-flex justify-content-between">
								<div>
									<button type="button" class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#discussionModal" data-type="task" data-id="<?= $task->idtask; ?>">
										💬
										<?= $task->count_messages; ?>
									</button>
									<button type="button" class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#detailModal" data-id="<?= $task->idtask; ?>">
										<i class="fa fa-eye"></i>
									</button>
								</div>
								<div class="d-flex align-items-center avatar-group">
									<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($task->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
									<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($task->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

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

					$('#detail_discussion_form').data('id', task_id);
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

					if (task.fichier_nom) {
						$('#attachment_download').attr('href', "<?= base_url(); ?>/" + task.fichier_nom);
						$('#attachment_container').removeClass('d-none');
					}

					$('#change_status').val(task.status);
					$('#status_form input[name="taskId"]').val(task.idtask);
				}
			});
		}

		$('#detailModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let task_id = $(button).attr('data-id');

			fetch_detail(task_id);
		});

		$('#detailModal').on('hide.bs.modal', function(event) {
			resetDetail();
		});

		$('#detail_discussion_form').submit(function(event) {

			event.preventDefault();

			let submitter = event.originalEvent.submitter;
			let buttonChild = $(submitter).html();
			let task_id = $(this).data('id');

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					"id": task_id,
					"message": $('#detail_message').val()
				},
				dataType: "json",
				beforeSend: function() {
					$(submitter).attr('disabled', "disabled");
					$(submitter).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
				},
				success: function(response) {

					$(submitter).removeAttr("disabled");
					$(submitter).html(buttonChild);

					$('#detail_message').val("");
					fetch_detail(task_id);
				}
			});
		});
	});
</script>
<?php end_section(); ?>
