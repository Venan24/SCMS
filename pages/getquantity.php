<?php
include('../session.php');
$productid = $_POST['MyValue'];

$stmt_productid = $db->prepare("SELECT product_quantity FROM products_list WHERE product_id = ?");
$stmt_productid->bind_param('i', $productid);
$stmt_productid->execute();
$result = $stmt_productid->get_result();
$row = mysqli_fetch_assoc($result);
echo json_encode($row['product_quantity']);

$stmt_productid->close();
$db->close();
?>
