<?php
require_once("included_functions.php");
$errors = $name = $username = $email = $password = $confirmpassword = "";
registration($connection);

// Registration functions
function registration($connection)
{
  global $error_array, $name, $username, $email, $password, $confirmpassword;
  if (isset($_POST["submit"])) {
    $name = protection($connection, $_POST["name"]);
    $username = protection($connection, $_POST["username"]);
    $email = protection($connection, $_POST["email"]);
    $password = protection($connection, $_POST["password"]);
    $confirmpassword = protection($connection, $_POST["confirmpassword"]);

    $required_fields = array("name", "username", "email", "password", "confirmpassword");
    hasPresence_emailValidation($required_fields);

    if (empty($error_array)) {
      checkingUsernameEmailTaken($connection, $name, $username, $email, $password, $confirmpassword);
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

// Function checking if username or email already taken
function checkingUsernameEmailTaken($connection, $name, $username, $email, $password, $confirmpassword)
{
  global $error_array;
  $duplicate = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
  if (mysqli_num_rows($duplicate) > 0) {
    $error_array["registration:"] = "failed - username or email already taken";
  } else {
    insertUserInDb($password, $confirmpassword, $name, $username, $email, $connection);
  }
}

// Insert data in DataBase function
function insertUserInDb($password, $confirmpassword, $name, $username, $email, $connection)
{
  global $error_array;
  if ($password == $confirmpassword) {
    // $password = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (name,username,email,password)
          VALUES('$name','$username','$email','$password')";
    mysqli_query($connection, $query);
    header("Location: login.php?msg=Registration successuly - now login");
    $error_array["registration:"] = "successful - <a href='login.php' style='color:white'>Login</a>";
  } else {
    $error_array["registration"] = "failed - passwords does not match";
  }
}
