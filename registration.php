<?php
include('db-connection.php');

if(isset($_POST["submit"])) {   
    $value = $_POST["user"];
    $fname=$_POST["fname"];
    $lname=$_POST["lname"];
    $house=$_POST["house"];
    $city=$_POST["city"];
    $district=$_POST["district"];
    $pincode=$_POST["pincode"];
    $email=$_POST["email"];
    $phno=$_POST["phno"];
    $password=password_hash($_POST["password"],PASSWORD_BCRYPT);


    if($value=="cust")
    {
        $sql = "INSERT INTO cust_details(cust_fname,cust_lname,cust_house,cust_city,cust_dist,cust_pincode,
        cust_username,cust_pass,cust_phno,cust_status) 
        VALUES('$fname','$lname','$house', '$city', '$district','$pincode', '$email', '$password', '$phno','Active')";
        if(mysqli_query($conn, $sql)){
          echo '<script>if(confirm("Registration Successfull, Do you want to login?")){
            window.location.href= "index.php";  
          }</script>';
        } else if(mysqli_errno($conn) == 1062){   //1062 error number for unique key violation
            echo '<script>alert("Email already exists. Please try logging in");</script>';
           
        }
        else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_errno($conn);
        }
    }
    else  {
        // echo "\n else case";
        $service = $_POST["service"];
        // echo "$service".$service;
      
        $sql = "INSERT INTO sp_details(s_id,sp_fname,sp_lname,sp_house,sp_city,sp_district,sp_pincode,sp_username,sp_password,sp_phone,sp_status) 
        VALUES('$service','$fname','$lname','$house', '$city', '$district','$pincode', '$email', '$password', '$phno','Active')";
        if(mysqli_query($conn, $sql)){
          echo '<script>if(confirm("Registration Successfull, Do you want to login?")){
            window.location.href= "index.php";  
          }</script>';
          
        } 
        else if(mysqli_errno($conn) == 1062){
             //1062 error number for unique key violation
          echo '<script>alert("Email already exists. Please try logging in");</script>';
          
        }
        else{
            //echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            echo mysqli_errno($conn); 
          }
    }
}

 mysqli_close($conn)
 // Check connection
//  if (!$conn) {
//      die("Connection failed: ");
//      }
//      echo "Connected successfully";
  
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Registration | DHS </title>
    <link rel="stylesheet" href="stylesheets/registration-style.css">
    <link href="stylesheets/bootstrap.css" rel="stylesheet">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">

    <div class="container-fluid">
        <a class="navbar-brand" href="#"> <img class="logo-img" src="images/logo.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> My Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Contact </a>
                </li>
            </ul>
        </div>
    </div>
</nav> -->
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form action="" method="POST">
        <div class="gender-details">
          <input type="radio" value="sp" name="user" id="dot-1" onclick="visService()"checked="checked" >
          <input type="radio" value="cust" name="user" id="dot-2" onclick="hideService()">
          <span class="gender-title">I am</span>
          <div class="category">
            <label for="dot-1">
              <span class="dot one"></span>
              <span  class="gender">Service Provider</span> 
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span  class="gender">Customer</span>
            
          </label>
          </div>
        </div>
        <div class="user-details">
          <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" name="fname" placeholder="Enter your first name" required>
          </div>
          <div class="input-box">
            <span class="details">Last Name</span>
            <input type="text" name="lname" placeholder="Enter your last name" required>
          </div>
          <div class="input-box">
            <span class="details">House</span>
            <input type="text" name="house" placeholder="Enter your house name" required>
          </div>
          <div class="input-box">
            <span class="details">City</span>
            <input type="text" name="city" placeholder="Enter your city" required>
        </div>
            <div class="input-box">
                <span class="details">District</span>
                <input type="text" name="district" placeholder="Enter your district" required>
              </div>
          
          <div class="input-box">
            <span class="details">Pincode</span>
            <input type="text" name="pincode" placeholder="Enter your Pincode" required pattern="[0-9]{6}" title="Enter 6 digit valid pincode">
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter your Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="something@xyz.com">
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" name="phno" placeholder="Enter your number" required pattern="[0-9]{10}" title="Enter 10 digit mobile number">
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" name="confirm-pass" id="confirmPassword" onchange="matchPassword()" placeholder="Confirm your password" required>
            <span class="details" id="confirmPassError"></span>
          </div>
          
        </div>

       
          <select name="service" class="btn btn-primary dropdown-toggle btn-drop" id="service"
           style="background-color: rgb(0, 0, 0); border-color: rgb(00,00,00);">
            <div class="dropdown-menu" >
              <option class="dropdown-item" value="" disabled selected hidden > Select Service</option>
              <option value=101>Electrician</option>
              <option value=102>Carpenter</option>
              <option value=103>Plumber</option>
              <option value=104>Mechanic</option>
              <option value=105>Painter</option>
              </div>
          </select>
          <script src="javascript/registration.js" type="text/javascript"></script>
        <div class="button">
          <input type="submit" value="Register" name="submit">
        </div>
      </form>
    </div>
  </div>

</body>

<script>

function matchPassword() {  
  var pw1 = document.getElementById("password").value;  
  var pw2 = document.getElementById("confirmPassword").value;
  console.log(pw1,"pass1");
  console.log(pw2,"pass2");  
  if(pw1 != pw2)  
  {   
    document.getElementById("confirmPassError").innerHTML= "Password do not match" ; 
  } else {
    document.getElementById("confirmPassError").innerHTML= "" ; 
  }  
}  

</script>
</html>