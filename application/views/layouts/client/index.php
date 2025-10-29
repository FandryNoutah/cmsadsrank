<?php start_section('stylesheet'); ?>
<style>
	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
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

	.table-wrapper th:nth-child(2),
	.table-wrapper td:nth-child(2) {
		width: 15%;
	}

	.table-wrapper th:nth-child(3),
	.table-wrapper td:nth-child(3) {
		width: 10%;
	}

	.table-wrapper th:nth-child(4),
	.table-wrapper td:nth-child(4) {
		width: 15%;
	}

	.table-wrapper th:nth-child(5),
	.table-wrapper td:nth-child(5) {
		width: 10%;
	}

	.table-wrapper th:nth-child(6),
	.table-wrapper td:nth-child(6) {
		width: 15%;
	}

	.budget {
		font-weight: 500;
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4">Client</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<li class="nav-item">
		<a class="nav-link py-3 active" type="button" id="list_tab" data-toggle="tab" data-target="#list" role="tab" aria-controls="list" aria-selected="true">
			<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
			List
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" type="button" id="kanban_tab" data-toggle="tab" data-target="#kanban" role="tab" aria-controls="kanban" aria-selected="false">
			<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
			Kanban
		</a>
	</li>
</ul>

<div class="row mx-lg-2 ml-auto">
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
		<button class="btn btn-dark" data-toggle="modal" data-target="#clientModal">
			<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
			Ajouter Client
		</button>
	</div>
</div>

<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">

	<div class="btn-group btn-group-toggle my-4" data-toggle="buttons">
		<label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="0" checked>
			All Companies
		</label>
		<label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="1">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #589E67;"></i>
			Active
		</label>
		<label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="2">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #B1AD1B;"></i>
			Pause
		</label>
		<label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="3">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #AF4B4B;"></i>
			Résilier
		</label>
	</div>

	<div class="tab-content" id="clientTabContent">

		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
			<div class="table-responsive">
				<table class="table table-wrapper">
					<thead class="bg-light text-muted">
						<tr>
							<th>Client</th>
							<th>Produit</th>
							<th>AM</th>
							<th>Client depuis le</th>
							<th>Budget</th>
							<th>Statut</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($donnee as $d): ?>
							<?php if ($d->budget != 0): ?>
								<tr class="client-filter" data-status="<?= $d->resiliation; ?>">
									<td>
										<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
											<img src="<?= $d->favicon ?>" class="img-thumbnail" width="28" height="28" alt="Client Image" style="margin-right: 8px;">
											<?= htmlspecialchars($d->nom_client) ?>
										</a>
									</td>

									<td class="text-muted"><?= $d->label_produit ?></td>
									<td>
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d->tech_photo_user)); ?>" width="28" height="28">
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d->am_photo_user)); ?>" width="28" height="28">
									</td>
									<td><?= date('d-m-Y', strtotime($d->mis_en_place_paiement)); ?></td>
									<td>
										<div class="budget">
											<?php if ($current_user->tech != 3): ?>
												<?php
												$budget = ($d->budget / 2) / 30.6;
												$budget = round($budget, 2);
												?>
												<?= $budget; ?> €
											<?php else: ?>
												<?= $d->budget; ?> €
											<?php endif; ?>
										</div>
									</td>
									<td>
										<?php if ($d->statut_demande_en_cours != 1): ?>
											<?php if ($d->resiliation == 1): ?>
												<span class="badge alert-success rounded-pill px-2 py-1">Active</span>
											<?php elseif ($d->resiliation == 2): ?>
												<span class="badge alert-warning rounded-pill px-2 py-1">Mis en pause</span>
											<?php elseif ($d->resiliation == 3): ?>
												<span class="badge alert-danger rounded-pill px-2 py-1">Résilié</span>
											<?php endif; ?>
										<?php else: ?>
											<span class="badge alert-second rounded-pill px-2 py-1" style="color: grey;">En cours de changement</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Kanban Section -->
		<div class="tab-pane fade" id="kanban" role="tabpanel" aria-labelledby="kanban_tab">
			<div class="row row-cols-3">

				<!-- ACTIVE -->
				<div class="col mb-3">
					<div class="card h-100">
						<div class="card-body">
							<span class="mx-1 badge alert-success rounded-pill p-2">Active</span>
							<?php foreach ($donnee as $d): ?>
								<?php if ($d->budget != 0 && $d->resiliation == 1): ?>
									<div class="card mt-3">
										<div class="card-body">
											<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" class="stretched-link"></a>
											<div class="mb-3"><img src="<?= $d->favicon ?>" width="48"></div>
											<p class="mb-3"><?= htmlspecialchars($d->nom_client) ?></p>
											<div class="d-flex justify-content-between">
												<span class="text-muted">
													<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>">
													<?= date('d-m-Y', strtotime($d->mis_en_place_paiement)); ?>
												</span>
												<div class="budget">
													<?php if ($current_user->tech != 3): ?>
														<?php $budget = round(($d->budget / 2) / 30.6, 2); ?>
														<?= $budget; ?> €
													<?php else: ?>
														<?= $d->budget; ?> €
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<!-- PAUSE -->
				<div class="col mb-3">
					<div class="card h-100">
						<div class="card-body">
							<span class="mx-1 badge alert-warning rounded-pill p-2">Pause</span>
							<?php foreach ($donnee as $d): ?>
								<?php if ($d->budget != 0 && $d->resiliation == 2): ?>
									<div class="card mt-3">
										<div class="card-body">
											<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" class="stretched-link"></a>
											<div class="mb-3"><img src="<?= $d->favicon ?>" width="48"></div>
											<p class="mb-3"><?= htmlspecialchars($d->nom_client) ?></p>
											<div class="d-flex justify-content-between">
												<span class="text-muted">
													<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>">
													<?= date('d-m-Y', strtotime($d->mis_en_place_paiement)); ?>
												</span>
												<div class="budget">
													<?php if ($current_user->tech != 3): ?>
														<?php $budget = round(($d->budget / 2) / 30.6, 2); ?>
														<?= $budget; ?> €
													<?php else: ?>
														<?= $d->budget; ?> €
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<!-- RÉSILIÉ -->
				<div class="col mb-3">
					<div class="card h-100">
						<div class="card-body">
							<span class="mx-1 badge alert-danger rounded-pill p-2">Résilié</span>
							<?php foreach ($donnee as $d): ?>
								<?php if ($d->budget != 0 && $d->resiliation == 3): ?>
									<div class="card mt-3">
										<div class="card-body">
											<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" class="stretched-link"></a>
											<div class="mb-3"><img src="<?= $d->favicon ?>" width="48"></div>
											<p class="mb-3"><?= htmlspecialchars($d->nom_client) ?></p>
											<div class="d-flex justify-content-between">
												<span class="text-muted">
													<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>">
													<?= date('d-m-Y', strtotime($d->mis_en_place_paiement)); ?>
												</span>
												<div class="budget">
													<?php if ($current_user->tech != 3): ?>
														<?php $budget = round(($d->budget / 2) / 30.6, 2); ?>
														<?= $budget; ?> €
													<?php else: ?>
														<?= $d->budget; ?> €
													<?php endif; ?>
												</div>
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

<?php $this->load->view('layouts/client/modal.php'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
	$(function() {
		$('.status-select').change(function() {
			let status = $(this).val();
			let $labels = $('.status-select').parent('label');

			$labels.removeClass('btn-light').addClass('btn-white text-muted');
			$labels.find(`.status-select[value="${status}"]`)
				.parent('label')
				.removeClass('btn-white text-muted')
				.addClass('btn-light');

			if (status == 0) {
				$('.client-filter').removeClass('d-none');
			} else {
				$('.client-filter').addClass('d-none');
				$('.client-filter[data-status="' + status + '"]').removeClass('d-none');
			}
		});
	});
</script>
<?php end_section(); ?>
