<?php
session_start();
require_once "../login/connection.php"; // Include your database connection file

// Search Consignee
$search_consignee_name = '';
if (isset($_GET['search_consignee_name'])) {
    $search_consignee_name = $_GET['search_consignee_name'];
}

// Fetch consignee details from the database based on search query
$sql = "SELECT * FROM consignee WHERE consignee LIKE '%$search_consignee_name%'";
$result = mysqli_query($conn, $sql);
$consignees = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Consignee Data</title>
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
        <h1 class="mb-4">View Consignee Data</h1>
        <!-- Search form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Consignee Name" name="search_consignee_name" value="<?php echo htmlspecialchars($search_consignee_name); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
            </div>
        </form>
        
        <!-- Display search results -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Consignee Name</th>
                        <th>Number</th>
                        <th>GST No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consignees as $consignee): ?>
                        <tr>
                            <td><?php echo $consignee['consignee']; ?></td>
                            <td><?php echo $consignee['number']; ?></td>
                            <td><?php echo $consignee['gstno']; ?></td>
                            <td>
                                <a href="edit_consignee.php?id=<?php echo $consignee['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_consignee.php?id=<?php echo $consignee['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this consignee?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript for exporting to Excel -->
    <script>
        function exportToExcel() {
            var table = document.querySelector('table');
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + escape(html);
            var link = document.createElement("a");
            link.download = "consignee_data.xls";
            link.href = url;
            link.click();
        }
    </script>
</body>
</html>
