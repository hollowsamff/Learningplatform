<?php
ob_start();
session_start();

include"../../databasephp/db.php";
include "../../databasephp/functions.php";

global $connection;

/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/	
if(isset($_POST["populatePageDropDowns"]) && !empty($_POST["populatePageDropDowns"])){	
   
    $post_name_array = [];
	$post_id_array = [];
	
	$stmt = mysqli_prepare($connection,"SELECT post_id, post_title FROM  posts");	
    mysqli_stmt_execute($stmt);	  
	mysqli_stmt_bind_result($stmt, $post_id, $post_name);
		 
	 while( mysqli_stmt_fetch($stmt) ){
	 
	   array_push($post_id_array, $post_id);
	   array_push($post_name_array, $post_name);
	 }
	 
	  mysqli_stmt_close($stmt); 
	 
	  echo json_encode(array("post_id_array"=>$post_id_array,"post_name_array"=>$post_name_array ));
	  return;
}


	 //Used to add quiz to database
	 if(isset($_POST["quizQuestionString"]) &&  isset($_POST["quizName"]) ){//Uses POST from add category form
		
		$postsids = escape($_POST["quizPostId"]);	
		
		$quizQuestionString = escape($_POST["quizQuestionString"]);	
		$questionsArray = explode("*-*", $quizQuestionString);//The different questions are separated with a *~*	
		//An explode is used to this split the text in to an array and the arrays values are  displayed on the page
		$quizName = escape($_POST["quizName"]);	

		$stmt = mysqli_prepare($connection,"INSERT INTO quiz(quiz_name, posts_id) VALUE(?,?)");//Create the quiz
		mysqli_stmt_bind_param($stmt,'si', $quizName, $postsids);
		mysqli_stmt_execute($stmt);
		
		if(!$stmt){//Test if the query fails	
		  //die("Query error")."<br>". mysqli_error($stmt);
		}	
		
		$lastId = mysqli_insert_id($connection);//Database id of the new quiz
		mysqli_stmt_close($stmt);//Close statment connection
			
		for($i = 0; $i < sizeof($questionsArray) - 1; $i++ ){//Input the quiz questions and answers of the new quiz into quiz_question database
			
            $answerArray = explode("~", $questionsArray[$i]);//questions are seperated with ~
			$stmt = mysqli_prepare($connection,"INSERT INTO quiz_question(quiz_id, quiz_question, answer_one_correct_answer, answer_two, answer_three, answer_four) VALUE(?,?,?,?,?,?)");
			mysqli_stmt_bind_param($stmt,'dsssss', $lastId, $answerArray[0], $answerArray[1], $answerArray[2], $answerArray[3], $answerArray[4]);
			mysqli_stmt_execute($stmt);
			
			if(!$stmt){//Test if the query fails	
			  die("Query error")."<br>". mysqli_error($stmt);
			}	
			
			mysqli_stmt_close($stmt);//Close statment connection	
	    }
	 }

?>