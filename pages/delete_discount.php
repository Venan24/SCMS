<?php
include ('../session.php');

if (isset($_POST['delete_this_id'])){
    $selected_id = $_POST['delete_this_id'];
}else {
    $selected_id = NULL;
}

if (!is_null($selected_id) || $selected_id != ""){ 
    $stmt_remove_discount_by_id = $db->prepare("DELETE FROM discount_list WHERE discount_id = ?");
    $stmt_remove_discount_by_id->bind_param('i', $selected_id);
    $stmt_remove_discount_by_id->execute();
    $stmt_remove_discount_by_id->close();
}else{
    echo "ERROR. Missing value. Possible attack";
}
$db->close();
?>