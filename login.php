<!-- <?php
require_once "db-connection.php";
echo $_SERVER["REQUEST_METHOD"];
$userType=$_POST["user"];
echo $userType."this is user";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "Entered";
 
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
        echo "Entered1";
        $sql = "SELECT * FROM cust_details where cust_username ='".$username."' AND cust_pass='".$password."'";
        if(mysqli_query($conn, $sql)){
        //    echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
        $result=mysqli_query($conn,$sql);
        if($result){

            while($row = mysqli_fetch_array($result))
            {
              echo "\nEmail".$row['cust_username']."\tPass: ".$row['cust_pass'];
            }
          }
        if(mysqli_num_rows($result)==1){
                  
        //header("location: index.php");
            echo"You have sucessfully logged in";
            header("location: cust-dashboard.php");
            exit();
        }
        else{
        echo"You entered incorrect password";
        exit();
        }
    }
    }

    else if($userType =="sp")
    {
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            echo "Entered1";
            $sql = "SELECT * FROM sp_details where sp_username ='".$username."' AND sp_password='".$password."'";
            if(mysqli_query($conn, $sql)){
            //    echo "Records inserted successfully.";
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
            $result=mysqli_query($conn,$sql);
            if($result){
    
                while($row = mysqli_fetch_array($result))
                {
                  echo "\nEmail".$row['sp_username']."\tPass: ".$row['sp_password '];
                }
              }
            if(mysqli_num_rows($result)==1){
                      
            //header("location: index.php");
                echo"You have sucessfully logged in";
                header("location: sp-dashboard.php");
                exit();
            }
            else{
            echo"You entered incorrect password";
            exit();
            }
        }
    }
        
    }
    
    // Close connection
    mysqli_close($conn);
?> -->