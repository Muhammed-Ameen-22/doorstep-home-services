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
        cust_username,cust_pass,cust_phno) 
        VALUES('$fname','$lname','$house', '$city', '$district','$pincode', '$email', '$password', '$phno')";
        if(mysqli_query($conn, $sql)){
        //    echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
    else  {
        // echo "\n else case";
        $service = $_POST["service"];
        // echo "$service".$service;
      
        $sql = "INSERT INTO sp_details(s_id,sp_fname,sp_lname,sp_house,sp_city,sp_district,sp_pincode,sp_username,sp_password,sp_phone) 
        VALUES('$service','$fname','$lname','$house', '$city', '$district','$pincode', '$email', '$password', '$phno')";
        if(mysqli_query($conn, $sql)){
        //    echo "Records inserted successfully.";
        } 
        else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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
<html>
<head>
<link href="stylesheets/cust-dashboard.css" rel="stylesheet">
<link href="stylesheets/bootstrap.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >
	<title>Success | DHS</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">

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
</nav>
<!-- <i class="fa fa-check" aria-hidden="true"></i> -->
<h1>Registration Success</h1>
</body>
</html>