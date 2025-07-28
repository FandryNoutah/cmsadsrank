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
<style>.form-group > label {font-weight:bold;}</style>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-form">Filtre avancé</h4>
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
			<div class="card-block">
				
				<form class="form" id="filterData">
					<div class="form-body---">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_format">Format</label>
									<?php echo form_dropdown('panneau_format[]', $filterData["panneau_format"], '', 'class="form-control multiselect" data-filter="panneau_format" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_type">Type</label>
									<?php echo form_dropdown('panneau_type[]', $filterData["panneau_type"], '', 'class="form-control multiselect" data-filter="panneau_type" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_province">Province</label>
									<?php echo form_dropdown('panneau_province[]', $filterData["panneau_province"], '', 'class="form-control multiselect" data-filter="panneau_province" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_axe">Axes</label>
									<?php echo form_dropdown('panneau_axe[]', $filterData["panneau_axe"], '', 'class="form-control multiselect" data-filter="panneau_axe" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_regisseur">Régisseur</label>
									<?php echo form_dropdown('panneau_regisseur[]', $filterData["panneau_regisseur"], '', 'class="form-control multiselect" data-filter="panneau_regisseur" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_sam">SAM</label>
									<?php echo form_dropdown('panneau_sam[]', $filterData["panneau_sam"], '', 'class="form-control multiselect" data-filter="panneau_sam" multiple="multiple"'); ?>
								</div>
							</div>
						</div>

						<div class="row">
							<!--
							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_region">Région / Arrondissement</label>
									<?php echo form_dropdown('panneau_region[]', $filterData["panneau_region"], '', 'class="form-control multiselect" data-filter="panneau_region" multiple="multiple"'); ?>
								</div>
							</div>
							-->
						
							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_couverture_4g">Couvert 4G</label>
									<?php echo form_dropdown('panneau_couverture_4g[]', $filterData["panneau_couverture_4g"], '', 'class="form-control multiselect" data-filter="panneau_couverture_4g" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_couverture_fo">Couvert FO</label>
									<?php echo form_dropdown('panneau_couverture_fo[]', $filterData["panneau_couverture_fo"], '', 'class="form-control multiselect" data-filter="panneau_couverture_fo" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="panneau_couverture_adsl">Couvert ADSL</label>
									<?php echo form_dropdown('panneau_couverture_adsl[]', $filterData["panneau_couverture_adsl"], '', 'class="form-control multiselect" data-filter="panneau_couverture_adsl" multiple="multiple"'); ?>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-group">
										<label for="panneau_visuel_actuel">Visuels</label>
										<?php echo form_dropdown('visuel_id[]', $filterData["all_visuel"], '', 'class="form-control multiselect" data-filter="panneau_visuel_actuel" multiple="multiple"'); ?>
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
				<div class="filtre_text">
					
				</div>
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
