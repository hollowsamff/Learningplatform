<?php
include"databasephp/db.php";
include"includes/header.php";
include"includes/navigation.php";

if(!is_logged_in()){	
	header("Location: index.php");
}

?>
<header>
<h1>Leaderboard</h1>
</header>
<hr>
<p>Completing the website quizzess will increase your score by one.</p>

	              <table>
		          <thead><tr><td colspan="3">Quiz Leaderboard</td></tr>	
			        <tr>
					  <td><strong> RANK </strong></td>
				      <td><strong> USER NAME </strong></td>
				      <td><strong>SCORE</strong></td>
			        </tr>		
		          </thead>		
		        <tbody id='userRows'>	
		        </tbody>
	            </table>
<style>
table {
  background: white;
  margin: 2%;
  width: 96%;
  border: 2px solid gray;
  border-collapse: collapse;  
  margin-bottom: 50px;
}

td, th {
  text-align: center;
  border: 2px solid gray;
  padding:8px;	
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
			   //setTimeout(worker, 5000);
             }
		});	
		
	})();
		
});
</script>		
<?php include"includes/footer.php";//Page footer include ?>