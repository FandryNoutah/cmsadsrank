<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Création d'annonce – Vue CI3 avec Aperçu Google Ads</title>
  <?php start_section('stylesheet') ?>
  <style>
    /* ======= Base ======= */
    .multi-col { column-width: 200px; column-fill: auto; overflow-x: auto; }
    .multi-col > * { break-inside: avoid; }
    .remove-btn { cursor: pointer; color: black; font-weight: bold; font-size: 18px; position: absolute; right: 10px; top: 8px; }
    .form-group-wrapper { position: relative; }
    .preview-card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    #preview-section { transition: opacity 0.4s ease-in-out; opacity: 0; }
    #preview-section:not(.d-none) { opacity: 1; }

    /* ======= Aperçu mobile (Google Ads like) ======= */
    .ads-phone{position:relative;margin:4px auto 0;width:340px;height:640px;border-radius:28px;border:1px solid #e5e7eb;background:#ffffff;box-shadow:0 10px 25px rgba(2,8,23,.12)}
    .ads-speaker{position:absolute;left:50%;transform:translateX(-50%);top:10px;width:80px;height:5px;border-radius:3px;background:#e5e7eb}
    .ads-screen{position:absolute;inset:34px 12px 14px;border-radius:22px;background:#ffffff;overflow:auto;border:1px solid #eef2f7}
    .ads-g{padding:14px;border-bottom:1px solid #f1f5f9}
    .ads-g-url{font-size:12px;color:#1e8e3e;margin-bottom:6px}
    .ads-g-title{font-size:16px;line-height:1.3;margin:0 0 6px;color:#1a0dab}
    .ads-g-desc{font-size:13px;color:#202124}
    .ads-sitelinks{display:grid;grid-template-columns:1fr;gap:10px;margin-top:10px}

    /* ======= Sections repliables ======= */
    .g-block{border:1px solid #e5e7eb;border-radius:8px;background:#fff;margin-bottom:14px}
    .g-head{display:flex;align-items:center;justify-content:space-between;gap:8px;padding:12px 14px;cursor:pointer}
    .g-head:hover{background:#f8fafc}
    .g-title{display:flex;align-items:center;gap:8px;font-weight:600}
    .g-sub{font-size:12px;color:#64748b}
    .g-arrow{transition:transform .2s ease}
    .g-body{padding:14px;border-top:1px solid #eef2f7;display:none;background:#fafbff}
    .g-block.open .g-body{display:block}
    .g-block.open .g-arrow{transform:rotate(180deg)}

    /* Lien d'ajout */
    .g-add{display:inline-flex;align-items:center;gap:6px;color:#1a73e8;font-weight:600;text-decoration:none;background:transparent;border:0;padding:0;cursor:pointer}
    .g-add:hover{color:#174ea6;text-decoration:underline}

    /* Compteurs */
    .g-field{position:relative;margin-bottom:10px}
    .g-counter{position:absolute;right:8px;bottom:-18px;font-size:12px;color:#64748b}
    .g-counter.bad{color:#d93025}
    .g-label{font-weight:600;margin-bottom:4px}

    /* Sticky right column */
    .sticky-col{position:sticky;top:20px;align-self:flex-start;max-height:calc(100vh - 40px);overflow:auto}

    /* Phone header (Google look) */
    .g-phone-header{position:sticky;top:0;background:#fff;border-bottom:1px solid #eef2f7;padding:10px 10px 12px;z-index:5}
    .g-googlemark{margin-bottom:8px}
    .g-phone-search{display:flex;align-items:center;gap:8px;border:1px solid #e5e7eb;border-radius:20px;padding:6px 10px}
    .g-phone-input{border:0;outline:none;flex:1}
    .g-ico{font-size:14px;opacity:.6}

    /* === Phone split layout (2/3 texte, 1/3 image si dispo) === */
    #pp-wrap{display:block}
    #pp-wrap.ads-split{display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:start}
    .ads-sideimg img{width:100%;height:auto;max-height:160px;border-radius:8px;object-fit:cover}
    /* Lignes pleine largeur quand split (meta + sitelinks) */
    .ads-split .pp-full{grid-column:1 / -1}

    /* Sitelink (titre + flèche) */
    .sl-item{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border:1px dashed #e5e7eb;border-radius:10px}
    .sl-title{color:#1a0dab;text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .sl-arrow{font-size:16px;opacity:.6}
    .annexe-item .remove-annexe{
  position: absolute; 
  right: 8px;
  top: 8px;
  z-index: 10; /
  pointer-events: auto;
}

.remove-btn{
  position:absolute;
  right:10px;
  top:8px;
  width:26px;
  height:26px;
  line-height:24px;
  text-align:center;
  border-radius:50%;
  font-weight:700;
  font-size:18px;
  color:#111827;        
  background:#ffffff;
  border:1px solid #e5e7eb;
  cursor:pointer;
  z-index:10;
  user-select:none;
}
.remove-btn:hover{ background:#f8fafc; }
.remove-btn:active{ transform:scale(0.96); }
.remove-btn:focus{ outline:2px solid #cbd5e1; outline-offset:2px; }



    html{scroll-behavior:smooth}
  </style>
  <?php end_section(); ?>
</head>
<body>
<?php start_section('content'); ?>
<?php foreach ($donnees as $d): ?>
<div class="container-fluid p-0 h-100">
  <div class="row no-gutters h-100">

    <!-- Formulaire principal -->
    <div class="col-12 col-lg-6 order-lg-2">
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

          <div class="form-group">
            <label>Mot clé</label>
            <textarea rows="10" type="text" class="form-control" name="mot_cle"><?= $groupe[0]['mot_cle'] ?></textarea>
          </div>

          <!-- Titres -->
          <div class="g-block" id="sec-titres">
            <div class="g-head" data-toggle="#body-titres">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Titres</div>
                <div class="g-sub">Ajoutez jusqu'à 15 titres (30 caractères max)</div>
              </div>
            </div>
            <div class="g-body" id="body-titres">
              <div id="titres-container">
                <?php foreach (!empty($ads_titres) ? $ads_titres : [''] as $titre): ?>
                <div class="form-group-wrapper g-field">
                  <label class="g-label">Titre</label>
                  <input type="text" class="form-control g-input" name="titres[]" maxlength="30" value="<?= htmlspecialchars($titre) ?>" data-max="30">
                  <span class="g-counter">0/30</span>
                  <span class="remove-btn">&times;</span>
                </div>
                <?php endforeach; ?>
              </div>
              <button type="button" class="g-add" id="add_titre">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Titre
              </button>
            </div>
          </div>

          <!-- Titres longs -->
          <div class="g-block" id="sec-titres-longs">
            <div class="g-head" data-toggle="#body-titres-longs">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Titres longs</div>
                <div class="g-sub">Ajoutez jusqu'à 5 titres longs (90 caractères max)</div>
              </div>
            </div>
            <div class="g-body" id="body-titres-longs">
              <div id="titres-longs-container">
                <?php foreach (!empty($ads_titres_longs) ? $ads_titres_longs : [''] as $titre_long): ?>
                <div class="form-group-wrapper g-field">
                  <label class="g-label">Titre long</label>
                  <input type="text" class="form-control g-input" name="titres_longs[]" maxlength="90" value="<?= htmlspecialchars($titre_long) ?>" data-max="90">
                  <span class="g-counter">0/90</span>
                  <span class="remove-btn">&times;</span>
                </div>
                <?php endforeach; ?>
              </div>
              <button type="button" class="g-add" id="add_titre_long">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Titre long
              </button>
            </div>
          </div>

          <!-- Descriptions -->
          <div class="g-block" id="sec-descriptions">
            <div class="g-head" data-toggle="#body-descriptions">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Descriptions</div>
                <div class="g-sub">Ajoutez jusqu'à 4 descriptions (90 caractères max)</div>
              </div>
            </div>
            <div class="g-body" id="body-descriptions">
              <div id="descriptions-container">
                <?php foreach (!empty($ads_descriptions) ? $ads_descriptions : [''] as $desc): ?>
                <div class="form-group-wrapper g-field">
                  <label class="g-label">Description</label>
                  <input type="text" class="form-control g-input" name="descriptions[]" maxlength="90" value="<?= htmlspecialchars($desc) ?>" data-max="90">
                  <span class="g-counter">0/90</span>
                  <span class="remove-btn">&times;</span>
                </div>
                <?php endforeach; ?>
              </div>
              <button type="button" class="g-add" id="add_description">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Description
              </button>
            </div>
          </div>

          <!-- Tiroir Chemins -->
        <div class="g-block" id="sec-chemins">
          <div class="g-head" data-toggle="#body-chemins">
            <div>
              <div class="g-title">
                <!-- Flèche SVG -->
                <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                Chemins
              </div>
              <div class="g-sub">Personnalisez l’URL affichée (2 champs max, 15 caractères chacun)</div>
            </div>
          </div>

          <div class="g-body" id="body-chemins">
            <div class="g-field">
              <label class="g-label">Chemin 1</label>
              <input type="text"
                    class="form-control g-input"
                    name="chemin1"
                    maxlength="15"
                    placeholder="ex : services"
                    value="<?= htmlspecialchars($groupe[0]['chemin1'] ?? '') ?>">
            </div>

            <div class="g-field">
              <label class="g-label">Chemin 2</label>
              <input type="text"
                    class="form-control g-input"
                    name="chemin2"
                    maxlength="15"
                    placeholder="ex : tarifs"
                    value="<?= htmlspecialchars($groupe[0]['chemin2'] ?? '') ?>">
            </div>

            <small class="text-muted d-block mt-2">
              💡 Ces chemins sont purement visuels et n’affectent pas l’URL réelle de destination.
            </small>
          </div>
        </div>

           <!-- Tiroir Images -->
          <div class="g-block" id="sec-images">
            <div class="g-head" data-toggle="#body-images">
              <div>
                <div class="g-title">
                  <!-- flèche SVG -->
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                  Proposition d’images
                </div>
                <div class="g-sub">Ajoutez ou gérez les visuels associés à cette campagne</div>
              </div>
            </div>

            <div class="g-body" id="body-images">
              <button type="button" class="btn btn-outline-dark mb-3" data-toggle="modal" data-target="#modalGestionImages">
                <i class="fa fa-images"></i> Gérer les images
              </button>
              <?php if (!empty($groupe[0]['file'])): ?>
                  <a href="<?= site_url('client/download_fichier/'.$groupe[0]['idcampagne']) ?>"
                    class="btn btn-primary">
                    Télécharger le fichier
                  </a>
              <?php else: ?>
                  <p>Aucun fichier disponible</p>
              <?php endif; ?>

              <div class="card mb-4 d-none" id="propositionImagesCard">
                <div class="card-body">
                  <div class="row no-gutters" id="propositionImagesContainer"></div>
                </div>
              </div>
            </div>
          </div>
       

          <!-- Liens annexes (Sitelinks) -->
          <div class="g-block" id="sec-sitelinks">
            <div class="g-head" data-toggle="#body-sitelinks">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Liens annexes</div>
                <div class="g-sub">Ajoutez jusqu'à 4 sitelinks (texte 25, 2 descriptions 90, URL finale)</div>
              </div>
            </div>
            <div class="g-body" id="body-sitelinks">
              <div id="liens-annexes-container">
                <?php
                  $prefilled = isset($sitelinks) && is_array($sitelinks) && count($sitelinks) ? $sitelinks : [
                    ['title'=>'', 'desc1'=>'', 'desc2'=>'', 'url'=>$groupe[0]['url_site']],
                    ['title'=>'', 'desc1'=>'', 'desc2'=>'', 'url'=>$groupe[0]['url_site']],
                  ];
                  // Limite à 2
                  $prefilled = array_slice($prefilled, 0, 2);
                  foreach ($prefilled as $sl):
                ?>
                <div class="p-2 mb-2 annexe-item" style="background:#f8fafc;border:1px solid #eef2f7;border-radius:8px; position:relative">
                  <button type="button" class="remove-btn">&times;</button>

                  <div class="g-field">
                    <label class="g-label">Texte du lien annexe</label>
                    <input type="text" class="form-control g-input" name="titre_annexe[]" data-max="25" maxlength="25"
                          value="<?= htmlspecialchars($sl['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <span class="g-counter">0/25</span>
                  </div>

                  <div class="g-field">
                    <label class="g-label">Description 1</label>
                    <input type="text" class="form-control g-input" name="desc1_annexe[]" data-max="90" maxlength="90"
                          value="<?= htmlspecialchars($sl['desc1'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <span class="g-counter">0/90</span>
                  </div>

                  <div class="g-field">
                    <label class="g-label">Description 2</label>
                    <input type="text" class="form-control g-input" name="desc2_annexe[]" data-max="90" maxlength="90"
                          value="<?= htmlspecialchars($sl['desc2'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <span class="g-counter">0/90</span>
                  </div>

                  <div class="g-field">
                    <label class="g-label">URL finale</label>
                    <input type="url" class="form-control" name="url_annexe[]"
                          value="<?= htmlspecialchars($sl['url'] ?? $groupe[0]['url_site'], ENT_QUOTES, 'UTF-8') ?>">
                  </div>
                </div>
                <?php endforeach; ?>
              </div>

              <!-- On garde le bouton d’ajout si tu veux monter jusqu’à 4 manuellement -->
              <button type="button" class="g-add" id="add_lien_annexe">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Lien annexe
              </button>
            </div>

          </div>

          <!-- Extensions d'accroche (Callout) -->
          <div class="g-block" id="sec-callout">
            <div class="g-head" data-toggle="#body-callout">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Extensions d'accroche</div>
                <div class="g-sub">Texte court, 25 caractères max</div>
              </div>
            </div>
            <div class="g-body" id="body-callout">
              <div id="accroche-container">
                <div class="g-field">
                  <label class="g-label">Texte de l'accroche</label>
                  <input type="text" class="form-control g-input" name="accroche_annexe[]" data-max="25" maxlength="25">
                  <span class="g-counter">0/25</span>
                  <span class="remove-btn">&times;</span>
                </div>
              </div>
              <button type="button" class="g-add" id="add_accroche">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Accroche
              </button>
            </div>
          </div>

          <!-- Extraits de site (Structured snippets) -->
          <div class="g-block" id="sec-snippet">
            <div class="g-head" data-toggle="#body-snippet">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Extraits de site</div>
                <div class="g-sub">Ajoutez des extraits (25 caractères max chacun)</div>
              </div>
            </div>
            <div class="g-body" id="body-snippet">
              <div id="snippet-container">
                <div class="g-field">
                  <label class="g-label">Extrait</label>
                  <input type="text" class="form-control g-input" name="site_annexe[]" data-max="25" maxlength="25">
                  <span class="g-counter">0/25</span>
                  <span class="remove-btn">&times;</span>
                </div>
              </div>
              <button type="button" class="g-add" id="add_snippet">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Extrait
              </button>
            </div>
          </div>

          <!-- Appelle -->
          <div class="g-block" id="sec-phone">
            <div class="g-head" data-toggle="#body-phone">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Numéro de téléphone</div>
                <div class="g-sub">Ajoutez numéro de téléphone</div>
              </div>
            </div>
            <div class="g-body" id="body-phone">
              <div class="g-field">
                <label class="g-label">Numéro</label>
                <input type="text" class="form-control g-input" name="numero" data-max="25" maxlength="25" placeholder="ex: +33 6 12 34 56 78">
                <span class="g-counter">0/25</span>
              </div>
            </div>
          </div>

          <!-- Adresse -->
          <div class="g-block" id="sec-address">
            <div class="g-head" data-toggle="#body-address">
              <div>
                <div class="g-title"><svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg> Adresse du client</div>
                <div class="g-sub">Entrer adresse du client</div>
              </div>
            </div>
            <div class="g-body" id="body-address">
              <div class="g-field">
                <label class="g-label">Adresse</label>
                <input type="text" class="form-control g-input" name="adresse" data-max="60" maxlength="60" placeholder="ex: 10 Rue de la Paix, 75002 Paris">
                <span class="g-counter">0/60</span>
              </div>
            </div>
          </div>
          <div class="form-group">
							<label>Mots-clés à exclure</label>
							<textarea class="form-control" rows="15" name="Mots_cle_exclus" id="mots_cle_exclus">
							<?= isset($mots_exclus[0]['exclusion']) ? htmlentities($mots_exclus[0]['exclusion']) : '' ?>
						</textarea>
						</div>

          <!-- Preview tableau -->
          <button type="button" class="btn btn-dark btn-sm btn-block mb-3" id="btn-next">Suivant</button>
          <div id="preview-section" class="preview-card mt-4 d-none">
            <h5 class="mb-3" id="preview-anchor">Aperçu de l'annonce</h5>
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
              <tr><th>Numéro</th><td id="preview-numero">Aucun numéro</td></tr>
              <tr><th>Adresse</th><td id="preview-adresse">Aucune adresse</td></tr>
            </table>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-outline-secondary" id="refresh-preview">🔄 Rafraîchir le tableau</button>
              <input type="submit" class="btn btn-dark" value="Terminer">
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Colonne infos (milieu) -->
    <div class="col-12 col-lg-3 px-3 pt-5 order-lg-1">
      <img src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="Google Ads" width="200">
      <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active">Brief de la campagne</a></li></ul>
      <div class="card" style="width: 100%;">
        <div class="card-body"><p class="text-muted"><?= nl2br($groupe[0]['information_campagne']); ?></p></div>
      </div>

      <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active">Société</a></li></ul>
      <div class="card mb-3" style="width: 100%;">
        <div class="card-body"><p class="text-muted"><?= nl2br($donnees[0]['info_base_client']); ?></p></div>
      </div>
    </div>

    <!-- Colonne Téléphone (droite) -->
    <div class="col-12 col-lg-3 px-3 pt-5 order-lg-3 ">
      <div class="card mb-3" style="width: 23rem;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
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
            <span class="mr-2">Date de mise en ligne : <?= htmlentities($d['annonce']) ?></span>
          </div>
          <?php endif; ?>
          <div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
            <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
            <span class="mr-2">Commerciale</span>
            <?php if (!empty($d['am_photo_user'])): ?>
              <img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24" class="ml-2" alt="">
            <?php endif; ?>
          </div>
          <div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
            <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
            <span class="mr-2">Account Manager</span>
            <?php if (!empty($d['tech_photo_user'])): ?>
              <img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24" class="ml-2" alt="">
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="card mb-3 sticky-col" style="width: 100%;" >
        <div class="card-body">
          <h6 class="mb-3">Aperçu mobile</h6>
          <div class="ads-phone">
            <div class="ads-speaker"></div>
            <div class="ads-screen">
              <!-- Bandeau Google (logo + barre de recherche) -->
              <div class="g-phone-header">
                <div style="text-align: center; margin-top: 5px; margin-bottom: 15px;">
                  <img style="text-align: center" alt="google" height="24" class="mx-auto" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBoZWlnaHQ9IjkyIiB2aWV3Qm94PSIwIDAgMjcyIDkyIiB3aWR0aD0iMjcyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0xMTUuNzUgNDcuMThjMCAxMi43Ny05Ljk5IDIyLjE4LTIyLjI1IDIyLjE4cy0yMi4yNS05LjQxLTIyLjI1LTIyLjE4QzcxLjI1IDM0LjMyIDgxLjI0IDI1IDkzLjUgMjVzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NFM4MC45OSAzOS4yIDgwLjk5IDQ3LjE4YzAgNy45IDUuNzkgMTMuNDQgMTIuNTEgMTMuNDRzMTIuNTEtNS41NSAxMi41MS0xMy40NHoiIGZpbGw9IiNFQTQzMzUiLz48cGF0aCBkPSJNMTYzLjc1IDQ3LjE4YzAgMTIuNzctOS45OSAyMi4xOC0yMi4yNSAyMi4xOHMtMjIuMjUtOS40MS0yMi4yNS0yMi4xOGMwLTEyLjg1IDkuOTktMjIuMTggMjIuMjUtMjIuMThzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NHMtMTIuNTEgNS40Ni0xMi41MSAxMy40NGMwIDcuOSA1Ljc5IDEzLjQ0IDEyLjUxIDEzLjQ0czEyLjUxLTUuNTUgMTIuNTEtMTMuNDR6IiBmaWxsPSIjRkJCQzA1Ii8+PHBhdGggZD0iTTIwOS43NSAyNi4zNHYzOS44MmMwIDE2LjM4LTkuNjYgMjMuMDctMjEuMDggMjMuMDctMTAuNzUgMC0xNy4yMi03LjE5LTE5LjY2LTEzLjA3bDguNDgtMy41M2MxLjUxIDMuNjEgNS4yMSA3Ljg3IDExLjE3IDcuODcgNy4zMSAwIDExLjg0LTQuNTEgMTEuODQtMTN2LTMuMTloLS4zNGMtMi4xOCAyLjY5LTYuMzggNS4wNC0xMS42OCA1LjA0LTExLjA5IDAtMjEuMjUtOS42Ni0yMS4yNS0yMi4wOSAwLTEyLjUyIDEwLjE2LTIyLjI2IDIxLjI1LTIyLjI2IDUuMjkgMCA5LjQ5IDIuMzUgMTEuNjggNC45NmguMzR2LTMuNjFoOS4yNXptLTguNTYgMjAuOTJjMC03LjgxLTUuMjEtMTMuNTItMTEuODQtMTMuNTItNi43MiAwLTEyLjM1IDUuNzEtMTIuMzUgMTMuNTIgMCA3LjczIDUuNjMgMTMuMzYgMTIuMzUgMTMuMzYgNi42MyAwIDExLjg0LTUuNjMgMTEuODQtMTMuMzZ6IiBmaWxsPSIjNDI4NUY0Ii8+PHBhdGggZD0iTTIyNSAzdjY1aC05LjVWM2g5LjV6IiBmaWxsPSIjMzRBODUzIi8+PHBhdGggZD0iTTI2Mi4wMiA1NC40OGw3LjU2IDUuMDRjLTIuNDQgMy42MS04LjMyIDkuODMtMTguNDggOS44My0xMi42IDAtMjIuMDEtOS43NC0yMi4wMS0yMi4xOCAwLTEzLjE5IDkuNDktMjIuMTggMjAuOTItMjIuMTggMTEuNTEgMCAxNy4xNCA5LjE2IDE4Ljk4IDE0LjExbDEuMDEgMi41Mi0yOS42NSAxMi4yOGMyLjI3IDQuNDUgNS44IDYuNzIgMTAuNzUgNi43MiA0Ljk2IDAgOC40LTIuNDQgMTAuOTItNi4xNHptLTIzLjI3LTcuOThsMTkuODItOC4yM2MtMS4wOS0yLjc3LTQuMzctNC43LTguMjMtNC43LTQuOTUgMC0xMS44NCA0LjM3LTExLjU5IDEyLjkzeiIgZmlsbD0iI0VBNDMzNSIvPjxwYXRoIGQ9Ik0zNS4yOSA0MS40MVYzMkg2N2MuMzEgMS42NC40NyAzLjU4LjQ3IDUuNjggMCA3LjA2LTEuOTMgMTUuNzktOC4xNSAyMi4wMS02LjA1IDYuMy0xMy43OCA5LjY2LTI0LjAyIDkuNjZDMTYuMzIgNjkuMzUuMzYgNTMuODkuMzYgMzQuOTEuMzYgMTUuOTMgMTYuMzIuNDcgMzUuMy40N2MxMC41IDAgMTcuOTggNC4xMiAyMy42IDkuNDlsLTYuNjQgNi42NGMtNC4wMy0zLjc4LTkuNDktNi43Mi0xNi45Ny02LjcyLTEzLjg2IDAtMjQuNyAxMS4xNy0yNC43IDI1LjAzIDAgMTMuODYgMTAuODQgMjUuMDMgMjQuNyAyNS4wMyA4Ljk5IDAgMTQuMTEtMy42MSAxNy4zOS02Ljg5IDIuNjYtMi42NiA0LjQxLTYuNDYgNS4xLTExLjY1bC0yMi40OS4wMXoiIGZpbGw9IiM0Mjg1RjQiLz48L3N2Zz4=">
                </div>
                <div class="g-phone-search">
                  <span class="g-ico">🔍</span>
                  <input type="text" class="g-phone-input" placeholder="Rechercher sur Google">
                  <span class="g-ico"></span>
                </div>
              </div>
              <div class="ads-g">
                <div style="display: flex">
                  <img src="<?= $donnees[0]['favicon'] ?>" alt="" class="rounded-circle" width="38" height="38">
                  <div>
                    <div style="margin-left: 10px;"><?= htmlentities($d['nom_client']) ?></div>
                    <div class="ads-g-url" id="pp-url" style="margin-left: 10px; margin-top: 5px;">exemple.com</div>
                  </div>
                </div>
                <h3 class="ads-g-title" id="pp-title">Votre titre d'annonce</h3>

                <div id="pp-wrap">
                  <div id="pp-main">
                    <div class="ads-g-desc" id="pp-desc">Votre description s'affiche ici. Rédigez un texte utile, précis et convaincant.</div>
                    <!-- Meta (adresse + téléphone) en full width quand image -->
                    <div class="ads-g-desc pp-full" id="pp-meta" style="display:none"></div>
                    <!-- Sitelinks en full width quand image -->
                    <div class="ads-sitelinks pp-full" id="pp-sitelinks" style="display:none"></div>
                  </div>
                  <div class="ads-sideimg">
                    <img id="pp-image" src="" alt="illustration" style="display:none" />
                  </div>
                </div>

              </div>
            </div>
          </div>
          <small class="text-muted d-block mt-2">Mise à jour en temps réel à la saisie.</small>
        </div>
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
    $(this).closest('.form-group-wrapper, .g-field, .annexe-item').remove();
    setTimeout(updatePhonePreview, 0);
  });

  $('#add_titre').click(() => { $('#titres-container').append(newInput('titres[]')); setTimeout(updatePhonePreview, 0); });
  $('#add_titre_long').click(() => { $('#titres-longs-container').append(newInput('titres_longs[]')); setTimeout(updatePhonePreview, 0); });
  $('#add_description').click(() => { $('#descriptions-container').append(newInput('descriptions[]')); setTimeout(updatePhonePreview, 0); });

  // Liens annexes (ajout max 4 + suppression)
  $('#add_lien_annexe').click(() => {
    const count = $('#liens-annexes-container .annexe-item').length;
    if (count >= 4) return;
    $('#liens-annexes-container').append(`
      <div class="p-2 mb-2 annexe-item" style="background:#f8fafc;border:1px solid #eef2f7;border-radius:8px; position:relative">
        <button type="button" class="btn btn-sm btn-outline-danger remove-annexe" style="position:absolute; right:8px; top:8px">&times;</button>
        <div class="g-field"><label class="g-label">Texte du lien annexe</label><input type="text" class="form-control g-input" name="titre_annexe[]" data-max="25" maxlength="25"><span class="g-counter">0/25</span></div>
        <div class="g-field"><label class="g-label">Description 1</label><input type="text" class="form-control g-input" name="desc1_annexe[]" data-max="90" maxlength="90"><span class="g-counter">0/90</span></div>
        <div class="g-field"><label class="g-label">Description 2</label><input type="text" class="form-control g-input" name="desc2_annexe[]" data-max="90" maxlength="90"><span class="g-counter">0/90</span></div>
        <div class="g-field"><label class="g-label">URL finale</label><input type="url" class="form-control" name="url_annexe[]" placeholder="https://exemple.com/page"></div>
      </div>`);
    setTimeout(() => { bindCounters(); updatePhonePreview(); }, 0);
  });
$(document).on('click', '.remove-annexe', function (e) {
  e.preventDefault();
  e.stopPropagation();
  const $item = $(this).closest('.annexe-item');
  $item.slideUp(120, function(){
    $(this).remove();
    updatePhonePreview();
  });
});



  function newInput(name) {
    let max = 30;
    if (name === 'descriptions[]' || name === 'titres_longs[]') max = 90;
    return `<div class="form-group-wrapper mb-2 g-field">
              <input type="text" class="form-control g-input" data-max="${max}" name="${name}" maxlength="${max}">
              <span class="g-counter">0/${max}</span>
              <span class="remove-btn">&times;</span>
            </div>`;
  }

  /* === Preview (table) === */
  $('#btn-next, #refresh-preview').on('click', function(e) {
    e.preventDefault();
    updateTablePreview();
    const $sec = $('#preview-section');
    if ($sec.hasClass('d-none')) $sec.removeClass('d-none');
    setTimeout(function(){
      const anchor = document.getElementById('preview-anchor') || document.getElementById('preview-section');
      if (!anchor) return;
      anchor.scrollIntoView({behavior:'smooth', block:'start'});
      const top = (anchor.getBoundingClientRect().top + window.pageYOffset) - 100;
      window.scrollTo({ top, behavior: 'smooth' });
    }, 50);
  });

  function updateTablePreview() {
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

    const num = $('input[name="numero"]').val().trim();
    const adr = $('input[name="adresse"]').val().trim();
    $('#preview-numero').text(num || 'Aucun numéro');
    $('#preview-adresse').text(adr || 'Aucune adresse');
  }

  /* === Sections repliables === */
  $(document).on('click', '.g-head', function(e){
    e.stopPropagation();
    const id = $(this).attr('data-toggle');
    const block = $(this).closest('.g-block');
    if (block.hasClass('open')) {
      $(id).slideUp(150, function(){ block.removeClass('open'); });
    } else {
      block.addClass('open');
      $(id).slideDown(150);
    }
  });
  $('.g-block').removeClass('open'); $('.g-body').hide();

  // Compteurs dynamiques
  function bindCounters(){
    $('.g-input').each(function(){
      const input = $(this);
      const max = parseInt(input.attr('data-max')||'0',10);
      const counter = input.siblings('.g-counter');
      const update = () => {
        const len = input.val().length;
        if(counter.length){ counter.text(`${len}/${max}`); counter.toggleClass('bad', max && len>max); }
        input.toggleClass('is-invalid', max && len>max);
      };
      input.off('input._ctr').on('input._ctr', update);
      update();
    });
  }
  bindCounters();

  /* === Aperçu Google Ads en temps réel (mobile) === */
  function hostFrom(url) {
    try { return new URL(url).host.replace(/^www\./,''); } catch { return 'exemple.com'; }
  }
  function buildDisplayUrl() {
    const host = hostFrom($('#url_campagne').val().trim());
    const p1 = $('input[name="chemin1"]').val().trim().replace(/^\//,'');
    const p2 = $('input[name="chemin2"]').val().trim().replace(/^\//,'');
    return [host, p1, p2].filter(Boolean).join('/');
  }
  function getArrayByName(name) {
    return $(`input[name="${name}"]`).map((_,el)=>el.value.trim()).get().filter(v=>v);
  }

  // Sitelinks: on limite à 2 et on n'affiche que le titre + flèche
  function collectSitelinks() {
    const texts = getArrayByName('titre_annexe[]');
    const urls  = getArrayByName('url_annexe[]');
    const items = [];
    for (let i=0; i<texts.length; i++) {
      if (texts[i]) items.push({ text: texts[i], url: urls[i] || '#' });
      if (items.length === 2) break;
    }
    return items;
  }
  function renderSitelinks(list) {
    const wrap = $('#pp-sitelinks').empty();
    if (!list.length) { wrap.hide(); return; }
    list.forEach(it => {
      const row = $('<div/>', { class: 'sl-item' })
        .append($('<a/>', { href: it.url||'#', class:'sl-title', text: it.text }))
        .append($('<span/>', { class:'sl-arrow', text: '›' }));
      wrap.append(row);
    });
    wrap.show();
  }

  // Image: on prend la 1re trouvée
  function firstPreviewImage(){
    return $('#propositionImagesContainer img:first').attr('src')
        || $('#imagePreviewContainer img:first').attr('src')
        || '';
  }

  function updatePhonePreview() {
    // 2 titres max
    const titles = getArrayByName('titres[]');
    const title = titles.slice(0,2).filter(Boolean).join(' | ');
    // 2 descriptions max
    const ds  = getArrayByName('descriptions[]');
    const desc = ds.slice(0,2).filter(Boolean).join(' — ') || "Votre description s'affiche ici. Rédigez un texte utile, précis et convaincant.";

    $('#pp-title').text(title || "Votre titre d'annonce");
    $('#pp-desc').text(desc);
    $('#pp-url').text(buildDisplayUrl());

    // Meta : adresse + téléphone (même style, séparateur " · ")
    const phone = $('input[name="numero"]').val().trim();
    const address = $('input[name="adresse"]').val().trim();
    if (address || phone) {
      let meta = '';
      if (address) meta += address;
      if (address && phone) meta += ' · ';
      if (phone) meta += phone;
      $('#pp-meta').text(meta).show();
    } else {
      $('#pp-meta').hide();
    }

    // Image: split 2/3–1/3 + meta & sitelinks en full width
    const img = firstPreviewImage();
    if (img) {
      $('#pp-image').attr('src', img).show();
      $('#pp-wrap').addClass('ads-split');
    } else {
      $('#pp-image').hide();
      $('#pp-wrap').removeClass('ads-split');
    }

    renderSitelinks(collectSitelinks());
  }

  // Saisie -> preview en temps réel
  $(document).on('input',
    'input[name="titres[]"], input[name="descriptions[]"], input[name="chemin1"], input[name="chemin2"], input[name="titre_annexe[]"], input[name="desc1_annexe[]"], input[name="desc2_annexe[]"], input[name="url_annexe[]"], input[name="accroche_annexe[]"], input[name="site_annexe[]"], input[name="numero"], input[name="adresse"], #url_campagne',
    function(){ bindCounters(); updatePhonePreview(); }
  );

  // Initial
  updatePhonePreview();

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
        updatePhonePreview();
      }
    }, 'json');
  }

  imagePreviewContainer.on('click', '.remove-image-btn', function() {
    $(this).closest('.image-item').remove();
    updatePhonePreview();
  });

  $('#addImageUrlBtn').click(function() {
    const url = $('#imageUrlInput').val().trim();
    if (!/^https?:\/\//i.test(url)) return alert('URL invalide');
    imagePreviewContainer.append(createImageItem(url));
    $('#imageUrlInput').val('');
    updatePhonePreview();
  });

  $('#saveImagesBtn').click(function() {
    let images = imagePreviewContainer.find('img').map((_,img)=>img.src).get();
    let data = { idcampagne, idclient, images };
    data[csrfName] = csrfHash;

    $.post(saveImagesUrl, data, function(resp) {
      if (resp.success) {
        updatePropositionImages(images);
        $('#modalGestionImages').modal('hide');
        updatePhonePreview();
      } else {
        alert(resp.message || 'Erreur lors de l’enregistrement');
      }
    }, 'json');
  });

  loadImages();

  /* Accroche: ajout/suppression */
  $('#add_accroche').click(() => {
    $('#accroche-container').append(
      `<div class="g-field">
         <label class="g-label">Texte de l'accroche</label>
         <input type="text" class="form-control g-input" name="accroche_annexe[]" data-max="25" maxlength="25">
         <span class="g-counter">0/25</span>
         <span class="remove-btn">&times;</span>
       </div>`
    );
    bindCounters();
  });

  /* Extraits de site: ajout/suppression */
  $('#add_snippet').click(() => {
    $('#snippet-container').append(
      `<div class="g-field">
         <label class="g-label">Extrait</label>
         <input type="text" class="form-control g-input" name="site_annexe[]" data-max="25" maxlength="25">
         <span class="g-counter">0/25</span>
         <span class="remove-btn">&times;</span>
       </div>`
    );
    bindCounters();
  });

});
</script>
<?php end_section(); ?>
</body>
</html>
