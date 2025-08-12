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
	<div class="container-fluid p-0 h-100">
		<div class="row no-gutters h-100">

			<?php $this->load->view('layouts/client/detail/sidebar'); ?>

			<div class="col w-100">
				<div class="container-fluid">

					<span class="badge alert-success rounded-pill px-4 py-3 mb-3" style="font-size: 12px; font-weight: 500;">
						<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
						Active
					</span>
					<div class="d-flex justify-content-start align-items-center mb-3">
						<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
						<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
						<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
						<img src="<?= base_url('assets/images/icons/figma/star_full.svg') ?>" alt="star_full" width="20" class="mr-1">
						<img src="<?= base_url('assets/images/icons/figma/star_half.svg') ?>" alt="star_half" width="20" class="mr-1">
						<span class="ml-3 py-1 px-3 badge" style="background-color: #edf2fe; color: #4976f4; font-size: 12px; font-weight: 500;">Bleu</span>
					</div>
					<h1 class="font-weight-bold mb-3" style="font-size: 48px;">
						<?php echo $d['nom_client'] ?>
						<img src="<?php echo $d['favicon']; ?>" width="43" class="float-right">
					</h1>
					<h5 class="mb-3"><?php echo $d['site_client'] ?></h5>
					<div class="row no-gutters mb-3">
						<div class="col pr-2">
							<div class="card h-100 mb-5">
								<div class="card-body">
									<ul class="nav nav-tabs mb-2">
										<li class="nav-item">
											<a class="nav-link py-3 active" type="button">
												Société
											</a>
										</li>
									</ul>

									<h6 class="text-muted font-weight-normal">
										<?php echo $d['info_base_client'] ?>
									</h6>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<div class="card h-100" style="width: 360px;">
								<div class="card-body">
									<div class="d-flex justify-content-between align-items-center">
										<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
											<?php echo $d['budget'] ?> €
										</button>
										<div class="dropdown no-arrow">
											<a href="javascript:void(0);" class="btn btn-light rounded-pill px-3 nav-link dropdown-toggle" id="clientDetailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fa fa-ellipsis-v" style="font-size: 16px;"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="clientDetailDropdown">
												<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#editModal">Modifier</a>
												<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#statusModal">Statut Client</a>
											</div>
										</div>
									</div>
									<br><br>
									<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
										<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
										<span class="mr-2">Date d'anniversaire</span>
										<span class="mr-2">|</span>
										<span class="mr-2"><?php echo $d['mis_en_place_paiement'] ?></span>
									</div>
									<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
										<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
										<span class="mr-2">Date de Mise en ligne</span>
										<span class="mr-2">|</span>
										<span class="mr-2"><?php echo $d['annonce'] ?></span>
									</div>
									<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
										<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
										<span class="mr-2">Commerciale</span>
										<span class="mr-2">
											<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24">
										</span>
									</div>
									<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
										<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
										<span class="mr-2">Account Manager</span>
										<span class="mr-2">
											<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24">
										</span>
									</div>
									<button class="btn btn-outline-dark btn-block">Onboarding</button>
								</div>
							</div>
						</div>
					</div>

					<div class="row row-cols-4 mb-5">
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
									<h3 class="m-0">Le 10/07/2025</h3>
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
									<h3 class="m-0"><?php echo $nbr_task ?> Tâches en cours</h3>
								</div>
							</div>
						</div>
					</div>

					<br><br>
					<ul class="nav nav-tabs mr-auto border-bottom mb-3" role="tablist">
						<li class="nav-item">
							<a class="nav-link py-3 active" type="button" id="budget_tab" data-toggle="tab" data-target="#budget" type="button" role="tab" aria-controls="budget" aria-selected="true">
								<img src="<?= base_url('assets/images/icons/figma/icon-budget.svg') ?>" alt="">
								Budget Annuel
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3" type="button" id="variation_tab" data-toggle="tab" data-target="#variation" type="button" role="tab" aria-controls="variation" aria-selected="false">
								<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
								Variations
							</a>
						</li>
					</ul>
					<div class="tab-content" id="taskTabContent">
						<div class="tab-pane fade mb-5 show active" id="budget" role="tabpanel" aria-labelledby="budget_tab">
							<div class="card">
								<div class="card-body">
									<h5>Budget</h5>
									<div class="d-flex align-items-center">
										<h2 class="mr-2"><?= $d['budget'] ?> Є</h2>
										<div class="mr-auto">
											<span class="badge alert-success rounded-pill py-2 px-3 font-weight-normal" style="font-size: 14px;">
												<i class="fa fa-chart-line mr-1"></i>
												12%
											</span>
										</div>
										<select class="form-control w-auto mr-5 border-dark text-dark" style="font-size: 14px; font-weight: 500;">
											<option selected>2023</option>
											<option value="1">2024</option>
											<option value="2">2025</option>
										</select>
									</div>
									<span class="text-muted" style="font-size: 14px;">Average Open Rate</span>
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
												<tr>
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
													<td><?php echo $u->date_demande ?></td>
													<td><?php echo $u->date_upsell ?></td>
													<td><?php echo $u->budget_initiale ?> €</td>
													<td><?php echo $u->budgets ?> €</td>
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

					<br><br>

					<h1 style="font-size: 48px;">Loocker Studio</h1>
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

					<br><br>

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
											<img src="<?php echo $d['cms_logo']; ?>" width="43">
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
										<?php echo $d['tracking_gtm'] ?>
									</span>
								</div>
							</div>
						</div>
					</div><br><br>

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
												<a href="javascript:void(0);" class="ml-auto">
													<i class="fa fa-ellipsis-v"></i>
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

							</tbody>
						</table>
					</div><br><br>

					<h1 style="font-size: 48px;">Point Bilan</h1>
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
	</div>

<?php endforeach; ?>

<?php $this->load->view('layouts/client/detail/modal/budget'); ?>
<?php $this->load->view('layouts/client/detail/modal/edit'); ?>
<?php $this->load->view('layouts/client/detail/modal/status'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
	$(function() {

		const chartData = <?= $chartData ?>;
		const tooltipData = <?= $tooltipData ?>;

		const currentMonthIndex = new Date().getMonth();

		// Generate colors
		const colors = chartData.map((_, i) => i === currentMonthIndex ? '#000000' : '#D8D8D8');

		const options = {
			chart: {
				type: 'bar',
				height: 400,
				toolbar: {
					show: false
				},
				events: {
					dataPointSelection: function(event, chartContext, config) {
						// Optional: handle click
					}
				}
			},
			series: [{
				name: 'Budget',
				data: chartData
			}],
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				labels: {
					style: {
						fontSize: '16px'
					}
				}
			},
			yaxis: {
				max: 6500,
				min: 0,
				tickAmount: 5,
				labels: {
					style: {
						fontSize: '16px'
					}
				}
			},
			plotOptions: {
				bar: {
					distributed: true,
					borderRadius: 5,
					columnWidth: '32px',
					endingShape: 'flat'
				}
			},
			colors: colors,
			states: {
				hover: {
					filter: {
						type: 'none'
					}
				},
				active: {
					allowMultipleDataPointsSelection: true,
					filter: {
						type: 'none'
					}
				}
			},
			tooltip: {
				custom: function({
					dataPointIndex
				}) {
					if (!tooltipData[dataPointIndex].length) return '';
					const item = tooltipData[dataPointIndex][0];
					return `
						<div class="card shadow-0 border-0">
							<div class="card-body p-3">
								<span class="badge badge-dark p-2 rounded-pill mr-2">
									<i class="fa fa-envelope-open"></i>
								</span>
								<span class="text-muted" style="font-weight: 500;">${item.date}</span>
								<div class="card mt-2">
									<div class="card-body p-2 bg-light" style="font-weight: 500;">
										<span class="text-muted">Budget</span>
										<span class="text-dark font-weight-bold" style="font-size: 16px;">${item.budget}</span>
									</div>
								</div>
							</div>
						</div>
					`;
				}
			},
			fill: {
				colors: colors
			},
			stroke: {
				width: 0
			},
			grid: {
				borderColor: '#ccc',
				yaxis: {
					lines: {
						show: true
					}
				},
				strokeDashArray: 4,
			},
			dataLabels: {
				enabled: false
			},
			legend: {
				show: false
			}
		};

		const chart = new ApexCharts(document.querySelector("#budgetChart"), options);

		chart.render();

		// Change color on hover and click
		/* $(document).on('mouseover', '.apexcharts-bar-area', function() {
			$(this).find('path').attr('fill', '#000');
		});
		$(document).on('mouseout', '.apexcharts-bar-area', function() {
			$(this).find('path').attr('fill', '#D8D8D8');
		}); */
	});
</script>

<?php end_section(); ?>
