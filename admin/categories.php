<?php //Page header include  page is used to show, delete and add categories from the database
include"includes/admin_header.php";

?>
<div id="wrapper">

  <!-- Navigation -->
  <?php 
	    include"includes/admin_navigation.php";//Page navigation include 	 
	 	include"includes/delete_modal.php";	 
	 ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">

        <div class="col-lg-12">
          <h1 class="page-header">
            Website Blog Categories CMS
          </h1>
          <div class="col-xs-6">
            <?php insert_categories();//Insert category function ?>

            <!-- Add category form-->
            <form action="" method="post">
              <div class="form-group">
                <label for="cat_title">Add Category</label>
                <input type="text" class="form-control" name="cat_title">
              </div>
              <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="Add category">
              </div>
            </form>

            <?php
			 //Update query  - used with insert category function
			 if(isset($_GET["edit"])){//Uses GET data from Current Categories edit button
			
			   include"includes/update_categories.php";//update_categories include
			 
			  }
			?>

          </div>
          <!--end col-xs-6 for current categories display-->

          <?php //Delete the categories from database categories table
			   if(isset($_GET['delete'])){//If user has sent the delete parameter useing the delete buttons delete the category if it is not being used by a post
			
						 $the_cat_id = escape($_GET['delete']);													 
						 $stmt = mysqli_prepare($connection,"
						 Delete 
						 FROM post_categories 
						 WHERE post_categories.cat_id = ?
						 AND 
						 post_categories.cat_id NOT IN (SELECT post_category_id FROM posts)
						 ");
						 mysqli_stmt_bind_param($stmt,'i', $the_cat_id);
						 mysqli_stmt_execute($stmt);
						 
						 mysqli_stmt_close($stmt);//Close statment
						 
						 //header("Location: categories.php");//Refresh the page - the page needs to be refreshed for the delete to work						    										 
				 }
          ?>

          <div class="col-xs-6">
            <h3>Website Blog Categories</h3>
            <p>(You cannot delete a category if it being used by a blog post)</p>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Category Title</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php
					   $stmt = mysqli_prepare($connection,"SELECT * FROM post_categories");

						if($stmt->execute()){
							
						  //Bind these variable to the SQL results
						  $stmt->bind_result($cat_id , $cat_title);
						  //Fetch will return all fow, so while will loop until reaches the end
						  while($stmt->fetch()){
							  
								echo"<tr>";
								
								echo "<td>{$cat_id}</td>";
								echo "<td>{$cat_title}</td>";
								
								echo "<td><a  class='btn btn-info' href='categories.php?edit={$cat_id}' > Edit </a></td>";//Edit button
								echo"<td><a class=' btn btn-danger delete_link' rel='$cat_id' href='javascript:void(0)' >Delete</a> </td>";
							
								//When the link is pressed assign the value in $cat_id to the parameter delete(will be used as index value in delete query)Then send the delete parameter to the delete query
								
								echo"</tr>";

						  }
						}	
				   ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
</div>  
<script>
    //Code used to make the delete function message box delete a post
    $(document).ready(function() {
      $(".delete_link").on('click', function() {
        var id = $(this).attr("rel");
        var delete_url = "categories.php?delete=" + id; //Used to run the delete query for the post		
        //Input the result in the delete model message
        $(".modal_delete_link").attr("href", delete_url);
        $('#myModal').modal('show');
      });
    }); //End of document.ready
</script>
  <?php include"includes/admin_footer.php";//Page footer include ?>

