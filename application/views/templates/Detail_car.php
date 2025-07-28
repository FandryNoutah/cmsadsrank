<h1> </h1>
<?php //datadump($perso); die();  ?>  
<?php //echo $concurrent[0]['remarque'] ?>







<?php 
$hide = array("id", "status");
$count = count($visuels) > 1; 

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
			    <h4 class="card-title">Liste des personnelles  dans le car <?php foreach($Car as $C){ ?><?php echo $C['Nom']; 	?> <span id="countItem"><?php echo $count; ?></span></h4>
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
			<h6>Nombre de places : <?php echo $C['Nombre_place']; ?> </h6>
			<h6>Nombre de personnelle : <?php echo $Nbre_presonnelle; ?> Personnelles</h6>
			<h6>Places Libre : <?php echo $Place_Libre; ?> Places</h6>
	    		<div class="card-block card-dashboard"></div>
				<div class="table-responsive" id="">
				<?php } ?>	
					
					
					<table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
						<thead>
							<tr>
								
								
								<th></th>
								<th>MATRICULE</th>
								<th>SOCIETE</th>
								<th>NOM</th>
								<th>PRENOMS</th>
								<th>DIRECTION</th>
								<th>LIGNE</th>
								<th>RAMASSAGE/REMISAGE</th>
								<th>ADRESSE EXACTE</th>
								<th>CONTACT</th>
								<th>LIEU DE TRAVAIL</th>
								<th>OBS</th>
								<th>GERER</th>
								<th>Actions</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($perso as $C){ ?>
							<tr>
								
										<td></td>
										<td><?php echo $C['Matricule']; 	?> </td>
										<td><?php echo $C['Societe']; 	?> </td>
										<td><?php echo $C['Nom']; 	?> </td>
										<td><?php echo $C['Prenom']; 	?> </td>		
										<td><?php echo $C['Direction']; 	?> </td>	
										<td><?php echo $C['Ligne']; 	?> </td>
										<td><?php echo $C['Ramassage_remisage']; 	?> </td>
										<td><?php echo $C['Adresse_exacte']; 	?> </td>		
										<td><?php echo $C['Contact']; 	?> </td>
										<td><?php echo $C['Lieu_de_travail']; 	?> </td>	
										<td><?php echo $C['OBS']; 	?> </td>
										<td><a href="<?php echo site_url('Personnelle/tranfrerer_Personnelle/'.$C['id_personnelle']); ?>" class="btn btn-info">Tranferer</a>
										
										
										<a href="<?php echo site_url('Personnelle/desabonner_Personnelle/'.$C['id_personnelle']); ?>" class="btn btn-danger">Desabonner</a></td>
										<td><?php echo anchor("Personnelle/update_personnelle/".$C['id_personnelle'], '<h6 class="btn btn-success">Modifier</h6><i  class="button" title="visuelConcurrent"></i>','data-edit="'.$C['id_personnelle'].'"') ;?>
										<?php echo anchor("Personnelle/delete_Personnelle/".$C['id_personnelle'], '<h6 class="btn btn-danger">Suprimer</h6><i  class="button" title="visuelConcurrent"></i>','data-edit="'.$C['id_personnelle'].'"') ;?>
										</td>
							<?php } ?>
								</tr>
						</tbody>
					</table>
				
					
					</div>
					
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
							<form action="<?php echo site_url('Visuels/EditConcurrent/'.$this->session->userdata($visuels[0]['id']));?>" method="post" enctype="multipart/form-data">
          <fieldset>
              
             <div class="form-group">
                <label for="exampleSelect1">Categorie</label>
                <select class="form-control" id="exampleSelect1" name="categorie">
            
			   <?php foreach($listeConcurrent as $C){ ?>
                        <option value="<?php echo $C['nomconcurrent'];?>"> <?php echo $C['nomconcurrent'];?>  </option>
                    <?php } ?>
                </select>
 
           <div class="form-group">
              <label for="exampleInputEmail1">Remarque</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="remarque">
            </div>
			
        
			<h4>Inserer support image 1</h4>
			<div class="col-md-3">
			<div class="form-group">
				<input type="file" name="image1">
			</div>
			<h4>Inserer support image 2</h4>
			</div>
			<div class="col-md-3">
			<div class="form-group">
				<input type="file" name="image2">
			</div>
			<h4>Inserer support image 3</h4>
			</div>
			<div class="col-md-3">
			<div class="form-group">
				<input type="file" name="image3">
			</div>
			<h4>Inserer support image 4</h4>
			</div>
			<div class="col-md-3">
			<div class="form-group">
				<input type="file" name="image4">
			</div>
			<input type="hidden" value="<?php echo $visuels[0]['id'] ?>" name="id" >
			</div>
            <button type="submit" class="btn btn-primary col-md-12">Editer</button>
          </fieldset>
        </form>
						
						
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
							<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Ajouter Concurrent Visuels</h2>
						</div>
						<div id="modal-form-new">
						
							<form action="<?php echo site_url('Visuels/AjoutConcurrent/'.$this->session->userdata('idVisuels'));?>" method="post" enctype="multipart/form-data">
          <fieldset>
              
             <div class="form-group">
                <label for="exampleSelect1">Categorie</label>
                <select class="form-control" id="exampleSelect1" name="categorie">
            
			   <?php foreach($listeConcurrent as $C){ ?>
                        <option value="<?php echo $C['nomconcurrent'];?>"> <?php echo $C['nomconcurrent'];?>  </option>
                    <?php } ?>
                </select>
 
           <div class="form-group">
              <label for="exampleInputEmail1">Remarque</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="remarque">
            </div>
			
            <h5>Inserer support image 1</h5>
			
			<div class="col-md-12">
			<div class="form-group">
				<input type="file" name="image1">
			</div>
			<h5>Inserer support image 2</h5>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<input type="file" name="image2">
			</div>
			<h5>Inserer support image 3</h5>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<input type="file" name="image3">
			</div>
			<h5>Inserer support image 4</h5>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<input type="file" name="image4">
			</div>
			<input type="hidden" value="<?php echo $visuels[0]['id'] ?>" name="id" >
			</div>
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
		autoFill: true,
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
<!--<input type="hidden" onclick="" name="exportdata" value="<?php //echo base64_encode(addslashes(json_encode($result))); ?>" />-->
