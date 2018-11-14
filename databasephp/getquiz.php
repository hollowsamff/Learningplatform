<?php
ob_start();
session_start();
include"../databasephp/db.php";
include "../databasephp/functions.php";
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
global $connection;
//Php include used to show the websites quizzes - the quizzes are called via ajax in the blogquiz.php page

if(isset($_POST["quizId"]) && !empty($_POST["quizId"])){
//Only logged in users can edit code
if(is_logged_in()){ 
	  $quizId = json_decode($_POST["quizId"]);
      $answerOneArray = array();
	  $answerTwoArray = array();
	  $answerThreeArray = array();
	  $answerFourArray = array();
	  $correctAnswerArray = array();
	  $quizQuestionArray = array();
	  $questionArrays = array();//Used to make the quiz answers apear in an random order
	  $quizImageArray = array();
	   
	  //Get the quiz name, questios and answers from the quiz_question and quiz databases
	  $stmt = mysqli_prepare($connection,"SELECT 
	  quiz_question.quiz_question,
	  quiz_question.answer_one_correct_answer,
	  quiz_question.answer_two,
	  quiz_question.answer_three,
	  quiz_question.answer_four,
	  quiz_question.quiz_id,
     `quiz_question`.`quiz_question_image`,
	  quiz.quiz_id,
	  quiz.quiz_name
	  FROM quiz_question	
	  INNER JOIN quiz ON quiz_question.quiz_id = quiz.quiz_id WHERE quiz_question.quiz_id = ? ");
	 
	  mysqli_stmt_bind_param($stmt,'i',$quizId);
	  mysqli_stmt_execute($stmt);
	  $totalQuizQuestions = 0;//Used to store how many questions are in the quiz

	  //Bind these variable to the SQL results
	  $stmt->bind_result(
	  $quizQuestion,
	  $answerOneArrayCorrectAnswer,
	  $answerTwo,
	  $answerThree,
	  $answerFour,
	  $quizQuestionQuizId,
	  $quizImageData,
	  $questionQuizId,
	  $questionQuizName 
	  );		
	  
       $quizQuestionQuizId = escape($quizQuestionQuizId);
	  
	  //Fetch will return all records, so while will loop until reaches the end
	  while($stmt->fetch()){

		 //Bind these variable from SQL to varables
		 $totalQuizQuestions++;
         array_push($correctAnswerArray,escape($answerOneArrayCorrectAnswer));
		 array_push($quizQuestionArray,escape($quizQuestion));
		 
		 if($quizImageData != ""){
		 array_push($quizImageArray, escape($quizImageData)); 
		 }
		 unset($questionArrays);
		 $questionArrays = array();
		 
		 array_push($questionArrays,escape($answerOneArrayCorrectAnswer));
		 array_push($questionArrays,escape($answerTwo));
		 array_push($questionArrays,escape($answerThree));
		 array_push($questionArrays,escape($answerFour));
		 shuffle($questionArrays);//Used to make the quiz answers apear in an random order
		 array_push($answerOneArray,$questionArrays[0]);
		 array_push($answerTwoArray,$questionArrays[1]);
		 array_push($answerThreeArray,$questionArrays[2]);
		 array_push($answerFourArray,$questionArrays[3]);
		 
	}			
		mysqli_stmt_close($stmt);//Close statment   
        mysqli_close($connection);		
  
	echo json_encode(array("quizQuestion"=>$quizQuestionArray, "quizId"=> $quizId, "quizName"=> $questionQuizName, "quizImageArray"=>$quizImageArray, "answerOne" => $answerOneArray, "answerTwo"=>$answerTwoArray,"answerThree"=> $answerThreeArray,"answerFour"=>$answerFourArray,"correctAnswer"=> $correctAnswerArray, "totalQuizQuestions"=>$totalQuizQuestions ));
 }
}


?>
