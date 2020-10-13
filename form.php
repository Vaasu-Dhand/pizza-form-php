<?php 
  // Import connect.php
  require("connect.php");

  // Get Variables
  $name = $_POST["name"];
  $pizzaBase = $_POST["pizza_base"];
  $pizzaType = $_POST["pizza_type"];
  $pizzaSize = $_POST["pizza_size"]; 
  $drink = $_POST["drink"];
  $quantityOfDrinks = $_POST["quantity_of_drinks"]; 
  $dessert = $_POST["dessert"];
  $delivery = $_POST["delivery"];
  // echo $name. " , " .$pizzaBase. " , " .$pizzaType. " , " .$pizzaSize. " , "  .$drink. " , " .$quantityOfDrinks . " , " .$dessert. " , " .$delivery
  
  // Total Price Calculation
  $totalPrice;
  // Pizza Size
  if ($pizzaSize === 'small') { 
    $totalPrice = 10;
  } else if ($pizzaSize === 'medium') {
    $totalPrice = 15;
  } else if ($pizzaSize === 'large') {
    $totalPrice = 20;
  }
  // Amount of Drinks
  $drinksPrice = 3 * $quantityOfDrinks;
  $totalPrice += $drinksPrice;
  // Dessert cost
  $totalPrice += 5; 
  $afterTax = $totalPrice * 1.13; // After Tax
  $deliveryCharges;
  if ($delivery === 'yes') {
    $deliveryCharges = 10;
  } else {
    $deliveryCharges = 0;
  }
  $total = $afterTax + $deliveryCharges // Total Price

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papa's Pizza | Order Summary</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="./Favicon.png" />
  <!-- StyleSheet Import -->
  <link rel="stylesheet" href="./style.css" />
</head>
<body>
  <div class="summary form container" style="margin-top: 10px; padding: 20px 40px">
    <h1>Papa's Pizza</h1>
    <h3>Order Summary</h3>
    <div class="flex flex-col">
      <div class="row">
        <span class="left">Customer Name:</span>
        <span class="right"><?php echo $name;?></span>
      </div>
      <div class="row">
        <span class="left">Pizza Base:</span>
        <span class="right"><?php echo $pizzaBase;?></span>
      </div>
      <div class="row">
        <span class="left">Pizza Type:</span>
        <span class="right"><?php echo $pizzaType;?></span>
      </div>
      <div class="row">
        <span class="left">Pizza Size:</span>
        <span class="right"><?php echo $pizzaSize;?></span>
      </div>
      <div class="row">
        <span class="left">Drink:</span>
        <span class="right"><?php echo $drink;?></span>
      </div>
      <div class="row">
        <span class="left">Quantity for Drinks:</span>
        <span class="right"><?php echo $quantityOfDrinks;?></span>
      </div>
      <div class="row">
        <span class="left">Dessert</span>
        <span class="right"><?php echo $dessert;?></span>
      </div>
      <div class="totals">
        <span class="left">Delivery Option:</span>
        <span class="right"><?php echo $delivery;?></span>
      </div>
      <div class="">
        <span class="left">Total Amount Before Tax: </span>
        <span class="right">$<?php echo $totalPrice;?></span>
      </div>
      <div class="">
        <span class="left">Total Amount After Tax: </span>
        <span class="right">$<?php echo $afterTax;?></span>
      </div>
      <div class="totals">
        <span class="left">Delivery Charges: </span>
        <span class="right">+ $<?php echo $deliveryCharges;?></span>
      </div>
      <div class="totals text-yellow">
        <span class="left">Total: </span>
        <span class="right">$<?php echo $total;?></span>
      </div>
    </div>
    <button class="btn" onclick="alert('You should not eat Pizzas!\nThey are not good for Health!😂')">Confirm Order</button>
  </div>
  <?php
    // DB Connect Function
    function dBConnection($hname,$uname,$pswd) {
      try{
        $dbConn = new PDO($hname,$uname,$pswd);
        // ? echo "Successfully connected to DB <br><br>" ;
        return $dbConn;
        } catch (PDOException $ex) {
          echo "connection error ".$ex. "<br><br>";
        }
      } // End of dbConnection
      
    // DB Connection
    $dbc = dBConnection($hostname,$username,$password);

    // Array of values
    $values = array($name, $pizzaBase, $pizzaType, $pizzaSize, $drink, $quantityOfDrinks, $dessert, $delivery, $totalPrice, $afterTax, $deliveryCharges, $total);
    // Insert Data Function
    function insertData($dbConn, $values) {
      // * Prefix's and Suffix's array values with single quotes
      for ($i = 0; $i <= 7; $i++) {
        $values[$i] = "'" .$values[$i]. "'";
      }
      $toSting = implode(",", $values); // Converts the values array to string
      $command="INSERT INTO pizza_order (name, pizzaBase, pizzaType, pizzaSize, drink, quantityOfDrinks, dessert, delivery, totalPrice, afterTax, deliveryCharges, total) VALUES ($toSting)";
      $stmt = $dbConn->prepare($command);
      $exeOK = $stmt->execute(); // Pass the array as a parameter to the execute method  
      // ? echo "exeOK  is " .$exeOK."<br>";
      if($exeOK) {
        // ? echo "INSERT SQL query successfully executed <br><br>";
        }
      else {
        echo "Error executing INSERT SQL query for  record <br><br>";
      }
    }
    insertData($dbc, $values);
?> 
</body>
</html>