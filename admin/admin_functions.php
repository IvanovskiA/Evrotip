<?php
require_once("../functions/included_functions.php");
$id = $_GET['id'];
$errors = "";
editUserFunction($connection, $id);
currentData($connection, $id);
// collecting data from edit user form
function editUserFunction($connection, $id)
{
  global $error_array, $name, $username, $email, $password, $role;
  if (isset($_POST["submit"])) {
    $name = protection($connection, $_POST["name"]);
    $username = protection($connection, $_POST["username"]);
    $email = protection($connection, $_POST["email"]);
    $password = protection($connection, $_POST["password"]);
    $role = $_POST["role"];
    $required_fields = array("name", "username", "password", "email");
    hasPresence_emailValidation($required_fields);


    if (empty($error_array)) {
      updateUserData($connection, $name, $username, $password, $email, $role, $error_array, $id);
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

// update user data if error array is empty
function updateUserData($connection, $name, $username, $password, $email, $role, $error_array, $id)
{
  $query = "UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email',`password`='$password',`role`='$role' WHERE id = $id";
  $result = mysqli_query($connection, $query);
  if ($result) {
    header("Location: indexAdmin.php?msg=User data update successfully");
  } else {
    $errmsg = mysqli_error($connection);
    return $error_array['Failed: '] = "$errmsg";
  }
}

//current data in database
function currentData($connection, $id)
{
  global $row;
  $query = "SELECT * FROM users WHERE  id = $id LIMIT 1";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
}

//delete user function
function deleteUser($connection, $id)
{
  $query = "DELETE FROM users WHERE id = $id";
  $result = mysqli_query($connection, $query);
  if ($result) {
    header("Location: indexAdmin.php?msg=User deleted successfylly");
  } else {
    echo "Failed: " . mysqli_error($connection);
  }
}
