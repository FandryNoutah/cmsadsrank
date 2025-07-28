
<?php //datadump($visuels); ?>
<?php //datadump($filters); die("end"); ?>
<?php //datadump($campagnes); ?>

<?php $hide = array("id", "status", "panneau_visuel_actuel", "panneau_emplacement", "panneau_visuel_actuel_path", "panneau_autres_images", "panneau_date_pose", "visuel_id", "campagne_id"); ?>
<?php $count = count($result) > 1 ? count($result) . " items" : count($result) . " item"; ?>

<?php $this->session->set_flashdata('result', $result); ?>
<?php $this->session->set_flashdata('filters', $filters); ?>

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
					            <th>Emplacement</th>
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

					    <?php foreach($result as $flag): ?>
							<?php $pos1 = strpos($flag->etat_bache, ","); ?>
							<?php $pos2 = strpos($flag->etat_poteau, ","); ?>
							<?php $pos3 = strpos($flag->etat_bache, ","); ?>
					        <tr>
					            <td><?php echo $flag->id ?></td>
					            <td><?php echo $flag->reference ?></td>
					            <td><?php echo $flag->visuel_actuel ?></td>
					            <td><?php echo $flag->quartier ?></td>
					            <td><?php echo $flag->emplacement ?></td>
					            <td><?php echo $flag->ville ?></td>
					            <td><?php echo $flag->axe ?></td>
					            <!--<td><?php //echo $flag->etat_bache . "---> " . $pos; ?></td>-->
								
								<td>
									<?php
										$i = 0;
										if($flag->etat_bache !== "") {
											if($pos1 == null) {
												echo $filters["_etat_bache"][$flag->etat_bache];
											} else {
												$etats = explode(",", $flag->etat_bache);
												foreach($etats as $etat) {
													echo $filters["_etat_bache"][$etat];
													if($i < count($etats) - 1) echo ", ";
													$i++;
												}
											}
										}
									?>
								</td>
					            
					            <td>
									<?php
										$i = 0;
										if($flag->etat_poteau !== "") {
											if($pos2 == null) {
												echo $filters["_etat_poteau"][$flag->etat_poteau];
											} else {
												$etats = explode(",", $flag->etat_poteau);
												foreach($etats as $etat) {
													echo $filters["_etat_poteau"][$etat];
													if($i < count($etats) - 1) echo ", ";
													$i++;
												}
											}
										}
									?>
								</td>
								
					            <td>
									<?php
										$i = 0;
										if($flag->etat_armature !== "") {
											if($pos2 == null) {
												echo $filters["_etat_armature"][$flag->etat_armature];
											} else {
												$etats = explode(",", $flag->etat_armature);
												foreach($etats as $etat) {
													echo $filters["_etat_armature"][$etat];
													if($i < count($etats) - 1) echo ", ";
													$i++;
												}
											}
										}
									?>
								</td>
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