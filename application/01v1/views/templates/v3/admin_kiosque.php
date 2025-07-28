
<?php if($this->session->flashdata("message-succes")): ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
			   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
			   </button>
			   <strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
		   </div>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<?php $this->load->view("templates/v3/parts/filter", array($filterData)); ?>
</div>

<div id="ajaxResult"></div>


<!--
<div class="row">
    <div class="col-xs-12">
		
		<?php 
//		echo "<pre>";
//		print_r($kiosques); 
//		echo "</pre>";
		?>
		
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
        <a href="<?php echo base_url("kiosques/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau kiosque</a>
    </div>
</div> -->



<script type="text/javascript">
	$(function() {
		var filters = "<?php echo addslashes(json_encode($filterData)) ?>";
		var filtersObject = JSON.parse(filters);
		loadAjax();
		$("select, input").change(function() {
			var checked = $(this).parents(".form-group").find("label").html();
			loadAjax(checked);
		});

		$("#dataExport").click(function(e) {
			exportData();
			return false;
		});
		
        function loadAjax(checked) {
			$(".content-overlay").show();
			var params = [checked];
			params.push();
			var ajaxData = $("#filterData").serialize() + "&filters=" + filters + "&support=4";
			var filterText = $("#filterData").serializeArray();
			var $text = [];
			var $counter = 0;
			var html = "";
			var textContent = "";
			console.log(filtersObject);
			
			$.ajax({
				type: "POST",
				url: '<?php echo base_url("filter") ?>',
				data: ajaxData,
				success: function(data) {
					$(".content-overlay").hide();
					$("#ajaxResult").html(data);
					var $dataTable = $('#tableData').DataTable({
						destroy: true,
			            responsive: false,
			            paging: true,
			            searching: true,
			            scrollX: true,
						//dom: 'Bfrtip',
						select: true,
						lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
						language: {
							"lengthMenu": "Afficher _MENU_ lignes par page",
							"search": "Rechercher:",
							"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
						},
						/*
			            columnDefs: [
			                { responsivePriority: 1, targets: 0 },
			                { responsivePriority: 2, targets: 3 },
			                { orderable: false, targets: 0 }
			            ],
						*/
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
						/*
						tableTools: {
							//sRowSelect: "os",
							//sRowSelector: 'td:first-child',
							aButtons: [
								//{ sExtends: "editor_create", editor: editor },
								//{ sExtends: "editor_edit",   editor: editor },
								//{ sExtends: "editor_remove", editor: editor }
							]
						},
						*/
			        });
					
					//console.log($dataTable.rows());
										
					$("a.dt-button").click(function() {
						var $_class =  $(this).attr("class");
						$("a.dt-button").removeClass("current");
						$(this).addClass("current");
					});
					
					$('#tableData tbody').on( 'click', 'tr', function () {
						//$(this).toggleClass('selected');
						//$dataTable.rows().select();
					});
					
			        var checkboxesNb = $(':checkbox.bulkaction').length;
			       
					
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
					
					$("#maj_campagne").click(function(e) {
						majCampagne(e);
					});
				},
				error: function(data) {
					alert("error");
				},
				done: function(data) {
					alert("done");
				}
			});
		}
		
		

		function exportData() {
			var exportData = $("input[name=exportdata]").val();
			console.log(exportData);
			$.ajax({
				type: "POST",
				url: '<?php echo base_url("panneau/export") ?>',
				data: "data=" + exportData,
				success: function(data) {
					alert("export successfull");;
				},
				error: function(data) {
					alert("error");
				},
				done: function(data) {
					alert("done");
				}
			});
			return false;
		}
		
		function majCampagne(event){
			var allIdsCount = $(':checkbox.bulkaction:checked').length;
			var allIds = $(':checkbox.bulkaction:checked');
			var allIdsVal = [];
			
			if(allIdsCount <= 0){
				alert("Veuillez cocher les panneaux à mettre à jour");
				event.stopImmediatePropagation();
				return false;
			} else {
				allIds.each(function(){
					allIdsVal.push($(this).attr("data-action"));
				});
				$("input[name=panneaux_ids]").val(allIdsVal);
			}
			
			return false;
		}
	});

	$.fn.serializeAssoc = function() {
		var data = {};
		$.each( this.serializeArray(), function( key, obj ) {
			var a = obj.name.match(/(.*?)\[(.*?)\]/);
			if(a !== null)
				{
					var subName = a[1];
					var subKey = a[2];

					if( !data[subName] ) {
						data[subName] = [ ];
					}

					if (!subKey.length) {
						subKey = data[subName].length;
					}

				if( data[subName][subKey] ) {
					if( $.isArray( data[subName][subKey] ) ) {
						data[subName][subKey].push( obj.value );
					} else {
						data[subName][subKey] = [ ];
						data[subName][subKey].push( obj.value );
					}
				} else {
					data[subName][subKey] = obj.value;
				}
			} else {
				if( data[obj.name] ) {
					if( $.isArray( data[obj.name] ) ) {
						data[obj.name].push( obj.value );
					} else {
						data[obj.name] = [ ];
						data[obj.name].push( obj.value );
					}
				} else {
					data[obj.name] = obj.value;
				}
			}
		});
	return data;
};
</script>