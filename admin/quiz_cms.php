<?php 
//This page will show the results from the website quizzes and the time website user have spent logged onto the website.
//The page uses ajax requests to the “get_user.php” page to work.
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*/
include"includes/admin_header.php";
?>  
<?php include"includes/admin_navigation.php";//Page navigation include  ?>
<div id="wrapper">

	<div id="page-wrapper">

		<div class="container-fluid">
		
			<section class="col-lg-12">
			   
			   <h1 class="page-header text-center">Blog quizzes CMS</h1>
		 
				<form action="" multiple="multiple" method="post" enctype="multipart/form-data">

					  <div class="form-group">
						<h3>Create new quiz</h3>
						<label for="quiz_name">Quiz name</label>
						<input type="text" name="quizName" id="quizName" class="form-control inputBox" placeholder="Enter quiz name" autocomplete="on">
						<h4 id="errorquizName">Quiz name cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<label for="quiz_question">Number of quiz questions</label>
						<input type="text" type="number_format" name="quizQuestionNumber" id="quizQuestionNumber" class="form-control inputBox" placeholder="Enter number of questions" autocomplete="on">
						<h4 id="errorQuestionNumber">Quiz number cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<label for="post_name">Blog post  the quiz will be on</label>
						<br>
						<select name="postName" id="postName" type="text" class="form-control">
						</select>
					  </div>

					  <div class="form-group">
						<input class="btn btn-primary" type="submit" value="Next" id="showHiddenForm">
					  </div>
				</form>
		  
			  
			  <article class="container">

				<form id="hiddenForm" action="" multiple="multiple" method="post" enctype="multipart/form-data">
					  <p id="currentQuestion"> Quiz question 1</p>
					  <div class="form-group">
						<input type="text" name="quizQuestion" id="quizQuestion" class="form-control inputBox" placeholder="Enter quiz question">
						<h4 id="errorQuizQuestion">Quiz name cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<input type="text" type="number_format" name="quizQuestionOne" id="quizQuestionOne" class="form-control inputBox" placeholder="Enter the correct answer">
						<h4 id="errorQuestionOne">Quiz question cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<input type="text" type="number_format" name="quizQuestionTwo" id="quizQuestionTwo" class="form-control inputBox" placeholder="Enter the wrong answer">
						<h4 id="errorQuestionTwo">Quiz question cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<input type="text" type="number_format" name="quizQuestionThree" id="quizQuestionThree" class="form-control inputBox" placeholder="Enter the wrong answer">
						<h4 id="errorQuestionThree">Quiz question cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<input type="text" type="number_format" name="quizQuestionFour" id="quizQuestionFour" class="form-control inputBox" placeholder="Enter the wrong answer">
						<h4 id="errorQuestionFour">Quiz question cannot be empty.</h4>
					  </div>

					  <div class="form-group">
						<input class="btn btn-primary" type="submit" name="createQuiz" value="Next" id="createQuiz">
					  </div>
				</form>
			  </article>
			  <!-- /.row -->

			</section>
	  </div>
  </div>
</div>

  <!--Include used to show quizzes on different pages-->
  <style>
    #errorQuestionOne,
    #errorQuestionTwo,
    #errorQuestionThree,
    #errorQuestionFour,
    #errorQuizQuestion,
    #errorQuestionNumber,
    #errorquizName {
      color: red;
      display: none;
    }
  </style>

  <script>
    $(document).ready(function() {
      var populatePageDropDowns = "populatePageDropDowns";
      jQuery.ajax({
        url: "includes/creatpostquizphpcode.php",
        dataType: "json",
        type: "post",
        data: {
          populatePageDropDowns: populatePageDropDowns
        },
        success: function(response) {
          //console.log(response);
          for (var x = 0; x < response["post_id_array"].length; x++) {
            $('#postName').append($('<option>', {
              value: response["post_id_array"][x],
              text: response["post_name_array"][x]
            }));
          }
        },
        complete: function() {}
      });
      var quizQuestionString = ""; //Used to save the first quiz question
      $("#hiddenForm").css("display", "none");
      var currentQuestion = 1;
      $("#showHiddenForm").on("click", function(e) {
        event.preventDefault();
        currentQuestion = 1;
        quizQuestionString = ""; //Used to save the first quiz question
        var questionNumber = $("#quizQuestionNumber").val().trim();
        var quizName = $("#quizName").val().trim();
        if (isNaN(questionNumber)) {
          alert("Question number has to be a number");
          return;
        }
        if (questionNumber == "") {
          event.preventDefault();
          $("#errorQuestionNumber").css("display", "inline"); //Show error message
        }
        if (quizName == "") {
          event.preventDefault();
          $("#errorquizName").css("display", "inline"); //Show error message
        }
        if (quizName != "" && questionNumber != "") {
          $("#showHiddenForm").css("display", "none");
          $("#errorquizName").css("display", "none");
          $("#errorQuestionNumber").css("display", "none");
          //Display boxes to input question ans answers using bootstrap ui effect
          $("#hiddenForm").stop(true, true).show("clip", {
            direction: "vertical"
          }, 800).animate({
            opacity: 1
          }, {
            duration: 800,
            queue: false
          });
        }
      });
      $("#createQuiz").on("click", function(e) {
        event.preventDefault();
        var quizName = $("#quizName").val().trim();
        var questionNumber = $("#quizQuestionNumber").val();
        var quizQuestion = $("#quizQuestion").val().trim();
        var answerOne = $("#quizQuestionOne").val().trim();
        var answerTwo = $("#quizQuestionTwo").val().trim();
        var answerThree = $("#quizQuestionThree").val().trim();
        var answerFour = $("#quizQuestionFour").val().trim();
        var QuizAnswers = "";
        if (isNaN(questionNumber)) {
          alert("Question number has to be a number");
          return;
        }
        if (questionNumber == "") {
          event.preventDefault();
          $("#errorQuestionNumber").css("display", "inline"); //Show error message
        }
        if (quizQuestion == "") {
          $("#errorQuizQuestion").css("display", "inline"); //Show error message
        }
        if (quizName == "") {
          event.preventDefault();
          $("#errorQuizQuestion").css("display", "inline"); //Show error message
        }
        if (answerOne == "") {
          event.preventDefault();
          $("#errorQuestionOne").css("display", "inline"); //Show error message
        }
        if (answerTwo == "") {
          event.preventDefault();
          $("#errorQuestionTwo").css("display", "inline"); //Show error message
        }
        if (answerThree == "") {
          event.preventDefault();
          $("#errorQuestionThree").css("display", "inline"); //Show error message
        }
        if (answerFour == "") {
          event.preventDefault();
          $("#errorQuestionFour").css("display", "inline"); //Show error message
        }
        if (quizName != "" && questionNumber != "" && quizQuestion != "" && answerOne != "" && answerTwo != "" && answerThree != "" && answerFour != "") {
          $("#errorquizName,#errorQuestionNumber,#errorQuestionNumber,#errorQuizQuestion,#errorQuestionOne,#errorQuestionTwo,#errorQuestionThree,#errorQuestionFour").css("display", "none");
          //Display boxes to input question ans answers using bootstrap ui effect
          $("#hiddenForm").stop(true, true).show("clip", {
            direction: "vertical"
          }, 800).animate({
            opacity: 0
          }, {
            duration: 800,
            queue: false
          });
          currentQuestion++;
          quizQuestionString += quizQuestion + "~" + answerOne + "~" + answerTwo + "~" + answerThree + "~" + answerFour + "" + "*-*"; //Used to save the quiz question and answer in a string
          //End of individual questions and answer are separated with a ~ and different questions are separated with a *-*			  
          var clearQuesionNumber = 2; //Clear input boxes for past questions and answers(do not delete the question and answer until the quiz has been submited)
          if (currentQuestion <= questionNumber) { //Show next question in the question
            $("#currentQuestion").html("Quiz question " + currentQuestion);
            $("#hiddenForm").stop(true, true).show("clip", {
              direction: "vertical"
            }, 800).animate({
              opacity: 1
            }, {
              duration: 800,
              queue: false
            });
          } else { //When user has input last question save quiz in database
            var quizPostId = $("#postName").val();
            $.ajax({ //Save score in database 
              type: "POST",
              url: "includes/creatpostquizphpcode.php",
              data: {
                quizQuestionString: quizQuestionString,
                quizName: quizName,
                quizPostId: quizPostId
              },
              success: function(msg) {
                //alert(msg);
                alert("Quiz created");
                //   location.reload();					
              }
            });
            clearQuesionNumber = 0; //Clear the question and question number after the quiz has been input into the database	
            $("#hiddenForm").css("display", "none");
          }
          $("#showHiddenForm").css("display", "inline-block");
          var inputBoxs = document.getElementsByClassName('inputBox'); //Get all the input boxs on the page
          var inputBoxsNum = inputBoxs.length; //Number of input boxs
          for (clearQuesionNumber; clearQuesionNumber < inputBoxsNum; clearQuesionNumber++) { //Clear input boxes for past questions and answers
            inputBoxs[clearQuesionNumber].value = "";
          }
        }
      });
    });
  </script>
  
  <?php include"includes/admin_footer.php";//Page footer include ?>
