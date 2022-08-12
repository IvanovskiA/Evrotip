<?php
session_start();

if ((($_SERVER['PHP_SELF'] === "/xml/admin/indexAdmin.php") ||
  ($_SERVER['PHP_SELF'] === "/xml/admin/editUser.php") ||
  ($_SERVER['PHP_SELF'] === "/xml/admin/deleteUser.php")
)) {
  require_once("../includes/settings.php");
} else {
  require_once("includes/settings.php");
}

$connection = mysqli_connect($DBHost, $DBUser, $DBUserPassword, $DBname);

if (mysqli_connect_errno()) {
  die("Mysql connecton failed: ") .
    mysqli_connect_error() .
    " (" . mysqli_connect_errno() . ")";
} else {
  // echo "Database connection successfully";
}
