<?php 
//Page show the indivigual pages for all of the blogs entrys 
include"databasephp/db.php";
//Page header include
include"includes/header.php";
//Page navigation bar include
include"includes/navigation.php";
//If the function that tests if a user is admin sents back false
if(!is_logged_in()){
	
	header("Location: index.php");
}

/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/

?>

<style>

  .containerImage {
	  width: 300px;
	}
  img {
	   margin: auto;
	}

  video {
    width: 40% !important;
    height: auto !important;
  }

  @media only screen and (max-width : 760px) {
    video {
      width: 100% !important;
      height: auto !important;
    }
  }
</style>
<!-- Page Content -->
<div class="container-fluid">

  <div class="row">
    <?php 
		//Put the id that was sent from the index page in a variable
		if(isset($_GET['p_id'])){
			
			$the_post_id = escape($_GET['p_id']);
			
			//Store the values from posts fields from database post table in varables
			$stmt = mysqli_prepare($connection,"SELECT
			posts.post_id		
			FROM posts 
			WHERE posts.post_id = $the_post_id AND post_status = 'published'
			ORDER BY posts.post_date DESC ");//Select the  post with the same id as was sent from the index page		
			
			mysqli_stmt_execute($stmt);	
			$stmt->bind_result(
			$post_id
			);							
			mysqli_stmt_store_result($stmt);//Store result 
			$count = mysqli_stmt_num_rows($stmt);		
			if($count < 1){//When no post was found
						
				echo "<h1 class='text-center'>No posts found</h1>";
				mysqli_stmt_close($stmt);
		
		   }else{

				while($stmt->fetch()){//Show post with the same id as was sent from the index page
					
					$post_id = escape($post_id);//$row is row from database				
	?>

				<!-- First Blog Post -->
				<h2 id="postTitel"></h2>
				<p>
				<span class="glyphicon glyphicon-time"></span> Posted on
				  <span id ="postDate"> </span>
				  by
				  <span id ="postAuthor"> </span>
				</p>
				
				<img class="img-responsive containerImage" width="auto" id ="postImage" src="" alt="Post image">

				<hr style=" border-color:#3CB371;">
				<p id="postContent">
				</p>
                <div id ="postVideo"></div>
<script>
	
  var postId = '<?php echo $the_post_id; ?>';
 // alert(postId);
 
  var getUserPostData = "getUserPostData";

	jQuery.ajax({
			url: 'databasephp/postphpcode.php',
			dataType: "json",
			type: "post",
			data: {getUserPostData:getUserPostData, postId:postId},		
			 
			 success: function(response){
			  $(document).ready(function() { 		
					 //alert("Data added to database");	

					 $("#postTitel").html(response["post_title"]);
					 $("#postAuthor").html(response["post_author"]);
					 $("#postDate").html(response["post_date"]);
					 $("#postContent").html(response["post_content"]);
					 
					 if (response["post_image"] != ""){
					     $("#postImage").attr("src","images/"+response["post_image"]+"");
					 }else{
						 $("#postImage").attr("src",""); 
					 }
					 
					 if (response["post_external_links_string"] != ""){
				         $("#postExternalLinks").html(response["post_external_links_string"]);
				     } 
					
					 
					 
				 var postHasVideo = response["post_has_video"];
					 
				 if(postHasVideo == 1){	//If post has video show vidoe then quizz
					
					$("#postVideo").html(response["video_string"]);
		
					document.getElementById('myVideo').addEventListener('ended', myHandler, false);
					  function myHandler(e) {//Load quiz when video ends
						$.ajax({
						  type: 'POST',
						  data: {
							the_post_id: <?php echo $the_post_id;?>
						  },
						  url: 'includes/blogquiz.php',
						  success: function(data) {
							$("#quiz").html(data);
							document.getElementById("quiz").scrollIntoView();//Scroll to quiz
						  }
						});
						
						$.ajax({ //Update the number of times a user has watched the video	
						  type: 'post',
						  url: "databasephp/postphpcode.php",
						  data: {
							the_post_id: <?php echo $the_post_id;?>
						  },
						  success: function(response) {
						  }
						});
					  }				
				 }else{//When the page has no video show the quizzes when the page loads
		
					  $.ajax({
						type: 'POST',
						data: {
						  the_post_id: <?php echo $the_post_id;?>
						},
						url: 'includes/blogquiz.php',
						success: function(data) {
						  console.log(data);
						  if (data != null) {
							$("#quiz").html(data);
						  }
						}
					  });
				 }	 
              });  
		   },
             error: function(){
             alert("failure");
        }
		});	
    </script>
			  		
				
		    <div id="postExternalLinks"></div>
			
				
				<div id="quiz"></div>
				<div id="length"></div>
				<div id="podcast"></div>
				<?php
				
				 }
				 
				 mysqli_stmt_close($stmt);
			  ?>		  
			 <?php
			if(isset($_POST['create_comment'])){
				
				$the_post_id = escape($_GET['p_id']);			
			  
				$comment_content  = escape($_POST["comment_content"] );
				$comment_status= "approved";

				$date = date('Y-m-d H:i:s');//Database uses American format so it needs to be converted to American  or it will not work
				//Associative arrays replace the index with a lable - this is called a key
				$error = [ "content" => "" ];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
						
				if($comment_content  == ''){

				   $error['comment'] = 'Comment cannot be empty';
				}		
				
				foreach ($error  as $key => $value) { // Used to test for and show error messages 
						
						if (empty($value)){
							
							unset($error[$key]);//Remove old values out of empty fields
						  }
						}	
				if(empty($error)){ //When no errors are found input comment
						
					$stmt= mysqli_prepare($connection,"INSERT INTO 
					comment(comment_post_id, comment_author, comment_content, comment_status, comment_date) 
					VALUE(?,?,?,?,?)");
					mysqli_stmt_bind_param($stmt,'issss' , $the_post_id, $_SESSION["user_name"],  $comment_content, $comment_status,$date);
					mysqli_stmt_execute($stmt);
					$comment_email="";
					$comment_author="";
					echo"<h4 class = 'text-center'>Comment submited</h4>";
					mysqli_stmt_close($stmt);//Close statmentute($stmt);
					//header("Refresh:0");
				}
			}
			?>
				  <!-- Contact Form -->
				  <div class="well">
					<h5>Leave a comment if you felt the material was helpful or if there are any improvements you feel could be made to the website</h5>
					<form action="" method="post" role="form">

					  <div class="form-group">
						<textarea name="comment_content" class="form-control" rows="3"></textarea>

						<h4 class="warning_red">
						  <?php echo isset($error['comment']) ? $error['comment'] : '' ?>
						</h4>
					  </div>
					  <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
					</form>
				  </div>
				  <hr style=" border-color:#3CB371;">

				  <!-- Posted Comments -->
			  <?php
			 
			 $query ="SELECT comment_date, comment_content, comment_author  FROM comment WHERE comment_post_id = $the_post_id 
			 AND comment_status = 'approved' ORDER BY comment_id DESC ";	 
			 $select_comments = mysqli_query($connection,$query);
			 $comentcount = 1;
			 //Show all the fields from the posts categories table 
			 while($row = mysqli_fetch_assoc($select_comments)){

					//Varables = the the values from the database
					$comment_author = $row['comment_author'];
					$comment_content = $row['comment_content'];
					$comment_date = $row['comment_date'];
					$comment_content = str_replace('\r\n','</br>',$comment_content);
			 ?>
					<!--Show  comment -->
					<div class="media">
					  <a class="pull-left" href="#">
							
						</a>
					  <div class="media-body">
						<table class="table table-bordered table-hover">
						  <thead style="background-color:white; border-color: red;">

							<p class="media-heading">
							  <?php 
				
							echo"$comment_content";
							echo "<p><span class='glyphicon glyphicon-time'></span> Posted on ". $comment_date = date('d-m-Y',strtotime(escape($comment_date)))." by ".$comment_author; ?>
							 </small>
							</p>
							</p>
							<hr>
						</table>
					  </div>
					  <hr style=" border-color:#3CB371;">
					</div>
			<?php 
			}
	   } 
	}
	else{		
	 header("Location: index.php");	
	} ?>

  </div>
</div>
<!-- /.row -->


<script>	  
$(document).ready(function() { 
   
   $(document ).on( "click", ".externalLink", function () {//Record number of time user click on external page links

      $.ajax({
        type: 'post',
        url: "databasephp/postphpcode.php",
        data: {
          externalLinkId: $(this).attr("id")
        },
        success: function(response) {}
      });
    });
	
  });
</script>
<br>

<?php include"includes/footer.php";//Page footer include ?>