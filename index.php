<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up Page</title>
  <link href="css/styles.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
  <form id="signupForm" method="post" action="welcome.html">
  <h1>Sign up</h1>
  First Name: <input class="input" type="text" name="fName"><br>
  Last Name:  <input class="input" type="text" name="lName"><br>
  Gender:     <input class="radio" type="radio" name="gender" value="m">Male
              <input class="radio"type="radio" name="gender" value="f">female<br><br>
  
  Zip Code:   <input class="input" type="text" name="zip" id="zip"><br>
  City:       <span id="city"></span><br>
  Latitude:   <span id="latitude"></span><br>
  Longitude:  <span id="longitude"></span><br>
  
  State: 
  <select id="state" name="state">
    <option value="">Select One</option>
    <!--     <option value="ca">California</option>
    <option value="ny">New York</option>
    <option value="tx">Texas</option> -->
  </select><br>
  
  Select a County <select id="county"></select><br><br>
  Desired Username: <input class="input" type="text"     id="username" name="username"><br>
  <span id="userError"></span><br>
  Password:         <input class="input" type="password" id="password" name="password"><br>
  Password Again:   <input class="input" type="password" id="passwordAgain"><br>
  <span id="passwordAgainError"></span><br /><br>
  <input type="submit" value="Sign Up">
    
  </form>
  <script>
    var usernameAvailable = false;
    // populate all states
    //$("#state").on("change", function(){
    window.onload = populateStates();
    
    function populateStates(){
      $.ajax({
      method: "get",
      url: "https://cst336.herokuapp.com/projects/api/state_abbrAPI.php",
      dataType: "json",
      data: {"state" : $("#state").val() },
      success: function(result,status) {
        result.forEach(function(i){
          $("#state").append("<option value =" + (i.usps).toLowerCase() +">" + i.state + "</option>");
          
        })
      }
    })}
 
        
    // displaying city from API after typing a zip code
    $("#zip").on("change", function(){
      //alert($("#zip").val());
    $.ajax({
      method: "get",
      url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
      dataType: "json",
      data: {"zip" : $("#zip").val() },
      success: function(result,status) {
  
     // alert(result.city);
      $("#city").html(result.city);
      $("#latitude").html(result.latitude);
      $("#longitude").html(result.longitude);
      }
    }) // ajax
});// zip
      
      
      
      $("#state").on("change", function(){
      $.ajax({
      method: "get",
      url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
      dataType: "json",
      data: {"state" : $("#state").val() },
      success: function(result,status) {
      //alert(result[0].county);
        $("#county").html("<option> Select One </option>")
        //for(let i = 0; i < result.length; i++){
        //  $("#county").append("<option>" + result[i].county + "</option>");
        result.forEach(function(i){
          $("#county").append("<option>" + i.county + "</option>");
        })
        //}
      }
    })// ajax
});// state

// testing for username 
    
      $("#username").on("change", function(){
      $.ajax({
      method: "get",
      url: "https://cst336.herokuapp.com/projects/api/usernamesAPI.php",
      dataType: "json",
      data: {"username" : $("#username").val() },
      success: function(result,status) {
        if(result.available){
          $("#userError").html("Username is available!");
          $("#userError").css("color","green");
          usernameAvailable = true;
        } else {
          $("#userError").html("Username is unavailable!");
          $("#userError").css("color","red");
          usernameAvailable = false;
        }
        //}
      }
    })// ajax
});// state

// form validation
    $("#signupForm").on("submit",function(e){
      //alert("Submitting Form...");
      if (!isFormValid()) {
        e.preventDefault();  
      }
      
    });
    
    function isFormValid(){
      var isValid = true;
      if(!usernameAvailable){
        isValid = false;
      }
      if ($("#username").val().length == 0) {
        isValid = false;
        $("#userError").html("Username is required");
        $("#userError").css("color","red");
      }
      if ($("#password").val() != $("#passwordAgain").val()) {
        $("#passwordAgainError").html("Password Mismatch!");
        isValid = false;
      }
      if ($("#password").val().length < 6) {
        $("#passwordAgainError").html("Password Does Not Meet The Required Length of 6 Characters!");
        isValid = false;
      }
      return isValid;
    }
  </script>
            
</body>
</html>