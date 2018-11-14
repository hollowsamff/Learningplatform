<?php
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/

//Function used to stop SQL attacks - remove bad thing from strings sent to function
function escape($string){
	global $connection;

	$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8'); //Stop user inputing other languages	
	$string   = stripslashes($string);
	return mysqli_real_escape_string($connection, trim(strip_tags($string)));	
}
//Function used to stop SQL attacks - used for content whcih needs tags e.g text that contains multiple lines
function escape2($string){
global $connection;

	$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8'); //Stop user inputing other languages	
	return mysqli_real_escape_string($connection, trim(($string)));
	
}

//Used to redirect the user to differnt pages
function redirect($location){
	global $connection;

	return header("Location:" . $location);
}



function is_admin(){
	
global $connection;

if(isset($_SESSION['user_role']) && !empty($_SESSION['user_role']) &&  $_SESSION['user_role'] == 'admin' ){ 

		return true;

	   }else{
			
	    return false;
	  }			
}


function is_logged_in(){
	
global $connection;

if(isset($_SESSION['user_role']) && !empty($_SESSION['user_role']) &&  $_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'notadmin' || $_SESSION['user_role'] == 'classgroupstudent'){  	

		return true;

	   }else{
			
	    return false;
	  }			
}



function login_user($username,$password){
	
	global $connection;	

	$username = escape($_POST['username'] );	
    $password = escape( $_POST['password']);
	
	//When the user inputs nothing in to the boxes reload index page
	if (empty($password) || empty($username)){ 
	   redirect("../index.php");
	}
		  
	$stmt = mysqli_prepare($connection,"SELECT user_last_name, user_first_name, user_id, user_name, user_password, user_role, completed_pre_test FROM users where user_name = (?)");
    mysqli_stmt_bind_param($stmt,'s' , $username);
	if( !$stmt ) exit('Error'. htmlspecialchars($db->error));

	mysqli_stmt_execute($stmt);
	
	//Bind these variable to the SQL results
	$stmt->bind_result($db_last_name , $db_user_first_name, $db_user_id, $db_user_name, $db_password, $db_user_role, $db_completed_pre_test);
		
	//Fetch will return all fow, so while will loop until reaches the end
	while($stmt->fetch()){
		
		//Use password_verify to decrypt blowfish password - uses original password and database password
		if (password_verify($password, $db_password)){
			       
				date_default_timezone_set('Europe/London');
				$date = new DateTime();
                $result = $date->format('Y-m-d H:i:s');
				
				$_SESSION['user_first_name'] = $db_user_first_name ;
				$_SESSION['user_last_name'] = $db_last_name ;
				$_SESSION['user_role'] = $db_user_role ;
				
				$_SESSION['user_name'] = $db_user_name;	
				$_SESSION['user_id'] = $db_user_id;	
				$_SESSION['completed_Pre_Study_Questionnaire'] = $db_completed_pre_test;	//Used to tests if the user has conducted pre-study questionnaire
				
				mysqli_stmt_close($stmt);//Close statment connection 
				
				$stmt = mysqli_prepare($connection,"INSERT INTO users_online_time (user_id, start_time,end_time) VALUES(?, ?,?)");	
				mysqli_stmt_bind_param($stmt,'dss', $_SESSION['user_id'], $result,$result);
		    	mysqli_stmt_execute($stmt);    
				
				$_SESSION['login_time_id'] = mysqli_insert_id($connection);
				mysqli_stmt_close($stmt);//Close statment
				
				//Used to set the time a user logged out to the time they logged in if they closed the web browser	
                setcookie("userTime", $result, time() + (86400 * 30 * 10), "/");// 86400 = 1 day
				setcookie("logintTimeId", $_SESSION['login_time_id'], time() + (86400 * 30 * 10), "/");// 86400 = 1 day
							
				redirect("../index.php");
				return;
				
			}else{//When password is wrong for found account reload index page
			
			mysqli_stmt_close($stmt);//Close statment connection 
			  redirect("../index.php");
			
			}
			
	      }//End of code when the stmt does not run
		  
		  redirect("../index.php");//When the username is not found  reload index page
      //}

}//End function		

//Function used to create a website account	
function regester_user($username,$email,$password, $firstName, $lastName,$userDOB){
		
	   global $connection;
	
       $username =  escape($username);
	   $email =  escape($email);
	   $firstName =  escape($firstName);
	   $lastName =  escape($lastName);
       $password =  escape($password);
       $role = "notadmin";
	   $userDOB = date('Y-m-d',strtotime(escape($userDOB)));//Convert date to English fromat
 
	   //Use blowfish to hash the password - first value is password variable , second is encryption type and third is number of time hash will be run
	   $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
	
	   $stmt = mysqli_prepare($connection, "INSERT INTO users(user_name, user_password, user_email, user_role,user_first_name,user_last_name,user_DOB) VALUES (?, ? , ? ,?,?,?,?)" );
	   
	   mysqli_stmt_bind_param($stmt,'sssssss',$username,  $password, $email  ,$role, $firstName, $lastName,$userDOB);

	   mysqli_stmt_execute($stmt);
	   
	   if(!$stmt){die("Query error"); }
      
	   mysqli_stmt_close($stmt);//Close statment connection 
    
	   return ;
 }



//Used to set error messages
function set_message($msg){
	
	if ( !empty($msg) ){
		
	$_SESSION['message'] = $msg;

	}else{
		
		$msg = "";

	}
	
}
//Used to show error messages
function dispay_message($type){
				
      if ( isset($_SESSION['message']) ) {
	
		echo "<p class='{$type}'>".$_SESSION['message']."</p>";
		unset($_SESSION['message']);
	}
}


//Function is used to test if other functions work
function confirm_query($result){
	
   global $connection;
	 
   if (!$result){//Validation to test if data is input into database 
		
		die('Query failed');
		
   }
}






//Stops users creating accounts with the same username
function user_name_exists($username){
	global $connection;

	$stmt4 = mysqli_prepare($connection,"SELECT user_id FROM users WHERE user_name = ? ");
	
    mysqli_stmt_bind_param($stmt4,'s', $username);
	
	mysqli_stmt_execute($stmt4);
	
    mysqli_stmt_store_result($stmt4);//Store result 
	
	$find_name_result = mysqli_stmt_num_rows($stmt4);
	
	if ($find_name_result > 0){
		
		return true;
		
	}else{
		
		return false;
		
	}
	 mysqli_stmt_close($stmt4);//Close statment connection 	
}


//Stops users creating accounts with the same email
function user_email_exists($user_email){
	
	global $connection;		
	$stmt3 = mysqli_prepare($connection,"SELECT user_id FROM users WHERE user_email = ? ");
	
	mysqli_stmt_bind_param($stmt3,'s', $user_email);
	mysqli_stmt_execute($stmt3);
    mysqli_stmt_store_result($stmt3);//Store result 
	
	$find_email = mysqli_stmt_num_rows($stmt3);

	
	if ($find_email > 0){
		
		return true;
		
	}else{
		
		return false;
		
	}
	 mysqli_stmt_close($stmt3);//Close statment connection 	
}

//Function is used to add a categories to the database - function is used on the categories.php page
function insert_categories(){

	 global $connection;

	 //Used to add category to database
	 if(isset($_POST["submit"])){//Uses POST from add category form
		
		  $cat_title = escape($_POST['cat_title']);	

			if($cat_title == "" || empty($cat_title)){//Test if the value is blank
			  
			  echo"<h4 class='warning_red'>Add Category shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
		//Use function to test if the category exists
		if (categories_exists($cat_title) !== false)//check if the return value is EXACTLY false, so the type is required to be boolean.
		{
			echo"<h4 class='warning_red'>Catagory already exists!</h4>";

		}else{
				$stmt= mysqli_prepare($connection,"INSERT INTO post_categories(cat_title) VALUE(?) ");
				mysqli_stmt_bind_param($stmt,'s' , $cat_title);
				mysqli_stmt_execute($stmt);
				
				if(!$stmt){//Test if the query fails
					
						//die("Query error")."<br>". mysqli_error($stmt);
				  }	
				
				mysqli_stmt_close($stmt);//Close statment connection 
			    redirect("categories.php");
			
				}
				
			}
	  } 
		
 }
	   

//Stops stop user inputing duplicate categories on the categories.php page
function categories_exists($cat_title){
	
	global $connection;		
	$stmt3 = mysqli_prepare($connection,"SELECT cat_id FROM post_categories WHERE cat_title= ? ");
	
	mysqli_stmt_bind_param($stmt3,'s', $cat_title);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result($stmt3);//Store result 
	
	$find_categories = mysqli_stmt_num_rows($stmt3);

	if ($find_categories > 0){
		

		return true;
		
		
	}else{

		return false;
	
		
	}
	
}   
	   
	   

	
//Index.php admin functions

//Select all values from  database tables uses vales from the check_status query
function record_count($table){	

	global $connection;	
	
    $stmt = mysqli_prepare($connection,"SELECT * FROM " . $table);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);//Store result 
    $result = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);//Close statment
	return $result;

}

//function used to find values to show in google charts on the admin index.php page - shows chart number 
function check_status($table, $colum, $status){
	
	global $connection;		
		
	$stmt = mysqli_prepare($connection,"SELECT * FROM $table WHERE $colum  = ? ");
	mysqli_stmt_bind_param($stmt,'s', $status);
	
	mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);//Store result 
	
	$find_status = mysqli_stmt_num_rows($stmt);

	if ($find_status < 1){//When no results are found return zero to the barchart
		
		mysqli_stmt_close($stmt);//Close statment
		
		$find_status = 0;
        return $find_status;
		
	}else{
		
		mysqli_stmt_close($stmt);//Close statment 
		return $find_status;
		
	}
	
}


























	
?>