<?php
require_once "../login/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gr_no'])) {
    $grNo = $_POST['gr_no'];
    $query = "DELETE FROM bill_list WHERE gr_no = '$grNo'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
mysqli_close($conn);
?>
