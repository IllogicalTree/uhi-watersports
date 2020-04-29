<?php

  require_once('../includes/connection.php');
  require_once('../includes/error.php');
  require_once('../includes/classes.php');

  // Returns array of object for a given matching field value
  // N.B. Setting  default params as true will return all matches if not specified
  function getData($table, $field=true, $fieldValue=true) {

    global $conn;
    $objects = [];

    // Fetch details of all products
    $query = $conn->query("SELECT * FROM $table WHERE $field = '$fieldValue'");
    
    // Iterate through each product and match fields to product
    while ($row = $query->fetch_assoc()) {

      global $object;

      // Return appropriate class based on table being accessed.
      switch ($table) {
        case 'ECATEGORY':
          $object = new Category();
          break;
        case 'EMEMBER':
          $object = new Member();
          break;
        case 'EORDER':
          $object = new Order();
          break;
        case 'EORDERLINE':
          $object = new OrderLine();
          break;
        case 'ESTOCK':
          $object = new Product();
          break;
      }
      
      // Iterate through row and match fields to object
      foreach ($row as $key => $param) {
        $object->$key = $param;
      }

      // Insert object to array
      array_push($objects, $object);
    }
    
    // Where there is only one match return only that one instead of an array
    $result = count($objects) > 1 ? $objects : $objects[0];
    return $result;

  }  

  function getCategory($category) {
    return getData('ECATEGORY', 'category', $category);
  }  

  function getMember($memberNo) {
    return getData('EMEMBER', 'memberNo', $memberNo);
  };

  function getMemberNo($orderNo) {
    return getData('EORDER', 'orderNo', $orderNo)->memberNo;
  };

  function getOrder($orderNo) {
    return getData('EORDER', 'orderNo', $orderNo);
  };

  function getOrderLines($orderNo) {

    $result = getData('EORDERLINE', "orderNo", $orderNo);

    // Code expects array (even if only 1 orderLine)
    if (count($result) === 1) {
      $result = [$result];
    };

    return $result;
  }

  function getProduct($stockno) {
    return getData('ESTOCK', 'stockNo', $stockno);
  };

  function getProducts() {
    return getData('ESTOCK');
  }

  // Return error if given paramater not set
  function requiredParam($param, $redirect) {
    if (!isset($_POST[$param])) {
      return error("'$param' not set", $redirect);
    }
    return $_POST[$param];
  }

  // Return error if given get paramater not set
  function requiredParamGet($param, $redirect) {
    if (!isset($_GET[$param])) {
      return error("'$param' not set", $redirect);
    }
    return $_GET[$param];
  }

  //Format number as currency
  function currency($price) {
    // Format prices appropriately, makes use of number_format
    // https://www.php.net/manual/en/function.number-format.php
    return '£' . number_format($price, 2);
  }

  function createOrder($memberNo) {
    global $conn;

    // Create new database entry for order for current user
    $createOrder = "INSERT INTO EORDER (memberNo) VALUES ('$memberNo')";

    // Return error should query fail
    if ($conn->query($createOrder) != TRUE) {
      return error('Failed to create order');
    }

    // Return automatically generated id
    // https://www.php.net/manual/en/mysqli.insert-id.php
    return $conn->insert_id;
  }

  function createOrderLine($orderNo, $stockNo,  $quantity) {
    global $conn;

    $query = "INSERT INTO EORDERLINE (orderNo, stockNo, quantity) VALUES ('$orderNo', '$stockNo', '$quantity')";

    // Return error should query fail
    if ($conn->query($query) != TRUE) {
      return error('Failed to create order line');
    }
  }

  function updateStock($stockNo, $newQuantity) {
    global $conn;

    $adjustStock = "UPDATE ESTOCK SET qtyInStock= $newQuantity WHERE stockNo='$stockNo'";
  
    // Return error should query fail
    if ($conn->query($adjustStock) != TRUE) {
      return error("Failed to adjust stock");
    }
  }

  function checkUserExists($email) {
    global $conn;

    $query = "SELECT email FROM EMEMBER WHERE email='$email'";
    $result = $conn->query($query);

    return $result;
  }

  function addUser($forename, $surname, $street, $town, $postcode, $email, $category, $password) {

    global $conn;

    // Hash password using bcrypt functionality
    // https://www.php.net/manual/en/function.password-hash.php

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO EMEMBER (forename, surname, street, town, postcode, email, category, passwordHash) VALUES ('$forename', '$surname', '$street','$town', '$postcode', '$email', '$category', '$passwordHash')";

    if ($conn->query($query) != TRUE) {
      return error('Failed to add user');
    }

    // Get memberNo from last insert id variable
    // https://www.php.net/manual/en/mysqli.insert-id.php
    $memberNo = $conn->insert_id;

    return $memberNo;
  }

  function login($email, $password) {

    global $conn;

    $findUser = $conn->query("SELECT * FROM EMEMBER WHERE email = '$email'");
    
    $row = $findUser->fetch_assoc();

    // Check provided password with database stored hash
    // https://www.php.net/manual/en/function.password-verify.php
    $match = password_verify($password, $row['passwordHash']);
    
    return $match ? $row['memberNo'] : false;
  }






?>
