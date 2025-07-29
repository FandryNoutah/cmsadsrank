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

					<div class="card position-absolute" style="width: 360px; top: 100px; right: 80px;">
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
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url('assets/vendors/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/fontawesome/js/all.min.js') ?>"></script>
</body>

</html>
