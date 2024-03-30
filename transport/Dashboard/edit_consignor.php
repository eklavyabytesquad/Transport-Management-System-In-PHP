<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Check if consignor ID is provided
if (!isset($_GET['id'])) {
    header("Location: view_consignor.php"); // Redirect if ID is not provided
    exit();
}

// Fetch consignor details from the database based on provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM consignor WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$consignor = mysqli_fetch_assoc($result);

// Check if consignor exists
if (!$consignor) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: view_consignor.php"); // Redirect if consignor does not exist
    exit();
}

// Update Consignor
if (isset($_POST['submit'])) {
    // Retrieve form data
    $consignorName = $_POST['consignor'];
    $number = $_POST['number'];
    $gstNo = $_POST['gstno'];

    // Update consignor in the database
    $sql = "UPDATE consignor SET consignor = ?, number = ?, gstno = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $consignorName, $number, $gstNo, $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Consignor details updated successfully.";
        header("Location: view_consignor.php");
        exit();
    } else {
        $error_message = "Error updating consignor details: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Consignor Detail</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .card {
            width: 400px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="mb-4 text-center">Edit Consignor Detail</h1>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <!-- Consignor edit form -->
            <form action="edit_consignor.php?id=<?php echo $id; ?>" method="post">
                <div class="mb-3">
                    <label for="consignor" class="form-label">Consignor Name</label>
                    <input type="text" id="consignor" name="consignor" class="form-control" value="<?php echo $consignor['consignor']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Number</label>
                    <input type="text" id="number" name="number" class="form-control" value="<?php echo $consignor['number']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gstno" class="form-label">GST no</label>
                    <input type="text" id="gstno" name="gstno" class="form-control" value="<?php echo $consignor['gstno']; ?>" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="view_consignor.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    <!-- Bootstrap JavaScript -->
</body>
</html>
