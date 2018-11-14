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
//If the function that tests if a user is admin sents back false

?>
    <div id="wrapper">
	
	 <!-- Navigation -->
	 <?php include"includes/admin_navigation.php";//Page navigation include  ?>
		
        <div id="page-wrapper">

         <main class="container-fluid">
		 
		 <header class="col-lg-12">
		 
             <h1 class="page-header text-center"> User data CMS</h1>

		 </header>
		 
		<section class="col-lg-12">

     <button class="btn btn-primary" id="getAllScores">Show All The Website Users Average Quiz Scores</button><br><br>
	 <button name="showQuestionnaireResults" id="showStackedChartQuestionnaireChart" class="btn btn-primary">Website questionnaire results</button>	
  
    <!--Select the user who quiz data will be displayed-->
	<section class="container">			
	  <h4>Filter by user</h4>		
	  <select id="mySelect" >
		<?php		
			$stmts = mysqli_prepare($connection,"SELECT user_name, user_id, user_role FROM users");
			mysqli_stmt_execute($stmts);
			
				$stmts->bind_result($user_name, $user_id, $user_role);
				
				 if($stmts->execute()){

					while($stmts->fetch()){
						
						if($user_role == "notadmin"){
							
							$group_name = "Not admin account";
							
						}else{
							
							$group_name ="Website admin account";
						}
							
					  echo "<option value='{$user_id}'>{$group_name} --- {$user_name}</option>";
					}
				 }			 
		mysqli_stmt_close($stmts);
		?>
	   </select>
	   <br><br>	
	 </section>
	 
	 <button name="userOnlineTimeHide" id="getUserOnlineTime" class="btn btn-primary">Get User Online Time</button>
     <button name ="hideAllUserScores" id="showUserScores" class="btn btn-primary">Show All The Users Quiz Scores</button> 	 
	 <button name ="quizzesAverageScoreByTotal" id="showUserScores2" class="btn btn-primary">Show User Quizzes Average Scores</button>
	 <button name="quizzesAverageScoreByDate" id="showUserScores3" class="btn btn-primary showLineChart">Show User Quizzes Average Scores By Date</button>	
	 <hr>
	 
	  <!--Stacked bar chart and summary table for website questionare-->  
	 <div id="visualization_wrap" class="hide">
        <caption><strong>Users responce to website questionnaire</strong></caption>
        <figure id="stackedChartHolder" class="hide"></figure>
     </div>
	 <table id="stackedChartTable" class="hide">
	 <caption><strong>Students rating of current online learning resources summary table</strong></caption>
	 <br>
		<thead>	
			<tr>
				<td>Responce question</td><td>Strongly agree</td><td>Agree</td><td>Neither agree or disagree</td><td>Disagree</td><td>Strongly disagree</td>
			</tr>		
		</thead>
		<tbody id = "stackedChartTableBody">		
			<tr>
			</tr>	
		</tbody>
		<tfoot>
         <tr id="stackedChartTotal"  class="totalColumn">
		 <th id="total" colspan="1">Total:</th>
			<td class="totalCol"></td>
			<td class="totalCol"></td>
			<td class="totalCol"></td>
			<td class="totalCol"></td>
			<td class="totalCol"></td>
         </tr>
        </tfoot>
	</table>

    <!--All user scores averages bar chart  <th id="total" colspan="1">Total:</th>-->  
	<section id ="allUserScoresQuizSelectHolder" class ="hide">
	  <hr style="border-color:blue;">		
	  <h3>Select quiz</h3>			
	  <select id="allUserScoresQuizSelect">
		<?php	
			$stmts = mysqli_prepare($connection,"SELECT quiz_name FROM quiz");
			mysqli_stmt_execute($stmts);

				 $stmts->bind_result($quiz_name);
				 if($stmts->execute()){

				    $stmts->bind_result($quiz_name);

					while($stmts->fetch()){					
					  echo "<option value='{$quiz_name}'>{$quiz_name}</option>";
					}
				 }			 
		mysqli_stmt_close($stmts);
		?>
	   </select>
	</section>
	<div id="wrapperOne">
	   <div id="allUserScoresCollumBox" class="hide">
			<figure id="chart_div1"></figure> 

	   </div>
	   <div id="allUserScoresCollumLegend" class="hide">
			<div id="box2"></div>
		Online user		
			<div id="box"></div>
		Classroom user
	   </div> 
	</div>
	<table id="allUserScoresCollumTable" class="hide">
	<br>
		<thead>	
			<tr>
				<td>Online user mean grade</td><td>Classroom user mean grade</td>
			</tr>		
		</thead>		
		<tbody>		
			<tr>
				<td id="onlineStudentMeanGrade"></td><td id="classroomStudentMeanGrade"></td>
			</tr>	
		</tbody>
	</table>

    <!--User online time-->  
	<section class="table-responsive">
	 <h2 class ="hide">User online time</h2>
	  <table id="userOnlineTimeHide" class ="table table-bordered table-hover hide">
	   <caption><strong>User online time</strong></caption>
	     <thead>
		        <tr>
				     <td>Total time logged on </td>
					 <td id="showTotalTimeLoggedOn">0</td>
					 <td></td>
				</tr>
				<tr>
				    <td>Week start date (Monday)</td>
					<td>Number of times logged on per week</td>
					<td>Total time logged on per week</td>
				</tr>
	     </thead>			
		 <tbody id="showUserOnlineTime">
	     </tbody>		  
	  </table>
	</section>
	   
	   
	<!--Indivigual user average grades for the website quizzes and tests table-->   
	<section  class="table-responsive">
	  <h2 class ="hide">Average grades for the website quizzes and tests</h2>
	   <table id="quizzesAverageScoreByTotal" class ="table table-bordered table-hover hide">
	   	<caption><strong>Average grades for the website quizzes and tests</strong></caption>	   
			<thead>
				<tr>
					<td>Quiz name</td>
					<td>Average Score</td>
				</tr>
			</thead>
			<tbody id="userScoreAverage">
			</tbody>
	  </table>
	</section> 
	  
	 <!--All the users resuts for the website quizzes and tests-->  
	 <section class="table-responsive">
	 <h2 class ="hide">All the users resuts for the website quizzes and tests</h2>
	 <table id="hideAllUserScores" class ="table table-bordered table-hover hide">
	 	<caption><strong>All the users resuts for the website quizzes and tests</strong></caption>
		<thead>
			<tr>
				<td>Quiz name</td>
				<td>Date</td>
				<td>User score</td>	
				<td>Percent</td>
			</tr>
		</thead>
		<tbody id="showAllUsers">
		</tbody>
		</table>
	 </section>
	 
	  
	<article id ="hideQuizSelect" class ="hide">	
	  <h3>Select quiz</h3>			
	  <select id="mySelectQuiz">
		<?php	
			$stmts = mysqli_prepare($connection,"SELECT quiz_name, quiz_id FROM quiz");
			mysqli_stmt_execute($stmts);

				 $stmts->bind_result($user_name, $user_id);
				 if( $stmts->execute()){

				  //Bind these variable to the SQL results
				   $stmts->bind_result($user_name, $user_id);

					while($stmts->fetch()){
						
					  $user_name = escape($user_name);
					  $user_id  = escape($user_id);
					  echo "<option value='{$user_id}'>{$user_name}</option>";
					}
				 }			 
		   mysqli_stmt_close($stmts);
		?>
	   </select>
	   </article>
	   <br>
	   
	   <article class="table-responsive">
		<h2 class ="hide">Weekly average scores for the website quizzes and tests</h2>
		<table id="quizzesAverageScoreByDate" class ="table table-bordered table-hover hide">
	   		<caption><strong>Weekly average scores for the website quizzes and tests</strong></caption>	   
			<thead>
				<tr>
					<td>Week start date (Monday)</td>
					<td>Number of times test conducted in the week</td>
					<td>Average Score</td>
				</tr>
			</thead>			
			<tbody id="userScoreWeek">
			</tbody>
		</table>
	</article>
	<!--User average score per week line chart -->
	<div id="wrapperOne">
	   <div id="userAverageScoreLineChartBox" class="hide">
			<figure id="chart_divs" class="chart"></figure> 
	   </div> 
	</div>
			
		
			<br><br>
				<div id="chart_div" style="width: 800px; height: 500px;"></div>
			<hr>
			 <br><br>
     </section>   
		   
		   
       </main>
            <!-- /.container-fluid -->
        </div>	
		
 
<?php include"includes/admin_footer.php";//Page footer include ?>

	
<style>
th, td {
	padding: 8px;
	text-align: left;
	border: 1px solid black!important;
}
</style>	

	
<script>

$("document").ready(function(){

	ajaxRequestGetUserQuizData();
	
    //////////////////////////////////////////////////////////////////////////

	var formLoaded = 0;//Load the charts when the page first loads
	google.charts.load('current', {
	 packages: ['corechart','bar']  
	 
	}).then(function () {	
		  
		  //Load line chart when button is pressed
		  $(".showLineChart").click(function() {
		    $("#hideQuizSelect").toggleClass("hide");
		    $("#userAverageScoreLineChartBox").toggleClass("hide");
		    drawlineChartWeeklyScoresAverage(lineChartWeeklyScoresAverageDates, lineChartWeeklyScoresAverageScores);
		    formLoaded++;  
		  });  
		  
		  //Load stacked bar chart when button is pressed
		  $("#showStackedChartQuestionnaireChart").on("click", function(){ 
		    $("#visualization_wrap").toggleClass("hide");
		    $("#stackedChartHolder").toggleClass("hide");
			stackedChartQuestionnaireResponse();
		  });
		  
		  //Load bar chart of all user average quiz scores when button is pressed
		  $("#getAllScores").on("click", function(){
			 $("#allUserScoresCollumBox").toggleClass("hide");
		     $("#allUserScoresCollumTable").toggleClass("hide");
			 $("#allUserScoresCollumLegend").toggleClass("hide");
			 $("#allUserScoresQuizSelectHolder").toggleClass("hide");			 
			 getAllUserScores();			 
		  });
    });
	
	
		function ajaxRequestGetAllUsersOnlineTime(userid){
						
	     	var userId = userid;//Used to select the user who time is being shown

			jQuery.ajax({
			url: 'includes/getusers.php',
			dataType: "json",
			type: "post",
			data: {userId:userId},		
			success: function(response){//Get the times the user has been logged on
			
			  var startTime1 = response["start_time"];
			  var endTime1 = response["end_time"];
			  var results1 = "";
			  var timeLoggedOnPerWeek1 = 0;
			  var timeLoggedOn1 = 0;
		
			  var x1 = 0;
		      var deleteIndex1 = 0;	  
			  var TestResultsForSeparateWeeks1 = new Array();		  
			  
			  startTime1 = startTime1.filter(function(currentValue, currentIndex, array){		  
			     if(endTime1[currentIndex] != '0000-00-00 00:00:00'){//Test to remove start dates that do not have end dates							 
						 return currentValue;
				  }
			  });
			  //console.log(startTime1);
				
			  endTime1 = endTime1.filter(function(currentValue, currentIndex, array){			  
			      if(currentValue != '0000-00-00 00:00:00'){//Test to remove end dates that are blank				 
					 return currentValue;
				  } 
			  });
			  
			  while(startTime1.length > 0){//Loop though all the dates in the array until all the dates have been removed
					 
				   var weekQuizzess1 = startTime1.filter(function(currentValue, currentIndex, array){//All the logins conducted in one week
						 
                        var first_date1 = new Date(array[0].replace(/-/g,"/"));//Convert from  mysql database format
						first_date1 = getMondays(new Date(first_date1));
												
						var start_date1 = new Date(currentValue.replace(/-/g,"/"));
						var end_date1 = new Date(endTime1[currentIndex].replace(/-/g,"/"));
						
						var lastDate1 = showDays(first_date1, start_date1);//Get number of days between the mondays of the first date in the array and the other values in the array;
						
						if(parseInt(lastDate1) > -8){//Used to get the index value of all the logins conducted seven days after the first date in the array  
						
							  deleteIndex1 = currentIndex;
							  var diff1 = Math.abs(new Date(start_date1) - new Date(end_date1));//Get differnce between login and logout time	
							  var secounds1 = Math.floor((diff1/1000));				
							  timeLoggedOnPerWeek1 += secounds1;
                           
                              //console.log("<br>"+secounds1+"="+timeLoggedOnPerWeek1);							  
							  return currentValue;
						}					
				     });
					 
					startTime1.splice(0, deleteIndex1 + 1);//Remove all the used dates
					endTime1.splice(0, deleteIndex1 + 1);			   
				   
					TestResultsForSeparateWeeks1[x1] = new Array();
					TestResultsForSeparateWeeks1[x1][0] = weekQuizzess1;//Add all the logins conducted in the differnt weeks into a mutli-dimmentinall array 		   		   
					TestResultsForSeparateWeeks1[x1][1] = timeLoggedOnPerWeek1;//Add the time logged in into the array
					timeLoggedOn1 += TestResultsForSeparateWeeks1[x1][1];
					x1++;	
		     }		
				var totalTimeString1 = convertToMin(timeLoggedOn1);//Display total time logged on
				var seconds1 = parseInt(timeLoggedOn1, 10);
	            var days1 = Math.floor(seconds1 / (3600*24));
             	seconds1 -= days1*3600*24;
	            var hrs1 = Math.floor(seconds1 / 3600);
				var mnts1 = Math.floor(seconds1 / 60);
	            seconds1 -= mnts1*60;yyy
										
		 },error: function(XMLHttpRequest, textStatus, errorThrown){
		    //alert(errorThrown); 
		 }				
		});		
	}
	
	
	
	
function timeStringToFloat(time) {
	var mins = 0;
	
	while (time > 60){
		time -=60;
		mins++;
	}
	
	
  return mins;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

//Used to draw a stacked bar chart to shows how users rated the website
  function stackedChartQuestionnaireResponse(){
	 			
     var displayType = "preStudy";//Used to decide if the chart should display the post or pre study questionnaire results

	  jQuery.ajax({
		url: 'includes/getusers.php',
		dataType: "json",
		type: "post",
		data: {displayType:displayType},		
		 success: function(response){
			 
		     //Remove old values from the table that summaries the chart
			 $("#stackedChartTableBody").html("<tr></tr>");
		     $("#stackedChartTable").toggleClass("hide");
		   
		    //Create the data table for stacked bar chart
			 var data = new google.visualization.DataTable();
			
             var easyToUseArray  = likertQuestionnaireResultsCount(response["easy_to_use_array"]);//Hold pre-study and post-study Likert scale questionnaire results, array 0 = question, array 1 = Strongly agree value, array 2 = agree value , array 3 = Neither agree or disagree value, array 4 = Disagree value and  array 5 = Strongly disagree value
			 //console.log(easyToUseArray);
			 
			 var wellOrganisedArray = likertQuestionnaireResultsCount(response["organized_rating_array"]);
			 //console.log(wellOrganisedArray);
			 
			 var usefulAndHelpful = likertQuestionnaireResultsCount(response["helpful_rating_array"]);
			 //console.log(usefulAndHelpful)
			 
			 var complementsLessons = likertQuestionnaireResultsCount(response["complements_teaching_rating_array"]);
			 //console.log(complementsLessons)

			 data.addColumn('string', 'Question');//Add the collums to the stacked bar
			 data.addColumn('number', 'Strongly agree');
			 data.addColumn('number', 'Agree');
			 data.addColumn('number', 'Neither agree or disagree');
			 data.addColumn('number', 'Disagree');
			 data.addColumn('number', 'Strongly disagree');
			  
			 data.addRows(easyToUseArray.length);//Add a row to the stacked bar(easy to use row)
			 for(var i = 0; i < easyToUseArray.length; i++){
				  data.setValue(0, i, easyToUseArray[i]);
			 }
			 data.addRows(wellOrganisedArray.length);
			 for(var i = 0; i < wellOrganisedArray.length; i++){
				data.setValue(1, i, wellOrganisedArray[i]);	
			 }
			 data.addRows(usefulAndHelpful.length);
			 for(var i = 0; i < usefulAndHelpful.length; i++){
				data.setValue(2, i, usefulAndHelpful[i]);	
			 }
			 data.addRows(complementsLessons.length);
			 for(var i = 0; i < complementsLessons.length; i++){
				data.setValue(3, i, complementsLessons[i]);	
			 }	
			 
			 //Calculate the totals of the collums https://stackoverflow.com/questions/10802244/sum-total-for-column-in-jquery
			 
			 var totals = [0,0,0,0,0];//Used to hold the totals
			 
			 //Get the number of table rows with values in them (ignore the Student responce question collums)
             var dataRows = $("#stackedChartTable tr:not('.totalColumn, .titlerow')");
	         //console.log(dataRows);
			 
             dataRows.each(function() {
               $(this).find('.rowDataSd').each(function(i){//Loop though all the cells in one row

				   totals[i]+=parseInt( $(this).html() );//Add up all the values inside the cells in one collum
				   //console.log("total"+totals[i]);
               });
             });
			
			//console.log(totals);	 
            $("#stackedChartTable td.totalCol").each(function(i){//Populate the table with the totals of the collums		
               $(this).html(totals[i]);
            });
				 
			//Set options for chart.
			var options = {
				isStacked: true, 
				vAxis: {    
				  title: 'Number of students',
				},
				hAxis: {
				  title: "Students responses",
				  slantedText: true,  // Enable slantedText for horizontal axis
				  slantedTextAngle: 90, // Define slant Angle 
			   },
			   height: 700,
			   'chartArea': {
				 "left":"10%",
				 "top":"20",
				 'width': '99%',
				 "margin-right":"10px",
				 "padding":"0px"
				},
				"bar": {
				  "groupWidth": "75%"
				},
				'legend': {
				  'position': 'bottom'
				}
			}; 
			
			//Instantiate and draw the chart
			var chart = new google.visualization.ColumnChart(document.getElementById('stackedChartHolder'));
			chart.draw(data, options);

			 $(document).ready(function () {
				 $(window).resize(function(){
				 stackedChartQuestionnaireResponse()
			 });
			});
		 },
		 error: function(XMLHttpRequest, textStatus, errorThrown){ 
		 
             //alert("Status: " + textStatus); 
			 //alert("Error: " + errorThrown);
         }  
	  });
  }
function likertQuestionnaireResultsCount(data){//Used to calculate the number of responces for the pre and post study questionnaires Likert scale questions - used in the stackedChartQuestionnaireResponse() function 
	
	var resultArray = [data[0], 0 ,0,0,0,0];
	
	for (var i = 0; i < data.length; i++){
		//alert(data[i]);
		switch(data[i]){
			case "Strongly agree":
			resultArray[1]++;
			break;
			case "Agree":
			resultArray[2]++;
			break;
			case "Neither agree nor disagree":
			resultArray[3]++;
			break;
			case "Disagree":
			resultArray[4]++;
			break;
			case "Strongly disagree":
			resultArray[5]++;
			break;
			default:
			break;
		}	
    }
	
   var results = "<tr><td>"+resultArray[0]+"</td><td class='rowDataSd'>"+resultArray[1]+"</td><td class='rowDataSd'>"+resultArray[2]+"</td><td class='rowDataSd'>"+resultArray[3]+"</td><td class='rowDataSd'>"+resultArray[4]+"</td><td class='rowDataSd'>"+resultArray[5]+"</<tr>";	
   $("#stackedChartTableBody").append(results);//Display result in table
   return resultArray;	
}  

/////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////
    
   var userScoresArray;	 

	function getAllUserScores(){//Get data to populate the collum chart that shows all the user average quiz scores - is used in the drawStudentsQuizScoresChart function 
	  var getAllData = 5;		  
	  jQuery.ajax({
		url: 'includes/getusers.php',
		dataType: "json",
		type: "post",
		data: {getAllData:getAllData},		
		 success: function(response){	

			var results = response["total_score_array"];
			var allUsersScoresForAverageScoreBarchart = new Array();
			
			var currentQuizName = $("#allUserScoresQuizSelect").val();
			
			for(var c = 0;  c < response["parent"].length; c++){
			
				if(response["parent"][c]["data"] == currentQuizName){
					allUsersScoresForAverageScoreBarchart.push(response["parent"][c]);
				}
			}		
						
			$("#allUserScoresCollumLegend").css("display","block");
			userScoresArray = allUsersScoresForAverageScoreBarchart;
			drawStudentsQuizScoresChart(userScoresArray);
		 }
	   });
	}	
  function drawStudentsQuizScoresChart(userScoresArray){//Draw the collum chart that shows all the users average scores - gets data from the getAllUserScores function

	  var data = new google.visualization.DataTable();
	  var onlineStudentMeanGrade = 0;
	  var onlineStudentCounter = 0;
	  var classroomStudentMeanGrade = 0;
	  var classroomStudentCounter = 0;
	  
      data.addColumn('string', 'User name');
      data.addColumn('number', 'Score');
      data.addColumn({ type: 'string', role: 'style' });

	  if (typeof userScoresArray !== 'undefined'){
		 
		  data.addRows(userScoresArray.length);
		
		  for(var i = 0; i < userScoresArray.length; i++){//Add the collums to the  line chart		
			
			data.setValue(i, 0, userScoresArray[i]["userName"]);
			data.setValue(i, 1, userScoresArray[i]["status"]);		
			
			if(userScoresArray[i]["userRole"] == "classgroupstudent"){
				
				data.setValue(i, 2, 'color: red');
                classroomStudentMeanGrade += parseInt(userScoresArray[i]["status"]);
//console.log("class"+classroomStudentMeanGrade);
			
                classroomStudentCounter++;				
			}else{				
				data.setValue(i, 2, 'color: green');
				onlineStudentMeanGrade += parseInt(userScoresArray[i]["status"]);
				//console.log("online"+userScoresArray[i]["status"]);
				
				onlineStudentCounter++;
			}
		  }	 
		   $("#classroomStudentMeanGrade").html(classroomStudentMeanGrade/classroomStudentCounter);
		   $("#onlineStudentMeanGrade").html(onlineStudentMeanGrade/onlineStudentCounter);
		}

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,{ 
		  calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation" },
        2]);

        var options = {
          title: userScoresArray[0]["data"]+" results",
	       hAxis: {
	         title: 'User name'
	       },
	       vAxis: {
	         title: 'User average score'
	      },
          height: 400,
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
        };	  
		var container = document.getElementById('chart_div1');
		container.style.display = 'block';//Hide the chart when the page first loads
		var chart = new google.visualization.ColumnChart(container);
        chart.draw(view, options);
  }
  
/////////////////////////////////////////////////////////////////////////////////////////////////
  
  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 
  function showDays(firstDate,secondDate){//Get number of day between dates
      var startDay = new Date(firstDate);
	  var endDay = new Date(secondDate);
	  var millisecondsPerDay = 1000 * 60 * 60 * 24;
	  var millisBetween = startDay.getTime() - endDay.getTime();
	  var days = millisBetween / millisecondsPerDay;
	  return (Math.floor(days));
  }	
  
//////////////////////////////
  
  function convertToMin(timeLoggedOn){//Convert total time online to days, hours and minutes      	
	var seconds = parseInt(timeLoggedOn, 10);           
	var days = Math.floor(seconds / (3600*24));
	seconds -= days*3600*24;
	var hrs = Math.floor(seconds / 3600);
	seconds -= hrs*3600;
	var mnts = Math.floor(seconds / 60);
	seconds -= mnts*60;	
	return days+" days, "+hrs+" Hrs, "+mnts+" Minutes, "+seconds+" Seconds";		
  }
  
//////////////////////////////
 
 function getMondays(date) {		
	 var day = date.getDay() || 7;
	 if( day !== 1 ) 
		date.setHours(-24 * (day - 1)); 
		date.setHours(0,0,0,0);
	 return date;
  }
  
 function getEndOfWeek(date) {
   date = getMondays(new Date(date))
   date.setDate(date.getDate() + 6);
   return date; 
 }	
//////////////////////////////

//Used to show website users online time in the #showUserOnlineTime table - get data from the getusers.php page
	function ajaxRequestGetOnlineTime(){
			
	     	var userId = $("#mySelect").val();//Used to select the user who time is being shown

			jQuery.ajax({
			url: 'includes/getusers.php',
			dataType: "json",
			type: "post",
			data: {userId:userId},		
			 success: function(response){//Get the times the user has been logged on
			
			  var startTime = response["start_time"];
			  var endTime = response["end_time"];
			  var results = "";
			  var timeLoggedOnPerWeek = 0;
			  var timeLoggedOn = 0;
			  var numberTimesLoggedOnPerWeek = 0;
			  var x = 0;
		      var deleteIndex = 0;	  
			  var TestResultsForSeparateWeeks = new Array();		  
			  
			  startTime = startTime.filter(function(currentValue, currentIndex, array){		  
			     if(endTime[currentIndex] != '0000-00-00 00:00:00'){//Test to remove start dates that do not have end dates							 
						 return currentValue;
				  }
			  });
				
			  endTime = endTime.filter(function(currentValue, currentIndex, array){			  
			      if(currentValue != '0000-00-00 00:00:00'){//Test to remove end dates that are blank				 
					 return currentValue;
				  } 
			  });
			  
			  while(startTime.length > 0){//Loop though all the dates in the array until all the dates have been removed
					 
				   timeLoggedOnPerWeek = 0;	
                   numberTimesLoggedOnPerWeek = 0;
				   
				   var weekQuizzess = startTime.filter(function(currentValue, currentIndex, array){//All the logins conducted in one week
						 
                        var first_date = new Date(array[0].replace(/-/g,"/"));//Convert from  mysql database format
						first_date = getMondays(new Date(first_date));
												
						var start_date = new Date(currentValue.replace(/-/g,"/"));
						var end_date = new Date(endTime[currentIndex].replace(/-/g,"/"));
						
						var lastDate = showDays(first_date, start_date);//Get number of days between the mondays of the first date in the array and the other values in the array;
						
						if(parseInt(lastDate) > -8){//Used to get the index value of all the logins conducted seven days after the first date in the array  
						
							  deleteIndex = currentIndex;
							  var diff = Math.abs(new Date(start_date) - new Date(end_date));//Get differnce between login and logout time	
							  var secounds = Math.floor((diff/1000));				
							  timeLoggedOnPerWeek += secounds;
                              numberTimesLoggedOnPerWeek++;	
                              //console.log("<br>"+secounds+"="+timeLoggedOnPerWeek);							  
							  return currentValue;
						}					
				     });
					 
					startTime.splice(0, deleteIndex + 1);//Remove all the used dates
					endTime.splice(0, deleteIndex + 1);			   
				   
					TestResultsForSeparateWeeks[x] = new Array();
					TestResultsForSeparateWeeks[x][0] = weekQuizzess;//Add all the logins conducted in the differnt weeks into a mutli-dimmentinall array 		   		   
					TestResultsForSeparateWeeks[x][1] = timeLoggedOnPerWeek;//Add the time logged in into the array
                  
				    //console.log(TestResultsForSeparateWeeks[x]);
					
					//if(TestResultsForSeparateWeeks[x][1] == 0){
					   //alert("This user has not logged in");
					   //$("#userOnlineTimeHide").toggleClass("hide");	 
					   //$("#showUserOnlineTime").html(+"0 days, 0 Hrs, 0 Minutes, 0 Seconds");
					  // x++;	
					  // break;
					//}
								
					var totalTimeString1 = convertToMin(TestResultsForSeparateWeeks[x][1]);//Convert total time logged on to days, hours and minutes  
		            //console.log("<br>"+totalTimeString1);
		
				    var start_date = new Date(TestResultsForSeparateWeeks[x][0][0].replace(/-/g,"/"));
					var myDate = getMondays(new Date(start_date));//Get the monday in the week the user logged in					
				    myDate = myDate.getDate() + '/' + ((myDate.getMonth() + 1) + '/' + myDate.getFullYear());//Converted date to uk format   
					   
					results += "<tr><td>"+myDate+"</td><td>"+numberTimesLoggedOnPerWeek+"</td><td>"+totalTimeString1+"</<tr>";//Add the monday of and number of hours conducted in the week 
					timeLoggedOn += TestResultsForSeparateWeeks[x][1];
					x++;	
		     }		
				var totalTimeString = convertToMin(timeLoggedOn);//Display total time logged on
				
				$("#showTotalTimeLoggedOn").html(totalTimeString);				
				$("#showUserOnlineTime").html(results);//Display result in table
										
		 },error: function(XMLHttpRequest, textStatus, errorThrown){
		    //alert(errorThrown); 
		 }				
		});		
	}
	
////////////////////////////////////////////////////////////////////////////

//Used to show the average grades for the users website quizzes in the #showAllUsers table, and the all the users results for the website quizzes in the #userScoreAverage table - get data from the getusers.php page	
	function ajaxRequestGetUserQuizData(){
	
		var quizIndex = $("#mySelectQuiz").val();//User can change the quizz that apears with the drop down menu		  
		var quizsId = $("#mySelect").val();//Used to select the user whos quizz  data is going apear with the drop down menu		  
	    var mondaysOfTests = [];
		var averageScoreArray = [];
		
		jQuery.ajax({
		url: 'includes/getusers.php',
		dataType: "json",
		type: "post",
		data: {quizId:quizsId},		
		success: function(response){//Show the selected quiz

		  var quizAllDataArray = response["records"][0];//quizDatesArray1["quizid"], quizDatesArray["date"],quizDatesArray["user_score"],quizDatesArray["user_max_score"]
		  //console.log(quizAllDataArray);
		  
		  var userScoresArray = quizAllDataArray["user_score"];
		  var userMaxScoresArray = quizAllDataArray["user_max_score"];
         		  
		  var quizTypeQuiz = quizAllDataArray["date"].filter(function(currentValue,currentIndex,array){//Remove all the results from all the quizzess not being shown - change with the #mySelectQuiz select
			if(quizAllDataArray["quizid"][currentIndex] == quizIndex){
			  return currentValue;						
			}				
		  })
		  
		  var quizDatesArray = quizTypeQuiz;				  		  
		  var TestResultsForSeparateWeeks = new Array();
		  var results = "";	
		  var x = 0;
		  var deleteIndex = 0;
		  var userScoreAverage = 0;
		  var userCurrentScore = 0;
		  var userMaxScore = 0;		 
		  
		  while(quizDatesArray.length > 0){//Loop though all the dates in the array until all the dates have been removed
		  
			 var weekQuizzess = quizDatesArray.filter(function(currentValue, currentIndex, array) {//All the quizzess conducted in one week
				  
					var first_date = new Date(array[0].replace(/-/g,"/"));//Convert first date in array from  mysql database format
					first_date = getMondays(new Date(first_date));
					
					var start_date = new Date(currentValue.replace(/-/g,"/"));
					
					var lastDate = showDays(first_date, start_date);//Get number of days between the monday of the first date in the array and the other values in the array					
			  
				  if(parseInt(lastDate) > -8){//Used to get the index value of all the quizzess conducted seven days befor the first date in the array
					  
					  userCurrentScore += parseInt(userScoresArray[currentIndex]);
					  userMaxScore += parseInt(userMaxScoresArray[currentIndex]);
					  deleteIndex = currentIndex;
					  return currentValue;
				  }
			  })
		
			 userScoreAverage = Math.floor((userCurrentScore / userMaxScore)  * 100);//Caculate average score of all quizzes from the weeek		 
			 quizDatesArray.splice(0, deleteIndex + 1);//Remove all the used quizzes  			 
			 userScoresArray.splice(0, deleteIndex + 1);//Remove all the used quizzes scores
			 userMaxScoresArray.splice(0, deleteIndex + 1);//Remove all the used quizzes scores
						 
			 TestResultsForSeparateWeeks[x] = new Array();
			 TestResultsForSeparateWeeks[x][0] = weekQuizzess;//Add all the quizzess conducted in the differnt weeks into a mutli-dimmentinall array 			 
			 var numberQuestions = TestResultsForSeparateWeeks[x][0].length;//Number of quizz conducted is the same as the length of the array
			 
			 var start_date1 = new Date(TestResultsForSeparateWeeks[x][0][0].replace(/-/g,"/"));
			 var myDate2 = getMondays(new Date(start_date1));			
			 myDate2 = myDate2.getDate() + '/' + ((myDate2.getMonth() + 1) + '/' + myDate2.getFullYear());//Converted date to uk format   
            
			 mondaysOfTests.push(myDate2);
			 averageScoreArray.push(userScoreAverage);

			 results += "<tr><td>"+myDate2+"</td><td>"+numberQuestions+"</td><td>"+userScoreAverage+"%</td><tr>";//Add the first date, the number of quizzess conducted and the average score from the week to a string
			 x++;//Incriment to the next value in the mutli-dimmentinall array 
			 userTotalScore = 0;
			 userCurrentScore = 0;
			 userMaxScore= 0;
		}				  
		$("#userScoreWeek").html(results);//Display the first date, the number of quizzess conducted and the average score from the week on the screen	  
		  
		 var AllQuizDataString = response["all_user_quiz_data"];//Show all the quiz data  - stored in one string
		 $("#showAllUsers").html(AllQuizDataString);
		 
		 lineChartWeeklyScoresAverageDates = mondaysOfTests;
		 lineChartWeeklyScoresAverageScores = averageScoreArray;
		 
		 if(formLoaded > 0){//Load the chart after the chart finishes loading
		    drawlineChartWeeklyScoresAverage(lineChartWeeklyScoresAverageDates, lineChartWeeklyScoresAverageScores);//Load line chart of users weekly average score
		 }
	  
		 var totalScoreArray = response["total_score_array"];//Show the average grade of all the quizzess
		 $("#userScoreAverage").html(totalScoreArray);
		 //console.log(totalScoreArray);
		},
		  error: function(XMLHttpRequest, textStatus, errorThrown) {
			 //alert("Student has not conducted any quizzes");
			 $('#mySelect').prop('selectedIndex',0);
		}		
	});//End ajax
   }
   
   var lineChartWeeklyScoresAverageDates;//Array used to hold the user weekly scores averages - the array is updated in the ajaxRequestGetUserQuizData function
   var lineChartWeeklyScoresAverageScores;
   
   //Used to draw a cullum chart for the average grades for the users website quizzes in the #showAllUsers table, - is used by the ajaxRequestGetUserQuizData() function
   function drawlineChartWeeklyScoresAverage(mondaysOfTests,averageScoreArray){
			  
		var data = new google.visualization.DataTable();  
		data.addColumn('string', 'Date');//Add the chart rows, x axis is date and y axis is users average score
		data.addColumn('number', 'Average score');
		
		if (typeof mondaysOfTests !== 'undefined'){
		 
		  data.addRows(mondaysOfTests.length);
		
		  for(var i = 0; i < mondaysOfTests.length; i++){//Add the collums to the  line chart		
			 data.setValue(i, 0, mondaysOfTests[i]);
			 data.setValue(i, 1, averageScoreArray[i]);
		  }	  
		}
		var options = {
			   title: 'User quizzes average scores per week',
			hAxis: {
			  title: 'Date'
			},
			vAxis: {
			  title: 'User score'
			},
			backgroundColor: '#f1f8e9'
		  };
		  var container = document.getElementById('chart_divs');
		  container.style.display = 'block';//Hide the chart when the page first loads
		  var chart = new google.visualization.LineChart(container);
		  google.visualization.events.addListener(chart, 'ready', function () {
			container.style.display = 'block';
		  });
		  chart.draw(data, options);		  
	}

  ////////////////////////////////////////////////////////////
  
  
  
  
  
  /////////////////////////////////////////////////////	
	
	 $('#mySelect').change(function(){ 
		 ajaxRequestGetUserQuizData();		 
		 if ( !$("#userOnlineTimeHide").hasClass( "hide" ) ) {//If the user online time is being displayed, update the time a user has logged into to the new users time
		    ajaxRequestGetOnlineTime();
		 }
	 });
			
	 $('#mySelectQuiz').change(function(){ 
		 ajaxRequestGetUserQuizData();		 
	});	
	$('#allUserScoresQuizSelect').change(function(){ 
		getAllUserScores();	 
    });	  
		
	 $(document).on("click","button", function(){

		 if(this.id == "getUserOnlineTime"){
	
		   $("#"+this.name).toggleClass("hide");	 
		   ajaxRequestGetOnlineTime();//Show the time a user has been logged on
		   
		   if($("#"+this.id).text() == "Get User Online Time" ){
			   
			   $("#"+this.id).text("Hide User Online Time")
			   
		   }else if ($("#"+this.id).text() == "Hide User Online Time" ){
			   
			   $("#"+this.id).text("Get User Online Time")
		   }	  
		   
		}else if (this.id != "getUserOnlineTimes"){
			
		   if ($("#"+this.id).text() == "Show All The Website Users Average Quiz Scores" ){
			    $("#"+this.id).text("Hide All The Website Users Average Quiz Scores");
				return;
			}else if ($("#"+this.id).text() == "Hide All The Website Users Average Quiz Scores" ){
			    $("#"+this.id).text("Show All The Website Users Average Quiz Scores");
				return;
			}
		   
		   $("#"+this.name).toggleClass("hide");
	  
		  if($("#"+this.id).text() == "Show All The Users Quiz Scores" ){
			   
			   $("#"+this.id).text("Hide All The Users Quiz Scores");
			   
		   }else if ($("#"+this.id).text() == "Hide All The Users Quiz Scores" ){
			   
			   $("#"+this.id).text("Show All The Users Quiz Scores");
		   }	   	  
		  else if($("#"+this.id).text() == "Show User Quizzes Average Scores" ){
			   
			   $("#"+this.id).text("Hide User Quizzes Average Scores");
			   
		   }else if ($("#"+this.id).text() == "Hide User Quizzes Average Scores" ){
			   
			   $("#"+this.id).text("Show User Quizzes Average Scores");
		   }
		  else if($("#"+this.id).text() == "Show User Quizzes Average Scores By Date" ){
			   	   
			   $("#"+this.id).text("Hide User Quizzes Average Scores By Date");
			   
		   }else if ($("#"+this.id).text() == "Hide User Quizzes Average Scores By Date" ){
				
			    $("#"+this.id).text("Show User Quizzes Average Scores By Date");
			}
	     }
	 });
	 
//////////////////////////////
  
  });
</script>

