
<?php

  /*
    Confirmation page, requires authenticated user
  */

  require_once('../includes/helper.php');

  // Return error if orderNo not provided
  $orderNo = requiredParamGet('orderNo', 'cart.php', 'get');
  
  // Returns error when anyone other than the member who placed the order attempts to view the invoice
  $memberNo = getMemberNo($orderNo);

  if ($memberNo != $user) {
    //return error($memberNo .getMemberNo($orderNo) , 'cart.php');
    return error('You are not authorised to view this page', 'cart.php');
  };
  

?>

<?php
  $member = getMember($memberNo);
  $category = getCategory($member->category);
  $orderLines = getOrderLines($orderNo);

  $discountRate = $category->discount / 100;
  $imgPath = $category->imagePath;
  $vatRate = 17.5 / 100;
  $total = 0;
?>

<h1> UHI Watersports Club </h1>

<h2>Thank you for your purchase, your order is confirmed below.</h2>

<table>
    <tr> <th> Order Number </th> <th> <?= $orderNo ?> </th> </tr>
    <tr> <th> Customer Number </th> <th> <?= $member->memberNo ?> </th> </tr>
    <tr> <th> Customer Forename </th> <th> <?= $member->forename ?> </th> </tr>
    <tr> <th> Customer Surname </th> <th><?= $member->forename ?> </th> </tr> 
    <tr> <th> Customer Street </th> <th><?= $member->street ?> </th> </tr>
    <tr> <th> Customer Town </th> <th><?= $member->town ?> </th> </tr>
    <tr> <th> Customer Postcode </th> <th><?= $member->postcode ?> </th> </tr>
    <tr> <th> Customer Email Address </th> <th><?= $member->email ?> </th> </tr>
    <tr> <th> Customer Category</th> <th><?= $member->category ?> </th> </tr>
    <tr> 
      <th> Category Image </th> 
      <th> <img src="../images/<?= $category->imagePath ?>" alt="<?= $category->category?> Category"></th>
    </tr>
  </table>

<table>
  <tr> 
    <th>Stock Number</th>
    <th>Stock Description</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
  </tr>

  <?php foreach ($orderLines as $orderLine): ?>

    <?php $orderLineProduct = getProduct($orderLine->stockNo); ?>

    <tr> 
      <th> <?= $orderLine->stockNo ?> </th>
      <th> <?= $orderLineProduct->description ?></th>
      <th> <?= currency($orderLineProduct->price) ?></th>
      <th> <?= $orderLine->quantity ?></th>
      <th> <?= currency($orderLine->quantity * $orderLineProduct->price)   ?></th>
    </tr>

    <?php $total = $total + ($orderLine->quantity * $orderLineProduct->price) ?>

  <?php endforeach ?>
</table>

<?php

  $discount = $discountRate * $total;
  $vat = ($total - $discount) * $vatRate;
  $grandTotal = ($total - $discount) + $vat;

?>

<table>
  <tr> 
    <th>Total</th>
    <th> <?= currency($total) ?> </th>
  </tr>
  <tr> 
    <th>Discount</th>
    <th> <?= currency($discount) ?> </th>
  </tr>
  <tr> 
    <th>VAT</th>
    <th> <?= currency($vat) ?> </th>
  </tr>
  <tr> 
    <th>Grand Total</th>
    <th> <?= currency($grandTotal) ?> </th>
  </tr>
</table>

<style>
  th, td {
    border: 1px solid black;
  }
</style>

<?php // Include button to view pdf copy ?>
<br> <a href= <?= '/~15027887/methods/pdfInvoice.php?orderNo='.$orderNo ?>> 
  View PDF Invoice
</a>
