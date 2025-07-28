<style>
        body {
            font-family: Arial, sans-serif;
            width: 50%;
        }
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
<div class="row">
    <div class="col-md-6">
    <h4 class="card-title" id="basic-layout-colored-form-control">Contexte client Google Ads</h4>
   </div>
   </div>
</br>
   <h5><?php foreach($client as $C): ?>
    <strong>Client:</strong> <?php echo $C['nom_client']; ?> </br></br>
    
    <?php foreach($donnees as $D): ?>
    <strong>Contexte client:</strong> <?php echo $D['contexte_client']; ?> </br></br>
    <?php endforeach; ?>
    <strong>Informations campagne:</strong>   </br></br>
    
        <section>
              
                <table border="1">
                <tr>
                    <th>Campagne Client & GA</th>
                    <th>Zones</th>
                    <th>Mots clés</th>
                </tr>
                <?php foreach($all_groupe as $DC): ?>
                <tr>
                    <td><?php echo $DC['nom_campagne'] ?></td>
                    <td><?php echo $DC['zones'] ?></td>
                    <td style="text-align: center"  ><?php  $motCles = explode("\n", $DC['mot_cle']);

foreach ($motCles as $motCle) {
   echo '"' . trim($motCle) . '"<br>';
} ?></td>
                </tr>
                    <?php endforeach; ?>
            </table>
            </section> 
          
            <?php endforeach; ?>







</h5>
