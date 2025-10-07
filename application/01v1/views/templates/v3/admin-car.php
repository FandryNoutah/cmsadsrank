




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
			    <h4 class="card-title">Gestion car <span id="countItem"><?php  ?></span></h4>
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
			<h5>Nombre de Car :<?php  echo count($liste_car); ?></h5>
				
			<div class="card-body collapse in">
	    		<div class="card-block card-dashboard"></div>
				<div class="table-responsive" id="">
					
					

					
					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
						<thead>
							<tr>
								
								
								<th></th>
								<th>Axes</th>
								<th>Nombre de place</th>
								<th>Prix/jours</th>
								
								<th>Préstataire</th>
								<th>Nom Chauffeur</th>
								<th>Numero Chauffeur</th>
								<th>Numero voiture</th>
								<th>Marque</th>
								<th>Fichce</th>
								<th>Actions</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($liste_car as $C){ ?>	
							<tr>
										<td></td>
										<td><?php echo $C['Nom']; 	?> </td>
										<td><?php echo $C['Nombre_place']; 	?> </td>
										<td><?php echo $C['Prix_jour']; 	?> </td>
										<td><?php echo $C['Prestataire']; 	?> </td>
										<td><?php echo $C['Nom_chauffeur']; 	?> </td>
										<td><?php echo $C['Numero_chauffeur']; 	?> </td>
										<td><?php echo $C['Numero_voiture']; 	?> </td>
										<td><?php echo $C['Marque']; 	?> </td>		
		
										
										<td ><?php echo anchor("Car/fiche_car/".$C['id_Car'], '<h6 class="btn btn-info">Fiche Car</h6><i  title="visuelConcurrent"></i>','data-edit="'.$C['id_Car'].'"') ;?></td>
										<td > <?php echo anchor("Car/update_car/".$C['id_Car'], '<h6 class="btn btn-success">Modifier</h6><i  class="button" title="visuelConcurrent"></i>','data-edit="'.$C['id_Car'].'"') ;?>
										<?php echo anchor("Car/delete_car/".$C['id_Car'], '<h6 class="btn btn-danger">Suprimer</h6><i  class="button" title="visuelConcurrent"></i>','data-edit="'.$C['id_Car'].'"') ;?>
										</td>
								
									
							</tr>
							<?php } ?>								
						</tbody>
						
								
					</table>
				
					<div style="margin-bottom: 20px;">
						<button class="actions action-edit" data-toggle="modal" data-target="#inlineNew"><i class="far fa-plus-square"></i>Nouveau</button>
						<button onclick="ExportToExcel('xlsx')">Export to excel</button>
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
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouvelle Car</h2>
						</div>
						<div id="modal-form-new">
						
							<!--<form action="<?php //echo base_url("liste_car/new") ?>" enctype="multipart/form-data" method="post" id="majCampagne">-->
							<form action="<?php echo base_url("Car/insert_liste_car") ?>" enctype="multipart/form-data" method="post" id="majCampagne" enctype="multipart/form-data">
							  <fieldset>
								<div class="form-group">
								  <label for="exampleInputEmail1">Nom </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Nom">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Nombre place </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Nombre_place">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Prix jour </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Prix_jour">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Prestataire </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Prestataire">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Nom chauffeur </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Nom_chauffeur">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Numero chauffeur </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Numero_chauffeur">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Numero voiture </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Numero_voiture">
								 </div>
								 <div class="form-group">
								  <label for="exampleInputEmail1">Marque </label>
								  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Marque">
								 </div>
								
								<div class="form-group">
								<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
							  </fieldset>
							</form>
							<form enctype="multipart/form-data" method="post" role="form"action="<?php echo base_url("Car/insert_liste_car_xls") ?>" enctype="multipart/form-data" method="post" id="majCampagne" enctype="multipart/form-data">
											<h3>Import excel data</h3>
										   <p><label>Select Excel File</label>
										   <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
										   <br />
										   <input type="submit" name="import" value="Import" class="btn btn-info" />
											</button>
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
function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tableData');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('Fichier.' + (type || 'xlsx')));
        }
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
		
		buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				],
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
			url: 'liste_car/edit',
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
	 var table2excel = new Table2Excel();

      document.getElementById('export').addEventListener('click', function() {
        table2excel.export(document.querySelectorAll('tableData'));
      });
	/*
	$('.action-new').on('click', function(e){
		$.ajax({
			url: 'liste_car/new',
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