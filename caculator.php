<?php 
//Page header include
/*
*Title: Sam francis source code
*    Author: Francis, S
*    Date: 2017
*    Code version: 1
*    Availability:https://codepen.io/hollowsamff/pen/XaRPMB
*/
include"includes/header.php";
?>	

<style>
body{
  text-align:center; 
}
body{background-color:lightgray;
}

.buttons{
  
  width:40px;
  
}
#hide{
  display:none;
}
    </style>

<?php 
include"includes/navigation.php";
?>		

<header class="container">
  <h1 id="MainPageLink">Caculator</h1>
  </header>
  <div class="container">

    <div class="row">

      <div id="minus" value=""></div>

      <div id="oldSum" value=""></div>
      <div id="hide">=</div>
      <div id="oldAnswer" value=""> </div>

      <div class="col-md-12">

        <div class="box text-center" id="calBody">
          <form>
            <div class="form-group">
              <input type="text" value="" id="sum" disabled="disabled">

            </div>
            <div class="form-group">
              <button id="AC" class="buttons" class="btn btn-primary">AC</button>
              <button id="CE" class="buttons" class="btn btn-primary">CE</button>
              <button id="%" class="buttons" class="btn btn-primary" value="%">%</button>
              <button id="/" class="buttons" class="btn btn-primary" value="%">&divide;</button>
            </div>

            <div class="form-group">
              <button id="7" value="7" class="buttons" class="btn btn-primary">7</button>
              <button id="8" value="8" class="buttons" class="btn btn-primary">8</button>
              <button id="9" value="9" class="buttons" class="btn btn-primary">9</button>
              <button id="+" value="+" class="buttons" class="btn btn-primary">+</button>
            </div>

            <div class="form-group">
              <button id="6" value="6" class="buttons" class="btn btn-primary">6</button>
              <button id="5" value="5" class="buttons" class="btn btn-primary">5</button>
              <button id="4" value="4" class="buttons" class="btn btn-primary">4</button>
              <button id="*" value="*" class="buttons" class="btn btn-primary">*</button>
            </div>

            <div class="form-group">
              <button id="3" value="3" class="buttons" class="btn btn-primary">3</button>
              <button id="2" value="2" class="buttons" class="btn btn-primary">2</button>
              <button id="1" value="1" class="buttons" class="btn btn-primary">1</button>
              <button id="-" value="-" class="buttons" class="btn btn-primary">-</button>
            </div>

            <div class="form-group">
              <button id="0" value="0" class="buttons" class="btn btn-primary">0</button>
              <button id="." value="." class="buttons" class="btn btn-primary">.</button>
              <button id="=" value="=" class="buttons" class="btn btn-primary">=</button>

            </div>


          </form>
        </div>
      </div>
    </div>


  </div>

  <script >
    
	
//Has error when a minus number is input and then the CE button is pressed

$("document").ready(function() {
  //Stores maths answer string
  var sums = [];
  //First value in sum
  var before = 0;
  //Grand total of sum
  var newTotal = 0;
  //Stores the maths operator
  var sighn = "";
 
  function resetCalulator() {
    sums = [];
    before = 0;
    newTotal = 0;
    $("#sum").val("");
    $("#oldSum").html("");
    $("#oldAnswer").html("");
    $("#hide").css("display", "none");
  }

  $("button").on("click", function(e) {
    e.preventDefault();
    //Used to calulate the answer from the first two number ( i.e 2 + 5)
    var index = -1;
    //Used to calulate the grand total - every time a sum is done using index, the new total is added into the sum array
    var index2 = -1;
    var index3 = -1;
    var sum = 0;
    var selectedButton = this.id;
    var regex = /\+|\*|\%|[CE]|\-|\//g;

    var oldSumFull = "";
    var oldSum = "";
  
    oldSumFull = $("#oldSum").html() + selectedButton;
    oldSum = $("#sum").val() + selectedButton;
 
    switch (selectedButton) {
      //Store maths operator
      case "+":
        sighn = "+";
        break;
      case "/":
        sighn = "/";
        break;
      case "*":
        sighn = "*";
        break;
      case "-":
        sighn = "-";
        break;
      case "%":
        sighn = "%";
        break;

      case "=": //Delete all values but answer
        
        $("#hide").css("display", "none");
        
        if (newTotal > 0) {
          sums = [];
          before = 0;
          $("#oldAnswer").html("");
          $("#sum").val(newTotal);
          sums.push(newTotal);
          $("#oldSum").html(newTotal);
          newTotal = 0;
        } else if (newTotal < 0) {
          sums = [];
          before = 0;
          $("#oldAnswer").html("");
          $("#sum").val(newTotal.toString());
          sums.push(newTotal.toString());
          $("#oldSum").html(newTotal.toString());
          newTotal = 0;
        }
        return;

      case "AC": //Reset calculator
        resetCalulator();
        return;

      case "CE":
///////////////////////////////////////////////////////////
        //Remove last calulation when user presses CE
          var sumValue = 0; 
          var finalSum = 0;
          //alert(newTotal);

          var sumTextValue = $("#sum").val();

          //When only one value is in sum do nothing
          if (!sumTextValue.match(/\d$/)  || ! $("#oldSum").html().match(/\d$/) ) {     
            return        
          }else{

          var mathSigns2 = sumTextValue.match(regex);

          //Get the last value in the active sum in the calulator window i.e the 5 of 55 + 5
          if (mathSigns2) {
            ///alert("test2");
            var finalMathSign2 = mathSigns2[mathSigns2.length - 1];
            var finalMathSignIndex2 = [];
            finalMathSignIndex2 = sumTextValue.lastIndexOf(finalMathSign2);
    
            var test = sumTextValue.slice(
              finalMathSignIndex2 + 1,
              sumTextValue.length
            );
            //alert(test);
            var numss = -test.length;

            sumValue = sumTextValue.substr(numss);                     
            
            alert(sumValue);
            
            if (finalMathSign2 == "+") {
              
              newTotal = newTotal - sumValue;
     
            } else if (finalMathSign2 == "-") {
              
              newTotal = newTotal + sumValue;
            
            } else if (finalMathSign2 == "*") {
            
             newTotal = newTotal / sumValue;
            
            } else if (finalMathSign2 == "/") {
            
              newTotal = newTotal * sumValue;
            
            }
       
          }
         // alert(newTotal);

//////////////////////////////////////////////////////////////////////
          //Cut old values from the answers strings
          var oldTextValue = $("#oldSum").text();

          //Find all the index values of the maths symbols in the string
          while ((match = regex.exec(oldTextValue)) != null) {
            //alert("match found at " + match.index);
            var indexFinal = match.index;
          }
          //The exec() method tests for a match in a string.
          //Loop though the array with the values and store the indexs;

          //alert(indexFinal);
          var string = oldTextValue.slice(indexFinal, oldTextValue.length);
          //alert(string);

          //Store all the values from the text box that match the regex critera
          var mathSigns = [];
          mathSigns = oldTextValue.match(regex);

          //Store last value from the text box that matchs the regex critera
          var finalMathSign = mathSigns[mathSigns.length - 1];

          //Store the postion of the last found regex critera
          var finalMathSignIndex = oldTextValue.lastIndexOf(finalMathSign);

          if (finalMathSignIndex > -1 && mathSigns.length >= 1) {
            
                //Used to find end of the string
                var lengths = $("#oldSum").text().length;

                if (finalMathSignIndex > 0) {
                  
                      //Cut all value from string until the found index
                      oldTextValue = oldTextValue.slice(0, finalMathSignIndex);

                      $("#oldSum").html(oldTextValue);
                      while ((match = regex.exec(oldTextValue)) != null) {
                        //alert("match found at " + match.index);
                        indexFinal = match.index;
                 
                      }
                      //alert(indexFinal);
                      string = oldTextValue.slice(indexFinal + 1, oldTextValue.length);
                  
                      var mathsignFinal = oldTextValue.slice(
                        indexFinal,
                        indexFinal + 1
                      );

                 }
             }
          }
 
        $("#oldAnswer").html(newTotal);
    
        alert($("#oldAnswer").html());
        
        if (mathsignFinal == "+") {
          finalSum = $("#oldAnswer").html() - string;       
        } else if (mathsignFinal == "-") {
          
          
          alert($("#oldAnswer").html());
          finalSum = Number($("#oldAnswer").html()) + Number(string);
            
            alert(finalSum);
            alert(string);

        } else if (mathsignFinal == "/") {
          //alert("test3");
          finalSum = $("#oldAnswer").html() * string;
          //$("#oldAnswer").html(finalSum);
        } else if (mathsignFinal == "*") {
          //alert("test4");
          finalSum = $("#oldAnswer").html() / string;
        }
        //alert(mathsignFinal);
       //alert(string);
        
        var input = finalSum + mathsignFinal + string ;
        //alert(input);
      
        newTotal = finalSum;
        
        $("#sum").val(finalSum + mathsignFinal + string);
        //When the calculation has one or more maths sign - add the values to the main maths calculation array and remove the old values
        sums.pop();
        sums.pop();
        sums.push(mathsignFinal);
        sums.push(newTotal);
        //sighn = mathsignFinal;
        //alert(newTotal);
        //return;
        return;
    }//End switch
    
//////////////////////////////////////////////////////////////////////////
   
    //Stop user inputing a sum that does not start a number or -
    if (!oldSum.match(/^[0-9]|\-/)) {
      return;
    }

    var length = oldSum.length;
    //Stop user pressing not number buttons twice
    if (
      (oldSum[length - 2] == "+" && selectedButton == "+") ||
      (oldSum[length - 2] == "%" && selectedButton == "%") ||
      (oldSum[length - 2] == "-" && selectedButton == "-") ||
      (oldSum[length - 2] == "/" && selectedButton == "/") ||
      (oldSum[length - 2] == "*" && selectedButton == "*") ||
      (oldSum[length - 2] == "." && selectedButton == ".")
    ) {
      return;
    }
    //Remove - if it first number in calulation
    if (oldSumFull[0] === "-") {
      oldSumFull = oldSumFull.substring(1, oldSumFull.length);
      oldSum = oldSum.substring(1, oldSum.length);

      $("#minus").html("-");
    }

    //Add user input to array
    sums.push(selectedButton);
    //Remove multiple dots i.e 5.5.5 from array
    if (
      sums.indexOf(".") > -1 &&
      sums.lastIndexOf(".") > -1 &&
      sums.lastIndexOf(".") !== sums.indexOf(".")
    ) {
      sums.splice(sums.lastIndexOf("."), 1);
      oldSum = sums;
    }

    //When button pressed is maths symbol add a new value to calulation
    if (sighn.match(regex)) {
      //Look at the last two values input into the calulator
      index = sums.indexOf(sighn);
      //Check though the string that holds the whole sum
      index2 = oldSum.lastIndexOf(sighn);
      index3 = oldSum.indexOf(sighn);
    }

    //Split the values into two varables
    if (index !== -1) {
      //Fist value before maths symbol is stored in before
      before = sums.splice(0, index + 1);
      before = before.join("");
      before = before.replace(regex, "");
    }

    //Value after maths symbol is stored in after
    var after = sums.join("");

    //When a two numbers exist in the sum - do maths
    if (before && after) {
      //When first number starts with -
      if ($("#minus").html() === "-") {
        if (newTotal < 0) {
        } else {
          before = before - before * 2;
        }
        $("#minus").html("");
      }

      if (sighn == "*") {
        if (newTotal < 0) {
          newTotal = Number(newTotal) * Number(after);
        } else {
          newTotal = Number(before) * Number(after);
        }
      } else if (sighn == "/") {
        if (newTotal < 0) {
          newTotal = Number(newTotal) / Number(after);
        } else {
          newTotal = Number(before) / Number(after);
        }
      } else if (sighn == "%") {
        if (newTotal < 0) {
          newTotal = Number(newTotal) % Number(after);
        } else {
          newTotal = Number(before) % Number(after);
        }
      } else if (sighn == "-") {
        if (newTotal < 0) {
          newTotal = Number(newTotal) - Number(after);
        } else {
          newTotal = Number(before) - Number(after);
        }
      } else if (sighn == "+") {
        if (newTotal < 0) {
          newTotal = Number(newTotal) + Number(after);

          if (Number(newTotal) + Number(after) > 0) {
            sums = [];
            before = 0;
            $("#oldAnswer").html("");
            $("#sum").val(newTotal);
            sums.push(newTotal);
            $("#oldAnswer").html(Number(newTotal.toFixed(2)));
            return;
          }
        } else {
          newTotal = Number(after) + Number(before);
        }
      }

      // alert(before);
      //alert(after);

      if (newTotal > 0) {
      } else {
      }
      newTotal = Number(newTotal.toFixed(2));

      $("#oldAnswer").html(newTotal);
    }

    //Remove duplicate symbols from maths question string
    oldSum = oldSum.replace(/\+\+|\-\+|\*\+|\/\+/g, "+");
    oldSum = oldSum.replace(/\*\*|\-\*|\+\*|\/\*/g, "*");
    oldSum = oldSum.replace(/\*\/|\-\/|\+\/|\/\//g, "/");
    oldSum = oldSum.replace(/\*\-|\-\-|\+\-|\/\-/g, "-");

    oldSumFull = oldSumFull.replace(/\+\+|\-\+|\*\+|\/\+/g, "+");
    oldSumFull = oldSumFull.replace(/\*\*|\-\*|\+\*|\/\*/g, "*");
    oldSumFull = oldSumFull.replace(/\*\/|\-\/|\+\/|\/\//g, "/");
    oldSumFull = oldSumFull.replace(/\*\-|\-\-|\+\-|\/\-/g, "-");

    //Used to store all the calulations until the user clears the calulator

    // newTotal =newTotal.toFixed(2);
    //When the user press a maths symbol for the secound time in row (i.e when the first index and last index of the + symbol are differnt) - updated the answer string to remove old values and add the new total to the sums array
    if (index3 !== index2 && index2 > -1 && index3 > -1) {
      //alert("test2");
      oldSum = newTotal.toString() + selectedButton;
      sums.push(newTotal);
      sums.push(selectedButton);
    }
    //When user does more than one sum add the old value to the calculation
    if (
      ($("#sum").val().indexOf("-") > -1 &&
        (sighn == "+" || sighn == "*" || sighn == "/" || sighn == "%")) ||
      ($("#sum").val().indexOf("+") > -1 &&
        (sighn == "-" || sighn == "*" || sighn == "/" || sighn == "%")) ||
      ($("#sum").val().indexOf("*") > -1 &&
        (sighn == "-" || sighn == "+" || sighn == "/" || sighn == "%")) ||
      ($("#sum").val().indexOf("/") > -1 &&
        (sighn == "-" || sighn == "*" || sighn == "+" || sighn == "%")) ||
      ($("#sum").val().indexOf("%") > -1 &&
        (sighn == "-" || sighn == "*" || sighn == "/" || sighn == "+"))
    ) {
      if (newTotal <= 0 && sighn == "+") {
        //oldSum = newTotal.toString() + selectedButton;
      } else {
        sums.push(newTotal);
        sums.push(selectedButton);
        oldSum = newTotal.toString() + selectedButton;
        //alert("test");
      }
    }
    //Last bit of calulation - apear inside calculator
    $("#sum").val(oldSum);
    //Full calculation - apear at top of calculator
    $("#oldSum").html(oldSumFull);

    //Shoe box eith equal sign  
    if ($("#oldAnswer").text().length > 0){     
      $("#hide").css("display", "block");
    }
    
  }); //End function

  ////////////////////////////////////////////////////////
}); //End document ready
</script>
<?php include "includes/footer.php";?>
