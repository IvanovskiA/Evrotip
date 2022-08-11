<?php
require_once("functions/write_functions.php");
include_once("components/header.php");
?>
<div class="container">
  <div class="form">
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="input-group">
          <select name="godina" value="">
            <option value="<?php echo date("Y") ?>"><?php echo date("Y") ?></option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
          </select>
          <label for="godina">Godina</label>
        </div>
        <div class="input-group">
          <select name="mesec" value="">
            <option value="<?php echo date("F") ?>"><?php echo date("F") ?></option>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">September</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
          </select>
          <label for="mesec">Odeberete mesec</label>
        </div>
      </div>
      <div class="input-group">
        <input type="file" name="file[]" id="file" multiple="multiple" />
      </div>
      <div class="row">
        <div class="roleRadio">
          <label for="">Choose format</label> <br>
          <input type="radio" name="format" id="xml" value="xml" required>
          <label for="read">XML</label>
          <input type="radio" name="format" id="json" value="json">
          <label for="json">JSON</label>
        </div>
      </div> <br>
      <button type="submit" name="submit" value="submit">Submit</button>
    </form>
  </div>
  <div style="text-align: center; margin-top: 200px">
    <?php echo "<h1 style='color: white'>" . $message . "</h1>" ?>
  </div>
</div>
<?php include_once("components/footer.php") ?>