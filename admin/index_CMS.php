<?php //Page header include  page is used to show, delete and add categories from the database
include"includes/admin_header.php";

?>

<script>
//Used to show the tool tip on the bullet point content boxes - explains that the user needs to separate bullets with full stops
$(document).ready(function(){
   // $('[data-toggle="tooltip"]').tooltip(); 
	
});
</script>


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
//An  explode is used to this split the text in to an array and the arrays values are  displayed on the page		
?>


<?php
//Query to update the posts - values sent from Edit Posts form
if(isset($_POST['update_post'])){


	//Associative arrays replace the index with a lable - this is called a key
	$error = [ "email" => "","image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array

	//Used to test if the image one is fake 
	$user_image_temp = $_FILES['image']['tmp_name'];
		
	if (!empty($user_image_temp)) {

		list($width, $height) = getimagesize($user_image_temp);
		
		if ($width < 1 || $height <1 ){
			
			 $error['image'] = 'You can not upload fake images on this website.';
				 
		}else{//When the image is real
			
			   //Function used to save the image - move from temp location to websites image folder
			   $user_image = $_FILES['image']['name'];
			   move_uploaded_file ($user_image_temp, "../images/$user_image");

		   }
		 }
		
	    //Used to test if the image  two is fake 
		$user_image_temp2 = $_FILES['image2']['tmp_name'];
			
		if (!empty($user_image_temp2)) {

			list($width, $height) = getimagesize($user_image_temp2);
			
			if ($width < 1 || $height <1 ){
				
				 $error['image2'] = 'You can not upload fake images on this website.';
					 
			}else{//When the image is real
				
				   //Function used to save the image - move from temp location to websites image folder
				   $user_image2 = $_FILES['image2']['name'];
				   move_uploaded_file ($user_image_temp2, "../images/$user_image2");

			   }
			 }
		
		// Used to test for and show error message
		foreach ($error  as $key => $value) {  
			
			if (empty($value)){
				
				unset($error[$key]);//Remove old values out of empty fields
			
			  }
			  
			}
			
	    if(empty($error)){ //When no errors are found edit page
				
			  if(empty($user_image)){//If user does not change image one keep current image
										
					$stmt2 = mysqli_prepare($connection,"SELECT indivigual_page_content_image_one FROM indivigual_page_content WHERE indivigual_page_content_id = 21");
					mysqli_stmt_execute($stmt2);
					
					$stmt2->bind_result($user_image);

					 while($stmt2->fetch()){//Loop though the database search and put the found image in a variable
						
					 $user_image =  $user_image ;
					}
			     mysqli_stmt_close($stmt2);//Close statment connection 
				}
				
				
				  if(empty($user_image2)){//If user does not change image one keep current image
										
					$stmt2 = mysqli_prepare($connection,"SELECT indivigual_page_content_image_two FROM indivigual_page_content WHERE indivigual_page_content_id = 21");
					mysqli_stmt_execute($stmt2);
					
					$stmt2->bind_result($user_image2);

					 while($stmt2->fetch()){//Loop though the database search and put the found image in a variable
						
					 $user_image2 =  $user_image2 ;
					}
			     mysqli_stmt_close($stmt2);//Close statment connection 
				}
				
			//Values from the forms are stored in varables 
			$page_heading = escape($_POST["Page_heading"]);
			$page_sub_heading = escape($_POST["page_sub_heading"]);
			
			$paragraph_one = $_POST["paragraph_one"] ;	
			$paragraph_one = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",$paragraph_one);	
			$paragraph_one = mysqli_real_escape_string($connection,$paragraph_one);

			$bullet_heading_one = escape($_POST["bullet_heading_one"]);
			
			//bullet points are seperate with a coma
			$bullet_list_one = $_POST["bullet_list_one"] ;	
			$bullet_list_one = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",$bullet_list_one);	
			$bullet_list_one = mysqli_real_escape_string($connection,$bullet_list_one);
			
			$bullet_heading_two = escape($_POST["bullet_heading_two"]);

			$paragraph_two = $_POST["paragraph_two"] ;	
			$paragraph_two = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",$paragraph_two);	
			$paragraph_two = mysqli_real_escape_string($connection,$paragraph_two);
		
			$content_separator="~";//This used to seperated the form varables in the string that is input into the database($content_string)
			
			//All the varables from the from a stored in one string and input into the database
			
			$content_string = 
			$page_heading.$content_separator.
			$page_sub_heading.$content_separator.
			$paragraph_one.$content_separator.
			$bullet_heading_one.$content_separator.
			$bullet_list_one . $content_separator. 
			$paragraph_two.$content_separator;
			$content_string = stripslashes($content_string);
			
			$stmt2 = mysqli_prepare($connection,"UPDATE indivigual_page_content SET indivigual_page_content_text = ? ,
			indivigual_page_content_image_one = ?,indivigual_page_content_image_two = ?
			WHERE indivigual_page_content_id = 21");
			mysqli_stmt_bind_param($stmt2,'sss',$content_string, $user_image, $user_image2);
			mysqli_stmt_execute($stmt2);

		   if(!$stmt2){//Test if the query fails//die("Query error test")."<br>". mysqli_error($stmt);
		   }	  
				  
			mysqli_stmt_close($stmt2);//Close statment

		    header("Location:index_CMS.php");

		}
}

?>

 <div id="wrapper">
	
	 <!-- Navigation -->
	 <?php include"includes/admin_navigation.php";//Page navigation include  ?>
		
        <div id="page-wrapper">

			 <div class="container-fluid">
			 <div class="col-lg-12">
			 
			 <h1 class="page-header text-center">About Us page CMS</h1>
			 <?php  
			 
			 //print_r($split_string); // Used to test if page content splis correcly?>
			 </div>
	 
			<div class="col-lg-12">

			 <form action = "" method="post" enctype="multipart/form-data">

					<div class = "form-group">
					<img width='100' src ='../images/<?php echo $user_image ?>' alt='Image one of Sam Francis Bath College profile site index page'>
					</div>
					<div class = "form-group">
					<label for= "post_image">Page image one</label>
					<input  type = "file" name = "image">
					<h4 class="warning_red"><?php echo isset($error['image']) ? $error['image'] : '' ?></h4>
					</div>
				
					<div class = "form-group">
					<img width='100' src ='../images/<?php echo $user_image2 ?>' alt='Image two of Sam Francis Bath College profile site index page'>
					</div>
					<div class = "form-group">
					<label for= "post_image2">Page image two</label>
					<input  type = "file" name = "image2">
					<h4 class="warning_red"><?php echo isset($error['image2']) ? $error['image2'] : '' ?></h4>
					</div>
				
					<label for= "title">Page heading</label>
					<input value="<?php echo $split_string[0];?>" type = "text" class="form-control" name = "Page_heading">
					 <br>
			  
					<label for= "title">Page subheading</label>
					<input value="<?php echo $split_string[1];?>" type = "text" class="form-control" name = "page_sub_heading">
					<br>

					<div class = "form-group">
					<label for= "post_content">Paragraph one</label>
					<textarea class="form-control" name = "paragraph_one" id="" cols="5" rows="5"><?php
					echo $split_string[2];
					?>
					</textarea>        
					<hr>
					</div>   
					 
					<label for= "title">Bulletpoint list one heading</label>
					<input value="<?php echo $split_string[3];?>" type = "text" class="form-control" name = "bullet_heading_one" size="10">
					<br>
					
					<div class = "form-group" href="#" data-toggle="tooltip" title="Separate bullets points with full stops"></div>
					<label for= "post_content"  href="#" data-toggle="tooltip" title="Separate bullets points with full stops">Bulletpoint list one</label>
					<p>Separate bullets points with full stops i.e .test.test</p>
					<textarea  class="form-control" name = "bullet_list_one"  id="bullet_list_one" cols="1" rows="1"><?php
					echo $split_string[4];
					?>
					</textarea>
					
					<hr>
					
					<div class = "form-group">
					<label for= "post_content">Paragraph two</label>
					<textarea class="form-control" name = "paragraph_two" id="" cols="5" rows="5"><?php
					echo $split_string[5];
					?>
					</textarea> 
					</div>
					
					<hr>

					<div class = "form-group">
					<input class = "btn btn-primary" type = "submit" name = "update_post" value="Edit Page">
					</div> 						

			 </form>				  
		   </div>

        </div>	
    </div>	
</div>	
<?php include"includes/admin_footer.php";//Page footer include ?>
