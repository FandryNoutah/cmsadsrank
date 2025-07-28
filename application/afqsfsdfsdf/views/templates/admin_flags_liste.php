<?php //datadump($campagnes); ?>
<?php //datadump($visuels); ?>
<?php //datadump($campagneVisuels); ?>
<?php //datadump($panneaux); ?>
<?php //datadump($filters); ?>
<?php //datadump($campagneVisuels); ?>
<?php //datadump($campagneVisuelsModel); ?>
<?php //datadump($_provinces); ?>



<?php //echo sizeof($byfilter); ?>
<?php //datadump($byfilter); ?>

<?php //exit(); ?>

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
	.multiselect-container.dropdown-menu {width:100%}
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
	<?php $this->load->view("templates/parts/filter_flag",  array($filters)); ?>
</div>

<div id="ajaxResult"></div>

<script type="text/javascript">
	$(function() {
		var filters = "<?php echo addslashes(json_encode($filters)) ?>";
		loadAjax();
		$("select, input").change(function() {
			loadAjax();
		});

		$("#dataExport").click(function(e) {
			exportData();
			return false;
		});

		
		/*
		$('#selectAll').click(function() {
		    var c = this.checked;
		    $(':checkbox').prop('checked',c);
		});
		*/


        function loadAjax() {
			var ajaxData = $("#filterData").serialize() + "&filters=" + filters;
			var loader = '<img src="<?php echo base_url('assets/images/ajax-loader.gif') ?>"/>';
			console.log(ajaxData);
			//alert($("#filterData").serialize());
			$.ajax({
				type: "POST",
				url: '<?php echo base_url("filtre_flag"); ?>',
				data: ajaxData,
				success: function(data) {
					$("#ajaxResult").html(data);
					$('#tableData').DataTable({
						destroy: true,
						responsive: true,
						paging: true,
						searching: true,
						lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "Tout"]],
						language: {
							"lengthMenu": "Afficher _MENU_ lignes par page",
							"search": "Rechercher:",
							"info": "Affichage de _START_ à _END_ de _TOTAL_ lignes",
							"processing": loader,
						},
						iDisplayLength: 25,
						columnDefs: [
							{ responsivePriority: 1, targets: 0 },
							{ responsivePriority: 2, targets: -1 }
						]
					});
					
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
						$(".massAction > span").html("(" + $(':checkbox.bulkaction:checked').length + " éléments)");
				    });
					
					
				    $(".bulkaction").change(function() {
				    	if(!$(this).prop('checked')) {
				    		$('#selectAll').prop('checked', false);
				    	}

						if($(':checkbox.bulkaction:checked').length == checkboxesNb) {
			    			$('#selectAll').prop('checked', true);
			    		}
						
						//alert($(':checkbox.bulkaction:checked').length);
						$(".massAction > span").html("(" + $(':checkbox.bulkaction:checked').length + " éléments)");
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
			//alert(allIds);
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
</script>