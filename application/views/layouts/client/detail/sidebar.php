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
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/ChatCircleText.png') ?>" />
					<span>GTM</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client') ?>">
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
					<img class="mr-2" src="<?= base_url('assets/images/ico/icone/Stack.png') ?>" />
					<span>Discussions</span>
				</a>
			</li>
		</ul>
	</div>
</nav>
