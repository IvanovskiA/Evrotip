<?php
require_once("db_conn.php");
if (!empty($_SESSION["iduser"])) {
  header("Location: index.php");
}
if (isset($_POST["submit"])) {
  $name = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $duplicate = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
  if (mysqli_num_rows($duplicate) > 0) {
    echo
    "<script> alert('Username or Email Has Already Taken'); </script>";
  } else {
    if ($password == $confirmpassword) {
      $query = "INSERT INTO users (name,username,email,password)
								VALUES('$name','$username','$email','$password')";
      mysqli_query($connection, $query);
      echo
      "<script>alert('Registration Successful');</script>";
    } else {
      echo
      "<script>alert('Passwords Does Not Match');</script>";
    }
  }
}

?>
<?php include_once("header.php") ?>
<div class="container">
  <form action="" method="POST">
    <div class="row">
      <div class="input-group">
        <input type="text" name="name" id="name" required value="">
        <label for="name">&nbsp;&nbsp;Name: </label>
      </div>
      <div class="input-group">
        <input type="text" name="username" id="username" required value="">
        <label for="username">&nbsp;&nbsp;Username: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="password" name="password" id="password" required value="">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
      <div class="input-group">
        <input type="password" name="confirmpassword" id="confirmpassword" required value="">
        <label for="confirmpassword">&nbsp;&nbsp;Confirm Password: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="text" name="email" id="email" required value="">
        <label for="email">&nbsp;&nbsp;Email: </label>
      </div>
      <div class="input-group"><button type="submit" name="submit">Registration</button></div>
    </div>
    <div class="input-group">
      <a href="login.php">Login</a>
    </div>
  </form>
  <br>
  <div class="divWinnerImg">
    <img class="imgWinner" src="img/giphy.gif" alt="">
  </div>
</div>
<?php include_once("footer.php") ?>