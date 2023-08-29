<!DOCTYPE html>
<html>
<body>
    <header>
        <h1>Dashboard</h1>
        <link rel="stylesheet" href="dashboard.css">
    </header>
    <main>
        <ul class="options">
            <li>
                <h2>Add Products</h2>
                <p><a href="add products.html" class="button">Click here to add products</a></p>
            </li>
            <li>
                <h2>Add Customers</h2>
                <p><a href="customer_details.html" class="button">Click here to add customer</a></p>
            </li>
            <li>
                <h2>Customer Details</h2>
                <p><a href="customer_details_show.html" class="button">Click here to view customer details</a></p>
            </li>
            <li>
                <h2>Sales Platform</h2>
                <p><a href="income and expenses.html" class="button">Click here to access the Seller Panel</a></p>
            </li>
            <li>
                <h2>Add bills</h2>
                <p><a href="bills.html" class="button">Click here to add bill</a></p>
            </li>
        </ul>

        <div class="transaction-history">
            <h2>Transaction History</h2>
            <form action="detail.php" method="GET">
                <label for="input_id">Input ID:</label>
                <input type="text" id="input_id" name="input_id" required>
                <input type="submit" value="Fetch Details">
            </form>

            
        </div>

        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get the canvas element
        var ctx = document.getElementById('myChart').getContext('2d');

        // Create the chart
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Receivables', 'Total Payables'],
                datasets: [{
                    label: 'Amount',
                    data: [
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

                        // Calculate total receivables
                        $sql_receivables = "SELECT SUM(total_amount) AS total_receivables FROM invoice2 WHERE stat = 'Unpaid'";
                        $result_receivables = $conn->query($sql_receivables);
                        $row_receivables = $result_receivables->fetch_assoc();
                        $total_receivables = $row_receivables['total_receivables'];

                        // Calculate total payables
                        $sql_payables = "SELECT SUM(amount) AS total_payables FROM bills WHERE status = 'Unpaid'";
                        $result_payables = $conn->query($sql_payables);
                        $row_payables = $result_payables->fetch_assoc();
                        $total_payables = $row_payables['total_payables'];

                        $conn->close();

                        echo $total_receivables . ", " . $total_payables;// Remaining code for chart remains the same
                        ?>
                    ],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
