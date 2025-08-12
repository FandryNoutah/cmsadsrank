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
Client
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<div class="row mx-lg-2 ml-auto my-3">
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

<div class="container-fluid my-4">
	<div class="btn-group btn-group-toggle" data-toggle="buttons">
		<label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" name="options" id="option1" checked>
			All Companies
		</label>
		<label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
			<input type="radio" name="options" id="option2">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #589E67;"></i>
			Active
		</label>
		<label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
			<input type="radio" name="options" id="option3">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #B1AD1B;"></i>
			Pause
		</label>
		<label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
			<input type="radio" name="options" id="option3">
			<i class="fa fa-circle mr-2" style="font-size: 10px; color: #AF4B4B;"></i>
			Résilier
		</label>
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
					Produit
					<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
				</th>
				<th>
					AM
					<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
				</th>
				<th>
					Client depuis le
					<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
				</th>
				<th>
					Budget
					<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
				</th>
				<th>
					Statut
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

						<td class="text-muted"><?php echo $d->label_produit ?></td>
						<td>
							<img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($d->tech_photo_user)); ?>" width="28" height="28" alt="Client Image"><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($d->am_photo_user)); ?>" width="28" height="28" alt="Client Image">
						</td>
						<td><?php echo $d->mis_en_place_paiement ?></td>
						<td><?php
							$budget = $d->budget;
							$budget = ($budget / 2) / 30.6;
							$budget = round($budget, 2);
							?>
							<?php echo $budget; ?> €</td>
						<td>
							<span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
								<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
								Active
							</span>
						</td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php $this->load->view('layouts/client/modal.php'); ?>

<?php end_section(); ?>
