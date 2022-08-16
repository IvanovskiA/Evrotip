<?php
require_once("functions/write_functions.php");
$_SESSION["xmlInsert"] = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES)) {
  $path = "uploadedFolders/";

  for ($i = 0; $i < count($_POST["folder"]); $i++) {
    $folder = dirname($_POST["folder"][$i]);
    // echo $folder;
    $full_path = $path . $folder;
    // echo $full_path;
    if (!file_exists($full_path)) {
      mkdir($full_path, 777, true);
    }

    $temp_file = $_FILES["file"]["tmp_name"][$i];
    $name = $_FILES["file"]["name"][$i];

    move_uploaded_file($temp_file, $full_path . "/" . $name);
  }

  $array = (explode("/", $folder));
  $folderName = $array[0];
  // echo $path . $folderName;
  $dir = $path . $folderName;

  $folder = scandir($dir);
  foreach ($folder as $folders) {
    if (is_dir("$dir/$folders")) {
      if ($folders !== "." && $folders !== "..") {
        $newDir = $dir . "/" . $folders . "/";
        $subfolder = scandir($newDir);
        foreach ($subfolder as $files) {
          if ($files !== "." && $files !== "..") {
            $file = $newDir . $files;
            // echo $file;
            $dom = new DOMDocument();
            $dom->load($file);
            $referenceNo = $dom->getElementsByTagName('ReferenceNo')->item(0)->nodeValue;
            $dateCreated = $dom->getElementsByTagName('DateCreated')->item(0)->nodeValue;
            $dataFromDate = $dom->getElementsByTagName('DataFromDate')->item(0)->nodeValue;
            $dataToDate = $dom->getElementsByTagName('DataToDate')->item(0)->nodeValue;
            $dateCreatedPreg = preg_replace("/[A-Za-z]/", " ", $dateCreated);
            $dataFromDatePreg = preg_replace("/[A-Za-z]/", " ", $dataFromDate);
            $dataToDatePreg = preg_replace("/[A-Za-z]/", " ", $dataToDate);
            $personList = $dom->getElementsByTagName('Person');
            $transactionDate = substr($referenceNo, 3);
            $transactionDate = substr_replace($transactionDate, "/", 2, 0);
            $transactionDate = substr_replace($transactionDate, "20", 6, 0);
            $transactionDate = str_replace("/", "-", $transactionDate);
            $d = strtotime($transactionDate);
            $transactionDate = date("Y-m-d", $d);
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
              $iSOType = $person->getElementsByTagName('ISOType')->item(0)->nodeValue;
              $iSOCode = $person->getElementsByTagName('ISOCode')->item(0)->nodeValue;
              $iSOCodeNew = strval($iSOCode);
              checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode);
              if (!checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)) {
                $_SESSION["xmlInsert"] .= $file . " Missing element!";
                continue (2);
              } else {
                insertDatainDb($referenceNo, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCodeNew);
                if (!insertDatainDb($referenceNo, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCodeNew)) {
                  $_SESSION["xmlInsert"] .= "Error with insert in database $file";
                }
              }
            }
          }
        }
      }
    }
  }
}

// print_r(scandir("uploadedFolders/2022/November/"));
