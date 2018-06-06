<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'baza');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   $db->set_charset("utf8");

	//Provjeri bazu
	if (!$db) {
    	printf("Db error: %s\n", mysqli_connect_error());
    	die();
	}
?>