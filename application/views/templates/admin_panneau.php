<style type="text/css">
	.card .card-title > span {
	    font-weight: 400;
	    font-size: 13px;
	    text-transform: none;
	}
</style>
<div class="row">
    <div class="col-xs-12">
    	
    	<?php if($this->session->flashdata("message-error")): ?>
	    	<div class="alert alert-danger alert-dismissible fade in mb-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Erreur!</strong> <?php echo $this->session->flashdata("message-error"); ?>
			</div>
		<?php endif; ?>

		<?php if($this->session->flashdata("message-succes")): ?>
	    	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
			</div>
		<?php endif; ?>


		<div class="row">
			<?php $this->load->view("templates/parts/filter",  array($filterData)); ?>
		</div>
        <div class="card">
            <div class="card-content filterResult">
            	<!--
	            <div class="card-header">
	                <h4 class="card-title">Liste Panneaux <span id="countItem"></span></h4>
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
	                	<table id="tableData" class="tableData filterResult table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
	                    </table>
	                </div>
	            </div>

				<div class="btnControls">
		            <a href="<?php //echo base_url("panneau/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau panneau</a>
	        		<a href="<?php //echo base_url("panneau/export") ?>" target="_self" class="btn btn-success upgrade-to-pro" id="dataExport">Exporter XLS</a>
        		</div>
        		-->
            </div>
        </div>
        
    </div>
</div>

<div id="resExport"></div>

<script type="text/javascript">
	$(function() {
		alert("ato");
		var filterData = "<?php echo addslashes(json_encode($filterData)) ?>";
		loadAjax();
		
		

		$("#dataExport").click(function(e) {
			exportData();
			return false;
		});

		$("select, input").change(function() {
			//alert($(this).attr("data-filter"));
			loadAjax();
		});

		function loadAjax() {
			var ajaxData = $("#filterData").serialize() + "&filterData=" + filterData;
			//console.log(ajaxData);
			$.ajax({
				type: "POST",
				url: '<?php echo base_url("filter") ?>',
				data: ajaxData,
				success: function(data) {
					$(".filterResult").html(data);
					$('#tableData').DataTable({
						destroy: true,
			            responsive: true,
			            paging: true,
			            searching: true,
			            iDisplayLength: 25,
			            columnDefs: [
			                { responsivePriority: 1, targets: 0 },
			                { responsivePriority: 2, targets: -1 }
			            ]
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
			alert("export");
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
	})
</script>