<?php 

  /*
    Generates a new order in database,  user must be authenticated with items in cart
  */

  require_once('../includes/helper.php');

  // Return error if user not currently authenticated
  if (!$user) {
    return error('No user authenticated', 'cart.php');
  }
  
  // Return error if cart empty
  if (count($cart) < 1) {
   return error('You must have items in your cart before ordering', 'cart.php');
  };

  $orderNo = createOrder($user);

  // Iterate through each item in cart and save item as orderline
  foreach ($cart as $cartItem) {

    // Create order line for cart item
    createOrderLine($orderNo, $cartItem['stockNo'], $cartItem['quantity']);

    // Get all product info for current cart item 
    $product = getProduct($cartItem['stockNo']);
    
    // Calculate new stock by subtracting quantity of item in cart from current stock
    $newQuantity = $product->qtyInStock - $cartItem['quantity'];
    
    // Update database stock with ammended quantity
    updateStock($cartItem['stockNo'], $newQuantity);
  };

  // Remove all items from cart
  $_SESSION['cart'] = [];

  // Redirect to confirmation page with orderNo as reference
  
  header('Location: /~15027887/pages/confirmation.php?orderNo=' . $orderNo);

?>