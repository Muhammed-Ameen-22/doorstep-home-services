<?php
require_once "db-connection.php";
session_start();
$currentUser = $_SESSION["name"];
$cust_id = $_SESSION['id'];
// $sql= "select rc.rc_id, s.s_name, rm.r_date, rc.r_status from request_child as rc inner join request_master as rm on rc.rm_id = rm.rm_id 
//         inner join service_details as s on rc.s_id = s.s_id where rm.cust_id = ".$cust_id ;

$sql= "select rc.rc_id, rc.r_status, rm.r_date, sr.s_name, concat(sp.sp_fname,' ',sp.sp_lname) as sp_name, sp.sp_phone
from request_child as rc 
inner join request_master as rm on rm.rm_id = rc.rm_id
inner join service_details as sr on sr.s_id = rc.s_id
inner join accept as a on a.rc_id =rc.rc_id
inner join sp_details as sp on sp.sp_id = a.sp_id 
where rm.cust_id = ".$cust_id ;

// $fetch_sp_name="select sp.sp_fname, sp.sp_lname from sp_details as sp inner join accept as a on a.sp_id=sp.sp_id "
if(mysqli_query($conn, $sql )){
  // $result = mysqli_query($conn,$sql);
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
    <link href="stylesheets/bootstrap.css" rel="stylesheet">
    <link href="stylesheets/style.css" rel="stylesheet">
    <link href="stylesheets/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >
    <link href="stylesheets/sp-dashboard.css" rel="stylesheet">
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
                        <a class="nav-link"> <?php echo "Hi, ".$currentUser; ?> </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"> My Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="cust-dashboard.php"> Dashboard</a>
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
            <th class="col-1" scope="col">Request ID</th>
            <th  class="col-2" scope="col">Service</th>
            <th class ="col-3" scope="col">Requested date</th>
            <th class="col-3" scope="col">Accepted by</th>
            <th class="col-1" scope="col">Req Status</th>
            <th class="col-1" scope="col">Payment Status</th>
          </tr>
        </thead>
        <tbody>
          
            <?php 
              while($row = $result->fetch_assoc()) {
                echo '<tr><td>'.$row["rc_id"].'</td>  <td>'.$row["s_name"].'</td> <td>'.$row["r_date"].'</td> 
                 <td>'.$row["sp_name"].'</td>
                 <td>'.$row["r_status"].'</td></tr>';
              }
              ?>  
         </tbody>
       </table>
       </div>
     </body>
     </html>