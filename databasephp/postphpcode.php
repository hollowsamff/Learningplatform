<?php
//This file contains the php function that get data from the website database
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

//Used to populate the post.php page with data from database
if(isset($_POST["getUserPostData"]) && !empty($_POST["getUserPostData"])){	
 
    $the_post_id = escape($_POST['postId']);   
 
    //Update post view count
	$stmt = mysqli_prepare($connection,"UPDATE  posts SET post_view_count = post_view_count + 1 WHERE post_id = ? ");
	mysqli_stmt_bind_param($stmt,'i' , $the_post_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);//Close statmentute($stmt);
	
	//Store the values from posts fields from database post table in varables
	$stmt = mysqli_prepare($connection,"SELECT
	posts.post_id,
	posts.post_title,
	posts.post_author,
	posts.post_date,
	posts.post_content,
	posts.post_image,
	posts.has_video,
	users.user_name			
	FROM posts 	
	INNER JOIN users
	on users.user_id = posts.post_author		
	WHERE posts.post_id = $the_post_id ORDER BY posts.post_date DESC ");//Select the  post with the same id as was sent from the index page		
	
	mysqli_stmt_execute($stmt);	
	$stmt->bind_result(
	$post_id,
	$post_title,
	$post_author,
	$post_date,
	$post_content,
	$post_image,
	$post_has_video,
	$user_name
	);							
	mysqli_stmt_store_result($stmt);//Store result 
	$count = mysqli_stmt_num_rows($stmt);		
	if($count < 1){//When no post was found
				
		//echo "<h1 class='text-center'>No posts found</h1>";
		///mysqli_stmt_close($stmt);
		

   }else{

		while($stmt->fetch()){//Show post with the same id as was sent from the index page
			
			$post_id = escape($post_id);//$row is row from database
			$post_title = escape($post_title);//$row is row from database
			$post_author = escape($post_author );//$row is row from database
			$post_date = escape($post_date);//$row is row from database
			$post_date = date('d-m-Y',strtotime( $post_date));
			$post_image = escape($post_image);//$row is row from database		
			$post_has_video = escape($post_has_video);
			$post_content =  str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"<br>",$post_content);	
			$post_content = mysqli_real_escape_string($connection,$post_content);
		}
   }
	$last_id = 5;

	$video_id = "";		
	$video_name = "";
	$video_href = "";
	$videoString = "";
	
	  //Get post video
    if($post_has_video == 1){
	 
		   $stmt7 = mysqli_prepare($connection,"
			SELECT 
			posts_videos.posts_video_id,
			posts_videos.video_name,
			posts_videos.video_href	
			FROM posts_videos
			INNER JOIN posts 
			on posts.post_id = posts_videos.post_id
			WHERE posts.post_id = $the_post_id");		

			mysqli_stmt_execute($stmt7);
			$stmt7->bind_result($video_id,$video_name,$video_href);	
			mysqli_stmt_store_result($stmt7);//Store result 
			$count = mysqli_stmt_num_rows($stmt7);

			//$conts = 0;
			while($stmt7->fetch()){//Show all the podcasts from the post
				$videoString ='<hr style="border-color:#3CB371;"><caption><strong>'.$video_name.'</caption></strong><br><video style="border: 2px solid black;" id="myVideo" controls><source src="video/'.$video_href.'" type="video/mp4">Your browser does not support HTML5 video.</video>';
			}	    
			mysqli_stmt_close($stmt7);	 	
	 }	
	
	 ///Get post external page links	
	 $post_external_links_string = "";
	 
     $stmt2 = mysqli_prepare($connection,"
		 SELECT posts_external_links_id,
		 posts_external_links.link_description,
		 posts_external_links.link_href
		 FROM posts 
		 INNER JOIN posts_external_links 
		 on posts.post_id = posts_external_links.posts_id
		 WHERE posts.post_id = $the_post_id");//Select the  post with the same id as was sent from the index page		
         
		 mysqli_stmt_execute($stmt2);	
		 
		 $stmt2->bind_result(
		 $posts_external_links_id,
		 $posts_external_links_description,
		 $posts_external_links_href);					
					
		 mysqli_stmt_store_result($stmt2);//Store result 
		 $count = mysqli_stmt_num_rows($stmt2);
		 
			if($count  > 0){
				
				$post_external_links_string .= '<hr style="border-color:#3CB371;"><h3 id="tests">Links to external learning material:</h3>';

				while($stmt2->fetch()){//Show post with the same id as was sent from the index page

				  $posts_download_links_href = escape($posts_external_links_href);
				  $post_external_links_string .= "<div>".$posts_external_links_description."<br><a class='externalLink' id=".$posts_external_links_id." href=".$posts_external_links_href." target='_blank'><span>".$posts_external_links_href."</span></a><br><br></div>";
				}
			}
		 ///$post_external_links_string += '<hr style=" border-color:#3CB371;">';
		 mysqli_stmt_close($stmt2);//Close statmentute($stmt);

	   echo json_encode(array("post_external_links_string"=>$post_external_links_string,"video_string"=>$videoString,"post_title"=>$post_title,"post_author"=>$user_name,"post_date"=>$post_date,"post_image"=>$post_image, "post_has_video"=>$post_has_video,"post_content"=>$post_content, "last_id"=>$last_id, ));		
	 
	   return;  
   

}


//The bit of code bellow are used to update users data from the post.php page, is used to update the number of times the user watches videos and clicks on external website links

if(isset($_POST["the_post_id"]) && !empty($_POST["the_post_id"])){	//Run when the user watches a video on the post.php page - record the number of time a user watches the video
//Only logged in users can edit code
if(is_logged_in()){
	$numberVisited = 1;	
	$postId = escape($_POST["the_post_id"]);	
	if(isset($_SESSION['user_id'])){		
	 $userId = $_SESSION['user_id'];
	 }else{	
		return;		
    }	
	$stmt= mysqli_prepare($connection,"SELECT user_video_id FROM user_video_watched WHERE user_id = ? AND post_video_id = ?");
	mysqli_stmt_bind_param($stmt,'ii' ,$userId,$postId);		
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);//Store result 
	 $count = mysqli_stmt_num_rows($stmt);//Find number of posts
	mysqli_stmt_close($stmt);

	if($count < 1 ){//Create new record
	   $stmt= mysqli_prepare($connection,"INSERT INTO user_video_watched(user_id, post_video_id ,number_times_watched) VALUE(?,?,?)");
		mysqli_stmt_bind_param($stmt,'ddd', $userId, $postId, $numberVisited );
		mysqli_stmt_execute($stmt);		
		mysqli_stmt_close($stmt);//Close statment connection 		
	}else{		
		$stmt = mysqli_prepare($connection,"UPDATE  user_video_watched SET number_times_watched = number_times_watched + 1 WHERE  user_id = ? AND post_video_id = ?");
	    mysqli_stmt_bind_param($stmt,'ii' ,$userId,$postId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);//Close statmentute($stmt);
	}	
  }
}

if(isset($_POST["externalLinkId"]) && !empty($_POST["externalLinkId"])){//Run when the user clicks a link on the post page -- record the number of time a user clicks a link 
echo "yay";
if(is_logged_in()){
	$numberVisited = 1;
	$externalLinkId = escape($_POST["externalLinkId"]);	
	if(isset($_SESSION['user_id'])){	 
	 $userId = $_SESSION['user_id'];
	}else{
		return;
	}
	$stmt= mysqli_prepare($connection,"SELECT user_websites_visited_id FROM user_websites_visited WHERE user_id = ? AND link_id = ?");
	mysqli_stmt_bind_param($stmt,'ii' ,$userId,$externalLinkId);		
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);//Store result 
	$count = mysqli_stmt_num_rows($stmt);//Find number of posts
	mysqli_stmt_close($stmt);
	if($count < 1 ){//Create new record		
	   $stmt= mysqli_prepare($connection,"INSERT INTO user_websites_visited(user_id, link_id,visited_number) VALUE(?,?,?)");
		mysqli_stmt_bind_param($stmt,'ddd', $userId, $externalLinkId, $numberVisited );
		mysqli_stmt_execute($stmt);		
		mysqli_stmt_close($stmt);//Close statment connection 		
	}else{//Update old record		
		$stmt = mysqli_prepare($connection,"UPDATE  user_websites_visited SET visited_number = visited_number + 1 WHERE  user_id = ? AND link_id = ?");
	    mysqli_stmt_bind_param($stmt,'ii' ,$userId,$externalLinkId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);//Close statmentute($stmt);
	}	
 }
}

  
                            
                        
                         








?>




