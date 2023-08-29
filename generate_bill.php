<!DOCTYPE html>
<html>
<head>
    <title>Generated Bill</title>
    <link rel="stylesheet" type="text/css" href="stylebill.css">
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .error-message {
            color: #f00;
            font-weight: bold;
            margin-top: 20px;
        }

        .success-message {
            color: #0f0;
            font-weight: bold;
            margin-top: 20px;
        }
        .checkout-button {
            background-color: #f39c12;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0;
            animation: fade-in 1s ease forwards;
            transition: background-color 0.3s ease;
        }

        .checkout-button:hover {
            background-color: #e67e22;
        }

        .pay-now-section,
        .pay-later-section {
            margin-top: 30px;
        }

        .pay-now-section h3,
        .pay-later-section h3 {
            margin-bottom: 10px;
        }

        .pay-now-section form,
        .pay-later-section form {
            display: inline-block;
        }

        .pay-now-section form button,
        .pay-later-section form button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0;
            animation: fade-in 1s ease forwards;
        }

        .pay-now-section form button:hover,
        .pay-later-section form button:hover {
            background-color: #45a049;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dashboard-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
        }

        .previous-page-link {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $productID = $_POST['product-id'];
        $quantity = $_POST['quantity'];
        $depositAmount = $_POST['amount'];
        $customerID = $_POST['customerID'];

        // Fetch the product price from the database based on the product ID
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

        // Prepare the SQL statement to fetch customer data
        $customerSql = "SELECT firstname, lastname FROM customers WHERE cid = ?";
        $customerStmt = $conn->prepare($customerSql);
        $customerStmt->bind_param("i", $customerID);

        // Execute the prepared statement to fetch customer data
        $customerStmt->execute();

        // Get the result
        $customerResult = $customerStmt->get_result();

        if ($customerResult->num_rows > 0) {
            $customerRow = $customerResult->fetch_assoc();
            $firstName = $customerRow["firstname"];
            $lastName = $customerRow["lastname"];

            // Prepare the SQL statement to fetch product data
            $productSql = "SELECT price, quantity FROM products WHERE id = ?";
            $productStmt = $conn->prepare($productSql);
            $productStmt->bind_param("i", $productID);

            // Execute the prepared statement to fetch product data
            $productStmt->execute();

            // Get the result
            $productResult = $productStmt->get_result();

            if ($productResult->num_rows > 0) {
                $productRow = $productResult->fetch_assoc();
                $price = $productRow["price"];
                $availableQuantity = $productRow["quantity"];

                // Check if there is enough quantity available to fulfill the order
                if ($availableQuantity < $quantity) {
                    echo "<div class='error-message'>Insufficient quantity available. Please try again with a lower quantity.</div>";
                } else {
                    // Calculate the total amount
                    $totalAmount = $quantity * $price;

                    // Calculate the return amount
                    $returnAmount = $depositAmount - $totalAmount;

                    if ($returnAmount >= 0) {
                        // Check if the "Checkout" button is clicked
                        if (isset($_POST['checkout'])) {
                            // Deduct the quantity from the database

                            $updateSql = "UPDATE products SET quantity = ? WHERE id = ?";
                            $updateStmt = $conn->prepare($updateSql);
                            $updateStmt->bind_param("ii", $newQuantity, $productID);
                            $updateResult = $updateStmt->execute();
                            $updateStmt->close();
                            
                            if ($updateResult) {
                                // Quantity deducted successfully
                                echo "<div class='success-message'>Quantity deducted successfully. Your order has been processed.</div>";
                            } else {
                                // Quantity deduction failed
                                echo "<div class='error-message'>Failed to deduct quantity. Please try again.</div>";
                            }
                             // Recalculate the remaining quantity after deduction
                          $remainingQuantity = $availableQuantity - $quantity;
               
                         
                          $currentDate = date("Y-m-d");
                          
                          $productID = $_POST['product-id'];
                          $quantity = $_POST['quantity'];
                          $depositAmount = $_POST['amount'];
                          $totalAmount = $totalAmount;
                          $returnAmount = $returnAmount;
                          $customerID = $_POST['customerID'];
                          $status = isset($_POST['status']) ? $_POST['status'] : 'paid';

                          $invoiceNumber = "INV" . uniqid();
                          $txnID = "TXN" . uniqid(); 
                          
                          // Insert data into the database
                          $insertSql = "INSERT INTO invoices (invoice_number,Txnid, invoice_date, product_id, quantity, deposit_amount, total_amount, return_amount,  stat, customerID)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $insertStmt = $conn->prepare($insertSql);
                            $insertStmt->bind_param("sssiiddsss", $invoiceNumber,$txnID, $currentDate, $productID, $quantity, $depositAmount, $totalAmount, $returnAmount,  $status, $customerID);
                            $insertResult = $insertStmt->execute();
                          
            
            

                          $insertStmt->close();
                          if ($insertResult) {
                            $newQuantity = $availableQuantity - $quantity;
                        
                            $updateProductSql = "UPDATE products SET quantity = ? WHERE id = ?";
                            $updateProductStmt = $conn->prepare($updateProductSql);
                            $updateProductStmt->bind_param("ii", $newQuantity, $productID);
                            $updateProductResult = $updateProductStmt->execute();
                            $updateProductStmt->close();
                          }

                            }
                            // Display the "Remaining Quantity" section after the deduction
                            if (isset($remainingQuantity)) {
                                echo "<div class='remaining-quantity-section'>";
                                echo "<h3>Remaining Quantity: " . $remainingQuantity . "</h3>";
                                echo "</div>";
                            }

                           

                        $currentDate = date("Y-m-d");
                        // Display the generated bill and return amount
                        echo "<div class='bill-container'>";
                        echo "<div class='bill-container'>";
                        echo "<div class='bill-header'>";
                        echo "<h2>DANFE MUNAL GRILL SHOP</h2>";
                        echo "<h3>Generated Bill</h3>";
                        echo "</div>";
                        echo "<div class='bill-details'>";
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Customer Name:</th>";
                        echo "<td>" . $firstName . " " . $lastName . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Date:</th>";
                        echo "<td>" . $currentDate . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Product ID:</th>";
                        echo "<td>" . $productID . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Order Quantity:</th>";
                        echo "<td>" . $quantity . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Deposit Amount:</th>";
                        echo "<td>$" . $depositAmount . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Total Amount:</th>";
                        echo "<td>$" . $totalAmount . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>Return Amount:</th>";
                        echo "<td>$" . $returnAmount . "</td>";
                        echo "</tr>";
                       
                        echo "</table>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";

                        // Display the payment sections
                          // Display the "Checkout" button before the "Pay Now" button
                        
                        echo "<h3>Pay Now</h3>";
                        echo "<div class='checkout-section'>";
                        echo "<form action='' method='post'>";
                        echo "<input type='hidden' name='product-id' value='" . $productID . "'>";
                        echo "<input type='hidden' name='quantity' value='" . $quantity . "'>";
                        echo "<input type='hidden' name='amount' value='" . $depositAmount . "'>";
                        echo "<input type='hidden' name='customerID' value='" . $customerID . "'>";
                        echo "<button class='checkout-button' type='submit' name='checkout'>Checkout</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "<div class='pay-now-section'>";
                        // Add a button to save as PDF
                        echo "<form action='save_pdf.php' method='post'>";
                        echo "<input type='hidden' name='Name' value='" . $currentDate . "'>";
                        echo "<input type='hidden' name='currentDate' value='" . $currentDate . "'>";
                        echo "<input type='hidden' name='productID' value='" . $productID . "'>";
                        echo "<input type='hidden' name='quantity' value='" . $quantity . "'>";
                        echo "<input type='hidden' name='depositAmount' value='" . $depositAmount . "'>";
                        echo "<input type='hidden' name='totalAmount' value='" . $totalAmount . "'>";
                        echo "<input type='hidden' name='returnAmount' value='" . $returnAmount . "'>";
                        echo "<button type='submit' name='savePDF'>Save as PDF</button><br>";
                        echo "</form>";
                        echo "</div>";
                        echo "Payment Type: Cash<br><br>";

                        // Pay Later Section
                        echo "<div class='pay-later-section'>";
                        echo "<h3>Pay Later</h3>";
                        echo "<form action='invoice3.php' method='post'>";
                        echo "<input type='hidden' name='currentDate' value='" . $currentDate . "'>";
                        echo "<input type='hidden' name='productID' value='" . $productID . "'>";
                        echo "<input type='hidden' name='quantity' value='" . $quantity . "'>";
                        echo "<input type='hidden' name='depositAmount' value='" . $depositAmount . "'>";
                        echo "<input type='hidden' name='totalAmount' value='" . $totalAmount . "'>";
                        echo "<input type='hidden' name='returnAmount' value='" . $returnAmount . "'>";
                        echo "<input type='hidden' name='customerID' value='" . $customerID . "'>";
                        echo "<input type='hidden' name='availablequantity' value='" .  $availableQuantity . "'>";
                        
                        echo "<button type='submit' name='payLater'>Pay Later</button>";
                        echo "</form>";
                        echo "</div>";
                    } else {
                        echo "<div class='error-message'>Insufficient Balance!</div>";
                    }
                }
            }
        }

        $customerStmt->close();
        $productStmt->close();
        $conn->close();
    }
    ?>
    <a href="dashboard.php" class="dashboard-link">Go to dashboard</a>
    <a href="javascript:history.go(-1)" class="previous-page-link">Go Back</a>
    </div>
</body>
</html>
