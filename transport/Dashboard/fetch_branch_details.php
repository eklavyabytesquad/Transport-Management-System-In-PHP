<?php
// fetch_branch_details.php

// Include database connection
require_once "../login/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stationCode = $_POST['station_code'];

    // Prepare and execute query to fetch branch details based on station code
    $sql = "SELECT * FROM branchdetail WHERE branchCode = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $stationCode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Return fetched data as JSON
        echo json_encode([
            'station_address' => $row['address'],
            'station_number' => $row['number'],
            'station_gstno' => $row['gstNo'],
            'transport_name' => $row['transport1'],
            'transport_rate' => $row['amount']
            // You can add more fields here as needed
        ]);
    } else {
        // Return an empty object if no data found
        echo json_encode([]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Log error if request method is not POST
    error_log("fetch_branch_details.php: Invalid request method");
    echo json_encode(["error" => "Invalid request method"]);
}
?>
