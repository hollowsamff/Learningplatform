<?php 
include "../databasephp/db.php";
//Page used to logout to the site - uses buttion in CMS section of site
session_start();
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
  //Remove old SESSIONs
  $_SESSION['user_role'] = null;
  $_SESSION['user_name']= null;	
  $_SESSION['user_id']= null;	
  $_SESSION['login_time_id']= null;
  $_SESSION['completed_Pre_Study_Questionnaire'] = null;
  $_SESSION['completed_Post_Study_Questionnaire']= null;
  session_unset(); 
  session_destroy();

  unset($_COOKIE['userTime']);
  setcookie('userTime', '', time() - 3600, '/'); // empty value and old timestamp  
  
  header("Location:../index.php");
?>
          

      