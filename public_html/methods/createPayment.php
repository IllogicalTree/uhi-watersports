<?php

  /*
    Creates a Stripe one-time payment session, user must be authenticated and cart must not be empty.
  */

  require_once('../includes/helper.php');

  // Return error if no user authenticated
  if (!$user) {
    return error('You must be logged in to view this page', 'cart.php');
  }

  // Return error if cart empty
  if (count($cart) < 1) {
    return error('You must have items in your cart before ordering', 'cart.php');
  }

  // Skip generation of new payment page as cart not changed
  $prevCart = $_SESSION['prevCart'];
  if ($cart == $prevCart) {
    $prevCart = $cart;
    
    // Redirect user directly to payment page
    return header('Location: /~15027887/methods/makePayment.php'); 
  }

  // Set prevCart to cart for later comparison
  $prevCart = $cart;
  
  /*
    Creating a Stripe checkout session requires the use of a private api key to send the require data to Stripe servers.
    
    Given that the website is not being hosted from a secure and private server environment I chose not to send the request directly to Stripe and instead deployed a secure cloud function to relay the data.

    It is for this reason that payments cannot be reliably verified without additional effort, with the current implemtation users can easily bypass the payment by sending a request directly to the checkout method. This should never be done in production.

    The stripe documentation was heavily referenced for this section: https://stripe.com/docs/payments/checkout/one-time
  */

  // Cloud function address
  $url = 'https://us-central1-watersports-266715.cloudfunctions.net/createSession';

  // Initialise empty array of invoiceItems
  $invoiceItems = array();

  // Iterate through each cart item and set invoice fields
  foreach ($_SESSION['cart'] as $cartItem) {

    // Get all product info for current cartItem
    $productData = getProduct($cartItem['stockNo']);

    // Add to invoiceItems with array of required fields
    array_push($invoiceItems, array(
      'name' => $productData->stockNo,
      'description' => $productData->description,
      // Placeholder image site
      'images' => ['https://picsum.photos/200'], 
      // N.B Stripe requires prices as int where last digits are decimals, e.g 100 = £1.00
      'amount' => intval($productData->price*100),  
      'currency' => 'gbp',
      'quantity'=> $cartItem['quantity'])
    );
  }


  // Code for sending post requests shamelessly stolen from stack overflow
  // https://stackoverflow.com/questions/5647461/how-do-i-send-a-post-request-with-php

  // Declare request options
  $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($invoiceItems)
      )
  );

  // Creates and sends request
  $context  = stream_context_create($options);
  $response = file_get_contents($url, false, $context);

  // Return error should request fail
  if ($response === false) {
    return error('Post requested failed');
  }

  // Decode reponse as object and save id value to session variable
  // N.B Session variable used as including Stripe session id within get params exceeds url length limit
  $sessionData = json_decode($response);
  $_SESSION['stripe'] = $sessionData->id;

  // Redirect user to payment page
  header('Location: /~15027887/methods/makePayment.php'); 

?>

