<?php
$errors = $usernameemail = $password = "";
require_once("included_functions.php");
logIn();
// login function
function logIn()
{
  if (isset($_SESSION["iduser"])) {
    header("Location: write.php");
  }
  global $connection, $error_array, $usernameemail, $password;
  if (isset($_POST["submit"])) {
    unset($_GET['msg']);
    $usernameemail = protection($connection, $_POST["username/Email"]);
    $password = protection($connection, $_POST["password"]);
    $required_fields = array("username/Email", "password");
    hasPresence_emailValidation($required_fields);

    if (empty($error_array)) {
      checkingLoginData($usernameemail, $password, $connection);
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

// function for checking data inserted in login form
function checkingLoginData($usernameemail, $password, $connection)
{
  global $error_array;
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
      $error_array["Failed: "] = "Wrong password";
    }
  } else {
    $error_array["Failed: "] = "User not registered";
  }
}
