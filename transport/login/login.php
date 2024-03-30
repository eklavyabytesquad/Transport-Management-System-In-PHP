<?php
session_start();
if (isset($_SESSION["empregister"])) {
   header("Location: ../Dashboard/dashboard.php"); // Redirect to dashboard.php in the transport directory
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SS TRANSPORT EMP LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
       .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f8f9fa; /* Light gray background */
        }
        .card-title {
            color: #007bff; /* Blue color for title */
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="max-width: 400px;">
            <h2 class="card-title text-center mb-4">Login</h2>
            <?php
            if (isset($_POST["login"])) {
                if (isset($_POST["fullName"]) && isset($_POST["password"])) {
                    $fullName = $_POST["fullName"];
                    $password = $_POST["password"];
                    require_once "connection.php";
                    $sql = "SELECT * FROM empregister WHERE fullName = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, "s", $fullName);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($result) {
                            $empregister = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            if ($empregister) {
                                // Compare entered password with the password from the database
                                if ($password === $empregister["password"]) {
                                    $_SESSION["empregister"] = "yes";
                                    $_SESSION["fullName"] = $fullName; // Set the fullName in session
                                    echo "<script>alert('Login successful'); window.location.href='../Dashboard/dashboard.php';</script>";
                                    exit();
                                } else {
                                    echo "<div class='alert alert-danger text-center'>Password does not match</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger text-center'>Employee not found</div>";
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                }
            }
            ?>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" placeholder="Enter Full Name" name="fullName" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" placeholder="Enter Password" name="password" class="form-control">
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="mt-3 text-center">
                <p>Not registered yet? <a href="enquiry.php">Send Request</a></p>
                <p>Go back to <a href="../">Home Page</a></p> <!-- Link to the home page -->
            </div>
        </div>
    </div>
</body>
</html>