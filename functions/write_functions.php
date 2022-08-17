<?php
require_once("included_functions.php");
require_once("xmlParser_functions.php");
require_once("jsonParser_functions.php");
$message = "";
$affectedRows = array("insertedRows" => 0, "updatedRows" => 0, "insertedSameData" => 0);
submitIndexForm();

// Collecting form data
function submitIndexForm()
{
  if (isset($_POST['submit'])) {
    global $mydir;
    $godina = $_POST['godina'];
    $mesec = $_POST['mesec'];
    $format = $_POST['format'];
    $mydir = "uploads/$format/$godina/$mesec/";
    $fileCount = count($_FILES['file']['name']);
    checkFileFormat($format, $fileCount);
  }
}

// Format inserted file function
function checkFileFormat($format, $fileCount)
{
  if ($format === "json") {
    $acceptedext = array("json");
    takeJSONData($fileCount, $acceptedext);
  } else {
    $acceptedext = array("xml");
    takeXMLData($fileCount, $acceptedext);
  }
}

// CheckingFilePresence 
function checkingFilePresence($i)
{
  global $fileName, $fileTmpName;
  $fileName = $_FILES['file']['name'][$i];
  $fileTmpName = $_FILES['file']['tmp_name'][$i];
  return file_exists($fileTmpName) || is_uploaded_file($fileTmpName);
}

// Checking extension of file/s
function checkExtension($fileName, $acceptedext)
{
  $extension = pathinfo($fileName, PATHINFO_EXTENSION);
  return in_array($extension, $acceptedext);
}

// Checking file structure
function checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)
{
  if (isset($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)) {
    return true;
  } else {
    return false;
  }
}

// Function for inserting data from xml or json file
function insertDatainDb($referenceNo, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)
{
  global $connection;
  static $insertedRows = 0;
  static $updatedRows = 0;
  static $insertedSameData = 0;
  global $affectedRows;
  $query = "INSERT INTO slotpersons(`ReferenceNo`, `DateCreated`, `DataFromDate`, `DataToDate`, `PersonObjectId`, `IsResident`, `FirstName`, `GenderTypeId`, `LastName`, `IdDocumentTypeId`, `IdNo`, `AddressTypeId`, `AddressLine1`, `City`, `ISOType`, `ISOCode`, `TransactionDate`) 
  VALUES ('$referenceNo','$dateCreatedPreg','$dataFromDatePreg','$dataToDatePreg','$personObjectId',$isResident,'$firstName', $genderTypeId ,'$lastName',$idDocumentTypeId,'$idNo',$addressTypeId,'$addressLine1','$city',$iSOType,'$iSOCode','$transactionDate')
  ON DUPLICATE KEY UPDATE `DateCreated`='$dateCreatedPreg',`DataFromDate`='$dataFromDatePreg',`DataToDate`='$dataToDatePreg',`PersonObjectId`='$personObjectId',`IsResident`=$isResident,`FirstName`='$firstName',`GenderTypeId`=$genderTypeId,`LastName`='$lastName',`IdDocumentTypeId`=$idDocumentTypeId,`IdNo`='$idNo',`AddressTypeId`=$addressTypeId,`AddressLine1`='$addressLine1',`City`='$city',`ISOType`=$iSOType,`ISOCode`='$iSOCode',`TransactionDate`='$transactionDate'";
  $result = mysqli_query($connection, $query);
  if ($result) {
    if (mysqli_affected_rows($connection) === 1) {
      $insertedRows++;
      $affectedRows["insertedRows"] = $insertedRows;
    } elseif (mysqli_affected_rows($connection) === 2) {
      $query = "SELECT * FROM slotpersons where ReferenceNo = '$referenceNo' AND PersonObjectId='$personObjectId' AND TransactionDate='$transactionDate' LIMIT 1";
      $result = mysqli_query($connection, $query);
      $row = mysqli_fetch_assoc($result);
      define("OLDPERSON", $row["id"]);
      if ($updatedRows > 0) {
        if (OLDPERSON !== $row["id"]) {
          $updatedRows++;
        }
        $affectedRows["updatedRows"] = $updatedRows;
      } else {
        $updatedRows++;
      }
    } elseif (mysqli_affected_rows($connection) === 0) {
      $insertedSameData++;
      $affectedRows["insertedSameData"] = $insertedSameData;
    }
    return true;
  } else {
    return false;
    echo mysqli_error($connection);
  }
}

// Move files in folder or creating folder if exist and move in created folder 
function folderExists($fileName, $fileTmpName)
{
  global $mydir, $message;
  if (!file_exists($mydir)) {
    mkdir($mydir, 0777, true);
    move_uploaded_file($fileTmpName, $mydir . $fileName);
  } else {
    move_uploaded_file($fileTmpName, $mydir . $fileName);
  }
  $message = "Data inserted and moved successfully in folder.";
}
