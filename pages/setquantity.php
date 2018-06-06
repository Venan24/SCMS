<?php
include('../session.php');
$productid = $_POST['MyValue'];
$newquantity = $_POST['MyNewValue'];

$stmt_productid = $db->prepare("UPDATE products_list SET product_quantity = ? WHERE product_id = ?");
$stmt_productid->bind_param('ii', $newquantity, $productid);
if($stmt_productid->execute()){
	echo "Succesfully";
}else{
	echo "Error, Try Again";
}

$stmt_productid->close();
$db->close();
?>
