<?php
include('../session.php');
$taxna = $_POST['TaxName'];
$taxam = $_POST['TaxAmount'];

$stmt_add_tax = $db->prepare("INSERT INTO tax_list (tax_name, tax_amount) VALUES (?, ?)");
$stmt_add_tax->bind_param('si', $taxna, $taxam);
if ($stmt_add_tax->execute()) {
	echo "Tax added sucessfully";
}else{
	echo "Error";
}

$stmt_add_tax->close();
$db->close();
?>
