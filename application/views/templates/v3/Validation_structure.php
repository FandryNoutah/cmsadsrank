<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Validation client — Campagne Google Ads</title>

	<!-- Styles & librairies -->
	<link href="<?php echo base_url('assets/css/font-awesome.all.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/vendors/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet" />

	<style>
		:root {
			--primary: #4EA5FE;
			--primary-dark: #358de6;
			--bg-light: #f9fbfc;
			--bg-card: #fff;
			--text-dark: #333;
			--muted: #6c757d;
			--border: #e0e0e0;
		}

		* {
			box-sizing: border-box
		}

		body {
			font-family: "Segoe UI", Arial, sans-serif;
			background: var(--bg-light);
			color: var(--text-dark);
			margin: 0
		}

		.container {
			width: 95%;
			max-width: 1200px;
			margin: 0 auto;
			padding: 25px 0 60px
		}

		h1,
		h2 {
			color: var(--primary);
			font-weight: 600;
			text-align: center
		}

		.section {
			background: var(--bg-card);
			border-radius: 14px;
			box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
			margin: 40px 0;
			padding: 25px
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

<body>
	<div class="container">

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
							<div class=" device-frame phone-frame">
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

		<div class="action-btns">
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
