<?php session_start();
require_once('navigation.php');
include('server.php'); 
?>

<?php 
$cart = new Page();
$cart->pageTitle = "Java Cafe - Checkout";
$cart->headerTitle = "Checkout";
$cart->displayPage();

if (!isset($_SESSION['username'])) {
	$_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="cartStyle.css">

<div class="row">
  <div class="col-75">
    <div class="container">
      <form method="post" action="home.php" >

        <div style="clear:both"></div>
    <br>
    <div class="table-responsive">
    <table class="table">
    <tr><th colspan="5"><h3>Order Details</h3></th></tr>
    <tr>
      <th style='color: #222' width="40%">Product Name</th>
      <th style='color: #222' width="10%">Quantity</th>
      <th style='color: #222' width="20%">Price</th>
      <th style='color: #222' width="15%">Total</th>
      <th style='color: #222' width="5%">Action</th>
    </tr>
    <?php
      if(!empty($_SESSION['shopping_cart'])):
        $total = 0;
          foreach($_SESSION['shopping_cart'] as $key => $product):

    ?>
    <tr>
      <td style='color: #222'><?php echo $product['prod_name']; ?></td>
      <td style='color: #222'><?php echo $product['prod_stock']; ?></td>
      <td style='color: #222'>$ <?php echo $product['prod_price']; ?></td>
      <td style='color: #222'>$ <?php echo number_format($product['prod_stock'] * $product['prod_price'], 2); ?></td>
      <td>
        <a href="cart.php?action=delete&id=<?php echo $product['prod_id']; ?>">
          <div class="btn-danger">Remove</div>
        </a>
      </td>
    </tr>
    <?php
            $total = $total + ($product['prod_stock'] * $product['prod_price']);
          endforeach;
    ?>
    <tr>
      <td style='color: #222' colspan="3" align="right">Total</td>
      <td style='color: #222' align="right">$ <?php echo number_format($total, 2); ?></td>
      <td></td>
    </tr>
    <tr>
      <!-- Show checkout button only if the shopping cart is not empty -->
      <td colspan="5">
      <?php
        if (isset($_SESSION['shopping_cart'])):
        if (count($_SESSION['shopping_cart']) > 0):
      ?>
      <?php endif; endif; ?>
      </td>
    </tr>
    <?php
        endif;
    ?>
    </table>
    </div>
  
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <?php include ('errors.php');?>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input value="<?php echo $fname; ?>" type="text" id="fname" name="fname" placeholder="Name">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input value="<?php echo $email; ?>" type="text" id="email" name="email" placeholder="Email">
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input value="<?php echo $address; ?>" type="text" id="adr" name="address" placeholder="Address">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" placeholder="City">

            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="State">
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" placeholder="Zip Code">
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cname" placeholder="First Middle Last">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="ccnum" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="Month">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="Year">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="CVV">
              </div>
            </div>
          </div>
          
        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
        </label>
        
        <?php
            if(empty($_SESSION['shopping_cart'])) { 
                $_SESSION['msg'] = "Cart must have at least one item";
            } else {
        ?>
        <input type="submit" value="Continue to checkout"  name="checkout" class="btn">
        <?php
              }
        ?>
      </form>
    </div>
  </div>
</div>

