<?php
require_once "../login/connection.php"; // Include your database connection file

$type = $_POST['type'];
$name = $_POST['name'];

$stmt = $conn->prepare("SELECT {$type}_company_gst FROM bill_list WHERE {$type}_company_name = ? LIMIT 1");
$stmt->bind_param("s", $name);
$stmt->execute();
$stmt->bind_result($gst);
$stmt->fetch();
$stmt->close();

echo $gst;
?>
