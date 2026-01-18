<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifier l'annonce – Vue CI3 (style création)</title>
  <?php start_section('stylesheet') ?>
  <style>
    /* ===== Base ===== */
    .remove-btn{cursor:pointer;color:black;font-weight:bold;font-size:18px;position:absolute;right:10px;top:8px}
    .form-group-wrapper{position:relative}
    .preview-card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.05)}
    #preview-section{transition:opacity .4s ease-in-out;opacity:0}
    #preview-section:not(.d-none){opacity:1}
    html{scroll-behavior:smooth}

    /* ===== Sections repliables (style Google Ads) ===== */
    .g-block{border:1px solid #e5e7eb;border-radius:8px;background:#fff;margin-bottom:14px}
    .g-head{display:flex;align-items:center;justify-content:space-between;gap:8px;padding:12px 14px;cursor:pointer}
    .g-head:hover{background:#f8fafc}
    .g-title{display:flex;align-items:center;gap:8px;font-weight:600}
    .g-sub{font-size:12px;color:#64748b}
    .g-arrow{transition:transform .2s ease}
    .g-body{padding:14px;border-top:1px solid #eef2f7;display:none;background:#fafbff}
    .g-block.open .g-body{display:block}
    .g-block.open .g-arrow{transform:rotate(180deg)}
    .g-add{display:inline-flex;align-items:center;gap:6px;color:#1a73e8;font-weight:600;text-decoration:none;background:transparent;border:0;padding:0;cursor:pointer}
    .g-add:hover{color:#174ea6;text-decoration:underline}

    /* Compteurs */
    .g-field{position:relative;margin-bottom:10px}
    .g-counter{position:absolute;right:8px;bottom:-18px;font-size:12px;color:#64748b}
    .g-counter.bad{color:#d93025}
    .g-label{font-weight:600;margin-bottom:4px}

    /* Colonne sticky droite */
    .sticky-col{position:sticky;top:20px;align-self:flex-start;max-height:calc(100vh - 40px);overflow:auto}

    /* ===== Téléphone (Google like) ===== */
    .ads-phone{position:relative;margin:4px auto 0;width:340px;height:640px;border-radius:28px;border:1px solid #e5e7eb;background:#ffffff;box-shadow:0 10px 25px rgba(2,8,23,.12)}
    .ads-speaker{position:absolute;left:50%;transform:translateX(-50%);top:10px;width:80px;height:5px;border-radius:3px;background:#e5e7eb}
    .ads-screen{position:absolute;inset:34px 12px 14px;border-radius:22px;background:#ffffff;overflow:auto;border:1px solid #eef2f7}
    .g-phone-header{position:sticky;top:0;background:#fff;border-bottom:1px solid #eef2f7;padding:10px 10px 12px;z-index:5}
    .g-phone-search{display:flex;align-items:center;gap:8px;border:1px solid #e5e7eb;border-radius:20px;padding:6px 10px}
    .g-phone-input{border:0;outline:none;flex:1}
    .g-ico{font-size:14px;opacity:.6}

    .ads-g{padding:14px;border-bottom:1px solid #f1f5f9}
    .ads-g-url{font-size:12px;color:#1e8e3e;margin-bottom:6px}
    .ads-g-title{font-size:16px;line-height:1.3;margin:0 0 6px;color:#1a0dab}
    .ads-g-desc{font-size:13px;color:#202124}

    /* ===== Layout 2/3 – 1/3 si image ===== */
    #pp-wrap{display:block}
    #pp-wrap.ads-split{display:grid;grid-template-columns:2fr 1fr;gap:12px;align-items:start}
    .ads-sideimg img{width:100%;height:auto;max-height:160px;border-radius:8px;object-fit:cover}
    .ads-split .pp-full{grid-column:1 / -1} /* meta + sitelinks full width quand image */

    /* ===== Sitelinks (2 max, titre seul + flèche) ===== */
    .ads-sitelinks{display:grid;grid-template-columns:1fr;gap:10px;margin-top:10px}
    .sl-item{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border:1px dashed #e5e7eb;border-radius:10px}
    .sl-title{color:#1a0dab;text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .sl-arrow{font-size:16px;opacity:.6}
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
  background:#fff;
  border:1px solid #e5e7eb;
  cursor:pointer;
  z-index:10;            /* <— évite qu'un élément passe par-dessus */
  user-select:none;
}
.remove-btn:hover{ background:#f8fafc; }
.remove-btn:active{ transform:scale(0.96); }
.remove-btn:focus{ outline:2px solid #cbd5e1; outline-offset:2px; }

  </style>
  <?php end_section(); ?>
</head>
<body>
<?php start_section('content'); ?>

<div class="container-fluid pt-3">
  <div class="row">

    <!-- Colonne Formulaire -->
    <div class="col-12 col-lg-6 order-lg-2">
      <form action="<?= base_url('Client/update_annonce') ?>" method="POST" enctype="multipart/form-data">
        <div class="container-fluid pt-2">
          <h5>Modifier l’annonce (Search)</h5>
          <hr class="my-3">

          <input type="hidden" name="idgroupe_annonce" value="<?= (int)$groupe[0]['idgroupe_annonce'] ?>">
          <input type="hidden" name="idcampagne" value="<?= (int)$groupe[0]['idcampagne'] ?>">
          <input type="hidden" name="idclients" value="<?= (int)$groupe[0]['idclients'] ?>">

          <div class="form-group">
            <label>Nom de l’entreprise</label>
            <input type="text" class="form-control" name="nom_entreprise" value="<?= htmlspecialchars($donnees[0]['nom_client'] ?? '') ?>">
          </div>

          <div class="form-group">
            <label>URL de la campagne</label>
            <input type="text" class="form-control" name="url_campagne" id="url_campagne" value="<?= htmlspecialchars($campagne['url_site'] ?? ($groupe[0]['url_groupe_annonce'] ?? '')) ?>">
          </div>

          <div class="form-group">
            <label>Mot clé</label>
            <textarea rows="6" type="text" class="form-control" name="mot_cle"><?= $groupe[0]['mot_cle'] ?></textarea>
          </div>

          <!-- Titres -->
          <div class="g-block" id="sec-titres">
            <div class="g-head" data-toggle="#body-titres">
              <div>
                <div class="g-title">
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  Titres
                </div>
                <div class="g-sub">Jusqu’à 15 titres (30 caractères max)</div>
              </div>
            </div>
            <div class="g-body" id="body-titres">
              <div id="titres-container">
                <?php foreach (($ads_titres ?? []) as $t): ?>
                <div class="form-group-wrapper g-field">
                  <label class="g-label">Titre</label>
                  <input type="text" class="form-control g-input" name="titres[]" data-max="30" maxlength="30" value="<?= htmlspecialchars($t) ?>">
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
                <div class="g-title">
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  Titres longs
                </div>
                <div class="g-sub">Jusqu’à 5 titres longs (90 caractères max)</div>
              </div>
            </div>
            <div class="g-body" id="body-titres-longs">
              <div id="titres-longs-container">
                <?php foreach (($ads_titres_longs ?? []) as $tl): ?>
                <div class="form-group-wrapper g-field">
                  <label class="g-label">Titre long</label>
                  <input type="text" class="form-control g-input" name="titres_longs[]" data-max="90" maxlength="90" value="<?= htmlspecialchars($tl) ?>">
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
                <div class="g-title">
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  Descriptions
                </div>
                <div class="g-sub">Jusqu’à 4 descriptions (90 caractères max)</div>
              </div>
            </div>
            <div class="g-body" id="body-descriptions">
              <div id="descriptions-container">
                <?php foreach (($ads_descriptions ?? []) as $dsc): ?>
                <div class="form-group-wrapper g-field">
                  <label class="g-label">Description</label>
                  <input type="text" class="form-control g-input" name="descriptions[]" data-max="90" maxlength="90" value="<?= htmlspecialchars($dsc) ?>">
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
            <div class="g-sub">Personnalisez l’URL affichée (2 champs max)</div>
          </div>
        </div>

        <div class="g-body" id="body-chemins">
          <div class="g-field">
            <label class="g-label">Chemin 1</label>
            <input type="text" class="form-control" name="chemin1"
                  maxlength="15" placeholder="ex : services"
                  value="<?= htmlspecialchars($groupe[0]['chemin1'] ?? '') ?>">
          </div>

          <div class="g-field">
            <label class="g-label">Chemin 2</label>
            <input type="text" class="form-control" name="chemin2"
                  maxlength="15" placeholder="ex : tarifs"
                  value="<?= htmlspecialchars($groupe[0]['chemin2'] ?? '') ?>">
          </div>
        </div>
      </div>


          <!-- Tiroir Proposition d’images -->
        <div class="g-block" id="sec-images">
          <div class="g-head" data-toggle="#body-images">
            <div>
              <div class="g-title">
                <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                Proposition d’images
              </div>
              <div class="g-sub">Ajoutez/éditez les visuels utilisés par la campagne</div>
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
            <div class="card mb-4 <?= empty($images) ? 'd-none' : '' ?>" id="propositionImagesCard">
              <div class="card-body">
                <div class="row no-gutters" id="propositionImagesContainer">
                  <?php if (!empty($images)): foreach ($images as $im): ?>
                    <div class="col-auto px-2 mb-3">
                      <img src="<?= htmlspecialchars($im['image_url']) ?>" width="120" class="rounded border" style="object-fit:cover;">
                    </div>
                  <?php endforeach; endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>


          <!-- Liens annexes -->
          <div class="g-block" id="sec-sitelinks">
            <div class="g-head" data-toggle="#body-sitelinks">
              <div>
                <div class="g-title">
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  Liens annexes
                </div>
                <div class="g-sub">Texte 25, 2 descriptions 90, URL finale</div>
              </div>
            </div>
            <div class="g-body" id="body-sitelinks">
              <div id="liens-annexes-container">
                <?php if (!empty($extensions)): foreach ($extensions as $ext): ?>
                  <div class="p-2 mb-2 annexe-item" style="background:#f8fafc;border:1px solid #eef2f7;border-radius:8px;position:relative">
                    <span class="remove-btn remove-annexe" role="button" tabindex="0" aria-label="Supprimer">&times;</span>

                    <div class="g-field"><label class="g-label">Texte du lien annexe</label><input type="text" class="form-control g-input" name="titre_annexe[]" data-max="25" maxlength="25" value="<?= htmlspecialchars($ext['titre_lien_annexe']) ?>"><span class="g-counter">0/25</span></div>
                    <div class="g-field"><label class="g-label">Description 1</label><input type="text" class="form-control g-input" name="desc1_annexe[]" data-max="90" maxlength="90" value="<?= htmlspecialchars($ext['description1_lien_annexe']) ?>"><span class="g-counter">0/90</span></div>
                    <div class="g-field"><label class="g-label">Description 2</label><input type="text" class="form-control g-input" name="desc2_annexe[]" data-max="90" maxlength="90" value="<?= htmlspecialchars($ext['description2_lien_annexe']) ?>"><span class="g-counter">0/90</span></div>
                    <div class="g-field"><label class="g-label">URL finale</label><input type="url" class="form-control" name="url_annexe[]" value="<?= htmlspecialchars($ext['url_lien_annexe']) ?>"></div>
                  </div>
                <?php endforeach; else: ?>
                  <div class="p-2 mb-2 annexe-item" style="background:#f8fafc;border:1px solid #eef2f7;border-radius:8px;position:relative">
                    <span class="remove-btn remove-annexe" role="button" tabindex="0" aria-label="Supprimer">&times;</span>

                    <div class="g-field"><label class="g-label">Texte du lien annexe</label><input type="text" class="form-control g-input" name="titre_annexe[]" data-max="25" maxlength="25"><span class="g-counter">0/25</span></div>
                    <div class="g-field"><label class="g-label">Description 1</label><input type="text" class="form-control g-input" name="desc1_annexe[]" data-max="90" maxlength="90"><span class="g-counter">0/90</span></div>
                    <div class="g-field"><label class="g-label">Description 2</label><input type="text" class="form-control g-input" name="desc2_annexe[]" data-max="90" maxlength="90"><span class="g-counter">0/90</span></div>
                    <div class="g-field"><label class="g-label">URL finale</label><input type="url" class="form-control" name="url_annexe[]" placeholder="https://exemple.com/page"></div>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="g-add" id="add_lien_annexe">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Lien annexe
              </button>
            </div>
          </div>

          <!-- Extensions d’accroche -->
          <div class="g-block" id="sec-callout">
            <div class="g-head" data-toggle="#body-callout">
              <div>
                <div class="g-title">
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  Extensions d’accroche
                </div>
                <div class="g-sub">Texte court, 25 caractères max</div>
              </div>
            </div>
            <div class="g-body" id="body-callout">
              <div id="accroche-container">
                <?php if (!empty($accroches)): foreach ($accroches as $acc): ?>
                  <div class="g-field">
                    <label class="g-label">Texte de l’accroche</label>
                    <input type="text" class="form-control g-input" name="accroche_annexe[]" data-max="25" maxlength="25" value="<?= htmlspecialchars($acc['texte_extension_accroche']) ?>">
                    <span class="g-counter">0/25</span>
                    <span class="remove-btn">&times;</span>
                  </div>
                <?php endforeach; else: ?>
                  <div class="g-field">
                    <label class="g-label">Texte de l’accroche</label>
                    <input type="text" class="form-control g-input" name="accroche_annexe[]" data-max="25" maxlength="25">
                    <span class="g-counter">0/25</span>
                    <span class="remove-btn">&times;</span>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="g-add" id="add_accroche">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Accroche
              </button>
            </div>
          </div>

          <!-- Extraits de site -->
          <div class="g-block" id="sec-snippet">
            <div class="g-head" data-toggle="#body-snippet">
              <div>
                <div class="g-title">
                  <svg width="16" height="16" class="g-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  Extraits de site
                </div>
                <div class="g-sub">25 caractères max chacun</div>
              </div>
            </div>
            <div class="g-body" id="body-snippet">
              <div id="snippet-container">
                <?php if (!empty($extraits)): foreach ($extraits as $snip): ?>
                  <div class="g-field">
                    <label class="g-label">Extrait</label>
                    <input type="text" class="form-control g-input" name="site_annexe[]" data-max="25" maxlength="25" value="<?= htmlspecialchars($snip['texte_extrait_de_site']) ?>">
                    <span class="g-counter">0/25</span>
                    <span class="remove-btn">&times;</span>
                  </div>
                <?php endforeach; else: ?>
                  <div class="g-field">
                    <label class="g-label">Extrait</label>
                    <input type="text" class="form-control g-input" name="site_annexe[]" data-max="25" maxlength="25">
                    <span class="g-counter">0/25</span>
                    <span class="remove-btn">&times;</span>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="g-add" id="add_snippet">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Extrait
              </button>
            </div>
          </div>

          <!-- Téléphone & Adresse -->
          <div class="g-field">
            <label class="g-label">Numéro</label>
            <input
              type="text"
              class="form-control g-input"
              name="numero"
              data-max="25"
              maxlength="25"
              placeholder="ex: +33 6 12 34 56 78"
              value="<?= htmlspecialchars($campagne['numero'] ?? ($groupe[0]['numero'] ?? '')) ?>"
            >
            <span class="g-counter">0/25</span>
          </div>
          <div class="g-field">
            <label class="g-label">Adresse</label>
            <input
              type="text"
              class="form-control g-input"
              name="adresse"
              data-max="60"
              maxlength="60"
              placeholder="ex: 10 Rue de la Paix, 75002 Paris"
              value="<?= htmlspecialchars($campagne['adresse'] ?? ($groupe[0]['adresse'] ?? '')) ?>"
            >
            <span class="g-counter">0/60</span>
          </div>

          <!-- Boutons -->
          <button type="button" class="btn btn-dark btn-sm btn-block mb-3" id="btn-next">Suivant</button>
          <div id="preview-section" class="preview-card mt-4 d-none">
            <h5 class="mb-3" id="preview-anchor">Aperçu de l’annonce</h5>
            <table class="table table-bordered">
              <tr><th>Campagne</th><td><?= htmlspecialchars($campagne['nom_campagne'] ?? '') ?></td></tr>
              <tr><th>Groupe d’annonce</th><td><?= htmlspecialchars($groupe[0]['nom_groupe'] ?? '') ?></td></tr>
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
              <input type="submit" class="btn btn-dark" value="Enregistrer">
            </div>
          </div>

        </div>
      </form>
    </div>

    <!-- Colonne infos -->
    <div class="col-12 col-lg-3 px-3 pt-4 order-lg-1">
      <img src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="Google Ads" width="200">
      <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active">Brief de la campagne</a></li></ul>
      <div class="card mb-3"><div class="card-body">
        <p class="text-muted"><?= nl2br(htmlspecialchars($donnees[0]['information_client'] ?? ($campagne['information_campagne'] ?? ''))) ?></p>
      </div></div>
      <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active">Société</a></li></ul>
      <div class="card"><div class="card-body">
        <p class="text-muted"><?= nl2br(htmlspecialchars($donnees[0]['info_base_client'] ?? '')) ?></p>
      </div></div>
    </div>

    <!-- Colonne Aperçu mobile -->
    <div class="col-12 col-lg-3 px-3 pt-4 order-lg-3 sticky-col">
      <div class="card mb-3" style="width: 23rem;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
              <?= isset($donnees[0]['budget']) ? htmlentities($donnees[0]['budget']) : '' ?> €
            </button>
          </div>
          <br><br>
          <?php if (!empty($donnees[0]['mis_en_place_paiement'])): ?>
          <div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
            <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
            <span class="mr-2">Date d'anniversaire : <?= htmlentities($donnees[0]['mis_en_place_paiement']) ?></span>
          </div>
          <?php endif; ?>
          <?php if (!empty($donnees[0]['annonce'])): ?>
          <div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
            <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
            <span class="mr-2">Date de mise en ligne : <?= htmlentities($donnees[0]['annonce']) ?></span>
          </div>
          <?php endif; ?>
          <div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
            <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
            <span class="mr-2">Commerciale</span>
            <?php if (!empty($donnees[0]['am_photo_user'])): ?>
              <img src="<?= base_url('assets/images/' . $donnees[0]['am_photo_user']) ?>" width="24" height="24" class="ml-2" alt="">
            <?php endif; ?>
          </div>
          <div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
            <i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
            <span class="mr-2">Account Manager</span>
            <?php if (!empty($donnees[0]['tech_photo_user'])): ?>
              <img src="<?= base_url('assets/images/' . $donnees[0]['tech_photo_user']) ?>" width="24" height="24" class="ml-2" alt="">
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="card mb-3" style="width:100%">
        <div class="card-body">
          <h6 class="mb-3">Aperçu mobile</h6>
          <div class="ads-phone">
            <div class="ads-speaker"></div>
            <div class="ads-screen">
              <div class="g-phone-header">
                  <div style="text-align: center; margin-top: 5px; margin-bottom: 15px;">
                  <img style="text-align: center" alt="google" height="24" class="mx-auto" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBoZWlnaHQ9IjkyIiB2aWV3Qm94PSIwIDAgMjcyIDkyIiB3aWR0aD0iMjcyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0xMTUuNzUgNDcuMThjMCAxMi43Ny05Ljk5IDIyLjE4LTIyLjI1IDIyLjE4cy0yMi4yNS05LjQxLTIyLjI1LTIyLjE4QzcxLjI1IDM0LjMyIDgxLjI0IDI1IDkzLjUgMjVzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NFM4MC45OSAzOS4yIDgwLjk5IDQ3LjE4YzAgNy45IDUuNzkgMTMuNDQgMTIuNTEgMTMuNDRzMTIuNTEtNS41NSAxMi41MS0xMy40NHoiIGZpbGw9IiNFQTQzMzUiLz48cGF0aCBkPSJNMTYzLjc1IDQ3LjE4YzAgMTIuNzctOS45OSAyMi4xOC0yMi4yNSAyMi4xOHMtMjIuMjUtOS40MS0yMi4yNS0yMi4xOGMwLTEyLjg1IDkuOTktMjIuMTggMjIuMjUtMjIuMThzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NHMtMTIuNTEgNS40Ni0xMi41MSAxMy40NGMwIDcuOSA1Ljc5IDEzLjQ0IDEyLjUxIDEzLjQ0czEyLjUxLTUuNTUgMTIuNTEtMTMuNDR6IiBmaWxsPSIjRkJCQzA1Ii8+PHBhdGggZD0iTTIwOS43NSAyNi4zNHYzOS44MmMwIDE2LjM4LTkuNjYgMjMuMDctMjEuMDggMjMuMDctMTAuNzUgMC0xNy4yMi03LjE5LTE5LjY2LTEzLjA3bDguNDgtMy41M2MxLjUxIDMuNjEgNS4yMSA3Ljg3IDExLjE3IDcuODcgNy4zMSAwIDExLjg0LTQuNTEgMTEuODQtMTN2LTMuMTloLS4zNGMtMi4xOCAyLjY5LTYuMzggNS4wNC0xMS42OCA1LjA0LTExLjA5IDAtMjEuMjUtOS42Ni0yMS4yNS0yMi4wOSAwLTEyLjUyIDEwLjE2LTIyLjI2IDIxLjI1LTIyLjI2IDUuMjkgMCA5LjQ5IDIuMzUgMTEuNjggNC45NmguMzR2LTMuNjFoOS4yNXptLTguNTYgMjAuOTJjMC03LjgxLTUuMjEtMTMuNTItMTEuODQtMTMuNTItNi43MiAwLTEyLjM1IDUuNzEtMTIuMzUgMTMuNTIgMCA3LjczIDUuNjMgMTMuMzYgMTIuMzUgMTMuMzYgNi42MyAwIDExLjg0LTUuNjMgMTEuODQtMTMuMzZ6IiBmaWxsPSIjNDI4NUY0Ii8+PHBhdGggZD0iTTIyNSAzdjY1aC05LjVWM2g5LjV6IiBmaWxsPSIjMzRBODUzIi8+PHBhdGggZD0iTTI2Mi4wMiA1NC40OGw3LjU2IDUuMDRjLTIuNDQgMy42MS04LjMyIDkuODMtMTguNDggOS44My0xMi42IDAtMjIuMDEtOS43NC0yMi4wMS0yMi4xOCAwLTEzLjE5IDkuNDktMjIuMTggMjAuOTItMjIuMTggMTEuNTEgMCAxNy4xNCA5LjE2IDE4Ljk4IDE0LjExbDEuMDEgMi41Mi0yOS42NSAxMi4yOGMyLjI3IDQuNDUgNS44IDYuNzIgMTAuNzUgNi43MiA0Ljk2IDAgOC40LTIuNDQgMTAuOTItNi4xNHptLTIzLjI3LTcuOThsMTkuODItOC4yM2MtMS4wOS0yLjc3LTQuMzctNC43LTguMjMtNC43LTQuOTUgMC0xMS44NCA0LjM3LTExLjU5IDEyLjkzeiIgZmlsbD0iI0VBNDMzNSIvPjxwYXRoIGQ9Ik0zNS4yOSA0MS40MVYzMkg2N2MuMzEgMS42NC40NyAzLjU4LjQ3IDUuNjggMCA3LjA2LTEuOTMgMTUuNzktOC4xNSAyMi4wMS02LjA1IDYuMy0xMy43OCA5LjY2LTI0LjAyIDkuNjZDMTYuMzIgNjkuMzUuMzYgNTMuODkuMzYgMzQuOTEuMzYgMTUuOTMgMTYuMzIuNDcgMzUuMy40N2MxMC41IDAgMTcuOTggNC4xMiAyMy42IDkuNDlsLTYuNjQgNi42NGMtNC4wMy0zLjc4LTkuNDktNi43Mi0xNi45Ny02LjcyLTEzLjg2IDAtMjQuNyAxMS4xNy0yNC43IDI1LjAzIDAgMTMuODYgMTAuODQgMjUuMDMgMjQuNyAyNS4wMyA4Ljk5IDAgMTQuMTEtMy42MSAxNy4zOS02Ljg5IDIuNjYtMi42NiA0LjQxLTYuNDYgNS4xLTExLjY1bC0yMi40OS4wMXoiIGZpbGw9IiM0Mjg1RjQiLz48L3N2Zz4=">
                </div>
                <div class="g-phone-search">
                  <span class="g-ico">🔍</span>
                  <input type="text" class="g-phone-input" placeholder="Rechercher sur Google">
                  <span class="g-ico">🎤</span>
                </div>
              </div>

              <div class="ads-g">
                <div style="display:flex;align-items:center;gap:10px">
                  <img src="<?= htmlspecialchars($donnees[0]['favicon'] ?? '') ?>" alt="" class="rounded-circle" width="38" height="38">
                  <div>
                    <div><?= htmlspecialchars($donnees[0]['nom_client'] ?? '') ?></div>
                    <div class="ads-g-url" id="pp-url" style="margin-top:5px;">exemple.com</div>
                  </div>
                </div>

                <h3 class="ads-g-title" id="pp-title">Votre titre d’annonce</h3>

                <div id="pp-wrap">
                  <div id="pp-main">
                    <div class="ads-g-desc" id="pp-desc">Votre description s’affiche ici. Rédigez un texte utile, précis et convaincant.</div>
                    <!-- Meta (adresse + téléphone) en pleine largeur quand image -->
                    <div class="ads-g-desc pp-full" id="pp-meta" style="display:none"></div>
                    <!-- Sitelinks en pleine largeur quand image -->
                    <div class="ads-sitelinks pp-full" id="pp-sitelinks" style="display:none"></div>
                  </div>
                  <div class="ads-sideimg">
                    <img id="pp-image" src="" alt="illustration" style="display:none" />
                  </div>
                </div>

              </div>
            </div>
          </div>
          <small class="text-muted d-block mt-2">Mise à jour en temps réel.</small>
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
        <div id="imagePreviewContainer" class="d-flex flex-wrap">
          <?php if (!empty($images)): foreach ($images as $im): ?>
            <div class="position-relative m-2 image-item">
              <img src="<?= htmlspecialchars($im['image_url']) ?>" width="120" height="120" class="rounded border" style="object-fit:cover;">
              <button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top:2px;right:2px;">&times;</button>
            </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-dark" id="saveImagesBtn">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
$(function(){

  /* ===== Toggle sections ===== */
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

  /* ===== Compteurs ===== */
  function bindCounters(){
    $('.g-input').each(function(){
      const $i=$(this), max=parseInt($i.attr('data-max')||'0',10), $c=$i.siblings('.g-counter');
      const update=()=>{ const len=$i.val().length; $c.text(`${len}/${max}`); $c.toggleClass('bad', max && len>max); $i.toggleClass('is-invalid', max && len>max); };
      $i.off('input._ctr').on('input._ctr', update); update();
    });
  }
  bindCounters();

  /* ===== Helpers ===== */
  const getArr = (name)=>$(`input[name="${name}"]`).map((_,el)=>el.value.trim()).get().filter(Boolean);
  function hostFrom(url){ try{ return new URL(url).host.replace(/^www\./,''); } catch { return 'exemple.com'; } }
  function buildDisplayUrl(){
    const host = hostFrom($('#url_campagne').val().trim());
    const p1 = $('input[name="chemin1"]').val().trim().replace(/^\//,'');
    const p2 = $('input[name="chemin2"]').val().trim().replace(/^\//,'');
    return [host,p1,p2].filter(Boolean).join('/');
  }

  /* ===== Sitelinks: 2 max, titre + flèche ===== */
  function collectSitelinks() {
    const texts = getArr('titre_annexe[]');
    const urls  = getArr('url_annexe[]');
    const items = [];
    for (let i=0;i<texts.length;i++) {
      if (texts[i]) items.push({ text: texts[i], url: urls[i] || '#' });
      if (items.length === 2) break;
    }
    return items;
  }
  function renderSitelinks(list) {
    const wrap = $('#pp-sitelinks').empty();
    if (!list || !list.length) { wrap.hide(); return; }
    list.forEach(it => {
      const row = $('<div/>', { class: 'sl-item' })
        .append($('<a/>', { href: it.url || '#', class:'sl-title', text: it.text }))
        .append($('<span/>', { class:'sl-arrow', text: '›' }));
      wrap.append(row);
    });
    wrap.show();
  }

  /* ===== Image: 1re image trouvée ===== */
  function firstPreviewImage(){
    return $('#propositionImagesContainer img:first').attr('src')
        || $('#imagePreviewContainer img:first').attr('src')
        || '';
  }

  /* ===== Aperçu (meta adresse · téléphone) ===== */
  function updatePhonePreview() {
    // 2 titres + 2 descriptions
    const titles = getArr('titres[]');
    const title = titles.slice(0,2).filter(Boolean).join(' | ');

    const ds  = getArr('descriptions[]');
    const desc = (ds.slice(0,2).filter(Boolean).join(' — '))
               || "Votre description s’affiche ici. Rédigez un texte utile, précis et convaincant.";

    $('#pp-title').text(title || "Votre titre d’annonce");
    $('#pp-desc').text(desc);
    $('#pp-url').text(buildDisplayUrl());

    // Meta (adresse · téléphone)
    const phone = $('input[name="numero"]').val().trim();
    const address = $('input[name="adresse"]').val().trim();
    if (address || phone) {
      const parts = [];
      if (address) parts.push(address);
      if (phone)   parts.push(phone);
      $('#pp-meta').text(parts.join(' · ')).show();
    } else {
      $('#pp-meta').hide();
    }

    // Image split 2/3–1/3
    const img = firstPreviewImage();
    if (img) { $('#pp-image').attr('src', img).show(); $('#pp-wrap').addClass('ads-split'); }
    else     { $('#pp-image').hide();                 $('#pp-wrap').removeClass('ads-split'); }

    // Sitelinks
    renderSitelinks(collectSitelinks());
  }

  /* ===== Ajout/Suppression champs ===== */
  $('#add_titre').click(()=>{ $('#titres-container').append(fieldTpl('titres[]',30)); bindCounters(); updatePhonePreview(); });
  $('#add_titre_long').click(()=>{ $('#titres-longs-container').append(fieldTpl('titres_longs[]',90)); bindCounters(); });
  $('#add_description').click(()=>{ $('#descriptions-container').append(fieldTpl('descriptions[]',90)); bindCounters(); updatePhonePreview(); });

  $('#add_lien_annexe').click(()=>{ $('#liens-annexes-container').append(annexeTpl()); bindCounters(); updatePhonePreview(); });
// Handler spécifique ANNEXE — supprime le bloc entier
$(document).on('click keydown', '.remove-annexe', function (e) {
  if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
  e.preventDefault();
  e.stopPropagation();
  e.stopImmediatePropagation(); // <— important !
  const $item = $(this).closest('.annexe-item');
  $item.slideUp(120, function(){
    $(this).remove();
    updatePhonePreview();
  });
});

// Handler générique — ignorer si c'est une annexe
$(document).on('click', '.remove-btn', function(e){
  if ($(this).hasClass('remove-annexe')) return; // déjà géré ci-dessus
  $(this).closest('.form-group-wrapper, .g-field').remove();
  updatePhonePreview();
});



  $('#add_accroche').click(()=>{ $('#accroche-container').append(accrocheTpl()); bindCounters(); });
  $('#add_snippet').click(()=>{ $('#snippet-container').append(snippetTpl()); bindCounters(); });

  $(document).on('click','.remove-btn',function(){
    $(this).closest('.form-group-wrapper, .g-field').remove();
    updatePhonePreview();
  });

  function fieldTpl(name,max){
    return `<div class="form-group-wrapper g-field">
              <input type="text" class="form-control g-input" name="${name}" data-max="${max}" maxlength="${max}">
              <span class="g-counter">0/${max}</span>
              <span class="remove-btn">&times;</span>
            </div>`;
  }
function annexeTpl(){
  return `<div class="p-2 mb-2 annexe-item" style="background:#f8fafc;border:1px solid #eef2f7;border-radius:8px;position:relative">
            <span class="remove-btn remove-annexe" role="button" tabindex="0" aria-label="Supprimer">&times;</span>
            <div class="g-field"><label class="g-label">Texte du lien annexe</label><input type="text" class="form-control g-input" name="titre_annexe[]" data-max="25" maxlength="25"><span class="g-counter">0/25</span></div>
            <div class="g-field"><label class="g-label">Description 1</label><input type="text" class="form-control g-input" name="desc1_annexe[]" data-max="90" maxlength="90"><span class="g-counter">0/90</span></div>
            <div class="g-field"><label class="g-label">Description 2</label><input type="text" class="form-control g-input" name="desc2_annexe[]" data-max="90" maxlength="90"><span class="g-counter">0/90</span></div>
            <div class="g-field"><label class="g-label">URL finale</label><input type="url" class="form-control" name="url_annexe[]" placeholder="https://exemple.com/page"></div>
          </div>`;
}

  function accrocheTpl(){
    return `<div class="g-field">
              <label class="g-label">Texte de l’accroche</label>
              <input type="text" class="form-control g-input" name="accroche_annexe[]" data-max="25" maxlength="25">
              <span class="g-counter">0/25</span>
              <span class="remove-btn">&times;</span>
            </div>`;
  }
  function snippetTpl(){
    return `<div class="g-field">
              <label class="g-label">Extrait</label>
              <input type="text" class="form-control g-input" name="site_annexe[]" data-max="25" maxlength="25">
              <span class="g-counter">0/25</span>
              <span class="remove-btn">&times;</span>
            </div>`;
  }

  /* ===== Preview tableau ===== */
  function updateTablePreview(){
    let titres = getArr('titres[]');
    $('#preview-titres').html(titres.length ? titres.join('<br>') : 'Aucun titre');
    let titresLongs = getArr('titres_longs[]');
    $('#preview-titres-longs').html(titresLongs.length ? titresLongs.join('<br>') : 'Aucun titre long');
    let descs = getArr('descriptions[]');
    $('#preview-descriptions').html(descs.length ? descs.join('<br>') : 'Aucune description');
    $('#preview-url').text($('#url_campagne').val().trim() || 'Aucune URL');
    $('#preview-chemin1').text($('input[name="chemin1"]').val().trim() || 'Aucun Chemin 1');
    $('#preview-chemin2').text($('input[name="chemin2"]').val().trim() || 'Aucun Chemin 2');
    let imgs=$('#propositionImagesContainer img').map((_,img)=>img.src).get();
    $('#preview-image').html(imgs.length ? imgs.map(src=>`<img src="${src}" width="120" style="margin:2px;object-fit:cover;">`).join('') : 'Aucune image');
    $('#preview-numero').text($('input[name="numero"]').val().trim() || 'Aucun numéro');
    $('#preview-adresse').text($('input[name="adresse"]').val().trim() || 'Aucune adresse');
  }
  $('#btn-next, #refresh-preview').on('click', function(e){
    e.preventDefault();
    updateTablePreview();
    const $sec=$('#preview-section');
    if($sec.hasClass('d-none')) $sec.removeClass('d-none');
    setTimeout(function(){
      const anchor=document.getElementById('preview-anchor')||document.getElementById('preview-section');
      if(!anchor) return;
      anchor.scrollIntoView({behavior:'smooth',block:'start'});
      const top=(anchor.getBoundingClientRect().top + window.pageYOffset) - 100;
      window.scrollTo({top,behavior:'smooth'});
    },50);
  });

  /* ===== Live update ===== */
  $(document).on('input',
    'input[name="titres[]"], input[name="titres_longs[]"], input[name="descriptions[]"], input[name="chemin1"], input[name="chemin2"], input[name="titre_annexe[]"], input[name="desc1_annexe[]"], input[name="desc2_annexe[]"], input[name="url_annexe[]"], input[name="accroche_annexe[]"], input[name="site_annexe[]"], input[name="numero"], input[name="adresse"], #url_campagne',
    function(){ bindCounters(); updatePhonePreview(); }
  );

  /* ===== Images (précharge + modal) ===== */
  const fetchImagesUrl = '<?= site_url("Client/fetch_images_campagnes") ?>';
  const saveImagesUrl  = '<?= site_url("Client/save_images_campagnes") ?>';
  const idcampagne = <?= (int)$groupe[0]['idcampagne'] ?>;
  const idclient   = <?= (int)$groupe[0]['idclients'] ?>;
  const csrfName='<?= $this->security->get_csrf_token_name() ?>';
  const csrfHash='<?= $this->security->get_csrf_hash() ?>';
  const propositionCard=$('#propositionImagesCard');
  const propositionContainer=$('#propositionImagesContainer');
  const imagePreviewContainer=$('#imagePreviewContainer');

  function createImageItem(src){
    return `<div class="position-relative m-2 image-item">
              <img src="${src}" width="120" height="120" class="rounded border" style="object-fit:cover;">
              <button type="button" class="btn btn-sm btn-danger position-absolute remove-image-btn" style="top:2px;right:2px;">&times;</button>
            </div>`;
  }
  function updatePropositionImages(images){
    propositionContainer.empty();
    if(!images || !images.length){ propositionCard.addClass('d-none'); return; }
    propositionCard.removeClass('d-none');
    images.forEach(src=>{ propositionContainer.append(`<div class="col-auto px-2 mb-3"><img src="${src}" width="120" class="rounded border" style="object-fit:cover;"></div>`); });
  }
  function loadImages(){
    if(!idcampagne) return;
    let data={ idcampagne }; data[csrfName]=csrfHash;
    $.post(fetchImagesUrl,data,function(resp){
      if(resp && resp.success){
        updatePropositionImages(resp.images||[]);
        imagePreviewContainer.empty();
        (resp.images||[]).forEach(src=> imagePreviewContainer.append(createImageItem(src)));
        updatePhonePreview();
      }
    },'json');
  }
  imagePreviewContainer.on('click','.remove-image-btn',function(){ $(this).closest('.image-item').remove(); updatePhonePreview(); });
  $('#addImageUrlBtn').click(function(){
    const url=$('#imageUrlInput').val().trim();
    if(!/^https?:\/\//i.test(url)) return alert('URL invalide');
    imagePreviewContainer.append(createImageItem(url));
    $('#imageUrlInput').val('');
    updatePhonePreview();
  });
  $('#saveImagesBtn').click(function(){
    let images=imagePreviewContainer.find('img').map((_,img)=>img.src).get();
    let data={ idcampagne, idclient, images }; data[csrfName]=csrfHash;
    $.post(saveImagesUrl,data,function(resp){
      if(resp && resp.success){ updatePropositionImages(images); $('#modalGestionImages').modal('hide'); updatePhonePreview(); }
      else{ alert(resp && resp.message ? resp.message : "Erreur lors de l'enregistrement"); }
    },'json');
  });
  loadImages();

  /* ===== Initial preview ===== */
  updatePhonePreview();

});
</script>
<?php end_section(); ?>
</body>
</html>
