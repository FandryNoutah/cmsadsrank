<?php if($this->session->flashdata('message-succes')): ?>
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
    background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup-content6 {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px; /* Ajuste la largeur selon tes besoins */
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
    background-color: #37BC9B;
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
    width: 100%; /* Prend toute la largeur disponible */
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
    width: 100%; /* Utilise toute la largeur disponible */
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
    width: 100%; /* Utilise toute la largeur disponible */
}

/* Effet hover sur le bouton d'annulation */
.cancel-btn:hover {
    background-color: #e67e22;
}


	</style>


<div class="row">
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
			    <h4 class="card-title">dashboard <span id="countItem"><?php  ?></span></h4>
				</br>
				<button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
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
			
				
			<div class="card-body collapse in">
	    		<div class="card-block card-dashboard"></div>
				<div class="table-responsive" id="">
				<?php //foreach($current_user as $groups): ?>	
					
			<?php //var_dump($current_user->last_name);?>
		
		<?php //endforeach; ?>
					

					
					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
						<thead>
							<tr>
								
								
								<th></th>
								<th>Client</th>
                                <th>Site internet</th>
                                <th>Déja client?</th>
                                <th>Produit</th>
                                <th>Budget</th>
                                <th>Initiative</th>
                                <th>AM</th>
								<th>Gocardless</th>
                                <th>Brief</th>
								<th>Envoi structure</th>
								<th>Validation structure</th>
                              
                                <th>Paiement reçu</th>
                                <th>Création Compte Ads</th>
                                <th>DataStudio</th>
                                <th>Annonce en ligne</th>
                                <th>Email Onboarding</th>
                                <th>Facturation</th>
                              
							</tr>
						</thead>
						
						<tbody>
						<?php foreach($donnee as $C): ?>
							<tr style="text-align: center; vertical-align: center;">
										<td></td>
										<td>
										<?php echo anchor("Googleads/editclient/".$C->idonnee, '<h6 class="fas fa-edit"></h6><i  class="button" ></i>','data-edit="'.$C->idonnee.'"') ;?>	
										<?php echo anchor("Googleads/view/".$C->idonnee, '<h6 class="fas fa-eye"></h6><i  class="button" ></i>','data-edit="'.$C->idonnee.'"') ;?>
										<?php //echo anchor("Googleads/editclient/".$C->idonnee, '<h6 class="fas fa-tasks"></h6><i  class="button" ></i>','data-edit="'.$C->idonnee.'"') ;?>
										<?php
										if($C->commentaire_client != NULL):
										
										echo anchor("Googleads/message/".$C->idonnee, '<h6 class="fas fa-envelope"></h6><i  class="button" ></i>','data-edit="'.$C->idonnee.'"') ;
										endif;
										?></br>
										<?php echo htmlspecialchars($C->nom_client); ?> 
											
										
									</td>
										<td><?php echo htmlspecialchars($C->site_client); ?></td>
										<?php if( $C->dejaclient == 0){ ?>
										<td href="#" id="openForm_<?php echo $C->idonnee; ?>" class="openForm"><a >Non</a></td>
										<?php } ?>
										<?php if($C->dejaclient != 0){ ?>
										<td  href="#" id="openForm_<?php echo $C->idonnee; ?>" class="openForm"><a >Oui</a></td>
										<?php } ?>
										<td class="open-product-popup" 
											data-product-id="<?php echo $C->idonnee; ?>" 
											data-product-label="<?php echo htmlspecialchars($C->label_produit); ?>">
											<?php echo htmlspecialchars($C->label_produit); ?>
										</td>
										<td>
											<?php $budget = $C->budget; $budget = ($budget / 2)/ 30.6; $budget = round($budget, 2);	?>
										
										<?php echo $budget; ?> €</td>
										<td >
                                                <img src="<?php //echo base_url(IMAGES_PATH . htmlspecialchars($C->photoinitiative)) ?>" alt="avatar" style="width: 40px;">
										<td>
                                                <img src="<?php //echo base_url(IMAGES_PATH . htmlspecialchars($C->photoam)) ?>" alt="avatar" style="width: 40px;">
										   </td>
										
										<td>
										    <?php if( $C->mis_en_place_paiement != 0000-00-00): ?>
										    <?php echo htmlspecialchars($C->mis_en_place_paiement 	); ?> 
										    <?php endif; ?>
										    </td>
										    <?php if( $C->Brief != 0000-00-00): ?>
										<?php if($C->campagne_actif == 0){ ?>
										<td style="background-color: Red; color: white">
											<?php echo anchor("Googleads/Admin_brief/".$C->idonnee, htmlspecialchars($C->Brief), 'style="color: white" data-edit="'.$C->idonnee.'"'); ?>
										</td>
										<?php } ?>
										<?php if($C->campagne_actif != 0){ ?>
										<td style="background-color: #37BC9B; color: white">
											<?php echo anchor("Googleads/Admin_brief/".$C->idonnee, htmlspecialchars($C->Brief), 'style="color: white" data-edit="'.$C->idonnee.'"'); ?>
										</td>
										
										<?php } ?>
										<?php endif; ?>
										<?php if( $C->Brief == 0000-00-00): ?>
										<td>  </td>
										
										<?php endif; ?>
										<?php if($C->validation_technique == "0000-00-00"){ ?>	
										<td >
										</td>
										<?php } ?>
										<?php if($C->validation_technique != "0000-00-00"){ ?>	
										<td style="background-color: #37BC9B; color: white">
										<?php  
												echo anchor(
													'Validation/validation_structure/' . $C->idclients, 
													$C->validation_technique, 
													['style' => 'color: white', 'data-edit' => $C->idclients, 'target' => '_blank']
												); 
											?>
										</td>
										<?php } ?>
									   <?php if($C->date_validation_structure == '0000-00-00'): ?>
    <td>
        <a id="openPopupBtn_<?php echo $C->idonnee; ?>">Ajouter une date</a>
    </td>
<?php else: ?>
    <td>
        <a id="openPopupBtn_<?php echo $C->idonnee; ?>"><?php echo htmlspecialchars($C->date_validation_structure); ?></a>
    </td>
<?php endif; ?>

<!-- Popup -->
<div id="popup_<?php echo $C->idonnee; ?>" class="popupdate">
    <div class="popup-content6">
        <span id="closePopupBtn_<?php echo $C->idonnee; ?>" class="close">&times;</span>
        <h2>Sélectionner une date de </br> validation structure</h2>
        <form id="dateForm_<?php echo $C->idonnee; ?>" action="<?php echo base_url('Googleads/validation_structure'); ?>" method="POST" class="formdate">
            <input type="hidden" name="idonnee" value="<?php echo $C->idonnee; ?>" required>
            <input class="dates" type="date" id="date_<?php echo $C->idonnee; ?>" name="date_validation_structure">
            <br><br>
            <button type="submit">Soumettre</button>
        </form>
    </div>
</div>

<script>
// Dynamically manage popups for each row
<?php foreach($donnee as $C): ?>
const openPopupBtn_<?php echo $C->idonnee; ?> = document.getElementById('openPopupBtn_<?php echo $C->idonnee; ?>');
const popup_<?php echo $C->idonnee; ?> = document.getElementById('popup_<?php echo $C->idonnee; ?>');
const closePopupBtn_<?php echo $C->idonnee; ?> = document.getElementById('closePopupBtn_<?php echo $C->idonnee; ?>');

// Ouvrir le popup spécifique à chaque ligne
openPopupBtn_<?php echo $C->idonnee; ?>.onclick = function() {
    popup_<?php echo $C->idonnee; ?>.style.display = 'flex';
}

// Fermer le popup spécifique à chaque ligne
closePopupBtn_<?php echo $C->idonnee; ?>.onclick = function() {
    popup_<?php echo $C->idonnee; ?>.style.display = 'none';
}

// Fermer le popup en cliquant en dehors du contenu
popup_<?php echo $C->idonnee; ?>.onclick = function(event) {
    if (event.target === popup_<?php echo $C->idonnee; ?>) {
        popup_<?php echo $C->idonnee; ?>.style.display = 'none';
    }
}

// Soumission du formulaire
const form_<?php echo $C->idonnee; ?> = document.getElementById('dateForm_<?php echo $C->idonnee; ?>');
form_<?php echo $C->idonnee; ?>.onsubmit = function(event) {
    event.preventDefault();
    const dateValue = document.getElementById('date_<?php echo $C->idonnee; ?>').value;
    popup_<?php echo $C->idonnee; ?>.style.display = 'none';  // Fermer le popup après soumission
    form_<?php echo $C->idonnee; ?>.submit(); // Soumettre le formulaire
}

<?php endforeach; ?>
</script>

											
											</td>
										<td></td>
										<td><?php 
												echo anchor(
													'Datastudio/datastudios/' . $C->idonnee, 
													'Lien', 
													['style' => 'color: black', 'data-edit' => $C->idonnee, 'target' => '_blank']
												); 
											?></td>
										<td>
										    
										    </td>
										<td><?php if($C->annonce != 0000-00-00): ?>
										    <?php echo htmlspecialchars($C->annonce); ?> 
										    <?php endif; ?></td>
										<td></td>
											<td></td>
									
									
									
										
								
									
							</tr>
							<?php endforeach; ?>	
														
						</tbody>
						
								
					</table>

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
							display: none; /* Cachée par défaut */
							position: fixed; /* Fixe la popup à l'écran */
							z-index: 1; /* Au-dessus de tout le reste */
							left: 0;
							top: 0;
							width: 100%;
							height: 100%;
							overflow: auto; /* Permet de faire défiler si nécessaire */
							background-color: rgba(0,0,0,0.4); /* Fond sombre semi-transparent */
						}

						.product-popup-content {
							background-color: #fefefe;
							margin: 15% auto;
							padding: 20px;
							border: 1px solid #888;
							width: 80%; /* Largeur de la popup */
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
								$(document).ready(function() {
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
								url: '<?php echo base_url("Googleads/get_product_details"); ?>',  // URL pour obtenir les détails du produit
								method: 'GET',
								data: { product_id: productId },
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
								url: '<?php echo base_url("Googleads/update_produit"); ?>',  // URL de votre contrôleur et méthode
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
						display: none; /* Caché par défaut */
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
							<div class="popup-content">
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
								<button type="submit">Envoyer</button>
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
						
						<button onclick="ExportToExcel('xlsx')">Export to excel</button>
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
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau client</h2>
						</div>
						<div id="modal-form-new">
						
							<!--<form action="<?php //echo base_url("liste_car/new") ?>" enctype="multipart/form-data" method="post" id="majCampagne">-->
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
								  <label for="exampleInputEmail1">Budget (Jour)</label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="budget">
								 </div>
								 <label >Déja client:</label>
								<select name="dejaclient" required>
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select><br><br>	
								 
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
									<?php foreach ($initiative as $d): ?>
										<option value="<?php echo htmlspecialchars($d->idinitiative); ?>">
											<?php echo htmlspecialchars($d->nominitiative); ?>
										</option>
									<?php endforeach; ?>
								</select>
								</div>
								<div class="form-group">
								  <label for="exampleInputEmail1">Account manager</label>
								 <select name="am" id="product-choice">
									<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
									<?php foreach ($am as $d): ?>
										<option value="<?php echo htmlspecialchars($d->idam); ?>">
											<?php echo htmlspecialchars($d->nomam); ?>
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
								<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
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

<!--<input type="hidden" onclick="" name="exportdata" value="<?php //echo base64_encode(addslashes(json_encode($result))); ?>" />-->

<script type="text/javascript">
function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tableData');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('Fichier.' + (type || 'xlsx')));
        }
$(function() {
	
	var $dataTable = $('#tableData').DataTable({
		
		destroy: true,
		responsive: false,
		paging: true,
		searching: true,
		scrollX: true,
		select: true,
		//autoFill: true,
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
		language: {
			"lengthMenu": "Afficher _MENU_ lignes par page",
			"search": "Rechercher:",
			"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
		},
		
		buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				],
		columnDefs: [{
			orderable: false,
			className: 'select-checkbox',
			targets: 0
		}],
		
		select: {
			style: 'os',
			selector: 'td:first-child'
		},
		order: [[ 1, 'asc' ]]
		
	});	
		
				
	$('#selectAll').click(function() {
		if ($dataTable.rows({selected: true}).count() > 0) {
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
			if (dt.rows().count() === dt.rows({selected: true}).count()) {
				// Deselect all items button.
				$('#selectAll i').attr('class', 'far fa-check-square');
				//return;
			} else if (dt.rows({selected: true}).count() === 0) {
				// Select all items button.
				$('#selectAll i').attr('class', 'far fa-square');
				//return;
			} else {
				// Deselect some items button.
				$('#selectAll i').attr('class', 'far fa-minus-square');
			}
			
			$selected = dt.rows({selected: true});
		}
		
		$selected.every(function (rowIdx, tableLoop, rowLoop) {
			//$(this.node()).addClass('selectedfsdfsdf');
			
			$(this.node()).map(function(){
				$checkedIds.push($(this).data("id"));
			}).get();
		});
		
		console.log($checkedIds);
	});
	
	$('#tableData').on('click', 'tbody td span.action-edit', function(e){
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
	/*
	$('.action-new').on('click', function(e){
		$.ajax({
			url: 'liste_car/new',
			data: "id=" + $data,
			type: 'post',
			success: function(data) {
				$("#modal-form").html(data);
			},
			error: function(data) {
				$("#modal-form").html("<p>Error</p>");
			}
		});
	});
	
	$('#tableData').on( 'click', 'tbody tr', function () {
		alert($dataTable.row(this).id);
		$dataTable.row(this).edit();
	});
	*/
});
</script>