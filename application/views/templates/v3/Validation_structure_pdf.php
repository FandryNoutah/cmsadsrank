<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Validation client</title>
    <!-- Font Awesome for icons (local) -->
    <link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/inventaire_pmax_pdf.css'); ?>" rel="stylesheet">
    <style>
        /* Only page-break CSS */
        .section { page-break-before: always; }
        .section:first-child { page-break-before: auto; }
        td {
        font-size: 13px! important;
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


            <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                <thead style="background-color: #007bff; color: #fff;">
                    <tr>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Zone</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Calendrier</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6; width: 70px;">Appareils</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Budget</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6; width: 120px;">Campagne</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6; width: 120px;">Groupe d'annonces</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;width: 250px;">Mots-clés</th>
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
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Campagne</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                    <b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b>

									
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Groupe d'annonces</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><b><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></b></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Titres</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;   text-transform: capitalize;"> <?php
                                $titres = [];
                                for ($i=1;$i<=12;$i++) if (!empty($G['titre'.$i])) $titres[] = htmlspecialchars($G['titre'.$i]);
                                echo !empty($titres) ? implode('<br>', $titres) : 'Aucun titre';
                                ?></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;   text-transform: capitalize;">Descriptions</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;   text-transform: capitalize;"><?php
                            $desc = [];
                            for ($i=1;$i<=4;$i++) if (!empty($G['descriptions'.$i])) $desc[] = htmlspecialchars($G['descriptions'.$i]);
                            echo !empty($desc) ? implode('<br>', $desc) : 'Aucune description';
                            ?></td>
                            </tr>
                             <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Images</th>
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
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Chemin 1</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['chemin1']; ?></td>
                                </tr>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Chemin 2</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['chemin2']; ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">URL</th>
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
                                    <a href="<?php echo $E['url_extensions']; ?>" style="color: #007bff; text-decoration: none;"><?php echo $E['url_extensions']; ?></a>
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
             
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                <h2 style="text-align: right; margin-top: -30px; color: black">Mots Clés à exclure</h2>
            </div>

            <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                <thead style="background-color: #4EA5FE; color: #fff;">
                    <tr>
                        <th colspan="2" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Liste</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $hasContent = false; ?>
                    <?php foreach ($exlusions as $D): ?>
                        <?php if ($D['exclusion'] != NULL): ?>
                            <?php $hasContent = true; ?>
                            <?php
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
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo nl2br($firstPart); ?></td>
                                <?php if (!empty($secondPart)): ?>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo nl2br($secondPart); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if (!$hasContent): ?>
                        <tr><td colspan="2" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Aucune exclusion</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>
   