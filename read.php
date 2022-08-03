<?php
require_once("db_conn.php");
if (!empty($_SESSION["iduser"])) {
  $userid = $_SESSION["iduser"];
  $result = mysqli_query($connection, "SELECT * FROM users WHERE id = $userid");
  $row = mysqli_fetch_assoc($result);
  $userRole = $row["role"];
  if ($userRole === "Write") {
    header("Location: index.php");
  }
} else {
  header("Location: login.php");
}
$message = "";
$table = "";
$query = "SELECT slotpersons.ReferenceNo, slotpersons.PersonObjectId, slotpersons.IsResident, slotpersons.FirstName, slotpersons.LastName, slotpersons.AddressLine1,
slotpersons.City, slotpersons.ISOType, country_iso.country, slotpersons.TransactionDate
FROM slotpersons 
INNER JOIN country_iso ON slotpersons.ISOCode = country_iso.iso_code";

if (isset($_POST['submit'])) {
  $startDate = $_POST['txtStartDate'];
  $endDate = $_POST['txtEndDate'];

  if (($startDate !== "" && $endDate !== "")) {
    $query .= " WHERE TransactionDate BETWEEN '$startDate' and '$endDate'";
    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);
    if ($count == "0") {
      $message = "Ne e pronajden nieden dobitnik!";
    }
  } else {
    $message = "Popolnete gi dvete (datum) polinja za prikaz na barani dobitnici!";
  }
}
$result = mysqli_query($connection, $query);
$table .= '
<table class="content-table display responsive nowrap" border="1px">
  <thead>
    <tr class="active">
      <th>#</th>
      <th>Reference No</th>
      <th>Person Object Id</th>
      <th>Is Resident</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Address Line 1</th>
      <th>City</th>
      <th>ISO Type</th>
      <th>Country</th>
      <th>Transaction Date</th>
    </tr>
  </thead>
  <tbody>';
$brojac = 1;
while ($row = mysqli_fetch_assoc($result)) {
  $referenceNo = $row['ReferenceNo'];
  $personObjectId = $row['PersonObjectId'];
  $isResident = $row['IsResident'];
  $firstName = $row['FirstName'];
  $lastName = $row['LastName'];
  $addressLine1 = $row['AddressLine1'];
  $city = $row['City'];
  $isoType = $row['ISOType'];
  $country = $row['country'];
  $transactionDate = $row['TransactionDate'];
  $table .= '
  <tr>
    <td>' .  $brojac . '</td>
    <td>' .  $referenceNo . '</td>
    <td>' .  $personObjectId . '</td>
    <td>' .  $isResident . '</td>
    <td>' .  $firstName . '</td>
    <td>' .  $lastName . '</td>
    <td>' .  $addressLine1 . '</td>
    <td>' .  $city . '</td>
    <td>' .  $isoType . '</td>
    <td>' .  $country . '</td>
    <td>' .  $transactionDate . '</td>
  </tr>';
  $brojac += 1;
}
$table .= '</tbody>
</table>';
?>
<?php include_once("header.php") ?>
<div class="container">
  <form action="" method="POST">
    <div class="row">
      <div class="input-group">
        <input type="date" name="txtStartDate" id="od" value="<?php if (isset($startDate)) {
                                                                echo $startDate;
                                                              } ?>">
        <label for="od">Odberete od:</label>
      </div>
      <div class="input-group">
        <input type="date" name="txtEndDate" id="do" value="<?php if (isset($endDate)) {
                                                              echo $endDate;
                                                            } ?>">
        <label for="do">Odberete do:</label>
      </div>
    </div>
    <div class="input-group">
      <button type="submit" name="submit" value="submit">Submit</button>
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
<?php include_once("footer.php") ?>