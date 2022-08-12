<?php
// Taking data from JSON file
function takeJSONData($fileCount, $acceptedext)
{
  global $message, $fileName, $fileTmpName;
  for ($i = 0; $i < $fileCount; $i++) {
    checkingFilePresence($i);
    if (!checkingFilePresence($i)) {
      $message = 'No uploaded file/s';
    } else {
      checkExtension($fileName, $acceptedext);
      if (!checkExtension($fileName, $acceptedext)) {
        $message .= " Wrong format " . $fileName;
      } else {
        $jsonData = file_get_contents($fileTmpName);
        $jsonData = json_decode($jsonData, true);
        $referenceNo = $jsonData["Report"]["ReferenceNo"];
        $dateCreated = $jsonData["Report"]["DateCreated"];
        $dataFromDate = $jsonData["Report"]["DataFromDate"];
        $dataToDate = $jsonData["Report"]["DataToDate"];
        $data = array();
        $personList = $jsonData["Report"]["PersonList"]["Person"];
        $persons_num = array_keys($personList);
        $dateCreatedPreg = preg_replace("/[A-Za-z]/", " ", $dateCreated);
        $dataFromDatePreg = preg_replace("/[A-Za-z]/", " ", $dataFromDate);
        $dataToDatePreg = preg_replace("/[A-Za-z]/", " ", $dataToDate);
        $transactionDate = $jsonData["Report"]["TransactionList"]["Transaction"]["0"]["TransactionDate"];
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
