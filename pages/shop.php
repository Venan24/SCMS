<?php
include('../session.php');  
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sales and Company Management System">
    <meta name="author" content="Venan Osmic">

    <title>SCMS - Shop</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- featherlight for image fadeing -->
    <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.css" type="text/css" rel="stylesheet" />

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
                    <h1 class="page-header">WebShop</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <?php 
                    $userData = $db->query("SELECT product_id, product_name, product_model, product_photo FROM products_list");
                        while ($row = mysqli_fetch_array($userData, MYSQLI_ASSOC)) {
                            echo '
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading text-center">
                                            <strong>'.$row['product_name'].' - '.$row['product_model'].'</strong>
                                        </div>
                                        <div class="panel-body text-center">
                                            <img src="../articles/'.$row['product_photo'].'" style="height:150px;" ></img>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-xs-5"><h4><strong>1282,50 KM</strong></h4></div>
                                            <div class="col-xs-7"><span class="align-middle"><button type="button" class="btn btn-outline btn-danger btn-block">View Article</button></span></div>
                                        </div>
                                    </div>
                                </div>';
                        }
                ?>
                                                   
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
    
    <!-- featherlight for image fadeing -->
    <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>
