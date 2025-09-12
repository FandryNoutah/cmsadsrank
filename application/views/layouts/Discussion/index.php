<?php start_section('page_title'); ?>
Discussion
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="row no-gutters h-100">

	<?php $this->load->view('layouts/discussion/sidebar'); ?>

	<div class="col" style="height: calc(100vh - 130px); overflow-y:auto;">
		<div class="container-fluid">

			<h5 class="mb-4">📥 Message note <small>(12 messages)</small></h5>

			<?php foreach ($notes as $note): ?>
				<div class="card mb-3">
					<div class="card-body">
						<div class="d-flex justify-content-between mb-2">
							<span class="font-weight-bold"><?= nl2br(htmlspecialchars($note->author)); ?></span>
							<span class="text-muted small"><?= nl2br(htmlspecialchars($note->date_due)); ?></span>
						</div>

						<div class="font-weight-bold mb-1"><?= htmlspecialchars($note->title); ?></div>
						<div class="text-muted small mb-2"><?= nl2br(htmlspecialchars($note->content)); ?></div>

						<button class="btn btn-light btn-sm mt-1">👍 4</button>
						<button class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#discussionModal">💬 2</button>

					</div>
				</div>
			<?php endforeach; ?>

			<h5 class="mb-4">📥 Message tâche <small>(12 messages)</small></h5>

			<?php foreach ($taches as $tache): ?>
				<div class="card mb-3">
					<div class="card-body">
						<div class="d-flex justify-content-between mb-2">
							<span class="font-weight-bold"><?= nl2br(htmlspecialchars($tache->AM_photo)); ?></span>
							<span class="text-muted small"><?= nl2br(htmlspecialchars($tache->date_due)); ?></span>
						</div>

						<div class="font-weight-bold mb-1"><?= htmlspecialchars($tache->title); ?></div>
						<div class="text-muted small mb-2"><?= nl2br(htmlspecialchars($tache->description)); ?></div>

						<button class="btn btn-light btn-sm mt-1">👍 4</button>
						<button class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#discussionModal">💬 2</button>

					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php $this->load->view('layouts/discussion/modal'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>

	$(function() {

		function fetch_discussion() {

			if (id_task != null) {

				$.ajax({
					type: "POST",
					url: "Task/fetch_discussion/" + id_task,
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
		}

		$('#discussionModal').on('show.bs.modal', function() {
			
		});
	});
</script>
<?php end_section(); ?>
