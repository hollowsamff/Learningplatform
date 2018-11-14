<?php
//Include used to save and display the websites quizzess -  sents data from to the  blogquiz.php page
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
ob_start();
session_start();
include"db.php";
include "functions.php";

?>

<?php
global $connection;

if(isset($_POST["playerScore"])  && $_POST["playerScore"] != null  ){//Run when the user quiz data is send from the quizInclude.php page

if(is_logged_in()){
	
		$score = escape($_POST["playerScore"]);	
		$quizId = escape($_POST["quizId"]);	
		$maxScore = escape($_POST["maxScore"]);	
		
		if(isset($_SESSION['user_id'])){	 
		 $userId = $_SESSION['user_id'];
		}else{
			return;
		}	
		if($score == "" || empty($score)){//Test if the value is blank	  	
			$score = 0;
		}			
		$stmt= mysqli_prepare($connection,"INSERT INTO user_quiz_score(user_id, quiz_id, user_score, max_score) VALUE(?,?,?,?)");
		mysqli_stmt_bind_param($stmt,'dddd', $userId, $quizId, $score, $maxScore);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);//Close statment connection

		$stmt = mysqli_prepare($connection,"UPDATE users SET score  =  score + 1  WHERE user_id = ?");
		mysqli_stmt_bind_param($stmt,'i' , $_SESSION["user_id"]);
		mysqli_stmt_execute($stmt);
	    mysqli_stmt_close($stmt);//Close statmentute($stmt);
 
		//redirect("quiz.php");				
	 }
 }
 
if(isset($_POST["playerScore"]) && $_POST["playerScore"] != null && isset($_POST["classroomStudent"]) ){//Run when the user quiz data is send from the weeklytests.php page

if(is_logged_in()){
	
		$score = escape($_POST["playerScore"]);	
		$quizId = escape($_POST["quizId"]);	
		$maxScore = escape($_POST["maxScore"]);	
		
		if(isset($_SESSION['user_id'])){	 
		 $userId = $_SESSION['user_id'];
		}else{
			return;
		}	
		if($score == "" || empty($score)){//Test if the value is blank	  	
			$score = 0;
		}			
		
		
		//if the record exists update it 
		$stmt= mysqli_prepare($connection,"INSERT INTO user_quiz_score(user_id, quiz_id, user_score, max_score) VALUE(?,?,?,?)");
		mysqli_stmt_bind_param($stmt,'dddd', $userId, $quizId, $score, $maxScore);
		mysqli_stmt_execute($stmt);
		if(!$stmt){//Test if the query fails	
		 //die("Query error")."<br>". mysqli_error($stmt);
		}		
		mysqli_stmt_close($stmt);//Close statment connection 
		//redirect("quiz.php");	
		
	$complete = "1";	
	//Used to stop student in the class room group from  completeing the quizzess more than once
	
	    $stmt= mysqli_prepare($connection,"INSERT INTO quiz_finished_classroom_students(user_id, quiz_id, complete) VALUE(?,?,?)");
		mysqli_stmt_bind_param($stmt,'ddd', $userId, $quizId, $complete);
		mysqli_stmt_execute($stmt);		
		mysqli_stmt_close($stmt);	
		//redirect("quiz.php");
	 }
 } 
 
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