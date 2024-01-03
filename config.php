<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_faunmunch";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn){
        die("Connection Failed:".mysqli_connect_error());
    }
    
date_default_timezone_set('Asia/Jakarta');   
?>