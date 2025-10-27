<?php start_section('stylesheet') ?>
<style>
.preview-card table {
    width: 100%;
    max-width: 1000px;
    margin: 0;           /* alignement à gauche */
    table-layout: fixed;
    word-wrap: break-word;
}

.preview-card table th {
    width: 200px;         /* largeur uniforme pour toutes les th */
    vertical-align: top;
    text-align: left;     /* assure l'alignement gauche */
}
.preview-card table td {
    vertical-align: top;
    word-break: break-word;
    white-space: pre-line; /* pour sauts de lignes dans titres et descriptions */
}

.preview-card table td img {
    width: 120px; /* images plus grandes */
    height: auto;
}
.images-row {
    display: flex;
    gap: 10px; /* espace entre les images */
    align-items: center;
}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4">Aperçu annonce Client</h1>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid">
<?php if (!empty($campagnes)): ?>
    <?php foreach ($campagnes as $campagne): ?>
        <h3><?= htmlspecialchars($campagne['nom_campagne']) ?></h3>

        <?php if (!empty($campagne['groupes_annonces'])): ?>
            <?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
                <div class="preview-card mt-4">
                    <h5 class="mb-3">Aperçu du groupe d'annonce</h5>
                    <table class="table table-bordered">
                        <tr >
                            <th >Campagne</th>
                            <td ><?= htmlspecialchars($campagne['nom_campagne']) ?></td>
                        </tr>
                        <tr>
                            <th>Groupe d'annonce</th>
                            <td><?= htmlspecialchars($groupe['nom_groupe'] ?: 'Aucun nom') ?></td>
                        </tr>
                        <tr>
                            <th>Mot clé</th>
                            <td><?= htmlspecialchars($groupe['mot_cle'] ?: 'Aucun Mot clé') ?></td>
                        </tr>

                        <tr>
                            <th>Titres</th>
                            <td>
                                <?php
                                $titres = [];
                                for ($i=1; $i<=12; $i++) {
                                    $key = 'titre'.$i;
                                    if (!empty($groupe[$key])) $titres[] = htmlspecialchars($groupe[$key]);
                                }
                                echo !empty($titres) ? implode("\n", $titres) : 'Aucun titre';
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Titres longs</th>
                            <td>
                                <?php
                                $longtitres = [];
                                for ($i=1; $i<=5; $i++) {
                                    $key = 'longtitre'.$i;
                                    if (!empty($groupe[$key])) $longtitres[] = htmlspecialchars($groupe[$key]);
                                }
                                echo !empty($longtitres) ? implode("\n", $longtitres) : 'Aucun titre long';
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Descriptions</th>
                            <td>
                                <?php
                                $descriptions = [];
                                for ($i=1; $i<=4; $i++) {
                                    $key = 'descriptions'.$i;
                                    if (!empty($groupe[$key])) $descriptions[] = htmlspecialchars($groupe[$key]);
                                }
                                echo !empty($descriptions) ? implode("\n", $descriptions) : 'Aucune description';
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>URL</th>
                            <td><?= !empty($groupe['url_groupe_annonce']) ? htmlspecialchars($groupe['url_groupe_annonce']) : 'Aucune URL' ?></td>
                        </tr>

                        <?php if ($campagne['type_campagne'] != 3): ?>
                            <tr>
                                <th>Chemin 1</th>
                                <td><?= !empty($groupe['chemin1']) ? htmlspecialchars($groupe['chemin1']) : 'Aucun chemin 1' ?></td>
                            </tr>
                            <tr>
                                <th>Chemin 2</th>
                                <td><?= !empty($groupe['chemin2']) ? htmlspecialchars($groupe['chemin2']) : 'Aucun chemin 2' ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <th>Description brève</th>
                            <td><?= !empty($groupe['description_breve']) ? htmlspecialchars($groupe['description_breve']) : 'Aucune description brève' ?></td>
                        </tr>

                        <tr>
                            <th>Images</th>
                            <td>
                                <?php if (!empty($campagne['images'])): ?>
                                    <div class="images-row">
                                        <?php foreach ($campagne['images'] as $img): ?>
                                            <img src="<?= htmlspecialchars($img->image_url) ?>" alt="">
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    Aucune
                                <?php endif; ?>
                            </td>
                        </tr>

                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Aucun groupe d'annonce disponible pour cette campagne.</p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-muted">Aucune campagne disponible.</p>
<?php endif; ?>
</div>
<?php end_section(); ?>

<?php start_section('script'); ?>
<?php end_section(); ?>
