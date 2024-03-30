<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Check if branch ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: branch.php"); // Redirect if ID is not provided
    exit();
}

$id = $_GET['id']; // Get branch ID from URL parameter

// Fetch branch details from the database based on provided ID
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

// Delete Branch
if (isset($_POST['delete'])) {
    // Delete branch from the database
    $sql = "DELETE FROM branchdetail WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Location details deleted successfully.";
        header("Location: branchdetail.php");
        exit();
    } else {
        $error_message = "Error deleting location details: " . mysqli_error($conn);
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
    <title>Delete Branch Detail</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="card p-4 mt-5">
            <h1 class="mb-4">Delete Branch Detail</h1>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="delete_branch.php?id=<?php echo $id; ?>" method="post">
                <p>Are you sure you want to delete the branch with ID <?php echo $id; ?>?</p>
                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                <a href="branch.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
