<?php

  /* 
    Register page
  */

  require_once('../includes/helper.php');
  require_once('../includes/navigation.php');

  // Return error if user already authenticated
  if ($user) {
    return error('You are already logged in', 'index.php');
  }

?>

<h1>Register</h1>

<form action="/~15027887/methods/registerUser.php" method='post'>

  Email <input type="email" name='email'>
  Forename <input type="text" name='forename'>
  Surname <input type="text" name='surname'>
  Street <input type="text" name='street'>
  Town <input type="text" name='town'>
  Postcode <input type="text" name='postcode'>
  
  Category
  <select name='category'>
    <option value="bronze">Bronze</option>
    <option value="silver">Silver</option>
    <option value="gold">Gold</option>
  </select>

  Password <input type="password" name='password'>
  Password Confirmation <input type="password" name='passwordConfirmation'>

  <input type="submit" value='Register'>
  
</form>
