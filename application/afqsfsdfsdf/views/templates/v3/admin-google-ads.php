<?php if ($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>
<style>
	.popupdate {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		/* Fond semi-transparent */
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}

	.popup-content6 {
		background-color: white;
		padding: 20px;
		border-radius: 10px;
		width: 400px;
		/* Ajuste la largeur selon tes besoins */
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		position: relative;
	}

	.popup-content6 h2 {
		margin-top: 0;
	}

	.close {
		position: absolute;
		top: 10px;
		right: 10px;
		cursor: pointer;
		font-size: 24px;
	}

	.dates {
		width: 100%;
		padding: 8px;
		font-size: 16px;
	}

	button {
		padding: 10px 20px;
		background-color: #00b388;
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	button:hover {
		background-color: #2a9f7b;
	}

	/* Style pour le bouton de fermeture */
	.close {
		position: absolute;
		top: 10px;
		right: 10px;
		font-size: 22px;
		color: #333;
		cursor: pointer;
		background-color: transparent;
		border: none;
		padding: 0;
	}

	/* L'effet hover sur le bouton de fermeture */
	.close:hover {
		color: #e74c3c;
	}

	/* Titre du popup */
	h2 {
		font-size: 18px;
		color: #333;
		margin-bottom: 20px;
	}

	/* Style pour le formulaire */
	.formdate {
		margin-top: 10px;
	}

	.abeldate {
		font-size: 16px;
		color: #333;
		margin-bottom: 10px;
		display: block;
	}

	/* Style pour l'input de date */
	.dates[type="date"] {
		padding: 12px 16px;
		margin-bottom: 20px;
		font-size: 16px;
		border: 1px solid #ddd;
		border-radius: 5px;
		width: 100%;
		/* Prend toute la largeur disponible */
		box-sizing: border-box;
		transition: border-color 0.3s;
	}

	/* Changement de couleur du champ date lorsqu'il est sélectionné */
	.dates[type="date"]:focus {
		border-color: #3498db;
		outline: none;
	}

	/* Style pour le bouton de soumission */
	.button1 {
		padding: 12px 20px;
		background-color: #4CAF50;
		color: white;
		font-size: 16px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		transition: background-color 0.3s ease;
		width: 100%;
		/* Utilise toute la largeur disponible */
		box-sizing: border-box;
	}

	/* Effet hover sur le bouton de soumission */
	.button1:hover {
		background-color: #45a049;
	}

	/* Style pour un bouton d'annulation (optionnel) */
	.cancel-btn {
		padding: 12px 20px;
		background-color: #f39c12;
		color: white;
		font-size: 16px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		transition: background-color 0.3s ease;
		margin-top: 10px;
		width: 100%;
		/* Utilise toute la largeur disponible */
	}

	/* Effet hover sur le bouton d'annulation */
	.cancel-btn:hover {
		background-color: #e67e22;
	}

	@font-face {
		font-family: 'Product Sans';
		font-style: normal;
		font-weight: normal;
		src: local('Product Sans'), url('<?php echo base_url(CSS_PATH . "/fontgoogle/ProductSans-Regular.woff"); ?>') format('woff');
	}

	#tableData td {
		text-align: center;
		/* Centre le texte horizontalement */
		vertical-align: middle;
		/* Centre le contenu verticalement */
	}


	.point-rouge {
		width: 10px;
		height: 10px;
		background-color: #F56C93;
		border-radius: 50%;
		display: inline-block;
		margin-right: 10px;
	}

	.table-striped tbody tr:nth-of-type(2n+1) {
		background-color: white;
	}
	.card-header {
  border-bottom:
0px solid #EEEEEE;
}
.table.dataTable tbody > tr.selected, table.dataTable tbody > tr > .selected {
  background-color: #f2f5fc! important;
}

</style>


<div class="row" >
	<div class="col-lg-12" >
		<div class="card">

			<div class="card-header">
				<div style=" border-bottom: 1px solid #EEEEEE;">
				<h4 class="card-title" style="margin-bottom: 10px;">dashboard <span id="countItem"><?php  ?></span></h4>
				</div>
				</br>
				<a href="#" data-toggle="modal" data-target="#inlineNew" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">Nouveau client</a>


				<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
						<li><a data-action="reload"><i class="icon-reload"></i></a></li>
						<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						<li><a data-action="close"><i class="icon-cross2"></i></a></li>
					</ul>
				</div>
			</div>



			<div class="row" style="margin-left: 10px;">
                            <div class="col-lg-3">
                        <label for="filterMois">Filtrer par mois :</label>
                        <select id="filterMois" class="form-control">
						<option value="">Tous les mois</option>
						<option value="01">Janvier</option>
						<option value="02">Février</option>
						<option value="03">Mars</option>
						<option value="04">Avril</option>
						<option value="05">Mai</option>
						<option value="06">Juin</option>
						<option value="07">Juillet</option>
						<option value="08">Août</option>
						<option value="09">Septembre</option>
						<option value="10">Octobre</option>
						<option value="11">Novembre</option>
						<option value="12">Décembre</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
				<label for="filterMonth">Filtrer par Année</label>
				<select id="filterAnnee" name="filterAnnee" class="form-control">
									<option value="">Toutes les années</option>
									<!-- Les options pour l'année sont générées dynamiquement -->
								</select>
			</div>
			</div>

			<div class="card-body collapse in">
				<div class="card-block card-dashboard"></div>
				<div class="table-responsive" id="">

					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap w-100" cellspacing="0" style="text-align: center !important;">
						<thead>
							<tr>
								<th></th>
								<th style="text-align: center !important;">Client</th>
								<th style="text-align: center !important;">Site internet</th>
								<th style="text-align: center !important;">Déja client?</th>
								<th style="text-align: center !important;">Produit</th>
								<th style="text-align: center !important;">Budget</th>
								<th style="text-align: center !important;">Initiative</th>
								<th style="text-align: center !important;">AM</th>
								<th style="text-align: center !important;">Gocardless</th>
								<th style="text-align: center !important;">Brief</th>
								<th style="text-align: center !important;">Envoi structure</th>
								<th style="text-align: center !important;">Validation structure</th>
								<th style="text-align: center !important;">Lien multimedia</th>
								<th style="text-align: center !important;">Paiement reçu</th>
								<th style="text-align: center !important;">Création Compte Ads</th>
								<th style="text-align: center !important;">DataStudio</th>
								<th style="text-align: center !important;">Annonce en ligne</th>
								<th style="text-align: center !important;">Email Onboarding</th>
								<th style="text-align: center !important;">Facturation</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($donnee as $C): 
								if ($C->budget != 0) : ?>
								<tr style="text-align: center; vertical-align: center; font-size: 14px;">
									<td >
										<a href="#" class="expand-row" data-id="<?php echo $C->idonnee; ?>" data-commentaire="<?php echo $C->commentaire_client; ?>">
											<i class="fas fa-plus" style="color: #949cab !important"></i>
										</a>
									</td>
									<td style="text-align: center !important;width: 50px! important;">
										<?php if ($C->commentaire_client != NULL): ?>
											<div class="point-rouge"></div>
										<?php endif; ?>
										<?php echo htmlspecialchars($C->nom_client); ?>
									</td>
									<td><?php echo htmlspecialchars($C->site_client); ?></td>

									<!-- Déjà client -->
									<?php if ($C->dejaclient == 0): ?>
										<td id="openForm_<?php echo $C->idonnee; ?>" class="openForm"><a href="#" style="color: #373a3c">Non</a></td>
									<?php else: ?>
										<td id="openForm_<?php echo $C->idonnee; ?>" class="openForm"><a href="#" style="color: #373a3c">Oui</a></td>
									<?php endif; ?>

									<!-- Produit -->
									<td class="open-product-popup" data-product-id="<?php echo $C->idonnee; ?>" data-product-label="<?php echo htmlspecialchars($C->label_produit); ?>">
										<?php echo htmlspecialchars($C->label_produit); ?>
									</td>

									<!-- Budget -->
									<td>
										<?php
										$budget = $C->budget;
										$budget = ($budget / 2) / 30.6;
										$budget = round($budget, 2);
										?>
										<?php echo $budget; ?> €
									</td>

									<!-- Initiative -->
									<td>
										<!-- Affichage de la photo de l'initiative (tech_user) -->
										<img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->tech_photo_user)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image">
									</td>

									<!-- AM (Account Manager) -->
									<td>
										<!-- Affichage de la photo de l'account manager (am_user) -->
										<img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->am_photo_user)); ?>" alt="Account Manager Avatar" style="width: 40px;" class="avatar-image">
									</td>


									<!-- Gocardless -->
									<td>
										<?php if ($C->mis_en_place_paiement != 0000 - 00 - 00): ?>
											<?php echo htmlspecialchars($C->mis_en_place_paiement); ?>
										<?php endif; ?>
									</td>

									<!-- Brief -->
									<?php if ($C->Brief != 0000 - 00 - 00): ?>
										<?php if ($C->campagne_actif == 0): ?>
											<td style="background-color: #ec2626; color: white">
												<b><?php echo anchor("Googleads/Admin_brief/" . $C->idonnee, htmlspecialchars($C->Brief), 'style="color: white" data-edit="' . $C->idonnee . '"'); ?></b>
											</td>
										<?php else: ?>
											<td style="background-color: #00b388; color: white">
												<b><?php echo anchor("Googleads/Admin_brief/" . $C->idonnee, htmlspecialchars($C->Brief), 'style="color: white" data-edit="' . $C->idonnee . '"'); ?></b>
											</td>
										<?php endif; ?>
									<?php else: ?>
										<td style="background-color: #ec2626; color: white">
												<b><?php echo anchor("Googleads/Admin_brief/" . $C->idonnee, 'N/D', 'style="color: white" data-edit="' . $C->idonnee . '"'); ?></b>
											</td>
									<?php endif; ?>

									<!-- Validation structure -->
									<?php if ($C->validation_technique != 0000-00-00): ?>
										<td style="background-color: #00b388; color: white">
											<b><?php echo anchor('Validation/validation_structure/' . $C->idclients, $C->validation_technique, ['style' => 'color: white', 'data-edit' => $C->idclients, 'target' => '_blank']); ?></b>
										</td>
									<?php else: ?>
										<td></td>
									<?php endif; ?>

									<!-- Date validation structure -->
									<?php if ($C->lien_datastudio == 0): ?>
										<td>
											<a class="openPopupBtn" data-id="<?php echo $C->idonnee; ?>">
												<b><?php echo ($C->date_validation_structure == 0000 - 00 - 00) ? 'Ajouter une date' : htmlspecialchars($C->date_validation_structure); ?></b>
											</a>
										</td>
									<?php endif; ?>
									<?php if ($C->lien_datastudio == 1): ?>
										<td style="background-color: #00b388; color: white">
											<a class="openPopupBtn" data-id="<?php echo $C->idonnee; ?>">
												<b><?php echo ($C->date_validation_structure == 0000 - 00 - 00) ? 'Ajouter une date' : htmlspecialchars($C->date_validation_structure); ?></b>

											</a>
										</td>
									<?php endif; ?>
									<?php if ($C->lien_datastudio == 0): ?>
										<td>

										</td>
									<?php endif; ?>
									<?php if ($C->lien_datastudio == 1): ?>
										<td>
											<a class="openPopupBtn" data-id="<?php echo $C->idonnee; ?>">
												<?php echo anchor('Datastudio/datastudios/' . $C->idonnee, 'Lien', ['style' => 'color: black', 'data-edit' => $C->idonnee, 'target' => '_blank']); ?>

											</a>
										</td>
									<?php endif; ?>
									<!-- Popup pour la sélection de la date -->
									<div class="popup" data-id="<?php echo $C->idonnee; ?>">
										<div class="popup-content6">
											<span class="closePopupBtn">&times;</span>
											<h2>Sélectionner une date de validation structure</h2>
											<form class="dateForm" action="<?php echo base_url('Googleads/validation_structure'); ?>" method="POST" class="formdate">
												<input type="hidden" name="idonnee" value="<?php echo $C->idonnee; ?>" required>
												<input class="dates" type="date" name="date_validation_structure">
												<br><br>
												<button type="submit">Soumettre</button>
											</form>
										</div>
									</div>

									<td>
										<a>
											<?php if ($C->paiement_recu == 0): ?>
												Non
											<?php endif; ?>
											<?php if ($C->paiement_recu == 1): ?>
												Oui
											<?php endif; ?>
										</a>
									</td>


									<td class="openPopupBtnPR" data-id="<?php echo $C->idonnee; ?>">
										<?php if ($C->Céation_compte_ads == 0000 - 00 - 00): ?>
											Ajouter date
										<?php endif; ?>

										<?php if ($C->Céation_compte_ads != 0000 - 00 - 00): ?>
											<?php echo $C->Céation_compte_ads; ?>
										<?php endif; ?>
									</td>

									<div id="popupYesOrNoPR_<?php echo $C->idonnee; ?>" class="popup">
										<div class="popup-content6">
											<span id="popupClose">&times;</span>
											<h2>Date création compte Ads</h2>
											<form class="selectForm" action="<?php echo base_url('Googleads/creation_ads'); ?>" method="POST">
												<input type="hidden" name="idonnee" id="idonneeInput" value="<?php echo $C->idonnee; ?>" required>
												<input class="dates" type="date" name="date_creation_ads">
												<br><br>
												<button type="submit">Mettre à jour</button>
											</form>
										</div>
									</div>

									<script>
										document.querySelector('.openPopupBtnPR').addEventListener('click', function() {
											var idonnee = this.getAttribute('data-id');
											// document.getElementById('idonneeInput').value = idonnee;
											document.getElementById('popupYesOrNoPR_' + idonnee).style.display = 'block'; // Pour afficher le popup
										});

										document.getElementById('popupClose').addEventListener('click', function() {
											document.getElementById('popupYesOrNoPR').style.display = 'none'; // Pour fermer le popup
										});
									</script>

									<td><a class="openPopupBtnAEL" data-id="<?php echo $C->idonnee; ?>">
											<?php if ($C->datastudio == 0): ?>
												Non
											<?php endif; ?>
											<?php if ($C->datastudio == 1): ?>
												Oui
											<?php endif; ?>
										</a></td>

									<!-- Annonce en ligne -->
									<td>
										<?php if ($C->annonce != 0000 - 00 - 00): ?>
											<?php echo htmlspecialchars($C->annonce); ?>
										<?php endif; ?>
									</td>

									</a></td>
									<td><a class="openPopupBtnEmail" data-id="<?php echo $C->idonnee; ?>">
											<?php if ($C->email_onboarding == 0): ?>
												Non
											<?php endif; ?>
											<?php if ($C->email_onboarding == 1): ?>
												Oui
											<?php endif; ?>
										</a></td>
									<td><a class="openPopupBtnFacturation" data-id="<?php echo $C->idonnee; ?>">
											<?php if ($C->facturation == 0): ?>
												Non
											<?php endif; ?>
											<?php if ($C->facturation == 1): ?>
												Oui
											<?php endif; ?>
										</a>
									</td>
								</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>

					<script>
						document.addEventListener('DOMContentLoaded', function() {
							document.querySelectorAll('.openPopupBtnPR').forEach(button => {
								button.addEventListener('click', function() {
									const id = this.getAttribute('data-id');
									const currentValue = this.textContent.trim();

									const popup = document.getElementById('popupYesOrNoPR_' + id);
									const select = document.getElementById('popupSelect');
									const popupTitle = document.getElementById('popupTitle');

									// select.value = currentValue === 'Oui' ? '1' : '0';

									popup.setAttribute('data-id', id);
									popup.style.display = 'flex';
								});
							});

							document.querySelectorAll('.openPopupBtnAEL').forEach(button => {
								button.addEventListener('click', function() {
									const id = this.getAttribute('data-id');
									const currentValue = this.textContent.trim();

									const popup = document.getElementById('popupYesOrNoAEL');
									const select = document.getElementById('popupSelect');
									const popupTitle = document.getElementById('popupTitle');

									select.value = currentValue === 'Oui' ? '1' : '0';


									popup.setAttribute('data-id', id);
									popup.style.display = 'flex';
								});
							});

							document.querySelectorAll('.openPopupBtnEmail').forEach(button => {
								button.addEventListener('click', function() {
									const id = this.getAttribute('data-id');
									const currentValue = this.textContent.trim();

									const popup = document.getElementById('popupYesOrNoEmail');
									const select = document.getElementById('popupSelect');
									const popupTitle = document.getElementById('popupTitle');

									select.value = currentValue === 'Oui' ? '1' : '0';


									popup.setAttribute('data-id', id);
									popup.style.display = 'flex';
								});
							});

							document.querySelectorAll('.openPopupBtnFacturation').forEach(button => {
								button.addEventListener('click', function() {
									const id = this.getAttribute('data-id');
									const currentValue = this.textContent.trim();

									const popup = document.getElementById('popupYesOrNoFacturation');
									const select = document.getElementById('popupSelect');
									const popupTitle = document.getElementById('popupTitle');

									select.value = currentValue === 'Oui' ? '1' : '0';


									popup.setAttribute('data-id', id);
									popup.style.display = 'flex';
								});
							});

							// document.getElementById('popupSubmit').addEventListener('click', function() {
							//     const popup = document.getElementById('popupYesOrNoPR');
							//     const id = popup.getAttribute('data-id');
							//     const field = popup.getAttribute('data-field');
							//     const newValue = document.getElementById('popupSelect').value;

							//     fetch('update_value.php', {
							//         method: 'POST',
							//         headers: { 'Content-Type': 'application/json' },
							//         body: JSON.stringify({ id, field, value: newValue })
							//     })
							//     .then(response => response.json())
							//     .then(data => {
							//         if (data.success) {
							//             document.querySelector(`[data-id="${id}"][data-field="${field}"]`).textContent = newValue === '1' ? 'Oui' : 'Non';
							//         }
							//     });

							//     popup.style.display = 'none';
							// });

							document.getElementById('popupClose').addEventListener('click', function() {
								document.getElementById('popupYesOrNoPR').style.display = 'none';
								document.getElementById('popupYesOrNoAEL').style.display = 'none';
								document.getElementById('popupYesOrNoEmail').style.display = 'none';
								document.getElementById('popupYesOrNoFacturation').style.display = 'none';

							});
						});
					</script>
					<script>
						/* document.querySelectorAll('.expand-row').forEach(button => {
							button.addEventListener('click', function() {
								const id = this.getAttribute('data-id');
								const detailsRow = document.getElementById('details_' + id);
								detailsRow.style.display = detailsRow.style.display === 'none' ? '' : 'none';
								this.innerHTML = detailsRow.style.display === 'none' ? '<i class="fas fa-plus"></i>' : '<i class="fas fa-minus"></i>';
							});
						}); */

						// Fonctionnalité de popup dynamique pour chaque ligne
						document.querySelectorAll('.openPopupBtn').forEach(button => {
							button.addEventListener('click', function() {
								const id = this.getAttribute('data-id');
								const popup = document.querySelector(`.popup[data-id="${id}"]`);
								if (popup) {
									popup.style.display = 'flex';
								} else {
									console.error("Popup non trouvé pour l'ID : " + id);
								}
							});
						});

						// Fermer le popup
						document.querySelectorAll('.closePopupBtn').forEach(button => {
							button.addEventListener('click', function() {
								const popup = this.closest('.popup');
								popup.style.display = 'none';
							});
						});

						// Fermer le popup en cliquant à l'extérieur du contenu
						document.querySelectorAll('.popup').forEach(popup => {
							popup.addEventListener('click', function(event) {
								if (event.target === popup) {
									popup.style.display = 'none';
								}
							});
						});

						// Soumettre le formulaire et fermer le popup
						document.querySelectorAll('.dateForm').forEach(form => {
							form.addEventListener('submit', function(event) {
								event.preventDefault();
								const popup = this.closest('.popup');
								popup.style.display = 'none';
								this.submit();
							});
						});
						document.querySelectorAll('.openPopupBtn').forEach(button => {
							button.addEventListener('click', function() {
								const id = this.getAttribute('data-id');
								const popup = document.querySelector(`.popup[data-id="42${id}"]`);
								if (popup) {
									popup.style.display = 'flex';
								} else {
									console.error("Popup non trouvé pour l'ID : " + id);
								}
							});
						});

						// Fermer le popup
						document.querySelectorAll('.closePopupBtn').forEach(button => {
							button.addEventListener('click', function() {
								const popup = this.closest('.popup');
								popup.style.display = 'none';
							});
						});

						// Fermer le popup en cliquant à l'extérieur du contenu
						document.querySelectorAll('.popup').forEach(popup => {
							popup.addEventListener('click', function(event) {
								if (event.target === popup) {
									popup.style.display = 'none';
								}
							});
						});

						// Soumettre le formulaire et fermer le popup
						document.querySelectorAll('.dateForm').forEach(form => {
							form.addEventListener('submit', function(event) {
								event.preventDefault();
								const popup = this.closest('.popup');
								popup.style.display = 'none';
								this.submit();
							});
						});
					</script>


					<!-- La popup (brief) -->
					<div class="briefoverlay" id="briefoverlay"></div>
					<div class="brief" id="brief">
						<h3>Choisir une date</h3>
						<input type="date" id="date-input">
						<br><br>
						<button class="closebrief" id="closebrief">Fermer</button>
					</div>

					<script>
						// Récupérer les éléments
						const ajoutBrief = document.getElementById("ajout-brief");
						const brief = document.getElementById("brief");
						const briefoverlay = document.getElementById("briefoverlay");
						const closeBrief = document.getElementById("closebrief");

						// Afficher le brief au clic sur la cellule
						ajoutBrief.addEventListener("click", function() {
							brief.style.display = "block";
							briefoverlay.style.display = "block";
						});

						// Fermer le brief quand on clique sur le bouton de fermeture
						closeBrief.addEventListener("click", function() {
							brief.style.display = "none";
							briefoverlay.style.display = "none";
						});

						// Fermer le brief quand on clique sur le briefoverlay
						briefoverlay.addEventListener("click", function() {
							brief.style.display = "none";
							briefoverlay.style.display = "none";
						});
					</script>
					<!-- Modale personnalisée -->
					<div id="product-popup" class="product-popup" style="display: none;">
						<div class="product-popup-content">
							<span id="close-popup" class="close-popup">&times;</span>
							<h2>Éditer un produit</h2>

							<!-- Formulaire pour éditer le produit -->
							<form id="edit-product-form" action="<?php echo base_url('Googleads/update_produit'); ?>" method="POST">
								<!-- Champ caché pour l'ID du produit -->
								<input type="hidden" id="product-id" name="product_id" value="">

								<label for="product-select">Choisir un produit:</label>
								<select id="product-select" name="product_id">
									<!-- Liste déroulante des produits remplie par PHP -->
									<?php foreach ($donnee as $C): ?>
										<option value="<?php echo $C->idproduit; ?>"><?php echo htmlspecialchars($C->label_produit); ?></option>
									<?php endforeach; ?>
								</select>

								<div id="product-info">
									<!-- Information sur le produit choisi (cette section peut être mise à jour dynamiquement) -->
								</div>

								<button type="submit">Sauvegarder</button>
							</form>
						</div>
					</div>
					<style>
						/* Style de la popup */
						.product-popup {
							display: none;
							/* Cachée par défaut */
							position: fixed;
							/* Fixe la popup à l'écran */
							z-index: 1;
							/* Au-dessus de tout le reste */
							left: 0;
							top: 0;
							width: 100%;
							height: 100%;
							overflow: auto;
							/* Permet de faire défiler si nécessaire */
							background-color: rgba(0, 0, 0, 0.4);
							/* Fond sombre semi-transparent */
						}

						.product-popup-content {
							background-color: #fefefe;
							margin: 15% auto;
							padding: 20px;
							border: 1px solid #888;
							width: 80%;
							/* Largeur de la popup */
							max-width: 600px;
						}

						.close-popup {
							color: #aaa;
							float: right;
							font-size: 28px;
							font-weight: bold;
						}

						.close-popup:hover,
						.close-popup:focus {
							color: black;
							text-decoration: none;
							cursor: pointer;
						}
					</style>
					<script>
						$(function() {
							// Quand on clique sur un <td> avec la classe .open-product-popup
							$(".open-product-popup").click(function() {
								// Afficher la modale
								$("#product-popup").fadeIn();
							});

							// Quand on clique sur le bouton de fermeture de la popup
							$("#close-popup").click(function() {
								// Cacher la modale
								$("#product-popup").fadeOut();
							});

							// Quand on change le produit dans la liste déroulante
							$("#product-select").change(function() {
								// Récupérer l'ID du produit sélectionné
								var productId = $(this).val();

								// Mettre à jour le champ caché avec l'ID du produit
								$("#product-id").val(productId);

								// Envoyer une requête AJAX pour obtenir les détails du produit (optionnel)
								$.ajax({
									url: '<?php echo base_url("Googleads/get_product_details"); ?>', // URL pour obtenir les détails du produit
									method: 'GET',
									data: {
										product_id: productId
									},
									success: function(response) {
										// Afficher les informations du produit dans la section #product-info
										$("#product-info").html(response);
									}
								});
							});

							// Quand on soumet le formulaire (par exemple, sauvegarder l'édition)
							$("#edit-product-form").submit(function(e) {
								e.preventDefault(); // Empêche la soumission du formulaire par défaut

								// Données à soumettre, y compris l'ID caché du produit
								var formData = $(this).serialize();

								// Envoi des données via AJAX pour sauvegarder
								$.ajax({
									url: '<?php echo base_url("Googleads/update_produit"); ?>', // URL de votre contrôleur et méthode
									method: 'POST',
									data: formData,
									success: function(response) {
										alert("Produit mis à jour avec succès !");
										$("#product-popup").fadeOut(); // Fermer la popup après l'enregistrement
									},
									error: function() {
										alert("Erreur lors de la mise à jour du produit.");
									}
								});
							});
						});
					</script>

					<!-- Popup -->
					<div id="popup" class="popup">
						<div class="popup-content">
							<span class="close-btn" onclick="closePopup()">&times;</span>
							<h3>Modifier l'historique</h3>
							<iframe id="popup-frame" src="" width="100%" height="400px" frameborder="0"></iframe>
						</div>
					</div>

					<!-- Styles CSS -->
					<style>
						/* Popup background */
						.popup {
							display: none;
							/* Caché par défaut */
							position: fixed;
							top: 0;
							left: 0;
							width: 100%;
							height: 100%;
							background-color: rgba(0, 0, 0, 0.7);
							z-index: 1000;
						}

						/* Contenu de la popup */
						.popup-content {
							position: absolute;
							top: 50%;
							left: 50%;
							transform: translate(-50%, -50%);
							background-color: white;
							padding: 20px;
							border-radius: 8px;
							width: 80%;
							max-width: 600px;
							text-align: center;
						}

						/* Bouton de fermeture */
						.close-btn {
							position: absolute;
							top: 10px;
							right: 20px;
							font-size: 30px;
							color: #aaa;
							cursor: pointer;
						}

						.close-btn:hover {
							color: black;
						}

						/* Style du lien d'édition */
						.icon-edit {
							font-size: 20px;
							color: #007bff;
							text-decoration: none;
						}

						.icon-edit:hover {
							text-decoration: underline;
						}
					</style>

					<!-- Script JavaScript -->
					<script>
						function openPopup(url) {
							// Afficher la popup
							document.getElementById('popup').style.display = 'block';

							// Charger l'URL dans un iframe à l'intérieur de la popup
							document.getElementById('popup-frame').src = url;
						}

						function closePopup() {
							// Cacher la popup
							document.getElementById('popup').style.display = 'none';

							// Arrêter le chargement de la page dans l'iframe (si nécessaire)
							document.getElementById('popup-frame').src = '';
						}
					</script>





					<!-- Popup formulaire (masqué par défaut) -->
					<div id="popupForm" class="popup">
						<div class="popup-content" style="height: 300px;">
							<span class="close" id="closeForm">&times;</span>
							<div class="popup-header">Déja client?</div>
							<!-- Formulaire dynamique -->
							<form action="<?php echo base_url("Googleads/dejaclient") ?>" method="POST" id="formPopup">
								<input type="hidden" id="idonnee" name="idonnee"> <!-- ID du client -->

								<!-- Affichage du nom du client -->
								<label for="clientName">Nom du client:</label>
								<p id="clientName" style="font-weight: bold;"></p><br><br>

								<!-- Liste déroulante Oui / Non -->
								<label for="decision">Décision:</label>
								<select id="decision" name="decision" required>
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select><br><br>

								<!-- Bouton de soumission -->
								<button type="submit" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Envoyer</button>
							</form>
						</div>
					</div>

					<script>
						// Récupérer tous les liens "Oui"
						var openFormLinks = document.querySelectorAll(".openForm");
						var popup = document.getElementById("popupForm");
						var closeForm = document.getElementById("closeForm");

						// Ajouter un événement pour chaque lien
						openFormLinks.forEach(function(link) {
							link.onclick = function(event) {
								event.preventDefault(); // Empêcher le comportement par défaut du lien

								var idonnee = this.id.replace('openForm_', ''); // Récupérer l'ID client depuis l'ID du lien
								var clientRow = this.closest("tr"); // Trouver la ligne correspondante (tr)

								// Récupérer le nom du client depuis la ligne
								var clientName = clientRow.querySelectorAll('td')[1].textContent; // Le nom du client est dans la deuxième cellule

								// Remplir le formulaire avec l'ID du client et le nom du client
								document.getElementById("idonnee").value = idonnee;
								document.getElementById("clientName").textContent = clientName; // Afficher le nom dans le formulaire

								// Vous pouvez également définir la valeur par défaut de la liste déroulante si nécessaire
								document.getElementById("decision").value = "oui"; // Valeur par défaut ("oui")

								// Afficher la popup
								popup.style.display = "flex";
							};
						});



						// Fermer la popup lorsque l'utilisateur clique sur "x"
						closeForm.onclick = function() {
							popup.style.display = "none"; // Masquer la popup
						}

						// Fermer la popup si l'utilisateur clique en dehors du formulaire
						window.onclick = function(event) {
							if (event.target == popup) {
								popup.style.display = "none";
							}
						}
					</script>

					<div style="margin-bottom: 20px;">

					</div>

				</div>
			</div>

			<div class="modal fade text-xs-left" id="inlineMaj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">MAJ Visuel</h2>
						</div>
						<div id="modal-form-edit"></div>
					</div>
				</div>
			</div>



			<div class="modal fade text-xs-left" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="padding: 20px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau client</h2>
						</div>
						<div id="modal-form-new">

							<!--<form action="<?php //echo base_url("liste_car/new") 
												?>" enctype="multipart/form-data" method="post" id="majCampagne">-->
							<form action="<?php echo base_url("Googleads/insert_client") ?>" enctype="multipart/form-data" method="post" id="majCampagne" enctype="multipart/form-data">
								<fieldset>
									<div class="form-group">
										<label for="exampleInputEmail1">Client </label>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="client">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Site internet </label>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="site_client">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Email Client </label>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email_client">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Numéro de téléphone </label>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="numero_client">
									</div>

									<div class="form-group">
										<label for="exampleInputEmail1">Budget</label>
										<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="budget">
									</div>
									<div class="form-group">
										<label>Déja client:</label>
										<select name="dejaclient" required>
											<option value="0">Non</option>
											<option value="1">Oui</option>

										</select><br><br>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Produit</label>
										<select name="product_choice" id="product-choice">
											<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
											<?php foreach ($produit as $d): ?>
												<option value="<?php echo htmlspecialchars($d->idproduit); ?>">
													<?php echo htmlspecialchars($d->label_produit); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Initiative</label>
										<select name="initiative" id="product-choice">
											<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
											<?php foreach ($users as $d): ?>
												<option value="<?php echo htmlspecialchars($d->id); ?>">
													<?php echo htmlspecialchars($d->first_name); ?> <?php echo htmlspecialchars($d->last_name); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Account manager</label>
										<select name="am" id="product-choice">
											<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
											<?php foreach ($users as $d): ?>
												<option value="<?php echo htmlspecialchars($d->id); ?>">
													<?php echo htmlspecialchars($d->first_name); ?> <?php echo htmlspecialchars($d->last_name); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Date mis en place du paiement</label>
										<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_mis_en_place">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Date brief</label>
										<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_brief">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Date annonce en ligne</label>
										<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_annonce">
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary col-md-12" style="font-size: 16px;font-weight: 500;margin-top: 50px;background-color: #4EA5FE; color: white;  border-radius: 20px;">Ajouter</button>
								</fieldset>
							</form>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php
//$myDateTime = DateTime::createFromFormat('Y-m-d', $dateString);
//$newDateString = $myDateTime->format('d-m-Y');
?>

<!-- <input type="hidden" onclick="" name="exportdata" value="<?php echo base64_encode(addslashes(json_encode($result))); ?>" /> -->

<script type="text/javascript">
	function ExportToExcel(type, fn, dl) {
		var elt = document.getElementById('tableData');
		var wb = XLSX.utils.table_to_book(elt, {
			sheet: "sheet1"
		});
		return dl ?
			XLSX.write(wb, {
				bookType: type,
				bookSST: true,
				type: 'base64'
			}) :
			XLSX.writeFile(wb, fn || ('Fichier.' + (type || 'xlsx')));
	}

	function createMonthFilter() {

		let form_group = $('<div>', {
			class: "form-group"
		});

		let label = $('<label for="month_filter">Filtre par mois:</label>').appendTo($(form_group));

		let input = $('<input>', {
			id: "month_filter",
			class: "dates",
			type: "month"
		}).appendTo($(form_group));

		$('#donnee_month_filter').append(form_group);
	} 

	function formatExpandable() {
		return (
			'<div>test</div>'
		);
	} 

	function createExpandableRow(idonnee, commentaire_client) {
		// Création de la ligne de tableau
		let tr = document.createElement("tr");
		tr.className = "expandable";
		tr.id = "details_" + idonnee;

		let td = document.createElement("td");
		td.colSpan = "19";
		td.style.textAlign = "left";
		
		// Ajout des liens
		td.innerHTML = `
			<a href="Googleads/editclient/${idonnee}"><i class="fas fa-edit" style="width: 25px;color: #949cab; margin-right: 10px;"></i></a>
			<a href="Googleads/view/${idonnee}"><i class="fas fa-eye" style="color: #949cab; margin-right: 10px;"></i></a>
			${commentaire_client ? `<a href="Googleads/message/${idonnee}"><i class="fas fa-envelope" style="color: #949cab; margin-right: 10px;"></i></a>` : ""}
			
			${createPopup("popupYesOrNoPR", "Paiement reçu ?", "Googleads/paiement_recu", idonnee)}
			${createPopup("popupYesOrNoEmail", "Email Onboarding", "Googleads/email_onboarding", idonnee)}
			${createPopup("popupYesOrNoFacturation", "Facturation", "Googleads/facturation", idonnee)}
		`;
		
		tr.appendChild(td);
		console.log(tr);
		
		return tr;
	}

	function createPopup(id, title, action, idonnee) {
		return `
			<div id="${id}_${idonnee}" class="popup">
				<div class="popup-content6">
					<span class="popupClose">&times;</span>
					<h2>${title}</h2>
					<form class="selectForm" action="${action}" method="POST">
						<input type="hidden" name="idonnee" value="${idonnee}" required>
						<select name="paiement_recu">
							<option value="1">Oui</option>
							<option value="0">Non</option>
						</select>
						<button type="submit">Mettre à jour</button>
					</form>
				</div>
			</div>
		`;
	}

	$(function() {

		let dom_l = '<"col-12 col-sm-auto"l>';
		let dom_B = '<"col-12 col-sm-auto ml-auto"B>';
		let dom_f = '<"col-12 col-sm-auto"f>';
		let dom_tr = '<"col-sm-12"tr>';
		let dom_i = '<"col-sm-12 col-md-5"i>';
		let dom_p = '<"col-sm-12 col-md-7"p>';
		let dom_custom_filter = '<"col-12 col-sm-auto"<"#donnee_month_filter.dataTables_length">>';

		let dom_top = '<"row"' + dom_l + dom_custom_filter + dom_B + dom_f +'>';
		let dom_center = '<"row"'+ dom_tr +'>';
		let dom_bottom = '<"row"'+ dom_i + dom_p +'>';

		let datatable_dom = dom_top + dom_center + dom_bottom;

		var $dataTable = $('#tableData').DataTable({
			dom: datatable_dom,
			destroy: true,
			responsive: false,
			paging: false,
			searching: true,
			scrollX: true,
			select: true,
			//autoFill: true,
			lengthMenu: [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "Tout"]
			],
			language: {
				"lengthMenu": "Afficher _MENU_ lignes par page",
				"search": "Rechercher:",
				"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
			},
			buttons: [
				'copy', 'csv', 'excel', 'pdf'
			],
			select: {
				style: 'os',
				selector: 'td:first-child'
			},
			order: [
				[1, 'asc']
			]
		});

		// Create month filter input as a DOM
		/* createMonthFilter();

		$('#month_filter').change(function(e) {
			
			let month_filter = $(this).val();
			let currentUrl = (window.location.href).split("?")[0];

			let params = new URLSearchParams({
				month_filter: month_filter
			});
			
			window.location.href = currentUrl + '?' + params.toString();
		}); */

		$dataTable.on('click', '.expand-row', function(e) {

			let tr = e.target.closest('tr');
			let row = $dataTable.row(tr);

			let idonnee = $(this).attr('data-id');
			let commentaire_client = $(this).attr('data-commentaire');
			
			if (row.child.isShown()) {
        		// This row is already open - close it
				row.child.hide();
				$(this).children('i').removeClass('fa-minus');
				$(this).children('i').addClass('fa-plus');
			} else {
				// Open this row
				row.child(createExpandableRow(idonnee, commentaire_client)).show();
				$(this).children('i').removeClass('fa-plus');
				$(this).children('i').addClass('fa-minus');
			}
			
		});

		$('#selectAll').click(function() {
			if ($dataTable.rows({
					selected: true
				}).count() > 0) {
				$dataTable.rows().deselect();
				$("input[type=checkbox]").prop("checked", false);
				return;
			}
			$("input[type=checkbox]").prop("checked", true);
			$dataTable.rows().select();
		});

		$dataTable.on('select deselect', function(e, dt, type, indexes) {
			var $selected = null;
			var $checkedIds = [];
			if (type === 'row') {
				// We may use dt instead of myTable to have the freshest data.
				if (dt.rows().count() === dt.rows({
						selected: true
					}).count()) {
					// Deselect all items button.
					$('#selectAll i').attr('class', 'far fa-check-square');
					//return;
				} else if (dt.rows({
						selected: true
					}).count() === 0) {
					// Select all items button.
					$('#selectAll i').attr('class', 'far fa-square');
					//return;
				} else {
					// Deselect some items button.
					$('#selectAll i').attr('class', 'far fa-minus-square');
				}

				$selected = dt.rows({
					selected: true
				});
			}

			$selected.every(function(rowIdx, tableLoop, rowLoop) {
				//$(this.node()).addClass('selectedfsdfsdf');

				$(this.node()).map(function() {
					$checkedIds.push($(this).data("id"));
				}).get();
			});

			console.log($checkedIds);
		});

		$('#tableData').on('click', 'tbody td span.action-edit', function(e) {
			// Prevent event propagation
			//e.stopPropagation();
			var $row = $(this).closest('tr');
			//var $data = $dataTable.row($row).data();
			//$data.unshift($(this).data("id"));
			var $data = $(this).data("id");
			//console.log($data);
			//alert('Edit ' + data[0]);
			$.ajax({
				url: 'liste_car/edit',
				data: "id=" + $data,
				type: 'post',
				success: function(data) {
					$("#modal-form-edit").html(data);
				},
				error: function(data) {
					$("#modal-form-edit").html("<p>Error</p>");
				}
			});
		});
		var table2excel = new Table2Excel();

		document.getElementById('export').addEventListener('click', function() {
			table2excel.export(document.querySelectorAll('tableData'));
		});
		
	});
</script>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour filtrer les lignes du tableau
    function filterTable() {
	let mois = document.getElementById('filterMois').value;
	let annee = document.getElementById('filterAnnee').value;
	let tableRows = document.querySelectorAll('#tableData tbody tr');

	tableRows.forEach(function(row) {
		let dateColumn = row.querySelector('td:nth-child(9)');
		let dateValue = dateColumn ? dateColumn.textContent.trim() : '';

		if (dateValue !== '') {
			let dateParts = dateValue.split('-');
			let rowMonth = dateParts[1];
			let rowYear = dateParts[0];

			if ((mois === '' || rowMonth === mois) && (annee === '' || rowYear === annee)) {
				row.style.display = '';
			} else {
				row.style.display = 'none';
			}
		} else {
			row.style.display = '';
		}
	});

	// 🔥 Recalcule les colonnes pour garder le bon alignement
	$('#tableData').DataTable().columns.adjust().draw(false);
}


    // Génération dynamique des années dans le filtre (limité de 2023 à 2030)
    var yearSelect = document.getElementById('filterAnnee');
    for (var year = 2022; year <= 2030; year++) {
        var option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    // Écouteurs d'événements pour les filtres
    document.getElementById('filterMois').addEventListener('change', filterTable);
    document.getElementById('filterAnnee').addEventListener('change', filterTable);

    // Lancer la fonction de filtrage dès que la page est prête
    filterTable();
});

</script>