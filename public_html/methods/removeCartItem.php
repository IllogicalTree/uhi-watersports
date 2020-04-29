<?php

  /*
    Attempts to register a new user, requires all user fields 
  */

  require_once('../includes/helper.php');

  // Return error if stockNo not provided
  requiredParam('stockNo', 'cart.php');

  $stockNo = $_POST['stockNo'];

  // Returns index of product in cart with stockNo using array search and array column methods
  // https://www.php.net/manual/en/function.array-search.php  
  // https://www.php.net/manual/en/function.array-column.php

  $itemIndex = array_search($stockNo, array_column($_SESSION['cart'], 'stockNo'));
  
  // Return error if item not in cart
  if ($itemIndex === false) {
    return error('Invalid paramaters passed', 'stock.php');
  }

  // Remove element of given index from cart
  array_splice($_SESSION['cart'], $itemIndex, 1);
  
  // Redirect user to cart page
  header('Location: /~15027887/pages/cart.php'); 

?>
