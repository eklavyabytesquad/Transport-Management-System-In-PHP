<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

if (!isset($_GET['id'])) {
    header("Location: view_consignee.php");
    exit();
}

$id = $_GET['id'];

// Fetch consignee details from the database based on provided ID
$sql = "SELECT * FROM consignee WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$consignee = mysqli_fetch_assoc($result);

if (!$consignee) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: view_consignee.php");
    exit();
}

// Update Consignee
if (isset($_POST['submit'])) {
    $consignee_name = $_POST['consignee'];
    $number = $_POST['number'];
    $gstno = $_POST['gstno'];

    $sql = "UPDATE consignee SET consignee = ?, number = ?, gstno = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $consignee_name, $number, $gstno, $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Consignee details updated successfully.";
        header("Location: view_consignee.php");
        exit();
    } else {
        $error_message = "Error updating consignee details: " . mysqli_error($conn);
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
    <title>Edit Consignee</title>
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
            <h1 class="mb-4 text-center">Edit Consignee</h1>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="edit_consignee.php?id=<?php echo $id; ?>" method="post">
    <div class="mb-3">
        <label for="consignee" class="form-label">Consignee Name</label>
        <input type="text" id="consignee" name="consignee" class="form-control" value="<?php echo $consignee['consignee']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="number" class="form-label">Number</label>
        <input type="text" id="number" name="number" class="form-control" value="<?php echo $consignee['number']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="gstno" class="form-label">GST No</label>
        <input type="text" id="gstno" name="gstno" class="form-control" value="<?php echo $consignee['gstno']; ?>" required>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <a href="view_consignee.php" class="btn btn-secondary">Cancel</a>
</form>


        </div>
    </div>
    <!-- Bootstrap JavaScript -->
</body>
</html>
