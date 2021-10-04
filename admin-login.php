<?php 
require_once "db-connection.php";
if(isset($_POST["login"])) {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql =  "SELECT * FROM admin_details where admin_username ='".$username."' and admin_password='".$password."'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){  
                    $row = mysqli_fetch_array($result);
                            
                        
                        header("location: admin-dashboard.html");
                        exit();
                }   
                    else{
                        echo '<script>alert("Wrong Username / Password");location.href = "admin-login.php";</script>';
                    }
}
?>
<html>
    <head>
        <title>ADMIN-LOGIN</title>
        <link href="stylesheets/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="stylesheets/admin-login.css">
       
    </head>
    <body>
        
    
    <form action="#" method ="POST" class="login-form">
  <h1>Login</h1>
  <div class="form-input-material">
    <input type="text" name="username" id="username" placeholder=" " autocomplete="off" required class="form-control-material" />
    <label for="username">Username</label>
  </div>
  <div class="form-input-material">
    <input type="password" name="password" id="password" placeholder=" " autocomplete="off" required class="form-control-material" />
    <label for="password">Password</label>
  </div>
  <button type="submit" value="login" name="login" class="btn btn-ghost">Login</button>
</form>
        </body>
    </html>



