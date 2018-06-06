<?php
include ('../session.php');

if (isset($_POST['delete_this_id'])){
    $selected_id = $_POST['delete_this_id'];
}else {
    $selected_id = NULL;
}

if (!is_null($selected_id) || $selected_id != ""){ 
    $stmt_check_category_by_id = $db->prepare("SELECT * FROM categories_list WHERE category_id = ?");
    $stmt_check_category_by_id->bind_param('i', $selected_id);
    $stmt_check_category_by_id->execute();
    $stmt_check_category_by_id->bind_result($category_id, $category_name, $category_active);
    $stmt_check_category_by_id->store_result();
    $stmt_check_category_by_id->fetch();
    
    if ($category_active != 1) {
        $stmt_remove_category_by_id = $db->prepare("DELETE FROM categories_list WHERE category_id = ?");
        $stmt_remove_category_by_id->bind_param('i', $selected_id);
        $stmt_remove_category_by_id->execute();
        $stmt_remove_category_by_id->close();
    }else{
        echo "You can not remove category that is still active";
    }  
}else{
    echo "ERROR. Missing value. Possible attack";
}
$db->close();
?>