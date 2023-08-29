<!DOCTYPE html>
<html>
<head>
    <title>Invoice Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .submit-section {
    margin-top: 20px;
    text-align: center;
}

.submit-button {
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit-button:hover {
    background-color: #45a049;
}

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    
    <h2>Invoice Form</h2>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "accountdb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $inserted = false;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the posted data
        $currentDate = $_POST['currentDate'];
        $productID = $_POST['productID'];
        $quantity = $_POST['quantity'];
        $depositAmount = $_POST['depositAmount'];
        $totalAmount = $_POST['totalAmount'];
        $returnAmount = $_POST['returnAmount'];
        $customerID = $_POST['customerID'];
        $availablequantity = $_POST['availablequantity'];
    
        // Calculate the remaining quantity after deduction
        
    
        // ... Rest of your code ...
    
        // Echo the posted data for verification
        echo "Current Date: " . $currentDate . "<br>";
        echo "Product ID: " . $productID . "<br>";
        echo "Quantity: " . $quantity . "<br>";
        echo "Deposit Amount: " . $depositAmount . "<br>";
        echo "Total Amount: " . $totalAmount . "<br>";
        echo "Return Amount: " . $returnAmount . "<br>";
        echo "Customer ID: " . $customerID . "<br>";
        echo "Available Quantity: " . $availablequantity . "<br>";
        
        
        
    
      
        // Validate customer ID existence
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

        if (isset($_POST['submit'])) {
            $currentDate = $_POST['currentDate'];
            $productID = $_POST['productID'];
            $quantity = $_POST['quantity'];
            $depositAmount = $_POST['depositAmount'];
            $totalAmount = $_POST['totalAmount'];
            $returnAmount = $_POST['returnAmount'];
            $customerID = $_POST['customerID'];
            $status = isset($_POST['status']) ? $_POST['status'] : 'unpaid';
            $due_date = $_POST['due_date'];
            $newQuantity = $availablequantity - $quantity;
            // Generate invoice number and txn ID
            $invoiceNumber = "INV" . uniqid();
            $txnID = "TXN" . uniqid();
            
        
                $insertSql = "INSERT INTO invoices (invoice_number, Txnid, invoice_date, product_id, quantity, deposit_amount, total_amount, return_amount, customerID, stat, due_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertSql);
                $stmt->bind_param("sssiiddssss", $invoiceNumber, $txnID, $currentDate, $productID, $quantity, $depositAmount, $totalAmount, $returnAmount, $customerID, $status, $due_date);
                $insertResult = $stmt->execute();
        
            if ($insertResult) {
                    
                   $remainingquantity = $availablequantity - $quantity;
                    $updateProductSql = "UPDATE products SET quantity = ? WHERE id = ?";
                    $updateProductStmt = $conn->prepare($updateProductSql);
                    $updateProductStmt->bind_param("ii", $remainingquantity, $productID);
                    $updateProductResult = $updateProductStmt->execute();
                    $updateProductStmt->close();
                    echo "<p class='success-message'>Success!</p>";
                    echo "Remaining Quantity: " .$remainingquantity. "<br> ";
            } else {
                echo "<p class='error-message'>Error inserting data. Please try again. Error: " . $stmt->error . "</p>";
            }
        }
        
        
    }
    ?>

<div class="submit-section">
    <form action="" method="post">
        <!-- Hidden fields to pass the parameters -->
        <input type="hidden" name="currentDate" value="<?php echo $currentDate; ?>">
        <input type="hidden" name="productID" value="<?php echo $productID; ?>">
        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
        <input type="hidden" name="depositAmount" value="<?php echo $depositAmount; ?>">
        <input type="hidden" name="totalAmount" value="<?php echo $totalAmount; ?>">
        <input type="hidden" name="returnAmount" value="<?php echo $returnAmount; ?>">
        <input type="hidden" name="customerID" value="<?php echo $customerID; ?>">
        <input type="hidden" name="availablequantity" value="<?php echo $availablequantity; ?>">
        <!-- Due Date input field -->
        <label for="due_date">Due Date:</label>
        <input type="date" id="due_date" name="due_date" required><br>
        
        <!-- Submit button -->
        <button class="submit-button" type="submit" name="submit">Checkout</button>
    </form>
</div>
<a href="javascript:history.back()" class="button">Go Back <br></a>

<!-- "Go to Dashboard" button -->
<a href="dashboard.php" class="button">Go to Dashboard</a>


</body>
</html>
