<?php

  /*
    Provides access to $conn variable containing database connection configuration
  */
  
  $host = "comp-server.uhi.ac.uk";
  $username = "USERNAME"; 
  $password = "PASSWORD";
  $database = "DATABASE";

  $conn = new mysqli($host, $username,$password, $database);
  if($conn->connect_error) {
    die('Database connection failure');
  }
?>
