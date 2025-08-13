<nav id="sidebarMenu" class="col-auto p-0 d-md-block bg-light sidebar collapse border-right" style="width: 250px;">
	<a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 border-bottom" href="#" style="height: 72px;">
		<img class="logo-full" src="<?= base_url('assets/images/figma/logo_adsrank.png') ?>" alt="" height="30">
		<img class="logo-split d-none" src="<?= base_url('assets/images/figma/logo_split.png') ?>" alt="" style="width: 30px;">
	</a>
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url(); ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
					<span class="nav-label">Dashboard</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-calendar.svg') ?>" />
					<span class="nav-label">Onboarding</span>
				</a>
			</li>
			<li class="nav-item rounded <?= ($this->uri->segment(1) == "Client") ? 'bg-white' : ''; ?>">
				<a class="nav-link text-secondary" href="<?= base_url('Client') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-clipboardtext.svg') ?>" />
					<span class="nav-label">Clients</span>
				</a>
			</li>
			<li class="nav-item rounded <?= ($this->uri->segment(1) == "Task") ? 'bg-white' : ''; ?>">
				<a class="nav-link text-secondary" href="<?= base_url('Task') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-clipboardtext.svg') ?>" />
					<span class="nav-label">Tâches</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Note') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-noteblank.svg') ?>" />
					<span class="nav-label">Notes</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-envelope.svg') ?>" />
					<span class="nav-label">Discussions</span>
				</a>
			</li>
			
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3">
				DATABASE
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
					<span class="nav-label">Loocker Studio</span>
				</a>
			</li>
			
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-briefcase.svg') ?>" />
					<span class="nav-label">Plan de taggage</span>
				</a>
			</li>
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2">
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-gear.svg') ?>" />
					<span class="nav-label">Utilisateur</span>
				</a>
			</li>
		</ul>
	</div>
</nav>
