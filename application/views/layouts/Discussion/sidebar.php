<div class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2">
			<h6 class="text-muted ml-3" style="font-size: 12px;">
				MENU
			</h6>

			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					Tout les messages
					<span class="badge badge-dark ml-2"><?= $nbr_discussion_all; ?></span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Note'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Note") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					Note
					<span class="badge badge-dark ml-2"><?= $nbr_discussion_note; ?></span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Team_task'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Team_task") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					Team Task
					<span class="badge badge-dark ml-2"><?= $nbr_discussion_task; ?></span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Brief'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Brief") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					Brief
					<span class="badge badge-dark ml-2">0</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Temporaire'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Temporaire") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					Temporaire
					<span class="badge badge-dark ml-2">0</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Gtm'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Gtm") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					GTM
					<span class="badge badge-dark ml-2"><?= $nbr_discussion_gtm; ?></span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('trash'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Trash") ? 'bg-light' : ''; ?>">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/EnvelopeOpen.png') ?>">
					Trash
					<span class="badge badge-dark ml-2">0</span>
				</a>
			</li>
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2">
			<h6 class="text-muted ml-3" style="font-size: 12px;">
				LABEL
			</h6>
			<li class="nav-item rounded">
				<a href="<?= base_url('projects'); ?>" class="nav-link text-decoration-none">
					📂 Projects
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('customers'); ?>" class="nav-link text-decoration-none">
					👥 Customers
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('companies'); ?>" class="nav-link text-decoration-none">
					🏢 Companies
				</a>
			</li>
		</ul>
	</div>
</div>
