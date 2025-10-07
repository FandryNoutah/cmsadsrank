<div class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2">
			<h6 class="text-muted ml-3" style="font-size: 12px;">
				MENU
			</h6>

			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "") ? 'bg-light' : ''; ?>">
					<i class="text-dark mr-2 far fa-envelope<?= ($this->uri->segment(2) == "") ? '-open' : ''; ?>" style="font-size: 18px;"></i>
					Tout les messages
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Note'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Note") ? 'bg-light' : ''; ?>">
					<i class="text-dark mr-2 far fa-envelope<?= ($this->uri->segment(2) == "Note") ? '-open' : ''; ?>" style="font-size: 18px;"></i>
					Note
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Team_task'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Team_task") ? 'bg-light' : ''; ?>">
					<i class="text-dark mr-2 far fa-envelope<?= ($this->uri->segment(2) == "Team_task") ? '-open' : ''; ?>" style="font-size: 18px;"></i>
					Team Task
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Brief'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Brief") ? 'bg-light' : ''; ?>">
					<i class="text-dark mr-2 far fa-envelope<?= ($this->uri->segment(2) == "Brief") ? '-open' : ''; ?>" style="font-size: 18px;"></i>
					Brief
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Temporaire'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Temporaire") ? 'bg-light' : ''; ?>">
					<i class="text-dark mr-2 far fa-envelope<?= ($this->uri->segment(2) == "Temporaire") ? '-open' : ''; ?>" style="font-size: 18px;"></i>
					Temporaire
				</a>
			</li>
			<li class="nav-item rounded">
				<a href="<?= base_url('Discussion/Gtm'); ?>" class="nav-link text-decoration-none <?= ($this->uri->segment(2) == "Gtm") ? 'bg-light' : ''; ?>">
					<i class="text-dark mr-2 far fa-envelope<?= ($this->uri->segment(2) == "Gtm") ? '-open' : ''; ?>" style="font-size: 18px;"></i>
					GTM
				</a>
			</li>
		</ul>
	</div>
</div>
