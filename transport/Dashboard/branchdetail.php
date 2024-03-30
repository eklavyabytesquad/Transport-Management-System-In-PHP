<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Search Branch
$search_location = $search_pincode = $search_branch_code = '';
if (isset($_GET['search_location'])) {
    $search_location = $_GET['search_location'];
}
if (isset($_GET['search_pincode'])) {
    $search_pincode = $_GET['search_pincode'];
}
if (isset($_GET['search_branch_code'])) {
    $search_branch_code = $_GET['search_branch_code'];
}

// Fetch branch details from the database based on search query
$sql = "SELECT * FROM branchdetail WHERE 
        (locationName LIKE '%$search_location%' AND
        pincode LIKE '%$search_pincode%' AND
        branchCode LIKE '%$search_branch_code%')";
$result = mysqli_query($conn, $sql);
$branches = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Branch List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .search-input {
            width: 200px; /* Adjust width as needed */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Show Station List</h1>
        <!-- Search form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search Location Name" name="search_location" value="<?php echo htmlspecialchars($search_location); ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search Pincode" name="search_pincode" value="<?php echo htmlspecialchars($search_pincode); ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search Branch Code" name="search_branch_code" value="<?php echo htmlspecialchars($search_branch_code); ?>">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="branch.php" class="btn btn-success">Add</a>
                    <button class="btn btn-info" onclick="exportToExcel()">Export to Excel</button>
                </div>
            </div>
        </form>
        
        <!-- Display search results -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SN no.</th>
                        <th>Station Name</th>
                        <th>Transport</th>
                        <th>Pincode</th>
                        <th>GST No</th>
                        <th>Address</th>
                        <th>Station Code</th>
                        <th>Number</th>                        
                        <th>Bhada(Rate)</th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($branches as $key => $branch): ?>
                        <tr id="row_<?php echo $key + 1; ?>">
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $branch['locationName']; ?></td>
                            <td><?php echo $branch['transport1']; ?></td>
                            <td><?php echo $branch['pincode']; ?></td>
                            <td><?php echo $branch['gstNo']; ?></td>
                            <td><?php echo $branch['address']; ?></td>
                            <td><?php echo $branch['branchCode']; ?></td>
                            <td><?php echo $branch['number']; ?></td>
                            <td><?php echo $branch['amount']; ?></td>
                            <td>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <input type="hidden" name="branch_id" value="<?php echo $branch['id']; ?>">
                                    <a href="edit_branch.php?id=<?php echo $branch['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="delete_branch.php?id=<?php echo $branch['id']; ?>" class="btn btn-danger btn-sm" onclick="deleteRow(<?php echo $key + 1; ?>)">Delete</a>
                                    
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function deleteRow(rowId) {
            // Remove the row with the specified ID
            document.getElementById("row_" + rowId).remove();
            // Update IDs of subsequent rows
            var rows = document.querySelectorAll("tbody tr");
            for (var i = rowId - 1; i < rows.length; i++) {
                rows[i].querySelector("td:first-child").innerText = i + 1;
                rows[i].id = "row_" + (i + 1);
            }
        }
        function exportToExcel() {
            var table = document.querySelector('table');
            var html = table.outerHTML;

            // Prepare Excel file
            var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
            var url = URL.createObjectURL(blob);

            // Create download link
            var a = document.createElement('a');
            a.href = url;
            a.download = 'branch_list.xls';
            a.click();
        }

    </script>
</body>
</html>
