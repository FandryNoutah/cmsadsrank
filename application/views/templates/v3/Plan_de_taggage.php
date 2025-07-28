

<style>
    #tableData td {
    text-align: center; /* Centre le texte horizontalement */
    vertical-align: middle; /* Centre le contenu verticalement */
}
.table-striped tbody tr:nth-of-type(2n+1) {
  background-color: white;
}
    
</style>
<?php if($this->session->flashdata('message-succes')): ?>
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
			    <h4 class="card-title">Plan de taggage <span id="countItem"><?php  ?></span></h4>
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
              <th style="text-align: center">AM</th>
            <th style="text-align: center; width: 500px;">Client</th>    
          
            <th style="text-align: center">Plan de taggage</th>
             <th style="text-align: center">Message</th>
             <th style="text-align: center">Etat</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($donnee as $C): ?>
        <tr>
              
            <td style="text-align: center">
                <img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->photo_users)); ?>" alt="avatar" style="width: 40px;" class="avatar-image">
                <a style="display: none"><?php echo htmlspecialchars($C->nomam); ?></a>
            </td>
            <td style="text-align: center"><?php echo htmlspecialchars($C->nom_client); ?></td>  
            <td style="text-align: center"><?php echo anchor('Plan_de_taggage/plandetaggage/' . $C->idclients, 'Voir plan', ['style' => 'color: black', 'data-edit' => $C->idclients]); ?></td>
            <td style="text-align: center"></td>  
            <td style="text-align: center"></td>  
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal for editing -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modifier les informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="accountId" name="accountId">
                    <div class="mb-3">
                        <label for="rapport" class="form-label">Rapport</label>
                        <input type="text" class="form-control" id="rapport" name="rapport" required>
                    </div>
                    <div class="mb-3">
                        <label for="rapportConversions" class="form-label">Rapport de conversions</label>
                        <input type="text" class="form-control" id="rapportConversions" name="rapportConversions">
                    </div>
                    <div class="mb-3">
                        <label for="rapportConvCa" class="form-label">Rapport Conv. + CA</label>
                        <input type="text" class="form-control" id="rapportConvCa" name="rapportConvCa">
                    </div>
                    <div class="mb-3">
                        <label for="bilan" class="form-label">Bilan</label>
                        <input type="text" class="form-control" id="bilan" name="bilan">
                    </div>
                    <div class="mb-3">
                        <label for="remarque" class="form-label">Remarque</label>
                        <textarea class="form-control" id="remarque" name="remarque" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Sauvegarder</button>
                </form>
            </div>
        </div>
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
        var accountName = $(this).data('name');
        var rapport = $(this).data('rapport');
        var rapportConversions = $(this).data('rapport-conversions');
        var rapportConvCa = $(this).data('rapport-conv-ca');
        var bilan = $(this).data('bilan');
        var remarque = $(this).data('remarque');

        // Remplir les champs du modal avec les informations de l'image cliquée
        $('#accountId').val(idonnee);
        $('#rapport').val(rapport);
        $('#rapportConversions').val(rapportConversions);
        $('#rapportConvCa').val(rapportConvCa);
        $('#bilan').val(bilan);
        $('#remarque').val(remarque);

        // Ouvrir le modal
        $('#editModal').modal('show');
    });

    // Soumettre le formulaire d'édition
    $('#editForm').on('submit', function(e) {
        e.preventDefault();

        var idonnee = $('#accountId').val();
        var rapport = $('#rapport').val();
        var rapportConversions = $('#rapportConversions').val();
        var rapportConvCa = $('#rapportConvCa').val();
        var bilan = $('#bilan').val();
        var remarque = $('#remarque').val();

        // Envoi des données via AJAX
        $.ajax({
            url: '<?php echo site_url("Listing/uptates_information_rapport"); ?>', // URL de la méthode
            method: 'POST',
            data: {
                idonnee: idonnee,
                rapport: rapport,
                rapportConversions: rapportConversions,
                rapportConvCa: rapportConvCa,
                bilan: bilan,
                remarque: remarque
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

					<script type="text/javascript">
$(function() {
    var $dataTable = $('#tableData').DataTable({
        destroy: true,
        responsive: false,
        paging: false,  // Pas de pagination, afficher tout
        searching: true,  // Recherche activée
        scrollX: true,
        language: {
            "search": "Rechercher:",
            "info": ""  // Désactiver l'affichage de l'information
        },
        order: [[1, 'asc']]
    });
});
</script>

