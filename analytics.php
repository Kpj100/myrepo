<!DOCTYPE html>
<html>
<head>
    <title>Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <header>
        <h1>Analytics</h1>
    </header>
    
    <main>
        <div class="chart-container">
            <h2>Sales Overview</h2>
            <canvas id="myChart"></canvas>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        // Fetch and populate data for the chart using PHP
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "accountdb";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data for the sales overview bar chart
        $sql_sales_overview = "SELECT SUM(total_amount) AS total_receivables
                               FROM invoices
                               WHERE invoices.stat = 'unpaid' " ;
        $result_sales_overview = $conn->query($sql_sales_overview);
        $row_sales_overview = $result_sales_overview->fetch_assoc();
        $total_receivables = $row_sales_overview['total_receivables'];

         $sql_sales_overview1 = "SELECT SUM(amount) AS total_payables
                               FROM bills
                               WHERE bills.status = 'Unpaid'";
        $result_sales_overview1 = $conn->query($sql_sales_overview1);
        $row_sales_overview1 = $result_sales_overview1->fetch_assoc();

       
        $total_payables = $row_sales_overview1['total_payables'];

        // Fetch data for the total amount paid by customers
        $sql_total_paid = "SELECT SUM(total_amount) AS total_paid
                           FROM invoices
                           WHERE stat = 'paid'";
        $result_total_paid = $conn->query($sql_total_paid);
        $row_total_paid = $result_total_paid->fetch_assoc();
        $total_paid_by_customers = $row_total_paid['total_paid'];

        $conn->close();
        ?>

        // Create and update the chart
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Incoming from customers (Unpaid)', 'To be paid to vendor (Unpaid)', 'Total paid by customers'],
                datasets: [{
                    label: 'Amount',
                    data: [
                        <?php echo $total_receivables; ?>,
                        <?php echo $total_payables; ?>,
                        <?php echo $total_paid_by_customers; ?>
                    ],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
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
