
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH . "/style4.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH . "/cours.css") ?>">
<style>
	body span {
		color: black ! important;
	}

	.main-menu.menu-dark .navigation>li.hover>a,
	.main-menu.menu-dark .navigation>li:hover>a {
		background-color: #e9e9ed;
		background-color: #E3EBF1! important;
	}

</style>

<div class="tete">

	<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" style="background-color: white! important">
		<!-- main menu header-->
		<div class="main-menu-header">
			<!--  <input type="text" placeholder="Search" class="menu-search form-control round"/>-->
		</div>
		<!-- / main menu header-->
		<!-- main menu content-->
		<div class="main-menu-content">
			<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main" style="background-color: white! important; height: 500px; ">

				<!-- <button  data-toggle="modal" data-target="#inlineNew" style="margin-bottom: 50px;margin-top: 50px;margin-left: 20px; width: 180px; height: 41px; background-color: #4285f4; color: #052740;color: white;  border-radius: 20px;">Nouveau client</button> -->
				<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="color: black; margin-top: 50px! important; margin-left: 25px"><b>Gestion client</b></span>
				<hr>

				<li class=" nav-item">
					<a href="<?php echo base_url("Googleads") ?>">
						<!--<i class="icon-printer3"></i>-->

						<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="font-size: 16px">Onboarding Client</span>
					</a>
				</li>
				<li class=" nav-item">
					<a href="<?php echo base_url("Listing") ?>">
						<!--<i class="icon-printer3"></i>-->

						<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="font-size: 16px">LookerStudio Client</span>
					</a>
				</li>
				<li class=" nav-item">
					<a href="<?php echo base_url("Plan_de_taggage") ?>">
						<!--<i class="icon-printer3"></i>-->

						<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="font-size: 16px">Plan de taggage</span>
					</a>
				</li>
				<li class=" nav-item">
					<a href="<?php echo base_url("Strategie") ?>">
						<!--<i class="icon-printer3"></i>-->

						<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="font-size: 16px">Teams Task</span>
						<?php if($count_non_completed_task != 0): ?>
						<span style="margin-left: 20px; background-color: #dd362e; border-radius: 50%; padding-left: 10px; padding-right: 10px; color: white! important; ">
							<?php echo $count_non_completed_task; ?>
						</span>
						<?php endif; ?>
					</a>
				</li>
				<li class=" nav-item">
					<a href="<?php echo base_url("Upsell") ?>">
						<!--<i class="icon-printer3"></i>-->

						<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="font-size: 16px">Upsell</span>
					</a>
				</li>
				<li class=" nav-item" style="margin-bottom: 50px;">
					<a href="<?php echo base_url("Resiliation") ?>">

						<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="font-size: 16px">Résiliation</span>
					</a>
				</li>
				<div style="margin-left: 20px;">
					<?php foreach ($users_groups as $groups): ?>
						<?php if ($groups->id == 1) { ?>
							<a href="<?php echo base_url('admin/User'); ?>" style=" margin-top: 50px;padding-left: 20px;padding-right: 20px;padding-top: 8px;padding-bottom: 8px;margin-top:20px;margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: #052740;color: white;  border-radius: 20px;">

								<span class="menu-title" style="color: white! important; margin-left: 10px;" data-i18n="nav.form_layouts.form_layout_basic">Customers</span>
							</a>

						<?php } ?>

					<?php endforeach; ?>
				</div>
			</ul>
			<hr>
			<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="color: black; margin-top: 50px! important; margin-left: 25px"><b>Actualité Adsrank</b></span>
			
			<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title" style="color: black; margin-top: 50px! important; margin-left: 25px">All4customer</span>
				
			<img width="75%" style="margin-top: 0px; margin-left: 5px;" src="<?php echo base_url("assets/images/All4Customer.jpg"); ?>" alt="WLB" title="WLB" />

		</div>

	</div>
</div>