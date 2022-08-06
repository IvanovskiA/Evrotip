<?php
require_once("included_functions.php");
$errors = $usernameemail = $password = "";
function logIn()
{
  global $connection, $error_array, $usernameemail, $password;
  if (isset($_SESSION["iduser"])) {
    header("Location: write.php");
  }
  if (isset($_POST["submit"])) {
    $usernameemail = mysqli_real_escape_string($connection, test_input($_POST["username/Email"]));
    $password = mysqli_real_escape_string($connection, test_input($_POST["password"]));

    $required_fields = array("username/Email", "password");
    hasPresence_emailValidation($required_fields);

    if (empty($error_array)) {
      checkingLoginData();
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

function checkingLoginData()
{
  global $error_array, $usernameemail, $password, $connection;
  $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$usernameemail' or email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
    // $password = password_verify($password, $row["password"]);
    if ($password === $row["password"]) {
      $_SESSION["login"] = true;
      $_SESSION["iduser"] = $row["id"];
      $_SESSION["roleuser"] = $row["role"];
      header("Location: write.php");
    } else {
      return $error_array["Failed: "] = "Wrong password";
    }
  } else {
    return $error_array["Failed: "] = "User not registered";
  }
}
