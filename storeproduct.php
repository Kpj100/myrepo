<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accountdb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['product-id']) && isset($_POST['product-name']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['category'])) {
        // Product Details Form submitted
        $id = $_POST['product-id']; 
        $productName = $_POST['product-name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Insert the data into the database
        $sql = "INSERT INTO products (id, product_name, quantity, price, category) VALUES ('$id', '$productName', '$quantity', '$price', '$category')";

        if ($conn->query($sql) === TRUE) {
            $message = "New product added successfully";
            $script = "alert('$message');"; // Show an alert
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $script = "alert('$message');"; // Show an alert
        }
    } elseif (isset($_POST['update-id']) && isset($_POST['update-quantity'])) {
        // Update Quantity Form submitted
        $update_id = $_POST['update-id'];
        $update_quantity = $_POST['update-quantity'];
    
        // Check if the update quantity is greater than or equal to 0
        if ($update_quantity >= 0) {
            // Update quantity in the database for the given ID
            $sql = "UPDATE products SET quantity = '$update_quantity' WHERE id = '$update_id'";
    
            if ($conn->query($sql) === TRUE) {
                // Check if the quantity has been updated correctly
                $select_sql = "SELECT quantity FROM products WHERE id = '$update_id'";
                $result = $conn->query($select_sql);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $updated_quantity = $row['quantity'];
                    echo "Quantity updated successfully for ID: $update_id. Updated quantity: $updated_quantity";
                } else {
                    echo "Invalid product id: $update_id";
                }
            } else {
                echo "Error updating quantity for ID: $update_id - " . $conn->error;
            }
        } else {
            echo "Invalid quantity value. Quantity must be greater than or equal to 0.";
        }
    }
    
    
}

$conn->close();

// Output the JavaScript script

?>


<a href="dashboard.php" class="btn btn-sucess">go to dashboard</a >