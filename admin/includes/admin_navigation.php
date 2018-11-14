<!--Fix error when link color is not changing in Chrome web browswer-->
<style>
.navbar-inverse .navbar-nav>li>a {
    color: #ffffff!important;
}
.navbar-inverse .navbar-brand {
     color: #ffffff!important;
}
.top-nav>li>a {
    color: #ffffff!important;
}
.side-nav>li>ul>li>a {
   color: #ffffff!important;
}
</style>
<!-- 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/-->

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->

			<div class="navbar-header">
			
		
							 
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
				
            </div>
			
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

			
				 
			 <li><a href="../index.php">Home Page</a></li>	
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  
					<?php 
					
					if(isset($_SESSION['user_name'])){
					
					echo $_SESSION['user_name'];
					
					}
					
					?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="../databasephp/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>	
                    </ul>
                </li>
            </ul>
			
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					
					<li>
                        <a href="./index_CMS.php"><i class="fa fa-fw fa-dashboard"></i> Index page CMS</a>
                    </li>
					
					<li>
                        <a href="./about_us_CMS.php"><i class="fa fa-fw fa-dashboard"></i>About Us page CMS</a>
                    </li>
					
					<li>
                        <a href="./user_data.php"><i class="fa fa-fw fa-dashboard"></i>Website User data CMS</a>
                    </li>
					<li>
                        <a href="./quiz_cms.php"><i class="fa fa-fw fa-dashboard"></i>Create blog quiz CMS</a>
                    </li>
					
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Blog Posts CMS<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php">View All Posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post">Add Posts</a>
					
								
                            </li>
                        </ul>
                    </li>

                    <li> <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i>Blog Category's CMS</a></li>
                    <li class="">
                        <a href="comments.php"><i class="fa fa-fw fa-file"></i>Blog Post's Comments CMS</a>
                    </li>
                      <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#comments_dropdown"><i class="fa fa-fw fa-arrows-v"></i>User Accounts CMS<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="comments_dropdown" class="collapse">
                            <li>
                                <a href="./users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_users">Add Users</a>
                            </li>
                        </ul>
                    </li>
					<li>
                        <a href="profile.php"><i class="fa fa-fw  fa-user"></i>Profile CMS</a>
					
                    </li>
		
                </ul>
            </div>
            <!-- /.navbar-collapse -->
			
        </nav>	
		
		
		<?php
		?>
		
		