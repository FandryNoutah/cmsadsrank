
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH."/style1.css") ?>">
</head>
<style>
body {
  margin: 0;
  padding: 0;
  background: url('<?php echo base_url("assets/images/5655049.jpg"); ?>') no-repeat center center fixed;
  background-size: cover;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.login-container {
  display: flex;
  width: 800px;
  height: 480px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  border-radius: 10px;
  overflow: hidden;
}

.left-panel {
  flex: 1;
  background-color: #0e1923;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 24px;
  padding: 20px;
}

.right-panel {
  flex: 1;
  background: #ffffffdd;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 40px;
}

.form-wrapper img {
  display: block;
  margin: 0 auto 30px auto;
  width: 150px;
}

.form-item {
  width: 100%;
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
}

.button {
  width: 100%;
  padding: 15px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.button:hover {
  background-color: #2980b9;
}
</style>

<body>
  <div class="login-container">
    <div class="left-panel">
    CRM Client
    </div>

    <div class="right-panel">
    <img src="<?php echo base_url(IMAGES_PATH . "/logo/logo3.png") ?>" alt="Brand Logo" width="150" style=" margin-bottom: 50px; margin-left: 25%;">
      <?php echo $this->session->flashdata('message'); ?>
      <?php echo form_open('', array('class' => 'form-horizontal form-simple')); ?>
       

        <?php echo form_error('identity'); ?>
        <?php echo form_input('identity', '', 'class="form-item" id="user-name" placeholder="Login" required'); ?>

        <?php echo form_error('password'); ?>
        <?php echo form_password('password', '', 'class="form-item" id="user-password" placeholder="Password" required'); ?>

        <button type="submit" class="button"><i class="icon-unlock2"></i> Login</button>
      </div>
      <?php echo form_close(); ?>
  </div>
</body>
