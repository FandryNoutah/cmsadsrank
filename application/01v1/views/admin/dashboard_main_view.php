<?php if($header) echo $header ?>
<?php if($leftmenu && $this->ion_auth->logged_in()) echo $leftmenu ?>
	
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-overlay"><div class="lds-ripple"><div></div><div></div></div></span></div>
			
			<?php if($page) echo $page ?>
		</div>
    </div>

<?php if($footer && $this->ion_auth->logged_in()) echo $footer ?>