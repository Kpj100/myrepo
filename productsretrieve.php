<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accountdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Select all data from products table
$sql = "SELECT id, product_name, quantity, price, expiration_date, category FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"]. "<br>";
    echo "Product Name: " . $row["product_name"]. "<br>";
    echo "Quantity: " . $row["quantity"]. "<br>";
    echo "Price: " . $row["price"]. "<br>";
    echo "Expiration Date: " . $row["expiration_date"]. "<br>";
    echo "Category: " . $row["category"]. "<br>";
    echo "<br>";
  }
} else {
  echo "0 results";
}

$conn->close();
?>
