<?php
require_once("db_conn.php");
if (!empty($_SESSION["iduser"])) {
  $userid = $_SESSION["iduser"];
  $result = mysqli_query($connection, "SELECT * FROM users WHERE id = $userid");
  $row = mysqli_fetch_assoc($result);
  $userRole = $row["role"];
  if ($userRole === "Read") {
    header("Location: read.php");
  }
} else {
  header("Location: login.php");
}
$message = "";
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
if (isset($_POST['submit'])) {
  $godina = $_POST['godina'];
  $mesec = $_POST['mesec'];
  $mydir = "$godina/$mesec/";
  $fileCount = count($_FILES['file']['name']);
  $acceptedext = array("xml");
  for ($i = 0; $i < $fileCount; $i++) {
    $fileName = $_FILES['file']['name'][$i];
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    if (!in_array($extension, $acceptedext)) {
      $message .= " Wrong file " . $fileName;
    } else {
      $dom->Load($_FILES['file']['tmp_name'][$i]);

      $referenceNo = $dom->getElementsByTagName('ReferenceNo')->item(0)->nodeValue;
      $dateCreated = $dom->getElementsByTagName('DateCreated')->item(0)->nodeValue;
      $dataFromDate = $dom->getElementsByTagName('DataFromDate')->item(0)->nodeValue;
      $dataToDate = $dom->getElementsByTagName('DataFromDate')->item(0)->nodeValue;
      $dateCreatedPreg = preg_replace("/[A-Za-z]/", " ", $dateCreated);
      $dataFromDatePreg = preg_replace("/[A-Za-z]/", " ", $dataFromDate);
      $dataToDatePreg = preg_replace("/[A-Za-z]/", " ", $dataToDate);
      $transactionDate = $dom->getElementsByTagName('TransactionDate')->item(0)->nodeValue;
      $personList = $dom->getElementsByTagName('Person');
      foreach ($personList as $person) {
        $personObjectId = $person->getElementsByTagName('PersonObjectId')->item(0)->nodeValue;
        $isResident = $person->getElementsByTagName('IsResident')->item(0)->nodeValue;
        $firstName = $person->getElementsByTagName('FirstName')->item(0)->nodeValue;
        $genderTypeId = $person->getElementsByTagName('GenderTypeId')->item(0)->nodeValue;
        $lastName = $person->getElementsByTagName('LastName')->item(0)->nodeValue;
        $idDocumentTypeId = $person->getElementsByTagName('IdDocumentTypeId')->item(0)->nodeValue;
        $idNo = $person->getElementsByTagName('IdNo')->item(0)->nodeValue;
        $addressTypeId = $person->getElementsByTagName('AddressTypeId')->item(0)->nodeValue;
        $addressLine1 = $person->getElementsByTagName('AddressLine1')->item(0)->nodeValue;
        $city = $person->getElementsByTagName('City')->item(0)->nodeValue;
        $isoType = $person->getElementsByTagName('ISOType')->item(0)->nodeValue;
        $isoCode = $person->getElementsByTagName('ISOCode')->item(0)->nodeValue;

        if (isset($dateCreated, $dataFromDate, $dataToDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $isoType, $isoCode)) {
          $query = "INSERT INTO slotpersons(`ReferenceNo`, `DateCreated`, `DataFromDate`, `DataToDate`, `PersonObjectId`, `IsResident`, `FirstName`, `GenderTypeId`, `LastName`, `IdDocumentTypeId`, `IdNo`, `AddressTypeId`, `AddressLine1`, `City`, `ISOType`, `ISOCode`, `TransactionDate`) 
          VALUES ('$referenceNo','$dateCreated','$dataFromDate','$dataToDate',$personObjectId,$isResident,'$firstName', $genderTypeId ,'$lastName',$idDocumentTypeId,'$idNo',$addressTypeId,'$addressLine1','$city',$isoType,$isoCode,'$transactionDate')
          ON DUPLICATE KEY UPDATE `DateCreated`='$dateCreatedPreg',`DataFromDate`='$dataFromDatePreg',`DataToDate`='$dataToDatePreg',`PersonObjectId`='$personObjectId',`IsResident`=$isResident,`FirstName`='$firstName',`GenderTypeId`=$genderTypeId,`LastName`='$lastName',`IdDocumentTypeId`=$idDocumentTypeId,`IdNo`='$idNo',`AddressTypeId`=$addressTypeId,`AddressLine1`='$addressLine1',`City`='$city',`ISOType`=$isoType,`ISOCode`=$isoCode";
          $result = mysqli_query($connection, $query);
        } else {
          $message .= $fileName . " Element exist!";
          continue (2);
        }
      }
      if (!file_exists($mydir)) {
        mkdir($mydir, 0777, true);
        move_uploaded_file($_FILES['file']['tmp_name'][$i], $mydir . $fileName);
      } else {
        move_uploaded_file($_FILES['file']['tmp_name'][$i], $mydir . $fileName);
      }
    }
  }
}
?>
<?php include_once("header.php") ?>

<div class="container">
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
    <button type="submit" name="submit" value="submit">Submit</button>
  </form>
  <div style="text-align: center; margin-top: 200px">
    <?php echo "<h1 style='color: white'>" . $message . "</h1>" ?>
  </div>
</div>
<?php include_once("footer.php") ?>
<?php
// $files = scandir($mydir);
// for ($i = 2; $i < count($files); $i++) { // $dom->Load("$godina/$mesec/" . $files[$i]);

// $referenceNo = $dom->getElementsByTagName('ReferenceNo')->item(0)->nodeValue;
// $dateCreated = $dom->getElementsByTagName('DateCreated')->item(0)->nodeValue;
// $dataFromDate = $dom->getElementsByTagName('DataFromDate')->item(0)->nodeValue;
// $dataToDate = $dom->getElementsByTagName('DataFromDate')->item(0)->nodeValue;
// $dateCreatedPreg = preg_replace("/[A-Za-z]/", " ", $dateCreated);
// $dataFromDatePreg = preg_replace("/[A-Za-z]/", " ", $dataFromDate);
// $dataToDatePreg = preg_replace("/[A-Za-z]/", " ", $dataToDate);
// $transactionDate = $dom->getElementsByTagName('TransactionDate')->item(0)->nodeValue;
// $personList = $dom->getElementsByTagName('Person');
// foreach ($personList as $person) {
// $personObjectId = $person->getElementsByTagName('PersonObjectId')->item(0)->nodeValue;
// $isResident = $person->getElementsByTagName('IsResident')->item(0)->nodeValue;
// $firstName = $person->getElementsByTagName('FirstName')->item(0)->nodeValue;
// $genderTypeId = $person->getElementsByTagName('GenderTypeId')->item(0)->nodeValue;
// $lastName = $person->getElementsByTagName('LastName')->item(0)->nodeValue;
// $idDocumentTypeId = $person->getElementsByTagName('IdDocumentTypeId')->item(0)->nodeValue;
// $idNo = $person->getElementsByTagName('IdNo')->item(0)->nodeValue;
// $addressTypeId = $person->getElementsByTagName('AddressTypeId')->item(0)->nodeValue;
// $addressLine1 = $person->getElementsByTagName('AddressLine1')->item(0)->nodeValue;
// $city = $person->getElementsByTagName('City')->item(0)->nodeValue;
// $isoType = $person->getElementsByTagName('ISOType')->item(0)->nodeValue;
// $isoCode = $person->getElementsByTagName('ISOCode')->item(0)->nodeValue;

// if (isset($dateCreated, $dataFromDate, $dataToDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $isoType, $isoCode)) {
// $query = "INSERT INTO slotpersons(`ReferenceNo`, `DateCreated`, `DataFromDate`, `DataToDate`, `PersonObjectId`, `IsResident`, `FirstName`, `GenderTypeId`, `LastName`, `IdDocumentTypeId`, `IdNo`, `AddressTypeId`, `AddressLine1`, `City`, `ISOType`, `ISOCode`, `TransactionDate`)
// VALUES ('$referenceNo','$dateCreated','$dataFromDate','$dataToDate',$personObjectId,$isResident,'$firstName', $genderTypeId ,'$lastName',$idDocumentTypeId,'$idNo',$addressTypeId,'$addressLine1','$city',$isoType,$isoCode,'$transactionDate')
// ON DUPLICATE KEY UPDATE `DateCreated`='$dateCreatedPreg',`DataFromDate`='$dataFromDatePreg',`DataToDate`='$dataToDatePreg',`PersonObjectId`='$personObjectId',`IsResident`=$isResident,`FirstName`='$firstName',`GenderTypeId`=$genderTypeId,`LastName`='$lastName',`IdDocumentTypeId`=$idDocumentTypeId,`IdNo`='$idNo',`AddressTypeId`=$addressTypeId,`AddressLine1`='$addressLine1',`City`='$city',`ISOType`=$isoType,`ISOCode`=$isoCode";
// $result = mysqli_query($connection, $query);
// } else {
// $message .= $fileName . " Element exist!";
// }
// }
// }
?>