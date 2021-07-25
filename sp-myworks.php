<?php
require_once "db-connection.php";
session_start();
$sp_id = $_SESSION['s_id'];
$sql= "select rc.rc_id, c.cust_fname, c.cust_house,c.cust_city,rm.r_date from request_child as rc inner join request_master as rm on rc.rm_id = rm.rm_id 
inner join cust_details as c on rm.cust_id = c.cust_id where rc.s_id = ".$sp_id." and rc.r_status = 'Accepted'";
if(mysqli_query($conn, $sql )){
  // $result = mysqli_query($conn,$sql);`
  // $my_request = mysqli_fetch_array($result);
  $result = $conn -> query($sql);
} else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
//echo "This is the req".$my_request['rc_id'];   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | DHS</title>
    <link href="stylesheets/sp-myworks.css" rel="stylesheet">
    <link href="stylesheets/bootstrap.css" rel="stylesheet">
    <link href="stylesheets/style.css" rel="stylesheet">
    <link href="stylesheets/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="javascript/bootstrap.js" type="text/javascript"></script>
    <script src="javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="javascript/bootstrap.bundle.js" type="text/javascript"></script>
   
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">

        <div class="container-fluid">
            <a class="navbar-brand" href="#"> <img class="logo-img" src="images/logo.png"> </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="sp-dashboard.php"> Dashboard</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link"  href="#"> My works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"> Log out </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<br>
<div class="req-table mt-100"> 
      <table class="table table-hover table-dark">
        <thead>
          <tr>
            <th class="col-1" scope="col">Work ID</th>
            <th  class="col-2" scope="col">Customer Name</th>
            <th class ="col-2" scope="col">Address</th>
            <th class ="col-2" scope="col">Work date</th>
            <th class="col-1">Amount</th>
            <th class="col-1"></th>
        
          </tr>
        </thead>
        <tbody>
          
            <?php 
              while($row = $result->fetch_assoc()) {
                echo '<tr><td>'.$row["rc_id"].'</td>  <td>'.$row["cust_fname"].'</td> <td>'.$row["cust_house"].'</td> 
                <td>'.$row["r_date"].'</td> <td><input type="text" placeholder="Amount"  id="amount"></td> 
                <td> <button class="btn btn-primary" id="compButton" type="submit" onClick="amtFix()">Completed</button></td></tr>' ;
              }
              ?>  
        </tbody>
      </table>
      </div>
      <script>
    function amtFix() 
    {
      document.getElementById("amount").readOnly = true;
      document. getElementById("compButton"). disabled = true;
    }
    </script>
    </body>
    </html>