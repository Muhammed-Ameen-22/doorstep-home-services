<?php 
require_once "db-connection.php";
    if(isset($_GET['cust']))
    {
        $delete_service_provider = "delete from cust_details where cust_id =".$_GET['cust'];
        if(mysqli_query($conn, $delete_service_provider )){
            header("location: admin-tables.php?id=sp");
        } else{
            echo "ERROR: Could not able to execute $delete_service_provider. " . mysqli_error($conn);
        } 
    }
    else if (isset($_GET['sp']))
    {
        $delete_service_provider = "update  sp_details set sp_status='Inactive' where sp_id=".$_GET['sp'];
        if(mysqli_query($conn, $delete_service_provider )){
            header("location: admin-tables.php?id=sp");
        } else{
            echo "ERROR: Could not able to execute $delete_service_provider. " . mysqli_error($conn);
        }
    }   
?>