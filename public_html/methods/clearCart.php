<?php

  /*
    Removes all products from cart
  */

  require_once('../includes/helper.php');

  $_SESSION['cart'] = [];

  // Redirct user back to cart
  header('Location: /~15027887/pages/cart.php');

?>