<?php include('server.php'); 
require_once('navigation.php');

$reserve = new Page();
$reserve->pageTitle = "Java Cafe - Reservation";
$reserve->displayPage();
?>
<?php
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
?>

<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( "#datepicker" ).datepicker();
} );
</script>

<script>
function populate(selector) {
  var select = $(selector);
  var hours, minutes, ampm;
  for (var i = 0; i <= 1450; i += 60) {
    hours = Math.floor(i / 60);
    minutes = i % 60;
    if (minutes < 10) {
      minutes = '0' + minutes; // adding leading zero to minutes portion
    }
    //add the value to dropdownlist
    select.append($('<option></option>')
      .attr('value', hours)
      .text(hours + ':' + minutes));
    }
} 

//Calling the function on pageload
window.onload = function (e) {
  populate('#timeDropdownlist');
}
</script>

<div class="header">
  <h3>Make a Reservation</h3>
</div>

<form method="post" action="reservation.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label>Party Size</label>
      <input  onClick="frm" type="number" name="size"  min="1" value="<?php echo $size ?>">
    </div>
    
    <div class="input-group">
      <label>Date</label>
	  <input type="text" id="datepicker">
    </div>
    
    <div class="input-group">
      <label>Time</label>
      <select id="timeDropdownlist"></select>
    </div>
    
    <div class="input-group">
      <button type="submit" class="btn" name="res">Find a Table</button>
    </div>
</form>
