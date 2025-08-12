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

				<div class="card card-hover mb-3">
					<div class="card-body" style="padding-top: 14px; padding-bottom: 14px;">
						<div class="d-flex justify-content-between align-items-center">
							<h6 class="mb-0 ml-3">
								Monthly product Descussion
							</h6>
							<span class="text-muted">
								Envoi Procédure + Invitation GTM
							</span>
							<span class="text-muted">
								<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
								Due Date 24 Jan 2023
							</span>
							<div class="row">
								<span class="col-auto mx-1 badge alert-success">Internal</span>
								<span class="col-auto mx-1 badge alert-warning">Marketing</span>
								<span class="col-auto mx-1 badge alert-danger">Urgent</span>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
							</div>
						</div>
					</div>
				</div>

				<div class="card card-hover mb-3">
					<div class="card-body" style="padding-top: 14px; padding-bottom: 14px;">
						<div class="d-flex justify-content-between align-items-center">
							<h6 class="mb-0 ml-3">
								Monthly product Descussion
							</h6>
							<span class="text-muted">
								Envoi Procédure + Invitation GTM
							</span>
							<span class="text-muted">
								<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
								Due Date 24 Jan 2023
							</span>
							<div class="row">
								<span class="col-auto mx-1 badge alert-success">Internal</span>
								<span class="col-auto mx-1 badge alert-warning">Marketing</span>
								<span class="col-auto mx-1 badge alert-danger">Urgent</span>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
							</div>
						</div>
					</div>
				</div>

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

				<div class="card card-hover mb-3">
					<div class="card-body" style="padding-top: 14px; padding-bottom: 14px;">
						<div class="d-flex justify-content-between align-items-center">
							<h6 class="mb-0 ml-3">
								Monthly product Descussion
							</h6>
							<span class="text-muted">
								Envoi Procédure + Invitation GTM
							</span>
							<span class="text-muted">
								<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
								Due Date 24 Jan 2023
							</span>
							<div class="row">
								<span class="col-auto mx-1 badge alert-success">Internal</span>
								<span class="col-auto mx-1 badge alert-warning">Marketing</span>
								<span class="col-auto mx-1 badge alert-danger">Urgent</span>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
							</div>
						</div>
					</div>
				</div>

				<div class="card card-hover mb-3">
					<div class="card-body" style="padding-top: 14px; padding-bottom: 14px;">
						<div class="d-flex justify-content-between align-items-center">
							<h6 class="mb-0 ml-3">
								Monthly product Descussion
							</h6>
							<span class="text-muted">
								Envoi Procédure + Invitation GTM
							</span>
							<span class="text-muted">
								<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
								Due Date 24 Jan 2023
							</span>
							<div class="row">
								<span class="col-auto mx-1 badge alert-success">Internal</span>
								<span class="col-auto mx-1 badge alert-warning">Marketing</span>
								<span class="col-auto mx-1 badge alert-danger">Urgent</span>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
							</div>
						</div>
					</div>
				</div>

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

				<div class="card card-hover mb-3">
					<div class="card-body" style="padding-top: 14px; padding-bottom: 14px;">
						<div class="d-flex justify-content-between align-items-center">
							<h6 class="mb-0 ml-3">
								Monthly product Descussion
							</h6>
							<span class="text-muted">
								Envoi Procédure + Invitation GTM
							</span>
							<span class="text-muted">
								<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
								Due Date 24 Jan 2023
							</span>
							<div class="row">
								<span class="col-auto mx-1 badge alert-success">Internal</span>
								<span class="col-auto mx-1 badge alert-warning">Marketing</span>
								<span class="col-auto mx-1 badge alert-danger">Urgent</span>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
							</div>
						</div>
					</div>
				</div>

				<div class="card card-hover mb-3">
					<div class="card-body" style="padding-top: 14px; padding-bottom: 14px;">
						<div class="d-flex justify-content-between align-items-center">
							<h6 class="mb-0 ml-3">
								Monthly product Descussion
							</h6>
							<span class="text-muted">
								Envoi Procédure + Invitation GTM
							</span>
							<span class="text-muted">
								<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
								Due Date 24 Jan 2023
							</span>
							<div class="row">
								<span class="col-auto mx-1 badge alert-success">Internal</span>
								<span class="col-auto mx-1 badge alert-warning">Marketing</span>
								<span class="col-auto mx-1 badge alert-danger">Urgent</span>
							</div>
							<div class="d-flex align-items-center avatar-group">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 3">
								<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="28" class="rounded-circle avatar" alt="Avatar 4">
							</div>
						</div>
					</div>
				</div>

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
											<a href="#" class="text-muted">
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
										<span class="col-auto text-muted">
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
										<span class="col-auto text-muted">
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
										<span class="col-auto text-muted">
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
										<span class="col-auto text-muted">
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
										<span class="col-auto text-muted">
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
											<a href="#" class="text-muted">
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
										<span class="col-auto text-muted">
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
										<span class="col-auto text-muted">
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

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
	$(function() {

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

	});
</script>
<?php end_section(); ?>
