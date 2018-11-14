<?php
include"databasephp/db.php";
include"includes/header.php";
include"includes/navigation.php";

?>
<header>
<h1>Register</h1>
<p>You will be able to add an image to the profile after you have registered </p>
</header>


<section class="container-fluid">
    
	<form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

		 <div class="form-group">
		 <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
		 <input type="text" name="userName" id="userName" class="form-control" placeholder="Enter Desired Username" value="" required>
		 <h4 class="warning_red"></h4>
		 </div>

	   <div class = "form-group">
		<label for = "firstName">Firstname</label>
		<input value ="" type ="text" class="form-control" name = "firstName" id="firstName" placeholder="Enter First Name">
		</div>
		
		<div class = "form-group">
		<label for= "lastName">Lastname</label>
		<input value="" type ="text" class="form-control" id="lastName" name = "lastName" placeholder="Enter Last Name">
		</div>
	
		<div class = "form-group">
		<label for= "title">DOB</label>
		<input type="date" class="form-control"  id="userDOB" name = "userDOB" placeholder="DD/MM/YYYY" 
		required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" title="Enter a date in this formart DD/MM/YYYY" autocomplete="on" value="">
		</div>

		 <div class="form-group">
		 <label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label>
		 <input type="email" value="" name="email" id="email" class="form-control" placeholder="Enter Desired Email Address" autocomplete="on" value="" required>
		 <h4 class="warning_red"></h4>
		 </div>

		<div class="form-group">
		<label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
		<input type="password" value="" name="password" id="password" class="form-control" placeholder="Password" required>
		</div>
		<div class="form-group">
		<label for="password2"><span class="glyphicon glyphicon-eye-open"></span> Retype Password</label>
		<input type="password" value ="" name="password2" id="password2" class="form-control" placeholder="Password" required>
		</div>
		<div class="form-group">
		    <button type="submit" name="regester" id="regester" class="btn btn-custom btn-lg btn-block btn-primary" value="Register">Register</button>
		</div>
	</form>
    <br><br>
</section>

<script>
$("document").ready(function(){
		
		
$("#regester").on("click", function(e) {//Add post useing ajax

	event.preventDefault();
						
	var userName = $("#userName").val();
	var firstName = $("#firstName").val();
	var lastName = $("#lastName").val();
	var email = $("#email").val();
	var DOB = $("#userDOB").val();
	var password = $("#password").val();
	var password2 = $("#password2").val();

	if(userName == ""){
		
		alert("User name cannot be empty");
		return;
	}
	if(email == ""){
		
		alert("Email cannot be empty");
		return;
	}
	if(DOB == ""){
		
		alert("DOB cannot be empty");
		return;
	}
	if(password == ""){
		
		alert("Password one cannot be empty");
		return;
	}
	if(password2 == ""){
		
		alert("Password two cannot be empty");
		return;
	}

	if(password2 != password){
		
		alert("Passwords are not the same");
		return;
	}
    var submitUserTODatabase = "submitUserTODatabase";
	jQuery.ajax({
		url: 'databasephp/regesterphpcode.php',
		dataType: "json",
		type: "post",
		data: {submitUserTODatabase:submitUserTODatabase,userName:userName,firstName:firstName,lastName:lastName,email:email,DOB:DOB,password:password, pasword2:password2},		
		 success: function(response){
			
			alert(JSON.stringify(response));

			if (JSON.stringify(response)=='{"message":"User added to database"}'){
				
				window.location = "registration.php";
			}	
		   },
		 complete: function() {
		  
		 }
	});	
			
});
		
});
</script>	

<?php include"includes/footer.php";//Page footer include ?>