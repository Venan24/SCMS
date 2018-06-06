<?php
   include('config.php');
   session_start();
   
   //Ako nije postavljena sesija prabaci ga na login
   if(!isset($_SESSION['login_user'])){
      header("location: login.php");
   }

   //Postavi sesiju s imenom username korisnika
   $user_check = $_SESSION['login_user'];
   //Prepared statement za podatke od tog usera
   $stmt_session = $db->prepare("SELECT * FROM users WHERE username = ? ");
   $stmt_session->bind_param('s', $user_check);
   $stmt_session->execute();
   //Spremi podatke
   $stmt_session->bind_result($user_id, $username, $password, $firstname, $lastname, $role);
   $stmt_session->store_result();
   $stmt_session->fetch();

   //Slika
   $stmt_image = $db->prepare("SELECT url FROM userimage WHERE BINARY user = ? ");
   $stmt_image->bind_param('s', $user_check);
   $stmt_image->execute();
   $stmt_image->bind_result($slikica);
   $stmt_image->store_result();
   $stmt_image->fetch();

   //Ako nema stavi default
   if (is_null($slikica)){
      $slikica = "default.png";
   }

   //Postavi Role da bude String zbog ispisivanja
   if($role == 1){
      $userrole = "Administrator";
   }else{
      $userrole = "Regular User";
   }
?>