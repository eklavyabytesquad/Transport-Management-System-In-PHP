<?php
session_start();
if (!isset($_SESSION["empregister"])) {
    header("Location: ../login/login.php");
    exit();
}

// Get the full name from the session
$fullName = $_SESSION['fullName'];

// Convert the full name to uppercase
$fullNameUpper = strtoupper($fullName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SS TRANSPORT DASHBOARD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

.centered {
    text-align: center;
}

h1 {
    font-family: Arial, sans-serif;
    font-size: 36px;
}

.animated {
    animation: slideIn 1s forwards;
    opacity: 0;
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="centered">
        <h1>WELCOME TO DASHBOARD <span class="animated"><?php echo $fullNameUpper; ?></span></h1>
    </div>
</body>
</html>
