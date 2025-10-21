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
<h1 class="h4 py-2">Plan de taggage</h1>
<div class="col-auto px-1">
		<button class="btn btn-dark" onclick="toggleEditMode()">Modifier</button>
	</div>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid">
	<!-- Mode lecture -->
	<div id="readOnlyView">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead class="bg-light text-muted">
					<tr>
						<th>Conversion</th>
						<th>Actions</th>
						<th>Types</th>
						<th>Remarque</th>
						<th>Etat</th>
						<th>Conditions</th>
						<th>Conversion ID</th>
						<th>Conversion Label</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($plan_taggage as $P): ?>
					<tr>
						<td><?= htmlspecialchars($P['conversion']) ?></td>
						<td><?= htmlspecialchars($P['actions']) ?></td>
						<td><?= htmlspecialchars($P['types']) ?></td>
						<td><?= htmlspecialchars($P['remarque']) ?></td>
						<td><?= htmlspecialchars($P['etat']) ?></td>
						<td><?= htmlspecialchars($P['conditions']) ?></td>
						<td><?= htmlspecialchars($P['conversion_id']) ?></td>
						<td><?= htmlspecialchars($P['extensions_appel']) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Mode édition (masqué par défaut) -->
	<div id="editModeView" style="display: none;">
		<form method="post" action="<?= base_url('Gtm/update_table') ?>">
			<div class="table-responsive mb-3">
				<table class="table table-bordered" id="editableTable">
					<thead class="bg-light text-muted">
						<tr>
							<th>Conversion</th>
							<th>Actions</th>
							<th>Types</th>
							<th>Remarque</th>
							<th>Etat</th>
							<th>Conditions</th>
							<th>Conversion ID</th>
							<th>Conversion Label</th>
							<th>Supprimer</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($plan_taggage as $index => $P): ?>
							<tr>
								<td><textarea name="rows[<?= $index ?>][conversion]" class="form-control auto-resize"><?= htmlspecialchars($P['conversion']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][actions]" class="form-control auto-resize"><?= htmlspecialchars($P['actions']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][types]" class="form-control auto-resize"><?= htmlspecialchars($P['types']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][remarque]" class="form-control auto-resize"><?= htmlspecialchars($P['remarque']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][etat]" class="form-control auto-resize"><?= htmlspecialchars($P['etat']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][conditions]" class="form-control auto-resize"><?= htmlspecialchars($P['conditions']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][conversion_id]" class="form-control auto-resize"><?= htmlspecialchars($P['conversion_id']) ?></textarea></td>
								<td><textarea name="rows[<?= $index ?>][conversion_label]" class="form-control auto-resize"><?= htmlspecialchars($P['extensions_appel']) ?></textarea></td>
								<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
								<input type="hidden" name="rows[<?= $index ?>][idplan_de_taggage]" value="<?= $P['idplan_de_taggage'] ?>">
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<button type="button" class="btn btn-secondary" onclick="addRow()">Ajouter ligne</button>
			<button type="submit" class="btn btn-success">Enregistrer</button>
			<button type="button" class="btn btn-outline-dark" onclick="cancelEditMode()">Annuler</button>
		</form>
	</div>
</div>
<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
function toggleEditMode() {
	document.getElementById('readOnlyView').style.display = 'none';
	document.getElementById('editModeView').style.display = 'block';
}

function cancelEditMode() {
	document.getElementById('readOnlyView').style.display = 'block';
	document.getElementById('editModeView').style.display = 'none';
}

function removeRow(button) {
	const row = button.closest('tr');
	const idInput = row.querySelector('input[name*="[idplan_de_taggage]"]');

	if (idInput && idInput.value) {
		// Ligne existante => marquer comme supprimée
		const hiddenInput = document.createElement('input');
		hiddenInput.type = 'hidden';
		hiddenInput.name = idInput.name.replace('[idplan_de_taggage]', '[deleted]');
		hiddenInput.value = '1';
		row.appendChild(hiddenInput);

		// Cacher visuellement
		row.style.display = 'none';
	} else {
		// Ligne ajoutée (pas encore dans la base) => supprimer complètement
		row.remove();
	}
}


function addRow() {
	const table = document.querySelector('#editableTable tbody');
	const rowCount = table.rows.length;
	const row = table.insertRow();

	const fields = ['conversion', 'actions', 'types', 'remarque', 'etat', 'conditions', 'conversion_id', 'conversion_label'];

	fields.forEach(field => {
		const cell = row.insertCell();
		const textarea = document.createElement('textarea');
		textarea.name = `rows[${rowCount}][${field}]`;
		textarea.className = 'form-control auto-resize';
		textarea.oninput = autoResize;
		cell.appendChild(textarea);
	});

	const cell = row.insertCell();
	const btn = document.createElement('button');
	btn.type = 'button';
	btn.className = 'btn btn-danger btn-sm';
	btn.innerText = 'X';
	btn.onclick = function () { removeRow(btn); };
	cell.appendChild(btn);
}

// Auto-resize des textarea
function autoResize() {
	this.style.height = 'auto';
	this.style.height = this.scrollHeight + 'px';
}

// Initialiser resize sur tous les textarea existants
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('textarea.auto-resize').forEach(textarea => {
		textarea.addEventListener('input', autoResize);
		textarea.dispatchEvent(new Event('input')); // initialiser
	});
});
</script>

<?php end_section(); ?>
