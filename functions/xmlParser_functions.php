<?php
// taking data from xml file
function takeXMLData($fileCount, $acceptedext)
{
  global $message, $fileName, $fileTmpName;
  $dom = new DOMDocument();
  $dom->preserveWhiteSpace = false;
  for ($i = 0; $i < $fileCount; $i++) {
    checkingFilePresence($i);
    if (!checkingFilePresence($i)) {
      $message = 'No uploaded file/s';
    } else {
      checkExtension($fileName, $acceptedext);
      if (!checkExtension($fileName, $acceptedext)) {
        $message .= " Wrong format " . $fileName;
      } else {
        $dom->Load($fileTmpName);
        $referenceNo = $dom->getElementsByTagName('ReferenceNo')->item(0)->nodeValue;
        $dateCreated = $dom->getElementsByTagName('DateCreated')->item(0)->nodeValue;
        $dataFromDate = $dom->getElementsByTagName('DataFromDate')->item(0)->nodeValue;
        $dataToDate = $dom->getElementsByTagName('DataToDate')->item(0)->nodeValue;
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
          $iSOType = $person->getElementsByTagName('ISOType')->item(0)->nodeValue;
          $iSOCode = $person->getElementsByTagName('ISOCode')->item(0)->nodeValue;

          checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode);
          if (!checkingStructure($referenceNo, $dateCreated, $dataFromDate, $dataToDate, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)) {
            $message .= $fileName . " Missing element!";
            continue (2);
          } else {
            insertDatainDb($referenceNo, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode);
            if (!insertDatainDb($referenceNo, $dateCreatedPreg, $dataFromDatePreg, $dataToDatePreg, $transactionDate, $personObjectId, $isResident, $firstName, $genderTypeId, $lastName, $idDocumentTypeId, $idNo, $addressTypeId, $addressLine1, $city, $iSOType, $iSOCode)) {
              $message = "Error with insert in database";
            }
          }
        }
        folderExists($fileName, $fileTmpName);
      }
    }
  }
}
