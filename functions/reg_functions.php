<?php
require_once("included_functions.php");
$errors = $name = $username = $email = $password = $confirmpassword = "";
registration();
// Registration functions
function registration()
{
  if (isset($_SESSION["iduser"])) {
    header("Location: write.php");
  }
  global $error_array, $connection, $name, $username, $email, $password, $confirmpassword;
  if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmpassword = trim($_POST["confirmpassword"]);

    $required_fields = array("name", "username", "email", "password", "confirmpassword");
    hasPresence_emailValidation($required_fields);

    if (empty($error_array)) {
      checkingRegistrationData($connection, $name, $username, $email, $password, $confirmpassword);
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

function checkingRegistrationData($connection, $name, $username, $email, $password, $confirmpassword)
{
  global $error_array;
  $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
  $statement = $connection->prepare($query);
  $statement->execute();
  if ($statement->rowCount() > 0) {
    $error_array["registration:"] = "failed - username or email already taken";
  } else {
    if ($password == $confirmpassword) {
      // $password = password_hash($password, PASSWORD_BCRYPT);
      $query = "INSERT INTO users (name,username,email,password)
              VALUES(:name,:username,:email,:password)";

      $query_run = $connection->prepare($query);
      $data = [
        ':name' => $name,
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
      ];
      $query_execute = $query_run->execute($data);
      if ($query_execute) {
        header("Location: login.php?msg=Registration successuly - now login");
        $error_array["registration:"] = "successful - <a href='login.php' style='color:white'>Login</a>";
      } else {
        $error_array["registration"] = "failed";
      }
    } else {
      $error_array["registration"] = "failed - passwords does not match";
    }
  }
}
