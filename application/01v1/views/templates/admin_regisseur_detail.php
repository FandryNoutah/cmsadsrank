<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style3.css") ?>">
</head>
<body>
<?php //echo  datadump($regisseurs); //die(); ?>
<?php //echo  datadump($regisseurs); //die(); ?>

<div class="yes">
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
						<?php //foreach ($regisseurs as $regisseur): ?>
						<div class="medialist col-xl-6 col-lg-6 col-sm-12">
							<div class="medialist-container">
								<a class="media-left" href="<?php echo base_url($regisseur->logo) ?>">
									<img class="media-object" src="<?php echo base_url($regisseur->logo) ?>" title="<?php echo $regisseur->label ?>" alt="<?php echo $regisseur->label ?>" style="width: 120px;height: 120px;" />
								</a>
								<div class="media-body">
									<h4 class="card-header text-center  text-uppercase" style="color:#56ad56"><?php echo $regisseur->label ?></h4>
									<h5 class="text-danger-200" style="color:#565899" ><?php echo $regisseur->telephone ?></h5>
									<h5 class="text-bold-200" style="color:#565899" ><?php echo $regisseur->email ?></h5>
									<p><?php echo $regisseur->commentaires ?></p>
									<h5 style="color:blue" >Date debut contrat: <?php echo $regisseur->DateDebut ?></h5><h5 style="color:blue"> Date fin contrat: <?php echo $regisseur->DateFin ?> </h5> 
									<h5 style="color:#565899 " >Information sur le contrat:</h5> <?php echo $regisseur->information ?></h5>
									<h3>Panneaux:</h3>
									<h5 class="text-bold-200" style="color:#565899" >Prix Panneaux 12 *3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->p12a3 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Panneaux 12 *6:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->p12a6 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Panneaux  4 * 3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->p4a3 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Panneaux  6 * 3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->p6a3 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Panneaux  6 * 6:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->p6a6 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Panneaux  8 * 3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->p8a3 ?>Ar</h5>
									
									<h3 class="center">Murs:</h3>
																	
									<h5 class="text-bold-200" style="color:#565899" >Prix Murs 12 *3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->m12a3 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Murs 12 6:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->m12a6 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Murs  4 * 3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->m4a3 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Murs  6 * 3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->m6a3 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Murs  6 * 6:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->m6a6 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Murs  8 * 3:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->m8a3 ?>Ar</h5>
									<h3 class="center">WLB:</h3>
									
									<h5 class="text-bold-200" style="color:#565899" >Prix WLB 3 * 3:....</h5><h5 class="text-bold-200" style="color:RED"> <?php echo $regisseur->w3a3 ?>Ar</h5>
								
									<h3 class="center">FLAGS:</h3>
									<h5 class="text-bold-200" style="color:#565899" >GM: </h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->flagsgm ?>Ar</h5> 
									<h5 class="text-bold-200" style="color:#565899" >PM: </h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->flagpm ?>Ar</h5> 
								
									<h3 class="center">Arches:</h3>
									<h5 class="text-bold-200" style="color:#565899" >Prix Arches  15 * 25:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->a15a25 ?>Ar</h5>
									<h5 class="text-bold-200" style="color:#565899" >Prix Arches  15 * 2:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->a15a2 ?>Ar</h5>
									
									<h3 class="center">Kiosque:</h3>
									<h5 class="text-bold-200" style="color:#565899" >Kiosque:....</h5><h5 class="text-bold-200" style="color:RED"  ><?php echo $regisseur->kiosque ?>Ar</h5>
									
								</div>
								<?php echo anchor("regisseur/edittarifs/".$regisseur->id, 'Metre à jour tarifs <i class="icon-edit" title="Editer"></i>','data-edit="'.$regisseur->id.'"') ;?>&nbsp;

								<div class="operations">
					           
                                	<div class="modal fade text-xs-left" id="default-<?php echo $regisseur->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									  	<div class="modal-dialog" role="document">
											<div class="modal-content">
											  	<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">é</span>
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
								
							
						</div>
					<?php //endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
</body>