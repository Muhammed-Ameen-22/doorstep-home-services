<?php 
require_once "db-connection.php";
    
    //$user = json_decode($_POST['user']);
    $json=file_get_contents('php://input');
    //print_r($data);
    $data = json_decode($json);
    //error_log($data2->user);
    if($data->user == 'cust')
    {
        $delete_service_provider = "update cust_details set cust_status='Inactive' where cust_id =".$data->id;
        if(mysqli_query($conn, $delete_service_provider )){
  
        } else{
            echo "ERROR: Could not able to execute $delete_service_provider. " . mysqli_error($conn);
        } 
        //$update_remark = "update cust_remark set remark='".$data->reason."' where cust_id =".$data->id;
        // $update_remark = "insert into cust_remark values(NULL,".$data->id.", '".$data->reason."')";
        $update_remark = "insert into cust_remark values(".$data->id.", '".$data->reason."') on duplicate key update remark='".$data->reason."'";
        

        error_log($update_remark);
        if(mysqli_query($conn, $update_remark )){
            header("location: admin-tables.php?id=cust");
        } else{
            echo "ERROR: Could not able to execute $update_remark. " . mysqli_error($conn);
        } 

    }
    else if ($data->user == 'sp')
    {
        // $delete_service_provider = "update  sp_details set sp_status='Inactive' where sp_id=".$_GET['sp'];
        // if(mysqli_query($conn, $delete_service_provider )){
        //     header("location: admin-tables.php?id=sp");
        // } else{
        //     echo "ERROR: Could not able to execute $delete_service_provider. " . mysqli_error($conn);
        // }


        $delete_service_provider = "update sp_details set sp_status='Inactive' where sp_id =".$data->id;
        if(mysqli_query($conn, $delete_service_provider )){
            
        } else{
            echo "ERROR: Could not able to execute $delete_service_provider. " . mysqli_error($conn);
        } 
        //$update_remark = "update cust_remark set remark='".$data->reason."' where cust_id =".$data->id;
        // $update_remark = "insert into cust_remark values(NULL,".$data->id.", '".$data->reason."')";
        $update_remark = "insert into sp_remark values(".$data->id.", '".$data->reason."') on duplicate key update remark='".$data->reason."'";
        

        error_log($update_remark);
        if(mysqli_query($conn, $update_remark )){
           
        } else{
            echo "ERROR: Could not able to execute $update_remark. " . mysqli_error($conn);
        } 
    }   
?>