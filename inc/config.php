<?php 

$host = "localhost";
$username = "root";
$password = "";
$dbName = "traveleasy";


$connect = mysqli_connect($host, $username, $password, $dbName);

if(!$connect){
    die("connection failed");
}

?>