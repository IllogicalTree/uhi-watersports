<?php
  
  /*

    Classes required

  */

  class Category {
    public $category;
    public $imagePath;
    public $discount;
  }

  class Member {
    public $memberNo;
    public $forename;
    public $surname;
    public $street;
    public $town;
    public $postcode;
    public $email;
    public $category;
    public $passwordHash;
  }

  class Order {
    public $orderNo;
    public $memberNo;
  }

  class OrderLine {
    public $orderNo;
    public $stockNo;
    public $quantity;
  }

  class Product {
    public $stockNo;
    public $description;
    public $price;
    public $qtyInStock;
  }

  ?>