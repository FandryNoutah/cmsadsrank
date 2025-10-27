<?php start_section('stylesheet') ?>
<style>
	/* Bigger switch size */
	.custom-switch.custom-switch-xl .custom-control-label::before {
		width: 95px;
		height: 40px;
		border-radius: 40px;
	}

	.custom-switch.custom-switch-xl .custom-control-label::after {
		width: 34px;
		/* knob size */
		height: 34px;
		border-radius: 50%;
		top: 7px;
		left: -32.7px;
		transition: transform 0.25s ease-in-out;
	}

	/* move knob when checked */
	.custom-switch.custom-switch-xl .custom-control-input:checked~.custom-control-label::after {
		transform: translateX(55px);
		/* 95 - knob(36) - margin(4) = ~55 */
	}

	/* ON background (black) */
	.custom-switch.custom-switch-xl .custom-control-input:checked~.custom-control-label::before {
		background-color: #000;
		border-color: #000;
	}

	/* .custom-control-input {
		transform: scale(1.5);
		margin-right: 10px;
	} */

	.step {
		display: none;
	}

	.step.active {
		display: block;
	}

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

	/* Style de la checkbox personnalisée */
	.toggle {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
	}

	.toggle input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	.switch {
		position: absolute;
		cursor: pointer;
		background-color: #ccc;
		border-radius: 34px;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		transition: 0.4s;
	}

	.knob {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		transition: 0.4s;
		border-radius: 50%;
	}

	/* Quand la checkbox est cochée */
	.toggle input:checked+.switch {
		background-color: Black;
	}

	/* Position de la "knob" quand c'est coché */
	.toggle input:checked+.switch .knob {
		transform: translateX(26px);
	}

	/* Style désactivé */
	.toggle input:disabled+.switch {
		background-color: #aaa;
		cursor: not-allowed;
	}

.toggle input:disabled + .switch .knob {
  background-color: #e0e0e0;
}
.conversion-container {
  cursor: pointer;
  transition: transform 0.2s;
}
.conversion-container:hover {
  transform: scale(1.03);
}
.border-primary {
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.4);
}
.camp-type-container {
  cursor: pointer;
  transition: all 0.25s ease;
}
.camp-type-container:hover {
  transform: scale(1.03);
}
.camp-type-container.border-dark {
  box-shadow: 0 0 10px rgba(0,0,0,0.25);
}
.google_btn{
	background-color: #1A73E8;
	color: white;
}
.google_btn:hover {
	background-color: #3162a3ff;
	color: white;
}

	.conversion-container {
		cursor: pointer;
		transition: transform 0.2s;
	}

	.conversion-container:hover {
		transform: scale(1.03);
	}

	.border-primary {
		box-shadow: 0 0 10px rgba(0, 123, 255, 0.4);
	}

	.camp-type-container {
		cursor: pointer;
		transition: all 0.25s ease;
	}

	.camp-type-container:hover {
		transform: scale(1.03);
	}

	.camp-type-container.border-dark {
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
	}

	/** INVENTORY MOCKUP STYLESHEET */
	/* Container */
	.pmax-mockups .mockup {
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	/* Icons & Labels */
	.mockup-icon img {
		width: 36px;
		height: auto;
	}

	.mockup-label {
		font-weight: 500;
		margin-top: 6px;
		margin-bottom: 10px;
		color: #333;
	}

	/* Phone frame */
	.phone-frame {
		width: 250px;
		height: 450px;
		background: #fff;
		border: 2px solid #ddd;
		border-radius: 30px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		position: relative;
		overflow: hidden;
	}

	.phone-frame::before {
		content: "";
		position: absolute;
		top: 6px;
		left: 50%;
		width: 40px;
		height: 4px;
		background: #ccc;
		border-radius: 10px;
		transform: translateX(-50%);
	}

	/* Screen area */
	.screen {
		width: 100%;
		height: 100%;
		background: #f8f9fa;
		padding: 25px 8px 8px 8px;
	}

	/* YouTube preview */
	.youtube-preview .thumbnail {
		width: 100%;
		height: 160px;
		background: #ddd url('https://placehold.co/300x160?text=Video+Thumbnail') center/cover;
		border-radius: 8px;
	}

	.youtube-preview .video-info {
		margin-top: 8px;
	}

	.youtube-preview .video-title {
		font-weight: 600;
		font-size: 13px;
		color: #111;
	}

	.youtube-preview .video-desc {
		font-size: 11px;
		color: #666;
	}

	/* Gmail preview */
	.gmail-preview .mail-header {
		display: flex;
		align-items: center;
		margin-bottom: 8px;
	}

	.gmail-preview .avatar {
		width: 30px;
		height: 30px;
		background: #ccc;
		border-radius: 50%;
		margin-right: 8px;
	}

	.gmail-preview .mail-title {
		font-size: 13px;
		font-weight: 600;
	}

	.gmail-preview .mail-desc {
		font-size: 11px;
		color: #666;
	}

	.gmail-preview .mail-image {
		width: 100%;
		height: 160px;
		background: #ddd url('https://placehold.co/300x160?text=Ad+Image') center/cover;
		border-radius: 8px;
	}

	/* Maps preview */
	.maps-preview {
		position: relative;
		background: #e6f0ff;
		border-radius: 8px;
		height: 100%;
	}

	.maps-preview .map {
		background: url('https://placehold.co/300x200?text=Map') center/cover;
		height: 160px;
		border-radius: 8px;
	}

	.maps-preview .pin {
		position: absolute;
		top: 70px;
		left: 50%;
		width: 20px;
		height: 20px;
		background: red;
		border-radius: 50% 50% 50% 0;
		transform: rotate(-45deg) translateX(-50%);
		border: 2px solid white;
	}

	.maps-preview .maps-desc {
		margin-top: 12px;
		font-size: 12px;
		color: #333;
		text-align: center;
	}

	/* Search preview */
	.search-preview .search-bar {
		background: #fff;
		border: 1px solid #ccc;
		height: 24px;
		border-radius: 20px;
		margin-bottom: 8px;
	}

	.search-preview .result-link {
		color: #006621;
		font-size: 11px;
	}

	.search-preview .result-title {
		font-weight: 600;
		color: #1a0dab;
		font-size: 13px;
	}

	.search-preview .result-desc {
		color: #545454;
		font-size: 11px;
	}

	/** INVENTORY MOCKUP STYLESHEET */
</style>
<?php end_section() ?>

<?php start_section('content'); ?>
<?php foreach ($donnees as $d): ?>
	<div class="row no-gutters h-100">
		<?php $this->load->view('layouts/client/onboarding/sidebar'); ?>

		<div class="col" style="height: calc(100vh - 101px); overflow-y:auto;">
			<div class="container-fluid pb-5 pt-3">


				<div class="dropdown position-absolute" style="right: 15px;">
						<?php if($current_user->tech == 3): ?>
						<?php if ($d['statut_brief'] == 1):  ?>
							<a type="button" class="badge alert-success rounded-pill px-4 py-3 mb-3 " style="font-size: 14px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
								Brief complété
							</a>
						<?php endif; ?>
						<?php if ($d['statut_brief'] == 0): ?>
							<div class="dropdown mb-3">
								<a class="badge alert-warning rounded-pill px-4 py-3 dropdown-toggle"
								href="#" id="clientStatusDropdown_<?= $d['idonnee'] ?>"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
								style="font-size: 14px; font-weight: 500;">
									<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
									Brouillon
								</a>

								<div class="dropdown-menu" aria-labelledby="clientStatusDropdown_<?= $d['idonnee'] ?>">
									<a href="#" class="dropdown-item text-primary sendToStructure"
									data-id="<?= $d['idonnee'] ?>">
										Envoyer à la structure
									</a>
								</div>
							</div>

							<!-- Modal de confirmation -->
							<div class="modal fade" id="confirmSendModal_<?= $d['idonnee'] ?>" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Confirmation</h5>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											Voulez-vous envoyer à la technique ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
											<form action="<?= site_url('Client/send_to_technique/' . $d['idonnee']) ?>" method="post" style="display:inline;">
												<button type="submit" class="btn btn-primary">Oui, envoyer</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>



						<?php endif; ?>
						<?php if($current_user->tech == 1): ?>
						<?php if ($d['statut_envoye'] == 1):  ?>
							<a type="button" class="badge alert-success rounded-pill px-4 py-3 mb-3 dropdown-toggle" style="font-size: 14px; font-weight: 500;" id="clientStatusDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
								Annonce complété
							</a>
							<?php endif; ?>
							<?php if ($d['statut_envoye'] == 0): ?>
								<div class="dropdown mb-3">
									<!-- Badge Annonce brouillon -->
									<a class="badge alert-warning rounded-pill px-4 py-3 dropdown-toggle"
									href="#" id="annonceStatusDropdown_<?= $d['idonnee'] ?>"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
									style="font-size: 14px; font-weight: 500;">
										<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
										Annonce brouillon
									</a>

									<div class="dropdown-menu" aria-labelledby="annonceStatusDropdown_<?= $d['idonnee'] ?>">
										<a href="#" class="dropdown-item text-primary sendAnnonce"
										data-id="<?= $d['idonnee'] ?>">
											Envoyer l’annonce
										</a>
									</div>
								</div>

								<!-- Modal de confirmation -->
								<div class="modal fade" id="confirmSendAnnonceModal_<?= $d['idonnee'] ?>" tabindex="-1" role="dialog">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Confirmation</h5>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												Voulez-vous vraiment envoyer cette annonce ?
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
												<form action="<?= site_url('Client/send_annonce/' . $d['idonnee']) ?>" method="post" style="display:inline;">
													<input type="hidden" value="<?= $d['account_manager'] ?>" name="am">
													<button type="submit" class="btn btn-primary">Oui, envoyer</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>

						<?php endif; ?>
				</div>
				<h1 class="mb-2" style="font-size: 48px; font-weight: 500;">
					Onboarding : <?= $d['nom_client'] ?>
				</h1>


					<div class="row mb-3">
						<div class="col">
							<div class="card">
								<div class="card-body">
									<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
										<li class="nav-item">
											<a class="nav-link py-3 active" type="button">
												Société
											</a>
										</li>
									</ul>

									<h6 class="text-muted font-weight-normal" style="font-size: 14px;">
										<?= nl2br($d['info_base_client']) ?></br>
									</h6>
								</div>
							</div>
						</div>

						<div class="col-auto">
							<div class="card" style="width: 23rem;">
								<div class="card-body">
									<div class="d-flex justify-content-between align-items-center">
										<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
											<?php function format_budget($nombre)
											{
												return number_format($nombre, 0, '', ' ');
											} ?>
											<b><?= format_budget($d['budget']) ?> €</b>
										</button>
									</div>
									<br><br>
									<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
										<i class="fa fa-check-square mr-2" style="color: Black; font-size: 18px;"></i>
										<span class="mr-2">Date d'anniversaire : <?= $d['mis_en_place_paiement'] ?></span>
									</div>
									<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
										<i class="fa fa-check-square mr-2" style="color: Black; font-size: 18px;"></i>
										<span class="mr-2">Date de mise en ligne : <?= $d['annonce'] ?></span>

									</div>
									<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
										<i class="fa fa-check-square mr-2" style="color: Black; font-size: 18px;"></i>
										<span class="mr-2">Commerciale</span>
										<span class="mr-2">
											<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24">
										</span>
									</div>
									<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
										<i class="fa fa-check-square mr-2" style="color: Black; font-size: 18px;"></i>
										<span class="mr-2">Account Manager</span>
										<span class="mr-2">
											<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24">
										</span>
									</div>
									<!-- <a href="< base_url('Client/annonces/' . $d['idclients']) ?>" class="btn btn-outline-dark btn-block">Voir annonce</a> -->
									<a href="<?= base_url('Validation/validation_structure/' . $d['idclients']) ?>" class="btn btn-outline-dark btn-block" target="_blank" >Annonce</a>
									<button type="button" class="btn btn-outline-dark btn-block" data-toggle="modal" data-target="#inventaireModal">
									Inventaire
									</button>
								<?php //echo anchor('Validation/validation_structure/' . $C->idclients, $C->validation_technique, ['style' => 'color: white', 'data-edit' => $C->idclients, 'target' => '_blank']); ?>		
								</div>
							</div>
						</div>
					</div>
					
				<h1 class="display-1 text-center mt-4" style="font-size: 42px;">
					Brief
				</h1>
				<div class="d-flex justify-content-between">
					<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
						<li class="nav-item">
							<a class="nav-link py-3 active" type="button">
								Brief client
							</a>
						</li>
					</ul>
					<div class="d-inline">
						<?php if (!empty($d['information_client'])): ?>
							<button class="btn btn-dark" data-toggle="modal" data-target="#briefModal">
								<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
								Modifier Brief
							</button>
						<?php else: ?>
							<button class="btn btn-dark" data-toggle="modal" data-target="#briefModal">
								<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
								Ajouter Brief
							</button>
						<?php endif; ?>
					</div>
				</div>
				<?php if (!empty($d['information_client'])): ?>
					<div class="card">
						<div class="card-body" style="height: 300px; overflow-y: auto;">
							<?= nl2br($d['information_client']); ?>
						</div>

					</div>
				<?php endif; ?>
				<!-- GTM -->
				<h1 class="display-1 text-center my-5" style="font-size: 42px;">
					Mise en place Google Tag manager
				</h1>

				<div class="card mb-3">
					<div class="card-body py-5 px-4">
						<div class="row align-items-center">

							<div class="col-6 text-center">
								<h3 class="mb-3" style="font-size: 32px; font-weight: 500;">Google Tag Manager</h3>

								<?php if (!empty($d['tracking_gtm'])): ?>
									<p class="text-muted" style="font-size: 18px; line-height: 150%;">
										Action : Demander l’accès administrateur au conteneur GTM (gtm@adsrank.fr) et vérifier la configuration.
									</p>
								<?php endif; ?>

								<?php if (empty($d['tracking_gtm'])): ?>
									<p class="text-muted" style="font-size: 18px; line-height: 150%;">
										Action : Vous pouvez activer la procédure GTM.
									</p>
								<?php endif; ?>
							</div>

							<div class="col-3">
								<?php if (!empty($d['tracking_gtm'])): ?>
									<span class="badge alert-success rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
										<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
										<?php echo $d['tracking_gtm']; ?>
									</span>
								<?php endif; ?>

								<?php if (empty($d['tracking_gtm'])): ?>
									<span class="badge alert-danger rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
										<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
										GTM non installé
									</span>
								<?php endif; ?>
							</div>
							<div class="col-3 text-center">
								<?php if (empty($procedure_gtm)): ?>
									<label class="toggle" aria-label="Activer procédure">
										<input type="checkbox" class="activer-procedure"
											data-idclient="<?php echo $d['idclients']; ?>"
											data-am="<?php echo $d['initiative']; ?>"
											data-assigned="<?php echo $d['account_manager']; ?>" />
										<span class="switch">
											<span class="knob"></span>
										</span>
									</label>
								<?php else: ?>
									<h2> Déja en place </h2>
									<label class="toggle" aria-label="Activer procédure">
										<input type="checkbox" class="activer-procedure"
											data-idclient="<?php echo $d['idclients']; ?>"
											data-am="<?php echo $d['initiative']; ?>"
											data-assigned="<?php echo $d['account_manager']; ?>"
											checked disabled />
										<span class="switch">
											<span class="knob"></span>
										</span>
									</label>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<!-- === MODAL POUR PARAMÈTRES DE CAMPAGNE === -->
				<div class="modal fade" id="parametresCampagneModal" tabindex="-1" aria-labelledby="parametresCampagneLabel" aria-hidden="true">
					<div class="modal-dialog modal-xl modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title fs-4" id="parametresCampagneLabel">Paramètres de la campagne</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
							</div>
							<div class="modal-body">
								<p class="text-center text-muted" style="font-size: 18px;">
									Pour atteindre les bonnes personnes, commencez par définir les paramètres clés de votre campagne
								</p>

								<div class="row row-cols-3 mt-4 mb-3">
									<div class="col">
										<div class="card conversion-container" data-value="ecommerce">
											<div class="card-body text-center">
												<div class="d-block mb-3">
													<i class="fa fa-database" style="font-size: 22px;"></i>
												</div>
												<h3>Site de vente</h3>
												<p class="text-muted">A centralized repository storing all contact.</p>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="card conversion-container" data-value="lead">
											<div class="card-body text-center">
												<div class="d-block mb-3">
													<i class="fa fa-link" style="font-size: 22px;"></i>
												</div>
												<h3>Site formulaire</h3>
												<p class="text-muted">Setting tasks, follow-ups, or reminders.</p>
											</div>
										</div>
									</div>
									<div class="col">
										<div class="card conversion-container" data-value="reservation">
											<div class="card-body text-center">
												<div class="d-block mb-3">
													<i class="fa fa-cloud" style="font-size: 22px;"></i>
												</div>
												<h3>Site Réservation</h3>
												<p class="text-muted">Automatically updating and enriching contact.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer d-flex justify-content-between">
								<button type="button" class="btn btn-primary" id="btnActiverCampagne" disabled>Activer</button>
							</div>
						</div>
					</div>
				</div>


				<!-- BRIEF -->
				<h1 class="display-1 text-center mt-4" style="font-size: 42px;">
					Campagne
				</h1>
				<div class="table-responsive">
					<table class="table table-wrapper">
						<thead class="bg-light text-muted">
							<tr>
								<th>ACTION</th>
								<th>TYPE</th>
								<th>CAMPAGNE</th>
								<th>BUDGET</th>
								<th>DEMANDE</th>
								<th>STATUT</th>
								<th></th> <!-- expand icon -->
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($donne_valider)): ?>
								<?php foreach ($donne_valider as $campagne): ?>
									<!-- parent row -->
									<tr>
										<td>
											<div class="dropdown no-arrow">
												<a class="dropdown-toggle text-decoration-none" href="#" data-toggle="dropdown">
													<i class="fa fa-ellipsis-v"></i>
												</a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="<?= site_url("Client/campagne/" . $idclients . "?id_camp=" . $campagne['idcampagne']) ?>">Modifier</a>
													<a class="dropdown-item text-danger" href="<?= site_url("Client/supprimer_campagne/" . $campagne['idcampagne']) ?>" onclick="return confirm('Supprimer cette campagne ?');">Supprimer</a>
													<!-- <php if ($campagne['type_campagne'] == 1): ?>
															<a class="dropdown-item" href="<?= site_url("Googleads/ajout_groupeannonce/" . $campagne['idcampagne']) ?>">Ajouter Groupe</a>
														<php elseif ($campagne['type_campagne'] == 2): ?>
															<a class="dropdown-item" href="<?= site_url("Googleads/ajout_groupeannonce_local/" . $campagne['idcampagne']) ?>">Ajouter Groupe Local</a>
														<php elseif ($campagne['type_campagne'] == 3): ?>
															<a class="dropdown-item" href="<?= site_url("Googleads/ajout_groupeannonce_pmax/" . $campagne['idcampagne']) ?>">Ajouter Groupe PMax</a>
														<php endif; ?>
														-->
												</div>
											</div>
										</td>
										<td>
											<?php
											switch ($campagne['type_campagne']) {
												case 1:
													echo "Search";
													break;
												case 2:
													echo "Local";
													break;
												case 3:
													echo "PMax";
													break;
												default:
													echo "Inconnu";
													break;
											}
											?>
										</td>
										<td><?= htmlspecialchars($campagne['nom_campagne']) ?></td>
										<td><?= isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0 ?> €</td>
										<td><span class="badge alert-primary">GTM</span></td>
										<td>
											<?php if (!empty($campagne['actif'])): ?>
												<span class="badge alert-primary"><i class="fa fa-circle"></i> En cours</span>
											<?php else: ?>
												<span class="badge alert-success"><i class="fa fa-circle"></i> Terminée</span>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<a data-toggle="collapse" href="#child<?= $campagne['idcampagne'] ?>" role="button" aria-expanded="false" aria-controls="child<?= $campagne['idcampagne'] ?>">
												<i class="fa fa-chevron-down text-muted"></i>
											</a>
										</td>
									</tr>

									<!-- child row -->
									<tr id="child<?= $campagne['idcampagne'] ?>" class="collapse border-0">
										<td colspan="7" class="border-0 p-0 pl-5">
											<?php if (!empty($campagne['groupes_annonces'])): ?>
												<table class="table table-wrapper mb-0">
													<tbody>
														<?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
															<tr>
																<td style="width: 200px;">
																	<strong><?= htmlspecialchars($groupe['nom_groupe']) ?></strong>
																</td>
																<td style="width:500px;">
																	<?= htmlspecialchars($groupe['contexte_groupes_annonces']) ?>
																</td>
																<td>
																	<?php
																	$mots = array_filter(array_map('trim', explode("\n", $groupe['mot_cle'])));
																	$totalMots = count($mots);
																	$motsAffiches = array_slice($mots, 0, 3);

																	foreach ($motsAffiches as $mot) {
																		echo '<span class="badge badge-secondary mr-1">' . htmlspecialchars($mot) . '</span>';
																	}

																	if ($totalMots > 3) {
																		echo '<span class="badge badge-secondary mr-1">...</span>';
																	}
																	?>
																</td>

																	<td>
																		<?php if ($groupe['statut'] == 1): ?>
																			<img src="<?= base_url('assets/images/icons/figma/CheckCircle.png') ?>" alt="Actif">
																		<?php else: ?>
																			<span class="text-muted">En cours</span>
																		<?php endif; ?>
																	</td>
																	<td style="width: 100px;">
																		<a href="<?= base_url('Client/insertgroupeannonce/' . $groupe['idgroupe_annonce']) ?>" class="btn btn-sm google_btn">
																			Créer annonce
																		</a>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												<?php else: ?>
													<em>Aucun groupe</em>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="7" class="text-center text-muted">Aucune campagne trouvée.</td>
									</tr>
							<?php endif; ?>
						</tbody>
					</table>

				</div>

				<button class="btn btn-dark" id="create_camp_button">
					<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
					Création Nouvelle Campagne
				</button>

				<div id="camp_creation_step" class="d-none">
					<p style="display: none;"><?= nl2br(htmlspecialchars($d['information_client'])); ?> </p>
					<!-- CAMPAGNE -->
					<div id="campagne_step" class="step active mb-4">
						<h1 class="display-1 text-center mt-5" style="font-size: 42px;">
							Choisissez votre objectif
						</h1>
						<p class="text-center text-muted" style="font-size: 18px;">
							Sélectionner un objectif pour adapter votre expérience aux objectifs et aux paramètres qui fonctionneront le mieux pour votre campagne
						</p>
						<div class="row row-cols-3 mt-4 mb-3">
							<div class="col">
								<div class="card h-100 camp-type-container">
									<div class="card-body">
										<img src="<?= base_url('assets/images/icons/figma/content_icon.png') ?>" alt="" class="mb-3" width="110">
										<h3>Search</h3>
										<p class="text-muted">Create, customize, and manage email marketing campaigns.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-conversion-type" data-target="#camp_1">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="camp_type" id="camp_1" value="1" class="d-none">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card h-100 camp-type-container">
									<div class="card-body">
										<img src="<?= base_url('assets/images/icons/figma/content_icon.png') ?>" alt="" class="mb-3" width="110">
										<h3>Performance Max</h3>
										<p class="text-muted">Tailor emails by segmenting contacts based on demographics, behavior.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-conversion-type" data-target="#camp_3">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="camp_type" id="camp_3" value="3" class="d-none">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card h-100 camp-type-container">
									<div class="card-body">
										<img src="<?= base_url('assets/images/icons/figma/relation_icon.png') ?>" alt="" class="mb-3" width="90">
										<h3>Locale</h3>
										<p class="text-muted">Create, customize, and manage email marketing campaigns.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-conversion-type" data-target="#camp_2">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="camp_type" id="camp_2" value="2" class="d-none">
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end align-items-center">
							<button class="btn btn-dark px-4 float-right" id="final_button">Suivant</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('layouts/client/onboarding/modal/brief', ['d' => $d]) ?>
	<?php $this->load->view('layouts/client/onboarding/modal/client') ?>
	<?php $this->load->view('layouts/client/onboarding/modal/inventaire_pmax') ?>


<?php endforeach; ?>
<?php end_section(); ?>


<?php start_section('script') ?>
<script>
	$(document).ready(function() {
    // Clic sur "Envoyer l’annonce"
    $(document).on('click', '.sendAnnonce', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $('#confirmSendAnnonceModal_' + id).modal('show');
    });
});

	$(document).ready(function() {

    // Clic sur "Envoyer à la structure"
    $(document).on('click', '.sendToStructure', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $('#confirmSendModal_' + id).modal('show');
    });

    // Clic sur "Oui, envoyer" dans la modale
    $(document).on('click', '.confirmSend', function() {
        const id = $(this).data('id');
        const modal = $('#confirmSendModal_' + id);
        modal.modal('hide');

        $.ajax({
            url: '<?= site_url("Client/send_to_technique") ?>/' + id,
            type: 'POST',
            success: function() {
                alert('Brief envoyé avec succès !');
                location.reload(); // rafraîchit la page
            },
            error: function() {
                alert('Erreur lors de l\'envoi.');
            }
        });
    });

});

	$(document).ready(function() {

		$('#clientModal').on('show.bs.modal', function(event) {

			let button = event.relatedTarget;
			var clientId = $(button).data('id');

			// Charge le contenu via AJAX
			$('#clientModalContent').html('Chargement...');

			$.ajax({
				url: '<?= site_url("Client/details_ajax") ?>/' + clientId,
				type: 'GET',
				success: function(response) {
					$('#clientModalContent').html(response);
				},
				error: function() {
					$('#clientModalContent').html("Erreur lors du chargement.");
				}
			});
		});

		let selectedConversion = null;
		let idclients = null;
		let am = null;
		let assigned_to = null;

		// Quand on clique sur le toggle
		$('.activer-procedure').change(function() {
			if (this.checked) {
				// On récupère les infos du data-
				idclients = $(this).data('idclient');
				am = $(this).data('am');
				assigned_to = $(this).data('assigned');

				// On ouvre la modale
				$('#parametresCampagneModal').modal('show');

				// On empêche l'envoi direct (au cas où)
				this.checked = false;
			}
		});

		// Quand on clique sur une carte de conversion
		$(document).on('click', '.conversion-container', function() {
			$('.conversion-container').removeClass('border-primary');
			$(this).addClass('border border-3 border-primary');
			selectedConversion = $(this).data('value');
			$('#btnActiverCampagne').prop('disabled', false);
		});

		// Quand on clique sur "Activer" dans la modale
		$('#btnActiverCampagne').click(function() {
			if (!selectedConversion) {
				alert('Veuillez sélectionner un type de conversion avant de continuer.');
				return;
			}

			let date_today = new Date().toISOString().split('T')[0];

			$.ajax({
				url: "<?php echo base_url('Client/activer_processus_tache'); ?>",
				method: "POST",
				data: {
					idclients: idclients,
					am: am,
					assigned_to: assigned_to,
					date: date_today,
					conversion: selectedConversion
				},
				success: function(response) {
					$('#parametresCampagneModal').modal('hide');
					alert("Processus activé avec succès !");
					location.reload(); // optionnel : rafraîchit la page
				},
				error: function() {
					alert("Erreur lors de l'activation du processus.");
				}
			});
		});

		// --- Bouton "Créer nouvelle campagne" ---
		$('#create_camp_button').click(function() {
			$('#camp_creation_step').removeClass('d-none');
			$('.scroll-container').animate({
				scrollTop: $('.scroll-container')[0].scrollHeight
			}, 800);
		});

		// --- Sélection du type de campagne (un seul choix) ---
		$('.select-conversion-type').click(function() {
			let target = $(this).data('target');
			$(target).prop('checked', true);

			// On retire le style de sélection sur les autres cartes
			$('.camp-type-container').removeClass('border-dark shadow');
			// On ajoute le style sur la carte sélectionnée
			$(this).closest('.camp-type-container').addClass('border-dark shadow');
		});

		// --- Validation / passage à la suite ---
		$('#final_button').click(function() {
			let camp_type = $('input[name="camp_type"]:checked').val();

			if (!camp_type) {
				alert("Veuillez sélectionner un type de campagne avant de continuer !");
				return;
			}

			// On récupère d'autres infos si besoin
			let gtm = $('input[name="gtm"]').is(':checked');
			let url = "<?= site_url('Client/campagne/' . $idclients); ?>?camp_type=" + camp_type + "&gtm=" + gtm;

			window.location.href = url;
		});

	});
</script>

<?php end_section() ?>
