<?php
session_start();

define("DBHost", "localhost");
define("DBUser", "root");
define("DBUserPassword", "ivanovski");
define("DBname", "slotufr");

$connection = mysqli_connect(DBHost, DBUser, DBUserPassword, DBname);

if (mysqli_connect_errno()) {
  die("Mysql connecton failed: ") .
    mysqli_connect_error() .
    " (" . mysqli_connect_errno() . ")";
} else {
  // echo "Database connection successfully";
}
