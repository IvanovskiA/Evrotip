<?php
require_once("db_conn.php");
if (isset($_SESSION["iduser"])) {
  $userid = $_SESSION["iduser"];
  $result = mysqli_query($connection, "SELECT * FROM users where id = $userid LIMIT 1");
  $row = mysqli_fetch_assoc($result);
  $userRole = $row["role"];
}
$pagetitle = $_SERVER["PHP_SELF"];
switch ($pagetitle) {
  case "/xml/indexAdmin.php":
    $title = "Evrotip Users";
    break;
  case "/xml/editUser.php":
    $title = "Evrotip Users";
    break;
  default:
    $title = "Evrotip Dobitnici";
    break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
  <script src="https://kit.fontawesome.com/9e05866ef3.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <button onclick="topFunction()" id="myBtn" title="Go to top"><img src="img/arrow-up.png" width="30px" height="30px" alt=""></button>
  <nav>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
      <i class="fa-solid fa-bars"></i>
    </label>
    <label class="logo"><a href="index.php"><img src="img/logo.png" alt=""></a></label>
    <ul>
      <li><a class="navTime"><?php if (!isset($userid)) {
                                echo date("Y/m/d H:i - l");
                              } ?></a></li>
      <li><a href="index.php"><?php if (isset($userid)) {
                                echo "Zapisuvaj";
                              } ?></a></li>
      <li><a href="read.php"><?php if (isset($userid)) {
                                echo "Citaj";
                              } ?></a></li>
      <li><a href="logout.php"><?php if (isset($userid)) {
                                  echo "Odjava";
                                } ?></a></li>
      <li><a href="indexAdmin.php"><?php if (isset($userid) && $userRole === "Admin") {
                                      echo "Admin";
                                    } ?></a></li>
    </ul>
  </nav>