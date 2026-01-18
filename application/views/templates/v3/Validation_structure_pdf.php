

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
                        <th style="padding: 12px; border: 1px solid #dee2e6; width: 70px;">Appareils</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">Budget</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6; width: 120px;">Campagne</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6; width: 120px;">Groupe d'annonces</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;width: 250px;">Mots-clés</th>
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
                                    <b></b><?php echo $G['nom_campagne']; ?></b>

									
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px; border: 1px solid #dee2e6; background-color: #007bff; color: #fff; width: 20%;">Groupe d'annonces</th>
                                <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;"><b></b><?php echo $G['nom_groupe']; ?></b></td>
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
                            
                          <?php endif; ?>
                   
                          <?php if ($G['type_campagnes'] == 2): ?>
                              
                          <?php endif; ?>
                        
                            
                            
                        </tbody>
                    </table>
                    <?php endforeach; ?>
                    <?php endif; ?>   
			
		</div>
       
        <div class="section">
                <?php if ($logoclient != NULL): ?> 
                <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                    <h2 style="text-align: right; margin-top: -30px;">Logo</h2>
                    <img src="<?php echo $logoclient; ?>" alt="Logo" style="max-width: 100px; width: 100%; height: auto; margin-left: 45%;"><br>
                      <div style="height: 2px; background-color: #ccc; margin: 20px 0;"></div><br>
                <?php endif; ?>

                <?php if ($images != NULL): ?>
                    <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                    <h2 style="text-align: right; margin-top: -30px;">Assets PMax</h2>
                    <div style="height: 2px; background-color: #ccc; margin: 20px 0;"></div>

                    <div style="justify-align: center; width: 100%; clear: both;">
                        <?php $counter = 0; ?>
                        <?php foreach ($images as $image): ?>
                            <div style="width: 100px; height: 70px; float: left; margin-right: 10px; margin-bottom: 15px; text-align: center;">
                                <?php if (!empty($image->image_base64)): ?>
                                    <img src="<?= $image->image_base64 ?>" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                            <?php $counter++; ?>
                            <?php if ($counter % 9 == 0): ?>
                                <div style="clear: both;"></div> <!-- Nouvelle ligne après 9 images -->
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div style="clear: both;"></div> <!-- Nettoyage à la fin -->
                    </div>
                <?php endif; ?>

                <?php if ($images_local != NULL): ?>
                    <div style="height: 2px; background-color: #ccc; margin: 20px 0;"></div>

                    <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
                    <h2 style="text-align: right; margin-top: -30px;">Assets Local</h2>

                    <div style="width: 100%; clear: both;">
                        <?php $counter = 0; ?>
                        <?php foreach ($images_local as $image): ?>
                            <div style="width: 100px; height: 70px; float: left; margin-right: 10px; margin-bottom: 15px; text-align: center;">
                                <?php if (!empty($image->image_base64)): ?>
                                    <img src="<?= $image->image_base64 ?>" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                            <?php $counter++; ?>
                            <?php if ($counter % 9 == 0): ?>
                                <div style="clear: both;"></div> <!-- Nouvelle ligne après 9 images -->
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div style="clear: both;"></div> <!-- Nettoyage à la fin -->
                    </div>
                <?php endif; ?>
            </div>
                                        
    <div class="section">
    <div>
        <img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width: 150px; width: 100%; height: auto;">
        <h2 style="text-align: right; margin-top: -30px;">Inventaire</h2>
    </div>

    <div style="width: 100%; text-align: center;">

        <!-- Youtube Block -->
        <div style="display: inline-block; vertical-align: top; width: 160px; margin-right: 2%;">
            <div class="header-mine">
                <div class="container">
                    <div class="block">
                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Youtube</h5>

                        <div class="ad-item">
                            <img src="<?php echo $youtube_base64; ?>" alt="Logo" style="max-width: 160px; width: 100%; height: auto;">
                            <img src="<?= $images[0]->image_base64 ?>" alt="Image" style="width: 140px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                            <div class="text" >
                                <h6 style="text-align: left! important; text-decoration: bold; color: black; font-size: 9px;"><?php echo $G['titre1']; ?></h6>
                                <p style="font-size: 8px;text-align: left! important"><?php echo !empty($G['description_breve']) ? $G['description_breve'] : "Aucune description"; ?></p><br>
                                <p style="font-size: 9px;text-align: left! important"><b>Annonce - </b> <?php echo $clients[0]['nom_client']; ?></p>
                            </div>
                            <div  style="text-align: left! important;">
                                <a href="#" style="font-size: 9px;">En savoir plus</a>
                            </div>
                        </div>

                        <div class="ad-item" style="margin-top: 20px;">
                            <img src="<?php echo $youtube2_base64; ?>" alt="Logo" style="max-width: 160px; width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gmail Block -->
        <div style="display: inline-block; vertical-align: top; width: 160px; margin-right: 2%;">
            <div class="header-mine">
                <div class="container">
                    <div class="block">
                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Gmail</h5>

                        <div class="ad-item">
                            <img src="<?php echo $entetegmail_base64; ?>" style="width: 100%;">
                            <div class="container2">
                                <div class="col1" style="margin-top: 15px; margin-left: 15px;">
                                    <img src="<?php //echo base_url($G['favicon']); ?>" style="width: 70%; margin-left: 15px;" alt="Favicon">
                                </div>
                                <div class="col2">
                                    <p style="text-align: left! important; font-size: 9px;"><?php echo !empty($G['titre3']) ? $G['titre3'] : $G['titre1']; ?> </br> à moi</p>
                                </div>
                            </div>

                            <?php if($images[1]->image_base64 != NULL): ?>
                            <img src="<?= $images[1]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <?php if($images[1]->image_base64 == NULL): ?>
                            <img src="<?= $images[1]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <h2 style="font-size: 9px;"><?php echo !empty($G['titre4']) ? $G['titre4'] : $G['titre1']; ?></h2>
                            <p><?php //!empty($G['descriptions3']) ? $G['descriptions3'] : "Aucune description" ?></p>
                            <img src="<?php echo $recherchegmail_base64; ?>" style="width: 100%;">

                            <p style="margin-left: 15px; font-size: 9px;">PROMOTIONS</p>
                            <div class="container2">
                                <div class="col1" style="margin-top: 20px">
                                    <!-- <img src="" style="width: 70%; margin-left: 15px;" alt="Favicon"> -->
                                </div>
                                <div class="col2">
                                    <p style="margin-left: 15px; font-size: 9px;"><b>Sponsored - </b> <?php echo !empty($G['titre5']) ? $G['titre5'] : $G['titre1']; ?><br>
                                        <?php echo !empty($G['descriptions4']) ? $G['descriptions4'] : "Aucune description" ?>
                                    </p>
                                </div>
                                <div class="col3">
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recherche Block -->
        <div style="display: inline-block; vertical-align: top; width: 160px; margin-right: 2%;">
            <div class="header-mine">
                <div class="container">
                    <div class="block">
                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Recherche</h5>

                        <!-- First Ad -->
                        <!-- Second Ad -->
                        <div class="ad-item">
                            <p style="text-align: left; margin-left: 15px; font-size: 9px;"><b>Sponsorisé</b></p>
                            <div class="container2">
                           
                                <p style="margin-left: 15px;font-size: 9px;"><b><?php echo $clients[0]['nom_client']; ?></b><br><?php echo $clients[0]['site_client']; ?></p>
                            </div>
                            <h2 style="margin-left: 15px; margin-top: 10px; color: #4285f4; text-align: left;font-size: 9px;"><?php echo $G['titre7']; ?> <?php echo $G['titre1']; ?></h2>
                            <p style="margin-left: 15px; margin-top: 10px; margin-right: 10px;font-size: 9px;"><?php echo !empty($G['descriptions1']) ? $G['descriptions1'] : "Aucune description"; ?></p>
                                
                            <div class="container2">
                                <div class="col1">
                                    </div>
                                <div class="col2">
                                   <?php if($images[2]->image_base64 != NULL): ?>
                            <img src="<?= $images[2]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <?php if($images[2]->image_base64 == NULL): ?>
                            <img src="<?= $images[1]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Display Block -->
        <div style="display: inline-block; vertical-align: top; width: 160px; margin-right: 2%;">
            <div class="header-mine">
                <div class="container">
                    <div class="block">
                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Display</h5>

                        <div class="ad-item">
                            <?php if($images[3]->image_base64 != NULL): ?>
                            <img src="<?= $images[3]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <?php if($images[3]->image_base64 == NULL): ?>
                            <img src="<?= $images[3]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="container2">
                           
                                <div class="col2">
                                    <p style="margin-left: 15px;font-size: 9px;"><b><?php echo $G['titre1']; ?></b><br><?php echo $G['description_breve']; ?></p>
                                </div>
                            </div>
                            <div>
                                <a href="#" style="font-size: 9px;">En savoir plus</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- Discover Block -->
        <div style="display: inline-block; vertical-align: top; width: 160px; margin-right: 2%;">
            <div class="header-mine">
                <div class="container">
                    <div class="block">
                        <h5 style="color: white; background-color: #4a86e8; padding: 10px; margin-top: 9px; margin-bottom: 20px; text-align: center; border-radius: 12px;">Discover</h5>

                        <div class="ad-item">
                            <?php if($images[4]->image_base64 != NULL): ?>
                            <img src="<?= $images[4]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <?php if($images[4]->image_base64 == NULL): ?>
                            <img src="<?= $images[1]->image_base64 ?>" alt="Image" style="width: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <p style="font-size: 9px;text-align: left! important"><b>Annonce - </b> <?php echo $clients[0]['nom_client']; ?></p>
                                <a href="#" style="font-size: 9px;">En savoir plus</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div> <!-- Fin du wrapper center -->
</div> <!-- Fin de .section -->



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

        


</div>
