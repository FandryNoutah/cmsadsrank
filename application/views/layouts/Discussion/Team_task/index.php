<?php start_section('stylesheet'); ?>
<link href="<?= base_url('assets/vendors/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<style>
 * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    .sidebar2 {
      width: 220px;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 20px;
      float: left;
      min-height: 100%;
    }

    .sidebar2 h3 {
      margin-bottom: 15px;
      font-size: 14px;
      text-transform: uppercase;
      color: #555;
    }

    .sidebar2 ul {
      list-style: none;
      padding-left: 0;
    }

    .sidebar2 ul li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      font-size: 14px;
      color: #333;
      cursor: pointer;
      transition: background 0.2s;
    }

    .sidebar2 ul li:hover {
      background: #f0f0f5;
      border-radius: 6px;
      padding-left: 6px;
    }

    .label-section {
      margin-top: 30px;
    }

    /* Contenu principal */
    .main {
      margin-left: 240px; /* pour laisser la place au menu */
      padding: 20px;
    }

    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .main-header h2 {
      font-size: 18px;
    }

    .message-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .message {
      background: #fff;
      padding: 15px;
      border: 1px solid #eee;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      transition: box-shadow 0.2s;
    }

    .message:hover {
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .message-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .sender {
      font-weight: bold;
      font-size: 14px;
    }

    .date {
      font-size: 12px;
      color: #777;
    }

    .subject {
      font-size: 15px;
      margin: 8px 0;
      font-weight: 600;
    }

    .preview {
      font-size: 13px;
      color: #555;
      margin-bottom: 10px;
    }

    /* Actions */
    .actions {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      background: #f5f5f7;
      border: none;
      border-radius: 8px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .action-btn:hover {
      background: #4f46e5;
      color: white;
    }
</style>
<?php end_section(); ?>
<?php

$totalMessages = 0;

foreach ($tache as $t) {
    $totalMessages += $t->count_messages;
}
?>

<?php start_section('page_title'); ?>
Discussion
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="sidebar2">
    <h3>Menu</h3>
       <ul>
      <li><a href="<?= base_url('Discussion'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Tout les messages <span>12</span></a></li>
      <li><a href="<?= base_url('Discussion/Note'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Note <span><?= $totalMessages; ?></span></a></li>
	    <li><a href="<?= base_url('Discussion/Team_Discussion'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Team Task <span><?= $totalMessages; ?></span></a></li>
      <li><a href="<?= base_url('Discussion/Brief'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Brief <span>8</span></a></li>
      <li><a href="<?= base_url('Discussion/Temporaire'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Temporaire <span>24</span></a></li>
      <li><a href="<?= base_url('Discussion/Gtm'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> GTM <span>15</span></a></li>
      <li><a href="<?= base_url('trash'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Trash <span>28</span></a></li>
    </ul>

    <div class="label-section">
      <h3>Label</h3>
      <ul>
        <li><a href="<?= base_url('projects'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Projects</a></li>
        <li><a href="<?= base_url('customers'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Customers</a></li>
        <li><a href="<?= base_url('companies'); ?>"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>" /> Companies</a></li>
      </ul>
    </div>
</div>


<div class="main">
    <div class="main-header">
      <h2>📥 Message Team Task <small>(<?= $totalMessages; ?> messages)</small></h2>
    </div>
    <div class="message-list">
        <?php foreach($tache as $t): ?>	
          <?php if($t->count_messages != 0): ?>		
          <div class="message">
            <div class="message-header">
              <span class="sender"><?= nl2br(htmlspecialchars($t->AM_name)); ?></span>
              <span class="date"><?= htmlspecialchars($t->date_due); ?></span>
            </div>
            <div class="subject"><?= htmlspecialchars($t->title); ?></div>
            <div class="preview"><?= nl2br(htmlspecialchars($t->description)); ?></div>
            <div class="actions">
              <a href="javascript:void(0);" 
            data-toggle="modal" 
            data-target="#discussionModal" 
            data-id="<?= $t->idtask; ?>" 
            data-title="<?= $t->title; ?>">
            <span>👍 4</span>
          </a>
          <a href="javascript:void(0);" 
            data-toggle="modal" 
            data-target="#discussionModal" 
            data-id="<?= $t->idtask; ?>" 
            data-title="<?= $t->title; ?>">
            <img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="Discussion" style="width: 16px; height: 16px;">
            <span><?= $t->count_messages; ?></span>
          </a>
          </div>

          </div>
          <?php endif; ?>
        <?php endforeach; ?>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php $this->load->view('layouts/Discussion/Team_task/modal/discussion'); ?>
<?php end_section(); ?>
<script>
	$(function() {

		$('.select2').select2();

		var id_Discussion = null;

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
			$('#status_form input[name="DiscussionId"]').removeAttr("value");
		}

		function resetForm() {
			$('#DiscussionId').removeAttr('value');
			$('#formModalLabel').text("Nouveau Tache")
			$('#Discussion_form').attr('action', "<?= base_url('Discussion/insert_tache'); ?>");
			$('#Discussion_type').val("");
			$('#Discussion_status').val("");
			$('#Discussion_title').val("");
			$('#idclients').val(null).removeAttr('disabled').trigger('change');
			$('#assigned_to').val("");
			$('#date_demande').val("");
			$('#date_due').val("");
			$('#tache').val("");
			$('#Discussion_form button[type="submit"]').text("Ajouter");
		}

		function fetch_discussion() {

			if (id_Discussion != null) {

				$.ajax({
					type: "POST",
					url: "Discussion/fetch_discussion/" + id_Discussion,
					dataType: "json",
					beforeSend: function() {
						$('#Discussion_discussion').html('<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>');
					},
					success: function(response) {

						$('#Discussion_discussion').html('');
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

								$('#Discussion_discussion').append(html); // append if ascendant ; prepend if descendant
							});
						} else {
							$('#Discussion_discussion').html(`
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

		function fetch_detail(Discussion_id) {

			$.ajax({
				type: "GET",
				url: "Discussion/detail_Discussion/" + Discussion_id,
				dataType: "json",
				beforeSend: function() {
					resetDetail();
				},
				success: function(response) {

					let Discussion = response.Discussion;
					let messages = response.messages;

					$('#detailModalLabel').text("Tâche: " + Discussion.title);
					$('#detail_date_due').val(Discussion.date_due);
					$('#detail_description').text(Discussion.description);

					// let photo_users = `<img src="<?= base_url(IMAGES_PATH); ?>/${Discussion.photo_users}" class="avatar rounded-circle" width="36" height="36" alt="Client Image">`;
					let am_photo = `<img src="<?= base_url(IMAGES_PATH); ?>/${Discussion.AM_photo}" class="avatar rounded-circle" width="36" height="36" alt="Client Image">`;
					let assigned_to_photo = `<img src="<?= base_url(IMAGES_PATH); ?>/${Discussion.assigned_to_photo}" class="avatar rounded-circle" width="36" height="36" alt="Client Image">`;

					$('#detail_avatar').append([am_photo, assigned_to_photo]);

					var type = "";
					switch (Discussion.type_tache) {
						case "1":
							type = "Team Discussion";
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
					switch (Discussion.Statuts_technique) {
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

					if (Discussion.fichier_nom) {
						$('#attachment_download').attr('href', "<?= base_url(); ?>/" + Discussion.fichier_nom);
						$('#attachment_container').removeClass('d-none');
					}

					$('#change_status').val(Discussion.status);
					$('#status_form input[name="DiscussionId"]').val(Discussion.idDiscussion);
				}
			});
		}

		$('.collapse').on('show.bs.collapse', function() {

			let aria_labelled = $(this).attr('aria-labelledby');
			$('#' + aria_labelled).find('.toggle-icon')
				.removeClass('fa-chevron-down')
				.addClass('fa-chevron-up');
		});

		$('.collapse').on('hide.bs.collapse', function() {

			let aria_labelled = $(this).attr('aria-labelledby');
			$('#' + aria_labelled).find('.toggle-icon')
				.removeClass('fa-chevron-up')
				.addClass('fa-chevron-down');
		});

		$('#discussionModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let title = $(button).attr('data-title');
			id_Discussion = $(button).attr('data-id');

			$('#discussionModalLabel').html('Discussion sur: ' + title ?? "Unknown");

			fetch_discussion();
		});

		$('#discussionModal').on('hide.bs.modal', function(event) {
			id_Discussion = null;
			$('#message').val("");
		});

		$('#message_form').submit(function(event) {

			event.preventDefault();

			let submitter = event.originalEvent.submitter;
			let buttonChild = $(submitter).html();

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					"id_Discussion": id_Discussion,
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
					fetch_discussion();
				}
			});
		});

		$('#detailModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let Discussion_id = $(button).attr('data-id');
			$('#detail_discussion_form').data('id', Discussion_id);

			fetch_detail(Discussion_id);
		});

		$('#detailModal').on('hide.bs.modal', function(event) {
			resetDetail();
		});

		$('#detail_discussion_form').submit(function(event) {

			event.preventDefault();

			let submitter = event.originalEvent.submitter;
			let buttonChild = $(submitter).html();
			let Discussion_id = $(this).data('id');

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					"id_Discussion": Discussion_id,
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
					fetch_detail(Discussion_id);
				}
			});
		});

		$('#formModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let id_Discussion = $(button).attr('data-id');

			if (id_Discussion) {

				$.ajax({
					type: "GET",
					url: "Discussion/detail_Discussion/" + id_Discussion,
					dataType: "json",
					beforeSend: function() {
						resetForm();
					},
					success: function(response) {

						let Discussion = response.Discussion;

						$('#formModalLabel').text("Modification note: " + Discussion.title)
						$('#Discussion_form').attr('action', "<?= site_url('Discussion/edits_Discussion'); ?>");
						$('#Discussion_type').val(Discussion.type_tache);
						$('#Discussion_status').val(Discussion.Statuts_technique);
						$('#Discussion_title').val(Discussion.title);
						$('#idclients').val(Discussion.idclients).attr('disabled', "disabled").trigger('change');
						$('#assigned_to').val(Discussion.assigned_to);
						$('#date_demande').val(Discussion.date_demande);
						$('#date_due').val(Discussion.date_due);
						$('#tache').val(Discussion.tache);
						$('#DiscussionId').val(Discussion.idDiscussion);
						$('#Discussion_form button[type="submit"]').text("Modifier");

					}
				});

			} else {
				$('#Discussion_form button[type="submit"]').text("Ajouter");
				$('#formModalLabel').text("Nouveau Tache")
				$('#Discussion_form').attr('action', "<?= site_url('Discussion/insert_tache') ?>");
			}
		});

		$('#formModal').on('hide.bs.modal', function(event) {
			resetForm();
		});
	});
</script>

<!-- Discussion modal create -->
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
