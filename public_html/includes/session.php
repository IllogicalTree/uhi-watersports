<?php

  /*
    Ensures all of the required session variables are set, elimates the need to check each time they are used.
  */


  // Starts session only if not already started
  // https://www.php.net/manual/en/function.session-status.php
  
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  $_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

  $_SESSION['currentUser'] = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : null;

  $_SESSION['error'] = isset($_SESSION['error']) ? $_SESSION['error'] : null;

  $_SESSION['stripe'] = isset($_SESSION['stripe']) ? $_SESSION['stripe'] : null;

  $cart = $_SESSION['cart'];
  $user = $_SESSION['currentUser'];
  $error = $_SESSION['error'];
  $stripe = $_SESSION['stripe'];
  
?>