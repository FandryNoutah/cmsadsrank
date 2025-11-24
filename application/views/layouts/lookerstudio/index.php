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
    .searsh {
        background-color: #fbf4ec;
        color: #d28e3d;  
    }
	 .local {
        background-color: #f7f7e8;
        color: #b1ab1d;  
    }
	 .pmax {
        background-color: #f7eded;
        color: #af4b4b;  
    }
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4 py-2">Looker Studio</h1>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">

	
	<div class="tab-content" id="clientTabContent">

		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
			<div class="table-responsive">

				<table class="table table-wrapper">
					<thead class="bg-light text-muted">
						<tr>
							<th>
								Client
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								AM
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Date de création
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Label
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Rapport
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Rapport de conversion
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Rapport Conv. + CA
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Bilan
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>

							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($donnee as $d): ?>
							<?php if ($d->budget != 0) : ?>
								<tr class="client-filter" data-status="<?= $d->resiliation; ?>">
									<td>
										<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
											<img src="<?= $d->favicon ?>" class="img-thumbnail" width="28" height="28" alt="Client Image" style="margin-right: 8px;">
											<?= htmlspecialchars($d->nom_client) ?>
										</a>
									</td>

									<td class="text-muted"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d->am_photo_user)); ?>" width="28" height="28" alt="Client Image"></td>
									<td>
										<?= $d->mis_en_place_paiement ?>
									</td>
									<td>
										

										<?php
											$types = [
												1 => ['label' => 'Search', 'class' => 'badge searsh'],
												2 => ['label' => 'Local',  'class' => 'badge local'],
												3 => ['label' => 'PMax',   'class' => 'badge pmax']
											];

											$ids = array_unique(array_map('trim', explode(',', $d->campagnes)));
											sort($ids, SORT_NUMERIC);

											foreach ($ids as $id):
												if (isset($types[$id])):
											?>
													<span class="<?php echo $types[$id]['class']; ?>">
														<?php echo $types[$id]['label']; ?>
													</span>
											<?php
												endif;
											endforeach;
											?>


									</td>
									<td>
										<?php if (!empty($d->rapport)): ?>
											<a href="<?php echo $d->rapport; ?>" target="_blank">
												<span class="badge alert-success rounded-pill px-2 py-2" style="font-size: 12px; font-weight: 500;">
													<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
													Rapport
												</span>
											</a>
										<?php else: ?>
											<?php
												$types = [
													1 => ['label' => 'Search', 'class' => 'badge searsh'],
													3 => ['label' => 'PMax',   'class' => 'badge pmax']
												];

												$ids = array_unique(array_map('trim', explode(',', $d->campagnes)));
												sort($ids, SORT_NUMERIC);

												// On vérifie si Search (1) ou PMax (3) existent
												$hasSearchOrPmax = false;

												foreach ($ids as $id) {
													if (isset($types[$id])) {
														
														$hasSearchOrPmax = true;
													}
												}

												if ($hasSearchOrPmax) {
													// Afficher Upcoming
													?>
													<a href="#" onclick="alert('Aucun rapport disponible'); return false;">
														<span class="badge alert-primary rounded-pill px-2 py-2"
															style="font-size:12px; font-weight:500;">
															<i class="fa fa-circle mr-1" style="font-size:10px;"></i>
															Upcoming
														</span>
													</a>
													<?php
												} else {
													// Rien trouvé → afficher un tiret
													echo '-';
												}
												?>

										<?php endif; ?>
									</td>

										<td>
											<?php if (!empty($d->rapport_conversions)): ?>
											<a href="<?php echo $d->rapport_conversions; ?>" target="_blank">
												<span class="badge alert-success rounded-pill px-2 py-2" style="font-size: 12px; font-weight: 500;">
													<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
													Conversions
												</span>
											</a>
										<?php else: ?>
											<?php
												$types = [
													3 => ['label' => 'PMax',   'class' => 'badge pmax']
												];

												$ids = array_unique(array_map('trim', explode(',', $d->campagnes)));
												sort($ids, SORT_NUMERIC);

												// On vérifie si Search (1) ou PMax (3) existent
												$hasSearchOrPmax = false;

												foreach ($ids as $id) {
													if (isset($types[$id])) {
														
														$hasSearchOrPmax = true;
													}
												}

												if ($hasSearchOrPmax) {
													// Afficher Upcoming
													?>
													<a href="#" onclick="alert('Aucun rapport disponible'); return false;">
														<span class="badge alert-primary rounded-pill px-2 py-2"
															style="font-size:12px; font-weight:500;">
															<i class="fa fa-circle mr-1" style="font-size:10px;"></i>
															Upcoming
														</span>
													</a>
													<?php
												} else {
													// Rien trouvé → afficher un tiret
													echo '-';
												}
												?>
										<?php endif; ?>
										</td>
										<td>
										<?php if (!empty($d->rapport_conv_ca)): ?>
											<a href="<?php echo $d->rapport_conv_ca; ?>" target="_blank">
												<span class="badge alert-success rounded-pill px-2 py-2" style="font-size: 12px; font-weight: 500;">
													<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
													Conv. + CA
												</span>
											</a>
										<?php else: ?>
											-
										<?php endif; ?>	
										</td>
										<td>
										<?php if (!empty($d->bilan)): ?>
											<a href="<?php echo $d->bilan; ?>" target="_blank">
												<span class="badge alert-success rounded-pill px-2 py-2" style="font-size: 12px; font-weight: 500;">
													<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
													Bilan
												</span>
											</a>
										<?php else: ?>
										-
										<?php endif; ?>	
										</td>
										<td>
											<div class="dropdown no-arrow">
												<a href="javascript:void(0);" class="text-muted dropdown-toggle" data-toggle="dropdown">
													<i class="fa fa-ellipsis-v"></i>
												</a>
												<div class="dropdown-menu">
													<button type="button" 
															class="dropdown-item open-rapport-modal"
															data-toggle="modal" 
															data-target="#rapportmodal"
															data-id="<?= $d->idonnee; ?>"
															data-rapport="<?= $d->rapport; ?>"
															data-conv="<?= $d->rapport_conversions; ?>"
															data-convca="<?= $d->rapport_conv_ca; ?>"
															data-bilan="<?= $d->bilan; ?>">
														<i class="fa fa-edit mr-2"></i> Modifier
													</button>

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

		
<?php $this->load->view('layouts/lookerstudio/modal.php'); ?>

<?php end_section(); ?>
<?php start_section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Initialisation des compteurs
    let counts = [0, 0, 0, 0]; // correspond aux colonnes 5,6,7,8

    // Parcourt toutes les lignes du tableau
    const rows = document.querySelectorAll(".table-wrapper tbody tr");

    rows.forEach(row => {
        // Colonnes à vérifier : 5=rapport, 6=rapport de conversion, 7=Conv+CA, 8=bilan
        for (let i = 0; i < 4; i++) {
            const cell = row.children[4 + i]; // 4+i car les index commencent à 0
            if (cell.textContent.trim().includes("Upcoming")) {
                counts[i]++;
            }
        }
    });

    // Sélectionne les th correspondants
    const thIndices = [5, 6, 7, 8]; // colonnes 5 à 8
    thIndices.forEach((col, idx) => {
        const th = document.querySelector(`.table-wrapper thead tr th:nth-child(${col})`);
        th.textContent += ` (${counts[idx]})`;
    });
});
</script>
<?php end_section(); ?>


