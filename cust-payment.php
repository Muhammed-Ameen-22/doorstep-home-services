<?php
require_once "db-connection.php";
session_start();
$currentUser = $_SESSION["name"];
$cust_id = $_SESSION['cust_id'];
$sql= "select p.total_amount, p.a_id, a.rc_id, a.sp_id, rc.rm_id , rm.cust_id
from payment as p
inner join accept as a on a.a_id=p.a_id
inner join request_child as rc on rc.rc_id=a.rc_id
inner join request_master as rm on rm.rm_id=rc.rm_id
where rm.cust_id = ".$cust_id." and p.p_status !='Paid'";

$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : "";

?>
<div class="px-4 px-lg-0">
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payment | DHS</title>
        <link href="stylesheets/bootstrap.css" rel="stylesheet">
        <link href="stylesheets/cust-payment.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700"
            rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="javascript/bootstrap.js" type="text/javascript"></script>
        <script src="javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="javascript/bootstrap.bundle.js" type="text/javascript"></script>
       
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
                            <a class="nav-link" href="#"> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> Contact </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <div class="pb-5">
      <div class="container">
        <div class="row py-5 p-4 bg-white rounded shadow-sm">
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Card</div>
            <div class="p-4">
              <p class="font-italic mb-4">Add card details</p>
              <!-- <div class="input-group mb-4 border rounded-pill p-2"> -->
                <!-- <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0"> -->
               
              <!-- </div> -->
              <div class="p-4">
                <form class="credit-card">
                  <div class="form-header">
                    <h4 class="title">Credit card detail</h4>
                  </div>
            
                  <div class="form-body">
                    <!-- Card Number -->
                    <input type="text" class="card-number" placeholder="Card Number">
            
                    <!-- Date Field -->
                    <div class="date-field">
                      <div class="month">
                        <select name="Month">
                          <option value="january">January</option>
                          <option value="february">February</option>
                          <option value="march">March</option>
                          <option value="april">April</option>
                          <option value="may">May</option>
                          <option value="june">June</option>
                          <option value="july">July</option>
                          <option value="august">August</option>
                          <option value="september">September</option>
                          <option value="october">October</option>
                          <option value="november">November</option>
                          <option value="december">December</option>
                        </select>
                      </div>
                      <div class="year">
                        <select name="Year">
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                        </select>
                      </div>
                    </div>
            
                    <!-- Card Verification Field -->
                    <div class="card-verification">
                      <div class="cvv-input">
                        <input type="text" placeholder="CVV">
                      </div>
                      <div class="cvv-details">
                        <p>3 or 4 digits usually found <br> on the signature strip</p>
                      </div>
                    </div>
                    <div class="input-group mb-4 border rounded-pill p-2">
                    <div class="input-group-append border-0">
                      <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>
                        Add Card</button>
                    </div>
                    </div>
                    <!-- Buttons -->
                    <!-- <button type="submit" class="proceed-btn"><a href="#">Proceed</a></button>
                    <button type="submit" class="paypal-btn"><a href="#">Pay With</a></button> -->
                  </div>
                </form>
              </div>
            </div>
            <!-- <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div> -->
         
          </div>
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Work summary </div>
            <div class="p-4">
              <p class="font-italic mb-4"></p>
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Work Total 
                    </strong><strong>Rs.<?php echo "$total_amount" ?></strong></li>
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Extra charges</strong>
                    <strong>Rs.<?php echo "0" ?></strong></li>
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                  <h5 class="font-weight-bold">Rs.<?php echo "$total_amount" ?></h5>
                </li>
              </ul><a href="#" class="btn btn-dark rounded-pill py-2 btn-block">Procceed to checkout</a>
            </div>
          </div>

        </div>
  
      </div>
    </div>
  </div>
  </body>
  </html>