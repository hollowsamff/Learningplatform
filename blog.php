<?php
include"databasephp/db.php";
include"includes/header.php";
include"includes/navigation.php";

/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/


if(!is_logged_in()){	
	header("Location: index.php");//Only profile user can only acess the profile.php page 
}

?>
<style>
img {
  margin: auto;  
}	
.containerImage {
  width: 300px;
}
	
</style> 
 <div class="container-fluid">	
		<!-- Blog Entries Column -->	
		<div class="col-md-8">
		<?php 
		
		$per_page = 5 ;//Number of posts on one page
		$contentlengh = 500; // Define how many character that will apear from content.
		
		if(isset($_GET['page'])){//Find value of the pagination loaded page
			
		   $page =  escape($_GET['page']);
			
		}else{
			$page = "";
		}
		
		if($page == "" || $page == 1){ //The page is the home page
			
			$page_1 = 0;
			
		}else{ //When the user is on a diffent page e.g 2
			$page_1 = ($page * $per_page ) - $per_page;//Value is the same as the limit of post being shown
		}
		
		
		//Filter the posts by the post categories 
		if(isset($_GET['name']) && isset($_GET['category'])){
			 
			$post_category_id  = escape($_GET['category']); 		
			$the_category_name = escape($_GET['name']);
			echo "<h1 class='page-header  text-center'> ". $the_category_name."</h1>";
			
			$stmt = mysqli_prepare($connection, "SELECT post_id FROM posts WHERE post_category_id = ? AND post_status = 'published' ");	        
			mysqli_stmt_bind_param($stmt,"i",$post_category_id);
			
		}else{
			
		   $stmt = mysqli_prepare($connection, "SELECT post_id FROM posts WHERE post_status = 'published'");
		}
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);//Store result 
		$count = mysqli_stmt_num_rows($stmt);//Find number of posts
		mysqli_stmt_close($stmt);
	
		if($count < 1 ){
			
		  echo "<h1 class='text-center'>No posts found</h1>";
		  echo"<hr>";
			
		}else{
			
		$count = ceil($count / $per_page);//Used with pagniation	
		
	    if(isset($_GET['name']) && isset($_GET['category'])){
				
			$stmt = mysqli_prepare($connection, "SELECT
			posts.post_id, 
			posts.post_title,
			posts.post_author,
			posts.post_date,
			posts.post_content,
			posts.post_image,
			posts.post_category_id,
            users.user_name			
			FROM posts 	
			INNER JOIN users
			on users.user_id = posts.post_author
			WHERE post_category_id = ? AND post_status = 'published'
			ORDER BY posts.post_date DESC LIMIT $page_1, $per_page");
			mysqli_stmt_bind_param($stmt,"i",$post_category_id);
		   
	    }else{
		 
			$stmt = mysqli_prepare($connection, "SELECT
			posts.post_id, 
			posts.post_title,
			posts.post_author,
			posts.post_date,
			posts.post_content,
			posts.post_image,
			posts.post_category_id,
            users.user_name			
			FROM posts 	
			INNER JOIN users 
			on users.user_id = posts.post_author
			WHERE  post_status = 'published'
			ORDER BY posts.post_date DESC LIMIT $page_1, $per_page");
	    }
		mysqli_stmt_execute($stmt);

		//Store result 
		mysqli_stmt_bind_result($stmt, $post_id, $post_title, $post_author, $post_date, $post_content,$post_image ,$post_category_id,$user_name);
		
		while($stmt->fetch()){
				
			$post_content= substr($post_content,0, $contentlengh);				
		    ?>
		
		    <!-- <h1 class="page-header"></h1>-->
			<!-- First Blog Post -->
			<h2><a href ="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a></h2>

			<p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date= date('d-m-Y',strtotime(escape( $post_date))) ?>
			 by <?php echo $user_name ?>		
			<!--<a href="author_posts.php?author=<?php echo $post_author ?>& p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a> in-->
			</p>
			<hr>			
			<a href ="post.php?p_id=<?php echo $post_id ?>">
			<img class="img-responsive containerImage" height="42"  src="images/<?Php echo $post_image;?>" alt="post image"><!-- $post_image contains a referance(the name) of the image from the database -->
			</a>
							
			<hr>
			<?php 
			//Remove spacing charecters from database string
			$post_content =  str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;")," <br> ",$post_content);		
			echo stripslashes($post_content);
			?>
			<br>
			<hr>
			<a class="btn btn-primary" href ="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
			<hr style="border-color:#3CB371;">

		<?php } 
		
		mysqli_stmt_close($stmt);
		
		}
		?>
			
		</div>			
		
		<!-- Blog Sidebar Widgets Column include-->
		<?php include "includes/sidebar.php"?>
  </div>
	<!-- /.row -->

  <ul class = "pager">
  <hr>
	<?php
	for($i = 1; $i <= $count; $i++){//Links to differnt pagination pages(only show limited number of posts on page

		if($i == $page){//Make the link to the page the user is on be a differnt color
		
		  if(isset($_GET['name']) && isset($_GET['category'])){			 
			 echo "<li><a style='background-color:lightgray' href='blog.php?page={$i}&category=$post_category_id&name=$the_category_name'>{$i}</a></li>"; 			
		  }else{			  
			 echo "<li><a style='background-color:lightgray' href='blog.php?page={$i}'>{$i}</a></li>"; 
		  }
		
		}else{
			
		  if(isset($_GET['name']) && isset($_GET['category'])){		  
			 echo "<li><a  href='blog.php?page={$i}&category=$post_category_id&name=$the_category_name'>{$i}</a></li>"; 
		  }else{
			 echo "<li><a  href='blog.php?page={$i}'>{$i}</a></li>";  
		  }
		  
		}				
	}
	?>
 </ul>
 <br>
			
<?php include"includes/footer.php";//Page footer include ?>