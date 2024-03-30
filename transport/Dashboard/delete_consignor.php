<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

if (!isset($_GET['id'])) {
    header("Location: view_consignor.php");
    exit();
}

$id = $_GET['id'];

// Prepare the DELETE statement
$sql = "DELETE FROM consignor WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters and execute the statement
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect back to the consignee view page
header("Location: view_consignor.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head section with meta tags, title, and Bootstrap CSS -->
</head>
<body>
    <!-- Navbar -->
    <!-- Container with card for displaying delete status -->
    <div class="container mt-5">
        <div class="card p-4">
            <h1 class="mb-4">Delete Consignor</h1>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <!-- Alert message for successful deletion -->
            <?php if (isset($_SESSION['success_message'])) : ?>
                <div class="alert alert-success" role="alert"><?php echo $_SESSION['success_message']; ?></div>
            <?php
                unset($_SESSION['success_message']);
            endif; ?>
            <!-- Button to return to view consignee page -->
            <a href="view_consignor.php" class="btn btn-primary">Back to View Consignee</a>
        </div>
    </div>
    <!-- Bootstrap JavaScript -->
</body>
</html>
