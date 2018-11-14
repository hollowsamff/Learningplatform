<?php
//File used to create connection to database for unauthorised users

//Store values for connection in an array
    $db_host = "localhost";
    $db_user = "";
    $db_pass = "";
    $db_name  = "webassigment2018";
	//$db_host = "10.16.16.15";
   // $db_user = "tomus-5ix-u-192236";
   // $db_pass = "Ntd.Nntgz";
   // $db_name  = "tomus-5ix-u-192236";
	

// Create connection
$connection = new mysqli($db_host, $db_user, $db_pass , $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);

}
   $connection->set_charset("utf-8");//Set charset to english
   
  
   
?>