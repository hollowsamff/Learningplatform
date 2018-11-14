<?php //Page header include  page is used to login to the sites CMS - page use case to show differnt content from includes
include"includes/admin_header.php";

?>
    <div id="wrapper">
	
	 <!-- Navigation -->
	 <?php include"includes/admin_navigation.php";//Page navigation include ?>
	
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
				
                    <div class="col-lg-12">
					
					    <h1 class="page-header text-center">Comments CMS</h1>
					<!--Page is used  to show all the comments on the comments.php page(is an include) -->
					
					<?php  //Code is used to change multiple posts status and delete multiple posts 
												 
					include("includes/delete_modal.php");
					
				    //!empty($_SESSION stops query runing when page reloads
					if(isset($_POST['check_box_array']) ){ 
                     
					//Store all the send values from the tick boxes in array(the ids of the selected posts)
					foreach($_POST['check_box_array'] as $check_boxes_values  ){
						
				     $check_boxes_values = escape($check_boxes_values);
						
				     //Value is the selected option from the bulk_options select
					 $bulk_options = escape($_POST['bulk_options']);
					 			
					 //Case what option was selected 
					 switch($bulk_options){
						 
						 case 'approve':// Change the status of selected posts to published
                         case 'unapprove': // Change the status of selected posts to draft
						 
							 $stmt = mysqli_prepare($connection,"UPDATE comment SET comment_status  = ?  WHERE comment_id = ? ");
							 mysqli_stmt_bind_param($stmt,'si',$bulk_options, $check_boxes_values );
							 mysqli_stmt_execute($stmt);

							 if(!$stmt){//Test if the query fails
					
							   die("Query error test")."<br>". mysqli_error($stmt);
							 }	  
					  
							 mysqli_stmt_close($stmt);//Close statment
							 

						 break;

						 case 'delete': // Delete selected posts

		
								 $stmt = mysqli_prepare($connection, "Delete FROM comment WHERE comment_id  = ? ");
								 mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
								 mysqli_stmt_execute($stmt);
								 mysqli_stmt_close($stmt);//Close statment connection 

						  break;

					     } //Close switch
				
					}
					
				 }
				
					
				?>

					<form method ="post" multiple="multiple" method="post" enctype="multipart/form-data">
					  <div class = "form-group">
							<select class ="form-control" name = "bulk_options" id= "select">	
								<option value="" >Select Option</option>
								<option value="approve" >Approve</option>
								<option value="unapprove" >Unapprove</option>
								<option value="delete" >Delete</option>
						   </select>
					  </div>
					    <div class = "form-group">
							<input type = "submit" name = "submit" id ="test" rel='1' class = "btn btn-success" value ="Apply">
					 </div>
					</form>
					<table class ="table table-bordered table-hover">	
                           <thead>
						   <tr>					
								<td><input  id = "select_All_Boxes" type ="checkbox"></td>
								<td>Author</td>
								<td>Comment</td>
								<td>Status</td>
								<td>In Responce To</td>
								<td>Date</td>
								<td>Change Status</td>
								<td>Delete</td>									
							</tr>
						</thead>
						<tbody style="background-color:white;">
								<?php
								//Find all the posts from database post table
								$query ="SELECT * FROM  comment ORDER BY comment_id ASC ";
								$select_comments = mysqli_query($connection,$query);
								
								//Show all the fields from the posts categories table 
								while($row = mysqli_fetch_assoc($select_comments)){
									//Varables = the the values from the database
									$comment_id = $row['comment_id'];
								    $comment_post_id = $row['comment_post_id'];
		                            $comment_author = $row['comment_author'];
							
		                            $comment_content = $row['comment_content'];
									$comment_status = $row['comment_status'];
									$comment_date = $row['comment_date'];
									$comment_date  = date("d-m-Y", strtotime($comment_date ));			
									
									 echo"<tr>";
									      ?>
										   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $comment_id;?>'></td>
										
										  <?php //Stores the ids of the selected boxes in an array
			
								
										echo"<td>$comment_author</td>";
								
									    $comment_content = str_replace('\r\n','</br>',$comment_content);
										echo"<td>$comment_content</td>";
								
								
										echo"<td>$comment_status</td>";
				
											$stmt2 = mysqli_prepare($connection,"SELECT post_id FROM posts WHERE post_id = ?");
											mysqli_stmt_bind_param($stmt2, 'i' , $comment_post_id);
											mysqli_stmt_execute($stmt2);
											if($stmt2->execute()){
												
											  //Bind these variable to the SQL results
											  $stmt2->bind_result($post_id);
											  //Fetch will return all fow, so while will loop until reaches the end
											  while($stmt2->fetch()){
											
														echo "<td><a href='../post.php?p_id=$post_id'>Post.$post_id </a></td>";//Link to the post that the comment was posted on
											  }								
																					
											}									
                                            mysqli_stmt_close($stmt2);

                                       $comment_date  = date("d-m-Y", strtotime($comment_date ));
									   echo"<td>$comment_date</td>";
									   
									   echo"<td><a class='btn btn-info' style = margin:1px; href='comments.php?approved={$comment_id}'>Approve</a>";//Used to approve a comment
									   echo"<a class='btn btn-info' href='comments.php?unapproved={$comment_id}'>unapproved </a></td>";//Used to unapprove a comment
									
									  //Delete works using the delete_link class
                                      ///echo"<td><a class=' btn btn-danger delete_link' rel='$comment_id' rel ={$comment_id} href='javascript:void(0)'>Delete</a> </td>";
									  echo"<td><a class=' btn btn-danger delete_link' rel='$comment_id' rel ={$comment_id} href='javascript:void(0)'>Delete</a></td>";
	
								   	echo"</tr>";
							    }
								?>
							</tbody>
						</table>
						
							<?Php

							//Delete comment function
							if(isset($_GET['delete']) && !empty($_SESSION)){//If user has sent the delete parameter useing the delete buttons
								
									 //Stop query string hack
									if(is_admin()){//Only logged in Admin users can edit code

								       $the_comment_id = escape($_GET['delete']);

									   $stmt = mysqli_prepare($connection,"Delete FROM comment WHERE comment_id = ?");
									   mysqli_stmt_bind_param($stmt,'i', $the_comment_id);
									   mysqli_stmt_execute($stmt);
					
									   mysqli_stmt_close($stmt);//Close statment

                                        header("Location: comments.php");//Refresh the page - the page needs to be refreshed for the delete to work
									 }
									
							    }
							
							//Unapprove comment function
							if(isset($_GET['unapproved'])){
				
						 	    if(is_admin()){//Only logged in Admin users can edit code
			
								   $the_comment_id = escape($_GET['unapproved']);
		                           $stmt = mysqli_prepare($connection, "UPDATE comment SET comment_status = 'unapproved' WHERE comment_id = ?");
	                       	       mysqli_stmt_bind_param($stmt,'i',$the_comment_id);
								   mysqli_stmt_execute($stmt);
								   mysqli_stmt_close($stmt);//Close statment connection 
		 
								   header("Location: comments.php");//Refresh the page - the page needs to be refreshed for the delete to work

							    }
							}
			
							
						    	//Approve comment function
							   	if(isset($_GET['approved'])){
				
						 	    if(is_admin()){//Only logged in Admin users can edit code
								
								   $the_comment_id = escape($_GET['approved']);
		                           $stmt = mysqli_prepare($connection, "UPDATE comment SET comment_status = 'approved' WHERE comment_id  = ?");
	                       	       mysqli_stmt_bind_param($stmt,'i',$the_comment_id);
								   mysqli_stmt_execute($stmt);
								   mysqli_stmt_close($stmt);//Close statment connection 
		 
								   header("Location: comments.php");//Refresh the page - the page needs to be refreshed for the delete to work

							    }
							}

							?>
							<script> //Code used to make the delete function message box delete a post
							
						    $(document).ready(function(){
							   
									
									$(".delete_link").on('click',function(){
									
									var id = $(this).attr("rel");
				
									var delete_url = "comments.php?delete="+ id; //Used to run the delete query for the post		
										
									//Input the result in the delete model message
									$(".modal_delete_link").attr("href",delete_url);
									
								    $('#myModal').modal('show')
								
								
								 });
					 
							});//End of document.ready
							</script>
				

                    </div>
                </div>
            </div>
        </div>	
	</div>	
<?php include"includes/admin_footer.php";//Page footer include ?>