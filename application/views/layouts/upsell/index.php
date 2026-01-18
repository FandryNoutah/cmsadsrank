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
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4">Suivi Budget</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<div class="row mx-lg-2" style="height: 50px;">
	<div class="col-auto px-1">
		<select id="userFilter" class="custom-select border-dark" style="margin-top: 5px;">
			<option value="">Sélectionner un utilisateur</option>
			<?php foreach($users as $u): ?>
				<option value="<?= $u->id ?>"><?= $u->first_name; ?> <?= $u->last_name; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid" style="margin-top: 20px;">
	<div class="tab-pane fade show active mb-5" id="list" role="tabpanel">
		<div class="row mb-3">
			<div class="col-md-3">
				<input type="text" id="searchInput" class="form-control" placeholder="Rechercher un client...">
			</div>
			<div class="col-md-2">
				<select id="typeFilter" class="form-control">
					<option value="">Tous</option>
					<option value="Upsell">Upsell</option>
					<option value="Baisse">Baisse</option>
				</select>
			</div>
			<div class="col-md-2">
				<input type="month" id="monthFilter" class="form-control">
			</div>
			<div class="col-md-2">
				<select id="statusFilter" class="form-control">
					<option value="">Tous les statuts</option>
					<option value="1">En ligne</option>
					<option value="0">En attente</option>
				</select>
			</div>
		</div>

		<div class="row mb-2">
			<div class="col-md-3">
				<strong>Total Upsell: </strong><span id="totalUpsell">0 €</span>
			</div>
			<div class="col-md-3">
				<strong>Total Baisse: </strong><span id="totalBaisse">0 €</span>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-wrapper">
				<thead class="bg-light text-muted">
					<tr>
						<th>Client</th>
						<th>Member</th>
						<th>Date de la demande</th>
						<th>Date Effective</th>
						<!-- <th>Type</th> -->
						<th>Budget</th>
						<th>Statut</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($upsell_active as $C): ?>
					<tr class="data-row"
						data-client="<?= htmlspecialchars($C['nom_client']); ?>"
						data-type="<?= ($C['type_upsell'] == 2 ? 'Upsell' : 'Baisse'); ?>"
						data-date="<?= htmlspecialchars($C['date_upsell']); ?>"
						data-budget="<?= (float)$C['budgets']; ?>"
						data-status="<?= htmlspecialchars($C['statut_actif']); ?>"
						data-user="<?= htmlspecialchars($C['am']); ?>">
						
						<td><?= htmlspecialchars($C['nom_client']); ?></td>
						<td>
							<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($C['tm_photo'])); ?>" width="28" height="28" alt="TM">
							<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($C['am_photo'])); ?>" width="28" height="28" alt="AM">
							
							<a style="display: none"><?= htmlspecialchars($C['nomam']); ?></a>
						</td>
						<td><?= htmlspecialchars($C['date_demande']); ?></td>
						<td><?= htmlspecialchars($C['date_upsell']); ?></td>
						<!-- <td>?= ($C['type_upsell'] == 2) ? 'Upsell' : 'Baisse'; ?></td> -->
						<td><?= htmlspecialchars($C['budgets']); ?> €</td>
						<td>
							<?php if($C['statut_actif'] == 0): ?>
								<span class="badge alert-warning px-2 py-1">En attente</span>
							<?php else: ?>
								<span class="badge alert-success px-2 py-1">En ligne</span>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const searchInput = document.getElementById('searchInput');
	const typeFilter = document.getElementById('typeFilter');
	const monthFilter = document.getElementById('monthFilter');
	const userFilter = document.getElementById('userFilter');
	const statusFilter = document.getElementById('statusFilter');
	const rows = document.querySelectorAll('.data-row');
	const totalUpsell = document.getElementById('totalUpsell');
	const totalBaisse = document.getElementById('totalBaisse');

	function applyFilters() {
		let upsellTotal = 0;
		let baisseTotal = 0;
		const searchVal = searchInput.value.toLowerCase();
		const typeVal = typeFilter.value;
		const monthVal = monthFilter.value;
		const userVal = userFilter.value;
		const statusVal = statusFilter.value;

		rows.forEach(row => {
			const client = row.dataset.client.toLowerCase();
			const type = row.dataset.type;
			const date = row.dataset.date;
			const budget = parseFloat(row.dataset.budget) || 0;
			const user = row.dataset.user;
			const status = row.dataset.status;

			let show = true;

			if (searchVal && !client.includes(searchVal)) show = false;
			if (typeVal && type !== typeVal) show = false;
			if (monthVal && !date.startsWith(monthVal)) show = false;
			if (userVal && user !== userVal) show = false;
			if (statusVal && status !== statusVal) show = false;

			row.style.display = show ? '' : 'none';

			if (show) {
				if (type === 'Upsell') upsellTotal += budget;
				if (type === 'Baisse') baisseTotal += budget;
			}
		});

		totalUpsell.textContent = `${upsellTotal.toFixed(2)} €`;
		totalBaisse.textContent = `${baisseTotal.toFixed(2)} €`;
	}

	// Activation des filtres
	[searchInput, typeFilter, monthFilter, userFilter, statusFilter].forEach(el => {
		el.addEventListener('input', applyFilters);
		el.addEventListener('change', applyFilters);
	});

	applyFilters();
});
</script>
<?php end_section(); ?>
