<?php //datadump($filterData); ?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Visuels</h4>
		
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
				<form id="stat-visuels" style="width: max-content;">
					<div style="display: inline;float: left;">
						<select name="stat-visuels" class="form-control">
							<option value="" selected>Tout</option>
							<option value="province">Par province</option>
							<option value="region">Par région</option>
							<option value="format">Par format</option>
							<option value="type">Par type</option>
						</select>
					</div>
					
					<div class="select-inline">
						<select name="province" class="form-control select-ctrl" disabled="disabled">
							<?php foreach($filterData["province"] as $key => $value): ?>
							<option value="<?php echo $key ?>"><?php echo $value ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					
					<div class="select-inline">
						<select name="region" class="form-control select-ctrl" disabled="disabled">
							<?php foreach($filterData["region"] as $key => $value): ?>
							<option value="<?php echo $key ?>"><?php echo $value ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					
					<div class="select-inline">
						<select name="format" class="form-control select-ctrl" disabled="disabled">
							<?php foreach($filterData["format"] as $key => $value): ?>
							<option value="<?php echo $key ?>"><?php echo $value ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					
					<div class="select-inline">
						<select name="type" class="form-control select-ctrl" disabled="disabled">
							<?php foreach($filterData["type"] as $key => $value): ?>
							<option value="<?php echo $key ?>"><?php echo $value ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="card-body collapse in" id="ajax-chart-visuels" style="height: 430px; max-height: 100%;"></div>
</div>


<script type="text/javascript">
	$(window).on("load", function(){
		
		$title = $("select[name=stat-visuels]").find("option:selected").text();
		
        loadVisuelChart($title);
		
        $("select[name=stat-visuels]").change(function() {
			var $selected = $(this).val();
			$title = "";
			
			$("select.select-ctrl").attr("disabled", "disabled");
			$("select[name=" + $selected + "]").removeAttr("disabled");
			
			$("select.select-ctrl").parent().hide();
			$("select[name=" + $selected + "]").parent().toggle("show");
			
			$title += $("select.select-ctrl:enabled").find("option:selected").text();
            loadVisuelChart($title);
        });
		
		$("select.select-ctrl").change(function() {
			$title = "";
			$title += $(this).find("option:selected").text();
			loadVisuelChart($title);
		});
    });
	
	function loadVisuelChart($title) {
		console.log($title);
        var ajaxData = $("form#stat-visuels").serialize();
		//alert(ajaxData);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("panneaux/getstatsvisuels") ?>' + "?title=" + $title,
            data: ajaxData,
            success: function(data) {
                //alert("success");
                $("#ajax-chart-visuels").html(data);
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