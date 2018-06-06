<?php
include('../session.php');

$greskica = "";
$uspjesno = "";

$stmt_pullData = $db->prepare("SELECT * FROM userimage  WHERE user = ?");
$stmt_pullData->bind_param('s', $username);
$stmt_pullData->execute();
$stmt_pullData->bind_result($id, $user, $url, $lastUpload);
$stmt_pullData->store_result();
$stmt_pullData->fetch();
$stmt_pullData->close();

$dozvoljeneExtenzije = array(
                "jpg",
                "jpeg",
                "gif",
                "png",
                "JPG"
);
$izabranaExtenzija   = @end(explode(".", $_FILES["file"]["name"]));

if (isset($_POST['pupload'])) {
                if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2097152) && in_array($izabranaExtenzija, $dozvoljeneExtenzije)) {
                                if ($_FILES["file"]["error"] > 0) {
                                                $greskica = "<div class='alert alert-danger'>Return Code: " . $_FILES["file"]["error"] . " </div>";
                                                
                                } else {
                                                if (file_exists("../upload/" . $_FILES["file"]["name"])) {
                                                                unlink("../upload/" . $_FILES["file"]["name"]);
                                                } else {
                                                                $pic  = $_FILES["file"]["name"];
                                                                $conv = explode(".", $pic);
                                                                $ext  = $conv['1'];
                                                                move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $username . "." . $ext);
                                                                $slika            = $username . "." . $ext;
                                                                $vrijeme          = date("Y-m-d H:i:s");
                                                                $stmt_updatePhoto = $db->prepare("UPDATE userimage SET url = ? , lastUpload = ? WHERE user = ? ");
                                                                $stmt_updatePhoto->bind_param('sss', $slika, $vrijeme, $username);
                                                                if ($stmt_updatePhoto->execute()) {
                                                                                $uspjesno = "<div class='alert alert-success'>Your photo is successully updated<br>Page will refresh in 3 seconds</div>";
                                                                                header("Refresh:3;url=user_profile.php");
                                                                }
                                                                $stmt_updatePhoto->close();
                                                }
                                }
                } else {
                                $greskica = "<div class='alert alert-danger'>File Size Limit Crossed 2MB Use Picture Size less than 2MB</div>";
                }
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
        <title>SCMS - <?php echo $username ?></title>
        
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
                        <h1 class="page-header">User Profile</h1>
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
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><strong><?php echo $firstname." ".$lastname ?></strong></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-3 col-lg-3 " align="center">
                                                        <img alt="User Image" src="../upload/<?php echo $slikica ?>" class="img-responsive"/>
                                                        <form action="" method="post" enctype="multipart/form-data">
                                                            <input style="margin-top: 5px;" type="file" name="file" /><br>
                                                            <input type="submit" name="pupload" class="btn btn-success" value="Add New Photo"/>
                                                        </form>
                                                    </div>
                                                    <div class=" col-md-9 col-lg-9 ">
                                                        <table class="table table-user-information">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Username:</td>
                                                                    <td><?php echo $username ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>First Name</td>
                                                                    <td><?php echo $firstname ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Last Name</td>
                                                                    <td><?php echo $lastname ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>User Role</td>
                                                                    <td><?php echo $userrole ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <?php
                                                    echo $uspjesno;
                                                    echo $greskica;
                                                 ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Password Change</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class=" col-md-12 col-lg-12 ">
                                                        <form role="form" action="" method="post">
                                                            <div class="form-group">
                                                                <label>Old Password:</label>
                                                                <input class="form-control" placeholder="Enter Old Password" id="old_pw" type="Password" required data-fv-notempty-message="You must enter Old Password" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>New Password:</label>
                                                                <input class="form-control" id="new_pw" type="Password" placeholder="Enter New Password" required 
                                                                data-fv-notempty-message="You must enter New Password" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Re-Enter New Password:</label>
                                                                <input class="form-control" id="new_pw_again" type="Password" placeholder="Re-Enter New Password" required data-fv-notempty-message="You must Re-Enter New Password" >
                                                            </div>
                                                            <button id="submitpw" class="btn btn-success">Change Your Password</button>
                                                            <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
            $(document).ready(function() {
                $("#submitpw").click(function(){
                    var OldPW = $('#old_pw').val();
                    var NewPw = $('#new_pw').val();
                    var NewPw2 = $('#new_pw_again').val();

                    if (NewPw == NewPw2) {
                        $.ajax({
                            url: 'setnewpw.php',
                            data: {OldPW, NewPw},
                            type: 'POST',
                            dataType:'HTML',

                            success: function(data) {
                                alert(data);
                            }
                        });
                    }else{
                        alert("Passwords does not match");
                    }
                });
            });
        </script>
    </body>
</html>