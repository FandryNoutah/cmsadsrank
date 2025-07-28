<!--

    [3] => panneau_format
    [4] => panneau_type
    

    [7] => panneau_province
    [8] => panneau_axe
    [9] => panneau_regisseur
    [13] => panneau_sam
    [14] => panneau_region

    [18] => panneau_couverture_4g
    [19] => panneau_couverture_fo
    [20] => panneau_couverture_adsl
    [21] => panneau_visuel_actuel
    [5] => panneau_date_pose
-->

<?php
/*
$default = "--- Veuillez selectionner ---";
foreach ($filterData as $key => $data) {
	if ($key != "yesno") {
		array_unshift($filterData[$key], $default);
	}
}
*/
?>

<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-form">Filtre avancé</h4>
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
									<label for="panneau_format">Format</label>
									<?php echo form_dropdown('panneau_format[]', $filterData["formats"], '', 'class="form-control multiselect" data-filter="panneau_format" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_type">Type</label>
									<?php echo form_dropdown('panneau_type[]', $filterData["types"], '', 'class="form-control multiselect" data-filter="panneau_type" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_province">Province</label>
									<?php echo form_dropdown('panneau_province[]', $filterData["provinces"], '', 'class="form-control multiselect" data-filter="panneau_province" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_axe">Axes</label>
									<?php echo form_dropdown('panneau_axe[]', $filterData["axes"], '', 'class="form-control multiselect" data-filter="panneau_axe" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_regisseur">Régisseur</label>
									<?php echo form_dropdown('panneau_regisseur[]', $filterData["regisseurs"], '', 'class="form-control multiselect" data-filter="panneau_regisseur" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_sam">SAM</label>
									<?php echo form_dropdown('panneau_sam[]', $filterData["sam"], '', 'class="form-control multiselect" data-filter="panneau_sam" multiple="multiple"'); ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_region">Région / Arrondissement</label>
									<?php echo form_dropdown('panneau_region[]', $filterData["province_arrd"], '', 'class="form-control multiselect" data-filter="panneau_region" multiple="multiple"'); ?>
								</div>
							</div>

						
							<div class="col-md-2">
								<!--
								<div class="form-group">
									<label for="panneau_couverture_4g">Couvert 4G</label>
									<?php //echo form_dropdown('panneau_couverture_4g', $filterData["yesno"], '2', 'class="form-control multiselect" data-filter="panneau_couverture_4g"'); ?>
								</div>
								-->
								<div class="form-group">
									<label for="panneau_couverture_4g">Couvert 4G</label>
									<?php echo form_dropdown('panneau_couverture_4g[]', $filterData["yesno"], '', 'class="form-control multiselect" data-filter="panneau_couverture_4g" multiple="multiple"'); ?>
									<!--
									<div class="input-group">
										<label class="display-inline-block custom-control custom-radio ml-1">
											<input type="radio" value="yes" name="panneau_couverture_4g" class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">Oui</span>
										</label>
										<label class="display-inline-block custom-control custom-radio">
											<input type="radio" value="no" name="panneau_couverture_4g" class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">Non</span>
										</label>
									</div>
									-->
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_couverture_fo">Couvert FO</label>
									<?php echo form_dropdown('panneau_couverture_fo[]', $filterData["yesno"], '', 'class="form-control multiselect" data-filter="panneau_couverture_fo" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_couverture_adsl">Couvert ADSL</label>
									<?php echo form_dropdown('panneau_couverture_adsl[]', $filterData["yesno"], '', 'class="form-control multiselect" data-filter="panneau_couverture_adsl" multiple="multiple"'); ?>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-group">
										<label for="panneau_visuel_actuel">Visuel actuel</label>
										<?php echo form_dropdown('panneau_visuel_actuel[]', $filterData["all_visuel"], '', 'class="form-control multiselect" data-filter="panneau_visuel_actuel" multiple="multiple"'); ?>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
								<!-- <label for="projectinput6">Date pose</label> -->
								</div>
							</div>
							

							
						</div>
					</div>
					<!--
					<div class="form-actions">
						<button type="button" class="btn btn-warning mr-1">
							<i class="icon-cross2"></i> Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="icon-check2"></i> Save
						</button>
					</div>
					-->
				</form>
			</div>
			
			aaaaa
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
