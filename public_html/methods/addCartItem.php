<?php

  /*
    Serves to add an item to the user cart, stockNo and quantity are required.
  */
  
  require_once('../includes/error.php');
  require_once('../includes/helper.php');

  // Return error when paramaters not set
  $stockNo = requiredParam('stockNo', 'stock.php');
  $quantity = requiredParam('quantity', 'stock.php');

  // Returns index of product in cart with stockNo using array search and array column methods
  // https://www.php.net/manual/en/function.array-search.php  
  // https://www.php.net/manual/en/function.array-column.php

  $itemIndex = array_search($stockNo, array_column($_SESSION['cart'], 'stockNo'));

  $cartItem = [
    'stockNo' => $stockNo,
    'quantity' => $quantity
  ];

  $cartLimit = 3;

  // Where item not already in cart
  if ($itemIndex === false) {
    
    // Return error if cart capacity reached
    if (count($_SESSION['cart']) >= $cartLimit) {
      error('A maximum of '. $cartLimit . ' items are permitted.', 'cart.php');
      return;
    };
    
    // Add cart item to cart session  
    array_push($_SESSION['cart'], $cartItem);

  } else {

    // Overwrite cart item with ammended quantity
    $_SESSION['cart'][$itemIndex] = $cartItem;
  }

  // Redirect user back to cart
  header('Location: /~15027887/pages/cart.php'); 

?>
