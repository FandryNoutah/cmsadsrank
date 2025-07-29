<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />

</head>

<body>
	<div class="container-fluid p-0 h-100">
		<div class="row no-gutters h-100">

			<!-- CUSTOM SIDEBAR FOR CLIENT DETAIL -->
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
						Holding ABL
						<br>
						(formations.lestudiobyamelie.fr)
					</h1>
					<h5>www.ouestlyon.com</h5>

					<span class="badge alert-primary px-4 py-2">
						Bleu
					</span>

					<div class="card position-absolute" style="width: 360px; top: 50px; right: 80px;">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center">
								<button class="btn btn-dark py-3 px-5">
									3000 $
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
								<span class="mr-2">20/07/2026</span>
							</div>
							<div class="d-flex justify-content-start mb-3">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Date de Mise en ligne</span>
								<span class="mr-2">|</span>
								<span class="mr-2">20/07/2026</span>
							</div>
							<div class="d-flex justify-content-start mb-3">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Commerciale</span>
								<span class="mr-2">
									<img src="<?= base_url('assets/images/icons/figma/frame-5518.png') ?>" width="24" height="24">
								</span>
							</div>
							<div class="d-flex justify-content-start mb-4">
								<span class="badge badge-light mr-3" style="width: 20px; height: 20px; background-color: #f2f2f2;">&nbsp;</span>
								<span class="mr-2">Account Manager</span>
								<span class="mr-2">
									<img src="<?= base_url('assets/images/icons/figma/frame-5518.png') ?>" width="24" height="24">
								</span>
							</div>
							<button class="btn btn-outline-dark btn-block">Onboarding</button>
						</div>
					</div>

					<br><br><br>
					<ul class="nav nav-tabs mb-2 border-bottom">
						<li class="nav-item">
							<a class="nav-link py-3 active" type="button">
								Société
							</a>
						</li>
					</ul>

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
							<div class="card">
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
							<div class="card">
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
							<div class="card">
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
							<div class="card">
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

					<ul class="nav nav-tabs mr-auto border-bottom mb-5" role="tablist">
						<li class="nav-item">
							<a class="nav-link py-3 active" type="button" id="budget_tab" data-toggle="tab" data-target="#budget" type="button" role="tab" aria-controls="budget" aria-selected="true">
								<img src="<?= base_url('assets/images/icons/figma/icon-budget.svg') ?>" alt="">
								Budget Annuel
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-3" type="button" id="kanban_tab" data-toggle="tab" data-target="#kanban" type="button" role="tab" aria-controls="kanban" aria-selected="false">
								<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
								Variations
							</a>
						</li>
					</ul>
					<div class="tab-content" id="taskTabContent">

						<div class="tab-pane fade mb-5" id="budget" role="tabpanel" aria-labelledby="budget_tab">

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url('assets/vendors/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/fontawesome/js/all.min.js') ?>"></script>
</body>

</html>
