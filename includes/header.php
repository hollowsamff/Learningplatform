<?php
ob_start();
session_start();
include "databasephp/functions.php";

if(isset($_SESSION['user_id'])){//Run when the user quiz data is send from the quizInclude page
	
   $user_id = $_SESSION['user_id'];
   $cookie = $_COOKIE["userTime"];
   $login_id1 = $_SESSION["login_time_id"];


}else{
	$user_id = "";	
	$cookie = "";
    $login_id1 = "";
}

/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability: https://codepen.io/hollowsamff/pen/PjxMvQ
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sam Francis">
	<meta name="description" content="Sam Francis website about himself">
    <meta name="keywords" content="SamFrancis, Sam, Francis, Bath, College, portfolio, website design,portfolio design,personal website,personal portfolio,portfolio site">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   	
	<!-- Bootstrap -->
	<script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js'></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	
	<link href="css/style.css" rel="stylesheet">	
     <title>Sam Francis student at Bath College portfolio design personal website</title>
	 
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<script>
$(document).ready(function(){


var sessionId = "<?php echo($user_id);?>"//Log the user out if they do not clicked the page for more than an hour
var sessionId2 = "<?php echo($cookie);?>"//Log the user out if they do not clicked the page for more than an hour
var loginTimeId = "<?php echo($login_id1);?>" 

if(sessionId == "" && sessionId2 != ""){//When the user closes the browser - update the time the user logged out to the time they logged in
	
window.location = "databasephp/logout.php?forceLoggedOf";//If the user has been forced logged of, sent the time the user last clicked on the page to the logout page		  

}

if(sessionId != ""){
	
	var dateTime = new Date().toLocaleString();	
	
	var ts = new Date();
	var unixSecondsOne = ((new Date(ts)).getTime()) / 1000;
	var myVar = setInterval(myTimer, 1000);

	function myTimer(){
	
		  ts2 = new Date();
		  unix_seconds = ((new Date(ts2)).getTime()) / 1000;
	  
		if(unixSecondsOne + 36000 < unix_seconds){//3600 = one hour
		    
		   clearInterval(myVar);	   
		   window.location = "databasephp/logout.php?logoutTime="+dateTime;  
		}
	}
	
	$(document).click(function(){//Update time when user clicks on page
	
    if (typeof unix_seconds !== 'undefined') {
	
	 if(unixSecondsOne + 36000 > unix_seconds){	
       
		 var updateUserOnlineTime = "senddata";
		 $.ajax({//Update the users online time
			type: "POST",
			url: "databasephp/updateuseronlinetimephpcode.php",
			data: {updateUserOnlineTime:updateUserOnlineTime,sessionId:sessionId,loginTimeId:loginTimeId},	
			success:function(msg) {
				//alert(msg);
			}
		});	
		 unixSecondsOne = unix_seconds;
	     dateTime = new Date().toLocaleString();	 
	 }	
	}
	});
  }  
});  
</script>
