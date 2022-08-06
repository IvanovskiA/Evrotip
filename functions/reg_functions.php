<?php
require_once("included_functions.php");
$errors = $name = $username = $email = $password = $confirmpassword = "";
// Registration functions
function registration()
{
  if (isset($_SESSION["iduser"])) {
    header("Location: write.php");
  }
  global $error_array, $connection, $name, $username, $email, $password, $confirmpassword;
  if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($connection, test_input($_POST["name"]));
    $username = mysqli_real_escape_string($connection, test_input($_POST["username"]));
    $email = mysqli_real_escape_string($connection, test_input($_POST["email"]));
    $password = mysqli_real_escape_string($connection, test_input($_POST["password"]));
    $confirmpassword = mysqli_real_escape_string($connection, test_input($_POST["confirmpassword"]));

    $required_fields = array("name", "username", "email", "password", "confirmpassword");

    hasPresence_emailValidation($required_fields);

    if (empty($error_array)) {
      checkingRegistrationData();
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}
function checkingRegistrationData()
{
  global $connection, $name, $username, $email, $password, $confirmpassword, $error_array;
  $duplicate = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
  if (mysqli_num_rows($duplicate) > 0) {
    return $error_array["registration:"] = "failed - username or email already taken";
  } else {
    if ($password == $confirmpassword) {
      // $password = password_hash($password, PASSWORD_BCRYPT);
      $query = "INSERT INTO users (name,username,email,password)
              VALUES('$name','$username','$email','$password')";
      mysqli_query($connection, $query);
      return $error_array["registration:"] = "successful - <a href='login.php' style='color:white'>Login</a>";
    } else {
      return $error_array["registration"] = "failed - passwords does not match";
    }
  }
}
