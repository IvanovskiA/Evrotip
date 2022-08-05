<?php
require_once("../db_conn.php");
if (!empty($_SESSION["iduser"])) {
  $userid = $_SESSION["iduser"];
  $result = mysqli_query($connection, "SELECT * FROM users WHERE id = $userid");
  $row = mysqli_fetch_assoc($result);
  $userRole = $row["role"];
  if ($userRole !== "Admin") {
    header("Location: ../index.php");
  }
} else {
  header("Location: ../login.php");
}
?>
<?php include_once("../components/header.php") ?>
<div class="container">
  <div class="searchresult" style="padding-top: 50px;">
    <?php include("../message.php"); ?>
    <table class="content-table" border="1px">
      <thead>
        <tr class="active">
          <th>ID</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Password</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['username'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['password'] ?></td>
            <td><?php echo $row['role'] ?></td>
            <td>
              <a href="editUser.php?id=<?php echo $row['id'] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="deleteUser.php?id=<?php echo $row['id'] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php include_once("../components/footer.php") ?>