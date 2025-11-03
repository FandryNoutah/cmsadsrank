<?php
/**
 * Validation_structure_pdf.php
 * Vue réécrite pour affichage et export PDF (Dompdf).
 */
?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Validation client – Campagne Google Ads</title>

<?php if (empty($is_pdf)): ?>
    <link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php endif; ?>

<style>
/* === CSS compatible Dompdf (remplacer l'ancien <style>) === */

@page {
  margin: 20mm 15mm; /* marges page */
}

:root{
  --primary:#4EA5FE;
  --bg-card:#ffffff;
  --text-dark:#333;
  --border:#e0e0e0;
}

body{
  font-family: "DejaVu Sans", Arial, sans-serif;
  color:var(--text-dark);
  background:#fff; /* Dompdf ignore souvent body background but keep */
  margin:0; padding:0;
}

.container{
  width:95%;
  max-width:1200px;
  margin:0 auto;
  padding:10px 0 30px;
}

/* Header (campagne) : garder sur UNE page, puis sauter */
.header-section{
  page-break-inside: avoid;
  page-break-after: always; /* FORCE nouvelle page après la campagne */
  padding-bottom:8px;
}

/* Remplacer .header-row flex par un simple tableau (éviter flex) */
.header-row{
  display:table;
  width:100%;
  table-layout:fixed;
}
.header-row .col-left,
.header-row .col-center,
.header-row .col-right{
  display:table-cell;
  vertical-align:middle;
}
.header-row .col-left, .header-row .col-right{
  width:140px;
}
.header-row img{ max-width:140px; height:auto; display:block; }

/* Sections générales */
.section{
  background:var(--bg-card);
  border-radius:6px;
  padding:10px;
  margin:10px 0;
  page-break-inside: avoid;
}

/* Table global simple */
table{ width:100%; border-collapse:collapse; font-size:12px; }
thead{ background:var(--primary); color:#fff; }
th, td{ padding:8px 10px; border:1px solid var(--border); vertical-align:top; text-align:left; }

/* Groupe card : UNE page par groupe */
.groupe-card{
  background:#fff;
  border:1px solid var(--border);
  border-radius:6px;
  padding:10px;
  margin:0 0 8px 0;
  box-shadow:none; /* éviter */
  page-break-inside: avoid;
  page-break-after: always; /* force chaque groupe sur page séparée */
}

/* Table interne du groupe */
.groupe-card table{ width:100%; border-collapse:collapse; font-size:13px; }
.groupe-card th{ background:var(--primary); color:#fff; padding:8px; width:200px; text-align:left; vertical-align:middle; }
.groupe-card td{ padding:8px; border:1px solid var(--border); vertical-align:middle; text-align:left; }

/* Images : pas de flex, utiliser inline-block */
.images-row{ display:block; text-align:left; margin-top:6px; }
.images-row .img-wrap{ display:inline-block; margin:4px; vertical-align:top; }
.images-row img{
  display:block;
  max-width:120px;
  max-height:90px;
  width:auto;
  height:auto;
  border-radius:4px;
}

/* Cacher éléments interactifs dans le PDF */
.edit-btn, .action-btns, .btn{ display:none !important; }

/* Titres */
h1,h2{ color:var(--primary); text-align:center; margin:6px 0 12px 0; font-weight:600; }

/* petites précautions */
* { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

</style>
</head>
<body>
<div class="container">

    <div class="section header-section" style="page-break-inside:avoid;">
        <div class="header-row">
            <?php if (!empty($logo_base64)): ?>
                <img src="<?= htmlspecialchars($logo_base64); ?>" alt="Logo">
            <?php else: ?>
                <div style="width:140px;height:40px;"></div>
            <?php endif; ?>
            <h1>Campagne Google Ads</h1>
            <div style="width:140px;"></div>
        </div>
    </div>

    <!-- Tableau global des campagnes (inchangé) -->
    <div class="section">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Calendrier</th>
                    <th>Appareils</th>
                    <th>Budget</th>
                    <th>Campagne</th>
                    <th>Groupe</th>
                    <th>Mots-Clés</th>
                    <?php if (empty($is_pdf)): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($campagnes) && is_array($campagnes)): ?>
                <?php foreach($campagnes as $C): 
                    $zones = htmlspecialchars($C['zones'] ?? '—');
                    $date_campagne = htmlspecialchars($C['date_campagne'] ?? '—');
                    $appareil = htmlspecialchars($C['appareil'] ?? '—');
                    $budget = htmlspecialchars($C['repartition_budget'] ?? '—');
                    $nom_campagne = htmlspecialchars($C['nom_campagne'] ?? '—');
                    $groupes = $C['groupes_annonces'] ?? [];
                ?>
                    <?php if (!empty($groupes)): ?>
                        <?php foreach ($groupes as $G): 
                            $nom_groupe = htmlspecialchars($G['nom_groupe'] ?? '—');
                            $mot_cle = nl2br(htmlspecialchars($G['mot_cle'] ?? '—'));
                        ?>
                        <tr>
                            <td><?= $zones; ?></td>
                            <td><?= $date_campagne; ?></td>
                            <td><?= $appareil; ?></td>
                            <td><?= $budget !== '—' ? $budget . ' €' : '—'; ?></td>
                            <td><b><?= $nom_campagne; ?></b></td>
                            <td><?= $nom_groupe; ?></td>
                            <td><?= $mot_cle; ?></td>
                            <?php if (empty($is_pdf)): ?>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="openEditCampaign('<?= htmlspecialchars($C['idcampagne']); ?>')">
                                    <i class="fa fa-edit"></i> Modifier
                                </button>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td><?= $zones; ?></td>
                            <td><?= $date_campagne; ?></td>
                            <td><?= $appareil; ?></td>
                            <td><?= $budget !== '—' ? $budget . ' €' : '—'; ?></td>
                            <td><b><?= $nom_campagne; ?></b></td>
                            <td colspan="<?= empty($is_pdf) ? 3 : 2; ?>">Aucun groupe d'annonce</td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="<?= empty($is_pdf) ? 8 : 7; ?>">Aucune campagne disponible.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Aperçu des groupes d'annonces (modifié) -->
    <div class="section">
        <h2 style="margin-bottom:12px;">Aperçu des Groupes d'Annonces</h2>

        <?php if (!empty($campagnes) && is_array($campagnes)): ?>
            <?php foreach ($campagnes as $C): 
                $groupes = $C['groupes_annonces'] ?? [];
                $camp_images = $C['images'] ?? [];
            ?>
                <?php foreach ($groupes as $G): ?>
                <div class="groupe-card">
                    <table>
                        <tr>
                            <th>Campagne</th>
                            <td><b><?= ucfirst(htmlspecialchars($C['nom_campagne'] ?? '—')); ?></b></td>
                        </tr>
                        <tr>
                            <th>Groupe</th>
                            <td><b><?= ucfirst(htmlspecialchars($G['nom_groupe'] ?? '—')); ?></b></td>
                        </tr>
                        <tr>
                            <th>Titres</th>
                            <td>
                                <?php
                                    $titres_html = 'Aucun titre';
                                    $titres = [];
                                    for ($i = 1; $i <= 12; $i++) {
                                        if (!empty($G['titre'.$i])) $titres[] = ucfirst(htmlspecialchars($G['titre'.$i]));
                                    }
                                    if (!empty($titres)) $titres_html = implode('<br>', $titres);
                                    echo $titres_html;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Descriptions</th>
                            <td>
                                <?php
                                    $desc_html = 'Aucune description';
                                    $descs = [];
                                    for ($i = 1; $i <= 4; $i++) {
                                        if (!empty($G['descriptions'.$i])) $descs[] = ucfirst(htmlspecialchars($G['descriptions'.$i]));
                                    }
                                    if (!empty($descs)) $desc_html = implode('<br>', $descs);
                                    echo $desc_html;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Images</th>
                            <td>
                                <div class="images-row">
                                    <?php
                                    if (!empty($camp_images) && is_array($camp_images)) {
                                        foreach ($camp_images as $img) {
                                            $image_base64 = is_object($img) ? ($img->image_base64 ?? '') : ($img['image_base64'] ?? '');
                                            $image_url = is_object($img) ? ($img->image_url ?? '') : ($img['image_url'] ?? '');
                                            $src = $image_base64 ?: $image_url;
                                            if ($src) {
                                                echo '<span class="img-wrap"><img src="'.htmlspecialchars($src).'" alt="Image annonce"></span>';
                                            }
                                        }
                                    } else {
                                        echo '<span>—</span>';
                                    }
                                    ?>
                                    </div>

                            </td>
                        </tr>
                        <tr>
                            <th>URL</th>
                            <td>
                                <?php $url = htmlspecialchars($G['url_groupe_annonce'] ?? ''); ?>
                                <?php if ($url): ?>
                                    <?php if (empty($is_pdf)): ?>
                                        <a href="<?= $url; ?>" target="_blank"><?= $url; ?></a>
                                    <?php else: ?>
                                        <?= $url; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    &mdash;
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <?php if (empty($is_pdf)): ?>
                    <button class="edit-btn" onclick="openEditGroupe('<?= htmlspecialchars($G['idgroupe_annonce'] ?? ''); ?>')">
                        <i class="fa fa-edit"></i> Modifier ce groupe
                    </button>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun groupe d'annonces à afficher.</p>
        <?php endif; ?>
    </div>

    <?php if (empty($is_pdf)): ?>
    <div class="action-btns">
        <a href="<?= base_url('Googleads/save_campagne_clients/'.($campagnes[0]['idcampagne'] ?? '')); ?>" class="btn btn-validate"><i class="fa fa-check"></i> Valider la campagne</a>
        <a href="<?= base_url('Validation/export_rendu/'.$campagnes[0]['idclients'].'?action=export'); ?>" class="btn btn-export" target="_blank"><i class="fa fa-file-pdf"></i> Exporter en PDF</a>
    </div>
    <?php endif; ?>

</div>

<?php if (empty($is_pdf)): ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEditCampaign(id){ console.log('openEditCampaign', id); }
function openEditGroupe(id){ console.log('openEditGroupe', id); }
</script>
<?php endif; ?>

</body>
</html>
