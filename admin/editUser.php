<?php
require_once("../db_conn.php");
include_once("userUpdate_functions.php");
blockRutes();
$id = $_GET['id'];
editUserFunction();

?>
<?php include_once("../components/header.php") ?>
<?php
currentData();
?>
<div class="container">
  <form action="" method="POST">
    <div class="row">
      <div class="input-group">
        <input type="text" name="name" id="name" value="<?php echo $row['name'] ?>">
        <label for="name">&nbsp;&nbsp;Name: </label>
      </div>
      <div class="input-group">
        <input type="text" name="username" id="username" value="<?php echo $row['username'] ?>">
        <label for="username">&nbsp;&nbsp;Username: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="text" name="password" id="password" value="<?php echo $row['password'] ?>">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
      <div class="input-group">
        <input type="text" name="email" id="email" value="<?php echo $row['email'] ?>">
        <label for="email">&nbsp;&nbsp;Email: </label>
      </div>
    </div>
    <div class="row">
      <div class="roleRadio">
        <label for="">Role</label> <br>
        <input type="radio" name="role" id="read" value="read" <?php echo ($row['role'] == 'Read') ? "checked" : ""; ?>>
        <label for="read">Read</label>
        <input type="radio" name="role" id="write" value="write" <?php echo ($row['role'] == 'Write') ? "checked" : ""; ?>>
        <label for="write">Write</label>
        <input type="radio" name="role" id="admin" value="admin" <?php echo ($row['role'] == 'Admin') ? "checked" : ""; ?>>
        <label for="admin">Admin</label>
        <input type="radio" name="role" id="read/write" value="read/write" <?php echo ($row['role'] == 'Read/Write') ? "checked" : ""; ?>>
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
<?php include_once("../components/footer.php") ?>