<?php
session_start();
// require_once("../includes/settings.php");

$DBHost = "localhost";
$DBUser = "root";
$DBUserPassword = "ivanovski";
$DBname = "slotufr";


$connection = mysqli_connect($DBHost, $DBUser, $DBUserPassword, $DBname);

if (mysqli_connect_errno()) {
  die("Mysql connecton failed: ") .
    mysqli_connect_error() .
    " (" . mysqli_connect_errno() . ")";
} else {
  // echo "Database connection successfully";
}
