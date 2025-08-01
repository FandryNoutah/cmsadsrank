<nav id="sidebarMenu" class="col-auto p-0 d-md-block bg-light sidebar collapse border-right" style="width: 250px;">
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3" style="font-size: 12px;">
				GENERAL SETTINGS
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url(); ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
					<span class="nav-label">Client</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
					<span class="nav-label">Applications</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-noteblank.svg') ?>" />
					<span class="nav-label">Tâches</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-clipboardtext.svg') ?>" />
					<span class="nav-label">Google Ads</span>
				</a>
			</li>
			<li class="nav-item rounded <?= ($this->uri->segment(1) == "Task") ? 'bg-white' : ''; ?>">
				<a class="nav-link text-secondary" href="<?= base_url('Task') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-clipboardtext.svg') ?>" />
					<span class="nav-label">Tasks</span>
				</a>
			</li>
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3" style="font-size: 12px;">
				WORKSPACE SETTINGS
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
					<span class="nav-label">Loocker Studio</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/addressbook.svg') ?>" />
					<span class="nav-label">Billing</span>
				</a>
			</li>
		</ul>
	</div>
</nav>