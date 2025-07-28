


<?php 
$hide = array("id", "status");
$count = count($visuels) > 1 ? count($visuels) . " items" : count(visuels) . " item"; 

$this->session->set_flashdata('result', $visuels);

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
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
			    <h4 class="card-title">Visuels <span id="countItem"><?php echo $count; ?></span></h4>
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
								
								<?php foreach($visuels as $key => $value) : ?>
									<?php foreach($value as $keyCol => $valueCol) : ?>
										<?php if(!is_array($valueCol) && !in_array($keyCol, $hide)) : ?>
											<th><strong><?php echo ucfirst($keyCol) ?></strong></th>
										<?php endif ?>
									<?php endforeach ?>
									<?php break; ?>
								<?php endforeach ?>
								<th>Fiche</th>
								<th>Actions</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($visuels as $keyRow => $valueRow) : ?>
							<tr data-id="<?php echo $valueRow->id ?>">
								<td></td>
								
								<?php foreach($valueRow as $keyCol => $valueCol) : ?>
									<?php if(!is_array($valueCol) && !in_array($keyCol, $hide)) : ?>
										<td>
											<a href="<?php echo $valueRow->logo ?>">
											<?php
												echo $keyCol != 'logo' ? $valueCol : '<img width="100" src="' . base_url($valueCol) . '" />'
											?>
											</a>
										</td>
									<?php endif; ?>
								<?php endforeach; ?>
								
								<td><?php echo anchor("visuels/visuelConcurrent/".$valueRow->id, '<h5>Afficher Concurrent Visuels</h5><i  class="button" title="visuelConcurrent"></i>','data-edit="'.$valueRow->id.'"') ;?>&nbsp;</td>
								
								<td>
									<span class="actions action-delete" style="color: red"><a href="visuels/delete/<?php echo $valueRow->id ?>"><i class="far fa-trash-alt"></i>Supprimer</a></span>
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
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">MAJ Visuel</h2>
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
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau Visuel</h2>
						</div>
						<div id="modal-form-new">
						
							<!--<form action="<?php //echo base_url("visuels/new") ?>" enctype="multipart/form-data" method="post" id="majCampagne">-->
							<form action="<?php echo base_url("visuels/insert_visuels") ?>" enctype="multipart/form-data" method="post" id="majCampagne" enctype="multipart/form-data">
							  <fieldset>
								<div class="form-group">
								  <label for="exampleInputEmail1">Nom </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="label">
								 </div>
								<div class="form-group">
								  <label for="exampleInputEmail1">Date visuels </label>
								  <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_visuel">
								</div> 
								<br>
								<div class="form-group">
									<label for="exampleInputEmail1">Logo </label>
									<br>
									<input type="file" name="logo">
								</div>
								<div class="form-group">
								<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
							  </fieldset>
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
		// Prevent event propagation
		//e.stopPropagation();
		var $row = $(this).closest('tr');
		//var $data = $dataTable.row($row).data();
		//$data.unshift($(this).data("id"));
		var $data = $(this).data("id");
		//console.log($data);
		//alert('Edit ' + data[0]);
		$.ajax({
			url: 'visuels/edit',
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
	
	/*
	$('.action-new').on('click', function(e){
		$.ajax({
			url: 'visuels/new',
			data: "id=" + $data,
			type: 'post',
			success: function(data) {
				$("#modal-form").html(data);
			},
			error: function(data) {
				$("#modal-form").html("<p>Error</p>");
			}
		});
	});
	
	$('#tableData').on( 'click', 'tbody tr', function () {
		alert($dataTable.row(this).id);
		$dataTable.row(this).edit();
	});
	*/
});
</script>