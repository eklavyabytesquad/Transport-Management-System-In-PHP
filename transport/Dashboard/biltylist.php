<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Manager</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-vyomDtH8wjnrU/d5FQV7OZBS8m0qj0BDARKn5zzX+qZKX+bswHY3E3cNsJ9y8CVKma+OQ8vhnRBzB1TlAps8sg==" crossorigin="anonymous" />
    <!-- Other head elements and styles -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        td a {
            text-decoration: none;
            color: #007bff;
        }
        .btn {
            padding: 6px 12px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Bill Manager</h2>
    <div class="col-md-8">
    <div class="row">
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control mb-2" placeholder="Search...">
        </div>
        <div class="col-md-6">
        <input type="date" id="searchDate" class="form-control" placeholder="Search by Date...">
       
    </div>
    </div>
    <button id="searchByDateBtn" class="btn btn-primary">Search</button>
        <button id="refreshBtn" class="btn btn-secondary">Refresh</button>
    </div>
    <table class="table">
    <thead>
        <tr>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">GR No</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Sender</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Receiver</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Destination</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Date</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Weight</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">No of Nag</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Payment Status</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Pvt Marks</th>
            <th class="fw-bold" style="font-family: 'Arial', sans-serif;">Action</th>
        </tr>
    </thead>
    <tbody id="invoiceTableBody">
        <!-- Invoice data will be populated here -->
    </tbody>
</table>

</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Other head elements and styles -->
<!-- Include your custom JavaScript file -->
<script>$(document).ready(function() {
    // Load invoices on page load
    loadInvoices();

    // Bind event to search input
    $('#searchInput').on('keyup', function() {
        searchInvoices($(this).val());
    });
});

function loadInvoices() {
    // AJAX request to fetch invoices
    $.ajax({
        url: 'fetch_invoices.php', // Your PHP script to fetch invoices
        method: 'GET',
        success: function(response) {
            $('#invoiceTableBody').html(response);
        }
    });
}

function searchInvoices(keyword) {
    // AJAX request to search invoices
    $.ajax({
        url: 'search_invoices.php', // Your PHP script to search invoices
        method: 'GET',
        data: { keyword: keyword },
        success: function(response) {
            $('#invoiceTableBody').html(response);
        }
    });
}


$(document).on('click', '.delete-btn', function() {
    var grNo = $(this).data('gr-no');
    deleteInvoice(grNo);
});

function deleteInvoice(grNo) {
    if (confirm("Are you sure you want to delete this invoice?")) {
        $.ajax({
            url: 'delete_invoice.php', // Your PHP script to delete invoice
            method: 'POST',
            data: { gr_no: grNo },
            success: function(response) {
                if (response === 'success') {
                    loadInvoices(); // Reload the invoices after deletion
                } else {
                    alert('Error deleting invoice. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error deleting invoice. Please try again.');
            }
        });
    }
}
$(document).on('click', '#searchByDateBtn', function() {
    var searchDate = $('#searchDate').val();
    searchInvoices(searchDate);
});


function searchInvoices(keyword) {
    // AJAX request to search invoices
    $.ajax({
        url: 'search_invoices.php', // Your PHP script to search invoices
        method: 'GET',
        data: { keyword: keyword },
        success: function(response) {
            $('#invoiceTableBody').html(response);
        }
    });
}
$(document).on('click', '#refreshBtn', function() {
    location.reload(); // Reload the page
});

</script>
</body>
</html>
