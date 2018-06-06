<?php
include('../session.php');
$old_password = $_POST['OldPW'];
$new_password = $_POST['NewPw'];

if (password_verify($old_password, $password)) {
	$pwhash = password_hash($new_password, PASSWORD_DEFAULT);
	$stmt_update_password = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
	$stmt_update_password->bind_param('ss', $pwhash, $username);
	if($stmt_update_password->execute()){
		echo "Password Succesfully Updated.";
		$stmt_update_password->close();
		$db->close();
	}else{
		echo "Error in password update. Try Again";
		$stmt_update_password->close();
		$db->close();
	}
}else{
	echo "You did not enter your old password correctly";
}
?>
