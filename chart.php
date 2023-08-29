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
$sql_receivables = "SELECT SUM(total_amount) AS total_receivables FROM invoice2 WHERE status = 'Unpaid'";
$result_receivables = $conn->query($sql_receivables);
$row_receivables = $result_receivables->fetch_assoc();
$total_receivables = $row_receivables['total_receivables'];

// Calculate total payables
$sql_payables = "SELECT SUM(amount) AS total_payables FROM bills WHERE status = 'Unpaid'";
$result_payables = $conn->query($sql_payables);
$row_payables = $result_payables->fetch_assoc();
$total_payables = $row_payables['total_payables'];

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 800px;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body>
    <canvas id="myChart"></canvas>
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
                    data: [<?php echo $total_receivables; ?>, <?php echo $total_payables; ?>],
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
