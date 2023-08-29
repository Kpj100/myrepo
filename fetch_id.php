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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the input customer ID
    $input_id = $_GET['id'];

    // Sanitize the input customer ID to prevent SQL injection
    $sanitized_id = $conn->real_escape_string($input_id);

    // Fetch customer details
    $customer_sql = "SELECT * FROM customers WHERE cid = $sanitized_id";
    $customer_result = $conn->query($customer_sql);

    if ($customer_result) {
        if ($customer_result->num_rows > 0) {
            // Customer ID is valid, redirect to generate_bill.php with the customer ID
            header("Location: generate_bill.php?id=$sanitized_id");
            exit();
        } else {
            // Customer ID not found, display an error message
            echo "Invalid Customer ID.";
        }
    } else {
        echo "Error in query execution: " . $conn->error;
    }

    $conn->close();
}
?>
