<?php
require_once("../functions/included_functions.php");
require_once("../components/header.php");
?>
<div class="container">
  <div class="searchresult">
    <?php include("../message.php"); ?>
    <table class="content-table" id="usersTable" style="width:100%;" border="1px">
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
        $statement = $connection->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
        ?>
          <tr>
            <td><?= $row->id  ?></td>
            <td><?= $row->name  ?></td>
            <td><?= $row->username  ?></td>
            <td><?= $row->email  ?></td>
            <td><?= $row->password ?></td>
            <td><?= $row->role ?></td>
            <td>
              <a href="editUser.php?id=<?= $row->id ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="deleteUser.php?id=<?= $row->id ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php include_once("../components/footer.php") ?>