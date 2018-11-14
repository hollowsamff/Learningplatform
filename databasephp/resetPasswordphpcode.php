<?php
//Page used to sent password reset link
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require __DIR__  .'/PHPMailer-master/src/PHPMailer.php';
require __DIR__  .'/PHPMailer-master/src/SMTP.php';
require __DIR__  .'/PHPMailer-master/src/Exception.php';

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

//Used to reset a user password after they have clicked on an email link - sents data to the resetpassword.php page
if(isset($_POST["resetPasswordLinkFromLink"]) && !empty($_POST["resetPasswordLinkFromLink"])){	
  
  $email = escape($_POST['email']);
  $resetToken = "";
  $password = escape($_POST['password']);   
  $password = escape($_POST['password']);  
  $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
  
  //Update password and clear password reset token
  $stmt = mysqli_prepare($connection,"UPDATE users SET user_password  = ?, reset_token = ? 
  WHERE user_email = ?");
  mysqli_stmt_bind_param($stmt,'sss',$password, $resetToken, $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  
  echo json_encode(array("message" => "Password reset"));
 
}




//Used to sent a password reset link for website user accounts- sents data to the resetpassword.php page
if(isset($_POST["sentResetPasswordLink"]) && !empty($_POST["sentResetPasswordLink"])){	
 
	 $email = escape($_POST["email"]);
	 if($email == ""){
		
	 echo json_encode(array("message" => "Email cannot be empty"));
	 return;
	 
	}	
	
    $stmt = mysqli_prepare($connection,"SELECT user_email, user_password FROM users WHERE user_email = ? ");
	mysqli_stmt_bind_param($stmt,'s', $email);
	mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);//Store result 
	
	$find_email = mysqli_stmt_num_rows($stmt);
	
	/* bind result variables */
    mysqli_stmt_bind_result($stmt, $user_email, $user_password);
    /* fetch values */
    while (mysqli_stmt_fetch($stmt)) {
    }
	
	if($find_email > 0){
		
		$date = date_create();
	    $resetToken = password_hash(date_timestamp_get($date), PASSWORD_BCRYPT, array('cost' => 12));//Password reset token
		
		$stmt2 = mysqli_prepare($connection,"UPDATE users SET reset_token  = ? WHERE user_email = ?");//Input password reset token in to database
		mysqli_stmt_bind_param($stmt2,'ss',$resetToken, $email);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_close($stmt2);
		
	    $link="<a href='http://localhost/projects/web2018project/resetpasswordfromlink.php?key=".$user_email."&reset=".$resetToken."'>Click To Reset password</a>";

		//Set up SMTP
        $mail = new PHPMailer();
		///$mail->SMTPDebug = 1;
		$mail->IsSMTP();                // Sets up a SMTP connection
		$mail->SMTPAuth = true;         // Connection with the SMTP does require authorization
		$mail->SMTPSecure = 'ssl';      // Connect using a TLS connection
		$mail->Host = "smtp.gmail.com";  //Gmail SMTP server address
		$mail->Port = 465;  //Gmail SMTP port
		$mail->Username = ""; // GMAIL username
		$mail->Password = "";  // GMAIL password

		//Recipients
		$mail->From='hollowsamff@gmail.com';
		$mail->FromName='sam';
		$mail->AddAddress('hollowsamff@aol.com', 'sam');
		$mail->Subject  =  'Reset Password';
		$mail->IsHTML(true);
		$mail->Body = 'Click On This Link to Reset Password '.$link.'';	
		
		 if($mail->Send())
		 {
		   echo json_encode(array("message" => "Check Your Email and Click on the link sent to your email"));
		   
		 }
		 else
		 {
		  ///echo "Mail Error - >".$mail->ErrorInfo;
		  echo json_encode(array("message" => "Email did not send"));
		   
		 }
		
	}else{
		
		echo json_encode(array("message" => "Check Your Email and Click on the link sent to your email"));
		return;
	}
	 
	 mysqli_stmt_close($stmt);//Close statment connection 	 
	
	 		
}



?>




