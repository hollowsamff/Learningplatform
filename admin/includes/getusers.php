<?php
//Include used to show the results of website users from websites quizzes - data is displayed in the user_data.php page
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
		
//Used to populate the stacked collum chart of website quesionaire
//Sends data to the stackedChartQuestionnaireResponse() function on the view_all_users.php page
if(isset($_POST["displayType"]) && !empty($_POST["displayType"])){	

 if(is_logged_in()){	

	$easy_to_use_array = ["Easy to use"];
    $organized_rating_array = ["Organized"];
	$helpful_rating_array = ["Helpful"];
	$complements_teaching_rating_array = ["Supports lessons"];
	
	$stmt3 = mysqli_prepare($connection,"SELECT 
	current_online_material_easy_to_use,
	current_online_material_easy_organized,
	current_online_material_easy_helpful,
	current_online_material_complements_teaching
	FROM pre_study_questionnaire_results");		
	
    mysqli_stmt_execute($stmt3);	  
	mysqli_stmt_bind_result($stmt3, $easy_to_use_rating, $organized_rating, $helpful_rating, $complements_teaching_rating);
		 
	 while( mysqli_stmt_fetch($stmt3) ){
	 
	   array_push($easy_to_use_array,$easy_to_use_rating);
	   array_push($organized_rating_array,$organized_rating);
	   array_push($helpful_rating_array,$helpful_rating);
	   array_push($complements_teaching_rating_array,$complements_teaching_rating);
	 }
	 
	  mysqli_stmt_close($stmt3);
	  echo json_encode(array("easy_to_use_array"=>$easy_to_use_array,"organized_rating_array"=>$organized_rating_array,"helpful_rating_array"=>$helpful_rating_array, "complements_teaching_rating_array"=>$complements_teaching_rating_array));
	  return;
	}	
}

//Get the amount of time a user has logged on to the website
//Used to populate the table that shows how long users have logged into the website
//Sends data to the ajaxRequestGetOnlineTime() function on the view_all_users.php page
if(isset($_POST["userId"]) && !empty($_POST["userId"])){
	
 if(is_logged_in()){	

	$quizId = json_decode($_POST["userId"]);
	$user_start_time_array = array();
	$user_end_time_array = array();

	$stmt2 = mysqli_prepare($connection,"SELECT start_time, end_time FROM users_online_time WHERE user_id = ? ORDER BY `users_online_time`.`start_time` ASC  ");	
	 mysqli_stmt_bind_param($stmt2,'i',$quizId);	  
	 mysqli_stmt_execute($stmt2);
		  
	 mysqli_stmt_bind_result($stmt2, $user_start_time, $user_end_time);
		 
	 while (mysqli_stmt_fetch($stmt2)){
	 
	   array_push($user_start_time_array,$user_start_time);
	   array_push($user_end_time_array,$user_end_time);
	 }		
	  mysqli_stmt_close($stmt2);
	  
	echo json_encode(array("start_time"=>$user_start_time_array,"end_time"=>$user_end_time_array));
	return;
	}
}



//Get all the users quiz result data for database  - used in ajaxRequestGetUserQuizData() on the view_all_users.php page
if(isset($_POST["quizId"]) && !empty($_POST["quizId"])){
if(is_logged_in()){
	 
	   $quizId = json_decode($_POST["quizId"]);
	   $correctAnswerArray = array();
	   
	   $average_score_array = array();   
	   $total_score_array = array();
	   $max_final_score = 0;
	   $max_user_score = 0;
	   
	   $final_quiz_name = "";  
	   $quiz_name = "";
	   
	   $dates_array = array();   
	   $quiz_id_array = array();
	   $user_score_array = array();
	   $user_max_score_array = array();

      $stmt = mysqli_prepare($connection,"
		 SELECT 
		 user_quiz_score.user_quiz_id,
		 user_quiz_score.quiz_id,
		 user_quiz_score.user_id,
		 user_quiz_score.date,
		 user_quiz_score.user_score,
		 user_quiz_score.max_score,

		 quiz.quiz_id,quiz.quiz_name,
		 users.user_name
		 
		 FROM  user_quiz_score	
		 
		 INNER JOIN quiz ON user_quiz_score.quiz_id = quiz.quiz_id
		 INNER JOIN users ON user_quiz_score.user_id = users.user_id		 
		 WHERE  users.user_id = ?
		 ORDER BY  quiz.quiz_id ASC, `user_quiz_score`.`date` ASC
	    ");
		
	  mysqli_stmt_bind_param($stmt,'i',$quizId);	  
	  mysqli_stmt_execute($stmt);
	 
	   /* bind result variables */
       mysqli_stmt_bind_result($stmt, $user_quiz_id, $quiz_id, $user_id, $date, $user_score, $max_score  ,$quiz_id, $quiz_name, $user_name);
 	 
        while (mysqli_stmt_fetch($stmt)) {

			 if($final_quiz_name == "" ){//Used to test what quiz is currently runing in the loop
				 
			    $final_quiz_name = $quiz_name;// When the first quiz apears set the name to it
			 }
			 
			 $max_final_score += $max_score;
			 $max_user_score += $user_score;
			
			 if($final_quiz_name != $quiz_name ){//Calulate the average score for all the website quizzes - when the current quiz name is differnt from the last quiz name it means a new quiz is being shown
         
                  $max_final_score -= $max_score;
			      $max_user_score -= $user_score;
			 
				  $totalQuizAverage =  round(($max_user_score / $max_final_score) * 100);
				  array_push($total_score_array,"<tr><td>$final_quiz_name score</td><td>$totalQuizAverage%</td></tr> ");

				  $max_final_score = $max_score;
			      $max_user_score = $user_score;
				  $final_quiz_name = $quiz_name;	  
			 }			
			$indivigualQuizAverage = $user_score / $max_score * 100;//Average score of all the users quizzes
			$indivigualQuizAverage = round($indivigualQuizAverage);
			array_push($average_score_array,"$indivigualQuizAverage");
			array_push($correctAnswerArray,"<tr><td>$quiz_name</td><td>$date</td><td> $user_score/$max_score</td><td>$indivigualQuizAverage%</td></tr>");
			
			/////////////////////
            array_push($user_max_score_array,"$max_score");
			array_push($user_score_array,"$user_score");
			array_push($dates_array,"$date");	           
			array_push($quiz_id_array,"$quiz_id");
			
			}
			
           /* close statement */
           mysqli_stmt_close($stmt);
	
	 $totalQuizAverage =  round(($max_user_score / $max_final_score) * 100);	
     array_push($total_score_array,"<tr><td>$final_quiz_name score</td><td>$totalQuizAverage%</td></tr> ");

	 $records = array();
     $records[] = array( 'quizid'=> $quiz_id_array ,'date'=>$dates_array, "user_score" =>$user_score_array,"user_max_score" =>$user_max_score_array);
	 	
	echo json_encode(array("all_user_quiz_data"=>$correctAnswerArray,"total_score_array" =>$total_score_array, "records"=>$records));
  }
}


//Get all the users quiz result data for database  - used in ajaxRequestGetUserQuizData() on the view_all_users.php page
if(isset($_POST["getAllData"]) && !empty($_POST["getAllData"])){
if(is_logged_in()){
	
$size = 0;
$p = 0;
$myarray = array();

while($p < $size) {
  
  $myarray[]["number"] = array("number" => "test", "data" => "kkk[1]", "status" => "A"); 
  $p++;
}
	        $userIdArray = array();
            $stmt2 = mysqli_prepare($connection,"
			 SELECT 
			 DISTINCT user_id
			 FROM  user_quiz_score	
			 ORDER BY user_id ASC 
			");
		    mysqli_stmt_execute($stmt2);
		    mysqli_stmt_bind_result($stmt2, $user_name);
			while (mysqli_stmt_fetch($stmt2)) {
				
				array_push($userIdArray,$user_name);
			}	
	        mysqli_stmt_close($stmt2); 
	
	   $quizId = json_decode($_POST["getAllData"]);
	   $total_score_array = array();

    for($i = 0; $i < sizeof($userIdArray); $i++){
	   
		   $max_user_score = 0;  
		   $max_final_score = 0;
		   $average_score_array = array();   
		   $dates_array = array();   
		   $quiz_id_array = array();
		   $user_score_array = array();
		   $user_max_score_array = array();
		   $final_quiz_name = "";  
		   $quiz_name = "";
		   
		  $stmt = mysqli_prepare($connection,"
			 SELECT 
			 user_quiz_score.user_quiz_id,
			 user_quiz_score.quiz_id,
			 user_quiz_score.user_id,
			 user_quiz_score.date,
			 user_quiz_score.user_score,
			 user_quiz_score.max_score,

			 quiz.quiz_id,quiz.quiz_name,
			 users.user_name,
			 users.user_role
			 
			 FROM  user_quiz_score	
			 
			 INNER JOIN quiz ON user_quiz_score.quiz_id = quiz.quiz_id
			 INNER JOIN users ON user_quiz_score.user_id = users.user_id		 
			 WHERE  users.user_id = ?
			 ORDER BY quiz.quiz_id ASC,`users`.`user_role` ASC, `user_quiz_score`.`date` ASC
			");
			
		  mysqli_stmt_bind_param($stmt,'i',$userIdArray[$i]);	  
		  mysqli_stmt_execute($stmt);
		 
		   /* bind result variables */
		   mysqli_stmt_bind_result($stmt, $user_quiz_id, $quiz_id, $user_id, $date, $user_score, $max_score  ,$quiz_id, $quiz_name, $user_name,$user_role);
		 
			while (mysqli_stmt_fetch($stmt)) {

				 if($final_quiz_name == "" ){//Used to test what quiz is currently runing in the loop
					 
					$final_quiz_name = $quiz_name;// When the first quiz apears set the name to it
				 }
				 
				 $max_final_score += $max_score;
				 $max_user_score += $user_score;
				
				 if($final_quiz_name != $quiz_name ){//Calulate the average score for all the website quizzes - when the current quiz name is differnt from the last quiz name it means a new quiz is being shown
			 
					  $max_final_score -= $max_score;
					  $max_user_score -= $user_score;
				 
					  $totalQuizAverage = round(($max_user_score / $max_final_score) * 100);
					  array_push($total_score_array,"$user_id - $final_quiz_name score - $totalQuizAverage%");
					  
					  $myarray[] = array("number" => $user_id, "data" => $final_quiz_name, "status" => $totalQuizAverage, "userName"=>$user_name,"userRole"=>$user_role);

					  $max_final_score = $max_score;
					  $max_user_score = $user_score;
					  $final_quiz_name = $quiz_name;	  
				 }			
				$indivigualQuizAverage = $user_score / $max_score * 100;//Average score of all the users quizzes
				$indivigualQuizAverage = round($indivigualQuizAverage);
				array_push($average_score_array,"$indivigualQuizAverage");
			
				/////////////////////
				array_push($user_max_score_array,"$max_score");
				array_push($user_score_array,"$user_score");
				array_push($dates_array,"$date");	           
				array_push($quiz_id_array,"$quiz_id");
				
				}	
		 $totalQuizAverage = round(($max_user_score / $max_final_score) * 100);	
		 
		 array_push($total_score_array,"$user_id - $final_quiz_name score - $totalQuizAverage% ");

		 $myarray[] = array("number" => $user_id, "data" => $final_quiz_name, "status" => $totalQuizAverage, "userName"=>$user_name,"userRole"=>$user_role);
		  
		 $max_final_score = $max_score;
		 $max_user_score = $user_score;
		 $final_quiz_name = $quiz_name;	  
		 
		 /* close statement */
		 mysqli_stmt_close($stmt); 
    }

	
	 echo json_encode(array( "parent"=> $myarray, "total_score_array" =>$total_score_array ));
  } 
}

mysqli_close($connection);
?>
