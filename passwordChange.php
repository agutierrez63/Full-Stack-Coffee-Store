<?php include('server.php'); 
require_once('navigation.php');

$psswdChange = new Page();
$psswdChange->pageTitle = "Java Cafe - Password Change";
$psswdChange->displayPage();

?>

<link rel="stylesheet" type="text/css" href="style.css">
  <div class="header">
    <h3>Change password</h3>
  </div>
  
<form method="POST" action="passwordChange.php">

    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username">
    </div>

    <div class="input-group">
      <label>New Password</label>
      <input type="password" name="password_1">
    </div>
    
    <div class="input-group">
      <label for="input-group">Confirm New Password</label>
      <input type="password"  name="password_2">
    </div>
    
    <button class="btn" type="submit" name="chng_psswd">Change Password</button>
</form>
