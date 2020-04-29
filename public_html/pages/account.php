<?php

  /*

    Account page, requires authenticated user

  */

  require_once('../includes/navigation.php');
  require_once('../includes/helper.php');
  
  // Throw an error if no user authenticated
  echo $user;
  //print_r($member);
  if (!$user) {
    return error('Log in to gain access to this page', 'index.php');
  }
  
  //Get data
  $member = getMember($user);
  $category = getCategory($member->category);

?>

<h1>Member Details</h1>

<?php
  foreach ($member as $key => $value) {
    echo "$key - $value <br>";
  }
?>

<h1>Category Details</h1>
<?php
  foreach ($category as $key => $value) {
    echo "$key - $value <br>";
  }
?>

<img src="../images/<?= $category->imagePath ?>" alt="<?= $category->category?> Category">


