<?php
require_once "db-connection.php";
$service_providers_available ="";
$pincode="";
session_start();
$currentUser = $_SESSION["name"];
if(isset($_POST['book'])){
    echo "hello";
    $service=$_POST['service'];
    $pincode=$_POST['pincode'];
    $quantity=$_POST['quantity'];
   $cust_id = $_SESSION['cust_id'];
   $req_date =$_POST['req-date'];
    
    $sql_insert_request_table = "insert into request_master values(NULL,'$cust_id','$req_date','$quantity')";
    if(mysqli_query($conn, $sql_insert_request_table)){
            
        } else{
            echo "ERROR: Could not able to execute $sql_insert_request_table. " . mysqli_error($conn);
        }
    $sql_last_inserted_id = "SELECT LAST_INSERT_ID() as id";
    $res = mysqli_query($conn, $sql_last_inserted_id);
    $last_inserted_id = mysqli_fetch_array($res);
    $id = $last_inserted_id['id'];
    $sql_insert_request_child = "insert into request_child values(NULL,$id,'$service','Requested',$pincode)";
    echo $sql_insert_request_child;
    if(mysqli_query($conn, $sql_insert_request_child)){
        header("location: cust-myrequests.php");
        
    } else{
        echo "ERROR: Could not able to execute $sql_insert_request_table. " . mysqli_error($conn);
    }
}
else if(isset($_POST['service']) && isset($_POST['pincode'])){
   
    $service=$_POST['service'];
    $pincode=$_POST['pincode'];
    $_SESSION['pincode']=$pincode;
    // echo "Hello: $service";
    // echo "Hello: $pincode";
    $sql="select count(*) as count from sp_details where s_id='".$service."' AND sp_pincode='".$pincode."'";
   // $sql="select count(*) as count from sp_details";
    $result=mysqli_query($conn,$sql);
    $count = mysqli_fetch_array($result);
    $query ="select s_name from service_details where s_id ='".$service."'";
    $result = mysqli_query($conn,$query);
    $service_name = mysqli_fetch_array($result);

    $service_providers_available = "There are ".$count[0]." ".$service_name[0]."(s) available in your area";


    // while($row = mysqli_fetch_array($result))
    //         {

    //          echo "valu";
    //           echo "\ncount is :".$row['count'];
    //           $service_providers_available = "There are ".$row['count']." no of service providers currently available";
    //           echo $service_providers_available;
    //         }

    // if(mysqli_num_rows($result)==1){
    //     echo"You have sucessfully logged in";
    //     
    //     exit();
    // }
    // else{
    // echo"You entered incorrect password";
    // exit();
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
                    <li class="nav-item active">
                        <a class="nav-link" > <?php echo "Hi, ".$currentUser; ?></a>
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
    <div class ="booking">
	<form action="cust-dashboard.php" method="POST">
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				
					<div class="booking-form">
						<form>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<span class="form-label">Select Service</span>
                                       
										<select class="form-control" name="service" id="service">
                                            <option value=101>Electrician</option>
                                            <option value=102>Carpenter</option>
                                            <option value=103>Plumber</option>
                                            <option value=104>Mechanic</option>
                                            <option value=105>Painter</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<span class="form-label">Pincode</span>
										<input class="form-control" id="pincode" type="text" placeholder="Pincode" name="pincode" value ="<?php echo$pincode ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-btn">
										<button class="submit-btn">Search</button>
									</div>
								</div>
                               <span class="form-label form-result"> <h6><?php echo $service_providers_available; ?> </h6></span>
							</div>
							<div class="row response">

								<div class="col-md-4">
									<div class="form-group">
										<span class="form-label">Quantity</span>
										<input class="form-control" type="text" placeholder="Quantity" name="quantity" >
									</div>
									</div>
                                    <div class="col-md-4">
									<div class="form-group">
										<span class="form-label">Date</span>
										<input class="form-control" type="date" name ="req-date">
									</div>
									</div>
								<div class="col-md-4">
									<div class="form-btn">
										<button class="submit-btn" name="book">Request</button>
									</div>
							</div>
							</div>
						</form>
					</div>
				
			</div>
		</div>
	</div>
	</form>
    </div>
</body>
<script type="text/javascript">
  document.getElementById('service').value = "<?php echo $service;?>";
</script>
</html>
 