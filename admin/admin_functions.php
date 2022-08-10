<?php
require_once("../functions/included_functions.php");
$id = $_GET['id'];
$errors = "";
editUserFunction();
currentData();
// collecting data from edit user form
function editUserFunction()
{
  global $error_array, $connection, $name, $username, $email, $password, $role;
  if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $role = $_POST["role"];
    $required_fields = array("name", "username", "password", "email");
    hasPresence_emailValidation($required_fields);


    if (empty($error_array)) {
      updateUserData($connection, $name, $username, $password, $email, $role, $error_array);
      errors($error_array);
    } else {
      errors($error_array);
    }
  }
}

// update user data if error array is empty
function updateUserData($connection, $name, $username, $password, $email, $role, $error_array)
{
  global $id;
  try {
    $query = "UPDATE users SET `name`=:name, `username`=:username, `email`=:email, `password`=:password, `role`=:role WHERE id = $id LIMIT 1";
    $statement = $connection->prepare($query);
    $data = [
      ":name" => $name,
      ":username" => $username,
      ":password" => $password,
      ":email" => $email,
      ":password" => $password,
      ":role" => $role,
    ];
    $query_execute = $statement->execute($data);
    if ($query_execute) {
      header("Location: indexAdmin.php?msg=User data update successfully");
    }
  } catch (PDOException $e) {
    $errmsg = $e->getMessage();
    return $error_array["Failed: "] = "$errmsg";
  }
}

//current data in database
function currentData()
{
  global $connection, $id, $row;
  $query = "SELECT * FROM users WHERE  id = :id LIMIT 1";
  $statement = $connection->prepare($query);
  $data = [":id" => $id];
  $statement->execute($data);
  $row = $statement->fetch(PDO::FETCH_OBJ);
}

//delete user function
function deleteUser($connection)
{
  global $id;
  try {
    $query = "DELETE FROM users WHERE id = :id";
    $statement = $connection->prepare($query);
    $data = [
      ':id' => $id
    ];
    $query_execute = $statement->execute($data);
    if ($query_execute) {
      header("Location: indexAdmin.php?msg=User deleted successfylly");
    }
  } catch (PDOException $e) {
    $errmsg = $e->getMessage();
    return $error_array["Failed: "] = "$errmsg";
  }
}
