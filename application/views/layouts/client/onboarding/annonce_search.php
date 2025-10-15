<?php start_section('stylesheet') ?>

<style>
	.multi-col {
		column-width: 200px;
		column-fill: auto;
		overflow-x: auto;
	}
	.multi-col > * {
		break-inside: avoid;
	}
	.remove-btn {
		cursor: pointer;
		color: black;
		font-weight: bold;
		font-size: 18px;
		position: absolute;
		right: 10px;
		top: 8px;
	}
	.form-group-wrapper {
		position: relative;
	}
	.preview-card {
		background: #fff;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.05);
	}
	#preview-section {
		transition: opacity 0.4s ease-in-out;
		opacity: 0;
	}
	#preview-section:not(.d-none) {
		opacity: 1;
	}
</style>

<?php end_section(); ?>
<?php start_section('content'); ?>
<?php foreach ($donnees as $d) : ?>
<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100">
		<nav id="sidebarMenu" class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
			<a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 mb-5" href="javascript:void(0);" style="height: 72px;">
				<img class="logo-full" src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="" height="72">
			</a>
			<div class="sidebar-sticky">
				<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
					<li class="nav-item rounded"><a class="nav-link text-secondary" href="#"><img src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" /><span>Campagne</span></a></li>
					<li class="nav-item rounded"><a class="nav-link text-secondary" href="#"><img src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" /><span>Paramètres</span></a></li>
					<li class="nav-item rounded"><a class="nav-link text-secondary" href="#"><img src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" /><span>Aperçu</span></a></li>
				</ul>
			</div>
		</nav>

		<div class="col">
			<form action="<?= base_url('Client/Ajoutgroupes/' . $groupe[0]['idclients']) ?>" method="POST" enctype="multipart/form-data">
				<div class="container-fluid pt-4">
					<h5>Campagne Search</h5>
					<hr class="my-4">

					<div class="form-group">
						<label for="nom_entreprise">Nom de l'entreprise</label>
						<input type="hidden" name="idgroupe_annonce" value="<?= $groupe[0]['idgroupe_annonce']; ?>">
						<input type="hidden" name="idcampagne" value="<?= $groupe[0]['idcampagne']; ?>">
						<input type="hidden" name="idclients" value="<?= $groupe[0]['idclients']; ?>">
						<input type="text" class="form-control" name="nom_entreprise" id="nom_entreprise" value="<?= $d['nom_client']; ?>">
					</div>

					<div class="form-group">
						<label for="url_campagne">URL de la campagne</label>
						<input type="text" class="form-control" name="url_campagne" id="url_campagne" value="<?= $groupe[0]['url_site']; ?>">
					</div>

					<div class="form-section-title">Titres (max 15)</div>
					<div id="titres-container">
						<?php if (!empty($ads_titres)) : ?>
							<?php foreach ($ads_titres as $titre) : ?>
								<div class="form-group-wrapper mb-2">
									<input type="text" class="form-control" name="titres[]" value="<?= htmlspecialchars($titre) ?>">
									<span class="remove-btn" style="color: black">&times;</span>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="form-group-wrapper mb-2">
								<input type="text" class="form-control" name="titres[]">
								<span class="remove-btn" style="color: black">&times;</span>
							</div>
						<?php endif; ?>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre">+ Ajouter un titre</button>

					<div class="form-section-title">Titres longs (max 5)</div>
					<div id="titres-longs-container">
						<?php if (!empty($ads_titres_longs)) : ?>
							<?php foreach ($ads_titres_longs as $titre_long) : ?>
								<div class="form-group-wrapper mb-2">
									<input type="text" class="form-control" name="titres_longs[]" value="<?= htmlspecialchars($titre_long) ?>">
									<span class="remove-btn" style="color: black">&times;</span>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="form-group-wrapper mb-2">
								<input type="text" class="form-control" name="titres_longs[]">
								<span class="remove-btn" style="color: black">&times;</span>
							</div>
						<?php endif; ?>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre_long">+ Ajouter un titre long</button>

					<div class="form-section-title">Descriptions (max 4)</div>
					<div id="descriptions-container">
						<?php if (!empty($ads_descriptions)) : ?>
							<?php foreach ($ads_descriptions as $desc) : ?>
								<div class="form-group-wrapper mb-2">
									<input type="text" class="form-control" name="descriptions[]" value="<?= htmlspecialchars($desc) ?>">
									<span class="remove-btn" style="color: black">&times;</span>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="form-group-wrapper mb-2">
								<input type="text" class="form-control" name="descriptions[]">
								<span class="remove-btn" style="color: black">&times;</span>
							</div>
						<?php endif; ?>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_description">+ Ajouter une description</button>

					<div class="form-section-title">Chemin 1</div>
					<input type="text" class="form-control mb-2" name="chemin1">

					<div class="form-section-title">Chemin 2</div>
					<input type="text" class="form-control mb-2" name="chemin2">

					<div class="form-section-title">Images</div>
					<input type="file" name="images[]" multiple class="form-control mb-3">

					<div class="form-section-title">Logo</div>
					<div class="row align-items-center mb-4">
						<div class="col-auto"><img src="<?= base_url($d['logo_client']); ?>" width="64"></div>
						<div class="col-auto">
							<button type="button" class="btn btn-light btn-sm" onclick="document.getElementById('logo').click();"><i class="fa fa-upload"></i> Upload Company Logo</button>
							<input type="file" id="logo" name="logo" hidden>
						</div>
					</div>

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

					<button type="button" class="btn btn-dark btn-sm btn-block mb-3" id="btn-next">Suivant</button>

					<div id="preview-section" class="preview-card mt-4 d-none">
						<h5 class="mb-3">Aperçu de l'annonce</h5>
						<table class="table table-bordered">
							<tr><th>Campagne</th><td><?= $groupe[0]['nom_campagne'] ?></td></tr>
							<tr><th>Groupe d'annonce</th><td><?= $groupe[0]['nom_groupe'] ?></td></tr>
							<tr><th>Titres</th><td id="preview-titres">Aucun titre</td></tr>
							<tr><th>Titres longs</th><td id="preview-titres-longs">Aucun titre long</td></tr>
							<tr><th>Descriptions</th><td id="preview-descriptions">Aucune description</td></tr>
							<tr><th>URL</th><td id="preview-url">Aucune URL</td></tr>
							<tr><th>Chemin 1</th><td id="preview-chemin1">Aucun Chemin 1</td></tr>
							<tr><th>Chemin 2</th><td id="preview-chemin2">Aucun Chemin 2</td></tr>
						</table>
						<div class="d-flex justify-content-between">
							<button type="button" class="btn btn-outline-secondary" id="refresh-preview">🔄 Rafraîchir le tableau</button>
							<input type="submit" class="btn btn-dark" value="Terminer">
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="col-auto px-3 pt-5">
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body">
					<button class="btn btn-dark py-3 px-5"><?= $d['budget'] ?> $</button>
					<br><br>
					<div><i class="fa fa-check-square mr-2"></i>Date Anniversaire : <?= $d['mis_en_place_paiement'] ?></div>
					<div><i class="fa fa-check-square mr-2"></i>Date de Mise en Ligne : <?= $d['annonce'] ?></div>
					<div><i class="fa fa-check-square mr-2"></i>Commerciale <img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24"></div>
					<div><i class="fa fa-check-square mr-2"></i>Account Manager <img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24"></div>
				</div>
			</div>

			<ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link py-3 active">Société</a></li></ul>
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['info_base_client']); ?></p></div>
			</div>

			<ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link py-3 active">Brief de la campagne</a></li></ul>
			<div class="card" style="width: 23rem;">
				<div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['information_client']); ?></p></div>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
	$(document).on('click', '.remove-btn', function () {
		$(this).closest('.form-group-wrapper').remove();
	});
	$('#add_titre').on('click', () => $('#titres-container').append(`<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="titres[]"><span class="remove-btn">&times;</span></div>`));
	$('#add_titre_long').on('click', () => $('#titres-longs-container').append(`<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="titres_longs[]"><span class="remove-btn">&times;</span></div>`));
	$('#add_description').on('click', () => $('#descriptions-container').append(`<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="descriptions[]"><span class="remove-btn">&times;</span></div>`));
	$('#add_lien_annexe').on('click', () => $('#liens-annexes-container').append(`<div class="form-group-wrapper mb-3 p-2 border rounded"><span class="remove-btn">&times;</span><input type="text" class="form-control mb-2" placeholder="Texte lien annexe" name="texte_annexe[]"><input type="text" class="form-control mb-2" placeholder="Description 1" name="desc1_annexe[]"><input type="text" class="form-control mb-2" placeholder="Description 2" name="desc2_annexe[]"><input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]"></div>`));

	$('#btn-next').on('click', function () {
		updatePreview();
		$('#preview-section').removeClass('d-none');
		setTimeout(() => {
			$('html, body').animate({
				scrollTop: $("#preview-section").offset().top
			}, 600);
		}, 100);
	});

	$('#refresh-preview').on('click', function () {
		updatePreview();
	});

	function updatePreview() {
		let titres = [];
		$('input[name="titres[]"]').each(function () {
			const val = $(this).val().trim();
			if (val !== '') titres.push(val);
		});
		$('#preview-titres').html(titres.length ? titres.join('<br>') : 'Aucun titre');

		let titresLongs = [];
		$('input[name="titres_longs[]"]').each(function () {
			const val = $(this).val().trim();
			if (val !== '') titresLongs.push(val);
		});
		$('#preview-titres-longs').html(titresLongs.length ? titresLongs.join('<br>') : 'Aucun titre long');

		let descriptions = [];
		$('input[name="descriptions[]"]').each(function () {
			const val = $(this).val().trim();
			if (val !== '') descriptions.push(val);
		});
		$('#preview-descriptions').html(descriptions.length ? descriptions.join('<br>') : 'Aucune description');

		const url = $('#url_campagne').val().trim();
		$('#preview-url').text(url || 'Aucune URL');

		const chemin1 = $('input[name="chemin1"]').val().trim();
		$('#preview-chemin1').text(chemin1 || 'Aucun Chemin 1');

		const chemin2 = $('input[name="chemin2"]').val().trim();
		$('#preview-chemin2').text(chemin2 || 'Aucun Chemin 2');
	}
</script>
<?php end_section(); ?>
