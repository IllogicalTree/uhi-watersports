
<?php  

  /* 
    Login page, user should not already be authenticated
  */

  require('../includes/helper.php');
  require('../includes/navigation.php') ;

  // Return error if user authenticated

  // require_once('../includes/error.php');

  if ($_SESSION['currentUser']) {
    return error('You are already logged in', 'index.php');
  }
  

?>

<h1>Login</h1>

<?= $error ?>

<form action="/~15027887/methods/loginUser.php" method='post'>

  Email <input type='email' name='email'>
  Password <input type='password' name='password'>

  <input type='submit' value='Login'>

</form>