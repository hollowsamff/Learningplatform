<?php
ob_start();
session_start();
include"db.php";
include "functions.php";
//If the function that tests if a user is admin sents back false
if(!is_admin()){
	header("Location: index.php");
}
?>

<?php
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
//Save the user questionnaire results in the the “pre_study_questionnaire_results” database table - get data from preusertest.php page

if(is_logged_in()){
	
	 global $connection;
		 
	 if(isset($_POST["testName"]) && $_POST["testName"] == "preTest"){
								 
		$selectComplements =  escape($_POST["selectComplements"]);	
		$selectHeplful =  escape($_POST["selectHeplful"]);
		$selectOrganised = escape($_POST["selectOrganised"]);
		$selectEasyUse =  escape($_POST["selectEasyUse"]);
		$selectTeachingMethod =  escape($_POST["selectTeachingMethod"]);
		$selectExtraHours = escape($_POST["selectExtraHours"]);
		$preOnlineCourseExperienceFrequency = escape($_POST["preOnlineCourseExperienceFrequency"]);
		$preOnlineCourseExperence = escape($_POST["selectExperence"]);	
		$studentResource =  escape($_POST["studentResource"]);

		$stmt = mysqli_prepare($connection,"INSERT INTO pre_study_questionnaire_results(
		user_id,
		current_online_material_easy_to_use,
		current_online_material_easy_organized,
		current_online_material_easy_helpful,
		current_online_material_complements_teaching,
		preferred_teaching_method,
		hours_studying_week,
		pre_online_course_experience,
		pre_online_course_experience_frequency,
		student_requests_for_website
		) 
		VALUE(?,?,?,?,?,?,?,?,?,?)");
		
		mysqli_stmt_bind_param($stmt,'dsssssddds', 
		$_SESSION["user_id"], 
		$selectEasyUse,
		$selectOrganised,
		$selectHeplful,
		$selectComplements,
		$selectTeachingMethod,
		$selectExtraHours,
		$preOnlineCourseExperence,
		$preOnlineCourseExperienceFrequency,
		$studentResource );
		mysqli_stmt_execute($stmt);
		
		if(!$stmt){//Test if the query fails	
		  //die("Query error")."<br>". mysqli_error($stmt);
		}	
		mysqli_stmt_close($stmt);//Close statment connection
		
		//Used to stop the user conducting the questionnaire more than once
		 $stmt = mysqli_prepare($connection,"UPDATE users SET completed_pre_test = 1  WHERE user_id = ?");
		 mysqli_stmt_bind_param($stmt,'i' , $_SESSION["user_id"]);
		 mysqli_stmt_execute($stmt);
		 mysqli_stmt_close($stmt);//Close statmentute($stmt);
	     $_SESSION['completed_Pre_Study_Questionnaire'] = 1;		
	 }	
	 

  }
?>