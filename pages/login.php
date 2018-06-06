<?php
include("../config.php");
session_start();

//Varijabla error za spremanje greske pilikom logina
$error = "";

//Ako je logovan tj. ako sesija jos uvijek postoji preusmjeri na panel
if (isset($_SESSION['login_user'])) {
    header("location:index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Spremi unesene podatke iz polja    
    $entered_username = mysqli_real_escape_string($db, $_POST['username']);
    $entered_password = mysqli_real_escape_string($db, $_POST['password']);
    
        //Prepared statement da povuce podatke iz baze za uneseni username
        $stmt = $db->prepare("SELECT * FROM users WHERE BINARY username = ?");
        $stmt->bind_param('s', $entered_username);
        $stmt->execute();
        //Spremi podatke
        $stmt->bind_result($user_id, $username, $password, $firstname, $lastname, $role);
        $stmt->store_result();
    
    //Provjeri da li postoji korisnik tj. samo jedan red kao rezultat
    if ($stmt->num_rows == 1) {
        //Fetchuj podatke
        if ($stmt->fetch()) {
            //Provjeri da li se uneseni pw poklapa sa Hashom iz baze tj. provjeri da li je pw tacan
            if (password_verify($entered_password, $password)) {
                //Provjera da li treba Rehash (ukoliko postoji noviji hash algoritam)
                if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
                    //Ako postoji noviji Hash po php password default algoritmu update-uj ga u bazi
                    $newHash      = password_hash($entered_password, PASSWORD_DEFAULT);
                    $stmt_reahash = $db->prepare("INSERT INTO users (password) VALUES (?) WHERE username = ?");
                    $stmt_reahash->bind_param('ss', $newHash, $entered_username);
                    $stmt_reahash->execute();
                    $stmt_reahash->close();
                }
                //Nakon provjere ili eventualnog update-a stvori sesiju i preusmjeri korisnika na panel
                $_SESSION['login_user'] = $entered_username;
                header("location: index.php");
            } else {
                $error = "<div class='alert alert-danger text-center'>Incorrerct Password</div>";
            }
        }
    } else {
        $error = "<div class='alert alert-danger text-center'>User with that username does not exist</div>";
    }
    $stmt->close();
    $db->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sales and Company Management System">
    <meta name="author" content="Venan Osmic">

    <title>SCMS - Login</title>

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

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <center><img src="../dist/img/logo.png" alt="Logo"></img></center>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" />
                            </fieldset>
                        </form>
                    </div>
                </div>
                <?php echo $error;?>
                <div class="alert alert-info text-center">
                    Development: <strong><a href="https://fb.com/Venan24">Venan Osmić</a></strong><br>
                    demo@demo.com / demo123
                </div>
            </div>
        </div>
    </div>

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
