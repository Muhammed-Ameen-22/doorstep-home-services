<html>
<head>
<title></title>
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
$table_to_be_selected = $_GET["id"];

if($table_to_be_selected == 'sp'){
    $sql = "SELECT * FROM sp_details inner join service_details on sp_details.s_id = service_details.s_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
     echo '<div class="container">
     <h2>Service Providers</h2>
     <ul class="responsive-table">
       <li class="table-header">
         <div class="col col-1">ID</div>
         <div class="col col-2">Service Type</div>
         <div class="col col-2">Name</div>
         <div class="col col-3">Address</div>
         <div class="col col-3">Email</div>
         <div class="col col-2">Phone</div>
         <div class="col col-1"></div>
         
       </li>';

    while($row = $result->fetch_assoc()) 
        {
        echo '<li class="table-row">
        <div class="col col-1" data-label="ID">'.$row['sp_id'].'</div>
        <div class="col col-2" data-label="Service">'.$row['s_name'].'</div>
        <div class="col col-2" data-label="Name">'. $row['sp_fname'].' '.$row['sp_lname'].'</div>
        <div class="col col-3" data-label="Address">'.$row['sp_house'].', '.$row['sp_city'].', 
        '.$row['sp_district'].', '.$row['sp_pincode'].'</div>
        <div class="col col-3" data-label="Email">'. $row['sp_username'].'</div>
        <div class="col col-2" data-label="Phone">'. $row['sp_phone'].'</div>
        <div class="col col-1" data-label=""><button class="btn" onclick="confirmDeletion('.$row['sp_id'].')"> <i class="fas fa-trash-alt"></i></button></div>
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

    $sql = "SELECT * FROM cust_details";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        echo '<div class="container">
        <h2>Customers</h2>
        <ul class="responsive-table">
          <li class="table-header">
            <div class="col col-1">ID</div>
            <div class="col col-2">Name</div>
            <div class="col col-3">Address</div>
            <div class="col col-4">Email</div>
            <div class="col col-2">Phone</div>
            
          </li>';
       
        while($row = $result->fetch_assoc()) 
            {
            echo '<li class="table-row">
            <div class="col col-1" data-label="ID">'.$row['cust_id'].'</div>
            <div class="col col-2" data-label="Name">'. $row['cust_fname'].' '.$row['cust_lname'].'</div>
            <div class="col col-3" data-label="Address">'.$row['cust_house'].', '.$row['cust_city'].', 
            '.$row['cust_dist'].', '.$row['cust_pincode'].'</div>
            <div class="col col-4" data-label="Email">'. $row['cust_username'].'</div>
            <div class="col col-2" data-label="Phone">'. $row['cust_phno'].'</div>
          </li>';
      
            }
            echo "</ul></div>";
            } 
            else
            {
            echo "0 results"; 
            }
}
$conn->close();

?>
</table>
</body>
<script> 

function confirmDeletion(id){
  if(confirm('Do you want to delete this entry?')){
    window.location.href= "delete.php?spid="+id;  
  }

}
</script>
</html>