<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modification Groupe - CMS Adsrank</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f4f5f7;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 40px 0;
    }
    .card-custom {
        max-width: 1000px;
        margin: auto;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        background-color: #fff;
        padding: 30px;
    }
    h4 {
        font-weight: 600;
        margin-bottom: 25px;
    }
    label {
        font-weight: 500;
    }
    .form-control {
        border-radius: 8px;
        padding: 10px 12px;
    }
    .btn-save {
        background-color: #4EA5FE;
        color: #fff;
        border-radius: 20px;
        font-weight: 500;
        width: 180px;
        height: 45px;
        transition: 0.3s;
    }
    .btn-save:hover {
        background-color: #3b8de0;
    }
    .form-section {
        border-top: 1px solid #e3e6ef;
        padding-top: 20px;
        margin-top: 20px;
    }
</style>
</head>
<body>

<div class="card-custom">
    <h4>Modification groupe</h4>
    <form action="<?php echo site_url('Validation/save_groupe_local'); ?>" method="POST" enctype="multipart/form-data">
        <?php foreach($groupe as $G){ ?>
        <input type="hidden" name="idgroupe_annonce" value="<?php echo $G['idgroupe_annonce']; ?>"/>
        <input type="hidden" name="idclients" value="<?php echo $G['idclients']; ?>"/>
        <input type="hidden" name="idcampagne" value="<?php echo $G['idcampagne']; ?>"/>
        <input type="hidden" name="type_campagne" value="<?php echo $G['type_campagnes']; ?>"/>

        <div class="mb-3">
            <label for="nom_groupe" class="form-label">Nom groupe d'annonce</label>
            <input class="form-control" type="text" name="nom_groupe" id="nom_groupe" value="<?php echo $G['nom_groupe']; ?>" />
        </div>

        <div class="form-section">
            <h6>Titres de l'annonce</h6>
            <div class="row g-3">
                <?php for($i=1; $i<=12; $i++) { ?>
                <div class="col-md-6">
                    <label for="titre<?php echo $i; ?>" class="form-label">Titre <?php echo $i; ?></label>
                    <input class="form-control" type="text" name="titre<?php echo $i; ?>" id="titre<?php echo $i; ?>" value="<?php echo $G['titre'.$i]; ?>" />
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="form-section">
            <h6>Descriptions de l'annonce</h6>
            <div class="row g-3">
                <?php for($i=1; $i<=4; $i++) { ?>
                <div class="col-md-6">
                    <label for="description<?php echo $i; ?>" class="form-label">Description <?php echo $i; ?></label>
                    <input class="form-control" type="text" name="description<?php echo $i; ?>" id="description<?php echo $i; ?>" value="<?php echo $G['descriptions'.$i]; ?>" />
                </div>
                <?php } ?>
                <div class="col-md-12">
                    <label for="description_breve" class="form-label">Description brève</label>
                    <input class="form-control" type="text" name="description_breve" id="description_breve" value="<?php echo $G['description_breve']; ?>" />
                </div>
            </div>
        </div>

        <div class="form-section">
            <label for="url" class="form-label">URL</label>
            <input class="form-control" type="text" name="url" id="url" value="<?php echo $G['url_groupe_annonce']; ?>" />
        </div>

        <?php } ?>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-save">Enregistrer</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
