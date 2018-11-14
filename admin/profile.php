<?php //Page used to show the profile of the loged in user
include"includes/admin_header.php";
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
if(isset($_SESSION['user_name'])){
	
	$username = $_SESSION['user_name'];
	$stmt = mysqli_prepare($connection,"SELECT user_id, user_name, user_password, user_first_name, user_last_name,
	user_email,  user_role, user_DOB FROM users WHERE user_name = ? ");
	mysqli_stmt_bind_param($stmt,"s", $username);
	$stmt->execute();
	
	$stmt->bind_result($user_id, $user_name, $user_password, $user_first_name, $user_last_name,
	$user_email, $user_role, $user_DOB );

		   	//Fetch will return all fow, so while will loop until reaches the end
	     while($stmt->fetch()){
			//Varables = the the values from the database
			$user_id = $user_id ;
			$user_name = $user_name;
		    $user_password = $user_password;
			$user_first_name = $user_first_name;
			$user_last_name = $user_last_name;
			$user_email = $user_email;
		
			$user_role = $user_role;
		    $user_DOB = $user_DOB;
		 }

        //Query to update the users - values sent from Edit users form
		if(isset($_POST['update_users'])){
			
				//Associative arrays replace the index with a lable - this is called a key
			    $error = [ "email" => "","image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array

		
			
				//Used to compare the original email and the user input email
			    $user2_email = $user_email;			
				$user_email = escape($_POST["user_email"] );
			
				//When email is the same do nothing 
				if ($user_email == $user2_email){

				}else{//Test if the email is being used by other users

					  if (user_email_exists($user_email)){
			
	 	                   $error['email'] = 'Email already exists, please pick another one.';
	                    }
				}
	            	

	            // Used to test for and show error message
				foreach ($error  as $key => $value) {  
					
					if (empty($value)){
						
						unset($error[$key]);//Remove old values out of empty fields
					
					  }
					}
					
                if(empty($error)){ //When no errors are found edit user
				
						//$user_role = mysqli_real_escape_string($connection, $_POST["user_role"] );	
						//$user_name = mysqli_real_escape_string($connection, $_POST["user_name"] );
						$user_first_name = escape($_POST["user_first_name"] );
						$user_last_name = escape($_POST["user_last_name"]);

						$user_DOB = escape($_POST["user_DOB"] );
						$user_DOB = date('Y-m-d',strtotime(escape($user_DOB)));//Convert date to database format
				

						if($_POST["user_password"]){
								
							$user_password = escape($_POST["user_password"] );	
							//Use blowfish to hash the password - first value is password variable , second is encryption type and third is number of time hash will be run
							$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
							
						}else{//When user does not input password keep current password
						
							$user_password = $user_password;	
						}

					   mysqli_stmt_close($stmt);//Close statment connection   
	
					
					    echo "User Updated";
	
					   	$stmt = mysqli_prepare($connection,"UPDATE users SET user_email  = ? , user_password = ?,  
						user_first_name = ? , user_last_name  = ?, user_DOB = ? WHERE user_id = ?");
						//Query to update database users
						mysqli_stmt_bind_param($stmt,'sssssi',$user_email, $user_password,  $user_first_name, $user_last_name, $user_DOB,
						 $user_id);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);//Close statment
			  
				}

	    	}
				
		}
?>
<div id="wrapper">

  <!-- Navigation -->
  <?php include"includes/admin_navigation.php";//Page navigation include ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <div class="col-lg-12">

        <h1 class="page-header text-center">User Profile</h1>

        <form action="" method="post" enctype="multipart/form-data">
          <!-- -->

          <div class="form-group">
            <label for="title">Username</label>
            <input value="<?php echo $user_name
							?> " type="text" class="form-control" name="user_name" readonly="value">
          </div>

          <div class="form-group">
            <label for="title">Firstname</label>
            <input value="<?php echo escape($user_first_name)?>" type="text" class="form-control" name="user_first_name">
          </div>

          <div class="form-group">
            <label for="title">Lastname</label>
            <input value="<?php echo escape($user_last_name)?>" type="text" class="form-control" name="user_last_name">
          </div>

          <div class="form-group">
            <label for="title">DOB</label>
            <input type="text" value="<?php echo $user_DOB = date('d-m-Y',strtotime(escape($user_DOB)));//Convert date to uk fromat?>" class="form-control" name="user_DOB" placeholder="DD/MM/YYYY" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" title="Enter a date in this formart DD/MM/YYYY"
            />
          </div>

          <div class="form-group">
            <label for="title">Email</label>
            <input value="<?php echo escape($user_email)?>" type="text" class="form-control" name="user_email">
            <h4 class="warning_red">
              <?php echo isset($error['email']) ? $error['email'] : '' ?>
            </h4>
          </div>

          <div class="form-group">
            <label for="title">Password</label>
            <input type="text" class="form-control" name="user_password">
          </div>

          <label for="title"></label>
          <input value="<?php echo escape($user_role)?>" type="hidden" class="form-control" name="$user_role" readonly="value">

          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update_users" value="Edit Profile">
          </div>

        </form>
      </div>

      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
</div>
  <?php include"includes/admin_footer.php";//Page footer include ?>