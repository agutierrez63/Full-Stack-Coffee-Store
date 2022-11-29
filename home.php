<?php session_start();
require_once('navigation.php');

$home = new Page();
$home->pageTitle = "Java Cafe - Home";
$home->headerTitle = "Home";

$home->displayPage();
?>
<link href='style.css' type='text/css' rel='stylesheet'>
<?php echo "<div class='headerTitle'><h1>Java Cafe</h1></div>\n"; ?>
<?php
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
  }
?>
<div class="content">
  <!-- notification message -->
  <?php if (isset($_SESSION['success'])) : ?>
  <div class="error success" >
    <h3>
    <?php
      echo $_SESSION['success'];
      unset($_SESSION['success']);
    ?>
    </h3>
  </div>
  <?php endif ?>

  <!-- logged in user information -->
  <?php  if (isset($_SESSION['username'])) : ?>
    <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    <p><a href="home.php?logout='1'" style="color: red; 
      text-decoration: none">Logout</a></p>
    <!--<p><a href="passwordChange.php" style="color: blue; 
      text-decoration:none">Change Password</a></p>-->
  <?php endif ?>
</div>

<p style=" padding: 80px; text-align: center; color: #FFB566; font-size: 15px;">
Java Cafe is in it's first upcoming year as a <br>start-up business. It recognized 
the fact that a <br>comprehensive, strategic plan is required to ensure <br>
profability and success. Java Cafe offers variety in coffee.<br> The market is need 
of coffee shops that provide<br> refreshment, convenience, and reasonable prices.
</p><br>

<div class="reserve">
  <a style="color: #331a00; text-decoration: none;" 
    href="reservation.php">Make a reservation</a>
</div>
<br><br><p style=" font-size: 15px; text-align: center; color: #A79888;">
1234 Altctrl, Javascript, JS 1011-0000</p>

<?php
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: home.php");
  }
?>
