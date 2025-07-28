
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
			    <h4 class="card-title">Listing client <span id="countItem"><?php  ?></span></h4>
			</div>
			
				
			<div class="card-body collapse in">
	    		<div class="card-block card-dashboard"></div>
				<div class="table-responsive" id="">
				<?php //foreach($current_user as $groups): ?>	
					
			<?php //var_dump($current_user->last_name);?>
		
		<?php //endforeach; ?>
        <div class="row">
                            <div class="col-lg-3">
                        <label for="filterEtat">Filtrer par état</label>
                        <select id="filterEtat" class="form-control">
                            <option value="">Tous</option>
                            <option value="0">Rapport à résilier</option>
                            <option value="1">Actif</option>
                            <option value="2">Résilié</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
    <label for="filterMonth">Filtrer par Mois</label>
    <select id="filterMonth" class="form-control">
        <option value="">Sélectionner un Mois</option>
        <!-- Les mois seront ajoutés dynamiquement -->
    </select>
</div>

<div class="col-lg-3">
    <label for="filterYear">Filtrer par Année</label>
    <select id="filterYear" class="form-control">
        <option value="">Sélectionner une Année</option>
        <!-- Les années seront ajoutées dynamiquement -->
    </select>
</div>


            </div>
					
					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>AM</th>
            <th>Nom du compte</th>
            
            <th>Date de création</th>
            <th>Contexte</th>
            <th>Rapport</th>
            <th>Rapport de conversions</th>
            <th>Rapport Conv. + CA</th>
            <th>Bilan</th>
            <th>Etat</th>
        </tr>
    </thead>
    <tbody>
        
        <?php foreach($donnee as $C): ?>
        <tr>
            <td>
                <img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($C->am_photo_user)); ?>" alt="avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($C->idonnee); ?>" data-name=""
                data-rapport="<?php echo htmlspecialchars($C->rapport); ?>"
                data-rapport-conversions="<?php echo htmlspecialchars($C->rapport_conversions); ?>"
                data-rapport-conv-ca="<?php echo htmlspecialchars($C->rapport_conv_ca); ?>"
                data-bilan="<?php echo htmlspecialchars($C->bilan); ?>"
                data-remarque="<?php echo htmlspecialchars($C->remarque); ?>"
                data-resiliation="<?php echo htmlspecialchars($C->resiliation); ?>">
            </td>
            <td><?php echo htmlspecialchars($C->nom_client); ?></td>
          
            <td><?php echo htmlspecialchars($C->annonce); ?></td>
            <td>
                <?php if($C->budget != 0) : ?>
                        <?php echo anchor('Listing/contexte/' . $C->idonnee, 'Contexte', ['style' => 'color: black', 'data-edit' => $C->idonnee]); ?>
                <?php endif; ?>
                <?php if($C->budget == 0) : ?>
                        <a href="<?php echo $C->contexte; ?>" target="_blank">Contexte</a>
                <?php endif; ?>
            </td>
            <td>
            <?php if($C->rapport != NULL): ?>      
            <a href="<?php echo $C->rapport; ?>" target="_blank">Rapport </a></td>
            <?php endif; ?>
            </td>
            <td>
                <?php if($C->rapport_conversions != NULL): ?>    
                <a href="<?php echo $C->rapport_conversions; ?>" target="_blank">Conversions</a>
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($C->rapport_conv_ca); ?></td>
            
            <td>
                <?php if($C->budget == 0): ?>      
                <a href="<?php echo $C->bilan; ?>" target="_blank">Bilan </a>
                <?php endif; ?>
                <?php if($C->budget != 0): ?>    
                <a href="<?php echo $C->bilan; ?>" target="_blank">Bilan</a>
                <?php endif; ?>
            </td>
        
            <td class="etat" data-resiliation="<?php echo htmlspecialchars($C->resiliation); ?>">
                <?php if ($C->resiliation == 0): ?>
                    <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25!important; border-radius: 4px;">Rapport à résilier</span>
                <?php endif; ?>
                <?php if ($C->resiliation == 1): ?>
                    <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767!important; border-radius: 4px;">Actif</span>
                <?php endif; ?>
                <?php if ($C->resiliation == 2): ?>
                    <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055!important; border-radius: 4px;">Résilié</span>
                <?php endif; ?>
            </td>
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
                    <div class="form-group">
                            <label for="resiliation">Etat</label>
                            <select name="resiliation" id="resiliation">
                                <option value="0">Rapport à résilié</option>
                                <option value="1">Actif</option>
                                <option value="2">Résilié</option>
                            </select>
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
<script>
$(document).ready(function () {
    // 📌 Clique sur image avatar
    $('.avatar-image').on('click', function () {
        const $this = $(this);
        $('#accountId').val($this.data('id'));
        $('#rapport').val($this.data('rapport'));
        $('#rapportConversions').val($this.data('rapport-conversions'));
        $('#rapportConvCa').val($this.data('rapport-conv-ca'));
        $('#bilan').val($this.data('bilan'));
        $('#remarque').val($this.data('remarque'));
        $('#resiliation').val($this.data('resiliation'));

        $('#editModal').modal('show');
    });

    // 📌 Formulaire AJAX
    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '<?= site_url("Listing/uptates_information_rapport") ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    $('#messageBox').show()
                        .text(res.message)
                        .css({
                            backgroundColor: res.status === 'success' ? 'green' : 'red',
                            color: 'white'
                        });

                    if (res.status === 'success') {
                        setTimeout(() => location.reload(), 1000);
                    }
                } catch (e) {
                    $('#messageBox').show().text('Erreur de traitement.').css({ backgroundColor: 'red', color: 'white' });
                }
            },
            error: function () {
                $('#messageBox').show().text('Erreur de communication avec le serveur.').css({ backgroundColor: 'red', color: 'white' });
            }
        });
    });

    // 📌 DataTable
    const $dataTable = $('#tableData').DataTable({
        destroy: true,
        responsive: false,
        paging: false,
        searching: true,
        scrollX: true,
        language: {
            search: "Rechercher:",
            info: ""
        },
        order: [[1, 'asc']],
        initComplete: function () {
            const api = this.api();

            const months = [
                "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
            ];

            months.forEach((month, i) => {
                $('#filterMonth').append(new Option(month, String(i + 1).padStart(2, '0')));
            });

            for (let year = 2022; year <= 2030; year++) {
                $('#filterYear').append(new Option(year, year));
            }

            $('#filterEtat, #filterMonth, #filterYear').on('change', function () {
                const etat = $('#filterEtat').val();
                const month = $('#filterMonth').val();
                const year = $('#filterYear').val();

                api.rows().every(function () {
                    const row = this.node();
                    const dateText = $(row).find('td').eq(2).text().trim();
                    const rowEtat = $(row).find('.etat').text().trim();

                    const date = new Date(dateText);
                    const rowMonth = String(date.getMonth() + 1).padStart(2, '0');
                    const rowYear = date.getFullYear();

                    let show = true;

                    if (etat !== '') {
                        const etatMap = {
                            "0": "Rapport à résilier",
                            "1": "Actif",
                            "2": "Résilié"
                        };
                        if (etatMap[etat] && etatMap[etat] !== rowEtat) show = false;
                    }

                    if (month && rowMonth !== month) show = false;
                    if (year && String(rowYear) !== year) show = false;

                    $(row).toggle(show);
                });

                // Corrige le bug d'alignement
                $dataTable.columns.adjust().draw(false);
            });
        }
    });
});
</script>


