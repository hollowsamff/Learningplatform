<?php
//This file contains the php function that get data from the website database
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

//Used to add user to users database table - used on registrtion.php page
if(isset($_POST["submitUserTODatabase"]) && !empty($_POST["submitUserTODatabase"])){	
 
 		 $email = escape($_POST["email"]);
		 $userName = escape($_POST["userName"]);
         $password = escape($_POST["password"]);
         $firstName = escape($_POST["firstName"]);
		 $lastName = escape($_POST["lastName"]);
		 $userDOB = escape($_POST["DOB"]);
		 $userDOB = date('Y-m-d',strtotime(escape($userDOB)));//Convert date to database format
		 
		 
		 if($userName == "" ){
	       echo json_encode(array("message" => "Username cannot be empty"));
           return;		   

	    }		 
	
	   if($password == ""){
	
	      echo json_encode(array("message" => "Password cannot be empty"));
	      echo "Email cannot be empty";;
	      return;

	    }		
		
		if($email == ""){
	
	     echo json_encode(array("message" => "Email cannot be empty"));
	     echo "Email cannot be empty";
		 return;

	    }	
				
		  //Associative arrays replace the index with a lable - this is called a key
		$error = ["username" => "", "email" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
			
        //Data validation to stop user inputing duplicate username or email 

	   if (user_name_exists($userName)){
		
		 $error['username'] = 'Username already exists, please pick another one.';
		 echo json_encode(array("Error message" => "Username already exists, please pick another one"));
		 return;

	  }else{
		  $error['username'] = '';
	  }	 

	  if (user_email_exists($email)){
			
	 	 $error['email'] = 'Email already exists, please pick another one.';
		 echo json_encode(array("Error message" => "Email already exists, please pick another one"));
		 return;	
				
	  }else{
		   
	    $error['email'] = '';   
	   }
	
		if($error['email'] == "" && $error['username'] == ""){
			
			regester_user($userName,$email,$password,$firstName, $lastName,$userDOB) ;// Load function to regester user 		
		    echo json_encode(array("message" => "User added to database"));

	    }
			  
		return;
	 		
}



?>




