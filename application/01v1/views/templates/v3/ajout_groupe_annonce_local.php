

<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #004A99;
            color: white;
            text-align: left;
        }
        td {
            background-color: #F4F8FB;
        }
        .header {
            font-weight: bold;
            color: #333;
            font-size: 18px;
            width: 35%;
        }
        .blue-cell {
            background-color: #4285f4;
            font-weight: bold;
            color: white;
            width: 10%;
        }
        .green-text {
            color: green;
        }
        .col {
            background-color: red;
        }
        /* Style for export button */
        .export-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #004A99;
            color: white;
            border: none;
            cursor: pointer;
        }
        /* Image style for logo */
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            width: 200px;
            padding-right: 20px;
        }
        .logo-container h1 {
            flex: 1;
            text-align: right;
        }


</style>
<h4 class="card-title" id="basic-layout-colored-form-control">Google Ads - Ajout Groupe d'annonces - Technique </h4>
<?php foreach($campagne as $D): ?>
							<h3></br>Campagne client : <a style="color: #37BC9B"> <?php echo $D['nom_campagne'] ?></a> </h3>
                            <table id="campaign-table">
    <thead>
        <tr>
            <th>Nom de campagne</th>
            <th style="width: 350px">Information campagne</th>
            <th style="width: 350px">Contexte groupe annonce</th>
            <th>Zone</th>
            <th>Objectif campagne</th>
            <th>URL</th>
            <th>Calendrier</th>
            <th>Appareils</th>
            <th>Budget</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach($campagnes as $D): ?>
            <tr>
                    <td >
                        <?php echo $D['nom_campagne']; ?>
                    </td>
                    <td ><?php echo $D['information_campagne']; ?></td>
                    <td ><?php echo $D['contexte_groupes_annonces']; ?></td>
                    
                    <td ><?php echo $D['zones']; ?></td>
                    <td ><?php echo $D['objectif']; ?></td>
                    <td ><?php echo $D['url_site']; ?></td>
                    <td ><?php echo $D['date_campagne']; ?></td>
                    <td ><?php echo $D['appareil']; ?></td>
                    <td ><?php echo $D['repartition_budget']; ?> €</td>
               
            </tr> <!-- Fermer la ligne ici pour chaque campagne -->
        <?php endforeach; ?>
    </tbody>
</table>

                            <?php foreach($groupe as $G): ?>
							<form action="<?php echo site_url('Googleads/Ajoutgroupelocal'); ?>" method="POST" enctype="multipart/form-data">
                                    <div id="annonce-groups">
                                        <div class="annonce-group">
                                        <input type="hidden" name="idgroupe_annonce" class="form-control" value="<?php echo $G['idgroupe_annonce']; ?>" > <br>
                                        <input type="hidden" name="idcampagne" class="form-control" value="<?php echo $D['idcampagne']; ?>" > <br>
                                        <input type="hidden" name="idclients" class="form-control" value="<?php echo $D['idclients']; ?>" > <br>
                                        <input type="hidden" name="type_campagne" class="form-control" value="<?php echo $D['type_campagne']; ?>" > <br>
                                            <label for="group-name">Nom du groupe :</label>
                                            <input type="text" name="nom_groupe" class="form-control" value="<?php echo $G['nom_groupe'] ?>"></a><br>
                                                   
                                            <label for="titre">Titre 1:</label>
                                            <input type="text" name="titre1" class="form-control" value="<?php echo $G['titre1'] ?>"><br>

                                            <label for="titre">Titre 2:</label>
                                            <input type="text" name="titre2" class="form-control" value="<?php echo $G['titre2'] ?>"><br>

                                            <label for="titre">Titre 3:</label>
                                            <input type="text" name="titre3" class="form-control" value="<?php echo $G['titre3'] ?>"><br>

                                            <label for="titre">Titre 4:</label>
                                            <input type="text" name="titre4" class="form-control" value="<?php echo $G['titre4'] ?>"><br>

                                            <label for="titre">Titre 5:</label>
                                            <input type="text" name="titre5" class="form-control" value="<?php echo $G['titre5'] ?>"><br>

                                            <label for="titre">Titre 6:</label>
                                            <input type="text" name="titre6" class="form-control" value="<?php echo $G['titre6'] ?>"><br>

                                            <label for="titre">Titre 7:</label>
                                            <input type="text" name="titre7" class="form-control" value="<?php echo $G['titre7'] ?>"><br>

                                            <label for="titre">Titre 8:</label>
                                            <input type="text" name="titre8" class="form-control" value="<?php echo $G['titre8'] ?>"><br>

                                            <label for="titre">Titre 9:</label>
                                            <input type="text" name="titre9" class="form-control" value="<?php echo $G['titre9'] ?>"><br>

                                            <label for="titre">Titre 10:</label>
                                            <input type="text" name="titre10" class="form-control" value="<?php echo $G['titre10'] ?>"><br>

                                            <label for="titre">Titre 11:</label>
                                            <input type="text" name="titre11" class="form-control" value="<?php echo $G['titre11'] ?>"><br>

                                            <label for="titre">Titre 12:</label>
                                            <input type="text" name="titre12" class="form-control" value="<?php echo $G['titre12'] ?>"><br>




                                        <label for="description">Description 1:</label>
                                                <textarea name="description1" class="form-control" ><?php echo $G['descriptions1'] ?></textarea><br>

                                                <label for="description">Description 2:</label>
                                                <textarea name="description2" class="form-control" ><?php echo $G['descriptions2'] ?></textarea><br>

                                                <label for="description">Description 3:</label>
                                                <textarea name="description3" class="form-control" ><?php echo $G['descriptions3'] ?></textarea><br>

                                                <label for="description">Description 4:</label>
                                                <textarea name="description4" class="form-control" ><?php echo $G['descriptions4'] ?></textarea><br>

                                                <label for="description">Description brève:</label>
                                                <textarea name="description_breve" class="form-control" ><?php echo $G['description_breve'] ?></textarea><br>

                                                <label for="url">URL :</label>
                                                <input type="text" name="url" class="form-control" value="<?php echo $G['url_groupe_annonce'] ?>"><br>

                                                <label for="keywords">Mot clé :</label>
                                                <textarea name="mot_cle" class="form-control" ><?php echo $G['mot_cle'] ?></textarea><br>
                                                   
                                                <label for="logos">Logo :</label>
                                                
                                                <input type="file" class="form-control" id="logos" aria-describedby="emailHelp" name="logos" value="<?php echo $G['logo_client']; ?>" accept=".jpg, .jpeg, .png">


                                                <img class="media-object" src="<?php echo base_url($G['logo_client']); ?>" 
                                                    title="<?php echo $G['logo_client']; ?>" alt="<?php echo $G['logo_client']; ?>" 
                                                    style="width: 50px;height: 50px;" />
                                                <label for="logos"> Favicon :</label>
                                                
                                                <input type="file" class="form-control" id="logos" aria-describedby="emailHelp" name="favicon" value="<?php echo $G['favicon']; ?>" accept=".jpg, .jpeg, .png">

                                                <img class="media-object" src="<?php echo base_url($G['favicon']); ?>" 
                                                    title="<?php echo $G['favicon']; ?>" alt="<?php echo $G['favicon']; ?>" 
                                                    style="width: 20px;height: 20px;" />
                                            
                                        

											<button type="submit" class="btn btn-success">Suivant</button>
											</form>
                                            <?php endforeach; ?>
                                            <?php endforeach; ?>