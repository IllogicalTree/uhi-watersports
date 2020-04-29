<?php

  /* 
    Stock page
  */

  require_once('../includes/helper.php');
  require_once('../includes/navigation.php');

  // Array containing objects of each product
  $products = getProducts();

?>

<?php require_once('../includes/error.php') ?>

<?php foreach ($products as $product): ?>

  <form action="/~15027887/methods/addCartItem.php" method='post'>
    <div> <?= $product->stockNo ?> </div>
    <div> <?= $product->description ?> </div>
    <div> <?= $product->price ?> </div>
    <div> <?= $product->qtyInStock ?> </div>
    
    <input type='hidden' name='action' value='add'>
    <input
      type="hidden"
      name='stockNo'
      value='<?= $product->stockNo ?>'
    >
    <input
      type="number"
      name='quantity'
      value=1 
      min=1 
      max=<?= $product->qtyInStock ?>
    >
    <input type="submit" value='Add to cart'>
  </form>
  <br>

<?php endforeach; ?>