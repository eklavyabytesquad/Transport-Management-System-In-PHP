<?php

require_once "../login/connection.php";

// Get search keyword from the AJAX request
$keyword = $_GET['keyword'];

// Escape the keyword to prevent SQL injection
$escaped_keyword = mysqli_real_escape_string($conn, "%$keyword%");

// Search invoices based on any column
$query = "SELECT * FROM bill_list 
          WHERE gr_no LIKE '$escaped_keyword' 
          OR sender_company_name LIKE '$escaped_keyword' 
          OR receiver_company_name LIKE '$escaped_keyword' 
          OR destination LIKE '$escaped_keyword' 
          OR currentdate LIKE '$escaped_keyword' 
          OR weight LIKE '$escaped_keyword' 
          OR no_of_packets LIKE '$escaped_keyword' 
          OR status LIKE '$escaped_keyword' 
          OR goods_pvt_mark LIKE '$escaped_keyword' 
          OR deliver LIKE '$escaped_keyword'"; // Include 'deliver' column in the query
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($invoice = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . strtoupper($invoice['gr_no']) . "</td>";
    echo "<td>" . strtoupper($invoice['sender_company_name']) . "</td>";
    echo "<td>" . strtoupper($invoice['receiver_company_name']) . "</td>";
    echo "<td>" . strtoupper($invoice['destination']) . "</td>";
    echo "<td>" . strtoupper($invoice['currentdate']) . "</td>";
    echo "<td>" . strtoupper($invoice['weight']) . "</td>";
    echo "<td>" . strtoupper($invoice['no_of_packets']) . "</td>";
    echo "<td>" . strtoupper($invoice['status']) . "</td>";
    echo "<td>" . strtoupper($invoice['goods_pvt_mark']) . "</td>";
    echo "<td>" . strtoupper($invoice['deliver']) . "</td>"; // Display delivery status

    echo "<td>";

    // Buttons column
    echo "<div class='btn-group' role='group'>";
    // Edit button
    echo "<a href='edit_invoice.php?gr_no={$invoice['gr_no']}' class='btn btn-primary'><i class='fas fa-pen'></i></a>";
    // Delete button with cross icon
    echo "<button class='btn btn-danger delete-btn' data-gr-no='{$invoice['gr_no']}'><i class='fas fa-times'></i></button>";
    // Download button with download icon
    echo "<button class='btn btn-info'><i class='fas fa-download'></i></button>";
    // Export button with export icon
    echo "<button class='btn btn-success'><i class='fas fa-file-export'></i></button>";
    echo "</div>"; // end btn-group div

    echo "</td>";
    echo "</tr>";
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);

?>
