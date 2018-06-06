<?php
include('../session.php');

if (isset($_GET['category_id'])){
    $selected_category_id = $_GET['category_id'];
}else{
    $selected_category_id = NULL;
}

if (!is_null($selected_category_id)){

$greskica = "";
$uspjesno = "";

$stmt_get_category_info = $db->prepare("SELECT * FROM categories_list WHERE category_id = ?");
$stmt_get_category_info->bind_param('i', $selected_category_id);
if ($stmt_get_category_info->execute()) {
    $stmt_get_category_info->bind_result($category_id, $category_name, $category_active);
    $stmt_get_category_info->store_result();
    $stmt_get_category_info->fetch();
    $stmt_get_category_info->close();
    
    if (is_null($category_name) || $category_name == ""){
        header("Location: hax.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = mysqli_real_escape_string($db, $_POST['category_name']);
    $category_active = mysqli_real_escape_string($db, $_POST['category_active']);
    
    $update_category_data = $db->prepare("UPDATE categories_list SET category_name = ? , category_active = ? WHERE category_id = ?");
    $update_category_data->bind_param('sii', $category_name, $category_active, $selected_category_id);
    if ($update_category_data->execute()) {
        $uspjesno = "<div class='alert alert-success'>Data successully updated. Auto-Refresh in 2 seconds.</div>";
        $update_category_data->close();
        header('Refresh: 2; url="edit_category.php?category_id='.$selected_category_id.'"');
    }else{
        $update_category_data->close();
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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SCMS - Edit Category</title>

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
                    <h1 class="page-header">Edit Category - <?php echo $category_name?></h1>
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
                                            <label>Category Name:</label>
                                            <input type="text" class="form-control" name="category_name" value="<?php echo $category_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Is It Active</label>
                                            <select id="CatActiveSelect" class="form-control" name="category_active">
                                                <option value="1" >Yes</option>
                                                <option value="0" >No</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Update Category Info</button>
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
    $(document).ready(function () {
    $(function() {
    	var temp = "<?php echo $category_active ?>"; 
        $("#CatActiveSelect").val(temp);
    });
    });
    </script>

</body>

</html>