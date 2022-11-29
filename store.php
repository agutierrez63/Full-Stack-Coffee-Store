<?php session_start();
require_once('navigation.php');
include('server.php');

$store = new Page();
$store->pageTitle = "Java Cafe - Store";
$store->displayPage();
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="storeStyle.css" />
  
<div class="container">
    <h3 style='border-style: ridge'>Store Items</h3>
    <?php

    $connect = mysqli_connect('localhost', 'agutierrez', 'Hey8Drejb', 'agutierrez');
    $query = 'SELECT * FROM CoffeeProducts ORDER by prod_id ASC';
    $result = mysqli_query($connect, $query);

    if ($result):
      if(mysqli_num_rows($result)>0):
        while($product = mysqli_fetch_assoc($result)):
          //print_r($product);
    ?>
    <div class="col-sm-4 col-md-3" >
      <form method="post" action="store.php?action=add&id=<?php echo $product['prod_id']; ?>">
        <div class="products">
          <img src="<?php echo $product['prod_img']; ?>"  style='height: 180px; width: 220px;' class="img-responsive" />
          <h4 class="text-info"><?php echo $product['prod_name']; ?></h4>
          <h4>$ <?php echo $product['prod_price']; ?></h4>
          <input type="text" name="prod_stock" class="form-control" value="1" />
          <input type="hidden" name="prod_name" value="<?php echo $product['prod_name']; ?>" />
          <input type="hidden" name="prod_price" value="<?php echo $product['prod_price']; ?>" />
          <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart" />
        </div>
      </form>
    </div>
    <?php
        endwhile;
      endif;
    endif;   
    ?>
    <div style="clear:both"></div>  
    <br />  
    <div class="table-responsive">  
    <table class="table">  
    <tr><th colspan="5"><h3>Order Details</h3></th></tr>   
    <tr>  
      <th style='color: #F8F8FF' width="40%">Product Name</th>  
      <th style='color: #F8F8FF' width="10%">Quantity</th>  
      <th style='color: #F8F8FF' width="20%">Price</th>  
      <th style='color: #F8F8FF' width="15%">Total</th>  
      <th style='color: #F8F8FF' width="5%">Action</th>  
    </tr>  
    <?php   
      if(!empty($_SESSION['shopping_cart'])):  
        $total = 0;  
          foreach($_SESSION['shopping_cart'] as $key => $product):
            
    ?>  
    <tr>  
      <td style='color: #F8F8FF'><?php echo $product['prod_name']; ?></td>  
      <td style='color: #F8F8FF'><?php echo $product['prod_stock']; ?></td>  
      <td style='color: #F8F8FF'>$ <?php echo $product['prod_price']; ?></td>  
      <td style='color: #F8F8FF'>$ <?php echo number_format($product['prod_stock'] * $product['prod_price'], 2); ?></td>  
      <td>
        <a href="store.php?action=delete&id=<?php echo $product['prod_id']; ?>">
          <div class="btn-danger">Remove</div>
        </a>
      </td>  
    </tr>  
    <?php  
            $total = $total + ($product['prod_stock'] * $product['prod_price']);  
          endforeach;  
    ?>  
    <tr>  
      <td style='color: #F8F8FF' colspan="3" align="right">Total</td>  
      <td style='color: #F8F8FF' align="right">$ <?php echo number_format($total, 2); ?></td>  
      <td></td>  
    </tr>  
    <tr>
      <!-- Show checkout button only if the shopping cart is not empty -->
      <td colspan="5">
      <?php 
        if (isset($_SESSION['shopping_cart'])):
        if (count($_SESSION['shopping_cart']) > 0):
      ?>
      <a href="cart.php" class="button">Proceed to Cart</a>
      <?php endif; endif; ?>
      </td>
    </tr>
    <?php  
      endif;
    ?>  
    </table>  
    </div>
</div>
