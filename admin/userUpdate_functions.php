<?php
require_once("../functions/included_functions.php");

function editUserFunction()
{
  global $error_array, $connection, $name, $username, $email, $password, $role;
  if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($connection, test_input($_POST["name"]));
    $username = mysqli_real_escape_string($connection, test_input($_POST["username"]));
    $email = mysqli_real_escape_string($connection, test_input($_POST["email"]));
    $password = mysqli_real_escape_string($connection, test_input($_POST["password"]));
    $role = $_POST["role"];

    $required_fields = array("name", "username", "password", "email");
    hasPresence_emailValidation($required_fields);


    if (empty($error_array)) {
      checkingUserUpdateData();
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

function checkingUserUpdateData()
{
  global $connection, $name, $username, $password, $email, $role, $id, $error_array;
  $query = "UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email',`password`='$password',`role`='$role' WHERE id = $id";
  $result = mysqli_query($connection, $query);
  if ($result) {
    header("Location: indexAdmin.php?msg=User data update successfully ");
  } else {
    $errmsg = mysqli_error($connection);
    return $error_array['Failed: '] = "$errmsg";
  }
}

function currentData()
{
  global $connection, $id;
  $query = "SELECT * FROM users WHERE  id = $id LIMIT 1";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
}
