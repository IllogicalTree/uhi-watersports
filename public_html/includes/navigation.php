<?php

  /*
    Navigation bar with error handler required for outputting errors
  */

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UHI Watersports</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<main>
  <body>
    <nav>
      <div class="nav-wrapper blue" >
        <a href="index.php" class="brand-logo">UHI Watersports</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li><a href="stock.php">Stock</a></li>
          <li><a href="cart.php">Cart</a></li>
          <?php 
            if ($_SESSION["currentUser"]) {
              echo '<li><a href="account.php">Account</a></li>';
              echo '<li><a href="/~15027887/methods/logoutUser.php">Sign out</a></li>';
            } else {
              echo '<li><a href="login.php">Login</a></li>';
              echo '<li><a href="register.php">Register</a></li>';
            };
          ?>
        </ul>
      </div>
    </nav>
