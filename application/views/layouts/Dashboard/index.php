<?php start_section('stylesheet'); ?>
<link href="<?= base_url('assets/vendors/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<style>
	:root {
		--bg: #ffffff;
		--text: #101112;
		--muted: #7a7f85;
		--accent: #0a0a0a;
		--track: #dadcdf;
		--p: 64;
	}

	* {
		box-sizing: border-box
	}

	.ring {
		--size: 120px;
		width: var(--size);
		height: var(--size);
		display: grid;
		place-items: center;
		border-radius: 50%;
		background:
			conic-gradient(var(--accent) calc(var(--p)*1%), var(--track) 0);
		position: relative;
	}

	.ring::after {
		content: "";
		position: absolute;
		inset: 10px;
		border-radius: 50%;
		background: var(--bg);
		box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .04);
	}

	.percent {
		position: relative;
		font-weight: 700;
		font-size: 28px;
	}


	.stack {
		flex: 1 1 auto;
		min-width: 0
	}

	.label {
		font-size: 22px;
		font-weight: 600;
		letter-spacing: .2px;
		color: #73787f
	}

	.big {
		font-size: 56px;
		font-weight: 800;
		line-height: 1.1;
		margin: .15em 0
	}

	.sub {
		font-size: 22px;
		color: #8a9096
	}


	.chev {
		flex: 0 0 auto;
		width: 56px;
		height: 56px;
		border-radius: 999px;
		border: 1.5px solid #111;
		display: grid;
		place-items: center;
		background: #fff;
		cursor: pointer;
		transition: .2s ease;
	}

	.chev:hover {
		transform: translateX(2px);
		box-shadow: 0 6px 16px rgba(0, 0, 0, .12)
	}

	.chev svg {
		width: 26px;
		height: 26px
	}

	.percent {
		position: relative;
		font-weight: 700;
		font-size: 28px;
		z-index: 1;
		/* 👈 Ajoute ceci */
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4 py-2">Dashboard</h1>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid pt-4" 
		<?php if (in_array($current_user->tech, [1, 2, 3])): ?>
			style="background-image: url('<?= site_url('assets/images/figma/') . "user_tech_" . $current_user->tech . ".svg" ?>'); background-repeat: no-repeat; background-position: top right 100px; background-size: 534px;"
		<?php endif; ?> >
	<div class="row row-cols-2 mb-5 position-relative">
		<div class="col-auto">
			<h1 class="display-4 mb-4">Bonjour <?= $current_user->first_name; ?></h1>
			<p class="mb-2">
				<u>
					<a href="https://citation-celebre.leparisien.fr/citations/262772" class="text-dark">
						Le lâche ne commence jamais, le faible ne termine jamais, <br> et le gagnant n'abandonne jamais.
					</a>
				</u>
			</p>
			<p class="mb-5">
				<u>
					<a href="https://citation-celebre.leparisien.fr/auteur/philip-knight-nike" class="text-muted">
						Philip Knight (Nike)
					</a>
				</u>
			</p>

			<div class="card" style="width: 344px; height: 129px;">
				<div class="card-body d-flex justify-content-between px-4">
					<img src="<?= site_url('assets/images/figma/trophee.png') ?>?>" alt="trophee" width="64" class="align-self-center">
					<div>
						<div class="span badge alert-warning p-2 mb-2">PRESENCES NOVEMBRE</div>
						<div class="d-flex justify-content-between">
							<div class="text-left">
								<h6 class="text-muted mb-2" style="font-size: 14px; font-weight: 500;">PRESENTS</h6>
								<h4 class="text-dark">51%</h4>
							</div>
							<div class="text-right">
								<h6 class="text-muted mb-2" style="font-size: 14px; font-weight: 500;">CONGES</h6>
								<h4 class="text-dark">4</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<p class="text-muted mb-5">
		Nous avons actuellement
		<span class="text-dark font-weight-bold">
			<?php echo $nbr_client; ?>
			Clients
			<i class="fa fa-globe ml-2"></i>
		</span>
	</p>

	<script>
		const completedPlanifie = <?= $nbr_task_planifier ?>;
		const totalPlanifie = <?= $nbr_task ?>;
		const pPlanifie = totalPlanifie > 0 ? Math.round((completedPlanifie / totalPlanifie) * 100) : 0;
		document.getElementById('percentPlanifie').textContent = pPlanifie + '%';
		document.getElementById('ringPlanifie').style.background =
			`conic-gradient(var(--accent) ${pPlanifie}%, var(--track) ${pPlanifie}% 100%)`;

		const completedAttribue = <?= $nbr_task_attribuer_plannifier ?>;
		const totalAttribue = <?= $nbr_task_attribuer ?>;
		const pAttribue = totalAttribue > 0 ? Math.round((completedAttribue / totalAttribue) * 100) : 0;
		document.getElementById('percentAttribue').textContent = pAttribue + '%';
		document.getElementById('ringAttribue').style.background =
			`conic-gradient(var(--accent) ${pAttribue}%, var(--track) ${pAttribue}% 100%)`;
	</script>

	<?php end_section(); ?>
