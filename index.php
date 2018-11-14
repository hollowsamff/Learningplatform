<?php 
//Login page for the menu content managment system. All the text on the page is generated from a database that the user can change using the websites content managment system
//Connection to database include
include"databasephp/dbnotautorised.php";
//Page header include
include"includes/header.php";
//Page navigation bar include
include"includes/navigation.php";
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability: https://codepen.io/hollowsamff/pen/PjxMvQ
*/
?>

<?php //Hide the login form after users login
				if(isset($_SESSION['user_id'])):
				?>

<?php //Hide the login form after users login
				
				if($_SESSION['user_role'] == "admin" || $_SESSION['user_role'] == "notadmin"){
				?>

<?php 
					//Find the content that will populate the page from the database
					 $stmt = mysqli_prepare($connection,"SELECT indivigual_page_content_id, indivigual_page_content_text, indivigual_page_content_image_one, indivigual_page_content_image_two
					  FROM indivigual_page_content WHERE indivigual_page_content_ID = 21");
					  if($stmt-> execute()){

						  $stmt->bind_result($id, $text,$user_image, $user_image2);
					  
						  while ($stmt->fetch()){

						  }
					  }
					//The values from the indivigual_page_content  field is stored in $text 
					$myString = $text;
					$split_string = explode('~', $myString);//The differnt section of the page are seperated by ~ 
					$split_string = preg_replace('~</p[^>]*>~', '',   $split_string);
			        $split_string = preg_replace('~<p[^>]*>~', '',   $split_string);
					
					//An  explode is used to this split the text in to an array and the arrays values are  displayed on the page		
					?>

    <section class="container-fluid">
    <div class="row">
        <div class="col-md-8">
		    <!--Show page heading-->
            <h1 style="color:#3CB371" class='text-center'><?php echo $split_string[0];?></h1>
			 <!--Show page sub heading-->
             <h3  class='text-center' style="margin-top:-5px;"><i><?php echo $split_string[1];?></i></h3>    
   
			 <br>
			 <!--Show page paragraph one-->
			 <?php echo $split_string[2];?>

			 
			 <!--Show page bullet point list one heading-->
			 <h3> <?php echo $split_string[3];?></h3>
			 
			 
			 <!--Show page bullet list one indivigual bullets-->
			 <ul class="b">
			 <?php 
			 //The bullet point values are seperated useing a coma in the website database
			 $bullet_list_one =   $split_string[4];	 
             $bullet_list_one = preg_replace('~</span[^></span[^>]*>]*>~', '', $bullet_list_one);
	         $bullet_list_one = preg_replace('~</span[^>]*>~', '', $bullet_list_one);
			 
             $bullet_list_one = explode('.', $bullet_list_one);//Store the differnt bullet point in an array
             $bullet_list_one_count = count($bullet_list_one);//Count the number of bullet points in the list
			
		     //Print all the bullet points from the array in a list useing a loop - the first value in the array is a coma so the loop starts at one
			 for($x = 1; $x < $bullet_list_one_count; $x++){//X is used to show all the items in the array when the loop runs
			

					//echo"<li><span>".$bullet_list_one[$x]."</span></li>";
			 }
			 
			 ?>
			 </ul>
 
			 <!--Show page bullet point list two heading-->
			 <p> <?php echo $split_string[5];?></p>
			 
					 <!--Show page bullet list two indivigual bullets-->
			 <ul class="b">
			 <?php 
			 
			 //The bullet point values are seperated useing a coma in the website database
		     $bullet_list_two =  $split_string[6];
	         $bullet_list_two = preg_replace('~</span[^>]*>~', '', $bullet_list_two);
             $bullet_list_two = explode(',', $bullet_list_two);//Store the differnt bullet point in an array
             $bullet_list_two_count = count($bullet_list_two);//Count the number of bullet points in the list
			
		     //Print all the bullet points from the array in a list useing a loop - the first value in the array is a coma so the loop starts at one
			 for($x = 1; $x < $bullet_list_two_count; $x++){//X is used to show all the items in the array when the loop runs
			
				echo"<li><span>".$bullet_list_two[$x]."</span></li>";
			 }
			 ?>
			 
			 
			 </ul>
			<br>
			  <!--Show page paragraph two-->
			 
        </div>
		
		    <div class ="col-md-1">
			<img  width='350' height='auto'  src ='images/<?php echo $user_image ?>' alt="companybuilding"><!-- $post_image contains a referance(the name) of the image from the database -->
			<br><br>
			<img  width='300' height='auto'  src ='images/<?php echo $user_image2?>' alt="companystaff">
			</div>
			
    </div>
	<br><br>
</section>

<?php
				}
				?>
				
<?php else: ?>
<!--Show login button-->

<button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background_color:green padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="fa fa-lock"></span> Login</h4>
      </div>

      <div class="modal-body" style="padding:40px 50px;">

        <form role="form" action="databasephp/login.php" method="post">
          <div class="form-group">
            <label for="usrname"><span></span> Username</label>
            <input name="username" type="text" class="form-control" value="" placeholder="Input username">
          </div>
          <div class="form-group">
            <label for="psw"><span></span> Password</label>
            <input name="password" type="password" class="form-control" value="" placeholder="Input password">
          </div>
          <div class="checkbox">
       
          </div>
          <button type="submit" name="login" class="btn btn-success btn-block"><span></span> Login</button>
        </form>

      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        <p>Not a member? <a style="color:blue" href="registration.php">Sign Up</a></p>
        <p>Forgot <a style="color:blue" href="resetpassword.php">Password?</a></p>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>

<style>
  label {
    font-weight: normal
  }

  ​ .containerImage {
    width: auto;
  }

  img {
    margin: auto;
  }

  #errorDescriptionMessage,
  #errorLocationMessage {
    color: red;
    display: none;
  }
</style>
<script>
  $(document).ready(function() {
    $("#myBtn").click(function() {
      $("#myModal").modal({
        backdrop: false
      });
    });
  });
</script>

<?php include "includes/footer.php";?>