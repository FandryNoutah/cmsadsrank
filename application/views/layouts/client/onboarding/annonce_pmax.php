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
        <!-- Sidebar -->
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

        <!-- Formulaire principal -->
        <div class="col">
            <form action="<?= base_url('Client/Ajoutgroupes/' . $groupe[0]['idclients']) ?>" method="POST" enctype="multipart/form-data">
                <div class="container-fluid pt-4">
                    <h5>Campagne Performance Max</h5>
                    <hr class="my-4">

                    <!-- Informations client -->
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

                    <!-- Titres -->
                    <div class="form-section-title">Titres (max 15)</div>
                    <div id="titres-container">
                        <?php if (!empty($ads_titres)) : ?>
                            <?php foreach ($ads_titres as $titre) : ?>
                                <div class="form-group-wrapper mb-2">
                                    <input type="text" class="form-control" name="titres[]" value="<?= htmlspecialchars($titre) ?>">
                                    <span class="remove-btn">&times;</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="form-group-wrapper mb-2">
                                <input type="text" class="form-control" name="titres[]">
                                <span class="remove-btn">&times;</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre">+ Ajouter un titre</button>

                    <!-- Titres longs -->
                    <div class="form-section-title">Titres longs (max 5)</div>
                    <div id="titres-longs-container">
                        <?php if (!empty($ads_titres_longs)) : ?>
                            <?php foreach ($ads_titres_longs as $titre_long) : ?>
                                <div class="form-group-wrapper mb-2">
                                    <input type="text" class="form-control" name="titres_longs[]" value="<?= htmlspecialchars($titre_long) ?>">
                                    <span class="remove-btn">&times;</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="form-group-wrapper mb-2">
                                <input type="text" class="form-control" name="titres_longs[]">
                                <span class="remove-btn">&times;</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_titre_long">+ Ajouter un titre long</button>

                    <!-- Descriptions -->
                    <div class="form-section-title">Descriptions (max 4)</div>
                    <div id="descriptions-container">
                        <?php if (!empty($ads_descriptions)) : ?>
                            <?php foreach ($ads_descriptions as $desc) : ?>
                                <div class="form-group-wrapper mb-2">
                                    <input type="text" class="form-control" name="descriptions[]" value="<?= htmlspecialchars($desc) ?>">
                                    <span class="remove-btn">&times;</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="form-group-wrapper mb-2">
                                <input type="text" class="form-control" name="descriptions[]">
                                <span class="remove-btn">&times;</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-outline-dark btn-sm mb-3" id="add_description">+ Ajouter une description</button>

                    <!-- Description brève -->
                    <div class="form-section-title">Description brève</div>
                    <input type="text" class="form-control mb-2" name="Description_brève">

                    <!-- Images -->
                    <div class="form-section-title">Proposition d'images</div>
                    <button type="button" class="btn btn-outline-dark mb-3" data-toggle="modal" data-target="#modalGestionImages">
                        <i class="fa fa-images"></i> Gérer les images
                    </button>
                    <?php if (!empty($images_site)): ?>
						<div class="card mb-4" id="propositionImagesCard">
							<div class="card-body">
								<div class="row no-gutters" id="propositionImagesContainer">
									<?php foreach ($images_site as $img): ?>
										<?php if (!empty($img->image_url)): ?>
											<div class="col-auto px-2 mb-3">
												<img src="<?= htmlspecialchars($img->image_url) ?>" 
													alt="Image site client" 
													width="120" 
													style="object-fit: cover; border-radius: 4px; cursor:pointer;" 
													class="img-proposition selected" 
													data-url="<?= htmlspecialchars($img->image_url) ?>">
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<?php endif; ?>

                    <!-- Liens annexes -->
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
                            <tr><th>Description brève</th><td id="Description-brève">Aucune description brève</td></tr>
                            <tr><th>Image</th><td id="image">Aucune image</td></tr>
                        </table>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" id="refresh-preview">🔄 Rafraîchir le tableau</button>
                            <input type="submit" class="btn btn-dark" value="Terminer">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar droit -->
        <div class="col-auto px-3 pt-5">
            <div class="card mb-3" style="width: 23rem;">
                <div class="card-body">
                    <button class="btn btn-dark py-3 px-5"><?= $d['budget'] ?> $</button><br><br>
                    <div><i class="fa fa-check-square mr-2"></i>Date Anniversaire : <?= $d['mis_en_place_paiement'] ?></div>
                    <div><i class="fa fa-check-square mr-2"></i>Date de Mise en Ligne : <?= $d['annonce'] ?></div>
                    <div><i class="fa fa-check-square mr-2"></i>Commerciale <img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24"></div>
                    <div><i class="fa fa-check-square mr-2"></i>Account Manager <img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24"></div>
                </div>
            </div>
            <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link py-3 active">Société</a></li></ul>
            <div class="card mb-3" style="width: 23rem;"><div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['info_base_client']); ?></p></div></div>
            <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link py-3 active">Brief de la campagne</a></li></ul>
            <div class="card" style="width: 23rem;"><div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['information_client']); ?></p></div></div>
        </div>
    </div>
</div>

<!-- Modal gestion images -->
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
    // Gestion ajout/suppression champs dynamiques
    $(document).on('click', '.remove-btn', function() {
        $(this).closest('.form-group-wrapper').remove();
    });
    $('#add_titre').click(() => $('#titres-container').append('<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="titres[]"><span class="remove-btn">&times;</span></div>'));
    $('#add_titre_long').click(() => $('#titres-longs-container').append('<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="titres_longs[]"><span class="remove-btn">&times;</span></div>'));
    $('#add_description').click(() => $('#descriptions-container').append('<div class="form-group-wrapper mb-2"><input type="text" class="form-control" name="descriptions[]"><span class="remove-btn">&times;</span></div>'));
    $('#add_lien_annexe').click(() => $('#liens-annexes-container').append('<div class="form-group-wrapper mb-3 p-2 border rounded"><span class="remove-btn">&times;</span><input type="text" class="form-control mb-2" placeholder="Texte lien annexe" name="texte_annexe[]"><input type="text" class="form-control mb-2" placeholder="Description 1" name="desc1_annexe[]"><input type="text" class="form-control mb-2" placeholder="Description 2" name="desc2_annexe[]"><input type="url" class="form-control mb-2" placeholder="URL" name="url_annexe[]"></div>'));

    const propositionCard = $('#propositionImagesCard');
    const propositionContainer = $('#propositionImagesContainer');
    const imagePreviewContainer = $('#imagePreviewContainer');

    const fetchImagesUrl = '<?= site_url("Client/fetch_images_campagnes") ?>';
    const saveImagesUrl  = '<?= site_url("Client/save_images_campagnes") ?>';
    const idcampagne = <?= isset($groupe[0]['idcampagne']) ? (int)$groupe[0]['idcampagne'] : 0 ?>;
    const idclient   = <?= isset($groupe[0]['idclients']) ? (int)$groupe[0]['idclients'] : 0 ?>;

    const csrfName = '<?= isset($this->security) ? $this->security->get_csrf_token_name() : '' ?>';
    const csrfHash = '<?= isset($this->security) ? $this->security->get_csrf_hash() : '' ?>';

    function createImageItem(src) {
        return `<div class="position-relative m-2 image-item">
                    <img src="${src}" width="120" height="120" class="rounded border" style="object-fit:cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top:2px; right:2px;">&times;</button>
                </div>`;
    }

    function updatePropositionImages(images) {
        propositionContainer.empty();
        if (!images || images.length === 0) {
            propositionCard.hide();
            return;
        }
        propositionCard.show();
        images.forEach(src => {
            propositionContainer.append(`<div class="col-auto px-2 mb-3"><img src="${src}" alt="Image" width="120" class="img-proposition selected" data-url="${src}" style="object-fit: cover; border-radius: 4px;"></div>`);
        });
    }

    function loadImages() {
        if (!idcampagne) return;
        let data = { idcampagne };
        if (csrfName && csrfHash) data[csrfName] = csrfHash;
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
        if (!/^https?:\/\//i.test(url)) { alert('URL invalide'); return; }
        imagePreviewContainer.append(createImageItem(url));
        $('#imageUrlInput').val('');
    });

    $('#saveImagesBtn').click(function() {
        let images = [];
        imagePreviewContainer.find('img').each(function() { images.push($(this).attr('src')); });
        let data = { idcampagne, idclient, images };
        if (csrfName && csrfHash) data[csrfName] = csrfHash;

        $.post(saveImagesUrl, data, function(resp) {
            if (resp.success) {
                updatePropositionImages(images);
                $('#modalGestionImages').modal('hide');
            } else {
                alert(resp.message || 'Erreur lors de l’enregistrement');
            }
        }, 'json');
    });

function updatePreview() {
    const collectInput = name => $('input[name="'+name+'[]"]').map(function(){return $(this).val().trim();}).get().filter(v=>v!=='');
    $('#preview-titres').html(collectInput('titres').join('<br>') || 'Aucun titre');
    $('#preview-titres-longs').html(collectInput('titres_longs').join('<br>') || 'Aucun titre long');
    $('#preview-descriptions').html(collectInput('descriptions').join('<br>') || 'Aucune description');
    $('#preview-url').text($('#url_campagne').val().trim() || 'Aucune URL');
    $('#Description-brève').text($('input[name="Description_brève"]').val().trim() || 'Aucune description brève');

    // Toutes les images sélectionnées
    const imgs = propositionContainer.find('img').map(function(){ return $(this).attr('src'); }).get();
    if (imgs.length) {
        let html = imgs.map(src => `<img src="${src}" width="120" style="object-fit:cover; border-radius:4px; margin:2px;">`).join('');
        $('#image').html(html);
    } else {
        $('#image').text('Aucune image');
    }
}


	

    $('#btn-next').click(function() { updatePreview(); $('#preview-section').removeClass('d-none'); $('html, body').animate({scrollTop: $("#preview-section").offset().top}, 600); });
    $('#refresh-preview').click(updatePreview);

    loadImages();
});
</script>
<?php end_section(); ?>
