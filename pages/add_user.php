<?php
include('../session.php');
if($role != 1){
    header("location: auth_warning.php");
}

$greskica="";
$uspjesnoDodan="";
$erorcode=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username  = preg_replace('/\s+/', '', mysqli_real_escape_string($db, $_POST['username']));
$password  = mysqli_real_escape_string($db, $_POST['password']);
$password2 = mysqli_real_escape_string($db, $_POST['password2']);
$ime       = preg_replace('/\s+/', '', stripslashes(mysqli_real_escape_string($db, $_POST['ime'])));
$prezime   = preg_replace('/\s+/', '', stripslashes(mysqli_real_escape_string($db, $_POST['prezime'])));
$role      = mysqli_real_escape_string($db, $_POST['role']);

if ($password == $password2) {
                $erorcode=0;
                $pwhash = password_hash($password, PASSWORD_DEFAULT);
} else {
                $erorcode=1;
                $greskica ="<div class='alert alert-danger'>Password are not the same</div>";
}

if ($role > 1 || $role < 0) {
                $erorcode=1;
                $greskica = "<div class='alert alert-danger'>User role error</div>";
}else{
    $erorcode=0;
}

if($erorcode == 0){
//Provjeri postojil takav username
$stmt_provjeriIsti = $db->prepare("SELECT username FROM users WHERE BINARY username = ? ");
$stmt_provjeriIsti->bind_param('s', $username);
$stmt_provjeriIsti->execute();
$stmt_provjeriIsti->bind_result($username2);
$stmt_provjeriIsti->store_result();
$stmt_provjeriIsti->fetch();
if ($stmt_provjeriIsti->num_rows == 1) {
                $greskica = "<div class='alert alert-danger'>Username already exist</div>";
                $stmt_provjeriIsti->close();
} else {
                $stmt_dodajKorisnika = $db->prepare("INSERT INTO users (username, password, firstname, lastname, role) VALUES (?, ?, ?, ?, ?)");
                $stmt_dodajKorisnika->bind_param('ssssi', $username, $pwhash, $ime, $prezime, $role);
                
                if ($stmt_dodajKorisnika->execute()) {
                                $nulica          = "";
                                $stmt_dodajSliku = $db->prepare("INSERT INTO userimage (user, url, lastUpload) VALUES (?, ?, ?)");
                                $stmt_dodajSliku->bind_param('sss', $username, $nulica, $nulica);
                                $stmt_dodajSliku->execute();
                                $stmt_dodajSliku->close();
                                $stmt_dodajKorisnika->close();
                                $uspjesnoDodan = "<div class='alert alert-success'>User added successfully</div>";
                }
                
                
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

    <title>SCMS - Add User</title>

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
                    <h1 class="page-header">Add New User</h1>
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
                                            <label>Username:</label>
                                            <input class="form-control" placeholder="Enter username" name="username" type="email">
                                        </div>
										<div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                                        </div>
										<div class="form-group">
                                            <label>Repeat Password:</label>
                                            <input type="password" class="form-control" name="password2" placeholder="Retype password">
                                        </div>
										<div class="form-group">
                                            <label>First Name:</label>
                                            <input class="form-control" name="ime" placeholder="Enter First Name">
                                        </div>
										<div class="form-group">
                                            <label>Last Name:</label>
                                            <input class="form-control" name="prezime" placeholder="Enter Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label>User Role</label>
                                            <select class="form-control" name="role">
                                                <option value="0" >User</option>
                                                <option value="1" >Administrator</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Add New User</button>
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
