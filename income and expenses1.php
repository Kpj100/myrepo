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
    
    h1 {
      margin-top: 50px;
      font-size: 28px;
      color: #333;
    }
    
    form {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    label {
      font-size: 16px;
      margin-right: 10px;
    }
    
    input[type="text"] {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    
    input[type="text"]:focus {
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

    /* Additional styles for table */
    table {
      width: 50%;
      margin: 20px auto;
      border-collapse: collapse;
      border: 1px solid #ccc;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>  
  <title>Fetch Product Details</title>
</head>
<body>
  <h1>Fetch Product Details</h1>

  <form action="sellerpaneldemo.php" method="GET">
    <label for="product-id">Product ID:</label>
    <input type="text" id="product-id" name="id">
    <input type="submit" value="Fetch">
  </form>


  <?php
  // Database connection details
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

  // Query to fetch all product details
  $sql = "SELECT id, product_name FROM products";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table>";
    echo "<tr><th>ID</th><th>Product Name</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>" . $row["id"] . "</td><td>" . $row["product_name"] . "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "No results found";
  }

  // Close connection
  $conn->close();
  ?>
</body>
</html>
