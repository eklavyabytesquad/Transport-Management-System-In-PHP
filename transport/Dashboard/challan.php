<?php
// Include database connection
require_once "../login/connection.php";

// Check if ID parameter is provided
if(isset($_GET['id'])) {
    // Get the ID of the selected challan
    $challan_id = $_GET['id'];

    // Fetch details of the selected challan
    $query = "SELECT * FROM challans WHERE id = 1";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $challan = mysqli_fetch_assoc($result);

    // Fetch associated invoices for the selected challan
    $query_invoices = "SELECT * FROM bill_list WHERE gr_no = '{$challan['A0017']}'";
    $result_invoices = mysqli_query($conn, $query_invoices);
    if (!$result_invoices) {
        die("Query failed: " . mysqli_error($conn));
    }
} else {
    echo "Challan ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challan Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Challan Details</h2>
    
    <div>
        <h3>Challan Information</h3>
        <p><strong>Challan No:</strong> <?php echo $challan['gr_no']; ?></p>
        <p><strong>Date:</strong> <?php echo $challan['currentdate']; ?></p>
        <p><strong>Sender Company:</strong> <?php echo $challan['sender_company_name']; ?></p>
        <p><strong>Receiver Company:</strong> <?php echo $challan['receiver_company_name']; ?></p>
        <p><strong>Nature of Goods:</strong> <?php echo $challan['nature_of_goods']; ?></p>
        <p><strong>No. of Packets:</strong> <?php echo $challan['no_of_packets']; ?></p>
        <p><strong>Weight:</strong> <?php echo $challan['weight']; ?></p>
        <p><strong>Status:</strong> <?php echo $challan['status']; ?></p>
        <p><strong>Destination:</strong> <?php echo $challan['destination']; ?></p>
        <p><strong>Goods Pvt Mark:</strong> <?php echo $challan['goods_pvt_mark']; ?></p>
    </div>

    <hr>

    <div>
        <h3>Associated Invoices</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>GR No</th>
                    <th>Sender Company</th>
                    <th>Receiver Company</th>
                    <th>Nature of Goods</th>
                    <th>No. of Packets</th>
                    <th>Weight</th>
                    <th>Status</th>
                    <th>Destination</th>
                    <th>Goods Pvt Mark</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($invoice = mysqli_fetch_assoc($result_invoices)) : ?>
                    <tr>
                        <td><?php echo $invoice['gr_no']; ?></td>
                        <td><?php echo $invoice['sender_company_name']; ?></td>
                        <td><?php echo $invoice['receiver_company_name']; ?></td>
                        <td><?php echo $invoice['nature_of_goods']; ?></td>
                        <td><?php echo $invoice['no_of_packets']; ?></td>
                        <td><?php echo $invoice['weight']; ?></td>
                        <td><?php echo $invoice['status']; ?></td>
                        <td><?php echo $invoice['destination']; ?></td>
                        <td><?php echo $invoice['goods_pvt_mark']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
