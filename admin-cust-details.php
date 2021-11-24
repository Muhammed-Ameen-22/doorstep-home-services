<html>
<head>
<title>DHS | Details</title>
<link rel="stylesheet" href="stylesheets/admin-tables.css">
<link href="stylesheets/bootstrap.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
    integrity="sha256-c9vxcXyAG4paArQG3xk6DjyW/9aHxai2ef9RpMWO44A=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src ="javascript/downloadPDF.js"> </script>
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
            <li class="nav-item ">
                <a class="nav-link" href="admin-dashboard.html"> Dashboard</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="admin-login.php"> Logout</a>
            </li>
        </ul>
    </div>
</div>
</nav>

  
<?php
require_once "db-connection.php";
$dateFrom=date("2021-01-01");
$dateTo=date("2022-01-01");
$total_sum_amount =0;

if(isset($_GET["cust_id"]))
{
$table_to_be_selected = 'cust';
$cust_fname=$_GET["name"];
$cust_id=$_GET["cust_id"];
}
else{
$table_to_be_selected = 'sp';
$sp_fname=$_GET["name"];
$sp_id=$_GET["sp_id"];
}

if($table_to_be_selected == 'sp'){

    if(isset($_GET["dateFrom"]) && isset($_GET["dateTo"]))
    {
       
     $dateFrom=$_GET["dateFrom"];
     $dateTo=$_GET["dateTo"];   
    }

    $sql = "SELECT rm.r_date, rm.cust_id, a.rc_id, p.a_id, p.total_amount, p.p_date,p.p_status, 
    concat(c.cust_fname,' ',c.cust_lname) as cust_name 
    from request_master as rm
    inner join request_child as rc on rc.rm_id=rm.rm_id 
    inner join accept as a on a.rc_id=rc.rc_id
    inner join payment as p on p.a_id=a.a_id 
    inner join cust_details as c on c.cust_id=rm.cust_id
    inner join sp_details as sp on sp.sp_id=a.sp_id
    where rm.r_date >= '". $dateFrom ."'and rm.r_date <='".$dateTo."' and  
    sp.sp_id=".$sp_id;

    $result = $conn->query($sql);
    echo '<div class="container">
     <h2>Works of '. $sp_fname.'</h2>
        <br>
        <form action="#" method="GET" id="ignore">
     <center>
         &nbsp &nbsp &nbsp Date From : <input type="date" name="dateFrom" value="'.$dateFrom.'">
        &nbsp &nbsp &nbsp
     Date To : <input class="form-group" type="date" class="dateFilter" name="dateTo" value="'.$dateTo.'">
     &nbsp &nbsp &nbsp
     &nbsp &nbsp &nbsp
     <input type="hidden" value="'.$sp_fname.'" name="name">
     <input type="hidden" value="'.$sp_id.'" name="sp_id">
     <button class="submit-btn" name="search">Search</button>
     </center>
     </form>
     <br> <br>
     <ul class="responsive-table">
       <li class="table-header">
       <div class="col col-1">Sl No.</div>
         <div class="col col-1">ID</div>
         <div class="col col-3">Requested By</div>
         <div class="col col-2">Req Date</div>
         <div class="col col-2">Total Amount</div>
         <div class="col col-2">Payment Status</div>
         <div class="col col-2">Payment Date</div>
         
         
       </li>';
    if ($result->num_rows > 0)
    {
     
      $serial_num=1;
    while($row = $result->fetch_assoc()) 
        {

            if($row['r_date']>=$dateFrom && $row['r_date'] <= $dateTo ){
              
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$serial_num.'</div>
            <div class="col col-1" data-label="ID">'.$row['rc_id'].'</div>
            <div class="col col-3" data-label="Name">'. $row['cust_name'].'</div>
            <div class="col col-2" data-label="Address">'.$row['r_date'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['total_amount'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['p_status'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['p_date'].'</div>
      </li>';
      $total_sum_amount = $total_sum_amount + $row['total_amount'];
              $serial_num++;
        }
    }

        
       echo "<h5 align='right'>Total amount : Rs. $total_sum_amount/-</h5>";
            echo "</ul></div>";
            }
    else {
        echo"<h5 align='center'>Sorry no request found </h5>";
    }
}
else if($table_to_be_selected == 'cust'){

    
    if(isset($_GET["dateFrom"]) && isset($_GET["dateTo"]))
    {
       
     $dateFrom=$_GET["dateFrom"];
     $dateTo=$_GET["dateTo"];   
    }
    $sql = "SELECT rm.r_date, rm.cust_id, rc.r_status, a.rc_id, p.a_id, p.total_amount, s.s_name, p.p_date, 
    concat(sp.sp_fname,' ',sp.sp_lname) as sp_name
    from request_master as rm
    inner join request_child as rc on rc.rm_id=rm.rm_id 
    inner join accept as a on a.rc_id=rc.rc_id
    inner join payment as p on p.a_id=a.a_id 
    inner join cust_details as c on c.cust_id=rm.cust_id
    inner join sp_details as sp on sp.sp_id=a.sp_id
    inner join service_details as s on s.s_id=sp.s_id
    where rm.r_date >= '". $dateFrom ."' and rm.r_date <='".$dateTo."' and 
    c.cust_id=".$cust_id;
 


    
    $result = $conn->query($sql);
    echo '<div class="container" id="table-details">
        <h2>Requests of '. $cust_fname.'</h2>
        <br>
        <form action="#" method ="GET">
        <center> &nbsp &nbsp &nbsp Date From : <input type="date" name="dateFrom" value="'.$dateFrom.'">
        &nbsp &nbsp &nbsp
     Date To : <input class="form-group" type="date" class="dateFilter" name="dateTo"  value="'.$dateTo.'">
     &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
     <input type="hidden" value="'.$cust_fname.'" name="name">
     <input type="hidden" value="'.$cust_id.'" name="cust_id">
     <button type="submit" class="submit-btn" name="search">Search</button>
     </center></form>
     
     <button class="btn btn-info" id="generatePDF" onclick="generatePDF()" style="float:right;">Download PDF</button>
     <br> <br>
     
        <ul class="responsive-table">
          <li class="table-header">
          <div class="col col-1">Sl No.</div>
            <div class="col col-1">ID</div>
            <div class="col col-new">Service</div>
            <div class="col col-2">Requested Date</div>
            <div class="col col-2">Req Status</div>
            <div class="col col-2">Accepted By</div>
            <div class="col col-2">Total Amount</div>
            <div class="col col-2">Payment Date</div>
            
          </li>';
    if ($result->num_rows > 0)
    {
      $serial_num=1;
      
        while($row = $result->fetch_assoc()) 
            {
    
            if($row['r_date']>=$dateFrom && $row['r_date'] <= $dateTo ){
                
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$serial_num.'</div>
            <div class="col col-1" data-label="ID">'.$row['rc_id'].'</div>
            <div class="col col-new" data-label="Name">'. $row['s_name'].'</div>
            <div class="col col-2" data-label="Address">'.$row['r_date'].'</div>
            <div class="col col-2" data-label="Email">'. $row['r_status'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['sp_name'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['total_amount'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['p_date'].'</div>
                
            
          </li>';
          $total_sum_amount = $total_sum_amount + $row['total_amount'];
          $serial_num++;
            }
            }
            echo "<h5 align='right'>Total amount : Rs. $total_sum_amount/-</h5>";
            echo "</ul></div>";
            }
    else {
        echo"<h5 align='center'>Sorry no request found </h5>";
    }
          } 

$conn->close();

?>
</table>
</body>
<script> 

function confirmDeletion(id,user){
  console.log(user);
  if(confirm('Do you want to delete this entry?')){
    window.location.href= "delete.php?"+user+"="+id;  
  }
}

// var doc = new jsPDF();
// // var specialElementHandlers = {
// //     '#editor': function (element, renderer) {
// //         return true;
// //     },
// //     '#ignore': function (element, renderer) {
// //     return true;
// //   }
// // };

// //margins.left, // x coord   margins.top, { // y coord
// $('#generatePDF').click(function () {

  

//   var pdf = new jsPDF('p', 'pt', 'letter');
//  pdf.addHTML($('.container')[1], function () 
//   { 
//      pdf.save('Test.pdf');
//  });

//     //  doc.fromHTML($('.container').html(), 15, 15, {
//     //     'width': 700,
//     //     'elementHandlers': specialElementHandlers
//     // });
   
//     // doc.save('sample_file.pdf');
// });



</script>
</html>