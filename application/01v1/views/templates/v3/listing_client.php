
<?php if($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>

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
                                <th>Remarque</th>
							</tr>
						</thead>
						
						<tbody>
						<?php foreach($donnee as $C): ?>
							<tr>
										
										<td><?php echo htmlspecialchars($C->nomam); ?></td>
										<td><?php echo htmlspecialchars($C->site_client); ?></td>
										<td></td>
										<td><?php 
												echo anchor(
													'Listing/contexte/' . $C->idonnee, 
													'Contexte', 
													['style' => 'color: black', 'data-edit' => $C->idonnee]
												); 
											?></td>
										<td>Datastudio</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										
									
										
								
									
							</tr>
							<?php endforeach; ?>	
														
						</tbody>
						
								
					</table>

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

