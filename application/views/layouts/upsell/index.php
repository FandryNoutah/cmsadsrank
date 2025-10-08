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

<?php start_section('page_title'); ?>
<h1 class="h4">Upsell / Baisse</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<div class="row mx-lg-2 my-2">
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
<div class="container-fluid">
		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
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
		<input type="date" id="dateStart" class="form-control" placeholder="Date début">
	</div>
	<div class="col-md-2">
		<input type="date" id="dateEnd" class="form-control" placeholder="Date fin">
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
						<th>
							Client
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Member
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Date de la demande
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Date Effective
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Type
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
						<th>
							Budget
							<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($upsell_active as $C): ?>
					<tr class="data-row"
						data-client="<?= htmlspecialchars($C['nom_client']); ?>"
						data-date="<?= htmlspecialchars($C['date_upsell']); ?>"
						data-type="<?= ($C['type_upsell'] == 2 ? 'Upsell' : 'Baisse'); ?>"
						data-budget="<?= (float) $C['budgets']; ?>">

						<td><?php echo htmlspecialchars($C['nom_client']); ?></td>  
						<td>
							<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($C['am_photo'])); ?>" width="28" height="28" alt="Client Image"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($C['tm_photo'])); ?>" width="28" height="28" alt="Client Image">
							<a style="display: none"><?php echo htmlspecialchars($C['nomam']); ?></a>
						</td>
						<td><?php echo htmlspecialchars($C['date_demande']); ?></td>  
						<td><?php echo htmlspecialchars($C['date_upsell']); ?></td>  
						<td><?php if($C['type_upsell'] == 2) :  ?>
								Upsell
							<?php endif; ?>
							<?php if($C['type_upsell'] ==1) :  ?>
								Baisse
							<?php endif; ?>
						</td> 
						<td><?php echo htmlspecialchars($C['budgets']); ?> €</td> 
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
	const dateStart = document.getElementById('dateStart');
	const dateEnd = document.getElementById('dateEnd');
	const rows = document.querySelectorAll('.data-row');
	const totalUpsell = document.getElementById('totalUpsell');
	const totalBaisse = document.getElementById('totalBaisse');

	function applyFilters() {
		let upsellTotal = 0;
		let baisseTotal = 0;
		const searchVal = searchInput.value.toLowerCase();
		const typeVal = typeFilter.value;
		const monthVal = monthFilter.value;
		const startVal = dateStart.value;
		const endVal = dateEnd.value;

		rows.forEach(row => {
			const client = row.dataset.client.toLowerCase();
			const type = row.dataset.type;
			const date = row.dataset.date;
			const budget = parseFloat(row.dataset.budget) || 0;

			let show = true;

			if (searchVal && !client.includes(searchVal)) show = false;
			if (typeVal && type !== typeVal) show = false;
			if (monthVal && !date.startsWith(monthVal)) show = false;
			if (startVal && date < startVal) show = false;
			if (endVal && date > endVal) show = false;

			row.style.display = show ? '' : 'none';

			if (show) {
				if (type === 'Upsell') upsellTotal += budget;
				if (type === 'Baisse') baisseTotal += budget;
			}
		});

		totalUpsell.textContent = `${upsellTotal.toFixed(2)} €`;
		totalBaisse.textContent = `${baisseTotal.toFixed(2)} €`;
	}

	searchInput.addEventListener('input', applyFilters);
	typeFilter.addEventListener('change', applyFilters);
	monthFilter.addEventListener('change', applyFilters);
	dateStart.addEventListener('change', applyFilters);
	dateEnd.addEventListener('change', applyFilters);
	applyFilters();
});
</script>

<?php end_section(); ?>
