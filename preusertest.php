<?php
include"databasephp/db.php";
include"includes/header.php";
include"includes/navigation.php";

if(!is_logged_in()){	
	header("Location: index.php");
}
if($_SESSION['completed_Pre_Study_Questionnaire'] == "1"){//Stop the user conducting the test more than once
	 
	header("Location: index.php");  
	 
}	
?>
<header>
<h1>Student pre-study questionnaire </h1>
</header>
<hr>

<form action ="" multiple="multiple"  method ="post"  enctype="multipart/form-data">

<style>
label {
    font-weight: 100;
}
</style>

<div class="form-group">
<label>Have you ever undertaken any additional online learning outside your course i.e. MOOCs, or other online courses?
</label>
<select id="selectExperence">
   <option value="0">No</option>
   <option value="1">Yes</option>
</select>
</div>
<div class="form-group hide" id="preOnlineCourseExperienceFrequency">
<label>When did you conduct this learning:
</label>
<br>  
<label>       
	<input type="radio" name="length" value="1" checked="checked">This month</label> 
	<label><input type="radio" name="length" value="3">Within the last 1-3 months</label>
	<label><input type="radio" name="length" value="6">Within the last 3-6 months</label> 	
    <label> <input type="radio" name="length" value="other"> Other  <input type="number" name="lenth" id="lenthOther" /> months</label> 	
</div>


<div class="form-group">
<label>What teaching method do you believe is the most effective?
</label>
<select id="selectTeachingMethod">
   <option value="Classroom">Classroom based (the teaching is conducted inside a classroom)</option>
   <option value="online">Online (the teaching is conducted online)</option>
   <option value="blended">Blended learning (using a mixture of online and classroom based learning)</option>
</select>
</div>

<div class="form-group">
<label>I find the current on-line learning available for my course (i.e. the Moodle) easy to use:</label>
<select id="selectEasyUse">
   <option value="Strongly agree">Strongly agree</option>
   <option value="Agree">Agree</option>
   <option value="Neither agree nor disagree">Neither agree nor disagree</option>
   <option value="Disagree">Disagree</option>
   <option value="Strongly disagree">Strongly disagree</option>
</select>
</div>

<div class="form-group">
<label>I find the current on-line learning available for my course (i.e. the Moodle) well organised:</label>
<select id="selectOrganised">
   <option value="Strongly agree">Strongly agree</option>
   <option value="Agree">Agree</option>
   <option value="Neither agree nor disagree">Neither agree nor disagree</option>
   <option value="Disagree">Disagree</option>
   <option value="Strongly disagree">Strongly disagree</option>
</select>
</div>

<div class="form-group">
<label>I find the current on-line learning available for my course (i.e. the Moodle) useful and helps me to learn:</label>
<select id="selectHeplful">
   <option value="Strongly agree">Strongly agree</option>
   <option value="Agree">Agree</option>
   <option value="Neither agree nor disagree">Neither agree nor disagree</option>
   <option value="Disagree">Disagree</option>
   <option value="Strongly disagree">Strongly disagree</option>
</select>
</div>

<div class="form-group">
<label>I find the current on-line learning available for my course (i.e. the Moodle) complements the  class based lectures:
</label>
<select id="selectComplements">
   <option value="Strongly agree">Strongly agree</option>
   <option value="Agree">Agree</option>
   <option value="Neither agree nor disagree">Neither agree nor disagree</option>
   <option value="Disagree">Disagree</option>
   <option value="Strongly disagree">Strongly disagree</option>
</select>
</div>

<div class="form-group" id="selectExtraHours">
<label>How much time do you spend studying outside class per week?
</label>
<br>  
<label>       
	<input type="radio" name="time" value="2" checked="checked">Less than 2 hours</label> 
	<label><input type="radio" name="time" value="2-5">2-5 hours</label>
	<label><input type="radio" name="time" value="5-7">5-7 hours</label> 	
    <label> <input type="radio" name="time" value="other"> Other  <input type="number" name="time" id="timeOther" /> hours </label> 	
</div>


<div class="form-group">
<label>What additional things would you like to see in an on-line learning resource website?</label>
  <textarea style="border:solid 1px black" type="text" name="studentResource" id="studentResource" class="form-control"></textarea>
</div>

<div class="form-group">
   <input class="btn btn-primary" type="submit" value="submit" id="submitData">
</div>

</div>
</form>

<script>
$(document).ready(function(){


	 $("#selectExperence").change(function(){
		 
		 $("#preOnlineCourseExperienceFrequency").toggleClass("hide");
		 
		 if($("#selectExperence").val()!= "online"){
 
              var preOnlineCourseExperienceFrequency = "";
		 }
		 
	});	
	
	$("#submitData").on("click",function(e){
	event.preventDefault();
	
		var testName = "preTest";		
		
		var preOnlineCourseExperienceFrequency = $("input[name='length']:checked").val();		
		if(preOnlineCourseExperienceFrequency == "other"){		
		 preOnlineCourseExperienceFrequency = $("#lenthOther").val();
		}	
		
		var	selectExperence = $("#selectExperence").val();
		if($("#selectExperence").val()!= "1"){
		 preOnlineCourseExperienceFrequency = "";
	    }	
		
		var selectTeachingMethod = $("#selectTeachingMethod").val();
		
		var selectComplements = $("#selectComplements").val();
		var selectHeplful = $("#selectHeplful").val();
		var selectOrganised = $("#selectOrganised").val();
		var selectEasyUse =  $("#selectEasyUse").val();
		
		var selectExtraHours = $("input[name='time']:checked").val();
		 if(selectExtraHours == "other"){		
		  selectExtraHours = $("#timeOther").val();
		  if( selectExtraHours == ""){
			  alert("Length of time studying can not be empty");
			  return;
		  }
		}	

	    var studentResource = $("#studentResource").val();
				
		$.ajax({//Save score in database 
		type: "POST",
		url: "databasephp/savestudyquestionnaires.php",
		data: {testName:testName, selectExtraHours:selectExtraHours, selectComplements:selectComplements, selectHeplful:selectHeplful, selectOrganised:selectOrganised, studentResource:studentResource, selectEasyUse:selectEasyUse, selectTeachingMethod:selectTeachingMethod, selectExperence:selectExperence, preOnlineCourseExperienceFrequency:preOnlineCourseExperienceFrequency},	
		success:function(msg) {
			//alert(msg);	
		    alert("You questionnaire has been submitted");
			//location.reload();//Reload page to remove the php session that allows the user to conduct the quiz 					
		 }
		});				
	});
	
	
});
</script>		
<?php include"includes/footer.php";//Page footer include ?>