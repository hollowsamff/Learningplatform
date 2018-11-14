<?php //Page header include  page is used to show, delete and add categories from the database - page use case to show differnt content from includes
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
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
					
					    <h1 class="page-header text-center">Posts CMS</h1>
					
					<?php
					
					
					if(isset($_GET['source'])){
						
						$source = $_GET['source'];
						
					}else{
						
						$source = ' ';
					}
				
					switch($source){
						
						case 'add_post';
						
							include "includes/add_post.php";//Load page that is used to add new posts
							
						break;
						
						
						case 'edit_posts';
						
							include "includes/edit_posts.php";//Load page that is used to edit posts
							
						break;
							
						default:
						
						include "includes/view_all_posts.php";//Show all the posts on the page
					
						break;
						
					}
									
					
					?>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>	
	</div>
<?php include"includes/admin_footer.php";//Page footer include ?>