<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-form">Nouveau flag</h4>
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
				<?php echo form_open_multipart('flags/add',array('class'=>'form-horizontal form-simple form'));?>
					<div class="form-body">
						<h4 class="form-section"><i class="icon-head"></i> Infos</h4>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="reference">Réference <?php echo form_error('reference'); ?></label>
									<?php echo form_input($reference, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="type">Type <?php echo form_error('type'); ?></label>
									<?php echo form_dropdown('type', $types, 1,'id="type" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="date_previsionnelle">Date prévisionnelle <?php echo form_error('date_previsionnelle'); ?></label>
									<?php echo form_input($date_previsionnelle, '', ''); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="date_effective">Date effective <?php echo form_error('date_effective'); ?></label>
									<?php echo form_input($date_effective, '', ''); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Coordonnées géographiques</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="longitude">Longitude <?php echo form_error('longitude'); ?></label>
									<?php echo form_input($longitude, '', 'required'); ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="latitude">Latitude <?php echo form_error('latitude'); ?></label>
									<?php echo form_input($latitude, '', 'required'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Emplacements</h4>
						<div class="row">
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="form-group">
									<label for="region">Région <?php echo form_error('region'); ?></label>
									<?php echo form_dropdown('region', $regions, 1,'id="region" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="form-group">
									<label for="province">Province <?php echo form_error('province'); ?></label>
									<?php echo form_dropdown('province', $provinces, 1,'id="province" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="form-group">
									<label for="axe">Axe <?php echo form_error('axe'); ?></label>
									<?php echo form_dropdown('axe', $axes, 1,'id="axe" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="form-group">
									<label for="arrondissement">Arrondissement <?php echo form_error('arrondissement'); ?></label>
									<?php echo form_dropdown('arrondissement', $arrondissements, 1,'id="arrondissement" class="form-control"'); ?>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="ville">Ville <?php echo form_error('ville'); ?></label>
								<div class="position-relative">
									<?php echo form_input($ville, '', 'required'); ?>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="quartier">Quartier <?php echo form_error('quartier'); ?></label>
								<div class="position-relative">
									<?php echo form_input($quartier, '', 'required'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="form-group">
									<label for="emplacement">Emplacement <?php echo form_error('emplacement'); ?></label>
									<?php echo form_input($emplacement, '', 'required'); ?>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="form-group">
									<label for="axe_prio">Axe prio <?php echo form_error('axe_prio'); ?></label>
									<?php echo form_dropdown('axe_prio', $yesno, 1,'id="axe_prio" class="form-control"'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-clipboard4"></i> Couverture</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="eligibilite_fo">Eligibilité FO <?php echo form_error('eligibilite_fo'); ?></label>
									<?php echo form_dropdown('eligibilite_fo', $yesno, 0,'id="eligibilite_fo" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="eligibilite_adsl">Eligibilité ADSL <?php echo form_error('eligibilite_adsl'); ?></label>
									<?php echo form_dropdown('eligibilite_adsl', $yesno, 0,'id="eligibilite_adsl" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="eligibilite_4g">Eligibilité 4G <?php echo form_error('eligibilite_4g'); ?></label>
									<?php echo form_dropdown('eligibilite_4g', $yesno, 0,'id="eligibilite_4g" class="form-control"'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-head"></i> Etats</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="etat_armature">Etat armature <?php echo form_error('etat_armature'); ?></label>
									<?php echo form_dropdown('etat_armature', $etats_armature, 1,'id="etat_armature" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="etat_bache">Etat bâche <?php echo form_error('etat_bache'); ?></label>
									<?php echo form_dropdown('etat_bache', $etats_bache, 1,'id="etat_bache" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="etat_poteau">Etat poteau <?php echo form_error('etat_poteau'); ?></label>
									<?php echo form_dropdown('etat_poteau', $etats_poteau, 1,'id="etat_poteau" class="form-control"'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-head"></i> Opérations</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="operations">Opérations <?php echo form_error('operations'); ?></label>
									<?php echo form_dropdown('operations', $operation, 1,'id="operations" class="form-control"'); ?>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="propal">Propal <?php echo form_error('propal'); ?></label>
									<?php echo form_input($propal, '', ''); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="non_flag">Non Flag <?php echo form_error('non_flag'); ?></label>
									<?php echo form_dropdown('non_flag', $yesno, 1,'id="non_flag" class="form-control"'); ?>
								</div>
							</div>
						</div>

						<h4 class="form-section"><i class="icon-head"></i> Visuels</h4>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="visuel_actuel">Visuel actuel<?php echo form_error('visuel_actuel'); ?></label><br/>
									<?php echo form_input($visuel_actuel, '', 'required'); ?>

									<label for="visuel_actuel_path"><?php echo form_error('visuel_actuel_path'); ?></label><br/>
									<?php echo form_upload($visuel_actuel_path,'',''); ?>
								</div>
							</div>
						</div>
						
						<h4 class="form-section"><i class="icon-head"></i> Observations</h4>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="observations">Observations <?php echo form_error('observations'); ?></label><br/>
									<?php echo form_textarea($observations,'','required'); ?>
								</div>
							</div>
						</div>						
					</div>

					<div class="form-actions">
						<button type="reset" class="btn btn-warning mr-1">
							<i class="icon-cross2"></i> Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							<i class="icon-check2"></i> Save
						</button>
					</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>