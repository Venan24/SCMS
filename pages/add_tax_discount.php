<?php
include('../session.php');
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SCMS - Add Tax or Discount</title>

    <!-- Latest compiled and minified Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

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
                    <h1 class="page-header">Add Tax Fee / Discount</h1>
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
                                    <div class="alert alert-info text-center">
                                        <strong>CREATE NEW TAX FEE</strong>
                                    </div>
                                    <form role="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Tax Fee Name:</label>
                                            <input class="form-control" placeholder="Enter Tax Fee name" id="tax_name" type="text" required 
                                            data-fv-notempty-message="Tax Name is required" >
                                        </div>
                                        <label>Tax Amount (in percentage %):</label>
                                        <div class="form-group input-group">
                                            <input class="form-control" placeholder="Enter Tax Amount" id="tax_amount" type="number" required 
                                            data-fv-notempty-message="Tax Amount is required" >
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <button type="submit" id="taxsubmit" class="btn btn-success">Add New Tax</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->


                                <div class="col-lg-6">
                                    <div class="alert alert-warning text-center">
                                        <strong>CREATE NEW DISCOUNT</strong>
                                    </div>
                                    <form role="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Discount Name:</label>
                                            <input class="form-control" placeholder="Enter Discount Name" id="discount_name" type="text" required 
                                            data-fv-notempty-message="Discount Name is required field" >
                                        </div>
                                        <label>Discount Amount (in percentage %):</label>
                                        <div class="form-group input-group">
                                            <input class="form-control" placeholder="Enter Product Model" id="discount_amount" type="number" required 
                                            data-fv-notempty-message="Discount Amount is required field" >
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <button type="submit" id="discountsubmit" class="btn btn-success">Add New Discount</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                </div>

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

    <!-- Latest compiled and minified Bootstrap Select JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script>
    $(document).ready(function() {
    $("#taxsubmit").click(function(){
        var TaxName = $('#tax_name').val();  
        var TaxAmount = $('#tax_amount').val();
            $.ajax({
                url: 'settax.php',
                data: {TaxName, TaxAmount},
                type: 'POST',
                dataType:'HTML',
                success: function(data) {
                     alert(data);
                }
            });
    });
    });
    
    $(document).ready(function() {
    $("#discountsubmit").click(function(){
        var DiscountName = $('#discount_name').val();  
        var DiscountAmount = $('#discount_amount').val();
            $.ajax({
                url: 'setdiscount.php',
                data: {DiscountName, DiscountAmount},
                type: 'POST',
                dataType:'HTML',
                success: function(data) {
                     alert(data);
                }
            });
    });
    });
    </script>

</body>

</html>