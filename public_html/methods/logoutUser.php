<?php

  /*
    Attempts to log a user out
  */

  require_once('../includes/helper.php');
  require_once('../includes/error.php');

  // Return error if no user authenticated
  if (!$user) {
    return error('You are not logged in', 'cart.php');
  }

  // Clear user and cart sessions
  $_SESSION['currentUser'] = null;
  $_SESSION['cart'] = [];

  // Technically not an error but serves purpose
  return error('Logged out successfully');
?>
