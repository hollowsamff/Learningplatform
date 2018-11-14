<script> 

$('document').ready(function(){
	//Used to show the tool tip on the TAGS content box - explains that the user needs to separate tags with comas
	$('[data-toggle="tooltip"]').tooltip(); 

});
</script>
<!--
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/				
-->


<!--Page is used  to show all the posts on the posts.php page(is an include) -->

					<?php  //Code is used to change multiple posts status and delete multiple posts 
					include("delete_modal.php");
					
				    //!empty($_SESSION stops query runing when page reloads
					if(isset($_POST['check_box_array']) && !empty($_POST['check_box_array']) ){ 

					//Store all the send values from the tick boxes in array(the ids of the selected posts)
					foreach($_POST['check_box_array'] as $check_boxes_values  ){
						
					$check_boxes_values = escape($check_boxes_values);
						
				     //Value is the selected option from the bulk_options select
					 $bulk_options = escape($_POST['bulk_options']);
					 			
					 //Case what option was selected 
					 switch($bulk_options){
						 
						 case 'published':// Change the status of selected posts to published
                         case 'draft': // Change the status of selected posts to draft
						 
						 $stmt = mysqli_prepare($connection,"UPDATE posts SET post_status  = ?  WHERE post_id = ? ");
						 mysqli_stmt_bind_param($stmt,'si',$bulk_options, $check_boxes_values );
						 mysqli_stmt_execute($stmt);

				         if(!$stmt){//Test if the query fails
				
					       die("Query error test")."<br>". mysqli_error($stmt);
				         }	  
				  
				         mysqli_stmt_close($stmt);//Close statment
						 
						 break;

						 case 'delete': // Delete selected posts

						     //Find out if posts have comments 
					         $stmt = mysqli_prepare($connection,"SELECT comment_id FROM comment");
							 mysqli_stmt_execute($stmt);
                             mysqli_stmt_store_result($stmt);//Store result 
	
	                         $comment_number = mysqli_stmt_num_rows($stmt);
						     mysqli_stmt_close($stmt);//Close statment 
					
						
		                      $stmt = mysqli_prepare($connection, "DELETE 
										posts,
										comment,
										posts_videos,
										posts_external_links
										FROM posts 
										
										LEFT JOIN `comment` ON posts.post_id = `comment`.`comment_post_id`	
										LEFT  JOIN `posts_videos` ON posts.post_id = `posts_videos`.`post_id`
										LEFT  JOIN user_video_watched ON `user_video_watched`.`post_video_id` = `posts_videos`.`posts_video_id`	
										LEFT  JOIN `posts_external_links` ON posts.post_id = `posts_external_links`.`posts_id`
										LEFT  JOIN user_websites_visited ON `user_websites_visited`.`link_id` =  `posts_external_links`.`posts_external_links_id`
										WHERE posts.post_id  = ? 
										
										");
									
									mysqli_stmt_bind_param($stmt,'i',$check_boxes_values);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_close($stmt);//Close statment connection 
						 break;
						 
						 case 'clone': //Clone posts
        
							 $stmt = mysqli_prepare($connection,"SELECT post_author, post_title, post_category_id, post_status,
							 post_image, post_tags, post_content, post_date
							 FROM posts WHERE post_id  = ? ");//Finds the post that was clonned
							 mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
							 mysqli_stmt_execute($stmt);

							 if(!$stmt){//Test if the query fails
							   die("Query error test")."<br>". mysqli_error($stmt);
							 }	  
							 
							 //Bind these variable to the SQL results
							 $stmt->bind_result($post_author, $post_title,$post_category_id,$post_status,$post_image,$post_tags,$post_content,$post_date);
							
							 //Fetch will return all fow, so while will loop until reaches the end
							 while($stmt->fetch()){//Copy all the values from the post back into the database

								$post_author = escape($post_author );
								$post_title = escape($post_title );
								$post_category_id = escape($post_category_id);
								$post_status = escape($post_status);
								$post_image = escape($post_image);
								$post_tags = escape($post_tags);

								//Add line breaks to content;	
								$post_content  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",	$post_content);
								$post_content  = mysqli_real_escape_string($connection,$post_content);
								$post_content  = stripslashes($post_content);
		
								$post_date = escape($post_date );
							   
							  }		
								
							   mysqli_stmt_close($stmt);//Close statment
								   
							   //Clone post
							   $stmt = mysqli_prepare($connection,"INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, 
							   post_content, post_tags, post_status)
							   VALUES(?,?,?,?,?,?,?,?) ");
								
							   mysqli_stmt_bind_param($stmt,'isssssss' ,$post_category_id, $post_title, $post_author , $post_date , 
							   $post_image , $post_content , $post_tags , $post_status);
							   mysqli_stmt_execute($stmt);
								
							  if(!$stmt){//Test if the query fails
										
								  die("Query error")."<br>". mysqli_error($stmt);
							   }	
							
							  mysqli_stmt_close($stmt);//Close statment connection 
							  
							  header("Location:posts.php");//Refresh the page - if the page is not refreshed the user can run the query again by refresing the page
							 
						  break;
						 	 
					  } //Close switch
				
					}
				   }
				
					
					?>
						
								 <!--Form which uses button and drop down menu to delete , the posts -->
								<form method ="post" multiple="multiple" method="post" enctype="multipart/form-data">
						          <div class = "form-group">
										<select class ="form-control" name = "bulk_options" id= "select">	
											<option value="">Select Option</option>
											<option value="published">Publish</option>
											<option value="draft">Draft</option>
											<option value="delete">Delete</option>
											<option value="clone">Clone</option>
									   </select>
							      </div>
								  <div class = "col-xs-4">
									<input type = "submit" name = "submit" id ="test" rel='1' class = "btn btn-success" value ="Apply">
									<a class = "btn btn-primary" href="posts.php?source=add_post"> Add New </a>
									<br><br>
								    <p>You cannot delete a post if one of the website quizzes is assigned  to it</p>		
                                  </div>  		
								
								<table class ="table table-bordered table-hover">
								<thead style="background-color:white;">
									<tr>
										<td><input  id = "select_All_Boxes" type ="checkbox"></td>
										
										<td>Title</td>
										<td>Author</td>
										<td>Date</td>
										<td>Content</td>
										<td>Video</td>
										<td>Image</td>
										<td>Category</td>
										<td>Comments</td>
										<td>Post Views</td>
										<td>Status</td>
										<td>Change Status</td>
										<td>Edit/View Post</td>
										<td>Delete Post</td>
										
									</tr>
								</thead>
							
							<tbody style="background-color:white;">
								<?php 
								//Find all the posts from database post table

								//Table join 
								$query ="SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status,
								posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_view_count,posts.post_content,post_categories.cat_id, post_categories.cat_title,users.user_name,posts_videos.video_name	
								
								FROM posts ";
								$query .="
								LEFT JOIN post_categories ON posts.post_category_id = post_categories.cat_id 
								LEFT JOIN users on users.user_id = posts.post_author	
								LEFT JOIN posts_videos ON posts.post_id = posts_videos.post_id 
								ORDER BY posts.post_id DESC ";  //connect two tables useing field with the same values
								
								$select_posts = mysqli_query($connection,$query);

								//Show all the fields from the posts categories table 
								while($row = mysqli_fetch_assoc($select_posts)){

									//Varables = the the values from the database
									$post_id = escape($row['post_id']);
									$post_author = escape($row['post_author']);
									$post_title = escape($row['post_title']);
									$post_category_id = escape($row['post_category_id']);
									$post_status = escape($row['post_status']);
									$post_image = escape($row['post_image']);
									$post_tags= escape($row['post_tags']);
									$post_comment_count = escape($row['post_comment_count']);
									$post_date = escape($row['post_date']);
									$post_date  = date('d-m-Y',strtotime(escape($post_date )));//Convert date to English fromat
									$post_view_count = escape($row['post_view_count']);
									$post_author_name = escape($row['user_name']);
									$post_content = $row['post_content'];
								    $post_content  = stripslashes($post_content);
                                    $post_video = $row['video_name'];
									//Tables joined so can use values from both
									$category_title = escape($row['cat_title']);
									$category_id = escape($row['cat_id']);

									 echo"<tr>";
									   ?>
									   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $post_id;?>'></td>
									
									   <?php //Stores the ids of the selected boxes in an array
									   
									    echo"<td>$post_title</td>";
										echo"<td>$post_author_name</td>";
										echo"<td>$post_date </td>";				
										echo"<td>$post_content</td>";
										echo"<td>$post_video</td>";
										
										echo "<td> <img width='75'  src ='../images/$post_image' alt='postimage'></td>";								
										echo"<td>{$category_title}</td>";
	
										$stmt2 = mysqli_prepare($connection,"SELECT * FROM comment WHERE comment_post_id = ?");
										mysqli_stmt_bind_param($stmt2, 'i' , $post_id);
										mysqli_stmt_execute($stmt2);
										mysqli_stmt_store_result($stmt2);//Store result 
										$number_of_comments = mysqli_stmt_num_rows($stmt2);
										mysqli_stmt_close($stmt2);
										

										echo"<td><a href='post_comments.php?id=$post_id&title=9'>$number_of_comments</a></td>";
								
										//Send post id and post author to page that show all the comments from that post						
										echo"<td><a href='posts.php?reset={$post_id}'> $post_view_count </a></td>";
										$post_date = date('d-m-Y',strtotime($post_date));//Convert date to database fromat
									 
									   
										echo"<td>$post_status</td>";
										echo"<td><a class='btn btn-info' style = margin:1px; href='posts.php?change_to_published={$post_id}' >Publish</a>";//Used to approve a comment
										echo"<a class='btn btn-info' href='posts.php?change_to_draft={$post_id}'>Draft</a></td>";//Used to unapprove a comment
							
										echo "<td><a class='btn btn-primary' style = margin:1px; href='../post.php?p_id={$post_id}'>View Post</a><a class='btn btn-info' href='posts.php?source=edit_posts&p_id={$post_id}'>Edit Post</a></td>";

										 //Delete works using the delete_link class
										 echo"<td><a class=' btn btn-danger delete_link' comment_number = '$number_of_comments'
										 rel='$post_id' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
										 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted
										 //With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window

									    echo"</tr>";
								
								}//End loop to show all values
								
	
								?>
							</tbody>
					 		</table>
					      </form>
						
						<?Php

		 		           //Used to change the status
							if(isset($_GET['change_to_published'])){
				
						 	    if(is_admin()){//Only logged in Admin users can edit code
								
								   $the_post_id = escape($_GET['change_to_published']);
		                           $stmt = mysqli_prepare($connection, "UPDATE posts SET post_status = 'published' WHERE post_id = ?");
	                       	       mysqli_stmt_bind_param($stmt,'i', $the_post_id);
								   mysqli_stmt_execute($stmt);
								   mysqli_stmt_close($stmt);//Close statment connection 
		 
								   header("Location: posts.php");//Refresh the page - the page needs to be refreshed for the delete to work
								
							      
							    }
							}
							 
							 
					       //Used to change the status
							if(isset($_GET['change_to_draft'])){
				
						 	    if(is_admin()){//Only logged in Admin users can edit code
								
								   $the_post_id = escape($_GET['change_to_draft']);
		                           $stmt = mysqli_prepare($connection, "UPDATE posts SET post_status = 'draft' WHERE post_id = ?");
	                       	       mysqli_stmt_bind_param($stmt,'i', $the_post_id);
								   mysqli_stmt_execute($stmt);
								   mysqli_stmt_close($stmt);//Close statment connection 
		 
								   header("Location: posts.php");//Refresh the page - the page needs to be refreshed for the delete to work
								
							      
							    }
							}
		 

							//Reset posts views
							if(isset($_GET['reset'])){
								
								if(isset($_SESSION['user_role']) && !empty($_SESSION)){//Only logged in Admin user can edit code
										 
							    if(is_admin()){//Only logged in Admin user can edit code
								
		 
									 $the_post_id = escape($_GET['reset']);
									 $stmt = mysqli_prepare($connection, "UPDATE posts SET post_view_count  = 0  WHERE post_id = ? ");
									 mysqli_stmt_bind_param($stmt,'i',$the_post_id);
									 mysqli_stmt_execute($stmt);
								     mysqli_stmt_close($stmt);//Close statment connection 
									
								 }	 
							  }
							}		


							
							//Delete post function
							if(isset($_GET['delete']) && !empty($_SESSION)){//If user has sent the delete parameter useing the delete buttons
								
								if(is_admin()){//Only logged in Admin users can edit code
										 								 										 	 
									$the_post_id = escape($_GET['delete']);
									$comment_number = escape($_GET['comment_number']);
									 
									    "<br>". $the_comment_number = escape($_GET['comment_number']);
									  
								        //Delete blog post and all the tables that use blog post as a foreign key
										$stmt = mysqli_prepare($connection, "DELETE 
										posts,
										comment,		
										posts_videos,
										posts_external_links
										FROM posts
										LEFT JOIN `comment` ON posts.post_id = `comment`.`comment_post_id`
										LEFT  JOIN `posts_videos` ON posts.post_id = `posts_videos`.`post_id`
										LEFT  JOIN user_video_watched ON `user_video_watched`.`post_video_id` = `posts_videos`.`posts_video_id`	
										LEFT  JOIN `posts_external_links` ON posts.post_id = `posts_external_links`.`posts_id`
										LEFT  JOIN user_websites_visited ON `user_websites_visited`.`link_id` =  `posts_external_links`.`posts_external_links_id`
										WHERE posts.post_id  = ? 
										
										");
											
										mysqli_stmt_bind_param($stmt,'i',$the_post_id);
										mysqli_stmt_execute($stmt);
										mysqli_stmt_close($stmt);//Close statment connection 
										
									    header("Location:posts.php");//Refresh the page - the page needs to be refreshed for the delete to work   
									 
									 
									 
									

								}
							 }

							?>
							

							<script> //Code used to make the delete function message box delete a post
							
	
								$(document).ready(function(){
						
								 $(".delete_link").on('click',function(){
							
									var id = $(this).attr("rel");
									var comment_number = $(this).attr('comment_number');//Number of comments on post - used to delete all the comments on the post
								    
									var delete_url = "posts.php?delete="+ id +
									"&comment_number="+ comment_number; //Used to run the delete query for the post		
										
									//Input the result in the delete model message
									$(".modal_delete_link").attr("href",delete_url);
									
								    $('#myModal').modal('show')
								
								
								 });
					 
							});//End of document.ready
							
				
							</script>
