<?php if($this->session->flashdata('message-succes')): ?>
    <div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
    </div>
<?php endif; ?>

<style>
/* Votre CSS ici */
.client-details {
    position: fixed;
    top: 0;
    right: -50%;
    width: 50%;
    height: 100vh;
    background-color: rgba(255, 255, 255, 0.9);
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
    transition: right 0.5s ease-in-out;
    padding: 20px;
    overflow-y: auto;
    z-index: 1000;
}

.client-details.show {
    right: 0;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
}

.task-details {
    display: none;
}

.task-form {
    width: 100%;
    margin: 50px auto;
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
    color: #007bff;
}

.form-label {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
    display: block;
}

.form-input, .form-textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 2px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px;
}

.form-textarea {
    height: 100px;
    resize: vertical;
}

.form-textarea:focus {
    border-color: #007bff;
    background-color: #f1faff;
}

.form-btn {
    background-color: #007bff;
    color: #fff;
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

.form-btn:hover {
    background-color: #0056b3;
}

.form-input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.form-input, .form-btn, .form-textarea {
    margin-top: 10px;
}

.form-label {
    margin-top: 10px;
}
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            
            <div class="card-body collapse in">
                <!-- Onglets -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                        <a class="nav-link active" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">ALL TASK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">TEAMS TASK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">TEMPORAIRE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">GTM</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    
                <br>
              
                <div class="tab-pane fade show active" id="tab4" role="tabpanel" aria-labelledby="tab0-tab">
                        <button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
                        <table id="tableData4" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                        <h4>Tout les tâches</h4>    
                        <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Date de la demande</th>
                                    <th>Date due</th>
                                    <th>Client</th>
                                    <th>AM</th>
                                    <th>TM</th>
                                    <th>Titre de la tâche</th>
                                    <th>Tâches</th>
                                    <th>Status Technique</th>
                                    <th>Notes équipes techniques</th>
                                    <th>Priorité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tache_team as $T): ?>
                                <tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
                                    <td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
                                    <td><?php echo htmlspecialchars($T->date_demande); ?></td>
                                    <td><?php echo htmlspecialchars($T->date_due); ?></td>
                                    <td><?php echo htmlspecialchars($T->nom_client); ?></td>
                                    <td><?php echo $T->am_first_name . " " . $T->am_last_name; ?></td>
                                    <td><?php echo $T->assigned_first_name . " " . $T->assigned_last_name; ?></td>
                                    <td><?php echo htmlspecialchars($T->title); ?></td>
                                    <td><?php echo htmlspecialchars($T->description); ?></td>
                                    <td style="background-color: <?php echo ($T->Statuts_technique == 0 ? 'yellow' : ($T->Statuts_technique == 1 ? 'blue' : ($T->Statuts_technique == 2 ? 'green' : ($T->Statuts_technique == 3 ? 'pink' : 'red')))); ?>">
                                        <?php echo ($T->Statuts_technique == 0 ? 'Planifier' : ($T->Statuts_technique == 1 ? 'En cours' : ($T->Statuts_technique == 2 ? 'Tâches complètes' : ($T->Statuts_technique == 3 ? 'Validation par l\'account manager' : 'Refusé par l\'équipe technique')))); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($T->note_technique); ?></td>
                                    <td><?php echo htmlspecialchars($T->priorite); ?></td>
                                </tr>

                                <div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">
        
                                    <?php var_dump($T); ?>
                                    <h3>Détails de la tâche</h3>
                                    <form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
                                        <input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($T->idtask); ?>" />
                                        <label for="date_demande" class="form-label">Date de la demande :</label>
                                        <input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($T->date_demande); ?>" required />

                                        <label for="date_due" class="form-label">Date due :</label>
                                        <input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($T->date_due); ?>" required />

                                        <label for="AM" class="form-label">Account Manager :</label>
                                        <select name="AM" class="form-input" required>
                                            <?php foreach ($users as $d): 
                                                $selected = ($d->id == $T->AM) ? 'selected' : ''; ?>
                                                <option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
                                                    <?php echo $d->first_name . " " . $d->last_name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="assigned_to" class="form-label">Utilisateur assigné :</label>
                                        <select name="assigned_to" class="form-input" required>
                                            <?php foreach ($users as $d): 
                                                $selected = ($d->id == $T->assigned_to) ? 'selected' : ''; ?>
                                                <option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
                                                    <?php echo $d->first_name . " " . $d->last_name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="leviers_marketing" class="form-label">Titre:</label>
                                        <input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($T->title); ?>" required/>

                                        <label for="description" class="form-label">Description :</label>
                                        <textarea name="description" class="form-textarea"><?php echo htmlspecialchars($T->description); ?></textarea>

                                        <label for="Statuts_technique" class="form-label">Status Technique :</label>
                                        <select name="Statuts_technique" class="form-input">
                                            <option value="0" <?php echo ($T->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
                                            <option value="1" <?php echo ($T->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option> 
                                            <option value="2" <?php echo ($T->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
                                            <option value="3" <?php echo ($T->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
                                            <option value="4" <?php echo ($T->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
                                        </select>

                                        <label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
                                        <textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($T->note_technique); ?></textarea>

                                        <button type="submit" class="form-btn">Mettre à jour</button>
                                    </form>
                                </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
                        <table id="tableData1" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Date de la demande</th>
                                    <th>Date due</th>
                                    <th>Client</th>
                                    <th>AM</th>
                                    <th>TM</th>
                                    <th>Titre de la tâche</th>
                                    <th>Tâches</th>
                                    <th>Status Technique</th>
                                    <th>Notes équipes techniques</th>
                                    <th>Priorité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tache_team as $T): ?>
                                <tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
                                    <td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
                                    <td><?php echo htmlspecialchars($T->date_demande); ?></td>
                                    <td><?php echo htmlspecialchars($T->date_due); ?></td>
                                    <td><?php echo htmlspecialchars($T->nom_client); ?></td>
                                    <td><?php echo $T->am_first_name . " " . $T->am_last_name; ?></td>
                                    <td><?php echo $T->assigned_first_name . " " . $T->assigned_last_name; ?></td>
                                    <td><?php echo htmlspecialchars($T->title); ?></td>
                                    <td><?php echo htmlspecialchars($T->description); ?></td>
                                    <td style="background-color: <?php echo ($T->Statuts_technique == 0 ? 'yellow' : ($T->Statuts_technique == 1 ? 'blue' : ($T->Statuts_technique == 2 ? 'green' : ($T->Statuts_technique == 3 ? 'pink' : 'red')))); ?>">
                                        <?php echo ($T->Statuts_technique == 0 ? 'Planifier' : ($T->Statuts_technique == 1 ? 'En cours' : ($T->Statuts_technique == 2 ? 'Tâches complètes' : ($T->Statuts_technique == 3 ? 'Validation par l\'account manager' : 'Refusé par l\'équipe technique')))); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($T->note_technique); ?></td>
                                    <td><?php echo htmlspecialchars($T->priorite); ?></td>
                                </tr>

                                <div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">
        
                                    <?php var_dump($T); ?>
                                    <h3>Détails de la tâche</h3>
                                    <form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
                                        <input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($T->idtask); ?>" />
                                        <label for="date_demande" class="form-label">Date de la demande :</label>
                                        <input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($T->date_demande); ?>" required />

                                        <label for="date_due" class="form-label">Date due :</label>
                                        <input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($T->date_due); ?>" required />

                                        <label for="AM" class="form-label">Account Manager :</label>
                                        <select name="AM" class="form-input" required>
                                            <?php foreach ($users as $d): 
                                                $selected = ($d->id == $T->AM) ? 'selected' : ''; ?>
                                                <option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
                                                    <?php echo $d->first_name . " " . $d->last_name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="assigned_to" class="form-label">Utilisateur assigné :</label>
                                        <select name="assigned_to" class="form-input" required>
                                            <?php foreach ($users as $d): 
                                                $selected = ($d->id == $T->assigned_to) ? 'selected' : ''; ?>
                                                <option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
                                                    <?php echo $d->first_name . " " . $d->last_name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="leviers_marketing" class="form-label">Titre:</label>
                                        <input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($T->title); ?>" required/>

                                        <label for="description" class="form-label">Description :</label>
                                        <textarea name="description" class="form-textarea"><?php echo htmlspecialchars($T->description); ?></textarea>

                                        <label for="Statuts_technique" class="form-label">Status Technique :</label>
                                        <select name="Statuts_technique" class="form-input">
                                            <option value="0" <?php echo ($T->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
                                            <option value="1" <?php echo ($T->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option> 
                                            <option value="2" <?php echo ($T->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
                                            <option value="3" <?php echo ($T->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
                                            <option value="4" <?php echo ($T->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
                                        </select>

                                        <label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
                                        <textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($T->note_technique); ?></textarea>

                                        <button type="submit" class="form-btn">Mettre à jour</button>
                                    </form>
                                </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Contenu de l'onglet 2 -->
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
                        <table id="tableData2" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Date de la demande</th>
                                    <th>Date due</th>
                                    <th>Client</th>
                                    <th>AM</th>
                                    <th>TM</th>
                                    <th>Titre de la tâche</th>
                                    <th>Tâches</th>
                                    <th>Status Technique</th>
                                    <th>Notes équipes techniques</th>
                                    <th>Priorité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tache_team as $T): ?>
                                <tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
                                    <td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
                                    <td><?php echo htmlspecialchars($T->date_demande); ?></td>
                                    <td><?php echo htmlspecialchars($T->date_due); ?></td>
                                    <td><?php echo htmlspecialchars($T->nom_client); ?></td>
                                    <td><?php echo $T->am_first_name . " " . $T->am_last_name; ?></td>
                                    <td><?php echo $T->assigned_first_name . " " . $T->assigned_last_name; ?></td>
                                    <td><?php echo htmlspecialchars($T->title); ?></td>
                                    <td><?php echo htmlspecialchars($T->description); ?></td>
                                    <td style="background-color: <?php echo ($T->Statuts_technique == 0 ? 'yellow' : ($T->Statuts_technique == 1 ? 'blue' : ($T->Statuts_technique == 2 ? 'green' : ($T->Statuts_technique == 3 ? 'pink' : 'red')))); ?>">
                                        <?php echo ($T->Statuts_technique == 0 ? 'Planifier' : ($T->Statuts_technique == 1 ? 'En cours' : ($T->Statuts_technique == 2 ? 'Tâches complètes' : ($T->Statuts_technique == 3 ? 'Validation par l\'account manager' : 'Refusé par l\'équipe technique')))); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($T->note_technique); ?></td>
                                    <td><?php echo htmlspecialchars($T->priorite); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Contenu de l'onglet 3 -->
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
                        <table id="tableData3" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Date de la demande</th>
                                    <th>Date due</th>
                                    <th>Client</th>
                                    <th>AM</th>
                                    <th>TM</th>
                                    <th>Titre de la tâche</th>
                                    <th>Tâches</th>
                                    <th>Status Technique</th>
                                    <th>Notes équipes techniques</th>
                                    <th>Priorité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tache_team as $T): ?>
                                <tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
                                    <td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
                                    <td><?php echo htmlspecialchars($T->date_demande); ?></td>
                                    <td><?php echo htmlspecialchars($T->date_due); ?></td>
                                    <td><?php echo htmlspecialchars($T->nom_client); ?></td>
                                    <td><?php echo $T->am_first_name . " " . $T->am_last_name; ?></td>
                                    <td><?php echo $T->assigned_first_name . " " . $T->assigned_last_name; ?></td>
                                    <td><?php echo htmlspecialchars($T->title); ?></td>
                                    <td><?php echo htmlspecialchars($T->description); ?></td>
                                    <td style="background-color: <?php echo ($T->Statuts_technique == 0 ? 'yellow' : ($T->Statuts_technique == 1 ? 'blue' : ($T->Statuts_technique == 2 ? 'green' : ($T->Statuts_technique == 3 ? 'pink' : 'red')))); ?>">
                                        <?php echo ($T->Statuts_technique == 0 ? 'Planifier' : ($T->Statuts_technique == 1 ? 'En cours' : ($T->Statuts_technique == 2 ? 'Tâches complètes' : ($T->Statuts_technique == 3 ? 'Validation par l\'account manager' : 'Refusé par l\'équipe technique')))); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($T->note_technique); ?></td>
                                    <td><?php echo htmlspecialchars($T->priorite); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Ajouter l'overlay
    $('body').append('<div id="overlay" class="overlay"></div>');

    // Lorsqu'on clique sur le nom du client
    $(".client-name").click(function() {
        var taskId = $(this).data("task-id");
        console.log(taskId);

        // Cacher tous les blocs de détails
        $(".task-details").hide();

        // Afficher le formulaire de détails de la tâche spécifique
        $('#task-details-' + taskId).show();

        // Afficher l'overlay et le formulaire de modification
        $('#overlay').show();
        $('#task-details-' + taskId).addClass('show');
    });

    // Fermeture lorsque l'on clique sur l'overlay
    $('#overlay').click(function() {
        $('.task-details').removeClass('show');
        $('#overlay').hide();

        setTimeout(function() {
            $('.task-details').hide();
        }, 500);
    });

    // Empêche la fermeture si l'on clique à l'intérieur du bloc de détails
    $('.task-details').click(function(event) {
        event.stopPropagation();
    });

    // Initialiser DataTables pour chaque tableau
    $('#tableData4, #tableData1, #tableData2, #tableData3').DataTable({
        destroy: true,
        responsive: true,
        paging: false,
        searching: true,
        scrollX: true,
        language: {
            "search": "Rechercher:",
            "info": ""
        },
        order: [[1, 'asc']]
    });

    // Ouvrir automatiquement l'onglet 1 à l'ouverture de la page
    $('#tab4-tab').tab('show'); // Simule un clic sur l'onglet 1
});
</script>

<div class="modal fade text-xs-left" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau tâche | TASKS</h2>
            </div>
            <div id="modal-form-new">
                <form style="padding: 30px;" action="<?php echo base_url("Strategie/insert_tache") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
                    <fieldset>
                        <div class="form-group">
                            <label for="date_demande">Date de la demande</label>
                            <input type="date" class="form-control" id="date_demande" name="date_demande">
                        </div>

                        <script>
                        // Fonction pour obtenir la date au format 'YYYY-MM-DD'
                        function setDefaultDate() {
                            const today = new Date();
                            const yyyy = today.getFullYear();
                            let mm = today.getMonth() + 1; // Mois commence à 0
                            let dd = today.getDate();

                            // Ajouter un zéro devant si le mois ou le jour sont inférieurs à 10
                            if (mm < 10) mm = '0' + mm;
                            if (dd < 10) dd = '0' + dd;

                            const formattedDate = yyyy + '-' + mm + '-' + dd;

                            // Définir la date par défaut dans l'input
                            document.getElementById('date_demande').value = formattedDate;
                        }

                        // Appeler la fonction dès que la page est chargée
                        window.onload = setDefaultDate;
                        </script>

                        <div class="form-group">
                            <label for="date_due">Date due</label>
                            <input type="date" class="form-control" id="date_due" name="date_due">
                        </div>

                        <label for="idclients">Client</label>
                        <select name="idclients" id="product-choice">
                            <?php foreach ($donnee as $d): ?>
                                <option value="<?php echo htmlspecialchars($d->idclients); ?>">
                                    <?php echo htmlspecialchars($d->nom_client); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="form-group">
                            <label for="AM">AM</label>
                            Utilisateur connecté: <?php echo $current_user->first_name . " " . $current_user->last_name ?>
                            <input type="hidden" class="form-control" name="AM" value="<?php echo $current_user->id ?>">
                        </div>

                        <div class="form-group">
                            <label for="assigned_to">TM</label>
                            <select name="assigned_to" id="product-choice">
                                <?php foreach ($users as $d): ?>
                                    <option value="<?php echo htmlspecialchars($d->id); ?>">
                                        <?php echo $d->first_name . " " . $d->last_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Leviers marketing</label>
                            <input type="text" class="form-control" name="title">
                        </div>

                        <div class="form-group">
                            <label for="tache">Tâches</label>
                            <textarea class="form-control" name="tache"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="Statuts_technique" required>
                                <option value="0">Planifier</option>
                                <option value="1">En cours</option>
                                <option value="2">Tâches complètes</option>
                                <option value="3">Validation par l'account manager</option>
                                <option value="4">Refusé par l'équipe technique</option>
                            </select>
                            <input type="hidden" name="type_tache" value="1">
                            <button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>