<?php
include('../session.php');

if (isset($_GET['customer_id'])){
    $selected_customer_id = $_GET['customer_id'];
}else{
    $selected_customer_id = NULL;
}

if (!is_null($selected_customer_id) || $selected_customer_id != ""){

$greskica = "";
$uspjesno = "";

$stmt_get_customer_info = $db->prepare("SELECT * FROM customers_list WHERE customer_id = ?");
$stmt_get_customer_info->bind_param('i', $selected_customer_id);
if ($stmt_get_customer_info->execute()) {
    $stmt_get_customer_info->bind_result($customer_id, $customer_name, $customer_address, $customer_phone, $customer_email);
    $stmt_get_customer_info->store_result();
    $stmt_get_customer_info->fetch();
    $stmt_get_customer_info->close();
    
    if (is_null($customer_name) || $customer_name == ""){
        header("Location: hax.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($db, $_POST['custname']);
    $customer_address = mysqli_real_escape_string($db, $_POST['custaddress']);
    $customer_phone = mysqli_real_escape_string($db, $_POST['custphone']);
    $customer_email = mysqli_real_escape_string($db, $_POST['custemail']);
    
    $update_customer_data = $db->prepare("UPDATE customers_list SET customer_name = ? , customer_address = ? , customer_phone = ?, customer_email = ? WHERE customer_id = ?");
    $update_customer_data->bind_param('ssssi', $customer_name, $customer_address, $customer_phone, $customer_email, $selected_customer_id);
    if ($update_customer_data->execute()) {
        $uspjesno = "<div class='alert alert-success'>Data successully updated.</div>";
        $update_customer_data->close();
    }else{
        $greskica = "<div class='alert alert-danger'>Error</div>";
        $update_customer_data->close();
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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SCMS - Edit Customer</title>

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
                    <h1 class="page-header">Edit Customer - <?php echo $customer_name?></h1>
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
                                            <label>Customer Name:</label>
                                            <input type="text" class="form-control" name="custname" value="<?php echo $customer_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Address:</label>
                                            <input type="text" class="form-control" name="custaddress" value="<?php echo $customer_address ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone:</label>
                                            <input type="text" class="form-control" name="custphone" value="<?php echo $customer_phone ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="custemail" value="<?php echo $customer_email ?>">
                                        </div>
                                        <button type="submit" id="refresh" class="btn btn-success">Update Customer Info</button>
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
	});
    </script>

</body>

</html>