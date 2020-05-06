<?php

  /*

    Account page, requires authenticated user

  */

  require_once('../includes/helper.php');
  require_once('../includes/navigation.php');
  
  // Throw an error if no user authenticated
  if (!$user) {
    return error('Log in to gain access to this page', 'index.php');
  }
  
  //Get data
  $member = getMember($user);
  $category = getCategory($member->category);

?>

<h1 class='center-align'>Member Details</h1>

<div class="container">
  <?php if ($error): ?>
    <blockquote> <?= $error ?> </blockquote>
    <?php $_SESSION['error'] = false ?>
  <?php endif; ?>

<?php
  foreach ($member as $key => $value) {
    if ($key !== "passwordHash") {
      echo "$key - $value <br>";
    };
  }
?>

<?php
  foreach ($category as $key => $value) {
    echo "$key - $value <br>";
  }
?>

<img src="../images/<?= $category->imagePath ?>" alt="<?= $category->category?> Category">


