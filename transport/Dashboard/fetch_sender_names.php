<?php
require_once "../login/connection.php"; // Include your database connection file

$query = $_POST['query'];

$stmt = $conn->prepare("SELECT DISTINCT sender_company_name FROM bill_list WHERE sender_company_name LIKE ?");
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();
$senderNames = array();
while ($row = $result->fetch_assoc()) {
    $senderNames[] = $row['sender_company_name'];
}
$stmt->close();

echo json_encode($senderNames);
?>
