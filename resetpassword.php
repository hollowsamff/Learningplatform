<?php
include"databasephp/db.php";
include"includes/header.php";
include"includes/navigation.php";
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability: https://codepen.io/hollowsamff/pen/PjxMvQ
*/
?>
<header>
<h1>Password reset</h1>
</header>

<h2 id ="message"></h2>
<br>

<div class="container-fluid">   
<section>

 <form method="post" action="resetpassword.php" id="login-form" role="form">
      <p>Enter Email Address To Send Password Link</p>	  
	   <div class="form-group">
		 <label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label>
		 <input type="email" value="" name="email" id="email" class="form-control" placeholder="Enter Desired Email Address" autocomplete="on" value="hollowsamff@aol.com" required>
		 <h4 class="warning_red"></h4>
		 </div>
      <button type="submit" name="resetPassword" id="resetPassword" class="btn btn-custom btn-lg btn-block btn-primary" value="Register">Reset password</button>
		
 </form>
</section>
</div>

<script>
$("document").ready(function(){
				
$("#resetPassword").on("click", function(e) {//Add post useing ajax

	event.preventDefault();
						
	var email = $("#email").val();
	
	if(email == ""){
		
		alert("Email cannot be empty");
		return;
	}

    var sentResetPasswordLink = "sentResetPasswordLink";
	jQuery.ajax({
		url: 'databasephp/resetPasswordphpcode.php',
		dataType: "json",
		type: "post",
		data: {sentResetPasswordLink:sentResetPasswordLink,email:email},		
		 success: function(response){
			
			 console.log(response);		
			//alert(JSON.stringify(response));
			
			$("#message").html("<br><span class='alert alert-success' role='alert'>"+response.message+"</span><br>");
		
		   },
		 complete: function() {
		  
		 }
	});	
			
});
		
});
</script>	

<?php include"includes/footer.php";//Page footer include ?>