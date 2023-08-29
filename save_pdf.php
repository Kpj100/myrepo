<?php
require_once('tcpdf/tcpdf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['savePDF'])) {
    // Retrieve the form data
    $currentDate = $_POST['currentDate'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $depositAmount = $_POST['depositAmount'];
    $totalAmount = $_POST['totalAmount'];
    $returnAmount = $_POST['returnAmount'];

    // Create a new TCPDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Generated Bill');
    $pdf->SetSubject('Generated Bill');
    $pdf->SetKeywords('Bill, Generated Bill, TCPDF');

    // Set default header and footer data
    $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));
    $pdf->setHeaderFont(array('helvetica', '', 10));
    $pdf->setFooterFont(array('helvetica', '', 8));

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont('courier');

    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(true, 15);

    // Add a page
    $pdf->AddPage();

    // Set content using HTML
    $content = "
        <h2 style='text-align: center; margin-bottom: 20px;'>Generated Bill</h2>
        <table style='width: 100%; border-collapse: collapse;'>
            <tr>
                <td style='padding: 5px 10px;'><strong>Date:</strong></td>
                <td style='padding: 5px 10px;'>{$currentDate}</td>
            </tr>
            <tr>
                <td style='padding: 5px 10px;'><strong>Product ID:</strong></td>
                <td style='padding: 5px 10px;'>{$productID}</td>
            </tr>
            <tr>
                <td style='padding: 5px 10px;'><strong>Order Quantity:</strong></td>
                <td style='padding: 5px 10px;'>{$quantity}</td>
            </tr>
            <tr>
                <td style='padding: 5px 10px;'><strong>Deposit Amount:</strong></td>
                <td style='padding: 5px 10px;'>{$depositAmount}</td>
            </tr>
            <tr>
                <td style='padding: 5px 10px;'><strong>Total Amount:</strong></td>
                <td style='padding: 5px 10px;'>{$totalAmount}</td>
            </tr>
            <tr>
                <td style='padding: 5px 10px;'><strong>Return Amount:</strong></td>
                <td style='padding: 5px 10px;'>{$returnAmount}</td>
            </tr>
        </table```
    <div style='text-align: center; margin-top: 20px;'>
        <button onclick='window.print()'>Print</button>
    </div>
";

    $pdf->writeHTML($content, true, false, true, false, '');

    // Set the file path and name
    $filePath = 'C:/xampp/htdocs/ams/generated_bill.pdf';

    // Generate the PDF and save it on the server
    $pdf->Output($filePath, 'F');

    // Provide the generated PDF as a download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="generated_bill.pdf"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}
?>
