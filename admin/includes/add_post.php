<!--- 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/
--><style>
#errorQuestionOne,
#errorQuizQuestion,
#errorQuestionNumber{
	color:red;
	display:none;
}
</style> 

<div id="jumpPoint"></div>
<div class="container-fluid">
  <div class="col-lg-12">

	<h2>Add Post</h2>
 
	  <div class="container">
         			
		 <form action = ""  multiple="multiple" method="post" enctype="multipart/form-data">
	
			<div class = "form-group">
			<label for= "post_categories">Post Name</label>
			 <input  type="text" name="postName" id="postName" class="form-control inputBox" placeholder="Enter post name" value="">
			  <h4 id="errorPostName">Post name cannot be empty.</h4>				 
			</div>
				
			<div class = "form-group">
			<label for= "post_categories">Post Category</label>
			<br>
			<select name="postCategories" id="postCategories" type = "text" class="form-control">
			</select>
			</div>
			
			<div class = "form-group">
			<label for= "post_categories">Post  Author</label>
			<br>
			<select name="postAuthor" id="postAuthor" type = "text" class="form-control">
			</select>
			</div>
			
			<div class = "form-group">
			   <label for= "post_status">Post Status</label>
			   <select type = "text" class="form-control" name = "post_status" id="postStatus">		
			      <option value= "published"> published </option>
			      <option value= "draft"> draft </option>
			   </select>
		    </div>

	

            <div id="status"></div>
			<div class = "form-group">
				<label for= "post_content">Post Content</label>
				<textarea class="form-control" name = "postContent" id="postContent" cols="30" rows="10">
				</textarea>
			</div>	
		
			
             </form>  
			    </div> 
			 
			 
			 <div class="container">		
					  <form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
						<div class = "form-group">
						<label for= "post_content">Post External Page Links</label>
						 <input  type="text" type="number_format" name="externalLinkNameNumber" id="externalLinkNameNumber" class="form-control inputBox" placeholder="Enter number of links">
						 <h4 id="errorQuestionNumber">Number of links cannot be empty.</h4>
						</div>
				
						<div class = "form-group">
						  <input class = "btn btn-primary" type = "submit" value="Add next link" id = "showHiddenForm">
						</div> 
					   </form>
				   </div><!-- /.row -->
				
				 <div class="container">
				  <form id="hiddenForm"  action = ""  multiple="multiple" method="post" enctype="multipart/form-data">
		
					<p id="currentQuestion"> Link 1</p>
					<div class = "form-group">
					 <input  type="text" name="externalLinkName" id="externalLinkName" class="form-control inputBox" placeholder="Enter the link name">
					 <h4 id="errorQuizQuestion">Link name cannot be empty.</h4>
					</div>
					
					<div class = "form-group">
					 <input  type="text" type="number_format" name="externalLinkHref" id="externalLinkHref" class="form-control inputBox" placeholder="Enter the link href" >
					 <h4 id="errorQuestionOne">Quiz href cannot be empty.</h4>
					</div>
								
					<div class = "form-group">
					 <input class = "btn btn-primary" type = "submit" name ="createQuiz" value="Next" id ="createQuiz">
					</div> 
				   </form>
				</div><!-- /.row -->
		        <form id="uploadImage" action="" method="post" enctype="multipart/form-data">
					<div class = "form-group">
						<div id="image_preview"> <img width="100" alt="user image placeholder" id="previewing" src="../images/rain.jpg" />
						</div>
						<hr id="line">
						<div id="selectImage">
						</div>
					</div>
					<div id="imageBox" class = "form-group">
						<label>Select A Image</label>
						<br><p> Image can not be larger than 50 mb size and the image format has to be a jpg or png or jpeg 
						<br>If you add a image you cannot create the post until you have clicked the submit button<br>
						Please only upload copyright free images since the website will not be held response if you do upload the image
						<br></p>

						<input id="imageFile" type="file" name="sortpic" required />
						<button id="upload" type="submit" value="Upload" class="submit">Submit</button>
						<div class="progress">
							<div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
						</div>
					</div>	 
					<div id="message"></div>
                </form>
	   
	   	     <form id="uploadvideo" action="" method="post" enctype="multipart/form-data">	
				<div class = "form-group">
					<label>Select A Post Video</label><br>
					Videos cannot be bigger than 50 mb (you cannot upload more than one video) <br> If you add a video you cannot create the post until you have clicked the submit button<br>
					<input id="videoFile" type="file" name="videoFile" required />
					<button id="uploadTwo" type="submit" value="Upload" class="submit">Submit</button>
				</div>
				<div class="form-group">
					<div class="progress">
						<div class="progress-bar progress-bar-success myprogress2" role="progressbar" style="width:0%">0%</div>
					</div>
				</div>
				   <div id="message1"></div>
		   </form>
	   
		<div class = "form-group">
			<input class = "btn btn-primary" type = "submit" value="Submit" id = "submitPost">
		</div> 
			 
			 
  

</div>
  
<script>		
$("document").ready(function(){


	    var populatePageDropDowns = "populatePageDropDowns";
	    ///Populate page dropdown menus(post author, post catagory and post status) with data from database
		jQuery.ajax({
			url: '../admin/includes/addpostphpcode.php',
			dataType: "json",
			type: "post",
			data: {populatePageDropDowns :populatePageDropDowns },		
			 
			 success: function(response){
						
			   for(var x = 0; x < response["cat_id_array"].length; x++ ){
					    
				   $('#postCategories').append($('<option>', {value:response["cat_id_array"][x], text:response["cat_title_array"][x]}));	
			    }		 
				for(var x = 0; x < response["user_id_array"].length; x++  ){
					    
				   $('#postAuthor').append($('<option>', {value:response["user_id_array"][x], text:response["user_name_array"][x]}));	
			    }
			   },
             complete: function() {
             }
		});	



 var form_data = "";	
 var file_data  = ""; 
 var errorMessage = "";
 
  	//Submit video file
	var video = "";
	$('#uploadTwo').on('click', function(e) {
	
	e.preventDefault();
	if ($('#videoFile').val() == '') {//Stop the user submiting until they have uploaded the required file              
	  alert("Select a video");
	  return;
    }
	 $('.myprogress2').css('width', '0');
     $('#message1').text('');
	
	$("#uploadTwo").attr("disabled","disabled");//Stop user uploading two image
  	file_data = $('#videoFile').prop('files')[0];   			
	form_data = new FormData();                  
	form_data.append('file', file_data);
	form_data.append('type', 'video');
	$('#message1').text('Uploading in progress...');
	
		if(file_data != ""){
			$.ajax({
				url: '../admin/includes/addpostphpcode.php', // point to server-side PHP script 
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',  //Progress bar for upload
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress2').text(percentComplete + '%');
                                    $('.myprogress2').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
				success: function(result){
       
				 if(result == "Video can not be larger than 50 mb size and the video format has to be a mp4"){
				    
					$("#uploadTwo").prop( "disabled", false );	
					$('.myprogress2').css('width', '0');
                    $('#message1').text('');
					alert("File was not upload");
					alert("Video can not be larger than 50 mb size and the video format has to be a mp4");
								
			        return;
					
				 }else if(result == "File already exists"){

					$('.myprogress2').css('width', '0');
                    $('#message1').text('');
					$("#uploadTwo").prop( "disabled", false );
					alert("File was not upload");
					alert("File name is being used - please change the file name and reupload");
					return;
				 }
				 else{
               					
						$('#message1').text('');
						$("#videoFile").val('');	
						$('.myprogress2').css('width', '0');
                        $('#message1').text('');
						alert("File uploaded");
						//$("#uploadvideo").hide( "fast" );
						video = result;	
				  }
				}
			});
	   }	
	});   
	//Submit image
     var image = "";	
	$('#upload').on('click', function(e) {
		
		e.preventDefault();
		 
		 if ($('#imageFile').val() == '') {//Stop the user submiting until they have uploaded the required file 
				  
			  alert("Select an image");
			  return ;
		} 
	  
	    $("#upload").attr("disabled","disabled");//Stop user uploading two image
		file_data = $('#imageFile').prop('files')[0];   
		form_data = new FormData();                  
		form_data.append('file', file_data);
		form_data.append('type', 'image');
		$('.myprogress').css('width', '0');
        $('#message').text('Uploading in progress...');
		$.ajax({
			url: '../admin/includes/addpostphpcode.php', // point to server-side PHP script 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',  //Progress bar for upload
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
			success: function(result){
				
			 if( result == "Image can not be larger than 50 mb size and the image format has to be a jpg or png or jpeg"){
				  
				alert("File was not upload");
				alert("Image can not be larger than 50 mb size and the image format has to be a jpg or png or jpeg");
				$('.myprogress').css('width', '0');
		     	$("#imageFile").val('');
				$("#upload").prop( "disabled", false );
				
			    return;
				
			  }
			  else if(result == "File already exists"){
					 
				alert("File was not upload");
			    alert("File name is being used - please change the file name and reupload");
				$('.myprogress').css('width', '0');
		     	$("#imageFile").val('');
				$("#upload").prop( "disabled", false );
			    return;
			  }		
             else{
                image = result;		
				$('#message1').text('');
				$("#imageFile").val('');
				$('#image_preview').css("display", "none");
	            //$("#imageBox").hide( "fast" ); 
                alert("File uploaded");	
             }
			}
		 });
	});
	
	
$(function() {
		$("#videoFile").change(function() {
			if ($("#videoFile").val() == "") {
				return;	
			}
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["video/mp4"];
			
			if(!((imagefile==match[0])))
			{
				alert("Please select a mp4 file");
				$("#videoFile").val('');
			    return false;		
			}	
		});
});
	
/////////////////////////////////////////////////////////////////////////////////////

	
	//Function to preview image after validation
	$(function() {
		
		$("#imageFile").change(function() {
			if ($("#imageFile").val() == "") { //Stop the user submiting until they have uploaded the required file 

					alert("Select an image");
					return;
				}
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg"];
			
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{
				$('#previewing').attr('src','../images/rain.jpg');
				alert("The file has to be  a jpeg, jpg or png images format and be smaller than 101 mb");
				$("#imageFile").val('');
			    return false;	
			}
			else
			{
				var reader = new FileReader();//Show iamge prevew
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}		
		});
	});
		
	function imageIsLoaded(e) {//Show iamge prevew
		$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
	};		
    $("#errorPostName").css('display', 'none');	
		
		
///////////////////////////////////////////////////////////////////////////////////

  var externalLinkNameString = "";
  var externalLinkHrefString  = "";
   
  $("#hiddenForm").css("display","none");
  var currentQuestion = 1;
	
	 $("#showHiddenForm").on("click", function(e) {
            event.preventDefault();
		    currentQuestion = 1;
		
	         externalLinkNameString = "";//Used to save the link name
			 externalLinkHrefString = "";//Used to save the link href
		 	 var questionNumber = $("#externalLinkNameNumber").val().trim();
	        
		    if(isNaN(questionNumber)){
	           alert("Question number has to be a number");
			   return;
            }
 
			if(questionNumber == ""){
			  event.preventDefault();
			  $("#errorQuestionNumber").css("display","inline"); //Show error message
			}
			

           if(questionNumber  !=""){
			
			  $("#showHiddenForm").css("display","none");
		  
		      $("#errorQuestionNumber").css("display","none"); 	
	          //Display boxes to input question ans answers using bootstrap ui effect
	          $("#hiddenForm").stop(true, true).show("clip", { direction: "vertical" }, 800).animate({ opacity: 1 }, { duration: 800, queue: false });
          }		
	   });	

	  $("#createQuiz").on("click", function(e) {
	       event.preventDefault();		   
		   var questionNumber = $("#externalLinkNameNumber").val();
		   var externalLinkName = $("#externalLinkName").val().trim();
	       var externalLinkHref = $("#externalLinkHref").val().trim();
 
           var QuizAnswers = ""; 
 
	        if(isNaN(questionNumber)){
			   alert("Question number has to be a number");
			   return;
			}
			if(questionNumber == ""){
			  event.preventDefault();
			  $("#errorQuestionNumber").css("display","inline"); //Show error message
			}	
			if(externalLinkName == ""){		
			  $("#errorQuizQuestion").css("display","inline"); //Show error message
			}	
		   			
			if(externalLinkHref == ""){
			  event.preventDefault();
			  $("#errorQuestionOne").css("display","inline"); //Show error message
			}	
		 
           if( questionNumber != "" &&  externalLinkName != "" &&  externalLinkHref != ""){

		      $("#errorQuestionNumber,#errorQuestionNumber,#errorQuizQuestion,#errorQuestionOne").css("display","none"); 
	          $("#hiddenForm").stop(true, true).show("clip", { direction: "vertical" }, 800).animate({ opacity: 0 }, { duration: 800, queue: false });
			  currentQuestion++;
			  
			  externalLinkNameString += externalLinkName+"~";//Used to save the result in a string
              externalLinkHrefString +=externalLinkHref+"~";
			  $("#externalLinkHref").val("");
			  $("#externalLinkName").val("");
			
			  if(currentQuestion <= questionNumber ){//Show next question in the question
				  
				  $("#currentQuestion").html("Link " + currentQuestion);
				  $("#hiddenForm").stop(true, true).show("clip", { direction: "vertical" }, 800).animate({ opacity: 1 }, { duration: 800, queue: false });
				  
			  }else{
				   console.log(externalLinkNameString);
				   console.log(externalLinkHrefString);
             
                  $("#hiddenForm").css("display","none");				  
			  }
			  
			  $("#showHiddenForm").css("display","inline-block");		  
		 }
			
	   });
	
	$("#submitPost").on("click", function(e) {//Add post useing ajax

	   event.preventDefault();	
	   
	  if ($('#videoFile').val() != '') {//Stop the user submiting until they have uploaded the required file 
              
		  alert("You cannot create the post until you have submitted the video");
		  return;
      }
	  if ($('#imageFile').val() != '') {//Stop the user submiting until they have uploaded the required file 
              
		  alert("You cannot create the post until you have submitted the image");
		  return;
      }

		var submitPost = "submitPost";
		var postName = $("#postName").val();;
		var postCategories = $("#postCategories").val();
		var postAuthor = $("#postAuthor").val();
		var postStatus = $("#postStatus").val();	
	    tinyMCE.triggerSave();
        var postContent = $("#postContent").val();
		if(postName == ""){
			$("#errorPostName").css('color', 'red');
			$("#errorPostName").css('display', 'block');
			document.getElementById("jumpPoint").scrollIntoView();//Scroll name box
			return;
		}else{
			$("#errorPostName").css('display', 'none');
		}  				 
			
		jQuery.ajax({
			url: '../admin/includes/addpostphpcode.php',
			dataType: "json",
			type: "post",
			data: {submitPost:submitPost,postName:postName,postCategories:postCategories,video:video,postAuthor:postAuthor,postStatus:postStatus,postContent:postContent,image:image,externalLinkNameString:externalLinkNameString,externalLinkHrefString:externalLinkHrefString,video:video},		
			 
			 success: function(response){
		
				//alert(response);
			    alert("Data added to database");	
				window.location = "posts.php";
				 	
			   },
             complete: function() {
			   // Schedule the next request when the current one's complete
			   //setTimeout(worker, 5000);
             }
		});	

	});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	//})();
});
</script>					

 <!-- /.container-fluid -->
 </div>		
	