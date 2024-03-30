<?php
// Establish database connection
require_once "..\login\connection.php";

// Fetch data from the database
$sql = "SELECT * FROM branchdetail ORDER BY locationName ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output file name and content type
    $filename = "SS_Transport_Branch_List.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Create a file pointer
    $output = fopen('php://output', 'w');

    // Write CSV headers
    fputcsv($output, array('Location Name', 'Transport', 'GST No', 'Pincode', 'Branch Code', 'Number', 'Amount'));

    // Loop through each row of the result set
    while ($row = $result->fetch_assoc()) {
        // Write data rows
        fputcsv($output, array(
            $row['locationName'],
            $row['transport1'],
            $row['gstNo'],
            $row['pincode'],
            $row['branchCode'],
            $row['number'],
            $row['amount']
        ));
    }

    // Close the file pointer
    fclose($output);
} else {
    echo "No data found";
}

$conn->close();
?>
