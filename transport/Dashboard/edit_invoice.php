<?php
// Include your database connection file
require_once "../login/connection.php";

// Check if gr_no is set in the URL parameters
if(isset($_GET['gr_no'])) {
    $grNo = $_GET['gr_no'];

    // Fetch the invoice details based on gr_no
    $query = "SELECT * FROM bill_list WHERE gr_no = '$grNo'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the invoice details
        $invoice = mysqli_fetch_assoc($result);
    } else {
        // Handle error if invoice not found
        echo "Invoice not found.";
        exit();
    }
} else {
    // Handle error if gr_no not provided
    echo "GR No not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Other head elements -->
     <!-- Include Font Awesome CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Other scripts -->
    <script>
        $(document).ready(function(){
    // Event listeners for input changes
    document.getElementById('weight').addEventListener('input', calculateTotal);
    document.getElementById('charges_per_kg').addEventListener('input', calculateTotal);
    document.getElementById('labour_charge').addEventListener('input', calculateTotal);
    document.getElementById('bill_charge').addEventListener('input', calculateTotal);
    document.getElementById('pf').addEventListener('input', calculateTotal);
    document.getElementById('other_charge').addEventListener('input', calculateTotal);

    // Initial calculation on page load
    calculateTotal();


    // Click event handler for the "Fetch Details" button
    $('#fetch_branch_details_btn').on('click', function() {
        // Get the value from the input field
        var stationCode = $('#destination').val().trim();

        // Check if the input is not empty
        if (stationCode !== '') {
            // Send an AJAX request to fetch branch details
            $.ajax({
                url: 'fetch_branch_details.php',
                method: 'POST',
                data: { station_code: stationCode },
                dataType: 'json',
                success: function(data) {
                    // Update input fields with fetched data
                    $('#station_address').val(data.station_address);
                    $('#station_number').val(data.station_number);
                    $('#station_gstno').val(data.station_gstno);
                    $('#transport_name').val(data.transport_name);
                    $('#charges_per_kg').val(data.transport_rate);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            // Clear input fields if station code is empty
            $('#station_address').val('');
            $('#station_number').val('');
            $('#station_gstno').val('');
            $('#transport_name').val('');
            $('#charges_per_kg').val('');
        }
    });
});

function calculateTotal() {
    var weight = parseFloat(document.getElementById('weight').value);
    var chargesPerKg = parseFloat(document.getElementById('charges_per_kg').value);
    var labourCharge = parseFloat(document.getElementById('labour_charge').value);
    var billCharge = parseFloat(document.getElementById('bill_charge').value);
    var pf = parseFloat(document.getElementById('pf').value);
    var otherCharge = parseFloat(document.getElementById('other_charge').value);

    // Calculate total based on weight and charges per kg
    var total = (weight * chargesPerKg) + labourCharge + billCharge + pf + otherCharge;

    // Set the calculated total in the total input field
    document.getElementById('total').value = total.toFixed(2);
}
</script>
<style>
        body {
            background: radial-gradient(circle, #ffffff, #007bff);
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(45deg, #ffffff 0%, #007bff 99%, #007bff 100%);
            animation: movingGradient 10s ease infinite;
            z-index: 0;
        }

        @keyframes movingGradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .card-header {
            background-color: #1083ff;/* Change the background color to blue */
            color: white; /* Change the text color to white */
            position: relative;
            z-index: 2; /* Ensure the header appears above the background */
        }
        
        .background-lines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px), 
                linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            z-index: -1;
            pointer-events: none; /* Ensure the lines don't interfere with mouse events */
        }
    </style>
</head>
<body>
<body>
<div class="background"></div>
<div class="background-lines"></div>
    <div class="container mt-5">
        <h1 class="mb-4">UPDATE BILL</h1>
        <div class="card">
            <div class="card-header">
                UPDATE BILTY
            </div>
            <div class="card-body">
                <div class="container mt-4">
                    <form id="invoiceForm" action=update_invoice.php method="post">
                    <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="current_date" class="form-label dark-bold-label">Date</label>
                            <input type="date" class="form-control" id="current_date" name="current_date" value="<?php echo isset($invoice['currentdate']) ? $invoice['currentdate'] : date('Y-m-d'); ?>" required>
                        </div>
                        <input type="hidden" name="gr_no" value="<?php echo $invoice['gr_no']; ?>">
                        <div class="col-md-6">
                            <label for="new_invoice_id" class="form-label dark-bold-label">GR No.</label>
                            <input type="text" class="form-control" id="new_invoice_id" name="new_invoice_id" value="<?php echo $invoice['gr_no']; ?>" readonly>

                        </div>
                    </div>
                </div>          
                   <br>
                    <div class="mb-3">
                <div class="mb-3">
                        <h5 class="card-title">Sender Details</h5>
                        <div class="row">
                        <div class="col-md-6">
                                    <label for="destination" class="form-label dark-bold-label">Station Code </label>
                                    <input type="text" class="form-control" id="destination" name="destination" value="<?php echo $invoice['destination']; ?>" required>
                                </div>
                                <div class="col-md-2 mt-4">
                                <button type="button" class="btn btn-primary" id="fetch_branch_details_btn">Fetch Details</button>
                            </div>
                                <div class="col-md-6">
                                <label for="station_address" class="form-label dark-bold-label">Station Address</label>
                                <input type="text" class="form-control" id="station_address" name="station_address"  readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="station_number" class="form-label dark-bold-label">Station Number</label>
                                <input type="text" class="form-control" id="station_number" name="station_number"  readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="station_gstno" class="form-label dark-bold-label">Station GST Number</label>
                                <input type="text" class="form-control" id="station_gstno" name="station_gstno"  required>
                            </div>
                            <div class="col-md-6">
                                <label for="transport_name" class="form-label dark-bold-label">Transport Name</label>
                                <input type="text" class="form-control" id="transport_name" name="transport_name"  readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="sender_company_name" class="form-label dark-bold-label">Consignee</label>
                                <input type="text" class="form-control" id="sender_company_name" name="sender_company_name" value="<?php echo $invoice['sender_company_name']; ?>" required>
                                <br>
                            </div>
                            <div class="col-md-6">
                                <label for="sender_company_gst" class="form-label dark-bold-label">GST Number</label>
                                <input type="text" class="form-control" id="sender_company_gst" name="sender_company_gst" value="<?php echo $invoice['sender_company_gst']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Receiver Details Section -->
                    <div class="mb-3">
                        <h5 class="card-title">Receiver Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="receiver_company_name" class="form-label dark-bold-label">Consignor</label>
                                <input type="text" class="form-control" id="receiver_company_name" name="receiver_company_name" value="<?php echo $invoice['receiver_company_name']; ?>" required>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-6">
                                <label for="receiver_company_gst" class="form-label dark-bold-label">GST Number</label>
                                <input type="text" class="form-control" id="receiver_company_gst" name="receiver_company_gst" value="<?php echo $invoice['receiver_company_gst']; ?>"  required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="mb-3">
                        <h5 class="card-title">Good Detail</h5>
                        <div class="row">
                            <div class="col-md-6">
                                    <label for="e_way_bill" class="form-label dark-bold-label">E-Way Bill</label>
                                    <input type="text" class="form-control" id="e_way_bill" name="e_way_bill" value="<?php echo $invoice['e_way_bill']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="sender_goods_bill_date" class="form-label dark-bold-label">Sender Goods Bill Date</label>
                                    <input type="date" class="form-control" id="sender_goods_bill_date" name="sender_goods_bill_date" value="<?php echo $invoice['sender_goods_bill_date']; ?>" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sender_goods_bill_no" class="form-label dark-bold-label">Sender Goods Bill No</label>
                                    <input type="text" class="form-control" id="sender_goods_bill_no" name="sender_goods_bill_no" value="<?php echo $invoice['sender_goods_bill_no']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="sender_goods_bill_value" class="form-label dark-bold-label">Sender Goods Bill Value</label>
                                    <input type="text" class="form-control" id="sender_goods_bill_value" name="sender_goods_bill_value" value="<?php echo $invoice['sender_goods_bill_value']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nature_of_goods" class="form-label dark-bold-label">Nature of Goods</label>
                                    <input type="text" class="form-control" id="nature_of_goods" name="nature_of_goods" value="<?php echo $invoice['nature_of_goods']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="goods_pvt_mark" class="form-label dark-bold-label">Goods Pvt Mark</label>
                                    <input type="text" class="form-control" id="goods_pvt_mark" name="goods_pvt_mark" value="<?php echo $invoice['goods_pvt_mark']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="no_of_packets" class="form-label dark-bold-label">Number of Packets</label>
                                    <input type="text" class="form-control" id="no_of_packets" name="no_of_packets" value="<?php echo $invoice['no_of_packets']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Charges and Amount Section -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="weight" class="form-label dark-bold-label">Weight</label>
                            <input type="text" class="form-control " id="weight" name="weight" value="<?php echo $invoice['weight']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="charges_per_kg" class="form-label dark-bold-label">Charges Per KG</label>
                            <input type="text" class="form-control " id="charges_per_kg" name="charges_per_kg" value="<?php echo $invoice['charges_per_kg']; ?>" required>
                        </div>
                    </div>
                    <!-- Charges Section -->
                    <div class="row charges-section">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="labour_charge" class="form-label dark-bold-label">Labour Charge</label>
                                    <input type="text" class="form-control " id="labour_charge" name="labour_charge" value="<?php echo $invoice['labour_charge']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label dark-bold-label">Payment Status</label>
                                    <select class="form-select" id="status" name="status" value="<?php echo $invoice['status']; ?>" required>
                                        <option value="pay">Paid</option>
                                        <option value="to pay">To Pay</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
    <label for="deliver" class="form-label dark-bold-label">Delivery Status</label>
    <div class="input-group">
        <select class="form-select" id="deliver" name="deliver" required>
            <option value="pending" <?php if ($invoice['deliver'] == 'pending') echo 'selected'; ?>>Pending <i class="fas fa-check text-success"></i></option>
            <option value="delivered" <?php if ($invoice['deliver'] == 'delivered') echo 'selected'; ?>>Delivered <i class="fas fa-check-double text-success"></i></option>
            <option value="cancelled" <?php if ($invoice['deliver'] == 'cancelled') echo 'selected'; ?>>Cancelled <i class="fas fa-times text-danger"></i></option>
        </select>
    </div>
</div>

                                <div class="col-md-6">
                                    <label for="bill_charge" class="form-label dark-bold-label">Bill Charge</label>
                                    <input type="text" class="form-control " id="bill_charge" name="bill_charge" value="50" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="pf" class="form-label dark-bold-label">PF</label>
                                    <input type="text" class="form-control " id="pf" name="pf" value="<?php echo $invoice['pf']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="other_charge" class="form-label dark-bold-label">Other Charge</label>
                                    <input type="text" class="form-control " id="other_charge" name="other_charge" value="<?php echo $invoice['other_charge']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="total" class="form-label dark-bold-label">Total</label>
                            <input type="text" class="form-control " id="total" name="total" value="<?php echo $invoice['total']; ?>" required>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>

</div>
</div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
