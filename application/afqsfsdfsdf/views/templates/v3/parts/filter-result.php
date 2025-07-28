<?php 
$tableHeader = array();
foreach($result as $keyRow => $valueRow) {
	foreach($valueRow as $keyCol => $valueCol) {
		$tableHeader[] = $keyCol;
	}
	break;
}

$hide = array("id", "longitude", "latitude", "commentaire", "status", "hm_visuel_campagne");
$count = count($result) > 1 ? count($result) . " items" : count($result) . " item"; 

$this->session->set_flashdata('result', $result);
$this->session->set_flashdata('filters', $filters); 

//datadump($filters);
?>

<div class="row">
	<div class="col-lg-12">

		<div class="card">

			<div class="card-header">
			    <h4 class="card-title">Liste <span id="countItem"><?php echo $count; ?></span></h4>
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
							<tr>
								
								<th>
									<button style="border: none; background: transparent; font-size: 14px;" id="selectAll">
										<i class="far fa-square"></i>  
									</button>
									
								</th>
								
								<?php foreach($tableHeader as $keyCol => $valueCol) : ?>
									<?php if(!is_array($valueCol) && !in_array($valueCol, $hide)) : ?>
										<th><strong><?php echo ucfirst($valueCol) ?></strong></th>
									<?php endif ?>
								<?php endforeach ?>
								
								<?php if(count($campagnes) >= 1) : ?>
									<?php foreach($campagnes as $campagne) : ?>
										<th><?php echo $campagne->label ?></th>
									<?php endforeach ?>
								<?php endif ?>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($result as $keyRow => $valueRow) : ?>
							<tr data-id="<?php echo $valueRow->id ?>">
								
								<td>
									<!--<input type="checkbox" class="bulkaction" id="row-<?php //echo $keyRow ?>" data-action="<?php //echo $keyRow ?>" title="<?php //echo $keyRow ?>" name="bulkaction[]"/>
									<input type="checkbox" class="checkbox" />-->
								</td>
								
								
								<?php foreach($valueRow as $keyCol => $valueCol) : ?>
									<?php if(!is_array($valueCol) && !in_array($keyCol, $hide)) : ?>
										<td><?php echo $valueCol ?></td>
									<?php endif; ?>
								<?php endforeach; ?>
								
								<?php if(count($campagnes) >= 1) : ?>
									<?php $campagnes = json_decode($valueRow->hm_visuel_campagne, true); ?>
									<?php foreach($campagnes as $keyCampagne => $campagne) : ?>
										<?php //$campagneVisuelArray = json_decode($campagne->data, true); ?>
										<td><?php echo $campagne ?></td>
									<?php endforeach ?>
								<?php endif ?>
								
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="btnControls">
			    <!--<a href="<?php //echo base_url("panneau/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau panneau</a>-->
			    <!--<button href="#" target="_self" class="btn btn-success" id="selectAll">Tout selectionner</button>-->
				
				
			    <a href="<?php echo base_url("panneau/add") ?>" target="_self" class="btn btn-success" id="dataExport">Ajouter</a>
			    <a href="<?php echo base_url("export") ?>" target="_self" class="btn btn-success" id="dataExport">Exporter XLS</a>
			    
				<button class="btn btn-success massAction maj_campagne" id="maj_campagne" data-toggle="modal" data-target="#inlineMaj" >Mettre à jour <span>(0 élément)</span></button>
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
							
							<input type="hidden" name="panneaux_ids" value="" placeholder="Panneaux IDs" class="form-control" readonly="readonly">
							<!--
							<div class="form-group">
								<div class="form-group">
									<label for="panneau_visuel_actuel">Select Campagne</label>
									<?php //end($campagnes); ?>
									<?php //$selected = key($campagnes); ?>
									<?php //echo form_dropdown('campagne_id', $campagnes, $selected, 'class="form-control select"'); ?>
								</div>
							</div>
							-->
							
							<div class="form-group">
								<div class="form-group">
									<label for="panneau_visuel_actuel">Select Visuel</label>
									<?php echo form_dropdown('visuel_id', $visuels, '', 'class="form-control select"'); ?>
								</div>
							</div>
												
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