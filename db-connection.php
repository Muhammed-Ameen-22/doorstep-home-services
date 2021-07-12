<?php
$servername = "localhost";
$username = "root";
$password = "";
$db="dhs";

$conn=mysqli_connect($servername,$username,$password,$db);


if(mysqli_connect_errno()){
    echo "Failed to connect to Mysql:" . mysqli_connect_error();
}
?>