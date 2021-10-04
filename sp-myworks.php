<?php
require_once "db-connection.php";
session_start();
$currentUser = $_SESSION["name"];
$s_id = $_SESSION['s_id'];
$sp_id = $_SESSION['sp_id'];
$select_my_works= "select rc.rc_id, c.cust_fname, c.cust_house,c.cust_city,rm.r_date from request_child as rc 
inner join request_master as rm on rc.rm_id = rm.rm_id 
inner join cust_details as c on rm.cust_id = c.cust_id where rc.s_id = ".$s_id." and rc.r_status = 'Accepted'";
if(mysqli_query($conn, $select_my_works )){
 
  $result = $conn -> query($select_my_works);
} else{
  echo "ERROR: Could not able to execute $select_my_works. " . mysqli_error($conn);
}


if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['COMPLETE'])){
  $rc_id = $_POST['rc_id'];
  $total_amount = $_POST['amount'];

  $get_acceptance_id = "select a_id from accept where rc_id =".$rc_id;
  if(mysqli_query($conn, $get_acceptance_id )){
    $res = $conn -> query($get_acceptance_id);
    $rows = $res->fetch_assoc();
    $acceptance_id = $rows['a_id'];

  } else{
    echo "ERROR: Could not able to execute $get_acceptance_id. " . mysqli_error($conn);
  }

  $insert_amount = "insert into payment values(NULL,NULL,'$acceptance_id','$total_amount','Not-Paid',NULL)";
  $request_complete = "update request_child set r_status = 'Completed' where rc_id =".$rc_id;
  if(mysqli_query($conn, $insert_amount )){
    mysqli_query($conn, $request_complete);
    header("location:sp-myworks");
  } else{
    echo "ERROR: Could not able to execute $insert_amount. " . mysqli_error($conn);
  }
}
$select_completed_works= "select rc.rc_id, c.cust_fname, c.cust_house,c.cust_city,rm.r_date,
pay.total_amount,a.a_id,pay.p_status from request_child as rc 
inner join request_master as rm on rc.rm_id = rm.rm_id 
inner join accept as a on rc.rc_id=a.rc_id
inner join payment as pay on a.a_id=pay.a_id
inner join cust_details as c on rm.cust_id = c.cust_id where rc.s_id = ".$s_id." and rc.r_status = 'Completed' and a.sp_id = ".$sp_id;
if(mysqli_query($conn, $select_completed_works )){
 
  $completed = $conn -> query($select_completed_works);
} else{
  echo "ERROR: Could not able to execute $select_completed_works. " . mysqli_error($conn);
}
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
                        <a class="nav-link"> <?php echo "Hi, ".$currentUser; ?> </a>
                    </li>
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
<h2><center>PENDING WORKS</center> </h2>
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
                echo '<form action="" method="POST"> <tr><td>'.$row["rc_id"].'</td>  <td>'.$row["cust_fname"].'</td> <td>'.$row["cust_house"].'</td> 
                <td>'.$row["r_date"].'</td> <td><input type="text" placeholder="Amount" name="amount"  id="'.$row["rc_id"].'">
                <input type="hidden" name="rc_id"  value="'.$row["rc_id"].'"></td> 
                <td> <button class="btn btn-primary" id="compButton" type="submit" name="COMPLETE" onClick="">Completed</button></td></tr> </form>' ;
              }
            
              ?>  
        </tbody>
      </table>
      </div>

      <h2><center>COMPLETED WORKS</center> </h2>
<div class="req-table mt-100"> 
      <table class="table table-hover table-dark">
        <thead>
          <tr>
            <th class="col-1" scope="col">Work ID</th>
            <th  class="col-2" scope="col">Customer Name</th>
            <th class ="col-2" scope="col">Address</th>
            <th class ="col-2" scope="col">Work date</th>
            <th class="col-1">Amount</th>
            <th class="col-1">Status</th>
            
        
          </tr>
        </thead>
        <tbody>
          
            <?php 
              while($row = $completed->fetch_assoc()) {
                echo ' <tr><td>'.$row["rc_id"].'</td>  <td>'.$row["cust_fname"].'</td> <td>'.$row["cust_house"].'</td> 
                <td>'.$row["r_date"].'</td> <td>'.$row["total_amount"].'</td> <td>'.$row["p_status"].'</td>   </tr>' ;
              }
              ?>  
        </tbody>
      </table>
      </div>
      <script>
    function setAmount(id) 
    {
      console.log("this is the id ",id);
      window.location.href= "sp-myworks.php?"+"rc_id="+id+"&";
      console.log(document.getElementById(id).value);
      document.getElementById(id).disabled = true;
      document. getElementById(id). disabled = true;
    }
    </script>
    </body>
    </html>