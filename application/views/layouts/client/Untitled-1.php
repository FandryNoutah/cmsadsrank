
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
<?php start_section('content'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />

</head>

<body>
	<?php foreach($donnees as $d): ?>
	<div class="container-fluid p-0 h-100">
		<div class="row no-gutters h-100">

			<?php $this->load->view('layouts/client/detail/sidebar') ?>

			<div class="col w-100">
				<div class="container-fluid position-relative">

					<br><br>
					<span class="badge alert-success rounded-pill px-4 py-3" style="font-size: 12px; font-weight: 500;">
						<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
						Active
					</span>
					<br><br><br>

					<div class="d-flex justify-content-start" style="font-size: 20px;">
						<i class="fa fa-star mr-1"></i>
						<i class="fa fa-star mr-1"></i>
						<i class="fa fa-star mr-1"></i>
						<i class="fa fa-star mr-1"></i>
						<i class="fa fa-star-half mr-1"></i>
					</div>
					<br>

					<h1 class="font-weight-bold" style="font-size: 48px;">
						<?php echo $d['nom_client'] ?>
						<br>
					</h1>
					<h5><?php echo $d['site_client'] ?></h5>

					<span class="badge alert-primary px-4 py-2">
						Bleu
					</span>

					<div class="card position-absolute" style="width: 360px; top: 100px; right: 80px;">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center">
								<button class="btn btn-dark py-3 px-5">
									<?php echo $d['budget'] ?> €
								</button>
								<button type="button" class="btn btn-light rounded-pill px-3">
									<i class="fa fa-ellipsis-v" style="font-size: 16px;"></i>
								</button>
							</div>
							<br><br>
							<div class="d-flex justify-content-start mb-3">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Date d'anniversaire</span>
								<span class="mr-2">|</span>
								<span class="mr-2"><?php echo $d['mis_en_place_paiement'] ?></span>
							</div>
							<div class="d-flex justify-content-start mb-3">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Date de Mise en ligne</span>
								<span class="mr-2">|</span>
								<span class="mr-2"><?php echo $d['annonce'] ?></span>
							</div>
							<div class="d-flex justify-content-start mb-3">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Commerciale</span>
								<span class="mr-2">
									<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24">
								</span>
							</div>
							<div class="d-flex justify-content-start mb-4">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Account Manager</span>
								<span class="mr-2">
									<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24">
								</span>
							</div>
							<button class="btn btn-outline-dark btn-block">Onboarding</button>
						</div>
					</div>
			
	
	<div class="card mb-5">
						<div class="card-body">
							<div class="d-flex align-items-center mb-4">
								<img src="<?= base_url('assets/images/figma/fb_debarras_logo.png') ?>" width="114">
								<h6 class="ml-3">Ouest lyonnais climatisation plomberie SARL</h6>
								<a href="#" class="text-decoration-none ml-auto mx-3">Categories</a>
								<a href="#" class="text-decoration-none mx-3">Marketing</a>
							</div>
							<h6 class="text-muted font-weight-normal">
								Meta Platforms, Inc., doing business as Meta and formerly named Facebook, Inc., and TheFacebook, Inc., is an American multinational technology conglomerate based in Menlo Park, California.
								<br>
								<br>
								The company owns Facebook, Instagram, and WhatsApp, among other products and services. The company owns Facebook, Instagram, and WhatsApp, among other products and services.The company owns Facebook, Instagram, and WhatsApp, among other products and
							</h6>
						</div>
					</div>

					<div class="row row-cols-4 mb-5">
						<div class="col">
							<div class="card h-100">
								<div class="card-body">
									<div class="d-flex align-items-center mb-2">
										<img src="<?= base_url('assets/images/figma/discu_queue.png') ?>" width="43">
										<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">File de discussion</a>
										<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
									</div>
									<h3 class="m-0">51 Discussions</h3>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card h-100">
								<div class="card-body">
									<div class="d-flex align-items-center mb-2">
										<img src="<?= base_url('assets/images/figma/google_meet.png') ?>" width="43">
										<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Google Meet</a>
										<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
									</div>
									<h3 class="m-0">Le 10/07/2025</h3>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card h-100">
								<div class="card-body">
									<div class="d-flex align-items-center mb-2">
										<img src="<?= base_url('assets/images/figma/air_call.png') ?>" width="43">
										<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">AirCall</a>
										<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
									</div>
									<h3 class="m-0">162 Appels</h3>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card h-100">
								<div class="card-body">
									<div class="d-flex align-items-center mb-2">
										<img src="<?= base_url('assets/images/figma/teams_tasks.png') ?>" width="43">
										<a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Teams Tasks</a>
										<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
									</div>
									<h3 class="m-0">5 Task</h3>
								</div>
							</div>
						</div>
					</div>

					<br><br>

					<ul class="nav nav-tabs mr-auto border-bottom mb-3" role="tablist">
						<li class="nav-item">
							<a class="nav-link py-3 active" type="button" id="budget_tab" data-toggle="tab" data-target="#budget" type="button" role="tab" aria-controls="budget" aria-selected="true">
								<img src="<?= base_url('assets/images/icons/figma/icon-budget.svg') ?>" alt="">
								Budget Annuel
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3" type="button" id="variation_tab" data-toggle="tab" data-target="#variation" type="button" role="tab" aria-controls="variation" aria-selected="false">
								<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
								Variations
							</a>
						</li>
					</ul>
					<div class="tab-content" id="taskTabContent">
						<div class="tab-pane fade mb-5 show active" id="budget" role="tabpanel" aria-labelledby="budget_tab">
							<div class="card">
								<div class="card-body">
									<h1>Graph here</h1>
								</div>
							</div>
						</div>
						<div class="tab-pane fade mb-5" id="variation" role="tabpanel" aria-labelledby="variation_tab">
							<div class="card">
								<div class="card-body">
									<h1>List here</h1>
								</div>
							</div>
						</div>
					</div>

					<br><br>

					<h1 style="font-size: 48px;">Loocker Studio</h1>
					<div class="row row-cols-3">
						<div class="col">
							<div class="card h-100">
								<div class="card-body text-center">
									<h5>Rapport Basic</h5>
									<span class="text-muted">
										<i class="fa fa-circle mr-2" style="color: #589e67;"></i>
										Active
									</span>
									<button class="btn btn-soutline-dark btn-block">Loocker Studio</button>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card h-100">
								<div class="card-body text-center">
									<h5>Rapport de conversion</h5>
									<span class="text-muted">
										<i class="fa fa-circle mr-2" style="color: #589e67;"></i>
										Active
									</span>
									<button class="btn btn-soutline-dark btn-block">Loocker Studio</button>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card h-100">
								<div class="card-body text-center">
									<h5>Rapport Bilan Annuel</h5>
									<br>
									<button class="btn btn-light btn-block">
										<i class="fa fa-plus"></i>
										Create Task
									</button>
								</div>
							</div>
						</div>
					</div>
					
					<br><br>

					<div class="d-flex justify-content-between">
						<h1 style="font-size: 48px;">Détection Modules</h1>
						<button class="btn btn-outline-dark btn-lg">Voir tout</button>
					</div>
					<br><br>
					<div class="row row-cols-2">
						<div class="col">
							<div class="card">
								<div class="card-body text-center">
									<h3 class="mb-3">6+ Apps connectés</h3>
									<p class="text-muted mx-5" style="font-size: 18px;">
										Embark on a transformative journey with our venture. Over 60 powerful tools to make your work more efficient and effective.
									</p>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card">
								<div class="card-body text-center">
									<h3 class="mb-3">Google Tag Manager</h3>
									<p class="text-muted mx-5" style="font-size: 18px;">
										Venture is audited and certified by few industry that have been leading in Security Third Party standards.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
	<?php endforeach; ?>

	<script src="<?= base_url('assets/vendors/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/fontawesome/js/all.min.js') ?>"></script>
	<?php end_section(); ?>
</body>

</html>