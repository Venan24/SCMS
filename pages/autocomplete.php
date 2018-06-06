<?php		
	$keyword = strval($_POST['query']);
	$search_param = "{$keyword}%";
	$conn = new mysqli('localhost', 'root', '' , 'baza');

	$sql = $conn->prepare("SELECT DISTINCT product_name FROM products_list WHERE product_name LIKE ?");
	$sql->bind_param("s", $search_param);			
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$countryResult[] = $row["product_name"];
		}
		echo json_encode($countryResult);
	}
	$conn->close();
?>

