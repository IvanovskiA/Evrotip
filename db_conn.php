<?php
session_start();
$connection = mysqli_connect('localhost', 'root', 'ivanovski', 'slotufr');
if (mysqli_connect_errno()) {
  die("Mysql connecton failed: ") .
    mysqli_connect_error() .
    " (" . mysqli_connect_errno() . ")";
}
