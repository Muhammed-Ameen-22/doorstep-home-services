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
                where cust_username ='".$username."'";

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
                        echo '<script>alert("Wrong Username / Password");</script>';
                    }
                }
                else{
                    echo '<script>alert("Wrong Username");</script>';
                    exit();
                }
            }
        }
        else if($userType=="sp")
        {
            // Validate credentials
        if(empty($username_err) && empty($password_err)){
            
            $sql =  "SELECT * FROM sp_details where sp_username ='".$username."'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){  
                    $row = mysqli_fetch_array($result);
                    if(password_verify($password,$row['sp_password'])){        
                        session_start();
                          
                        $_SESSION["sp_id"] = $row['sp_id'];
                        $_SESSION["s_id"] = $row['s_id']; 
                        header("location: sp-dashboard.php");
                        exit();
                    }
                    else{
                        echo '<script>alert("Wrong Username / Password");</script>';
                    }
                }
                else{
                    echo '<script>alert("Wrong Username");</script>';
                    exit();
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
   
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">

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

    <div id="carouselExampleIndicators" class="carousel slide"  data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active" data-interval="2000">
                <img class="d-block w-100" src="images/background1.jpg" alt="First slide">
                <div class="carousel-caption">
                    <a href="" class="button-login btn btn-primary" data-toggle="modal" data-target="#modalLoginForm" >Login</a>
                </div>
            </div>
            <div class="carousel-item" data-interval="2000">
                <img class="d-block w-100" src="images/background4.png" alt="Second slide">
                <div class="carousel-caption">
                    <a href="" class="button-login btn btn-primary" data-toggle="modal" data-target="#modalLoginForm" >Login</a>
                </div>
            </div>
            <div class="carousel-item" data-interval="2000">
                <img class="d-block w-100" src="images/background2.png" alt="Third slide">
                <div class="carousel-caption">
                    <a href="" class="button-login btn btn-primary" data-toggle="modal" data-target="#modalLoginForm" >Login</a>
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
                    <input class="radio-cus form-check-input" type="radio" name="user"  value="cust" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                      Customer
                    </label>
                  </div><br>
            </div>
            <div class="sign-txt">
                <div class="form-check " style="text-align: left    ">
                    <input class="radio-sp form-check-input" type="radio" name="user" value="sp" id="flexRadioDefault2" >
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
          <div class="pass-txt"><a href="#">Forgot password?</a></div>
          <input type="submit" value="Login" name="login">
        </form>
        <div class="sign-txt">Not yet member? <a href="registration.html">Signup now</a></div>
      </div>



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
    <hr class="my-4" id="contact">
    <div class="container-fluid padding fadeInUp">
        <div class="row  text-center padding">
            <div class="col-12">
                <h2>Connect</h2>
            </div>
            <div class="col-12 social padding">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-google-plus-g"></i></a>
            </div>

        </div>
    </div>
    <footer>
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
    
    <script src="javascript/logincheck.js" type="text/javascript"></script>
</body>

</html>

