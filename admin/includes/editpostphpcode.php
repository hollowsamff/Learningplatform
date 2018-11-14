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

		$get_post_id = escape($_POST['postId']);//Put sent value in varable
		
	     //Find the posts with the same id that was sent from the posts.php page
		 $stmt = mysqli_prepare($connection,"SELECT post_id, post_category_id, post_title, post_comment_count,  post_author, post_date,	 
		 post_image, post_content, post_tags, post_status FROM posts WHERE post_id = ?");
		 mysqli_stmt_bind_param($stmt,"i", $get_post_id);
		 $stmt->execute();
         $stmt->bind_result($post_id, $post_category_id, $post_title, $post_comment_count,  $post_author_id, $post_date,	 
		 $post_image, $post_content, $post_tags, $post_status);
	
		//Show all the fields from the post	database on the page
	   while($stmt->fetch()){
		   
		   //Add line breaks to content;	
			$post_content  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",	$post_content);
			$post_content  = mysqli_real_escape_string($connection,$post_content);
			$post_content  = stripslashes($post_content);
	   }
	
    $user_status_array = [];
	
    if($post_status == "published"){
		
		array_push($user_status_array, "published");
		array_push($user_status_array, "draft");

	}else{
			
		array_push($user_status_array, "draft");
		array_push($user_status_array, "published");
	}
	
	
	$user_name_array = [];
	$user_id_array = [];
	$user_selected_author_id = "";
    $user_selected_author_name = "";
	$stmt = mysqli_prepare($connection,"
	SELECT user_id, user_name 
	FROM users
	");	
    mysqli_stmt_execute($stmt);	  
	mysqli_stmt_bind_result($stmt, $user_id, $user_name);
		 
	 while( mysqli_stmt_fetch($stmt) ){
	 
		 if($user_id == $post_author_id){		 
			 $user_selected_author_id = $user_id;
			 $user_selected_author_name = $user_name;		 
		 }else{		 
		  array_push($user_id_array, $user_id);
		  array_push($user_name_array, $user_name);		  
		 }
	 }
	 mysqli_stmt_close($stmt); 
	 //Add the post author to front of array (so it will apear first in the drop down on edit_posts.php
	 if($user_selected_author_id != "" ||  $user_selected_author_name != ""){	
		array_unshift($user_id_array,$user_selected_author_name);
		array_unshift($user_name_array, $user_selected_author_name);
	 }
	
	$cat_title_array = [];
	$cat_id_array = [];
	$user_selected_catagory_id = "";
	$user_selected_catagory_name = "";
	$stmt = mysqli_prepare($connection,"
	SELECT cat_id, cat_title 
	FROM  post_categories
	");	
    mysqli_stmt_execute($stmt);	  
	mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
		 
	 while( mysqli_stmt_fetch($stmt) ){
	 
	  if($cat_id == $post_category_id){
		  
		  $user_selected_catagory_id = $cat_id;
		  $user_selected_catagory_name = $cat_title;
		  
	  }else{
		  
		array_push($cat_title_array, $cat_title);
	    array_push($cat_id_array, $cat_id); 
		
	  }
	 }
	  mysqli_stmt_close($stmt);
	  
	  //Add the post category to front of array (so it will apear first in the drop down on edit_posts.php)
	  if($user_selected_catagory_id != "" ||  $user_selected_catagory_name != ""){
		 array_unshift($cat_title_array,$user_selected_catagory_name);
		 array_unshift($cat_id_array, $user_selected_catagory_id);
	  }
	  
	  echo json_encode(array("post_content"=>$post_content,"post_image"=>$post_image,"post_title"=>$post_title,"post_author"=>$post_author_id,"cat_title_array"=>$cat_title_array, "cat_id_array"=>$cat_id_array, "user_id_array"=>$user_id_array,"user_name_array"=>$user_name_array,"user_status_array"=>$user_status_array ));
	  return;
}

//Add a new post to the website database - function used on the add_post.php page
if(isset($_POST["submitPost"]) && !empty($_POST["submitPost"])){	

             $post_id = escape($_POST['postId']);
			 
			 $post_title = escape($_POST['postName']);
			 $post_image = escape($_POST['image']);
			 
			 $post_status = escape($_POST['postStatus']);
			 $post_author = escape($_POST['postAuthor']);  
			 $post_category_id = escape($_POST['postCategories']);
			 
			 //Add line breaks to content;	
			 $post_content = escape2($_POST['postContent']);
		     $post_content  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",	$post_content);
		     $post_content  = mysqli_real_escape_string($connection,$post_content);
		     $post_content  = stripslashes($post_content);
			
			$post_comment_count = 0;
			$post_view_count = 0;
			
			$post_date = date('Y-m-d H:i:s');		
			
		   $stmt = mysqli_prepare($connection,"UPDATE posts 
		   SET 
		   post_title = ?,
		   post_content = ?,
		   post_status = ? ,
		   post_image = ?,
		   post_date = ?,
		   
		   post_category_id = ?,
		   post_author = ?
		   WHERE post_id = ?");
		   mysqli_stmt_bind_param($stmt,'sssssiii',
		   $post_title,
		   $post_content,
		   $post_status,
		   $post_image,
		   $post_date,
		   
		   $post_category_id,
		   $post_author,
		   $post_id);
		   mysqli_stmt_execute($stmt);
	
		 
            //////////////////////////////////////////////////////////////////////////////Add post download links, podcasts, videoand external links to the post composite tables
			
			//Blog post external website links
			$post_external_link_name = escape($_POST['externalLinkNameString']);	
		    $post_external_link_name_array = explode("~", $post_external_link_name);//The different questions are separated with a *~*	
						
			$post_external_link_href = escape($_POST['externalLinkHrefString']);		 
			$post_external_link_Href_array = explode("~", $post_external_link_href);//The different questions are separated with a *~*	
			 
            if ($post_external_link_name != ""){
	
                $stmt3 = mysqli_prepare($connection, "DELETE posts_external_links FROM posts_external_links WHERE posts_id = ?");							
				mysqli_stmt_bind_param($stmt3,'i',$post_id);
				mysqli_stmt_execute($stmt3);
				mysqli_stmt_close($stmt3);//Close statment connection 
			 
			 for($i = 0; $i < sizeof($post_external_link_name_array)-1; $i++ ){//Input the quiz questions and answers of the new quiz into quiz_question database			        

			    $stmt2 = mysqli_prepare($connection,"INSERT INTO posts_external_links(posts_id,link_description,link_href) VALUE(?,?,?)");
				mysqli_stmt_bind_param($stmt2,'iss', $post_id, $post_external_link_name_array[$i],$post_external_link_Href_array[$i] );
			    mysqli_stmt_execute($stmt2);
				mysqli_stmt_close($stmt2);
			
	        }
		 }  
		    

	      $post_video = escape($_POST['video']);
		  if($post_video != ""){
			  
				$stmt3 = mysqli_prepare($connection, "DELETE posts_videos FROM posts_videos WHERE post_id = ?");							
				mysqli_stmt_bind_param($stmt3,'i',$post_id);
				mysqli_stmt_execute($stmt3);
				mysqli_stmt_close($stmt3);//Close statment connection 
			
                $stmt2 = mysqli_prepare($connection,"INSERT INTO posts_videos(post_id,video_name,video_href) VALUE(?,?,?)");
			    mysqli_stmt_bind_param($stmt2,'iss', $post_id, $post_video ,$post_video  );
			    mysqli_stmt_execute($stmt2);
				mysqli_stmt_close($stmt2);
				
				//Update post view count
				$stmt4 = mysqli_prepare($connection,"UPDATE posts SET has_video = 1 WHERE post_id = ? ");
				mysqli_stmt_bind_param($stmt4,'i' , $post_id);
				mysqli_stmt_execute($stmt4);
			    mysqli_stmt_close($stmt4);//Close statmentute($stmt);
		  }
		  
		  
		  
			
		mysqli_stmt_close($stmt);	 		 
		echo json_encode(array("last_id"=>$post_id));		 
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
	

	if(($_FILES["file"]["size"] > 50000)//Approx. 50mb files can be uploaded.
	
	&& !in_array($file_extension, $validextensions)) {
	   
	   //Stop user uploading fake video
	   echo "Video can not be larger than 100 mb size and the video format has to be a mp4";
	   return;			
	}
	
    if (file_exists("../../video/" . $_FILES["file"]["name"])) {
	
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

	if(($_FILES["file"]["size"] > 50000)//Approx. 50mb files can be uploaded.
	&& !in_array($file_extension, $validextensions)) {
	   
	   //Stop user uploading fake images
	   echo "Image can not be larger than 100 mb size and the image format has to be a jpg or png or jpeg";
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