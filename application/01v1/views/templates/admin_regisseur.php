<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style3.css") ?>">
</head>
<body>


<div class="row match-height">
	<div class="col-xl-12 col-lg-12">

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
				<h4 class="card-title">Régisseurs</h4>
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
				<div class="card-block">
					<div class="media-list row">
						<?php foreach ($regisseurs as $regisseur): ?>
						<div class="medialist col-xl-6 col-lg-6 col-sm-12">
							<input type="hidden" name="id" value="<?php echo $regisseur->id; ?>" />
							<div class="medialist-container">
								<a class="media-left" href="<?php echo base_url($regisseur->logo) ?>">
									<img  class="media-object" src="<?php echo base_url($regisseur->logo) ?>" title="<?php echo $regisseur->label ?>" alt="<?php echo $regisseur->label ?>" style="width: 120px;height: 120px;" /> 
								</a>
								<div class="media-body">
									<h4 class="card-header text-center  text-uppercase" style="color:#56ad56"><?php echo $regisseur->label ?></h4>
									<h5 class="text-danger-200" style="color:#565899" ><?php echo $regisseur->telephone ?></h5>
									<h5 class="text-bold-200" style="color:#565899" ><?php echo $regisseur->email ?></h5>
									<p><?php echo $regisseur->commentaires ?></p>
									<h5 style="color:blue" >Date debut contrat: <?php echo $regisseur->DateDebut ?></h5><h5 style="color:blue"> Date fin contrat: <?php echo $regisseur->DateFin ?> </h5> 
									<h5 style="color:#565899 " >Information sur le contrat:</h5> <?php echo $regisseur->information ?></h5>
								
									<?php echo anchor("regisseur/detail/".$regisseur->id, '<h3>Tarifs Regisseur</h3><i  class="button" title="Detail"></i>','data-edit="'.$regisseur->id.'"') ;?>&nbsp;
								</div>

								<div class="operations">
					            	<?php echo anchor("regisseur/edit/".$regisseur->id, '<i class="icon-edit" title="Editer"></i>','data-edit="'.$regisseur->id.'"') ;?>&nbsp;
                                	<?php echo anchor("regisseur/delete/".$regisseur->id, '<i class="icon-android-delete" title="Supprimer"></i>','data-toggle="modal" data-target="#default-'.$regisseur->id.'" onclick="return false;"') ;?>

                                	<div class="modal fade text-xs-left" id="default-<?php echo $regisseur->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
											<div class="modal-content">
											  	<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">×</span>
													</button>
													<h4 class="modal-title" id="myModalLabel1">Confirmation</h4>
											  	</div>
											  	<div class="modal-body">
													<p>Voulez-vous vraiment supprimer le régisseur <b><?php echo $regisseur->label ?></b> ?</p>
											  	</div>
											  	<div class="modal-footer">
													<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
													<a href="<?php echo base_url("regisseur/delete/".$regisseur->id) ?>" target="_self" class="btn btn-outline-primary">Supprimer</a>
											  	</div>
											</div>
									  	</div>
									</div>
									
								</div>
								
							</div>
								<div >
					            	
                             
								</div>	
							
						</div>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<a href="<?php echo base_url("regisseur/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau régisseur</a>
	</div>
</div>

</body>