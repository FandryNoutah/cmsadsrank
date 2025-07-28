
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Validation client</title>
    <link rel="stylesheet" href="https://portail.lyc-la-martiniere-diderot.ac-lyon.fr/srv1/html/cours_html_css_isn/exo_sup_isn/fichier_ci_dessous.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
                  body{
            background-color: white! important;
            color: black;
          
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            width: 1400px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #e0e0e0;
            font-size: 14px;
            cursor: pointer;
        }

        th {
            background-color: #4EA5FE;
            color: white;
            text-transform: none;
            letter-spacing: 1px;
        }

        .state-cell {
            background-color: #f1f8ff;
        }

        .state-1 {
            background-color: #6CF5C2 ;
            color: black;
            font-weight: 500;
        }

        .state-2 {
            background-color: #FFE177 ;
            color: black;
            font-weight: 500;
        }

        .state-4 {
            background-color: #F56C93 ;
            color: black;
            font-weight: 500;
        }

        .state-null {
            background-color: grey;
            color: white;
            font-weight: 500;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            margin-top: 0%;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 5px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            cursor: pointer;
        }

    </style>
</head>
<body>
<?php if($this->session->flashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Succès!</strong> <?php echo $this->session->flashdata("message"); ?>
    </div>
<?php endif; ?>

<div id="exportable-content">
    <h1>Plan de taggage 
        <?php foreach($clients as $C): ?>
            <?php echo $C['nom_client']; ?>
        <?php endforeach; ?>
    </h1>
    <?php echo anchor(
    "Googleads/gestion_extension/".$C['idclients'],
    '<span style="margin-right: 20px;display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; width: 60px; height: 41px; background-color: #4EA5FE !important; color: white !important; border-radius: 20px; text-decoration: none;">
        <i class="fa fa-arrow-left" style="margin-right: 8px;"></i>
    </span>',
    'data-edit="'.$C['idclients'].'"'
); ?>

<?php echo anchor(
    "Googleads/ajoutplandetaggage/".$C['idclients'],
    '<span style="margin-right: 20px;display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; width: 250px; height: 41px; background-color: #4EA5FE !important; color: white !important; border-radius: 20px; text-decoration: none;">
        Ajouter plan de taggage
    </span>',
    'data-edit="'.$C['idclients'].'"'
); ?>

    <br><br><br>
    <table id="campaign-table">
        <thead>
            <tr>
                <th> </th>
                <th>Conversion</th>
                <th>Actions</th>
                <th>Types</th>
                <th>Remarques</th>
                <th>Etat</th>
                <th>Conditions</th>
                <th>Conversion ID</th>
                <th>Conversion Label</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($plan_taggage as $P): ?>
            <tr data-id="<?php echo $P['idplan_de_taggage']; ?>"> 
                <td> <?php echo anchor(
                            "Googleads/deleteplandetagggage/".$P['idplan_de_taggage'], 
                            '<i class="fas fa-trash" style="color: #949cab"></i>', 
                            'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette plan de taggage ?\');" data-edit="'.$P['idplan_de_taggage'].'"'
                        ); ?></td>
                <td class="conversion"><?php echo $P['conversion']; ?></td>
                <td class="actions"><?php echo $P['actions']; ?></td>
                <td class="types"><?php echo $P['types']; ?></td>
                <td class="remarque"><?php echo $P['remarque']; ?></td>

                <td class="state-cell <?php 
                    if($P['etat'] == 0) echo 'state-null';
                    if($P['etat'] == 1) echo 'state-1';
                    if($P['etat'] == 2) echo 'state-2';
                    if($P['etat'] == 3) echo 'state-4'; 
                    ?>" 
                    onclick="editState(this)">
                    <?php 
                        if($P['etat'] == 0) echo 'à définir';
                        if($P['etat'] == 1) echo 'Implémenté';
                        if($P['etat'] == 2) echo 'En attente client';
                        if($P['etat'] == 3) echo 'À faire'; 
                    ?>
                </td>
                <td class="conditions"><?php echo $P['conditions']; ?></td>
                <td class="conversion_id"><?php echo $P['conversion_id']; ?></td>
                <td class="conversion_label"><?php echo $P['conversion_label']; ?></td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal pour modifier les données -->
<div id="editModal" class="modal" >
    <div class="modal-content" style="margin-top: 50px;">
        <span class="close-btn">&times;</span>
        <h2>Modifier les informations</h2>
        <form id="modalForm">
            <label for="conversion">Conversion :</label>
            <input type="text" id="conversion" name="conversion">

            <label for="actions">Actions :</label>
            <input type="text" id="actions" name="actions">

            <label for="types">Types :</label>
            <input type="text" id="types" name="types">

            <label for="remarque">Remarque :</label>
            <input type="text" id="remarque" name="remarque">

            <label for="etat">Etat :</label>
            <select name="etat" class="form-control">
                <option value="NULL">à définir</option>
                <option value="1">Implémenté</option>
                <option value="2">En attente client</option>
                <option value="3">À faire</option>
            </select>

            <label for="conditions">Conditions :</label>
            <input type="text" id="conditions" name="conditions">

            <label for="conversion_id">Conversion ID :</label>
            <input type="text" id="conversion_id" name="conversion_id">

            <label for="conversion_label">Conversion Label :</label>
            <input type="text" id="conversion_label" name="conversion_label">

            <input type="hidden" id="rowId" name="rowId"> <!-- ID de la ligne pour identifier l'élément à mettre à jour -->
            <button type="submit" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Sauvegarder</button>
        </form>
    </div>
</div>

<script>
// Ouvrir la popup quand une cellule de la colonne "conversion" est cliquée
document.querySelectorAll("td.conversion").forEach(cell => {
    cell.addEventListener("click", function() {
        var row = this.closest('tr'); // Trouver la ligne (tr) de la cellule cliquée
        var rowId = row.getAttribute('data-id'); // Récupérer l'ID unique de la ligne

        // Remplir la popup avec les données actuelles de la cellule
        document.getElementById('conversion').value = row.querySelector('.conversion').innerText;
        document.getElementById('actions').value = row.querySelector('.actions').innerText;
        document.getElementById('types').value = row.querySelector('.types').innerText;
        document.getElementById('remarque').value = row.querySelector('.remarque').innerText;
        document.getElementById('conditions').value = row.querySelector('.conditions').innerText;
        document.getElementById('conversion_id').value = row.querySelector('.conversion_id').innerText;
        document.getElementById('conversion_label').value = row.querySelector('.conversion_label').innerText;

        // Récupérer et pré-sélectionner l'état dans le popup
        var state = row.querySelector('.state-cell').innerText.trim();
        var stateSelect = document.querySelector('select[name="etat"]');
        switch(state) {
            case 'Implémenté':
                stateSelect.value = "1";
                break;
            case 'En attente client':
                stateSelect.value = "2";
                break;
            case 'À faire':
                stateSelect.value = "3";
                break;
            default:
                stateSelect.value = "NULL"; // Valeur par défaut
                break;
        }

        // Enregistrer l'ID de la ligne dans un champ caché pour l'usage lors de la mise à jour
        document.getElementById('rowId').value = rowId;

        // Afficher la popup
        document.getElementById('editModal').style.display = "block";
    });
});

// Fermer la popup
document.querySelector('.close-btn').addEventListener("click", function() {
    document.getElementById('editModal').style.display = "none";
});

// Fermer la popup si l'utilisateur clique en dehors
window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        document.getElementById('editModal').style.display = "none";
    }
};

// Gestion de la soumission du formulaire
document.getElementById('modalForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêcher la soumission traditionnelle du formulaire

    var rowId = document.getElementById('rowId').value;  // ID de la ligne à mettre à jour

    // Récupérer les nouvelles valeurs du formulaire
    var conversion = document.getElementById('conversion').value;
    var actions = document.getElementById('actions').value;
    var types = document.getElementById('types').value;
    var remarque = document.getElementById('remarque').value;
    var conditions = document.getElementById('conditions').value;
    var conversion_id = document.getElementById('conversion_id').value;
    var conversion_label = document.getElementById('conversion_label').value;
    var etat = document.querySelector('select[name="etat"]').value;  // État sélectionné dans le formulaire

    // Créer un objet FormData à partir des valeurs du formulaire
    var data = new FormData();
    data.append('rowId', rowId);
    data.append('conversion', conversion);
    data.append('actions', actions);
    data.append('types', types);
    data.append('remarque', remarque);
    data.append('conditions', conditions);
    data.append('conversion_id', conversion_id);
    data.append('conversion_label', conversion_label);
    data.append('etat', etat); // Ajouter l'état sélectionné

    // Faire une requête AJAX pour mettre à jour la ligne dans la base de données
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo site_url('Googleads/updateData'); ?>', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {
                // Mise à jour réussie, mettre à jour l'UI
                var row = document.querySelector(`tr[data-id="${rowId}"]`);

                row.querySelector('.conversion').innerText = conversion;
                row.querySelector('.actions').innerText = actions;
                row.querySelector('.types').innerText = types;
                row.querySelector('.remarque').innerText = remarque;
                row.querySelector('.conditions').innerText = conditions;
                row.querySelector('.conversion_id').innerText = conversion_id;
                row.querySelector('.conversion_label').innerText = conversion_label;

                // Mettre à jour l'état dans la table (affichage)
                var stateText = "";
                switch(etat) {
                    case '1':
                        stateText = "Implémenté";
                        break;
                    case '2':
                        stateText = "En attente client";
                        break;
                    case '3':
                        stateText = "À faire";
                        break;
                    default:
                        stateText = "à définir";
                        break;
                }
                row.querySelector('.state-cell').innerText = stateText;

                // Fermer la popup
                document.getElementById('editModal').style.display = "none";
            } else {
                alert('Erreur : ' + response.message);
            }
        }
    };

    xhr.send(data);
});

</script>
    <style>
        /* Style pour le modal */
        .modal {
            display: none; /* Cacher par défaut */
            position: fixed;
            z-index: 1; /* Mettre le modal au-dessus de tout */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Fond sombre */
            background-color: rgba(0,0,0,0.4); /* Fond transparent */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style pour le formulaire */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        input, select, textarea {
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</br></br>
<!--
<h2>Liste des tâches</h2>
<ul>
    <?php //foreach($tasks as $T): ?>
        <li>
            <strong>Titre :</strong> <?php //echo htmlspecialchars($T->title); ?><br>
            <strong>Description :</strong> <?php //echo nl2br(htmlspecialchars($T->description)); ?><br>
            <strong>Pour :</strong> <?php //echo htmlspecialchars($T->first_name); ?> <?php //echo htmlspecialchars($T->last_name); ?><br>
            <strong>Status :</strong> <?php //echo htmlspecialchars($T->status); ?><br>

          Boutons de modification et suppression -->
               <!-- <a href="#" class="openEditModalBtn btn btn-secondary" data-id="<?php //echo $T->idtask; ?>" data-title="<?php //echo htmlspecialchars($T->title); ?>" data-description="<?php echo htmlspecialchars($T->description); ?>" data-assigned-to="<?php echo htmlspecialchars($T->first_name); ?>" data-status="<?php echo htmlspecialchars($T->status); ?>">Modifier</a>

            <a href="<?php //echo site_url('googleads/delete_task?id=' . $T->idtask . '&client_id=' . $T->idclients); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">Supprimer</a>
        </li>
        <hr>
    <?php //endforeach; ?>
</ul> -->
<!-- Modal pour modifier une tâche -->
<div id="editTaskModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Modifier la tâche</h2>
        <form id="editTaskForm" action="<?php echo site_url('Googleads/edit_task'); ?>" method="POST">
            <input type="hidden" id="editTaskId" name="idtask">
            <!-- Ajout du champ caché pour l'idclients -->
            <?php foreach($clients as $C): ?>
            <input type="hidden" id="editClientId" name="idclients" value="<?php echo $C['idclients']; ?>">
            <?php endforeach; ?>

            <label for="editTitle">Titre de la tâche :</label>
            <input type="text" id="editTitle" name="title" required>

            <label for="editDescription">Description :</label>
            <textarea id="editDescription" name="description" required></textarea>

            <label for="editAssignedTo">Attribuer à :</label>
            <select name="user_id" id="editAssignedTo">
                <?php foreach($users as $u): ?>
                    <option value="<?= $u->id ?>"><?= $u->first_name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="editStatus">Statut :</label>
            <select name="status" id="editStatus">
                <option value="en cours">En cours</option>
                <option value="effectuée">Effectuée</option>
                <option value="annulée">Annulée</option>
            </select>

            <button type="submit">Modifier la tâche</button>
        </form>
    </div>
</div>
<script>
// Ouvrir le modal pour modifier la tâche
document.querySelectorAll('.openEditModalBtn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le lien de rediriger

        // Récupérer les données de la tâche à partir des attributs `data-`
        var taskId = this.getAttribute('data-id');
        var taskTitle = this.getAttribute('data-title');
        var taskDescription = this.getAttribute('data-description');
        var assignedTo = this.getAttribute('data-assigned-to');
        var status = this.getAttribute('data-status');

        // Pré-remplir les champs du modal avec les données de la tâche
        document.getElementById('editTaskId').value = taskId;
        document.getElementById('editTitle').value = taskTitle;
        document.getElementById('editDescription').value = taskDescription;

        // Pré-sélectionner la personne à laquelle la tâche est attribuée
        var selectAssignedTo = document.getElementById('editAssignedTo');
        for (var option of selectAssignedTo.options) {
            if (option.text === assignedTo) {
                option.selected = true;
                break;
            }
        }

        // Pré-sélectionner le statut de la tâche
        document.getElementById('editStatus').value = status;

        // Afficher le modal
        var modal = document.getElementById('editTaskModal');
        modal.style.display = 'block';

        // Ajouter un écouteur pour fermer le modal
        document.querySelector('.close-btn').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Fermer le modal si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    });
});


    </script>

</br>
<!--  <button id="openModalBtn">Ajouter une tâche</button> -->
<!-- Le Modal -->
<div id="addTaskModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Ajouter une nouvelle tâche</h2>
        <form id="addTaskForm" action="<?php echo site_url('Googleads/add_task'); ?>" method="POST">
            <?php foreach($clients as $C): ?>
                <input type="hidden" id="clientId" name="idclients" value="<?php echo $C['idclients']; ?>">
            <?php endforeach; ?>

            <label for="title">Titre de la tâche :</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>

            <label for="assigned_to">Attribuer à :</label>
            <select name="user_id">
                <?php foreach($users as $u): ?>
                    <option value="<?= $u->id ?>"><?= $u->first_name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="status">Statut :</label>
            <select name="status" id="taskStatus">
                <option value="en cours">En cours</option>
                <option value="effectuée">Effectuée</option>
                <option value="annulée">Annulée</option>
            </select>

            <button type="submit">Ajouter la tâche</button>
        </form>
    </div>
</div>

<script>
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
    
    var closeBtn = modal.querySelector(".close-btn");
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

document.getElementById("openModalBtn").onclick = function() {
    openModal("addTaskModal");
};

</script>



</body>
</html>
