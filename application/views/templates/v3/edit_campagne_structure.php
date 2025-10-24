<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Interface de gestion hors media.">
    <meta name="author" content="Dev Miora">

    <title>CMS Adsrank<?php if(isset($page_title) && $page_title) echo " | " . $page_title; ?></title>

    <!-- Favicons -->
    <?php $favicon = base_url(IMAGES_PATH."/ico/logo4.png"); ?>
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $favicon ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $favicon ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $favicon ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $favicon ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $favicon ?>">
    <link rel="shortcut icon" type="image/png" href="<?= $favicon ?>">

    <!-- CSS Vendors -->
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/bootstrap.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/glyphicons.css") ?>">
    <link rel="stylesheet" href="<?= base_url(FONTS_PATH."/icomoon.css") ?>">
    <link rel="stylesheet" href="<?= base_url(FONTS_PATH."/flag-icon-css/css/flag-icon.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url(VENDORS_PATH."/css/extensions/pace.css") ?>">
    <link rel="stylesheet" href="<?= base_url(PLUGINS_PATH."/multiselect/css/prettify.css") ?>">
    <link rel="stylesheet" href="<?= base_url(PLUGINS_PATH."/multiselect/css/bootstrap-multiselect.css") ?>">

    <!-- CSS App -->
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/bootstrap-extended.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/app.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/colors.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/core/menu/menu-types/vertical-menu.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/core/menu/menu-types/vertical-overlay-menu.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/core/colors/palette-gradient.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/font-awesome.all.min.css") ?>">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/datatables/dataTables.bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/datatables/responsive.bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/datatables/buttons.dataTables.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/datatables/select.dataTables.min.css") ?>">

    <!-- OpenLayers -->
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/openlayers/ol_v5.2.0.css") ?>">
    <link rel="stylesheet" href="<?= base_url(CSS_PATH."/openlayers/ol-popup.css") ?>">

    <!-- JS Vendors -->
    <script src="<?= base_url(SCRIPTS_PATH."/core/libraries/jquery.min.js") ?>"></script>
    <script src="<?= base_url(SCRIPTS_PATH."/openlayers/ol_v5.2.0.js") ?>"></script>
    <script src="<?= base_url(CSS_PATH."/table2excel.js") ?>"></script>
    <script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <style>
        body {
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .card-body {
            background-color: white;
            margin: 20px;
            width: 100%;
            max-width: 1200px;
        }
    </style>
</head>

<body>
<div class="card-body">
    <div class="card-block p-4">
        <h4 class="mb-4" style="font-weight: 600;">Modification campagne</h4>

        <form action="<?= site_url('Validation/updateDonneeClient'); ?>" method="POST" enctype="multipart/form-data" class="bg-light rounded shadow-sm p-4">
            <?php foreach($campagne as $C): ?>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="zone" class="form-label text-dark">Zone</label>
                    <input class="form-control" type="text" name="zones" id="zone" value="<?= htmlspecialchars($C['zones']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="date_campagne" class="form-label text-dark">Calendrier</label>
                    <input class="form-control" type="text" name="date_campagne" id="date_campagne" value="<?= htmlspecialchars($C['date_campagne']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="appareil" class="form-label text-dark">Appareils</label>
                    <input class="form-control" type="text" name="appareil" id="appareil" value="<?= htmlspecialchars($C['appareil']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="budget" class="form-label text-dark">Budget</label>
                    <input class="form-control" type="text" name="budget" id="budget" value="<?= htmlspecialchars($C['repartition_budget']); ?>">
                </div>
                <div class="col-md-6">
                    <label for="nom_campagne" class="form-label text-dark">Campagne</label>
                    <input class="form-control" type="text" name="nom_campagne" id="nom_campagne" value="<?= htmlspecialchars($C['nom_campagne']); ?>">
                </div>
            </div>

            <h4 class="mb-4" style="font-weight: 600;">Modification groupe d'annonce</h4>

            <?php foreach($groupe as $G): ?>
                <input type="hidden" name="idcampagne" value="<?= htmlspecialchars($C['idcampagne']); ?>">
                <input type="hidden" name="idgroupe_annonce" value="<?= htmlspecialchars($G['idgroupe_annonce']); ?>">
                <input type="hidden" name="idclients" value="<?= htmlspecialchars($C['idclients']); ?>">

                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="nom_groupe" class="form-label text-dark">Groupe d'annonce</label>
                        <input class="form-control" type="text" name="nom_groupe" id="nom_groupe" value="<?= htmlspecialchars($G['nom_groupe']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="mot_cle" class="form-label text-dark">Mot clé</label>
                        <textarea class="form-control form-control-lg" name="mot_cle" id="mot_cle" rows="16" placeholder="Saisir les mots clés"><?= htmlspecialchars($G['mot_cle']); ?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success" name="update" style="font-size: 16px; font-weight: 500; width: 180px; height: 41px; margin-left: 10px; background-color: #4EA5FE; color: white; border-radius: 20px;">
                    Enregistrer
                </button>
            </div>
            <?php endforeach; ?>
        </form>
    </div>
</div>
</body>
</html>
