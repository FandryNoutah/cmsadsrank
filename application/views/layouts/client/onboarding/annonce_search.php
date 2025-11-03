<?php start_section('stylesheet') ?>
<style>
	.multi-col { column-width: 200px; column-fill: auto; overflow-x: auto; }
	.multi-col > * { break-inside: avoid; }
	.remove-btn { cursor: pointer; color: black; font-weight: bold; font-size: 18px; position: absolute; right: 10px; top: 8px; }
	.form-group-wrapper { position: relative; }
	.preview-card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
	#preview-section { transition: opacity 0.4s ease-in-out; opacity: 0; }
	#preview-section:not(.d-none) { opacity: 1; }
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>
<?php foreach ($donnees as $d): ?>
<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100">

		<!-- Sidebar -->
		<nav id="sidebarMenu" class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
			<a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 mb-5" href="#" style="height: 72px;">
				<img class="logo-full" src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="logo" height="72">
			</a>
			<div class="sidebar-sticky">
				<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
					<li class="nav-item"><a class="nav-link text-secondary" href="#"><img src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" /> Campagne</a></li>
					<li class="nav-item"><a class="nav-link text-secondary" href="#"><img src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" /> Paramètres</a></li>
					<li class="nav-item"><a class="nav-link text-secondary" href="#"><img src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" /> Aperçu</a></li>
				</ul>
			</div>
		</nav>

		<!-- Formulaire principal -->
		<div class="col">
			<form action="<?= base_url('Client/Ajoutgroupes/' . $groupe[0]['idclients']) ?>" method="POST" enctype="multipart/form-data">
				<div class="container-fluid pt-4">
					<h5>Campagne Search</h5>
					<hr class="my-4">

					<input type="hidden" name="idgroupe_annonce" value="<?= $groupe[0]['idgroupe_annonce'] ?>">
					<input type="hidden" name="idcampagne" value="<?= $groupe[0]['idcampagne'] ?>">
					<input type="hidden" name="idclients" value="<?= $groupe[0]['idclients'] ?>">

					<div class="form-group">
						<label>Nom de l'entreprise</label>
						<input type="text" class="form-control" name="nom_entreprise" value="<?= $d['nom_client'] ?>">
					</div>

					<div class="form-group">
						<label>URL de la campagne</label>
						<input type="text" class="form-control" name="url_campagne" id="url_campagne" value="<?= $groupe[0]['url_site'] ?>">
					</div>

					<!-- Titres -->
					<div class="form-section-title">Titres (max 15)</div>
					<div id="titres-container">
						<?php foreach (!empty($ads_titres) ? $ads_titres : [''] as $titre): ?>
							<div class="form-group-wrapper mb-2">
								<input type="text" class="form-control" name="titres[]" value="<?= htmlspecialchars($titre) ?>">
								<span class="remove-btn">&times;</span>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre">+ Ajouter un titre</button>

					<!-- Titres longs -->
					<div class="form-section-title">Titres longs (max 5)</div>
					<div id="titres-longs-container">
						<?php foreach (!empty($ads_titres_longs) ? $ads_titres_longs : [''] as $titre_long): ?>
							<div class="form-group-wrapper mb-2">
								<input type="text" class="form-control" name="titres_longs[]" value="<?= htmlspecialchars($titre_long) ?>">
								<span class="remove-btn">&times;</span>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre_long">+ Ajouter un titre long</button>

					<!-- Descriptions -->
					<div class="form-section-title">Descriptions (max 4)</div>
					<div id="descriptions-container">
						<?php foreach (!empty($ads_descriptions) ? $ads_descriptions : [''] as $desc): ?>
							<div class="form-group-wrapper mb-2">
								<input type="text" class="form-control" name="descriptions[]" value="<?= htmlspecialchars($desc) ?>">
								<span class="remove-btn">&times;</span>
							</div>
						<?php endforeach; ?>
					</div>
					<button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_description">+ Ajouter une description</button>

					<!-- Chemins -->
					<div class="form-section-title">Chemin 1</div>
					<input type="text" class="form-control mb-2" name="chemin1">
					<div class="form-section-title">Chemin 2</div>
					<input type="text" class="form-control mb-2" name="chemin2">

					<!-- Images -->
					<div class="form-section-title">Proposition d'images</div>
					<button type="button" class="btn btn-outline-dark mb-3" data-toggle="modal" data-target="#modalGestionImages">
						<i class="fa fa-images"></i> Gérer les images
					</button>

					<div class="card mb-4 d-none" id="propositionImagesCard">
						<div class="card-body">
							<div class="row no-gutters" id="propositionImagesContainer"></div>
						</div>
					</div>

					<!-- Liens annexes -->
					<div class="form-section-title">Liens annexes</div>
					<div id="liens-annexes-container">
						<?php if (!empty($extensions)): ?>
							<?php foreach ($extensions as $ext): ?>
								<div class="form-group-wrapper mb-3 p-2 border rounded">
									<span class="remove-btn">&times;</span>
                                    <p>Titre extensions</p>
									<input type="text" class="form-control mb-2" placeholder="Titre extensions" name="titre_annexe[]" value="<?= htmlspecialchars($ext['titre_extensions']) ?>">
									<p>Description extensions</p>
                                    <input type="text" class="form-control mb-2" placeholder="Description extensions" name="extensions_annexe[]" value="<?= htmlspecialchars($ext['description_extensions']) ?>">
									<p>Extensions Accroche</p>
                                    <input type="text" class="form-control mb-2" placeholder="Extensions Accroche" name="accroche_annexe[]" value="<?= htmlspecialchars($ext['extensions_accroche']) ?>">
									<p>Extraits de site</p>
                                    <input type="text" class="form-control mb-2" placeholder="Extraits de site" name="site_annexe[]" value="<?= htmlspecialchars($ext['extensions_extrait_site']) ?>">
									<p>Extensions de Lieu</p>
                                    <input type="text" class="form-control mb-2" placeholder="Extensions de Lieu" name="lieu_annexe[]" value="<?= htmlspecialchars($ext['extensions_lieu']) ?>">
									<p>Extensions d'appel</p>
                                    <input type="text" class="form-control mb-2" placeholder="Appel" name="appel_annexe[]" value="<?= htmlspecialchars($ext['extensions_appel']) ?>">
									<input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]" value="<?= htmlspecialchars($ext['url_extensions']) ?>">
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<!-- Si aucune extension existante -->
							<div class="form-group-wrapper mb-3 p-2 border rounded">
								<span class="remove-btn">&times;</span>
								<input type="text" class="form-control mb-2" placeholder="Titre extensions" name="titre_annexe[]">
								<input type="text" class="form-control mb-2" placeholder="Description extensions" name="extensions_annexe[]">
								<input type="text" class="form-control mb-2" placeholder="Extensions Accroche" name="accroche_annexe[]">
								<input type="text" class="form-control mb-2" placeholder="Extraits de site" name="site_annexe[]">
								<input type="text" class="form-control mb-2" placeholder="Extensions de Lieu" name="lieu_annexe[]">
								<input type="text" class="form-control mb-2" placeholder="Appel" name="appel_annexe[]">
								<input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]">
							</div>
						<?php endif; ?>
					</div>

					<button type="button" class="btn btn-outline-dark btn-sm mb-5" id="add_lien_annexe">+ Ajouter un lien annexe</button>
					<div class="form-group">
							<label>Mots-clés à exclure</label>
							<textarea class="form-control" rows="15" name="Mots_cle_exclus"><?= isset($mots_exclus[0]['exclusion']) ? htmlentities($mots_exclus[0]['exclusion']) : '' ?></textarea>
					</div>		
					<!-- Preview -->
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
							<tr><th>Images</th><td id="preview-image">Aucune image</td></tr>
						</table>
						<div class="d-flex justify-content-between">
							<button type="button" class="btn btn-outline-secondary" id="refresh-preview">🔄 Rafraîchir le tableau</button>
							<input type="submit" class="btn btn-dark" value="Terminer">
						</div>
					</div>
				</div>
			</form>
			
		</div>

		<!-- Colonne droite -->
		<div class="col-auto px-3 pt-5">
			<!-- Infos client -->
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body">
					<button class="btn btn-dark py-3 px-5"><?= $d['budget'] ?> $</button>
					<br><br>
					<div><i class="fa fa-check-square mr-2"></i>Date Anniversaire : <?= $d['mis_en_place_paiement'] ?></div>
					<div><i class="fa fa-check-square mr-2"></i>Date de Mise en Ligne : <?= $d['annonce'] ?></div>
					<div><i class="fa fa-check-square mr-2"></i>Commerciale <img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24"></div>
					<div><i class="fa fa-check-square mr-2"></i>Account Manager <img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24"></div>
				</div>
			</div>

			<!-- Infos société -->
			<ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active">Société</a></li></ul>
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['info_base_client']); ?></p></div>
			</div>

			<!-- Brief -->
			<ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active">Brief de la campagne</a></li></ul>
			<div class="card" style="width: 23rem;">
				<div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['information_client']); ?></p></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Gestion Images -->
<div class="modal fade" id="modalGestionImages" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Gérer les images de la campagne</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="mb-3 input-group">
					<input type="text" class="form-control" id="imageUrlInput" placeholder="https://exemple.com/image.jpg">
					<div class="input-group-append">
						<button class="btn btn-outline-dark" type="button" id="addImageUrlBtn">Ajouter URL</button>
					</div>
				</div>
				<div id="imagePreviewContainer" class="d-flex flex-wrap"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-dark" id="saveImagesBtn">Enregistrer</button>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
$(document).ready(function() {

	/* === Ajout/Suppression des champs === */
	$(document).on('click', '.remove-btn', function() {
		$(this).closest('.form-group-wrapper').remove();
	});
	$('#add_titre').click(() => $('#titres-container').append(newInput('titres[]')));
	$('#add_titre_long').click(() => $('#titres-longs-container').append(newInput('titres_longs[]')));
	$('#add_description').click(() => $('#descriptions-container').append(newInput('descriptions[]')));
	$('#add_lien_annexe').click(() => $('#liens-annexes-container').append(newAnnexe()));

	function newInput(name) {
		return `<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="${name}"><span class="remove-btn">&times;</span></div>`;
	}
	function newAnnexe() {
		return `	<input type="text" class="form-control mb-2" placeholder="Titre extensions" name="titre_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Description extensions" name="extensions_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Extensions Accroche" name="accroche_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Extraits de site" name="site_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Extensions de Lieu" name="lieu_annexe[]">
							<input type="text" class="form-control mb-2" placeholder="Appel" name="appel_annexe[]">
							<input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]">`;
	}

	/* === Preview === */
	$('#btn-next, #refresh-preview').click(function() {
		updatePreview();
		$('#preview-section').removeClass('d-none');
	});

	function updatePreview() {
		let titres = $('input[name="titres[]"]').map((_,el)=>el.value.trim()).get().filter(v=>v);
		$('#preview-titres').html(titres.length ? titres.join('<br>') : 'Aucun titre');

		let titresLongs = $('input[name="titres_longs[]"]').map((_,el)=>el.value.trim()).get().filter(v=>v);
		$('#preview-titres-longs').html(titresLongs.length ? titresLongs.join('<br>') : 'Aucun titre long');

		let descs = $('input[name="descriptions[]"]').map((_,el)=>el.value.trim()).get().filter(v=>v);
		$('#preview-descriptions').html(descs.length ? descs.join('<br>') : 'Aucune description');

		$('#preview-url').text($('#url_campagne').val().trim() || 'Aucune URL');
		$('#preview-chemin1').text($('input[name="chemin1"]').val().trim() || 'Aucun Chemin 1');
		$('#preview-chemin2').text($('input[name="chemin2"]').val().trim() || 'Aucun Chemin 2');

		let imgs = $('#propositionImagesContainer img').map((_,img)=>img.src).get();
		$('#preview-image').html(imgs.length ? imgs.map(src=>`<img src="${src}" width="120" style="margin:2px;object-fit:cover;">`).join('') : 'Aucune image');
	}

	/* === Images === */
	const fetchImagesUrl = '<?= site_url("Client/fetch_images_campagnes") ?>';
	const saveImagesUrl  = '<?= site_url("Client/save_images_campagnes") ?>';
	const idcampagne = <?= (int)$groupe[0]['idcampagne'] ?>;
	const idclient   = <?= (int)$groupe[0]['idclients'] ?>;
	const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
	const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
	const propositionCard = $('#propositionImagesCard');
	const propositionContainer = $('#propositionImagesContainer');
	const imagePreviewContainer = $('#imagePreviewContainer');

	function createImageItem(src) {
		return `<div class="position-relative m-2 image-item">
					<img src="${src}" width="120" height="120" class="rounded border" style="object-fit:cover;">
					<button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top:2px;right:2px;">&times;</button>
				</div>`;
	}

	function updatePropositionImages(images) {
		propositionContainer.empty();
		if (!images || images.length === 0) {
			propositionCard.addClass('d-none');
			return;
		}
		propositionCard.removeClass('d-none');
		images.forEach(src => {
			propositionContainer.append(`<div class="col-auto px-2 mb-3"><img src="${src}" width="120" class="rounded border" style="object-fit:cover;"></div>`);
		});
	}

	function loadImages() {
		if (!idcampagne) return;
		let data = { idcampagne };
		data[csrfName] = csrfHash;
		$.post(fetchImagesUrl, data, function(resp) {
			if (resp.success) {
				updatePropositionImages(resp.images);
				imagePreviewContainer.empty();
				resp.images.forEach(src => imagePreviewContainer.append(createImageItem(src)));
			}
		}, 'json');
	}

	imagePreviewContainer.on('click', '.remove-image-btn', function() {
		$(this).closest('.image-item').remove();
	});

	$('#addImageUrlBtn').click(function() {
		const url = $('#imageUrlInput').val().trim();
		if (!/^https?:\/\//i.test(url)) return alert('URL invalide');
		imagePreviewContainer.append(createImageItem(url));
		$('#imageUrlInput').val('');
	});

	$('#saveImagesBtn').click(function() {
		let images = imagePreviewContainer.find('img').map((_,img)=>img.src).get();
		let data = { idcampagne, idclient, images };
		data[csrfName] = csrfHash;

		$.post(saveImagesUrl, data, function(resp) {
			if (resp.success) {
				updatePropositionImages(images);
				$('#modalGestionImages').modal('hide');
			} else {
				alert(resp.message || 'Erreur lors de l’enregistrement');
			}
		}, 'json');
	});

	loadImages(); 
});
</script>
<?php end_section(); ?>
