<style>
	.sidebar span{
		color: #282a2c;
	}

</style>
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
				<a class="nav-link text-secondary" href="#gtm">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
					<span>Mise en place GTM</span>
				</a>
			</li>
			<li class="nav-item rounded">
				<a class="nav-link text-secondary" href="#campagne">
					<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
					<span>Ajout campagne</span>
				</a>
			</li>
		</ul>

	</div>
	<li class="nav-item rounded" style="margin-top: 40px;">
	<span style="margin-left: 40px; font-size: 16px; "><b>Synthèse du budget</b></span>

	
	
		
    <a class="nav-link text-secondary"  style="margin-top: 40px;">
		<span><b>Budget total: <?= (float)$donnees[0]['budget'] ?> € </b></span><br>
        <hr>

        <?php if (!empty($donne_valider)): ?>
            <span><b>Répartition du budget par campagne</b></span><br>
            <hr>

            <?php 
            // Calcul du total des budgets de campagnes validées
            $totalCampagnes = 0;
            foreach ($donne_valider as $campagne) {
                $totalCampagnes += isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0;
            }
            ?>

            <?php foreach ($donne_valider as $campagne): ?>
                <p>
                    <b><?= htmlspecialchars($campagne['nom_campagne']) ?> :</b> 
                    <?= isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0 ?> € 
                </p>
            <?php endforeach; ?>

            <hr>
            <p><b>Total des budgets de campagnes :</b> <?= $totalCampagnes ?> €</p>

            <?php if ($totalCampagnes > (float)$donnees[0]['budget']): ?>
                <div class="alert alert-danger" role="alert">
                    ⚠️ Attention : le total des budgets de campagnes (<?= $totalCampagnes ?> €)
                    dépasse le budget total autorisé (<?= (float)$donnees[0]['budget'] ?> €) !
                </div>

            <?php elseif ($totalCampagnes == (float)$donnees[0]['budget']): ?>
                <div class="alert alert-success" role="alert">
                    ✅ Parfait : le total des budgets de campagnes est exactement égal au budget total (<?= $totalCampagnes ?> €) !
                </div>

            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    ⚠️ Il reste encore du budget à utiliser : 
                    <?= (float)$donnees[0]['budget'] - $totalCampagnes ?> € sur <?= (float)$donnees[0]['budget'] ?> €.
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </a>
</li>



</nav>
