<?php

  /*
    Generates a pdf invoice to be displayed to the user
  */
  
  require_once('../includes/helper.php');

  // Returns error when orderNo not provided
  requiredParamGet('orderNo', 'cart.php');

  $orderNo = $_GET['orderNo'];

  // Returns error when anyone other than the member who placed the order attempts to view the invoice
  if (getMemberNo($orderNo) != $_SESSION['currentUser']) {
    return error('You are not authorised to view this page', 'cart.php');
  };

  $memberNo = getMemberNo($orderNo);
  $member = getMember($memberNo);
  $category = getCategory($member->category);
  $orderLines = getOrderLines($orderNo);

  $discountRate = $category->discount / 100;
  $imgPath = $category->imagePath;
  $vatRate = 17.5 / 100;
  $total = 0;

  // For pdf functionality I am making use of the tcpdf library https://github.com/tecnickcom/tcpdf , most of the code below was taken from the provided documentation. 

  // Import pdf library
  require_once('../tcpdf/tcpdf.php');

  // Create new pdf 
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // Set document metadata and disable default header and footer
  $pdf->SetCreator('UHI Watersports');
  $pdf->SetAuthor('UHI Watersports');
  $pdf->SetTitle('Invoice for order '. $orderNo . ' '. $member->$memberNo);
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);

  $pdf->AddPage();

  $imgSrc = "../images/" . $category->imagePath;
  $imgAlt = $category->category . " Category";

  // Start a html 'document' that will be used to generate pdf
  $html = "
  <h1> UHI Watersports Club</h1>

  <table>
    <tr> <th>Order Number</th> <th> $orderNo </th> </tr>
    <tr> <th>Customer Number</th> <th> $member->memberNo </th></tr>
    <tr> <th>Customer Forename</th> <th> $member->forename </th></tr>
    <tr> <th>Customer Surname</th> <th> $member->forename </th></tr> 
    <tr> <th>Customer Street</th> <th> $member->street </th></tr>
    <tr> <th>Customer Town</th> <th> $member->town </th></tr>
    <tr> <th>Customer Postcode</th> <th> $member->postcode </th></tr>
    <tr> <th>Customer Email Address</th> <th> $member->email </th></tr>
    <tr> <th>Customer Category</th> <th> $member->category</th></tr>
  </table>

  <table>
    <tr> 
      <th>Stock Number</th>
      <th>Stock Description</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total</th>
    </tr>
  ";

  foreach ($orderLines as $orderLine) {

    $orderLineProduct = getProduct($orderLine->stockNo);

    // Append 'document' with orderLine details
    $formattedPrice = currency($orderLineProduct->price);
    $formattedTotal = currency($orderLine->quantity * $orderLineProduct->price);
    $html .=  "
    <tr> 
      <th> $orderLine->stockNo </th>
      <th> $orderLineProduct->description </th>
      <th> $formattedPrice </th>
      <th> $orderLine->quantity </th>
      <th> $formattedTotal  </th>
    </tr>
    ";

    $total = $total + ($orderLine->quantity * $orderLineProduct->price);

  };
  
  $discount = $discountRate * $total;
  $formattedDiscount = currency($discount);
  $vat =($total - $discount) * $vatRate;
  
  $formattedVAT = currency($vat);
  $grandTotal = currency(($total - $discount) + $vat);

  $html .= "
  </table>

  <table>
    <tr> 
      <th>Total</th>
      <th> $formattedTotal </th>
    </tr>
    <tr> 
      <th>Discount</th>
      <th> $formattedDiscount </th>
    </tr>
    <tr> 
      <th>VAT</th>
      <th> $formattedVAT </th>
    </tr>
    <tr> 
      <th>Grand Total</th>
      <th> $grandTotal </th>
    </tr>
  </table>
  <style>
    th, td {
      border: 1px solid black;
    }
  </style>
  ";

  // Write html to pdf and output to user
  $pdf->writeHTML($html, true, false, true, false, '');
  $pdf->Output('Invoice.pdf', 'I');

?>
