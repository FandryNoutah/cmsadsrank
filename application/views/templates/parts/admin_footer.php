<style>
	/* Applique le flexbox pour l'ensemble du corps de la page */
	html,
	body {
		height: 100%;
		margin: 0;
	}

	body {
		display: flex;
		flex-direction: column;
	}

	/* Le footer est poussé en bas grâce à margin-top: auto */
	.footer {
		margin-top: auto;
		background-color: #f8f9fa;
		width: 100%;
		padding: 10px 0;
	}

</style>

<footer class="footer footer-static footer-light navbar-border">
	<p class="clearfix text-muted text-sm-center mb-0 px-2">
		<span class="float-md-left d-xs-block d-md-inline-block">
			<a href="#" target="" class="text-bold-800 grey darken-2">Adsrank 2025 </a>
		</span>
	</p>
</footer>

<!-- BEGIN VENDOR JS-->
<script src="<?php echo base_url(VENDORS_PATH . "/js/ui/tether.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/core/libraries/bootstrap.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(VENDORS_PATH . "/js/ui/perfect-scrollbar.jquery.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(VENDORS_PATH . "/js/ui/unison.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(VENDORS_PATH . "/js/ui/blockUI.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(VENDORS_PATH . "/js/ui/jquery.matchHeight-min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(VENDORS_PATH . "/js/ui/screenfull.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(VENDORS_PATH . "/js/extensions/pace.min.js") ?>" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="<?php echo base_url(VENDORS_PATH . "/js/charts/chart.min.js") ?>" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="<?php echo base_url(SCRIPTS_PATH . "/core/app-menu.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/core/app.js") ?>" type="text/javascript"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/pages/dashboard-lite.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/pages/dashboard-2.js") ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->

<!-- BEGIN DAtatables JS-->
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/jquery.dataTables.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/dataTables.bootstrap.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/dataTables.responsive.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/responsive.bootstrap.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/dataTables.buttons.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/dataTables.select.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts/datatables/buttons.colVis.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(PLUGINS_PATH . "/multiselect/js/prettify.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(PLUGINS_PATH . "/multiselect/js/bootstrap-multiselect.js") ?>" type="text/javascript"></script>

<!-- Custom scripts -->
<script src="<?php echo base_url(SCRIPTS_PATH . "/scripts.js") ?>" type="text/javascript"></script>

<!-- Custom scripts -->

<!-- END DAtatables JS-->.
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

</body>