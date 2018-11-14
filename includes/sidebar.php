
			<!-- Blog Sidebar Widgets Column
			/*
			*Title: Sam francis source code
			*    Author: Francis, S
			*    Date: 2017
			*    Code version: 1
			*    Availability: https://codepen.io/hollowsamff/pen/PjxMvQ
			*/
			-->
            <div class="col-md-4">
		
                <!-- Blog Categories Well -->
                <div class="well">
				    <?php
					//Store the values from posts fields from database categories table in varables
			        $stmt = mysqli_prepare($connection,"SELECT cat_title, cat_id  FROM  post_categories");
                    mysqli_stmt_execute($stmt);
                    $stmt->bind_result($cat_title, $cat_id);
				    ?>
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                           <ul class="list-unstyled">
								<?php
									//Show all the categories from database categories table in the side bar
									while($stmt->fetch()){									
						        		$cat_title = escape($cat_title);
                                        $cat_id = escape($cat_id);
										echo "<li><a href='blog.php?category=$cat_id&name=$cat_title'>{$cat_title}</a></li>";
									}
									mysqli_stmt_close($stmt);//Close statment connection 
							    ?>
                            </ul>
                        </div>
                    </div>
                    <div id="scores"></div>		
                </div>
				
				<div class="well">
					<h4>Logged in as <?php echo $_SESSION['user_name'];?></h4>				
					<a class="btn btn-primary" href ="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
				</div>

				<table>
		          <thead><tr><td colspan="3">Quiz Leaderboard</td></tr>	
			        <tr>
					  <td><strong>RANK</strong></td>
				      <td><strong>USER NAME</strong></td>
				      <td><strong>SCORE</strong></td>
			        </tr>		
		          </thead>		
		        <tbody id='userRows'>	
		        </tbody>
				<tfoot>
				   <tr>
				      <td colspan="3">
					    Completing the website quizzes will increase your score by one (you can redo the quizzes to increase your score).<br>
					  <button class="btn btn-primary"><a href="leaderboard.php" style="color:white; text-decoration: none;">Show all scores</a></button>
					  </td>
				   </tr>
				</tfoot>
	            </table>
				
				
             </div>		

<style>
table {
  background: white;
  margin: 2%;
  width: 96%;
  border: 2px solid gray;
  border-collapse: collapse;  
}

td, th {
  text-align: center;
  border: 2px solid gray;
  padding:10px;	
}
</style>		

				
				
<script>		
$("document").ready(function(){
								
	 var getQuizHighScores = "getQuizHighScores";
	 
	(function worker() {//Update the high score table on the page ever five secounds
	
		jQuery.ajax({
			url: 'databasephp/phpquizhighscore.php',
			dataType: "json",
			type: "post",
			data: {getQuizHighScores:getQuizHighScores},		
			 
			 success: function(response){
						
			  $("#userRows").html("");
			  var backgroundColor = "white";
			  console.log(response["user_name_array"]);
				for(var x = 0; x < response["user_name_array"].length; x++  ){
					
					if(response["user_id"] == response["user_id_array"][x]){
						backgroundColor = "lightgray";
					}
					else{
					   backgroundColor = "white";
					}
					$("#userRows").append("<tr style='background-color:"+backgroundColor+"' ><td>"+(x+1)+"</td><td>"+response["user_name_array"][x]+"</td><td>"+response["user_score_array"][x]+"</td></tr>");
				 }
			   },
             complete: function() {
			   // Schedule the next request when the current one's complete
			   setTimeout(worker, 5000);
             }
		});	
		
	})();
});
</script>					
				