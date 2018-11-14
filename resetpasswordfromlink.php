<?php
include"databasephp/db.php";
include"includes/header.php";
include"includes/navigation.php";
?>


<header>
<h1>Password reset</h1>
</header>

<h2 id ="message"></h2>
<br>
<?php
if($_GET['key'] && $_GET['reset'] && !empty($_GET['reset']) && !empty($_GET['key']))
{
	global $connection;
		
	$email =  escape($_GET['key']);
	$resetToken = escape($_GET['reset']);
 
	//When the user inputs nothing in to the boxes reload index page
	if (empty($resetToken) || empty($email)){ 
	   redirect("resetpassword.php");
	}
	
    $stmt = mysqli_prepare($connection,"SELECT user_password FROM users WHERE user_email = ? AND reset_token = ?");
    mysqli_stmt_bind_param($stmt,'ss' , $email, $resetToken);
	//if( !$stmt ) exit('Error'. htmlspecialchars($db->error));

	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);//Store result 
    $find_name_result = mysqli_stmt_num_rows($stmt);
	
	if ($find_name_result == 1){
    ?>	
	
	     <p>Enter New password</p>
		 <form method="post" action="resetpassword.php" id="login-form" role="form">	  
		   <div class="form-group">
		   	 <input type="hidden" id= "email" name="email" value="<?php echo $email;?>">
			 <label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
			 <input type="password" value="" name="password" id="password" class="form-control" placeholder="Enter password" autocomplete="on" value="" required>
			 </div>
		  <button type="submit" name="resetPassword" id="resetPassword" class="btn btn-custom btn-lg btn-block btn-primary" value="Register">Reset password</button>			
          </form>
	
    <?php	
	
  }else{
	  
	  echo "Password link has expired";
  }
}else{
	
	header('Location: '."index.php");	
}
?>

<script>
$("document").ready(function(){
	
$("#resetPassword").on("click", function(e) {//Add post useing ajax

	event.preventDefault();
						
	var password = $("#password").val();
	var email = $("#email").val();
	if(password == ""){
		
		alert("password cannot be empty");
		return;
	}

    var resetPasswordLinkFromLink = "resetPasswordLinkFromLink";
	jQuery.ajax({
		url: 'databasephp/resetPasswordphpcode.php',
		dataType: "json",
		type: "post",
		data: {resetPasswordLinkFromLink:resetPasswordLinkFromLink,password:password,email:email},		
		 success: function(response){
		    
		        alert("Password updated");	
				window.location = "index.php";
				  
		   },
		 complete: function() {
		  
		 }
	});	
			
});
		
});
</script>	

<?php include"includes/footer.php";//Page footer include ?>