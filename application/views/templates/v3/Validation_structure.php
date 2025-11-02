<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Validation client</title>
	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
	<!-- Font Awesome for icons (local) -->
	<link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet">
	<style>
		/* Only page-break CSS */
		.section {
			page-break-before: always;
			margin-top: 50px;
		}

		.section:first-child {
			page-break-before: auto;
		}

		td {
			background-color: white ! important;
		}

		.thumb-box {
			overflow: hidden;
			position: relative;
		}

		.thumb-box img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			object-position: center;
			display: block;
		}

		/** INVENTORY MOCKUP STYLESHEET */

		/* Icons & Labels */
		.mockup-icon img {
			width: 36px;
			height: auto;
		}

		.mockup-label {
			font-weight: 500;
			margin-top: 6px;
			margin-bottom: 10px;
			color: #333;
		}

		/* Phone frame */
		.phone-frame {
			width: 180px;
			height: 400px;
			background: #f8f9fa;
			border: 2px solid #ddd;
			border-radius: 30px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			position: relative;
			overflow: hidden;
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
		}

		/* Top notch (like a speaker line) */
		.phone-frame::before {
			content: "";
			position: absolute;
			top: 8px;
			left: 50%;
			transform: translateX(-50%);
			width: 40px;
			height: 4px;
			background: #ccc;
			border-radius: 10px;
		}

		/* Inner screen area */
		.screen {
			flex: 1;
			width: 100%;
			height: 100%;
			background: #fff;
			padding: 20px 10px;
			border-radius: 28px;
			overflow-y: auto;
		}
	</style>

</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">

	<div style="width: 90%; margin: 0 auto; padding: 15px;">
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
						<th style="padding: 12px; border: 1px solid #dee2e6; width: 250px">Mots-clés</th>
						<?php if ($action !== "export"): ?>
							<th style="padding: 12px; border: 1px solid #dee2e6;">Action</th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>

					<?php if (empty($donne_valider)): ?>
						<tr>
							<td colspan="8" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Aucune donnée disponible</td>
						</tr>
					<?php else: ?>
						<?php foreach ($donne_valider as $D): ?>
							<?php $countG = count($D['groupes_annonces']); ?>
							<?php if ($countG == 0): ?>
								<tr>
									<td colspan="8" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Aucun groupe d'annonces</td>
								</tr>
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
										<?php endif; ?>Campagne
								</th>
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
											</div>
											<div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;">
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

										<div class="row row-cols-5 text-center">
											<div class="col">
												<div class="mockup-icon">
													<img src="https://cdn3.iconfinder.com/data/icons/social-network-30/512/social-06-1024.png" alt="YouTube">
												</div>
												<p class="mockup-label">YouTube</p>
											</div>
											<div class="col">
												<div class="mockup-icon">
													<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/48/google-gmail-256.png" alt="Gmail">
												</div>
												<p class="mockup-label">Gmail</p>
											</div>
											<div class="col">
												<div class="mockup-icon">
													<img src="https://cdn2.iconfinder.com/data/icons/social-icons-33/128/Google-512.png" alt="Search">
												</div>
												<p class="mockup-label">Search</p>
											</div>
											<div class="col">
												<div class="mockup-icon">
													<img src="https://ailecs.org/wp-content/uploads/2024/07/web_100dp_33B54D_FILL0_wght400_GRAD0_opsz48.png" alt="Display">
												</div>
												<p class="mockup-label">Display</p>
											</div>
											<div class="col">
												<div class="mockup-icon">
													<img src="https://cdn1.iconfinder.com/data/icons/logos-brands-in-colors/150/Google_Discover-512.png" alt="Discover">
												</div>
												<p class="mockup-label">Discover</p>
											</div>
										</div>
										<div class="row row-cols-5 mb-4 small">
											<!-- YouTube -->
											<div class="col-auto">
												<div class="phone-frame">
													<div class="screen">
														<div class="d-flex justify-content-between align-items-center">
															<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PCFET0NUWVBFIHN2ZyAgUFVCTElDICctLy9XM0MvL0RURCBTVkcgMS4xLy9FTicgICdodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQnPjxzdmcgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB3aWR0aD0iMTAwJSIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczpzZXJpZj0iaHR0cDovL3d3dy5zZXJpZi5jb20vIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PHBhdGggZD0iTTE1OS44NzQsMjE2LjY5OGMtMS44NzgsLTcuMDI2IC03LjQxLC0xMi41NTggLTE0LjQzNiwtMTQuNDM2Yy0xMi43MzUsLTMuNDEyIC02My43OTYsLTMuNDEyIC02My43OTYsLTMuNDEyYzAsMCAtNTEuMDYxLDAgLTYzLjc5NiwzLjQxMmMtNy4wMjUsMS44NzggLTEyLjU1OCw3LjQxIC0xNC40MzYsMTQuNDM2Yy0zLjQxMSwxMi43MzQgLTMuNDExLDM5LjMwMyAtMy40MTEsMzkuMzAzYzAsMCAwLDI2LjU2OCAzLjQxMSwzOS4zMDFjMS44NzgsNy4wMjYgNy40MTEsMTIuNTU5IDE0LjQzNiwxNC40MzdjMTIuNzM1LDMuNDExIDYzLjc5NiwzLjQxMSA2My43OTYsMy40MTFjMCwwIDUxLjA2MSwwIDYzLjc5NiwtMy40MTFjNy4wMjYsLTEuODc4IDEyLjU1OCwtNy40MTEgMTQuNDM2LC0xNC40MzdjMy40MTMsLTEyLjczMyAzLjQxMywtMzkuMzAxIDMuNDEzLC0zOS4zMDFjMCwwIDAsLTI2LjU2OSAtMy40MTMsLTM5LjMwM1oiIHN0eWxlPSJmaWxsOiNlZDFmMjQ7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTY1LjMxMywyODAuNDk0bDQyLjQyMiwtMjQuNDkzbC00Mi40MjIsLTI0LjQ5NGwwLDQ4Ljk4N1oiIHN0eWxlPSJmaWxsOiNmZmY7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTI1NS4xMSwyOTEuNjIzYzAuODk0LC0yLjMzMyAxLjM0MywtNi4xNDggMS4zNDMsLTExLjQ0MmwwLC0yMi4zMDRjMCwtNS4xMzcgLTAuNDQ5LC04Ljg5MyAtMS4zNDMsLTExLjI2OGMtMC44OTUsLTIuMzczIC0yLjQ3MiwtMy41NjEgLTQuNzI4LC0zLjU2MWMtMi4xOCwwIC0zLjcxOSwxLjE4OCAtNC42MTMsMy41NjFjLTAuODk1LDIuMzc1IC0xLjM0Myw2LjEzMSAtMS4zNDMsMTEuMjY4bDAsMjIuMzA0YzAsNS4yOTQgMC40MjcsOS4xMDkgMS4yODUsMTEuNDQyYzAuODU1LDIuMzM2IDIuNDExLDMuNTAzIDQuNjcxLDMuNTAzYzIuMjU2LDAgMy44MzMsLTEuMTY3IDQuNzI4LC0zLjUwM1ptLTE4LjA5OCwxMS4yMTFjLTMuMjMzLC0yLjE3NyAtNS41MywtNS41NjUgLTYuODksLTEwLjE2Yy0xLjM2MywtNC41OTEgLTIuMDQzLC0xMC43MDMgLTIuMDQzLC0xOC4zMzJsMCwtMTAuMzkyYzAsLTcuNzA3IDAuNzc3LC0xMy44OTcgMi4zMzUsLTE4LjU2NmMxLjU1NiwtNC42NzEgMy45ODgsLTguMDc3IDcuMjk4LC0xMC4yMThjMy4zMDgsLTIuMTQgNy42NDgsLTMuMjExIDEzLjAyLC0zLjIxMWM1LjI5NCwwIDkuNTM2LDEuMDkgMTIuNzI4LDMuMjdjMy4xOTEsMi4xNzkgNS41MjcsNS41ODYgNy4wMDcsMTAuMjE2YzEuNDc3LDQuNjM0IDIuMjE3LDEwLjgwMiAyLjIxNywxOC41MDlsMCwxMC4zOTJjMCw3LjYyOSAtMC43MiwxMy43NjEgLTIuMTYsMTguMzkyYy0xLjQ0MSw0LjYzMyAtMy43NzcsOC4wMTggLTcuMDA2LDEwLjE1OGMtMy4yMzIsMi4xNDEgLTcuNjA5LDMuMjExIC0xMy4xMzYsMy4yMTFjLTUuNjg1LDAgLTEwLjE0MiwtMS4wOSAtMTMuMzcsLTMuMjY5WiIgc3R5bGU9ImZpbGw6IzI3MjcyNztmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNNDg3LjA2OCwyNDQuMzg1Yy0wLjgxNiwxLjAxMyAtMS4zNjMsMi42NjcgLTEuNjM0LDQuOTYyYy0wLjI3NCwyLjI5NyAtMC40MDcsNS43ODEgLTAuNDA3LDEwLjQ1MmwwLDUuMTM5bDExLjc5MSwwbDAsLTUuMTM5YzAsLTQuNTkzIC0wLjE1NiwtOC4wNzcgLTAuNDY2LC0xMC40NTJjLTAuMzEyLC0yLjM3MyAtMC44NzUsLTQuMDQ1IC0xLjY5MiwtNS4wMmMtMC44MTksLTAuOTczIC0yLjA4NCwtMS40NiAtMy43OTYsLTEuNDZjLTEuNzE0LDAgLTIuOTc4LDAuNTA3IC0zLjc5NiwxLjUxOFptLTIuMDQxLDMwLjEyOGwwLDMuNjJjMCw0LjU5NCAwLjEzMyw4LjAzNyAwLjQwNywxMC4zMzNjMC4yNzEsMi4yOTcgMC44MzUsMy45NzIgMS42OTMsNS4wMjNjMC44NTcsMS4wNSAyLjE3OCwxLjU3NyAzLjk3MSwxLjU3N2MyLjQxMSwwIDQuMDY3LC0wLjkzNiA0Ljk2MiwtMi44MDRjMC44OTQsLTEuODY4IDEuMzgxLC00Ljk4MSAxLjQ1OSwtOS4zNDJsMTMuODk2LDAuODE4YzAuMDc4LDAuNjI1IDAuMTE3LDEuNDc5IDAuMTE3LDIuNTY4YzAsNi42MTggLTEuODA5LDExLjU2MiAtNS40MywxNC44MzFjLTMuNjE4LDMuMjY5IC04LjczOSw0LjkwNSAtMTUuMzU1LDQuOTA1Yy03Ljk0LDAgLTEzLjUwNywtMi40OTEgLTE2LjY5OCwtNy40NzVjLTMuMTkzLC00Ljk4IC00Ljc4OSwtMTIuNjg3IC00Ljc4OSwtMjMuMTJsMCwtMTIuNDk2YzAsLTEwLjc0MiAxLjY1NSwtMTguNTg0IDQuOTY0LC0yMy41MjhjMy4zMDgsLTQuOTQ0IDguOTcyLC03LjQxNiAxNi45OTEsLTcuNDE2YzUuNTI1LDAgOS43NjksMS4wMTIgMTIuNzI3LDMuMDM2YzIuOTU3LDIuMDI2IDUuMDQsNS4xNzggNi4yNDcsOS40NTljMS4yMDcsNC4yODIgMS44MTEsMTAuMTk5IDEuODExLDE3Ljc0OWwwLDEyLjI2MmwtMjYuOTczLDBaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0xOTcuNzcyLDI3My4xNzJsLTE4LjMzMywtNjYuMjA5bDE1Ljk5NywwbDYuNDIyLDMwLjAwOWMxLjYzNiw3LjM5OCAyLjg0MiwxMy43MDMgMy42MiwxOC45MTdsMC40NjgsMGMwLjU0NCwtMy43MzYgMS43NTEsLTEwLjAwMSAzLjYxOSwtMTguOGw2LjY1NiwtMzAuMTI2bDE1Ljk5OCwwbC0xOC41NjYsNjYuMjA5bDAsMzEuNzYzbC0xNS44ODEsMGwwLC0zMS43NjNaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0zMjQuNzE0LDIzMy4zNTVsMCw3MS41OGwtMTIuNjExLDBsLTEuNDAyLC04Ljc1NmwtMC4zNSwwYy0zLjQyNiw2LjYxNyAtOC41NjQsOS45MjQgLTE1LjQxNCw5LjkyNGMtNC43NDgsMCAtOC4yNTEsLTEuNTU2IC0xMC41MDksLTQuNjdjLTIuMjU4LC0zLjExMyAtMy4zODYsLTcuOTggLTMuMzg2LC0xNC41OTZsMCwtNTMuNDgybDE2LjExNCwwbDAsNTIuNTQ3YzAsMy4xOTMgMC4zNTEsNS40NyAxLjA1MSw2LjgzYzAuNzAxLDEuMzY0IDEuODY5LDIuMDQ1IDMuNTAzLDIuMDQ1YzEuNDAyLDAgMi43NDUsLTAuNDI4IDQuMDI4LC0xLjI4NWMxLjI4NSwtMC44NTcgMi4yMzgsLTEuOTQ1IDIuODYyLC0zLjI2OWwwLC01Ni44NjhsMTYuMTE0LDBaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik00MDcuMzcxLDIzMy4zNTVsMCw3MS41OGwtMTIuNjExLDBsLTEuNDAyLC04Ljc1NmwtMC4zNDgsMGMtMy40MjksNi42MTcgLTguNTY2LDkuOTI0IC0xNS40MTYsOS45MjRjLTQuNzQ5LDAgLTguMjUxLC0xLjU1NiAtMTAuNTA5LC00LjY3Yy0yLjI1OSwtMy4xMTMgLTMuMzg2LC03Ljk4IC0zLjM4NiwtMTQuNTk2bDAsLTUzLjQ4MmwxNi4xMTQsMGwwLDUyLjU0N2MwLDMuMTkzIDAuMzUsNS40NyAxLjA1LDYuODNjMC43MDIsMS4zNjQgMS44NywyLjA0NSAzLjUwNCwyLjA0NWMxLjQwMiwwIDIuNzQ1LC0wLjQyOCA0LjAyOCwtMS4yODVjMS4yODUsLTAuODU3IDIuMjM4LC0xLjk0NSAyLjg2MiwtMy4yNjlsMCwtNTYuODY4bDE2LjExNCwwWiIgc3R5bGU9ImZpbGw6IzI3MjcyNztmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNMzY4LjUwMywyMTkuOTI2bC0xNS45OTgsMGwwLDg1LjAwOWwtMTUuNzY0LDBsMCwtODUuMDA5bC0xNS45OTcsMGwwLC0xMi45NjJsNDcuNzU5LDBsMCwxMi45NjJaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik00NDUuOTMzLDI3My45OTVjMCw1LjIxNyAtMC4yMTYsOS4zMDQgLTAuNjQzLDEyLjI2MWMtMC40MjgsMi45NiAtMS4xNDgsNS4wNjIgLTIuMTYsNi4zMDZjLTEuMDEyLDEuMjQ2IC0yLjM3NywxLjg2OCAtNC4wODYsMS44NjhjLTEuMzI2LDAgLTIuNTUyLC0wLjMxMSAtMy42NzksLTAuOTM0Yy0xLjEzMSwtMC42MjMgLTIuMDQzLC0xLjU1NyAtMi43NDUsLTIuODAzbDAsLTQwLjYzNmMwLjU0NSwtMS45NDUgMS40NzksLTMuNTQyIDIuODAzLC00Ljc4OGMxLjMyNCwtMS4yNDMgMi43NjIsLTEuODY4IDQuMzIsLTEuODY4YzEuNjM1LDAgMi44OTksMC42NDMgMy43OTUsMS45MjZjMC44OTQsMS4yODUgMS41MTgsMy40NDUgMS44NjksNi40ODNjMC4zNSwzLjAzNSAwLjUyNiw3LjM1NSAwLjUyNiwxMi45NmwwLDkuMjI1Wm0xNC43NzEsLTI5LjE5N2MtMC45NzUsLTQuNTE0IC0yLjU1MSwtNy43ODQgLTQuNzMsLTkuODFjLTIuMTgsLTIuMDIzIC01LjE3OCwtMy4wMzUgLTguOTkxLC0zLjAzNWMtMi45NTgsMCAtNS43MjIsMC44MzggLTguMjksMi41MTFjLTIuNTY5LDEuNjc0IC00LjU1NSwzLjg3MyAtNS45NTYsNi41OTdsLTAuMTE4LDBsMC4wMDEsLTM3LjcxN2wtMTUuNTMsMGwwLDEwMS41OWwxMy4zMTEsMGwxLjYzNiwtNi43NzJsMC4zNDksMGMxLjI0NSwyLjQxMyAzLjExMyw0LjMyIDUuNjA1LDUuNzIyYzIuNDkxLDEuNDAxIDUuMjU2LDIuMTAyIDguMjkyLDIuMTAyYzUuNDQ4LDAgOS40NTcsLTIuNTEyIDEyLjAyNywtNy41MzJjMi41NjksLTUuMDIxIDMuODUzLC0xMi44NjMgMy44NTMsLTIzLjUzbDAsLTExLjMyNWMwLC04LjAxOCAtMC40ODcsLTE0LjI4NSAtMS40NTksLTE4LjgwMVoiIHN0eWxlPSJmaWxsOiMyNzI3Mjc7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PC9nPjwvc3ZnPg==" alt="Youtube" width="58">
															<i class="fa fa-search"></i>
														</div>
														<div class="thumb-box" style="height: 140px;">
															<img src=<?= $G['images'][0] ?? "https://placehold.co/120x120?text=Youtube+Ads" ?> alt="placeholder">
														</div>
														<div class="alert alert-primary border-0 py-0 px-2 d-flex justify-content-between align-items-center">
															<span class="small font-weight-bold">Book now</span>
															<i class="fa fa-external-link-alt"></i>
														</div>
														<div class="row no-gutters justify-content-between">
															<div class="col-auto">
																<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
															</div>
															<div class="col px-2">
																<p class="font-weight-bold m-0"><?= $G['nom_groupe'] ?></p>
																<p class="small text-muted m-0"><?= $G['descriptions1'] ?></p>
															</div>
															<div class="col-auto">
																<i class="fa fa-ellipsis-v"></i>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!-- Gmail -->
											<div class="col-auto">
												<div class="phone-frame">
													<div class="screen">
														<div class="d-flex justify-content-between align-items-center mb-3">
															<i class="fa fa-chevron-left mr-auto"></i>
															<i class="mr-4 far fa-star"></i>
															<i class="mr-4 fa fa-trash"></i>
															<i class="fa fa-ellipsis-h"></i>
														</div>
														<div class="row no-gutters justify-content-start mb-3">
															<div class="col-auto">
																<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
															</div>
															<div class="pl-2 col">
																<p class="small m-0">Résidence-Luxe</p>
																<p class="small m-0 text-muted">à Moi</p>
															</div>
														</div>
														<div class="thumb-box mb-3" style="height: 140px;">
															<img src=<?= $G['images'][1] ?? $G['images'][0] ?? "https://placehold.co/120x120?text=Gmail+Attachment" ?> alt="placeholder">
														</div>

														<p class="font-weight-bold mb-2"><?= $G['nom_groupe'] ?></p>
														<p class="small text-muted"><?= $G['descriptions1'] ?></p>

														<span class="badge badge-primary py-2 w-100 rounded-pill">Book now</span>
													</div>
												</div>
											</div>

											<!-- Search -->
											<div class="col-auto">
												<div class="phone-frame">
													<div class="screen">
														<div class="d-flex align-items-center mb-1">
															<i class="fa fa-bars text-muted"></i>
															<img alt="google" height="24" class="mx-auto" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBoZWlnaHQ9IjkyIiB2aWV3Qm94PSIwIDAgMjcyIDkyIiB3aWR0aD0iMjcyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0xMTUuNzUgNDcuMThjMCAxMi43Ny05Ljk5IDIyLjE4LTIyLjI1IDIyLjE4cy0yMi4yNS05LjQxLTIyLjI1LTIyLjE4QzcxLjI1IDM0LjMyIDgxLjI0IDI1IDkzLjUgMjVzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NFM4MC45OSAzOS4yIDgwLjk5IDQ3LjE4YzAgNy45IDUuNzkgMTMuNDQgMTIuNTEgMTMuNDRzMTIuNTEtNS41NSAxMi41MS0xMy40NHoiIGZpbGw9IiNFQTQzMzUiLz48cGF0aCBkPSJNMTYzLjc1IDQ3LjE4YzAgMTIuNzctOS45OSAyMi4xOC0yMi4yNSAyMi4xOHMtMjIuMjUtOS40MS0yMi4yNS0yMi4xOGMwLTEyLjg1IDkuOTktMjIuMTggMjIuMjUtMjIuMThzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NHMtMTIuNTEgNS40Ni0xMi41MSAxMy40NGMwIDcuOSA1Ljc5IDEzLjQ0IDEyLjUxIDEzLjQ0czEyLjUxLTUuNTUgMTIuNTEtMTMuNDR6IiBmaWxsPSIjRkJCQzA1Ii8+PHBhdGggZD0iTTIwOS43NSAyNi4zNHYzOS44MmMwIDE2LjM4LTkuNjYgMjMuMDctMjEuMDggMjMuMDctMTAuNzUgMC0xNy4yMi03LjE5LTE5LjY2LTEzLjA3bDguNDgtMy41M2MxLjUxIDMuNjEgNS4yMSA3Ljg3IDExLjE3IDcuODcgNy4zMSAwIDExLjg0LTQuNTEgMTEuODQtMTN2LTMuMTloLS4zNGMtMi4xOCAyLjY5LTYuMzggNS4wNC0xMS42OCA1LjA0LTExLjA5IDAtMjEuMjUtOS42Ni0yMS4yNS0yMi4wOSAwLTEyLjUyIDEwLjE2LTIyLjI2IDIxLjI1LTIyLjI2IDUuMjkgMCA5LjQ5IDIuMzUgMTEuNjggNC45NmguMzR2LTMuNjFoOS4yNXptLTguNTYgMjAuOTJjMC03LjgxLTUuMjEtMTMuNTItMTEuODQtMTMuNTItNi43MiAwLTEyLjM1IDUuNzEtMTIuMzUgMTMuNTIgMCA3LjczIDUuNjMgMTMuMzYgMTIuMzUgMTMuMzYgNi42MyAwIDExLjg0LTUuNjMgMTEuODQtMTMuMzZ6IiBmaWxsPSIjNDI4NUY0Ii8+PHBhdGggZD0iTTIyNSAzdjY1aC05LjVWM2g5LjV6IiBmaWxsPSIjMzRBODUzIi8+PHBhdGggZD0iTTI2Mi4wMiA1NC40OGw3LjU2IDUuMDRjLTIuNDQgMy42MS04LjMyIDkuODMtMTguNDggOS44My0xMi42IDAtMjIuMDEtOS43NC0yMi4wMS0yMi4xOCAwLTEzLjE5IDkuNDktMjIuMTggMjAuOTItMjIuMTggMTEuNTEgMCAxNy4xNCA5LjE2IDE4Ljk4IDE0LjExbDEuMDEgMi41Mi0yOS42NSAxMi4yOGMyLjI3IDQuNDUgNS44IDYuNzIgMTAuNzUgNi43MiA0Ljk2IDAgOC40LTIuNDQgMTAuOTItNi4xNHptLTIzLjI3LTcuOThsMTkuODItOC4yM2MtMS4wOS0yLjc3LTQuMzctNC43LTguMjMtNC43LTQuOTUgMC0xMS44NCA0LjM3LTExLjU5IDEyLjkzeiIgZmlsbD0iI0VBNDMzNSIvPjxwYXRoIGQ9Ik0zNS4yOSA0MS40MVYzMkg2N2MuMzEgMS42NC40NyAzLjU4LjQ3IDUuNjggMCA3LjA2LTEuOTMgMTUuNzktOC4xNSAyMi4wMS02LjA1IDYuMy0xMy43OCA5LjY2LTI0LjAyIDkuNjZDMTYuMzIgNjkuMzUuMzYgNTMuODkuMzYgMzQuOTEuMzYgMTUuOTMgMTYuMzIuNDcgMzUuMy40N2MxMC41IDAgMTcuOTggNC4xMiAyMy42IDkuNDlsLTYuNjQgNi42NGMtNC4wMy0zLjc4LTkuNDktNi43Mi0xNi45Ny02LjcyLTEzLjg2IDAtMjQuNyAxMS4xNy0yNC43IDI1LjAzIDAgMTMuODYgMTAuODQgMjUuMDMgMjQuNyAyNS4wMyA4Ljk5IDAgMTQuMTEtMy42MSAxNy4zOS02Ljg5IDIuNjYtMi42NiA0LjQxLTYuNDYgNS4xLTExLjY1bC0yMi40OS4wMXoiIGZpbGw9IiM0Mjg1RjQiLz48L3N2Zz4=">
														</div>
														<div class="d-flex justify-content-between align-items-center border rounded-pill w-100 px-2 py-1">
															<i class="fa fa-search"></i>
															<img height="20" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBpZD0iQ2FwYV8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxNTAgMTUwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMTUwIDE1MCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojMUE3M0U4O30KCS5zdDF7ZmlsbDojRUE0MzM1O30KCS5zdDJ7ZmlsbDojNDI4NUY0O30KCS5zdDN7ZmlsbDojRkJCQzA0O30KCS5zdDR7ZmlsbDojMzRBODUzO30KCS5zdDV7ZmlsbDojNENBRjUwO30KCS5zdDZ7ZmlsbDojMUU4OEU1O30KCS5zdDd7ZmlsbDojRTUzOTM1O30KCS5zdDh7ZmlsbDojQzYyODI4O30KCS5zdDl7ZmlsbDojRkJDMDJEO30KCS5zdDEwe2ZpbGw6IzE1NjVDMDt9Cgkuc3QxMXtmaWxsOiMyRTdEMzI7fQoJLnN0MTJ7ZmlsbDojRjZCNzA0O30KCS5zdDEze2ZpbGw6I0U1NDMzNTt9Cgkuc3QxNHtmaWxsOiM0MjgwRUY7fQoJLnN0MTV7ZmlsbDojMzRBMzUzO30KCS5zdDE2e2NsaXAtcGF0aDp1cmwoI1NWR0lEXzJfKTt9Cgkuc3QxN3tmaWxsOiMxODgwMzg7fQoJLnN0MTh7b3BhY2l0eTowLjI7ZmlsbDojRkZGRkZGO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MTl7b3BhY2l0eTowLjM7ZmlsbDojMEQ2NTJEO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjB7Y2xpcC1wYXRoOnVybCgjU1ZHSURfNF8pO30KCS5zdDIxe29wYWNpdHk6MC4zO2ZpbGw6dXJsKCNfNDVfc2hhZG93XzFfKTtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDIye2NsaXAtcGF0aDp1cmwoI1NWR0lEXzZfKTt9Cgkuc3QyM3tmaWxsOiNGQTdCMTc7fQoJLnN0MjR7b3BhY2l0eTowLjM7ZmlsbDojMTc0RUE2O2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjV7b3BhY2l0eTowLjM7ZmlsbDojQTUwRTBFO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjZ7b3BhY2l0eTowLjM7ZmlsbDojRTM3NDAwO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0Mjd7ZmlsbDp1cmwoI0ZpbmlzaF9tYXNrXzFfKTt9Cgkuc3QyOHtmaWxsOiNGRkZGRkY7fQoJLnN0Mjl7ZmlsbDojMEM5RDU4O30KCS5zdDMwe29wYWNpdHk6MC4yO2ZpbGw6IzAwNEQ0MDtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMxe29wYWNpdHk6MC4yO2ZpbGw6IzNFMjcyMztlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMye2ZpbGw6I0ZGQzEwNzt9Cgkuc3QzM3tvcGFjaXR5OjAuMjtmaWxsOiMxQTIzN0U7ZW5hYmxlLWJhY2tncm91bmQ6bmV3ICAgIDt9Cgkuc3QzNHtvcGFjaXR5OjAuMjt9Cgkuc3QzNXtmaWxsOiMxQTIzN0U7fQoJLnN0MzZ7ZmlsbDp1cmwoI1NWR0lEXzdfKTt9Cgkuc3QzN3tmaWxsOiNGQkJDMDU7fQoJLnN0Mzh7Y2xpcC1wYXRoOnVybCgjU1ZHSURfOV8pO2ZpbGw6I0U1MzkzNTt9Cgkuc3QzOXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xMV8pO2ZpbGw6I0ZCQzAyRDt9Cgkuc3Q0MHtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xM18pO2ZpbGw6I0U1MzkzNTt9Cgkuc3Q0MXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xNV8pO2ZpbGw6I0ZCQzAyRDt9Cjwvc3R5bGU+PGc+PGcgaWQ9ImcxNzQ4MCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQ2LjMwMzQsMjM2LjM3ODkpIj48cGF0aCBjbGFzcz0ic3Q2IiBkPSJNLTU3MS4zLTE0Ny4zYzcuOSwwLDE0LjItNi40LDE0LjItMTQuMmwwLTMzLjJjMC03LjktNi40LTE0LjItMTQuMi0xNC4yICAgIGMtNy45LDAtMTQuMiw2LjQtMTQuMiwxNC4ydjMzLjJDLTU4NS41LTE1My43LTU3OS4xLTE0Ny4zLTU3MS4zLTE0Ny4zIiBpZD0icGF0aDE3NDgyIi8+PC9nPjxnIGlkPSJnMTc0ODQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDY0NS40ODAzLDIzMy4xNDkyKSI+PHBhdGggY2xhc3M9InN0NSIgZD0iTS01NzUuMi0xMjUuNUwtNTc1LjItMTI1LjV2MTQuOWg5LjV2LTE0LjhjLTEuNSwwLjItMy4xLDAuMi00LjcsMC4yICAgIEMtNTcyLjEtMTI1LjEtNTczLjYtMTI1LjItNTc1LjItMTI1LjUiIGlkPSJwYXRoMTc0ODYiLz48L2c+PGcgaWQ9ImcxNzQ4OCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQzLjM4MDksMjM1LjkxMTUpIj48cGF0aCBjbGFzcz0ic3Q5IiBkPSJNLTU4NS4yLTE0NC4xYy00LjItNC4zLTYuOS05LjUtNi45LTE2LjZoLTkuNWMwLDkuNSwzLjcsMTcuMyw5LjcsMjMuM2wwLjEtMC4xICAgIGMwLDAsMCwwLTAuMS0wLjFMLTU4NS4yLTE0NC4xeiIgaWQ9InBhdGgxNzQ5MCIvPjwvZz48ZyBpZD0iZzE3NDkyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2NTAuNDA4MSwyMzguNzkpIj48cGF0aCBjbGFzcz0ic3Q3IiBkPSJNLTU1MS43LTE2My42YzAsMTEuOS0xMC41LDIzLjYtMjMuNywyMy42Yy02LjYsMC0xMi41LTIuNy0xNi44LTdsLTAuMSwwLjFsLTYuNiw2LjYgICAgYzAsMCwwLDAsMC4xLDAuMWM0LjksNC45LDExLjQsOC4yLDE4LjcsOS4zYzEuNiwwLjIsMy4yLDAuNCw0LjgsMC40YzEuNiwwLDMuMiwwLDQuNy0wLjJjMTYuMS0yLjMsMjguNC0xNi4xLDI4LjQtMzIuN0gtNTUxLjd6IiBpZD0icGF0aDE3NDk0Ii8+PC9nPjwvZz48L3N2Zz4=" alt="google-microphone">
														</div>
														<hr class="mb-1 mt-2">
														<p class="small font-weight-bold mb-2">Sponsorisé</p>
														<div class="row no-gutters justify-content-start mb-2">
															<div class="col-auto">
																<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
															</div>
															<div class="pl-2 col">
																<p class="m-0">Résidence-Luxe</p>
																<p class="small m-0 text-muted"><?= $G['url_site'] ?></p>
															</div>
														</div>

														<p class="text-primary mb-2"><?= $G['nom_groupe'] ?></p>
														<p class="small text-muted mb-2"><?= $G['descriptions1'] ?></p>

														<span class="border rounded-pill text-primary py-1 px-2 small">Chalets de Luxe</span>
														<span class="border rounded-pill text-primary py-1 px-2 small">Promotions</span>
														<hr>
														<i class="fa fa-phone"></i>
														Appeler le <?= $G['téléphone'] ?>
													</div>
												</div>
											</div>

											<!-- Display -->
											<div class="col-auto">
												<div class="phone-frame">
													<div class="screen">
														<div class="thumb-box mb-3" style="height: 140px;">
															<img src=<?= $G['images'][2] ?? $G['images'][1] ?? $G['images'][0] ?? "https://placehold.co/120x120?text=Display" ?> alt="placeholder">
														</div>
														<div class="row no-gutters justify-content-start mb-2">
															<div class="col-auto">
																<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
															</div>
															<div class="pl-2 col">
																<p class="m-0">Résidence-Luxe</p>
															</div>
														</div>
														<div class="d-flex justify-content-between">
															<span class="small text-muted">Résidence-Luxe</span>
															<span class="small">
																En savoir plus
																<i class="fa fa-chevron-right"></i>
															</span>
														</div>
														<hr>
													</div>
												</div>
											</div>

											<!-- Discover -->
											<div class="col-auto">
												<div class="phone-frame">
													<div class="screen">
														<div class="row no-gutters justify-content-start mb-3">
															<div class="col-auto">
																<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
															</div>
															<div class="pl-2 col">
																<p class="m-0"><?= $G['nom_groupe'] ?></p>
																<p class="small m-0 text-muted">Sponsored</p>
															</div>
														</div>
														<div class="thumb-box mb-3" style="height: 220px;">
															<img src=<?= $G['images'][3] ?? $G['images'][2] ?? $G['images'][1] ?? $G['images'][0] ?? "https://placehold.co/120x120?text=Discovery" ?> alt="placeholder">
															<span class="bg-white position-absolute text-primary" style="right: 2px; top: 2px; padding: 0px 2px;">
																<i class="fa fa-info-circle"></i>
															</span>
														</div>
														<p><?= $G['descriptions1'] ?></p>
														<div class="d-flex justify-content-end align-items-center text-muted">
															<i class="far fa-heart mr-4"></i>
															<i class="fa fa-share-square mr-4"></i>
															<i class="fa fa-ellipsis-h"></i>
														</div>
													</div>
												</div>
											</div>

										</div>
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
								<td> <?php echo anchor("Validation/editextensions/" . $E['idextensions'], '<i class="fas fa-edit" style="margin-left: 10px;display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;"></i>', 'data-edit="' . $E['idextensions'] . '"'); ?>
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
							<?php echo anchor("Validation/exclusion/" . $D['idclients'], '<i class="fas fa-edit" style="display: inline-block; padding: 5px 10px; font-size: 14px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;"></i>', 'data-edit="' . $D['idclients'] . '" class="open-popup"'); ?>
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
						<tr>
							<td colspan="2" style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Aucune exclusion</td>
						</tr>
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

					<button type="submit" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">Valider</button>
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
					<a href="<?php echo base_url('Validation/export_rendu/' . $id); ?>" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #4EA5FE; border: 1px solid #4EA5FE; border-radius: 4px; text-decoration: none;" target="_blank">
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
				background: rgba(0, 0, 0, 0.5);
				/* Fond semi-transparent */
				display: none;
				align-items: center;
				justify-content: center;
				z-index: 9999;
				/* S'assurer qu'il soit au-dessus des autres éléments */
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
				width: 100%;
				/* Occupe toute la largeur du parent */
				height: 750px;
				/* Définit une hauteur de 500px */
				font-size: 16px;
				/* Vous pouvez ajuster la taille du texte ici si nécessaire */
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
