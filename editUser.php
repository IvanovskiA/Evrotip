<?php
require_once("db_conn.php");
include_once("included_functions.php");
if (!empty($_SESSION["iduser"])) {
  $userid = $_SESSION["iduser"];
  $result = mysqli_query($connection, "SELECT * FROM users WHERE id = $userid");
  $row = mysqli_fetch_assoc($result);
  $userRole = $row["role"];
  if ($userRole !== "Admin") {
    header("Location: index.php");
  }
} else {
  header("Location: login.php");
}
$id = $_GET['id'];
$error_array = array();
$errors = "";
if (isset($_POST["submit"])) {
  $name = test_input($_POST["name"]);
  if ($name === "") {
    $error_array["name"] = "can't be blank";
  }
  $username = test_input($_POST["username"]);
  if ($username === "") {
    $error_array["username"] = "can't be blank";
  }
  $email = test_input($_POST["email"]);
  if ($email === "") {
    $error_array["email"] = "can't be blank";
  } else {
    if (validationEmail($email) === false) {
      $error_array["email format"] = "wrong";
    }
  }
  $password = test_input($_POST["password"]);
  if ($password === "") {
    $error_array["password"] = "can't be blank";
  }
  $role = $_POST["role"];

  if (!empty($error_array)) {
    errors($error_array);
  } else {
    $name = mysqli_real_escape_string($connection, $name);
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email',`password`='$password',`role`='$role' WHERE id = $id";
    $result = mysqli_query($connection, $query);
    if ($result) {
      header("Location: indexAdmin.php?msg=User data update successfully ");
    } else {
      echo "Failed: " . mysqli_error($connection); // naprajgo so message porakata so ke ja prikazva pod formata vo bodyto
    }
  }
}

?>
<?php include_once("header.php") ?>
<?php
$id = $_GET['id'];
$query = "SELECT * FROM users WHERE  id = $id LIMIT 1";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
?>
<div class="container">
  <form action="" method="POST">
    <div class="row">
      <div class="input-group">
        <input type="text" name="name" id="name" required value="<?php echo $row['name'] ?>">
        <label for="name">&nbsp;&nbsp;Name: </label>
      </div>
      <div class="input-group">
        <input type="text" name="username" id="username" required value="<?php echo $row['username'] ?>">
        <label for="username">&nbsp;&nbsp;Username: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="password" name="password" id="password" value="<?php echo $row['password'] ?>">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
      <div class="input-group">
        <input type="text" name="email" id="email" required value="<?php echo $row['email'] ?>">
        <label for="email">&nbsp;&nbsp;Email: </label>
      </div>
    </div>
    <div class="row">
      <div class="roleRadio">
        <label for="">Role</label> <br>
        <input type="radio" name="role" id="read" value="Read" <?php echo ($row['role'] == 'Read') ? "checked" : ""; ?>>
        <label for="read">Read</label>
        <input type="radio" name="role" id="write" value="Write" <?php echo ($row['role'] == 'Write') ? "checked" : ""; ?>>
        <label for="write">Write</label>
        <input type="radio" name="role" id="admin" value="Admin" <?php echo ($row['role'] == 'Admin') ? "checked" : ""; ?>>
        <label for="admin">Admin</label>
        <input type="radio" name="role" id="read/write" value="Read/Write" <?php echo ($row['role'] == 'Read/Write') ? "checked" : ""; ?>>
        <label for="admin">Read/Write</label>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="input-group" style="margin-bottom: 0px;">
        <button type="submit" name="submit">Update</button>
      </div>
      <div class="adminCancel" style="width: 45%;">
        <a href="indexAdmin.php">Cancel</a>
      </div>
    </div>
    <br><br><br>
    <div class="row">
      <?php echo $errors; ?>
    </div>
  </form>
</div>
<?php include_once("footer.php") ?>