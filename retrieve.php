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

// Select all data from customers table
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

$customerData = array();

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    $customerData[] = array(
      "name" => $row["firstname"] . " " . $row["lastname"],
      "gender" => $row["gender"],
      "number" => $row["number"]
    );
  }
}

echo json_encode($customerData);

$conn->close();
?>
