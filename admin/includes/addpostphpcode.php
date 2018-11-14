<?php
ob_start();
session_start();

include"../../databasephp/db.php";
include "../../databasephp/functions.php";

global $connection;
 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/

//Used to populate the add_post.php page dropdown menus with data from database
if(isset($_POST["populatePageDropDowns"]) && !empty($_POST["populatePageDropDowns"])){	
   
    $cat_title_array = [];
	$cat_id_array = [];
    $user_name_array = [];
	$user_id_array = [];
	
	$stmt = mysqli_prepare($connection,"
	SELECT cat_id, cat_title 
	FROM  post_categories
	");	
    mysqli_stmt_execute($stmt);	  
	mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
		 
	 while( mysqli_stmt_fetch($stmt) ){
	 
	   array_push($cat_title_array, $cat_title);
	   array_push($cat_id_array,  $cat_id);
	 }
	  mysqli_stmt_close($stmt);
	  
	  
	$stmt = mysqli_prepare($connection,"
	SELECT user_id, user_name 
	FROM users
	");	
    mysqli_stmt_execute($stmt);	  
	mysqli_stmt_bind_result($stmt, $user_id, $user_name);
		 
	 while( mysqli_stmt_fetch($stmt) ){
	 
	   array_push($user_id_array, $user_id);
	   array_push($user_name_array, $user_name);
	 }
	 
	  mysqli_stmt_close($stmt); 
	 
	  echo json_encode(array("cat_title_array"=>$cat_title_array, "cat_id_array"=>$cat_id_array, "user_id_array"=>$user_id_array,"user_name_array"=>$user_name_array ));
	  return;
}

//Add a new post to the website database - function used on the add_post.php page
if(isset($_POST["submitPost"]) && !empty($_POST["submitPost"])){	


			 $POST_title = escape($_POST['postName']);
			 $POST_image = escape($_POST['image']);
			 $POST_content = escape2($_POST['postContent']);
			 $POST_status = escape($_POST['postStatus']);
			 $post_author = escape($_POST['postAuthor']);
			 $POST_category_id = escape(json_decode($_POST['postCategories']));  
			 $POST_category_id = escape($_POST['postCategories']);
			 //Add line breaks to content;	
		     $POST_content  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",	$POST_content);
		     $POST_content  = mysqli_real_escape_string($connection,$POST_content);
		     $POST_content  = stripslashes($POST_content);
			
			$post_comment_count = 0;
			$post_view_count = 0;
			
			$POST_date = date('Y-m-d H:i:s');
			
			//Query to input values into database
			$stmt = mysqli_prepare($connection, "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_content, post_status, post_image) 
			VALUES (?,?,?,?,?,?,?)" );
			mysqli_stmt_bind_param($stmt,'issssss',$POST_category_id, $POST_title, $post_author, $POST_date,  $POST_content,$POST_status, $POST_image);

			mysqli_stmt_execute($stmt);
				   	
		     $last_id = mysqli_insert_id($connection);
			 $num = $last_id;
		
            //////////////////////////////////////////////////////////////////////////////Add post download links, podcasts, videoand external links to the post composite tables
			
			//Blog post external website links
			 $post_external_link_name = escape($_POST['externalLinkNameString']);	
		     $post_external_link_name_array = explode("~", $post_external_link_name);//The different questions are separated with a *~*	
						
			 $post_external_link_href = escape($_POST['externalLinkHrefString']);		 
			 $post_external_link_Href_array = explode("~", $post_external_link_href);//The different questions are separated with a *~*	
			 		 
			 for($i = 0; $i < sizeof($post_external_link_name_array)-1; $i++ ){//Input the quiz questions and answers of the new quiz into quiz_question database			        

				$stmt2 = mysqli_prepare($connection,"INSERT INTO posts_external_links(posts_id,link_description,link_href) VALUE(?,?,?)");
				mysqli_stmt_bind_param($stmt2,'iss', $num, $post_external_link_name_array[$i],$post_external_link_Href_array[$i] );
				mysqli_stmt_execute($stmt2);
				mysqli_stmt_close($stmt2);
			
	        }
			
	       $post_video = escape($_POST['video']);
		   if($post_video != ""){
                $stmt2 = mysqli_prepare($connection,"INSERT INTO posts_videos(post_id,video_name,video_href) VALUE(?,?,?)");
				mysqli_stmt_bind_param($stmt2,'iss', $num, $post_video ,$post_video  );
				mysqli_stmt_execute($stmt2);
				mysqli_stmt_close($stmt2);
				
				//Update post view count
				$stmt3 = mysqli_prepare($connection,"UPDATE posts SET has_video = 1 WHERE post_id = ? ");
				mysqli_stmt_bind_param($stmt3,'i' , $num);
				mysqli_stmt_execute($stmt3);
				mysqli_stmt_close($stmt3);//Close statmentute($stmt);
		   }
			
		mysqli_stmt_close($stmt);	 		 
		echo json_encode(array("last_id"=>$last_id));		 
	    return;
}


//Used to upload a files to the database image folder - function used on the add_post.php page
if(isset($_FILES["file"]["type"]))
{	


//Upload podcast
if($_POST['type'] == "video"){
	
	 $validextensions = array("mp4");
	 $temporary = explode(".", $_FILES["file"]["name"]);
	 $file_extension = end($temporary);
	
	if(($_FILES["file"]["size"] > 50000000)//Approx 50mb files can be uploaded (number in kb)
	|| !in_array($file_extension, $validextensions)) {
	   
	   //Stop user uploading fake video
	   echo "Video can not be larger than 50 mb size and the video format has to be a mp4";
	   return;			
	}

	if (file_exists("../../video/".$_FILES["file"]["name"])) {
	
		echo "File already exists";
	   
	   return;	
	}
	else
	{
		$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
		$targetPath = "../../video/".$_FILES['file']['name']; // Target path where file is to be stored
		move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file.
	    echo $_FILES["file"]["name"];
	
		return;	
			
	 }
     
}

if($_POST['type'] == "image"){

	$validextensions = array("jpeg", "jpg", "png","PNG");
	$temporary = explode(".", $_FILES["file"]["name"]);
	$file_extension = end($temporary);

	if(($_FILES["file"]["size"] > 50000000)//Approx. 100mb files can be uploaded.
	
	&& !in_array($file_extension, $validextensions)) {
	   
	   //Stop user uploading fake images
	   echo "Image can not be larger than 50 mb size and the image format has to be a jpg or png or jpeg";
	   return;			
	}
	else{

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check == false) {
        echo "File is not an image - " . $check["mime"] . ".";
		return;
    }

    if ($_FILES["file"]["error"] > 0)
	{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			return;
	}
	else
	{
			if (file_exists("../../images/" . $_FILES["file"]["name"])) {
			
				echo "File already exists";
				
			}
			else
			{
			    $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
			    $targetPath = "../../images/".$_FILES['file']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file.
			
				echo $_FILES["file"]["name"];
	
			}
	  }	 
	}
 }
}

?>