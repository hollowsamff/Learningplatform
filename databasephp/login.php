<?php  session_start();
include "../databasephp/db.php";
include "../databasephp/functions.php";
//Page used to login to the site - data is sent from the sidebar.php include 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
 if(isset($_POST['login'])) {	 

  login_user($_POST['username'], $_POST['password'] );//Load function to login user

 }
 
?>

