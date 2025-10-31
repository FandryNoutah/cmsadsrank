<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Validation client – Campagne Google Ads</title>
<link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root {
    --primary:#4EA5FE; --primary-dark:#358de6; --bg-light:#f9fbfc; --bg-card:#ffffff; --text-dark:#333; --border:#e0e0e0;
}
body{font-family:"Segoe UI",Arial,sans-serif;background-color:var(--bg-light);color:var(--text-dark);margin:0;padding:0;}
.container{width:95%;max-width:1200px;margin:0 auto;padding:25px 0 60px;}
h1,h2{color:var(--primary);font-weight:600;text-align:center;}
.section{background:var(--bg-card);border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,0.05);margin:40px 0;padding:25px;}
.header-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;}
.header-row img{max-width:140px;height:auto;}
table{width:100%;border-collapse:collapse;font-size:15px;}
thead{background-color:var(--primary);color:#fff;}
th,td{padding:12px 14px;border-bottom:1px solid var(--border);vertical-align:top;text-align:left;}
tbody tr:nth-child(even){background-color:#f6f9fc;}
a{color:var(--primary);text-decoration:none;}
.btn{display:inline-block;padding:8px 16px;font-size:14px;border-radius:8px;color:#fff;background-color:var(--primary);text-decoration:none;transition:.2s;}
.btn:hover{background-color:var(--primary-dark);}
.images-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-start;justify-content:flex-start;margin-left:10px;}
.images-row img{width:160px;height:120px;border-radius:10px;object-fit:cover;box-shadow:0 1px 5px rgba(0,0,0,0.1);transition:transform .2s;}
.images-row img:hover{transform:scale(1.05);}
.groupe-card{background:#fdfdfd;border:1px solid var(--border);border-radius:12px;padding:20px;margin-bottom:25px;box-shadow:0 1px 8px rgba(0,0,0,0.03);position:relative;}
.groupe-card table{border-collapse:collapse;width:100%;}
.groupe-card th{background-color:var(--primary);color:#fff;width:200px;font-weight:600;text-align:left;vertical-align:top;padding:10px 12px;border:1px solid #fff;}
.groupe-card td{background-color:#fff;color:var(--text-dark);padding:10px 12px;border:1px solid var(--border);}
.edit-btn{position:absolute;bottom:15px;right:20px;background-color:var(--primary);color:#fff;border:none;border-radius:6px;padding:8px 14px;font-size:13px;cursor:pointer;transition:background-color .2s;}
.edit-btn:hover{background-color:var(--primary-dark);}
.action-btns{text-align:center;margin-top:40px;display:flex;justify-content:center;gap:20px;}
.btn-validate{background-color:#28a745;}
.btn-export{background-color:var(--primary);}
@media print{
  .edit-btn,.btn,.action-btns{display:none;}
  .section{page-break-before:always;} /* ← seulement à l'impression */
}
</style>
</head>

<body>
<div class="container">

  <div class="section">
    <div class="header-row">
      <?php if (!empty($logo_base64)): ?>
        <img src="<?= htmlspecialchars($logo_base64); ?>" alt="Logo">
      <?php else: ?>
        <div style="width:140px;height:1px;"></div>
      <?php endif; ?>
      <h1>Campagne Google Ads</h1>
      <div style="width:140px;height:1px;"></div>
    </div>

    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Zone</th><th>Calendrier</th><th>Appareils</th><th>Budget</th>
          <th>Campagne</th><th>Groupe</th><th>Mots-Clés</th><th>Actions</th>
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
                  <?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
                  <?= $b !== '' ? htmlspecialchars($b).' €' : '—'; ?>
                </td>
                <td><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
                <td><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></td>
                <td><?= nl2br(htmlspecialchars($G['mot_cle'] ?? '—')); ?></td>
                <td>
                  <button class="btn btn-sm btn-primary" onclick="openEditCampaign('<?= htmlspecialchars($C['idcampagne'] ?? '') ?>')">
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
            <div class="form-group"><label>Mots-Clés</label><textarea name="mot_cle" id="edit_mot_cle_campaign" class="form-control" rows="3"></textarea></div>
            <div class="text-right mt-3">
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="section">
    <h2>Aperçu des Groupes d'Annonces</h2>
    <?php if (!empty($campagnes) && is_array($campagnes)): ?>
      <?php foreach ($campagnes as $C): ?>
        <?php $groupes = $C['groupes_annonces'] ?? []; $campImages = $C['images'] ?? []; ?>
        <?php foreach ($groupes as $G): ?>
          <div class="groupe-card">
            <table>
              <tr><th>Campagne</th><td><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></td></tr>
              <tr><th>Groupe</th><td><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></td></tr>
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
              <tr><th>Images</th>
                <td>
                  <div class="images-row">
                    <?php if (!empty($campImages) && is_array($campImages)): ?>
                      <?php foreach($campImages as $img):
                        $b64 = is_object($img) ? ($img->image_base64 ?? '') : ($img['image_base64'] ?? '');
                        $url = is_object($img) ? ($img->image_url ?? '')    : ($img['image_url'] ?? '');
                        $src = $b64 ?: $url;
                        if ($src): ?>
                          <img src="<?= htmlspecialchars($src); ?>" alt="Image annonce">
                        <?php endif; endforeach; ?>
                    <?php else: ?>
                      — 
                    <?php endif; ?>
                  </div>
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

            <button class="edit-btn" onclick="openEditGroupe('<?= htmlspecialchars($G['idgroupe_annonce'] ?? '') ?>')">
              <i class="fa fa-edit"></i> Modifier ce groupe
            </button>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun groupe d'annonces à afficher.</p>
    <?php endif; ?>
  </div>

  <div class="action-btns">
    <a href="<?= base_url('Googleads/save_campagne_clients/'.($campagnes[0]['idcampagne'] ?? '')); ?>" class="btn btn-validate">
      <i class="fa fa-check"></i> Valider la campagne
    </a>
    <!-- lien export aligné avec le contrôleur -->
    <a href="<?= base_url('Validation/validation_structure/'.($id ?? ($campagnes[0]['idclients'] ?? '')).'?action=export'); ?>" class="btn btn-export" target="_blank">
      <i class="fa fa-file-pdf"></i> Exporter en PDF
    </a>
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

            <div class="form-group"><label>Nom du groupe</label><input type="text" name="nom_groupe" id="edit_nom_groupe" class="form-control"></div>
            <div class="form-group"><label>Mots-Clés</label><textarea name="mot_cle" id="edit_mot_cle" class="form-control" rows="3"></textarea></div>
            <div class="row">
              <div class="col-md-6"><label>Titres (12 max)</label><textarea name="titres" id="edit_titres" class="form-control" rows="5"></textarea></div>
              <div class="col-md-6"><label>Descriptions (4 max)</label><textarea name="descriptions" id="edit_descriptions" class="form-control" rows="5"></textarea></div>
            </div>
            <div class="form-group mt-3"><label>URL</label><input type="text" name="url_groupe_annonce" id="edit_url_groupe_annonce" class="form-control"></div>

            <div class="d-flex justify-content-between align-items-center mt-4">
              <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#modalGestionImages"><i class="fa fa-image"></i> Gérer les images</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button>
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

</div><!-- /.container -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Dataset JS
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
        url_groupe_annonce:<?= json_encode($G['url_groupe_annonce'] ?? '') ?>
      },
    <?php endforeach; ?>
  <?php endforeach; ?>
<?php endif; ?>
];

// Actions
function openEditCampaign(id){
  const campagne = (campagnesJS || []).find(c => String(c.idcampagne) === String(id));
  if(!campagne) return;
  document.getElementById('edit_idcampagne').value = campagne.idcampagne || '';
  document.getElementById('edit_zones').value = campagne.zones || '';
  document.getElementById('edit_date_campagne').value = campagne.date_campagne || '';
  document.getElementById('edit_appareil').value = campagne.appareil || '';
  document.getElementById('edit_budget').value = campagne.repartition_budget || '';
  document.getElementById('edit_nom_campagne').value = campagne.nom_campagne || '';
  const motsCles = (campagne.groupes_annonces || []).map(g => g.mot_cle || '').filter(Boolean).join("\n");
  document.getElementById('edit_mot_cle_campaign').value = motsCles;
  $('#modalEditCampaign').modal('show');
}

function openEditGroupe(id){
  const groupe = (groupesData || []).find(g => String(g.idgroupe_annonce) === String(id));
  if(!groupe) return;
  document.getElementById('edit_idgroupe_annonce').value = groupe.idgroupe_annonce || '';
  document.getElementById('edit_idcampagne').value = groupe.idcampagne || '';
  document.getElementById('edit_idclients').value = groupe.idclients || '';
  document.getElementById('edit_nom_groupe').value = groupe.nom_groupe || '';
  document.getElementById('edit_mot_cle').value = groupe.mot_cle || '';
  document.getElementById('edit_titres').value = (groupe.titres || []).join("\n");
  document.getElementById('edit_descriptions').value = (groupe.descriptions || []).join("\n");
  document.getElementById('edit_url_groupe_annonce').value = groupe.url_groupe_annonce || '';
  $('#modalEditGroupe').modal('show');
}
</script>
</body>
</html>
