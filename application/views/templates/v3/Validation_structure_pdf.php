<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Validation client</title>

	<!-- Styles & librairies -->
	<link rel="stylesheet" href="file://<?= FCPATH . 'assets/vendors/bootstrap/css/bootstrap.css' ?>">
	<!-- <link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>"> -->
	<link rel="stylesheet" href="file://<?= FCPATH . 'assets/css/font-awesome.all.min.css' ?>">

	<style>

		.section {
			background: var(--bg-card);
			border-radius: 14px;
			box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
			margin: 40px 0;
			padding: 25px
		}

		/* Cartes groupes */
		.groupe-card {
			position: relative;
			background: #fff;
			border: 1px solid var(--border);
			border-radius: 12px;
			padding: 20px;
			margin-bottom: 25px;
			box-shadow: 0 1px 8px rgba(0, 0, 0, .03)
		}

		.groupe-card table {
			border-collapse: collapse;
			width: 100%
		}

		.groupe-card th {
			background: var(--primary);
			color: #fff;
			width: 210px;
			font-weight: 600;
			text-align: left;
			vertical-align: top;
			padding: 10px 12px;
			border: 1px solid #fff
		}

		.groupe-card td {
			background: #fff;
			color: var(--text-dark);
			padding: 10px 12px;
			border: 1px solid var(--border)
		}

		/* Barre d’actions compacte */
		.card-actions {
			position: absolute;
			top: 12px;
			right: 12px;
			display: flex;
			gap: 8px;
			align-items: center
		}

		.btn-icon {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 6px;
			width: 34px;
			height: 34px;
			border-radius: 8px;
			border: 1px solid var(--border);
			background: #fff;
			color: var(--text-dark);
			cursor: pointer;
			box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
			transition: .2s
		}

		.btn-icon:hover {
			background: var(--bg-light)
		}

		.btn-icon i {
			font-size: 14px
		}

		/* Boutons unifiés */
		.btn-action {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			padding: 10px 18px;
			font-size: 15px;
			border-radius: 10px;
			border: 1px solid var(--border);
			background: #fff;
			color: var(--text-dark);
			box-shadow: 0 1px 6px rgba(0, 0, 0, .08);
			transition: .2s
		}

		.btn-action:hover {
			background: var(--bg-light)
		}

		.btn-action-primary {
			background: var(--primary);
			color: #fff;
			border: none
		}

		.btn-action-primary:hover {
			background: var(--primary-dark);
			color: #fff
		}

		.btn-action-secondary {
			background: #fff;
			color: #666;
			border: 1px solid var(--border)
		}

		.btn-action-secondary:hover {
			background: #f1f1f1
		}

		.btn-action-danger {
			background: #ffeded;
			color: #c00;
			border: 1px solid #ffcccc
		}

		.btn-action-danger:hover {
			background: #ffd9d9
		}

		/* Images */
		.image-thumb {
			position: relative;
			display: inline-block;
			margin: 3px;
			width: 160px;
			height: 120px;
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .1)
		}

		.image-thumb img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block
		}

		/* Modal images */
		.images-toolbar {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
			align-items: center;
			margin-bottom: 12px
		}

		.images-toolbar .spacer {
			flex: 1
		}

		.thumb {
			position: relative;
			width: 150px;
			height: 110px;
			margin: 6px;
			border-radius: 8px;
			overflow: hidden;
			border: 1px solid var(--border)
		}

		.thumb img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block
		}

		.thumb .thumb-actions {
			position: absolute;
			top: 6px;
			right: 6px;
			opacity: 0;
			transition: opacity .15s;
			display: flex;
			gap: 6px
		}

		.thumb:hover .thumb-actions {
			opacity: 1
		}

		.btn-icon-sm {
			width: 28px;
			height: 28px;
			border-radius: 6px;
			border: 1px solid var(--border);
			background: rgba(255, 255, 255, .9);
			color: #333
		}

		/* Compteurs */
		.counter {
			font-size: 12px;
			color: var(--muted)
		}

		.counter.invalid {
			color: #c00;
			font-weight: 600
		}

		.action-btns {
			text-align: center;
			margin-top: 40px;
			display: flex;
			justify-content: center;
			gap: 14px
		}

		.table1 td {
			text-align: center;
			text-transform: capitalize
		}

		@media print {

			.card-actions,
			.btn,
			.action-btns {
				display: none
			}

			.section {
				page-break-before: always
			}
		}

		/* Titre aligné à gauche, contenu centré (tableau principal) */
		table th {
			text-align: left !important;
		}

		table td {
			text-align: center !important;
			vertical-align: middle !important;
		}

		/* Largeur spécifique pour la mise en page PDF si nécessaire */
		.section {
			width: 1350px;
		}

		/* Icônes mockup PMAX */
		.mockup-icon {
			width: 64px;
			height: 64px;
			border-radius: 16px;
			background: #f3f4f6;
			border: 1px solid #e5e7eb;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 8px;
		}

		.mockup-icon img {
			max-width: 40px;
			max-height: 40px;
		}

		.mockup-label {
			font-weight: 600;
			margin: 0;
			font-size: .9rem;
		}

		.device-frame.phone-frame {
			width: 220px;
			border-radius: 24px;
			border: 2px solid #e5e7eb;
			background: #fff;
			padding: 10px;
			box-shadow: 0 4px 14px rgba(0, 0, 0, .05);
		}

		.device-frame .screen {
			min-height: 360px;
		}

		.thumb-box img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-radius: .5rem;
		}

		.rounded-pill {
			border-radius: 50rem !important;
		}

		.small {
			font-size: .8rem;
		}

		.font-weight-bold {
			font-weight: 600;
		}

		.row.row-cols-5>[class^="col"] {
			margin-bottom: .75rem;
		}

		.fa {
			line-height: 1;
		}

		@media (max-width:1440px) {
			.device-frame.phone-frame {
				width: 210px;
				padding: 8px;
			}

			.device-frame .screen {
				min-height: 340px;
			}

			.mockup-icon {
				width: 58px;
				height: 58px;
			}

			.mockup-icon img {
				max-width: 36px;
			}
		}
	</style>

	<style>
		/* Only page-break CSS */
		.section {
			page-break-before: always;
		}

		.section:first-child {
			page-break-before: auto;
		}

		td {
			font-size: 13px ! important;
		}

		table th {
			text-align: left !important;
		}

		table td {
			text-align: center !important;
			vertical-align: middle !important;
		}
	</style>

	<style>
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

		.device-frame {
			background: #fff;
			border: 2px solid #ddd;
			border-radius: 30px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			position: relative;
			overflow: hidden;
			display: inline-block;
		}

		/* Phone */
		.phone-frame {
			width: 245px;
			height: 430px;
			border-radius: 30px;
		}

		.phone-frame::before {
			content: "";
			position: absolute;
			top: 8px;
			left: 50%;
			width: 40px;
			height: 4px;
			background: #ccc;
			border-radius: 10px;
			transform: translateX(-50%);
		}

		/* Tablet */
		.tablet-frame {
			width: 400px;
			height: 430px;
			border-radius: 24px;
		}

		.tablet-frame::before {
			content: "";
			position: absolute;
			top: 10px;
			left: 50%;
			width: 60px;
			height: 5px;
			background: #ccc;
			border-radius: 10px;
			transform: translateX(-50%);
		}

		/* Desktop */
		.desktop-frame {
			width: 600px;
			height: 430px;
			border-radius: 10px;
			border: 4px solid #ccc;
		}

		.desktop-frame::before {
			content: "";
			position: absolute;
			top: -18px;
			left: 50%;
			width: 120px;
			height: 12px;
			background: #ccc;
			border-radius: 6px;
			transform: translateX(-50%);
		}

		.desktop-frame::after {
			content: "";
			position: absolute;
			bottom: -30px;
			left: 50%;
			width: 80px;
			height: 6px;
			background: #ccc;
			border-radius: 3px;
			transform: translateX(-50%);
		}

		/* Screen area */
		.screen {
			width: 100%;
			height: 100%;
			background: #f8f9f9ff;
			overflow: hidden;
			padding: 25px 15px 15px 15px;
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


			<table style="width: 100%; border-collapse: collapse; background-color: #fff; text-align: center; border: 1px solid #d0d0d0; /* contour général gris clair */">
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
						<?php foreach ($campagnes as $C): ?>
							<?php $groupes = $C['groupes_annonces'] ?? []; ?>
							<?php if (!empty($groupes)): ?>
								<?php foreach ($groupes as $G): ?>
									<tr style="border-bottom: 1px solid #d0d0d0;">
										<td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['zones'] ?? '—'); ?></td>
										<td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['date_campagne'] ?? '—'); ?></td>
										<td style="border: 1px solid #d0d0d0;"><?= htmlspecialchars($C['appareil'] ?? '—'); ?></td>
										<td style="border: 1px solid #d0d0d0;">
											<?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
											<?= $b !== '' ? htmlspecialchars($b) . ' €' : '—'; ?>
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
										<?= $b !== '' ? htmlspecialchars($b) . ' €' : '—'; ?>
									</td>
									<td style="border: 1px solid #d0d0d0;"><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
									<td style="border: 1px solid #d0d0d0;" colspan="3">Aucun groupe d’annonce</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="8" style="border: 1px solid #d0d0d0;">Aucune campagne disponible.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>

		</div>

		<?php if (!empty($campagnes) && is_array($campagnes)): ?>
			<?php foreach ($campagnes as $C): ?>
				<?php $groupes = $C['groupes_annonces'] ?? [];
				$campImages = $C['images'] ?? []; ?>
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
																																				for ($i = 1; $i <= 12; $i++) if (!empty($G['titre' . $i])) $titres[] = htmlspecialchars($G['titre' . $i]);
																																				echo !empty($titres) ? implode('<br>', $titres) : 'Aucun titre';
																																				?></td>
								</tr>
								<tr>
									<th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;   text-transform: capitalize;">Descriptions</th>
									<td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;   text-transform: capitalize;"><?php
																																			$desc = [];
																																			for ($i = 1; $i <= 4; $i++) if (!empty($G['descriptions' . $i])) $desc[] = htmlspecialchars($G['descriptions' . $i]);
																																			echo !empty($desc) ? implode('<br>', $desc) : 'Aucune description';
																																			?></td>
								</tr>
								<tr>
									<th style="padding: 12px; border: 1px solid #dee2e6; background-color: #4ea5fe; color: #fff; width: 20%;">Images</th>
									<td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">

										<div class="images-row">
											<?php if (!empty($campImages) && is_array($campImages)): ?>
												<?php foreach ($campImages as $img):
													$b64 = is_object($img) ? ($img->image_base64 ?? '') : ($img['image_base64'] ?? '');
													$url = is_object($img) ? ($img->image_url ?? '')    : ($img['image_url'] ?? '');
													$src = $b64 ?: $url;
													if ($src): ?>
														<img src="<?= htmlspecialchars($src); ?>" alt="Image annonce" style="width:160px;height:120px;border-radius:10px; margin-top: 20px;">
												<?php endif;
												endforeach; ?>
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
											<?php else: ?>—<?php endif; ?>
									</td>
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

					<div class="d-flex justify-content-around mb-4 small">
						<!-- YouTube -->
						<div class="">
							<div class="device-frame phone-frame">
								<div class="screen">
									<div class="d-flex justify-content-between align-items-center">
										<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PCFET0NUWVBFIHN2ZyAgUFVCTElDICctLy9XM0MvL0RURCBTVkcgMS4xLy9FTicgICdodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQnPjxzdmcgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB3aWR0aD0iMTAwJSIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczpzZXJpZj0iaHR0cDovL3d3dy5zZXJpZi5jb20vIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PHBhdGggZD0iTTE1OS44NzQsMjE2LjY5OGMtMS44NzgsLTcuMDI2IC03LjQxLC0xMi41NTggLTE0LjQzNiwtMTQuNDM2Yy0xMi43MzUsLTMuNDEyIC02My43OTYsLTMuNDEyIC02My43OTYsLTMuNDEyYzAsMCAtNTEuMDYxLDAgLTYzLjc5NiwzLjQxMmMtNy4wMjUsMS44NzggLTEyLjU1OCw3LjQxIC0xNC40MzYsMTQuNDM2Yy0zLjQxMSwxMi43MzQgLTMuNDExLDM5LjMwMyAtMy40MTEsMzkuMzAzYzAsMCAwLDI2LjU2OCAzLjQxMSwzOS4zMDFjMS44NzgsNy4wMjYgNy40MTEsMTIuNTU5IDE0LjQzNiwxNC40MzdjMTIuNzM1LDMuNDExIDYzLjc5NiwzLjQxMSA2My43OTYsMy40MTFjMCwwIDUxLjA2MSwwIDYzLjc5NiwtMy40MTFjNy4wMjYsLTEuODc4IDEyLjU1OCwtNy40MTEgMTQuNDM2LC0xNC40MzdjMy40MTMsLTEyLjczMyAzLjQxMywtMzkuMzAxIDMuNDEzLC0zOS4zMDFjMCwwIDAsLTI2LjU2OSAtMy40MTMsLTM5LjMwM1oiIHN0eWxlPSJmaWxsOiNlZDFmMjQ7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTY1LjMxMywyODAuNDk0bDQyLjQyMiwtMjQuNDkzbC00Mi40MjIsLTI0LjQ5NGwwLDQ4Ljk4N1oiIHN0eWxlPSJmaWxsOiNmZmY7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTI1NS4xMSwyOTEuNjIzYzAuODk0LC0yLjMzMyAxLjM0MywtNi4xNDggMS4zNDMsLTExLjQ0MmwwLC0yMi4zMDRjMCwtNS4xMzcgLTAuNDQ5LC04Ljg5MyAtMS4zNDMsLTExLjI2OGMtMC44OTUsLTIuMzczIC0yLjQ3MiwtMy41NjEgLTQuNzI4LC0zLjU2MWMtMi4xOCwwIC0zLjcxOSwxLjE4OCAtNC42MTMsMy41NjFjLTAuODk1LDIuMzc1IC0xLjM0Myw2LjEzMSAtMS4zNDMsMTEuMjY4bDAsMjIuMzA0YzAsNS4yOTQgMC40MjcsOS4xMDkgMS4yODUsMTEuNDQyYzAuODU1LDIuMzM2IDIuNDExLDMuNTAzIDQuNjcxLDMuNTAzYzIuMjU2LDAgMy44MzMsLTEuMTY3IDQuNzI4LC0zLjUwM1ptLTE4LjA5OCwxMS4yMTFjLTMuMjMzLC0yLjE3NyAtNS41MywtNS41NjUgLTYuODksLTEwLjE2Yy0xLjM2MywtNC41OTEgLTIuMDQzLC0xMC43MDMgLTIuMDQzLC0xOC4zMzJsMCwtMTAuMzkyYzAsLTcuNzA3IDAuNzc3LC0xMy44OTcgMi4zMzUsLTE4LjU2NmMxLjU1NiwtNC42NzEgMy45ODgsLTguMDc3IDcuMjk4LC0xMC4yMThjMy4zMDgsLTIuMTQgNy42NDgsLTMuMjExIDEzLjAyLC0zLjIxMWM1LjI5NCwwIDkuNTM2LDEuMDkgMTIuNzI4LDMuMjdjMy4xOTEsMi4xNzkgNS41MjcsNS41ODYgNy4wMDcsMTAuMjE2YzEuNDc3LDQuNjM0IDIuMjE3LDEwLjgwMiAyLjIxNywxOC41MDlsMCwxMC4zOTJjMCw3LjYyOSAtMC43MiwxMy43NjEgLTIuMTYsMTguMzkyYy0xLjQ0MSw0LjYzMyAtMy43NzcsOC4wMTggLTcuMDA2LDEwLjE1OGMtMy4yMzIsMi4xNDEgLTcuNjA5LDMuMjExIC0xMy4xMzYsMy4yMTFjLTUuNjg1LDAgLTEwLjE0MiwtMS4wOSAtMTMuMzcsLTMuMjY5WiIgc3R5bGU9ImZpbGw6IzI3MjcyNztmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNNDg3LjA2OCwyNDQuMzg1Yy0wLjgxNiwxLjAxMyAtMS4zNjMsMi42NjcgLTEuNjM0LDQuOTYyYy0wLjI3NCwyLjI5NyAtMC40MDcsNS43ODEgLTAuNDA3LDEwLjQ1MmwwLDUuMTM5bDExLjc5MSwwbDAsLTUuMTM5YzAsLTQuNTkzIC0wLjE1NiwtOC4wNzcgLTAuNDY2LC0xMC40NTJjLTAuMzEyLC0yLjM3MyAtMC44NzUsLTQuMDQ1IC0xLjY5MiwtNS4wMmMtMC44MTksLTAuOTczIC0yLjA4NCwtMS40NiAtMy43OTYsLTEuNDZjLTEuNzE0LDAgLTIuOTc4LDAuNTA3IC0zLjc5NiwxLjUxOFptLTIuMDQxLDMwLjEyOGwwLDMuNjJjMCw0LjU5NCAwLjEzMyw4LjAzNyAwLjQwNywxMC4zMzNjMC4yNzEsMi4yOTcgMC44MzUsMy45NzIgMS42OTMsNS4wMjNjMC44NTcsMS4wNSAyLjE3OCwxLjU3NyAzLjk3MSwxLjU3N2MyLjQxMSwwIDQuMDY3LC0wLjkzNiA0Ljk2MiwtMi44MDRjMC44OTQsLTEuODY4IDEuMzgxLC00Ljk4MSAxLjQ1OSwtOS4zNDJsMTMuODk2LDAuODE4YzAuMDc4LDAuNjI1IDAuMTE3LDEuNDc5IDAuMTE3LDIuNTY4YzAsNi42MTggLTEuODA5LDExLjU2MiAtNS40MywxNC44MzFjLTMuNjE4LDMuMjY5IC04LjczOSw0LjkwNSAtMTUuMzU1LDQuOTA1Yy03Ljk0LDAgLTEzLjUwNywtMi40OTEgLTE2LjY5OCwtNy40NzVjLTMuMTkzLC00Ljk4IC00Ljc4OSwtMTIuNjg3IC00Ljc4OSwtMjMuMTJsMCwtMTIuNDk2YzAsLTEwLjc0MiAxLjY1NSwtMTguNTg0IDQuOTY0LC0yMy41MjhjMy4zMDgsLTQuOTQ0IDguOTcyLC03LjQxNiAxNi45OTEsLTcuNDE2YzUuNTI1LDAgOS43NjksMS4wMTIgMTIuNzI3LDMuMDM2YzIuOTU3LDIuMDI2IDUuMDQsNS4xNzggNi4yNDcsOS40NTljMS4yMDcsNC4yODIgMS44MTEsMTAuMTk5IDEuODExLDE3Ljc0OWwwLDEyLjI2MmwtMjYuOTczLDBaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0xOTcuNzcyLDI3My4xNzJsLTE4LjMzMywtNjYuMjA5bDE1Ljk5NywwbDYuNDIyLDMwLjAwOWMxLjYzNiw3LjM5OCAyLjg0MiwxMy43MDMgMy42MiwxOC45MTdsMC40NjgsMGMwLjU0NCwtMy43MzYgMS43NTEsLTEwLjAwMSAzLjYxOSwtMTguOGw2LjY1NiwtMzAuMTI2bDE1Ljk5OCwwbC0xOC41NjYsNjYuMjA5bDAsMzEuNzYzbC0xNS44ODEsMGwwLC0zMS43NjNaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0zMjQuNzE0LDIzMy4zNTVsMCw3MS41OGwtMTIuNjExLDBsLTEuNDAyLC04Ljc1NmwtMC4zNSwwYy0zLjQyNiw2LjYxNyAtOC41NjQsOS45MjQgLTE1LjQxNCw5LjkyNGMtNC43NDgsMCAtOC4yNTEsLTEuNTU2IC0xMC41MDksLTQuNjdjLTIuMjU4LC0zLjExMyAtMy4zODYsLTcuOTggLTMuMzg2LC0xNC41OTZsMCwtNTMuNDgybDE2LjExNCwwbDAsNTIuNTQ3YzAsMy4xOTMgMC4zNTEsNS40NyAxLjA1MSw2LjgzYzAuNzAxLDEuMzY0IDEuODY5LDIuMDQ1IDMuNTAzLDIuMDQ1YzEuNDAyLDAgMi43NDUsLTAuNDI4IDQuMDI4LC0xLjI4NWMxLjI4NSwtMC44NTcgMi4yMzgsLTEuOTQ1IDIuODYyLC0zLjI2OWwwLC01Ni44NjhsMTYuMTE0LDBaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik00MDcuMzcxLDIzMy4zNTVsMCw3MS41OGwtMTIuNjExLDBsLTEuNDAyLC04Ljc1NmwtMC4zNDgsMGMtMy40MjksNi42MTcgLTguNTY2LDkuOTI0IC0xNS40MTYsOS45MjRjLTQuNzQ5LDAgLTguMjUxLC0xLjU1NiAtMTAuNTA5LC00LjY3Yy0yLjI1OSwtMy4xMTMgLTMuMzg2LC03Ljk4IC0zLjM4NiwtMTQuNTk2bDAsLTUzLjQ4MmwxNi4xMTQsMGwwLDUyLjU0N2MwLDMuMTkzIDAuMzUsNS40NyAxLjA1LDYuODNjMC43MDIsMS4zNjQgMS44NywyLjA0NSAzLjUwNCwyLjA0NWMxLjQwMiwwIDIuNzQ1LC0wLjQyOCA0LjAyOCwtMS4yODVjMS4yODUsLTAuODU3IDIuMjM4LC0xLjk0NSAyLjg2MiwtMy4yNjlsMCwtNTYuODY4bDE2LjExNCwwWiIgc3R5bGU9ImZpbGw6IzI3MjcyNztmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNMzY4LjUwMywyMTkuOTI2bC0xNS45OTgsMGwwLDg1LjAwOWwtMTUuNzY0LDBsMCwtODUuMDA5bC0xNS45OTcsMGwwLC0xMi45NjJsNDcuNzU5LDBsMCwxMi45NjJaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik00NDUuOTMzLDI3My45OTVjMCw1LjIxNyAtMC4yMTYsOS4zMDQgLTAuNjQzLDEyLjI2MWMtMC40MjgsMi45NiAtMS4xNDgsNS4wNjIgLTIuMTYsNi4zMDZjLTEuMDEyLDEuMjQ2IC0yLjM3NywxLjg2OCAtNC4wODYsMS44NjhjLTEuMzI2LDAgLTIuNTUyLC0wLjMxMSAtMy42NzksLTAuOTM0Yy0xLjEzMSwtMC42MjMgLTIuMDQzLC0xLjU1NyAtMi43NDUsLTIuODAzbDAsLTQwLjYzNmMwLjU0NSwtMS45NDUgMS40NzksLTMuNTQyIDIuODAzLC00Ljc4OGMxLjMyNCwtMS4yNDMgMi43NjIsLTEuODY4IDQuMzIsLTEuODY4YzEuNjM1LDAgMi44OTksMC42NDMgMy43OTUsMS45MjZjMC44OTQsMS4yODUgMS41MTgsMy40NDUgMS44NjksNi40ODNjMC4zNSwzLjAzNSAwLjUyNiw3LjM1NSAwLjUyNiwxMi45NmwwLDkuMjI1Wm0xNC43NzEsLTI5LjE5N2MtMC45NzUsLTQuNTE0IC0yLjU1MSwtNy43ODQgLTQuNzMsLTkuODFjLTIuMTgsLTIuMDIzIC01LjE3OCwtMy4wMzUgLTguOTkxLC0zLjAzNWMtMi45NTgsMCAtNS43MjIsMC44MzggLTguMjksMi41MTFjLTIuNTY5LDEuNjc0IC00LjU1NSwzLjg3MyAtNS45NTYsNi41OTdsLTAuMTE4LDBsMC4wMDEsLTM3LjcxN2wtMTUuNTMsMGwwLDEwMS41OWwxMy4zMTEsMGwxLjYzNiwtNi43NzJsMC4zNDksMGMxLjI0NSwyLjQxMyAzLjExMyw0LjMyIDUuNjA1LDUuNzIyYzIuNDkxLDEuNDAxIDUuMjU2LDIuMTAyIDguMjkyLDIuMTAyYzUuNDQ4LDAgOS40NTcsLTIuNTEyIDEyLjAyNywtNy41MzJjMi41NjksLTUuMDIxIDMuODUzLC0xMi44NjMgMy44NTMsLTIzLjUzbDAsLTExLjMyNWMwLC04LjAxOCAtMC40ODcsLTE0LjI4NSAtMS40NTksLTE4LjgwMVoiIHN0eWxlPSJmaWxsOiMyNzI3Mjc7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PC9nPjwvc3ZnPg==" alt="Youtube" width="58">
										<i class="fa fa-search"></i>
									</div>
									<div class="thumb-box" style="height: 140px;">
										<img src=<?= $groupe['images'][0] ?? "https://placehold.co/120x120?text=Youtube+Ads" ?> alt="placeholder">
									</div>
									<div class="alert alert-primary border-0 py-0 px-2 d-flex justify-content-between align-items-center">
										<span class="small font-weight-bold">Réservation</span>
										<i class="fa fa-external-link-alt"></i>
									</div>
									<div class="row no-gutters justify-content-between">
										<div class="col-auto">
											<img src="<?= $groupe['favicon'] ?>" alt="" class="rounded-circle" width="38">
										</div>
										<div class="col px-2">
											<p class="font-weight-bold m-0"><?= $groupe['titre1'] ?></p>
											<p class="small text-muted m-0"><?= $groupe['descriptions1'] ?></p>
										</div>
										<div class="col-auto">
											<i class="fa fa-ellipsis-v"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Gmail -->
						<div class="">
							<div class=" device-frame phone-frame">
								<div class="screen">
									<div class="d-flex justify-content-between align-items-center mb-3">
										<i class="fa fa-chevron-left mr-auto"></i>
										<i class="mr-4 far fa-star"></i>
										<i class="mr-4 fa fa-trash"></i>
										<i class="fa fa-ellipsis-h"></i>
									</div>
									<div class="row no-gutters justify-content-start mb-3">
										<div class="col-auto">
											<img src="<?= $groupe['favicon'] ?>" alt="" class="rounded-circle" width="38">
										</div>
										<div class="pl-2 col">
											<p class="small m-0"><?= $groupe['nom_client'] ?></p>
											<p class="small m-0 text-muted">à Moi</p>
										</div>
									</div>
									<div class="thumb-box mb-3" style="height: 140px;">
										<img src=<?= $groupe['images'][1] ?? $groupe['images'][0] ?? "https://placehold.co/120x120?text=Gmail+Attachment" ?> alt="placeholder">
									</div>

									<p class="font-weight-bold mb-2"><?= $groupe['titre1'] ?></p>
									<p class="small text-muted"><?= $groupe['descriptions1'] ?></p>

									<span class="badge badge-primary py-2 w-100 rounded-pill">Réservation</span>
								</div>
							</div>
						</div>

						<!-- Search -->
						<div class="">
							<div class=" device-frame phone-frame">
								<div class="screen">
									<div class="d-flex align-items-center mb-1">
										<i class="fa fa-bars text-muted"></i>
										<img alt="google" height="24" class="mx-auto" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBoZWlnaHQ9IjkyIiB2aWV3Qm94PSIwIDAgMjcyIDkyIiB3aWR0aD0iMjcyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0xMTUuNzUgNDcuMThjMCAxMi43Ny05Ljk5IDIyLjE4LTIyLjI1IDIyLjE4cy0yMi4yNS05LjQxLTIyLjI1LTIyLjE4QzcxLjI1IDM0LjMyIDgxLjI0IDI1IDkzLjUgMjVzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NFM4MC45OSAzOS4yIDgwLjk5IDQ3LjE4YzAgNy45IDUuNzkgMTMuNDQgMTIuNTEgMTMuNDRzMTIuNTEtNS41NSAxMi41MS0xMy40NHoiIGZpbGw9IiNFQTQzMzUiLz48cGF0aCBkPSJNMTYzLjc1IDQ3LjE4YzAgMTIuNzctOS45OSAyMi4xOC0yMi4yNSAyMi4xOHMtMjIuMjUtOS40MS0yMi4yNS0yMi4xOGMwLTEyLjg1IDkuOTktMjIuMTggMjIuMjUtMjIuMThzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NHMtMTIuNTEgNS40Ni0xMi41MSAxMy40NGMwIDcuOSA1Ljc5IDEzLjQ0IDEyLjUxIDEzLjQ0czEyLjUxLTUuNTUgMTIuNTEtMTMuNDR6IiBmaWxsPSIjRkJCQzA1Ii8+PHBhdGggZD0iTTIwOS43NSAyNi4zNHYzOS44MmMwIDE2LjM4LTkuNjYgMjMuMDctMjEuMDggMjMuMDctMTAuNzUgMC0xNy4yMi03LjE5LTE5LjY2LTEzLjA3bDguNDgtMy41M2MxLjUxIDMuNjEgNS4yMSA3Ljg3IDExLjE3IDcuODcgNy4zMSAwIDExLjg0LTQuNTEgMTEuODQtMTN2LTMuMTloLS4zNGMtMi4xOCAyLjY5LTYuMzggNS4wNC0xMS42OCA1LjA0LTExLjA5IDAtMjEuMjUtOS42Ni0yMS4yNS0yMi4wOSAwLTEyLjUyIDEwLjE2LTIyLjI2IDIxLjI1LTIyLjI2IDUuMjkgMCA5LjQ5IDIuMzUgMTEuNjggNC45NmguMzR2LTMuNjFoOS4yNXptLTguNTYgMjAuOTJjMC03LjgxLTUuMjEtMTMuNTItMTEuODQtMTMuNTItNi43MiAwLTEyLjM1IDUuNzEtMTIuMzUgMTMuNTIgMCA3LjczIDUuNjMgMTMuMzYgMTIuMzUgMTMuMzYgNi42MyAwIDExLjg0LTUuNjMgMTEuODQtMTMuMzZ6IiBmaWxsPSIjNDI4NUY0Ii8+PHBhdGggZD0iTTIyNSAzdjY1aC05LjVWM2g5LjV6IiBmaWxsPSIjMzRBODUzIi8+PHBhdGggZD0iTTI2Mi4wMiA1NC40OGw3LjU2IDUuMDRjLTIuNDQgMy42MS04LjMyIDkuODMtMTguNDggOS44My0xMi42IDAtMjIuMDEtOS43NC0yMi4wMS0yMi4xOCAwLTEzLjE5IDkuNDktMjIuMTggMjAuOTItMjIuMTggMTEuNTEgMCAxNy4xNCA5LjE2IDE4Ljk4IDE0LjExbDEuMDEgMi41Mi0yOS42NSAxMi4yOGMyLjI3IDQuNDUgNS44IDYuNzIgMTAuNzUgNi43MiA0Ljk2IDAgOC40LTIuNDQgMTAuOTItNi4xNHptLTIzLjI3LTcuOThsMTkuODItOC4yM2MtMS4wOS0yLjc3LTQuMzctNC43LTguMjMtNC43LTQuOTUgMC0xMS44NCA0LjM3LTExLjU5IDEyLjkzeiIgZmlsbD0iI0VBNDMzNSIvPjxwYXRoIGQ9Ik0zNS4yOSA0MS40MVYzMkg2N2MuMzEgMS42NC40NyAzLjU4LjQ3IDUuNjggMCA3LjA2LTEuOTMgMTUuNzktOC4xNSAyMi4wMS02LjA1IDYuMy0xMy43OCA5LjY2LTI0LjAyIDkuNjZDMTYuMzIgNjkuMzUuMzYgNTMuODkuMzYgMzQuOTEuMzYgMTUuOTMgMTYuMzIuNDcgMzUuMy40N2MxMC41IDAgMTcuOTggNC4xMiAyMy42IDkuNDlsLTYuNjQgNi42NGMtNC4wMy0zLjc4LTkuNDktNi43Mi0xNi45Ny02LjcyLTEzLjg2IDAtMjQuNyAxMS4xNy0yNC43IDI1LjAzIDAgMTMuODYgMTAuODQgMjUuMDMgMjQuNyAyNS4wMyA4Ljk5IDAgMTQuMTEtMy42MSAxNy4zOS02Ljg5IDIuNjYtMi42NiA0LjQxLTYuNDYgNS4xLTExLjY1bC0yMi40OS4wMXoiIGZpbGw9IiM0Mjg1RjQiLz48L3N2Zz4=">
									</div>
									<div class="d-flex justify-content-between align-items-center border rounded-pill w-100 px-2 py-1">
										<i class="fa fa-search"></i>
										<span class="mr-auto ml-3"><?= htmlspecialchars(strtok($groupe['mot_cle'] ?? '', "\n"), ENT_QUOTES, 'UTF-8') ?></span>
										<img height="20" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBpZD0iQ2FwYV8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxNTAgMTUwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMTUwIDE1MCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojMUE3M0U4O30KCS5zdDF7ZmlsbDojRUE0MzM1O30KCS5zdDJ7ZmlsbDojNDI4NUY0O30KCS5zdDN7ZmlsbDojRkJCQzA0O30KCS5zdDR7ZmlsbDojMzRBODUzO30KCS5zdDV7ZmlsbDojNENBRjUwO30KCS5zdDZ7ZmlsbDojMUU4OEU1O30KCS5zdDd7ZmlsbDojRTUzOTM1O30KCS5zdDh7ZmlsbDojQzYyODI4O30KCS5zdDl7ZmlsbDojRkJDMDJEO30KCS5zdDEwe2ZpbGw6IzE1NjVDMDt9Cgkuc3QxMXtmaWxsOiMyRTdEMzI7fQoJLnN0MTJ7ZmlsbDojRjZCNzA0O30KCS5zdDEze2ZpbGw6I0U1NDMzNTt9Cgkuc3QxNHtmaWxsOiM0MjgwRUY7fQoJLnN0MTV7ZmlsbDojMzRBMzUzO30KCS5zdDE2e2NsaXAtcGF0aDp1cmwoI1NWR0lEXzJfKTt9Cgkuc3QxN3tmaWxsOiMxODgwMzg7fQoJLnN0MTh7b3BhY2l0eTowLjI7ZmlsbDojRkZGRkZGO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MTl7b3BhY2l0eTowLjM7ZmlsbDojMEQ2NTJEO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjB7Y2xpcC1wYXRoOnVybCgjU1ZHSURfNF8pO30KCS5zdDIxe29wYWNpdHk6MC4zO2ZpbGw6dXJsKCNfNDVfc2hhZG93XzFfKTtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDIye2NsaXAtcGF0aDp1cmwoI1NWR0lEXzZfKTt9Cgkuc3QyM3tmaWxsOiNGQTdCMTc7fQoJLnN0MjR7b3BhY2l0eTowLjM7ZmlsbDojMTc0RUE2O2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjV7b3BhY2l0eTowLjM7ZmlsbDojQTUwRTBFO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjZ7b3BhY2l0eTowLjM7ZmlsbDojRTM3NDAwO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0Mjd7ZmlsbDp1cmwoI0ZpbmlzaF9tYXNrXzFfKTt9Cgkuc3QyOHtmaWxsOiNGRkZGRkY7fQoJLnN0Mjl7ZmlsbDojMEM5RDU4O30KCS5zdDMwe29wYWNpdHk6MC4yO2ZpbGw6IzAwNEQ0MDtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMxe29wYWNpdHk6MC4yO2ZpbGw6IzNFMjcyMztlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMye2ZpbGw6I0ZGQzEwNzt9Cgkuc3QzM3tvcGFjaXR5OjAuMjtmaWxsOiMxQTIzN0U7ZW5hYmxlLWJhY2tncm91bmQ6bmV3ICAgIDt9Cgkuc3QzNHtvcGFjaXR5OjAuMjt9Cgkuc3QzNXtmaWxsOiMxQTIzN0U7fQoJLnN0MzZ7ZmlsbDp1cmwoI1NWR0lEXzdfKTt9Cgkuc3QzN3tmaWxsOiNGQkJDMDU7fQoJLnN0Mzh7Y2xpcC1wYXRoOnVybCgjU1ZHSURfOV8pO2ZpbGw6I0U1MzkzNTt9Cgkuc3QzOXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xMV8pO2ZpbGw6I0ZCQzAyRDt9Cgkuc3Q0MHtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xM18pO2ZpbGw6I0U1MzkzNTt9Cgkuc3Q0MXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xNV8pO2ZpbGw6I0ZCQzAyRDt9Cjwvc3R5bGU+PGc+PGcgaWQ9ImcxNzQ4MCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQ2LjMwMzQsMjM2LjM3ODkpIj48cGF0aCBjbGFzcz0ic3Q2IiBkPSJNLTU3MS4zLTE0Ny4zYzcuOSwwLDE0LjItNi40LDE0LjItMTQuMmwwLTMzLjJjMC03LjktNi40LTE0LjItMTQuMi0xNC4yICAgIGMtNy45LDAtMTQuMiw2LjQtMTQuMiwxNC4ydjMzLjJDLTU4NS41LTE1My43LTU3OS4xLTE0Ny4zLTU3MS4zLTE0Ny4zIiBpZD0icGF0aDE3NDgyIi8+PC9nPjxnIGlkPSJnMTc0ODQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDY0NS40ODAzLDIzMy4xNDkyKSI+PHBhdGggY2xhc3M9InN0NSIgZD0iTS01NzUuMi0xMjUuNUwtNTc1LjItMTI1LjV2MTQuOWg5LjV2LTE0LjhjLTEuNSwwLjItMy4xLDAuMi00LjcsMC4yICAgIEMtNTcyLjEtMTI1LjEtNTczLjYtMTI1LjItNTc1LjItMTI1LjUiIGlkPSJwYXRoMTc0ODYiLz48L2c+PGcgaWQ9ImcxNzQ4OCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQzLjM4MDksMjM1LjkxMTUpIj48cGF0aCBjbGFzcz0ic3Q5IiBkPSJNLTU4NS4yLTE0NC4xYy00LjItNC4zLTYuOS05LjUtNi45LTE2LjZoLTkuNWMwLDkuNSwzLjcsMTcuMyw5LjcsMjMuM2wwLjEtMC4xICAgIGMwLDAsMCwwLTAuMS0wLjFMLTU4NS4yLTE0NC4xeiIgaWQ9InBhdGgxNzQ5MCIvPjwvZz48ZyBpZD0iZzE3NDkyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2NTAuNDA4MSwyMzguNzkpIj48cGF0aCBjbGFzcz0ic3Q3IiBkPSJNLTU1MS43LTE2My42YzAsMTEuOS0xMC41LDIzLjYtMjMuNywyMy42Yy02LjYsMC0xMi41LTIuNy0xNi44LTdsLTAuMSwwLjFsLTYuNiw2LjYgICAgYzAsMCwwLDAsMC4xLDAuMWM0LjksNC45LDExLjQsOC4yLDE4LjcsOS4zYzEuNiwwLjIsMy4yLDAuNCw0LjgsMC40YzEuNiwwLDMuMiwwLDQuNy0wLjJjMTYuMS0yLjMsMjguNC0xNi4xLDI4LjQtMzIuN0gtNTUxLjd6IiBpZD0icGF0aDE3NDk0Ii8+PC9nPjwvZz48L3N2Zz4=" alt="google-microphone">
									</div>
									<hr>
									<p class="small font-weight-bold mb-2">Sponsorisé</p>
									<div class="row no-gutters justify-content-start mb-2">
										<div class="col-auto">
											<img src="<?= $groupe['favicon'] ?>" alt="" class="rounded-circle" width="38">
										</div>
										<div class="pl-2 col">
											<p class="m-0"><?= $groupe['nom_client'] ?></p>
											<p class="small m-0 text-muted"><?= $groupe['url_site'] ?></p>
										</div>
									</div>

									<p class="text-primary mb-2"><?= $groupe['titre1'] ?></p>
									<p class="small text-muted mb-2"><?= $groupe['descriptions1'] ?></p>

									<span class="border rounded-pill text-primary py-1 px-2 small"><?= htmlspecialchars(strtok($groupe['mot_cle'] ?? '', "\n"), ENT_QUOTES, 'UTF-8') ?></span>
									<span class="border rounded-pill text-primary py-1 px-2 small">Promotions</span>
									<hr>
									<i class="fa fa-phone"></i>
									Appeler le <?= $groupe['numero_client'] ?>
								</div>
							</div>
						</div>

						<!-- Display -->
						<div class="">
							<div class=" device-frame phone-frame">
								<div class="screen">
									<div class="thumb-box mb-3" style="height: 140px;">
										<img src=<?= $groupe['images'][2] ?? $groupe['images'][1] ?? $groupe['images'][0] ?? "https://placehold.co/120x120?text=Display" ?> alt="placeholder">
									</div>
									<div class="row no-gutters justify-content-start mb-2">
										<div class="col-auto">
											<img src="<?= $groupe['favicon'] ?>" alt="" class="rounded-circle" width="38">
										</div>
										<div class="pl-2 col">
											<p class="m-0"><?= $groupe['nom_client'] ?></p>
										</div>
									</div>
									<div class="d-flex justify-content-between">
										<span class="small text-muted"><?= $groupe['titre1'] ?></span>
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
						<div class="">
							<div class=" device-frame phone-frame">
								<div class="screen">
									<div class="row no-gutters justify-content-start mb-3">
										<div class="col-auto">
											<img src="<?= $groupe['favicon'] ?>" alt="" class="rounded-circle" width="38">
										</div>
										<div class="pl-2 col">
											<p class="m-0"><?= $groupe['nom_client'] ?></p>
											<p class="small m-0 text-muted">Sponsored</p>
										</div>
									</div>
									<div class="thumb-box mb-3" style="height: 220px;">
										<img src=<?= $groupe['images'][3] ?? $groupe['images'][2] ?? $groupe['images'][1] ?? $groupe['images'][0] ?? "https://placehold.co/120x120?text=Discovery" ?> alt="placeholder">
										<span class="bg-white position-absolute text-primary" style="right: 2px; top: 2px; padding: 0px 2px;">
											<i class="fa fa-info-circle"></i>
										</span>
									</div>
									<p><?= $groupe['descriptions1'] ?></p>
									<div class="d-flex justify-content-end align-items-center text-muted">
										<i class="far fa-heart mr-4"></i>
										<i class="fa fa-share-square mr-4"></i>
										<i class="fa fa-ellipsis-h"></i>
									</div>
								</div>
							</div>
						</div>

					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div> <!-- .section -->

	</div>
</body>

</html>
