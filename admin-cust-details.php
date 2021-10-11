<html>
<head>
<title>DHS | Details</title>
<link rel="stylesheet" href="stylesheets/admin-tables.css">
<link href="stylesheets/bootstrap.css" rel="stylesheet">
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

  
<?php
require_once "db-connection.php";
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
    $sql = "SELECT rm.r_date, rm.cust_id, a.rc_id, p.a_id, p.total_amount, p.p_date,p.p_status, 
    concat(c.cust_fname,' ',c.cust_lname) as cust_name 
    from request_master as rm
    inner join request_child as rc on rc.rm_id=rm.rm_id 
    inner join accept as a on a.rc_id=rc.rc_id
    inner join payment as p on p.a_id=a.a_id 
    inner join cust_details as c on c.cust_id=rm.cust_id
    inner join sp_details as sp on sp.sp_id=a.sp_id
    where sp.sp_id=".$sp_id;
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
     echo '<div class="container">
     <h2>Works of '. $sp_fname.'</h2>

     <input type="date">
     <ul class="responsive-table">
       <li class="table-header">
         <div class="col col-1">ID</div>
         <div class="col col-3">Requested By</div>
         <div class="col col-2">Req Date</div>
         <div class="col col-2">Total Amount</div>
         <div class="col col-2">Payment Status</div>
         <div class="col col-2">Payment Date</div>
         
         
       </li>';

    while($row = $result->fetch_assoc()) 
        {
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$row['rc_id'].'</div>
            <div class="col col-3" data-label="Name">'. $row['cust_name'].'</div>
            <div class="col col-2" data-label="Address">'.$row['r_date'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['total_amount'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['p_status'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['p_date'].'</div>
      </li>';
  
        }
        echo "</ul></div>";
        } 
        else
        {
        echo "0 results"; 
        }
}
else if($table_to_be_selected == 'cust'){

    $sql = "SELECT rm.r_date, rm.cust_id, rc.r_status, a.rc_id, p.a_id, p.total_amount, s.s_name, p.p_date, 
    concat(sp.sp_fname,' ',sp.sp_lname) as sp_name 
    from request_master as rm
    inner join request_child as rc on rc.rm_id=rm.rm_id 
    inner join accept as a on a.rc_id=rc.rc_id
    inner join payment as p on p.a_id=a.a_id 
    inner join cust_details as c on c.cust_id=rm.cust_id
    inner join sp_details as sp on sp.sp_id=a.sp_id
    inner join service_details as s on s.s_id=sp.s_id
    where c.cust_id=".$cust_id;

    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        echo '<div class="container">
        <h2>Requests of '. $cust_fname.'</h2>
        <ul class="responsive-table">
          <li class="table-header">
            <div class="col col-1">ID</div>
            <div class="col col-2">Service</div>
            <div class="col col-2">Requested Date</div>
            <div class="col col-2">Req Status</div>
            <div class="col col-2">Accepted By</div>
            <div class="col col-2">Total Amount</div>
            <div class="col col-2">Payment Date</div>
            
          </li>';
       
        while($row = $result->fetch_assoc()) 
            {
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$row['rc_id'].'</div>
            <div class="col col-2" data-label="Name">'. $row['s_name'].'</div>
            <div class="col col-2" data-label="Address">'.$row['r_date'].'</div>
            <div class="col col-2" data-label="Email">'. $row['r_status'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['sp_name'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['total_amount'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['p_date'].'</div>
   
            
          </li>';
      
            }
            echo "</ul></div>";
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
</script>
</html>