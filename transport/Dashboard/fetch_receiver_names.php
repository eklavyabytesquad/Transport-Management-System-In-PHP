<?php
require_once "../login/connection.php"; // Include your database connection file

$query = $_POST['query'];

$stmt = $conn->prepare("SELECT DISTINCT receiver_company_name FROM bill_list WHERE receiver_company_name LIKE ?");
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();
$receiverNames = array();
while ($row = $result->fetch_assoc()) {
    $receiverNames[] = $row['receiver_company_name'];
}
$stmt->close();

echo json_encode($receiverNames);
?>
