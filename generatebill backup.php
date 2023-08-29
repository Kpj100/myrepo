<!DOCTYPE html>
<html>
<head>
  <title>Generated Bill</title>
  <link rel="stylesheet" type="text/css" href="stylebill.css">
  <style>
    .bill-container {
      /* Add your custom styles for the bill container */
    }

    .bill-header {
      /* Add your custom styles for the bill header */
    }

    .bill-details {
      /* Add your custom styles for the bill details */
    }

    .error-message {
      /* Add your custom styles for the error message */
    }
  </style>
</head>
<body>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $productID = $_POST['product-id'];
    $quantity = $_POST['quantity'];
    $depositAmount = $_POST['amount'];

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

    // Prepare the SQL statement with a parameter
    $sql = "SELECT price, quantity FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $price = $row["price"];
      $availableQuantity = $row["quantity"];

      // Check if there is enough quantity available to fulfill the order
      if ($availableQuantity < $quantity) {
        echo "<div class='error-message'>Insufficient quantity available. Please try again with a lower quantity.</div>";
      } else {
        // Calculate the total amount
        $totalAmount = $quantity * $price;

        // Calculate the return amount
        $returnAmount = $depositAmount - $totalAmount;

        if ($returnAmount >= 0) {
          // Deduct the quantity from the database
          $newQuantity = $availableQuantity - $quantity;
          $updateSql = "UPDATE products SET quantity = ? WHERE id = ?";
          $updateStmt = $conn->prepare($updateSql);
          $updateStmt->bind_param("ii", $newQuantity, $productID);
          $updateStmt->execute();
          $updateStmt->close();

          // Get the current system date
          $currentDate = date("Y-m-d");

          // Display the generated bill and return amount
          echo "<div class='bill-container'>";
          echo "<div class='bill-header'>";
          echo "<h2>Generated Bill</h2>";
          echo "</div>";
          echo "<div class='bill-details'>";
          echo "<table>";
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

          // Add a hyperlink to temp.php
          echo "<div class='link-container'>";
          echo "<a href='dashboard.php' class='dashboard-link'>Go to dashboard</a><br>"; 
        // Add a span element with a class for the gap
          echo "<a href='javascript:history.go(-1)' class='previous-page-link'>Go Back</a>";
          echo "</div>";
          
        } else {
          echo "<div class='error-message'>Insufficient Balance!</div>";
        }
      }
    }

    $stmt->close();
    $conn->close();
  }
  ?>
</body>
</html>
