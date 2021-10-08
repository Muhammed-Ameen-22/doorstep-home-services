<?php 
require_once "db-connection.php";
    if(isset($_GET['cust']))
    {
        $cancel_req = "update request_child set r_status='Cancelled' where rc_id=".$_GET['cust'];
        if(mysqli_query($conn, $cancel_req )){
            header("location: cust-myrequests.php");
        } else{
            echo "ERROR: Could not able to execute $cancel_req. " . mysqli_error($conn);
        } 
    }
   
?>