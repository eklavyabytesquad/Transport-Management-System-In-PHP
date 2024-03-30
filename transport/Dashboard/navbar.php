<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Navbar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        /* Custom styles for hamburger menu */
        .navbar-toggler-icon {
            background-color: transparent;
            border: none;
            outline: none;
            cursor: pointer;
            width: 40px;
            height: 3px;
            display: block;
            position: relative;
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-toggler-icon span {
            background-color: #000;
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            transition: transform 0.3s ease-in-out;
        }

        .navbar-toggler-icon span:nth-child(1) {
            top: 0;
        }

        .navbar-toggler-icon span:nth-child(2) {
            top: 50%;
            transform: translateY(-50%);
        }

        .navbar-toggler-icon span:nth-child(3) {
            bottom: 0;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon span:nth-child(1),
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon span:nth-child(3) {
            transform: translateY(50%) rotate(45deg);
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon span:nth-child(2) {
            opacity: 0;
        }

        /* Styling for dropdown menu */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 10rem;
            padding: .5rem 0;
            margin: .125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: .25rem;
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .dropdown-menu a {
            display: block;
            padding: .25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #f8f9fa;
            color: #000;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Custom navbar styles */
        .navbar {
            background-color: #007bff; /* Blue navbar background color */
            box-shadow: 0 2px 4px rgba(5, 4, 4, 0.1); /* Shadow effect */
        }

        .navbar-brand,
        .nav-link {
            color: #fff; /* White text color */
        }

        .navbar-brand:hover,
        .nav-link:hover {
            color: #f8f9fa; /* Lighter white on hover */
        }
    </style>
</head>
<body>
<?php
// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if 'fullName' key is set in $_SESSION
if (isset($_SESSION['fullName'])) {
    $fullName = $_SESSION['fullName'];

    // Convert the full name to uppercase
    $fullNameUpper = strtoupper($fullName);
} else {
    // If 'fullName' is not set, you can set a default value or redirect the user
    // For example, set a default value
    $fullNameUpper = "Guest";
}
?>

<nav class="navbar navbar-expand-lg navbar-#1083ff; bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><strong>SS TRANSPORT DASHBOARD</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Left side items -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMaster" role="button" aria-expanded="false">
                        <strong>Master</strong>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMaster">
                        <li><a href="consignor_add.php" class="dropdown-item"><strong>Add Consignor</strong></a></li>
                        <li><a href="consignee_add.php" class="dropdown-item"><strong>Add Consignee</strong></a></li>
                        <li><a href="emp_register.php" class="dropdown-item"><strong>Manage User</strong></a></li>
                        <li><a href="branch.php" class="dropdown-item"><strong>Add Branch</strong></a></li>
                        <li><a href="biltyform.php" class="dropdown-item"><strong>Bilty Master</strong></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_invoice.php" ><strong>Create New Bill</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="biltylist.php"><strong>Bill List</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="challan.php"><strong>Challan</strong></a>
                </li>
            </ul>
        </div>
<!-- Right side items -->
<div class="collapse navbar-collapse order-lg-last" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><strong><i class="fas fa-bell"></i></strong></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                        <strong><?php echo $fullNameUpper; ?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a href="#" class="dropdown-item"><strong>Profile</strong></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="../login/logout.php" class="dropdown-item"><strong>Logout</strong></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
