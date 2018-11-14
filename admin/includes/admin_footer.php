<!-- 
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/jwjVpG
*/-->
<footer>
</footer>


<script>
$(document).ready(function(){
	//Tiny mc plugin for text boxes    
	tinymce.init({ selector:'textarea' });
    //Used to multi select tick box in admin pages
	$('#select_All_Boxes').click(function(event){ //Name of main multi select tick box being edited - runs when item is clicked
			
	if(this.checked){ //If the box is not selected
		
		$('.check_Boxes').each(function(){ //Select all the indivigual tick boxes of this class
			this.checked = true; //Make all the tick boxes ticked
		});   
		
	}else{
		
		$('.check_Boxes').each(function(){ //Class of indivigual tick boxes
		this.checked = false; //Deselect all the selected tick boxes
		});   
	}
  });

});//End of document.ready

</script>
 <!-- Latest compiled and minified JavaScript -->
<script src ='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'>
</script>
	
</body>

</html>