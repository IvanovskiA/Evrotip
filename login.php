<?php
require_once("db_conn.php");
include_once("included_functions.php");
if (!empty($_SESSION["iduser"])) {
  header("Location: index.php");
}
$errors_array = array();
$errors = "";
if (isset($_POST["submit"])) {
  $usernameemail = test_input($_POST["usernameemail"]);
  if ($usernameemail === "") {
    $error_array["Username or Email"] = "can't be blank";
  }
  $password = test_input($_POST["password"]);
  if ($password === "") {
    $error_array["password"] = "can't be blank";
  }
  if (!empty($error_array)) {
    errors($error_array);
  } else {
    $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$usernameemail' or email = '$usernameemail'");
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
      // $password = password_verify($password, $row["password"]);
      if ($password == $row["password"]) {
        $_SESSION["login"] = true;
        $_SESSION["iduser"] = $row["id"];
        header("Location: index.php");
      } else {
        echo "<script>alert('Wrong Password'); </script>";
      }
    } else {
      echo "<script> alert('User Not Registered'); </script>";
    }
  }
}
?>
<?php include_once("header.php"); ?>
<div class="container">
  <form action="" method="POST" autocomplete="off">
    <div class="row">
      <div class="input-group">
        <input type="text" name="usernameemail" id="usernameemail" required value="">
        <label for="usernameemail">&nbsp;&nbsp;Username or Email: </label>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="password" required value="">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
    </div>
    <div class="input-group">
      <button type="submit" name="submit">Login</button>
    </div>
    <div class="input-group">
      <a href="registration.php">Register</a>
    </div>
  </form>
  <div class="divWinnerImg">
    <div class="row">
      <?php echo $errors ?>
    </div>
    <div class="row" style="margin-top: -150px;">
      <img class="imgWinner" src="img/giphy.gif" alt="">
    </div>
  </div>
</div>
<?php include_once("footer.php") ?>