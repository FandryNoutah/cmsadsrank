<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupérer les images</title>
    <style>
        .image-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
            padding: 10px;
        }

        .image-grid img {
            width: 100%;
            height: auto;
            max-width: 200px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>Récupérer les images d'un site Web</h1>
    
    <form method="POST" action="<?= site_url('Test/index'); ?>">
        <label for="domain_name">Nom de domaine (ex : example.com) :</label>
        <input type="text" name="domain_name" id="domain_name" required>
        <button type="submit">Récupérer les images</button>
    </form>

    <?php if (!empty($images)): ?>
        <h2>Images trouvées :</h2>
        <div class="image-grid">
            <?php foreach ($images as $image): ?>
                <div><img src="<?= $image; ?>" alt="Image"></div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucune image trouvée.</p>
    <?php endif; ?>

</body>
</html>
