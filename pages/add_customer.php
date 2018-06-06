<?php
include('../session.php');
$greskica="";
$uspjesnoDodan="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$cus_name  = mysqli_real_escape_string($db, $_POST['cname']);
$cus_address = mysqli_real_escape_string($db, $_POST['caddress']);
$cus_phone = mysqli_real_escape_string($db, $_POST['cphone']);
$cus_email = mysqli_real_escape_string($db, $_POST['cemail']);

//Provjeri postojil takav username
$stmt_provjeriIsti = $db->prepare("SELECT customer_name FROM customers_list WHERE customer_name = ? ");
$stmt_provjeriIsti->bind_param('s', $cus_name);
$stmt_provjeriIsti->execute();
$stmt_provjeriIsti->bind_result($username2);
$stmt_provjeriIsti->store_result();
$stmt_provjeriIsti->fetch();
if ($stmt_provjeriIsti->num_rows == 1) {
                $greskica = "<div class='alert alert-danger'>Customer/Company already exist</div>";
                $stmt_provjeriIsti->close();
} else {
                $stmt_dodajKorisnika = $db->prepare("INSERT INTO customers_list (customer_name, customer_address, customer_phone, customer_email) VALUES (?, ?, ?, ?)");
                $stmt_dodajKorisnika->bind_param('ssss', $cus_name, $cus_address, $cus_phone, $cus_email);
                
                if ($stmt_dodajKorisnika->execute()) {
                                $uspjesnoDodan = "<div class='alert alert-success'>Customer added successfully</div>";
                                $stmt_dodajKorisnika->close();
                }          
}
$db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SCMS - Add Customer</title>

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
                    <h1 class="page-header">Add New Customer</h1>
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
                                    <form role="form" action="" method="post">
                                        <div class="form-group">
                                            <label>Customer/Company Name:</label>
                                            <input class="form-control" placeholder="Enter Customer/Company name" name="cname" type="text" required 
                                            data-fv-notempty-message="Customer/Company Name is required field" >
                                        </div>
										<div class="form-group">
                                            <label>Customer Address:</label>
                                            <input class="form-control" name="caddress" placeholder="Enter Customer Address" required 
                                            data-fv-notempty-message="Customer Address is required field" >
                                        </div>
										<div class="form-group">
                                            <label>Customer Phone Number:</label>
                                            <input class="form-control" name="cphone" placeholder="Enter Customer Phone Number" required 
                                            data-fv-notempty-message="Customer Phone Number is required field" >
                                        </div>
										<div class="form-group">
                                            <label>Customer Email</label>
                                            <input class="form-control" name="cemail" placeholder="Enter Customer Email" required 
                                            data-fv-notempty-message="Customer Email is required field" >
                                        </div>
                                        <button type="submit" class="btn btn-success">Add New Customer</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                    <br>
                                    <?php
                                        echo $uspjesnoDodan;
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
