<?php

  /*
    Attempts to register a new user, requires all user fields 
  */

  require_once('../includes/helper.php');

  // Returns error should any paramater not be provided
  $email = requiredParam('email', 'register.php');
  $forename = requiredParam('forename', 'register.php');
  $surname = requiredParam('surname', 'register.php');
  $street = requiredParam('street', 'register.php');
  $town = requiredParam('town', 'register.php');
  $postcode = requiredParam('postcode', 'register.php');
  $category = requiredParam('category', 'register.php');
  $password = requiredParam('password', 'register.php');
  $passwordConfirmation = requiredParam('passwordConfirmation', 'register.php');

  // Returns error if password and password confirmation differ
  if (!($password === $passwordConfirmation)) {
    return error('Passwords do not match', 'register.php');
  };

  // Queries database for a user with given email
  $result = checkUserExists($email);

  // Returns error where account already exists
  if ($result->num_rows > 0) {
    return error('Account already exists', 'register.php');
  };

  // Add user to database
  $memberNo = addUser($forename, $surname, $street, $town, $postcode, $email, $category, $password);

  $_SESSION['currentUser'] = $memberNo;
  
  // Redirect user to account page
  header('Location: /~15027887/pages/account.php'); 
  
?>
