<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />

	<style>

		body {
			overflow-y: hidden;
		}

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

		.logo-full,
		.logo-collapsed {
			transition: opacity 0.2s ease;
		}

		#toggleSidebar {
			left: 235px;
			top: 21px;
			z-index: 1021;
			transition: left 0.3s ease;
		}

		#toggleSidebar.toggled {
			left: 61px;
			transition: left 0.3s ease;
		}
	</style>

	<?= $stylesheet ?>

</head>

<body>

	<div class="container-fluid p-0 h-100 position-relative">
		<button class="btn btn-light py-0 px-1 position-absolute border" id="toggleSidebar">
			<img class="img" src="<?= base_url('assets/images/icons/figma/Menu/CaretDoubleHorizontal.png') ?>">
		</button>
		<div class="row no-gutters h-100">

			<?= $sidebar ?>

			<div class="col w-100 h-100 overflow-auto scroll-container">
				<?= $header ?>

				<div class="wrapper">

					<?php if (isset($content) && $content != ""): ?>
						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pt-1 border-bottom">
							<?= $page_title ?>
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

		function pad(n) {
			return String(n).padStart(2, '0');
		}

		function toLocalInputString(d) {
			if (!(d instanceof Date)) d = new Date(d);
			return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
		}

		function parseDateForInput(value) {
			if (!value) return '';
			if (value instanceof Date) return toLocalInputString(value);

			var s = String(value).trim();

			if (/^\d+$/.test(s)) {
				var n = Number(s);
				if (s.length === 10) n = n * 1000;
				var dt = new Date(n);
				if (!isNaN(dt)) return toLocalInputString(dt);
			}

			var mysqlMatch = s.match(/^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/);
			if (mysqlMatch) {
				var y = Number(mysqlMatch[1]),
					m = Number(mysqlMatch[2]) - 1,
					day = Number(mysqlMatch[3]);
				var hh = Number(mysqlMatch[4]),
					mm = Number(mysqlMatch[5]),
					ss = Number(mysqlMatch[6] || 0);
				return toLocalInputString(new Date(y, m, day, hh, mm, ss));
			}

			var iso = s.replace(' ', 'T');
			var dt2 = new Date(iso);
			if (!isNaN(dt2)) return toLocalInputString(dt2);

			return '';
		}

		$(function() {

			$('#toggleSidebar').click(function() {

				$('#sidebarMenu').toggleClass("collapsed");
				$('.nav-label').toggleClass("d-none");

				$('.logo-full').toggleClass('d-none');
				$('.logo-split').toggleClass('d-none');

				$(this).toggleClass('toggled');
			});

			$('#search_client').keyup(function(event) {

				let keyword = $(this).val();
				if (keyword) {

					$(this).dropdown('show');

					$.ajax({
						type: "POST",
						url: "<?= site_url('Client/search') ?>",
						data: {
							"keyword": keyword,
						},
						dataType: "json",
						beforeSend: function() {
							$('#clients_dropdown').html('<div class="w-100 dropdown-item text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div>');
						},
						success: function(response) {

							$('#clients_dropdown').html("");

							if (response.length > 0) {

								$.each(response, function(index, client) {

									let id = client.idclients;
									let name = client.nom_client;

									let a = `
										<a href="<?= site_url('Client/detail_client'); ?>/${id}" class="dropdown-item">
											${name}
										</a>
									`;

									$('#clients_dropdown').append(a);
								});
							} else {
								$('#clients_dropdown').html('<div class="dropdown-item text-center">Aucun client trouvé!</div>');
							}
						}
					});
				} else {
					$(this).dropdown('hide');
				}
			});
		});
	</script>
	<?= $script ?>

</body>

</html>
