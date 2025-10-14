<?php start_section('stylesheet') ?>

<style>
	.multi-col {
		column-width: 200px;
		column-fill: auto;
		overflow-x: auto;
	}

	.multi-col>* {
		break-inside: avoid;
	}
	<style>
	.remove-btn {
		cursor: pointer;
		color: red;
		font-weight: bold;
		font-size: 18px;
		position: absolute;
		right: 10px;
		top: 8px;
	}

	.form-group-wrapper {
		position: relative;
	}
</style>

</style>

<?php end_section(); ?>

<?php start_section('content'); ?>
<?php foreach ($donnees as $d) : ?>
<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100">

		<!-- SIDEBAR -->
		<nav id="sidebarMenu" class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
			<a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 mb-5" href="javascript:void(0);" style="height: 72px;">
				<img class="logo-full" src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="" height="72">
			</a>
			<div class="sidebar-sticky">
				<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
					<li class="nav-item rounded">
						<a class="nav-link text-secondary" href="#">
							<img src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
							<span>Campagne</span>
						</a>
					</li>
					<li class="nav-item rounded">
						<a class="nav-link text-secondary" href="#">
							<img src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
							<span>Paramètres</span>
						</a>
					</li>
					<li class="nav-item rounded">
						<a class="nav-link text-secondary" href="#">
							<img src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
							<span>Aperçu</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<!-- FORMULAIRE CENTRAL -->
		<div class="col">
			<form action='<?= site_url('Client/ajout_campagne/' . $idclients) . "?conversion=$conversion&camp_type=$camp_type&gtm=$gtm" ?>' method="POST">
				<div class="container-fluid pt-4">

					<h5>Campagne PMax</h5>
					<hr class="my-4">

					<!-- INFOS ENTREPRISE -->
					<div class="form-group">
						<label for="nom_entreprise">Nom de l'entreprise</label>
						<input type="text" class="form-control" name="nom_entreprise" id="nom_entreprise">
					</div>

					<div class="form-group">
						<label for="url_campagne">URL de la campagne</label>
						<input type="url" class="form-control" name="url_campagne" id="url_campagne">
					</div>

					<!-- TITRES -->
					<div class="form-section-title">Titres (max 15)</div>
					<div id="titres-container">
						<input type="text" class="form-control mb-2" name="titres[]">
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre">+ Ajouter un titre</button>

					<!-- TITRES LONGS -->
					<div class="form-section-title">Titres longs (max 5)</div>
					<div id="titres-longs-container">
						<input type="text" class="form-control mb-2" name="titres_longs[]">
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre_long">+ Ajouter un titre long</button>

					<!-- DESCRIPTIONS -->
					<div class="form-section-title">Descriptions (max 4)</div>
					<div id="descriptions-container">
						<input type="text" class="form-control mb-2" name="descriptions[]">
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_description">+ Ajouter une description</button>

					<!-- IMAGES -->
					<div class="form-section-title">Images</div>
					<input type="file" name="images[]" multiple class="form-control mb-3">

					<!-- LOGO -->
					<div class="form-section-title">Logo</div>
					<div class="row align-items-center mb-4">
						<div class="col-auto">
							<img src="<?php echo base_url($d['logo_client']); ?>" width="64">
						</div>
						<div class="col-auto">
							<button type="button" class="btn btn-light btn-sm" onclick="document.getElementById('logo').click();">
								<i class="fa fa-upload"></i> Upload Company Logo
							</button>
							<input type="file" id="logo" name="logo" hidden>
						</div>
					</div>

					<!-- LIENS ANNEXES -->
					<div class="form-section-title">Liens annexes</div>
					<div id="liens-annexes-container">
						<div class="form-group">
							<input type="text" class="form-control mb-2" placeholder="Texte lien annexe" name="texte_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Description 1" name="desc1_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Description 2" name="desc2_annexe[]">
							<input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]">
						</div>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-5" id="add_lien_annexe">+ Ajouter un lien annexe</button>

					<!-- BOUTONS -->
					<button type="button" class="btn btn-dark btn-sm btn-block mb-5">Suivant</button>
					<div class="d-flex justify-content-between mb-5">
						
						<button type="submit" class="btn btn-dark">Terminer</button>
					</div>
				</div>
			</form>
		</div>

		<!-- PANEL DROIT -->
		<div class="col-auto px-3 pt-5">
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<button class="btn btn-dark py-3 px-5"><?= $d['budget'] ?> $</button>
					</div>
					<br>
					<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
						<i class="fa fa-check-square mr-2"></i>
						<span>Date Anniversaire : <?= $d['mis_en_place_paiement'] ?></span>
					</div>
					<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
						<i class="fa fa-check-square mr-2"></i>
						<span>Date de Mise en Ligne : <?= $d['annonce'] ?></span>
					</div>
					<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
						<i class="fa fa-check-square mr-2"></i>
						<span>Commerciale</span>
						<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24">
					</div>
					<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
						<i class="fa fa-check-square mr-2"></i>
						<span>Account Manager</span>
						<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24">
					</div>
				</div>
			</div>

			<!-- Bloc société -->
			<ul class="nav nav-tabs mb-3">
				<li class="nav-item"><a class="nav-link py-3 active">Société</a></li>
			</ul>
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body">
					<p class="text-muted font-weight-normal" style="font-size: 15.5px;">
						<?= nl2br($donnees[0]['info_base_client']); ?>	
					</p>
				</div>
			</div>

			<!-- Brief -->
			<ul class="nav nav-tabs mb-3">
				<li class="nav-item"><a class="nav-link py-3 active">Brief de la campagne</a></li>
			</ul>
			<div class="card" style="width: 23rem;">
				<div class="card-body">
					<p class="text-muted font-weight-normal" style="font-size: 15.5px;">
						<?= nl2br($donnees[0]['information_client']); ?>	
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-5 preview-card">
	<h5 class="mb-3">Aperçu de l'annonce</h5>
	<table class="table table-bordered">
		<tr><th>Campagne</th><td><?= $d['nom_campagne'] ?></td></tr>
		<tr><th>Titres</th><td id="preview-titres"></td></tr>
		<tr><th>Descriptions</th><td id="preview-descriptions"></td></tr>
		<tr><th>URL</th><td id="preview-url"></td></tr>
	</table>
</div>

<?php endforeach; ?>
<?php end_section() ?>

<?php start_section('script'); ?>
	<script>
	// Fonction générique pour supprimer le bloc parent
	$(document).on('click', '.remove-btn', function () {
		$(this).closest('.form-group-wrapper').remove();
	});

	// TITRES
	$('#add_titre').on('click', () => {
		const bloc = `
			<div class="form-group-wrapper mb-2">
				<input type="text" class="form-control" name="titres[]">
				<span class="remove-btn">&times;</span>
			</div>`;
		$('#titres-container').append(bloc);
	});

	// TITRES LONGS
	$('#add_titre_long').on('click', () => {
		const bloc = `
			<div class="form-group-wrapper mb-2">
				<input type="text" class="form-control" name="titres_longs[]">
				<span class="remove-btn">&times;</span>
			</div>`;
		$('#titres-longs-container').append(bloc);
	});

	// DESCRIPTIONS
	$('#add_description').on('click', () => {
		const bloc = `
			<div class="form-group-wrapper mb-2">
				<input type="text" class="form-control" name="descriptions[]">
				<span class="remove-btn">&times;</span>
			</div>`;
		$('#descriptions-container').append(bloc);
	});

	// LIENS ANNEXES
	$('#add_lien_annexe').on('click', () => {
		const bloc = `
			<div class="form-group-wrapper mb-3 p-2 border rounded">
				<span class="remove-btn">&times;</span>
				<input type="text" class="form-control mb-2" placeholder="Texte lien annexe" name="texte_annexe[]">
				<input type="text" class="form-control mb-2" placeholder="Description 1" name="desc1_annexe[]">
				<input type="text" class="form-control mb-2" placeholder="Description 2" name="desc2_annexe[]">
				<input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]">
			</div>`;
		$('#liens-annexes-container').append(bloc);
	});
</script>

<?php end_section(); ?>
