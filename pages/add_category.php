<?php
include('../session.php');
$greskica="";
$uspjesnoDodan="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$categoryname  = mysqli_real_escape_string($db, $_POST['category_name']);
$categoryactive = mysqli_real_escape_string($db, $_POST['category_active']);

//Provjeri postojil takav username
$stmt_check_category_exist = $db->prepare("SELECT category_name FROM categories_list WHERE category_name = ? ");
$stmt_check_category_exist->bind_param('s', $categoryname);
$stmt_check_category_exist->execute();
$stmt_check_category_exist->bind_result($categoryname2);
$stmt_check_category_exist->store_result();
$stmt_check_category_exist->fetch();
if ($stmt_check_category_exist->num_rows == 1) {
                $greskica = "<div class='alert alert-danger'>Category with entered name already exist</div>";
                $stmt_check_category_exist->close();
} else {
                $stmt_add_category = $db->prepare("INSERT INTO categories_list (category_name, category_active) VALUES (?, ?)");
                $stmt_add_category->bind_param('si', $categoryname, $categoryactive);
                
                if ($stmt_add_category->execute()) {
                                $uspjesnoDodan = "<div class='alert alert-success'>Category added successfully</div>";
                                $stmt_add_category->close();
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

    <title>SCMS - Add Category</title>

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
                    <h1 class="page-header">Add New Category</h1>
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
                                            <label>Category Name:</label>
                                            <input class="form-control" placeholder="Enter Category name" name="category_name" type="text" required 
                                            data-fv-notempty-message="Category Name is required field" >
                                        </div>
                                        <div class="form-group">
                                            <label>Is It Active</label>
                                            <select class="form-control" name="category_active">
                                                <option value="1" >Yes</option>
                                                <option value="0" >No</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Add New Category</button>
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
