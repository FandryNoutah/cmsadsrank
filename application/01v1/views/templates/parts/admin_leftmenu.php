<!-- main menu-->
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style4.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/cours.css") ?>">
</head>
<body>
<div class="tete">

<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
      <!--  <input type="text" placeholder="Search" class="menu-search form-control round"/>-->
      </div>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          
			<!--
			<li class=" nav-item">
				<a href="<?php //echo base_url("panneau/liste") ?>">
					<i class="icon-paper"></i>
					<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Panneaux</span>
					<span class="tag tag tag-primary tag-pill float-xs-right mr-2"><?php //echo count($panneaux) ?></span>
				</a>
			</li>
          
			<li class=" nav-item">
				<a href="<?php //echo base_url("flags/liste") ?>">
					<i class="icon-table2"></i>
					<span data-i18n="nav.bootstrap_tables.table_basic" class="menu-title">Flags</span>
					<span class="tag tag tag-primary tag-pill float-xs-right mr-2"><?php //echo count($kiosques) ?></span>
				</a>
			</li>
			-->
		  
		
			<?php //if($current_user ?>
			<?php foreach($users_groups as $groups): ?>	
			 <?php if($groups->id == 1){ ?> 


			<li class=" nav-item">
				<a href="<?php echo base_url("Googleads") ?>">
					<!--<i class="icon-printer3"></i>-->
					<img width="18" src="<?php echo base_url("assets/images/icons/hm_regisseur.png"); ?>" alt="WLB" title="WLB"/>
					<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Fiche Google Ads</span>
				</a>
			</li>
			<li class=" nav-item">
				<a href="<?php echo base_url("Listing") ?>">
					<!--<i class="icon-printer3"></i>-->
					<img width="18" src="<?php echo base_url("assets/images/icons/hm_regisseur.png"); ?>" alt="WLB" title="WLB"/>
					<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">LookerStudio Client</span>
				</a>
			</li>
			<li class=" nav-item">
				<a href="<?php echo base_url("Strategie") ?>">
					<!--<i class="icon-printer3"></i>-->
					<img width="18" src="<?php echo base_url("assets/images/icons/hm_regisseur.png"); ?>" alt="WLB" title="WLB"/>
					<span data-i18n="nav.form_layouts.form_layout_basic" class="menu-title">Teams Task</span>
				</a>
			</li>
			


	
			
			
          
			<?php } ?>
		
			<?php endforeach; ?>
        </ul>
		
		

	</div>

</div>
</div>
</body>
</html>