<?php

  /*
    Attempts to login a user, email and password are required.
  */

  require_once('../includes/helper.php');
  require_once('../includes/error.php');

  // Return error if email and password not provided
  $email = requiredParam('email', 'login.php');
  $password = requiredParam('password', 'login.php');

  // Return error if passwords do not match
  $memberNo = login($email, $password);

  echo $memberNo;

  if (!$memberNo) {
    return error('Invalid credentials', 'login.php');
  }
  
  // Set user session to member number
  $_SESSION["currentUser"] = $memberNo;

  // Redirect user to account page
  header('Location: /~15027887/pages/account.php'); 

?>
