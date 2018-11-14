<!--- 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/
-->

<script> 

$('document').ready(function(){
	
	var sendForm= true;
	
	//If the username, password , email fields are blank the user can not submit the form
	$('#add_users').click(function(){

		var str = $('#user_name').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_user_name').css('display','inline');
		}
		
		
		var str = $('#user_password').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_user_password').css('display','inline');
		}
		
		var str = $('#user_email').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_user_email').css('display','inline');
		}
		
	});
	
});
 
</script>


<?php
//Page is used to add a user to database - is include for the users.php page
if(isset($_POST["add_users"])){ //Run when the page form is sent

       $user_name =  escape($_POST["user_name"]);
	   $user_email =  escape($_POST["user_email"]);
	   $user_password =  escape($_POST["user_password"]);
	   $user_first_name = escape($_POST["user_first_name"] );
	   $user_last_name = escape($_POST["user_last_name"]);
	   $user_DOB = escape($_POST["user_DOB"] );
	   $user_role = escape($_POST["user_role"]);
		  
        //Associative arrays replace the index with a lable - this is called a key
		$error = ["username" => "", "email" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
			
        //Data validation to stop user inputing duplicate username or email 

	   if (user_name_exists($user_name)){
		
		 $error['username'] = 'Username already exists, please pick another one.';

		}	

	  if (user_email_exists($user_email)){
			
	 	 $error['email'] = 'Email already exists, please pick another one.';
				
	   }
		  		
	 
	   foreach ($error  as $key => $value) { // Used to test for and show error messages 
			
			if (empty($value)){
				
				unset($error[$key]);//Remove old values out of empty fields
			
		      }
		    }
			
		if(empty($error)){ //When no errors are found add user
		
			   //Remove values from error messages
			   $username ='';
			   $email ='';  
			   
               $user_DOB = date('d/m/Y',strtotime(escape($user_DOB)));//Convert date to English format - is diplayed when users is not added
			   //Use blowfish to hash the password - first value is password variable , second is encryption type and third is number of time hash will be run
			   $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
               $user_first_name = escape($_POST["user_first_name"] );
			   $user_last_name = escape($_POST["user_last_name"]);
			  
			   $user_DOB = escape($_POST["user_DOB"] );
			   $user_DOB = date('Y-m-d',strtotime(escape($user_DOB)));//Convert date to English fromat
				
			   $user_role = escape($_POST["user_role"]);
			
			   $stmt = mysqli_prepare($connection, "INSERT INTO users(user_name, user_password, user_first_name, user_last_name, user_email, user_role, user_DOB) 
			   VALUES (?, ? , ? ,?,?, ? , ?)" );
			   
			   mysqli_stmt_bind_param($stmt,'sssssss',$user_name, $user_password, $user_first_name, $user_last_name, $user_email, $user_role, $user_DOB);

			   mysqli_stmt_execute($stmt);
			   
			   if(!$stmt){ // die("Query error")."<br>". mysqli_error($stmt); 
			   }
				//Remove values so users can input another user without reloding the page
			   $user_name =  null;
			   $user_email =  null;
			   $user_password =  null;
			   $user_first_name = null;
			   $user_last_name = null;
			   $user_DOB = null;
			   $user_role = null;

			   mysqli_stmt_close($stmt);//Close statment connection
               echo " <h4> User Created: " . " " . "<a href='users.php'>View Users</a></h4>";

			  }

		}		 		


?>
<div class="container-fluid">

   <div class="col-lg-12">

	<h2> Add User</h2>
	<form action = "" method="post" enctype="multipart/form-data"><!-- --> 

	<div class = "form-group">
	<label for= "title">Firstname</label>
	<input type="text" name="user_first_name" id="user_first_name" class="form-control" placeholder="Enter Desired First Name" autocomplete="on" value="<?php echo isset($user_first_name) ? $user_first_name : '' ;?>" >
    </div>
	
	<div class = "form-group">
	<label for= "title">Lastname</label>
	<input type="text" name="user_last_name" id="user_last_name" class="form-control" placeholder="Enter Desired Last Name" autocomplete="on" value="<?php echo isset($user_last_name) ? $user_last_name : '' ;?>" >
    </div>
	
	
	<div class = "form-group">
	<label for= "title">DOB</label>
	<input type="date" class="form-control"  name = "user_DOB" placeholder="DD/MM/YYYY" 
	required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" title="Enter a date in this formart DD/MM/YYYY" autocomplete="on" value="<?php echo isset( $user_DOB ) ?  $user_DOB : '' ;?>">
	</div>

	<div class = "form-group">
	<label for= "title">Username</label>
	<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($user_name) ? $user_name : '' ;?>" >
	<h4 class="warning_red"><?php echo isset($error['username']) ? $error['username'] : '' ?></h4>
    </div>

	<style>#error_message_user_name{color:red;display:none}</style>
	<h4 id="error_message_user_name" class="error">Username cannot be empty.</h4>
	
	<div class = "form-group">
	<label for= "title">Password</label>
	<input type="password" name="user_password" id="user_password" class="form-control" placeholder="Enter Desired Password" autocomplete="on" value="<?php echo isset($user_password) ? $user_password : '' ;?>" >
	
    </div>
	
	<style>#error_message_user_password{color:red;display:none}</style>
	<h4 id="error_message_user_password" class="error">Password cannot be empty.</h4>
	

    <div class = "form-group">
	<label for= "title">Email</label>
	
	<input type="email" name="user_email" id="user_email" class="form-control" placeholder="Enter Desired Email" 
	autocomplete="on" value="<?php echo isset($user_email) ? $user_email : '' ;?>" >
	<h4 class="warning_red"><?php echo isset($error['email']) ? $error['email'] : '' ?></h4>
   </div>
	
	<style>#error_message_user_email{color:red;display:none}</style>
	<h4 id="error_message_user_email" class="error">Email cannot be empty.</h4>
	

	<div class = "form-group">
	<label for= "user_role">User Role</label><br>
	<select name = "user_role" class="form-control">
	<?php
	  //Find all the users from database
	  if (empty($user_role)){
	
		?>
		<option value ="notadmin">Select Options</option>
		<option value ="admin">admin</option>
		<option value ="notadmin">notadmin</option>
		<?php

	  }else{
	  //If the form is not sent show the user role that was not selected in the select
	  echo "<option value='$user_role'>{$user_role}</option>";
		
	  if ($user_role == "admin"){
		
	  echo "<option value='notadmin'>notadmin</option>";

	  }else{
		
		echo "<option value='admin'>admin</option>";
		
	   }
	   
	  }
	?>
	</select>
	</div>
	
	
    <br>
	<div class = "form-group">
    <input class = "btn btn-primary" type = "submit" name = "add_users" value="Add User" id ="add_users">
	</div> 						
    </form>  
	
    </div>
 <!-- /.container-fluid -->
 </div>
 
 