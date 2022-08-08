<?php
require_once("db_conn.php");
require_once("functions/read_functions.php");
include_once("components/header.php")
?>
<div class="container">
  <form action="" method="POST">
    <div class="fieldsMessage">
      <p><i> (mm/dd/yyyy)</i></p>
    </div>
    <div class="row">
      <div class="input-group">
        <input type="date" name="txtStartDate" id="od" value="<?php echo $startDate; ?>">
        <label for="od">Odberete od:</label>
      </div>
      <div class="input-group">
        <input type="date" name="txtEndDate" id="do" value="<?php echo $endDate; ?>">
        <label for="do">Odberete do:</label>
      </div>
    </div>
    <div class="row">
      <div class="input-group">
        <button type="submit" name="submit" value="submit">Submit</button>
      </div>
      <div class="input-group">
        <a href="read.php"><button>All winners</button></a>
      </div>
    </div>
  </form>
  <div class="searchresult">
    <?php if ($message === "") {
      echo $table;
    } else {
      echo "<h1>" . $message . "</h1>";
    } ?>
  </div>
</div>
<?php include_once("components/footer.php") ?>