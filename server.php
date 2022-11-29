<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();
$products = array();

// connect to the database
$db = mysqli_connect('localhost', 'agutierrez', 'Hey8Drejb', 'agutierrez');

// REGISTER USER
if (isset($_POST['reg_user'])) {
    
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure a user does not 
  // already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1); //encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password)
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: home.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: home.php');
  	} else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

//PASSWORD CHANGE
if(isset($_POST['chng_psswd'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    if(md5($password_1) == $_SESSION['username']['password_1']) {
        if(empty($password_2)) {
            $password = $_SESSION['username']['password_1'];
        } else {
            $password = hash('md5', $password_2);
        }

        $query = "UPDATE users SET email='$email', password='$password', 
            WHERE username='$username'";
        $results = mysqli_query($db, $query);
        if(mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
  	        $_SESSION['success'] = "Password Changed Succesfully";
  	        header('location: home.php');
        } else {
            array_push($errors, "Passwords do not match");
        }
    }
}

// SHOPPING CART
// check if Add to Cart button has been submitted
if(filter_input(INPUT_POST, 'add_to_cart')){
    if(isset($_SESSION['shopping_cart'])){
        
        // keep track of how mnay products are in the shopping cart
        $count = count($_SESSION['shopping_cart']);
        
        // create sequantial array for matching array keys to products id's
        $product_ids = array_column($_SESSION['shopping_cart'], 'prod_id');
        
        if (!in_array(filter_input(INPUT_GET, 'prod_id'), $product_ids)){
        $_SESSION['shopping_cart'][$count] = array
            (
                'prod_id' => filter_input(INPUT_GET, 'prod_id'),
                'prod_name' => filter_input(INPUT_POST, 'prod_name'),
                'prod_price' => filter_input(INPUT_POST, 'prod_price'),
                'prod_stock' => filter_input(INPUT_POST, 'prod_stock')
            );   
        }
        else { // product already exists, increase quantity
            // match array key to id of the product being added to the cart
            for ($i = 0; $i < count($product_ids); $i++){
                if ($product_ids[$i] == filter_input(INPUT_GET, 'prod_id')){
                    // add item quantity to the existing product in the array
                    $_SESSION['shopping_cart'][$i]['prod_stock'] += filter_input(INPUT_POST, 'prod_stock');
                }
            }
        }
        
    }
    else { // if shopping cart doesn't exist, create first product with array key 0
        //create array using submitted form data, start from key 0 and fill it with values
        $_SESSION['shopping_cart'][0] = array
        (
            'prod_id' => filter_input(INPUT_GET, 'prod_id'),
            'prod_name' => filter_input(INPUT_POST, 'prod_name'),
            'prod_price' => filter_input(INPUT_POST, 'prod_price'),
            'prod_stock' => filter_input(INPUT_POST, 'prod_stock')
        );
    }
}

if(filter_input(INPUT_GET, 'action') == 'delete'){
    // loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if ($product['prod_id'] == filter_input(INPUT_GET, 'prod_id')){
            // remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    //reset session array keys so they match with $product_ids numeric array
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}

// pre_r($_SESSION);

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}


// CART INFORMATION VALIDATION
function sani($data) {
    return(htmlspecialchars(stripslashes(trim($data))));
}

if (isset($_POST['checkout'])) {
  
  $fname = sani($_POST['fname']);  
  $address = sani($_POST['address']);  
  $city = sani($_POST['city']);  
  $state = sani($_POST['state']);  
  $zip = sani($_POST['zip']);  
  $cname = sani($_POST['cname']);  
  $ccnum = sani($_POST['ccnum']);  
  $expmonth = sani($_POST['expmonth']);  
  $expyear = sani($_POST['expyear']);  
  $cvv = sani($_POST['cvv']);  
  $email = mysqli_real_escape_string($db, $_POST['email']);
  
  if (empty($fname)) { array_push($errors, "Name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($address)) { array_push($errors, "Address is required"); }
  if (empty($city)) { array_push($errors, "City is required"); }
  if (empty($state)) { array_push($errors, "State is required"); }
  if (empty($zip)) { array_push($errors, "Zip Code is required"); }
  if (empty($cname)) { array_push($errors, "Name on credit card is required"); }
  if (empty($ccnum)) { array_push($errors, "Credit card number is required"); }
  if (empty($expmonth)) { array_push($errors, "Experation month number is required"); }
  if (empty($expyear)) { array_push($errors, "Experation year is required"); }
  if (empty($cvv)) { array_push($errors, "CVV is required"); }
}
?>
