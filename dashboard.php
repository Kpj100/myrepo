<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
  <style>  
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #c0c0c0;
}

header {
  background-color: 400080;
  color: #400040;
  text-align: center;
  padding: 15px 0;
}

main {
  padding: 20px;
}

.dashboard {
  display: grid;
  
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 20px;
}

.option-card {
  background-color: #8080c0;
  border-radius: 5px;
  padding: 15px;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.option-card:hover {
  transform: translateY(-5px);
  box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

.option-card h2 {
  margin-top: 0;
}

.option-card a.button {
  display: inline-block;
  padding: 8px 15px;
  background-color: #3498db;
  color: #fff;
  text-decoration: none;
  border-radius: 3px;
  font-size: 14px;
}

.transaction-history {
  margin-top: 30px;
  padding: 20px;
  background-color: c0c0c0#;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.transaction-history h2 {
  margin: 0 0 15px;
  font-size: 24px;
  background-color:800080 #;
  color: #400040;
}

.transaction-history form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.transaction-history label {
  font-size: 16px;
  margin-bottom: 10px;
  color: #000000;
}

.transaction-history input[type="text"] {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
  width: 50%;
  margin-bottom: 15px;
  transition: border-color 0.3s;
}

.transaction-history input[type="text"]:focus {
  border-color: #3498db;
  outline: none;
}

.transaction-history input[type="submit"] {
  background-color: #3498db;
  color: #000000;
  border: none;
  padding: 8px 15px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

.transaction-history input[type="submit"]:hover {
  background-color: #258cd1;
}

.transaction-history input[type="submit"][disabled] {
  background-color: #ccc;
  cursor: not-allowed;
}

.chart-container {
  width: 48%;
  float: left;
  margin: 1%;
  background-color: #f9f9f9;
  border-radius: 5px;
  padding: 20px;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.chart-container:hover {
  transform: translateY(-5px);
  box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}
</style>
</head>
<body>

<header>
    <h1>Dashboard</h1>
</header>

<main>
    <div class="dashboard">
        <!-- Option 1: Add Products -->
        <div class="option-card">
            <h2>Add Products</h2>
            <p><a href="add products.html" class="button">Click here to add products</a></p>
        </div>
        <!-- Option 2: Add Customers -->
        <div class="option-card">
            <h2>Add Customers</h2>
            <p><a href="customer_details.html" class="button">Click here to add customer</a></p>
        </div>
        <!-- Option 3: Customer Details -->
        <div class="option-card">
            <h2>Customer Details</h2>
            <p><a href="customer_details_show.html" class="button">Click here to view customer details</a></p>
        </div>
        <!-- Option 4: Sales Platform -->
        <div class="option-card">
            <h2>Sales Platform</h2>
            <p><a href="income and expenses1.php" class="button">Click here to access the Seller Panel</a></p>
        </div>
        <!-- Option 5: Add Bills -->
        <div class="option-card">
            <h2>Add Bills</h2>
            <p><a href="bills.html" class="button">Click here to add bill</a></p>
        </div>
        <!-- Option 6: Analytics -->
        <div class="option-card">
            <h2>Analytics</h2>
            <p><a href="analytics.php" class="button">Click here to see report</a></p>
        </div>
    </div>
    <!-- Transaction History -->
    <div class="transaction-history">
        <h2>Transaction History</h2>
        <form action="detail.php" method="GET">
            <label for="input_id">Input Customer ID:</label>
            <input type="text" id="input_id" name="input_id" required>
            <input type="submit" value="Fetch Details">
        </form>
    </div>
</main>

</body>
</html>
