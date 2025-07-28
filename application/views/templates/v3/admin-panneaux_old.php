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

<?php //datadump($locations); ?>
		
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
	<?php $this->load->view("templates/v3/parts/filter",  array($filterData)); ?>
</div>

<div id="ajaxResult"></div>

<section id="gmaps">
	<div class="row">
		<?php $this->load->view("templates/v3/parts/part-gmap-panneaux",  ["panneaux" => $panneaux, "locations" => $locations]); ?>
	</div>
</section>

<script type="text/javascript">
	$(function() {
		var filters = "<?php echo addslashes(json_encode($filterData)) ?>";
		loadAjax();
		$("select, input").change(function() {
			var checked = $(this).parents(".form-group").find("label").html();
			loadAjax(checked);
		});

		$("#dataExport").click(function(e) {
			exportData();
			return false;
		});
		
		//console.log(typeof(filters));
		//console.log(typeof(JSON.parse(filters)));
		var filtersObject = JSON.parse(filters);
		console.log(filtersObject);
		
        function loadAjax(checked) {
			$(".content-overlay").show();
			//if(checked) {alert("checked");}
			//else {alert("unchecked");}
			
			var params = [checked];
			
			params.push();
			
			var ajaxData = $("#filterData").serialize() + "&filters=" + filters;
			var filterText = $("#filterData").serializeArray();
			var $text = [];
			var $counter = 0;
			var html = "";
			var textContent = "";
			console.log(filtersObject);
			/*
			$.each($("#filterData").serializeAssoc(), function(index, valueArray) {
				console.log(index);
				var textLabel = index.replace("panneau_", "");
				textLabel = textLabel.toUpperCase();
				html += '<div class="index ' + index + '">';
				//html += "<span>" + checked + " - " + index + " : </span>";
				html += "<span>" + textLabel.split('_').join(' ') + " : </span>";
				$.each(valueArray, function(key, value) {
					textContent = filtersObject[index][value];
					if(textContent instanceof Object) {
						if(index == "visuel_id") {
							html += textContent.panneau_visuel_name + " / ";
						} else {
							html += textContent.label + " / ";
						}
						
					} else {
						html += textContent + " / ";
					}
				});
				html += '</div>';
			});
			$(".filtre_text").html(html);
			*/
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
						lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
						language: {
							"lengthMenu": "Afficher _MENU_ lignes par page",
							"search": "Rechercher:",
							"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
							//"zeroRecords": "Nothing found - sorry",
							//"info": "Showing page _PAGE_ of _PAGES_",
							//"infoEmpty": "No records available",
							//"infoFiltered": "(filtered from _MAX_ total records)"
						},
			            //iDisplayLength: 25,
			            columnDefs: [
			                { responsivePriority: 1, targets: 0 },
			                { responsivePriority: 2, targets: 3 },
			                { orderable: false, targets: 0 }
			            ],
						/*
			            dom: 'lBfrtip',
				        buttons: [
				            {
				                extend: 'colvisGroup',
				                text: 'Informations',
				                show: [ 1, 2, 3, 7 ],
				                hide: [ 4, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ]
				            },
				            {
				                extend: 'colvisGroup',
				                text: 'Emplacements',
				                show: [ 4, 5, 6, 11, 12, 13 ],
				                hide: [ 1, 2, 3, 7, 8, 9, 10, 14, 15, 16, 17, 18 ]
				            },
				            {
				                extend: 'colvisGroup',
				                text: 'Coûts',
				                show: [ 8, 9, 10 ],
				                hide: [ 1, 2, 3, 4, 5, 6, 7, 11, 12, 13, 14, 15, 16, 17, 18 ]
				            },
				            {
				                extend: 'colvisGroup',
				                text: 'Couverture',
				                show: [ 16, 17, 18 ],
				                hide: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15  ]
				            },
				            {
				                extend: 'colvisGroup',
				                text: 'Coordonnées',
				                show: [ 14, 15 ],
				                hide: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 16, 17, 18 ]
				            },
				            {
				                extend: 'colvisGroup',
				                text: 'Afficher tout',
				                show: ':hidden'
				            }
				        ]
						*/
			        });
					
					/*
					//Click on row or on Checkbox both
					$('#tableData tbody, :checkbox.bulkaction').on( 'click', 'tr', function () {
						$(this).toggleClass('selected');
						alert( $dataTable.rows('.selected').data().length +' row(s) selected' );
						console.log( $(this).data("id") );
						console.log( $(this).find(":checkbox.bulkaction").prop('checked') );
						
						$check = $(this).find(":checkbox.bulkaction");
						if(!$check.prop('checked')) {
				    		$check.prop('checked', true);
				    	} else {
				    		$check.prop('checked', false);
						}
					} );
					*/
				 
					/*
					$('#button').click( function () {
						alert( table.rows('.selected').data().length +' row(s) selected' );
					});
					*/
					
					$("a.dt-button").click(function() {
						var $_class =  $(this).attr("class");
						$("a.dt-button").removeClass("current");
						$(this).addClass("current");
					});
					
			        var checkboxesNb = $(':checkbox.bulkaction').length;
			        //alert(checkboxesNb);
					
			        $('#selectAll').change(function(){
				        //var checkboxes = $(this).closest('form').find(':checkbox');
				        //alert($(this).attr("data-action"));
				        var checkboxes = $(':checkbox.bulkaction');
				        if($(this).prop('checked')) {
				          checkboxes.prop('checked', true);
				        } else {
				          checkboxes.prop('checked', false);
				        }
						//alert($(':checkbox.bulkaction:checked').length);
						var $element = "";
						var $elementCount = $(':checkbox.bulkaction:checked').length;
						$element += $elementCount + " élément"
						$element += $elementCount > 1 ? "s" : "";
						
						console.log($elementCount);
						console.log($element);
						
						$(".massAction > span").html("(" + $element + ")");
				    });
					
				    $("#selectAll, .bulkaction").change(function(event) {
				    	if(!$(this).prop('checked')) {
				    		$('#selectAll').prop('checked', false);
				    	}

						if($(':checkbox.bulkaction:checked').length == checkboxesNb) {
			    			$('#selectAll').prop('checked', true);
			    		}
						
						//alert($(':checkbox.bulkaction:checked').length);
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
				//contentType: 'application/json;charset=utf-8',
				success: function(data) {
					alert("export successfull");
					//alert(data);
					//$('#resExport').html(data);
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
			//alert("tratra");
			var allIdsCount = $(':checkbox.bulkaction:checked').length;
			//alert(allIdsCount);
			var allIds = $(':checkbox.bulkaction:checked');
			var allIdsVal = [];
			
			if(allIdsCount <= 0){
				alert("Veuillez cocher les panneaux à mettre à jour");
				event.stopImmediatePropagation();
				return false;
			}else{
				//console.log(allIds.val());
				allIds.each(function(){
					allIdsVal.push($(this).attr("data-action"));
				});
				
				$("input[name=panneaux_ids]").val(allIdsVal);
				//$("form#majCampagne").submit();
			}
			
			return false;
		}
	})
	
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