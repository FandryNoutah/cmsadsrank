<?php start_section('stylesheet'); ?>
<style>
	/* .table-wrapper {
		border-collapse: separate !important;
		border-spacing: 0 10px;
	}

	.table-wrapper tr {
		background: #fff;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
		border-radius: 8px;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		padding: 1rem;
	} */

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
<?php start_section('page_title'); ?>
GTM
<?php end_section(); ?>

<?php start_section('page_heading'); ?>


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
</div>

<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="tab-content" id="clientTabContent">
<ul class="nav nav-tabs mb-3" role="tablist">
		<li class="nav-item">
			<a class="nav-link py-3 active task-filter-button" data-type="0" type="button">
				GTM
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link py-3 task-filter-button" data-type="1" type="button">
				Optimisation
			</a>
		</li>
	</ul>
	<div class="container-fluid">
		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
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
								<td>2025-07-06</td>
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
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	</div>

	<div class="tab-pane fade" id="kanban" role="tabpanel" aria-labelledby="kanban_tab">
		<div class="row row-cols-3">

			<!-- ACTIVE COLUMN -->
			<div class="col mb-3">
				<div class="card h-100" style="border-radius: 8px;">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<span class="mx-1 badge alert-success rounded-pill p-2" style="font-size: 14px; font-weight: 500;">
								<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
								Active
							</span>
							<span class="badge alert-light mx-1 text-dark" style="font-size: 14px;">4</span>
							<a href="#" class="text-dark text-decoration-none ml-auto" style="font-size: 28px;">+</a>
						</div>

						<?php foreach ($donnee as $d): ?>
							<?php if ($d->budget != 0) : ?>
								<div class="card mt-3">
									<div class="card-body">
										<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" class="stretched-link"></a>
										<div class="d-block mb-3">
											<img src="<?= $d->favicon ?>" alt="" width="48">
										</div>
										<p style="font-size: 18px; font-weight: 400;" class="mb-3">
											<?= htmlspecialchars($d->nom_client) ?>
										</p>
										<div class="d-flex justify-content-between">
											<span class="text-muted">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
												<?= $d->mis_en_place_paiement ?>
											</span>
											<?php
											$budget = $d->budget;
											$budget = ($budget / 2) / 30.6;
											$budget = round($budget, 2);
											?>
											<span>
												<?= $budget; ?> €</td>
											</span>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<!-- PAUSE COLUMN -->
			<div class="col mb-3">
				<div class="card h-100" style="border-radius: 8px;">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<span class="mx-1 badge alert-warning rounded-pill p-2" style="font-size: 14px; font-weight: 500;">
								<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
								Pause
							</span>
							<span class="badge alert-light mx-1 text-dark" style="font-size: 14px;">4</span>
							<a href="#" class="text-dark text-decoration-none ml-auto" style="font-size: 28px;">+</a>
						</div>

						<div class="card mt-3">
							<div class="card-body">
								<div class="d-block mb-3">
									<img src="<?= base_url('assets/images/icons/figma/brand-logos-10.svg') ?>" alt="" width="48">
								</div>
								<p style="font-size: 18px; font-weight: 400;" class="mb-3">Ouest lyonnais climatisation plomberie SARL</p>
								<div class="d-flex justify-content-between">
									<span class="text-muted">
										<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
										16/08/2013
									</span>
									<span>$2.120</span>
								</div>
							</div>
						</div>
						<div class="card mt-3">
							<div class="card-body">
								<div class="d-block mb-3">
									<img src="<?= base_url('assets/images/icons/figma/brand-logos-10.svg') ?>" alt="" width="48">
								</div>
								<p style="font-size: 18px; font-weight: 400;" class="mb-3">Ouest lyonnais climatisation plomberie SARL</p>
								<div class="d-flex justify-content-between">
									<span class="text-muted">
										<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
										16/08/2013
									</span>
									<span>$2.120</span>
								</div>
							</div>
						</div>
						<div class="card mt-3">
							<div class="card-body">
								<div class="d-block mb-3">
									<img src="<?= base_url('assets/images/icons/figma/brand-logos-10.svg') ?>" alt="" width="48">
								</div>
								<p style="font-size: 18px; font-weight: 400;" class="mb-3">Ouest lyonnais climatisation plomberie SARL</p>
								<div class="d-flex justify-content-between">
									<span class="text-muted">
										<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
										16/08/2013
									</span>
									<span>$2.120</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- RESILIER COLUMN -->
			<div class="col mb-3">
				<div class="card h-100" style="border-radius: 8px;">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<span class="mx-1 badge alert-danger rounded-pill p-2" style="font-size: 14px; font-weight: 500;">
								<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
								Résilier
							</span>
							<span class="badge alert-light mx-1 text-dark" style="font-size: 14px;">4</span>
							<a href="#" class="text-dark text-decoration-none ml-auto" style="font-size: 28px;">+</a>
						</div>

						<div class="card mt-3">
							<div class="card-body">
								<div class="d-block mb-3">
									<img src="<?= base_url('assets/images/icons/figma/brand-logos-10.svg') ?>" alt="" width="48">
								</div>
								<p style="font-size: 18px; font-weight: 400;" class="mb-3">Ouest lyonnais climatisation plomberie SARL</p>
								<div class="d-flex justify-content-between">
									<span class="text-muted">
										<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
										16/08/2013
									</span>
									<span>$2.120</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layouts/client/modal.php'); ?>

<?php end_section(); ?>
