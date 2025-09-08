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
<p class="my-2">
	Dashboard
</p>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid pt-4">

	<h1 class="display-3 mb-4">Bonjour <?= $current_user->first_name; ?></h1>

	<p class="text-muted mb-5">
		Used and helping over more
		<span class="text-dark font-weight-bold">
			<?php echo $nbr_client; ?>
			Companies
			<i class="fa fa-globe ml-2"></i>
		</span>
	</p>

	<div class="row row-cols-3 mb-5">

		<!-- ACTIF -->
		<div class="col mb-3">
			<div class="card h-100">
				<div class="card-body">
					<div class="d-flex justify-content-end mb-4">
						<span class="badge alert-success rounded-pill py-2 px-3 font-weight-normal" style="font-size: 14px;">
							<i class="fa fa-chart-line mr-1"></i>
							12%
						</span>
					</div>
					<div class="d-flex justify-content-between">
						<div>
							<p class="text-muted mb-2" style="font-weight: 500;">Actifs</p>
							<span class="text-dark" style="font-weight: 500; font-size: x-large;"><?php echo $nbr_client_actif; ?></span>
						</div>
						<div>
							<p class="text-muted mb-2" style="font-weight: 500;">Budget</p>
							<span class="text-dark" style="font-weight: 500; font-size: x-large;"><?php echo $total_budget_actif; ?> €</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- PAUSE -->
		<div class="col mb-3">
			<div class="card h-100">
				<div class="card-body">
					<div class="d-flex justify-content-end mb-4">
						<span class="badge alert-success rounded-pill py-2 px-3 font-weight-normal" style="font-size: 14px;">
							<i class="fa fa-chart-line mr-1"></i>
							12%
						</span>
					</div>
					<div class="d-flex justify-content-between">
						<div>
							<p class="text-muted mb-2" style="font-weight: 500;">En Pause</p>
							<span class="text-dark" style="font-weight: 500; font-size: x-large;"><?php echo $nbr_client_pause; ?></span>
						</div>
						<div>
							<p class="text-muted mb-2" style="font-weight: 500;">Budget</p>
							<span class="text-dark" style="font-weight: 500; font-size: x-large;"><?php echo $total_budget_en_pause; ?> €</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Graph -->
		<div class="col mb-3">
			<div class="card h-100">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-start mb-2">
						<div class="ring" id="ringPlanifie">
							<div class="percent" id="percentPlanifie">0%</div>
						</div>
						<div class="ml-3">
							<a href="#" class="text-decoration-none text-muted stretched-link">Progression tâche</a>
							<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;" href="<?= base_url('Task') ?>"></i>
							<h3 class="m-0"><span id="donePlanifie"><?= $nbr_task_planifier ?></span>/<span id="totalPlanifie"><?= $nbr_task ?></span> Tâches</h3>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- RESILIE -->
		<div class="col mb-3">
			<div class="card h-100">
				<div class="card-body">
					<div class="d-flex justify-content-end mb-4">
						<span class="badge alert-success rounded-pill py-2 px-3 font-weight-normal" style="font-size: 14px;">
							<i class="fa fa-chart-line mr-1"></i>
							12%
						</span>
					</div>
					<div class="d-flex justify-content-between">
						<div>
							<p class="text-muted mb-2" style="font-weight: 500;">Résilié</p>
							<span class="text-dark" style="font-weight: 500; font-size: x-large;"><?php echo $nbr_client_resilie; ?></span>
						</div>
						<div>
							<p class="text-muted mb-2" style="font-weight: 500;">Budget</p>
							<span class="text-dark" style="font-weight: 500; font-size: x-large;"><?php echo $total_budget_resilie; ?> €</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col mb-3">
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

		<div class="col mb-3">
			<div class="card h-100">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<div class="ring" id="ringAttribue">
							<div class="percent" id="percentAttribue">0%</div>
						</div>
						<div class="ml-3">
							<a href="#" class="text-decoration-none text-muted stretched-link">
								Progression tâche attribuée
								<i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
							</a>
							<h3 class="m-0"><span id="doneAttribue"><?= $nbr_task_attribuer_plannifier ?></span>/<span id="totalAttribue"><?= $nbr_task_attribuer ?></span> Tâches</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row row-cols-3">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<span class="badge badge-light mb-2">5</span>
					<h4>Alertes</h4>

					<ul class="list-group list-group-flush">
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-warning px-2 py-1 mb-2">
								FACTURATION
							</span>
							<p class="font-weight-bold mb-1">CB Refusé - Volt Consulting</p>
							<span class="text-muted">Montant: € 149 - relance D+3</span>
						</li>
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-primary px-2 py-1 mb-2">
								TECHNIQUE
							</span>
							<p class="font-weight-bold mb-1">GTM Désinstallé - Metatag code manquant</p>
							<span class="text-muted">Client: Bloom's Décor</span>
						</li>
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-danger px-2 py-1 mb-2">
								ACCOUNT MANAGER
							</span>
							<p class="font-weight-bold mb-1">Meeting with Client</p>
							<span class="text-muted">This monthly progress agenda</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h4>Discussions</h4>

					<ul class="list-group list-group-flush">
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-warning px-2 py-1 mb-2">
								TEAM TASKS
							</span>
							<p class="font-weight-bold mb-1">Point Bilan - ACIER DISTRIBUTION</p>
							<span class="text-muted">Teddy • Hier • 7 messages</span>
						</li>
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-primary px-2 py-1 mb-2">
								GTM
							</span>
							<p class="font-weight-bold mb-1">GTM Désinstallé - Metatag code manquant</p>
							<span class="text-muted">Salomé • 2 j • 3 messages</span>
						</li>
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-purple px-2 py-1 mb-2">
								OPTIMISATION
							</span>
							<p class="font-weight-bold mb-1">Meeting with Client</p>
							<span class="text-muted">Laurent • 4 j • 5 messages</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h4>Brief Client à venir</h4>

					<ul class="list-group list-group-flush">
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-warning px-2 py-1 mb-2">
								11:00 - 12:00 Feb 2, 2019
							</span>
							<p class="font-weight-bold mb-1">Ergoconcept - Brief</p>
							<span class="text-muted">Aujourd'hui 15:00 • Google Meet</span>
						</li>
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-primary px-2 py-1 mb-2">
								11:00 - 12:00 Feb 2, 2019
							</span>
							<p class="font-weight-bold mb-1">Metafor - Brief</p>
							<span class="text-muted">Aujourd'hui 16:30 • Meet</span>
						</li>
						<li class="list-group-item border-0 pl-0">
							<span class="badge alert-purple px-2 py-1 mb-2">
								11:00 - 12:00 Feb 2, 2019
							</span>
							<p class="font-weight-bold mb-1">Meetio - Brief</p>
							<span class="text-muted">Aujourd'hui 16:30 • Meet</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<br><br>
	<h3>Client</h3>
	Nombre de client : <?php echo $nbr_client; ?></br>
	Nombre de client Actif : <?php echo $nbr_client_actif; ?> Budget : <?php echo $total_budget_actif; ?> €</br>
	Nombre de client En pause : <?php echo $nbr_client_pause;  ?> Budget : <?php echo $total_budget_en_pause; ?> €</br>
	Nombre de client Résilié : <?php echo $nbr_client_resilie; ?> Budget : <?php echo $total_budget_resilie; ?> €</br>
	<h3>Note</h3>
	<?php foreach ($notes as $n): ?>
		<?= htmlspecialchars($n->title); ?>
	<?php endforeach; ?></br>
	<h3>Discussion tâche</h3></br>
	Nombre de discussion tâche : <?php echo $nbr_discussion_task; ?></br>
	<h3>Discussion Note</h3></br>
	Nombre de discussion Note : <?php echo $nbr_discussion_note; ?></br>
	<h3>Discussion GTM</h3></br>
	Nombre de discussion GTM : <?php echo $nbr_discussion_gtm; ?></br>

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
