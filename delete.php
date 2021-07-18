<?php 
require_once "db-connection.php";

    $delete_service_provider = "delete from sp_details where sp_id =".$_GET['spid'];
    
    if(mysqli_query($conn, $delete_service_provider )){
        header("location: admin-tables.php?id=sp");
    } else{
        echo "ERROR: Could not able to execute $delete_service_provider. " . mysqli_error($conn);
    }
?>