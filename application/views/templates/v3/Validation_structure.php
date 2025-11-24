<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Validation client — Campagne Google Ads</title>

	<!-- Styles & librairies -->
	<link href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet" />
	<style>
		.section {
			background: var(--bg-card);
			border-radius: 14px;
			box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
			margin: 40px 0;
			padding: 25px;
			/* width: 1350px; */
		}

		/* Table */
		table {
			width: 100%;
			border-collapse: collapse;
			font-size: 15px
		}

		thead {
			background: var(--primary);
			color: #fff
		}

		th,
		td {
			padding: 12px 14px;
			border-bottom: 1px solid var(--border);
			vertical-align: top;
			text-align: left
		}

		tbody tr:nth-child(even) {
			background: #f6f9fc
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
			background: #fff;
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
			background: #fff;
			border-radius: 10px;
			transform: translateX(-50%);
		}

		/* Desktop */
		.desktop-frame {
			width: 600px;
			height: 430px;
			border-radius: 10px;
			border: 4px solid #fff;
		}

		.desktop-frame::before {
			content: "";
			position: absolute;
			top: -18px;
			left: 50%;
			width: 120px;
			height: 12px;
			background: #fff;
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
			background: #fff;
			border-radius: 3px;
			transform: translateX(-50%);
		}

		/* Screen area */
		.screen {
			width: 100%;
			height: 100%;
			background: #fff;
			overflow: hidden;
			padding: 25px 15px 15px 15px;
		}
	</style>
</head>

<body>
	<div class="container-fluid px-5 pb-5">

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
						<th style="width:100px;background-color:#a4c2f4">Budget</th>
						<th style="width:300px;">Campagne</th>
						<th style="width:300px;">Groupe</th>
						<th style="width:300px;">Mots‑clés (groupe)</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($campagnes) && is_array($campagnes)): ?>
						<?php foreach ($campagnes as $C): ?>
							<?php $groupes = $C['groupes_annonces'] ?? []; ?>
							<?php if (!empty($groupes)): ?>
								<?php foreach ($groupes as $G): ?>
									<tr>
										<td><?= htmlspecialchars($C['zones'] ?? '—'); ?></td>
										<td><?= htmlspecialchars($C['date_campagne'] ?? '—'); ?></td>
										<td><?= htmlspecialchars($C['appareil'] ?? '—'); ?></td>
										<td>
											<?php $b = trim((string)($C['repartition_budget'] ?? '')); ?>
											<?= $b !== '' ? htmlspecialchars($b) . ' €' : '—'; ?>
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
										<?= $b !== '' ? htmlspecialchars($b) . ' €' : '—'; ?>
									</td>
									<td><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
									<td colspan="3">Aucun groupe d’annonce</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="8">Aucune campagne disponible.</td>
						</tr>
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
					<?php $groupes = $C['groupes_annonces'] ?? [];
					$campImages = $C['images'] ?? []; ?>
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
								<tr>
									<th>Campagne</th>
									<td><b><?= htmlspecialchars($C['nom_campagne'] ?? ''); ?></b></td>
								</tr>
								<tr>
									<th>Groupe</th>
									<td><b><?= htmlspecialchars($G['nom_groupe'] ?? ''); ?></b></td>
								</tr>
								<tr>
									<th>Titres</th>
									<td>
										<?php
										$titres = [];
										for ($i = 1; $i <= 12; $i++) if (!empty($G['titre' . $i])) $titres[] = htmlspecialchars($G['titre' . $i]);
										echo !empty($titres) ? implode('<br>', $titres) : 'Aucun titre';
										?>
									</td>
								</tr>
								<tr>
									<th>Descriptions</th>
									<td>
										<?php
										$desc = [];
										for ($i = 1; $i <= 4; $i++) if (!empty($G['descriptions' . $i])) $desc[] = htmlspecialchars($G['descriptions' . $i]);
										echo !empty($desc) ? implode('<br>', $desc) : 'Aucune description';
										?>
									</td>
								</tr>

								<?php if (($G['type_campagnes'] ?? null) == 1): ?>
									<tr>
										<th>Chemin 1</th>
										<td><?= htmlspecialchars($G['chemin1'] ?? ''); ?></td>
									</tr>
									<tr>
										<th>Chemin 2</th>
										<td><?= htmlspecialchars($G['chemin2'] ?? ''); ?></td>
									</tr>
								<?php endif; ?>

								<?php if (($G['type_campagnes'] ?? null) == 2 || ($G['type_campagnes'] ?? null) == 3): ?>
									<tr>
										<th>Description brève</th>
										<td><?= htmlspecialchars($G['description_breve'] ?? ''); ?></td>
									</tr>
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

								<tr>
									<th>URL</th>
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
						<?php $i = 0;
						foreach ($extensions as $E): ?>
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
						<?php $i++;
						endforeach; ?>
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

			<table style="width:100%;border-collapse:collapse;border:1px solid #dee2e6;background:#fff">
				<thead style="background:#4EA5FE;color:#fff">
					<tr>
						<th colspan="2" style="padding:12px;border:1px solid #dee2e6;text-align:center">Liste</th>
					</tr>
				</thead>
				<tbody>
					<?php $hasContent = false;
					$i = 0;
					foreach ($exlusions as $D): if ($D['exclusion'] != NULL): $hasContent = true;
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
							<tr>
								<td style="padding:12px;border:1px solid #dee2e6;text-align:center"><?php echo nl2br($firstPart); ?></td>
								<?php if (!empty($secondPart)): ?>
									<td style="padding:12px;border:1px solid #dee2e6;text-align:center"><?php echo nl2br($secondPart); ?></td>
								<?php endif; ?>
							</tr>
					<?php $i++;
						endif;
					endforeach; ?>
					<?php if (!$hasContent): ?>
						<tr>
							<td colspan="2" style="padding:12px;border:1px solid #dee2e6;text-align:center">Aucune exclusion</td>
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

		<!-- Inventaire PMAX -->
		<div class="section">
			<div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
				<img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
				<h2 class="m-0" style="color:#000">Inventaire PMax</h2>
			</div>

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

			<?php foreach ($groupe_valider as $groupe): ?>
				<?php if ($groupe['type_campagne'] == 3): ?>

					<div class="row row-cols-5 mb-4 small">
						<!-- YouTube -->
						<div class="col-auto">
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
						<div class="col-auto">
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
						<div class="col-auto">
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
						<div class="col-auto">
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
						<div class="col-auto">
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
		</div>

		<!-- Inventaire Search -->
		<div class="section">
			<div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
				<img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
				<h2 class="m-0" style="color:#000">Inventaire Search</h2>
			</div>

			<?php foreach ($groupe_valider as $groupe): ?>
				<?php if ($groupe['type_campagne'] == 1): ?>
					<div class="row row-cols-3 justify-content-around  mb-4 small">

						<!-- Search -->
						<div class="col-auto">
							<div class="text-center">
								<div class="mockup-icon">
									<img src="data:image/png;base64,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" alt="Mobile">
								</div>
								<p class="mockup-label">Mobile</p>
							</div>

							<!-- foreach here -->
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

						<!-- Search -->
						<div class="col-auto">
							<div class="text-center">
								<div class="mockup-icon">
									<img src="data:image/png;base64,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" alt="Tablet">
								</div>
								<p class="mockup-label">Tablette</p>
							</div>

							<!-- foreach here -->
							<div class=" device-frame tablet-frame">
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

						<!-- Search -->
						<div class="col-auto">
							<div class="text-center">
								<div class="mockup-icon">
									<img src="data:image/png;base64,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" alt="Desktop">
								</div>
								<p class="mockup-label">Bureau</p>
							</div>

							<div class=" device-frame tablet-frame" style="width: 500px;">
								<div class="screen">
									<div class="d-flex align-items-center mb-1">

										<img alt="google" height="24" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBoZWlnaHQ9IjkyIiB2aWV3Qm94PSIwIDAgMjcyIDkyIiB3aWR0aD0iMjcyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0xMTUuNzUgNDcuMThjMCAxMi43Ny05Ljk5IDIyLjE4LTIyLjI1IDIyLjE4cy0yMi4yNS05LjQxLTIyLjI1LTIyLjE4QzcxLjI1IDM0LjMyIDgxLjI0IDI1IDkzLjUgMjVzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NFM4MC45OSAzOS4yIDgwLjk5IDQ3LjE4YzAgNy45IDUuNzkgMTMuNDQgMTIuNTEgMTMuNDRzMTIuNTEtNS41NSAxMi41MS0xMy40NHoiIGZpbGw9IiNFQTQzMzUiLz48cGF0aCBkPSJNMTYzLjc1IDQ3LjE4YzAgMTIuNzctOS45OSAyMi4xOC0yMi4yNSAyMi4xOHMtMjIuMjUtOS40MS0yMi4yNS0yMi4xOGMwLTEyLjg1IDkuOTktMjIuMTggMjIuMjUtMjIuMThzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NHMtMTIuNTEgNS40Ni0xMi41MSAxMy40NGMwIDcuOSA1Ljc5IDEzLjQ0IDEyLjUxIDEzLjQ0czEyLjUxLTUuNTUgMTIuNTEtMTMuNDR6IiBmaWxsPSIjRkJCQzA1Ii8+PHBhdGggZD0iTTIwOS43NSAyNi4zNHYzOS44MmMwIDE2LjM4LTkuNjYgMjMuMDctMjEuMDggMjMuMDctMTAuNzUgMC0xNy4yMi03LjE5LTE5LjY2LTEzLjA3bDguNDgtMy41M2MxLjUxIDMuNjEgNS4yMSA3Ljg3IDExLjE3IDcuODcgNy4zMSAwIDExLjg0LTQuNTEgMTEuODQtMTN2LTMuMTloLS4zNGMtMi4xOCAyLjY5LTYuMzggNS4wNC0xMS42OCA1LjA0LTExLjA5IDAtMjEuMjUtOS42Ni0yMS4yNS0yMi4wOSAwLTEyLjUyIDEwLjE2LTIyLjI2IDIxLjI1LTIyLjI2IDUuMjkgMCA5LjQ5IDIuMzUgMTEuNjggNC45NmguMzR2LTMuNjFoOS4yNXptLTguNTYgMjAuOTJjMC03LjgxLTUuMjEtMTMuNTItMTEuODQtMTMuNTItNi43MiAwLTEyLjM1IDUuNzEtMTIuMzUgMTMuNTIgMCA3LjczIDUuNjMgMTMuMzYgMTIuMzUgMTMuMzYgNi42MyAwIDExLjg0LTUuNjMgMTEuODQtMTMuMzZ6IiBmaWxsPSIjNDI4NUY0Ii8+PHBhdGggZD0iTTIyNSAzdjY1aC05LjVWM2g5LjV6IiBmaWxsPSIjMzRBODUzIi8+PHBhdGggZD0iTTI2Mi4wMiA1NC40OGw3LjU2IDUuMDRjLTIuNDQgMy42MS04LjMyIDkuODMtMTguNDggOS44My0xMi42IDAtMjIuMDEtOS43NC0yMi4wMS0yMi4xOCAwLTEzLjE5IDkuNDktMjIuMTggMjAuOTItMjIuMTggMTEuNTEgMCAxNy4xNCA5LjE2IDE4Ljk4IDE0LjExbDEuMDEgMi41Mi0yOS42NSAxMi4yOGMyLjI3IDQuNDUgNS44IDYuNzIgMTAuNzUgNi43MiA0Ljk2IDAgOC40LTIuNDQgMTAuOTItNi4xNHptLTIzLjI3LTcuOThsMTkuODItOC4yM2MtMS4wOS0yLjc3LTQuMzctNC43LTguMjMtNC43LTQuOTUgMC0xMS44NCA0LjM3LTExLjU5IDEyLjkzeiIgZmlsbD0iI0VBNDMzNSIvPjxwYXRoIGQ9Ik0zNS4yOSA0MS40MVYzMkg2N2MuMzEgMS42NC40NyAzLjU4LjQ3IDUuNjggMCA3LjA2LTEuOTMgMTUuNzktOC4xNSAyMi4wMS02LjA1IDYuMy0xMy43OCA5LjY2LTI0LjAyIDkuNjZDMTYuMzIgNjkuMzUuMzYgNTMuODkuMzYgMzQuOTEuMzYgMTUuOTMgMTYuMzIuNDcgMzUuMy40N2MxMC41IDAgMTcuOTggNC4xMiAyMy42IDkuNDlsLTYuNjQgNi42NGMtNC4wMy0zLjc4LTkuNDktNi43Mi0xNi45Ny02LjcyLTEzLjg2IDAtMjQuNyAxMS4xNy0yNC43IDI1LjAzIDAgMTMuODYgMTAuODQgMjUuMDMgMjQuNyAyNS4wMyA4Ljk5IDAgMTQuMTEtMy42MSAxNy4zOS02Ljg5IDIuNjYtMi42NiA0LjQxLTYuNDYgNS4xLTExLjY1bC0yMi40OS4wMXoiIGZpbGw9IiM0Mjg1RjQiLz48L3N2Zz4=">
										<div class="d-flex justify-content-between align-items-center border rounded-pill px-2 py-1 mx-2" style="width: 65%;">
											<span class="mr-auto"><?= htmlspecialchars(strtok($groupe['mot_cle'] ?? '', "\n"), ENT_QUOTES, 'UTF-8') ?></span>
											<img class="mx-1" height="20" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBpZD0iQ2FwYV8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxNTAgMTUwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMTUwIDE1MCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojMUE3M0U4O30KCS5zdDF7ZmlsbDojRUE0MzM1O30KCS5zdDJ7ZmlsbDojNDI4NUY0O30KCS5zdDN7ZmlsbDojRkJCQzA0O30KCS5zdDR7ZmlsbDojMzRBODUzO30KCS5zdDV7ZmlsbDojNENBRjUwO30KCS5zdDZ7ZmlsbDojMUU4OEU1O30KCS5zdDd7ZmlsbDojRTUzOTM1O30KCS5zdDh7ZmlsbDojQzYyODI4O30KCS5zdDl7ZmlsbDojRkJDMDJEO30KCS5zdDEwe2ZpbGw6IzE1NjVDMDt9Cgkuc3QxMXtmaWxsOiMyRTdEMzI7fQoJLnN0MTJ7ZmlsbDojRjZCNzA0O30KCS5zdDEze2ZpbGw6I0U1NDMzNTt9Cgkuc3QxNHtmaWxsOiM0MjgwRUY7fQoJLnN0MTV7ZmlsbDojMzRBMzUzO30KCS5zdDE2e2NsaXAtcGF0aDp1cmwoI1NWR0lEXzJfKTt9Cgkuc3QxN3tmaWxsOiMxODgwMzg7fQoJLnN0MTh7b3BhY2l0eTowLjI7ZmlsbDojRkZGRkZGO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MTl7b3BhY2l0eTowLjM7ZmlsbDojMEQ2NTJEO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjB7Y2xpcC1wYXRoOnVybCgjU1ZHSURfNF8pO30KCS5zdDIxe29wYWNpdHk6MC4zO2ZpbGw6dXJsKCNfNDVfc2hhZG93XzFfKTtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDIye2NsaXAtcGF0aDp1cmwoI1NWR0lEXzZfKTt9Cgkuc3QyM3tmaWxsOiNGQTdCMTc7fQoJLnN0MjR7b3BhY2l0eTowLjM7ZmlsbDojMTc0RUE2O2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjV7b3BhY2l0eTowLjM7ZmlsbDojQTUwRTBFO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjZ7b3BhY2l0eTowLjM7ZmlsbDojRTM3NDAwO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0Mjd7ZmlsbDp1cmwoI0ZpbmlzaF9tYXNrXzFfKTt9Cgkuc3QyOHtmaWxsOiNGRkZGRkY7fQoJLnN0Mjl7ZmlsbDojMEM5RDU4O30KCS5zdDMwe29wYWNpdHk6MC4yO2ZpbGw6IzAwNEQ0MDtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMxe29wYWNpdHk6MC4yO2ZpbGw6IzNFMjcyMztlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMye2ZpbGw6I0ZGQzEwNzt9Cgkuc3QzM3tvcGFjaXR5OjAuMjtmaWxsOiMxQTIzN0U7ZW5hYmxlLWJhY2tncm91bmQ6bmV3ICAgIDt9Cgkuc3QzNHtvcGFjaXR5OjAuMjt9Cgkuc3QzNXtmaWxsOiMxQTIzN0U7fQoJLnN0MzZ7ZmlsbDp1cmwoI1NWR0lEXzdfKTt9Cgkuc3QzN3tmaWxsOiNGQkJDMDU7fQoJLnN0Mzh7Y2xpcC1wYXRoOnVybCgjU1ZHSURfOV8pO2ZpbGw6I0U1MzkzNTt9Cgkuc3QzOXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xMV8pO2ZpbGw6I0ZCQzAyRDt9Cgkuc3Q0MHtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xM18pO2ZpbGw6I0U1MzkzNTt9Cgkuc3Q0MXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xNV8pO2ZpbGw6I0ZCQzAyRDt9Cjwvc3R5bGU+PGc+PGcgaWQ9ImcxNzQ4MCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQ2LjMwMzQsMjM2LjM3ODkpIj48cGF0aCBjbGFzcz0ic3Q2IiBkPSJNLTU3MS4zLTE0Ny4zYzcuOSwwLDE0LjItNi40LDE0LjItMTQuMmwwLTMzLjJjMC03LjktNi40LTE0LjItMTQuMi0xNC4yICAgIGMtNy45LDAtMTQuMiw2LjQtMTQuMiwxNC4ydjMzLjJDLTU4NS41LTE1My43LTU3OS4xLTE0Ny4zLTU3MS4zLTE0Ny4zIiBpZD0icGF0aDE3NDgyIi8+PC9nPjxnIGlkPSJnMTc0ODQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDY0NS40ODAzLDIzMy4xNDkyKSI+PHBhdGggY2xhc3M9InN0NSIgZD0iTS01NzUuMi0xMjUuNUwtNTc1LjItMTI1LjV2MTQuOWg5LjV2LTE0LjhjLTEuNSwwLjItMy4xLDAuMi00LjcsMC4yICAgIEMtNTcyLjEtMTI1LjEtNTczLjYtMTI1LjItNTc1LjItMTI1LjUiIGlkPSJwYXRoMTc0ODYiLz48L2c+PGcgaWQ9ImcxNzQ4OCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQzLjM4MDksMjM1LjkxMTUpIj48cGF0aCBjbGFzcz0ic3Q5IiBkPSJNLTU4NS4yLTE0NC4xYy00LjItNC4zLTYuOS05LjUtNi45LTE2LjZoLTkuNWMwLDkuNSwzLjcsMTcuMyw5LjcsMjMuM2wwLjEtMC4xICAgIGMwLDAsMCwwLTAuMS0wLjFMLTU4NS4yLTE0NC4xeiIgaWQ9InBhdGgxNzQ5MCIvPjwvZz48ZyBpZD0iZzE3NDkyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2NTAuNDA4MSwyMzguNzkpIj48cGF0aCBjbGFzcz0ic3Q3IiBkPSJNLTU1MS43LTE2My42YzAsMTEuOS0xMC41LDIzLjYtMjMuNywyMy42Yy02LjYsMC0xMi41LTIuNy0xNi44LTdsLTAuMSwwLjFsLTYuNiw2LjYgICAgYzAsMCwwLDAsMC4xLDAuMWM0LjksNC45LDExLjQsOC4yLDE4LjcsOS4zYzEuNiwwLjIsMy4yLDAuNCw0LjgsMC40YzEuNiwwLDMuMiwwLDQuNy0wLjJjMTYuMS0yLjMsMjguNC0xNi4xLDI4LjQtMzIuN0gtNTUxLjd6IiBpZD0icGF0aDE3NDk0Ii8+PC9nPjwvZz48L3N2Zz4=" alt="google-microphone">
											<i class="fa fa-search mx-1"></i>
										</div>

									</div>

									<hr>
									<div class="container pl-5">

										<p class="small font-weight-bold mb-2">Sponsorisé</p>
										<div class="row mb-4">
											<?php if (!empty($groupe['images'][0])): ?>
												<div class="col-md-8">
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
												</div>
												<div class="col-md-4">
													<div class="thumb-box" style="height: 140px;">
														<img src="<?= $groupe['images'][0] ?>"
															alt="placeholder" class="img-fluid h-100 w-100" style="object-fit: cover;">
													</div>
												</div>
											<?php else: ?>
												<div class="col-12">
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
												</div>
											<?php endif; ?>
										</div>



										<span class="border rounded-pill text-primary py-1 px-2 small"><?= htmlspecialchars(strtok($groupe['mot_cle'] ?? '', "\n"), ENT_QUOTES, 'UTF-8') ?></span>
										<span class="border rounded-pill text-primary py-1 px-2 small">Promotions</span>
										<hr>
										<i class="fa fa-phone"></i>
										Appeler le <?= $groupe['numero_client'] ?>
									</div>
								</div>
							</div>
						</div>

					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<!-- Inventaire Local -->
		<div class="section">
			<div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
				<img src="<?php echo $logo_base64; ?>" alt="Logo" style="max-width:150px;height:auto" />
				<h2 class="m-0" style="color:#000">Inventaire Search</h2>
			</div>

			<?php foreach ($groupe_valider as $groupe): ?>
				<?php if ($groupe['type_campagne'] == 2): ?>

					<ul class="nav nav-tabs mb-4 d-flex justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="pmax_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn1.iconfinder.com/data/icons/unicons-line-vol-3/24/graph-bar-256.png" alt="Tout">
								</div>
								<p class="mockup-label mt-0">Tout</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="local_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/150/google-maps-1024.png" alt="Maps">
								</div>
								<p class="mockup-label mt-0">Maps</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="local_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://ailecs.org/wp-content/uploads/2024/07/web_100dp_33B54D_FILL0_wght400_GRAD0_opsz48.png" alt="Display">
								</div>
								<p class="mockup-label mt-0">Display</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="local_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/48/google-gmail-1024.png" alt="Gmail">
								</div>
								<p class="mockup-label mt-0">Gmail</p>
							</a>
						</li>
					</ul>

					<div class="row text-center mockup justify-content-around">

						<!-- Search -->
						<div class="col-auto">
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
						<div class="col-auto">
							<div class=" device-frame phone-frame">
								<div class="screen">
									<div class="thumb-box mb-3" style="height: 140px;">
										<img src="data:image/jpeg;base64,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" alt="placeholder">
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

						<!-- Gmail -->
						<div class="col-auto">
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
										<img src="<?= $groupe['images'][0] ?>" alt="placeholder">
									</div>

									<p class="font-weight-bold mb-2"><?= $groupe['titre1'] ?></p>
									<p class="small text-muted"><?= $groupe['descriptions1'] ?></p>

									<span class="badge badge-primary py-2 w-100 rounded-pill">Réservation</span>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<div class="action-btns mb-5">
			<a href="<?= base_url('Client/valider_campagne/' . ($campagnes[0]['idclients'] ?? '')); ?>" class="btn-action btn-action-secondary" target="_blank">
				<i class="fa fa-file-pdf"></i> Valider la campagne
			</a>
			<a href="<?= base_url('Validation/exporter/' . ($campagnes[0]['idclients'] ?? '')); ?>" class="btn-action btn-action-secondary" target="_blank">
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
					<div class="modal-header">
						<h5 class="modal-title">Gérer les images</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
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
		const TITLE_MAX = 30,
			DESC_MAX = 90,
			TITLES_MAX_COUNT = 12,
			DESCS_MAX_COUNT = 4;

		// ===========================
		// Dataset JS depuis le serveur
		// ===========================
		const campagnesJS = <?= json_encode($campagnes ?? []); ?>;
		const groupesData = [
			<?php if (!empty($campagnes) && is_array($campagnes)): ?>
				<?php foreach ($campagnes as $C): $groupes = $C['groupes_annonces'] ?? []; ?>
					<?php foreach ($groupes as $G): ?> {
							idgroupe_annonce: "<?= htmlspecialchars($G['idgroupe_annonce'] ?? '', ENT_QUOTES) ?>",
							idcampagne: "<?= htmlspecialchars($C['idcampagne'] ?? '', ENT_QUOTES) ?>",
							idclients: "<?= htmlspecialchars($C['idclients'] ?? '', ENT_QUOTES) ?>",
							nom_groupe: <?= json_encode($G['nom_groupe'] ?? '') ?>,
							mot_cle: <?= json_encode($G['mot_cle'] ?? '') ?>,
							titres: [<?php for ($i = 1; $i <= 12; $i++) {
											if (!empty($G['titre' . $i])) {
												echo json_encode($G['titre' . $i]) . ',';
											}
										} ?>],
							descriptions: [<?php for ($i = 1; $i <= 4; $i++) {
												if (!empty($G['descriptions' . $i])) {
													echo json_encode($G['descriptions' . $i]) . ',';
												}
											} ?>],
							url_groupe_annonce: <?= json_encode($G['url_groupe_annonce'] ?? '') ?>,
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
		function makeLineInput(value = '', max = 30, name = 'title') {
			const id = 'fld_' + name + '_' + Math.random().toString(36).slice(2);
			const wrapper = document.createElement('div');
			wrapper.className = 'form-row align-items-center mb-2';

			const inputCol = document.createElement('div');
			inputCol.className = 'col';
			const input = document.createElement('input');
			input.type = 'text';
			input.className = 'form-control';
			input.value = value || '';
			input.maxLength = max;
			input.id = id;
			input.dataset.max = String(max);
			inputCol.appendChild(input);

			const ctrCol = document.createElement('div');
			ctrCol.className = 'col-auto';
			const span = document.createElement('span');
			span.className = 'counter';
			span.textContent = `${(value||'').length}/${max}`;
			ctrCol.appendChild(span);

			const delCol = document.createElement('div');
			delCol.className = 'col-auto';
			const delBtn = document.createElement('button');
			delBtn.type = 'button';
			delBtn.className = 'btn-icon';
			delBtn.title = 'Supprimer';
			delBtn.innerHTML = '<i class="fa fa-trash"></i>';
			delBtn.addEventListener('click', () => wrapper.remove());
			delCol.appendChild(delBtn);

			input.addEventListener('input', () => {
				const len = input.value.length,
					m = parseInt(input.dataset.max, 10);
				span.textContent = `${len}/${m}`;
				span.classList.toggle('invalid', len > m);
			});

			wrapper.appendChild(inputCol);
			wrapper.appendChild(ctrCol);
			wrapper.appendChild(delCol);
			return wrapper;
		}

		function collectLines(containerId, maxCount) {
			const inputs = document.querySelectorAll(`#${containerId} input.form-control`);
			const values = [];
			inputs.forEach((el, idx) => {
				if (idx < maxCount) {
					const v = (el.value || '').trim();
					if (v) values.push(v);
				}
			});
			return values;
		}

		// ===========================
		// Actions : Edit Campagne
		// ===========================
		function openEditCampaign(id) {
			const campagne = (campagnesJS || []).find(c => String(c.idcampagne) === String(id));
			if (!campagne) return;
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
		const titlesList = () => document.getElementById('titlesList');
		const descsList = () => document.getElementById('descsList');

		function fillList(container, arr, maxLen, name, maxCount) {
			container.innerHTML = '';
			(arr || []).slice(0, maxCount).forEach(v => {
				container.appendChild(makeLineInput(v, maxLen, name));
			});
			if (!arr || arr.length === 0) {
				container.appendChild(makeLineInput('', maxLen, name));
			}
		}

		function openEditGroupe(id) {
			const g = (groupesData || []).find(x => String(x.idgroupe_annonce) === String(id));
			if (!g) return;

			// ids
			document.getElementById('edit_idgroupe_annonce').value = g.idgroupe_annonce || '';
			document.getElementById('edit_idcampagne').value = g.idcampagne || '';
			document.getElementById('edit_idclients').value = g.idclients || '';

			// simples
			document.getElementById('edit_nom_groupe').value = g.nom_groupe || '';
			document.getElementById('edit_mot_cle').value = g.mot_cle || '';
			document.getElementById('edit_url_groupe_annonce').value = g.url_groupe_annonce || '';

			// listes avec compteurs
			fillList(titlesList(), g.titres || [], TITLE_MAX, 'title', TITLES_MAX_COUNT);
			fillList(descsList(), g.descriptions || [], DESC_MAX, 'desc', DESCS_MAX_COUNT);

			// conditionnels
			document.getElementById('edit_type_campagnes').value = g.type_campagnes ?? '';
			document.getElementById('edit_chemin1').value = g.chemin1 || '';
			document.getElementById('edit_chemin2').value = g.chemin2 || '';
			document.getElementById('edit_description_breve').value = g.description_breve || '';

			const typeCamp = Number(g.type_campagnes);
			const wrapChemin1 = document.getElementById('wrap_chemin1');
			const wrapChemin2 = document.getElementById('wrap_chemin2');
			const wrapDescBr = document.getElementById('wrap_description_breve');
			if (typeCamp === 1) {
				wrapChemin1.classList.remove('d-none');
				wrapChemin2.classList.remove('d-none');
				wrapDescBr.classList.add('d-none');
			} else if (typeCamp === 2 || typeCamp === 3) {
				wrapChemin1.classList.add('d-none');
				wrapChemin2.classList.add('d-none');
				wrapDescBr.classList.remove('d-none');
			} else {
				wrapChemin1.classList.add('d-none');
				wrapChemin2.classList.add('d-none');
				wrapDescBr.classList.add('d-none');
			}

			$('#modalEditGroupe').modal('show');
		}

		// Ajout d’un titre / d’une description
		document.getElementById('btnAddTitle')?.addEventListener('click', () => {
			const c = titlesList();
			if (c.querySelectorAll('input.form-control').length >= TITLES_MAX_COUNT) return;
			c.appendChild(makeLineInput('', TITLE_MAX, 'title'));
		});
		document.getElementById('btnAddDesc')?.addEventListener('click', () => {
			const c = descsList();
			if (c.querySelectorAll('input.form-control').length >= DESCS_MAX_COUNT) return;
			c.appendChild(makeLineInput('', DESC_MAX, 'desc'));
		});

		// Avant submit du groupe : sérialiser vers hidden
		document.getElementById('formEditGroupe')?.addEventListener('submit', function(e) {
			const titles = collectLines('titlesList', TITLES_MAX_COUNT).map(v => v.slice(0, TITLE_MAX));
			const descs = collectLines('descsList', DESCS_MAX_COUNT).map(v => v.slice(0, DESC_MAX));
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
		let currentIds = {
			idcampagne: null,
			idclients: null
		};
		let imagesTemp = [];

		function openImageManagerForCampagne(idCampagne, idClient) {
			currentIds = {
				idcampagne: idCampagne,
				idclients: idClient
			};
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

		function confirmRemoveImage(index) {
			if (!Number.isInteger(index)) return;
			if (confirm('Supprimer cette image ?')) removeImage(index);
		}

		function removeImage(index) {
			imagesTemp.splice(index, 1);
			imagesTemp = imagesTemp.map((img, i) => ({
				image_url: img.image_url,
				rank: i
			}));
			refreshImagePreview();
		}
		document.getElementById('btnClearImages')?.addEventListener('click', function() {
			if (!imagesTemp.length) return;
			if (confirm('Tout effacer pour cette campagne ?')) {
				imagesTemp = [];
				refreshImagePreview();
			}
		});
		document.getElementById('addImageUrlBtn')?.addEventListener('click', function() {
			const input = document.getElementById('imageUrlInput');
			const url = (input.value || '').trim();
			if (!url) return;
			imagesTemp.push({
				image_url: url,
				rank: imagesTemp.length
			});
			input.value = '';
			refreshImagePreview();
		});
		document.getElementById('saveImagesBtn')?.addEventListener('click', function() {
			if (!currentIds.idcampagne) return alert("Aucune campagne sélectionnée.");
			const $btn = $(this).prop('disabled', true).text('Enregistrement...');
			$.ajax({
				url: "<?= site_url('Validation/updateImages'); ?>",
				method: "POST",
				data: {
					idcampagne: currentIds.idcampagne,
					idclients: currentIds.idclients,
					images: JSON.stringify(imagesTemp)
				},
				success: function(res) {
					try {
						const data = JSON.parse(res);
						if (data.status === 'success') {
							window.location.reload();
							return;
						}
						alert("Erreur : " + (data.message || 'Inconnue'));
					} catch {
						alert("Erreur inattendue côté serveur.");
					}
				},
				error: function() {
					alert("Erreur réseau ou serveur lors de la mise à jour des images.");
				},
				complete: function() {
					$btn.prop('disabled', false).text('Enregistrer');
				}
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
		function openEditKeywords(idgroupe, currentText, idCampagne, idClients) {
			document.getElementById('kw_idgroupe').value = idgroupe || '';
			document.getElementById('kw_idcampagne').value = idCampagne || '';
			document.getElementById('kw_idclients').value = idClients || '';
			document.getElementById('kw_textarea').value = (currentText || '').trim();
			$('#modalEditKeywords').modal('show');
			setTimeout(() => document.getElementById('kw_textarea').focus(), 150);
		}

		// --- save AJAX
		document.getElementById('kw_save_btn')?.addEventListener('click', saveKeywordsFromModal);

		// Ctrl+Enter pour enregistrer
		document.getElementById('kw_textarea')?.addEventListener('keydown', function(e) {
			if (e.ctrlKey && e.key === 'Enter') {
				e.preventDefault();
				saveKeywordsFromModal();
			}
		});

		function saveKeywordsFromModal() {
			const btn = document.getElementById('kw_save_btn');
			const idg = document.getElementById('kw_idgroupe').value;
			const txt = document.getElementById('kw_textarea').value.trim();

			if (!idg) {
				alert('ID groupe manquant');
				return;
			}

			$(btn).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enregistrement...');

			$.ajax({
				url: "<?= site_url('Validation/updateMotCleGroupe'); ?>",
				method: "POST",
				data: {
					idgroupe_annonce: idg,
					mot_cle: txt
				},
				success: function(res) {
					try {
						const data = typeof res === 'object' ? res : JSON.parse(res);
						if (data.status === 'success') {
							// Fermer le modal puis recharger la page
							$('#modalEditKeywords').modal('hide');
							// rechargement immédiat (force refresh pour éviter le cache)
							window.location.reload(true);
							return;
						}
						alert('Erreur : ' + (data.message || 'Inconnue'));
					} catch (err) {
						alert('Réponse serveur invalide.');
					}
				},
				error: function() {
					alert('Erreur réseau ou serveur.');
				},
				complete: function() {
					$(btn).prop('disabled', false).html('<i class="fa fa-save"></i> Enregistrer');
				}
			});
		}
	</script>
</body>

</html>
