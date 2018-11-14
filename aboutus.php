<?php
include"databasephp/dbnotautorised.php";
include"includes/header.php";
include"includes/navigation.php";
?>

	<?php 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
	
	
	//Find the content that will populate the page from the database
	 $stmt = mysqli_prepare($connection,"SELECT indivigual_page_content_id, indivigual_page_content_text, indivigual_page_content_image_one, indivigual_page_content_image_two
	  FROM indivigual_page_content WHERE indivigual_page_content_ID = 22");
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
			 $bullet_list_one = $split_string[4];
			 $bullet_list_one = preg_replace('~</span[^>]*>~', '', $bullet_list_one);
             $bullet_list_one = explode('.', $bullet_list_one);//Store the differnt bullet point in an array
			 
             $bullet_list_one_count = count($bullet_list_one);//Count the number of bullet points in the list
			
		     //Print all the bullet points from the array in a list useing a loop - the first value in the array is a coma so the loop starts at one
			 for($x = 1; $x < $bullet_list_one_count; $x++){//X is used to show all the items in the array when the loop runs
			
					echo"<li><span>".$bullet_list_one[$x]."</span></li>";
			 }
			 
			 ?>
			 </ul>
			 
 
			 <!--Show page bullet point list two heading-->
			 <p> <?php echo $split_string[5];?></p>
			 
			 <!--Show page bullet list two indivigual bullets-->
			 <ul class="b">
			 <?php 
			 //The bullet point values are seperated useing a coma in the website database
		     $bullet_list_two = $split_string[6];	    
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

		
<?php include"includes/footer.php";//Page footer include ?>