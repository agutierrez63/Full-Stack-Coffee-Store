<?php include('server.php'); 
require_once('navigation.php');

$login = new Page();
$login->pageTitle = "Java Cafe - Login";
$login->displayPage();
?>
<link href='style.css' type='text/css' rel='stylesheet'>
<div class="header">
    <h3>Login</h3>
</div>

<form method="post" action="login.php">
    <?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
      Not yet a member? <a href="register.php">Sign up</a>
  	</p>
</form>
