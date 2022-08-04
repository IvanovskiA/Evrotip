<?php
require_once("db_conn.php");
include_once("included_functions.php");
if (!empty($_SESSION["iduser"])) {
  header("Location: index.php");
}
$errors = "";
$error_array = array();
if (isset($_POST["submit"])) {
  $name = test_input($_POST["name"]);
  $username = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $confirmpassword = test_input($_POST["confirmpassword"]);

  $required_fields = array("name", "username", "email", "password", "confirmpassword");

  function hasPresence_emailValidation($array)
  {
    global $error_array;
    foreach ($array as $key) {
      $value = test_input($_POST[$key]);
      if (!has_presence($value)) {
        $error_array[$key] = "can't be blank";
      }
      if ($key === "email") {
        if (!validationEmail($value)) {
          if (!array_key_exists($key, $error_array)) {
            $error_array[$key] = "wrong format";
          }
        }
      } else {
        continue;
      }
    }
  }
  hasPresence_emailValidation($required_fields);

  if (empty($error_array)) {
    $duplicate = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($duplicate) > 0) {
      $error_array["registration:"] = "failed - username or email already taken";
    } else {
      if ($password == $confirmpassword) {
        $name = mysqli_real_escape_string($connection, $name);
        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
        // $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name,username,email,password)
								VALUES('$name','$username','$email','$password')";
        mysqli_query($connection, $query);
        $error_array["registration:"] = "successful - <a href='login.php' style='color:white'>Login</a>";
      } else {
        echo
        $error_array["registration"] = "failed - passwords does not match";
      }
    }
    errors($error_array);
  } else {
    errors($error_array);
  }
}
?>
<?php include_once("components/header.php") ?>
<div class="container">
  <form action="" method="POST" autocomplete="off">
    <div class="fieldsMessage">
      <p><i>All fields are required</i></p>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="text" name="name" id="name" value="">
        <label for="name">&nbsp;&nbsp;Name: </label>
      </div>
      <div class="input-group">
        <input type="text" name="username" id="username" value="">
        <label for="username">&nbsp;&nbsp;Username: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="password" name="password" id="password" value="">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
      <div class="input-group">
        <input type="password" name="confirmpassword" id="confirmpassword" value="">
        <label for="confirmpassword">&nbsp;&nbsp;Confirm Password: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="text" name="email" id="email" value="">
        <label for="email">&nbsp;&nbsp;Email: </label>
      </div>
      <div class="input-group"><button type="submit" name="submit">Registration</button></div>
    </div>
    <div class="input-group">
      <!-- <a href="login.php">Login</a> -->
    </div>
    <div class="row">
      <?php echo $errors; ?>
    </div>
  </form>
  <br>
  <div class="divWinnerImg">
    <div class="row" style="margin-top: -150px;">
      <img class="imgWinner" src="img/giphy.gif" alt="">
    </div>
  </div>
</div>
<?php include_once("components/footer.php") ?>