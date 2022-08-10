<?php
require_once("included_functions.php");
defaultValues();
searchingWinners();
printingTable();
// function for modify query
function searchByDate($startDate, $endDate)
{
  global $connection, $query, $message;
  if (($startDate !== "" && $endDate !== "")) {
    $query .= " WHERE TransactionDate BETWEEN '$startDate' and '$endDate'";
    $statement = $connection->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    if ($count == "0") {
      $message = "Ne e pronajden nieden dobitnik!";
    }
  } else {
    $message = "Popolnete gi dvete (datum) polinja za prikaz na barani dobitnici!";
  }
}
// print table function
function printingTable()
{
  global $connection, $query, $table;
  $statement = $connection->prepare($query);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $result = $statement->fetchAll();
  $table = '
<table  class="content-table" style="width:100%" border="1px">
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
  foreach ($result as $row) {
    $referenceNo = $row->ReferenceNo;
    $personObjectId = $row->PersonObjectId;
    $isResident = $row->IsResident;
    $firstName = $row->FirstName;
    $lastName = $row->LastName;
    $addressLine1 = $row->AddressLine1;
    $city = $row->City;
    $isoType = $row->ISOType;
    $country = $row->country;
    $transactionDate = $row->TransactionDate;
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
  return $table;
}
// function for submited form in read page
function searchingWinners()
{
  global $startDate, $endDate;
  if (isset($_POST['submit'])) {
    $startDate = $_POST['txtStartDate'];
    $endDate = $_POST['txtEndDate'];
    searchByDate($startDate, $endDate);
  }
}

// default query and date in read
function defaultValues()
{
  global $message, $query, $endDate, $startDate;
  $message = "";
  $query = "SELECT slotpersons.ReferenceNo, slotpersons.PersonObjectId, slotpersons.IsResident, slotpersons.FirstName, slotpersons.LastName, slotpersons.AddressLine1,
slotpersons.City, slotpersons.ISOType, country_iso.country, slotpersons.TransactionDate
FROM slotpersons 
INNER JOIN country_iso ON slotpersons.ISOCode = country_iso.iso_code";
  $endDate = date("Y-m-d");
  $startDate = date("Y-m-d", strtotime('-2 days', strtotime($endDate)));
}
