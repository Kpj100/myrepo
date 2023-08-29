<!DOCTYPE html>
<html>
<head>
  <style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f5f5;
  text-align: center;
}

h2 {
  margin-top: 20px;
  font-size: 24px;
  color: #333;
}

form {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

label {
  font-size: 16px;
  margin-bottom: 5px;
  color: #333;
}

input[type="number"] {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
  width: 50%;
  margin-bottom: 15px;
  transition: border-color 0.3s;
}

input[type="number"]:focus {
  border-color: #3498db;
  outline: none;
}

input[type="submit"] {
  background-color: #3498db;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

input[type="submit"]:hover {
  background-color: #258cd1;
}

input[type="submit"][disabled] {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
  <title>Bill Generator</title>
   
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
    // Query to fetch customer details
        $sql = "SELECT cid, firstname, lastname FROM customers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<table>";
            echo "<tr><th>Customer ID</th><th>First Name</th><th>Last Name</th></tr>";
            while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["cid"] . "</td><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No customer details found.";
        }

    // Prepare the SQL statement with a parameter
    $sql = "SELECT id, product_name, quantity, price, category FROM products WHERE id = ?";
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
      echo "Category: " . $row["category"] . "<br>";
      ?>
      <h2>Order Details</h2>
      <form id="order-form" method="POST" action="generate_bill.php">
        <input type="hidden" name="product-id" value="<?php echo $id; ?>">
        <label for="order-quantity">Order Quantity:</label>
        <input type="number" id="order-quantity" name="quantity" min="1" required>

        <label for="deposit-amount">Deposit Amount:</label>
        <input type="number" id="deposit-amount" name="amount" min="1" required>

        <label for="customerID">CustomerID:</label>
        <input type="number" id="customerID" name="customerID" min="1" required>

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
