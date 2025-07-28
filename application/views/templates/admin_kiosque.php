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
                <h4 class="card-title">Liste kiosques</h4>
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
					            <th>Nom</th>
					            <th>Dimension</th>
					            <th>Status</th>
					            <th>Opérations</th>
					        </tr>
					    </thead>
					    
					    <tbody>

					    <?php foreach($kiosques as $kiosque): ?>
					    	<?php $dimension = $kiosque->dimension == 1 ? "GM" : "PM"; ?>
					    	<?php $status 	 = $kiosque->status == 1 ? "Actif" : "Inactif"; ?>
					        <tr>
					            <td><?php echo $kiosque->nom_kiosque ?></td>
					            <td><?php echo $dimension ?></td>
					            <td><?php echo $status ?></td>
					            <td>
					            	<?php echo anchor("kiosque/edit/".$kiosque->id, '<i class="icon-edit" title="Editer"></i>','data-edit="'.$kiosque->id.'"') ;?>&nbsp;
                                	<?php echo anchor("kiosque/delete/".$kiosque->id, '<i class="icon-android-delete" title="Supprimer"></i>','data-toggle="modal" data-target="#default-'.$kiosque->id.'" onclick="return false;"') ;?>

                                	<div class="modal fade text-xs-left" id="default-<?php echo $kiosque->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
											<div class="modal-content">
											  	<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
													<h4 class="modal-title" id="myModalLabel1">Confirmation</h4>
											  	</div>
											  	<div class="modal-body">
													<p>Voulez-vous vraiment supprimer le kiosque <b><?php echo $kiosque->nom_kiosque; ?></b> ?</p>
											  	</div>
											  	<div class="modal-footer">
													<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
													<a href="<?php echo base_url("kiosque/delete/".$kiosque->id) ?>" target="_self" class="btn btn-outline-primary">Supprimer</a>
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
        </div>
        <a href="<?php echo base_url("kiosque/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau kiosque</a>
    </div>
</div>
