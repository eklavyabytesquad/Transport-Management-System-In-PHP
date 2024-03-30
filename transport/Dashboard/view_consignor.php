<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Search Consignor
$search_consignor_name = '';
if (isset($_GET['search_consignor_name'])) {
    $search_consignor_name = $_GET['search_consignor_name'];
}

// Fetch consignor details from the database based on search query
$sql = "SELECT * FROM consignor WHERE consignor LIKE '%$search_consignor_name%'";
$result = mysqli_query($conn, $sql);
$consignors = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Consignor Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">View Consignor Data</h1>
        <!-- Search form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Consignor Name" name="search_consignor_name" value="<?php echo htmlspecialchars($search_consignor_name); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
            </div>
        </form>
        
        <!-- Display search results -->
        <div class="table-responsive">
            <table class="table table-striped" id="consignorTable">
                <thead>
                    <tr>
                        <th>Consignor Name</th>
                        <th>Number</th>
                        <th>GST No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consignors as $consignor): ?>
                        <tr>
                            <td><?php echo $consignor['consignor']; ?></td>
                            <td><?php echo $consignor['number']; ?></td>
                            <td><?php echo $consignor['gstno']; ?></td>
                            <td>
                                <a href="edit_consignor.php?id=<?php echo $consignor['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_consignor.php?id=<?php echo $consignor['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this consignor?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SheetJS (js-xlsx) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            const table = document.getElementById("consignorTable");
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Consignor Data");
            XLSX.writeFile(wb, "consignor_data.xlsx");
        }
    </script>
</body>
</html>
