<div class="row">
    <div class="col-xs-12">
    	
    	<?php if($this->session->flashdata("message-error")): ?>
	    	<div class="alert alert-danger alert-dismissible fade in mb-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Erreur!</strong> <?php echo $this->session->flashdata("message-error"); ?>
			</div>
		<?php endif; ?>

		<?php if($this->session->flashdata("message-succes")): ?>
	    	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
			</div>
		<?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Liste Flags</h4>
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
                <div class="table-responsive">
                    <table id="tableData" class="table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
					    <thead>
					        <tr>
					            <th>#</th>
					            <th>Réference</th>
					            
					            <th>Visuel actuel</th>
					            
					            
					            
					            <th>Quartier</th>
					            <th>Ville</th>
					            
					            <th>Axe</th>
					            <th>Etat bache</th>
					            <th>Etat poteau</th>
					            <th>Etat armature</th>

					            <!-- <th>Emplacement</th> -->
					            <!--<th class="all">Opérations</th>-->
					        </tr>
					    </thead>
					    
					    <tbody>

					    <?php foreach($flags as $flag): ?>
					        <tr>
					            <td><?php echo $flag->id ?></td>
					            <td><?php echo $flag->reference ?></td>
					            
					            <td><?php echo $flag->visuel_actuel ?></td>
					            
					            
					            
					            <td><?php echo $flag->quartier ?></td>
					            <td><?php echo $flag->ville ?></td>
					            <td><?php echo $flag->axe ?></td>
					            <td><?php echo $flag->etat_bache ?></td>
					            <td><?php echo $flag->etat_poteau ?></td>
					            <td><?php echo $flag->etat_armature ?></td>

					            <!--
					            <td>
					            	<?php //echo anchor("flags/view/".$flag->id, '<i class="icon-eye" title="+ détails"></i>','data-view="'.$flag->id.'"') ;?>&nbsp;
					            	<?php //echo anchor("flags/edit/".$flag->id, '<i class="icon-edit" title="Editer"></i>','data-edit="'.$flag->id.'"') ;?>&nbsp;
                                	<?php //echo anchor("flags/delete/".$flag->id, '<i class="icon-android-delete" title="Supprimer"></i>','data-toggle="modal" data-target="#default-'.$flag->id.'" onclick="return false;"') ;?>

                                	<div class="modal fade text-xs-left" id="default-<?php //echo $flag->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
											<div class="modal-content">
											  	<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
													<h4 class="modal-title" id="myModalLabel1">Confirmation</h4>
											  	</div>
											  	<div class="modal-body">
													<p>Voulez-vous vraiment supprimer le flag <b><?php //echo $flag->reference; ?></b> ?</p>
											  	</div>
											  	<div class="modal-footer">
													<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
													<a href="<?php //echo base_url("flags/delete/".$flag->id) ?>" target="_self" class="btn btn-outline-primary">Supprimer</a>
											  	</div>
											</div>
									  	</div>
									</div>
					            </td>
								-->
					        </tr>
					    <?php endforeach; ?>

					    </tbody>
					</table>
                </div>
            </div>
        </div>
        <a href="<?php echo base_url("flags/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau flag</a>
    </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('#tableData').DataTable({
			destroy: true,
			responsive: true,
			paging: true,
			searching: true,
			lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "Tout"]],
			language: {
				"lengthMenu": "Afficher _MENU_ lignes par page",
				"search": "Rechercher:",
				"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
				"processing": "<img src='img/loading.gif'> Loading...",
			},
			iDisplayLength: 25,
			columnDefs: [
				{ responsivePriority: 1, targets: 0 },
				{ responsivePriority: 2, targets: -1 }
			]
		});
	});
</script>