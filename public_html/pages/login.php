
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

<h1 class='center-align'>Login</h1>

<div class="container">
  <?php if ($error): ?>
    <blockquote> <?= $error ?> </blockquote>
    <?php $_SESSION['error'] = false ?>
  <?php endif; ?>
  <div class="row">
    <form class="col s12" action='/~15027887/methods/loginUser.php' method='post'>
      <div class="row">
        <div class="input-field col s12">
          <input name='email' id="email" type="text" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input name='password' id="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <button class="btn green right" type="submit" name="action">
          Login
        </button>
      </div>
    </form>
  </div>  
</div>