<?php
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

  if (isset($referenceNo)) {
    echo "Angel";
  }
  echo "<br><br><br>";
}
