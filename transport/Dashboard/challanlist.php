<?php
// Include database connection
require_once "../login/connection.php";

// Handle form submission to create a new challan entry
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data and insert into database
    // This part is to be filled based on your specific requirements
}

// Fetch existing challans from the database
$query = "SELECT * FROM challans";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challan Manager</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Challan Manager</h2>
    
    <!-- Form to create a new challan entry -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Include form fields for creating a new challan entry -->
        <!-- These fields should include input fields for truck, driver, owner, destination, date, etc. -->
        
        <button type="submit" class="btn btn-primary mt-3">Create Challan</button>
    </form>

    <hr>

    <!-- Display existing challans -->
    <h3>Existing Challans</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Challan No</th>
                <th>Truck</th>
                <th>Driver</th>
                <th>Owner</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['challan_no']; ?></td>
                    <td><?php echo $row['truck']; ?></td>
                    <td><?php echo $row['driver']; ?></td>
                    <td><?php echo $row['owner']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td>
                        <!-- Button to select invoices and add to current challan -->
                        <a href="select_invoices.php?challan_id=<?php echo $row['id']; ?>" class="btn btn-primary">Select Invoices</a>
                        <!-- Other actions buttons -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
