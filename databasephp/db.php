<?php
//File used to create connection to database for authorised users
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
//Store values for connection in an array
    $db_host = "localhost";
    $db_user = "samfrancis";
    $db_pass = "password";
    $db_name  = "webassigment2018";
	
	//$db_host = "10.16.16.15";
   // $db_user = "tomus-5ix-u-192236";
   // $db_pass = "Ntd.Nntgz";
   // $db_name  = "tomus-5ix-u-192236";
	
	
	

//Covert valus from array to constants(all uppercase letters)
//foreach($db as $key => $value){	
	//define(strtoupper($key), $value);//$key is used to uppercase the values
	//$key is equal to $db values: e.g. in $db["db_host"] db_host is the key	
//}

// Create connection
$connection = new mysqli($db_host, $db_user, $db_pass , $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);

}
   $connection->set_charset("utf-8");//Set charset to english
 
?>
