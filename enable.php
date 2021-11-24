<?php 
require_once "db-connection.php";
    if(isset($_GET['cust']))
    {
        $enable_service_provider = "update cust_details set cust_status='Active' where cust_id =".$_GET['cust'];
        $delete_remark = "delete from cust_remark where cust_id =".$_GET['cust'];
        if(mysqli_query($conn, $enable_service_provider )){
            mysqli_query($conn,$delete_remark);
            header("location: admin-tables.php?id=cust");
        } else{
            echo "ERROR: Could not able to execute $enable_service_provider. " . mysqli_error($conn);
        } 

    }
    else if (isset($_GET['sp']))
    {
        $enable_service_provider = "update  sp_details set sp_status='Active' where sp_id=".$_GET['sp'];
        if(mysqli_query($conn, $enable_service_provider )){
            header("location: admin-tables.php?id=sp");
        } else{
            echo "ERROR: Could not able to execute $enable_service_provider. " . mysqli_error($conn);
        }
    }   
?>