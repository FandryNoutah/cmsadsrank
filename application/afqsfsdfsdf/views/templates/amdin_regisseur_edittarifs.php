<div class="col-md-12">
		<h1  style="font-family:prisdtina;margin-top:20px;margin-bottom:30px"><u>Editer tarif régisseur</u></h1>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control"></h4>
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

		
		<?php 
		
			//datadump($all_regisseur);
			$panneaux = array(
						"p12a3" => "Panneau 12x3",
						"p12a6" => "Panneau 12x6",
						"p4a3"  => "Panneau 4x3",
						"p6a3" => "Panneau 6x3",
						"p6a6" => "Panneau 6x6",
						"p8a3" => "Panneau 8x3",
			);
			$murs = array(
						"m12a3" => "Murs 12x3",
						"m12a6" => "Murs 12x6",
						"m4a3"  => "Murs 4x3",
						"m6a3" => "Murs 6x3",
						"m6a6" => "Murs 6x6",
						"m8a3" => "Murs 8x3",
			);		
			foreach($panneaux as $key => $value) {
				//echo "key = $key - valeur = $value <br>";
			}
			foreach($murs as $key2 => $value2) {
				//echo "key = $key - valeur = $value <br>";
			}
		?>
		
		

		<div class="card-body collapse in">
			
				<div class="card-text"></div>
				<!--
				<div id="infoMessage"><?php //echo $message;?></div>
				-->
				
				<?php echo form_open_multipart(uri_string()); ?>
					<div class="form-body">
						<?php foreach($panneaux as $key => $value): ?>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="p12a3" style="color:white"><?php echo $value; ?><?php echo form_error($key); ?></label>
									<?php echo form_input($key, $all_regisseur->$key, 'required'); ?> Ariary
								</div>
							</div>
						</div>
						<?php endforeach; ?>
						<?php foreach($murs as $key2 => $value2): ?>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="p12a3" style="color:white"><?php echo $value2; ?><?php echo form_error($key2); ?></label>
									<?php echo form_input($key2, $all_regisseur->$key2, 'required'); ?> Ariary
								</div>
							</div>
						</div>
						<?php endforeach; ?>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="w3a3" style="color:white">WLB :<?php echo form_error('w3a3'); ?></label>
									<?php echo form_input($w3a3,'','required'); ?> Ariary
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="flagsgm" style="color:white">Flags GM :<?php echo form_error('flagsgm'); ?></label><br/>
									<?php echo form_input($flagsgm,'','required'); ?> Ariary
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="flagpm" style="color:white">Flags PM:<?php echo form_error('flagpm'); ?></label><br/>
									<?php echo form_input($flagpm,'','required'); ?> Ariary
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="a15a25" style="color:white">Arches :<?php echo form_error('a15a25'); ?></label><br/>
									<?php echo form_input($a15a25,'','required'); ?> Ariary
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="a15a2"style="color:white">Arches :<?php echo form_error('a15a2'); ?></label><br/>
									<?php echo form_input($a15a2,'','required'); ?> Ariary
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="card-header text-center bg-primary text-uppercase" style="color:white">
									<label for="kiosque" style="color:white">Kiosque :<?php echo form_error('kiosque'); ?></label><br/>
									<?php echo form_input($kiosque,'',''); ?> Ariary
								</div>
							</div>
						</div>
					</div>

							

					<div class="form-actions right">
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
