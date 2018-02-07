<?php
/*************************
 * Author : Mukesh Kumar
 * Date : 15.12.2017
 ************************/
require_once '../include/config.php';
// include('config.php');
unset($_SESSION['Auth']);
session_destroy();
unset($_COOKIE);
header('location: index.php');
?>