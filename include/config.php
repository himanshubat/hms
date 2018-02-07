<?php
/*************************
 * Author : Mukesh Kumar
 * Date : 15.12.2017
**************************/
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'vibhor85_babs15';
// Create connection
$conn = mysqli_connect($host, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>
