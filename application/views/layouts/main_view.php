<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />

	<style>

		#sidebarMenu.collapsed {
			width: 75px !important;
			transition: width 0.3s ease;
		}

		#sidebarMenu {
			transition: width 0.3s ease;
		}

		.wrapper {
			transition: margin-left 0.3s ease;
		}

		#sidebarMenu+.col {
			transition: width 0.3s ease;
		}

		.logo-full, .logo-collapsed {
			transition: opacity 0.2s ease;
		}

	</style>
	
	<?= $stylesheet ?>

</head>

<body>

	<div class="container-fluid p-0 h-100">
		<div class="row no-gutters h-100">

			<?= $sidebar ?>

			<div class="col w-100 h-100 overflow-auto">
				<?= $header ?>

				<div class="wrapper">

					<?php if (isset($content) && $content != ""): ?>
						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 px-3 pt-1 border-bottom">
							<h1 class="h4"><?= $page_title ?></h1>
							<?= $page_heading ?>
						</div>

						<?= $content ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url('assets/vendors/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/bootstrap/js/popper.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/fontawesome/js/all.min.js') ?>"></script>

	<script>
		$(function() {
			$('#toggleSidebar').click(function() {

				$('#sidebarMenu').toggleClass("collapsed");
				$('.nav-label').toggleClass("d-none");

				$('.logo-full').toggleClass('d-none');
  				$('.logo-split').toggleClass('d-none');
			});
		});
	</script>
	<?= $script ?>

</body>

</html>
