<?php
include('../session.php');

if (isset($_GET['user_id'])){
    $selected_user_id = $_GET['user_id'];
}else{
    $selected_user_id = NULL;
}

if (!is_null($selected_user_id) || $selected_user_id != ""){

$greskica = "";
$uspjesno = "";

$stmt_get_user_info = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt_get_user_info->bind_param('i', $selected_user_id);
if ($stmt_get_user_info->execute()) {
    $stmt_get_user_info->bind_result($user_id, $username, $password, $firstname, $lastname, $role);
    $stmt_get_user_info->store_result();
    $stmt_get_user_info->fetch();
    $stmt_get_user_info->close();
    
    if (is_null($username) || $username == ""){
        header("Location: hax.php");
    }
}

if($role == 1){
    $userrole = "Administrator";
   }else{
      $userrole = "Korisnik";
   }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = mysqli_real_escape_string($db, $_POST['username']);
    $first_name = mysqli_real_escape_string($db, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($db, $_POST['lastname']);
    $user_role = mysqli_real_escape_string($db, $_POST['role']);

    if($user_role < 0 || $user_role > 1 ){
    	echo "ERROR. Missing value. Possible attack";
    }else{
    $update_user_data = $db->prepare("UPDATE users SET username = ? , firstname = ? , lastname = ?, role = ? WHERE id = ?");
    $update_user_data->bind_param('sssii', $user_name, $first_name, $last_name, $user_role, $selected_user_id);
    if ($update_user_data->execute()) {
        $uspjesno = "<div class='alert alert-success'>Data successully updated.</div>";
        $update_user_data->close();
        header('Refresh: 2; url="edit_user.php?user_id='.$selected_user_id.'"');
    }else{
        $update_user_data->close();
        $greskica = "<div class='alert alert-danger'>Error</div>";
    }
}
    
}
}else{
    header("Location: hax.php");
}
$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sales and Company Management System">
    <meta name="author" content="Venan Osmic">

    <title>SCMS - Edit User</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'navigation.php' ?>
        <!-- Navigation -->

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit User - <?php echo $username?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Username (email):</label>
                                            <input type="email" class="form-control" name="username" value="<?php echo $username ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>First Name:</label>
                                            <input type="text" class="form-control" name="firstname" value="<?php echo $firstname ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name:</label>
                                            <input type="text" class="form-control" name="lastname" value="<?php echo $lastname ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>User Role</label>
                                            <select id="CatSelect" class="form-control" name="role">
                                                <option value="0" >User</option>
                                                <option value="1" >Administrator</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="refresh" class="btn btn-success">Update User Info</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                    <br>
                                    <?php
                                        echo $uspjesno;
                                        echo $greskica;
                                    ?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <script>
    $(document).ready (function(){
    	setTimeout(function () {
			$(".alert-success").slideUp(500);
        },1500);

    	$(function() {
        	var temp = "<?php echo $role ?>"; 
            $("#CatSelect").val(temp);
        });
	});
    </script>

</body>

</html>