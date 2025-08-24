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
Onboarding
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<li class="nav-item">
		<a class="nav-link py-3 active" type="button" id="list_tab" data-toggle="tab" data-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">
			<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
			List
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" type="button" id="kanban_tab" data-toggle="tab" data-target="#kanban" type="button" role="tab" aria-controls="kanban" aria-selected="false">
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
								Site internet
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Déja client?
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Produit
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Budget
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Initiative
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								AM
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>

							<th>
								Création Compte Ads
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								DataStudio
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Annonce en ligne
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Email Onboarding
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
							<th>
								Facturation
								<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2">
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($donnee as $C): if ($C->budget != 0): ?>
								<tr>
									<!-- Client avec favicon + lien -->
									<td>
										<a href="<?= base_url('Client/detail_client/' . $C->idclients) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
											<img src="<?= $C->favicon ?>" class="img-thumbnail" width="28" height="28" alt="Client Image" style="margin-right: 8px;">
											<?= htmlspecialchars($C->nom_client) ?>
										</a>
									</td>

									<!-- Site internet -->
									<td><?= htmlspecialchars($C->site_client) ?></td>

									<!-- Déjà client -->
									<td>
										<?php if ($C->dejaclient == 0): ?>
											<span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px;">Oui</span>
										<?php else: ?>
											<span class="badge alert-warning rounded-pill px-2 py-1" style="font-size: 12px;">Non</span>
										<?php endif; ?>
									</td>

									<!-- Produit -->
									<td><?= htmlspecialchars($C->label_produit) ?></td>

									<!-- Budget -->
									<td>
										<?php $budget = round(($C->budget / 2) / 30.6, 2); ?>
										<?= $budget ?> €
									</td>

									<!-- Initiative -->
									<td>
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($C->tech_photo_user)); ?>" width="28" height="28" alt="Initiative">
									</td>

									<!-- AM -->
									<td>
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($C->am_photo_user)); ?>" width="28" height="28" alt="AM">
									</td>

									<!-- Gocardless 
							<td> //($C->mis_en_place_paiement != '0000-00-00') ? htmlspecialchars($C->mis_en_place_paiement) : '' ?></td>
	
							 Brief 
							<td>
								//($C->Brief != '0000-00-00') ? anchor("Googleads/Admin_brief/" . $C->idonnee, htmlspecialchars($C->Brief)) : 'N/D' ?>
							</td>
	
							Envoi structure 
							<td>
								 //($C->date_validation_structure != '0000-00-00') ? htmlspecialchars($C->date_validation_structure) : '' ?>
							</td>
	
						 Validation structure 
							<td>
								 //($C->validation_technique != '0000-00-00') ? anchor('Validation/validation_structure/' . $C->idclients, $C->validation_technique, ['target' => '_blank']) : '' ?>
							</td>
	
							 Lien multimedia 
							<td>
							  ($C->lien_datastudio == 1) ? anchor('Datastudio/datastudios/' . $C->idonnee, 'Lien', ['target' => '_blank']) : '' ?>
							</td> -->

									<!-- Création Compte Ads -->
									<td><?= ($C->Céation_compte_ads != '0000-00-00') ? htmlspecialchars($C->Céation_compte_ads) : 'Ajouter date' ?></td>

									<!-- DataStudio -->
									<td><?= ($C->datastudio == 1) ? 'Oui' : 'Non' ?></td>
									
									<!-- Annonce en ligne -->
									<td><?= ($C->annonce != '0000-00-00') ? htmlspecialchars($C->annonce) : '' ?></td>
									
									<!-- Paiement reçu -->
									<!-- <td><!?= ($C->paiement_recu == 1) ? 'Oui' : 'Non' ?></td> -->

									<!-- Email Onboarding -->
									<td><?= ($C->email_onboarding == 1) ? 'Oui' : 'Non' ?></td>

									<!-- Facturation -->
									<td><?= ($C->facturation == 1) ? 'Oui' : 'Non' ?></td>
								</tr>
						<?php endif;
						endforeach; ?>
					</tbody>

				</table>
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
</div>

<?php $this->load->view('layouts/client/modal.php'); ?>

<?php end_section(); ?>
