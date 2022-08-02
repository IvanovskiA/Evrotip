<?php
require_once("db_conn.php");
if (!empty($_SESSION["iduser"])) {
  header("Location: index.php");
}
if (isset($_POST["submit"])) {
  $usernameemail = $_POST["usernameemail"];
  $password = $_POST["password"];
  $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$usernameemail' or email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
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
    <img class="imgWinner" src="img/giphy.gif" alt="">
  </div>
  <br>
</div>
<?php include_once("footer.php") ?>