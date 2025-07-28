<?php 
$hide = array("id", "status");
$count = count($campagnes) > 1 ? count($campagnes) . " items" : count($campagnes) . " item"; 

$this->session->set_flashdata('result', $campagnes);

?>

<?php if($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>

<div class="row">
<h1>USER</h1>
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
			    <h4 class="card-title">Campagnes <span id="countItem"><?php echo $count; ?></span></h4>
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
									<button style="border: none; display: none; background: transparent; font-size: 14px;" id="selectAll">
										<i class="far fa-square"></i>  
									</button>
								</th>
								
								<?php foreach($campagnes as $key => $value) : ?>
									<?php foreach($value as $keyCol => $valueCol) : ?>
										<?php if(!is_array($valueCol) && !in_array($keyCol, $hide)) : ?>
											<th><strong><?php echo ucfirst($keyCol) ?></strong></th>
										<?php endif ?>
									<?php endforeach ?>
									<?php break; ?>
								<?php endforeach ?>
								<th>Actions</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($campagnes as $keyRow => $valueRow) : ?>
							<tr data-id="<?php echo $valueRow->id ?>">
								<td></td>
								
								<?php foreach($valueRow as $keyCol => $valueCol) : ?>
									<?php if(!is_array($valueCol) && !in_array($keyCol, $hide)) : ?>
										<td><?php echo $valueCol ?></td>
									<?php endif; ?>
								<?php endforeach; ?>
								
								
								<td>
									<span class="actions action-delete"><a href="campagnes/delete/<?php echo $valueRow->id ?>"><i class="far fa-trash-alt"></i>Supprimer</a></span>
									<span class="actions action-edit" data-id="<?php echo $valueRow->id ?>" data-toggle="modal" data-target="#inlineMaj"><i class="far fa-edit"></i>Editer</span>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					
					<div style="margin-bottom: 20px;">
						<button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
					</div>
					
				</div>
			</div>
			
			<div class="modal fade text-xs-left" id="inlineMaj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">MAJ Campagne</h2>
						</div>
						<div id="modal-form-edit"></div>
					</div>
				</div>
			</div>
			
			<div class="modal fade text-xs-left" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouvelle campagne</h2>
						</div>
						<div id="modal-form-new">
						
							<!--<form action="<?php //echo base_url("visuels/new") ?>" enctype="multipart/form-data" method="post" id="majCampagne">-->
							<?php echo form_open('visuels/new'); ?>
								<div class="modal-body">
									<div class="form-group">
										<label for="label">Nom <?php echo form_error('label', '<span class="error">', '</span>'); ?></label>
										<?php echo form_input('label', '', 'id="label" class="form-control" required'); ?>
									</div>
									
									<div class="form-group">
										<label for="date_visuel">Date début <?php echo form_error('date_visuel', '<span class="error">', '</span>'); ?></label>
										<div class="position-relative has-icon-left">
											<?php //echo form_input(["type" => "date", "name" => "date_visuel"], $data->date_visuel, 'class="form-control"', 'required'); ?>
											<?php echo form_input(["type" => "date", "name" => "date_visuel", "id" => "date_visuel" ], '', 'class="form-control" required'); ?>
											<div class="form-control-position">
												<i class="icon-calendar5"></i>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label for="date_visuel">Date début <?php echo form_error('date_visuel', '<span class="error">', '</span>'); ?></label>
										<div class="position-relative has-icon-left">
											<?php //echo form_input(["type" => "date", "name" => "date_visuel"], $data->date_visuel, 'class="form-control"', 'required'); ?>
											<?php echo form_input(["type" => "date", "name" => "date_visuel", "id" => "date_visuel" ], '', 'class="form-control" required'); ?>
											<div class="form-control-position">
												<i class="icon-calendar5"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="Fermer">
									<input type="submit" class="btn btn-outline-primary btn-lg" value="Ajouter">
								</div>
							</form>
							
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php
//$myDateTime = DateTime::createFromFormat('Y-m-d', $dateString);
//$newDateString = $myDateTime->format('d-m-Y');
?>

<!--<input type="hidden" onclick="" name="exportdata" value="<?php //echo base64_encode(addslashes(json_encode($result))); ?>" />-->

<script type="text/javascript">
$(function() {
	var $dataTable = $('#tableData').DataTable({
		destroy: true,
		responsive: false,
		paging: true,
		searching: true,
		scrollX: true,
		select: true,
		//autoFill: true,
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
		language: {
			"lengthMenu": "Afficher _MENU_ lignes par page",
			"search": "Rechercher:",
			"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
		},
		columnDefs: [{
			orderable: false,
			className: 'select-checkbox',
			targets: 0
		}],
		select: {
			style: 'os',
			selector: 'td:first-child'
		},
		order: [[ 1, 'asc' ]]
	});			
				
	$('#selectAll').click(function() {
		if ($dataTable.rows({selected: true}).count() > 0) {
			$dataTable.rows().deselect();
			$("input[type=checkbox]").prop("checked", false);
			return;
		}
		$("input[type=checkbox]").prop("checked", true);
		$dataTable.rows().select();
	});
				
	$dataTable.on('select deselect', function(e, dt, type, indexes) {
		var $selected = null;
		var $checkedIds = [];
		if (type === 'row') {
			// We may use dt instead of myTable to have the freshest data.
			if (dt.rows().count() === dt.rows({selected: true}).count()) {
				// Deselect all items button.
				$('#selectAll i').attr('class', 'far fa-check-square');
				//return;
			} else if (dt.rows({selected: true}).count() === 0) {
				// Select all items button.
				$('#selectAll i').attr('class', 'far fa-square');
				//return;
			} else {
				// Deselect some items button.
				$('#selectAll i').attr('class', 'far fa-minus-square');
			}
			
			$selected = dt.rows({selected: true});
		}
		
		$selected.every(function (rowIdx, tableLoop, rowLoop) {
			//$(this.node()).addClass('selectedfsdfsdf');
			
			$(this.node()).map(function(){
				$checkedIds.push($(this).data("id"));
			}).get();
		});
		
		console.log($checkedIds);
	});
	
	$('#tableData').on('click', 'tbody td span.action-edit', function(e){
		var $data = $(this).data("id");
		//console.log($data);
		//alert('Edit ' + data[0]);
		$.ajax({
			url: 'campagnes/edit',
			data: "id=" + $data,
			type: 'post',
			success: function(data) {
				$("#modal-form-edit").html(data);
			},
			error: function(data) {
				$("#modal-form-edit").html("<p>Error</p>");
			}
		});
	});
});
</script>