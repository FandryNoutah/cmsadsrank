<?php start_section('stylesheet'); ?>
<style>
	.section-title {
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 8px;
	}

	.toggle {
		--w: 38px;
		--h: 20px;
		position: relative;
	}

	.switch {
		width: var(--w);
		height: var(--h);
		border-radius: 999px;
		background: #E6E6E6;
		display: inline-block;
		position: relative;
		transition: background .18s ease;
	}

	.knob {
		--size: 14px;
		width: var(--size);
		height: var(--size);
		border-radius: 50%;
		background: black;
		position: absolute;
		top: 50%;
		transform: translate(4px, -50%);
		transition: transform .18s ease, background .18s ease;
	}

	input[type="checkbox"] {
		position: absolute;
		opacity: 0;
		pointer-events: none;
	}

	input[type="checkbox"]:checked+.switch {
		background: #111;
	}

	input[type="checkbox"]:checked+.switch .knob {
		transform: translate(calc(var(--w) - 18px), -50%);
		background: #fff;
	}

	label.toggle {
		cursor: pointer;
		display: inline-flex;
		align-items: center;
	}

	.toggle-label {
		font-size: 14px;
		font-weight: 500;
		margin-left: 8px;
	}
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100">
		<?php $this->load->view('layouts/client/detail/sidebar'); ?>
		<div class="col w-100">
			<div class="container-fluid">
				<br>
				<div class="d-flex justify-content-between">
					<h1 style="font-size: 48px;">Tâches en cours | <?php echo $donnees[0]['nom_client'] ?></h1>

				</div><br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr class="text-muted">
								<th>Label</th>
								<th>Date de la demande</th>
								<th>Date due</th>
								<th>Description</th>
								<th>Status</th>
								<th>
									<!-- Actions -->
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="6">
									<a href="#" class="text-dark">
										<i class="fa fa-plus"></i>
										New Task
									</a>
								</td>
							</tr>
							<?php if ($task != NULL): ?>
								<?php foreach ($task as $t): ?>
									<tr>
										<td class="align-middle" style="font-weight: 500;"><?php echo $t->title; ?></td>
										<td class="align-middle text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?php echo $t->date_demande; ?>
										</td>
										<td class="align-middle text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?php echo $t->date_due; ?>
										</td>
										<td class="align-middle text-muted">
											<?php echo $t->description; ?>
										</td>

										<td class="align-middle">
											<span class="badge alert-warning rounded-pill px-3 py-2" style="font-size: 12px; font-weight: 500;">
												<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
												Planned
											</span>
										</td>
										<td>
											<a href="javascript:void(0);" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
												<i class="fa fa-ellipsis-v"></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>

						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('layouts/task/modal/detail'); ?>
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
			$('#detail_type').html("");
			$('#detail_status').html("");
			$('#detail_avatar').html("");
		}

		function fetch_detail(task_id) {

			$.ajax({
				type: "GET",
				url: "<?= base_url('Task/detail_task/') ?>"+ task_id,
				dataType: "json",
				beforeSend: function() {
					resetDetail();
				},
				success: function(response) {

					let task = response.task;
					let messages = response.messages;

					$('#detailModalLabel').text("Tâche: " + task.title);
					$('#detail_due_date').val(task.date_due);
					$('#detail_description').text(task.description);

					let photo_users = `<img src="<?= base_url(IMAGES_PATH); ?>/${task.photo_users}" class="avatar rounded-circle" width="36" height="36" alt="Client Image">`;
					// let assigned_photo = `<img src="<?= base_url(IMAGES_PATH); ?>/${task.assigned_to_photo}" class="avatar rounded-circle" width="28" height="28" alt="Client Image">`;

					$('#detail_avatar').append(photo_users);

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
				}
			});
		}

		$('#detailModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let task_id = $(button).attr('data-id');
			$('#detail_discussion_form').data('id', task_id);

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
					"id_task": task_id,
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

<script>
	document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
		cb.addEventListener('change', e => {
			console.log('Toggle changed:', e.target.checked);
		});
	});
	document.getElementById('toggle_procedure').addEventListener('change', function(e) {
		var checked = e.target.checked;
		fetch('<?php echo site_url('Client/activer_processus_tache'); ?>', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: 'etat=' + (checked ? 1 : 0)
			})
			.then(response => response.text())
			.then(data => {
				console.log('Réponse serveur:', data);
			})
			.catch(err => {
				console.error('Erreur:', err);
			});
	});
</script>
<?php end_section(); ?>
