<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Validation client</title>
    
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
    <link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/inventaire_pmax_pdf.css'); ?>" rel="stylesheet">
    <style>
        /* Only page-break CSS */
        .section { page-break-before: always; }
        .section:first-child { page-break-before: auto; }
        td {
        font-size: 13px! important;
        }
        table th { 
  text-align: left !important; 
}
table td {
  text-align: center !important;
  vertical-align: middle !important;
}

    </style>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: white;">
    <div style="width: 90%; max-width: 1650px; margin: 0 auto; padding: 15px; margin-top: -50px;">
        <div class="section">
            <h1 style="text-align: center; margin-bottom: 15px; font-size: 2em;">Campagne Google ADS</h1>

            <div>
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                <h2 style="text-align: right; margin-top: -30px;">Campagne</h2>
            </div>


            <table style="
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  text-align: center;
  border: 1px solid #d0d0d0; /* contour général gris clair */
">
<thead style="text-align: center;">
  <tr>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #a4c2f4; color: white; width: 100px; text-align: center; vertical-align: middle;">Zone</th>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #a4c2f4; color: white; width: 100px; text-align: center; vertical-align: middle;">Calendrier</th>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #a4c2f4; color: white; width: 100px; text-align: center; vertical-align: middle;">Appareils</th>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #a4c2f4; color: white; width: 100px; text-align: center; vertical-align: middle;">Budget</th>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #4ea5fe; color: white; width: 100px; text-align: center; vertical-align: middle;">Campagne</th>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #4ea5fe; color: white; width: 100px; text-align: center; vertical-align: middle;">Groupe d'annonces</th>
    <th style="padding: 12px; border: 1px solid #d0d0d0; background-color: #4ea5fe; color: white; width: 100px; text-align: center; vertical-align: middle;">Mots-clés</th>
  </tr>
</thead>


  <tbody>
    <?php if (!empty($campagnes) && is_array($campagnes)): ?>
      <?php foreach($campagnes as $C): ?>
        <?php $groupes = $C['groupes_annonces'] ?? []; ?>
        <?php if (!empty($groupes)): ?>
          <?php foreach($groupes as $G): ?>
            <tr style="border-bottom: 1px solid #d0d0d0;">
              <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['zones'] ?? '—'); ?></td>
              <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['date_campagne'] ?? '—'); ?></td>
              <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['appareil'] ?? '—'); ?></td>
              <td style="border: 1px solid #d0d0d0;">
                <?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
                <?= $b !== '' ? htmlspecialchars($b).' €' : '—'; ?>
              </td>
              <td style="border: 1px solid #d0d0d0;"><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
              <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></td>
              <td style="border: 1px solid #d0d0d0;"><?= nl2br(htmlspecialchars($G['mot_cle'] ?? '—')); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr style="border-bottom: 1px solid #d0d0d0;">
            <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['zones'] ?? '—'); ?></td>
            <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['date_campagne'] ?? '—'); ?></td>
            <td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['appareil'] ?? '—'); ?></td>
            <td style="border: 1px solid #d0d0d0;">
              <?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
              <?= $b !== '' ? htmlspecialchars($b).' €' : '—'; ?>
            </td>
            <td style="border: 1px solid #d0d0d0;"><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
            <td style="border: 1px solid #d0d0d0;" colspan="3">Aucun groupe d’annonce</td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="8" style="border: 1px solid #d0d0d0;">Aucune campagne disponible.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

        </div>
        
            <?php if (!empty($campagnes) && is_array($campagnes)): ?>
                <?php foreach ($campagnes as $C): ?>
                    <?php $groupes = $C['groupes_annonces'] ?? []; $campImages = $C['images'] ?? []; ?>
                    <?php foreach ($groupes as $G): ?>            
        <div class="section">
            <div>
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                <h2 style="text-align: right; margin-top: -30px;">Annonce</h2>
            </div>
          			
                  <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff; margin-bottom: 30px;">
                        <tbody>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Campagne</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                    <b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b>

									
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Groupe d'annonces</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><b><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></b></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Titres</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;   text-transform: capitalize;"> <?php
                                $titres = [];
                                for ($i=1;$i<=12;$i++) if (!empty($G['titre'.$i])) $titres[] = htmlspecialchars($G['titre'.$i]);
                                echo !empty($titres) ? implode('<br>', $titres) : 'Aucun titre';
                                ?></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;   text-transform: capitalize;">Descriptions</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;   text-transform: capitalize;"><?php
                            $desc = [];
                            for ($i=1;$i<=4;$i++) if (!empty($G['descriptions'.$i])) $desc[] = htmlspecialchars($G['descriptions'.$i]);
                            echo !empty($desc) ? implode('<br>', $desc) : 'Aucune description';
                            ?></td>
                            </tr>
                             <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Images</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                    
                                <div class="images-row" >   
                                <?php if (!empty($campImages) && is_array($campImages)): ?>
                                <?php foreach($campImages as $img):
                                    $b64 = is_object($img) ? ($img->image_base64 ?? '') : ($img['image_base64'] ?? '');
                                    $url = is_object($img) ? ($img->image_url ?? '')    : ($img['image_url'] ?? '');
                                    $src = $b64 ?: $url;
                                    if ($src): ?>
                                    <img src="<?= htmlspecialchars($src); ?>" alt="Image annonce" style="width:160px;height:120px;border-radius:10px; margin-top: 20px;">
                                    <?php endif; endforeach; ?>
                                <?php else: ?>
                                — 
                                <?php endif; ?>
                                </div>
                            </tr>                        
                             <?php if ($G['type_campagnes'] == 1): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Chemin 1</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['chemin1']; ?></td>
                                </tr>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Chemin 2</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['chemin2']; ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">URL</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                        <?php $url = trim((string)($G['url_groupe_annonce'] ?? '')); ?>
                                <?php if ($url): ?>
                                    <a href="<?= htmlspecialchars($url); ?>" target="_blank" rel="noopener"><?= htmlspecialchars($url); ?></a>
                                <?php else: ?>—<?php endif; ?></td>
                                </tr>
                        
                            
                            
                        </tbody>
                    </table>
           
             </div>  
             <?php endforeach; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Aucun groupe d'annonces à afficher.</p>
            <?php endif; ?>


            <?php if (!empty($extensions) && is_array($extensions)): ?>
            <div class="section">
     
                <div>
                    <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                    <h2 style="text-align: right; margin-top: -30px; color: black">Extensions</h2>
                </div>

                <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                    <thead style="background-color: #4EA5FE; color: #fff;">
                        <tr>
                            <th style="padding: 12px; border: 1px solid #dee2e6;">Liens annexes</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6;">Accroche</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6;">Extraits de site</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6;">Lieu</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6;">Appel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($extensions as $E): ?>
                            <tr style="background-color: <?php echo ($i % 2 == 0) ? '#fff' : '#fff'; ?>;">
                                <td style="padding: 12px; border: 1px solid #dee2e6;">
                                    <strong><?php echo $E['titre_extensions']; ?></strong><br>
                                    <?php echo $E['description_extensions']; ?><br>
                                    <a href="<?php echo $E['url_extensions']; ?>" style="color: #4ea5fe; text-decoration: none;"><?php echo $E['url_extensions']; ?></a>
                                </td>
                                <?php if ($i === 0): ?>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;text-align: center;"><?php echo $E['extensions_accroche']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;text-align: center;"><?php echo $E['extensions_extrait_site']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;text-align: center;"><?php echo $E['extensions_lieu']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;text-align: center;"><?php echo $E['extensions_appel']; ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
        <?php endif; ?>

        <div class="section">
            <img src="<?php echo $logo_base64; ?>" alt="Logo" 
                style="max-width: 150px; width: 100%; height: auto;">
            <h2 style="text-align: right; margin-top: -30px; color: black;">
                Mots Clés à exclure
            </h2>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
            <thead style="background-color: #4EA5FE; color: #fff;">
                <tr>
                    <th colspan="2" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                        Liste
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $hasContent = false; ?>
                <?php foreach ($exlusions as $D): ?>
                    <?php if ($D['exclusion'] != NULL): ?>
                        <?php 
                            $hasContent = true;
                            $exclusion = htmlspecialchars($D['exclusion']);
                            $lines = explode("\n", $exclusion);
                            $lineCount = count($lines);

                            if ($lineCount > 21) {
                                $firstPart = implode("\n", array_slice($lines, 0, 21));
                                $secondPart = implode("\n", array_slice($lines, 21));
                            } else {
                                $firstPart = $exclusion;
                                $secondPart = '';
                            }
                        ?>
                        <tr style="background-color: <?php echo ($i % 2 == 0) ? '#fff' : '#fff'; ?>;">
                            <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                <?php echo nl2br($firstPart); ?>
                            </td>
                            <?php if (!empty($secondPart)): ?>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                    <?php echo nl2br($secondPart); ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (!$hasContent): ?>
                    <tr>
                        <td colspan="2" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                            Aucune exclusion
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


       <!-- Inventaire PMAX -->
    <div class="section">
        <img src="<?php echo $logo_base64; ?>" alt="Logo"
            style="max-width: 150px; width: 100%; height: auto;">

        <h2 style="text-align: right; margin-top: -30px; color: black;">
            Inventaire PMax
        </h2>

        <?php foreach ($groupe_valider as $groupe): ?>
            <?php if ($groupe['type_campagne'] == 3): ?>

                <div class="row row-cols-5 mb-4 small" style="margin-left: 20px;">
                    <!-- YouTube -->
                    <div class="col-auto">
                        <div class="device-frame phone-frame">
                            <div class="screen">

                                <div class="d-flex justify-content-between align-items-center">
                                    <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PCFET0NUWVBFIHN2ZyAgUFVCTElDICctLy9XM0MvL0RURCBTVkcgMS4xLy9FTicgICdodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQnPjxzdmcgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB3aWR0aD0iMTAwJSIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczpzZXJpZj0iaHR0cDovL3d3dy5zZXJpZi5jb20vIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PHBhdGggZD0iTTE1OS44NzQsMjE2LjY5OGMtMS44NzgsLTcuMDI2IC03LjQxLC0xMi41NTggLTE0LjQzNiwtMTQuNDM2Yy0xMi43MzUsLTMuNDEyIC02My43OTYsLTMuNDEyIC02My43OTYsLTMuNDEyYzAsMCAtNTEuMDYxLDAgLTYzLjc5NiwzLjQxMmMtNy4wMjUsMS44NzggLTEyLjU1OCw3LjQxIC0xNC40MzYsMTQuNDM2Yy0zLjQxMSwxMi43MzQgLTMuNDExLDM5LjMwMyAtMy40MTEsMzkuMzAzYzAsMCAwLDI2LjU2OCAzLjQxMSwzOS4zMDFjMS44NzgsNy4wMjYgNy40MTEsMTIuNTU5IDE0LjQzNiwxNC40MzdjMTIuNzM1LDMuNDExIDYzLjc5NiwzLjQxMSA2My43OTYsMy40MTFjMCwwIDUxLjA2MSwwIDYzLjc5NiwtMy40MTFjNy4wMjYsLTEuODc4IDEyLjU1OCwtNy40MTEgMTQuNDM2LC0xNC40MzdjMy40MTMsLTEyLjczMyAzLjQxMywtMzkuMzAxIDMuNDEzLC0zOS4zMDFjMCwwIDAsLTI2LjU2OSAtMy40MTMsLTM5LjMwM1oiIHN0eWxlPSJmaWxsOiNlZDFmMjQ7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PC9nPjwvc3ZnPg=="
                                        alt="YouTube" width="58">
                                    <i class="fa fa-search"></i>
                                </div>

                                <div class="thumb-box" style="height: 140px;">
                                    <img src="<?= $groupe['images'][0] ?? 'https://placehold.co/120x120?text=Youtube+Ads' ?>" 
                                        alt="placeholder">
                                </div>

                                <div class="alert alert-primary border-0 py-0 px-2 d-flex justify-content-between align-items-center">
                                    <span class="small font-weight-bold">Réservation</span>
                                    <i class="fa fa-external-link-alt"></i>
                                </div>

                                <div class="row no-gutters justify-content-between">
                                    <div class="col-auto">
                                        <img src="<?= $groupe['favicon'] ?>" alt="" 
                                            class="rounded-circle" width="38">
                                    </div>
                                    <div class="col px-2">
                                        <p class="font-weight-bold m-0"><?= $groupe['titre1'] ?></p>
                                        <p class="small text-muted m-0"><?= $groupe['descriptions1'] ?></p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </div>
                                </div>

                            </div> <!-- .screen -->
                        </div> <!-- .device-frame -->
                    </div> <!-- .col-auto -->
                </div> <!-- .row -->

            <?php endif; ?>
        <?php endforeach; ?>
    </div> <!-- .section -->

   