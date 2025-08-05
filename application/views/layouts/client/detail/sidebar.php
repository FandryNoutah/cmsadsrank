<nav id="sidebarMenu" class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="sidebartext-muted font-weight-light ml-3" style="font-size: 12px;">
				GENERAL SETTINGS
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url(); ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
					<span>Client</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
					<span>Applications</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-noteblank.svg') ?>" />
					<span>Tâches</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="<?= base_url('Client') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-clipboardtext.svg') ?>" />
					<span>Google Ads</span>
				</a>
			</li>
			<li class="nav-item rounded <?= ($this->uri->segment(1) == "Task") ? 'bg-white' : ''; ?>">
				<a class="nav-link text-secondary" href="<?= base_url('Task') ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-clipboardtext.svg') ?>" />
					<span>Tasks</span>
				</a>
			</li>
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<h6 class="sidebartext-muted font-weight-light ml-3" style="font-size: 12px;">
				WORKSPACE SETTINGS
			</h6>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
					<span>Loocker Studio</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/addressbook.svg') ?>" />
					<span>Billing</span>
				</a>
			</li>
		</ul>
	</div>
</nav>
