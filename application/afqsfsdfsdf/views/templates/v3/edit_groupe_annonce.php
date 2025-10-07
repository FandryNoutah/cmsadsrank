<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Google Ads - Ajout Groupe d'annonces</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Internal CSS -->
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Navbar */
        .navbar {
            background-color: #37BC9B;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            color: white;
            font-weight: 500;
            font-size: 1.5rem;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        /* Main Content Container */
        .main-container {
            margin-top: 80px; /* to avoid overlap with navbar */
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Card Title */
        .card-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Card Header */
        .card-header {
            background-color: #37BC9B;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Form Inputs */
        input[type="text"], textarea {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f9f9f9;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #37BC9B;
            outline: none;
            background-color: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Labels */
        label {
            font-size: 1rem;
            font-weight: 500;
            color: #666;
        }

        /* Buttons */
        button {
            padding: 12px 24px;
            background-color: #37BC9B;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2a9d7b;
        }

        button:focus {
            outline: none;
        }

        /* Link Styling */
        a {
            color: #37BC9B;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .card-title {
                font-size: 1.2rem;
            }

            input[type="text"], textarea {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>


    <!-- Main Content -->
    <div class="main-container">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Google Ads - Modifier Groupe d'annonces</h4>
                </div>

                <div class="card-body">
                    <?php foreach ($search as $D): ?>
                        <h3><br>Campagne client : <a href="#" style="color: #37BC9B"><?php echo $D['nom_client']; ?></a></h3>
                    <?php endforeach; ?>

                    <form action="<?php echo site_url('Googleads/save_groupe'); ?>" method="POST" enctype="multipart/form-data">
                    <div id="annonce-groups">
                        <div class="annonce-group">
                            <!-- Hidden Fields -->
                            <input type="hidden" name="idgroupe_annonce" class="form-control" value="<?php echo $D['idgroupe_annonce']; ?>"> 
                            <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>"> 
                            <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagne']; ?>">

                            <!-- Group Name -->
                            <label for="group-name">Nom du groupe :</label>
                            <input type="text" name="nom_groupe" class="form-control" value="<?php echo $D['nom_groupe']; ?>">

                            <!-- Titles (1 to 12) -->
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <label for="titre<?php echo $i; ?>">Titre <?php echo $i; ?>:</label>
                                <input type="text" name="titre<?php echo $i; ?>" class="form-control" value="<?php echo $D["titre{$i}"]; ?>">
                            <?php endfor; ?>

                            <!-- Descriptions (1 to 4) -->
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <label for="description<?php echo $i; ?>">Description <?php echo $i; ?>:</label>
                                <input type="text" name="description<?php echo $i; ?>" class="form-control" value="<?php echo $D["descriptions{$i}"]; ?>">
                            <?php endfor; ?>

                            <!-- Paths -->
                            <label for="chemin1">Chemin 1 :</label>
                            <input type="text" name="chemin1" class="form-control" value="<?php echo $D['chemin1']; ?>">

                            <label for="chemin2">Chemin 2 :</label>
                            <input type="text" name="chemin2" class="form-control" value="<?php echo $D['chemin2']; ?>">

                            <!-- URL -->
                            <label for="url">URL :</label>
                            <input type="text" name="url" class="form-control" value="<?php echo $D['url_groupe_annonce']; ?>">

                            <!-- Keyword -->
                            <label for="keywords">Mot clé :</label>
                            <input type="text" name="mot_cle" class="form-control" value="<?php echo $D['mot_cle']; ?>">

                            <!-- Submit Button -->
                            <button type="submit">Sauvegarder</button>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
