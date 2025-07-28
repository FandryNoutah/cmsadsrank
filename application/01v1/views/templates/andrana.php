<html>
<head>
<title>My Form</title>
</head>
<body>

<?php echo validation_errors(); ?>

<?php echo form_open('andrana'); ?>

<h5>Username</h5>
<input type="text" name="username" value="" size="50" />
<?php echo form_error("username"); ?>

<h5>Password</h5>
<input type="text" name="password" value="" size="50" />
<?php echo form_error("password"); ?>

<h5>Password Confirm</h5>
<input type="text" name="passconf" value="" size="50" />
<?php echo form_error("passconf"); ?>

<h5>Email Address</h5>
<input type="text" name="email" value="" size="50" />
<?php echo form_error("email"); ?>

<h5>Fichier</h5>
<input type="file" name="fichier" value="" size="50" />
<?php echo form_error("fichier"); ?>

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>