<?php
require_once "db-connection.php";
session_start();
if(!isset($_SESSION["sp_id"])){
  header('location: index.php');
}
$currentUser = $_SESSION["name"];
$s_id = $_SESSION['s_id'];
$sp_id=$_SESSION['sp_id'];
$sql= "select rc.rc_id, c.cust_fname, rm.r_date from request_child as rc inner join request_master as rm on rc.rm_id = rm.rm_id 
inner join cust_details as c on rm.cust_id = c.cust_id where rc.s_id = ".$s_id." and r_status = 'Requested' and rm.rm_id not in 
(select rc.rm_id from request_child as rc inner join accept  as a on rc.rc_id=a.rc_id where sp_id=".$sp_id.")" ;


if(mysqli_query($conn, $sql )){
  // $result = mysqli_query($conn,$sql);
  // $my_request = mysqli_fetch_array($result);
  $result = $conn -> query($sql);
} else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

if($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['ACCEPT'])){
  $rc_id=$_GET['req_id'];
  $update_req_status = "update request_child set r_status ='Accepted' where rc_id = ".$_GET['req_id'];
  if(mysqli_query($conn, $update_req_status )){
    //updated request_child status to Accepted
  
     $insert_into_accept ="insert into accept values(NULL,'$rc_id','$sp_id','Accepted')";
        if(mysqli_query($conn, $insert_into_accept)){
            //Inserted into accept table
        } else{
          echo "ERROR: Could not able to execute $insert_into_accept " . mysqli_error($conn);
        }
     header("location: sp-dashboard");
  } else{
    echo "ERROR: Could not able to execute $update_req_status. " . mysqli_error($conn);
  }
}


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
   
    <script src="javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="javascript/bootstrap.bundle.js" type="text/javascript"></script>
   
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        
    <script src="javascript/bootstrap.js" type="text/javascript"></script>
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
                <li class="nav-item">
                        <a class="nav-link" > <?php echo "Hi, ".$currentUser; ?></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="sp-dashboard.php"> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="sp-myworks.php"> My works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sp-profile-edit.php"> Profile </a>
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
            <th  class="col-2" scope="col">Customer Name</th>
            <th class ="col-3" scope="col">Requested date</th>
            <th class="col-1"></th>
          </tr>
        </thead>
        <tbody>
          
            <?php 
              while($row = $result->fetch_assoc()) {
                echo '<form action=""><tr><td><input type="hidden" value="'.$row["rc_id"].'" name="req_id">'.$row["rc_id"].'</td>  <td>'.$row["cust_fname"].'</td> <td>'.$row["r_date"].'</td> 
                 <td>  <input type="submit" value="Accept" name="ACCEPT"  )"> </form></td></tr>';
              }
              ?>  
           <!-- <th scope="row">1</th>
            <td>Shyam</td>
            <td>12-07-2021</td>-->
            <!-- <td><input type="button" value="Accept"></td>  -->
        
          
          <!-- <tr>
            <th scope="row">2</th>
            <td>Jake</td>
            <td>15-07-2021</td>
          
          </tr>
          <tr>
            <th scope="row">3</th>
            <td >Harry</td>
            <td>19-07-2021</td>
        
          </tr> -->
        </tbody>
      </table>
      </div>
    </body>

    </html>