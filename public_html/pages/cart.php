<?php 

  /*

    Cart page, shows all current cart items

  */

  require_once('../includes/helper.php');
  require_once( '../includes/navigation.php');

  $grandTotal = 0;
?>

<br>
<div class="container">
  <?php if ($error): ?>
    <blockquote> <?= $error ?> </blockquote>
    <?php $_SESSION['error'] = false ?>
  <?php endif; ?>
  
  <?php if (count($cart) < 1): ?>
    <blockquote>Your cart is empty, add some items!</blockquote>
  <?php endif; ?>
  
<?php foreach ($cart as $cartItem): ?>

  <?php
    // Get product data and calculate totals
    $product = getProduct($cartItem['stockNo']);
    $cartItemTotal = $cartItem['quantity'] * $product->price;
    $grandTotal += $cartItemTotal
  ?>

  <div>
    <div> <?= $product->stockNo; ?> </div>
    <div> <?= $product->description; ?> </div>
    <div> <?= '£' . number_format($product->price, 2); ?> </div>
    <form action='/~15027887/methods/addCartItem.php' method='post'>
      <input 
        type='hidden' 
        name='stockNo' 
        value='<?= $cartItem['stockNo'] ?>'
      >
      <input 
        type='number'
        name='quantity' 
        value= <?= $cartItem['quantity'] ?>
        min=1 
        max=40
      >
      <input class='btn green' type='submit' value='Save Changes'>
    </form> 
    <form action='/~15027887/methods/removeCartItem.php' method='post'>
      <input 
        type='hidden' 
        name='stockNo' 
        value='<?= $cartItem['stockNo'] ?>'
      >
      <input class='btn red' type='submit' value='Remove Product'>
    </form> 
  </div>
  <br>
<?php endforeach; ?>

<div>
  <div style='font-weight: bold'> Grand Total: <?= '£' . number_format($grandTotal, 2); ?> </div> <br>
  <a class='btn blue' href="/~15027887/methods/createPayment.php">Check out</a>
  <!--
    As discussed elsewhere, payment implementation is not secure and can be skipped entirely by visiting the correct page

    <a href="/~15027887/methods/checkout.php">Skip Payment</a>
-->
  <a class='btn green' href="stock.php">Add More Products</a>
  <p> Use 4242 4242 4242 4242 as card number on check out</p>
</div>
