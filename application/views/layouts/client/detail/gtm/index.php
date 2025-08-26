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
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>

<?php foreach ($donnees as $d): ?>
	<div class="row no-gutters h-100">

		<?php $this->load->view('layouts/client/detail/sidebar'); ?>

		<div class="col" style="height: calc(100vh - 101px); overflow-y:auto;">
			<div class="container-fluid pb-5">

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link py-3 active" type="button" id="gtm_tab" data-toggle="tab" data-target="#gtm" type="button" role="tab" aria-controls="list" aria-selected="true">
							<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
							Google Task Manager
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link py-3" type="button" id="optimisation_tab" data-toggle="tab" data-target="#optimisation" type="button" role="tab" aria-controls="kanban" aria-selected="false">
							<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
							Optimisation
						</a>
					</li>
				</ul>
				<div class="tab-content" id="clientTabContent">
					<div class="tab-pane fade show active mb-5" id="gtm" role="tabpanel" aria-labelledby="gtm_tab">
						<div class="table-responsive">

							<table class="table table-wrapper">
								<thead class="bg-light text-muted">
									<tr>
										<th>
											Société
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											URL
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											AM
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Date de la demande
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Invitation reçu
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											GTM
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Status
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											<!-- Actions -->
										</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($donnee as $d): ?>
										<?php if ($d->budget != 0) : ?>
											<tr>
												<td>
													<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
														<img src="<?= $d->favicon ?>" class="img-thumbnail" width="28" height="28" alt="Client Image" style="margin-right: 8px;">
														<?= htmlspecialchars($d->nom_client) ?>
													</a>
												</td>

												<td class="text-muted"><?= $d->site_client ?></td>
												<td>
													<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d->am_photo_user)); ?>" width="28" height="28" alt="Client Image">
												</td>
												<td class="text-muted">
													<i class="fa fa-calendar"></i>
													16/08/2013
												</td>
												<td>
													<span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
														<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
														2025-08-17
													</span>
												</td>
												<td>
													<span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
														<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
														Installé
													</span>
												</td>
												<td>
													<span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
														<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
														Implémenté
													</span>
												</td>
												<td>
													<div class="dropdown no-arrow">
														<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
															<i class="fa fa-ellipsis-v"></i>
														</a>
														<div class="dropdown-menu">
															<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $d->idonnee; ?>">
																<i class="fa fa-eye mr-2"></i>
																Détails
															</button>
															<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $d->idonnee; ?>">
																<i class="fa fa-edit mr-2"></i>
																Modifier
															</button>
															<div class="dropdown-divider"></div>
															<a href="<?= base_url('Gtm/delete/' . $d->idonnee); ?>" class="dropdown-item text-danger" data-id="<?= $d->idonnee; ?>">
																<i class="fa fa-trash mr-2"></i>
																Supprimer
															</a>
														</div>
													</div>
												</td>
											</tr>
										<?php endif; ?>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="tab-pane fade" id="optimisation" role="tabpanel" aria-labelledby="optimisation_tab">

						<div class="table-responsive">
							<table class="table table-wrapper">
								<thead class="bg-light text-muted">
									<tr>
										<th>
											Task Name
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Débogage
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Discussion
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Octobre
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Novembre
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											Décembre
											<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
										</th>
										<th>
											<!-- Actions -->
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											Volt Consulting
										</td>
										<td class="text-muted">
											<span class="badge alert-danger rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
												<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
												Erreur
											</span>
										</td>
										<td>
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url(IMAGES_PATH . '/icons/figma/frame-5518.png'); ?>" class="avatar rounded-circle" width="28" height="28" alt="Client Image">
												<img src="<?= base_url(IMAGES_PATH . '/icons/figma/frame-5518.png'); ?>" class="avatar rounded-circle" width="28" height="28" alt="Client Image">
											</div>
										</td>
										<td class="text-muted">
											<span class="badge alert-warning rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
												<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
												16/08/2013
											</span>
										</td>
										<td class="text-muted">
											<span class="badge alert-warning rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
												<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
												16/08/2013
											</span>
										</td>
										<td class="text-muted">
											<span class="badge alert-warning rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
												<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
												16/08/2013
											</span>
										</td>
										<td>
											<div class="dropdown no-arrow">
												<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
													<i class="fa fa-ellipsis-v"></i>
												</a>
												<div class="dropdown-menu">
													<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="">
														<i class="fa fa-eye mr-2"></i>
														Détails
													</button>
													<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="">
														<i class="fa fa-edit mr-2"></i>
														Modifier
													</button>
													<div class="dropdown-divider"></div>
													<a href="#" class="dropdown-item text-danger" data-id="<?= $d->idonnee; ?>">
														<i class="fa fa-trash mr-2"></i>
														Supprimer
													</a>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php end_section(); ?>
