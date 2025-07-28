<div class="card">
	<div class="card-header">
		<h4 class="card-title">Panneaux</h4>
		
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
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group card-header">
				<form id="stat-panneau">
					<select name="stat-panneau" class="form-control">
						<option value="province">Province</option>
						<option value="region">Région</option>
						<option value="regisseur">Régisseur</option>
					</select>
				</form>
			</div>
		</div>
	</div>
	<div class="card-body collapse in" id="ajax-chart-panneaux" style="height: 430px; max-height:100%;"></div>
</div>

<script type="text/javascript">
    //ajax-chart-panneaux
    $(window).on("load", function(){
        loadPanneauChart();

        $("#stat-panneau select").change(function() {
            loadPanneauChart();
        })
    });

    function loadPanneauChart() {
        var ajaxData = $("#stat-panneau select").serialize();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("panneaux/getstats") ?>',
            data: ajaxData,
            success: function(data) {
                //alert("success");
                $("#ajax-chart-panneaux").html(data);
            },
            error: function(data) {
                alert("error");
            },
            done: function(data) {
                alert("done");
            }
        });
    }
</script>