<pre>
<?php //print_r($filterData); ?>
</pre>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-form">Filtre avancé<h4>
			<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
			<div class="heading-elements">
				<ul class="list-inline mb-0">
					<li><a data-action="collapse"><i class="icon-plus4"></i></a></li>
					<li><a data-action="reload"><i class="icon-reload"></i></a></li>
					<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
					<li><a data-action="close"><i class="icon-cross2"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="card-body collapse">
			<div class="card-block">
				
				<form class="form" id="filterData">
					<div class="form-body---">
						<div class="row">
								<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_province">Province</label>
									<?php echo form_dropdown('province[]', $filterData["province"], '', 'class="form-control multiselect" data-filter="province" multiple="multiple"'); ?>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_type">Type</label>
									<?php echo form_dropdown('type[]', $filterData["type"], '', 'class="form-control multiselect" data-filter="type" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_format">Format</label>
									<?php echo form_dropdown('format[]', $filterData["format"], '', 'class="form-control multiselect" data-filter="format" multiple="multiple"'); ?>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-group">
										<label for="panneau_visuel_actuel">Visuel actuel</label>
										<?php echo form_dropdown('visuel_actuel[]', $filterData["visuel"], '', 'class="form-control multiselect" data-filter="visuel" multiple="multiple"'); ?>
									</div>
								</div>
							</div>

							


							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_regisseur">Régisseur</label>
									<?php echo form_dropdown('regisseur[]', $filterData["regisseur"], '', 'class="form-control multiselect" data-filter="regisseur" multiple="multiple"'); ?>
								</div>
							</div>
						
							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_region">Région / Arrondissement</label>
									<?php echo form_dropdown('region[]', $filterData["region"], '', 'class="form-control multiselect" data-filter="region" multiple="multiple"'); ?>
								</div>
							</div>

						
							
							

							<div class="col-md-2">
								<div class="form-group">
								<!-- <label for="projectinput6">Date pose</label> -->
								</div>
							</div>
							
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
  		//alert("Datatables");
        window.prettyPrint() && prettyPrint();
        $('select.multiselect').multiselect({
            includeSelectAllOption: true,
			nonSelectedText: ' Aucune selection',
			selectAllText: ' Tout selectionner',
            enableFiltering: true
        });
	});
</script>
