<?php //Page header include  page is used to login to the sites CMS - page use case to show differnt content from includes
include"includes/admin_header.php";
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/	
?>
    <div id="wrapper">

	
	
	 <!-- Navigation -->
	 <?php include"includes/admin_navigation.php";//Page navigation include ?>
	
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
				
                    <div class="col-lg-12">
					
					    <h1 class="page-header text-center">User Accounts CMS</h1>
					
					
					<?php

					if(isset($_GET['source'])){
						
						$source = $_GET['source'];
						
					}else{
						
						$source = ' ';
					}
				
					switch($source){
						
						case 'add_users';
						
							include "includes/add_users.php";//Load page that is used to add new users
							
						break;
						
						
						case 'edit_users';
						
							include "includes/edit_users.php";//Load page that is used to edit users
							
						break;
							
						default:
						
						include "includes/view_all_users.php";//Show all the users from database
					
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