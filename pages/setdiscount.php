<?php
include('../session.php');
$discname = $_POST['DiscountName'];
$discamount = $_POST['DiscountAmount'];

$stmt_add_Discount = $db->prepare("INSERT INTO discount_list (discount_name, discount_amount) VALUES (?, ?)");
$stmt_add_Discount->bind_param('si', $discname, $discamount);
if ($stmt_add_Discount->execute()) {
	echo "Discount added sucessfully";
}else{
	echo "Error";
}

$stmt_add_Discount->close();
$db->close();
?>
