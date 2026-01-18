<style>
	.sidebar span{
		color: #282a2c;
	}

</style>
<nav class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="text-muted font-weight-light ml-3" style="font-size: 12px; color: #282a2c;">
				GENERAL SETTINGS
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client/detail_client/' . $donnees[0]['idclients']) ?>">
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/UserGear.png') ?>" />
					<span>Client</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client/application/' . $donnees[0]['idclients']) ?>">
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/QrCode.png') ?>" />
					<span>Applications</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client/tache_client/' . $donnees[0]['idclients']) ?>">
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/CalendarCheck.png') ?>" />
					<span>Tâches</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client/gtm/' . $donnees[0]['idclients']) ?>">
					 <img class="mr-2" src="<?= base_url('assets/images/ico/icone/gtm.png') ?>" width="25"/>
					<span>GTM</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/PhoneCall.png') ?>" />
					<span>Aircall</span>
				</a>
			</li>
			<!-- <li class="nav-item rounded <!?= ($this->uri->segment(1) == "Task") ? 'bg-white' : ''; ?>">
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<= base_url('Task') ?>">
					<img class="mr-2" src="<= base_url('assets/images/ico/icone/ChatCircleText.png') ?>" />
					<span>Point bilan</span>
				</a>
			</li> -->
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="text-muted font-weight-light ml-3" style="font-size: 12px;">
				WORKSPACE SETTINGS
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Lookerstudio') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/ChartLineUp.png') ?>" />
					<span>Loocker Studio</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Discussion') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/ChatCircleText.png') ?>" />
					<span>Discussions</span>
				</a>
			</li>
		</ul>
	</div>
	<?php foreach ($donnees as $d): ?>
		<div class="col-auto">
									<ul class="nav nav-tabs mb-3" style="margin-top: 25px;">
										<li class="nav-item">
											<a class="nav-link py-2 active" type="button">
												Logo
											</a>
										</li>
									</ul>
									<?php if ($d['logo_client'] == NULL): ?>
										<?php echo form_open_multipart('Client/upload_logo'); ?>

										<div class="form-group m-0">
											<input type="file" name="logo" id="logo" style="display: none;" onchange="this.form.submit();">
											<input type="hidden" name="idclients" value="<?= $d['idclients']; ?>">
											<button type="button" class="btn btn-light btn-sm" onclick="document.getElementById('logo').click();">
												<i class="fa fa-plus"></i> Ajouter Logo
											</button>
										</div>
										<?php echo form_close(); ?>
									<?php endif; ?>
									<?php if ($d['logo_client'] != NULL): ?>
										<?php echo form_open_multipart('Client/upload_logo'); ?>

										<div class="form-group">
											<input type="file" name="logo" id="logo" style="display: none;" onchange="this.form.submit();">
											<input type="hidden" name="idclients" value="<?= $d['idclients']; ?>">
											<button type="button" class="btn btn-light btn-sm" onclick="document.getElementById('logo').click();">
												<img src="<?php echo base_url($d['logo_client']); ?>" width="100" />
											</button>
										</div>
										<?php echo form_close(); ?>
									<?php endif; ?>
								</div>

								<div class="col-auto" >
									<ul class="nav nav-tabs mb-3" style="margin-top: 25px;">
										<li class="nav-item">
											<a class="nav-link py-2 active" type="button">
												Favicon
											</a>
										</li>
									</ul>		<div class="form-group">
											<?php if($d['favicon'] != NULL): ?>	
											<img src="<?= $d['favicon']; ?>" width="30" class="mr-2" style="margin-left: 25px;">
											<?php else: ?>
											<img src="<?= base_url('assets/images/ico/default_favicon.png') ?>" width="28" class="mr-2" > 
											<?php endif; ?>
									</div>
								</div>

	<?php endforeach; ?>		
</nav>
