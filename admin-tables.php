<html>
<head>
<title>DHS | Details</title>
<link rel="stylesheet" href="stylesheets/admin-tables.css">
<link href="stylesheets/bootstrap.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  

<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
    integrity="sha256-c9vxcXyAG4paArQG3xk6DjyW/9aHxai2ef9RpMWO44A=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src ="javascript/downloadPDF.js"> </script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >
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
                <a class="nav-link" href="index.php"> Logout</a>
            </li>
        </ul>
    </div>
</div>
</nav>

<!-- <script>
      $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
    } );
    </script>  -->
<?php
require_once "db-connection.php";

$dateFrom=date("2021-01-01");
$dateTo=date("2022-01-01");
$total_sum_amount =0;
$table_to_be_selected = $_GET["id"];

if($table_to_be_selected == 'sp'){
    $sql = "SELECT * FROM sp_details inner join service_details on 
    sp_details.s_id = service_details.s_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
    
      
     echo '





<div class="container">
     <h2>Service Providers</h2>
<br> 
<button class="btn btn-info" id="generatePDF" onclick="generatePDF()" style="float:right;">Download PDF</button>
     <input type="text" id="myInput" onkeyup="myFunctionSp()" placeholder="Search for names..">
     <br>
     
     <br>
     
     <ul class="responsive-table" id="dataTable">
       <li class="table-header">
       <div class="col col-1">Sl No.</div>
         
         <div class="col col-2">Service Type</div>
         <div class="col col-2">Name</div>
         <div class="col col-3">Address</div>
         <div class="col col-3">Email</div>
         <div class="col col-2">Phone</div>
         <div class="col col-1"></div>
         
       </li>';
       $serial_num=1;

    while($row = $result->fetch_assoc()) 
        {
        echo '<li class="table-row">
        <div class="col col-1" data-label="ID">'.$serial_num.'</div>
       
        <div class="col col-2" data-label="Service">'.$row['s_name'].'</div>
        <div class="col col-2" data-label="Name"> <a href="admin-cust-details.php?sp_id='.$row['sp_id'].'&name='. $row['sp_fname'].' '.$row['sp_lname'].'">'. $row['sp_fname'].' '.$row['sp_lname'].'</a></div>
        <div class="col col-3" data-label="Address">'.$row['sp_house'].', '.$row['sp_city'].', 
        '.$row['sp_district'].', '.$row['sp_pincode'].'</div>
        <div class="col col-3" data-label="Email">'. $row['sp_username'].'</div>
        <div class="col col-2" data-label="Phone">'. $row['sp_phone'].'</div>
        <div class="col col-1" data-label="">
        ';
        $serial_num++;
        
        if($row["sp_status"]=="Active")
        {
        echo '<button class="submit-btn2" onclick="confirmDeletion('.$row['sp_id'].',\'sp\')">Disable </button></div>';
        }
        else
        {
         echo' <button class="submit-btn3" onclick="confirmEnable('.$row['sp_id'].',\'sp\')"> Enable</button></div>';
        }
        echo'
        </li>';
  
        }
      
        } 
        else
        {
        echo "0 results"; 
        }
}
else if($table_to_be_selected == 'cust'){

    //$sql = "SELECT * FROM cust_details left outer join cust_remark on cust_remark.cust_id = cust_details.cust_id";
    $sql = "Select * from cust_details";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        echo '<div class="container" id="table-details">
        <h2>Customers</h2>

        <br> 
     <input type="text" id="myInput" onkeyup="myFunctionCust()" placeholder="Search for names..">
     <p>
     <button class="btn btn-info" id="generatePDF" onclick="generatePDF()" style="float:right;">Download PDF</button>
   </p>
     <br>
     <br>

        <ul class="responsive-table" id="dataTable">
          <li class="table-header">
          <div class="col col-1">Sl No.</div>
      
            <div class="col col-2">Name</div>
            <div class="col col-3">Address</div>
            <div class="col col-2">Email</div>
            <div class="col col-2">Phone</div>
            <div class="col col-2">Status</div>
            
          </li>';
          $serial_num=1;
       
        while($row = $result->fetch_assoc()) 
            {
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$serial_num.'</div>
         
            <div class="col col-2" data-label="Name"><a href="admin-cust-details.php?cust_id='.$row['cust_id'].'&name='. $row['cust_fname'].' '.$row['cust_lname'].'">'. $row['cust_fname'].' '.$row['cust_lname'].'</a></div>
            <div class="col col-3" data-label="Address">'.$row['cust_house'].', '.$row['cust_city'].', 
            '.$row['cust_dist'].', '.$row['cust_pincode'].'</div>
            <div class="col col-2" data-label="Email">'. $row['cust_username'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['cust_phno'].'</div>
            <div class="col col-2" data-label="">'. $row['cust_status'].'</div>
            <div class="col col-1" data-label="">
            ';
            $serial_num++;
            
            if($row["cust_status"]=="Active")
        {
        echo '<button class="submit-btn2" onclick="confirmDeletion('.$row['cust_id'].',\'cust\')">Disable </button></div>';
        }
        else
        {
         echo' <button class="submit-btn3" onclick="confirmEnable('.$row['cust_id'].',\'cust\')"> Enable</button></div>';
        }
        echo'
          </li> ';
      
            }
            echo "</ul></div>";
            }
            else
        {
        echo "0 results"; 
        }
          }
          
        
else
{
  if(isset($_GET["dateFrom"]) && isset($_GET["dateTo"]))
    {
       
     $dateFrom=$_GET["dateFrom"];
     $dateTo=$_GET["dateTo"];   
     if($dateFrom> $dateTo){
       echo "<script>alert('Please enter valid 'from' and 'to' dates')</script>";
     }
    }
  
    $sql= "select p.total_amount, p.p_id,p.p_date,a.a_id,a.rc_id, a.sp_id, rc.rm_id , rc.s_id, rm.cust_id,rm.r_date,
    c.cust_fname,c.cust_lname,sp.sp_fname,sp.sp_lname,s.s_name
      from payment as p
      inner join accept as a on a.a_id=p.a_id
      inner join sp_details as sp on sp.sp_id=a.sp_id
      
      inner join request_child as rc on rc.rc_id=a.rc_id
      inner join service_details as s on s.s_id=rc.s_id
      inner join request_master as rm on rm.rm_id=rc.rm_id
      inner join cust_details as c on c.cust_id=rm.cust_id
      where rm.r_date >='". $dateFrom ."'and rm.r_date <='".$dateTo."' order by rm.r_date ";

    $result = $conn->query($sql);
    
       
        echo '<div class="container">
        <h2>TRANSACTIONS</h2>
<BR>
<form action="#" method="GET">
        <center> &nbsp &nbsp &nbsp Date From : <input type="date" name="dateFrom" value="'.$dateFrom.'">
        &nbsp &nbsp &nbsp
     Date To : <input class="form-group" type="date" class="dateFilter" name="dateTo" value="'.$dateTo.'">
     &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
     <input type="hidden" value="'.$table_to_be_selected.'" name="id">
     <button class="submit-btn" name="search">Search</button>
    
     </center></form><p>
     <button class="btn btn-info" id="generatePDF" onclick="generatePDF()" style="float:right;">Download PDF</button>
</p><br>
     <br>
        <ul class="responsive-table">
          <li class="table-header">
          <div class="col col-1">Sl No.</div>
            <div class="col col-1">ID</div>
            <div class="col col-2">CUSTOMER</div>
            <div class="col col-2">SERVICE PROVIDER</div>
            <div class="col col-2">SERVICE</div>
            <div class="col col-1">AMOUNT</div>
            <div class="col col-2">WORK DATE</div>
            <div class="col col-2">PAYMENT DATE</div>
            
          </li>';
          $serial_num=1;
          if ($result->num_rows > 0)
          {
        while($row = $result->fetch_assoc()) 
            {
              if($row['r_date']>=$dateFrom && $row['r_date'] <= $dateTo ){
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$serial_num.'</div>
            <div class="col col-1" data-label="ID">'.$row['p_id'].'</div>
            <div class="col col-2" data-label="Name">'. $row['cust_fname'].' '.$row['cust_lname'].'</div>
            <div class="col col-2" data-label="Address">'.$row['sp_fname'].' '.$row['sp_lname'].'</div>
            <div class="col col-2" data-label="Email">'. $row['s_name'].'</div>
            <div class="col col-1" data-label="Amount">'. $row['total_amount'].'</div>
            <div class="col col-2" data-label="Work Date">'. $row['r_date'].'</div>
            <div class="col col-2" data-label="Payment Date">'. $row['p_date'].'</div> </li>';
            
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
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "delete.php", true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  var reasonForRejection = prompt("Please enter the reason for disabling!");
  xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            
            console.log("Success");
          window.location.href ="admin-tables.php?id="+user;
        }
    };
  xhr.send(JSON.stringify({
    reason: reasonForRejection,
    id: id,
    user: user
}));
  // if(confirm('Do you want to disable this entry?')){
  //   window.location.href= "delete.php?"+user+"="+id;  
  // }
}

function confirmEnable(id,user){
  console.log(user);
  if(confirm('Do you want to enable this entry?')){
    window.location.href= "enable.php?"+user+"="+id;  
  }
}
</script>

<script>
function myFunctionSp() {
  // Declare variables
  var input, filter, table, li, div, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("dataTable");
  li = table.getElementsByTagName("li");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    div = li[i].getElementsByTagName("div")[2];
    if (div) {
      txtValue = div.textContent || div.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
}
</script>

<script>
  
function myFunctionCust() {
  // Declare variables
  var input, filter, table, li, div, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("dataTable");
  li = table.getElementsByTagName("li");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    div = li[i].getElementsByTagName("div")[1];
    if (div) {
      txtValue = div.textContent || div.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
}



// var doc = new jsPDF();

function generatePDF1() {

  

  var pdf = new jsPDF('p','pt','a4');
//var source = document.getElementById('table-container').innerHTML;
console.log(document.getElementById('table-details'));
var margins = {
   top: 25,
   bottom: 60,
   left: 25,
   width: 400
};
// all coords and widths are in jsPDF instance's declared units
// 'inches' in this case
pdf.text(20, 20, 'Hello world.');
doc.setFillColor(204, 204,204,0);
pdf.addHTML(document.getElementById('dataTable'), margins.top, margins.left, {}, function() {
   pdf.save('test.pdf');
});

}
</script>



</html>