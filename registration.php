<?php
require_once("db_conn.php");
include_once("functions/reg_functions.php");
if (!empty($_SESSION["iduser"])) {
  header("Location: index.php");
}
registration();
?>
<?php include_once("components/header.php") ?>
<div class="container">
  <form action="" method="POST" autocomplete="off">
    <div class="fieldsMessage">
      <p><i>All fields are required</i></p>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="text" name="name" id="name" value="<?= $name ?>">
        <label for="name">&nbsp;&nbsp;Name: </label>
      </div>
      <div class="input-group">
        <input type="text" name="username" id="username" value="<?= $username ?>">
        <label for="username">&nbsp;&nbsp;Username: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="password" name="password" id="password" value="<?= $password ?>">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
      <div class="input-group">
        <input type="password" name="confirmpassword" id="confirmpassword" value="<?= $confirmpassword ?>">
        <label for="confirmpassword">&nbsp;&nbsp;Confirm Password: </label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="text" name="email" id="email" value="<?= $email ?>">
        <label for="email">&nbsp;&nbsp;Email: </label>
      </div>
      <div class="input-group"><button type="submit" name="submit">Registration</button></div>
    </div>
    <div class="input-group">
      <a href="login.php">Login</a>
    </div>
    <div class="row">
      <?php echo $errors; ?>
    </div>
  </form>
  <br>
  <div class="divWinnerImg">
    <div class="row" style="margin-top: -150px;">
      <img class="imgWinner" src="img/giphy.gif" alt="">
    </div>
  </div>
</div>
<?php include_once("components/footer.php") ?>