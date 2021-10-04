<?php
require_once "db-connection.php";

session_start();
$amount=$_SESSION['total_amt'];
$a_id =$_SESSION['a_id'];


 
$currentUser = $_SESSION["name"];
if(isset($_GET['id'])){
    
    $sql_get_card_details = "select card_id from card where cust_id=".$_GET['cust'];
    if($result = mysqli_query($conn, $sql_get_card_details)){
        $row = $result->fetch_assoc();
        $card_id = $row['card_id'];
       
    } else{
        echo "ERROR: Could not able to execute $sql_get_card_details. " . mysqli_error($conn);
    }

    $sql_update_payment_table = "update payment set p_status='Paid',card_id=".$card_id.",p_date=now() where a_id='$a_id'";
    if(mysqli_query($conn, $sql_update_payment_table)){
            $sql_get_payment_id="select p_id from payment where a_id =".$a_id;
            $paymentrow = mysqli_query($conn,$sql_get_payment_id);
            $payment_id = $paymentrow->fetch_assoc();

            echo '<script>alert("Payment successfull!");</script>';
        } else{
            echo "ERROR: Could not able to execute $sql_update_payment_table. " . mysqli_error($conn);
        }
    
    // if(mysqli_query($conn, $sql_insert_request_child)){
    //   //  header("location: cust-myrequests.php");

    // } else{
    //     echo "ERROR: Could not able to execute $sql_insert_request_table. " . mysqli_error($conn);
    // }
}



?> 

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="stylesheets/bootstrap.css" rel="stylesheet">
    <link href="stylesheets/cust-dashboard.css" rel="stylesheet">


	<title>Customer Dashboard | DHS</title>
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">

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
                    <li class="nav-item">
                        <a class="nav-link" > <?php echo "Hi, ".$currentUser; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cust-myrequests.php"> My Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class ="container">
        <br>
	<H3> Payment Success !! Thank you</H3>
    <h5>Your payment ID for future reference :  <?php echo $payment_id['p_id']; ?> </h5>
    </div>
</body>
<script type="text/javascript">
 
</script>
</html>
 