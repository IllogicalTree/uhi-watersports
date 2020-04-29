<?php

  /*
    Sends user to Stripe to collect payment, requires stripe session id.
  */

  require_once('../includes/helper.php');

  // Return error if no stripe session
  if (!$_SESSION['stripe']) {
    error('Stripe session not set');
  };

  // Encode Stripe session to be of expected format
  $session = json_encode(array('sessionId' => $_SESSION['stripe']));
?>

<?php

  /*
  N.B There is likely a way to do this entirely in php server side but I couldn't find this documented anywhere.

  Javascript code below taken from Stripe documentation. 
  https://stripe.com/docs/payments/checkout/one-time

  First script imports the required Stripe javascript library.

  The second script initialises stripe using my public key and attempts to redirect the user to a checkout page with the given session data.
  */
?>

<script src="https://js.stripe.com/v3/"></script>

<script>
  var stripe = Stripe('pk_test_Wj0FsBHgHRw4SKmPeiEjnssB00Nswl3Qwg');
  stripe.redirectToCheckout(
    <?= $session ?>
  ).then(function (result) {
    console.log(result.error.message)
  });
</script>