<?php start_section('stylesheet'); ?>

<style>
	.multi-col {
		column-width: 200px;
		column-fill: auto;
		overflow-x: auto;
	}

	.multi-col>* {
		break-inside: avoid;
	}
</style>

<?php end_section(); ?>

<?php start_section('content'); ?>

<?php foreach ($donnees as $d) : ?>
	<div class="container-fluid p-0 h-100">
		<div class="row no-gutters h-100">

			<nav id="sidebarMenu" class="col-auto p-0 d-md-block sidebar collapse border-right" style="width: 250px;">

				<a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 mb-5" href="javascript:void(0);" style="height: 72px;">
					<img class="logo-full" src="<?= base_url('assets/images/figma/logo-google-ads.png') ?>" alt="" height="72">
				</a>
				<div class="sidebar-sticky">
					<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
						<li class="nav-item rounded">
							<a class="nav-link text-secondary" href="#">
								<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-chartpie.svg') ?>" />
								<span>Menu 1</span>
							</a>
						</li>
						<li class="nav-item rounded">
							<a class="nav-link text-secondary" href="#">
								<img class="mr-2" src="<?= base_url('assets/images/icons/figma/icon-bell.svg') ?>" />
								<span>Menu 2</span>
							</a>
						</li>
					</ul>

					<ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
						<li class="nav-item rounded">
							<a class="nav-link text-secondary" href="#">
								<img class="mr-2" src="<?= base_url('assets/images/icons/figma/chartlineup.svg') ?>" />
								<span>Exemple Menu</span>
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<div class="col">
				<form action='<?= site_url('Client/ajout_campagne/' . $idclients) . "?conversion=$conversion&camp_type=$camp_type&gtm=$gtm" ?>' method="POST">
					<div class="container-fluid pt-4">

						<h5>Campagne Performance Maximum</h5>
						<hr class="my-4">

						<div class="row align-items-center mb-4">
							<div class="col-auto">
								<img src="<?= base_url('assets/images/figma/discu_queue.png') ?>" class="img-thumbnail rounded-circle" width="64">
							</div>
							<div class="col-auto">
								<input type="hidden" name="file">
								<button type="button" class="btn btn-light btn-sm">
									<i class="fa fa-upload"></i>
									Upload Company Logo
								</button>
							</div>
						</div>

						<div class="form-group">
							<label for="nom_campagne_pmax">Nom de la campagne</label>
							<input type="text" class="form-control" name="nom_campagne_pmax" id="nom_campagne_pmax">
						</div>

						<div class="form-group">
							<label for="information_campagne_pmax">Information de la campagne</label>
							<textarea class="form-control" name="information_campagne_pmax" id="information_campagne_pmax"></textarea>
						</div>

						<div class="form-group">
							<label for="url_campagne_pmax">URL de la campagne</label>
							<input type="url" class="form-control" name="url_campagne_pmax" id="url_campagne_pmax">
						</div>

						<div class="form-group">
							<label for="repartition_budget_pmax">Budget de la campagne</label>
							<input type="number" class="form-control" name="repartition_budget_pmax" id="repartition_budget_pmax">
						</div>

						
						<div class="form-group">
							<label>Groupe d'annonce</label>
							<input type="text" class="form-control" name="groupe_annonce[]">
							</div>

						<div class="form-group">
							<label>Saisir des mots-clés du groupe d'annonce</label>
							<textarea name="Mot_cle[]" class="form-control" maxlength="50"></textarea>
						</div>
						

						<div class="form-group">
							<label for="">Quels produits ou services promouvez-vous dans cette campagne ?</label>
							<textarea name="" class="form-control" maxlength="50"></textarea>
						</div>

						<div class="form-group">
							<label for="">En quoi vos produits ou services sont-ils uniques ?</label>
							<textarea name="" class="form-control" maxlength="50"></textarea>
						</div>

						<h5>Paramètres de la campagne</h5>
						<div class="form-group">
							<label for="zone_pmax">Zone géographique</label>
							<input type="text" class="form-control" name="zone_pmax" id="zone_pmax">
						</div>

						<div class="form-group">
							<label for="">Langues</label>
							<select name="" class="form-control">
								<option value="">Lang 1</option>
								<option value="">Lang 2</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Cibles</label>
							<select name="" class="form-control">
								<option value="">Cible 1</option>
								<option value="">Cible 2</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Tranche d'âges</label>
							<select name="" class="form-control">
								<option value="">1</option>
								<option value="">2</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Audiences</label>
							<select name="" class="form-control">
								<option value="">Audience 1</option>
								<option value="">Audience 2</option>
							</select>
						</div>

						<div class="container mb-3">
							<div class="multi-col" style="height: 200px;">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Affinité</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Acheteurs</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Actualités et politique</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Alimentation et restauration</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Banque et finance</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Beauté et bien-être</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Maison et jardinage</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Modes de vie et loisirs</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Médias et divertissement</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Sport et remise en forme</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Technologie</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Voyages</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="" id="" class="custom-control-input">
									<label for="" class="custom-control-label">Véhicules et transports</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="appareil_pmax">Appareil</label>
							<select name="appareil_pmax" id="appareil_pmax" class="form-control">
								<option value="">Appareil 1</option>
								<option value="">Appareil 2</option>
							</select>
						</div>

						<button type="button" class="btn btn-dark btn-sm btn-block mb-5">Suivant</button>

						<ul class="nav nav-tabs mb-3">
							<li class="nav-item">
								<a class="nav-link py-3 active" type="button">
									Propositions de mots-clés à exclure
								</a>
							</li>
						</ul>

						<div class="card bg-light">
							<div class="card-body">
								<div class="multi-col" style="height: 550px;">
									<p class="mb-1">micro entreprise</p>
									<p class="mb-1">auto entrepreneur</p>
									<p class="mb-1">microentreprise</p>
									<p class="mb-1">création entreprise</p>
									<p class="mb-1">freelance</p>
									<p class="mb-1">business plan</p>
									<p class="mb-1">statut juridique</p>
									<p class="mb-1">financement pôle emploi</p>
									<p class="mb-1">prime création</p>
									<p class="mb-1">auto-entrepreneur</p>
									<p class="mb-1">boutique en ligne</p>
									<p class="mb-1">dropshipping</p>
									<p class="mb-1">vinted</p>
									<p class="mb-1">définition</p>
									<p class="mb-1">comment faire</p>
									<p class="mb-1">pdf</p>
									<p class="mb-1">gratuit</p>
									<p class="mb-1">exemple</p>
									<p class="mb-1">livre blanc</p>
									<p class="mb-1">template</p>
									<p class="mb-1">coursseed</p>
									<p class="mb-1">pre seed</p>
									<p class="mb-1">early stage</p>
									<p class="mb-1">incubateur</p>
									<p class="mb-1">accélérateur</p>
									<p class="mb-1">business angel</p>
									<p class="mb-1">levée de fonds seed</p>
								</div>
							</div>
						</div>

						<ul class="nav nav-tabs mb-3">
							<li class="nav-item">
								<a class="nav-link py-3 active" type="button">
									Proposition d'images
								</a>
							</li>
						</ul>

						<div class="card mb-4">
							<div class="card-body">
								<div class="row no-gutters">
									<div class="col-auto px-2 mb-3">
										<img src="<?= base_url('assets/images/formats/betewq5osgluxdan7v5blfsgba.jpg') ?>" alt="" width="120">
									</div>
									<div class="col-auto px-2 mb-3">
										<img src="<?= base_url('assets/images/formats/betewq5osgluxdan7v5blfsgba.jpg') ?>" alt="" width="120">
									</div>
									<div class="col-auto px-2 mb-3">
										<img src="<?= base_url('assets/images/formats/betewq5osgluxdan7v5blfsgba.jpg') ?>" alt="" width="120">
									</div>
									<div class="col-auto px-2 mb-3">
										<img src="<?= base_url('assets/images/formats/betewq5osgluxdan7v5blfsgba.jpg') ?>" alt="" width="120">
									</div>
									<div class="col-auto px-2 mb-3">
										<img src="<?= base_url('assets/images/formats/betewq5osgluxdan7v5blfsgba.jpg') ?>" alt="" width="120">
									</div>
									<div class="col-auto px-2 mb-3">
										<img src="<?= base_url('assets/images/formats/betewq5osgluxdan7v5blfsgba.jpg') ?>" alt="" width="120">
									</div>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-between mb-5">
							<button class="btn btn-outline-dark" type="reset">Ajouter une nouvelle campagne</button>
							<button class="btn btn-dark" type="submit">Terminer</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-auto px-3 pt-5">
				<div class="card mb-3" style="width: 23rem;">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<button class="btn btn-dark py-3 px-5" data-toggle="modal" data-target="#budgetModal">
								<?= $d['budget'] ?> €
							</button>
							<div class="dropdown no-arrow">
								<a href="javascript:void(0);" class="btn btn-light rounded-pill px-3 nav-link dropdown-toggle" id="clientDetailDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-ellipsis-v" style="font-size: 16px;"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="clientDetailDropdown">
									<a class="dropdown-item" href="javscript:void(0);" data-toggle="modal" data-target="#editModal">Modifier</a>
								</div>
							</div>
						</div>
						<br><br>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Date d'anniversaire : <?= $d['mis_en_place_paiement'] ?></span>
						</div>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Date de mise en ligne : <?= $d['annonce'] ?></span>

						</div>
						<div class="d-flex justify-content-start mb-3" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Commerciale</span>
							<span class="mr-2">
								<img src="<?= base_url('assets/images/' . $d['am_photo_user']) ?>" width="24" height="24">
							</span>
						</div>
						<div class="d-flex justify-content-start mb-4" style="font-size: 15px;">
							<i class="fa fa-check-square mr-2" style="color: #f0f0f0ff; font-size: 18px;"></i>
							<span class="mr-2">Account Manager</span>
							<span class="mr-2">
								<img src="<?= base_url('assets/images/' . $d['tech_photo_user']) ?>" width="24" height="24">
							</span>
						</div>
						<a href="<?= base_url('Client/onboarding/' . $d['idclients']) ?>" class="btn btn-outline-dark btn-block">Onboarding</a>
					</div>
				</div>

				<ul class="nav nav-tabs mb-3">
					<li class="nav-item">
						<a class="nav-link py-3 active" type="button">
							Société
						</a>
					</li>
				</ul>

				<div class="card mb-3" style="width: 23rem;">
					<div class="card-body">
						<p class="text-muted font-weight-normal" style="font-size: 15.5px;">
							Meta Platforms, Inc., doing business as Meta and formerly named Facebook, Inc., and TheFacebook, Inc., is an American multinational technology conglomerate based in Menlo Park, California.
							The company owns Facebook, Instagram, and WhatsApp, among other products and services. The company owns Facebook, Instagram, and WhatsApp, among other products and services.The company owns Facebook, Instagram, and WhatsApp, among other products and
						</p>
					</div>
				</div>

				<ul class="nav nav-tabs mb-3">
					<li class="nav-item">
						<a class="nav-link py-3 active" type="button">
							Brief de la campagne
						</a>
					</li>
				</ul>

				<div class="card" style="width: 23rem;">
					<div class="card-body">
						<p class="text-muted font-weight-normal" style="font-size: 15.5px;">
							Meta Platforms, Inc., doing business as Meta and formerly named Facebook, Inc., and TheFacebook, Inc., is an American multinational technology conglomerate based in Menlo Park, California.
							The company owns Facebook, Instagram, and WhatsApp, among other products and services. The company owns Facebook, Instagram, and WhatsApp, among other products and services.The company owns Facebook, Instagram, and WhatsApp, among other products and
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php end_section() ?>
