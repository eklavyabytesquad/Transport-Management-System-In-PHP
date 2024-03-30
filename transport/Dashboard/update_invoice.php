<?php
// Include your database connection file
require_once "../login/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if(isset($_POST['gr_no']) && isset($_POST['current_date']) && isset($_POST['sender_company_name']) && isset($_POST['sender_company_gst'])  && isset($_POST['status']) ) {
        // Sanitize input data to prevent SQL injection
        $grNo = mysqli_real_escape_string($conn, $_POST['gr_no']);
        $currentDate = mysqli_real_escape_string($conn, $_POST['current_date']);
        $senderCompanyName = mysqli_real_escape_string($conn, $_POST['sender_company_name']);
        $senderCompanyGST = mysqli_real_escape_string($conn, $_POST['sender_company_gst']);
        $receiverCompanyName = mysqli_real_escape_string($conn, $_POST['receiver_company_name']);
        $receiverCompanyGST = mysqli_real_escape_string($conn, $_POST['receiver_company_gst']);
        $eWayBill = mysqli_real_escape_string($conn, $_POST['e_way_bill']);
        $senderGoodsBillDate = mysqli_real_escape_string($conn, $_POST['sender_goods_bill_date']);
        $senderGoodsBillNo = mysqli_real_escape_string($conn, $_POST['sender_goods_bill_no']);
        $senderGoodsBillValue = mysqli_real_escape_string($conn, $_POST['sender_goods_bill_value']);
        $natureOfGoods = mysqli_real_escape_string($conn, $_POST['nature_of_goods']);
        $goodsPvtMark = mysqli_real_escape_string($conn, $_POST['goods_pvt_mark']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);
        $noOfPackets = mysqli_real_escape_string($conn, $_POST['no_of_packets']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $deliver = mysqli_real_escape_string($conn, $_POST['deliver']);
        $chargesPerKg = mysqli_real_escape_string($conn, $_POST['charges_per_kg']);
        $labourCharge = mysqli_real_escape_string($conn, $_POST['labour_charge']);
        $billCharge = mysqli_real_escape_string($conn, $_POST['bill_charge']);
        $pf = mysqli_real_escape_string($conn, $_POST['pf']);
        $otherCharge = mysqli_real_escape_string($conn, $_POST['other_charge']);
        $total = mysqli_real_escape_string($conn, $_POST['total']);

        // Update the invoice details in the database
        $query = "UPDATE bill_list SET currentdate='$currentDate', sender_company_name='$senderCompanyName', sender_company_gst='$senderCompanyGST', receiver_company_name='$receiverCompanyName', receiver_company_gst='$receiverCompanyGST', e_way_bill='$eWayBill', sender_goods_bill_date='$senderGoodsBillDate', sender_goods_bill_no='$senderGoodsBillNo', sender_goods_bill_value='$senderGoodsBillValue', nature_of_goods='$natureOfGoods', goods_pvt_mark='$goodsPvtMark', weight='$weight', no_of_packets='$noOfPackets', status='$status', deliver='$deliver', charges_per_kg='$chargesPerKg', labour_charge='$labourCharge', bill_charge='$billCharge', pf='$pf', other_charge='$otherCharge', total='$total' WHERE gr_no='$grNo'";
 $result = mysqli_query($conn, $query);

 if ($result) {
    // Redirect to biltylist.php after successful update
    header("Location: biltylist.php");
    exit(); // Make sure to exit after redirection
} else {
    echo "Error updating invoice: " . mysqli_error($conn);
}
} else {
echo "All fields are required.";
}
} else {
echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
