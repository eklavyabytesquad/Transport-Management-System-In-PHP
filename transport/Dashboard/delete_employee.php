<?php
session_start();

require_once "../login/connection.php";

if (isset($_GET["fullname"])) {
    $fullName = $_GET["fullname"];

    // Delete the employee based on full name
    $sql_delete = "DELETE FROM empregister WHERE fullName = ?";
    $stmt_delete = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete, $sql_delete)) {
        mysqli_stmt_bind_param($stmt_delete, "s", $fullName);
        mysqli_stmt_execute($stmt_delete);
        header("Location: emp_register.php"); // Redirect back to emp_register.php after deletion
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
