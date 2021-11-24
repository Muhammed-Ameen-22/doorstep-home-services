<?php 
require_once "db-connection.php";
if(isset($_POST["login"])) {
    $userType=$_POST["user"];
    // Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = $login_err = "";
    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        if($userType=="cust")
        {
    
            // Validate credentials
            if(empty($username_err) && empty($password_err)){
                // Prepare a select statement
                
            //     $sql = "SELECT * FROM cust_details where cust_username ='".$username."' AND cust_pass='".password_hash($_POST["password"],PASSWORD_BCRYPT)."'";
            //     echo($sql);
            //     if(mysqli_query($conn, $sql)){
            //     //    echo "Records inserted successfully.";
            //     } else{
            //         echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            //     }
            //     $result=mysqli_query($conn,$sql);
            //     // if($result==1){

            //     //     while($row = mysqli_fetch_array($result))
            //     //     {
            //     //       echo "\nEmail".$row['cust_email']."\tPass: ".$row['cust_pass'];
            //     //     }
            //     //   }
            //     if(mysqli_num_rows($result)==1){          
            //         header("location: cust-dashboard.php");
            //         exit();
            //     }
            //     else{
            //    echo"Wrong pass";
            //     exit();
            //     }

                $sql =  "SELECT concat(cust_fname,' ',cust_lname) as name,cust_pass,cust_username,cust_id from cust_details 
                where cust_username ='".$username."'and cust_status!='Inactive'";

                $result=mysqli_query($conn,$sql);
       
                if(mysqli_num_rows($result)>0){  
                    $row = mysqli_fetch_array($result);
        
                    if(password_verify($password,$row['cust_pass'])){   
                        session_start();
                        $_SESSION["name"] = $row['name'];   
                        $_SESSION["cust_id"] = $row['cust_id']; 
                        
                        header("location: cust-dashboard.php");
                        exit();
                    }
                    else{
                        echo '<script>alert("Wrong Username / Password"); location.href = "index.php";</script>';
                    }
                }
                else{
                  $sql = "SELECT cust_remark.remark as remark from cust_remark inner join cust_details 
                  on cust_remark.cust_id = cust_details.cust_id where cust_details.cust_username = '".$username."'";
        
                   $result=mysqli_query($conn,$sql);
                   
                   if(mysqli_num_rows($result)>0){  
                    $row = mysqli_fetch_array($result);
                    $remark = $row['remark'];
                   
                    echo '<script>alert("Your account has been revoked due to : '.$remark.'"); location.href = "index.php";</script>'; 
                   }
                   else{
                    echo '<script>alert("Please try again with a valid account"); ';
                    // exit();
                }
              }
            }
        }
        else if($userType=="sp")
        {
            // Validate credentials
        if(empty($username_err) && empty($password_err)){
            
            $sql =  "SELECT * FROM sp_details where sp_username ='".$username."' and sp_status!='Inactive'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){  
                    $row = mysqli_fetch_array($result);
                    if(password_verify($password,$row['sp_password'])){        
                        session_start();
                        $_SESSION["name"] = $row['sp_fname']." ".$row['sp_lname'] ; 
                        //echo $_SESSION["name"];
                        $_SESSION["sp_id"] = $row['sp_id'];
                        $_SESSION["s_id"] = $row['s_id']; 
                        header("location: sp-dashboard.php");
                        exit();
                    }
                    else{
                        echo '<script>alert("Wrong Username / Password");location.href = "index.php";</script>';
                    }
                }
                else{
                    echo '<script>alert("Please try again with a valid account"); location.href = "index.php";</script>';
                    
                    //exit();
                }
        } 
        }
            
        }
}
    
    // Close connection
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | DHS</title>

    <link rel="stylesheet" href="assets/css/maicons.css">
    

<link rel="stylesheet" href="assets/css/bootstrap.css">

<link rel="stylesheet" href="assets/vendor/animate/animate.css">

<link rel="stylesheet" href="assets/css/theme.css">

    <link href="stylesheets/bootstrap.css" rel="stylesheet">
    <link href="stylesheets/style.css" rel="stylesheet">
    <link href="stylesheets/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" >

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="javascript/bootstrap.js" type="text/javascript"></script>
    <script src="javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="javascript/bootstrap.bundle.js" type="text/javascript"></script>
   
    <!-- <style>
        body
        {
            background:red;
        }
    
.navbar-default {
    background: none;
  	border: none;
}
    </style> -->

</head>

<body>
    <!-- <div class="header"> -->
    <nav class="navbar my-nav navbar-expand-lg navbar-light  fixed-top ">

        <div class="container-fluid">
            <a class="navbar-brand" href="#"> <img class="logo-img" src="images/logo.png"> </a> 
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#modalLoginForm" href="#"> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#aboutus"> About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact"> Contact </a>
                    </li>
                </ul>
            </div>
        </div>
        
    </nav>
   
    <!-- <div class="bg-image">
        <img src="images/bg.jpg"  alt="">
        <div class="bg-image-caption">
            Services are at your doorstep 
            <div class="col-md-4">
				<div class="form-btn" data-toggle="modal" data-target="#modalLoginForm">
                	<button class="submit-btn">Login</button>
				</div>
			</div>
        </div>
    </div> -->
    <br><br><br> <br>

    <div class="container">
      <!-- <div class="page-banner home-banner"> -->
        <div class="row align-items-center flex-wrap-reverse h-100">
          <div class="col-md-12 py-10 wow fadeInLeft">
          <div id="carouselExampleIndicators" class="my-carousel carousel slide"  data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active" data-interval="2000">
                <img class="d-block w-100 img-fluid" src="images/background1.jpg" alt="First slide">
                <div class="carousel-caption">
                    <!-- <h2 class="carousel-head">SERVICE AT YOUR DOORSTEP</h2> -->
                    <!-- <a href="" class="button-login btn btn-primary" data-toggle="modal" data-target="#modalLoginForm" >
                        Login</a> -->
                    <div class="col-md-4">
									<div class="form-btn" data-toggle="modal" data-target="#modalLoginForm">
										<button class="submit-btn">Login</button>
									</div>
					</div>
                </div>
            </div>
            <div class="carousel-item" data-interval="2000">
                <img class="d-block w-100 img-fluid" src="images/background4.png" alt="Second slide">
                <div class="carousel-caption">
                    <!-- <a href="" class="button-login btn btn-primary" data-toggle="modal" data-target="#modalLoginForm" >Login</a> -->
                    <div class="col-md-4">
									<div class="form-btn" data-toggle="modal" data-target="#modalLoginForm">
										<button class="submit-btn">Login</button>
									</div>
					</div>
                </div>
            </div>
            <div class="carousel-item" data-interval="2000">
                <img class="d-block w-100 img-fluid" src="images/background2.png" alt="Third slide">
                <div class="carousel-caption">
                    <!-- <a href="" class="button-login btn btn-primary" data-toggle="modal" data-target="#modalLoginForm" >Login</a> -->
                    <div class="col-md-4">
									<div class="form-btn" data-toggle="modal" data-target="#modalLoginForm">
										<button class="submit-btn">Login</button>
									</div>
					</div>
                </div>
            </div> 
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </div>
    
    <div class="login-modal modal wrapper " tabindex="-1" id="modalLoginForm" >
        <button type="button" class="close" data-dismiss="modal">
            &times;
      </button>
        <header>Login Form</header>
        <form action="" method="POST">
            <p style="text-align: left; font-size: 25px;">
                Login as : 
            </p>
            <div class="sign-txt" style="text-align: left;">
                <div class="form-check ">
                    <input class="radio-cus form-check-input" type="radio" name="user"  value="cust" id="flexRadioDefault1" checked required>
                    <label class="form-check-label" for="flexRadioDefault1">
                      Customer
                    </label>
                  </div><br>
            </div>
            <div class="sign-txt">
                <div class="form-check " style="text-align: left    ">
                    <input class="radio-sp form-check-input" type="radio" name="user" value="sp" id="flexRadioDefault2" requ>
                    <label class="form-check-label" for="flexRadioDefault1">
                      Service Provider
                    </label>
                  </div><br>
            </div>

            <div class="field email">
            <div class="input-area">
              <input type="text" placeholder="Email Address" class="email" name="username">
              <i class="icon fas fa-envelope"></i>
              <i class="error error-icon fas fa-exclamation-circle"></i>
            </div>
            <div class="error error-txt">Email can't be blank</div>
          </div>
          <div class="field password">
            <div class="input-area">
              <input type="password" placeholder="Password" name="password">
              <i class="icon fas fa-lock"></i>
              <i class="error error-icon fas fa-exclamation-circle"></i>
            </div>
            <div class="error error-txt">Password can't be blank</div>
          </div>
          <!-- <div class="pass-txt"><a href="#">Forgot password?</a></div> -->
          <input type="submit" style="background-color:red" value="Login" name="login">
        </form>
        <div class="sign-txt">Not yet member? <a href="registration.php">Signup now</a></div>
      </div>
           
          </div>
         
        </div>
        <a href="#service" class="btn-scroll" data-role="smoothscroll"><span class="mai-arrow-down"></span></a>
      </div>
    <!-- </div> -->
    
    <div class=circle>
    

      <!-- </div> -->



    <div class="container-fluid padding " id="aboutus">
        <div class="row welcome text-center">
            <div class="col-12">
                <h1 class="display-4">We Serve We Built</h1>
            </div>
            <hr>
            <div class="col-12">
                <p class="lead"> We provide services which are hard for you to reach out.
                    Our service providers are a click away, they will provide you the best services available.
                    The best is provided to you from the best in your locality.
                </p>
            </div>
            
        </div>
    </div>

    <div class="page-section bg-light">
    <div class="container">
      <div class="text-center wow fadeInUp">
        <div class="subhead" id="service" name="service">Our services</div>
        <h2 class="title-section">SERVICES WE PROVIDE</h2>
        <div class="divider mx-auto"></div>
      </div>

        <div class="row">
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Electrical works</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Plumbing</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Carpentry</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Painting works</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Mechanical works</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Car cleaning</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>House works</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 col-xl-3 py-3 wow zoomIn">
            <div class="features">
              <div class="header mb-3">
                <span class="mai-business"></span>
              </div>
              <h5>Marble works</h5>
              <p>We analyse your website's structure, internal architecture & other key</p>
            </div>
          </div>
        </div>

    </div> <!-- .container -->
  </div>

  <div class="page-section banner-info">
    <div class="wrap bg-image" style="background-image: url(../assets/img/bg_pattern.svg);">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 py-3 pr-lg-5 wow fadeInUp">
            <h2 class="title-section">DHS to connect you with the <br> workers</h2>
            <div class="divider"></div>
            <p>We have experienced workers and connect them easily for your needs.</p>
            
            <ul class="theme-list theme-list-light text-white">
              <li>
                <div class="h5">How DHS works?</div>
                <p>Both the customer and the service providers can register in our portal</p>
              
                <p>Customer can request for the specific service and the service provider can accept the work if he needs.</p>
              </li>
            </ul>
          </div>
          <div class="col-lg-6 py-3 wow fadeInRight">
            <div class="img-fluid text-center">
              <img src="assets/img/banner_image_2.svg" alt="">
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .wrap -->
  </div>

  <div class="page-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="card-service wow fadeInUp">
            <div class="header">
              <img src="assets/img/services/service-1.svg" alt="">
            </div>
            <div class="body">
              <h5 class="text-secondary">DHS Customer</h5>
              <p>We help you find the service providers you need</p>
              
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card-service wow fadeInUp">
            <div class="header">
              <img src="assets/img/services/service-2.svg" alt="">
            </div>
            <div class="body">
              <h5 class="text-secondary">DHS Service Provider</h5>
              <p>We help you to find the customers requiring your service</p>
             
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card-service wow fadeInUp">
            <div class="header">
              <img src="assets/img/services/service-3.svg" alt="">
            </div>
            <div class="body">
              <h5 class="text-secondary">Secure and Efficient</h5>
              <p>We help you to have a secure and efficient connections</p>
             
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .container -->
  </div>
    <!-- <footer>
        <div class="container-fluid padding">
            <div class="row text-center">
                <div class="col-md-6">
                    <hr class="light">
                    <p>8089373439</p>
                    <p>doorstep@gmail.com</p> 
                </div>
                <div class="col-md-6">
                    <hr class="light">
                    <h4>ADDRESS</h4>
                    <hr class="light">
                    <p>192/291</p>
                    <p>Thrikketaapuram, Sakakakakak</p>
                    <p>Kerala</p>
                </div>
                <div class="col-md-12">
                    <hr class="light">
                    <h5>&copy;doorstep.com</h5>
                </div>
            </div>

        </div>
    </footer>
     -->
     <footer class="page-footer bg-image" style="background-image: url(assets/img/world_pattern.svg);">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-4 py-4">
          <h3>DHS</h3>
          <p>Portal to connect the workers with the customers.</p>

          <div class="social-media-button">
            <a href="#"><span class="mai-logo-facebook-f"></span></a>
            <a href="#"><span class="mai-logo-twitter"></span></a>
            <a href="#"><span class="mai-logo-google-plus-g"></span></a>
            <a href="#"><span class="mai-logo-instagram"></span></a>
            <a href="#"><span class="mai-logo-youtube"></span></a>
          </div>
        </div>
        <div class="col-lg-4 py-4">
          <h5>Contact Us</h5>
          <p>22/A24 Skyline Towers,Palluruthy, Kochi</p>
          <p>Ernakulam, Kerala</p>
          <a href="#" class="footer-link">+91 8089 3734 39</a><br>
          <a href="#" class="footer-link">dhsofficial@gmail.com</a>
        </div>
        <div class="col-lg-4 py-4">
         
          <ul class="footer-menu">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Career</a></li>
            <li><a href="#">Advertise</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Help & Support</a></li>
          </ul>
        </div>
        
        
      </div>

      <p class="text-center" id="copyright">Copyright &copy; 2020.</p>
    </div>
  </footer>

<script src="assets/js/jquery-3.5.1.min.js"></script>

<script src="assets/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/google-maps.js"></script>

<script src="assets/vendor/wow/wow.min.js"></script>

<script src="../assets/js/theme.js"></script>
    <script src="javascript/logincheck.js" type="text/javascript"></script>
</body>

</html>

