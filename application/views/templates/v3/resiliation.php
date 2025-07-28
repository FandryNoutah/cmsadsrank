<style>
	#tableData td {
		text-align: center;
		/* Centre le texte horizontalement */
		vertical-align: middle;
		/* Centre le contenu verticalement */
	}

	/* Assurez-vous que Select2 prend toute la largeur du modal */
	#idclients {
		width: 100%;
		/* Donne toute la largeur disponible */
	}

	.table-striped tbody tr:nth-of-type(2n+1) {
		background-color: white;
	}
</style>

<!-- Ajouter jQuery (si ce n'est pas déjà fait) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Ajouter le CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Ajouter le JavaScript de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<?php if ($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>
<div id="messageBox" style="display: none; padding: 10px; margin-top: 20px; border-radius: 5px;"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
				<h4 class="card-title">Résiliation - Pause<span id="countItem"><?php  ?></span></h4>
			</div>


			<div class="card-body collapse in">
				<div class="card-block card-dashboard"></div>
				<div class="table-responsive" id="">
					<?php //foreach($current_user as $groups): 
					?>

					<?php //var_dump($current_user->last_name);
					?>

					<?php //endforeach; 
					?>
					<a href="#" data-toggle="modal" data-target="#inlineNew" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">
					Nouveau
					</a>


					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Date création</th>
								<th>Fin de campagne</th>
								<th>Client</th>
								<th>AM</th>

								<th>TM</th>
								<th>Demande</th>
								<th>Informations</th>
								<th>Etat</th>
							</tr>
						</thead>
						<tbody>

							<?php

							foreach ($resiliation as $C): ?>
								<tr>
									<td><?php echo htmlspecialchars($C->date_resiliation); ?></td>
									<td><?php echo htmlspecialchars($C->fin_campagne); ?></td>
									<td><?php echo htmlspecialchars($C->nom_client); ?></td>
									<!-- Affichage de la photo de l'Account Manager (am_upsell) -->
									<td>
										<img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->am_user_photo_users)); ?>" alt="AM Avatar" style="width: 40px;" class="avatar-image"
											data-id="<?php echo htmlspecialchars($C->idonnee); ?>"
											data-information_resiliation="<?php echo htmlspecialchars($C->information_resiliation); ?>"
											data-demande_resiliation="<?php echo htmlspecialchars($C->demande_resiliation); ?>"
											data-statut_resiliation="<?php echo htmlspecialchars($C->statut_resiliation); ?>">
									</td>
									<td> <img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->tech_user_photo_users)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($C->idonnee); ?>">
									</td>
									<?php if ($C->demande_resiliation == 3): ?>
										<td>Arrêt campagne/résiliation client</td>
									<?php endif; ?>
									<?php if ($C->demande_resiliation == 2): ?>
										<td>Mis en pause</td>
									<?php endif; ?>


									<td><?php echo htmlspecialchars($C->information_resiliation); ?> </td>
									<?php if ($C->statut_resiliation == 0): ?>
										<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
									<?php endif; ?>
									<?php if ($C->statut_resiliation == 1): ?>
										<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">Tâche programmer</span></td>
									<?php endif; ?>
									<?php if ($C->statut_resiliation == 2): ?>
										<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Tâche complète</span></td>
									<?php endif; ?>
									<?php if ($C->statut_resiliation == 3): ?>
										<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Résilié</span></td>
									<?php endif; ?>
									<?php if ($C->statut_resiliation == 4): ?>
										<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Client actif</span></td>
									<?php endif; ?>



								</tr>
							<?php endforeach; ?>

						</tbody>
					</table>

					<!-- Modal for editing -->
					<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="editModalLabel">Modifier Upsell</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form id="editForm">
										<input type="hidden" id="accountId" name="accountId">
										<div class="mb-3">
											<label for="information_resiliation" class="form-label">Information resiliation</label>
											<input type="text" class="form-control" id="information_resiliation" name="information_resiliation" required>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Demande resiliation</label>
											<select name="demande_resiliation" id="demande_resiliation">
												<option value="3">Arrêt campagne/résiliation client</option>
												<option value="2">Mis en pause</option>
											</select>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Statut resiliation</label>
											<select name="statut_resiliation" id="statut_resiliation">
												<option value="0">Planifier</option>
												<option value="1">Tâche programmer</option>
												<option value="2">Tâche complète</option>
											</select>
										</div>
										<button type="submit" class="btn btn-primary" style=" height: 41px; background-color: #4EA5FE; color: white;  border-radius: 20px;">Sauvegarder</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			// Quand l'image est cliquée
			$('.avatar-image').on('click', function() {
				var idonnee = $(this).data('id');
				var information_resiliation = $(this).data('information_resiliation');
				var demande_resiliation = $(this).data('demande_resiliation');
				var statut_resiliation = $(this).data('statut_resiliation');


				// Remplir les champs du modal avec les informations de l'image cliquée
				$('#accountId').val(idonnee);
				$('#information_resiliation').val(information_resiliation);
				$('#demande_resiliation').val(demande_resiliation);
				$('#statut_resiliation').val(statut_resiliation);


				// Ouvrir le modal
				$('#editModal').modal('show');
			});

			// Soumettre le formulaire d'édition
			$('#editForm').on('submit', function(e) {
				e.preventDefault();

				var idonnee = $('#accountId').val();
				var information_resiliation = $('#information_resiliation').val();
				var demande_resiliation = $('#demande_resiliation').val();
				var statut_resiliation = $('#statut_resiliation').val();


				// Envoi des données via AJAX
				$.ajax({
					url: '<?php echo site_url("Resiliation/uptates_information_resiliation"); ?>', // URL de la méthode
					method: 'POST',
					data: {
						idonnee: idonnee,
						information_resiliation: information_resiliation,
						demande_resiliation: demande_resiliation,
						statut_resiliation: statut_resiliation
					},
					success: function(response) {
						var responseData = JSON.parse(response);

						// Afficher le message dans le messageBox
						$('#messageBox').show();
						if (responseData.status === 'success') {
							$('#messageBox').text(responseData.message).css('background-color', 'green').css('color', 'white');
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
		});
	</script>
	<!-- Code du modal -->
	<div class="modal fade text-xs-left" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="padding: 20px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Résilier client</h2>
				</div>
				<div id="modal-form-new">
					<form action="<?php echo base_url("Resiliation/resiliation") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
						<fieldset>
							<br><br>
							<input type="hidden" class="form-control" name="am_resiliation" value="<?php echo $current_user->id; ?>">
							<input type="hidden" class="form-control" name="resiliation" value="0">

							<div class="form-group">
								<label for="exampleInputEmail1">Type</label>
								<select name="demande_resiliation" id="product-choice">
									<option value="3">Arrêt campagne/résiliation client</option>
									<option value="2">Mis en pause</option>
								</select>
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">Client</label>
								<select name="client" id="idclients">
									<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
									<?php foreach ($donnee as $d): ?>
										<option value="<?php echo $d->idclients; ?>">
											<?php echo htmlspecialchars($d->nom_client); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<!-- Script d'initialisation de Select2 après l'ouverture du modal -->
								<script>
									$('#inlineNew').on('shown.bs.modal', function() {
										setTimeout(function() {
											// Initialiser Select2
											$('#idclients').select2({
												placeholder: 'Rechercher un client...',
												allowClear: true,
												tags: true, // Permet la saisie libre de nouveaux éléments
												dropdownParent: $('#inlineNew')
											}).on("select2:open", function() {
												console.log("Select2 est ouvert !"); // Vérifier si le champ est ouvert
											});
										}, 200);
									});
								</script>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">TM</label>
								<select name="tm" id="product-choice">
									<option value="<?php echo $users[7]['id']; ?>">
										<?php echo $users[7]['first_name']; ?>
									</option>
								</select>
							</div>
							<div class="form-group">
								<label for="date_upsell1">Date</label>
								<input type="date" class="form-control" id="date_upsell1" name="date_resiliation" value="">
							</div>
							<script>
								// Cette fonction définit la date d'aujourd'hui comme valeur par défaut
								document.getElementById('date_upsell1').value = new Date().toISOString().split('T')[0];
							</script>
							<div class="form-group">
								<label for="exampleInputEmail1">Date de résiliation</label>
								<input type="date" class="form-control" id="exampleInputEmail1" name="fin_campagne">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Information</label>
								<textarea class="form-control" id="exampleInputEmail1" name="information_resiliation"></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Statut</label>
								<select name="statut_resiliation" id="product-choice">
									<option value="0">Planifier</option>
									<option value="1">Tâche programmer</option>
									<option value="2">Tâche complète</option>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary col-md-12" style=" height: 41px; background-color: #4EA5FE; color: white;  border-radius: 20px;">Ajouter</button>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>



</div>
<script type="text/javascript">
	$(function() {
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
	});
</script>