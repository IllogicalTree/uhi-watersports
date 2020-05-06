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

<h1 class='center-align'>Register</h1>

<div class="container">
  <?php if ($error): ?>
    <blockquote> <?= $error ?> </blockquote>
    <?php $_SESSION['error'] = false ?>
  <?php endif; ?>
  <div class="row">
    <form class="col s12" action='/~15027887/methods/registerUser.php' method='post'>
      <div class="row">
        <div class="input-field col s6">
          <input name='forename' id="forename" type="text" class="validate">
          <label for="forename">Forename</label>
        </div>
        <div class="input-field col s6">
          <input name='surname' id="surname" type="text" class="validate">
          <label for="surname">Surname</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input name='email' id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
        <div class="input-field col s6">
          <select name='category'>
            <option value="bronze">Bronze</option>
            <option value="silver">Silver</option>
            <option value="gold">Gold</option>
          </select>
          <label>Category</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s4">
          <input name='street' id="street" type="text" class="validate">
          <label for="street">Street</label>
        </div>
        <div class="input-field col s4">
          <input name='town' id="town" type="text" class="validate">
          <label for="town">Town</label>
        </div>
        <div class="input-field col s4">
          <input name='postcode' id="postcode" type="text" class="validate">
          <label for="postcode">Postcode</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input name='password' id="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
        <div class="input-field col s6">
          <input name='passwordConfirmation' id="passwordConfirmation" type="password" class="validate">
          <label for="passwordConfirmation">Password Confirmation</label>
        </div>
      </div>
      <div class="row">
        <button class="btn green right" type="submit" name="action">
          Register
        </button>
      </div>
    </form>
  </div>  
</div>

<!-- Required for select menu -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems);
});
</script>