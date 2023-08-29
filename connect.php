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

// Insert form data into table
$sql = "INSERT INTO customers (cid, firstname, lastname, number, gender)
VALUES ('".$_POST["cid"]."','".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["number"]."', '".$_POST["gender"]."')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>



<a href="dashboard.php" class="btn btn-sucess">go to dasboard</a >

