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
	<?php if ($d['statut_demande_en_cours'] == 3): ?>

		<div class="modal fade" id="choixCampagneModal" tabindex="-1" aria-labelledby="choixCampagneLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content rounded-3 shadow-lg">
					<div class="modal-header">
						<h2 class="modal-title" id="choixCampagneLabel">Relance client</h2>
					</div>
					<div class="modal-body">
						<form method="post" action="<?= site_url('Client/relance'); ?>">

							<input type="hidden" name="idclients" value="<?= $d['idclients']; ?>">
							<div class="row row-cols-2 mt-4 mb-2">
								<div class="col">
									<div class="card camp-container h-100">
										<div class="card-body">
											<div class="d-block mb-2">
												<i class="fa fa-cloud" style="font-size: 22px;"></i>
											</div>
											<h3>Campagne précédente</h3>
											<p class="text-muted">Continuer avec la campagne existante.</p>
											<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-camp" data-target="#camp_resa">
												<i class="fa fa-arrow-right"></i>
											</a>
											<input type="radio" name="camp_param" id="camp_resa" value="1" class="d-none">
										</div>
									</div>
								</div>
								<div class="col">
									<div class="card camp-container h-100">
										<div class="card-body">
											<div class="d-block mb-2">
												<i class="fa fa-database" style="font-size: 22px;"></i>
											</div>
											<h3>Nouvelle campagne</h3>
											<p class="text-muted">Démarrer une nouvelle campagne à partir de zéro.</p>
											<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-camp" data-target="#camp_sale">
												<i class="fa fa-arrow-right"></i>
											</a>
											<input type="radio" name="camp_param" id="camp_sale" value="2" class="d-none">
										</div>
									</div>
								</div>


							</div>
							<div class="text-end mt-4">
								<button type="submit" class="btn btn-primary">Valider</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				var modal = new bootstrap.Modal(document.getElementById('choixCampagneModal'));
				modal.show();

				document.querySelectorAll('.select-camp').forEach(function(el) {
					el.addEventListener('click', function() {
						var target = document.querySelector(this.dataset.target);
						if (target) {
							target.checked = true;
							document.querySelectorAll('.camp-container').forEach(c => c.classList.remove('border-primary'));
							this.closest('.camp-container').classList.add('border', 'border-primary');
						}
					});
				});
			});
		</script>

	<?php endif; ?>

	<div class="row no-gutters h-100">

		<?php $this->load->view('layouts/client/detail/sidebar'); ?>

		<div class="col" style="height: calc(100vh - 101px); overflow-y:auto;">
			<div class="container-fluid position-relative pb-5">

				<div class="dropdown position-absolute" style="right: 15px;">
					<?php if ($d['statut_demande_en_cours'] == 0):  ?>
						<?php if ($d['resiliation'] == 1):  ?>
							<a type="button" class="badge alert-success rounded-pill px-4 py-3 mb-3 dropdown-toggle" style="font-size: 14px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
								Active
							</a>
						<?php endif; ?>
						<?php if ($d['resiliation'] == 2):  ?>
							<a type="button" class="badge alert-warning rounded-pill px-4 py-3 mb-3 dropdown-toggle" style="font-size: 14px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
								Mis en pause
							</a>
						<?php endif; ?>
						<?php if ($d['resiliation'] == 3):  ?>
							<a type="button" class="badge alert-danger rounded-pill px-4 py-3 mb-3 dropdown-toggle" style="font-size: 14px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
								Résilié
							</a>
						<?php endif; ?>
						<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="clientStatusDropdown">
							<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#statusModal">Statut Client</a>
						</div>
					<?php endif; ?>
					<?php if ($d['statut_demande_en_cours'] == 1 || $d['statut_demande_en_cours'] == 3):  ?>
						<a type="button" class="badge alert-second rounded-pill px-4 py-3 mb-3" style="font-size: 14px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
							En cours de changement
						</a>
					<?php endif; ?>
				</div>

				<div class="d-flex justify-content-start align-items-center mb-2" id="star_rating">
					<?php $noteClient = isset($note) ? $note : 0; ?>

					<?php for ($i = 1; $i <= 5; $i++): ?>
						<img
							src="<?= base_url('assets/images/icons/figma/') . ($i <= $noteClient ? 'star_full.svg' : 'Empty_Star.svg') ?>"
							alt="star"
							width="20"
							class="mr-1 star"
							data-index="<?= $i ?>">
					<?php endfor; ?>

					<input type="hidden" id="idclients" value="<?= $donnees[0]['idclients'] ?>">
				</div>

				<h1 class="mb-2" style="font-size: 48px; font-weight: 500;">
					<?= $d['nom_client'] ?>
				</h1>
				<h5 class="mb-3"><a href="<?= $d['site_client'] ?>" target="_blank" style="color: black"><?= $d['site_client'] ?></a></h5>

				<div class="row mb-3">
					<div class="col">
						<div class="card">
							<div class="card-body">
								<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
									<li class="nav-item">
										<a class="nav-link py-3 active" type="button">
											Société
										</a>
									</li>
								</ul>

								<h6 class="text-muted font-weight-normal" style="font-size: 14px;">
									<?= $d['info_base_client'] ?></br>
								</h6>
							</div>
						</div>
					</div>

					<div class="col-auto">
						<div class="card" style="width: 23rem;">
							<div class="card-body">
								<div class="d-flex justify-content-between align-items-center">
									<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
										<?php function format_budget($nombre)
										{
											return number_format($nombre, 0, '', ' ');
										} ?>
										<b><?= format_budget($d['budget']) ?> €</b>
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
								<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
									<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
									<span class="mr-2">Client</span>
									<div class="dropdown" style="display: inline-block;">
										<?php if ($d['Couleur'] == 0): ?>
											<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 500; color: Grey; cursor: pointer;">
												<i class="fa fa-circle mr-1" style="font-size: 14px;" id="colorIcon"></i>Choisir couleur
											</a>
										<?php endif; ?>
										<?php if ($d['Couleur'] == 1): ?>
											<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 500; color: #4976f4; cursor: pointer;">
												<i class="fa fa-circle mr-1" style="font-size: 14px;" id="colorIcon"></i>
											</a>
										<?php endif; ?>
										<?php if ($d['Couleur'] == 2): ?>
											<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 500; color: #e9165d; cursor: pointer;">
												<i class="fa fa-circle mr-1" style="font-size: 14px;" id="colorIcon"></i>
											</a>
										<?php endif; ?>
										<?php if ($d['Couleur'] == 3): ?>
											<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 500; color: #f6c500; cursor: pointer;">
												<i class="fa fa-circle mr-1" style="font-size: 14px;" id="colorIcon"></i>
											</a>
										<?php endif; ?>
										<?php if ($d['Couleur'] == 4): ?>
											<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 500; color: #1da946; cursor: pointer;">
												<i class="fa fa-circle mr-1" style="font-size: 14px;" id="colorIcon"></i>
											</a>
										<?php endif; ?>

										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="#" onclick="changeColor(1, '#0093cf', <?= $d['idclients'] ?>)">
												<i class="fa fa-circle" style="color: #0093cf;"></i>
											</a>
											<a class="dropdown-item" href="#" onclick="changeColor(2, '#e9165d', <?= $d['idclients'] ?>)">
												<i class="fa fa-circle" style="color: #e9165d;"></i>
											</a>
											<a class="dropdown-item" href="#" onclick="changeColor(3, '#f6c500', <?= $d['idclients'] ?>)">
												<i class="fa fa-circle" style="color: #f6c500;"></i>
											</a>
											<a class="dropdown-item" href="#" onclick="changeColor(4, '#1da946', <?= $d['idclients'] ?>)">
												<i class="fa fa-circle" style="color: #1da946;"></i>
											</a>
										</div>
									</div>
								</div>
								<a href="<?= base_url('Client/onboarding/' . $d['idclients']) ?>" class="btn btn-outline-dark btn-block">Onboarding</a>
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4">
					<div class="card-body">
						<div class="d-flex justify-content-between">
							<div class="row">
								<div class="col-auto">
									<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
										<li class="nav-item">
											<a class="nav-link py-2 active" type="button">
												Secteur Activité
											</a>
										</li>
									</ul>
								</div>
								<div class="col-auto">
									<span class="badge alert-dark py-2 px-4">Artisan Plombier</span>
								</div>
							</div>
							<div class="row">
								<div class="col-auto">
									<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
										<li class="nav-item">
											<a class="nav-link py-2 active" type="button">
												Logo
											</a>
										</li>
									</ul>
								</div>
								<div class="col-auto">
									<?php if ($d['logo_client'] == NULL): ?>
										<?php echo form_open_multipart('Client/upload_logo'); ?>

										<div class="form-group m-0">
											<input type="file" name="logo" id="logo" style="display: none;" onchange="this.form.submit();">
											<input type="hidden" name="idclients" value="<?= $d['idclients']; ?>">
											<button type="button" class="btn btn-light btn-sm" onclick="document.getElementById('logo').click();">
												<i class="fa fa-plus"></i> Ajouter Logo
											</button>
										</div>
										<?php echo form_close(); ?>
									<?php endif; ?>
									<?php if ($d['logo_client'] != NULL): ?>
										<?php echo form_open_multipart('Client/upload_logo'); ?>

										<div class="form-group">
											<input type="file" name="logo" id="logo" style="display: none;" onchange="this.form.submit();">
											<input type="hidden" name="idclients" value="<?= $d['idclients']; ?>">
											<button type="button" class="btn btn-light btn-sm" onclick="document.getElementById('logo').click();">
												<img src="<?php echo base_url($d['logo_client']); ?>" width="150" />
											</button>
										</div>
										<?php echo form_close(); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-auto">
									<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
										<li class="nav-item">
											<a class="nav-link py-2 active" type="button">
												Favicon
											</a>
										</li>
									</ul>
								</div>
								<div class="col-auto">
									<img src="<?= $d['favicon']; ?>" width="28" class="mr-2">
								</div>
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
								<table class="table table-wrapper" style="text-align: center;">
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
													<?php if ($u->type_upsell == 5): ?>
														<span class="badge alert-danger rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
															<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
															Résiliation complète </span>
													<?php endif; ?>
													<?php if ($u->type_upsell == 4): ?>
														<span class="badge alert-warning rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
															<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
															Mise en pause
														</span>
													<?php endif; ?>
												</td>
												<td><?= $u->date_demande ?></td>
												<td><?= $u->date_upsell ?></td>
												<td>
													<?php if ($u->type_upsell == 4): ?>
														Pause
													<?php endif; ?>
													<?php if ($u->type_upsell == 5): ?>
														Résilié
													<?php endif; ?>
													<?php if ($u->type_upsell == 1 || $u->type_upsell == 2): ?>
														<?= $u->budget_initiale ?> €
													<?php endif; ?>
												</td>
												<td>
													<?php if ($u->type_upsell == 4): ?>
														Pause
													<?php endif; ?>
													<?php if ($u->type_upsell == 5): ?>
														Résilié
													<?php endif; ?>
													<?php if ($u->type_upsell == 1 || $u->type_upsell == 2): ?>
														<?= $u->budgets ?> €
													<?php endif; ?>
												</td>
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
								<?php if (empty($matched_calls[0]->started_at)): ?>
									<h3 class="m-0">Invalide</h3>
								<?php endif; ?>
								<?php if (!empty($matched_calls[0]->started_at)): ?>
									<h3 class="m-0"><?= date('Y-m-d', $matched_calls[0]->started_at) ?></h3>
								<?php endif; ?>
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

										<?php if ($d['cms'] != "Inconnu ou non détectable automatiquement"): ?>
											<img src="<?= $d['cms_logo']; ?>" width="43">
										<?php endif; ?>
										<?php if ($d['cms'] == "Inconnu ou non détectable automatiquement"): ?>
											Inconnu ou non détectable automatiquement
										<?php endif; ?>
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
									<?php if (!empty($d['tracking_gtm'])): ?>
										<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
										<?= $d['tracking_gtm'] ?>
								</span>
							<?php endif; ?>
							<?php if (empty($d['tracking_gtm'])): ?>
								<span class="badge alert-danger rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
									<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
									GTM Non installé
								</span>

							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<br><br></br></br>

				<div class="d-flex justify-content-between">
					<h1 style="font-size: 48px;">Tâches en cours</h1>
					<form action="<?= base_url('Client/tache_client/' . $donnees[0]['idclients']) ?>" method="get">
						<button class="btn btn-outline-dark btn-lg" type="submit">Voir tout</button>
					</form>
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
												<a href="javascript:void(0);" class="text-decoration-none text-muted ta***REMOVED*** dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
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

	<?php $this->load->view('layouts/client/detail/modal/budget', $d); ?>
	<?php $this->load->view('layouts/client/detail/modal/edit', ['d' => $d]); ?>
	<?php $this->load->view('layouts/client/detail/modal/status'); ?>
	<?php $this->load->view('layouts/client/detail/modal/task'); ?>

<?php endforeach; ?>

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
			let year = $(this).val(); // .val() et non .data('year')
			$('.budget-year-row').addClass('d-none');
			$('.budget-year-row[data-year="' + year + '"]').removeClass('d-none');
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
<?php $noteClient = isset($note) ? $note : 0; ?>

<!-- <div class="d-flex justify-content-start align-items-center mb-3" id="star_rating">
	<?php for ($i = 1; $i <= 5; $i++): ?>
		<img
			src="<?= base_url('assets/images/icons/figma/') . ($i <= $noteClient ? 'star_full.svg' : 'Empty_Star.svg') ?>"
			alt="star"
			width="20"
			class="mr-1 star"
			data-index="<?= $i ?>">
	<?php endfor; ?>

	<span class="ml-3 py-1 px-3 badge" style="background-color: #edf2fe; color: #4976f4; font-size: 12px; font-weight: 500;">
		Bleu
	</span>

	<span id="selected-rating" class="ml-2 font-weight-bold text-primary">
		<?= $noteClient > 0 ? $noteClient . '/5' : '' ?>
	</span>
</div> -->

<!-- ID du client -->
<input type="hidden" id="idclients" value="<?= $donnees[0]['idclients'] ?>">
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const stars = document.querySelectorAll("#star_rating .star");
		const ratingDisplay = document.getElementById("selected-rating");
		const idClient = document.getElementById("idclients").value;

		stars.forEach(star => {
			star.addEventListener("click", function() {
				const rating = parseInt(this.dataset.index);

				// Mise à jour visuelle des étoiles
				stars.forEach((s, i) => {
					s.src = (i < rating) ?
						"<?= base_url('assets/images/icons/figma/star_full.svg') ?>" :
						"<?= base_url('assets/images/icons/figma/Empty_Star.svg') ?>";
				});

				// Affiche la note choisie
				if (ratingDisplay) ratingDisplay.textContent = rating + "/5";

				// Envoi AJAX au serveur
				fetch("<?= base_url('Client/enregistrer') ?>", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded"
						},
						body: "rating=" + encodeURIComponent(rating) + "&idclients=" + encodeURIComponent(idClient)
					})
					.then(res => res.json())
					.then(data => {
						if (data.status === "success") {
							console.log("Note enregistrée !");
						} else {
							console.error("Erreur serveur:", data.message);
						}
					})
					.catch(err => console.error("Erreur AJAX:", err));
			});
		});
	});


	function changeColor(colorId, colorHex, idclients, el) {
		$(el).closest('.dropdown').find('#colorIcon').css('color', colorHex);

		$.ajax({
			url: '<?= base_url("Client/change_color") ?>',
			type: 'POST',
			data: {
				color_id: colorId,
				idclients: idclients
			},
			success: function(response) {
				try {
					const data = JSON.parse(response);
					if (data.status === 'success' && data.redirect_url) {
						window.location.href = data.redirect_url;
					} else {
						alert('Erreur : ' + (data.message || 'inconnue'));
					}
				} catch (e) {
					console.error('Réponse invalide du serveur:', response);
					alert('Erreur de traitement de la réponse.');
				}
			}

		});
	}
</script>

<?php end_section(); ?>
