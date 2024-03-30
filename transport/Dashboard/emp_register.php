<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SS TRANSPORT EMP REGISTER</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
    <script>
    // JavaScript function to confirm before deleting
    function confirmDelete() {
        return confirm("Are you sure you want to delete this user?\nक्या आप वाकई इस उपयोगकर्ता को हटाना चाहते हैं?");
    }
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container">
        <?php
        require_once "../login/connection.php"; // Include the database connection file

        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $password = $_POST["password"];

            // Check if the user already exists
            $sql_check = "SELECT * FROM empregister WHERE fullName = ?";
            $stmt_check = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt_check, $sql_check)) {
                mysqli_stmt_bind_param($stmt_check, "s", $fullName);
                mysqli_stmt_execute($stmt_check);
                $result_check = mysqli_stmt_get_result($stmt_check);
                if (mysqli_num_rows($result_check) > 0) {
                    echo "<div class='alert alert-danger'>User already exists.</div>";
                } else {
                    // Insert new user if not already exists
                    $sql_insert = "INSERT INTO empregister (fullName, password) VALUES (?, ?)";
                    $stmt_insert = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
                        mysqli_stmt_bind_param($stmt_insert, "ss", $fullName, $password);
                        mysqli_stmt_execute($stmt_insert);
                        echo "<div class='alert alert-success'>You have registered a new employee successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                    }
                }
            }
        }

        // Fetch and display already registered employees
        echo "<br><br>";
        $sql_select = "SELECT * FROM empregister";
        $result = mysqli_query($conn, $sql_select);
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Already Registered Employees\n पहले से पंजीकृत कर्मचारी</h2>";
            echo "<table class='table'>";
            echo "<thead><tr><th>Full Name पूरा नाम</th><th>Password पासवर्ड</th><th>Action हटाए इसे</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['fullName' ]}</td>";
                echo "<td>{$row['password']}</td>";
                echo "<td><a href='delete_employee.php?fullname=" . urlencode($row['fullName']) . "' class='btn btn-danger' onclick='return confirmDelete()'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No employees registered yet.</p>";
        }

        echo "<br><br><br><br><br><br>";
        echo "<h2>Register New Employees\n नए कर्मचारियों का पंजीकरण करें</h2>";
        ?>
        <form action="emp_register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name पूरा नाम">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="password" placeholder="Password पासवर्ड">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
            <div><p>Want to go back? <a href="dashboard.php">Main Page</a></p></div>
        </form>
    </div>
</body>
</html>
