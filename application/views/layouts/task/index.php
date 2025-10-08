<?php start_section('stylesheet'); ?>
<link href="<?= base_url('assets/vendors/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<style>
	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		border: border;
		border-bottom: 1px solid #dee2e6 !important;
		padding: 14px !important;
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

	.table-synced th:nth-child(2),
	.table-synced td:nth-child(2) {
		width: 15%;
	}

	.table-synced th:nth-child(3),
	.table-synced td:nth-child(3) {
		width: 15%;
	}

	.table-synced th:nth-child(4),
	.table-synced td:nth-child(4) {
		width: 15%;
	}

	.table-synced th:nth-child(5),
	.table-synced td:nth-child(5) {
		width: 10%;
	}

	.table-synced th:nth-child(6),
	.table-synced td:nth-child(6) {
		width: 10%;
	}

	.table-synced th:nth-child(7),
	.table-synced td:nth-child(7) {
		width: 5%;
	}

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
<h1 class="h4">Task</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<li class="nav-item">
		<a class="nav-link py-3 active" type="button" id="list_tab" data-toggle="tab" data-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">
			<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
			List
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" type="button" id="kanban_tab" data-toggle="tab" data-target="#kanban" type="button" role="tab" aria-controls="kanban" aria-selected="false">
			<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
			Kanban
		</a>
	</li>
</ul>

<div class="row mx-lg-2">
	<div class="col-auto px-1">
		<select id="task_type_filter" class="custom-select border-dark">
			<option disabled selected>Filter</option>
			<option value="0">All Task</option>
			<option value="1">Team Task</option>
			<option value="2">Temporaire</option>
			<option value="3">GTM</option>
			<option value="7">Résiliation</option>
			<option value="8">Mise en pause</option>
			<option value="9">Relance</option>
			<option value="5">Upsell</option>
			<option value="6">Baisse</option>
		</select>
	</div>
	<div class="col-auto px-1">
		<select id="task_user_filter" class="custom-select border-dark">
			<option disabled selected>Filter</option>
			<option value="0">Tous</option>
			<?php foreach ($users as $u): ?>
				<option value="<?= $u['id']; ?>"><?= $u['first_name'] . " " . $u['last_name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col-auto px-1">
		<button class="btn btn-dark" data-toggle="modal" data-target="#formModal">
			<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
			Add Task
		</button>
	</div>
</div>

<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
	<div class="btn-group btn-group-toggle my-4" data-toggle="buttons">
		<label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="all" checked>
			All Task
		</label>
		<label class="btn btn-white rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="expired">
			<i class="fa fa-circle mr-2 text-danger" style="font-size: 10px; color: #AF4B4B;"></i>
			En Retard
		</label>
		<label class="btn btn-white rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="urgent">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #AF4B4B;"></i>
			Urgent
		</label>
	</div>

	<div class="tab-content" id="taskTabContent">

		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">

			<a class="text-decoration-none w-100" id="headingOne" role="button" data-toggle="collapse" data-target="#collapsePlanned" aria-expanded="true" aria-controls="collapsePlanned">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-warning" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">Planifié</span>
					<span class="text-muted"><?= $count_planned; ?> open tasks</span>
				</p>
			</a>

			<div id="collapsePlanned" class="collapse show" aria-labelledby="headingOne">

				<table class="table table-wrapper table-synced w-100" id="planned_table">
					<tbody>
						<?php foreach ($tache as $t):  ?>
							<?php if ($t->status == "planifié"): ?>
								<tr class="task-filter" data-type="<?= $t->type_tache ?>" data-am="<?= $t->AM; ?>" data-assigned="<?= $t->assigned_to ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= $t->Statuts_technique == 3; ?>">
								<td>
										<h6 class="mb-0 ml-3">
											<?= $t->nom_client; ?>
										</h6>
									</td>
									<td>
										<span class="text-muted">
											<?= $t->title; ?>
										</span>
									</td>
									<td>
										<span class="text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?= $t->date_due; ?>
										</span>
									</td>
									
									<td>
										<div class="row">
											<?php if ($t->type_tache == 1): ?>
													<div class="mr-2">
														<span class="badge alert-success">Team task</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 2): ?>
													<div class="mr-2">
														<span class="badge alert-success">Temporaire</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 3): ?>
													<div class="mr-2">
														<span class="badge alert-success">GTM</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 4): ?>
													<div class="mr-2">
														<span class="badge alert-success">Plan de taggage</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 5): ?>
													<div class="mr-2">
														<span class="badge alert-success">Upsell</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 6): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Baisse</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 7): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Résiliation</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 8): ?>
													<div class="mr-2">
														<span class="badge alert-warning">Mise en pause</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 9): ?>
													<div class="mr-2">
														<span class="badge alert-success">Relance</span>
													</div>
												<?php endif; ?>
											<?php if ($t->Statuts_technique == 3): ?>
												<span class="col-auto mx-1 badge alert-danger">Urgent</span>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="d-flex align-items-center avatar-group">
											<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
											<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
										</div>
									</td>
									<td>
										<div class="row">
											<span class="col-auto">
												<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask; ?>" data-title="<?= $t->title; ?>">
													<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
													<?= $t->count_messages; ?>
												</a>
											</span>
											<?php if ($t->fichier_nom != null): ?>
												<span class="col-auto">
													<a href="#" class="text-muted">
														<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
													</a>
												</span>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="dropdown no-arrow">
											<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-ellipsis-v"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
													<i class="fa fa-eye mr-2"></i>
													Détails
												</button>
												<?php if ($this->current_user->id === $t->AM): ?>
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $t->idtask; ?>">
													<i class="fa fa-edit mr-2"></i>
													Modifier
												</button>
												<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger">
													<i class="fa fa-trash mr-2"></i>
													Supprimer
												</a>
												<?php endif; ?>
											</div>
										</div>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>

			<hr>

			<a class="text-decoration-none w-100" id="headingTwo" role="button" data-toggle="collapse" data-target="#collapseUpcoming" aria-expanded="true" aria-controls="collapseUpcoming">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-primary" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">En Cours</span>
					<span class="text-muted"><?= $count_upcoming; ?> open tasks</span>
				</p>
			</a>

			<div id="collapseUpcoming" class="collapse show" aria-labelledby="headingTwo">

				<table class="table table-wrapper table-synced w-100" id="upcoming_table">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if ($t->status == "en cours"): ?>
								<tr class="task-filter" data-type="<?= $t->type_tache ?>" data-am="<?= $t->AM; ?>" data-assigned="<?= $t->assigned_to ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= $t->Statuts_technique == 3; ?>">
									<td>
										<h6 class="mb-0 ml-3">
											<?= $t->nom_client; ?>
										</h6>
									</td>
									<td>
										<span class="text-muted">
											<?= $t->title; ?>
										</span>
									</td>
									
									<td>
										<span class="text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?= $t->date_due; ?>
										</span>
									</td>
									<td>
										<div class="row">
											<?php if ($t->type_tache == 1): ?>
													<div class="mr-2">
														<span class="badge alert-success">Team task</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 2): ?>
													<div class="mr-2">
														<span class="badge alert-success">Temporaire</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 3): ?>
													<div class="mr-2">
														<span class="badge alert-success">GTM</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 4): ?>
													<div class="mr-2">
														<span class="badge alert-success">Plan de taggage</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 5): ?>
													<div class="mr-2">
														<span class="badge alert-success">Upsell</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 6): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Baisse</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 7): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Résiliation</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 8): ?>
													<div class="mr-2">
														<span class="badge alert-warning">Mise en pause</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 9): ?>
													<div class="mr-2">
														<span class="badge alert-success">Relance</span>
													</div>
												<?php endif; ?>
											<?php if ($t->Statuts_technique == 3): ?>
												<span class="col-auto mx-1 badge alert-danger">Urgent</span>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="d-flex align-items-center avatar-group">
											<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
										</div>
									</td>
									<td>
										<div class="row">
											<span class="col-auto">
												<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask; ?>" data-title="<?= $t->title; ?>">
													<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
													<?= $t->count_messages; ?>
												</a>
											</span>
											<?php if ($t->fichier_nom != null): ?>
												<span class="col-auto">
													<a href="#" class="text-muted">
														<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
													</a>
												</span>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="dropdown no-arrow">
											<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-ellipsis-v"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
													<i class="fa fa-eye mr-2"></i>
													Détails
												</button>
												<?php if ($this->current_user->id === $t->AM): ?>
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $t->idtask; ?>">
													<i class="fa fa-edit mr-2"></i>
													Modifier
												</button>
												<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger">
													<i class="fa fa-trash mr-2"></i>
													Supprimer
												</a>
												<?php endif; ?>
											</div>
										</div>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<hr>

			<a class="text-decoration-none w-100" id="headingThree" role="button" data-toggle="collapse" data-target="#collapseCompleted" aria-expanded="true" aria-controls="collapseCompleted">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-success" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">Terminé</span>
					<span class="text-muted"><?= $count_completed; ?> open tasks</span>
				</p>
			</a>

			<div id="collapseCompleted" class="collapse show" aria-labelledby="headingThree">

				<table class="table table-wrapper table-synced w-100" id="completed_table">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if ($t->status == "effectuée"): ?>
								<tr class="task-filter" data-type="<?= $t->type_tache ?>" data-am="<?= $t->AM; ?>" data-assigned="<?= $t->assigned_to ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= $t->Statuts_technique == 3; ?>">
									<td>
										<h6 class="mb-0 ml-3">
											<?= $t->nom_client; ?>
										</h6>
									</td>
									<td>
										<span class="text-muted">
											<?= $t->title; ?>
										</span>
									</td>
									<td>
										<span class="text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?= $t->date_due; ?>
										</span>
									</td>
									<td>
										<div class="row">
											<?php if ($t->type_tache == 1): ?>
													<div class="mr-2">
														<span class="badge alert-success">Team task</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 2): ?>
													<div class="mr-2">
														<span class="badge alert-success">Temporaire</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 3): ?>
													<div class="mr-2">
														<span class="badge alert-success">GTM</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 4): ?>
													<div class="mr-2">
														<span class="badge alert-success">Plan de taggage</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 5): ?>
													<div class="mr-2">
														<span class="badge alert-success">Upsell</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 6): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Baisse</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 7): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Résiliation</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 8): ?>
													<div class="mr-2">
														<span class="badge alert-warning">Mise en pause</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 9): ?>
													<div class="mr-2">
														<span class="badge alert-success">Relance</span>
													</div>
												<?php endif; ?>
											<?php if ($t->Statuts_technique == 3): ?>
												<span class="col-auto mx-1 badge alert-danger">Urgent</span>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="d-flex align-items-center avatar-group">
											<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
										</div>
									</td>
									<td>
										<div class="row">
											<span class="col-auto">
												<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask; ?>" data-title="<?= $t->title; ?>">
													<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
													<?= $t->count_messages; ?>
												</a>
											</span>
											<?php if ($t->fichier_nom != null): ?>
												<span class="col-auto">
													<a href="#" class="text-muted">
														<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
													</a>
												</span>
											<?php endif; ?>
										</div>
									</td>
									<td>
										<div class="dropdown no-arrow">
											<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-ellipsis-v"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
													<i class="fa fa-eye mr-2"></i>
													Détails
												</button>
												<?php if ($this->current_user->id === $t->AM): ?>
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $t->idtask; ?>">
													<i class="fa fa-edit mr-2"></i>
													Modifier
												</button>
												<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger">
													<i class="fa fa-trash mr-2"></i>
													Supprimer
												</a>
												<?php endif; ?>
											</div>
										</div>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>

			</div>

			<hr>
		</div>

		<div class="tab-pane fade" id="kanban" role="tabpanel" aria-labelledby="kanban_tab">
			<div class="row row-cols-3">
				<div class="col mb-3">
					<div class="card" style="border-radius: 8px;">
						<div class="card-body">
							<i class="fa fa-circle text-warning" style="font-size: 10px;"></i>
							<span class="h4 mx-2 w-auto">Planifié</span>
							<span class="text-muted"><?= $count_planned; ?> open tasks</span>
							<?php foreach ($tache as $t): ?>
								<?php if ($t->status == "planifié"): ?>
									<div class="card mt-3 task-filter" data-type="<?= $t->type_tache ?>" data-am="<?= $t->AM; ?>" data-assigned="<?= $t->assigned_to ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= $t->Statuts_technique == 3; ?>">
										<div class="card-body">
											<div class="d-flex">
												<?php if ($t->type_tache == 1): ?>
													<div class="mr-2">
														<span class="badge alert-success">Team task</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 2): ?>
													<div class="mr-2">
														<span class="badge alert-success">Temporaire</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 3): ?>
													<div class="mr-2">
														<span class="badge alert-success">GTM</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 4): ?>
													<div class="mr-2">
														<span class="badge alert-success">Plan de taggage</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 5): ?>
													<div class="mr-2">
														<span class="badge alert-success">Upsell</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 6): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Baisse</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 7): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Résiliation</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 8): ?>
													<div class="mr-2">
														<span class="badge alert-warning">Mise en pause</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 9): ?>
													<div class="mr-2">
														<span class="badge alert-success">Relance</span>
													</div>
												<?php endif; ?>
												<?php if ($t->Statuts_technique == 3): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Urgent</span>
													</div>
												<?php endif; ?>
												<div class="dropdown no-arrow ml-auto">
													<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-ellipsis-h"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
															<i class="fa fa-eye mr-2"></i>
															Détails
														</button>
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $t->idtask; ?>">
															<i class="fa fa-edit mr-2"></i>
															Modifier
														</button>
														<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger">
															<i class="fa fa-trash mr-2"></i>
															Supprimer
														</a>
													</div>
												</div>
											</div>
											<h6 class="my-3" style="font-size: 14px;"><?= $t->nom_client; ?></h6>
											<span class="text-muted d-block mb-3"><?= $t->title; ?></span>
											<span class="text-muted d-block mb-3">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
												Date Due <?= $t->date_due; ?>
											</span>
											<div class="row no-gutters" style="font-size: 14px;">
												<div class="col-auto mr-auto">
													<div class="d-flex align-items-center avatar-group">
														<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
													</div>
												</div>
												<?php if ($t->fichier_nom != null): ?>
													<span class="col-auto mr-3">
														<a href="#" class="text-muted">
															<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
														</a>
													</span>
												<?php endif; ?>
												<span class="col-auto">
													<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask; ?>" data-title="<?= $t->title; ?>">
														<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
														<?= $t->count_messages; ?>
													</a>
												</span>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>

						</div>
					</div>
				</div>
				<div class="col mb-3">
					<div class="card" style="border-radius: 8px;">
						<div class="card-body">
							<i class="fa fa-circle text-primary" style="font-size: 10px;"></i>
							<span class="h4 mx-2 w-auto">En cours</span>
							<span class="text-muted"><?= $count_upcoming; ?> open tasks</span>

							<!-- Eto no manao foreach -->
							<?php foreach ($tache as $t): ?>
								<?php if ($t->status == "en cours"): ?>
									<div class="card mt-3 task-filter" data-type="<?= $t->type_tache ?>" data-am="<?= $t->AM; ?>" data-assigned="<?= $t->assigned_to ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= $t->Statuts_technique == 3; ?>">
										<div class="card-body">
											<div class="d-flex">
												<?php if ($t->type_tache == 1): ?>
													<div class="mr-2">
														<span class="badge alert-success">Team task</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 2): ?>
													<div class="mr-2">
														<span class="badge alert-success">Temporaire</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 3): ?>
													<div class="mr-2">
														<span class="badge alert-success">GTM</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 4): ?>
													<div class="mr-2">
														<span class="badge alert-success">Plan de taggage</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 5): ?>
													<div class="mr-2">
														<span class="badge alert-success">Upsell</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 6): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Baisse</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 7): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Résiliation</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 8): ?>
													<div class="mr-2">
														<span class="badge alert-warning">Mise en pause</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 9): ?>
													<div class="mr-2">
														<span class="badge alert-success">Relance</span>
													</div>
												<?php endif; ?>
												<?php if ($t->Statuts_technique == 3): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Urgent</span>
													</div>
												<?php endif; ?>
												<div class="dropdown no-arrow ml-auto">
													<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-ellipsis-h"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
															<i class="fa fa-eye mr-2"></i>
															Détails
														</button>
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $t->idtask; ?>">
															<i class="fa fa-edit mr-2"></i>
															Modifier
														</button>
														<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger">
															<i class="fa fa-trash mr-2"></i>
															Supprimer
														</a>
													</div>
												</div>
											</div>
											<h6 class="my-3" style="font-size: 14px;"><?= $t->nom_client; ?></h6>
											<span class="text-muted d-block mb-3"><?= $t->title; ?></span>
											<span class="text-muted d-block mb-3">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
												Date Due <?= $t->date_due; ?>
											</span>
											<div class="row no-gutters" style="font-size: 14px;">
												<div class="col-auto mr-auto">
													<div class="d-flex align-items-center avatar-group">
														<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
													</div>
												</div>
												<?php if ($t->fichier_nom != null): ?>
													<span class="col-auto mr-3">
														<a href="#" class="text-muted">
															<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
														</a>
													</span>
												<?php endif; ?>
												<span class="col-auto">
													<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask; ?>" data-title="<?= $t->title; ?>">
														<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
														<?= $t->count_messages; ?>
													</a>
												</span>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="col mb-3">
					<div class="card" style="border-radius: 8px;">
						<div class="card-body">
							<i class="fa fa-circle text-success" style="font-size: 10px;"></i>
							<span class="h4 mx-2 w-auto">Terminé</span>
							<span class="text-muted"><?= $count_completed; ?> open tasks</span>
							<!-- Eto no manao foreach -->
							<?php foreach ($tache as $t): ?>
								<?php if ($t->status == "effectuée"): ?>
									<div class="card mt-3 task-filter" data-type="<?= $t->type_tache ?>" data-am="<?= $t->AM; ?>" data-assigned="<?= $t->assigned_to ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= $t->Statuts_technique == 3; ?>">
										<div class="card-body">
											<div class="d-flex">
												<?php if ($t->type_tache == 1): ?>
													<div class="mr-2">
														<span class="badge alert-success">Team task</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 2): ?>
													<div class="mr-2">
														<span class="badge alert-success">Temporaire</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 3): ?>
													<div class="mr-2">
														<span class="badge alert-success">GTM</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 4): ?>
													<div class="mr-2">
														<span class="badge alert-success">Plan de taggage</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 5): ?>
													<div class="mr-2">
														<span class="badge alert-success">Upsell</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 6): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Baisse</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 7): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Résiliation</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 8): ?>
													<div class="mr-2">
														<span class="badge alert-warning">Mise en pause</span>
													</div>
												<?php endif; ?>
												<?php if ($t->type_tache == 9): ?>
													<div class="mr-2">
														<span class="badge alert-success">Relance</span>
													</div>
												<?php endif; ?>
												<?php if ($t->Statuts_technique == 3): ?>
													<div class="mr-2">
														<span class="badge alert-danger">Urgent</span>
													</div>
												<?php endif; ?>
												<div class="dropdown no-arrow ml-auto">
													<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-ellipsis-h"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $t->idtask; ?>">
															<i class="fa fa-eye mr-2"></i>
															Détails
														</button>
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $t->idtask; ?>">
															<i class="fa fa-edit mr-2"></i>
															Modifier
														</button>
														<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger">
															<i class="fa fa-trash mr-2"></i>
															Supprimer
														</a>
													</div>
												</div>
											</div>
											<h6 class="my-3" style="font-size: 14px;"><?= $t->nom_client; ?></h6>
											<span class="text-muted d-block mb-3"><?= $t->title; ?></span>
											<span class="text-muted d-block mb-3">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
												Date Due <?= $t->date_due; ?>
											</span>
											<div class="row no-gutters" style="font-size: 14px;">
												<div class="col-auto mr-auto">
													<div class="d-flex align-items-center avatar-group">
														<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
														<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Client Image">
													</div>
												</div>
												<?php if ($t->fichier_nom != null): ?>
													<span class="col-auto mr-3">
														<a href="#" class="text-muted">
															<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
														</a>
													</span>
												<?php endif; ?>
												<span class="col-auto">
													<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask; ?>" data-title="<?= $t->title; ?>">
														<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
														<?= $t->count_messages; ?>
													</a>
												</span>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layouts/task/modal/form'); ?>
<?php $this->load->view('layouts/task/modal/detail'); ?>
<?php $this->load->view('layouts/task/modal/discussion'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>

<script src="<?= base_url('assets/vendors/select2/js/select2.min.js'); ?>"></script>

<!-- Task filter script -->
<script>
	$(function() {

		function filter_task(type) {

			if (type == 0) {
				$('.task-filter').removeClass('d-none');
			} else {
				$('.task-filter').addClass('d-none');
				$('.task-filter[data-type="' + type + '"]').removeClass('d-none');
			}
		}

		$('#task_type_filter').change(function() {
			let type = $(this).val();
			filter_task(type);
		});

		$('#task_user_filter').change(function() {
			let id = $(this).val();

			if (id == 0) {
				$('.task-filter').removeClass('d-none');
			} else {
				$('.task-filter').addClass('d-none');
				$('.task-filter[data-am="' + id + '"]').removeClass('d-none');
				$('.task-filter[data-assigned="' + id + '"]').removeClass('d-none');
			}
		});
	});
</script>

<!-- Index page script -->
<script>
	$(function() {

		$('.select2').select2();

		var id_task = null;

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
			$('#status_form').addClass('d-none');
		}

		function resetForm() {
			$('#taskId').removeAttr('value');
			$('#formModalLabel').text("Nouveau Tache")
			$('#task_form').attr('action', "<?= base_url('Task/insert_tache'); ?>");
			$('#task_type').val("");
			$('#task_status').val("");
			$('#task_title').val("");
			$('#idclients').val(null).removeAttr('disabled').trigger('change');
			$('#assigned_to').val("");
			$('#date_demande').val("");
			$('#date_due').val("");
			$('#tache').val("");
			$('#task_form button[type="submit"]').text("Ajouter");
		}

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

		function fetch_detail(task_id) {

			$.ajax({
				type: "GET",
				url: "Task/detail_task/" + task_id,
				dataType: "json",
				beforeSend: function() {
					resetDetail();
				},
				success: function(response) {

					let task = response.task;
					let messages = response.messages;

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

					if (task.assigned_to == <?= $this->current_user->id ?> || task.AM == <?= $this->current_user->id ?>) {
						$('#change_status').val(task.status);
						$('#status_form input[name="taskId"]').val(task.idtask);

						$('#status_form').removeClass('d-none');
					}
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
			id_task = $(button).attr('data-id');

			$('#discussionModalLabel').html('Discussion sur: ' + title ?? "Unknown");

			fetch_discussion();
		});

		$('#discussionModal').on('hide.bs.modal', function(event) {
			id_task = null;
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
					"id_task": id_task,
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

		$('#formModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let id_task = $(button).attr('data-id');

			if (id_task) {

				$.ajax({
					type: "GET",
					url: "Task/detail_task/" + id_task,
					dataType: "json",
					beforeSend: function() {
						resetForm();
					},
					success: function(response) {

						let task = response.task;

						$('#formModalLabel').text("Modification note: " + task.title)
						$('#task_form').attr('action', "<?= site_url('Task/edits_task'); ?>");
						$('#task_type').val(task.type_tache);
						$('#task_status').val(task.Statuts_technique);
						$('#task_title').val(task.title);
						$('#idclients').val(task.idclients).attr('disabled', "disabled").trigger('change');
						$('#assigned_to').val(task.assigned_to);
						$('#date_demande').val(task.date_demande);
						$('#date_due').val(task.date_due);
						$('#tache').val(task.description);
						$('#taskId').val(task.idtask);
						$('#task_form button[type="submit"]').text("Modifier");

					}
				});

			} else {
				$('#task_form button[type="submit"]').text("Ajouter");
				$('#formModalLabel').text("Nouveau Tache")
				$('#task_form').attr('action', "<?= site_url('Task/insert_tache') ?>");
			}
		});

		$('#formModal').on('hide.bs.modal', function(event) {
			resetForm();
		});

		$('.status-select').change(function() {
			let filter = $(this).val();
			
			$('.status-select').parent('label.btn-light').removeClass('btn-light').addClass('btn-white');
			$(this).parent('label').addClass('btn-light').removeClass('btn-white');
			
			switch (filter) {
				case "expired":
					$('.task-filter').addClass('d-none');
					$('.task-filter[data-expired="true"]').removeClass('d-none');
					break;
					
				case "urgent":
					$('.task-filter').addClass('d-none');
					$('.task-filter[data-urgent="1"]').removeClass('d-none');
					break;
					
				default:
					$('.task-filter').removeClass('d-none');
					break;
			}
		});
	});
</script>

<!-- Task modal create -->
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

<script>
	/* function setDefaultDate() {
		const today = new Date();
		const yyyy = today.getFullYear();
		let mm = today.getMonth() + 1;
		let dd = today.getDate();
		if (mm < 10) mm = '0' + mm;
		if (dd < 10) dd = '0' + dd;

		const formattedDate = yyyy + '-' + mm + '-' + dd;
		document.getElementById('exampleInputEmail1').value = formattedDate;
	}
	window.onload = setDefaultDate; */
</script>
<?php end_section(); ?>
