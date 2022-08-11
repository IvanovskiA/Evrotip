<?php
// takeing data from JSON file
function takeJSONData($fileCount, $acceptedext)
{
  global $message;
  for ($i = 0; $i < $fileCount; $i++) {
    // skrati tuka kod so funkcija
    $fileName = $_FILES['file']['name'][$i];
    $fileTmpName = $_FILES['file']['tmp_name'][$i];
    if (!file_exists($fileTmpName) || !is_uploaded_file($fileTmpName)) {
      $message = 'No uploaded file/s';
    } else {
      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      if (!in_array($extension, $acceptedext)) {
        $message .= " Wrong file " . $fileName;
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
            $message .= $fileName . " Element exist!";
            continue (2);
          }
        }
        folderExists($fileName, $fileTmpName);
      }
    }
  }
}
