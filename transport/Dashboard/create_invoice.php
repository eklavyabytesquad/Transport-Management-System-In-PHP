

<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file


// Initialize variables with empty values
error_reporting(E_ALL);
ini_set('display_errors', 1);

$gr_no = $sender_company_name = $sender_company_gst = $receiver_company_name = $receiver_company_gst = $destination = '';
$e_way_bill = $sender_goods_bill_no = $nature_of_goods = $goods_pvt_mark = '';
$sender_goods_bill_value = $weight = $no_of_packets = $charges_per_kg = $labour_charge = $bill_charge = $pf = $other_charge = $total = '';
$sender_goods_bill_date = $currentdate = date("Y-m-d");

// Function to generate GR No.

// Function to generate GR No.

function generateGRNo($conn) {
    // Query to get the last gr_no entry from your database
    $sql = "SELECT gr_no FROM bill_list ORDER BY gr_no DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If there are rows in the result, fetch the last gr_no
        $row = $result->fetch_assoc();
        $last_gr_no = $row["gr_no"];

        // Extract numeric part and increment
        $numeric_part = substr($last_gr_no, 1);
        $new_numeric_part = str_pad((int)$numeric_part + 1, strlen($numeric_part), '0', STR_PAD_LEFT);
        $new_gr_no = "A" . $new_numeric_part;
    } else {
        // If no rows found, initialize gr_no to A0001
        $new_gr_no = 'A0001';
    }

    // Return the generated gr_no
    return $new_gr_no;
}
$query = "SELECT *, mob FROM bill_list";

generateGRNo($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $gr_no = $_POST['new_invoice_id'];
    $sender_company_name = $_POST['sender_company_name'];
    $sender_company_gst = $_POST['sender_company_gst'];
    $receiver_company_name = $_POST['receiver_company_name'];
    $receiver_company_gst = $_POST['receiver_company_gst'];
    $e_way_bill = $_POST['e_way_bill'];
    $sender_goods_bill_date = $_POST['sender_goods_bill_date'];
    $sender_goods_bill_no = $_POST['sender_goods_bill_no'];
    $sender_goods_bill_value = $_POST['sender_goods_bill_value'];
    $nature_of_goods = $_POST['nature_of_goods'];
    $goods_pvt_mark = $_POST['goods_pvt_mark'];
    $weight = $_POST['weight'];
    $no_of_packets = $_POST['no_of_packets'];
    $charges_per_kg = $_POST['charges_per_kg'];
    $labour_charge = $_POST['labour_charge'];
    $bill_charge = $_POST['bill_charge'];
    $pf = $_POST['pf'];
    $other_charge = $_POST['other_charge'];
    $total = $_POST['total'];
    $mob = $_POST['mob'];
    $status = $_POST['status'];
    $deliver = $_POST['deliver'];
    $currentdate = $_POST['current_date']; 
    $destination = $_POST['destination'];// Change to current_date to match HTML form field name

    
// Insert data into database
$sql = "INSERT INTO bill_list (`gr_no`, `currentdate`, `sender_company_name`, `sender_company_gst`, `receiver_company_name`, `receiver_company_gst`, `e_way_bill`, `sender_goods_bill_date`, `sender_goods_bill_no`, `sender_goods_bill_value`, `nature_of_goods`, `goods_pvt_mark`, `weight`, `no_of_packets`,  `charges_per_kg`, `labour_charge`, `bill_charge`, `pf`, `other_charge`, `total`, `destination`, `mob`, `status`, `deliver`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssssssssssssddddddsssss", $gr_no, $currentdate, $sender_company_name, $sender_company_gst, $receiver_company_name, $receiver_company_gst, $e_way_bill, $sender_goods_bill_date, $sender_goods_bill_no, $sender_goods_bill_value, $nature_of_goods, $goods_pvt_mark, $weight, $no_of_packets,$charges_per_kg, $labour_charge, $bill_charge, $pf, $other_charge, $total, $destination, $mob, $status, $deliver);
    // Rest of your code remains unchanged
    mysqli_stmt_execute($stmt);

    // Check if data is inserted successfully
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Generate and store the next GR number
        $_SESSION['gr_no'] = generateGRNo($conn);

        $_SESSION['success_message'] = "Invoice created successfully.";
        header("Location: create_invoice.php");
        exit();
    } else {
        $error_message = "Error creating invoice: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    $error_message = "Error preparing SQL statement: " . mysqli_error($conn);
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .dark-bold-label {
                            color: #343a40; /* Dark color */
                            font-weight: bold; /* Bold font weight */
                            }
        /* Custom CSS for autocomplete dropdown */
           /* Custom CSS for autocomplete dropdown */
.ui-autocomplete {
    max-height: 200px; /* Set max-height to limit the height of the dropdown */
    overflow-y: auto; /* Enable vertical scrolling if needed */
    border: 1px solid #ccc; /* Add border */
    background-color: #fff; /* Set background color */
    padding: 5px; /* Add padding */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
    max-width: 300px; /* Set max-width to limit the width of the dropdown */
    width: auto !important; /* Set width to auto */
}

.ui-menu-item {
    padding: 8px 12px; /* Add padding */
    cursor: pointer; /* Change cursor to pointer */
    transition: background-color 0.3s ease; /* Add transition for smooth hover effect */
}

.ui-menu-item:hover,
.ui-state-active {
    background-color: #f0f0f0; /* Change background color on hover */
}

.ui-state-active a {
    color: #333; /* Change text color of active item */
}

.ui-menu-item .ui-corner-all {
    border-radius: 5px; /* Add border-radius for rounded corners */
}
@keyframes shadow-animation {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }
            50% {
                box-shadow: 0 0 20px 10px rgba(0, 123, 255, 0.7);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }
        }

        /* Apply animation to card */
        .blue-shadow {
            animation: shadow-animation 10s infinite;
        }

    </style>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <!-- Other head elements -->
 
    <!-- Other scripts -->
    <script>
$(document).ready(function(){
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
</script>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">CREATE BILL</h1>
        <div class="card blue-shadow">
        <div class="card">
            <div class="card-header">
                Create bilty
            </div>
            <div class="card-body">
                <!-- Invoice creation form -->
                <form id="invoiceForm" action=create_invoice.php method="post">

                 <div class="mb-3">
                        <h5 class="card-title">Bill Detail</h5>
                        <div class="row">
                           <div class="col-md-6">
                                    <label for="current_date" class="form-label dark-bold-label">Date</label>
                                    <input type="date" class="form-control" id="current_date" name="current_date" value="<?php echo $currentdate; ?>" required>
                                </div>

                            <!-- Add a date picker for the current date -->
                            <div class="col-md-6">
                            <label for="new_invoice_id" class="form-label dark-bold-label">GR No.</label>
                            <input type="text" class="form-control" id="new_invoice_id" name="new_invoice_id" value="<?php echo isset($_SESSION['gr_no']) ? $_SESSION['gr_no'] : generateGRNo($conn); ?>" readonly>

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
                                    <input type="text" class="form-control" id="destination" name="destination" required>
                                </div>
                                <div class="col-md-2 mt-4">
                                <button type="button" class="btn btn-primary" id="fetch_branch_details_btn">Fetch Details</button>
                            </div>
                                <div class="col-md-6">
                                <label for="station_address" class="form-label dark-bold-label">Station Address</label>
                                <input type="text" class="form-control" id="station_address" name="station_address" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="station_number" class="form-label dark-bold-label">Station Number</label>
                                <input type="text" class="form-control" id="station_number" name="station_number" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="station_gstno" class="form-label dark-bold-label">Station GST Number</label>
                                <input type="text" class="form-control" id="station_gstno" name="station_gstno" required>
                            </div>
                            <div class="col-md-6">
                                <label for="transport_name" class="form-label dark-bold-label">Transport Name</label>
                                <input type="text" class="form-control" id="transport_name" name="transport_name" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="sender_company_name" class="form-label dark-bold-label">Consignee</label>
                                <input type="text" class="form-control" id="sender_company_name" name="sender_company_name"  required>
                                <br>
                            </div>
                       


                            <div class="col-md-6">
                                <label for="sender_company_gst" class="form-label dark-bold-label">GST Number</label>
                                <input type="text" class="form-control" id="sender_company_gst" name="sender_company_gst"  required>
                            </div>
                            <div class="col-md-6">
                                <label for="mob" class="form-label dark-bold-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mob" name="mob" required>
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
                                <input type="text" class="form-control" id="receiver_company_name" name="receiver_company_name"  required>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-6">
                                <label for="receiver_company_gst" class="form-label dark-bold-label">GST Number</label>
                                <input type="text" class="form-control" id="receiver_company_gst" name="receiver_company_gst"  required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="mb-3">
                        <h5 class="card-title">Good Detail</h5>
                        <div class="row">
                            <div class="col-md-6">
                                    <label for="e_way_bill" class="form-label dark-bold-label">E-Way Bill</label>
                                    <input type="text" class="form-control" id="e_way_bill" name="e_way_bill" value="<?php echo htmlspecialchars($e_way_bill); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="sender_goods_bill_date" class="form-label dark-bold-label">Sender Goods Bill Date</label>
                                    <input type="date" class="form-control" id="sender_goods_bill_date" name="sender_goods_bill_date" value="<?php echo $sender_goods_bill_date; ?>" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sender_goods_bill_no" class="form-label dark-bold-label">Sender Goods Bill No</label>
                                    <input type="text" class="form-control" id="sender_goods_bill_no" name="sender_goods_bill_no" value="<?php echo htmlspecialchars($sender_goods_bill_no); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="sender_goods_bill_value" class="form-label dark-bold-label">Sender Goods Bill Value</label>
                                    <input type="text" class="form-control" id="sender_goods_bill_value" name="sender_goods_bill_value" value="<?php echo htmlspecialchars($sender_goods_bill_value); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nature_of_goods" class="form-label dark-bold-label">Nature of Goods</label>
                                    <input type="text" class="form-control" id="nature_of_goods" name="nature_of_goods" value="<?php echo htmlspecialchars($nature_of_goods); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="goods_pvt_mark" class="form-label dark-bold-label">Goods Pvt Mark</label>
                                    <input type="text" class="form-control" id="goods_pvt_mark" name="goods_pvt_mark" value="<?php echo htmlspecialchars($goods_pvt_mark); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="no_of_packets" class="form-label dark-bold-label">Number of Packets</label>
                                    <input type="text" class="form-control" id="no_of_packets" name="no_of_packets" value="<?php echo htmlspecialchars($no_of_packets); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Charges and Amount Section -->

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="weight" class="form-label dark-bold-label">Weight</label>
                            <input type="text" class="form-control " id="weight" name="weight" required>
                        </div>
                        <div class="col-md-6">
                            <label for="charges_per_kg" class="form-label dark-bold-label">Charges Per KG</label>
                            <input type="text" class="form-control " id="charges_per_kg" name="charges_per_kg" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <label for="deliver" class="form-label dark-bold-label">Delivery Status</label>
                    <div class="input-group">
                        <select class="form-select" id="deliver" name="deliver" required>
                            <option value="pending">Pending <i class="fas fa-check text-success"></i></option>
                            <option value="delivered">Delivered <i class="fas fa-check-double text-success"></i></option>
                            <option value="cancelled">Cancelled <i class="fas fa-times text-danger"></i></option>
                        </select>
                    </div>
                </div>
                     <div class="mb-3">
    <label for="status" class="form-label dark-bold-label">Status</label>
    <select class="form-select" id="status" name="status" required>
        <option value="pay">Pay</option>
        <option value="to pay">To Pay</option>
    </select>
</div>
                <br><br>
                    <!-- Charges Section -->
                    <div class="row charges-section">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="labour_charge" class="form-label dark-bold-label">Labour Charge</label>
                                    <input type="text" class="form-control " id="labour_charge" name="labour_charge" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="bill_charge" class="form-label dark-bold-label">Bill Charge</label>
                                    <input type="text" class="form-control " id="bill_charge" name="bill_charge" value="50" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="pf" class="form-label dark-bold-label">PF</label>
                                    <input type="text" class="form-control " id="pf" name="pf" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="other_charge" class="form-label dark-bold-label">Other Charge</label>
                                    <input type="text" class="form-control " id="other_charge" name="other_charge" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="total" class="form-label dark-bold-label">Total</label>
                            <input type="text" class="form-control " id="total" name="total" readonly>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
                <!-- Success Message -->
                <?php if (isset($_SESSION['success_message'])) : ?>
                    <div class="alert alert-success mt-3" role="alert">
                        <?php echo $_SESSION['success_message']; ?>
                    </div>
                <?php 
                    unset($_SESSION['success_message']);
                    endif; 
                ?>
            </div>
        </div>
    </div>
                </div>

<!-- Custom JavaScript -->
<script>
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

        // Event listeners for input changes
        document.getElementById('weight').addEventListener('input', calculateTotal);
        document.getElementById('charges_per_kg').addEventListener('input', calculateTotal);
        document.getElementById('labour_charge').addEventListener('input', calculateTotal);
        document.getElementById('bill_charge').addEventListener('input', calculateTotal);
        document.getElementById('pf').addEventListener('input', calculateTotal);
        document.getElementById('other_charge').addEventListener('input', calculateTotal);

        // Initial calculation on page load
        calculateTotal();
</script>
<script>
    $(document).ready(function(){
        // Autocomplete for sender's name
        $('#sender_company_name').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: 'fetch_sender_names.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        query: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 0, // Update minimum length to 0
            delay: 300, // Add a small delay to prevent too frequent requests
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 1000); // Set z-index to make sure it appears above other elements
            },
            select: function(event, ui) { // Corrected event name
                var senderName = ui.item.value;
                $.ajax({
                    url: 'fetch_gst.php',
                    method: 'POST',
                    data: {
                        type: 'sender',
                        name: senderName
                    },
                    success: function(gst) {
                        $('#sender_company_gst').val(gst);
                    }
                });
            }
        });

        // Autocomplete for receiver's name
        $('#receiver_company_name').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: 'fetch_receiver_names.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        query: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 0, // Update minimum length to 0
            delay: 300, // Add a small delay to prevent too frequent requests
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 1000); // Set z-index to make sure it appears above other elements
            },
            select: function(event, ui) { // Corrected event name
                var receiverName = ui.item.value;
                $.ajax({
                    url: 'fetch_gst.php',
                    method: 'POST',
                    data: {
                        type: 'receiver',
                        name: receiverName
                    },
                    success: function(gst) {
                        $('#receiver_company_gst').val(gst);
                    }
                });
            }
        });
    });
</script>
</body>
</html>
