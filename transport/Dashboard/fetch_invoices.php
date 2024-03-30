<?php
// Include your database connection file
require_once "../login/connection.php";

// Fetch all invoices from the database
$query = "SELECT * FROM bill_list";
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
    
    // Display delivery status
    echo "<td>" . strtoupper($invoice['deliver']) . "</td>";

    // Buttons column
    echo "<td>";
    // Edit button
    echo "<div class='btn-group-vertical' role='group'>";
    echo "<a href='edit_invoice.php?gr_no={$invoice['gr_no']}' class='btn btn-primary'><i class='fas fa-pen'></i></a>";
    echo "</div>"; // end btn-group-vertical div

    echo "<div class='btn-group-vertical' role='group'>";
    // Delete button with cross icon
    echo "<button class='btn btn-danger delete-btn' data-gr-no='{$invoice['gr_no']}'><i class='fas fa-times'></i></button>";
    echo "</div>"; // end btn-group-vertical div

    echo "<div class='btn-group-vertical' role='group'>";
    // Download button with download icon
    echo "<button class='btn btn-info'><i class='fas fa-download'></i></button>";
    echo "</div>"; // end btn-group-vertical div

    echo "<div class='btn-group-vertical' role='group'>";
    // Export button with export icon
    echo "<button class='btn btn-success'><i class='fas fa-file-export'></i></button>";
    echo "</div>"; // end btn-group-vertical div

    echo "</td>"; // end buttons column

    echo "</tr>";
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
