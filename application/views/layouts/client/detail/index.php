<?php start_section('stylesheet');  ?>
<style>
	.table-wrapper {
		border-spacing: 15px 0 !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		/* border: border; */
		border-bottom: 2px solid #dee2e6 !important;
		border-top: 0px !important;
	}

	/* .table-wrapper tbody tr td:first-child,
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
	} */
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>

<?php foreach ($donnees as $d): ?>
	<div class="row no-gutters h-100">

		<?php $this->load->view('layouts/client/detail/sidebar'); ?>

		<div class="col" style="height: calc(100vh - 101px); overflow-y:auto;">
			<div class="container-fluid pb-5">

				<div class="dropdown">

					<a type="button" class="badge alert-success rounded-pill px-4 py-3 mb-3 dropdown-toggle" style="font-size: 12px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
						Active
					</a>
					<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="clientStatusDropdown">
						<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#statusModal">Statut Client</a>
					</div>
				</div>

				<div class="row mb-4">
					<div class="col overflow-hidden">
						<div class="d-flex justify-content-start align-items-center mb-3">
							<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
							<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
							<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
							<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
							<img src="<?= base_url('assets/images/icons/figma/star_half.svg') ?>" alt="star_half" width="20" class="mr-1">
							<span class="ml-3 py-1 px-3 badge" style="background-color: #edf2fe; color: #4976f4; font-size: 12px; font-weight: 500;">Bleu</span>
						</div>
						<h1 class="mb-3" style="font-size: 48px; font-weight: 500;">
							<?= $d['nom_client'] ?>
						</h1>
						<h5 class="mb-3" style=""><?= $d['site_client'] ?></h5>
					</div>
					<div class="col-auto">
						<div class="card h-100" style="width: 23rem;">
							<div class="card-body">
								<div class="d-flex justify-content-between align-items-center">
									<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
										<?= $d['budget'] ?> €
									</button>
									<div class="dropdown no-arrow">
										<a href="javascript:void(0);" class="btn btn-light rounded-pill px-3 nav-link dropdown-toggle" id="clientDetailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v" style="font-size: 16px;"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="clientDetailDropdown">
											<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#editModal">Modifier</a>
										</div>
									</div>
								</div>
								<br><br>
								<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
									 <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
									<span class="mr-2">Date d'anniversaire : <?= $d['mis_en_place_paiement'] ?></span>
								</div>
								<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
									 <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
									<span class="mr-2">Date de mise en ligne : <?= $d['annonce'] ?></span>

								</div>
								<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
									 <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
									<span class="mr-2">Commerciale</span>
									<span class="mr-2">
										<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24">
									</span>
								</div>
								<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
									 <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
									<span class="mr-2">Account Manager</span>
									<span class="mr-2">
										<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24">
									</span>
								</div>
								<a href="<?= base_url('Client/onboarding/' . $d['idclients']) ?>" class="btn btn-outline-dark btn-block">Onboarding</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row no-gutters mb-3">
					<div class="col pr-2" style="margin-right: 15px;">
						<div class="card h-100 mb-5">
							<div class="card-body">
								<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
									<li class="nav-item">
										<a class="nav-link py-3 active" type="button">
											Société
										</a>
									</li>
								</ul>

								<h6 class="text-muted font-weight-normal" style="font-size: 15.5px;">
									<?= $d['info_base_client'] ?></br>
								</h6>
								<!-- <ul class="nav nav-tabs">
									<li class="nav-item">
										<a class="nav-link py-3 active" type="button">
											Favicon
											<img src="<?= $d['favicon']; ?>" width="43"></br>
										</a>
									</li>
								</ul> -->
							</div>
						</div>
					</div>
					<div class="col-auto">
						<div class="card" style="width: 23rem;">
							<div class="card-body">
								<table class="table table-borderless">
									<tr>
										<td class="align-bottom text-center" style="border-bottom: 2px solid black; font-weight: 500;">
											Secteur Activité
										</td>
										<td class="text-center">
											<span class="badge alert-dark">Artisan Plombier</span>
										</td>
									</tr>
									<tr>
										<td class="align-bottom text-center" style="border-bottom: 2px solid black; font-weight: 500;">
											Logo
										</td>
										<td class="text-center">
											<button class="btn btn-light btn-sm">
												<i class="fa fa-plus"></i>
												Ajouter Logo
											</button>
											<!-- <span class="badge alert-dark">Artisan Plombier</span> -->
										</td>
									</tr>
									<tr>
										<td class="align-bottom text-center" style="border-bottom: 2px solid black; font-weight: 500;">
											Favicon
										</td>
										<td class="text-center">
											<img src="<?= $d['favicon']; ?>" width="28" class="mr-2">
											Venture
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

				<br>

				<h1 style="font-size: 48px;">Budget annuel</h1>
				</br>

				<div class="tab-content" id="taskTabContent">
					<div class="tab-pane fade mb-5 show active" id="budget" role="tabpanel" aria-labelledby="budget_tab">
						<div class="card">
							<div class="card-body">
								<h5>Hausse et baisse de budget</h5>
								<div class="d-flex align-items-center">
									<h2 class="mr-2"><?= $d['budget'] ?> Є</h2>
									<div class="mr-auto">
										<span class="badge alert-success rounded-pill py-2 px-3 font-weight-normal" style="font-size: 14px;">
											<i class="fa fa-chart-line mr-1"></i>
											12%
										</span>
									</div>
									<select class="form-control w-auto mr-5 border-dark text-dark" id="filter_budget_year" style="font-size: 14px; font-weight: 500;">
										<option value="2023">2023</option>
										<option value="2024">2024</option>
										<option value="2025">2025</option>
									</select>
								</div>
								<span class="text-muted" style="font-size: 14px;">Budget actuellement en cours</span>
								<table class="table table-wrapper">
									<thead>
										<tr>
											<th>
												Gestion de budget
											</th>
											<th>
												Date de la demande
											</th>
											<th>
												Date Effective
											</th>
											<th>
												Montant
											</th>
											<th>
												Nouveau montant
											</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($upsell as $u): ?>
											<tr class="budget-year-row" data-year="<?= explode('-', $u->date_demande)[0]; ?>">
												<td>
													<?php if ($u->type_upsell == 2): ?>
														<span class="badge alert-success rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
															<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
															Hausse de budget
														</span>
													<?php endif; ?>
													<?php if ($u->type_upsell == 1): ?>
														<span class="badge alert-danger rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
															<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
															Baisse de budget
														</span>
													<?php endif; ?>
												</td>
												<td><?= $u->date_demande ?></td>
												<td><?= $u->date_upsell ?></td>
												<td><?= $u->budget_initiale ?> €</td>
												<td><?= $u->budgets ?> €</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane fade mb-5" id="variation" role="tabpanel" aria-labelledby="variation_tab">
						<div class="card">
							<div class="card-body">
								<h1>Liste</h1>
							</div>
						</div>
					</div>
				</div>
				<br>

				<div class="row row-cols-4 mb-5" style="margin-top: 30px;">
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex align-items-center mb-2">
									<img src="<?= base_url('assets/images/figma/discu_queue.png') ?>" width="43">
									<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">File de discussion</a>
									<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
								</div>
								<h3 class="m-0">51 Discussions</h3>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex align-items-center mb-2">
									<img src="<?= base_url('assets/images/figma/google_meet.png') ?>" width="43">
									<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Google Meet</a>
									<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
								</div>
								<h3 class="m-0">2025-07-12</h3>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex align-items-center mb-2">
									<img src="<?= base_url('assets/images/figma/air_call.png') ?>" width="43">
									<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">AirCall</a>
									<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
								</div>
								<h3 class="m-0"><?= date('Y-m-d', $matched_calls[0]->started_at) ?></h3>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="d-flex align-items-center mb-2">
									<img src="<?= base_url('assets/images/figma/teams_tasks.png') ?>" width="43">
									<a href="<?= base_url('Client/tache_client/' . $donnees[0]['idclients']) ?>" class="text-decoration-none text-muted ml-3 stretched-link">Teams Tasks</a>
									<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
								</div>
								<h3 class="m-0"><?= $nbr_task ?> Tâches en cours</h3>
							</div>
						</div>
					</div>
				</div>

				<br>
				<div class="d-flex justify-content-between">
					<h1 style="font-size: 48px;">Loocker Studio</h1>
				</div><br>
				<div class="row row-cols-3">
					<div class="col">
						<div class="card h-100">
							<div class="card-body text-center">
								<h5>Rapport Basic</h5>
								<span class="text-muted">
									<i class="fa fa-circle mr-2" style="color: #589e67;"></i>
									Active
								</span>
								<button class="btn btn-soutline-dark btn-block">Loocker Studio</button>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body text-center">
								<h5>Rapport de conversion</h5>
								<span class="text-muted">
									<i class="fa fa-circle mr-2" style="color: #589e67;"></i>
									Active
								</span>
								<button class="btn btn-soutline-dark btn-block">Loocker Studio</button>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body text-center">
								<h5>Rapport Bilan Annuel</h5>
								<br>
								<button class="btn btn-light btn-block">
									<i class="fa fa-plus"></i>
									Create Task
								</button>
							</div>
						</div>
					</div>
				</div>

				</br></br></br></br>

				<div class="d-flex justify-content-between">
					<h1 style="font-size: 48px;">Détection Modules</h1>
					<form action="<?= base_url('Client/application/' . $donnees[0]['idclients']) ?>" method="get">
						<button class="btn btn-outline-dark btn-lg" type="submit">Voir tout</button>
					</form>


				</div><br>
				<div class="row row-cols-2">
					<div class="col">
						<div class="card h-100">
							<div class="card-body text-center">
								<h3 class="mb-4">6+ Apps connectés</h3>
								<p class="text-muted mx-5 mb-5" style="font-size: 18px;">
									Embark on a transformative journey with our venture. Over 60 powerful tools to make your work more efficient and effective.
								</p>
								<div class="row justify-content-center">
									<div class="col-auto">
										<img src="<?= $d['cms_logo']; ?>" width="43">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body text-center">
								<h3 class="mb-4">Google Tag Manager</h3>
								<p class="text-muted mx-5 mb-5" style="font-size: 18px;">
									Venture is audited and certified by few industry that have been leading in Security Third Party standards.
								</p>
								<span class="badge alert-success rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
									<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
									<?= $d['tracking_gtm'] ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<br><br></br></br>

				<div class="d-flex justify-content-between">
					<h1 style="font-size: 48px;">Tâches en cours</h1>
					<button class="btn btn-outline-dark btn-lg">Voir tout</button>
				</div><br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr class="text-muted">
								<th>Label</th>
								<th>Date de la demande</th>
								<th>Date due</th>
								<th>Description</th>
								<th>Member</th>
								<th>Status</th>
								<th></th>
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
										<td class="align-middle" style="font-weight: 500;"><?= $t->title; ?></td>
										<td class="align-middle text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?= $t->date_demande; ?>
										</td>
										<td class="align-middle text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											<?= $t->date_due; ?>
										</td>
										<td class="align-middle text-muted">
											<?= $t->description; ?>
										</td>
										<td class="align-middle">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="28" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="28" class="rounded-circle avatar" alt="Avatar 2">

											</div>
										</td>
										<td class="align-middle">
											<span class="badge alert-warning rounded-pill px-3 py-2" style="font-size: 12px; font-weight: 500;">
												<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
												Planned
											</span>
										</td>
										<td>
											<div class="dropdown no-arrow">
											<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-ellipsis-v"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#taskModal" data-id="<?= $t->idtask; ?>">Détails</button>
											</div>
										</div>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>

						</tbody>
					</table>
				</div><br><br></br></br>

				<h1 style="font-size: 48px;">Point Bilan</h1>
				</br>
				<div class="row row-cols-3">
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="row justify-content-star">
									<span class="col-auto mx-1 p-2 badge" style="background-color: #f7f7e8; color: #b1ab1d; font-size: 12px; font-weight: 500;">Weekly</span>
									<span class="col-auto mx-1 p-2 badge" style="background-color: #edf2fe; color: #4976f4; font-size: 12px; font-weight: 500;">Product</span>
								</div>
								<br>
								<h5 class="text-dark">Product Team Meeting</h5>
								<br>
								<p class="text-muted">
									This monthly progress agenda is following this items:

									Introduction to Newest Product Plan

									Monthly Revenue updates for each products
								</p>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="row justify-content-star">
									<span class="col-auto mx-1 p-2 badge" style="background-color: #f7f7e8; color: #b1ab1d; font-size: 12px; font-weight: 500;">Weekly</span>
									<span class="col-auto mx-1 p-2 badge" style="background-color: #edf2fe; color: #4976f4; font-size: 12px; font-weight: 500;">Product</span>
								</div>
								<br>
								<h5 class="text-dark">Product Team Meeting</h5>
								<br>
								<p class="text-muted">
									This monthly progress agenda is following this items:

									Introduction to Newest Product Plan

									Monthly Revenue updates for each products
								</p>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100">
							<div class="card-body">
								<div class="row justify-content-star">
									<span class="col-auto mx-1 p-2 badge" style="background-color: #f7f7e8; color: #b1ab1d; font-size: 12px; font-weight: 500;">Weekly</span>
									<span class="col-auto mx-1 p-2 badge" style="background-color: #edf2fe; color: #4976f4; font-size: 12px; font-weight: 500;">Product</span>
								</div>
								<br>
								<br>
								<br>
								<button class="btn btn-light btn-block">
									<i class="fa fa-plus"></i>
									Create Task
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php $this->load->view('layouts/client/detail/modal/budget'); ?>
<?php $this->load->view('layouts/client/detail/modal/edit'); ?>
<?php $this->load->view('layouts/client/detail/modal/status'); ?>
<?php $this->load->view('layouts/client/detail/modal/task'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
	$(function() {

		const currentMonthIndex = new Date().getMonth();

		function resetTask() {
			$('#task_discussion').html("");
			$('#taskModalLabel').text("");
			$('#task_due_date').removeAttr('value');
			$('#task_description').text("");
			$('#task_discussion_form').removeAttr('id');
		}

		function fetch_task(task_id) {

			$.ajax({
				type: "GET",
				url: "<?= site_url('Task/detail_task/'); ?>" + task_id,
				dataType: "json",
				beforeSend: function() {
					resetTask();
				},
				success: function(response) {

					let task = response.task;
					let messages = response.messages;

					$('#taskModalLabel').text("Tâche: " + task.title);
					$('#task_due_date').val(task.date_due);
					$('#task_description').text(task.description);

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

						$('#task_discussion').prepend(html);
					});
				}
			});
		}

		$('#filter_budget_year').change(function() {
			let year = $(this).data('year');
			$('.budget-year-row').addClass('d-none');
			$('.budget-year-row[data-year="'+ year +'"]').removeClass('d-none');
		});

		$('#taskModal').on('show.bs.modal', function(event) {

			let button = $(event.relatedTarget);
			let task_id = $(button).attr('data-id');
			
			$('#task_discussion_form').data('id', task_id);

			fetch_task(task_id);
		});

		$('#taskModal').on('hide.bs.modal', function(event) {
			resetTask();
		});

		$('#task_discussion_form').submit(function(event) {

			event.preventDefault();

			let submitter = event.originalEvent.submitter;
			let buttonChild = $(submitter).html();
			let task_id = $(this).data('id');

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					"id_task": task_id,
					"message": $('#task_message').val()
				},
				dataType: "json",
				beforeSend: function() {
					$(submitter).attr('disabled', "disabled");
					$(submitter).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
				},
				success: function(response) {

					$(submitter).removeAttr("disabled");
					$(submitter).html(buttonChild);

					$('#task_message').val("");
					fetch_task(task_id);
				}
			});
		});
	});
</script>

<?php end_section(); ?>
