<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $consignor = $_POST['consignor'];
    $number = $_POST['number'];
    $gstNo = $_POST['gstNo'];

    // Insert into database
    $sql = "INSERT INTO consignor (consignor, number, gstNo) 
            VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $consignor, $number, $gstNo);
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Successfully submitted.";
    } else {
        $error_message = "Error submitting data: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Consignor Detail</title>
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
            <h1 class="mb-4">Add Consignor Detail</h1>
            <?php if (isset($success_message)) : ?>
                <div class="alert alert-success" role="alert"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <!-- Form to add consignor details -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                    <label for="consignor" class="form-label">Consignor Name</label>
                    <input type="text" id="consignor" name="consignor" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Number</label>
                    <input type="text" id="number" name="number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="gstNo" class="form-label">GST No</label>
                    <input type="text" id="gstNo" name="gstNo" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="view_consignor.php" class="btn btn-success">SHOW CONSIGNOR LIST</a>
            </form>
        </div>
    </div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
