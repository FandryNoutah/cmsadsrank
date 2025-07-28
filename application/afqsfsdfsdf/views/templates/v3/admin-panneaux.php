<style type="text/css">
	.card .card-title > span {
	    font-weight: 400;
	    font-size: 13px;
	    text-transform: none;
	}
	.card .btnControls {
	    padding: 0px 20px 20px;
	}
	a.dt-button.current {
		font-weight: bold;
		text-transform: uppercase;
	}
	.index > span { font-weight: bold; }
</style>
		
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

<section id="">
	<div class="row">
		<div class="col-xs-6">
			<?php $this->load->view("templates/v3/parts/part-panneaux-gmap",  ["locations" => $locations]); ?>
		</div>
		
		<div class="col-xs-6">
			<?php $this->load->view("templates/v3/parts/part-panneaux-chart"); ?>
			<?php $this->load->view("templates/v3/parts/part-panneaux-chart-visuels", [$filterData]); ?>
		</div>
	</div>
</section>

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
			var ajaxData = $("#filterData").serialize() + "&filters=" + filters + "&support=5";
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
			        /*
					$('#selectAll').change(function(){
				        var checkboxes = $(':checkbox.bulkaction');
				        if($(this).prop('checked')) {
				          checkboxes.prop('checked', true);
				        } else {
				          checkboxes.prop('checked', false);
				        }
						var $element = "";
						var $elementCount = $(':checkbox.bulkaction:checked').length;
						$element += $elementCount + " élément"
						$element += $elementCount > 1 ? "s" : "";
						
						console.log($elementCount);
						console.log($element);
						
						$(".massAction > span").html("(" + $element + ")");
				    });
					
					
					$("#_selectAll_").on("click", function(e) {
						$(this).prop("checked", true);
						if ($(this).is(":checked")) {
							$dataTable.rows().select();
						} else {
							$dataTable.rows().deselect();
						}
						return false;
					});
					*/
					
					/*
				    $("#selectAll, .bulkaction").change(function(event) {
				    	if(!$(this).prop('checked')) {
				    		$('#selectAll').prop('checked', false);
				    	}

						if($(':checkbox.bulkaction:checked').length == checkboxesNb) {
			    			$('#selectAll').prop('checked', true);
			    		}
						var $element = "";
						var $elementCount = $(':checkbox.bulkaction:checked').length;
						$element += $elementCount + " élément"
						$element += $elementCount > 1 ? "s" : "";
						console.log($elementCount);
						console.log($element);
						$(".massAction > span").html("(" + $element + ")");
						event.preventDefault();
						var checkedIds = $(":checkbox.bulkaction:checked").map(function(){
							return $(this).data("action");
						}).get();
						$("input[name=panneaux_ids]").val(checkedIds);
						console.log(checkedIds);
				    });
					*/
					
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
	/*
	var editor = new $.fn.dataTable.Editor({
		//ajax: "../php/staff.php",
		table: "#tableData",
		fields: [{
				label: "First name:",
				name: "first_name"
			}, {
				label: "Last name:",
				name: "last_name"
			}, {
				label: "Position:",
				name: "position"
			}, {
				label: "Office:",
				name: "office"
			}, {
				label: "Extension:",
				name: "extn",
				multiEditable: false
			}, {
				label: "Start date:",
				name: "start_date",
				type: "datetime"
			}, {
				label: "Salary:",
				name: "salary"
			}
		]
	});
	*/
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