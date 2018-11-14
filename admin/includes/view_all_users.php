<!--Page is used  to show all the users on the users.php page(is an include) -->
<!--
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/				
-->
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
	 
	 case 'admin':// Change the status of selected posts to published
	 case 'notadmin': // Change the status of selected posts to draft
	 
		 $stmt = mysqli_prepare($connection,"UPDATE users SET user_role  = ?  WHERE user_id = ? ");
		 mysqli_stmt_bind_param($stmt,'si',$bulk_options, $check_boxes_values );
		 mysqli_stmt_execute($stmt);

	
		 mysqli_stmt_close($stmt);//Close statment
		 

	 break;

	 case 'delete': // Delete selected posts

	 //Stop user deleting thier own account
	 if ($check_boxes_values == $_SESSION['user_id']){

		?>
		
		<script>
									
			alert('You can not delete the logged in user!') ? "" : window.location = 'users.php';
			
		 </script>

		<?php

		 break;
	   
	 }

		   $stmt = mysqli_prepare($connection,"
		   DELETE
		   from users_online_time 
		   where users_online_time.user_id = ?
		   ");
		   mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
		   mysqli_stmt_execute($stmt);					
		   mysqli_stmt_close($stmt);//Close statment


		   $stmt = mysqli_prepare($connection,"
		   DELETE
		   from user_quiz_score
		   where user_quiz_score.user_id = ?
		   ");
		   
		   mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
		   mysqli_stmt_execute($stmt);					
		   mysqli_stmt_close($stmt);//Close statment
		   
		   $stmt = mysqli_prepare($connection,"
		   DELETE
		   from user_video_watched
		   where user_video_watched.user_id = ?;
		   ");
		   mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
		   mysqli_stmt_execute($stmt);					
		   mysqli_stmt_close($stmt);//Close statment
		   
		   $stmt = mysqli_prepare($connection,"
		   DELETE
		   from user_websites_visited
		   where user_websites_visited.user_id = ?;
		   ");
		   mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
		   mysqli_stmt_execute($stmt);					
		   mysqli_stmt_close($stmt);//Close statment
		   
		   
		   $stmt = mysqli_prepare($connection,"
		   DELETE
		   from  pre_study_questionnaire_results
		   where   pre_study_questionnaire_results.user_id = ?;
		   ");
			mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
		   mysqli_stmt_execute($stmt);					
		   mysqli_stmt_close($stmt);//Close statment


	 $stmt = mysqli_prepare($connection, "Delete FROM users WHERE user_id  = ? ");
	 mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
	 mysqli_stmt_execute($stmt);
	 mysqli_stmt_close($stmt);//Close statment connection 
	
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
											<option value="admin">admin</option>
											<option value="notadmin">notadmin</option>
											<option value="delete">Delete</option>
									   </select>
							      </div>
								  <div class = "col-xs-4">
									<input type = "submit" name = "submit" id ="test" rel='1' class = "btn btn-success" value ="Apply">
									<a class = "btn btn-primary" href="users.php?source=add_users"> Add New </a>
                                   </div>		
								
								<table class ="table table-bordered table-hover">
								<thead style="background-color:white;">	
								<tr>
								    <td><input  id = "select_All_Boxes" type ="checkbox"></td>
								
								    <td>Username</td>
									<td>Firstname</td>
									<td>Lastname</td>
									<td>Email</td>
									<td>DOB</td>
									<td>Role</td>
								    <td>Role Select</td>
									<td>Edit</td>
                                    <td>Delete</td>	
									
								</tr>
							</thead>
						
						    <tbody style="background-color:white;">
								<?php
								//Find all the posts from database post table
								 $stmt = mysqli_prepare($connection,"SELECT user_id , user_name ,user_password,user_first_name,user_last_name,
								  user_email, user_role,user_DOB FROM users");

	                             if($stmt->execute()){
		
	                             //Bind these variable to the SQL results
	                              $stmt->bind_result($user_id , $user_name ,$user_password,$user_first_name,$user_last_name,
								  $user_email, $user_role,$user_DOB);
								  
								 }
	                               //Fetch will return all fow, so while will loop until reaches the end
								   //Show all the fields from the posts categories table 
	                              while($stmt->fetch()){
	
									//Varables = the the values from the database
									$user_id = escape($user_id );
								    $user_name = escape($user_name);
		                            $user_password = escape($user_password);
									$user_first_name = escape($user_first_name);
									$user_last_name = escape($user_last_name);
									$user_email = escape($user_email);
									$user_role = escape($user_role);	
									$user_DOB = escape($user_DOB);
									$user_DOB = date('d-m-Y',strtotime(escape($user_DOB)));//Convert date to English fromat
									echo"<tr>";
									    ?>
										   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $user_id;?>'></td>
										
										<?php //Stores the ids of the selected boxes in an array
										
										echo"<td>$user_name</td>";
										echo"<td>$user_first_name</td>";
										echo"<td>$user_last_name</td>";
										echo"<td>$user_email</td>";
			
										if (!empty ($user_DOB)){
											
										echo"<td>$user_DOB</td>";	

										}
										echo"<td>$user_role</td>";
							    		echo"<td><a class='btn btn-info' style = margin:1px; href='users.php?change_to_admin={$user_id}'>admin</a>";//Used to approve a comment
									    echo"<a class='btn btn-info'    href='users.php?change_to_subscriber={$user_id}'>notadmin </a></td>";//Used to unapprove a comment
									    echo"<td><a class='btn btn-info' href='users.php?source=edit_users&user_id={$user_id}'>Edit </a></td>";//Send the id of the selected user to the edit users page
                                        //Delete works using the delete_link class
                                        echo"<td><a class=' btn btn-danger delete_link' rel='$user_id' rel ={$user_id} href='javascript:void(0)'>Delete</a> </td>";
								        echo"</tr>";
							    }
								
								mysqli_stmt_close($stmt);//Close statment connection 
								?>
							</tbody>
							</table>
							</form>
							
						
							<?Php

							//Delete user function
							if(isset($_GET['delete']) && !empty($_SESSION)){//If user has sent the delete parameter useing the delete buttons
								
									 //Stop query string hack
									if(is_admin()){//Only logged in Admin users can edit code

								       $the_user_id = escape($_GET['delete']);
									   //Stop user deleting thier own account
									   if ($the_user_id == $_SESSION['user_id']){
					
	                                        ?>
							                <script>
																	
								             ///    alert('You can not delete the logged in user!') ? "" : window.location = 'users.php';
									 
								            </script>
								            <?php
						
										    return;
									   }
									  									   
									   $stmt = mysqli_prepare($connection,"
                                       DELETE
									   from users_online_time 
									   where users_online_time.user_id = ?;
									   ");
									   mysqli_stmt_bind_param($stmt,'i', $the_user_id);
									   mysqli_stmt_execute($stmt);					
									   mysqli_stmt_close($stmt);//Close statment
									   
								
									   $stmt = mysqli_prepare($connection,"
                                       DELETE
									   from user_quiz_score
									   where user_quiz_score.user_id = ?;
									   ");
									   mysqli_stmt_bind_param($stmt,'i', $the_user_id);
									   mysqli_stmt_execute($stmt);					
									   mysqli_stmt_close($stmt);//Close statment
									   
									   $stmt = mysqli_prepare($connection,"
                                       DELETE
									   from user_video_watched
									   where user_video_watched.user_id = ?;
									   ");
									   mysqli_stmt_bind_param($stmt,'i', $the_user_id);
									   mysqli_stmt_execute($stmt);					
									   mysqli_stmt_close($stmt);//Close statment
									   
									   $stmt = mysqli_prepare($connection,"
                                       DELETE
									   from user_websites_visited
									   where user_websites_visited.user_id = ?;
									   ");
									   mysqli_stmt_bind_param($stmt,'i', $the_user_id);
									   mysqli_stmt_execute($stmt);					
									   mysqli_stmt_close($stmt);//Close statment

									
									   $stmt = mysqli_prepare($connection,"
                                       DELETE
									   from  pre_study_questionnaire_results
									   where   pre_study_questionnaire_results.user_id = ?;
									   ");
									   mysqli_stmt_bind_param($stmt,'i', $the_user_id);
									   mysqli_stmt_execute($stmt);					
									   mysqli_stmt_close($stmt);//Close statment
									   
									   ///////////////////////////////////////////////
									   
									   $stmt = mysqli_prepare($connection,"
                                       DELETE
									   from users
									   where user_id = ?;
									   ");
									   mysqli_stmt_bind_param($stmt,'i', $the_user_id);
									   mysqli_stmt_execute($stmt);					
									   mysqli_stmt_close($stmt);//Close statment
									   
                                       header("Location:users.php");//Refresh the page - the page needs to be refreshed for the delete to work
									 }
									
							    }
							
						
							//Used to change the users role
							if(isset($_GET['change_to_admin'])){
				
						 	    if(is_admin()){//Only logged in Admin users can edit code
								
								   $the_user_id = escape($_GET['change_to_admin']);
		                           $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = 'admin' WHERE user_id = ?");
	                       	       mysqli_stmt_bind_param($stmt,'i', $the_user_id);
								   mysqli_stmt_execute($stmt);
								   mysqli_stmt_close($stmt);//Close statment connection 
		 
								   header("Location: users.php");//Refresh the page - the page needs to be refreshed for the delete to work
								
							      
							    }
							}
							 
							 
							//Used to change the users role
							if(isset($_GET['change_to_subscriber'])){
				
						 	    if(is_admin()){//Only logged in Admin users can edit code
								
								   $the_user_id = escape($_GET['change_to_subscriber']);
		                           $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = 'notadmin' WHERE user_id = ?");
	                       	       mysqli_stmt_bind_param($stmt,'i', $the_user_id);
								   mysqli_stmt_execute($stmt);
								   mysqli_stmt_close($stmt);//Close statment connection 
		 
								   header("Location: users.php");//Refresh the page - the page needs to be refreshed for the delete to work

							    }
							}

							?>
							
							
							<script> //Code used to make the delete function message box delete a post
							
	
						    $(document).ready(function(){
							   
							   
							 $(".delete_link").on('click',function(){
									
									var id = $(this).attr("rel");
				
									var delete_url = "users.php?delete="+ id; //Used to run the delete query for the post		
										
									//Input the result in the delete model message
									$(".modal_delete_link").attr("href",delete_url);
									
								    $('#myModal').modal('show')
								
								
								 });
					 
							});//End of document.ready
							
							</script>