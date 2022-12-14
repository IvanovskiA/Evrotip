<?php require_once("functions/included_functions.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="description" content="Applications which give us winners and users of this application">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <link rel="shortcut icon" href="#">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo $path . "assets/css/style.css"; ?>">
</head>

<body>
  <button onclick="topFunction()" id="myBtn" title="Go to top"><img src=" <?php echo $path . "assets/img/arrow-up.png" ?>" width="30px" height="30px" alt="arrowUpImg"></button>
  <nav>
    <label class="logo"><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><img src="<?php echo $path . "assets/img/logo.png" ?>" alt="Evrotip logo"></a></label>
    <div class="navbarLinks">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fa-solid fa-bars"></i>
      </label>
      <ul>
        <li><a class="navTime" href="<?php echo $_SERVER['PHP_SELF']; ?>"><?php if (!isset($userRole)) {
                                                                            echo date("Y/m/d H:i - l");
                                                                          } ?></a></li>
        <li><a class="navLink" href="<?php echo $path . "write.php" ?>"><?php if (isset($userRole)) {
                                                                          echo "Zapisuvaj";
                                                                        } ?></a></li>
        <li><a class="navLink" href="<?php echo $path . "read.php" ?>"><?php if (isset($userRole)) {
                                                                          echo "Citaj";
                                                                        } ?></a></li>
        <li><a class="navLink" href="<?php echo $path . "logout.php" ?>"><?php if (isset($userRole)) {
                                                                            echo "Odjava";
                                                                          } ?></a></li>
        <li><a class="navLink" href="<?php echo $path . "admin/indexAdmin.php" ?>"><?php if (isset($userRole) && $userRole === "admin") {
                                                                                      echo "admin";
                                                                                    } ?></a></li>
      </ul>
    </div>
  </nav>