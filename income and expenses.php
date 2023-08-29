<!DOCTYPE html>
<html>
<head>
  <title>Bill Generator</title>
  <link rel="stylesheet" type="text/css" href="stylebill.css">
  <script src="script.js"></script>
</head>
<body>
  <h2>Product Details</h2>
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "accountdb";

  // Check if the ID parameter is provided
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement with a parameter
    $sql = "SELECT id, product_name, quantity, price, expiration_date, category FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" represents the data type of the parameter (in this case, integer)

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // Output data of the row
      $row = $result->fetch_assoc();
      echo "ID: " . $row["id"] . "<br>";
      echo "Product Name: " . $row["product_name"] . "<br>";
      echo "In stock Quantity: " . $row["quantity"] . "<br>";
      echo "Price: $" . $row["price"] . "<br>";
      
      ?>
      <h2>Order Details</h2>
      <form id="order-form" method="POST" action="sellerpaneldemo1.php">
        <input type="hidden" name="product-id" value="<?php echo $id; ?>">
        <label for="order-quantity">Order Quantity:</label>
        <input type="number" id="order-quantity" name="quantity" min="1" required>

        <label for="deposit-amount">Deposit Amount:</label>
        <input type="number" id="deposit-amount" name="amount" min="1" required>

        <input type="submit" value="Generate Bill" <?php if ($row["quantity"] <= 0) { echo "disabled"; } ?>>
      </form>
      <?php
    } else {
      echo "No product found with the provided ID.";
    }

    $stmt->close();
    $conn->close();
  } else {
    echo "No ID parameter provided.";
  }
  ?>
</body>
</html>
