<?php start_section('stylesheet'); ?>
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
Task
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
		<button class="btn btn-dark" data-toggle="modal" data-target="#taskModal">
			<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
			Add Task
		</button>
	</div>
</div>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">

	<ul class="nav nav-tabs mb-3" role="tablist">
		<li class="nav-item">
			<a class="nav-link py-3 active" type="button">
				All Task
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link py-3" type="button">
				Team Task
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link py-3" type="button">
				Temporaire
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link py-3" type="button">
				GTM
			</a>
		</li>
	</ul>

	<div class="tab-content" id="taskTabContent">

		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">

			<a class="text-decoration-none w-100" id="headingOne" role="button" data-toggle="collapse" data-target="#collapsePlanned" aria-expanded="true" aria-controls="collapsePlanned">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-warning" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">Planifié</span>
					<span class="text-muted">3 open tasks</span>
				</p>
			</a>

			<div id="collapsePlanned" class="collapse show" aria-labelledby="headingOne">
				<button class="btn btn-light btn-block my-3 font-weight-normal">
					<i class="fa fa-plus"></i>
					Create Task
				</button>

				<table class="table table-wrapper w-100">
					<tbody>
						<?php foreach ($tache_team as $t):  ?>
							<tr>
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
										<span class="col-auto mx-1 badge alert-success">Internal</span>
										<span class="col-auto mx-1 badge alert-warning">Marketing</span>
										<span class="col-auto mx-1 badge alert-danger">Urgent</span>
									</div>
								</td>
								<td>
									<div class="d-flex align-items-center avatar-group">
										<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
										<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
										<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
										<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
									</div>
								</td>
								<td>
									<a href="#" class="text-decoration-none text-muted">
										<i class="fa fa-ellipsis-h"></i>
									</a>
								</td>
							</tr>
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
					<span class="text-muted">3 open tasks</span>
				</p>
			</a>

			<div id="collapseUpcoming" class="collapse show" aria-labelledby="headingTwo">
				<button class="btn btn-light btn-block my-3 font-weight-normal">
					<i class="fa fa-plus"></i>
					Create Task
				</button>

				<table class="table table-wrapper w-100">
					<tbody>
						<!-- foreach here -->
						<tr>
							<td>
								<h6 class="mb-0 ml-3">
									Monthly product Descussion
								</h6>
							</td>
							<td>
								<span class="text-muted">
									Envoi Procédure + Invitation GTM
								</span>
							</td>
							<td>
								<span class="text-muted">
									<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
									Due Date 24 Jan 2023
								</span>
							</td>
							<td>
								<div class="row">
									<span class="col-auto mx-1 badge alert-success">Internal</span>
									<span class="col-auto mx-1 badge alert-warning">Marketing</span>
									<span class="col-auto mx-1 badge alert-danger">Urgent</span>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center avatar-group">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
								</div>
							</td>
							<td>
								<a href="#" class="text-decoration-none text-muted">
									<i class="fa fa-ellipsis-h"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>
								<h6 class="mb-0 ml-3">
									Monthly product Descussion
								</h6>
							</td>
							<td>
								<span class="text-muted">
									Envoi Procédure + Invitation GTM
								</span>
							</td>
							<td>
								<span class="text-muted">
									<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
									Due Date 24 Jan 2023
								</span>
							</td>
							<td>
								<div class="row">
									<span class="col-auto mx-1 badge alert-success">Internal</span>
									<span class="col-auto mx-1 badge alert-warning">Marketing</span>
									<span class="col-auto mx-1 badge alert-danger">Urgent</span>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center avatar-group">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
								</div>
							</td>
							<td>
								<a href="#" class="text-decoration-none text-muted">
									<i class="fa fa-ellipsis-h"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<hr>

			<a class="text-decoration-none w-100" id="headingThree" role="button" data-toggle="collapse" data-target="#collapseCompleted" aria-expanded="true" aria-controls="collapseCompleted">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-success" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">Terminé</span>
					<span class="text-muted">3 open tasks</span>
				</p>
			</a>

			<div id="collapseCompleted" class="collapse show" aria-labelledby="headingThree">
				<button class="btn btn-light btn-block my-3 font-weight-normal">
					<i class="fa fa-plus"></i>
					Create Task
				</button>

				<table class="table table-wrapper w-100">
					<tbody>
						<!-- foreach here -->
						<tr>
							<td>
								<h6 class="mb-0 ml-3">
									Monthly product Descussion
								</h6>
							</td>
							<td>
								<span class="text-muted">
									Envoi Procédure + Invitation GTM
								</span>
							</td>
							<td>
								<span class="text-muted">
									<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
									Due Date 24 Jan 2023
								</span>
							</td>
							<td>
								<div class="row">
									<span class="col-auto mx-1 badge alert-success">Internal</span>
									<span class="col-auto mx-1 badge alert-warning">Marketing</span>
									<span class="col-auto mx-1 badge alert-danger">Urgent</span>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center avatar-group">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
								</div>
							</td>
							<td>
								<a href="#" class="text-decoration-none text-muted">
									<i class="fa fa-ellipsis-h"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>
								<h6 class="mb-0 ml-3">
									Monthly product Descussion
								</h6>
							</td>
							<td>
								<span class="text-muted">
									Envoi Procédure + Invitation GTM
								</span>
							</td>
							<td>
								<span class="text-muted">
									<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
									Due Date 24 Jan 2023
								</span>
							</td>
							<td>
								<div class="row">
									<span class="col-auto mx-1 badge alert-success">Internal</span>
									<span class="col-auto mx-1 badge alert-warning">Marketing</span>
									<span class="col-auto mx-1 badge alert-danger">Urgent</span>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center avatar-group">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
									<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
								</div>
							</td>
							<td>
								<a href="#" class="text-decoration-none text-muted">
									<i class="fa fa-ellipsis-h"></i>
								</a>
							</td>
						</tr>
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
							<span class="text-muted">3 open tasks</span>

							<button class="btn btn-light btn-block my-3 font-weight-normal">
								<img src="<?= base_url('assets/images/icons/figma/icon-plus-3.svg') ?>" alt="">
								Create Task
							</button>

							<?php foreach ($tache_team as $t): ?>
								<div class="card mt-3">
									<div class="card-body">
										<div class="d-flex">
											<div class="mr-2">
												<span class="badge alert-success">Internal</span>
											</div>
											<div class="mr-2">
												<span class="badge alert-warning">Marketing</span>
											</div>
											<div class="mr-2">
												<span class="badge alert-danger">Urgent</span>
											</div>
											<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
												<i class="fa fa-ellipsis-h"></i>
											</a>
										</div>
										<h6 class="my-3" style="font-size: 14px;"><?= $t->nom_client; ?></h6>
										<span class="text-muted d-block mb-3"><?= $t->title; ?></span>
										<span class="text-muted d-block mb-3">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date <?= $t->date_due; ?>
										</span>
										<div class="row no-gutters" style="font-size: 14px;">
											<div class="col-auto mr-auto">
												<div class="d-flex align-items-center avatar-group">
													<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
													<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
													<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
													<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
												</div>
											</div>
											<span class="col-auto mr-3">
												<a href="#" class="text-muted">
													<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
													5
												</a>
											</span>
											<span class="col-auto">
												<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>" data-title="<?= $t->title; ?>">
													<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
													19
												</a>
											</span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>

						</div>
					</div>
				</div>
				<div class="col mb-3">
					<div class="card" style="border-radius: 8px;">
						<div class="card-body">
							<i class="fa fa-circle text-primary" style="font-size: 10px;"></i>
							<span class="h4 mx-2 w-auto">En cours</span>
							<span class="text-muted">3 open tasks</span>

							<button class="btn btn-light btn-block my-3 font-weight-normal">
								<img src="<?= base_url('assets/images/icons/figma/icon-plus-3.svg') ?>" alt="">
								Create Task
							</button>

							<!-- Eto no manao foreach -->
							<div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Monthly product Descussion</h6>
									<div class="row mb-3" style="font-size: 14px;">
										<span class="col-auto mr-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date 24 Jan 2023
										</span>
										<span class="col-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/checklist.svg') ?>" alt="">
											10/124
										</span>
									</div>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3 text-muted">
											<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
											5
										</span>
										<span class="javascript:void(0);ol-auto text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>">
											<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
											19
										</span>
									</div>
								</div>
							</div>
							<div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Monthly product Descussion</h6>
									<div class="row mb-3" style="font-size: 14px;">
										<span class="col-auto mr-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date 24 Jan 2023
										</span>
										<span class="col-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/checklist.svg') ?>" alt="">
											10/124
										</span>
									</div>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3 text-muted">
											<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
											5
										</span>
										<span class="javascript:void(0);ol-auto text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>">
											<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
											19
										</span>
									</div>
								</div>
							</div>
							<div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Monthly product Descussion</h6>
									<div class="row mb-3" style="font-size: 14px;">
										<span class="col-auto mr-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date 24 Jan 2023
										</span>
										<span class="col-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/checklist.svg') ?>" alt="">
											10/124
										</span>
									</div>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3 text-muted">
											<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
											5
										</span>
										<span class="javascript:void(0);ol-auto text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>">
											<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
											19
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col mb-3">
					<div class="card" style="border-radius: 8px;">
						<div class="card-body">
							<i class="fa fa-circle text-success" style="font-size: 10px;"></i>
							<span class="h4 mx-2 w-auto">Terminé</span>
							<span class="text-muted">3 open tasks</span>

							<button class="btn btn-light btn-block my-3 font-weight-normal">
								<img src="<?= base_url('assets/images/icons/figma/icon-plus-3.svg') ?>" alt="">
								Create Task
							</button>

							<!-- Eto no manao foreach -->
							<div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Andréa et Stephano le compte pour moi Assor Doukhan (assordoukhanavocats.fr)</h6>
									<span class="text-muted d-block mb-3">Envoi Procédure + Invitation GTM</span>
									<span class="text-muted d-block mb-3">
										<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
										Due Date 24 Jan 2023
									</span>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3">
											<a href="#" class="text-muted">
												<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
												5
											</a>
										</span>
										<span class="col-auto">
											<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>">
												<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
												19
											</a>
										</span>
									</div>
								</div>
							</div>
							<div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Monthly product Descussion</h6>
									<div class="row mb-3" style="font-size: 14px;">
										<span class="col-auto mr-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date 24 Jan 2023
										</span>
										<span class="col-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/checklist.svg') ?>" alt="">
											10/124
										</span>
									</div>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3 text-muted">
											<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
											5
										</span>
										<span class="javascript:void(0);ol-auto text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>">
											<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
											19
										</span>
									</div>
								</div>
							</div>
							<div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Monthly product Descussion</h6>
									<div class="row mb-3" style="font-size: 14px;">
										<span class="col-auto mr-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date 24 Jan 2023
										</span>
										<span class="col-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/checklist.svg') ?>" alt="">
											10/124
										</span>
									</div>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3 text-muted">
											<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
											5
										</span>
										<span class="javascript:void(0);ol-auto text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= $t->idtask ?>">
											<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
											19
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layouts/task/modal/form'); ?>
<?php $this->load->view('layouts/task/modal/discussion'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>

<!-- Index page script -->
<script>
	$(function() {

		var id_task = null;

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
<?php end_section(); ?>
