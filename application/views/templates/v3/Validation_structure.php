<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Validation client — Campagne Google Ads</title>

  <!-- Styles & librairies -->
  <link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    :root{
      --primary:#4EA5FE; --primary-dark:#358de6; --bg-light:#f9fbfc; --bg-card:#fff;
      --text-dark:#333; --muted:#6c757d; --border:#e0e0e0;
    }
    *{box-sizing:border-box}
    body{font-family:"Segoe UI",Arial,sans-serif;background:var(--bg-light);color:var(--text-dark);margin:0}
    .container{width:95%;max-width:1200px;margin:0 auto;padding:25px 0 60px}
    h1,h2{color:var(--primary);font-weight:600;text-align:center}
    .section{background:var(--bg-card);border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.05);margin:40px 0;padding:25px}

    /* Table */
    table{width:100%;border-collapse:collapse;font-size:15px}
    thead{background:var(--primary);color:#fff}
    th,td{padding:12px 14px;border-bottom:1px solid var(--border);vertical-align:top;text-align:left}
    tbody tr:nth-child(even){background:#f6f9fc}

    /* Cartes groupes */
    .groupe-card{position:relative;background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px;margin-bottom:25px;box-shadow:0 1px 8px rgba(0,0,0,.03)}
    .groupe-card table{border-collapse:collapse;width:100%}
    .groupe-card th{background:var(--primary);color:#fff;width:210px;font-weight:600;text-align:left;vertical-align:top;padding:10px 12px;border:1px solid #fff}
    .groupe-card td{background:#fff;color:var(--text-dark);padding:10px 12px;border:1px solid var(--border)}

    /* Barre d’actions compacte */
    .card-actions{position:absolute;top:12px;right:12px;display:flex;gap:8px;align-items:center}
    .btn-icon{
      display:inline-flex;align-items:center;justify-content:center;gap:6px;
      width:34px;height:34px;border-radius:8px;border:1px solid var(--border);
      background:#fff;color:var(--text-dark);cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,.06);transition:.2s
    }
    .btn-icon:hover{background:var(--bg-light)}
    .btn-icon i{font-size:14px}

    /* Boutons unifiés */
    .btn-action{
      display:inline-flex;align-items:center;justify-content:center;gap:8px;
      padding:10px 18px;font-size:15px;border-radius:10px;border:1px solid var(--border);
      background:#fff;color:var(--text-dark);box-shadow:0 1px 6px rgba(0,0,0,.08);transition:.2s
    }
    .btn-action:hover{background:var(--bg-light)}
    .btn-action-primary{background:var(--primary);color:#fff;border:none}
    .btn-action-primary:hover{background:var(--primary-dark);color:#fff}
    .btn-action-secondary{background:#fff;color:#666;border:1px solid var(--border)}
    .btn-action-secondary:hover{background:#f1f1f1}
    .btn-action-danger{background:#ffeded;color:#c00;border:1px solid #ffcccc}
    .btn-action-danger:hover{background:#ffd9d9}

    /* Images */
    .image-thumb{position:relative;display:inline-block;margin:3px;width:160px;height:120px;border-radius:10px;overflow:hidden;box-shadow:0 1px 5px rgba(0,0,0,.1)}
    .image-thumb img{width:100%;height:100%;object-fit:cover;display:block}

    /* Modal images */
    .images-toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:12px}
    .images-toolbar .spacer{flex:1}
    .thumb{position:relative;width:150px;height:110px;margin:6px;border-radius:8px;overflow:hidden;border:1px solid var(--border)}
    .thumb img{width:100%;height:100%;object-fit:cover;display:block}
    .thumb .thumb-actions{position:absolute;top:6px;right:6px;opacity:0;transition:opacity .15s;display:flex;gap:6px}
    .thumb:hover .thumb-actions{opacity:1}
    .btn-icon-sm{width:28px;height:28px;border-radius:6px;border:1px solid var(--border);background:rgba(255,255,255,.9);color:#333}

    /* Compteurs */
    .counter{font-size:12px;color:var(--muted)}
    .counter.invalid{color:#c00;font-weight:600}

    .action-btns{text-align:center;margin-top:40px;display:flex;justify-content:center;gap:14px}
    .table1 td{text-align:center;text-transform:capitalize}

    @media print{
      .card-actions,.btn,.action-btns{display:none}
      .section{page-break-before:always}
    }

    /* Titre aligné à gauche, contenu centré (tableau principal) */
    table th { text-align:left !important; }
    table td { text-align:center !important; vertical-align:middle !important; }

    /* Largeur spécifique pour la mise en page PDF si nécessaire */
    .section{ width: 1350px; }

    /* Icônes mockup PMAX */
    .mockup-icon{ width:64px;height:64px;border-radius:16px;background:#f3f4f6;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;margin:0 auto 8px; }
    .mockup-icon img{ max-width:40px;max-height:40px; }
    .mockup-label{ font-weight:600;margin:0;font-size:.9rem; }
    .device-frame.phone-frame{ width:220px;border-radius:24px;border:2px solid #e5e7eb;background:#fff;padding:10px;box-shadow:0 4px 14px rgba(0,0,0,.05); }
    .device-frame .screen{ min-height:360px; }
    .thumb-box img{ width:100%;height:100%;object-fit:cover;border-radius:.5rem; }
    .rounded-pill{ border-radius:50rem !important; }
    .small{ font-size:.8rem; }
    .font-weight-bold{ font-weight:600; }
    .row.row-cols-5 > [class^="col"]{ margin-bottom:.75rem; }
    .fa{ line-height:1; }
    @media (max-width:1440px){
      .device-frame.phone-frame{ width:210px;padding:8px; }
      .device-frame .screen{ min-height:340px; }
      .mockup-icon{ width:58px;height:58px; }
      .mockup-icon img{ max-width:36px; }
    }
  </style>
</head>
<body>
<div class="container">

  <!-- En-tête -->
  <div class="section">
    <h1 style="font-size:2em;color:#000;text-align:center">Campagne Google Ads</h1>

    <div class="d-flex align-items-center justify-content-between" style="margin-bottom:10px;">
      <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
      <h2 class="m-0" style="color:#000">Campagne</h2>
    </div>

    <!-- Tableau campagnes -->
    <table class="table table-bordered table-hover" style="text-align:center;">
      <thead>
        <tr>
          <th style="width:100px;background-color:#a4c2f4">Zone</th>
          <th style="width:100px;background-color:#a4c2f4">Calendrier</th>
          <th style="width:100px;background-color:#a4c2f4">Appareils</th>
		  <th style="width:100px;background-color:#a4c2f4">Ages</th>
          <th style="width:100px;background-color:#a4c2f4">Budget</th>
          <th style="width:300px;">Campagne</th>
          <th style="width:300px;">Groupe</th>
          <th style="width:300px;">Mots‑clés (groupe)</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($campagnes) && is_array($campagnes)): ?>
        <?php foreach($campagnes as $C): ?>
          <?php $groupes = $C['groupes_annonces'] ?? []; ?>
          <?php if (!empty($groupes)): ?>
            <?php foreach($groupes as $G): ?>
              <tr>
                <td><?= htmlspecialchars($C['zones'] ?? '—'); ?></td>
                <td><?= htmlspecialchars($C['date_campagne'] ?? '—'); ?></td>
                <td><?= htmlspecialchars($C['appareil'] ?? '—'); ?></td>
				<td>
					<?= nl2br(htmlspecialchars(str_replace(',', "\n", $C['age'] ?? '—'))); ?>
				</td>

                <td>
                  <?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
                  <?= $b !== '' ? htmlspecialchars($b).' €' : '—'; ?>
                </td>
                <td><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
                <td><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></td>
                <td>
                  <div class="d-flex align-items-start justify-content-between">
                    <div class="pr-2" id="kw_preview_<?= htmlspecialchars($G['idgroupe_annonce'] ?? '') ?>">
                      <?= nl2br(htmlspecialchars($G['mot_cle'] ?? '—')); ?>
                    </div>
                    <button class="btn-icon" title="Modifier les mots‑clés de ce groupe"
                      onclick="openEditKeywords(
                        '<?= htmlspecialchars($G['idgroupe_annonce'] ?? '') ?>',
                        `<?= htmlspecialchars($G['mot_cle'] ?? '', ENT_QUOTES) ?>`,
                        '<?= htmlspecialchars($C['idcampagne'] ?? '') ?>',
                        '<?= htmlspecialchars($C['idclients'] ?? '') ?>'
                      )">
                      <i class="fa fa-edit"></i>
                    </button>
                  </div>
                </td>

                <td>
                  <button class="btn-action btn-action-secondary"
                          onclick="openEditCampaign('<?= htmlspecialchars($C['idcampagne'] ?? '') ?>')">
                    <i class="fa fa-edit"></i> Modifier
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td><?= htmlspecialchars($C['zones'] ?? '—'); ?></td>
              <td><?= htmlspecialchars($C['date_campagne'] ?? '—'); ?></td>
              <td><?= htmlspecialchars($C['appareil'] ?? '—'); ?></td>
              <td>
                <?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
                <?= $b !== '' ? htmlspecialchars($b).' €' : '—'; ?>
              </td>
              <td><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
              <td colspan="3">Aucun groupe d’annonce</td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="8">Aucune campagne disponible.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Groupes -->
  <div class="section">
    <div class="d-flex align-items-center justify-content-between" style="margin-bottom:10px;">
      <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
      <h2 class="m-0" style="color:#000">Annonces</h2>
    </div>
    <?php if (!empty($campagnes) && is_array($campagnes)): ?>
      <?php foreach ($campagnes as $C): ?>
        <?php $groupes = $C['groupes_annonces'] ?? []; $campImages = $C['images'] ?? []; ?>
        <?php foreach ($groupes as $G): ?>
          <div class="groupe-card">

            <div class="card-actions">
              <button class="btn-icon" title="Modifier ce groupe"
                onclick="openEditGroupe('<?= htmlspecialchars($G['idgroupe_annonce'] ?? '') ?>')">
                <i class="fa fa-edit"></i>
              </button>
              <button class="btn-icon" title="Gérer les images de la campagne"
                onclick="openImageManagerForCampagne('<?= htmlspecialchars($C['idcampagne'] ?? '') ?>',
                                                     '<?= htmlspecialchars($C['idclients'] ?? '') ?>')">
                <i class="fa fa-image"></i>
              </button>
            </div>

            <table class="table1">
              <tr><th>Campagne</th><td><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td></tr>
              <tr><th>Groupe</th><td><b><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></b></td></tr>
              <tr><th>Titres</th><td>
                <?php
                  $titres = [];
                  for ($i=1;$i<=12;$i++) if (!empty($G['titre'.$i])) $titres[] = htmlspecialchars($G['titre'.$i]);
                  echo !empty($titres) ? implode('<br>', $titres) : 'Aucun titre';
                ?>
              </td></tr>
              <tr><th>Descriptions</th><td>
                <?php
                  $desc = [];
                  for ($i=1;$i<=4;$i++) if (!empty($G['descriptions'.$i])) $desc[] = htmlspecialchars($G['descriptions'.$i]);
                  echo !empty($desc) ? implode('<br>', $desc) : 'Aucune description';
                ?>
              </td></tr>

              <?php if (($G['type_campagnes'] ?? null) == 1): ?>
                <tr><th>Chemin 1</th><td><?= htmlspecialchars($G['chemin1'] ?? ''); ?></td></tr>
                <tr><th>Chemin 2</th><td><?= htmlspecialchars($G['chemin2'] ?? ''); ?></td></tr>
              <?php endif; ?>

              <?php if (($G['type_campagnes'] ?? null) == 2 || ($G['type_campagnes'] ?? null) == 3): ?>
                <tr><th>Description brève</th><td><?= htmlspecialchars($G['description_breve'] ?? ''); ?></td></tr>
              <?php endif; ?>

              <tr id="row_campagne_<?= htmlspecialchars($C['idcampagne'] ?? '') ?>">
                <th>Images</th>
                <td class="image-column">
                  <?php if (!empty($campImages)): ?>
                    <?php foreach ($campImages as $img): ?>
                      <?php $src = htmlspecialchars(is_object($img) ? $img->image_url : $img['image_url']); ?>
                      <span class="image-thumb"><img src="<?= $src ?>" alt="" /></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="text-muted">Aucune image</span>
                  <?php endif; ?>
                </td>
              </tr>

              <tr><th>URL</th>
                <td>
                  <?php $url = trim((string)($G['url_groupe_annonce'] ?? '')); ?>
                  <?php if ($url): ?>
                    <a href="<?= htmlspecialchars($url); ?>" target="_blank" rel="noopener"><?= htmlspecialchars($url); ?></a>
                  <?php else: ?>—<?php endif; ?>
                </td>
              </tr>
            </table>

          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun groupe d’annonces à afficher.</p>
    <?php endif; ?>
  </div>

  <!-- Extensions -->
  <?php if (!empty($extensions) && is_array($extensions)): ?>
  <div class="section">
    <div class="d-flex align-items-center justify-content-between">
      <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
      <h2 class="m-0" style="color:#000">Extensions</h2>
    </div>

    <table style="width:100%;border-collapse:collapse;border:1px solid #dee2e6;background:#fff">
      <thead style="background:#4EA5FE;color:#fff">
        <tr>
          <th style="padding:12px;border:1px solid #dee2e6">Liens annexes</th>
          <th style="padding:12px;border:1px solid #dee2e6">Accroche</th>
          <th style="padding:12px;border:1px solid #dee2e6">Extraits de site</th>
          <th style="padding:12px;border:1px solid #dee2e6">Lieu</th>
          <th style="padding:12px;border:1px solid #dee2e6">Appel</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; foreach ($extensions as $E): ?>
          <tr>
            <td style="padding:12px;border:1px solid #dee2e6">
              <strong><?php echo $E['titre_extensions']; ?></strong><br />
              <?php echo $E['description_extensions']; ?><br />
              <a href="<?php echo $E['url_extensions']; ?>" style="color:#007bff;text-decoration:none"><?php echo $E['url_extensions']; ?></a>
            </td>
            <?php if ($i === 0): ?>
              <td rowspan="<?php echo count($extensions); ?>" style="padding:12px;border:1px solid #dee2e6;text-align:center"><?php echo $E['extensions_accroche']; ?></td>
              <td rowspan="<?php echo count($extensions); ?>" style="padding:12px;border:1px solid #dee2e6;text-align:center"><?php echo $E['extensions_extrait_site']; ?></td>
              <td rowspan="<?php echo count($extensions); ?>" style="padding:12px;border:1px solid #dee2e6;text-align:center"><?php echo $E['extensions_lieu']; ?></td>
              <td rowspan="<?php echo count($extensions); ?>" style="padding:12px;border:1px solid #dee2e6;text-align:center"><?php echo $E['extensions_appel']; ?></td>
            <?php endif; ?>
          </tr>
        <?php $i++; endforeach; ?>
      </tbody>
    </table>

    <div class="text-right mt-2">
      <button class="btn-action btn-action-secondary" onclick="openEditExtensions()">
        <i class="fa fa-edit"></i> Modifier
      </button>
    </div>
  </div>
  <?php endif; ?>

		<!-- Exclusions -->
		<div class="section">
			<div class="d-flex align-items-center justify-content-between">
				<img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
				<h2 class="m-0" style="color:#000">Mots‑clés à exclure</h2>
			</div>

			<?php
// 1️⃣ Calcul du nombre maximum de colonnes
$maxColumns = 1;

foreach ($exlusions as $D) {
    if (!empty($D['exclusion'])) {
        $lines = explode("\n", $D['exclusion']);
        $maxColumns = max($maxColumns, ceil(count($lines) / 21));
    }
}
?>

				<table style="width:100%;border-collapse:collapse;border:1px solid #dee2e6;background:#fff">
					<thead style="background:#4EA5FE;color:#fff">
						<tr>
							<th colspan="<?= $maxColumns ?>"
								style="padding:12px;border:1px solid #dee2e6;text-align:center! important;font-weight:bold">
								Liste
							</th>
						</tr>
					</thead>

					<tbody>
					<?php
					$hasContent = false;

					foreach ($exlusions as $D):
						if (!empty($D['exclusion'])):
							$hasContent = true;

							// Sécurisation
							$exclusion = htmlspecialchars($D['exclusion']);

							// Découpage en lignes
							$lines = explode("\n", $exclusion);

							// Découpage en colonnes (21 lignes max)
							$columns = array_chunk($lines, 21);
					?>
							<tr>
								<?php foreach ($columns as $column): ?>
									<td style="padding:12px;border:1px solid #dee2e6;
											text-align:center;vertical-align:top;
											word-break:break-word;">
										<?= nl2br(implode("\n", $column)); ?>
									</td>
								<?php endforeach; ?>
							</tr>
					<?php
						endif;
					endforeach;

					if (!$hasContent):
					?>
							<tr>
								<td colspan="<?= $maxColumns ?>"
									style="padding:12px;border:1px solid #dee2e6;text-align:center">
									Aucune exclusion
								</td>
							</tr>
					<?php endif; ?>
					</tbody>
				</table>


			<div class="text-right mt-2">
				<button class="btn-action btn-action-secondary" onclick="openEditExclusions()">
					<i class="fa fa-edit"></i> Modifier
				</button>
			</div>
		</div>

                


            <div class="action-btns">
       <a href="<?= base_url('Client/valider_campagne/'.($campagnes[0]['idclients'] ?? '')); ?>" class="btn-action btn-action-secondary" target="_blank">
      <i class="fa fa-file-pdf"></i> Valider la campagne
    </a>           
    <a href="<?= base_url('Validation/exporter/'.($campagnes[0]['idclients'] ?? '')); ?>" class="btn-action btn-action-secondary" target="_blank">
      <i class="fa fa-file-pdf"></i> Exporter en PDF
    </a>
  </div>
                  
  <!-- Modal CAMPAGNE -->
  <div class="modal fade" id="modalEditCampaign" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form id="formEditCampaign" method="POST" action="<?= site_url('Validation/updateCampagne'); ?>">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Modifier la campagne</h5>
            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="idcampagne" id="edit_idcampagne">
            <div class="form-group"><label>Zone</label><input type="text" name="zones" id="edit_zones" class="form-control"></div>
            <div class="form-group"><label>Calendrier</label><input type="text" name="date_campagne" id="edit_date_campagne" class="form-control"></div>
            <div class="form-group"><label>Appareils</label><input type="text" name="appareil" id="edit_appareil" class="form-control"></div>
            <div class="form-group"><label>Budget</label><input type="number" name="repartition_budget" id="edit_budget" class="form-control"></div>
            <div class="form-group"><label>Campagne</label><input type="text" name="nom_campagne" id="edit_nom_campagne" class="form-control"></div>

            <!-- NOTE : pas de “mot_cle” ici (désormais géré par groupe) -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-action btn-action-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i> Annuler
            </button>
            <button type="submit" class="btn-action btn-action-primary">
              <i class="fa fa-save"></i> Enregistrer
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Mots-Clés (par groupe) -->
<div class="modal fade" id="modalEditKeywords" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document"> <!-- volontairement compact -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Modifier les mots-clés du groupe</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="kw_idgroupe">
        <input type="hidden" id="kw_idcampagne">
        <input type="hidden" id="kw_idclients">
        <div class="form-group mb-0">
          <label>Mots-Clés (un par ligne)</label>
          <textarea id="kw_textarea" class="form-control" rows="8" placeholder="ex: mot clé 1&#10;mot clé 2"></textarea>
          <!-- <small class="text-muted">Astuce : <kbd>Ctrl</kbd>+<kbd>Entrée</kbd> pour enregistrer.</small> -->
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn-action btn-action-secondary" data-dismiss="modal">
          <i class="fa fa-times"></i> Annuler
        </button>
        <button type="button" class="btn-action btn-action-primary" id="kw_save_btn">
          <i class="fa fa-save"></i> Enregistrer
        </button>
      </div>
    </div>
  </div>
</div>


  <!-- Modal GROUPE -->
  <div class="modal fade" id="modalEditGroupe" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Modifier le groupe d’annonce</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="formEditGroupe" method="POST" action="<?= site_url('Validation/updateDonneeClient'); ?>">
            <input type="hidden" name="idgroupe_annonce" id="edit_idgroupe_annonce">
            <input type="hidden" name="idcampagne" id="edit_idcampagne">
            <input type="hidden" name="idclients" id="edit_idclients">

            <div class="form-group"><label>Nom du groupe</label>
              <input type="text" name="nom_groupe" id="edit_nom_groupe" class="form-control">
            </div>

            <div class="form-group"><label>Mots-Clés (ce groupe)</label>
              <textarea name="mot_cle" id="edit_mot_cle" class="form-control" rows="3"></textarea>
            </div>

            <!-- TITRES (12 max, 30 chars) -->
            <div class="mb-3">
              <div class="d-flex align-items-center justify-content-between">
                <label class="m-0">Titres (12 max, 30 caractères)</label>
                <button type="button" class="btn-icon" id="btnAddTitle" title="Ajouter un titre"><i class="fa fa-plus"></i></button>
              </div>
              <div id="titlesList" class="mt-2"></div>
            </div>

            <!-- DESCRIPTIONS (4 max, 90 chars) -->
            <div class="mb-3">
              <div class="d-flex align-items-center justify-content-between">
                <label class="m-0">Descriptions (4 max, 90 caractères)</label>
                <button type="button" class="btn-icon" id="btnAddDesc" title="Ajouter une description"><i class="fa fa-plus"></i></button>
              </div>
              <div id="descsList" class="mt-2"></div>
            </div>

            <div class="form-group"><label>URL</label>
              <input type="text" name="url_groupe_annonce" id="edit_url_groupe_annonce" class="form-control">
            </div>

            <!-- Champs conditionnels -->
            <div class="form-row mt-3">
              <div class="col-12">
                <input type="hidden" name="type_campagnes" id="edit_type_campagnes">
              </div>
              <div class="col-md-6 d-none" id="wrap_chemin1">
                <label>Chemin 1</label>
                <input type="text" name="chemin1" id="edit_chemin1" class="form-control">
              </div>
              <div class="col-md-6 d-none" id="wrap_chemin2">
                <label>Chemin 2</label>
                <input type="text" name="chemin2" id="edit_chemin2" class="form-control">
              </div>
              <div class="col-12 d-none mt-2" id="wrap_description_breve">
                <label>Description brève</label>
                <input type="text" name="description_breve" id="edit_description_breve" class="form-control">
              </div>
            </div>

            <!-- champs cachés pour sérialiser -->
            <textarea name="titres" id="hidden_titres" class="d-none"></textarea>
            <textarea name="descriptions" id="hidden_descriptions" class="d-none"></textarea>

            <div class="d-flex justify-content-between align-items-center mt-4">
              <button type="button" class="btn-action btn-action-secondary"
                title="Gérer les images de la campagne"
                onclick="openImageManagerForCampagne(
                  document.getElementById('edit_idcampagne').value,
                  document.getElementById('edit_idclients').value
                )">
                <i class="fa fa-image"></i> Images de la campagne
              </button>
              <div>
                <button type="button" class="btn-action btn-action-secondary" data-dismiss="modal">
                  <i class="fa fa-times"></i> Annuler
                </button>
                <button type="submit" class="btn-action btn-action-primary">
                  <i class="fa fa-save"></i> Enregistrer
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal IMAGES -->
  <div class="modal fade" id="modalGestionImages" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Gérer les images</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
        <div class="modal-body">
          <div class="images-toolbar">
            <div class="input-group" style="max-width:520px;">
              <input type="text" class="form-control" id="imageUrlInput" placeholder="https://exemple.com/image.jpg">
              <div class="input-group-append">
                <button class="btn-action btn-action-secondary" type="button" id="addImageUrlBtn"><i class="fa fa-plus"></i> Ajouter</button>
              </div>
            </div>
            <div class="spacer"></div>
            <button type="button" class="btn-action btn-action-danger" id="btnClearImages"><i class="fa fa-trash"></i> Tout effacer</button>
            <button type="button" class="btn-action btn-action-primary" id="saveImagesBtn"><i class="fa fa-save"></i> Enregistrer</button>
          </div>
          <div id="imagePreviewContainer" class="d-flex flex-wrap"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal EXTENSIONS -->
  <div class="modal fade" id="modalEditExtensions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form id="formEditExtensions" method="POST" action="<?= site_url('Validation/updateExtensions'); ?>">
        <input type="hidden" name="idcampagne" value="<?= $campagnes[0]['idcampagne'] ?? ''; ?>">
        <input type="hidden" name="idclients" value="<?= $campagnes[0]['idclients'] ?? ''; ?>">

        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Modifier les Extensions</h5>
            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <h6 class="text-primary">Liens annexes</h6>
            <div id="liensContainer"></div>
            <button type="button" class="btn-icon mt-2" id="addLienBtn" title="Ajouter un lien annexe">
              <i class="fa fa-plus"></i>
            </button>
            <hr>
            <div class="form-group"><label>Accroche</label><input type="text" name="extensions_accroche" id="edit_extensions_accroche" class="form-control"></div>
            <div class="form-group"><label>Extraits de site</label><input type="text" name="extensions_extrait_site" id="edit_extensions_extrait_site" class="form-control"></div>
            <div class="form-group"><label>Lieu</label><input type="text" name="extensions_lieu" id="edit_extensions_lieu" class="form-control"></div>
            <div class="form-group"><label>Appel</label><input type="text" name="extensions_appel" id="edit_extensions_appel" class="form-control"></div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn-action btn-action-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i> Annuler
            </button>
            <button type="submit" class="btn-action btn-action-primary">
              <i class="fa fa-save"></i> Enregistrer
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal EXCLUSIONS -->
  <div class="modal fade" id="modalEditExclusions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form id="formEditExclusions" method="POST" action="<?= site_url('Validation/updateExclusions'); ?>">
        <input type="hidden" name="idclients" value="<?= $campagnes[0]['idclients'] ?? ''; ?>">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Modifier les Mots-Clés à Exclure</h5>
            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Liste des mots-clés exclus (un par ligne)</label>
              <textarea name="exclusion" id="edit_exclusion" class="form-control" rows="8"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-action btn-action-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i> Annuler
            </button>
            <button type="submit" class="btn-action btn-action-primary">
              <i class="fa fa-save"></i> Enregistrer
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div><!-- /.container -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ===========================
// Constantes
// ===========================
const TITLE_MAX = 30, DESC_MAX = 90, TITLES_MAX_COUNT = 12, DESCS_MAX_COUNT = 4;

// ===========================
// Dataset JS depuis le serveur
// ===========================
const campagnesJS = <?= json_encode($campagnes ?? []); ?>;
const groupesData = [
<?php if (!empty($campagnes) && is_array($campagnes)): ?>
  <?php foreach ($campagnes as $C): $groupes = $C['groupes_annonces'] ?? []; ?>
    <?php foreach ($groupes as $G): ?>
{
  idgroupe_annonce:"<?= htmlspecialchars($G['idgroupe_annonce'] ?? '', ENT_QUOTES) ?>",
  idcampagne:"<?= htmlspecialchars($C['idcampagne'] ?? '', ENT_QUOTES) ?>",
  idclients:"<?= htmlspecialchars($C['idclients'] ?? '', ENT_QUOTES) ?>",
  nom_groupe:<?= json_encode($G['nom_groupe'] ?? '') ?>,
  mot_cle:<?= json_encode($G['mot_cle'] ?? '') ?>,
  titres:[<?php for($i=1;$i<=12;$i++){ if(!empty($G['titre'.$i])){ echo json_encode($G['titre'.$i]).','; } } ?>],
  descriptions:[<?php for($i=1;$i<=4;$i++){ if(!empty($G['descriptions'.$i])){ echo json_encode($G['descriptions'.$i]).','; } } ?>],
  url_groupe_annonce:<?= json_encode($G['url_groupe_annonce'] ?? '') ?>,
  type_campagnes: <?= json_encode($G['type_campagnes'] ?? null) ?>,
  chemin1: <?= json_encode($G['chemin1'] ?? '') ?>,
  chemin2: <?= json_encode($G['chemin2'] ?? '') ?>,
  description_breve: <?= json_encode($G['description_breve'] ?? '') ?>
},
    <?php endforeach; ?>
  <?php endforeach; ?>
<?php endif; ?>
];

// ===========================
// Helpers UI – champs dynamiques + compteurs
// ===========================
function makeLineInput(value='', max=30, name='title'){
  const id = 'fld_'+name+'_'+Math.random().toString(36).slice(2);
  const wrapper = document.createElement('div');
  wrapper.className = 'form-row align-items-center mb-2';

  const inputCol = document.createElement('div');
  inputCol.className = 'col';
  const input = document.createElement('input');
  input.type = 'text'; input.className = 'form-control'; input.value = value || '';
  input.maxLength = max; input.id = id; input.dataset.max = String(max);
  inputCol.appendChild(input);

  const ctrCol = document.createElement('div');
  ctrCol.className = 'col-auto';
  const span = document.createElement('span');
  span.className = 'counter'; span.textContent = `${(value||'').length}/${max}`;
  ctrCol.appendChild(span);

  const delCol = document.createElement('div');
  delCol.className = 'col-auto';
  const delBtn = document.createElement('button');
  delBtn.type = 'button'; delBtn.className = 'btn-icon'; delBtn.title = 'Supprimer';
  delBtn.innerHTML = '<i class="fa fa-trash"></i>';
  delBtn.addEventListener('click', ()=> wrapper.remove());
  delCol.appendChild(delBtn);

  input.addEventListener('input', ()=>{
    const len = input.value.length, m = parseInt(input.dataset.max,10);
    span.textContent = `${len}/${m}`;
    span.classList.toggle('invalid', len>m);
  });

  wrapper.appendChild(inputCol);
  wrapper.appendChild(ctrCol);
  wrapper.appendChild(delCol);
  return wrapper;
}
function collectLines(containerId, maxCount){
  const inputs = document.querySelectorAll(`#${containerId} input.form-control`);
  const values = [];
  inputs.forEach((el, idx)=>{
    if (idx < maxCount){
      const v = (el.value||'').trim();
      if (v) values.push(v);
    }
  });
  return values;
}

// ===========================
// Actions : Edit Campagne
// ===========================
function openEditCampaign(id){
  const campagne = (campagnesJS || []).find(c => String(c.idcampagne) === String(id));
  if(!campagne) return;
  document.getElementById('edit_idcampagne').value = campagne.idcampagne || '';
  document.getElementById('edit_zones').value = campagne.zones || '';
  document.getElementById('edit_date_campagne').value = campagne.date_campagne || '';
  document.getElementById('edit_appareil').value = campagne.appareil || '';
  document.getElementById('edit_budget').value = campagne.repartition_budget || '';
  document.getElementById('edit_nom_campagne').value = campagne.nom_campagne || '';
  $('#modalEditCampaign').modal('show');
}

// ===========================
// Actions : Edit Groupe
// ===========================
const titlesList = ()=> document.getElementById('titlesList');
const descsList  = ()=> document.getElementById('descsList');

function fillList(container, arr, maxLen, name, maxCount){
  container.innerHTML = '';
  (arr || []).slice(0,maxCount).forEach(v=>{
    container.appendChild(makeLineInput(v, maxLen, name));
  });
  if (!arr || arr.length === 0){
    container.appendChild(makeLineInput('', maxLen, name));
  }
}

function openEditGroupe(id){
  const g = (groupesData || []).find(x => String(x.idgroupe_annonce) === String(id));
  if(!g) return;

  // ids
  document.getElementById('edit_idgroupe_annonce').value = g.idgroupe_annonce || '';
  document.getElementById('edit_idcampagne').value       = g.idcampagne || '';
  document.getElementById('edit_idclients').value        = g.idclients || '';

  // simples
  document.getElementById('edit_nom_groupe').value       = g.nom_groupe || '';
  document.getElementById('edit_mot_cle').value          = g.mot_cle || '';
  document.getElementById('edit_url_groupe_annonce').value = g.url_groupe_annonce || '';

  // listes avec compteurs
  fillList(titlesList(), g.titres || [], TITLE_MAX, 'title', TITLES_MAX_COUNT);
  fillList(descsList(),  g.descriptions || [], DESC_MAX, 'desc', DESCS_MAX_COUNT);

  // conditionnels
  document.getElementById('edit_type_campagnes').value   = g.type_campagnes ?? '';
  document.getElementById('edit_chemin1').value          = g.chemin1 || '';
  document.getElementById('edit_chemin2').value          = g.chemin2 || '';
  document.getElementById('edit_description_breve').value= g.description_breve || '';

  const typeCamp = Number(g.type_campagnes);
  const wrapChemin1 = document.getElementById('wrap_chemin1');
  const wrapChemin2 = document.getElementById('wrap_chemin2');
  const wrapDescBr  = document.getElementById('wrap_description_breve');
  if (typeCamp === 1){
    wrapChemin1.classList.remove('d-none'); wrapChemin2.classList.remove('d-none'); wrapDescBr.classList.add('d-none');
  } else if (typeCamp === 2 || typeCamp === 3){
    wrapChemin1.classList.add('d-none'); wrapChemin2.classList.add('d-none'); wrapDescBr.classList.remove('d-none');
  } else {
    wrapChemin1.classList.add('d-none'); wrapChemin2.classList.add('d-none'); wrapDescBr.classList.add('d-none');
  }

  $('#modalEditGroupe').modal('show');
}

// Ajout d’un titre / d’une description
document.getElementById('btnAddTitle')?.addEventListener('click', ()=>{
  const c = titlesList();
  if (c.querySelectorAll('input.form-control').length >= TITLES_MAX_COUNT) return;
  c.appendChild(makeLineInput('', TITLE_MAX, 'title'));
});
document.getElementById('btnAddDesc')?.addEventListener('click', ()=>{
  const c = descsList();
  if (c.querySelectorAll('input.form-control').length >= DESCS_MAX_COUNT) return;
  c.appendChild(makeLineInput('', DESC_MAX, 'desc'));
});

// Avant submit du groupe : sérialiser vers hidden
document.getElementById('formEditGroupe')?.addEventListener('submit', function(e){
  const titles = collectLines('titlesList', TITLES_MAX_COUNT).map(v=> v.slice(0, TITLE_MAX));
  const descs  = collectLines('descsList',  DESCS_MAX_COUNT).map(v=> v.slice(0, DESC_MAX));
  document.getElementById('hidden_titres').value = titles.join("\n");
  document.getElementById('hidden_descriptions').value = descs.join("\n");
});

// ===========================
// Extensions
// ===========================
function openEditExtensions() {
  const extensionsJS = <?= json_encode($extensions ?? []); ?>;
  if (!extensionsJS.length) return alert("Aucune extension à modifier");
  const container = document.getElementById('liensContainer');
  container.innerHTML = '';
  extensionsJS.forEach(E => addLienRow(E.titre_extensions, E.description_extensions, E.url_extensions));
  document.getElementById('edit_extensions_accroche').value = extensionsJS[0].extensions_accroche || '';
  document.getElementById('edit_extensions_extrait_site').value = extensionsJS[0].extensions_extrait_site || '';
  document.getElementById('edit_extensions_lieu').value = extensionsJS[0].extensions_lieu || '';
  document.getElementById('edit_extensions_appel').value = extensionsJS[0].extensions_appel || '';
  $('#modalEditExtensions').modal('show');
}
function addLienRow(titre = '', desc = '', url = '') {
  const container = document.getElementById('liensContainer');
  const row = document.createElement('div');
  row.className = 'border rounded p-2 mb-2 bg-light lien-row';
  row.innerHTML = `
    <div class="form-row align-items-end">
      <div class="col-md-4"><label>Titre</label><input type="text" name="titre_extensions[]" class="form-control" value="${titre}"></div>
      <div class="col-md-4"><label>Description</label><input type="text" name="description_extensions[]" class="form-control" value="${desc}"></div>
      <div class="col-md-3"><label>URL</label><input type="text" name="url_extensions[]" class="form-control" value="${url}"></div>
      <div class="col-md-1 text-center"><button type="button" class="btn-icon removeLienBtn" title="Supprimer"><i class="fa fa-trash"></i></button></div>
    </div>`;
  container.appendChild(row);
  row.querySelector('.removeLienBtn').addEventListener('click', () => row.remove());
}
document.getElementById('addLienBtn')?.addEventListener('click', () => addLienRow());

// ===========================
// Gestion d'images (campagne only)
// ===========================
let currentIds = { idcampagne: null, idclients: null };
let imagesTemp = [];

function openImageManagerForCampagne(idCampagne, idClient) {
  currentIds = { idcampagne: idCampagne, idclients: idClient };
  const campagne = (campagnesJS || []).find(c => String(c.idcampagne) === String(idCampagne));
  imagesTemp = Array.isArray(campagne?.images) ? JSON.parse(JSON.stringify(campagne.images)) : [];
  refreshImagePreview();
  $('#modalGestionImages').modal('show');
}
function refreshImagePreview() {
  const container = document.getElementById('imagePreviewContainer');
  container.innerHTML = '';
  if (!imagesTemp.length) {
    container.innerHTML = '<p class="text-muted mb-0">Aucune image pour cette campagne.</p>';
    return;
  }
  imagesTemp.forEach((img, index) => {
    const src = img.image_url || '';
    const item = document.createElement('div');
    item.className = 'thumb';
    item.innerHTML = `
      <img src="${src}" alt="">
      <div class="thumb-actions">
        <button type="button" class="btn-icon-sm" title="Supprimer" onclick="confirmRemoveImage(${index})"><i class="fa fa-times"></i></button>
      </div>`;
    container.appendChild(item);
  });
}
function confirmRemoveImage(index){
  if (!Number.isInteger(index)) return;
  if (confirm('Supprimer cette image ?')) removeImage(index);
}
function removeImage(index) {
  imagesTemp.splice(index, 1);
  imagesTemp = imagesTemp.map((img, i) => ({ image_url: img.image_url, rank: i }));
  refreshImagePreview();
}
document.getElementById('btnClearImages')?.addEventListener('click', function(){
  if (!imagesTemp.length) return;
  if (confirm('Tout effacer pour cette campagne ?')) { imagesTemp = []; refreshImagePreview(); }
});
document.getElementById('addImageUrlBtn')?.addEventListener('click', function () {
  const input = document.getElementById('imageUrlInput');
  const url = (input.value || '').trim();
  if (!url) return;
  imagesTemp.push({ image_url: url, rank: imagesTemp.length });
  input.value = '';
  refreshImagePreview();
});
document.getElementById('saveImagesBtn')?.addEventListener('click', function () {
  if (!currentIds.idcampagne) return alert("Aucune campagne sélectionnée.");
  const $btn = $(this).prop('disabled', true).text('Enregistrement...');
  $.ajax({
    url: "<?= site_url('Validation/updateImages'); ?>",
    method: "POST",
    data: {
      idcampagne: currentIds.idcampagne,
      idclients:  currentIds.idclients,
      images:     JSON.stringify(imagesTemp)
    },
    success: function (res) {
      try {
        const data = JSON.parse(res);
        if (data.status === 'success') { window.location.reload(); return; }
        alert("Erreur : " + (data.message || 'Inconnue'));
      } catch { alert("Erreur inattendue côté serveur."); }
    },
    error: function () { alert("Erreur réseau ou serveur lors de la mise à jour des images."); },
    complete: function () { $btn.prop('disabled', false).text('Enregistrer'); }
  });
});

// ===========================
// Exclusions
// ===========================
function openEditExclusions() {
  const exclusionsJS = <?= json_encode($exlusions ?? []); ?>;
  if (!exclusionsJS.length) return alert("Aucune donnée d'exclusion trouvée");
  const exclu = exclusionsJS.find(e => e.exclusion !== null) || exclusionsJS[0];
  document.getElementById("edit_exclusion").value = exclu.exclusion || "";
  $('#modalEditExclusions').modal('show');
}
// --- ouverture du modal mots-clés
function openEditKeywords(idgroupe, currentText, idCampagne, idClients){
  document.getElementById('kw_idgroupe').value = idgroupe || '';
  document.getElementById('kw_idcampagne').value = idCampagne || '';
  document.getElementById('kw_idclients').value = idClients || '';
  document.getElementById('kw_textarea').value = (currentText || '').trim();
  $('#modalEditKeywords').modal('show');
  setTimeout(()=> document.getElementById('kw_textarea').focus(), 150);
}

// --- save AJAX
document.getElementById('kw_save_btn')?.addEventListener('click', saveKeywordsFromModal);

// Ctrl+Enter pour enregistrer
document.getElementById('kw_textarea')?.addEventListener('keydown', function(e){
  if (e.ctrlKey && e.key === 'Enter') { e.preventDefault(); saveKeywordsFromModal(); }
});

function saveKeywordsFromModal(){
  const btn = document.getElementById('kw_save_btn');
  const idg  = document.getElementById('kw_idgroupe').value;
  const txt  = document.getElementById('kw_textarea').value.trim();

  if (!idg) { alert('ID groupe manquant'); return; }

  $(btn).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enregistrement...');

  $.ajax({
    url: "<?= site_url('Validation/updateMotCleGroupe'); ?>",
    method: "POST",
    data: { idgroupe_annonce: idg, mot_cle: txt },
    success: function(res){
      try {
        const data = typeof res === 'object' ? res : JSON.parse(res);
        if (data.status === 'success'){
          // Fermer le modal puis recharger la page
          $('#modalEditKeywords').modal('hide');
          // rechargement immédiat (force refresh pour éviter le cache)
          window.location.reload(true);
          return;
        }
        alert('Erreur : ' + (data.message || 'Inconnue'));
      } catch(err){
        alert('Réponse serveur invalide.');
      }
    },
    error: function(){
      alert('Erreur réseau ou serveur.');
    },
    complete: function(){
      $(btn).prop('disabled', false).html('<i class="fa fa-save"></i> Enregistrer');
    }
  });
}


</script>
</body>
</html>