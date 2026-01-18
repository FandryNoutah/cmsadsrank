<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Import Excel - Clients</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body class="p-4">
<div class="container">
    <h1>Import Excel - Clients</h1>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('Client/import_excel_process') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="excel_file">Fichier Excel (.xlsx, .xls, .csv)</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>
        </div>

        <div class="form-group mt-3">
            <small class="text-muted">
                Mapping automatique détecté : <br>
                - Société -> nom_client <br>
                - Site Internet -> site_client <br>
                - Activité -> secteur_activite <br>
                - Tel.n°1 -> numero_client <br>
                - Date Création -> date de mise en place (si fournie)
            </small>
        </div>

        <button class="btn btn-primary mt-2" type="submit">Importer</button>
        <a class="btn btn-secondary mt-2" href="<?= site_url('Client') ?>">Retour</a>
    </form>
</div>
</body>
</html>
