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
							<!--
							<div class="col-md-3">
								<div class="form-group">
									<label for="panneau_format">Arrondissement</label>
									<?php echo form_dropdown('arrondissement[]', $filterData["arrondissements"], '', 'class="form-control multiselect" data-filter="panneau_format" multiple="multiple"'); ?>
								</div>
							</div>
							-->
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_type">Etat bâche</label>
									<?php echo form_dropdown('etat_bache[]', $filterData["etat_bache"], '', 'class="form-control multiselect" data-filter="panneau_type" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_province">Etat armature</label>
									<?php echo form_dropdown('etat_armature[]', $filterData["etat_armature"], '', 'class="form-control multiselect" data-filter="panneau_province" multiple="multiple"'); ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="panneau_axe">Etat poteau</label>
									<?php echo form_dropdown('etat_poteau[]', $filterData["etat_poteau"], '', 'class="form-control multiselect" data-filter="panneau_axe" multiple="multiple"'); ?>
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
