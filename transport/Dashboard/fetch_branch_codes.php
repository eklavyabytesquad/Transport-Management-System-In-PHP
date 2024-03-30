<?php
// fetch_branch_codes.php

// Include your database connection file
require_once "../login/connection.php";

// Prepare and execute query to fetch branch codes
$sql = "SELECT branchCode FROM branchdetail"; // Change 'your_table_name' to your actual table name
$result = mysqli_query($conn, $sql);

if ($result) {
    $branchCodes = []; // Array to store branch codes

    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $branchCodes[] = $row['branchCode'];
    }

    // Return branch codes as JSON
    echo json_encode($branchCodes);
} else {
    // Handle query error
    echo json_encode(['error' => 'Failed to fetch branch codes']);
}

// Close database connection
mysqli_close($conn);
?>
