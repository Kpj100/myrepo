<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payLater'])) {
  // Retrieve the form data
  $currentDate = $_POST['currentDate'];
  $productID = $_POST['productID'];
  $quantity = $_POST['quantity'];
  $depositAmount = $_POST['depositAmount'];
  $totalAmount = $_POST['totalAmount'];
  $returnAmount = $_POST['returnAmount'];
  $customerID = $_POST['customerID']; // Added line

  // Insert the bill details into the invoices table
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

  // Check if the customer ID exists in the customers table
  $checkSql = "SELECT * FROM customers WHERE cid = ?";
  $checkStmt = $conn->prepare($checkSql);
  $checkStmt->bind_param("i", $customerID);
  $checkStmt->execute();
  $checkResult = $checkStmt->get_result();

  if ($checkResult->num_rows === 0) {
    echo "Error: Customer not found";
    $checkStmt->close();
    $conn->close();
    exit();
  }


  

  $insertSql = "INSERT INTO invoices (invoice_date,product_id, quantity, deposit_amount, total_amount, return_amount, customerID) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($insertSql);
  $stmt->bind_param("siiiiii", $currentDate, $productID, $quantity, $depositAmount, $totalAmount, $returnAmount, $customerID);
  

  // Execute the prepared statement
  if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    // Redirect to invoice.html
    header("Location: invoice3.html");
    exit();
  } else {
    echo "Error storing bill details: " . $conn->error;
  }
  // Add a hyperlink to the dashboard
  echo "<a href='dashboard.php' class='dashboard-link'>Go to dashboard</a><br>";
  // Add a hyperlink to go back
  echo "<a href='javascript:history.go(-1)' class='previous-page-link'>Go Back</a><br>";
  $stmt->close();
  $conn->close();
  
}
?>
