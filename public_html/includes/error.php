<?php

  /*
    Error Hanlder, passed error messages between pages
  */

  require_once('../includes/session.php');

  function error($message, $redirect=false) {
    $redirect = isset($redirect) ? ('../pages/' . $redirect) : '../index.php';
    $_SESSION['error'] = $message;
    header('Location: ' . $redirect);
  };

?>
