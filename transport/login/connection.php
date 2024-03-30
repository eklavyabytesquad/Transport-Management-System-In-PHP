<?php

$hostName = "localhost:3307";
$dbUser = "root";
$dbPassword = "T1234ekl@arn"; // Add your database password here if applicable
$dbName = "location";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
