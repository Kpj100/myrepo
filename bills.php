<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "accountdb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve bill details from HTML form
$bill_number = $_POST['bill_number'];
$vendor_id = $_POST['vendor_id'];
$amount = $_POST['amount'];
$due_date = $_POST['due_date'];
$status = $_POST['status'];

// Insert data into bills table
$sql = "INSERT INTO bills (bill_number, vendor_id, amount, due_date, status)
        VALUES ('$bill_number', $vendor_id, $amount, '$due_date', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "New bill inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


<a href="dashboard.php" class="btn btn-sucess">go to dashboard</a >