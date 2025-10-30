<nav class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">
	<div class="sidebar-sticky">
		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<!-- <h6 class="sidebartext-muted font-weight-light ml-3" style="font-size: 12px;">
				Titre 1
			</h6> -->
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#information">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
					<span>Information client</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#brief">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
					<span>Brief</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#gtm">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
					<span>Mise en place GTM</span>
				</a>
			</li>
		</ul>

		<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
			<!-- <h6 class="sidebartext-muted font-weight-light ml-3" style="font-size: 12px;">
				Titre 2
			</h6> -->
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#campagne">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
					<span>Création de campagne</span>
				</a>
			</li>
		</ul>
	</div>
	
										
	
	<li class="nav-item rounded" style="margin-top: 300px;">
			<a class="nav-link text-secondary" href="#campagne">
			Budgets total: <b><?= $donnees[0]['budget'] ?> €</b>
			<?php if(!empty($donne_valider)):  ?>
			<span>Récapitulation budgets campagne</span>
	
	
	<?php foreach ($donne_valider as $campagne): ?>
	<p>	<?= htmlspecialchars($campagne['nom_campagne']) ?> : </br>	
	<?= isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0 ?> €
	</p>
	<?php endforeach; ?>
	</a>
	</li>
	<?php endif; ?>
</nav>
