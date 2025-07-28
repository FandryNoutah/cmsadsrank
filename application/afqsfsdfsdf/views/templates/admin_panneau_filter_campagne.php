<?php //datadump($filters["_visuels"]); die();?>
<?php //datadump($datapost); ?>
<h1><?php //echo sizeof($result); ?></h1>
<?php //datadump($result); ?>
<?php //die(); ?>

<?php //datadump($visuels); ?>
<?php //datadump($campagnes); ?>

<?php $hide = array("id", "status", "panneau_visuel_actuel", "panneau_emplacement", "panneau_visuel_actuel_path", "panneau_autres_images", "panneau_date_pose", "visuel_id", "campagne_id"); ?>
<?php $count = count($result) > 1 ? count($result) . " items" : count($result) . " item"; ?>

<?php $this->session->set_flashdata('result', $result); ?>
<?php $this->session->set_flashdata('filters', $filters); ?>

<div class="row">
	<div class="col-lg-12">
		

	
	
		<div class="card">

			<div class="card-header">
			    <h4 class="card-title">Liste Panneaux <span id="countItem"><?php echo $count; ?></span></h4>
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
				<div class="table-responsive" id="">
					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
						<thead>
							<?php foreach($result as $keyRow => $panneauRow) : ?>
								<tr>
									<td>
										<label for="selectAll">Action</label>
										<input type="checkbox" class="" id="selectAll" data-action="" name="bulkactionHandler" /></td>
									<?php foreach($panneauRow as $keyCol => $panneauCol) : ?>
										<?php if(!is_array($panneauCol) && !in_array($keyCol, $hide)) : ?>
											<td><strong><?php echo format_col_header($keyCol) ?></strong></td>
										<?php endif ?>
									<?php endforeach ?>
									
									<?php $cellCount = 0; ?>
									<?php foreach($filters["_campagnes"] as $key => $value) : ?>
										<?php $borderColor = $cellCount == 0 ? "border-left: 1px solid #000" : ""; ?>
										<td style="background-color: darkgray;<?php echo $borderColor; ?>"><strong><?php echo $value["panneau_campagne_nom"] ?></strong></td>
										<?php $cellCount++; ?>
									<?php endforeach ?>
								</tr>
								<?php break; ?>
							<?php endforeach ?>
						</thead>
						
						<tbody>
							<?php foreach($result as $keyRow => $panneauRow) : ?>
							
								<tr data-id="<?php echo $keyRow ?>">
									<td>
										<input type="checkbox" class="bulkaction" id="row-<?php echo $keyRow ?>" data-action="<?php echo $keyRow ?>" title="<?php echo $keyRow ?>" name="bulkaction[]"/>
									</td>
									<?php foreach($panneauRow as $keyCol => $panneauCol) : ?>
									
										<?php if(!is_array($panneauCol) && !in_array($keyCol, $hide)) : ?>
											<?php
												switch ($keyCol) {
													case 'panneau_format':
														$panneauCol = $filters["panneau_format"][$panneauCol]["label"];
														break;
													case 'panneau_type':
														$panneauCol = $filters["panneau_type"][$panneauCol]["label"];
														break;
													case 'panneau_province':
														$panneauCol = $filters["panneau_province"][$panneauCol]["label"];
														break;
													case 'panneau_axe':
														$panneauCol = $filters["panneau_axe"][$panneauCol]["label"];
														break;
													case 'panneau_sam':
														$panneauCol = $filters["panneau_sam"][$panneauCol]["label"];
														break;
													case 'panneau_regisseur':
														$panneauCol = $filters["panneau_regisseur"][$panneauCol]["label"];
														break;
													case 'panneau_cout_impression':
													case 'panneau_cout_pose_finition':
													case 'panneau_cout_location':
														$panneauCol = "Ar " . number_format(intval($panneauCol), 0, '', '.');
														break;
													case 'panneau_couverture_4g':
														$panneauCol = $filters["panneau_couverture_4g"][$panneauCol];
														break;
													case 'panneau_couverture_fo':
														$panneauCol = $filters["panneau_couverture_fo"][$panneauCol];
														break;
													case 'panneau_couverture_adsl':
														$panneauCol = $filters["panneau_couverture_adsl"][$panneauCol];
														break;
													default:
														break;
												}
											?>
											<td><?php echo $panneauCol ?></td>
											
											
											
											
											<?php else: if(is_array($panneauCol)): ?>
												<?php //foreach($panneauCol as $keyVisuels => $valueVisuels) : ?>
													<!--<td><strong><?php //if($valueVisuels["visuel_id"] != 0) echo $filters["_visuels"][$valueVisuels["visuel_id"]]["panneau_visuel_name"] ?></strong></td>-->
												<?php //endforeach ?>

												<?php //for($i = 1; $i <= count($filters["_campagnes"]); $i++): ?>
												<?php $cellCount = 0; ?>
												<?php foreach($filters["_campagnes"] as $k_id => $id_campagne): ?>
													<?php $borderColor = $cellCount == 0 ? "border-left: 1px solid #000" : ""; ?>
													<td style="background-color: lightgray;<?php echo $borderColor; ?>">
													
														<?php 
																						
															$idd = isset($panneauCol[$k_id]) ? $panneauCol[$k_id]["visuel_id"] : null;
															
															
															
															$visuel_array = (isset($filters["visuel_id"]) && $idd) ? $filters["visuel_id"][$idd] : array();
															//$visuel_name = ($visuel_array && isset($visuel_array["panneau_visuel_name"])) ? $visuel_array["panneau_visuel_name"] : "no_visuel"; 
															$visuel_name = ($visuel_array && isset($visuel_array["panneau_visuel_name"])) ? $visuel_array["panneau_visuel_name"] : "no_visuel"; 

														?>
													
														<?php $valueData = (isset($panneauCol[$k_id]["visuel_id"]) && $panneauCol[$k_id]["visuel_id"] != 0) ? $visuel_name : "-"; ?>
														<?php echo $valueData; ?>
													</td>
													<?php $cellCount++; ?>
												<?php endforeach ?>


												<?php endif ?>
										<?php endif ?>
									<?php endforeach ?>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="btnControls">
			    <!--<a href="<?php //echo base_url("panneau/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau panneau</a>-->
			    <a href="<?php echo base_url("panneau/add") ?>" target="_self" class="btn btn-success" id="dataExport">Ajouter</a>
			    <a href="<?php echo base_url("export") ?>" target="_self" class="btn btn-success" id="dataExport">Exporter XLS</a>
			    
				<button class="btn btn-success massAction maj_campagne" id="maj_campagne" data-toggle="modal" data-target="#inlineMaj" >Mettre à jour <span>(0 élément)</span></button>
				<!--<div class="btn-group">
					<button type="button" class="btn btn-success massAction">Mass Action <span>(0 éléménts)</span></button>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					</button>
					<div class="dropdown-menu">
						<a class="dropdown-item maj_campagne" id="maj_campagne" data-toggle="modal" data-target="#inlineMaj" >Màj visuel</a>
						<a class="dropdown-item" href="#">Mettre à jour</a>
						<a class="dropdown-item" href="#">Mettre à jour</a>
						<a class="dropdown-item" href="#">Mettre à jour</a>
					</div>
				</div>-->
			</div>
			
			
			
			<!-- MODAL -->
			<div class="modal fade text-xs-left" id="inlineMaj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title text-text-bold-600" id="myModalLabel33">Ajout Campagne-Visuel</h2>
						</div>
						<form action="<?php echo base_url("panneau/majcampagne") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
						  <div class="modal-body">
							<!--
							<label><strong>Campagne :</strong> <?php echo "Campagne St Valentin 2017" ?></label>
							<div class="form-group">
								<input type="hidden" name="panneaux_ids" value="" placeholder="Panneaux IDs" class="form-control" readonly="readonly">
							</div>
							-->

							<input type="hidden" name="panneaux_ids" value="" placeholder="Panneaux IDs" class="form-control" readonly="readonly">
							
							<div class="form-group">
								<div class="form-group">
									<label for="panneau_visuel_actuel">Select Campagne</label>
									<?php end($campagnes); ?>
									<?php $selected = key($campagnes); ?>
									<?php echo form_dropdown('campagne_id', $campagnes, $selected, 'class="form-control select"'); ?>
								</div>
							</div>
							
							<div class="form-group">
								<div class="form-group">
									<label for="panneau_visuel_actuel">Select Visuel</label>
									<?php echo form_dropdown('visuel_id', $visuels, '', 'class="form-control select"'); ?>
								</div>
							</div>
							
							<!--
							<label><strong>Visuel :</strong> <?php echo "Select Visuel" ?></label>
							<div class="form-group">
								<input type="hidden" name="visuel_id" value="" placeholder="Visuel ID" class="form-control" readonly="readonly">
							</div>
							-->
												
						  </div>
						  <div class="modal-footer">
							<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
							<input type="submit" class="btn btn-outline-primary btn-lg" value="Mettre à jour">
						  </div>
						</form>
					</div>
				</div>
			</div>
			<!-- MODAL -->
			
			
			
			
		</div>
	</div>
</div>

<input type="hidden" onclick="" name="exportdata" value="<?php echo base64_encode(addslashes(json_encode($result))); ?>" />