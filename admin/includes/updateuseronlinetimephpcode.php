<?php
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/				

//This file contains the php function that get data from the website database-->
ob_start();
session_start();
include"../../databasephp/db.php";
include "../../databasephp/functions.php";

//Used to update the time the user has been logged onto the website - function is used in the header.php page
if(isset($_POST["updateUserOnlineTime"])){
	global $connection;

   date_default_timezone_set('Europe/London');	
   $date = new DateTime();
   $result = $date->format('Y-m-d H:i:s');
   if(isset($_SESSION['user_id']))
   {
   $stmt10 = mysqli_prepare($connection,"UPDATE users_online_time SET end_time = ?  WHERE users_online_time_id = ?  && user_id = ? ");	
   mysqli_stmt_bind_param($stmt10,'sdd', $result, $_SESSION['login_time_id'], $_SESSION['user_id']);
   mysqli_stmt_execute($stmt10);	
   mysqli_stmt_close($stmt10);//Close statment	
   }
}






?>




