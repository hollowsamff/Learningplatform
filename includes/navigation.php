
<!-- Navigation bar
  
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability: https://codepen.io/hollowsamff/pen/PjxMvQ
*/
 -->
  
    <nav class="navbar navbar-inverse navbar-fixed-top" >

        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
				</button> 
			<a class= "navbar-brand " href='index.php'>Home</a>
		
			</div>	
			
    	   <!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php
						$registration_class = '';//Used for static links
						$index_class = '';//Used for static links							
						$page_name = basename($_SERVER['PHP_SELF']);//Find name of current page
						$registration = 'registration.php'; //Names of static links
						$index = 'index.php'; //Names of static links					
					?>
					  <li><a style="color:white;" href ="aboutus.php">About us</a></li> 
					   <li><a style="color:white;" href ="registration.php">Register</a></li> 
			
						 
					 <?php //If user is logged in show link to the currently showing post page in navigation bar 
					 if(isset($_SESSION['user_id'])){	
                          
							 if($_SESSION['user_role'] == "admin") {
							 
							  ?>
							     <li><a style="color:white;" href ="admin/index.php">Website CMS</a></li> 					 
                              <?php
							 }else{
							  if($_SESSION['completed_Pre_Study_Questionnaire'] == "0"){			
							  ?>
								<li><a style="color:white;" href ="preusertest.php">Pre-study questionnaire</a></li> 
							   <?php
							   }
							 }
								 
						?>
                  	 
					   <li><a style="color:white;" href ="blog.php">Blog</a></li> 
					   <li><a style="color:white;" href ="leaderboard.php">Leaderboard</a></li> 
					   <li><a style="color:white;" href ="databasephp/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
						
					  <?php
					  }
					  ?>					
					
				</ul>
		      </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<!--Code used to change the color of the active webpage-->
<style>
nav a.current {
  background-color:#3CB371;
}
</style>

<script>
$(function(){
  $('a').each(function() {
    if ($(this).prop('href') == window.location.href) {
      $(this).addClass('current');
  }
  });
});
</script>