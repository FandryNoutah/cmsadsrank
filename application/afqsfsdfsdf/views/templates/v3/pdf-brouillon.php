

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
    </style>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="width: 90%; max-width: 1140px; margin: 0 auto; padding: 15px; margin-top: -50px;">
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
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Appareils</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Budget</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Campagne</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Groupe d'annonces</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Mots-clés</th>
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
                                    </tr>
                                <?php endfor; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($groupe_valider)): ?>
            <?php foreach ($groupe_valider as $G): ?>
		<div class="section">
			<h1 style="text-align: center; margin-bottom: 15px; font-size: 2em;  margin-top: -30px;">Groupe Annonce</h1>
            <div>
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                <h2 style="text-align: right; margin-top: -30px;">Annonce</h2>
            </div>

				<!-- Groupe Annonce Section -->
				
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff; margin-bottom: 30px;">
                        <tbody>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Campagne</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                    <?php echo $G['nom_campagne']; ?>

									
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Groupe d'annonces</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['nom_groupe']; ?></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Titres</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo implode('<br>', array_filter([$G['titre1'], $G['titre2'], $G['titre3'], $G['titre4'], $G['titre5'], $G['titre6'], $G['titre7'], $G['titre8'], $G['titre9'], $G['titre10'], $G['titre11'], $G['titre12']])); ?></td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Descriptions</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo implode('<br>', array_filter([$G['descriptions1'], $G['descriptions2'], $G['descriptions3'], $G['descriptions4']])); ?></td>
                            </tr>
                            <?php if ($G['type_campagnes'] == 3 || $G['type_campagnes'] == 2): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Description brève</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><?php echo $G['description_breve']; ?></td>
                                </tr>
                            <?php endif; ?>
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
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><a href="<?php echo $G['url_groupe_annonce']; ?>" target="_blank" style="color: #007bff; text-decoration: none;"><?php echo $G['url_groupe_annonce']; ?></a></td>
                           
                        </tr>
                            <?php if ($G['type_campagnes'] == 5): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Logo</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                                        <img src="<?php echo $G['logo_client']; ?>" alt="Logo" style="max-width: 100px; width: 100%; height: auto;">
                                    </td>
                                </tr>
                            <?php endif; ?>
                        
                            <?php if ($G['type_campagnes'] == 3): ?>
                              
                                                          
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Images</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                                    <?php if (empty($images)): ?>
                                    <div style="width: 100%; padding: 15px; text-align: center;">Aucune image disponible</div>
                                        <?php else: ?>
                                            <div style="width: 100%; clear: both;">
                                                <?php $counter = 0; ?>
                                                <?php foreach ($images as $image): ?>
                                                    <div style="width: 100px; height: 80px; float: left; margin-right: 10px; margin-bottom: 15px; text-align: center;">
                                                        <?php if (!empty($image->image_base64)): ?>
                                                            <img src="<?= $image->image_base64 ?>" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">
                                                        <?php endif; ?>
                                                    </div>

                                                    <?php $counter++; ?>
                                                    <?php if ($counter % 6 == 0): ?>
                                                        <div style="clear: both;"></div> <!-- Nouvelle ligne après 6 images -->
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <div style="clear: both;"></div> <!-- Nettoyage à la fin -->
                                            </div>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                     
                            <?php if ($G['type_campagnes'] == 2): ?>
                                <tr>
                                    <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Images</th>
                                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; margin: -15px;">
                                          
                                            <?php if (empty($images_local)): ?>
                                          
                                                <div style="width: 100%; padding: 15px; text-align: center;">Aucune image disponible</div>
                                            <?php else: ?>
                                                <?php $counter = 0; ?>
                                                <?php foreach ($images_local as $image): ?>
                                                    <div class="col-md-2" id="image-<?= $image->id ?>" data-id="<?= $image->id ?>" style="padding: 0;"> <!-- Enlève le padding par défaut -->
                                                        <div class="image-card" style="display: flex; justify-content: center;">
                                                            <!-- Vérifier si l'image est locale ou externe -->
                                                            <?php if (strpos($image->image_url, 'http') === 0): ?>
                                                                <!-- Image externe -->
                                                                <img src="<?= $image->image_url ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                                            <?php else: ?>
                                                                <!-- Image locale (dans le dossier 'uploads') -->
                                                                <img src="<?= base_url($image->image_url) ?>" alt="Image" style="width: 160px; height: 120px; object-fit: cover; margin-bottom: 15px;"> <!-- Taille plus petite en format paysage -->
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <?php $counter++; ?>

                                                    <!-- Commencer une nouvelle ligne après chaque 6 images -->
                                                    <?php if ($counter % 6 == 0): ?>
                                                        </div> <!-- Fermeture de la ligne précédente -->
                                                        <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;"> <!-- Nouvelle ligne avec écart -->
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                           
                                        </div>
                                        <?php endif; ?>               
										
                                    </td>
                                </tr>
                            <?php endif; ?>
                            
                        </tbody>
                    </table>
			
		</div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($extensions) && is_array($extensions)): ?>
            <div class="section">
     
            <div>
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                <h2 style="text-align: right; margin-top: -30px;">Extensions</h2>
            </div>

                <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                    <thead style="background-color: #007bff; color: #fff;">
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
                            <tr style="background-color: <?php echo ($i % 2 == 0) ? '#f8f9fa' : '#fff'; ?>;">
                                <td style="padding: 12px; border: 1px solid #dee2e6;">
                                    <strong><?php echo $E['titre_extensions']; ?></strong><br>
                                    <?php echo $E['description_extensions']; ?><br>
                                    <a href="<?php echo $E['url_extensions']; ?>" style="color: #007bff; text-decoration: none;"><?php echo $E['url_extensions']; ?></a>
                                </td>
                                <?php if ($i === 0): ?>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $E['extensions_accroche']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $E['extensions_extrait_site']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $E['extensions_lieu']; ?></td>
                                    <td rowspan="<?php echo count($extensions); ?>" style="padding: 12px; border: 1px solid #dee2e6;"><?php echo $E['extensions_appel']; ?></td>
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
             
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                <h2 style="text-align: right; margin-top: -30px;">Mots Clés à exclure<</h2>
            </div>

            <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; background-color: #fff;">
                <thead style="background-color: #007bff; color: #fff;">
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
        </div>

        <div class="section">        
    
    <div>
        <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
        <h2 style="text-align: right; margin-top: -30px;">Inventaire</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 180px;">
                            <div class="header-mine">
                                <div class="container">
                                    <div class="block">
                                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Youtube</h5>

                                        <div class="ad-item">
                                            <img src="<?php echo $youtube_base64; ?>" alt="Logo" style="max-width: 180px; width: 100%; height: auto;">
                                            <img src="<?= $images[0]->image_base64 ?>" alt="Image" style="max-width: 180px; object-fit: cover;">
                                            <div class="text">
                                                <h6 style="margin-left: 15px; text-decoration: bold; color: black;"><?php echo $G['titre1']; ?></h6>
                                                <p style="font-size: 11px;"><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description"; ?></p><br>
                                                <p style="font-size: 12px;"><b>Annonce - </b> <?php echo $clients[0]['nom_client']; ?></p>
                                            </div>
                                            <div class="ep-btn">
                                                <a href="#" style="font-size: 12px;">En savoir plus</a>
                                            </div>
                                        </div>

                                        <div class="ad-item" style="margin-top: 20px;">
                                            <img src="<?php echo $youtube_base64; ?>" alt="Logo" style="max-width: 180px; width: 100%; height: auto;">
                                            <img src="<?= $images[1]->image_base64 ?>" alt="Image" style="max-width: 180px; object-fit: cover;">
                                            <div class="text">
                                                <h6 style="margin-left: 15px; text-decoration: bold; color: black;"><?php echo !empty($G['titre2']) ? $G['titre2'] : $G['titre1']; ?></h6>
                                                <p style="font-size: 11px;"><?php echo !empty($G['descriptions2']) ? $G['descriptions2'] : "Aucune description"; ?></p><br>
                                                <p style="font-size: 12px;"><b>Annonce - </b> <?php echo $clients[0]['nom_client']; ?></p>
                                            </div>
                                            <div class="ep-btn">
                                                <a href="#" style="font-size: 12px;">En savoir plus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </th>
                <th style="width: 180px;">
                            <div class="header-mine">
                                <div class="container">
                                    <div class="block">
                                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Youtube</h5>

                                        <div class="ad-item">
                                            <img src="<?php echo $youtube_base64; ?>" alt="Logo" style="max-width: 180px; width: 100%; height: auto;">
                                            <img src="<?= $images[0]->image_base64 ?>" alt="Image" style="max-width: 180px; object-fit: cover;">
                                            <div class="text">
                                                <h6 style="margin-left: 15px; text-decoration: bold; color: black;"><?php echo $G['titre1']; ?></h6>
                                                <p style="font-size: 11px;"><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description"; ?></p><br>
                                                <p style="font-size: 12px;"><b>Annonce - </b> <?php echo $clients[0]['nom_client']; ?></p>
                                            </div>
                                            <div class="ep-btn">
                                                <a href="#" style="font-size: 12px;">En savoir plus</a>
                                            </div>
                                        </div>

                                        <div class="ad-item" style="margin-top: 20px;">
                                            <img src="<?php echo $youtube_base64; ?>" alt="Logo" style="max-width: 180px; width: 100%; height: auto;">
                                            <img src="<?= $images[1]->image_base64 ?>" alt="Image" style="max-width: 180px; object-fit: cover;">
                                            <div class="text">
                                                <h6 style="margin-left: 15px; text-decoration: bold; color: black;"><?php echo !empty($G['titre2']) ? $G['titre2'] : $G['titre1']; ?></h6>
                                                <p style="font-size: 11px;"><?php echo !empty($G['descriptions2']) ? $G['descriptions2'] : "Aucune description"; ?></p><br>
                                                <p style="font-size: 12px;"><b>Annonce - </b> <?php echo $clients[0]['nom_client']; ?></p>
                                            </div>
                                            <div class="ep-btn">
                                                <a href="#" style="font-size: 12px;">En savoir plus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </th>
            </tr>
        </thead>
    </table>
    </div>


</div>
