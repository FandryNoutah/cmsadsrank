<?php start_section('stylesheet') ?>
<style>
	.multi-col { column-width: 200px; column-fill: auto; overflow-x: auto; }
	.multi-col>* { break-inside: avoid; }
	.img-proposition { cursor: pointer; transition: transform .08s ease; }
	.loading-spinner { display:inline-block; width:48px; height:48px; border:4px solid rgba(0,0,0,.1); border-left-color:#000; border-radius:50%; animation: spin 1s linear infinite; margin:30px auto; }
	@keyframes spin { to { transform: rotate(360deg); } }
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>
<?php
// Variables attendues : $donnees, $campagne, $groupes_annonces, $idclients, $id_camp, $images_site, $mots_exclus
$d = isset($donnees[0]) ? $donnees[0] : (is_array($donnees) ? $donnees : []);
$images_site = isset($images_site) && is_array($images_site) ? $images_site : [];
?>

<div class="container-fluid p-0 h-100">
	<div class="row no-gutters h-100">
		<nav id="sidebarMenu" class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
			<a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 mb-5" href="javascript:void(0);" style="height: 72px;">
				<img class="logo-full" src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="Google Ads" height="72">
			</a>
			<div class="sidebar-sticky">
				<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
					<li class="nav-item rounded"><a class="nav-link text-secondary" href="#"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" /><span>Paramètre</span></a></li>
					<li class="nav-item rounded"><a class="nav-link text-secondary" href="#"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" /><span>Groupes d'annonces</span></a></li>
				</ul>
				<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
					<li class="nav-item rounded"><a class="nav-link text-secondary" href="#"><img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" /><span>Asset média</span></a></li>
				</ul>
			</div>
		</nav>

		<div class="col">
			<form action="<?= site_url('Client/update_campagne/' . $idclients) . '?id_camp=' . urlencode($id_camp) ?>" method="POST">
				<input type="hidden" name="id_campagne" value="<?= (int)$id_camp ?>">

				<div class="container-fluid pt-4">
					<div class="d-flex align-items-center mb-2">
						<h5 class="mb-0">Modifier la campagne – Réseau de Recherche</h5>
						<span class="badge badge-secondary ml-2"><?= htmlentities($campagne->type_campagne ?? 'search') ?></span>
					</div>
					<hr class="my-4">

					<!-- images sélectionnées (gérées via le modal) -->
					<input type="hidden" name="selectedImages" id="selectedImagesInput" value="<?= implode(',', $images_site) ?>">

					<div class="row align-items-center mb-4">
						<div class="col-auto">
							<?php if (!empty($d['logo_client'])): ?>
								<img src="<?= base_url($d['logo_client']) ?>" width="64" alt="logo client">
							<?php endif; ?>
						</div>
					</div>

					<div class="form-group">
						<label for="nom_campagne_search">Nom de la campagne</label>
						<input type="text" class="form-control" name="nom_campagne_search" id="nom_campagne_search" value="<?= htmlentities($campagne->nom_campagne ?? (($d['nom_client'] ?? 'Campagne') . ' - Search')) ?>">
					</div>

					<div class="form-group">
						<label for="url_campagne">URL de la campagne</label>
						<input type="url" class="form-control" name="url_campagne" id="url_campagne" value="<?= htmlentities($campagne->url ?? ($donnees[0]['site_client'] ?? '')) ?>">
					</div>

					<div class="form-group">
						<label for="information_campagne_search">Information de la campagne</label>
						<button type="button" class="btn btn-outline-dark mb-3" id="generate-info-campagne" data-idclient="<?= $idclients ?>">
							<i class="fa fa-magic"></i> Regénérer avec ChatGPT
						</button>
						<textarea rows="12" class="form-control" name="information_campagne_search" id="information_campagne_search"><?= isset($campagne->information_campagne) ? htmlentities($campagne->information_campagne) : '' ?></textarea>
					</div>

					<div class="form-group">
						<label for="repartition_budget_search">Budget de la campagne (€)</label>
						<input type="number" class="form-control" name="repartition_budget_search" id="repartition_budget_search" value="<?= htmlentities($campagne->repartition_budget ?? '') ?>">
					</div>

					<div id="groupe_annonce_container" class="mb-4 pt-4">
						<?php if (!empty($groupes_annonces) && is_array($groupes_annonces)) : ?>
							<?php foreach ($groupes_annonces as $idx => $g) :
								$nom_groupe  = isset($g['nom_groupe']) ? htmlentities($g['nom_groupe']) : '';
								$contexte    = isset($g['contexte_groupes_annonces']) ? htmlentities($g['contexte_groupes_annonces']) : '';
								$mot_cle     = isset($g['mot_cle']) ? htmlentities($g['mot_cle']) : '';
							?>
							<div class="group-annonce-content">
								<div class="form-group d-flex justify-content-between align-items-center">
									<label class="mb-0">Groupe d'annonce <?= (int)($idx + 1) ?></label>
									<button type="button" class="btn btn-outline-dark btn-sm generate-group-keywords-url-context" data-idclient="<?= htmlentities($idclients) ?>">
										<i class="fa fa-magic"></i> Générer
									</button>
								</div>
								<div class="form-group">
									<label>Nom du groupe</label>
									<input type="text" class="form-control" name="groupe_annonce[]" value="<?= $nom_groupe ?>">
								</div>
								<div class="form-group">
									<label>Contexte du groupe d'annonce</label>
									<textarea name="contexte_groupe_annonce[]" class="form-control" rows="4"><?= $contexte ?></textarea>
								</div>
								<div class="form-group">
									<label>Mots-clés du groupe</label>
									<textarea name="Mot_cle[]" class="form-control" rows="6"><?= $mot_cle ?></textarea>
								</div>
								<button type="button" class="btn btn-sm btn-danger remove_groupe_annonce mt-2">Supprimer</button>
								<hr>
							</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="group-annonce-content original">
								<div class="form-group d-flex justify-content-between align-items-center">
									<label class="mb-0">Groupe d'annonce 1</label>
									<button type="button" class="btn btn-outline-dark btn-sm generate-group-keywords-url-context" data-idclient="<?= htmlentities($idclients) ?>">
										<i class="fa fa-magic"></i> Générer
									</button>
								</div>
								<div class="form-group"><label>Nom du groupe</label><input type="text" class="form-control" name="groupe_annonce[]"></div>
								<div class="form-group"><label>Contexte du groupe d'annonce</label><textarea name="contexte_groupe_annonce[]" class="form-control" rows="4"></textarea></div>
								<div class="form-group"><label>Mots-clés du groupe</label><textarea name="Mot_cle[]" class="form-control" rows="6"></textarea></div>
							</div>
						<?php endif; ?>

						<div class="text-center mb-4">
							<button type="button" class="btn btn-outline-dark btn-sm" id="add_groupe_annonce">
								<i class="fa fa-plus"></i> Ajouter un groupe d'annonce
							</button>
						</div>
					</div>

					<h5>Paramètres de la campagne</h5>

					<div class="form-group">
						<label for="zone_search">Zone géographique</label>
						<input type="text" class="form-control" name="zone_search" id="zone_search" value="<?= htmlentities($campagne->zones ?? '') ?>">
					</div>
					<div class="form-group">
						<label for="langue">Langues</label>
						<select name="langue" id="langue" class="form-control">
							<option value="fr" <?= (($campagne->langue ?? '')=='fr')?'selected':''; ?>>Français</option>
							<option value="en" <?= (($campagne->langue ?? '')=='en')?'selected':''; ?>>Anglais</option>
						</select>
					</div>
					<div class="form-group">
						<label for="cible">Cibles</label>
						<select name="cible" id="cible" class="form-control">
							<option value="B2B" <?= (($campagne->cible ?? '')=='B2B')?'selected':''; ?>>B2B</option>
							<option value="B2C" <?= (($campagne->cible ?? '')=='B2C')?'selected':''; ?>>B2C</option>
						</select>
					</div>
					<div class="form-group">
						<label for="age-range">Tranche d'âges</label>
						<select name="age" id="age-range" class="form-control">
							<?php $age = $campagne->age ?? ''; ?>
							<option value="">-- Sélectionnez --</option>
							<?php foreach (["Tous âges","18-24","25-34","35-44","45-54","55-64","65+"] as $opt): ?>
								<option value="<?= $opt ?>" <?= ($age===$opt)?'selected':''; ?>><?= $opt ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="sexe">Sexe</label>
						<select name="sexe" id="sexe" class="form-control">
							<?php $sx = $campagne->sexe ?? 'Tous sexe'; ?>
							<?php foreach (["Tous sexe","Homme","Femme","Inconnu"] as $opt): ?>
								<option value="<?= $opt ?>" <?= ($sx===$opt)?'selected':''; ?>><?= $opt ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Diffusion</label>
						<input type="text" name="date_campagne" class="form-control" value="<?= htmlentities($campagne->date_campagne ?? '7J/7, 24h/24') ?>">
					</div>
					<div class="form-group">
						<label for="audience">Audiences</label>
						<select name="audience" id="audience" class="form-control">
							<?php $aud = $campagne->audience ?? ''; ?>
							<option value="">—</option>
							<option value="Audience 1" <?= ($aud==='Audience 1')?'selected':''; ?>>Audience 1</option>
							<option value="Audience 2" <?= ($aud==='Audience 2')?'selected':''; ?>>Audience 2</option>
						</select>
					</div>
					<div class="form-group">
						<label for="appareil_search">Appareil</label>
						<select name="appareil" id="appareil_search" class="form-control">
							<?php $ap = $campagne->appareil ?? 'Ordinateur / Mobile / Tablette'; ?>
							<?php foreach ([
								"Ordinateur / Mobile / Tablette",
								"Ordinateur","Mobile","Tablette",
								"Ordinateur / Mobile","Ordinateur / Tablette","Mobile / Tablette"
							] as $opt): ?>
								<option value="<?= $opt ?>" <?= ($ap===$opt)?'selected':''; ?>><?= $opt ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<ul class="nav nav-tabs mb-3">
						<li class="nav-item">
							<a class="nav-link py-3 active">Mots-clés à exclure</a>
							<button type="button" class="btn btn-outline-dark mb-3 generate-keywords-btn" data-idclient="<?= $idclients ?>">
								<i class="fa fa-magic"></i> Regénérer avec ChatGPT
							</button>
						</li>
					</ul>
					<div class="form-group">
						<label>Propositions de mots-clés à exclure</label>
						<textarea class="form-control" rows="15" name="Mots_cle_exclus"><?= isset($mots_exclus[0]['exclusion']) ? htmlentities($mots_exclus[0]['exclusion']) : '' ?></textarea>
					</div>


					<div class="d-flex justify-content-between mb-5">
						<a href="<?= site_url('Client/campagne/'.$idclients.'?id_camp='.urlencode($id_camp)) ?>" class="btn btn-outline-secondary">Annuler</a>
						<button type="submit" class="btn btn-dark">Enregistrer les modifications</button>
					</div>
				</div>
			</form>
		</div>

		<div class="col-auto px-3 pt-5">
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<button class="btn btn-dark py-3 px-5" type="button">
							<?= isset($d['budget']) ? htmlentities($d['budget']) : '' ?> €
						</button>
					</div>
					<br><br>
					<?php if (!empty($d['mis_en_place_paiement'])): ?>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Date d'anniversaire : <?= htmlentities($d['mis_en_place_paiement']) ?></span>
						</div>
					<?php endif; ?>
					<?php if (!empty($d['annonce'])): ?>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Mise en ligne : <?= htmlentities($d['annonce']) ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link py-3 active">Société</a></li></ul>
			<div class="card mb-3" style="width: 23rem;">
				<div class="card-body">
					<p class="text-muted" style="font-size: 15.5px;">
						<?= isset($donnees[0]['info_base_client']) ? nl2br(htmlentities($donnees[0]['info_base_client'])) : '' ?>
					</p>
				</div>
			</div>

			<ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link py-3 active">Brief de la campagne</a></li></ul>
			<div class="card" style="width: 23rem;">
				<div class="card-body">
					<p class="text-muted" style="font-size: 15.5px;">
						<?= isset($donnees[0]['information_client']) ? nl2br(htmlentities($donnees[0]['information_client'])) : '' ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL GESTION IMAGES -->
<div class="modal fade" id="modalGestionImages" tabindex="-1" role="dialog" aria-labelledby="modalGestionImagesLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalGestionImagesLabel">Gérer les images de la campagne</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<input type="file" id="imageUpload" accept="image/*" multiple class="d-none">
					<div class="input-group mt-2">
						<input type="text" class="form-control" id="imageUrlInput" placeholder="https://exemple.com/image.jpg">
						<div class="input-group-append"><button class="btn btn-outline-dark" type="button" id="addImageUrlBtn">Ajouter URL</button></div>
					</div>
				</div>
				<div id="imagePreviewContainer" class="d-flex flex-wrap">
					<?php foreach ($images_site as $img): ?>
						<div class="position-relative m-2 image-item">
							<img src="<?= $img ?>" width="120" height="120" class="rounded border" style="object-fit:cover;">
							<button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top: 2px; right: 2px;">&times;</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
// — Génération mots-clés par groupe —
$(document).on('click', '.generate-group-keywords-url-context', function(){
  const idClient = $(this).data('idclient');
  const $btn = $(this);
  const $block = $btn.closest('.group-annonce-content');
  const url = ($('#url_campagne').val() || '').trim();
  const contexte = ($block.find('textarea[name="contexte_groupe_annonce[]"]').val() || '').trim();
  const nomGroupe = ($block.find('input[name="groupe_annonce[]"]').val() || '').trim();
  const $dest = $block.find('textarea[name="Mot_cle[]"]');
  if (!url) { alert("Renseigne d'abord l’URL de la campagne."); return; }
  if (!contexte && !nomGroupe) { alert("Ajoute au moins un contexte ou un nom de groupe."); return; }
  const endpoint = '<?= site_url("Client/generate_group_keywords_url_context") ?>/' + encodeURIComponent(idClient);
  const payload = { url_campagne:url, contexte:contexte, nom_groupe:nomGroupe };
  if (typeof csrfName!== 'undefined' && csrfName && typeof csrfHash!== 'undefined' && csrfHash) { payload[csrfName]=csrfHash; }
  const oldHtml=$btn.html(); const oldVal=$dest.val();
  $btn.prop('disabled',true).html('<span class="spinner-border spinner-border-sm"></span> Génération...');
  $dest.val('⏳ Génération des mots-clés...');
  $.post(endpoint, payload, function(resp){
    if (resp && resp.csrfName && resp.csrfHash) { window.csrfName=resp.csrfName; window.csrfHash=resp.csrfHash; }
    if (resp && resp.status==='success') { $dest.val(resp.data || ''); }
    else { console.error(resp); alert(resp && resp.message ? resp.message : 'Échec de la génération.'); $dest.val(oldVal); }
  }, 'json').fail(function(xhr){ console.error(xhr); alert('Erreur réseau / serveur.'); $dest.val(oldVal); })
  .always(function(){ $btn.prop('disabled',false).html(oldHtml); });
});

// — Regénération info campagne —
$('#generate-info-campagne').on('click', function(){
  const idClient = $(this).data('idclient');
  const url = ($('#url_campagne').val() || '').trim();
  if (!url) { alert("Veuillez saisir l'URL."); return; }
  const endpoint = '<?= site_url("Client/information_campagne") ?>/' + encodeURIComponent(idClient);
  const payload = { url:url };
  if (typeof csrfName!== 'undefined' && csrfName && typeof csrfHash!== 'undefined' && csrfHash) { payload[csrfName]=csrfHash; }
  const $btn=$(this), $ta=$('#information_campagne_search');
  const old=$btn.html(); $btn.prop('disabled',true).html('<span class="spinner-border spinner-border-sm"></span> Génération...');
  $.post(endpoint, payload, function(resp){
    if (resp && resp.csrfName && resp.csrfHash) { window.csrfName=resp.csrfName; window.csrfHash=resp.csrfHash; }
    if (resp && resp.status==='success') { $ta.val(resp.data || ''); }
    else { console.error(resp); alert(resp && resp.message ? resp.message : 'Erreur de génération.'); }
  }, 'json').fail(function(){ alert('Erreur réseau / serveur.'); })
  .always(function(){ $btn.prop('disabled',false).html(old); });
});

// — Exclusions (mots-clés à exclure) —
$(document).on('click', '.generate-keywords-btn', function(){
  const idClient = $(this).data('idclient');
  const campagneInfo = ($('#information_campagne_search').val() || '').trim();
  if (!campagneInfo) { alert("Renseigne d'abord 'Information de la campagne'."); return; }
  const endpoint = '<?= site_url("Client/get_mot_cle_a_exclure") ?>/' + encodeURIComponent(idClient);
  const payload = { information_campagne_search: campagneInfo };
  if (typeof csrfName!== 'undefined' && csrfName && typeof csrfHash!== 'undefined' && csrfHash) { payload[csrfName]=csrfHash; }
  const $btn=$(this), old=$btn.html(); $btn.prop('disabled',true).html('<span class="spinner-border spinner-border-sm"></span> Génération...');
  $.post(endpoint, payload, function(resp){
    if (resp && resp.csrfName && resp.csrfHash) { window.csrfName=resp.csrfName; window.csrfHash=resp.csrfHash; }
    if (resp && resp.status==='success') { $('textarea[name="Mots_cle_exclus"]').val(resp.data || ''); }
    else { console.error(resp); alert(resp && resp.message ? resp.message : 'Échec de la génération.'); }
  }, 'json').fail(function(){ alert('Erreur réseau / serveur.'); })
  .always(function(){ $btn.prop('disabled',false).html(old); });
});

// — Groupes dynamiques —
$(document).ready(function(){
  const $container = $('#groupe_annonce_container');
  $('#add_groupe_annonce').on('click', function(){
    const index = $container.find('.group-annonce-content').length + 1;
    const $clone = $container.find('.group-annonce-content').first().clone();
    $clone.find('input[name="groupe_annonce[]"]').val('');
    $clone.find('textarea[name="contexte_groupe_annonce[]"]').val('');
    $clone.find('textarea[name="Mot_cle[]"]').val('');
    $clone.find('label:first').text("Groupe d'annonce " + index);
    if ($clone.find('.remove_groupe_annonce').length===0) {
      $clone.append('<button type="button" class="btn btn-sm btn-danger remove_groupe_annonce mt-2">Supprimer</button><hr>');
    }
    $container.append($clone);
  });
  $container.on('click', '.remove_groupe_annonce', function(){ $(this).closest('.group-annonce-content').remove(); });
});

// — Images depuis l'URL + modal —
$(document).ready(function(){
  const fetchImagesUrl = '<?= site_url("Client/fetch_images_campagnes") ?>';
  const propositionCard = $('#propositionImagesCard');
  const propositionContainer = $('#propositionImagesContainer');
  const selectedImagesInput = $('#selectedImagesInput');
  const imagePreviewContainer = $('#imagePreviewContainer');
  <?php if (isset($this->security) && method_exists($this->security,'get_csrf_hash')): ?>
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
  <?php else: ?>
    const csrfName = '', csrfHash = '';
  <?php endif; ?>
  function debounce(fn,delay){ let t=null; return function(){ clearTimeout(t); t=setTimeout(()=>fn.apply(this,arguments),delay); } }
  function updateSelected(){ const selected=[]; $('.img-proposition.selected').each(function(){ selected.push($(this).data('url')); }); selectedImagesInput.val(selected.join(',')); }
  function createItem(src){ return `<div class="position-relative m-2 image-item"><img src="${src}" width="120" height="120" class="rounded border" style="object-fit:cover;"><button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top:2px; right:2px;">&times;</button></div>`; }
  function updateProps(images){ propositionContainer.empty(); if(!Array.isArray(images)||!images.length){ propositionCard.hide(); selectedImagesInput.val(''); return; } propositionCard.show(); let html=''; images.forEach(src=>{ html+=`<div class=\"col-auto px-2 mb-3\"><img src=\"${src}\" width=\"120\" class=\"img-proposition selected\" data-url=\"${src}\" style=\"object-fit:cover; border-radius:4px;\"></div>`; }); propositionContainer.html(html); updateSelected(); }
  function fetchImagesForUrl(url){ if(!url){ propositionContainer.empty(); propositionCard.hide(); selectedImagesInput.val(''); return; }
    let data={url:url}; if(csrfName&&csrfHash){ data[csrfName]=csrfHash; }
    propositionContainer.html('<div class="col-12 text-center"><div class="loading-spinner"></div><p class="mt-2">Chargement des images...</p></div>'); propositionCard.show();
    $.post(fetchImagesUrl, data, function(resp){ if(resp && resp.success && Array.isArray(resp.images) && resp.images.length>0){ updateProps(resp.images); imagePreviewContainer.empty(); resp.images.forEach(src=> imagePreviewContainer.append(createItem(src))); } else { propositionContainer.html('<div class="col-12 text-center text-muted">Aucune image trouvée</div>'); selectedImagesInput.val(''); } }, 'json').fail(function(){ propositionContainer.html('<div class="col-12 text-center text-danger">Erreur lors du chargement</div>'); }); }
  $(document).on('click','.img-proposition', function(){ $(this).toggleClass('selected'); updateSelected(); });
  const initialUrl = ($('#url_campagne').val()||'').trim(); if(initialUrl) fetchImagesForUrl(initialUrl);
  $('#url_campagne').on('input paste', debounce(function(){ const url=$(this).val().trim(); if(url.length<10){ propositionContainer.empty(); propositionCard.hide(); selectedImagesInput.val(''); return; } fetchImagesForUrl(url); }, 800));
  $('#imagePreviewContainer').on('click','.remove-image-btn', function(){ $(this).closest('.image-item').remove(); });
  $('#addImageUrlBtn').on('click', function(){ const url=$('#imageUrlInput').val().trim(); if(!url) return; imagePreviewContainer.append(createItem(url)); $('#imageUrlInput').val(''); });
  $('#imageUpload').on('change', function(e){ for(const file of e.target.files){ const reader=new FileReader(); reader.onload=function(ev){ imagePreviewContainer.append(createItem(ev.target.result)); }; reader.readAsDataURL(file); } $(this).val(''); });
  $('#saveImagesBtn').on('click', function(){ const images=[]; imagePreviewContainer.find('img').each(function(){ images.push($(this).attr('src')); }); $('#selectedImagesInput').val(images.join(',')); updateProps(images); $('#modalGestionImages').modal('hide'); });
});
</script>
<?php end_section(); ?>
