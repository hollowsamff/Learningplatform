<?php
//This file contains the php function that get data from the website database-->
ob_start();
session_start();
include"db.php";
include "functions.php";

/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/

//Used to populate the quiz leaderboards in sidebar.php and leaderboard.php 
if(isset($_POST["getQuizHighScores"]) && !empty($_POST["getQuizHighScores"])){	

 if(is_logged_in()){	

	$user_name_array = [];
	$user_id_array = [];
    $user_score_array = [];
	
	$stmt = mysqli_prepare($connection,"
	SELECT user_name, score ,user_id 
	FROM  users 
	ORDER BY score DESC");
	
    mysqli_stmt_execute($stmt);	  
	mysqli_stmt_bind_result($stmt, $user_name, $score, $user_id);
		 
	 while( mysqli_stmt_fetch($stmt) ){
	 
	   array_push($user_name_array,$user_name);
	   array_push($user_score_array,$score);
       array_push($user_id_array,$user_id);
	 }
	 
	  mysqli_stmt_close($stmt);
	  echo json_encode(array("user_name_array"=>$user_name_array,"user_score_array"=>$user_score_array,"user_id_array"=>$user_id_array,"user_id"=>$_SESSION['user_id']));
	  return;
	}	
}


?>




