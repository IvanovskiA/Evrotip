<?php
require_once("included_functions.php");
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

// takeing data from xml file
function takeXMLData($fileCount, $acceptedext)
{
  global $message;
  $dom = new DOMDocument();
  $dom->preserveWhiteSpace = false;
  for ($i = 0; $i < $fileCount; $i++) {
    $fileName = $_FILES['file']['name'][$i];
    $fileTmpName = $_FILES['file']['tmp_name'][$i];
    if (!file_exists($fileTmpName) || !is_uploaded_file($fileTmpName)) {
      $message = 'No uploaded file/s';
    } else {
      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      if (!in_array($extension, $acceptedext)) {
        $message .= " Wrong file " . $fileName;
      } else {
        $dom->Load($fileTmpName);
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

          checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $isoType, $isoCode);
          if (!checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $isoType, $isoCode)) {
            $message .= $fileName . " Element exist!";
            continue (2);
          }
        }
        folderExists($fileName, $fileTmpName);
      }
    }
  }
}

// takeing data from JSON file
function takeJSONData($fileCount, $acceptedext)
{
  global $message;
  for ($i = 0; $i < $fileCount; $i++) {
    $fileName = $_FILES['file']['name'][$i];
    $fileTmpName = $_FILES['file']['tmp_name'][$i];
    if (!file_exists($fileTmpName) || !is_uploaded_file($fileTmpName)) {
      $message = 'No uploaded file/s';
    } else {
      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      if (!in_array($extension, $acceptedext)) {
        $message .= " Wrong file " . $fileName;
      } else {
        $jsonData = file_get_contents("example.json");
        $jsonData = json_decode($jsonData, true);
        $referenceNo = $jsonData["Report"]["ReferenceNo"];
        $dateCreated = $jsonData["Report"]["DateCreated"];
        $dataFromDate = $jsonData["Report"]["DataFromDate"];
        $dataToDate = $jsonData["Report"]["DataToDate"];
        $transactionDate = $jsonData["Report"]["TransactionList"]["Transaction"]["0"]["TransactionDate"];
        $data = array();
        $personList = $jsonData["Report"]["PersonList"]["Person"];
        $persons_num = array_keys($personList);
        $dateCreatedPreg = preg_replace("/[A-Za-z]/", " ", $dateCreated);
        $dataFromDatePreg = preg_replace("/[A-Za-z]/", " ", $dataFromDate);
        $dataToDatePreg = preg_replace("/[A-Za-z]/", " ", $dataToDate);
        for ($i = 0; $i < count($persons_num); $i++) {
          $personList = $jsonData["Report"]["PersonList"]["Person"][$i];
          foreach ($personList as $key => $value) {
            if ((!empty($value)) && ($key[0] !== "#")) {
              if ($key === "IdDocumentList") {
                $idDocument = $jsonData["Report"]["PersonList"]["Person"][$i]["IdDocumentList"]["IdDocument"];
                foreach ($idDocument as $key => $value) {
                  $data[lcfirst($key)] = $value;
                }
              } elseif ($key === "AddressList") {
                $Address = $jsonData["Report"]["PersonList"]["Person"][$i]["AddressList"]["Address"];
                foreach ($Address as $key => $value) {
                  if ((!empty($value)) && ($key[0] !== "#")) {
                    if ($key === "Country") {
                      $Country = $jsonData["Report"]["PersonList"]["Person"][$i]["AddressList"]["Address"]["Country"];
                      foreach ($Country as $key => $value) {
                        $data[lcfirst($key)] = $value;
                      }
                    } else {
                      $data[lcfirst($key)] = $value;
                      continue;
                    }
                  }
                }
              } else {
                $data[lcfirst($key)] = $value;
              }
            }
          }
          extract($data);
          checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode);
          if (!checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)) {
            $message .= $fileName . " Element exist!";
            continue (2);
          }
        }
        folderExists($fileName, $fileTmpName);
      }
    }
  }
}

// checking XML structure
function checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $isoType, $isoCode)
{
  global $connection;
  if (isset($dateCreated, $dataFromDate, $dataToDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $isoType, $isoCode)) {
    $query = "INSERT INTO slotpersons(`ReferenceNo`, `DateCreated`, `DataFromDate`, `DataToDate`, `PersonObjectId`, `IsResident`, `FirstName`, `GenderTypeId`, `LastName`, `IdDocumentTypeId`, `IdNo`, `AddressTypeId`, `AddressLine1`, `City`, `ISOType`, `ISOCode`, `TransactionDate`) 
            VALUES ('$referenceNo','$dateCreated','$dataFromDate','$dataToDate',$personObjectId,$isResident,'$firstName', $genderTypeId ,'$lastName',$idDocumentTypeId,'$idNo',$addressTypeId,'$addressLine1','$city',$isoType,$isoCode,'$transactionDate')
            ON DUPLICATE KEY UPDATE `DateCreated`='$dateCreatedPreg',`DataFromDate`='$dataFromDatePreg',`DataToDate`='$dataToDatePreg',`PersonObjectId`='$personObjectId',`IsResident`=$isResident,`FirstName`='$firstName',`GenderTypeId`=$genderTypeId,`LastName`='$lastName',`IdDocumentTypeId`=$idDocumentTypeId,`IdNo`='$idNo',`AddressTypeId`=$addressTypeId,`AddressLine1`='$addressLine1',`City`='$city',`ISOType`=$isoType,`ISOCode`=$isoCode";
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
