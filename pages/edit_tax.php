<?php
include('../session.php');

if (isset($_GET['tax_id'])){
    $selected_tax_id = $_GET['tax_id'];
}else{
    $selected_tax_id = NULL;
}

if (!is_null($selected_tax_id) || $selected_tax_id != ""){

$greskica = "";
$uspjesno = "";

$stmt_get_tax_info = $db->prepare("SELECT * FROM tax_list WHERE tax_id = ?");
$stmt_get_tax_info->bind_param('i', $selected_tax_id);
if ($stmt_get_tax_info->execute()) {
    $stmt_get_tax_info->bind_result($tax_id, $tax_name, $tax_amount);
                $stmt_get_tax_info->store_result();
                $stmt_get_tax_info->fetch();
                $stmt_get_tax_info->close();
                
                if (is_null($tax_name) || $tax_name == ""){
                    header("Location: hax.php");
                }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $tax_name = mysqli_real_escape_string($db, $_POST['taxname']);
                $tax_amount = mysqli_real_escape_string($db, $_POST['taxamount']);
                
                $update_tax_data = $db->prepare("UPDATE tax_list SET tax_name = ? , tax_amount = ? WHERE tax_id = ?");
                $update_tax_data->bind_param('sii', $tax_name, $tax_amount, $selected_tax_id);
                if ($update_tax_data->execute()) {
                    $uspjesno = "<div class='alert alert-success'>Data successully updated. Auto-Refresh in 2 seconds.</div>";
                    $update_tax_data->close();
                    header('Refresh: 2; url="edit_tax.php?tax_id='.$selected_tax_id.'"');
                }else{
                    $update_tax_data->close();
                    $greskica = "<div class='alert alert-danger'>Error</div>";
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

    <title>SCMS - Edit Tax</title>

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
                    <h1 class="page-header">Edit Tax - <?php echo $tax_name?></h1>
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
                                            <label>Tax Name:</label>
                                            <input type="text" class="form-control" name="taxname" value="<?php echo $tax_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Amount:</label>
                                            <input type="number" class="form-control" name="taxamount" value="<?php echo $tax_amount ?>">
                                        </div>
                                        <button type="submit" class="btn btn-success">Update Tax Info</button>
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

</body>

</html>
