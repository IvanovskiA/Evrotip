<?php
require_once("included_functions.php");
require_once("xmlParser_functions.php");
require_once("jsonParser_functions.php");
$message = "";
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
    if ($format === "json") {
      $acceptedext = array("json");
      takeJSONData($fileCount, $acceptedext);
    } else {
      $acceptedext = array("xml");
      takeXMLData($fileCount, $acceptedext);
    }
  }
}

// checking XML structure
function checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)
{
  global $connection;
  if (isset($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)) {
    $query = "INSERT INTO slotpersons(`ReferenceNo`, `DateCreated`, `DataFromDate`, `DataToDate`, `PersonObjectId`, `IsResident`, `FirstName`, `GenderTypeId`, `LastName`, `IdDocumentTypeId`, `IdNo`, `AddressTypeId`, `AddressLine1`, `City`, `ISOType`, `ISOCode`, `TransactionDate`) 
            VALUES ('$referenceNo','$dateCreated','$dataFromDate','$dataToDate',$personObjectId,$isResident,'$firstName', $genderTypeId ,'$lastName',$idDocumentTypeId,'$idNo',$addressTypeId,'$addressLine1','$city',$iSOType,$iSOCode,'$transactionDate')
            ON DUPLICATE KEY UPDATE `DateCreated`='$dateCreatedPreg',`DataFromDate`='$dataFromDatePreg',`DataToDate`='$dataToDatePreg',`PersonObjectId`='$personObjectId',`IsResident`=$isResident,`FirstName`='$firstName',`GenderTypeId`=$genderTypeId,`LastName`='$lastName',`IdDocumentTypeId`=$idDocumentTypeId,`IdNo`='$idNo',`AddressTypeId`=$addressTypeId,`AddressLine1`='$addressLine1',`City`='$city',`ISOType`=$iSOType,`ISOCode`=$iSOCode";
    $result = mysqli_query($connection, $query);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
}

// move files in folder or creating folder if exist and move in created folder 
function folderExists($fileName, $fileTmpName)
{
  global $mydir, $message;
  if (!file_exists($mydir)) {
    mkdir($mydir, 0777, true);
    move_uploaded_file($fileTmpName, $mydir . $fileName);
  } else {
    move_uploaded_file($fileTmpName, $mydir . $fileName);
  }
  $message = 'Data inserted and moved successfully in folder.';
}
