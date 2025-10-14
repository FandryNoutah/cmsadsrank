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
</style>
<?php end_section() ?>

<?php start_section('content'); ?>
<?php foreach ($donnees as $d): ?>
	<div class="container-fluid p-0 h-100">
		<div class="row no-gutters h-100">
			<?php $this->load->view('layouts/client/onboarding/sidebar'); ?>

			<div class="col w-100">
				<div class="container-fluid mb-5">

					<!-- DETAIL -->
					<h1 class="display-1 text" style="font-size: 42px;">
						Onboarding :
						<?= $d['nom_client'] ?>
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
										<div class="dropdown no-arrow">
											<img class="mr-2" src="<?= base_url('assets/images/ico/Eye.png') ?>" />
										</div>
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
								<button class="btn btn-dark">
									<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
									Modifier Brief
								</button>
							<?php endif; ?>
							<?php if (empty($d['information_client'])): ?>
								<button class="btn btn-dark" data-toggle="modal" data-target="#briefModal">
									<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
									Ajouter Brief
								</button>
							<?php endif; ?>
						</div>
					</div>
					<?php if (!empty($d['information_client'])): ?>
						<div class="card">
							<div class="card-body">
								<?= nl2br($d['information_client']); ?>
							</div>
						</div>
					<?php endif; ?>

					<!-- BRIEF -->
					<h1 class="display-1 text-center mt-4" style="font-size: 42px;">
						Campagne
					</h1>
					<div class="table-responsive">
						<table class="table table-hover table-wrapper">
							<thead class="bg-light text-muted">
								<tr>
									<th class="text-muted">ACTION</th>
									<th class="text-muted">TYPE</th>
									<th class="text-muted">CAMPAGNE</th>
									<th class="text-muted">BUDGET</th>
									<th class="text-muted">DEMANDE</th>
									<th class="text-muted">STATUT</th>
									<th class="text-muted">GROUPES D'ANNONCES</th>
									<th class="text-muted">MOT CLE</th>
									
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($donne_valider)): ?>
									<?php foreach ($donne_valider as $campagne): ?>
										<tr>
											<td>
												<div class="dropdown">
													<a class="dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownMenuLink<?= $campagne['idcampagne'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="fa fa-ellipsis-v"></i>
													</a>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuLink<?= $campagne['idcampagne'] ?>">
														<a class="dropdown-item" href="<?= site_url("Googleads/editcampagne/".$campagne['idcampagne']) ?>">Modifier</a>
														<a class="dropdown-item text-danger" href="<?= site_url("Googleads/deletecampagne/".$campagne['idcampagne']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette campagne ?');">Supprimer</a>
														<?php if ($campagne['type_campagne'] == 1): ?>
															<a class="dropdown-item" href="<?= site_url("Googleads/ajout_groupeannonce/".$campagne['idcampagne']) ?>">Ajouter Groupe</a>
														<?php elseif ($campagne['type_campagne'] == 2): ?>
															<a class="dropdown-item" href="<?= site_url("Googleads/ajout_groupeannonce_local/".$campagne['idcampagne']) ?>">Ajouter Groupe Local</a>
														<?php elseif ($campagne['type_campagne'] == 3): ?>
															<a class="dropdown-item" href="<?= site_url("Googleads/ajout_groupeannonce_pmax/".$campagne['idcampagne']) ?>">Ajouter Groupe PMax</a>
														<?php endif; ?>
													</div>
												</div>
											</td>
											<td>
												<?php 
													switch ($campagne['type_campagne']) {
														case 1: echo "Search"; break;
														case 2: echo "Local"; break;
														case 3: echo "PMax"; break;
														default: echo "Inconnu"; break;
													}
												?>
											</td>
											<td><?= htmlspecialchars($campagne['nom_campagne']) ?></td>
											<td><?= isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0 ?> €</td>
											<td><span class="badge alert-primary">GTM</span></td>
											<td>
												<?php if (isset($campagne['actif']) && $campagne['actif'] == 1): ?>
													<span class="badge alert-primary">
														<i class="fa fa-circle"></i> En cours
													</span>
												<?php else: ?>
													<span class="badge alert-success">
														<i class="fa fa-circle"></i> Terminée
													</span>
												<?php endif; ?>
											</td>
											<td>
												<?php if (!empty($campagne['groupes_annonces'])): ?>
													<?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
														<div style="margin-bottom: 10px;">
															<a href="<?= base_url('Client/insertgroupeannonce/' . $groupe['idgroupe_annonce']) ?>"><strong><?= htmlspecialchars($groupe['nom_groupe']) ?></strong></a><br>
														</div>
														<hr>
													<?php endforeach; ?>
												<?php else: ?>
													<em>Aucun groupe</em>
												<?php endif; ?>
											</td>
											<td>
												<?php if (!empty($campagne['groupes_annonces'])): ?>
													<?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
														<div style="margin-bottom: 10px;">
															<?php 
																$mots = explode("\n", $groupe['mot_cle']);
																foreach ($mots as $mot) {
																	if (trim($mot) !== '') {
																		echo '<span class="badge badge-secondary">"' . htmlspecialchars(trim($mot)) . '"</span> ';
																	}
																}
															?>
														</div>
														<hr>
													<?php endforeach; ?>
												<?php else: ?>
													<em>Aucun groupe</em>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="9" class="text-center text-muted">Aucune campagne trouvée.</td>
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
						<p style="display: none;"><?= nl2br($d['information_client']); ?> </p>
						<!-- CAMPAGNE -->
						<div id="campagne_step" class="step active mb-4">
							<h1 class="display-1 text-center mt-5" style="font-size: 42px;">
								Paramètres de la campagne
							</h1>
							<p class="text-center text-muted" style="font-size: 18px;">
								Pour atteindre les bonnes personnes, commencez par définir les paramètres clés de votre campagne
							</p>
							<div class="row row-cols-3 mt-4 mb-3">
								<div class="col">
									<div class="card conversion-container">
										<div class="card-body">
											<div class="d-block mb-3">
												<i class="fa fa-database" style="font-size: 22px;"></i>
											</div>
											<h3>Sales</h3>
											<p class="text-muted">A centralized repository storing all contact information.</p>
											<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-conversion" data-target="#conversion_ecommerce">
												Discover More
												<i class="fa fa-arrow-right"></i>
											</a>
											<input type="radio" name="conversion" id="conversion_ecommerce" value="ecommerce" class="d-none">
										</div>
									</div>
								</div>
								<div class="col">
									<div class="card conversion-container">
										<div class="card-body">
											<div class="d-block mb-3">
												<i class="fa fa-link" style="font-size: 22px;"></i>
											</div>
											<h3>Lead</h3>
											<p class="text-muted">Setting tasks, follow-ups, or reminders associated with specific contacts.</p>
											<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-conversion" data-target="#conversion_lead">
												Discover More
												<i class="fa fa-arrow-right"></i>
											</a>
											<input type="radio" name="conversion" id="conversion_lead" value="lead" class="d-none">
										</div>
									</div>
								</div>
								<div class="col">
									<div class="card conversion-container">
										<div class="card-body">
											<div class="d-block mb-3">
												<i class="fa fa-cloud" style="font-size: 22px;"></i>
											</div>
											<h3>Réservation</h3>
											<p class="text-muted">Automatically updating and enriching contact data.</p>
											<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-conversion" data-target="#conversion_reservation">
												Discover More
												<i class="fa fa-arrow-right"></i>
											</a>
											<input type="radio" name="conversion" id="conversion_reservation" value="reservation" class="d-none">
										</div>
									</div>
								</div>
							</div>

							<div class="d-flex justify-content-end align-items-center">
								<button class="btn btn-dark px-4 float-right next-button" data-input="conversion">Suivant</button>
							</div>
						</div>

						<!-- OBJECTIF -->
						<div id="camp_type_step" class="step mb-4">
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
								<button class="btn btn-dark px-4 float-right next-button" data-input="camp_type">Suivant</button>
							</div>
						</div>

						<!-- GOOGLE TAG -->
						<div id="gtm_step" class="step mb-4">
							<h1 class="display-1 text-center my-5" style="font-size: 42px;">
								Mise en place Google Tag manager
							</h1>
							<div class="card mb-3">
								<div class="card-body py-5 px-4">
									<div class="row align-items-center">
										<div class="col-6 text-center">
											<h3 class="mb-3" style="font-size: 32px; font-weight: 500;">Google Tag Manager</h3>
											<p class="text-muted" style="font-size: 18px; line-height: 150%;">Venture is audited and certified by few industry that have been leading in Security Third Party standards.</p>
										</div>
										<div class="col-3">
											<span class="badge alert-success rounded-pill py-3 px-5">
												<i class="fa fa-circle"></i>
												GTM 30000HGY
											</span>
										</div>
										<div class="col-3 text-center">
											<div class="custom-control custom-switch custom-switch-xl">
												<input type="checkbox" class="custom-control-input" id="gtm" name="gtm">
												<label class="custom-control-label" for="gtm"></label>
											</div>
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
	</div>
</div>
<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clientModalLabel">Détails du Client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="clientModalContent">
        Chargement...
      </div>
    </div>
  </div>
</div>

<?php endforeach; ?>
<?php $this->load->view('layouts/client/onboarding/brief-modal') ?>
<?php end_section(); ?>

<?php start_section('script') ?>.
<script>
$(document).ready(function(){
    $('.eye-icon').on('click', function(){
        var clientId = $(this).data('id');

        // Affiche la modal
        $('#clientModal').modal('show');

        // Charge le contenu via AJAX
        $('#clientModalContent').html('Chargement...');

        $.ajax({
            url: '<?= site_url("Client/details_ajax") ?>/' + clientId,
            type: 'GET',
            success: function(response){
                $('#clientModalContent').html(response);
            },
            error: function(){
                $('#clientModalContent').html("Erreur lors du chargement.");
            }
        });
    });
});
</script>

<script>
	$(function() {

		$('#create_camp_button').click(function() {

			$('#camp_creation_step').removeClass('d-none');

			$('.scroll-container').animate({
				scrollTop: $('.scroll-container')[0].scrollHeight
			}, 1000);

		});

		$('.select-conversion').click(function() {

			let target = $(this).data('target');

			$(target).prop('checked', true);
			$('.conversion-container').removeClass('border-dark border-danger shadow');
			$(this).parents('.conversion-container').addClass('border-dark shadow');
		});

		$('.select-conversion-type').click(function() {

			let target = $(this).data('target');

			$(target).prop('checked', true);
			$('.camp-type-container').removeClass('border-dark border-danger shadow');
			$(this).parents('.camp-type-container').addClass('border-dark shadow');
		});

		// STEP CODE
		$('.next-button').click(function() {

			let input = $(this).data('input');
			let value = $('input[name="' + input + '"]:checked').val();

			if (!value) {
				$('input[name="' + input + '"]').parents('.card').removeClass('border-dark');
				$('input[name="' + input + '"]').parents('.card').addClass('border-danger shadow');
			} else {
				$('input[name="' + input + '"]').parents('.card').removeClass('border-danger');
				// $(this).parents('.step').removeClass('active');
				$(this).parents('.step').next('.step').addClass('active');

				$('.scroll-container').animate({
					scrollTop: $('.scroll-container')[0].scrollHeight
				}, 1000);
			}

		});

		$('#final_button').click(function() {

			let conversion = $('input[name="conversion"]:checked').val();
			let camp_type = $('input[name="camp_type"]:checked').val();
			let gtm = $('input[name="gtm"]').is(':checked');

			if (!conversion || !camp_type) {
				alert("Veuillez d'abord choisir les options précédentes!");
			} else {

				let url = "<?= site_url('Client/campagne/' . $idclients); ?>?conversion=" + conversion + "&camp_type=" + camp_type + "&gtm=" + gtm;
				window.location.href = url;
			}
		});
	});
</script>
<?php end_section() ?>
