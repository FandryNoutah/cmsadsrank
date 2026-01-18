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
<h1 class="h4">Excel</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	
<div class="col-auto px-1">
    <button id="exportExcelBtn" class="btn btn-dark" type="button">
        <img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
        Exporter en excel
    </button>
</div>

</div>

<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">


	<div class="tab-content" id="clientTabContent">

		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
			<div class="table-responsive">
				<table class="table table-wrapper">
					<thead class="bg-light text-muted">
						<tr>
							<th>Client</th>
							<th>GTM</th>
							<th>Google Ads</th>
							<th>Analytics</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($donnee as $d): ?>
							<?php //if ($d->budget != 0): ?>
								<tr class="client-filter" data-status="<?= $d->resiliation; ?>">
									<td>
											<?= htmlspecialchars($d->nom_client) ?>
										</a>
									</td>

									<td class="text-muted"><?= $d->tracking_gtm ?></td>
									<td class="text-muted"><?= $d->googleads ?></td>
									<td class="text-muted"><?= $d->google_analytics ?></td>
									
								</tr>
							<?php //endif; ?>
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
											<?php if($d->favicon != "https://www.memoriafuneraire.com/favicon.ico"): ?>	
											<div class="mb-3"><img src="<?= $d->favicon ?>" width="48"></div>
											<?php else: ?>
											<div class="mb-3"><img src="<?= base_url('assets/images/ico/default_favicon.png') ?>" width="48"></div>
											<?php endif; ?>
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

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
document.getElementById('exportExcelBtn').addEventListener('click', function () {
    // crée un formulaire caché
    var form = document.createElement('form');
    form.method = 'GET'; // ou 'POST' si tu veux
    form.action = '<?= site_url("excel/export") ?>';

    // si CodeIgniter CSRF est activé et tu veux POST, ajoute le token :
    <?php if ($this->config->item('csrf_protection')): ?>
        var inputToken = document.createElement('input');
        inputToken.type = 'hidden';
        inputToken.name = '<?= $this->security->get_csrf_token_name() ?>';
        inputToken.value = '<?= $this->security->get_csrf_hash() ?>';
        form.appendChild(inputToken);
    <?php endif; ?>

    document.body.appendChild(form);
    form.submit();
});
</script>
<?php end_section(); ?>

