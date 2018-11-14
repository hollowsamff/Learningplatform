<?php
	
include "../databasephp/functions.php";
include"../databasephp/db.php";	

?>

<!--Page used to show quizzes on different pages, use the getquiz.pgp page to show the quizzes and thesaveuserquizscore.php to save the users scores--> 
<div class="hideDiv" >
<h5 id="showQuizNumber" ><b>Please conduct the following quizzes to test what you have learned</b></h5> 
 <h4>Select a quiz:</h4>
<select id="mySelect" >
<?php
  if(isset($_POST["the_post_id"])){//Run when the user quiz data is send from the quizInclude page - only show quiz for the post the user is on
				
	$the_post_id = escape($_POST["the_post_id"]);
    $stmts = mysqli_prepare($connection,"SELECT quiz_name, quiz_id FROM quiz WHERE posts_id = ?");
    mysqli_stmt_bind_param($stmts,'d' ,$the_post_id);
	mysqli_stmt_execute($stmts);
	mysqli_stmt_store_result($stmts);//Store result 
	echo $count = mysqli_stmt_num_rows($stmts);//Find number of posts
	
  }else{
	
    $stmts = mysqli_prepare($connection,"SELECT quiz_name, quiz_id FROM quiz");
	mysqli_stmt_execute($stmts);
	mysqli_stmt_store_result($stmts);//Store result 
	echo $count = mysqli_stmt_num_rows($stmts);//Find number of posts
	  
  }
	 if($count > 0 ){
	 
		 $stmts->bind_result($quizNamesList,$quizIdsList);
		 if( $stmts->execute()){

		  //Bind these variable to the SQL results
		   $stmts->bind_result($quizNamesList,$quizIdsList);

			while( $stmts->fetch()){
				
			  $quiz_names = escape($quizNamesList);
			  $quiz_ids  = escape($quizIdsList);
			  echo "<option value='{$quizIdsList}'>{$quizNamesList}</option>";
			}
		 }
	 }else{
		 
		 echo "<option value='none'>none</option>";
	 }
mysqli_stmt_close($stmts);
?>
</select> 

  <h3 id = "quizNameShow">Quiz one</h3>
  <span id="currentQuizQuestion">Question:<span id="questionCurretNums">0</span>/<span id="questionMaxNums">5</span></span>

  <span id="showPlayerScore">Score:</span>
  <br>
  <div class="container">
      <div class="quizBox">    
		   <h4 id="quizQuestion"></h4>
		   
		   <img id="quizImage" class="img-responsive containerImage" width="auto" src="" alt="Quiz image">
		   
		   <br>
		   
		   <div id="answerOne" value="1" class="quizAnswer"></div>
		   <div id="answerTwo" value="2" class="quizAnswer"></div>
		   <div id="answerThree" value="3" class="quizAnswer"></div>
		   <div id="answerFour" value="4" class="quizAnswer"></div>   
		   <button id="startQuiz"class="btn-primary" style="margin:0px;">Restart quiz</button>
	   </div>
  </div>
</div>
</div>
<hr style=" border-color:#3CB371;">
<style>


.hideDiv{
	display:none;
}


@media only screen and (max-width: 500px) {
	
.quizAnswer {
   height: auto;
}  
}
</style>

<script>

//alert($("#mySelect :selected").text()); // The text content of the selected option

 $(document).on("mouseover", ".quizAnswer", function() {  
  $(this).css('background', 'gray'); 
 }); 
 $(document).on("mouseleave", ".quizAnswer", function() {   
  $(this).css('background', 'white');       
 });
  
 $(document).ready(function(){

  var quizId = "";
  var quizName = "";
  var quizImage = "";
  var quizQuestion = "";	
  var answerOne = "";
  var answerTwo = "";
  var answerThree = "";
  var answerFour ="";
  var winingAnswer = "";	
  var currentQuestion = 0;
  var playerScore = 0;
  var dateLong = new Date();
  var shortDate = dateLong.toLocaleDateString();	   

  ajaxRequest();

   function ajaxRequest(){//Get quiz for database with ajax
	 
     quizId = $("#mySelect").val();//User can change the quiz that apears with the drop down menu
	 
	 if(quizId == "none"){
	    $(".hideDiv").css("display", "none");
        return;
	 }else{
		$(".hideDiv").css("display", "inline-block");
	 }
	 
	 jQuery.ajax({
		url: "databasephp/blogquizphp.php",
		dataType: "json",
		type: "post",
		data: {quizId:quizId},		
		success: function(response) {//Show the selected quiz

			 quizId = response["quizId"];
		   	 quizName = response["quizName"];
			 quizImage = response["quizImageArray"];
			 quizQuestion = response["quizQuestion"];
			 answerOne = response["answerOne"];
			 answerTwo = response["answerTwo"];
			 answerThree = response["answerThree"];
			 answerFour = response["answerFour"];
			 winingAnswer = response["correctAnswer"];			
	         resetQuiz();					
		}		
	});//End ajax
  }
  
  $('#mySelect').change(function(){ //When user changes quiz from dropdown
     ajaxRequest();
  });
	
  function resetQuiz(){//Used to reset the quiz

		playerScore = 0;
		currentQuestion = 0;	
		dateLong = new Date();
		shortDate = dateLong.toLocaleDateString();
		
        //$('#quizImage').attr('src', "images/"+quizImage[0]+"");
		$("#currentQuizQuestion").css("display", "block");
		$(".quizBox").css("border", "1px solid black");
		$(".quizBox").css("height", "auto");		
		$("#showPlayerScore").html("Score:"+playerScore);		
		$("#questionCurretNums").html(currentQuestion+1);
		$("#questionMaxNums").html(quizQuestion.length);
		$(".quizAnswer").css("display", "inline-block");
		$("#quizNameShow").html(quizName);				
		$("#questionCurretNums").html(currentQuestion+1);//Load next question in the quiz
		$("#quizQuestion").html(quizQuestion[currentQuestion]);
		
		if(quizImage.length > currentQuestion ){
			
			$("#quizImage").css("display", "inline-block");	
			$('#quizImage').attr('src', "images/"+quizImage[currentQuestion]+"");
			
		}else{
			
			$('#quizImage').attr('src', "");
			$("#quizImage").css("display", "none");			
		}
		
		$("#answerOne").html(answerOne[currentQuestion]);
		$("#answerTwo").html(answerTwo[currentQuestion]);
		$("#answerThree").html(answerThree[currentQuestion]);
		$("#answerFour").html(answerFour[currentQuestion]); 			
	}
			
  $(document).on("click","#startQuiz",function(){//Reset quiz to first question
	  resetQuiz();
  });	 
  
  var answersArray = new Array;//Hold the correct answers to the questions the user got wrong
  var userClickedAnswer = 0;//Stop the user clicking on the same answer twice
	
  $(document).on("click",".quizAnswer", function(){//load next question or score when user clicks on the quiz answers
     
	if(currentQuestion < quizQuestion.length && userClickedAnswer == 0){
		
		userClickedAnswer = 1;//Stop the user clicking on the same answer twice
		var answer = $(this).attr("value");	
		
		if($(this).text() == winingAnswer[currentQuestion]){
			
			playerScore++;
			$("#showPlayerScore").html("Score: "+playerScore);
			
			if(answer == "1"){
			  $("#answerOne").css("backgroundColor","green");	
			}else if(answer == "2"){
			  $("#answerTwo").css("backgroundColor","green");	
			}else if(answer == "3"){
			  $("#answerThree").css("backgroundColor","green");	
			}else if(answer == "4"){
			  $("#answerFour").css("backgroundColor","green");	
			}	
           
		      answersArray.push("<div style='border:1px solid black; margin-top:5px;' class='hideAnswers hide'>Question "+(currentQuestion+1)+" of "+quizQuestion.length+" <br> "+ $("#quizQuestion").html()+  "<br><br><span style='color:green'class='glyphicon glyphicon-ok'> Correct</span><br><br> You answered <br><div class='alert alert-success'>" + $(this).text() +"</span></div></div>");
				
					 		
		}else{		
          
			if(answer == "1"){
			  $("#answerOne").css("backgroundColor","red");	
			}else if(answer == "2"){
			  $("#answerTwo").css("backgroundColor","red");	
			}else if(answer == "3"){
			  $("#answerThree").css("backgroundColor","red");	
			}else if(answer == "4"){
			  $("#answerFour").css("backgroundColor","red");	
			}
			
		     answersArray.push("<div style='border:1px solid black; margin-top:5px;' class='hideAnswers hide'>Question "+(currentQuestion+1)+" of "+quizQuestion.length+" <br> "+ $("#quizQuestion").html()+  "<br><br><span style='color:red'class='glyphicon glyphicon-remove'> Incorrect</span><br><br>	You answered <br><div class='alert alert-danger'>" + $(this).text() +"</span></div>Correct answer <br><div class='alert alert-success'>" + winingAnswer[currentQuestion]+"</div></div>");
				
		}			

	   setTimeout(function(){//Run the next bit of code after 250 milisecounds
	    
		userClickedAnswer = 0;
		currentQuestion++;		
		$("#questionCurretNums").html(currentQuestion+1);//Load next question in the quiz
		$("#quizQuestion").html(quizQuestion[currentQuestion]);
		
		if(quizImage.length > currentQuestion ){
			
			$("#quizImage").css("display", "inline-block");	
			$('#quizImage').attr('src', "images/"+quizImage[currentQuestion]+"");
			
		}else{
			$('#quizImage').attr('src', "");
			$("#quizImage").css("display", "none");			
		}

		$("#answerOne").html(answerOne[currentQuestion]);
		$("#answerTwo").html(answerTwo[currentQuestion]);
		$("#answerThree").html(answerThree[currentQuestion]);
		$("#answerFour").html(answerFour[currentQuestion]); 
		
		 if(currentQuestion == quizQuestion.length ){//When the user completes the last question the score will be displayed and saved in the database 
		 
		 $.ajax({//Save score in database 
			type: "POST",
			url: "databasephp/blogquizphp.php",
			data: {playerScore: playerScore, maxScore:currentQuestion, quizId:quizId},	
			success:function( msg) {	
			  //alert(msg);
			  
			}
		  });				 

	 	  var studentName = "<?php if(isset($_SESSION['user_name'])){ echo $_SESSION['user_name']; }else{echo "you";}?>"
		  
		  var scorePercent = Math.floor(((playerScore / quizQuestion.length) * 100));

		  $("#currentQuizQuestion").css("display", "none");
		  $(".quizAnswer").css("display", "none");
		  $(".quizBox").css("border", "0px solid black");
		  
		  $("#quizQuestion").html('<div style="width:100%; height:300px; padding:20px; text-align:center; border: 10px solid #787878; font-size:15px"><div style="width:100%; height:250px; padding:20px; text-align:center; border: 5px solid #787878"><span style="font-size:20px; font-weight:bold">Certificate of Completion</span><br><span>'+studentName+'</span><br/> scored '+scorePercent+'/100<br><span>on the  </span><br><span>'+quizName+'</span><br><span id="certificateDate">'+shortDate+'</span></div></div>');	
         
		  $("#quizQuestion").append("<br><button id='reviewIncorrectAnswers'class='btn-primary' style='margin:0px;'>Review quiz answers</button><br>");
	     
		 for(var i = 0; i < answersArray.length; i++){
			 
			 $("#quizQuestion").append(answersArray[i]);
		 }
		
		 }
		}, 250);		 
	  }	
	});
		
   $(document).on("click","#reviewIncorrectAnswers",function(){//Reset quiz to first question
	 $(".hideAnswers").toggleClass("hide");
   });	
  
	
});//End document ready
</script>

<?php
if(isset($_GET["showAddQuiz"])){//When the user loads the quiz.php page
	
include "includes/footer.php";	

}
?>