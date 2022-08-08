<?php
require_once("db_conn.php");
require_once("functions/login_functions.php");
include_once("components/header.php");
?>
<div class="container">
  <form action="" method="POST" autocomplete="off">
    <?php include("message.php"); ?>
    <div class="row">
      <div class="input-group">
        <input type="text" name="username/Email" id="username/Email" value="<?= $usernameemail ?>">
        <label for="username/Email">&nbsp;&nbsp;Username or Email: </label>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="password" value="<?= $password ?>">
        <label for="password">&nbsp;&nbsp;Password: </label>
      </div>
    </div>
    <div class="input-group">
      <button type="submit" name="submit">Login</button>
    </div>
    <div class="input-group">
      <a href="registration.php">Register</a>
    </div>
    <div class="row">
      <?= $errors ?>
    </div>
  </form>
  <div class="divWinnerImg">
    <div class="row" style="margin-top: -150px;">
      <img class="imgWinner" src="img/giphy.gif" alt="">
    </div>
  </div>
</div>
<?php include_once("components/footer.php") ?>