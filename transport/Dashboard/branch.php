

<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Create Branch
if (isset($_POST['submit'])) {
    // Retrieve form data
    $locationName = $_POST['locationName'];
    $transport1 = $_POST['transport1'];
    $pincode = $_POST['pincode'];
    $gstNo = $_POST['gstNo'];
    $address = $_POST['address'];
    $branchCode = $_POST['branchCode'];
    $number = $_POST['number'];
    $amount = $_POST['amount'];


    // Insert into database
    $sql = "INSERT INTO branchdetail (locationName, transport1, pincode, gstNo, address, branchCode, number , amount) 
            VALUES (?, ?, ?, ?, ?, ?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssisssss", $locationName, $transport1, $pincode, $gstNo, $address, $branchCode ,$number, $amount);
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to prevent form resubmission and add success parameter to URL
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=true");
        exit();
    } else {
        $error_message = "Error adding location details: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="card p-4 mt-5">
            <h1 class="mb-4">Add Location Details</h1>
            <?php if (isset($_GET['success']) && $_GET['success'] == 'true') : ?>
                <div class="alert alert-success" role="alert">Location details added successfully.</div>
            <?php endif; ?>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <!-- Form to add location details -->
            <form id="addBranchForm" action="branch.php" method="post">
            <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="locationName" class="form-label">Location</label>
                        <input type="text" id="locationName" name="locationName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="transport1" class="form-label">Transport Name</label>
                        <input type="text" id="transport1" name="transport1" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" id="pincode" name="pincode" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="gstNo" class="form-label">GST No</label>
                        <input type="text" id="gstNo" name="gstNo" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address of Transport</label>
                    <textarea id="address" name="address" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="branchCode" class="form-label">Branch Code</label>
                    <input type="text" id="branchCode" name="branchCode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Number</label>
                    <input type="number" id="number" name="number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" id="number" name="amount" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="branchdetail.php" class="btn btn-success">SHOW BRANCH LIST</a>
            </form>
        </div>
    </div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to show Bootstrap alert
        function showAlert(message, className) {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${className} alert-dismissible fade show mt-3`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            // Append alert to the container
            document.querySelector('.container').insertAdjacentElement('afterbegin', alertDiv);
            // Close the alert after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
</body>
</html>
