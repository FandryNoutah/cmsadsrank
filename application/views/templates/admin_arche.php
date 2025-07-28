<div class="row">
    <div class="col-xs-12">
   
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
                <h4 class="card-title">Liste arches</h4>
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
                    <table id="example" class="table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
					    <thead>
					        <tr>
					            <th>#</th>
					            <th>Formats</th>
					            <th>Emplacement</th>
					            <th>Province</th>
					            <th>Visuel</th>
					            <th>Opérations</th>
					        </tr>
					    </thead>
					    
					    <tbody>

					    <?php foreach($arches as $arche): ?>
					    	<?php //$dimension = $arche->dimension == 1 ? "GM" : "PM"; ?>
					    	<?php //$status 	 = $arche->status == 1 ? "Actif" : "Inactif"; ?>
					        <tr>
					            <td><?php echo $arche->id ?></td>
					            <td><?php echo $arche->hm_arche_format ?></td>
					            <td><?php echo $arche->hm_arche_emplacement ?></td>
					            <td><?php echo $arche->hm_arche_province ?></td>
					            <td>
					            	<?php echo $arche->hm_arche_visuel ?>
					            	<?php if($arche->hm_arche_visuel_path): ?>
					            		<br/>
					            		<img width="120" src="<?php echo base_url($arche->hm_arche_visuel_path); ?>" />
					            	<?php endif; ?>	
					            </td>
					            
					            <td>
					            	<?php echo anchor("arche/edit/".$arche->id, '<i class="icon-edit" title="Editer"></i>','data-edit="'.$arche->id.'"') ;?>&nbsp;
                                	<?php echo anchor("arche/delete/".$arche->id, '<i class="icon-android-delete" title="Supprimer"></i>','data-toggle="modal" data-target="#default-'.$arche->id.'" onclick="return false;"') ;?>

                                	<div class="modal fade text-xs-left" id="default-<?php echo $arche->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
											<div class="modal-content">
											  	<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
													<h4 class="modal-title" id="myModalLabel1">Confirmation</h4>
											  	</div>
											  	<div class="modal-body">
													<p>Voulez-vous vraiment supprimer l'arche ?</p>
											  	</div>
											  	<div class="modal-footer">
													<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
													<a href="<?php echo base_url("arche/delete/".$arche->id) ?>" target="_self" class="btn btn-outline-primary">Supprimer</a>
											  	</div>
											</div>
									  	</div>
									</div>
					            </td>
					        </tr>
					    <?php endforeach; ?>

					    </tbody>
					</table>
                </div>
            </div>
			<?php foreach($users_groups as $groups): ?>	
			 <?php if($groups->id == 1){ ?> 
        </div>
        <a href="<?php echo base_url("arche/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouvel arche</a>
    <?php endforeach; ?>
	</div>
</div>
