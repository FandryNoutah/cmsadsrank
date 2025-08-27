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

</style>
<?php end_section() ?>

<?php start_section('content'); ?>

<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100">
		<?php $this->load->view('layouts/client/onboarding/sidebar'); ?>

		<div class="col w-100">
			<div class="container-fluid mb-5">

				<!-- DETAIL -->
				<h1 class="display-1 text-center" style="font-size: 42px;">
					Onboarding Client: <br>
					Ouest lyonnais climatisation plomberie SARL <br>
					Search Engine
				</h1>

				<div class="row no-gutters">
					<div class="col pr-2" style="margin-right: 30px;">
						<div class="card h-100 mb-5" style="margin-bottom: 0rem !important;">
							<div class="card-body">
								<ul class="nav nav-tabs mb-3" style="margin-top: -15px;">
									<li class="nav-item">
										<a class="nav-link py-3 active" type="button">
											Société
										</a>
									</li>
								</ul>

								<h6 class="text-muted font-weight-normal" style="font-size: 15.5px;">
									Meta Platforms, Inc., doing business as Meta and formerly named Facebook, Inc., and TheFacebook, Inc., is an American multinational technology conglomerate based in Menlo Park, California.

									The company owns Facebook, Instagram, and WhatsApp, among other products and services. The company owns Facebook, Instagram, and WhatsApp, among other products and services.The company owns Facebook, Instagram, and WhatsApp, among other products and
								</h6>
							</div>
						</div>
					</div>

					<div class="col-auto">
						<div class="card h-100" style="width: 420px;">
							<div class="card-body">
								<div class="d-flex justify-content-between align-items-center">
									<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
										3000 $
									</button>
									<div class="dropdown no-arrow">
										<a href="javascript:void(0);" class="btn btn-light rounded-pill px-3 nav-link dropdown-toggle" id="clientDetailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v" style="font-size: 16px;"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="clientDetailDropdown">
											<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#editModal">Modifier</a>
											<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#statusModal">Statut Client</a>
										</div>
									</div>
								</div>
								<br><br>
								<div class="d-flex justify-content-start mb-3" style="font-size: 18px;">
									<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
									<span class="mr-2">Date Anniversaire | 20/07/2026</span>
								</div>
								<div class="d-flex justify-content-start mb-3" style="font-size: 18px;">
									<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
									<span class="mr-2">Date de Mise en Ligne | 20/07/2026</span>

								</div>
								<div class="d-flex justify-content-start mb-3" style="font-size: 18px;">
									<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
									<span class="mr-2">Commerciale</span>
									<span class="mr-2">
										<img src="<?= base_url('assets/images/icons/figma/frame-5518.png') ?>" width="24" height="24">
									</span>
								</div>
								<div class="d-flex justify-content-start mb-4" style="font-size: 18px;">
									<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
									<span class="mr-2">Account Manager</span>
									<span class="mr-2">
										<img src="<?= base_url('assets/images/icons/figma/frame-5518.png') ?>" width="24" height="24">
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- BRIEF -->
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
						<li class="nav-item">
							<a class="nav-link py-3" type="button">
								Information Importante
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3" type="button">
								Valeur Ajouté
							</a>
						</li>
					</ul>
					<div class="d-inline">
						<button class="btn btn-dark">
							<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
							Modifier Brief
						</button>
					</div>
				</div>
				<div class="card" style="height: 400px;">
					<div class="card-body">
						<!-- IF BRIEF VIDE -->
						<div class="d-flex align-items-center justify-content-center h-100">
							<button class="btn btn-dark stretched-link" data-toggle="modal" data-target="#briefModal">
								<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
								Ajouter Brief
							</button>
						</div>

						<!-- IF BRIEF EXISTE -->
						<!-- <p class="text-muted">Test</p> -->
					</div>
				</div>

				<button class="btn btn-dark mt-5" id="create_camp_button">
					<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
					Création Nouvelle Campagne
				</button>

				<div id="camp_creation_step" class="d-none">

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
								<div class="card camp-container">
									<div class="card-body">
										<div class="d-block mb-3">
											<i class="fa fa-database" style="font-size: 22px;"></i>
										</div>
										<h3>Sales</h3>
										<p class="text-muted">A centralized repository storing all contact information.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-camp" data-target="#camp_sale">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="camp_param" id="camp_sale" value="sales" class="d-none">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card camp-container">
									<div class="card-body">
										<div class="d-block mb-3">
											<i class="fa fa-link" style="font-size: 22px;"></i>
										</div>
										<h3>Lead</h3>
										<p class="text-muted">Setting tasks, follow-ups, or reminders associated with specific contacts.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-camp" data-target="#camp_lead">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="camp_param" id="camp_lead" value="lead" class="d-none">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card camp-container">
									<div class="card-body">
										<div class="d-block mb-3">
											<i class="fa fa-cloud" style="font-size: 22px;"></i>
										</div>
										<h3>Réservation</h3>
										<p class="text-muted">Automatically updating and enriching contact data.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-camp" data-target="#camp_resa">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="camp_param" id="camp_resa" value="resa" class="d-none">
									</div>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-end align-items-center">
							<button class="btn btn-dark px-4 float-right next-button" data-input="camp_param">Suivant</button>
						</div>
					</div>

					<!-- OBJECTIF -->
					<div id="objectif_step" class="step mb-4">
						<h1 class="display-1 text-center mt-5" style="font-size: 42px;">
							Choisissez votre objectif
						</h1>
						<p class="text-center text-muted" style="font-size: 18px;">
							Sélectionner un objectif pour adapter votre expérience aux objectifs et aux paramètres qui fonctionneront le mieux pour votre campagne
						</p>
						<div class="row row-cols-3 mt-4 mb-3">
							<div class="col">
								<div class="card h-100 obj-container">
									<div class="card-body">
										<img src="<?= base_url('assets/images/icons/figma/content_icon.png') ?>" alt="" class="mb-3" width="110">
										<h3>Search</h3>
										<p class="text-muted">Create, customize, and manage email marketing campaigns.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-obj" data-target="#obj_search">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="obj" id="obj_search" value="search" class="d-none">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card h-100 obj-container">
									<div class="card-body">
										<img src="<?= base_url('assets/images/icons/figma/content_icon.png') ?>" alt="" class="mb-3" width="110">
										<h3>Performance Max</h3>
										<p class="text-muted">Tailor emails by segmenting contacts based on demographics, behavior.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-obj" data-target="#obj_pmax">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="obj" id="obj_pmax" value="pmax" class="d-none">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card h-100 obj-container">
									<div class="card-body">
										<img src="<?= base_url('assets/images/icons/figma/relation_icon.png') ?>" alt="" class="mb-3" width="90">
										<h3>Locale</h3>
										<p class="text-muted">Create, customize, and manage email marketing campaigns.</p>
										<a href="javascript:void(0);" class="stretched-link text-dark font-weight-bold select-obj" data-target="#obj_locale">
											Discover More
											<i class="fa fa-arrow-right"></i>
										</a>
										<input type="radio" name="obj" id="obj_locale" value="locale" class="d-none">
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end align-items-center">
							<button class="btn btn-dark px-4 float-right next-button" data-input="obj">Suivant</button>
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

<?php $this->load->view('layouts/client/onboarding/brief-modal') ?>
<?php end_section(); ?>

<?php start_section('script') ?>
<script>
	$(function() {

		$('#create_camp_button').click(function() {

			$('#camp_creation_step').removeClass('d-none');

			$('.scroll-container').animate({
				scrollTop: $('.scroll-container')[0].scrollHeight
			}, 1000);

		});

		$('.select-camp').click(function() {

			let target = $(this).data('target');

			$(target).prop('checked', true);
			$('.camp-container').removeClass('border-dark border-danger shadow');
			$(this).parents('.camp-container').addClass('border-dark shadow');
		});

		$('.select-obj').click(function() {

			let target = $(this).data('target');

			$(target).prop('checked', true);
			$('.obj-container').removeClass('border-dark border-danger shadow');
			$(this).parents('.obj-container').addClass('border-dark shadow');
		});

		// STEP CODE
		$('.next-button').click(function() {

			let input = $(this).data('input');
			let value = $('input[name="'+ input +'"]:checked').val();

			if (!value) {
				$('input[name="'+ input +'"]').parents('.card').removeClass('border-dark');
				$('input[name="'+ input +'"]').parents('.card').addClass('border-danger shadow');
			} else {
				$('input[name="'+ input +'"]').parents('.card').removeClass('border-danger');
				// $(this).parents('.step').removeClass('active');
				$(this).parents('.step').next('.step').addClass('active');

				$('.scroll-container').animate({
					scrollTop: $('.scroll-container')[0].scrollHeight
				}, 1000);
			}
			
		});
		
		$('#final_button').click(function() {

			let camp_param = $('input[name="camp_param"]:checked').val();
			let obj = $('input[name="obj"]:checked').val();
			let gtm = $('input[name="gtm"]').is(':checked');

			if (!camp_param || !obj) {
				alert("Veuillez d'abord choisir les options précédentes!");
			} else {
				alert("redirecting soon!")
			}
		});
	});
</script>
<?php end_section() ?>
