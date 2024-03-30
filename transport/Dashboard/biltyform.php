<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;
        }
    </style>
    <style>
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-container .input-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .form-container .input-group .form-label {
            margin-bottom: 0;
            flex-basis: 30%; /* Adjust the label width */
        }

        .form-container .input-group .form-control {
            flex-grow: 1;
        }

        .btn-small {
            padding: 0.375rem 0.75rem; /* Adjust the button padding */
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="mt-5">Common Values In Bilty बिल्टी में सामान्य मूल्य</h1>
        <form id="invoiceForm" action="" method="post" class="mt-4 form-container">
            <?php
            // Fetch data from database and populate form fields
            require_once "../login/connection.php"; // Include your database connection file

            $sql = "SELECT * FROM constbill LIMIT 1"; // Assuming only one row in constbill table
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            // Define fields and their corresponding database columns
            $fields = array(
                "Billing Branch Address" => "BillBranchAdd",
                "GST NO" => "gst_no",
                "Bank Detail 1" => "bank_detail_1",
                "Bank Detail 2" => "bank_detail_2",
                "Customer Care" => "customer_care"
            );

            foreach ($fields as $label => $column) {
                echo '<div class="input-group">';
                echo '<label for="' . $column . '" class="form-label">' . $label . '</label>';
                echo '<input type="text" id="' . $column . '" name="' . $column . '" class="form-control" value="' . $row[$column] . '" readonly>';
                echo '<button type="button" class="btn btn-danger edit-btn btn-sm">Edit</button>';
                echo '</div>';
            }
            ?>
            <button type="submit" name="submit" class="btn btn-primary mt-3 btn-small">Save Changes</button>
            <button type="button" id="refreshButton" class="btn btn-primary mt-3 btn-small">Refresh (CTRL+R)</button>
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit'])) {
            // Update database with edited values
            $success_count = 0;
            $error_count = 0;
            foreach ($fields as $label => $column) {
                if (isset($_POST[$column])) {
                    $value = $_POST[$column];
                    $update_sql = "UPDATE constbill SET $column = '$value'";
                    if (mysqli_query($conn, $update_sql)) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                }
            }

            if ($success_count > 0) {
                $success_message = 'Successfully edited ' . $success_count . ' field(s).';
            }
            if ($error_count > 0) {
                $error_message = 'Error updating ' . $error_count . ' field(s).';
            }

            if ($success_count > 0) {
                echo '<div class="alert alert-success mt-3" role="alert">' . $success_message . '</div>';
            }
            if ($error_count > 0) {
                echo '<div class="alert alert-danger mt-3" role="alert">' . $error_message . '</div>';
            }
        }
        ?>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle edit mode
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const inputField = button.previousElementSibling;
                const saveButton = button.nextElementSibling;
                inputField.readOnly = !inputField.readOnly;
                saveButton.style.display = inputField.readOnly ? 'none' : 'block';
            });
        });

        // Refresh button action
        document.getElementById('refreshButton').addEventListener('click', function() {
            window.location.reload();
        });
    </script>
</body>
</html>
