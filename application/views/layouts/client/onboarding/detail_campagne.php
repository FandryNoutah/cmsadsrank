<div class="text-right mb-3">
    <a href="<?= site_url('client/export_pdf/' . $id) ?>" target="_blank">
        <img class="mr-2" src="<?= base_url('assets/images/icons/figma/ArrowLineDown.png') ?>" />
    </a>
</div>

<h1 class="display-1 text-center mt-4" style="font-size: 42px;">Campagne</h1>

<div class="table-responsive">
    <table class="table table-hover table-wrapper">
        <thead class="bg-light text-muted">
            <tr>
                <th class="text-muted">TYPE</th>
                <th class="text-muted">CAMPAGNE</th>
                <th class="text-muted">BUDGET</th>
                <th class="text-muted">GROUPES D'ANNONCES</th>
                <th class="text-muted">MOT CLE</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($donne_valider)): ?>
                <?php foreach ($donne_valider as $campagne): ?>
                    <tr>
                        <td>
                            <?php 
                                switch ($campagne['type_campagne']) {
                                    case 1: echo "Search"; break;
                                    case 2: echo "Local"; break;
                                    case 3: echo "PMax"; break;
                                    default: echo "Inconnu"; break;
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($campagne['nom_campagne']) ?></td>
                        <td><?= isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0 ?> €</td>
                        <td>
                            <?php if (!empty($campagne['groupes_annonces'])): ?>
                                <?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
                                    <div style="margin-bottom: 10px;">
                                        <a href="<?= base_url('Client/insertgroupeannonce/' . $groupe['idgroupe_annonce']) ?>">
                                            <strong><?= htmlspecialchars($groupe['nom_groupe']) ?></strong>
                                        </a><br>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <em>Aucun groupe</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($campagne['groupes_annonces'])): ?>
                                <?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
                                    <div style="margin-bottom: 10px;">
                                        <?php 
                                            $mots = explode("\n", $groupe['mot_cle']);
                                            foreach ($mots as $mot) {
                                                if (trim($mot) !== '') {
                                                    echo '<span class="badge badge-secondary">"' . htmlspecialchars(trim($mot)) . '"</span> ';
                                                }
                                            }
                                        ?>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <em>Aucun groupe</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center text-muted">Aucune campagne trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<h1 class="display-1 text-center mt-4" style="font-size: 42px;">Groupe d'annonce</h1>

<div>
    <h5 class="mb-3">Aperçu de l'annonce</h5>
    <?php foreach ($groupe_annonce as $groupe): ?>
        <table class="table table-bordered">
            <tr>
                <th>Campagne</th>
                <td><?= $groupe['nom_campagne'] ?></td>
            </tr>
            <tr>
                <th>Groupe d'annonce</th>
                <td><?= $groupe['nom_groupe'] ?></td>
            </tr>
            <tr>
                <th>Titres</th>
               <td id="preview-titres">
					<?php
						for ($i = 1; $i <= 12; $i++) {
							$titre = $groupe["titre$i"] ?? '';
							if (!empty(trim($titre))) {
								echo htmlspecialchars($titre) . "<br>";
							}
						}
					?>
				</td>

            </tr>
            <tr>
                <th>Titres longs</th>
                <td id="preview-titres-longs">
					<?php
						for ($i = 1; $i <= 5; $i++) {
							$longtitre = $groupe["longtitre$i"] ?? '';
							if (!empty(trim($longtitre))) {
								echo htmlspecialchars($longtitre) . "<br>";
							}
						}
					?>
				</td>

            </tr>
            <tr>
                <th>Descriptions</th>
                <td id="preview-descriptions">
					<?php
						for ($i = 1; $i <= 4; $i++) {
							$desc = $groupe["descriptions$i"] ?? '';
							if (!empty(trim($desc))) {
								echo htmlspecialchars($desc) . "<br>";
							}
						}
					?>
				</td>

            </tr>
            <tr>
                <th>URL</th>
                <td id="preview-url"><?= $groupe['url_groupe_annonce'] ?></td>
            </tr>
            <tr>
                <th>Chemin 1</th>
                <td id="preview-chemin1"><?= $groupe['chemin1'] ?></td>
            </tr>
            <tr>
                <th>Chemin 2</th>
                <td id="preview-chemin2"><?= $groupe['chemin2'] ?></td>
            </tr>
        </table>
    <?php endforeach; ?>
</div>

<h1 class="display-1 text-center mt-4" style="font-size: 42px;">Assets</h1>

<?php foreach ($images as $image): ?>
    <div style="width: 100px; height: 70px; float: left; margin-right: 10px; margin-bottom: 15px; text-align: center;">
        <?php if (!empty($image->image_url)): ?>
            <img src="<?= $image->image_url ?>" alt="Image" style="width: 100%; height: 100%; object-fit: cover;">
        <?php endif; ?>
    </div>
<?php endforeach; ?>
