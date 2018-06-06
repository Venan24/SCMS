<?php
include('../session.php');

if($role != 1){
    header("location: auth_warning.php");
}

$greskica = "";
$uspjesno = "";

$stmt_get_company_info = $db->prepare("SELECT * FROM company_info");
if ($stmt_get_company_info->execute()) {
    $stmt_get_company_info->bind_result($company_logo, $company_name, $company_address, $company_email, $company_phone);
    $stmt_get_company_info->store_result();
    $stmt_get_company_info->fetch();
    $stmt_get_company_info->close();
}

$dozvoljeneExtenzije = array(
    "jpg",
    "jpeg",
    "gif",
    "png",
    "JPG"
);
$izabranaExtenzija   = @end(explode(".", $_FILES["file"]["name"]));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name    = mysqli_real_escape_string($db, $_POST['compname']);
    $company_address = mysqli_real_escape_string($db, $_POST['compaddress']);
    $company_email   = mysqli_real_escape_string($db, $_POST['compemail']);
    $company_phone   = mysqli_real_escape_string($db, $_POST['compphone']);
    
    if ($_FILES["file"]["size"] > 0) {
        
        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2097152) && in_array($izabranaExtenzija, $dozvoljeneExtenzije)) {
            if ($_FILES["file"]["error"] > 0) {
                $greskica = "<div class='alert alert-danger'>Return Code: " . $_FILES["file"]["error"] . " </div>";
            } else {
                if (file_exists("../dist/img/" . $_FILES["file"]["name"])) {
                    unlink("../dist/img/" . $_FILES["file"]["name"]);
                } else {
                    $pic  = $_FILES["file"]["name"];
                    $conv = explode(".", $pic);
                    $ext  = $conv['1'];
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../dist/img/" . $company_name . "." . $ext);
                    $slika                = $company_name . "." . $ext;
                    $stmt_all_company_data = $db->prepare("UPDATE company_info SET company_logo = ? , company_name = ? , company_address = ? , company_email = ?, company_phone = ? ");
                    $stmt_all_company_data->bind_param('sssss', $slika, $company_name, $company_address, $company_email, $company_phone);
                    if ($stmt_all_company_data->execute()) {
                        $uspjesno = "<div class='alert alert-success'>Data successully updated. Auto-Refresh in 2 seconds.</div>";
                        $stmt_all_company_data->close();
                        header('Refresh: 2; url=edit_company.php');
                    }
                }
            }
        } else {
            $greskica = "<div class='alert alert-danger'>File Size Limit Crossed 2MB Use Picture Size less than 1MB</div>";
        }
    } else {
        $update_company_data_nophoto = $db->prepare("UPDATE company_info SET company_name = ? , company_address = ? , company_email = ?, company_phone = ?");
        $update_company_data_nophoto->bind_param('ssss', $company_name, $company_address, $company_email, $company_phone);
        if ($update_company_data_nophoto->execute()) {
            $uspjesno = "<div class='alert alert-success'>Data successully updated. Auto-Refresh in 2 seconds.</div>";
            $update_company_data_nophoto->close();
            header('Refresh: 2; url=edit_company.php');
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

    <title>SCMS - Edit Company Info</title>

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
                    <h1 class="page-header">Edit Company Info</h1>
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
                                            <label>Company Logo:</label>
                                            <img src="../dist/img/<?php echo $company_logo ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>New Logo:</label>
                                            <input type="file" name="file" />
                                        </div>
                                        <div class="form-group">
                                            <label>Company Name:</label>
                                            <input type="text" class="form-control" name="compname" value="<?php echo $company_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Address:</label>
                                            <input type="text" class="form-control" name="compaddress" value="<?php echo $company_address ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="compemail" value="<?php echo $company_email ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone:</label>
                                            <input type="text" class="form-control" name="compphone" value="<?php echo $company_phone ?>">
                                        </div>
                                        <button type="submit" class="btn btn-success">Update Company Info</button>
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