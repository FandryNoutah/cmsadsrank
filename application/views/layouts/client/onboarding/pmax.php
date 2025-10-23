<?php start_section('stylesheet'); ?>

<style>
	.multi-col {
		column-width: 200px;
		column-fill: auto;
		overflow-x: auto;
	}

	.multi-col>* {
		break-inside: avoid;
	}

	.loading-spinner {
		display: inline-block;
		width: 48px;
		height: 48px;
		border: 4px solid rgba(0, 0, 0, 0.1);
		border-left-color: #000;
		border-radius: 50%;
		animation: spin 1s linear infinite;
		margin: 30px auto;
	}

	@keyframes spin {
		to {
			transform: rotate(360deg);
		}
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
						<li class="nav-item rounded">
							<a class="nav-link text-secondary" href="#">
								<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
								<span>Menu 1</span>
							</a>
						</li>
						<li class="nav-item rounded">
							<a class="nav-link text-secondary" href="#">
								<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
								<span>Menu 2</span>
							</a>
						</li>
					</ul>

					<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
						<li class="nav-item rounded">
							<a class="nav-link text-secondary" href="#">
								<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
								<span>Exemple Menu</span>
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<div class="col">
				<form action='<?= site_url('Client/ajout_campagne/' . $idclients) . "?conversion=$conversion&camp_type=$camp_type&gtm=$gtm" ?>' method="POST">
					<div class="container-fluid pt-4">

						<h5>Campagne Performance Maximum</h5>
						<hr class="my-4">

						<!-- <div class="row align-items-center mb-4">
							<div class="col-auto">
								<img src="<?= base_url('assets/images/figma/discu_queue.png') ?>" class="img-thumbnail rounded-circle" width="64">
							</div>
							<div class="col-auto">
								<input type="hidden" name="file">
								<button type="button" class="btn btn-light btn-sm">
									<i class="fa fa-upload"></i>
									Upload Company Logo
								</button>
							</div>
						</div>
						-->
						<input type="hidden" name="selectedImages" id="selectedImagesInput" value="<?= implode(',', $images_site) ?>">

						<div class="form-group">
							<label for="nom_campagne_pmax">Nom de la campagne</label>
							<input type="text" class="form-control" name="nom_campagne_pmax" id="nom_campagne_pmax">
						</div>
						<div class="form-group">
							<label for="url_campagne">URL de la campagne</label>
							<input type="url" class="form-control" name="url_campagne" id="url_campagne">
						</div>

						<div class="form-group">
							<label for="information_campagne_search">Information de la campagne</label>

							<button
								type="button"
								class="btn btn-outline-dark mb-3"
								id="generate-info-campagne"
								data-idclient="<?= $idclients ?>">
								<i class="fa fa-images"></i> Générer avec ChatGPT
							</button>

							<textarea class="form-control" name="information_campagne_search" id="information_campagne_search"><?= isset($campagne) ? htmlentities($campagne->information_campagne) : '' ?></textarea>
						</div>


						<div class="form-group">
							<label for="repartition_budget_pmax">Budget de la campagne</label>
							<input type="number" class="form-control" name="repartition_budget_pmax" id="repartition_budget_pmax">
						</div>


						<div class="form-group">
							<label>Groupe d'annonce</label>
							<input type="text" class="form-control" name="groupe_annonce[]">
						</div>

						<div class="form-group">
							<label>Saisir des mots-clés du groupe d'annonce</label>
							<textarea name="Mot_cle[]" class="form-control" maxlength="50"></textarea>
						</div>


						<div class="form-group">
							<label for="">Quels produits ou services promouvez-vous dans cette campagne ?</label>
							<textarea name="" class="form-control" maxlength="50"></textarea>
						</div>

						<div class="form-group">
							<label for="">En quoi vos produits ou services sont-ils uniques ?</label>
							<textarea name="" class="form-control" maxlength="50"></textarea>
						</div>

						<h5>Paramètres de la campagne</h5>
						<div class="form-group">
							<label for="zone_pmax">Zone géographique</label>
							<input type="text" class="form-control" name="zone_pmax" id="zone_pmax">
						</div>

						<div class="form-group">
							<label for="">Langues</label>
							<select name="" class="form-control">
								<option value="">Français</option>
								<option value="">Anglais</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Cibles</label>
							<select name="cible" class="form-control">
								<option value="">B2B</option>
								<option value="">B2C</option>
							</select>
						</div>

						<div class="form-group">
							<label for="age-range">Tranche d'âges</label>
							<select name="age" id="age-range" class="form-control">
								<option value="">-- Sélectionnez une tranche d'âge --</option>
								<option value="18-24">18 - 24 ans</option>
								<option value="25-34">25 - 34 ans</option>
								<option value="35-44">35 - 44 ans</option>
								<option value="45-54">45 - 54 ans</option>
								<option value="55-64">55 - 64 ans</option>
								<option value="65+">65 ans et plus</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Audiences</label>
							<select name="" class="form-control">
								<option value="">Audience 1</option>
								<option value="">Audience 2</option>
							</select>
						</div>

						<div class="container mb-3">
							<div class="multi-col" style="height: 200px;">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Affinité</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Acheteurs</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Actualités et politique</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Alimentation et restauration</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Banque et finance</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Beauté et bien-être</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Maison et jardinage</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Modes de vie et loisirs</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Médias et divertissement</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Sport et remise en forme</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Technologie</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Voyages</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Véhicules et transports</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="appareil_search">Appareil</label>
							<select name="appareil" id="appareil_search" class="form-control">
								<option value="Ordinateur / Mobile / Tablette">Ordinateur / Mobile / Tablette</option>
								<option value="Ordinateur">Ordinateur</option>
								<option value="Mobile">Mobile</option>
								<option value="Tablette">Tablette</option>
								<option value="Ordinateur / Mobile">Ordinateur / Mobile</option>
								<option value="Ordinateur / Tablette">Ordinateur / Tablette</option>
								<option value="Mobile / Tablette">Mobile / Tablette</option>
							</select>
						</div>
						<ul class="nav nav-tabs mb-3">
							<li class="nav-item">
								<a class="nav-link py-3 active">Propositions de mots-clés à exclure</a>
								<button
									type="button"
									class="btn btn-outline-dark mb-3 generate-keywords-btn"
									data-idclient="<?= $idclients ?>">
									<i class="fa fa-images"></i> Générer avec chatgpt
								</button>

							</li>
						</ul>

						<div class="form-group">
							<label>Propositions de mots-clés à exclure</label>
							<textarea class="form-control" rows="15" name="Mots_cle_exclus"><?= isset($mots_exclus) ? htmlentities($mots_exclus) : '' ?></textarea>
						</div>

						<ul class="nav nav-tabs mb-3">
							<li class="nav-item">
								<a class="nav-link py-3 active">Proposition d'images</a>
							</li>
							<button type="button" class="btn btn-outline-dark mb-3" data-toggle="modal" data-target="#modalGestionImages">
								<i class="fa fa-images"></i> Gérer les images
							</button>
						</ul>

						<div class="card mb-4" id="propositionImagesCard" style="<?= empty($images_site) ? 'display:none;' : '' ?>">
							<div class="card-body">
								<div class="row no-gutters" id="propositionImagesContainer">
									<?php foreach ($images_site as $img): ?>
										<div class="col-auto px-2 mb-3">
											<img src="<?= $img ?>" alt="Image site client" width="120" style="object-fit: cover; border-radius: 4px; cursor:pointer;" class="img-proposition selected" data-url="<?= $img ?>">
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-between mb-5">
							<button class="btn btn-dark" type="submit">Terminer</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-auto px-3 pt-5">
				<div class="card mb-3" style="width: 23rem;">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
								<?= $d['budget'] ?> €
							</button>
						</div>
						<br><br>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Date d'anniversaire : <?= $d['mis_en_place_paiement'] ?></span>
						</div>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Date de mise en ligne : <?= $d['annonce'] ?></span>
						</div>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Commerciale</span>
							<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24" class="ml-2">
						</div>
						<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Account Manager</span>
							<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24" class="ml-2">
						</div>
					</div>
				</div>

				<ul class="nav nav-tabs mb-3">
					<li class="nav-item">
						<a class="nav-link py-3 active">Société</a>
					</li>
				</ul>

				<div class="card mb-3" style="width: 23rem;">
					<div class="card-body">
						<p class="text-muted font-weight-normal" style="font-size: 15.5px;">
							<?= nl2br($donnees[0]['info_base_client']); ?>
						</p>
					</div>
				</div>

				<ul class="nav nav-tabs mb-3">
					<li class="nav-item">
						<a class="nav-link py-3 active">Brief de la campagne</a>
					</li>
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

	<div class="modal fade" id="modalGestionImages" tabindex="-1" role="dialog" aria-labelledby="modalGestionImagesLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalGestionImagesLabel">Gérer les images de la campagne</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<input type="file" id="imageUpload" accept="image/*" multiple class="d-none">
						<!-- <button type="button" class="btn btn-sm btn-dark" onclick="document.getElementById('imageUpload').click();">
							<i class="fa fa-upload"></i> Ajouter depuis l’ordinateur
						</button> -->
						<div class="input-group mt-2">
							<input type="text" class="form-control" id="imageUrlInput" placeholder="https://exemple.com/image.jpg">
							<div class="input-group-append">
								<button class="btn btn-outline-dark" type="button" id="addImageUrlBtn">Ajouter URL</button>
							</div>
						</div>
					</div>
					<div id="imagePreviewContainer" class="d-flex flex-wrap">
						<?php foreach ($images_site as $img): ?>
							<div class="position-relative m-2 image-item">
								<img src="<?= $img ?>" width="120" height="120" class="rounded border" style="object-fit:cover;">
								<button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 2px; right: 2px;">&times;</button>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
					<button type="button" class="btn btn-dark" id="saveImagesBtn">Enregistrer</button>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php end_section() ?>
<?php start_section('script'); ?>
<script>
	$(document).ready(function() {
		$('#generate-info-campagne').on('click', function() {
			const idClient = $(this).data('idclient');
			const urlCampagne = $('#url_campagne').val();

			if (!urlCampagne) {
				alert("Veuillez entrer une URL de campagne.");
				return;
			}

			$.ajax({
				url: '<?= base_url("Client/information_campagne") ?>/' + idClient,
				method: 'POST',
				data: {
					url: urlCampagne
				},
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						$('#information_campagne_search').val(response.data);
					} else {
						alert("Une erreur est survenue.");
					}
				},
				error: function() {
					alert("Erreur lors de la communication avec le serveur.");
				}
			});
		});
	});
	$(document).ready(function() {
		$('.generate-keywords-btn').on('click', function() {
			const idClient = $(this).data('idclient');
			const infoCampagne = $('#information_campagne_search').val();

			if (!infoCampagne) {
				alert("Veuillez remplir les informations de la campagne avant de générer les mots-clés à exclure.");
				return;
			}

			$.ajax({
				url: '<?= base_url("Client/get_mot_cle_a_exclure") ?>/' + idClient,
				method: 'POST',
				data: {
					information_campagne_search: infoCampagne
				},
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						$('textarea[name="Mots_cle_exclus"]').val(response.data);
					} else {
						alert(response.message || "Erreur lors de la génération des mots-clés.");
					}
				},
				error: function() {
					alert("Erreur serveur lors de la génération.");
				}
			});
		});
	});
</script>
<script>
	$(function() {
		const imageContainer = $('#imagePreviewContainer');
		const hiddenInput = $('#selectedImagesInput');
		const propositionCard = $('#propositionImagesCard');
		const propositionContainer = $('#propositionImagesContainer');

		imageContainer.on('click', '.btn-danger', function() {
			$(this).closest('.image-item').remove();
		});

		$('#addImageUrlBtn').on('click', function() {
			const url = $('#imageUrlInput').val().trim();
			if (url) {
				imageContainer.append(createImageItem(url));
				$('#imageUrlInput').val('');
			}
		});

		$('#imageUpload').on('change', function(event) {
			const files = event.target.files;
			for (let file of files) {
				const reader = new FileReader();
				reader.onload = function(e) {
					imageContainer.append(createImageItem(e.target.result));
				};
				reader.readAsDataURL(file);
			}
			$(this).val('');
		});

		$('#saveImagesBtn').on('click', function() {
			const images = [];
			imageContainer.find('img').each(function() {
				images.push($(this).attr('src'));
			});
			hiddenInput.val(images.join(','));
			updatePropositionImages(images);
			$('#modalGestionImages').modal('hide');
		});

		function updatePropositionImages(images) {
			propositionContainer.empty();
			if (images.length === 0) {
				propositionCard.hide();
			} else {
				propositionCard.show();
				images.forEach(src => {
					propositionContainer.append(`
					<div class="col-auto px-2 mb-3">
						<img src="${src}" alt="Image site client" width="120" style="object-fit: cover; border-radius: 4px;">
					</div>
				`);
				});
			}
		}

		function createImageItem(src) {
			return `
				<div class="position-relative m-2 image-item">
					<img src="${src}" width="120" height="120" class="rounded border" style="object-fit:cover;">
					<button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 2px; right: 2px;">&times;</button>
				</div>`;
		}

		$('#add_groupe_annonce').on('click', function() {
			let $original = $('#groupe_annonce_container .original').first();
			let $newGroup = $original.clone();
			$newGroup.find('input, textarea').val('');
			let count = $('#groupe_annonce_container .group-annonce-content').length + 1;
			$newGroup.find('label:first').text("Groupe d'annonce " + count);
			$newGroup.append('<button type="button" class="btn btn-sm btn-danger remove_groupe_annonce mt-2">Supprimer</button>');
			$newGroup.prepend('<hr>');
			$newGroup.removeClass('original');
			$newGroup.insertBefore($('#groupe_annonce_container .text-center'));
		});

		$(document).on('click', '.remove_groupe_annonce', function() {
			$(this).closest('.group-annonce-content').remove();
		});

		$('#multiple_groupe_annonce').change(function() {
			let checked = $(this).is(':checked');
			$('#add_groupe_annonce').parent('.text-center').toggleClass('d-none', !checked);
		});
	});
	const fetchImagesUrl = '<?= site_url("Client/fetch_images_campagne") ?>';
	<?php if (function_exists('csrf_token') || (isset($this->security) && method_exists($this->security, 'get_csrf_hash'))): ?>
		const csrfName = '<?= isset($this->security) ? $this->security->get_csrf_token_name() : '' ?>';
		const csrfHash = '<?= isset($this->security) ? $this->security->get_csrf_hash() : '' ?>';
	<?php else: ?>
		const csrfName = '';
		const csrfHash = '';
	<?php endif; ?>

	$(document).ready(function() {
		function debounce(fn, delay) {
			let timer = null;
			return function() {
				const context = this,
					args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function() {
					fn.apply(context, args);
				}, delay);
			};
		}

		const propositionCard = $('#propositionImagesCard');
		const propositionContainer = $('#propositionImagesContainer');
		const selectedImagesInput = $('#selectedImagesInput');
		const imagePreviewContainer = $('#imagePreviewContainer');

		function updateSelectedFromPropositions() {
			let selected = [];
			$('.img-proposition.selected').each(function() {
				selected.push($(this).data('url'));
			});
			selectedImagesInput.val(selected.join(','));
		}

		$(document).on('click', '.img-proposition', function() {
			$(this).toggleClass('selected');
			updateSelectedFromPropositions();
		});

		const fetchImagesForUrl = debounce(function(url) {
			if (!url) {
				propositionContainer.empty();
				propositionCard.hide();
				selectedImagesInput.val('');
				return;
			}
			let data = {
				url: url
			};
			if (csrfName && csrfHash) data[csrfName] = csrfHash;

			const loader = '<div class="col-12 text-center">Chargement...</div>';
			propositionContainer.html(loader);
			propositionCard.show();

			$.ajax({
				url: fetchImagesUrl,
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function(resp) {
					if (resp && resp.success && Array.isArray(resp.images) && resp.images.length > 0) {
						let html = '';
						resp.images.forEach(function(img) {
							html += `
							<div class="col-auto px-2 mb-3">
								<img src="${img}" alt="Image site client"
									width="120"
									class="img-proposition selected"
									data-url="${img}"
									style="object-fit: cover; border-radius: 4px;">
							</div>`;
						});
						propositionContainer.html(html);
						selectedImagesInput.val(resp.images.join(','));
						imagePreviewContainer.empty();
						resp.images.forEach(function(src) {
							imagePreviewContainer.append(createImageItem(src));
						});
					} else {
						propositionContainer.html('<div class="col-12 text-center text-muted">Aucune image trouvée</div>');
						selectedImagesInput.val('');
					}
				},
				error: function() {
					propositionContainer.html('<div class="col-12 text-center text-danger">Erreur lors du chargement</div>');
				}
			});
		}, 550);

		$('#url_campagne').on('input paste change', function() {
			const url = $(this).val().trim();
			if (url.length === 0) {
				propositionContainer.empty();
				propositionCard.hide();
				selectedImagesInput.val('');
				return;
			}
			fetchImagesForUrl(url);
		});

		imagePreviewContainer.on('click', '.remove-image-btn', function() {
			$(this).closest('.image-item').remove();
		});

		$('#addImageUrlBtn').on('click', function() {
			const url = $('#imageUrlInput').val().trim();
			if (!url) return;
			imagePreviewContainer.append(createImageItem(url));
			$('#imageUrlInput').val('');
		});

		$('#imageUpload').on('change', function(event) {
			const files = event.target.files;
			for (let file of files) {
				const reader = new FileReader();
				reader.onload = function(e) {
					imagePreviewContainer.append(createImageItem(e.target.result));
				};
				reader.readAsDataURL(file);
			}
			$(this).val('');
		});

		$('#saveImagesBtn').on('click', function() {
			const images = [];
			imagePreviewContainer.find('img').each(function() {
				images.push($(this).attr('src'));
			});
			selectedImagesInput.val(images.join(','));
			updatePropositionImages(images);
			$('#modalGestionImages').modal('hide');
		});

		function createImageItem(src) {
			return `
			<div class="position-relative m-2 image-item">
				<img src="${src}" width="120" height="120" class="rounded border" style="object-fit:cover;">
				<button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top: 2px; right: 2px;">&times;</button>
			</div>`;
		}

		function updatePropositionImages(images) {
			propositionContainer.empty();
			if (!Array.isArray(images) || images.length === 0) {
				propositionCard.hide();
				selectedImagesInput.val('');
				return;
			}
			propositionCard.show();
			let html = '';
			images.forEach(function(src) {
				html += `
				<div class="col-auto px-2 mb-3">
					<img src="${src}" alt="Image site client"
						width="120"
						class="img-proposition selected"
						data-url="${src}"
						style="object-fit: cover; border-radius: 4px;">
				</div>`;
			});
			propositionContainer.html(html);
		}
	});
</script>
<?php end_section(); ?>
