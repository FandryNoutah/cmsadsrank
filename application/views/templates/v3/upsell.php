<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">

<style>
	#tableData td {
		text-align: center;
		/* Centre le texte horizontalement */
		vertical-align: middle;
		/* Centre le contenu verticalement */
	}

	/* Assurez-vous que Select2 prend toute la largeur du modal */
	#upsell_client {
		z-index: 9999;
	}

	.table-striped tbody tr:nth-of-type(2n+1) {
		background-color: white;
	}
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->

<?php if ($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>
<div id="messageBox" style="display: none; padding: 10px; margin-top: 20px; border-radius: 5px;  background-color: #6CF5C2! important;"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
				<h4 class="card-title">Upsell - Booster - Baisse<span id="countItem"><?php  ?></span></h4>
			</div>

			<div class="card-body collapse in">
				<div class="card-block card-dashboard"></div>
				<div class="table-responsive">

				<a href="#" data-toggle="modal" data-target="#inlineNew" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">
				Nouveau
				</a>

				<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Date de demande</th>
            <th>Demande</th>
            <th>AM</th>
            <th>Client</th>
            <th>Type</th>
            <th>Budget</th>
            <th>Date Upsell/baisse</th>
            <!-- <th>TM</th> -->
            <th style="text-align: center">Infos Compta</th>
            <th>Infos AM</th>
		
            <th>Etat</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($upsell as $C): ?>
            <tr>
                <td><?php echo htmlspecialchars($C->date_upsell); ?></td>
                <td>
                    <img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->compta_photo)); ?>" alt="AM Avatar" style="width: 40px;" class="avatar-image"
                         data-idupsell="<?php echo htmlspecialchars($C->idupsell); ?>"
                         data-information="<?php echo htmlspecialchars($C->information); ?>"
                         data-etat="<?php echo htmlspecialchars($C->etat); ?>">
                </td>
				<td>
				<img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->am_photo)); ?>"
     class="modifier-am-image"
     style="width: 40px; cursor: pointer;"
     data-idupsell="<?php echo htmlspecialchars($C->idupsell); ?>"
     data-information-am="<?php echo htmlspecialchars($C->information_am); ?>">


				</td>


                <td><?php echo htmlspecialchars($C->nom_client); ?></td>

                <!-- Type -->
                <td>
                    <?php
                    switch ($C->type_upsell) {
                        case 1:
                            echo "Baisse";
                            break;
                        case 2:
                            echo "Upsell";
                            break;
                        case 3:
                            echo "Booster";
                            break;
                        default:
                            echo "Non défini";
                    }
                    ?>
                </td>

                <!-- Budget -->
                <td>
                    <?php
                    $budget_initiale = $C->budget_initiale;
                    $budget_demande = $C->budgets;
                    $budget_finale = $budget_initiale;

                    if ($C->type_upsell == 2) {
                        $budget_finale += $budget_demande;
                        echo "Budget initiale : $budget_initiale €<br>Budget à augmenter : $budget_demande €<br>Budget final : $budget_finale €";
                    } elseif ($C->type_upsell == 1) {
                        $budget_finale -= $budget_demande;
                        echo "Budget initiale : $budget_initiale €<br>Baisse de budget : - $budget_demande €<br>Budget final : $budget_finale €";
                    } elseif ($C->type_upsell == 3) {
                        echo "Budget initiale : $budget_initiale €<br>Budget à augmenter : $budget_demande €<br>Budget final : $budget_demande €";
                    }
                    ?>
                </td>

                <td><?php echo htmlspecialchars($C->date_demande); ?></td>

                <!-- Informations -->
                <td><?php echo htmlspecialchars($C->information); ?></td>
                <td><?php echo htmlspecialchars($C->information_am); ?></td>



                <td>
					<?php
					$etatLabels = [
						0 => ['label' => 'Planifier', 'bg' => '#FFE177', 'color' => '#817E25'],
						1 => ['label' => 'Tâche programmée', 'bg' => '#64D5FE', 'color' => '#2079B0'],
						2 => ['label' => 'Tâche complétée', 'bg' => '#6CF5C2', 'color' => '#008767'],
					];

					$etatData = $etatLabels[$C->etat];
					echo '<span class="etat-badge" 
								data-idupsell="' . htmlspecialchars($C->idupsell) . '" 
								data-etat="' . htmlspecialchars($C->etat) . '"
								style="padding: 10px 25px; background-color: ' . $etatData['bg'] . '; color: ' . $etatData['color'] . '; border-radius: 4px; cursor: pointer;">' . $etatData['label'] . '</span>';
					?>
				</td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modifierEtatAmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formModifierEtatAm">
        <div class="modal-header">
          <h5 class="modal-title">Changer l’état AM</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="etat-am-idupsell" name="idupsell">
          <label for="etat-am-select">État AM :</label>
          <select class="form-control" id="etat-am-select" name="etat_am">
            <option value="0">Planifier</option>
            <option value="1">En cours</option>
            <option value="2">Terminé</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Gérer le clic sur le badge etat_am
document.querySelectorAll('.etat-am-badge').forEach(function (badge) {
    badge.addEventListener('click', function () {
        const id = this.dataset.idupsell;
        const etatAm = this.dataset.etatAm;

        document.getElementById('etat-am-idupsell').value = id;
        document.getElementById('etat-am-select').value = etatAm;

        $('#modifierEtatAmModal').modal('show');
    });
});

// Gérer la soumission du formulaire AJAX
document.getElementById('formModifierEtatAm').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('etat-am-idupsell').value;
    const etat_am = document.getElementById('etat-am-select').value;

    fetch("<?= base_url('Upsell/update_etat_am') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({ idupsell: id, etat_am: etat_am })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            $('#modifierEtatAmModal').modal('hide');
            setTimeout(() => location.reload(), 300);
        } else {
            alert("Erreur : " + data.message);
        }
    })
    .catch(err => {
        console.error("Erreur AJAX :", err);
    });
});

				</script>

<div class="modal fade" id="modifierEtatModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formModifierEtat">
        <div class="modal-header">
          <h5 class="modal-title">Changer l’état</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="etat-idupsell" name="idupsell">
          <label for="etat-select">État :</label>
          <select class="form-control" id="etat-select" name="etat">
            <option value="0">Planifier</option>
            <option value="1">Tâche programmée</option>
            <option value="2">Tâche complétée</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
// Gérer la soumission du formulaire AJAX
document.getElementById('formModifierEtatAm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Récupérer les données
    const id = document.getElementById('etat-am-idupsell').value;
    const etat_am = document.getElementById('etat-am-select').value;

    // Afficher les valeurs récupérées dans la console pour vérification
    console.log("ID Upsell:", id);
    console.log("Nouvel état AM:", etat_am);

    // Envoyer la requête AJAX
    fetch("<?= base_url('Upsell/update_etat_am') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            idupsell: id,
            etat_am: etat_am
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data); // Vérifier la réponse dans la console

        if (data.status === "success") {
            // Masquer le modal après la soumission
            $('#modifierEtatAmModal').modal('hide');
            // Rafraîchir la page après un délai de 300ms pour éviter un bug d'affichage
            setTimeout(() => location.reload(), 300);
        } else {
            alert("Erreur : " + data.message);
        }
    })
    .catch(err => {
        console.error("Erreur AJAX :", err);
    });
});

</script>



























<div class="modal fade" id="modifierAmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formModifierAm">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'information AM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="am-idupsell" name="idupsell">
                    <textarea id="am-information" name="information_am" class="form-control" rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".modifier-am-image");

    images.forEach(function (img) {
        img.addEventListener("click", function () {
            const id = this.dataset.idupsell;
            const info = this.dataset.informationAm;

            document.getElementById("am-idupsell").value = id;
            document.getElementById("am-information").value = info;

            // Bootstrap 4: $('#id').modal('show');
            $('#modifierAmModal').modal('show');
        });
    });

    document.getElementById("formModifierAm").addEventListener("submit", function (e) {
        e.preventDefault();

        const id = document.getElementById("am-idupsell").value;
        const info = document.getElementById("am-information").value;

        fetch("<?= base_url('Upsell/info_tech') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ idupsell: id, information_am: info })
        })
        .then(res => res.json())
        .then(data => {
    if (data.status === "success") {
        $('#modifierAmModal').modal('hide');

        // Petit délai avant le reload pour éviter bug visuel
        setTimeout(() => {
            location.reload(); // Recharge toute la page
        }, 300);
    } else {
        // Affiche un message d'erreur sans alert
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger';
        errorDiv.textContent = data.message;
        document.querySelector('.modal-body').prepend(errorDiv);
    }
})

        .catch(err => console.error("Erreur AJAX :", err));
    });
});
</script>

<style>
/* Styles du popup */
.popup {
    display: none; /* Le popup est caché par défaut */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fond sombre */
}

.popup-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}



</style>

































<script>
	document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".avatar-image");

    images.forEach(function (img) {
        img.addEventListener("click", function () {
            // Récupérer les données
            const id = img.getAttribute("data-idupsell");
            const information = img.getAttribute("data-information");

            // Remplir la modal avec les données
            document.getElementById("idupsell").value = id;
            document.getElementById("information_upsell").value = information;

            // Afficher la modal
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });

    // Soumettre le formulaire via AJAX
    document.getElementById("editForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const idupsell = document.getElementById("idupsell").value;
        const information_upsell = document.getElementById("information_upsell").value;

        // Envoyer la requête AJAX
        fetch('<?php echo base_url("Upsell/info_am"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'idupsell': idupsell,
                'information_upsell': information_upsell
            })
        })
        .then(response => response.json())
        .then(data => {
            // Vérifier si la mise à jour a réussi
            if (data.status === 'success') {
                // Fermer la modal
                const editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                editModal.hide();

                // Mettre à jour l'élément dans la table si nécessaire
                // Vous pouvez aussi mettre à jour l'information dans le tableau en temps réel
                const row = document.querySelector(`tr[data-idupsell="${idupsell}"]`);
                if (row) {
                    const infoCell = row.querySelector('.info-cell');
                    infoCell.textContent = information_upsell; // Met à jour l'information dans la table
                }
            } else {
                // Si vous voulez informer l'utilisateur autrement (par exemple, changer la couleur de fond ou afficher un message sans alerte)
                const errorMessage = document.createElement('div');
                errorMessage.textContent = data.message;
                errorMessage.style.color = 'red';
                document.body.appendChild(errorMessage);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    });
});
</script>
<!-- Modal for editing -->
		<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editModalLabel">Infos pour AM</h5>
					</div>
					<div class="modal-body">
						<form id="editForm" action="<?php echo base_url("Upsell/info_am"); ?>">
							<input type="hidden" id="idupsell" name="idupsell">
							<div class="mb-3">
								<textarea class="form-control" id="information_upsell" name="information_upsell" rows="4"></textarea>
							</div>
							<button type="submit" class="btn btn-primary" style="height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px;">Sauvegarder</button>
						</form>
					</div>
				</div>
			</div>
		</div>
</div>
</div>
</div>
</div>
<!-- Code du modal -->
<!-- Modal -->
<div class="modal fade text-xs-left" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title text-text-bold-300" id="myModalLabel33">Créer Upsell - Baisse</h2>
            </div>
            <div id="modal-form-new">
                <form action="<?php echo base_url("Upsell/creer_upsell") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
                    <fieldset>
                        <input type="hidden" class="form-control" name="demmande_upsell" value="<?php echo $current_user->id; ?>">

                        <div class="form-group">
                            <label for="type_upsell">Type</label>
                            <select name="type_upsell" id="type_upsell" class="form-control">
								<option ></option>
                                <option value="2">Upsell - création de nouvelle campagne</option>
                                <option value="1">Baisse de budget</option>
                                <option value="3">Booster</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="client_select">Client</label>
                            <select name="client" id="client_select" class="form-control" style="width: 100%;">
							<option ></option>
                                <?php foreach ($donnee as $d): ?>
                                    <option value="<?php echo $d->idclients; ?>" data-budget="<?php echo $d->budget; ?>">
                                        <?php echo htmlspecialchars($d->nom_client); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="budget_initiale">Budget initiale</label>
                            <input type="text" class="form-control" name="budget_initiale" id="budget_initiale" value="">
                        </div>

                        <div class="form-group">
                            <label for="budget_upsell">Budget</label>
                            <input type="text" class="form-control" name="budget_upsell" id="budget_upsell" value="">
                        </div>

                        <div class="form-group" id="am_container" style="display: none;">
                            <label for="am_select">AM</label>
                            <select name="am" id="am_select" class="form-control">
                                <?php foreach($users as $u): ?>
                                    <option value="<?php echo $u['id']; ?>">
                                        <?php echo $u['first_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- TM -->
						<div class="form-group" id="tm_container" style="display: none;">
							<label for="tm_select">TM</label>
							<select name="tm" id="tm_select" class="form-control">
								<option value="<?php echo $users[7]['id']; ?>">
									<?php echo $users[7]['first_name']; ?>
								</option>
							</select>
						</div>


                        <div class="form-group">
                            <label for="date_upsell">Date de demande</label>
                            <input type="date" class="form-control" id="date_upsell" name="date_upsell" value="">
                        </div>

                        <div class="form-group">
                            <label for="date_demande_upsell">Date Upsell / Baisse</label>
                            <input type="date" class="form-control" id="date_demande_upsell" name="date_demande_upsell">
                        </div>

                        <div class="form-group">
                            <label for="information_upsell">Information</label>
                            <textarea class="form-control" id="information_upsell" name="information_upsell"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="statut_upsell">Statut</label>
                            <select name="statut_upsell" id="statut_upsell" class="form-control">
                                <option value="0">Planifier</option>
                                <option value="1">Tâche programmée</option>
                                <option value="2">Tâche complétée</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> -->

<script>
	$(document).ready(function() {
    // Sélection d'un client et mise à jour du budget
    $('#client_select').on('change', function() {
        var selectedClient = $(this).find('option:selected');
        var budget = selectedClient.data('budget');
        $('#budget_initiale').val(budget);
    });

    // Affichage de l'AM uniquement pour certains types
	$(document).ready(function() {
    // Affichage de l'AM et TM uniquement pour certains types
	$('#type_upsell').on('change', function() {
    var type = $(this).val();

    if (type === '2' || type === '1') {
        // Afficher AM et TM pour Upsell et Baisse
        $('#am_container').show();
        $('#tm_container').show();
    } else if (type === '3') {
        // Afficher seulement TM pour Booster
        $('#am_container').hide();
        $('#tm_container').show();
    } else {
        // Cacher les deux pour tout autre cas
        $('#am_container').hide();
        $('#tm_container').hide();
    }
});


});




    // Formulaire modal pour la mise à jour (fusion des deux blocs sur .avatar-image)
    $('body').on('click', '.avatar-image', function() {
        var idupsell = $(this).data('idupsell');
        var budget = $(this).data('budget');
        var information = $(this).data('information');
        var etat = $(this).data('etat');

        $('#idonnee').val(idupsell);
        $('#inforamtion_upsell').val(information);
        $('#budget').val(budget);
        $('#statut_upsell').val(etat);
        $('#editModal').modal('show');
    });

    // Soumettre le formulaire d'édition
    $('#editForm').on('submit', function(e) {
        e.preventDefault();

        var idonnee = $('#idonnee').val();
        var inforamtion_upsell = $('#inforamtion_upsell').val();
        var budget_upsell = $('#budget_upsell').val();
        var statut_upsell = $('#statut_upsell').val();

        // Envoi des données via AJAX
        $.ajax({
            url: '<?php echo site_url("Upsell/uptates_information"); ?>', // URL de la méthode
            method: 'POST',
            data: {
                idonnee: idonnee,
                inforamtion_upsell: inforamtion_upsell,
                budget_upsell: budget_upsell,
                statut_upsell: statut_upsell
            },
            success: function(response) {
                var responseData = JSON.parse(response);

                // Afficher le message dans le messageBox
                $('#messageBox').show();
                if (responseData.status === 'success') {
                    $('#messageBox').text(responseData.message).css('background-color', '#6CF5C2').css('color', 'black');
                    // Rafraîchir la page après une mise à jour réussie
                    location.reload(); // Rafraîchir la page
                } else {
                    $('#messageBox').text(responseData.message).css('background-color', 'red').css('color', 'white');
                }
            },
            error: function() {
                $('#messageBox').show().text('Erreur de communication avec le serveur.').css('background-color', 'red').css('color', 'white');
            }
        });
    });

    // Initialiser DataTable
    var $dataTable = $('#tableData').DataTable({
        destroy: true,
        responsive: false,
        paging: false, // Pas de pagination, afficher tout
        searching: true, // Recherche activée
        scrollX: true,
        language: {
            "search": "Rechercher:",
            "info": "" // Désactiver l'affichage de l'information
        },
        order: [
            [1, 'asc']
        ]
    });

    // Initialiser Select2
    $('#client_select').select2({
        placeholder: "Sélectionner un client",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#inlineNew')
    });
});

</script>