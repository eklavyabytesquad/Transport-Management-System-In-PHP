<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Check if branch ID is provided
if (!isset($_GET['id'])) {
    header("Location: branch.php"); // Redirect if ID is not provided
    exit();
}

// Fetch branch details from the database based on provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM branchdetail WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$branch = mysqli_fetch_assoc($result);

// Check if branch exists
if (!$branch) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: branch.php"); // Redirect if branch does not exist
    exit();
}

// Update Branch
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


    // Update database
    $sql = "UPDATE branchdetail SET locationName = ?, transport1 = ?, pincode = ?, gstNo = ?, address = ?, number= ?, amount= ?,  branchCode = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssisssssi", $locationName, $transport1, $pincode, $gstNo, $address,$number,$amount, $branchCode, $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Location details updated successfully.";
        header("Location: branchdetail.php");
        exit();
    } else {
        $error_message = "Error updating location details: " . mysqli_error($conn);
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
    <title>Edit Branch Detail</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="card p-4 mt-5">
            <h1 class="mb-4">Edit Branch Detail</h1>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="edit_branch.php?id=<?php echo $id; ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="locationName" class="form-label">Location</label>
                        <input type="text" id="locationName" name="locationName" class="form-control" value="<?php echo $branch['locationName']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="transport1" class="form-label">Transport NAme</label>
                        <input type="text" id="transport1" name="transport1" class="form-control" value="<?php echo $branch['transport1']; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" id="pincode" name="pincode" class="form-control" value="<?php echo $branch['pincode']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="state" class="form-label">GST No</label>
                        <input type="text" id="state" name="state" class="form-control" value="<?php echo $branch['gstNo']; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address of Transport</label>
                    <textarea id="address" name="address" class="form-control" required><?php echo $branch['address']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="branchCode" class="form-label">Branch Code</label>
                    <input type="text" id="branchCode" name="branchCode" class="form-control" value="<?php echo $branch['branchCode']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">number</label>
                    <input type="text" id="number" name="number" class="form-control" value="<?php echo $branch['number']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Amount</label>
                    <input type="text" id="number" name="amount" class="form-control" value="<?php echo $branch['amount']; ?>" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
