
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style1.css") ?>">
</head>
<body>
<div class="cursor">
<?php echo $this->session->flashdata('message');?>
<?php echo form_open('',array('class'=>'form-horizontal form-simple'));?>
<div class="form-wrapper">
  

	<div class="card-title text-xs-center">
                        <div class="p-1"><img src="<?php echo base_url(IMAGES_PATH."/logo/adsrank.png") ?>" alt="Branding logo"></div>
                    </div>
				
                    <div class="card-block">
                        <!--<form class="form-horizontal form-simple" action="index.html" novalidate>-->
							
                            <fieldset class="form-group position-relative has-icon-left mb-0">
							
                                <!--<input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="Your Username" required>-->
                                <?php echo form_error('identity');?>
                                <?php echo form_input('identity','','class="form-item" id="user-name" placeholder="Login" required');?>
                            
								<div class="form-control-position">
                                    <i class="icon-head"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <!--
                                <input type="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Enter Password" required>-->
                    
                                <?php echo form_error('password');?>
                                <?php echo form_password('password','','class="form-item" id="user-password" placeholder="Password" required');?>

                                <div class="form-control-position">
                                    <i class="icon-key3"></i>
                                </div>
                            </fieldset>
                                
                                <!--
                                <div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                    <fieldset>
                                        <input type="checkbox" id="remember-me" class="chk-remember">
                                  <?php echo form_checkbox('remember','1',FALSE, 'id="remember-me" class="yo"');?>
									<fieldset class="remembers">	
									 <label for="remember-me"> Remember me</label>
                                    </fieldset>
                                </div>
								<div class="mouse">
                                <div class="col-md-6 col-xs-12 text-xs-center text-md-right"><a href="recover-password.html" class="mouse">Mot de passe oublié?</a></div>
								</div>  
							</fieldset>-->
							 <div class="mouse">
							 <div class="button-panel">
							 <div class="mouse">
                            <button type="submit" class="button"><i class="icon-unlock2"></i> Login</button>
							</div>
							</div>
						  </div>
						<?php echo form_close();?>
                    </div>
             
    
  
</div>
</div>
</body>
</html>