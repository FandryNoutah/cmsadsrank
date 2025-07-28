


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Validation client</title>
    <!-- Font Awesome for icons (local) -->
    <link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet">
    <style>
        /* Only page-break CSS */
        .section { 
            page-break-before: always; 
            margin-top: 50px;
        }
        .section:first-child { page-break-before: auto; }
        td{
            background-color: white! important;
        }
    </style>

</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">

    <div style="width: 90%; max-width: 1140px; margin: 0 auto; padding: 15px;">
        <!-- Campagne Google ADS Section -->
        <div class="section">
            <h1 style="text-align: center; margin-bottom: 15px; font-size: 2em;">Campagne Google ADS</h1>
            <div style="display: flex; margin-bottom: 15px;">
                <div style="width: 50%; padding: 15px;">
                    <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                </div>
                <div style="width: 50%; padding: 15px; text-align: right;">
                    <h1 style="margin: 0; font-size: 2em;">Campagne</h1>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                <thead style="background-color: #4EA5FE; color: #fff;">
                    <tr>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Zone</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Calendrier</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Appareils</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Budget</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Campagne</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Groupe d'annonces</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Mots-clés</th>
						<?php if ($action !== "export"): ?>
                        	<th style="padding: 12px; border: 1px solid #dee2e6;">Action</th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($donne_valider)): ?>
                        <tr><td colspan="8" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Aucune donnée disponible</td></tr>
                    <?php else: ?>
                        <?php foreach ($donne_valider as $D): ?>
                            <?php $countG = count($D['groupes_annonces']); ?>
                            <?php if ($countG == 0): ?>
                                <tr><td colspan="8" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Aucun groupe d'annonces</td></tr>
                            <?php else: ?>
                                <?php for ($i = 0; $i < $countG; $i++): ?>
                                    <tr style="background-color: <?php echo ($i % 2 == 0) ? '#f8f9fa' : '#fff'; ?>;">
                                        <?php if ($i == 0): ?>
                                            <td rowspan="<?php echo $countG; ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $D['zones']; ?></td>
                                            <td rowspan="<?php echo $countG; ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $D['date_campagne']; ?></td>
                                            <td rowspan="<?php echo $countG; ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $D['appareil']; ?></td>
                                            <td rowspan="<?php echo $countG; ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $D['repartition_budget']; ?> €</td>
                                            <td rowspan="<?php echo $countG; ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $D['nom_campagne']; ?></td>
                                        <?php endif; ?>
                                        <td style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $D['groupes_annonces'][$i]['nom_groupe']; ?></td>
                                        <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                            <?php
												$motCles = explode("\n", $D['groupes_annonces'][$i]['mot_cle']);
												echo implode('<br>', array_map('trim', $motCles));
                                            ?>
                                        </td>

										<?php if ($action !== "export"): ?>
											<td style="padding: 12px; border: 1px solid #dee2e6;">
												<?php echo anchor("Validation/editcampagne/" . $D['idcampagne'], '<i class="fas fa-edit"></i>', ['style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;', 'data-edit' => $D['idcampagne']]); ?>
											</td>
										<?php endif; ?>
                                    </tr>
                                <?php endfor; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

		<div class="section">
			<h1 style="text-align: center; margin-bottom: 15px; font-size: 2em;">Groupe Annonce</h1>
			<div style="display: flex; margin-bottom: 15px;">
				<div style="width: 50%; padding: 15px;">
					<img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
				</div>
				<div style="width: 50%; padding: 15px; text-align: right;">
					<h1 style="margin: 0; font-size: 2em;">Annonce</h1>
				</div>
			</div>
				<!-- Groupe Annonce Section -->
				<?php if (!empty($groupe_valider)): ?>
					<?php foreach ($groupe_valider as $G): ?>
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff; margin-bottom: 30px;">
                        <tbody>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;"><?php if ($action !== "export"): ?>
										<?php if ($G['type_campagnes'] == 1): ?>
											<b><?php echo anchor("Validation/editgroupesearch/" . $G['idgroupe_annonce'], '<i class="fas fa-edit"></i>', ['style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none; float: right;', 'data-edit' => $G['idgroupe_annonce']]); ?></b>
										<?php elseif ($G['type_campagnes'] == 2): ?>
											<b><?php echo anchor("Validation/editgroupelocal/" . $G['idgroupe_annonce'], '<i class="fas fa-edit"></i>', ['style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none; float: right;', 'data-edit' => $G['idgroupe_annonce']]); ?></b>
										<?php elseif ($G['type_campagnes'] == 3): ?>
											<b><?php echo anchor("Validation/editgroupepmax/" . $G['idgroupe_annonce'], '<i class="fas fa-edit"></i>', ['style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none; float: right;', 'data-edit' => $G['idgroupe_annonce']]); ?></b>
										<?php endif; ?>
									<?php endif; ?>Campagne</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                    <b><?php echo $G['nom_campagne']; ?></b>

									
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Groupe d'annonces</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><b><?php echo $G['nom_groupe']; ?></b></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Titres</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo implode('<br>', array_filter([$G['titre1'], $G['titre2'], $G['titre3'], $G['titre4'], $G['titre5'], $G['titre6'], $G['titre7'], $G['titre8'], $G['titre9'], $G['titre10'], $G['titre11'], $G['titre12']])); ?></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Descriptions</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo implode('<br>', array_filter([$G['descriptions1'], $G['descriptions2'], $G['descriptions3'], $G['descriptions4']])); ?></td>
                            </tr>
                            <?php if ($G['type_campagnes'] == 3 || $G['type_campagnes'] == 2): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Description brève</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['description_breve']; ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($G['type_campagnes'] == 1): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Chemin 1</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['chemin1']; ?></td>
                                </tr>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Chemin 2</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['chemin2']; ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">URL</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><a href="<?php echo $G['url_groupe_annonce']; ?>" target="_blank" style="color: #4EA5FE; text-decoration: none;"><?php echo $G['url_groupe_annonce']; ?></a></td>
                            </tr>
                            <?php if ($G['type_campagnes'] == 5): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Logo</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                        <img src="<?php echo $G['logo_client']; ?>" alt="Logo" style="max-width: 100px; width: 100%; height: auto;">
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($G['type_campagnes'] == 3): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Logo</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center">
                                                            <img src="<?= base_url($clients[0]['logo_client']) ?>" alt="Image" style="width: 160px; height: auto; object-fit: cover; margin-bottom: 15px;">
                                    </td>

                                </tr>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Images</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; flex-direction: column; gap: 15px;">
                                            <?php if (empty($images)): ?>
                                                <div style="width: 100%; padding: 15px; text-align: center;">Aucune image disponible</div>
                                            <?php else: ?>
                                                <?php $counter = 0; ?>
                                                <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Première ligne -->
                                                <?php foreach ($images as $image): ?>
                                                    <div id="image-<?= $image->id ?>" data-id="<?= $image->id ?>">
                                                        <?php if (strpos($image->image_url, 'http') === 0): ?>
                                                            <img src="<?= $image->image_url ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                                        <?php else: ?>
                                                            <img src="<?= base_url($image->image_url) ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                                        <?php endif; ?>
                                                    </div>

                                                    <?php $counter++; ?>

                                                    <?php if ($counter % 5 == 0 && $counter !== count($images)): ?>
                                                        </div> <!-- Fin de la ligne actuelle -->
                                                        <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Nouvelle ligne -->
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </div> <!-- Fermeture de la dernière ligne -->
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($action !== "export"): ?>
                                            <?php echo anchor("Validation/gestion_image/" . $G['idgroupe_annonce'], '<i class="fas fa-edit"></i>', [
                                                'style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none; float: right;',
                                                'data-edit' => $G['idgroupe_annonce']
                                            ]); ?>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endif; ?>
                            <?php if ($G['type_campagnes'] == 2): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Logo</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center">
                                                            <img src="<?= base_url($clients[0]['logo_client']) ?>" alt="Image" style="width: 160px; height: auto; object-fit: cover; margin-bottom: 15px;">
                                    </td>

                                </tr>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Images</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                                        <?php if (empty($images_local)): ?>
                                            <div style="width: 100%; padding: 15px; text-align: center;">Aucune image disponible</div>
                                        <?php else: ?>
                                            <?php $counter = 0; ?>
                                            <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;">
                                            <?php foreach ($images_local as $image): ?>
                                                <div class="col-md-2" id="image-<?= $image->id ?>" data-id="<?= $image->id ?>" style="padding: 0;">
                                                    <div class="image-card" style="display: flex; justify-content: center;">
                                                        <?php if (strpos($image->image_url, 'http') === 0): ?>
                                                            <img src="<?= $image->image_url ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                                        <?php else: ?>
                                                            <img src="<?= base_url($image->image_url) ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <?php $counter++; ?>
                                                <?php if ($counter % 5 == 0 && $counter !== count($images_local)): ?>
                                                    </div><div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;">
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($action !== "export"): ?>
                                            <?php echo anchor("Validation/gestion_image/" . $G['idgroupe_annonce'], '<i class="fas fa-edit"></i>', [
                                                'style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none; float: right;',
                                                'data-edit' => $G['idgroupe_annonce']
                                            ]); ?>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endif; ?>
                            <?php if ($G['type_campagnes'] == 3 && $action !== "export"): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Inventaire</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
										<?php if ($action !== "export"): ?>
                                        	<?php echo anchor("Googleads/visualiser/" . $G['idclients'], '<i class="fas fa-plus"></i> Inventaire', ['style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;', 'data-edit' => $G['idclients']]); ?>
										<?php endif ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($G['type_campagnes'] == 2 && $action !== "export"): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4EA5FE; color: #fff; width: 20%;">Inventaire</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
										<?php if ($action !== "export"): ?>
                                        	<?php echo anchor("Googleads/inventaire_local/" . $G['idclients'], '<i class="fas fa-plus"></i> Inventaire', ['style' => 'display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;', 'data-edit' => $G['idclients']]); ?>
										<?php endif ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
					
        <!-- Extensions Section -->
        <?php if (!empty($extensions) && is_array($extensions)): ?>
            <div class="section">
                <div style="display: flex; margin-bottom: 15px;">
                    <div style="width: 50%; padding: 15px;">
                        <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                    </div>
                    <div style="width: 50%; padding: 15px; text-align: right;">
                        <h1 style="margin: 0; font-size: 2em;">Extensions</h1>
                    </div>
                </div>
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                    <thead style="background-color: #4EA5FE; color: #fff;">
                        <tr>
                            <th style="padding: 12px; border: 1px solid #dee2e6; width:40px;"></th>
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
                            <tr style="background-color: <?php echo ($i % 2 == 0) ? '#f8f9fa' : '#fff'; ?>;">
                                <td> <?php echo anchor("Validation/editextensions/".$E['idextensions'], '<i class="fas fa-edit" style="margin-left: 10px;display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;"></i>','data-edit="'.$E['idextensions'].'"'); ?>
                               </td>
                                <td style="padding: 12px; border: 1px solid #dee2e6;">
                               
                                    <strong><?php echo $E['titre_extensions']; ?></strong><br>
                                    <?php echo nl2br(wordwrap($E['description_extensions'], 35, "\n", true)); ?>
                                    <br>
                                    <?php
                                    $url = $E['url_extensions'];

                                    // Coupe à ".com" ou ".fr"
                                    $cut_pos = false;

                                    if (strpos($url, '.com/') !== false) {
                                        $cut_pos = strpos($url, '.com/') + 4;
                                    } elseif (strpos($url, '.fr/') !== false) {
                                        $cut_pos = strpos($url, '.fr/') + 3;
                                    } elseif (strpos($url, '.com') !== false) {
                                        $cut_pos = strpos($url, '.com') + 4;
                                    } elseif (strpos($url, '.fr') !== false) {
                                        $cut_pos = strpos($url, '.fr') + 3;
                                    }

                                    // Récupération de l'URL à afficher
                                    $display_url = $cut_pos ? substr($url, 0, $cut_pos) : $url;

                                    // Ajout de "/(...)" si l'URL est plus longue
                                    if ($cut_pos && strlen($url) > $cut_pos) {
                                        $display_url .= '/(...)';
                                    }
                                    ?>

                                    <a href="<?php echo $E['url_extensions']; ?>" style="color: #4EA5FE; text-decoration: none;">
                                        <?php echo htmlspecialchars($display_url); ?>
                                    </a>


                                </td>
                                <?php if ($i === 0): ?>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6; text-align: center">
                                        <?php echo nl2br($E['extensions_accroche']); ?>
                                    </td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6; text-align: center">
                                    <?php echo nl2br($E['extensions_extrait_site']); ?>
                                    </td>

                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6; width: 150px;"><?php echo $E['extensions_lieu']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;width: 130px; text-align: center"><?php echo $E['extensions_appel']; ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>


        <!-- Mots Clés à exclure Section -->
        <div class="section">
            <div style="display: flex; margin-bottom: 15px;">
                <div style="width: 50%; padding: 15px;">
                    <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                </div>
                <div style="width: 50%; padding: 15px; text-align: right;">
                    <h1 style="margin: 0; font-size: 2em;">Mots Clés à exclure</h1>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                <thead style="background-color: #4EA5FE; color: #fff;">
                    <tr>
                        <th colspan="2" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Liste 
                        <?php echo anchor("Validation/exclusion/".$D['idclients'], '<i class="fas fa-edit" style="display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;"></i>','data-edit="'.$D['idclients'].'" class="open-popup"'); ?>
 </th>
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
                            <tr style="background-color: <?php echo ($i % 2 == 0) ? '#f8f9fa' : '#fff'; ?>;">
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


            <!-- Popup (initialement masqué) -->
            <div id="popupForm" style="display:none;">
                <div class="popup-content">
                <form action="<?php echo site_url('Validation/exclusion'); ?>" method="post">
               
                <h4 style="font-weight: 600">Mot clé à exclure</h4>
                
                <!-- Champ caché pour l'ID du client -->
                <input type="hidden" name="idclients" value="<?php echo htmlspecialchars($D['idclients'], ENT_QUOTES, 'UTF-8'); ?>" /> 
                
                <!-- Zone de texte pré-remplie avec la valeur de l'exclusion -->
                <textarea id="comment" name="exclusion" class="large-textarea"><?php echo htmlspecialchars($D['exclusion'], ENT_QUOTES, 'UTF-8'); ?></textarea><br>
                
                <button type="submit"  style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">Valider</button>
            </form>

    </div>
    
</div>
<?php if ($action !== "export"): ?>
			<?php $F = intval($donne_valider[0]['idclients']); ?>
			<div style="display: flex; justify-content: center; margin-top: 30px; margin-bottom: 30px; gap: 15px;">
				<div style="padding: 15px;">
					<?php echo anchor(
						"Googleads/save_campagne_clients/" . $F,
						'<i class="fa fa-check"></i> Valider la campagne',
						['style' => 'display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #28a745; border: 1px solid #28a745; border-radius: 4px; text-decoration: none;']
					); ?>
				</div>
				<div style="padding: 15px;">
					<a href="<?php echo base_url('Validation/export_rendu/' . $id ); ?>" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;" target="_blank">
						Exporter en PDF
					</a>
				</div>
			</div>
		<?php endif; ?>
<!-- Style du Popup -->
<style>
    #popupForm {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999; /* S'assurer qu'il soit au-dessus des autres éléments */
    }
    .popup-content {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
        height: 900px; 
        margin-left: 39%;
    }

    textarea {
        width: 100%;
        height: 100px;
    }
    .large-textarea {
        width: 100%; /* Occupe toute la largeur du parent */
        height: 750px; /* Définit une hauteur de 500px */
        font-size: 16px; /* Vous pouvez ajuster la taille du texte ici si nécessaire */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Lorsque le lien avec la classe "open-popup" est cliqué
    $('.open-popup').on('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien

        // Affiche le popup
        $('#popupForm').fadeIn();
    });

    // Lorsque le bouton "Fermer" est cliqué
    $('#closePopup').on('click', function() {
        // Masque le popup
        $('#popupForm').fadeOut();
    });

    // Lorsque l'utilisateur clique en dehors du popup, il se ferme
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.popup-content').length && !$(event.target).closest('.open-popup').length) {
            $('#popupForm').fadeOut();
        }
    });
});
</script>

</body>
</html>