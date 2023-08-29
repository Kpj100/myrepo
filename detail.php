<!DOCTYPE html>
<html>
<head>
  <title>Invoice Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f2f2f2;
      padding: 20px;
    }

    h3 {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }

    th {
      background-color: #f8f8f8;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
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
    // Retrieve the input ID
    $input_id = $_GET['input_id'];

    // Sanitize the input ID to prevent SQL injection
    $sanitized_id = $conn->real_escape_string($input_id);

    // Fetch customer details
    $customer_sql = "SELECT * FROM customers WHERE cid = $sanitized_id";
    $customer_result = $conn->query($customer_sql);
    $invoices_sql = "SELECT * FROM invoices WHERE customerID = $sanitized_id";
    $invoices_result = $conn->query($invoices_sql);
    

    if ($customer_result && $invoices_result) {
        if ($customer_result->num_rows > 0) {
            $customer_row = $customer_result->fetch_assoc();
            $customer_firstname = $customer_row['firstname'];
            $customer_lastname = $customer_row['lastname'];
            $customer_gender = $customer_row['gender'];

            // Display customer details
            echo "<h3>Customer ID: $sanitized_id</h3>";
            echo "<h3>Customer Name: $customer_firstname $customer_lastname</h3>";
            echo "<h3>Gender: $customer_gender</h3>";

            // Display invoice details
            echo "<h3>All Transaction History</h3>";
            echo "<table>";
            echo "<tr><th>Invoice Number</th><th>Invoice Date</th><th>Product ID</th><th>Quantity</th><th>Deposit Amount</th><th>Total Amount</th><th>Return Amount</th><th>TxnID</th><th>Status</th>><th>Due-Date</th></tr>";

            while ($invoice_row = $invoices_result->fetch_assoc()) {
                $invoice_number = $invoice_row['invoice_number'];
                $invoice_date = $invoice_row['invoice_date'];
                $product_id = $invoice_row['product_id'];
                $quantity = $invoice_row['quantity'];
                $deposit_amount = $invoice_row['deposit_amount'];
                $total_amount = $invoice_row['total_amount'];
                $return_amount = $invoice_row['return_amount'];
                $txn_id = $invoice_row['Txnid'];
                $status = $invoice_row['stat'];
                $due_date = $invoice_row['due_date'];

                echo "<tr>";
                echo "<td>$invoice_number</td>";
                echo "<td>$invoice_date</td>";
                echo "<td>$product_id</td>";
                echo "<td>$quantity</td>";
                echo "<td>$deposit_amount</td>";
                echo "<td>$total_amount</td>";
                echo "<td>$return_amount</td>";
                echo "<td>$txn_id</td>";
                echo "<td>$status</td>";
                echo "<td>$due_date</td>";
                echo "</tr>";
              

              

                
            }


        } else {
            echo "Customer not found. Please Add First";
        }
    } else {
        echo "Error in query execution: " . $conn->error;
    }

    $conn->close();
}
?>

</body>
</html>
