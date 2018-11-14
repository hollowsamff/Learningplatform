<?php 
//Page header include
include"includes/admin_header.php";

?>
<div id="wrapper">
  <!-- Navigation -->
  <?php include"includes/admin_navigation.php";//Page navigation include ?>

  <div id="page-wrapper">

    <div class="container-fluid">
      <!-- Page Heading -->
      <header class="row">

        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome to your Content Managment System <small> <?php echo $_SESSION['user_first_name']." ".$_SESSION['user_last_name'];?> </small>
          </h1>
        </div>
        <h4>Download link for <a href="../downloadablefiles/User Manual.docx" download>website user manual</a></h4>

      </header>
  
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-file-text fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">

                  <!-- /.Number of posts in database - uses function from functions.php  -->
                  <div class='huge'>
                    <?php echo $posts_counts = record_count('posts');?> </div>

                  <div>Posts</div>
                </div>
              </div>
            </div>

            <a href="posts.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-green">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-comments fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">

                  <!-- /.Number of comments in database - uses function from functions.php  -->
                  <div class='huge'>
                    <?php  echo $comment_count = record_count('comment'); ?> </div>

                  <div>Comments</div>
                </div>
              </div>
            </div>
            <a href="comments.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-yellow">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-user fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">

                  <!-- /.Number of users in database - uses function from functions.php  -->
                  <div class='huge'>
                    <?php echo $user_count = record_count('users');?> </div>

                  <div> Users</div>
                </div>
              </div>
            </div>
            <a href="users.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="panel panel-red">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-list fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">

                  <!-- /.Number of categories in database - uses function from functions.php  -->
                  <div class='huge'>
                    <?php echo $categories_count = record_count('post_categories');?> </div>

                  <div>Categories</div>
                </div>
              </div>
            </div>
            <a href="categories.php">
              <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
              </div>
            </a>
          </div>
        </div>
      </div>
	
      <div class="row">
          <?php
			//Querys to find values to show in google charts on the admin index.php page - shows chart number 
			//Use function to find values to show in charts
			$posts_draft_count = check_status('posts','post_status','draft');
			$posts_published_count = check_status('posts','post_status','published');
			$unapproved_comments_count = check_status('comment','comment_status','unapproved');
			$approved_comments_count = check_status('comment','comment_status','approved');		
		  ?>
          <script type="text/javascript">
            google.charts.load('current', {
              'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Data', 'Count'],
                <?php //Non static update loop
				
						  //Hold  and print the differt charts names
						  $element_text = [ 'Draft Posts', 'Published Posts',  'Approved Comments','Pending Comments','Website Accounts','Blog Categories'];

						  //Hold and print the number in each chart 
						  $element_count = [$posts_draft_count, $posts_published_count, $approved_comments_count, $unapproved_comments_count, $user_count, $categories_count ];
						  
						  for($i = 0;$i < 6; $i++){ //Show the charts - thier are four: posts, users, comments and categories 
						  
							  echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
		 
						  }																
				?>
              ]);
              var options = {
                chart: {
                  title: '',
                  subtitle: '',
                }
              };
              var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
              chart.draw(data, options);
            }
          </script>
          <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
      </div>

    </div>
    <!-- /.container-fluid -->

  </div>
  </div>
  <?php include"includes/admin_footer.php";//Page footer include ?>